@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Customer</h2>
            <a href="{{ route('master_customers.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <form action="{{ route('master_customers.update', $master_customer->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ $master_customer->nama_lengkap }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No. NIK</label>
            <input type="text" name="no_nik" class="form-control" value="{{ $master_customer->no_nik }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telp" class="form-control" value="{{ $master_customer->no_telp }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3">{{ $master_customer->alamat }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto KTP</label><br>
            @if ($master_customer->foto_ktp)
                <img src="{{ asset('storage/' . $master_customer->foto_ktp) }}" alt="KTP" width="100" class="rounded mb-2">
            @endif
            <input type="file" name="foto_ktp" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-app-layout>
@endsection
