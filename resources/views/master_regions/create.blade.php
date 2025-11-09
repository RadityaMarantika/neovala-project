@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Master Region</h2>
            <a href="{{ route('master_regions.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card shadow mt-4 p-4">
        <form action="{{ route('master_regions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Kode Region</label>
                <input type="text" name="kode_region" class="form-control" required placeholder="Masukkan Kode region">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Lokasi Apartemen</label>
                <input type="text" name="nama_apart" class="form-control" required placeholder="Masukkan nama apartemen">
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</x-app-layout>
@endsection
