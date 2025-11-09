<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPettycash;
use App\Models\TransaksiPettycash;
use App\Models\TransaksiSaldoPettycash;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PettycashReportController extends Controller
{
    /**
     * Tampilkan halaman filter laporan pettycash
     */
    public function index(Request $request)
    {
        $pettycashes = MasterPettycash::orderBy('nama_pettycash')->get();

        $pettycashId = $request->input('pettycash_id');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $laporan = null;

        if ($pettycashId) {
            $pettycash = MasterPettycash::findOrFail($pettycashId);

            $queryTransaksi = TransaksiPettycash::where('pettycash_id', $pettycashId);
            $querySaldo = TransaksiSaldoPettycash::where(function ($q) use ($pettycashId) {
                $q->where('pettycash_asal_id', $pettycashId)
                  ->orWhere('pettycash_tujuan_id', $pettycashId);
            });

            if ($tanggalAwal && $tanggalAkhir) {
                $queryTransaksi->whereBetween('tanggal_transaksi', [$tanggalAwal, $tanggalAkhir]);
                $querySaldo->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            }

            $transaksi = $queryTransaksi->orderBy('tanggal_transaksi')->get();
            $mutasiSaldo = $querySaldo->orderBy('tanggal')->get();

            // Hitung total masuk & keluar
            $totalIn = $transaksi->where('jenis_transaksi', 'Cash In')->sum('nominal');
            $totalOut = $transaksi->where('jenis_transaksi', 'Cash Out')->sum('nominal');

            $totalTopup = $mutasiSaldo->where('jenis_transaksi', 'topup')
                ->where('pettycash_tujuan_id', $pettycashId)->sum('nominal');

            $totalTransferIn = $mutasiSaldo->where('jenis_transaksi', 'transfer')
                ->where('pettycash_tujuan_id', $pettycashId)->sum('nominal');

            $totalTransferOut = $mutasiSaldo->where('jenis_transaksi', 'transfer')
                ->where('pettycash_asal_id', $pettycashId)->sum('nominal');

            $laporan = [
                'pettycash' => $pettycash,
                'saldo_awal' => $pettycash->saldo_awal,
                'total_in' => $totalIn + $totalTopup + $totalTransferIn,
                'total_out' => $totalOut + $totalTransferOut,
                'saldo_akhir' => $pettycash->saldo_awal + $totalIn + $totalTopup + $totalTransferIn - ($totalOut + $totalTransferOut),
                'transaksi' => $transaksi,
                'mutasi' => $mutasiSaldo,
            ];
        }

        return view('reports.pettycash_filter', compact(
            'pettycashes',
            'laporan',
            'tanggalAwal',
            'tanggalAkhir',
            'pettycashId'
        ));
    }

    /**
     * Export hasil filter pettycash ke PDF
     */
   public function exportPdf(Request $request)
{
    $pettycashId = $request->query('pettycash_id');
    $tanggalAwal = $request->query('tanggal_awal');
    $tanggalAkhir = $request->query('tanggal_akhir');

    if (!$pettycashId) {
        return back()->with('error', 'Pilih petty cash terlebih dahulu.');
    }

    $pettycash = MasterPettycash::findOrFail($pettycashId);

    // Ambil transaksi petty cash
    $trxPetty = TransaksiPettycash::where('pettycash_id', $pettycashId)
        ->when($tanggalAwal && $tanggalAkhir, fn($q) => 
            $q->whereBetween('tanggal_transaksi', [$tanggalAwal, $tanggalAkhir])
        )
        ->orderBy('tanggal_transaksi')
        ->get();

    // Ambil transaksi mutasi saldo petty cash
    $mutasi = TransaksiSaldoPettycash::where(function ($q) use ($pettycashId) {
            $q->where('pettycash_asal_id', $pettycashId)
              ->orWhere('pettycash_tujuan_id', $pettycashId);
        })
        ->when($tanggalAwal && $tanggalAkhir, fn($q) => 
            $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        )
        ->orderBy('tanggal')
        ->get();

    // Gabungkan semua transaksi
    $items = collect();

    foreach ($trxPetty as $t) {
        $direction = strtolower($t->jenis_transaksi) === 'cash in' ? 'in' : 'out';
        $items->push((object)[
            'date' => Carbon::parse($t->tanggal_transaksi),
            'jenis' => ucfirst($t->jenis_transaksi),
            'keterangan' => $t->keperluan ?? $t->keterangan ?? '-',
            'nominal' => (float)$t->nominal,
            'direction' => $direction,
            'source' => 'petty',
        ]);
    }

    foreach ($mutasi as $m) {
        $direction = 'neutral';
        if ($m->jenis_transaksi === 'topup') {
            $direction = $m->pettycash_tujuan_id == $pettycashId ? 'in' : 'out';
        } elseif ($m->jenis_transaksi === 'transfer') {
            if ($m->pettycash_tujuan_id == $pettycashId) $direction = 'in';
            elseif ($m->pettycash_asal_id == $pettycashId) $direction = 'out';
        }

        $items->push((object)[
            'date' => Carbon::parse($m->tanggal),
            'jenis' => ucfirst($m->jenis_transaksi),
            'keterangan' => $m->keterangan ?? '-',
            'nominal' => (float)$m->nominal,
            'direction' => $direction,
            'source' => 'mutasi',
        ]);
    }

    $items = $items->sortBy(fn($i) => $i->date->timestamp)->values();

    // Hitung total & saldo berjalan
    $saldoAwal = (float)($pettycash->saldo_awal ?? 0);
    $saldoBerjalan = $saldoAwal;
    $totalIn = 0;
    $totalOut = 0;

    foreach ($items as $item) {
        if ($item->direction == 'in') {
            $saldoBerjalan += $item->nominal;
            $totalIn += $item->nominal;
        } elseif ($item->direction == 'out') {
            $saldoBerjalan -= $item->nominal;
            $totalOut += $item->nominal;
        }
        $item->saldo_berjalan = $saldoBerjalan;
    }

    $periodeAwal = $tanggalAwal ? Carbon::parse($tanggalAwal)->translatedFormat('d F Y') : '-';
    $periodeAkhir = $tanggalAkhir ? Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') : '-';
    $printedAt = Carbon::now()->translatedFormat('l, d F Y H:i');

    $pdf = Pdf::loadView('pdf.pettycash', [
        'pettycash' => $pettycash,
        'items' => $items,
        'periodeAwal' => $periodeAwal,
        'periodeAkhir' => $periodeAkhir,
        'saldoAwal' => $saldoAwal,
        'totalIn' => $totalIn,
        'totalOut' => $totalOut,
        'saldoAkhir' => $saldoBerjalan,
        'printedAt' => $printedAt,
    ])->setPaper('A4', 'portrait');

 return $pdf->stream('Laporan_PettyCash_' . $pettycash->nama_pettycash . '.pdf');
}
}
