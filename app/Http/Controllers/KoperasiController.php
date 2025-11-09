<?php

namespace App\Http\Controllers;

use App\Models\KoperasiAccount;
use App\Models\KoperasiTabunganTransaction;
use App\Models\KoperasiPinjaman;
use App\Models\KoperasiPinjamanInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\MasterKaryawan;

class KoperasiController extends Controller
{

    // HR lihat semua akun koperasi

    public function indexAccounts()
    {
        // eager load relasi karyawan dan creator (jika ada)
        $accounts = KoperasiAccount::with(['karyawan','creator'])->get();

        // ambil list karyawan untuk dropdown
        $karyawans = MasterKaryawan::orderBy('nama_lengkap')->get();

        return view('koperasi.hr.accounts.index', compact('accounts', 'karyawans'));
    }

    // HR lihat transaksi tabungan untuk approval
    public function indexTabungan()
    {
        $tabungans = KoperasiTabunganTransaction::with('account.karyawan')
            ->where('status', 'request')
            ->get();
        return view('koperasi.hr.tabungan.index', compact('tabungans'));
    }

    // HR lihat pengajuan pinjaman untuk approval
    public function indexPinjaman()
    {
        $pinjamans = KoperasiPinjaman::with('account.karyawan')
            ->where('status', 'request')
            ->get();
        return view('koperasi.hr.pinjaman.index', compact('pinjamans'));
    }


    // HR buat akun koperasi untuk karyawan
    public function createAccount(Request $request)
    {
        
        if (!auth()->user()->hasRole('HR')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'karyawan_id' => 'required|exists:master_karyawans,id',
            'jenis' => 'required|in:tabungan,pinjaman',
        ]);

        // Cek apakah karyawan sudah punya account jenis ini
        $exists = KoperasiAccount::where('karyawan_id', $request->karyawan_id)
            ->where('jenis', $request->jenis)
            ->exists();

        if ($exists) {
            return back()->withErrors('Karyawan ini sudah punya akun koperasi jenis ' . $request->jenis);
        }

        $kode = strtoupper($request->jenis[0]) . '-' . Str::upper(Str::random(6));

        $account = KoperasiAccount::create([
            'kode_koperasi' => $kode,
            'jenis' => $request->jenis,
            'karyawan_id' => $request->karyawan_id,
            'tanggal_buat' => now(),
            'dibuat_oleh' => Auth::id(),
        ]);

        return back()->with('success', "Akun koperasi {$account->jenis} berhasil dibuat.");
    }

    // Approve / Reject tabungan
    public function approveTabungan($id, Request $request)
    {
        
        if (!auth()->user()->hasRole('HR')) {
            abort(403, 'Unauthorized action.');
        }

        $tabungan = KoperasiTabunganTransaction::findOrFail($id);

        if ($request->status == 'approved') {
            $lastSaldo = KoperasiTabunganTransaction::where('koperasi_account_id', $tabungan->koperasi_account_id)
                ->where('status', 'approved')
                ->sum('jumlah');

            $saldoBaru = $lastSaldo + $tabungan->jumlah;

            $tabungan->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'saldo_after' => $saldoBaru,
            ]);
        } else {
            $tabungan->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
            ]);
        }

        return back()->with('success', "Tabungan berhasil diupdate.");
    }

    // Approve / Reject pinjaman
    public function approvePinjaman($id, Request $request)
    {
        
        if (!auth()->user()->hasRole('HR')) {
            abort(403, 'Unauthorized action.');
        }

        $pinjaman = KoperasiPinjaman::findOrFail($id);

        if ($request->status == 'approved') {
            $nominalPerCicilan = $pinjaman->jumlah_pinjam / $pinjaman->jumlah_cicilan;

            for ($i = 1; $i <= $pinjaman->jumlah_cicilan; $i++) {
                KoperasiPinjamanInstallment::create([
                    'koperasi_pinjaman_id' => $pinjaman->id,
                    'periode' => now()->addMonths($i - 1)->format('M Y'),
                    'jatuh_tempo' => now()->addMonths($i - 1)->endOfMonth(),
                    'jumlah_cicilan' => $nominalPerCicilan,
                ]);
            }

            $pinjaman->update([
                'status' => 'on progress',
                'approved_by' => Auth::id(),
                'nominal_per_cicilan' => $nominalPerCicilan,
            ]);
        } else {
            $pinjaman->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
            ]);
        }

        return back()->with('success', "Pinjaman berhasil diupdate.");
    }

    public function getAvailableKaryawan($jenis)
    {
        if (!in_array($jenis, ['tabungan', 'pinjaman'])) {
            return response()->json([]);
        }

        $existing = KoperasiAccount::where('jenis', $jenis)
            ->pluck('karyawan_id')
            ->toArray();

        $available = MasterKaryawan::whereNotIn('id', $existing)
            ->select('id', 'nama_lengkap')
            ->orderBy('nama_lengkap')
            ->get();

        return response()->json($available);
    }



}
