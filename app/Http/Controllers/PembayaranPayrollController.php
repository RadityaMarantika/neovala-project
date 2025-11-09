<?php

namespace App\Http\Controllers;


use App\Models\MasterPayroll;
use App\Models\PembayaranPayroll;
use App\Models\KoperasiAccount;
use App\Models\KoperasiPinjaman;
use App\Models\KoperasiPinjamanInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PembayaranPayrollController extends Controller
    {
    public function index()
    {
    $items = PembayaranPayroll::with('master.karyawan')->orderBy('tanggal_pembayaran','desc')->paginate(20);
    return view('payrolls.pembayaran.index', compact('items'));
    }


    public function create()
    {
    $karyawans = \App\Models\MasterKaryawan::orderBy('nama_lengkap')->get();
    $masters = MasterPayroll::with('karyawan')->get();
     // Default nilai kosong untuk form baru
    $defaultData = [
        'ph_allowance' => 0,
        'loan_repayment' => 0,
        'remaining_loan' => 0,
        'penalties' => 0,
    ];

    return view('payrolls.pembayaran.create', compact('masters', 'defaultData','karyawans'));
    }

    public function store(Request $request)
    {
    $data = $request->validate([
    'payroll_id' => 'required|exists:master_payrolls,id',
    'tanggal_pembayaran' => 'required|date',
    'ph_allowance' => 'nullable|numeric',
    'other_allowance' => 'nullable|numeric',
    'loan_repayment' => 'nullable|numeric',
    'remaining_loan' => 'nullable|numeric',
    'penalties' => 'nullable|numeric',
    'status_payroll' => 'nullable|in:Pending,Approve,Done'
    ]);


    // snapshot master
    $master = MasterPayroll::findOrFail($data['payroll_id']);
    $payload = [
    'payroll_id' => $master->id,
    'tanggal_pembayaran' => $data['tanggal_pembayaran'],
    'basic_salary' => $master->basic_salary,
    'leader_fee' => $master->leader_fee,
    'insentive_fee' => $master->insentive_fee,
    'nama_bank' => $master->nama_bank,
    'nama_rekening' => $master->nama_rekening,
    'nomor_rekening' => $master->nomor_rekening,
    'ph_allowance' => $data['ph_allowance'] ?? 0,
    'other_allowance' => $data['other_allowance'] ?? 0,
    ];


    // compute earnings
    $payload['total_earning'] = array_sum([
    $payload['basic_salary'],$payload['leader_fee'],$payload['insentive_fee'],$payload['ph_allowance'],$payload['other_allowance']
    ]);


    // If user didn't pass loan/penalty, try to fetch from other DB tables
    if (!isset($data['loan_repayment']) || !isset($data['remaining_loan'])) {
    // attempt to fetch loan installment sum for employee from koperasi_pinjaman_installments
    $loanRepayment = DB::table('koperasi_pinjaman_installments')
    ->where('karyawan_id', $master->karyawan_id)
    ->where('status','pending')
    ->sum('jumlah_cicilan');


    $remainingLoan = DB::table('koperasi_pinjaman_installments')
    ->where('karyawan_id', $master->karyawan_id)
    ->where('status','pending')
    ->count();


    $payload['loan_repayment'] = $data['loan_repayment'] ?? $loanRepayment ?? 0;
    $payload['remaining_loan'] = $data['remaining_loan'] ?? $remainingLoan ?? 0;
    } else {
    $payload['loan_repayment'] = $data['loan_repayment'];
    $payload['remaining_loan'] = $data['remaining_loan'];
    }


    if (!isset($data['penalties'])) {
    // penalties: sum of menit_telat_masuk multiplied by penalty per minute (set here as 1000)
    $penaltyPerMinute = 1000; // adjust as needed or put in config
    $totalLateMinutes = DB::table('absensis')
    ->where('karyawan_id', $master->karyawan_id)
    ->whereBetween('tanggal', [
    date('Y-m-01', strtotime($data['tanggal_pembayaran'])),
    date('Y-m-t', strtotime($data['tanggal_pembayaran']))
    ])
    ->sum('menit_telat_masuk');


    $payload['penalties'] = $totalLateMinutes * $penaltyPerMinute;
    } else {
    $payload['penalties'] = $data['penalties'];
    }


    $payload['total_deduction'] = $payload['loan_repayment'] + $payload['penalties'];
    $payload['take_home_pay'] = $payload['total_earning'] - $payload['total_deduction'];


    $payload['created_by'] = Auth::id();
    $payload['status_payroll'] = $data['status_payroll'] ?? 'Pending';


    $p = PembayaranPayroll::create($payload);


    // optional: send whatsapp notification (stub)
    if ($master->no_wa) {
    try {
    $this->sendWhatsappNotification($master->no_wa, "Gaji Anda untuk bulan " . date('F Y', strtotime($payload['tanggal_pembayaran'])) . " sejumlah Rp " . number_format($p->take_home_pay));
    } catch (\Exception $e) {
    // log but don't break
    }
    }


    return redirect()->route('pembayaran-payroll.index')->with('success','Payroll payment saved');
    }

   public function edit($id)
{
    // Ambil data pembayaran berdasarkan ID
    $pembayaranPayroll = PembayaranPayroll::findOrFail($id);

    // Ambil semua master payroll dan relasi karyawan (untuk dropdown, dll)
    $masters = MasterPayroll::with('karyawan')->orderBy('id', 'desc')->get();

    // Ambil semua karyawan (optional jika perlu ditampilkan)
    $karyawans = \App\Models\MasterKaryawan::orderBy('nama_lengkap')->get();

    // Default data agar tidak error jika null
    $defaultData = [
        'ph_allowance' => $pembayaranPayroll->ph_allowance ?? 0,
        'loan_repayment' => $pembayaranPayroll->loan_repayment ?? 0,
        'remaining_loan' => $pembayaranPayroll->remaining_loan ?? 0,
        'penalties' => $pembayaranPayroll->penalties ?? 0,
    ];

    return view('payrolls.pembayaran.edit', compact(
        'pembayaranPayroll',
        'masters',
        'karyawans',
        'defaultData'
    ));
}


    public function update(Request $request, PembayaranPayroll $pembayaranPayroll)
    {
    $data = $request->validate([
    'ph_allowance' => 'nullable|numeric',
    'other_allowance' => 'nullable|numeric',
    'loan_repayment' => 'nullable|numeric',
    'remaining_loan' => 'nullable|numeric',
    'penalties' => 'nullable|numeric',
    'status_payroll' => 'nullable|in:Pending,Approve,Done'
    ]);


    // allow editing of numeric fields
    $pembayaranPayroll->update(array_merge($data, [
    'total_earning' => ($pembayaranPayroll->basic_salary + $pembayaranPayroll->leader_fee + $pembayaranPayroll->insentive_fee + ($data['ph_allowance'] ?? $pembayaranPayroll->ph_allowance) + ($data['other_allowance'] ?? $pembayaranPayroll->other_allowance)),
    'total_deduction' => ($data['loan_repayment'] ?? $pembayaranPayroll->loan_repayment) + ($data['penalties'] ?? $pembayaranPayroll->penalties),
    'take_home_pay' => ( ($pembayaranPayroll->basic_salary + $pembayaranPayroll->leader_fee + $pembayaranPayroll->insentive_fee + ($data['ph_allowance'] ?? $pembayaranPayroll->ph_allowance) + ($data['other_allowance'] ?? $pembayaranPayroll->other_allowance)) - (( $data['loan_repayment'] ?? $pembayaranPayroll->loan_repayment) + ($data['penalties'] ?? $pembayaranPayroll->penalties) ) )
    ]));


    return redirect()->route('pembayaran-payroll.index')->with('success','Updated');
    }


    public function destroy(PembayaranPayroll $pembayaranPayroll)
    {
    $pembayaranPayroll->delete();
    return back()->with('success','Deleted');
    }

    
    public function getPenalties($karyawan_id, $bulan)
{
    $month = date('m', strtotime($bulan));
    $year  = date('Y', strtotime($bulan));

    // Ambil semua absen untuk karyawan tsb di bulan itu
    $absensis = \App\Models\Absensi::where('karyawan_id', $karyawan_id)
        ->whereHas('shift', function ($q) use ($month, $year) {
            $q->whereMonth('jadwal_tanggal', $month)
              ->whereYear('jadwal_tanggal', $year);
        })
        ->get();

    // Hitung denda pakai rumus kamu
    $dendaMasukTelat   = $absensis->where('status_absen_masuk', 'Telat')->count() * 20000;
    $dendaMasukAlfa    = $absensis->where('status_absen_masuk', 'Alfa')->count() * 50000;
    $dendaPulangTelat  = $absensis->where('status_absen_pulang', 'Telat')->count() * 15000;
    $dendaPulangKosong = $absensis->whereNull('status_absen_pulang')->count() * 30000;

    $totalDenda = $dendaMasukTelat + $dendaMasukAlfa + $dendaPulangTelat + $dendaPulangKosong;

    return response()->json([
        'penalties' => $totalDenda,
        'detail' => [
            'dendaMasukTelat' => $dendaMasukTelat,
            'dendaMasukAlfa' => $dendaMasukAlfa,
            'dendaPulangTelat' => $dendaPulangTelat,
            'dendaPulangKosong' => $dendaPulangKosong,
        ]
    ]);
}


public function getLoanData($karyawan_id)
{
    $account = \App\Models\KoperasiAccount::where('karyawan_id', $karyawan_id)
        ->latest('id')
        ->first();

    if (!$account) {
        return response()->json([
            'loan_repayment' => 0,
            'remaining_loan' => 0,
            'note' => 'tidak ada akun koperasi',
        ]);
    }

    $pinjaman = \App\Models\KoperasiPinjaman::where('koperasi_account_id', $account->id)
    ->where('status', 'on progress') // hanya ambil pinjaman aktif
    ->latest('id')
    ->first();

    if (!$pinjaman) {
        return response()->json([
            'loan_repayment' => 0,
            'remaining_loan' => 0,
            'note' => 'tidak ada pinjaman aktif',
            'debug' => [
                'account_id' => $account->id,
                'karyawan_id' => $karyawan_id,
                'account_found' => true,
                'query' => 'koperasi_account_id = ' . $account->id,
            ],
        ]);
    }

    $installments = \App\Models\KoperasiPinjamanInstallment::where('koperasi_pinjaman_id', $pinjaman->id)->get();

    if ($installments->isEmpty()) {
        return response()->json([
            'loan_repayment' => 0,
            'remaining_loan' => (float) $pinjaman->jumlah_pinjaman,
            'note' => 'belum ada installment',
            'debug' => [
                'account_id' => $account->id,
                'pinjaman_id' => $pinjaman->id,
            ],
        ]);
    }

$nextInstallment = $installments->where('status', '!=', 'lunas')->sortBy('jatuh_tempo')->first();
$loanRepayment = $nextInstallment ? (float) $nextInstallment->jumlah_cicilan : 0;

$totalInstallment = (float) $installments->sum('jumlah_cicilan');
$paidInstallment = (float) $installments->where('status', 'lunas')->sum('jumlah_cicilan');
$remainingLoan = max(0, $totalInstallment - $paidInstallment);

return response()->json([
    'loan_repayment' => $loanRepayment,
    'remaining_loan' => $remainingLoan,
    'debug' => [
        'account_id' => $account->id,
        'pinjaman_id' => $pinjaman->id,
        'total_installments' => $installments->count(),
        'paid_installment' => $paidInstallment,
        'unpaid_installments' => $installments->where('status', '!=', 'lunas')->count(),
        'statuses' => $installments->pluck('status'),
    ]
]);

}

public function approve($id)
{
    $payroll = PembayaranPayroll::select(
        'id', 'payroll_id', 'tanggal_pembayaran',
        'basic_salary', 'leader_fee', 'insentive_fee',
        'nama_bank', 'nama_rekening', 'nomor_rekening',
        'ph_allowance', 'other_allowance', 'total_earning',
        'loan_repayment', 'remaining_loan', 'penalties',
        'total_deduction', 'take_home_pay'
    )->findOrFail($id);

    DB::beginTransaction();

    try {
        // Update status payroll menjadi Approve
        $payroll->update(['status_payroll' => 'Approve']);

        // Ambil data master payroll (untuk dapatkan id karyawan)
        $master = MasterPayroll::find($payroll->payroll_id);
        if (!$master) {
            throw new \Exception('Data master payroll tidak ditemukan.');
        }

        $karyawan_id = $master->karyawan_id;

        // Coba cari akun koperasi
        $account = KoperasiAccount::where('karyawan_id', $karyawan_id)
            ->latest('id')
            ->first();

        if (!$account) {
            // Tidak punya akun koperasi → lanjut tanpa error
            DB::commit();
            return back()->with('success', 'Payroll berhasil di-approve (tanpa pinjaman koperasi).');
        }

        // Cari pinjaman aktif (prioritas status on progress / approved)
        $possibleStatuses = ['on progress', 'on_progress', 'on progres', 'onprogress', 'approved'];
        $pinjaman = KoperasiPinjaman::where('koperasi_account_id', $account->id)
            ->where(function ($q) use ($possibleStatuses) {
                foreach ($possibleStatuses as $st) {
                    $q->orWhere('status', $st);
                }
            })
            ->latest('id')
            ->first();

        // Kalau tidak ada pinjaman aktif, skip tanpa error
        if (!$pinjaman) {
            DB::commit();
            return back()->with('success', 'Payroll berhasil di-approve (tanpa pinjaman aktif).');
        }

        // Ambil cicilan pinjaman
        $installments = KoperasiPinjamanInstallment::where('koperasi_pinjaman_id', $pinjaman->id)
            ->where('status', '!=', 'lunas')
            ->orderBy('jatuh_tempo', 'asc')
            ->get();

        // Jika ada cicilan yang belum lunas
        if ($installments->isNotEmpty()) {
            // Ambil cicilan pertama yang belum lunas
            $candidate = $installments->first();

            // Update status jadi lunas
            $candidate->update([
                'status' => 'lunas',
                'paid_at' => $payroll->tanggal_pembayaran,
                'updated_at' => now(),
            ]);

            // Kurangi saldo pinjaman
            $newJumlahPinjaman = max((float)$pinjaman->jumlah_pinjaman - (float)$candidate->jumlah_cicilan, 0);
            $newJumlahCicilan = max((int)$pinjaman->jumlah_cicilan - 1, 0);

            $pinjaman->update([
                'jumlah_pinjaman' => $newJumlahPinjaman,
                'jumlah_cicilan' => $newJumlahCicilan,
            ]);

            // Kalau semua cicilan lunas, ubah status pinjaman jadi done
            $remaining = KoperasiPinjamanInstallment::where('koperasi_pinjaman_id', $pinjaman->id)
                ->where('status', '!=', 'lunas')
                ->count();

            if ($remaining === 0) {
                $pinjaman->update(['status' => 'done']);
            }
        }

        DB::commit();
        return back()->with('success', 'Payroll berhasil di-approve dan cicilan koperasi diperbarui.');

    } catch (\Throwable $th) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan saat approve: ' . $th->getMessage());
    }
}



