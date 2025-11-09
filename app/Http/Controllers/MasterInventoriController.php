<?php

namespace App\Http\Controllers;

use App\Models\MasterInventori;
use Illuminate\Http\Request;

class MasterInventoriController extends Controller
{
    public function index()
    {
        $inventoris = MasterInventori::orderBy('nama_barang')->paginate(10);
        return view('master_inventori.index', compact('inventoris'));
    }

    public function create()
    {
        $kategoriOptions = [
            'Amenitis',
            'Perkakas Rumah Tangga',
            'Elektronik',
            'Perlengkapan Dapur',
            'Perlengkapan Makan',
        ];

        $jenisOptions = ['Barang Habis Pakai', 'Barang Tidak Habis Pakai'];
        $satuanOptions = ['pcs', 'kg', 'liter', 'pack', 'unit'];

        return view('master_inventori.create', compact('kategoriOptions', 'jenisOptions', 'satuanOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:master_inventoris,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'satuan' => 'required|string',
            'merk' => 'nullable|string|max:100',
            'kategori' => 'required|string',
            'jenis' => 'required|string',
            'catatan' => 'required|string',
            'nama_toko' => 'nullable|string|max:100',
            'link_toko' => 'required|string',
            'maps' => 'required|string',
        ]);

        MasterInventori::create($validated);

        return redirect()->route('master_inventori.index')
            ->with('success', 'Data inventori berhasil ditambahkan.');
    }

    public function show(MasterInventori $masterInventori)
    {
        $inventori = $masterInventori;
        return view('master_inventori.show', compact('inventori'));
    }


    public function edit(MasterInventori $masterInventori)
    {
        $kategoriOptions = [
            'Amenitis',
            'Perkakas Rumah Tangga',
            'Elektronik',
            'Perlengkapan Dapur',
            'Perlengkapan Makan',
        ];

        $jenisOptions = ['Barang Habis Pakai', 'Barang Tidak Habis Pakai'];
        $satuanOptions = ['pcs', 'kg', 'liter', 'pack', 'unit'];

        return view('master_inventori.edit', compact('masterInventori', 'kategoriOptions', 'jenisOptions', 'satuanOptions'));
    }

    public function update(Request $request, MasterInventori $masterInventori)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:master_inventoris,kode_barang,' . $masterInventori->id,
            'nama_barang' => 'required|string|max:100',
            'satuan' => 'required|string',
            'merk' => 'nullable|string|max:100',
            'kategori' => 'required|string',
            'jenis' => 'required|string',
            'catatan' => 'required|string',
            'nama_toko' => 'nullable|string|max:100',
            'link_toko' => 'required|string',
            'maps' => 'required|string',
        ]);

        $masterInventori->update($validated);

        return redirect()->route('master_inventori.index')
            ->with('success', 'Data inventori berhasil diperbarui.');
    }

    public function destroy(MasterInventori $masterInventori)
    {
        $masterInventori->delete();
        return redirect()->route('master_inventori.index')
            ->with('success', 'Data inventori berhasil dihapus.');
    }
}
