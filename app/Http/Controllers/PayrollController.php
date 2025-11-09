<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\MasterKaryawan;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('karyawan')->latest()->get();
        return view('payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $karyawans = MasterKaryawan::orderBy('nama_lengkap')->get();
        return view('payroll.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'karyawan_id' => 'required',
            'basic_salary' => 'required|numeric',
            'overtime_pay' => 'nullable|numeric',
            'ph_allowances' => 'nullable|numeric',
            'leader_fee' => 'nullable|numeric',
            'incentive_fee' => 'nullable|numeric',
            'other_allowances' => 'nullable|numeric',
            'total_loan' => 'nullable|numeric',
            'loan_repayment' => 'nullable|numeric',
            'remaining_loan' => 'nullable|numeric',
            'penalties' => 'nullable|numeric',
            'outstanding_cash' => 'nullable|numeric',
            'descriptions' => 'nullable|string',
            'payment_date' => 'nullable|date',
            'bank_name' => 'nullable|string',
            'account_bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'prepared_by' => 'nullable|string',
            'approved_by' => 'nullable|string',
        ]);

        $data['total_earnings'] =
            $data['basic_salary'] + ($data['overtime_pay'] ?? 0) +
            ($data['ph_allowances'] ?? 0) + ($data['leader_fee'] ?? 0) +
            ($data['incentive_fee'] ?? 0) + ($data['other_allowances'] ?? 0);

        $data['total_deductions'] =
            ($data['total_loan'] ?? 0) + ($data['loan_repayment'] ?? 0) +
            ($data['remaining_loan'] ?? 0) + ($data['penalties'] ?? 0) +
            ($data['outstanding_cash'] ?? 0);

        $data['take_home_pay'] = $data['total_earnings'] - $data['total_deductions'];

        Payroll::create($data);

        return redirect()->route('payroll.index')->with('success', 'Data payroll berhasil dibuat.');
    }

    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $karyawans = MasterKaryawan::orderBy('nama_lengkap')->get();
        return view('payroll.edit', compact('payroll', 'karyawans'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $data = $request->all();
        $data['total_earnings'] =
            $data['basic_salary'] + ($data['overtime_pay'] ?? 0) +
            ($data['ph_allowances'] ?? 0) + ($data['leader_fee'] ?? 0) +
            ($data['incentive_fee'] ?? 0) + ($data['other_allowances'] ?? 0);

        $data['total_deductions'] =
            ($data['total_loan'] ?? 0) + ($data['loan_repayment'] ?? 0) +
            ($data['remaining_loan'] ?? 0) + ($data['penalties'] ?? 0) +
            ($data['outstanding_cash'] ?? 0);

        $data['take_home_pay'] = $data['total_earnings'] - $data['total_deductions'];

        $payroll->update($data);

        return redirect()->route('payroll.index')->with('success', 'Data payroll berhasil diperbarui.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payroll.index')->with('success', 'Data payroll berhasil dihapus.');
    }
}
