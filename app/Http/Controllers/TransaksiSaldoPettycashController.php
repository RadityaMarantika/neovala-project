<?php

namespace App\Http\Controllers;

use App\Models\TransaksiSaldoPettycash;
use App\Models\MasterPettycash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiSaldoPettycashController extends Controller
{
    public function index()
    {
        $transaksis = TransaksiSaldoPettycash::with(['asal', 'tujuan'])
            ->latest()
            ->paginate(10);

        return view('transaksi_saldo_pettycash.index', compact('transaksis'));
    }

    public function create()
    {
        $pettycashes = MasterPettycash::all();
        return view('transaksi_saldo_pettycash.create', compact('pettycashes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:topup,transfer',
            'pettycash_asal_id' => 'nullable|exists:master_pettycashes,id',
            'pettycash_tujuan_id' => 'required|exists:master_pettycashes,id',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
            'bukti_transfer' => 'nullable',
        ]);

        DB::transaction(function () use ($request) {
            $transaksi = TransaksiSaldoPettycash::create([
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => $request->jenis_transaksi,
                'pettycash_asal_id' => $request->pettycash_asal_id,
                'pettycash_tujuan_id' => $request->pettycash_tujuan_id,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
                'dibuat_oleh' => Auth::id(),
            ]);

            // Update saldo
            if ($request->jenis_transaksi === 'topup') {
                $tujuan = MasterPettycash::find($request->pettycash_tujuan_id);
                $tujuan->increment('saldo_berjalan', $request->nominal);
            } elseif ($request->jenis_transaksi === 'transfer') {
                $asal = MasterPettycash::find($request->pettycash_asal_id);
                $tujuan = MasterPettycash::find($request->pettycash_tujuan_id);

                $asal->decrement('saldo_berjalan', $request->nominal);
                $tujuan->increment('saldo_berjalan', $request->nominal);
            }
        });

        return redirect()->route('transaksi_saldo_pettycash.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show($id)
    {
        $transaksi = TransaksiSaldoPettycash::with(['asal', 'tujuan'])->findOrFail($id);
        return view('transaksi_saldo_pettycash.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = TransaksiSaldoPettycash::findOrFail($id);
        $pettycashes = MasterPettycash::all();
        return view('transaksi_saldo_pettycash.edit', compact('transaksi', 'pettycashes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi = TransaksiSaldoPettycash::findOrFail($id);
        $transaksi->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi_saldo_pettycash.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = TransaksiSaldoPettycash::findOrFail($id);
        $transaksi->delete();
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
