<?php

namespace App\Http\Controllers;

use App\Models\MasterShift;
use Illuminate\Http\Request;

class MasterShiftController extends Controller
{
    public function index()
    {
        $masterShifts = MasterShift::orderBy('buat_kode_shift')->get();
        return view('master_shifts.index', compact('masterShifts'));
    }

    public function create()
    {
        // tidak perlu ambil semua masterShifts kalau hanya untuk create
        return view('master_shifts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'buat_kode_shift' => 'required|unique:master_shifts,buat_kode_shift',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
        ]);

        MasterShift::create($data);
        return redirect()->route('master_shifts.index')->with('success','Master shift berhasil dibuat.');
    }

    public function edit(MasterShift $masterShift)
    {
        return view('master_shifts.edit', compact('masterShift'));
    }

    public function update(Request $request, MasterShift $masterShift)
    {
        $data = $request->validate([
            'buat_kode_shift' => 'required|unique:master_shifts,buat_kode_shift,' . $masterShift->id,
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
        ]);

        $masterShift->update($data);
        return redirect()->route('master_shifts.index')->with('success','Master shift berhasil diupdate.');
    }

    public function destroy(MasterShift $masterShift)
    {
        $masterShift->delete();
        return redirect()->route('master_shifts.index')->with('success','Master shift berhasil dihapus.');
    }

}
