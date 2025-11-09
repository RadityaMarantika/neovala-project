<?php

namespace App\Http\Controllers;

use App\Models\PettyCash;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PettyCashController extends Controller
{
     public function index()
    {
        $pettyCashes = PettyCash::with(['createdBy', 'karyawan'])->latest()->get();

        // hitung total masuk & keluar
        $totalMasuk = $pettyCashes->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $pettyCashes->where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('petty_cash.index', compact('pettyCashes', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function create()
    {
        $karyawans = MasterKaryawan::orderBy('nama_lengkap')->get();
        return view('petty_cash.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:masuk,keluar',
            'kategori' => 'required|string',
            'subkategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'upload_bukti' => 'nullable|mimes:pdf,jpg,jpeg,png',
        ]);

        // Upload bukti kalau ada
        $pathBukti = null;
        if ($request->hasFile('upload_bukti')) {
            $pathBukti = $request->file('upload_bukti')->store('pettycash', 'public');
        }

        // Ambil saldo terakhir
        $lastSaldo = PettyCash::latest()->value('saldo') ?? 0;

        // Hitung saldo baru
        $saldoBaru = $request->jenis === 'masuk'
            ? $lastSaldo + $request->jumlah
            : $lastSaldo - $request->jumlah;

        // Simpan transaksi
        PettyCash::create([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'subkategori' => $request->subkategori,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'create_by' => Auth::id(),
            'diambil_oleh' => $request->diambil_oleh,
            'saldo' => $saldoBaru,
            'upload_bukti' => $pathBukti, // simpan path bukti
        ]);

        return redirect()->route('petty_cash.index')
            ->with('success', 'Transaksi petty cash berhasil disimpan.');
    }



    public function edit($id)
    {
        $pettyCash = PettyCash::findOrFail($id);
        $karyawans = MasterKaryawan::orderBy('nama_lengkap')->get();
        return view('petty_cash.edit', compact('pettyCash', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:masuk,keluar',
            'kategori' => 'required|string',
            'subkategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $pettyCash = PettyCash::findOrFail($id);

        $pettyCash->update([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'subkategori' => $request->subkategori,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'diambil_oleh' => $request->diambil_oleh,
        ]);

        return redirect()->route('petty_cash.index')->with('success', 'Transaksi petty cash berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pettyCash = PettyCash::findOrFail($id);
        $pettyCash->delete();

        return redirect()->route('petty_cash.index')->with('success', 'Transaksi petty cash berhasil dihapus.');
    }
}
