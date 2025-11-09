<?php

namespace App\Http\Controllers;

use App\Models\PengajuanShift;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanShiftController extends Controller
{
    // List semua pengajuan untuk HR
    public function index()
    {
        $pengajuans = PengajuanShift::with(['karyawan', 'shift', 'user'])->latest()->get();
        return view('pengajuan_shift.index', compact('pengajuans'));
    }

    // Form create untuk karyawan
    public function create()
    {
        $shifts = Shift::orderBy('jadwal_tanggal', 'asc')->get();
        return view('pengajuan_shift.create', compact('shifts'));
    }

    // Simpan pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'jenis_pengajuan' => 'required|in:izin,backup,sakit',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'foto_bukti' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengajuan_foto', 'public');
        }
        
        $fotobuktiPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotobuktiPath = $request->file('foto_bukti')->store('pengajuan_fotobukti', 'public');
        }

        PengajuanShift::create([
            'karyawan_id' => Auth::id(), // otomatis dari user login
            'shift_id' => $request->shift_id,
            'pengajuan_by' => Auth::id(),
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'foto' => $fotoPath,
            'foto_bukti' => $fotobuktiPath,
            'status' => 'pending',
        ]);

        return redirect()->route('pengajuan-shift.index')->with('success', 'Pengajuan berhasil dikirim.');
    }

    // Approve pengajuan
    public function approve(PengajuanShift $pengajuan)
    {
        $pengajuan->update([
            'status' => 'approved',
            'approve_by' => Auth::id()
        ]);
        $statusMap = [
            'izin' => 'izin',
            'backup' => 'backup',
            'sakit' => 'sakit',
        ];

        DB::table('shift_karyawan')
            ->where('shift_id', $pengajuan->shift_id)
            ->where('karyawan_id', $pengajuan->karyawan_id)
            ->update(['status' => $statusMap[$pengajuan->jenis_pengajuan]]);

        return back()->with('success', 'Pengajuan disetujui & shift diperbarui.');
    }

    // Reject pengajuan
    public function reject(PengajuanShift $pengajuan)
    {
        $pengajuan->update([
            'status' => 'rejected',
            'approve_by' => Auth::id()
        ]);
        
        return back()->with('success', 'Pengajuan ditolak.');
    }
}
