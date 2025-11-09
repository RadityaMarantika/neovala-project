<?php

namespace App\Http\Controllers;

use App\Models\MasterAgen;
use Illuminate\Http\Request;

class MasterAgenController extends Controller
{
    public function index()
    {
        $master_agens = MasterAgen::all();
        return view('master_agens.index', compact('master_agens'));
    }

    public function create()
    {
        return view('master_agens.create');
    }

    public function store(Request $request)
    {
        MasterAgen::create($request->all());
        return redirect()->route('master_agens.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(MasterAgen $masterAgen)
    {
        return view('master_agens.show', compact('masterAgen'));
    }

    public function edit(MasterAgen $masterAgen)
    {
        return view('master_agens.edit', compact('masterAgen'));
    }

    public function update(Request $request, MasterAgen $masterAgen)
    {
        $masterAgen->update($request->all());
        return redirect()->route('master_agens.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(MasterAgen $masterAgen)
    {
        $masterAgen->delete();
        return redirect()->route('master_agens.index')->with('success', 'Data berhasil dihapus');
    }
}
