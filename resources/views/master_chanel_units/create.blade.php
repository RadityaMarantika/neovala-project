@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Tambah Chanel Unit</h2>
            <a href="{{ route('master_chanel_units.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card shadow mt-4 p-4">
        <form action="{{ route('master_chanel_units.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label class="form-label fw-semibold">Jenis Koneksi</label>
                    <select name="jenis_koneksi" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Owner Unit">Owner Unit</option>
                        <option value="Tenant Relation">Tenant Relation</option>
                    </select>
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
    </div>
</x-app-layout>
@endsection
