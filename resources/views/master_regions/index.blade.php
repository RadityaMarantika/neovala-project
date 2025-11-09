@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Master Region</h2>
            <a href="{{ route('master_regions.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="card shadow mt-4 p-4">
        <table class="table table-bordered table-hover">
            <thead class="bg-gray-100">
                <tr>
                    <th width="5%">#</th>
                    <th>Kode Region</th>
                    <th>Lokasi Apartemen</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_region ?? '-' }}</td>
                    <td>{{ $item->nama_apart ?? '-' }}</td>
                    <td>
                        <a href="{{ route('master_regions.edit', $item->id) }}" class="text-blue-500">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('master_regions.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus data ini?')" class="text-red-500 border-0 bg-transparent">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
@endsection
