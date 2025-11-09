@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Data PettyCash</h2>
            <a href="{{ route('master-pettycash.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Tambah PettyCash
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
                        <th>Nama Petty Cash</th>
                        <th>Dikelola Oleh</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Berjalan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pettycashs as $cash)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cash->nama_pettycash }}</td>
                            <td>{{ $cash->karyawan ? $cash->karyawan->nama_lengkap : '-' }}</td>
                            <td>Rp {{ number_format($cash->saldo_awal, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($cash->saldo_berjalan, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('master-pettycash.edit', $cash->id) }}" class="btn btn-warning btn-sm rounded-3">Edit</a>
                                <form action="{{ route('master-pettycash.destroy', $cash->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Yakin hapus petty cash ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>
@endsection
