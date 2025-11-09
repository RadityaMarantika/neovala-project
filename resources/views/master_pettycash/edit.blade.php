@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Data PettyCash</h2>
            <a href="{{ route('master-pettycash.index') }}" class="btn btn-success">
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
            <form action="{{ route('master-pettycash.update', $pettycash->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Petty Cash</label>
                    <input type="text" name="nama_pettycash" value="{{ $pettycash->nama_pettycash }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dikelola Oleh</label>
                    <input type="text" name="dikelola_oleh" value="{{ $pettycash->dikelola_oleh }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Saldo Awal</label>
                    <input type="number" name="saldo_awal" value="{{ $pettycash->saldo_awal }}" class="form-control" required>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary rounded-3">Update</button>
                    <a href="{{ route('master_pettycash.index') }}" class="btn btn-secondary rounded-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
@endsection
