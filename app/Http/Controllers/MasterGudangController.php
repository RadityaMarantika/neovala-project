<?php

namespace App\Http\Controllers;

use App\Models\MasterGudang;
use Illuminate\Http\Request;

class MasterGudangController extends Controller
{
    public function index()
    {
        $gudangs = MasterGudang::orderBy('nama_gudang')->paginate(10);
        return view('master_gudang.index', compact('gudangs'));
    }

    public function create()
    {
        return view('master_gudang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:100',
            'region' => 'required|string',
            'kepala_gudang' => 'nullable|string|max:100',
        ]);

        MasterGudang::create($validated);

        return redirect()->route('master_gudang.index')
            ->with('success', 'Data gudang berhasil ditambahkan.');
    }

    public function show(MasterGudang $masterGudang)
    {
        return view('master_gudang.show', compact('masterGudang'));
    }

    public function edit(MasterGudang $masterGudang)
    {
        return view('master_gudang.edit', compact('masterGudang'));
    }

    public function update(Request $request, MasterGudang $masterGudang)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:100',
            'region' => 'required|string',
            'kepala_gudang' => 'nullable|string|max:100',
        ]);

        $masterGudang->update($validated);

        return redirect()->route('master_gudang.index')
            ->with('success', 'Data gudang berhasil diperbarui.');
    }

    public function destroy(MasterGudang $masterGudang)
    {
        $masterGudang->delete();
        return redirect()->route('master_gudang.index')
            ->with('success', 'Data gudang berhasil dihapus.');
    }
}
