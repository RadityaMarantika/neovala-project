<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\MasterShift;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data distinct lokasi
        $lokasiList = Shift::select('lokasi')->distinct()->pluck('lokasi')->filter()->values();

        // Ambil filter dari request
        $lokasiDipilih = $request->lokasi;
        $tanggalDipilih = $request->tanggal;

        // Query dasar
        $query = Shift::withCount('karyawans');

        // Filter lokasi jika ada
        if ($lokasiDipilih) {
            $query->where('lokasi', $lokasiDipilih);
        }

        // Filter tanggal jika ada
        if ($tanggalDipilih) {
            $query->whereDate('jadwal_tanggal', $tanggalDipilih);
        }

        // Ambil data dengan urutan tanggal
        $shifts = $query->orderBy('jadwal_tanggal', 'asc')->get();

        return view('shifts.index', compact('shifts', 'lokasiList', 'lokasiDipilih', 'tanggalDipilih'));
    }



    public function create() {
        $karyawans = MasterKaryawan::orderBy('nama_lengkap')->get();
        $masterShifts = MasterShift::orderBy('buat_kode_shift')->get(); // ambil semua master shift
        return view('shifts.create', compact('karyawans', 'masterShifts'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'lokasi' => 'required|in:Ayam Bakar,Transpark Juanda',
            'master_shift_id' => 'required|exists:master_shifts,id',
            'jadwal_tanggal' => 'required|date',
            'karyawan_ids' => 'required|array|min:1',
            'karyawan_ids.*' => 'exists:master_karyawans,id',
        ]);

        // Ambil data dari MasterShift
        $masterShift = MasterShift::findOrFail($data['master_shift_id']);

        // Buat Shift baru berdasarkan MasterShift
        $shift = Shift::create([
            'lokasi' => $data['lokasi'],
            'kode_shift' => $masterShift->buat_kode_shift,
            'jenis' => $masterShift->jenis_shift,
            'jam_masuk_kerja' => $masterShift->jam_masuk,
            'jam_pulang_kerja' => $masterShift->jam_pulang,
            'jam_kerja' => $this->hitungJamKerja($masterShift->jam_masuk, $masterShift->jam_pulang),
            'jadwal_tanggal' => $data['jadwal_tanggal'],
        ]);

        // Sync karyawan yang dipilih
        $shift->karyawans()->sync($data['karyawan_ids']);

        return redirect()->route('shifts.index')->with('success', 'Shift berhasil dibuat.');
    }

   public function edit(Shift $shift)
{
    // cari master_shift berdasarkan kode_shift (lebih aman)
    $masterShift = MasterShift::where('buat_kode_shift', $shift->kode_shift)->first();
    // Ambil semua karyawan sesuai lokasi
    $karyawans = MasterKaryawan::where('penempatan', $shift->lokasi)
                    ->orderBy('nama_lengkap')
                    ->get();

    // Ambil semua shift di tanggal yang sama untuk lokasi yang sama
    $usedKaryawanIds = DB::table('shift_karyawan')
        ->join('shifts', 'shift_karyawan.shift_id', '=', 'shifts.id')
        ->where('shifts.jadwal_tanggal', $shift->jadwal_tanggal)
        ->where('shifts.lokasi', $shift->lokasi)
        ->where('shifts.id', '!=', $shift->id) // jangan hitung shift ini sendiri
        ->pluck('shift_karyawan.karyawan_id')
        ->toArray();

    // Filter agar karyawan yang sudah masuk shift hari ini tidak muncul lagi
    $karyawans = $karyawans->whereNotIn('id', $usedKaryawanIds);

    $masterShifts = MasterShift::orderBy('buat_kode_shift')->get();

    return view('shifts.edit', compact('shift', 'karyawans', 'masterShifts', 'masterShift'));
}


    public function update(Request $request, Shift $shift)
    {
        $data = $request->validate([
            'bekerja' => 'array',
            'bekerja.*' => 'exists:master_karyawans,id',
            'libur' => 'array',
            'libur.*' => 'exists:master_karyawans,id',
            'backup' => 'array',
            'backup.*' => 'exists:master_karyawans,id',
        ]);

        // Sinkronisasi karyawan dengan status
        $syncData = [];
        foreach (['bekerja', 'libur', 'backup'] as $status) {
            if (!empty($data[$status])) {
                foreach ($data[$status] as $karyawanId) {
                    $syncData[$karyawanId] = ['status' => $status];
                }
            }
        }

        $shift->karyawans()->sync($syncData);

        return redirect()->route('shifts.index')->with('success', 'Shift berhasil diperbarui.');
    }


    /**
     * Hitung durasi jam kerja dari jam masuk dan jam pulang
     */
   private function hitungJamKerja($jamMasuk, $jamPulang)
{
    // Jika salah satu null (contoh: L-Shift / Libur), langsung 0 jam kerja
    if (is_null($jamMasuk) || is_null($jamPulang) || $jamMasuk === '' || $jamPulang === '') {
        return 0;
    }

    $masuk = explode(':', $jamMasuk);
    $pulang = explode(':', $jamPulang);

    // Pastikan formatnya valid (minimal ada jam dan menit)
    if (count($masuk) < 2 || count($pulang) < 2) {
        return 0;
    }

    $jamMasukNum = (int)$masuk[0] + ((int)$masuk[1] / 60);
    $jamPulangNum = (int)$pulang[0] + ((int)$pulang[1] / 60);

    $durasi = $jamPulangNum - $jamMasukNum;

    // Jika hasil negatif (shift malam), tambahkan 24 jam
    if ($durasi <= 0) {
        $durasi += 24;
    }

    return $durasi;
}


    public function destroy(Shift $shift) {
        $shift->delete();
        return back()->with('success', 'Shift dihapus.');
    }

    public function generateForm()
    {
        return view('shifts.generate');
    }

    public function storeGenerate(Request $request)
    {
        $data = $request->validate([
            'lokasi' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'shifts' => 'required|array', // wajib pilih minimal 1 shift
            'shifts.*' => 'exists:master_shifts,id', // validasi id shift valid
        ]);

        $selectedShifts = MasterShift::whereIn('id', $data['shifts'])->get();
        $periode = new \DatePeriod(
            new \DateTime($data['tanggal_awal']),
            new \DateInterval('P1D'),
            (new \DateTime($data['tanggal_akhir']))->modify('+1 day')
        );

        foreach ($periode as $tanggal) {
            foreach ($selectedShifts as $mShift) {
                Shift::create([
                    'lokasi' => $data['lokasi'],
                    'kode_shift' => $mShift->buat_kode_shift,
                    'jenis' => $mShift->jenis_shift,
                    'jam_masuk_kerja' => $mShift->jam_masuk,
                    'jam_pulang_kerja' => $mShift->jam_pulang,
                    'jam_kerja' => $this->hitungJamKerja($mShift->jam_masuk, $mShift->jam_pulang),
                    'jadwal_tanggal' => $tanggal->format('Y-m-d'),
                ]);
            }
        }

        return redirect()->route('shifts.index')
            ->with('success', 'Shift periode berhasil digenerate.');
    }

    
}
