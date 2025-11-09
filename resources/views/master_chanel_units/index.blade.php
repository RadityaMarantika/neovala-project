@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Master Chanel Unit</h2>
            <a href="{{ route('master_chanel_units.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="card shadow mt-4 p-4">
        <table class="table table-bordered table-hover">
            <thead class="bg-gray-100">
                <tr>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>No NIK</th>
                    <th>Jenis Koneksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->no_nik }}</td>
                    <td>{{ $item->jenis_koneksi }}</td>
                    <td>
                        <a href="{{ route('master_chanel_units.edit', $item->id) }}" class="text-blue-500"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('master_chanel_units.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="text-red-500 bg-transparent border-0" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-500">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
@endsection
