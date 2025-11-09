@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Agen</h2>
            <a href="{{ route('master_agens.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <form action="{{ route('master_agens.store') }}" method="POST" class="p-4">
        @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">No NIK</label>
                    <input type="text" name="no_nik" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">No Telepon</label>
                    <input type="text" name="no_telp" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Alamat</label>
                    <input type="text" name="alamat" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Foto KTP</label>
                    <input type="file" name="foto_ktp" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Bank</label>
                    <input type="text" name="nama_bank" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">No Rekening</label>
                    <input type="text" name="bank_rek" class="form-control">
                </div>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                <i class="fas fa-save"></i> Simpan
            </button>
    </form>
</x-app-layout>
@endsection
