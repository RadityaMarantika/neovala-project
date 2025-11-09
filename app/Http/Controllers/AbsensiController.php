<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Shift;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // ----- Konfigurasi batas telat (menit) -----
    private function batasTelatMasuk(): int { return 30; }
    private function batasTidakAbsenPulang(): int { return 60; } // telat lebih 60 menit dianggap Tidak Absen Pulang

// ----- INDEX: LIST ABSENSI -----
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Absensi::with(['karyawan','shift'])->latest();

        // Kalau bukan admin → filter absensi sesuai karyawan yang login
        if (!$user->hasRole('Web App Support')) {
            $karyawan = $user->karyawan;
            if ($karyawan) {
                $query->where('karyawan_id', $karyawan->id);
            } else {
                return redirect()->back()->withErrors('Data karyawan tidak ditemukan.');
            }
        }

        // Filter by tanggal (opsional)
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $absensis = $query->paginate(10);

        return view('absensi.index', compact('absensis'));
    }



    // ----- FORM MASUK -----
   public function createMasuk()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return redirect()->back()->withErrors('Data karyawan tidak ditemukan.');
        }

        $today = Carbon::today();

        $shift = Shift::whereDate('jadwal_tanggal', $today)
            ->whereHas('karyawans', function ($q) use ($karyawan) {
                $q->where('master_karyawans.id', $karyawan->id);
            })
            ->first();

        if (!$shift) {
            return redirect()->back()->withErrors('Shift hari ini belum dijadwalkan.');
        }

        return view('absensi.masuk', compact('shift', 'karyawan'));
    }


    public function storeMasuk(Request $request) {
        $data = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'karyawan_id' => 'required|exists:master_karyawans,id',
            'foto_selfi_masuk' => 'required|image|max:2048',
            'share_live_location_masuk' => 'required|string|max:500',
            'file_form_masuk' => 'nullable|file|max:4096'
        ]);

        $shift = Shift::findOrFail($data['shift_id']);

        // Simpan file
        $pathSelfie = $request->file('foto_selfi_masuk')->store('absensi/selfie_masuk', 'public');
        $pathForm = $request->file('file_form_masuk')?->store('absensi/form_masuk', 'public');

        $now = Carbon::now();
        // Kalau jadwal_tanggal bertipe DATETIME
        $jamMasuk = Carbon::parse($shift->jadwal_tanggal)->setTimeFromTimeString($shift->jam_masuk_kerja);

        $telatMenit = $now->isAfter($jamMasuk) ? $jamMasuk->diffInMinutes($now) : 0;

        // Tentukan status otomatis
        $status = 'Masuk';
        if ($telatMenit > 0 && $telatMenit <= $this->batasTelatMasuk()) {
            $status = 'Telat';
        } elseif ($telatMenit > $this->batasTelatMasuk()) {
            $status = 'Alfa';
        }

        // Buat atau update (jika sudah ada record untuk shift & karyawan)
        $absen = Absensi::updateOrCreate(
            ['karyawan_id' => $data['karyawan_id'], 'shift_id' => $data['shift_id']],
            [
                'waktu_masuk' => $now,
                'menit_telat_masuk' => $telatMenit,
                'foto_selfi_masuk' => $pathSelfie,
                'share_live_location_masuk' => $data['share_live_location_masuk'],
                'status_absen_masuk' => $status,
                'file_form_masuk' => $pathForm ?? null,
                'masuk_by' => Auth::id(),
            ]
        );

        return redirect()->route('absensi.show', $absen->id)->with('success', 'Absen masuk tercatat.');
    }

    // ----- FORM PULANG -----
    public function createPulang()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            return redirect()->back()->withErrors('Data karyawan tidak ditemukan.');
        }

        $today = Carbon::today();

        $shift = Shift::whereDate('jadwal_tanggal', $today)
            ->whereHas('karyawans', function ($q) use ($karyawan) {
                $q->where('master_karyawans.id', $karyawan->id);
            })
            ->first();

        if (!$shift) {
            return redirect()->back()->withErrors('Shift hari ini belum dijadwalkan.');
        }

        return view('absensi.pulang', compact('shift', 'karyawan'));
    }

    public function storePulang(Request $request) {
        $data = $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'karyawan_id' => 'required|exists:master_karyawans,id',
            'foto_selfi_pulang' => 'required|image|max:2048',
            'share_live_location_pulang' => 'required|string|max:500',
            'file_form_pulang' => 'nullable|file|max:4096'
        ]);

        $shift = Shift::findOrFail($data['shift_id']);

        // Simpan file
        $pathSelfie = $request->file('foto_selfi_pulang')->store('absensi/selfie_pulang', 'public');
        $pathForm = $request->file('file_form_pulang')?->store('absensi/form_pulang', 'public');

        $now = Carbon::now();

        $jamPulang = Carbon::parse($shift->jadwal_tanggal)->setTimeFromTimeString($shift->jam_pulang_kerja);
        // "Telat pulang" diartikan pulang melebihi jam pulang (lembur/terlambat checkout)
        $telatMenit = $now->isAfter($jamPulang) ? $jamPulang->diffInMinutes($now) : 0;

        $status = $telatMenit === 0 ? 'Tepat Waktu' : 'Telat';
        if ($telatMenit >= $this->batasTidakAbsenPulang()) {
            $status = 'Tidak Absen Pulang';
        }

        $absen = Absensi::firstOrCreate(
            ['karyawan_id' => $data['karyawan_id'], 'shift_id' => $data['shift_id']]
        );

        $absen->update([
            'waktu_pulang' => $now,
            'menit_telat_pulang' => $telatMenit,
            'foto_selfi_pulang' => $pathSelfie,
            'share_live_location_pulang' => $data['share_live_location_pulang'],
            'status_absen_pulang' => $status,
            'file_form_pulang' => $pathForm ?? null,
            'pulang_by' => Auth::id(),
        ]);

        return redirect()->route('absensi.show', $absen->id)->with('success', 'Absen pulang tercatat.');
    }

    // ----- SHOW DETAIL ABSENSI -----
    public function show(Absensi $absensi) {
        $absensi->load('karyawan','shift');
        return view('absensi.show', compact('absensi'));
    }

    // ----- ADMIN: UPDATE STATUS MANUAL (izin/backup/libur) -----
    public function adminUpdateMasuk(Request $request, Absensi $absensi) {
        $data = $request->validate([
            'status_absen_masuk' => 'required|in:Masuk,Telat,Alfa,Izin,Backup,Libur',
            'file_form_masuk' => 'nullable|file|max:4096',
        ]);
        if ($request->hasFile('file_form_masuk')) {
            $path = $request->file('file_form_masuk')->store('absensi/form_masuk', 'public');
            $absensi->file_form_masuk = $path;
        }
        $absensi->status_absen_masuk = $data['status_absen_masuk'];
        $absensi->modifyMasuk_by = Auth::id();
        $absensi->save();

        return back()->with('success', 'Status absen masuk diperbarui.');
    }

    public function adminUpdatePulang(Request $request, Absensi $absensi) {
        $data = $request->validate([
            'status_absen_pulang' => 'required|in:Tepat Waktu,Telat,Tidak Absen Pulang,Izin,Backup',
            'file_form_pulang' => 'nullable|file|max:4096',
        ]);
        if ($request->hasFile('file_form_pulang')) {
            $path = $request->file('file_form_pulang')->store('absensi/form_pulang', 'public');
            $absensi->file_form_pulang = $path;
        }
        $absensi->status_absen_pulang = $data['status_absen_pulang'];
        $absensi->modifyPulang_by = Auth::id();
        $absensi->save();

        return back()->with('success', 'Status absen pulang diperbarui.');
    }
}
