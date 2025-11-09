@extends('layouts.base')

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="fw-bold text-primary mb-0">Data Unit</h2>
                <a href="{{ route('master_units.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                    <i class="fas fa-plus-circle"></i> Tambah Data
                </a>
            </div>
        </x-slot>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <div class="card shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>No Unit</th>
                            <th>Jenis Koneksi</th>
                            <th>Status Sewa</th>
                            <th>Status Kelola</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $u->nama_lengkap }}</td>
                                <td>{{ $u->no_unit }}</td>
                                <td>{{ $u->jenis_koneksi }}</td>
                                <td>{{ $u->status_sewa }}</td>
                                <td>{{ $u->status_kelola }}</td>
                                <td>
                                    <a href="{{ route('master_units.edit', $u->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('master_units.destroy', $u->id) }}" class="d-inline"
                                        method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus data?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-app-layout>
@endsection
