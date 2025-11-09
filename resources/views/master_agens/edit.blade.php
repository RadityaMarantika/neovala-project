@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Agen</h2>
            <a href="{{ route('master_agens.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <form action="{{ route('master_agens.update', $master_agen->id) }}" method="POST" class="p-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Kode Agen</label>
            <input type="text" name="kode_agen" class="form-control" value="{{ $master_agen->kode_agen }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Agen</label>
            <input type="text" name="nama_agen" class="form-control" value="{{ $master_agen->nama_agen }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Wilayah</label>
            <input type="text" name="wilayah" class="form-control" value="{{ $master_agen->wilayah }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" value="{{ $master_agen->kontak }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-app-layout>
@endsection
