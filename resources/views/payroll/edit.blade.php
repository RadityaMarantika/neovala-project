@extends('layouts.base')

@section('content')
<div class="container py-4">
    <h2 class="text-2xl font-bold mb-4">Edit Data Payroll</h2>

    <form action="{{ route('payroll.update', $payroll->id) }}" method="POST" id="payrollForm">
        @csrf
        @method('PUT')

        {{-- Nama Karyawan --}}
        <div class="mb-4">
            <label class="block text-sm font-medium">Nama Karyawan</label>
            <select name="karyawan_id" class="form-control" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id }}" {{ $karyawan->id == $payroll->karyawan_id ? 'selected' : '' }}>
                        {{ $karyawan->nama_lengkap }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Earnings --}}
        <h4 class="font-semibold mt-6 mb-2 text-blue-600">Earnings</h4>
        <div class="grid grid-cols-2 gap-4">
            @foreach (['basic_salary','overtime_pay','ph_allowances','leader_fee','incentive_fee','other_allowances'] as $field)
                <x-input label="{{ ucwords(str_replace('_', ' ', $field)) }}"
                         name="{{ $field }}" type="number" step="0.01"
                         value="{{ old($field, $payroll->$field) }}" />
            @endforeach
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-green-700">Total Earnings</label>
            <input type="number" name="total_earnings" id="total_earnings" class="form-control bg-green-50 font-semibold"
                   value="{{ old('total_earnings', $payroll->total_earnings) }}" readonly>
        </div>

        {{-- Deductions --}}
        <h4 class="font-semibold mt-6 mb-2 text-red-600">Deductions</h4>
        <div class="grid grid-cols-2 gap-4">
            @foreach (['total_loan','loan_repayment','remaining_loan','penalties','outstanding_cash'] as $field)
                <x-input label="{{ ucwords(str_replace('_', ' ', $field)) }}"
                         name="{{ $field }}" type="number" step="0.01"
                         value="{{ old($field, $payroll->$field) }}" />
            @endforeach
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-red-700">Total Deductions</label>
            <input type="number" name="total_deductions" id="total_deductions" class="form-control bg-red-50 font-semibold"
                   value="{{ old('total_deductions', $payroll->total_deductions) }}" readonly>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-blue-700">Take Home Pay</label>
            <input type="number" name="take_home_pay" id="take_home_pay" class="form-control bg-blue-50 font-bold text-lg"
                   value="{{ old('take_home_pay', $payroll->take_home_pay) }}" readonly>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6">
            <x-input label="Payment Date" name="payment_date" type="date" value="{{ old('payment_date', $payroll->payment_date) }}" />
            <x-input label="Bank Name" name="bank_name" type="text" value="{{ old('bank_name', $payroll->bank_name) }}" />
            <x-input label="Account Bank Name" name="account_bank_name" type="text" value="{{ old('account_bank_name', $payroll->account_bank_name) }}" />
            <x-input label="Account Number" name="account_number" type="text" value="{{ old('account_number', $payroll->account_number) }}" />
            <x-input label="Prepared By" name="prepared_by" type="text" value="{{ old('prepared_by', $payroll->prepared_by) }}" />
            <x-input label="Approved By" name="approved_by" type="text" value="{{ old('approved_by', $payroll->approved_by) }}" />
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium">Descriptions</label>
            <textarea name="descriptions" rows="3" class="form-control">{{ old('descriptions', $payroll->descriptions) }}</textarea>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn btn-success px-4 py-2">Update</button>
        </div>
    </form>
</div>

{{-- Reuse JS hitung otomatis --}}
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
