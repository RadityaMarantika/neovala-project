<?php

namespace App\Http\Controllers;

use App\Models\KoperasiAccount;
use App\Models\KoperasiTabunganTransaction;
use App\Models\KoperasiPinjaman;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoperasiKaryawanController extends Controller
{
    /**
     * Helper: cari master karyawan yang terkait user login
     */
    protected function resolveKaryawan()
    {
        $user = Auth::user();

        if (!empty($user->karyawan_id)) {
            return MasterKaryawan::find($user->karyawan_id);
        }

        if (!empty($user->master_karyawan_id)) {
            return MasterKaryawan::find($user->master_karyawan_id);
        }

        if (!empty($user->email)) {
            return MasterKaryawan::where('nama_lengkap', $user->name)->first();
        }

        return null;
    }

    // ======================================================
    // TABUNGAN
    // ======================================================

    public function indexTabungan()
    {
        $karyawan = $this->resolveKaryawan();
        if (!$karyawan) {
            return view('koperasi.tabungan.index', [
                'tabungans' => collect(),
                'saldo' => 0,
                'account' => null,
                'message' => 'Data karyawan tidak ditemukan. Hubungi HR.'
            ]);
        }

        $account = KoperasiAccount::where('karyawan_id', Auth::id())
            ->where('jenis', 'tabungan')
            ->first();


        if (!$account) {
            return view('koperasi.tabungan.index', [
                'tabungans' => collect(),
                'saldo' => 0,
                'account' => null,
                'message' => 'Akun tabungan belum dibuat oleh HR.'
            ]);
        }

        $tabungans = $account->tabunganTransactions()
            ->orderByDesc('tanggal_input')
            ->get();

        $saldo = $tabungans->where('status', 'approved')->sum('jumlah');

        return view('koperasi.tabungan.index', compact('tabungans', 'saldo', 'account'));
    }

    public function createTabungan($accountId = null)
    {
        $karyawan = $this->resolveKaryawan();
        if (!$karyawan) {
            return redirect()->route('koperasi.tabungan.index')
                ->with('error', 'Data karyawan tidak ditemukan.');
        }

        $account = $accountId
            ? KoperasiAccount::find($accountId)
            : KoperasiAccount::where('karyawan_id', $karyawan->id)->where('jenis', 'tabungan')->first();

        if (!$account || $account->karyawan_id != $karyawan->id || $account->jenis !== 'tabungan') {
            return redirect()->route('koperasi.tabungan.index')
                ->with('error', 'Akun tabungan tidak valid atau belum dibuat HR.');
        }

        return view('koperasi.tabungan.create', compact('account'));
    }

    public function storeTabungan(Request $request, $accountId = null)
    {
        $karyawan = $this->resolveKaryawan();
        if (!$karyawan) {
            return back()->withErrors('Data karyawan tidak ditemukan.');
        }

        $account = $accountId
            ? KoperasiAccount::find($accountId)
            : KoperasiAccount::where('karyawan_id', $karyawan->id)->where('jenis', 'tabungan')->first();

        if (!$account) {
            return back()->withErrors('Akun tabungan belum dibuat HR.');
        }

        $request->validate([
            'tanggal_input' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'upload_bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->hasFile('upload_bukti')
            ? $request->file('upload_bukti')->store('koperasi/tabungan', 'public')
            : null;

        KoperasiTabunganTransaction::create([
            'koperasi_account_id' => $account->id,
            'karyawan_id' => $account->karyawan_id, // ✅ ambil dari account
            'tanggal_input' => $request->tanggal_input,
            'jumlah' => $request->jumlah,
            'upload_bukti' => $path,
            'status' => 'request',
        ]);

        return redirect()->route('koperasi.tabungan.index')->with('success', 'Tabungan diajukan, menunggu approval HR.');
    }

    // ======================================================
    // PINJAMAN
    // ======================================================

    public function indexPinjaman()
    {
        $karyawan = $this->resolveKaryawan();
        if (!$karyawan) {
            return view('koperasi.pinjaman.index', [
                'pinjamans' => collect(),
                'account' => null,
                'message' => 'Data karyawan tidak ditemukan.'
            ]);
        }

        $account = KoperasiAccount::where('karyawan_id', $karyawan->id)
            ->where('jenis', 'pinjaman')
            ->first();

        if (!$account) {
            return view('koperasi.pinjaman.index', [
                'pinjamans' => collect(),
                'account' => null,
                'message' => 'Akun pinjaman belum dibuat oleh HR.'
            ]);
        }

        $pinjamans = $account->pinjaman()
            ->orderByDesc('tanggal_pengajuan')
            ->get();

        return view('koperasi.pinjaman.index', compact('pinjamans', 'account'));
    }

    public function createPinjaman($accountId = null)
    {
        $karyawan = $this->resolveKaryawan();
        if (!$karyawan) {
            return redirect()->route('koperasi.pinjaman.index')
                ->with('error', 'Data karyawan tidak ditemukan.');
        }

        $account = $accountId
            ? KoperasiAccount::find($accountId)
            : KoperasiAccount::where('karyawan_id', $karyawan->id)->where('jenis', 'pinjaman')->first();

        if (!$account || $account->karyawan_id != $karyawan->id || $account->jenis !== 'pinjaman') {
            return redirect()->route('koperasi.pinjaman.index')
                ->with('error', 'Akun pinjaman tidak valid atau belum dibuat HR.');
        }

        return view('koperasi.pinjaman.create', compact('account'));
    }

    public function storePinjaman(Request $request, $accountId = null)
    {
        $karyawan = $this->resolveKaryawan();
        if (!$karyawan) {
            return back()->withErrors('Data karyawan tidak ditemukan.');
        }

        $account = $accountId
            ? KoperasiAccount::find($accountId)
            : KoperasiAccount::where('karyawan_id', $karyawan->id)->where('jenis', 'pinjaman')->first();

        if (!$account) {
            return back()->withErrors('Akun pinjaman belum dibuat HR.');
        }

        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'jumlah_pinjam' => 'required|numeric|min:100000',
            'alasan' => 'required|string',
            'jumlah_cicilan' => 'required|integer|min:1|max:120',
            'upload_bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->hasFile('upload_bukti')
            ? $request->file('upload_bukti')->store('koperasi/pinjaman', 'public')
            : null;

        KoperasiPinjaman::create([
            'koperasi_account_id' => $account->id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'alasan' => $request->alasan,
            'upload_bukti' => $path,
            'jumlah_cicilan' => $request->jumlah_cicilan,
            'status' => 'request',
        ]);

        return redirect()->route('koperasi.pinjaman.index')->with('success', 'Pengajuan pinjaman berhasil, menunggu approval HR.');
    }
}
