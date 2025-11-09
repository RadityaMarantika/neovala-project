@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Data Sewa Customer</h2>
            <a href="{{ route('master_cs_sewas.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <form action="{{ route('master_cs_sewas.update', $master_cs_sewa->id) }}" method="POST" class="p-4">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Contoh field utama --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Periode Sewa</label>
                <select name="periode_sewa" class="form-select" required>
                    @foreach(['3 Bulan', '6 Bulan', '12 Bulan'] as $periode)
                        <option value="{{ $periode }}" {{ $master_cs_sewa->periode_sewa == $periode ? 'selected' : '' }}>{{ $periode }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Pengambilan Kunci</label>
                <input type="date" name="pengambilan_kunci" value="{{ $master_cs_sewa->pengambilan_kunci }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Biaya Sewa Unit</label>
                <input type="number" name="biaya_sewa_unit" value="{{ $master_cs_sewa->biaya_sewa_unit }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Biaya Utilitas</label>
                <input type="number" name="biaya_utilitas" value="{{ $master_cs_sewa->biaya_utilitas }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Total Hutang</label>
                <input type="number" name="total_hutang" value="{{ $master_cs_sewa->total_hutang }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Total Profit</label>
                <input type="number" name="total_profit" value="{{ $master_cs_sewa->total_profit }}" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-app-layout>
@endsection
