<?php

namespace App\Http\Controllers;

use App\Models\MasterChanelUnit;
use Illuminate\Http\Request;

class MasterChanelUnitController extends Controller
{
    public function index()
    {
        $data = MasterChanelUnit::all();
        return view('master_chanel_units.index', compact('data'));
    }

    public function create()
    {
        return view('master_chanel_units.create');
    }

    public function store(Request $request)
    {
        MasterChanelUnit::create($request->all());
        return redirect()->route('master_chanel_units.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(MasterChanelUnit $masterChanelUnit)
    {
        return view('master_chanel_units.show', compact('masterChanelUnit'));
    }

    public function edit(MasterChanelUnit $masterChanelUnit)
    {
        return view('master_chanel_units.edit', compact('masterChanelUnit'));
    }

    public function update(Request $request, MasterChanelUnit $masterChanelUnit)
    {
        $masterChanelUnit->update($request->all());
        return redirect()->route('master_chanel_units.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(MasterChanelUnit $masterChanelUnit)
    {
        $masterChanelUnit->delete();
        return redirect()->route('master_chanel_units.index')->with('success', 'Data berhasil dihapus');
    }
}
