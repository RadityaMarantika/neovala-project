@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Data Sewa Customer</h2>
            <a href="{{ route('master_cs_sewas.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <form action="{{ route('master_cs_sewas.store') }}" method="POST" class="p-4">
        @csrf

        <div class="row">
            {{-- Dropdown Relasi --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Agen</label>
                <select name="agen_id" class="form-select" required>
                    <option value="">-- Pilih Agen --</option>
                    @foreach($agens as $agen)
                        <option value="{{ $agen->id }}">{{ $agen->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Unit</label>
                <select name="unit_id" class="form-select" required>
                    <option value="">-- Pilih Unit --</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->no_unit }} - {{ $unit->nama_tower }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Data Sewa --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Periode Sewa</label>
                <select name="periode_sewa" class="form-select" required>
                    <option value="">-- Pilih Periode --</option>
                    @foreach(['3 Bulan', '6 Bulan', '12 Bulan'] as $periode)
                        <option value="{{ $periode }}">{{ $periode }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Pengambilan Kunci</label>
                <input type="date" name="pengambilan_kunci" class="form-control" required>
            </div>

            {{-- Biaya --}}
            @foreach(['biaya_sewa_unit', 'biaya_utilitas', 'biaya_ipl', 'biaya_listrik', 'biaya_air', 'biaya_wifi', 'biaya_jual_unit', 'fee_agen', 'deposit'] as $field)
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <input type="number" name="{{ $field }}" class="form-control" min="0" placeholder="Masukkan nominal (Rp)">
                </div>
            @endforeach

            {{-- Pembayaran --}}
            @foreach(['pembayaran_listrik', 'pembayaran_air', 'pembayaran_wifi'] as $field)
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <select name="{{ $field }}" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Paid by Marketing', 'Paid by Company', 'Paid by Customer'] as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach

            <div class="col-md-6 mb-3">
                <label class="form-label">Marketing</label>
                <select name="marketing_id" class="form-select">
                    <option value="">-- Pilih Marketing --</option>
                    @foreach($marketings as $m)
                        <option value="{{ $m->id }}">{{ $m->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-2">Simpan</button>
    </form>
</x-app-layout>
@endsection
