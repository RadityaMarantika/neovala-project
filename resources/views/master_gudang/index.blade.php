@extends('layouts.base')

@section('content')

<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">List Gudang</h2>
            <a href="{{ route('master_gudang.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
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
                        <th>No</th>
                        <th>Nama Gudang</th>
                        <th>Region</th>
                        <th>Kepala Gudang</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gudangs as $g)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $g->nama_gudang }}</td>
                        <td>{{ $g->region }}</td>
                        <td>{{ $g->kepala_gudang }}</td>
                        <td class="text-center">
                            <a href="{{ route('master_gudang.show', $g->id) }}" class="btn btn-sm btn-info">👁️</a>
                            <a href="{{ route('master_gudang.edit', $g->id) }}" class="btn btn-sm btn-warning">✏️</a>
                            <form action="{{ route('master_gudang.destroy', $g->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger">🗑️</button>
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
