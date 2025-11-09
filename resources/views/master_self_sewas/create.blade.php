@extends('layouts.base')

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Data Self Sewa</h2>
            <a href="{{ route('master_self_sewas.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="p-4 bg-white rounded shadow">
        <form action="{{ route('master_self_sewas.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Agen</label>
                    <select name="agen_id" class="form-select">
                        <option value="">-- Pilih Agen --</option>
                        @foreach ($agens as $agen)
                            <option value="{{ $agen->id }}">{{ $agen->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Unit</label>
                    <select name="unit_id" class="form-select">
                        <option value="">-- Pilih Unit --</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->no_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Periode Sewa</label>
                    <select name="periode_sewa" class="form-select">
                        <option value="1 Bulan">1 Bulan</option>
                        <option value="3 Bulan">3 Bulan</option>
                        <option value="6 Bulan">6 Bulan</option>
                        <option value="12 Bulan">12 Bulan</option>
                    </select>
                </div>

                <div>
                    <label>Tanggal Pengambilan Kunci</label>
                    <input type="date" name="pengambilan_kunci" class="form-control">
                </div>

                <div>
                    <label>Biaya Sewa Unit</label>
                    <input type="number" name="biaya_sewa_unit" class="form-control">
                </div>

                <div>
                    <label>Biaya Utilitas</label>
                    <input type="number" name="biaya_utilitas" class="form-control">
                </div>

                <div>
                    <label>Biaya IPL</label>
                    <input type="number" name="biaya_ipl" class="form-control">
                </div>

                <div>
                    <label>Pembayaran Listrik</label>
                    <select name="pembayaran_listrik" class="form-select">
                        <option value="Paid by Marketing">Paid by Marketing</option>
                        <option value="Paid by Company">Paid by Company</option>
                        <option value="Paid by Customer">Paid by Customer</option>
                    </select>
                </div>

                <div>
                    <label>Biaya Listrik</label>
                    <input type="number" name="biaya_listrik" class="form-control">
                </div>

                <div>
                    <label>Pembayaran Air</label>
                    <select name="pembayaran_air" class="form-select">
                        <option value="Paid by Marketing">Paid by Marketing</option>
                        <option value="Paid by Company">Paid by Company</option>
                        <option value="Paid by Customer">Paid by Customer</option>
                    </select>
                </div>

                <div>
                    <label>Biaya Air</label>
                    <input type="number" name="biaya_air" class="form-control">
                </div>

                <div>
                    <label>Pembayaran Wifi</label>
                    <select name="pembayaran_wifi" class="form-select">
                        <option value="Paid by Marketing">Paid by Marketing</option>
                        <option value="Paid by Company">Paid by Company</option>
                        <option value="Paid by Customer">Paid by Customer</option>
                    </select>
                </div>

                <div>
                    <label>Biaya Wifi</label>
                    <input type="number" name="biaya_wifi" class="form-control">
                </div>

                <div>
                    <label>Total Hutang</label>
                    <input type="number" name="total_hutang" class="form-control">
                </div>

                <div>
                    <label>Marketing</label>
                    <select name="marketing_id" class="form-select">
                        <option value="">-- Pilih Marketing --</option>
                        @foreach ($marketings as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Fee Agen</label>
                    <input type="number" name="fee_agen" class="form-control">
                </div>

                <div>
                    <label>Deposit</label>
                    <input type="number" name="deposit" class="form-control">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>

@endsection
