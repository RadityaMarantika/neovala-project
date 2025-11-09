<?php


namespace App\Http\Controllers;


use App\Models\MasterPayroll;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MasterPayrollController extends Controller
{
    public function index()
        {
            $items = MasterPayroll::with('karyawan')->paginate(20);
            return view('payrolls.master.index', compact('items'));
        }


    public function create()
        {
            // Ambil ID karyawan yang sudah punya payroll
            $karyawanSudahAda = MasterPayroll::pluck('karyawan_id')->toArray();

            // Ambil hanya karyawan yang belum punya payroll
            $karyawans = MasterKaryawan::whereNotIn('id', $karyawanSudahAda)->get();
            return view('payrolls.master.create', compact('karyawans'));
        }


    public function store(Request $request)
        {
            $data = $request->validate([
            'karyawan_id' => 'required|exists:master_karyawans,id',
            'basic_salary' => 'nullable|numeric',
            'leader_fee' => 'nullable|numeric',
            'insentive_fee' => 'nullable|numeric',
            'nama_bank' => 'nullable|string',
            'nama_rekening' => 'nullable|string',
            'nomor_rekening' => 'nullable|string',
            'no_wa' => 'nullable|string'
        ]);


        MasterPayroll::create($data);


        return redirect()->route('master-payroll.index')->with('success','Master payroll created');
    }


    public function edit(MasterPayroll $masterPayroll)
        {
            $karyawans = \App\Models\MasterKaryawan::orderBy('nama_lengkap')->get();
            return view('payrolls.master.edit', ['item'=>$masterPayroll, 'karyawans'=>$karyawans]);
        }


    public function update(Request $request, MasterPayroll $masterPayroll)
    {
        // Validasi data
        $data = $request->validate([
            'karyawan_id' => 'nullable|exists:master_karyawans,id',
            'basic_salary' => 'nullable|numeric',
            'leader_fee' => 'nullable|numeric',
            'insentive_fee' => 'nullable|numeric',
            'nama_bank' => 'nullable|string|max:255',
            'nama_rekening' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'no_wa' => 'nullable|string|max:20',
        ]);

        // Update data payroll
        $masterPayroll->update($data);

        // Redirect balik ke index dengan notifikasi sukses
        return redirect()
            ->route('master-payroll.index')
            ->with('success', 'Data payroll berhasil diperbarui!');
    }

    public function fetchData($karyawan_id)
    {
        // Ambil total lembur
        $ph_allowance = DB::table('lemburs')
            ->where('karyawan_id', $karyawan_id)
            ->sum('total_lembur');

        // Ambil cicilan yang sudah dibayar
        $loan_repayment = DB::table('koperasi_pinjaman_installments')
            ->where('karyawan_id', $karyawan_id)
            ->where('status', 'lunas')
            ->sum('jumlah_cicilan');

        // Ambil sisa pinjaman (belum lunas)
        $remaining_loan = DB::table('koperasi_pinjaman_installments')
            ->where('karyawan_id', $karyawan_id)
            ->where('status', '!=', 'lunas')
            ->sum('jumlah_cicilan');

        // Ambil total menit keterlambatan
        $penalties = DB::table('absensi')
            ->where('karyawan_id', $karyawan_id)
            ->sum('menit_telat_masuk');

        return response()->json([
            'ph_allowance' => $ph_allowance,
            'loan_repayment' => $loan_repayment,
            'remaining_loan' => $remaining_loan,
            'penalties' => $penalties,
        ]);
    }

}
