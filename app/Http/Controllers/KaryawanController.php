<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller  
{ 

public function jadwalShifts(Request $request)
{
    // Ambil nilai range (default 7)
    $range = (int) $request->input('range', 7);

    // Tanggal awal = hari ini
    $startDate = Carbon::today()->startOfDay();

    // Hitung tanggal akhir berdasarkan range
    $endDate = match ($range) {
        14 => $startDate->copy()->addDays(13)->endOfDay(),
        default => $startDate->copy()->addDays(6)->endOfDay(),
    };

    // Jika user pilih tanggal manual, override start dan end
    if ($request->filled('tanggal')) {
        $filterDate = Carbon::parse($request->tanggal);
        $startDate = $filterDate->copy()->startOfDay();
        $endDate = $filterDate->copy()->endOfDay();
        // supaya range reset ke 1 hari
        $range = 1;
    }

    // Ambil daftar lokasi unik dari tabel shift
    $lokasiList = Shift::select('lokasi')->distinct()->pluck('lokasi');

    // Ambil shift sesuai filter
    $shiftsQuery = Shift::with('karyawans')
        ->whereBetween('jadwal_tanggal', [$startDate, $endDate]);

    if ($request->filled('lokasi')) {
        $shiftsQuery->where('lokasi', $request->lokasi);
    }

    $shifts = $shiftsQuery->get()
        ->groupBy('lokasi')
        ->map(function ($lokasiGroup) {
            return $lokasiGroup->groupBy(function ($shift) {
                return Carbon::parse($shift->jadwal_tanggal)->format('Y-m-d');
            });
        });

    // Ambil karyawan (bisa difilter lokasi)
    $karyawansQuery = MasterKaryawan::orderBy('nama_lengkap');
    if ($request->filled('lokasi')) {
        $karyawansQuery->where('penempatan', $request->lokasi);
    }
    $karyawans = $karyawansQuery->get();

    return view('karyawan.jadwal', compact(
        'karyawans',
        'shifts',
        'lokasiList',
        'startDate',
        'endDate',
        'range'
    ));
}




 public function reporting(Request $request)
    {
        $bulan = $request->bulan; // format: YYYY-MM
        $reportData = $this->getReportData($bulan);

        return view('karyawan.reporting', compact('reportData', 'bulan'));
    }

    // 🔑 helper ambil data
    private function getReportData($bulan = null)
    {
        $query = MasterKaryawan::with(['absensis.shift']); // ikut load shift

        if ($bulan) {
            $month = date('m', strtotime($bulan));
            $year  = date('Y', strtotime($bulan));

            $query->whereHas('absensis.shift', function ($q) use ($month, $year) {
                $q->whereMonth('jadwal_tanggal', $month)
                  ->whereYear('jadwal_tanggal', $year);
            });
        }

        $karyawans = $query->get();

        return $karyawans->map(function ($karyawan) {
            // hitung jumlah status absen masuk/pulang
            $totalMasuk  = $karyawan->absensis->count();
            $totalPulang = $karyawan->absensis->whereNotNull('status_absen_pulang')->count();

            $dendaMasukTelat   = $karyawan->absensis->where('status_absen_masuk', 'Telat')->count() * 20000;
            $dendaMasukAlfa    = $karyawan->absensis->where('status_absen_masuk', 'Alfa')->count() * 50000;
            $dendaPulangTelat  = $karyawan->absensis->where('status_absen_pulang', 'Telat')->count() * 15000;
            $dendaPulangKosong = $karyawan->absensis->whereNull('status_absen_pulang')->count() * 30000;

            $totalDenda = $dendaMasukTelat + $dendaMasukAlfa + $dendaPulangTelat + $dendaPulangKosong;

            return [
                'nama'                => $karyawan->nama_lengkap,
                'total_masuk'         => $totalMasuk,
                'total_pulang'        => $totalPulang,
                'denda_masuk_telat'   => $dendaMasukTelat,
                'denda_masuk_alfa'    => $dendaMasukAlfa,
                'denda_pulang_telat'  => $dendaPulangTelat,
                'denda_pulang_kosong' => $dendaPulangKosong,
                'total_denda'         => $totalDenda,
            ];
        });
    }

    // 📊 Export ke Excel
    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan;
        $reportData = $this->getReportData($bulan);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header kolom
        $sheet->fromArray([
            ['Nama Karyawan', 'Total Masuk', 'Total Pulang', 'Denda Masuk Telat', 'Denda Masuk Alfa', 'Denda Pulang Telat', 'Denda Pulang Kosong', 'Total Denda']
        ], null, 'A1');

        // isi data
        $rows = [];
        foreach ($reportData as $row) {
            $rows[] = [
                $row['nama'],
                $row['total_masuk'],
                $row['total_pulang'],
                $row['denda_masuk_telat'],
                $row['denda_masuk_alfa'],
                $row['denda_pulang_telat'],
                $row['denda_pulang_kosong'],
                $row['total_denda'],
            ];
        }
        $sheet->fromArray($rows, null, 'A2');

        $writer = new Xlsx($spreadsheet);
        $filename = 'reporting-absensi-karyawan_' . ($bulan ?? date('Y-m')) . '.xlsx';

        // response download
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename);
    }

    // 📑 Export ke PDF
    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan;
        $reportData = $this->getReportData($bulan);

        $pdf = Pdf::loadView('karyawan.reporting_pdf', [
            'reportData' => $reportData,
            'bulan'      => $bulan
        ])->setPaper('a4', 'landscape');

        return $pdf->download('reporting-absensi-karyawan_' . ($bulan ?? date('Y-m')) . '.pdf');
    }

   public function updateStatus(Request $request)
{
    try {
        // Validasi data
        $request->validate([
            'pivot_id' => 'required|integer',
            'status'   => 'required|string',
        ]);

        // Update data di tabel pivot
        DB::table('shift_karyawan')
            ->where('id', $request->pivot_id)
            ->update(['status' => $request->status, 'updated_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diubah.']);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}


}
