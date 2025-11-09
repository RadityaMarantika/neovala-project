<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    // menampilkan daftar lembur
    public function index()
    {
        // cek kalau user bukan super admin, lempar forbidden
        if (!auth()->user()->hasRole('Web App Support')) {
            abort(403, 'Unauthorized action.');
        }

        $lemburs = Lembur::with('karyawan')->latest()->get();
        return view('lembur.index', compact('lemburs'));
    }

    // form create
    public function create()
    {
        return view('lembur.create');
    }

    // simpan pengajuan lembur
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_lembur' => 'required|date',
            'durasi_jam_lembur' => 'required',
            'jam_mulai_lembur' => 'required',
            'jam_selesai_lembur' => 'required',
            'alasan_lembur' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengajuan_lembur', 'public');
        }

        Lembur::create([
            'karyawan_id' => Auth::id(), // otomatis dari user login
            'tanggal_lembur' => $request->tanggal_lembur,
            'durasi_jam_lembur' => $request->durasi_jam_lembur,
            'jam_mulai_lembur' => $request->jam_mulai_lembur,
            'jam_selesai_lembur' => $request->jam_selesai_lembur,
            'alasan_lembur' => $request->alasan_lembur,
            'status_lembur' => 'Request',
            'foto' => $fotoPath,
            'request_by' => Auth::id(),
        ]);

        return redirect()->route('lembur.my')->with('success', 'Pengajuan lembur berhasil diajukan.');
    }

    // update status lembur
    public function updateStatus(Request $request, $id)
    {
        $lembur = Lembur::findOrFail($id);
        $status = $request->status;

        if ($status == 'Accepted') {
            $lembur->update([
                'status_lembur' => 'Accepted',
                'accepted_by' => Auth::id()
            ]);
        } elseif ($status == 'Rejected') {
            $lembur->update([
                'status_lembur' => 'Rejected',
                'rejected_by' => Auth::id()
            ]);
        } // elseif ($status == 'Ongoing') {
           // $lembur->update([
            //    'status_lembur' => 'Ongoing',
            // ]);
        // } elseif ($status == 'Done') {
           // $lembur->update([
             //   'status_lembur' => 'Done',
               // 'done_by' => Auth::id()
            // ]);
        // } 

        return back()->with('success', 'Status lembur berhasil diperbarui.');
    }

    public function accept($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'Accepted';
        $lembur->accepted_by = Auth::id();
        $lembur->save();

        return redirect()->back()->with('success', 'Pengajuan lembur diterima.');
    }

    public function reject($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'Rejected';
        $lembur->rejected_by = Auth::id();
        $lembur->save();

        return redirect()->back()->with('success', 'Pengajuan lembur ditolak.');
    }

    public function start($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'Ongoing';
        $lembur->request_by = Auth::id();
        $lembur->save();

        return redirect()->back()->with('success', 'Lembur dimulai.');
    }

    public function done($id)
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->status_lembur = 'Done';
        $lembur->done_by = Auth::id();
        $lembur->save();

        return redirect()->back()->with('success', 'Lembur selesai.');
    }

    // halaman untuk karyawan melihat lemburnya sendiri
    public function myLembur()
    {
        $lemburs = Lembur::where('karyawan_id', Auth::id())
            ->latest()
            ->get();

        return view('lembur.my', compact('lemburs'));
    }

}
