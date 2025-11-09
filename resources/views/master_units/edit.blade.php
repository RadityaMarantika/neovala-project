@extends('layouts.base')

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="fw-bold text-primary mb-0">Edit Unit</h2>
        </x-slot>

        <div class="card shadow-sm rounded-4 p-4">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Bank</label>
                    <input type="text" name="nama_bank" class="form-control" value="{{ $masterUnit->nama_bank }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">No Rekening</label>
                    <input type="text" name="no_rekening" class="form-control" value="{{ $masterUnit->no_rekening }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Rekening</label>
                    <input type="text" name="nama_rekening" class="form-control"
                        value="{{ $masterUnit->nama_rekening }}">
                </div>
            </div>


            <h5 class="fw-bold mt-4">Identitas Unit</h5>
            <hr>


            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Region</label>
                    <select name="region_id" class="form-select" required>
                        @foreach ($regions as $r)
                            <option value="{{ $r->id }}" {{ $masterUnit->region_id == $r->id ? 'selected' : '' }}>
                                {{ $r->nama_region }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">No Unit</label>
                    <input type="text" name="no_unit" class="form-control" value="{{ $masterUnit->no_unit }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Surat Kontrak (PDF)</label>
                    <input type="file" name="surat_kontrak" class="form-control">
                    @if ($masterUnit->surat_kontrak)
                        <a href="{{ asset('storage/' . $masterUnit->surat_kontrak) }}" target="_blank">Lihat File</a>
                    @endif
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Status Sewa</label>
                    <select name="status_sewa" class="form-select" required>
                        <option {{ $masterUnit->status_sewa == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option {{ $masterUnit->status_sewa == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status Kelola</label>
                    <select name="status_kelola" class="form-select" required>
                        <option {{ $masterUnit->status_kelola == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option {{ $masterUnit->status_kelola == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Detail Hutang</label>
                    <select name="detail_hutang" class="form-select" required>
                        <option {{ $masterUnit->detail_hutang == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option {{ $masterUnit->detail_hutang == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>


            <button class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </x-app-layout>
@endsection