/**
 * Fungsi kirim WA via Fonnte API
 */

public function transfer(Request $request, $id)
{
    $request->validate([
        'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    DB::beginTransaction();

    try {
        $payroll = PembayaranPayroll::with('master.karyawan')->findOrFail($id);
        Log::info('Payroll ditemukan:', ['id' => $id, 'nama' => optional($payroll->master->karyawan)->nama_lengkap]);

        $path = $request->file('bukti_transfer')->store('payroll-transfer', 'public');
        $payroll->update([
            'bukti_transfer' => $path,
            'status_payroll' => 'Done',
        ]);
        Log::info('Bukti transfer disimpan:', ['path' => $path]);

       $master = $payroll->master;

        if ($master && $master->no_wa) {
            $periode = $master->periode_payroll ?? date('F Y');
            $pesan = "Halo {$master->karyawan->nama_lengkap} 👋,\n\n" .
                "Gaji kamu untuk periode *{$periode}* telah ditransfer 💸.\n\n" .
                "Total Take Home Pay: Rp " . number_format($payroll->take_home_pay, 0, ',', '.') . "\n\n" .
                "Terima kasih atas kerja kerasmu bulan ini 🙌";

            $this->sendWhatsappNotification($master->no_wa, $pesan);
        

        } else {
            Log::warning('Nomor WA tidak ditemukan untuk payroll id:', ['id' => $id]);
        }

        DB::commit();
        return back()->with('success', 'Transfer berhasil disimpan dan notifikasi WA telah dikirim.');
    } catch (\Throwable $th) {
        DB::rollBack();
        Log::error('Gagal transfer:', ['error' => $th->getMessage()]);
        return back()->with('error', 'Gagal menyimpan transfer: ' . $th->getMessage());
    }
}

private function sendWhatsappNotification($no_wa, $message)
{
    $token = env('FONNTE_TOKEN');
    if (!$token) {
        Log::error('FONNTE_TOKEN belum diatur di .env');
        throw new \Exception('FONNTE_TOKEN belum diatur di file .env');
    }

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.fonnte.com/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'target' => $no_wa,
            'message' => $message,
        ],
        CURLOPT_HTTPHEADER => [
            "Authorization: $token"
        ],
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    Log::info('Fonnte Response', ['response' => $response, 'error' => $error]);

    return $response;
}


}