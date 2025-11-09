@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Data Transaksi PettyCash</h2>
            <a href="{{ route('transaksi-pettycash.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Buat Data PettyCash
            </a>
        </div>
    </x-slot>


    <div class="py-6">
        {{-- Alert Section --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
        @endif

        {{-- Main Card --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Petty Cash</th>
                        <th>Jenis Transaksi</th>
                        <th>Keperluan</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->tanggal_transaksi }}</td>
                        <td>{{ $t->pettycash->nama_pettycash ?? '-' }}</td>
                        <td>{{ ucfirst($t->jenis_transaksi) }}</td>
                        <td>{{ $t->keperluan }}</td>
                        <td>Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
@endsection
