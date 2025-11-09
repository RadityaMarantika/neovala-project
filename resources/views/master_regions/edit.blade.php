@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Master Region</h2>
            <a href="{{ route('master_regions.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card shadow mt-4 p-4">
        <form action="{{ route('master_regions.update', $masterRegion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Region</label>
                <input type="text" name="nama_region" value="{{ $masterRegion->nama_region }}" class="form-control" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</x-app-layout>
@endsection
