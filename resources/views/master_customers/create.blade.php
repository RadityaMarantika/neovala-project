@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Customer</h2>
            <a href="{{ route('master_customers.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <form action="{{ route('master_customers.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required placeholder="Masukkan nama lengkap">
        </div>

        <div class="mb-3">
            <label class="form-label">No. NIK</label>
            <input type="text" name="no_nik" class="form-control" required placeholder="Masukkan nomor NIK">
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telp" class="form-control" required placeholder="Masukkan nomor telepon">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto KTP</label>
            <input type="file" name="foto_ktp" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</x-app-layout>
@endsection
