<?php

namespace App\Http\Controllers;

use App\Models\KategoriPettycash;
use Illuminate\Http\Request;

class KategoriPettycashController extends Controller
{
    public function index()
    {
        $kategoris = KategoriPettycash::orderBy('kategori')->get();
        return view('kategori_pettycash.index', compact('kategoris'));
    }

    public function getSubkategori($kategori)
{
    $data = \App\Models\KategoriPettycash::where('kategori', $kategori)
        ->select('sub_kategori')
        ->orderBy('sub_kategori')
        ->get();

    return response()->json($data);
}


    public function create()
    {
        return view('kategori_pettycash.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'sub_kategori' => 'required|string|max:255',
        ]);

        KategoriPettycash::create($request->all());
        return redirect()->route('kategori_pettycash.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(KategoriPettycash $kategori_pettycash)
    {
        return view('kategori_pettycash.edit', compact('kategori_pettycash'));
    }

    public function update(Request $request, KategoriPettycash $kategori_pettycash)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'sub_kategori' => 'required|string|max:255',
        ]);

        $kategori_pettycash->update($request->all());
        return redirect()->route('kategori_pettycash.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(KategoriPettycash $kategori_pettycash)
    {
        $kategori_pettycash->delete();
        return redirect()->route('kategori_pettycash.index')->with('success', 'Data berhasil dihapus!');
    }

}
