@extends('layouts.base')

@section('content')
<div class="py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-warning text-dark">
            <h5><i class="fas fa-edit me-2"></i>Edit Barang Inventori</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('master_inventori.update', $inventori->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $inventori->kode_barang }}" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $inventori->nama_barang }}" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Rak</label>
                        <input type="text" name="kode_rak" value="{{ $inventori->kode_rak }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Satuan</label>
                        <select name="satuan" class="form-select">
                            @foreach(['pcs', 'kg', 'liter', 'pack'] as $satuan)
                                <option value="{{ $satuan }}" {{ $inventori->satuan == $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Merk</label>
                        <input type="text" name="merk" value="{{ $inventori->merk }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select">
                            @foreach(['Amenitis', 'Perkakas Rumah Tangga', 'Elektronik', 'Perlengkapan Dapur', 'Perlengkapan Makan'] as $kategori)
                                <option value="{{ $kategori }}" {{ $inventori->kategori == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis</label>
                        <select name="jenis" class="form-select">
                            <option value="Barang Habis Pakai" {{ $inventori->jenis == 'Barang Habis Pakai' ? 'selected' : '' }}>Barang Habis Pakai</option>
                            <option value="Barang Tidak Habis Pakai" {{ $inventori->jenis == 'Barang Tidak Habis Pakai' ? 'selected' : '' }}>Barang Tidak Habis Pakai</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('master_inventori.index') }}" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
