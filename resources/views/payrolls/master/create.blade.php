@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Master Payroll</h2>
            <a href="{{ route('master-payroll.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>Back
            </a>
        </div>
    </x-slot>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm mt-3">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger shadow-sm mt-3">{{ session('error') }}</div>
    @endif

    <div class="py-12">
        {{-- Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Payroll</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('master-payroll.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="karyawan_id" class="font-weight-bold">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" id="karyawan_id"
                                class="form-control @error('karyawan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawans as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- Basic Salary --}}
                        <div class="col-md-6 mb-3">
                            <label for="basic_salary_display" class="font-weight-bold">Basic Salary</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light">Rp</span>
                                <input 
                                    type="text" 
                                    id="basic_salary_display"
                                    class="form-control text-end @error('basic_salary') is-invalid @enderror"
                                    placeholder="Masukkan gaji pokok"
                                    value="{{ old('basic_salary') ? number_format(old('basic_salary'), 0, ',', '.') : '' }}"
                                    oninput="formatRupiahGlobal(this, 'basic_salary_hidden')"
                                >
                                <input type="hidden" name="basic_salary" id="basic_salary_hidden">
                                @error('basic_salary')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Leader Fee --}}
                        <div class="col-md-6 mb-3">
                            <label for="leader_fee_display" class="font-weight-bold">Leader Fee</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light">Rp</span>
                                <input 
                                    type="text" 
                                    id="leader_fee_display"
                                    class="form-control text-end @error('leader_fee') is-invalid @enderror"
                                    placeholder="Masukkan leader fee"
                                    value="{{ old('leader_fee') ? number_format(old('leader_fee'), 0, ',', '.') : '' }}"
                                    oninput="formatRupiahGlobal(this, 'leader_fee_hidden')"
                                >
                                <input type="hidden" name="leader_fee" id="leader_fee_hidden">
                                @error('leader_fee')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Insentive Fee --}}
                        <div class="col-md-6 mb-3">
                            <label for="insentive_fee_display" class="font-weight-bold">Insentive Fee</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light">Rp</span>
                                <input 
                                    type="text" 
                                    id="insentive_fee_display"
                                    class="form-control text-end @error('insentive_fee') is-invalid @enderror"
                                    placeholder="Masukkan insentive fee"
                                    value="{{ old('insentive_fee') ? number_format(old('insentive_fee'), 0, ',', '.') : '' }}"
                                    oninput="formatRupiahGlobal(this, 'insentive_fee_hidden')"
                                >
                                <input type="hidden" name="insentive_fee" id="insentive_fee_hidden">
                                @error('insentive_fee')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        {{-- Nama Bank --}}
                        <div class="col-md-6 mb-3">
                            <label for="nama_bank" class="font-weight-bold">Nama Bank</label>
                            <input type="text" name="nama_bank" id="nama_bank"
                                class="form-control @error('nama_bank') is-invalid @enderror"
                                placeholder="Masukkan nama bank" value="{{ old('nama_bank') }}">
                            @error('nama_bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Rekening --}}
                        <div class="col-md-6 mb-3">
                            <label for="nama_rekening" class="font-weight-bold">Nama Rekening</label>
                            <input type="text" name="nama_rekening" id="nama_rekening"
                                class="form-control @error('nama_rekening') is-invalid @enderror"
                                placeholder="Masukkan nama pemilik rekening" value="{{ old('nama_rekening') }}">
                            @error('nama_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor Rekening --}}
                        <div class="col-md-6 mb-3">
                            <label for="nomor_rekening" class="font-weight-bold">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" id="nomor_rekening"
                                class="form-control @error('nomor_rekening') is-invalid @enderror"
                                placeholder="Masukkan nomor rekening" value="{{ old('nomor_rekening') }}">
                            @error('nomor_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div class="col-md-6 mb-3">
                            <label for="no_wa" class="font-weight-bold">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" id="no_wa"
                                class="form-control @error('no_wa') is-invalid @enderror"
                                placeholder="Contoh: 6281234567890" value="{{ old('no_wa') }}">
                            @error('no_wa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <a href="{{ route('master-payroll.index') }}" class="btn btn-outline-secondary mr-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
{{-- === SCRIPT GLOBAL === --}}
<script>
function formatRupiahGlobal(input, hiddenId) {
    const cursorPos = input.selectionStart;
    let value = input.value.replace(/\D/g, ''); // hanya angka

    // Format angka ke ribuan
    const formatted = new Intl.NumberFormat('id-ID').format(value);
    input.value = formatted;

    // Simpan nilai murni ke input hidden
    const hiddenInput = document.getElementById(hiddenId);
    hiddenInput.value = value;

    // Kembalikan posisi kursor
    input.setSelectionRange(cursorPos, cursorPos);
}
</script>
@endsection
