<?php

namespace App\Http\Controllers;

use App\Models\MasterRegion;
use Illuminate\Http\Request;

class MasterRegionController extends Controller
{
    public function index()
    {
        $data = MasterRegion::all();
        return view('master_regions.index', compact('data'));
    }

    public function create()
    {
        return view('master_regions.create');
    }

    public function store(Request $request)
    {
        MasterRegion::create($request->all());
        return redirect()->route('master_regions.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(MasterRegion $masterRegion)
    {
        return view('master_regions.show', compact('masterRegion'));
    }

    public function edit(MasterRegion $masterRegion)
    {
        return view('master_regions.edit', compact('masterRegion'));
    }

    public function update(Request $request, MasterRegion $masterRegion)
    {
        $masterRegion->update($request->all());
        return redirect()->route('master_regions.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(MasterRegion $masterRegion)
    {
        $masterRegion->delete();
        return redirect()->route('master_regions.index')->with('success', 'Data berhasil dihapus');
    }
}
