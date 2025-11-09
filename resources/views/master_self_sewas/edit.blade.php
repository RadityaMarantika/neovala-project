@extends('layouts.base')

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Data Self Sewa</h2>
            <a href="{{ route('master_self_sewas.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="p-4 bg-white rounded shadow">
        <form action="{{ route('master_self_sewas.update', $master_self_sewa->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Agen</label>
                    <select name="agen_id" class="form-select">
                        @foreach ($agens as $agen)
                            <option value="{{ $agen->id }}" {{ $agen->id == $master_self_sewa->agen_id ? 'selected' : '' }}>
                                {{ $agen->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Unit</label>
                    <select name="unit_id" class="form-select">
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ $unit->id == $master_self_sewa->unit_id ? 'selected' : '' }}>
                                {{ $unit->no_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Periode Sewa</label>
                    <select name="periode_sewa" class="form-select">
                        <option value="1 Bulan" {{ $master_self_sewa->periode_sewa == '1 Bulan' ? 'selected' : '' }}>1 Bulan</option>
                        <option value="3 Bulan" {{ $master_self_sewa->periode_sewa == '3 Bulan' ? 'selected' : '' }}>3 Bulan</option>
                        <option value="6 Bulan" {{ $master_self_sewa->periode_sewa == '6 Bulan' ? 'selected' : '' }}>6 Bulan</option>
                        <option value="12 Bulan" {{ $master_self_sewa->periode_sewa == '12 Bulan' ? 'selected' : '' }}>12 Bulan</option>
                    </select>
                </div>

                <div>
                    <label>Pengambilan Kunci</label>
                    <input type="date" name="pengambilan_kunci" class="form-control" value="{{ $master_self_sewa->pengambilan_kunci }}">
                </div>

                <div>
                    <label>Biaya Sewa Unit</label>
                    <input type="number" name="biaya_sewa_unit" class="form-control" value="{{ $master_self_sewa->biaya_sewa_unit }}">
                </div>

                <div>
                    <label>Biaya Utilitas</label>
                    <input type="number" name="biaya_utilitas" class="form-control" value="{{ $master_self_sewa->biaya_utilitas }}">
                </div>

                <div>
                    <label>Biaya IPL</label>
                    <input type="number" name="biaya_ipl" class="form-control" value="{{ $master_self_sewa->biaya_ipl }}">
                </div>

                <div>
                    <label>Total Hutang</label>
                    <input type="number" name="total_hutang" class="form-control" value="{{ $master_self_sewa->total_hutang }}">
                </div>

                <div>
                    <label>Marketing</label>
                    <select name="marketing_id" class="form-select">
                        @foreach ($marketings as $mk)
                            <option value="{{ $mk->id }}" {{ $mk->id == $master_self_sewa->marketing_id ? 'selected' : '' }}>
                                {{ $mk->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Fee Agen</label>
                    <input type="number" name="fee_agen" class="form-control" value="{{ $master_self_sewa->fee_agen }}">
                </div>

                <div>
                    <label>Deposit</label>
                    <input type="number" name="deposit" class="form-control" value="{{ $master_self_sewa->deposit }}">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>

@endsection
