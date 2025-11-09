@extends('layouts.base')
@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Master Payroll</h2>
            <a href="{{ route('master-payroll.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>
    
    <div class="py-12">

        {{-- Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Payroll</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('master-payroll.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Karyawan --}}
                        <div class="col-md-6 mb-3">
                            <label for="karyawan_id" class="font-weight-bold">Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" id="karyawan_id" disabled
                                class="form-control @error('karyawan_id') is-invalid @enderror" readonly>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawans as $k)
                                    <option value="{{ $k->id }}" {{ $k->id == $item->karyawan_id ? 'selected' : '' }}>
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
                            <label for="basic_salary" class="font-weight-bold">Basic Salary</label>
                            <input type="number" name="basic_salary" id="basic_salary"
                                value="{{ old('basic_salary', $item->basic_salary) }}"
                                class="form-control @error('basic_salary') is-invalid @enderror"
                                placeholder="Masukkan gaji pokok" step="0.01">
                            @error('basic_salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Leader Fee --}}
                        <div class="col-md-6 mb-3">
                            <label for="leader_fee" class="font-weight-bold">Leader Fee</label>
                            <input type="number" name="leader_fee" id="leader_fee"
                                value="{{ old('leader_fee', $item->leader_fee) }}"
                                class="form-control @error('leader_fee') is-invalid @enderror"
                                placeholder="Masukkan leader fee" step="0.01">
                            @error('leader_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Insentive Fee --}}
                        <div class="col-md-6 mb-3">
                            <label for="insentive_fee" class="font-weight-bold">Insentive Fee</label>
                            <input type="number" name="insentive_fee" id="insentive_fee"
                                value="{{ old('insentive_fee', $item->insentive_fee) }}"
                                class="form-control @error('insentive_fee') is-invalid @enderror"
                                placeholder="Masukkan insentive fee" step="0.01">
                            @error('insentive_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Bank --}}
                        <div class="col-md-6 mb-3">
                            <label for="nama_bank" class="font-weight-bold">Nama Bank</label>
                            <input type="text" name="nama_bank" id="nama_bank"
                                value="{{ old('nama_bank', $item->nama_bank) }}"
                                class="form-control @error('nama_bank') is-invalid @enderror"
                                placeholder="Masukkan nama bank">
                            @error('nama_bank')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Rekening --}}
                        <div class="col-md-6 mb-3">
                            <label for="nama_rekening" class="font-weight-bold">Nama Rekening</label>
                            <input type="text" name="nama_rekening" id="nama_rekening"
                                value="{{ old('nama_rekening', $item->nama_rekening) }}"
                                class="form-control @error('nama_rekening') is-invalid @enderror"
                                placeholder="Masukkan nama pemilik rekening">
                            @error('nama_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor Rekening --}}
                        <div class="col-md-6 mb-3">
                            <label for="nomor_rekening" class="font-weight-bold">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" id="nomor_rekening"
                                value="{{ old('nomor_rekening', $item->nomor_rekening) }}"
                                class="form-control @error('nomor_rekening') is-invalid @enderror"
                                placeholder="Masukkan nomor rekening">
                            @error('nomor_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div class="col-md-6 mb-4">
                            <label for="no_wa" class="font-weight-bold">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" id="no_wa"
                                value="{{ old('no_wa', $item->no_wa) }}"
                                class="form-control @error('no_wa') is-invalid @enderror"
                                placeholder="Contoh: 6281234567890">
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
                            <i class="fas fa-save"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@endsection
