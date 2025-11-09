<?php

namespace App\Http\Controllers;

use App\Models\MasterPettycash;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;

class MasterPettycashController extends Controller
{
    public function index()
    {
        $pettycashs = MasterPettycash::latest()->get();
        return view('master_pettycash.index', compact('pettycashs'));
    }

    public function create()
    {
        $karyawans = MasterKaryawan::orderBy('nama_lengkap')->get();
        return view('master_pettycash.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pettycash' => 'required|string|max:255',
            'dikelola_oleh_id' => 'nullable|exists:master_karyawans,id',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        MasterPettycash::create([
            'nama_pettycash' => $request->nama_pettycash,
            'dikelola_oleh_id' => $request->dikelola_oleh_id,
            'saldo_awal' => $request->saldo_awal,
            'saldo_berjalan' => $request->saldo_awal,
        ]);

        return redirect()->route('master-pettycash.index')
            ->with('success', 'Data petty cash berhasil dibuat!');
    }


    public function edit(MasterPettycash $masterPettycash)
    {
        $pettycash = $masterPettycash;
        return view('master_pettycash.edit', compact('pettycash'));
    }

    public function update(Request $request, MasterPettycash $masterPettycash)
    {
        $request->validate([
            'nama_pettycash' => 'required|string|max:255',
            'dikelola_oleh' => 'required|string|max:255',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        $masterPettycash->update($request->only(['nama_pettycash', 'dikelola_oleh', 'saldo_awal']));

        return redirect()->route('master-pettycash.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(MasterPettycash $masterPettycash)
    {
        $masterPettycash->delete();
        return redirect()->route('master-pettycash.index')->with('success', 'Data berhasil dihapus!');
    }
}
