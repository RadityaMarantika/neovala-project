@extends('layouts.base')

@section('content')
 
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Data Transaksi PettyCash</h2>
            <a href="{{ route('transaksi-pettycash.index') }}" class="btn btn-success">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    {{-- Alert Section --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="py-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header">
                <h4 class="fw-bold mb-0">Edit Petty Cash</h4>
            </div>
            <div class="card-body">
            <form action="{{ route('transaksi_pettycash.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Pilih Petty Cash</label>
                    <select name="pettycash_id" class="form-select" required>
                        @foreach($pettycashs as $cash)
                            <option value="{{ $cash->id }}" {{ $transaksi->pettycash_id == $cash->id ? 'selected' : '' }}>{{ $cash->nama_pettycash }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Transaksi</label>
                    <select name="jenis_transaksi" class="form-select" required>
                        <option value="cash_in" {{ $transaksi->jenis_transaksi == 'cash_in' ? 'selected' : '' }}>Cash In</option>
                        <option value="cash_out" {{ $transaksi->jenis_transaksi == 'cash_out' ? 'selected' : '' }}>Cash Out</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keperluan</label>
                    <textarea name="keperluan" class="form-control" rows="3" required>{{ $transaksi->keperluan }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nominal</label>
                    <input type="number" name="nominal" value="{{ $transaksi->nominal }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bukti Foto</label>
                    <input type="file" name="bukti_foto" class="form-control">
                    @if($transaksi->bukti_foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $transaksi->bukti_foto) }}" width="120" class="rounded shadow-sm">
                        </div>
                    @endif
                </div>
                <div class="text-end">
                    <button class="btn btn-primary rounded-3">Update Transaksi</button>
                    <a href="{{ route('transaksi_pettycash.index') }}" class="btn btn-secondary rounded-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
