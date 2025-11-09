<?php

namespace App\Http\Controllers;

use App\Models\MasterKaryawan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PelanggaranController extends Controller
{
    // 📌 List semua pelanggaran
    public function index()
    {
        $pelanggaran = Pelanggaran::with('karyawan')->latest()->paginate(10);
        return view('pelanggaran.index', compact('pelanggaran'));
    }

    // 📌 Form create pelanggaran
    public function create()
    {
        $karyawan = MasterKaryawan::all(); // dropdown semua karyawan
        return view('pelanggaran.create', compact('karyawan'));
    }

   // 📌 Simpan pelanggaran baru
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'        => 'required|exists:master_karyawans,id',
            'jenis'              => 'required|in:Surat Teguran,SP1,SP2,SP3',
            'status_pelanggaran' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_mulai'      => 'required|date',
            'durasi'             => 'required', // ✅ durasi minggu
            'keterangan'         => 'nullable|string',
            'file_surat'         => 'nullable|mimes:pdf,jpg,png|max:2048',
        ]);

    // Bersihkan & cast durasi supaya jadi integer (ambil angka saja)
        $durasiRaw = $request->input('durasi');
        // Ambil angka dari input, mis. "3" atau "3 minggu" -> 3
        $durasi = (int) preg_replace('/\D/', '', (string) $durasiRaw);

        // Validasi durasi sebagai integer 1..8 setelah pembersihan
        if ($durasi < 1 || $durasi > 8) {
            return back()->withInput()->withErrors(['durasi' => 'Durasi harus berupa angka antara 1 hingga 8 minggu.']);
        }

        $tanggal_mulai   = Carbon::parse($request->tanggal_mulai);
        // Gunakan integer $durasi (minggu)
        $tanggal_selesai = $tanggal_mulai->copy()->addWeeks($durasi);

        $pelanggaran = new Pelanggaran();
        $pelanggaran->karyawan_id        = $request->karyawan_id;
        $pelanggaran->jenis              = $request->jenis;
        $pelanggaran->status_pelanggaran = $request->status_pelanggaran;
        $pelanggaran->tanggal_mulai      = $tanggal_mulai;
        $pelanggaran->tanggal_selesai    = $tanggal_selesai;
        $pelanggaran->durasi             = $request->durasi; // ✅ simpan juga durasi
        $pelanggaran->keterangan         = $request->keterangan;

        if ($request->hasFile('file_surat')) {
            $pelanggaran->file_surat = $request->file('file_surat')->store('pelanggaran', 'public');
        }

        $pelanggaran->created_by = Auth::id();
        $pelanggaran->save();

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Surat pelanggaran berhasil ditambahkan!');
    }

    // 📌 Detail pelanggaran
    public function show($id)
    {
        $pelanggaran = Pelanggaran::with('karyawan')->findOrFail($id);
        return view('pelanggaran.show', compact('pelanggaran'));
    }

    // 📌 Form edit pelanggaran
    public function edit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $karyawan = MasterKaryawan::all();
        return view('pelanggaran.edit', compact('pelanggaran', 'karyawan'));
    }

    // 📌 Update pelanggaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'karyawan_id'     => 'required|exists:master_karyawans,id',
            'jenis'           => 'required|in:Surat Teguran,SP1,SP2,SP3',
            'status_pelanggaran' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_mulai'   => 'required|date',
            'keterangan'      => 'nullable|string',
            'file_surat'      => 'nullable|mimes:pdf,jpg,png|max:2048',
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);

        $tanggal_mulai   = Carbon::parse($request->tanggal_mulai);
        $tanggal_selesai = $tanggal_mulai->copy()->addDays(30);

        $pelanggaran->karyawan_id     = $request->karyawan_id;
        $pelanggaran->jenis           = $request->jenis;
        $pelanggaran->status_pelanggaran = $request->status_pelanggaran;
        $pelanggaran->tanggal_mulai   = $tanggal_mulai;
        $pelanggaran->tanggal_selesai = $tanggal_selesai;
        $pelanggaran->keterangan      = $request->keterangan;

        if ($request->hasFile('file_surat')) {
            $pelanggaran->file_surat = $request->file('file_surat')->store('pelanggaran', 'public');
        }

        $pelanggaran->modify_by = Auth::id();
        $pelanggaran->save();

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Surat pelanggaran berhasil diperbarui!');
    }

    // 📌 Hapus pelanggaran (opsional)
    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus!');
    }

    // PelanggaranController.php
    public function viewFile($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $path = storage_path('app/public/'.$pelanggaran->file_surat);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path); // ini akan set header Content-Type sesuai file
    }

    // 📌 Summary Pelanggaran
    public function summary()
    {
        // Total semua pelanggaran
        $total = Pelanggaran::count();

        // Hitung per jenis
        $perJenis = Pelanggaran::select('jenis', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis')
            ->get();

        // Hitung total per karyawan
        $perKaryawan = Pelanggaran::select('karyawan_id', DB::raw('COUNT(*) as total'))
            ->with('karyawan')
            ->groupBy('karyawan_id')
            ->get();

        // Load semua data (riwayat detail)
        $riwayat = Pelanggaran::with('karyawan')->latest()->get();

        return view('pelanggaran.summary', compact('total', 'perJenis', 'perKaryawan', 'riwayat'));
    }




}
