@extends('layouts.base')

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Pembayaran Payroll Karyawan</h2>
            <a href="{{ route('pembayaran-payroll.index') }}" class="btn btn-danger">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Edit Data Payroll</h5>
            </div>

            <div class="card-body bg-light">
                {{-- FIX: gunakan $pembayaranPayroll bukan $masters --}}
                <form action="{{ route('pembayaran-payroll.update', $pembayaranPayroll->id) }}" method="POST" id="payrollForm">
                    @csrf
                    @method('PUT')

                    {{-- ================= MASTER PAYROLL ================= --}}
                    <div class="mb-4 p-4 bg-white rounded shadow-sm">
                        <h5 class="fw-bold text-primary mb-4">Karyawan & Periode</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="payroll_id" class="fw-semibold mb-2 d-block">Pilih Karyawan</label>
                                <select name="payroll_id" id="payroll_id" 
                                    class="form-select form-select-lg text-truncate"
                                    required>
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach($masters as $m)
                                        <option value="{{ $m->id }}"
                                            data-karyawan_id="{{ $m->karyawan_id }}"
                                            data-basic_salary="{{ $m->basic_salary }}"
                                            data-leader_fee="{{ $m->leader_fee }}"
                                            data-insentive_fee="{{ $m->insentive_fee }}"
                                            data-nama_bank="{{ $m->nama_bank }}"
                                            data-nama_rekening="{{ $m->nama_rekening }}"
                                            data-nomor_rekening="{{ $m->nomor_rekening }}"
                                            {{ $pembayaranPayroll->payroll_id == $m->id ? 'selected' : '' }}>
                                            {{ optional($m->karyawan)->nama_lengkap ?? $m->karyawan_id }} — 
                                            Rp {{ number_format($m->basic_salary) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="bulan_payroll" class="fw-semibold mb-2 d-block">Bulan Payroll</label>
                                <input type="month" name="bulan_payroll" id="bulan_payroll"
                                    class="form-control form-control-lg"
                                    value="{{ $pembayaranPayroll->bulan_payroll }}">
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal_pembayaran" class="fw-semibold mb-2 d-block">Tanggal Pembayaran</label>
                                <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran"
                                    class="form-control form-control-lg"
                                    value="{{ $pembayaranPayroll->tanggal_pembayaran }}">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="karyawan_id" id="karyawan_id" value="{{ $pembayaranPayroll->karyawan_id }}">

                    {{-- ================= REKENING INFO ================= --}}
                    <div class="mb-4 p-3 bg-white rounded shadow-sm">
                        <h5 class="fw-bold text-primary mb-3">Rekening</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Nama Bank</label>
                                <input type="text" id="nama_bank" class="form-control bg-light" 
                                    value="{{ $pembayaranPayroll->nama_bank }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Nama Rekening</label>
                                <input type="text" id="nama_rekening" class="form-control bg-light" 
                                    value="{{ $pembayaranPayroll->nama_rekening }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Nomor Rekening</label>
                                <input type="text" id="nomor_rekening" class="form-control bg-light" 
                                    value="{{ $pembayaranPayroll->nomor_rekening }}" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- ================= EARNING VS DEDUCTION ================= --}}
                    <div class="p-3 bg-white rounded shadow-sm">
                        <div class="row">
                            {{-- LEFT SIDE - EARNINGS --}}
                            <div class="col-md-6 border-end pe-4">
                                <h5 class="fw-bold text-secondary mb-3">Earnings</h5>

                                @foreach ([
                                    'Basic Salary' => 'basic_salary',
                                    'Leader Fee' => 'leader_fee',
                                    'Insentive Fee' => 'insentive_fee',
                                    'PH Allowance' => 'ph_allowance',
                                    'Other Allowance' => 'other_allowance'
                                ] as $label => $id)
                                    <div class="mb-3">
                                        <label class="fw-semibold mb-2">{{ $label }}</label>
                                        <input type="text" name="{{ $id }}" id="{{ $id }}"
                                            class="form-control {{ in_array($id, ['basic_salary','leader_fee','insentive_fee']) ? 'bg-light' : '' }}"
                                            value="{{ number_format($pembayaranPayroll->$id) }}"
                                            {{ in_array($id, ['basic_salary','leader_fee','insentive_fee']) ? 'readonly' : '' }}>
                                    </div>
                                @endforeach

                                <div class="mt-4">
                                    <label class="fw-semibold text-success">Total Earnings</label>
                                    <input type="text" id="total_earning" name="total_earning"
                                        class="form-control bg-success-subtle fw-bold text-end"
                                        value="{{ number_format($pembayaranPayroll->total_earning) }}" readonly>
                                </div>
                            </div>

                            {{-- RIGHT SIDE - DEDUCTIONS --}}
                            <div class="col-md-6 ps-4">
                                <h5 class="fw-bold text-secondary mb-3">Deductions</h5>

                                @foreach ([
                                    'Loan Repayment' => 'loan_repayment',
                                    'Remaining Loan' => 'remaining_loan',
                                    'Penalties' => 'penalties'
                                ] as $label => $id)
                                    <div class="mb-3">
                                        <label class="fw-semibold mb-2">{{ $label }}</label>
                                        <input type="text" name="{{ $id }}" id="{{ $id }}"
                                            class="form-control {{ $id !== 'loan_repayment' ? 'bg-light' : '' }}"
                                            value="{{ number_format($pembayaranPayroll->$id) }}"
                                            {{ $id !== 'loan_repayment' ? 'readonly' : '' }}>
                                    </div>
                                @endforeach

                                <div class="mt-4">
                                    <label class="fw-semibold text-danger">Total Deductions</label>
                                    <input type="text" id="total_deduction" name="total_deduction"
                                        class="form-control bg-danger-subtle fw-bold text-end"
                                        value="{{ number_format($pembayaranPayroll->total_deduction) }}" readonly>
                                </div>

                                <hr class="my-4">

                                <div class="mb-3">
                                    <label class="fw-bold text-primary fs-5">Take Home Pay</label>
                                    <input type="text" id="take_home_pay" name="take_home_pay"
                                        class="form-control form-control-lg bg-primary text-white fw-bold text-end"
                                        value="{{ number_format($pembayaranPayroll->take_home_pay) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================= BUTTON ================= --}}
                    <div class="text-end mt-4">
                        <button class="btn btn-primary px-5 py-2">
                            <i class="bi bi-save me-1"></i> Update Payroll
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- ===================== SCRIPT ===================== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    function toNumber(value) {
        if (!value) return 0;
        value = String(value).replace(/\./g, '').replace(/[^\d]/g, '');
        return parseInt(value, 10) || 0;
    }
    function toRupiah(value) {
        const n = parseInt(value) || 0;
        return n.toLocaleString('id-ID');
    }

    function recalcTotals() {
        const basic = toNumber(basic_salary.value);
        const leader = toNumber(leader_fee.value);
        const insentive = toNumber(insentive_fee.value);
        const ph = toNumber(ph_allowance.value);
        const other = toNumber(other_allowance.value);
        const loan = toNumber(loan_repayment.value);
        const penalty = toNumber(penalties.value);

        const totalEarning = basic + leader + insentive + ph + other;
        const totalDeduction = loan + penalty;
        const takeHome = totalEarning - totalDeduction;

        total_earning.value = toRupiah(totalEarning);
        total_deduction.value = toRupiah(totalDeduction);
        take_home_pay.value = toRupiah(takeHome);
    }

    ['ph_allowance','other_allowance','loan_repayment'].forEach(id => {
        const el = document.getElementById(id);
        el.addEventListener('input', e => {
            const val = toNumber(e.target.value);
            e.target.value = toRupiah(val);
            recalcTotals();
        });
    });

    const form = document.getElementById('payrollForm');
    form.addEventListener('submit', () => {
        [
            'basic_salary','leader_fee','insentive_fee',
            'ph_allowance','other_allowance','loan_repayment',
            'penalties','total_earning','total_deduction','take_home_pay'
        ].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = toNumber(el.value);
        });
    });
});
</script>

@endsection
