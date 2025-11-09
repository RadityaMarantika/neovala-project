@extends('layouts.base')
@section('content')
<div class="py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white">
            <h5>Tambah Gudang</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('master_gudang.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Gudang</label>
                    <input type="text" name="nama_gudang" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Region</label>
                    <select name="region" class="form-select" required>
                        <option value="">-- Pilih Region --</option>
                        <option>Transpark Juanda</option>
                        <option>Ayam Keshwari</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kepala Gudang</label>
                    <input type="text" name="kepala_gudang" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('master_gudang.index') }}" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
