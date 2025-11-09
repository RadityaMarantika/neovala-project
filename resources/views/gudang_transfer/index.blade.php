@extends('layouts.base')

@section('content')

<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Transfer Item Transaction</h2>
            <a href="{{ route('gudang_transfer.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                            <th>Kode</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Tanggal</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transfers as $tr)
                        <tr>
                            <td>{{ $tr->kode_transfer }}</td>
                            <td>{{ $tr->gudangAsal->nama_gudang ?? '-' }}</td>
                            <td>{{ $tr->gudangTujuan->nama_gudang ?? '-' }}</td>
                            <td>{{ $tr->tanggal_transfer }}</td>
                            <td>{{ $tr->creator->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('gudang_transfer.edit', $tr->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('gudang_transfer.destroy', $tr->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $transfers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
