@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Chanel Unit</h2>
            <a href="{{ route('master_chanel_units.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="card shadow mt-4 p-4">
        <form action="{{ route('master_chanel_units.update', $masterChanelUnit->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ $masterChanelUnit->nama_lengkap }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">No NIK</label>
                    <input type="text" name="no_nik" class="form-control" value="{{ $masterChanelUnit->no_nik }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jenis Koneksi</label>
                    <select name="jenis_koneksi" class="form-select">
                        <option value="Marketing" {{ $masterChanelUnit->jenis_koneksi == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Owner Unit" {{ $masterChanelUnit->jenis_koneksi == 'Owner Unit' ? 'selected' : '' }}>Owner Unit</option>
                        <option value="Tenant Relation" {{ $masterChanelUnit->jenis_koneksi == 'Tenant Relation' ? 'selected' : '' }}>Tenant Relation</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Bank</label>
                    <input type="text" name="nama_bank" class="form-control" value="{{ $masterChanelUnit->nama_bank }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">No Rekening</label>
                    <input type="text" name="bank_rek" class="form-control" value="{{ $masterChanelUnit->bank_rek }}">
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</x-app-layout>
@endsection
