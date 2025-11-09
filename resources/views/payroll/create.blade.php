@extends('layouts.base')

@section('content')
<div class="container py-4">
    <h2 class="text-2xl font-bold mb-4">Tambah Data Payroll</h2>

    <form action="{{ route('payroll.store') }}" method="POST" id="payrollForm">
        @csrf

        {{-- Nama Karyawan --}}
        <div class="mb-4">
            <label class="block text-sm font-medium">Nama Karyawan</label>
            <select name="karyawan_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id }}">{{ $karyawan->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>

        {{-- === EARNINGS === --}}
        <h4 class="font-semibold mt-6 mb-2 text-blue-600">Earnings</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Basic Salary</label>
                <input type="number" name="basic_salary" class="w-full border rounded p-2" step="0.01" required>
            </div>
            <div>
                <label>Overtime Pay</label>
                <input type="number" name="overtime_pay" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>PH Allowances</label>
                <input type="number" name="ph_allowances" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>Leader Fee</label>
                <input type="number" name="leader_fee" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>Incentive Fee</label>
                <input type="number" name="incentive_fee" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>Other Allowances</label>
                <input type="number" name="other_allowances" class="w-full border rounded p-2" step="0.01">
            </div>
        </div>

        {{-- Total Earnings --}}
        <div class="mt-4">
            <label class="block text-sm font-medium text-green-700">Total Earnings</label>
            <input type="number" name="total_earnings" id="total_earnings" class="w-full border rounded p-2 bg-green-50 font-semibold" readonly>
        </div>

        {{-- === DEDUCTIONS === --}}
        <h4 class="font-semibold mt-6 mb-2 text-red-600">Deductions</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Total Loan</label>
                <input type="number" name="total_loan" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>Loan Repayment</label>
                <input type="number" name="loan_repayment" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>Remaining Loan</label>
                <input type="number" name="remaining_loan" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>Penalties</label>
                <input type="number" name="penalties" class="w-full border rounded p-2" step="0.01">
            </div>
            <div>
                <label>Outstanding Cash</label>
                <input type="number" name="outstanding_cash" class="w-full border rounded p-2" step="0.01">
            </div>
        </div>

        {{-- Total Deductions --}}
        <div class="mt-4">
            <label class="block text-sm font-medium text-red-700">Total Deductions</label>
            <input type="number" name="total_deductions" id="total_deductions" class="w-full border rounded p-2 bg-red-50 font-semibold" readonly>
        </div>

        {{-- === TAKE HOME PAY === --}}
        <div class="mt-4">
            <label class="block text-sm font-medium text-blue-700">Take Home Pay</label>
            <input type="number" name="take_home_pay" id="take_home_pay" class="w-full border rounded p-2 bg-blue-50 font-bold text-lg" readonly>
        </div>

        {{-- Informasi Tambahan --}}
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div>
                <label>Payment Date</label>
                <input type="date" name="payment_date" class="w-full border rounded p-2">
            </div>
            <div>
                <label>Bank Name</label>
                <input type="text" name="bank_name" class="w-full border rounded p-2">
            </div>
            <div>
                <label>Account Bank Name</label>
                <input type="text" name="account_bank_name" class="w-full border rounded p-2">
            </div>
            <div>
                <label>Account Number</label>
                <input type="text" name="account_number" class="w-full border rounded p-2">
            </div>
            <div>
                <label>Prepared By</label>
                <input type="text" name="prepared_by" class="w-full border rounded p-2">
            </div>
            <div>
                <label>Approved By</label>
                <input type="text" name="approved_by" class="w-full border rounded p-2">
            </div>
        </div>

        {{-- Descriptions --}}
        <div class="mt-4">
            <label class="block text-sm font-medium">Descriptions</label>
            <textarea name="descriptions" rows="3" class="w-full border rounded p-2"></textarea>
        </div>

        {{-- Tombol --}}
        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>

{{-- JS untuk perhitungan otomatis --}}
<script>
    const form = document.getElementById('payrollForm');
    const earningsFields = ['basic_salary','overtime_pay','ph_allowances','leader_fee','incentive_fee','other_allowances'];
    const deductionsFields = ['total_loan','loan_repayment','remaining_loan','penalties','outstanding_cash'];

    form.addEventListener('input', () => {
        let totalEarnings = 0;
        earningsFields.forEach(name => totalEarnings += parseFloat(form[name].value) || 0);
        form['total_earnings'].value = totalEarnings.toFixed(2);

        let totalDeductions = 0;
        deductionsFields.forEach(name => totalDeductions += parseFloat(form[name].value) || 0);
        form['total_deductions'].value = totalDeductions.toFixed(2);

        form['take_home_pay'].value = (totalEarnings - totalDeductions).toFixed(2);
    });
</script>
@endsection
