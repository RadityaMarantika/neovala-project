<?php

namespace App\Http\Controllers;

use App\Models\ShiftKaryawan;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TukarShiftController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $karyawan = MasterKaryawan::where('user_id', $user->id)->first();

        // Ambil semua shift milik karyawan login
        $shiftsSaya = ShiftKaryawan::with('shift')
            ->where('karyawan_id', $karyawan->id)
            ->get();

        // Ambil semua shift karyawan lain
        $shiftsLain = ShiftKaryawan::with(['shift', 'karyawan'])
            ->where('karyawan_id', '!=', $karyawan->id)
            ->get();

        return view('shifts.tukar', compact('shiftsSaya', 'shiftsLain'));
    }

   public function tukar(Request $request)
{
    $data = $request->validate([
        'shift_saya' => 'required|exists:shift_karyawan,id',
        'shift_teman' => 'required|exists:shift_karyawan,id',
    ]);

    $user = Auth::user();
    $karyawanSaya = MasterKaryawan::where('user_id', $user->id)->first();

    $shiftSaya = ShiftKaryawan::findOrFail($data['shift_saya']);
    $shiftTeman = ShiftKaryawan::findOrFail($data['shift_teman']);

    DB::transaction(function () use ($shiftSaya, $shiftTeman, $karyawanSaya) {
        // Simpan data sementara untuk tukar shift_id dan status
        $tempShiftId = $shiftSaya->shift_id;
        $tempStatus = $shiftSaya->status;

        // Tukar shift_id
        $shiftSaya->shift_id = $shiftTeman->shift_id;
        $shiftTeman->shift_id = $tempShiftId;

        // Tukar status (Bekerja <-> Libur)
        $shiftSaya->status = $shiftTeman->status;
        $shiftTeman->status = $tempStatus;

        // Catatan otomatis
        $namaSaya = $karyawanSaya->nama_lengkap ?? $karyawanSaya->nama;
        $namaTeman = $shiftTeman->karyawan->nama_lengkap ?? $shiftTeman->karyawan->nama;

        $shiftSaya->catatan = "{$namaSaya} tukar shift dengan {$namaTeman}";
        $shiftTeman->catatan = "{$namaTeman} tukar shift dengan {$namaSaya}";

        // Simpan perubahan
        $shiftSaya->save();
        $shiftTeman->save();
    });

    return back()->with('success', 'Shift dan status berhasil ditukar.');
}

}
