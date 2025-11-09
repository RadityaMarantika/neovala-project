@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Data Customer</h2>
            <a href="{{ route('master_customers.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="card p-4 mt-3 shadow-sm rounded-3">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Lengkap</th>
                    <th>No. NIK</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Foto KTP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($master_customers as $customer)
                    <tr>
                        <td>{{ $customer->nama_lengkap }}</td>
                        <td>{{ $customer->no_nik }}</td>
                        <td>{{ $customer->no_telp }}</td>
                        <td>{{ $customer->alamat }}</td>
                        <td>
                            @if ($customer->foto_ktp)
                                <img src="{{ asset('storage/' . $customer->foto_ktp) }}" alt="KTP" width="60" class="rounded">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('master_customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('master_customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data customer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
@endsection
