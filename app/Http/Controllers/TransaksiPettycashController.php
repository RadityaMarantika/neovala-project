<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPettycash;
use App\Models\MasterPettycash;
use App\Models\KategoriPettycash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransaksiPettycashController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiPettycash::with('pettycash', 'user')->latest()->get();
        return view('transaksi_pettycash.index', compact('transaksi'));
    }

   public function create()
{
    $user = Auth::user();
    $pettycashs = MasterPettycash::all();
    $pettycash_user = null;

    if ($user && $user->karyawan) {
        $pettycash_user = MasterPettycash::where('dikelola_oleh_id', $user->karyawan->id)->first();
    }

    // Ambil kategori unik dari tabel kategori_pettycashes
    $kategoriList = KategoriPettycash::select('kategori')->distinct()->orderBy('kategori')->get();

    return view('transaksi_pettycash.create', compact('pettycashs', 'pettycash_user', 'kategoriList'));
}



    public function store(Request $request)
    {
        $request->validate([
            'pettycash_id' => 'required|exists:master_pettycashes,id',
            'region' => 'required',
            'jenis_transaksi' => 'required|in:Cash In,Cash Out',
            'metode_transaksi' => 'required|in:Cash,Transfer',
            'kategori' => 'required',
            'sub_kategori' => 'required',
            'keperluan' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'bukti_foto' => 'nullable|image|max:2048',
        ]);

        $master = MasterPettycash::findOrFail($request->pettycash_id);
        $saldoSebelum = $master->saldo_berjalan;
        $saldoBerjalan = $request->jenis_transaksi === 'Cash In'
            ? $saldoSebelum + $request->nominal
            : $saldoSebelum - $request->nominal;

        $fotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $fotoPath = $request->file('bukti_foto')->store('bukti_pettycash', 'public');
        }

        TransaksiPettycash::create([
            'pettycash_id' => $request->pettycash_id,
            'tanggal_transaksi' => now(),
            'jenis_transaksi' => $request->jenis_transaksi,
            'metode_transaksi' => $request->metode_transaksi,
            'region' => $request->region,
            'kategori' => $request->kategori,
            'sub_kategori' => $request->sub_kategori,
            'keperluan' => $request->keperluan,
            'nominal' => $request->nominal,
            'bukti_foto' => $fotoPath,
            'saldo_sebelum' => $saldoSebelum,
            'saldo_berjalan' => $saldoBerjalan,
            'created_by' => Auth::id(),
        ]);

        // Update saldo di master
        $master->update(['saldo_berjalan' => $saldoBerjalan]);

        return redirect()->route('transaksi-pettycash.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function edit(TransaksiPettycash $transaksiPettycash)
    {
        $pettycashs = MasterPettycash::all();
        return view('transaksi_pettycash.edit', compact('transaksiPettycash', 'pettycashs'));
    }

    public function update(Request $request, TransaksiPettycash $transaksiPettycash)
    {
        // Untuk keamanan, biasanya transaksi petty cash tidak diubah, tapi bisa ditambahkan kalau kamu mau
    }

    public function destroy(TransaksiPettycash $transaksiPettycash)
    {
        $transaksiPettycash->delete();
        return back()->with('success', 'Transaksi berhasil dihapus!');
    }
}
