@extends('layouts.base')

@section('content')
    <x-app-layout>
        {{-- Header --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="fw-bold text-primary mb-0">Tambah Data Unit</h2>
                <a href="{{ route('master_units.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </x-slot>

        {{-- ✅ FORM DIMULAI DI SINI --}}
        <form action="{{ route('master_units.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="card shadow-sm rounded-4 p-4">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Koneksi <span class="text-danger">*</span></label>
                        <select name="jenis_koneksi" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Owner">Owner</option>
                            <option value="Marketing">Marketing</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="form-control"
                            required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">No KTP <span class="text-danger">*</span></label>
                        <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">No Telp <span class="text-danger">*</span></label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="form-control" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                {{-- =================== BANK =================== --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Bank</label>
                        <input type="text" name="nama_bank" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No Rekening</label>
                        <input type="text" name="no_rekening" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Rekening</label>
                        <input type="text" name="nama_rekening" class="form-control">
                    </div>
                </div>

                <h5 class="fw-bold mt-4">Identitas Unit</h5>
                <hr>

                {{-- =================== IDENTITAS UNIT =================== --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Region</label>
                        <select name="region_id" class="form-select" required>
                            @foreach ($regions as $r)
                                <option value="{{ $r->id }}">{{ $r->nama_apart }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">No Unit</label>
                        <input type="text" name="no_unit" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Surat Kontrak (PDF)</label>
                        <input type="file" name="surat_kontrak" class="form-control">
                    </div>
                </div>

                {{-- =================== STATUS =================== --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Status Sewa</label>
                        <select name="status_sewa" class="form-select" required>
                            <option>Aktif</option>
                            <option>Non-Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status Kelola</label>
                        <select name="status_kelola" class="form-select" required>
                            <option>Aktif</option>
                            <option>Non-Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Detail Hutang</label>
                        <select name="detail_hutang" class="form-select" required>
                            <option>Aktif</option>
                            <option>Non-Aktif</option>
                        </select>
                    </div>
                </div>

                {{-- ✅ TOMBOL SUBMIT --}}
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>

            </div>
        </form>
        {{-- ✅ FORM DITUTUP DI SINI --}}

    </x-app-layout>
@endsection
