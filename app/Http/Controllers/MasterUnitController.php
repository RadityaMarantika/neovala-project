<?php

namespace App\Http\Controllers;

use App\Models\MasterUnit;
use App\Models\MasterRegion;
use Illuminate\Http\Request;

class MasterUnitController extends Controller
{
    public function index()
    {
        $units = MasterUnit::latest()->get();
        return view('master_units.index', compact('units'));
    }

    public function create()
    {
        $regions = MasterRegion::all();
        return view('master_units.create', compact('regions'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'jenis_koneksi' => 'required',
            'nama_lengkap' => 'required',
            'no_ktp' => 'required|unique:master_units',
            'no_telp' => 'required|unique:master_units',
            'alamat' => 'nullable',
            'nama_bank' => 'nullable',
            'no_rekening' => 'nullable|unique:master_units',
            'nama_rekening' => 'nullable',
            'region_id' => 'required|exists:master_regions,id',
            'no_unit' => 'required',
            'surat_kontrak' => 'nullable|file|mimes:pdf',
            'status_sewa' => 'required',
            'status_kelola' => 'required',
            'detail_hutang' => 'required',
        ]);

        if ($r->hasFile('surat_kontrak')) {
            $data['surat_kontrak'] = $r->file('surat_kontrak')->store('kontrak', 'public');
        }

        MasterUnit::create($data);

        return redirect()->route('master_units.index')->with('success', 'Data Unit berhasil ditambahkan.');
    }

    public function edit(MasterUnit $masterUnit)
    {
        $regions = MasterRegion::all();
        return view('master_units.edit', compact('masterUnit', 'regions'));
    }

    public function update(Request $r, MasterUnit $masterUnit)
    {
        $data = $r->validate([
            'jenis_koneksi' => 'required',
            'nama_lengkap' => 'required',
            'no_ktp' => 'required|unique:master_units,no_ktp,' . $masterUnit->id,
            'no_telp' => 'required|unique:master_units,no_telp,' . $masterUnit->id,
            'alamat' => 'nullable',
            'nama_bank' => 'nullable',
            'no_rekening' => 'nullable|unique:master_units,no_rekening,' . $masterUnit->id,
            'nama_rekening' => 'nullable',
            'region_id' => 'required|exists:master_regions,id',
            'no_unit' => 'required',
            'surat_kontrak' => 'nullable|file|mimes:pdf',
            'status_sewa' => 'required',
            'status_kelola' => 'required',
            'detail_hutang' => 'required',
        ]);

        if ($r->hasFile('surat_kontrak')) {
            $data['surat_kontrak'] = $r->file('surat_kontrak')->store('kontrak', 'public');
        }

        $masterUnit->update($data);

        return redirect()->route('master_units.index')->with('success', 'Data Unit berhasil diupdate.');
    }

    public function destroy(MasterUnit $masterUnit)
    {
        $masterUnit->delete();
        return redirect()->back()->with('success', 'Data Unit berhasil dihapus.');
    }
}
