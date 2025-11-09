@extends('layouts.base')

@section('content')
<div class="py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white">
            <h5><i class="fas fa-plus-circle me-2"></i>Tambah Barang Inventori</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('master_inventori.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control @error('kode_barang') is-invalid @enderror" value="{{ old('kode_barang') }}" required>
                        @error('kode_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" value="{{ old('nama_barang') }}" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Satuan</label>
                        <select name="satuan" class="form-select w-full">
                            <option value="">-- Pilih Satuan --</option>
                            @foreach(['pcs', 'kg', 'liter', 'pack'] as $satuan)
                                <option value="{{ $satuan }}" {{ old('satuan') == $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Merk</label>
                        <input type="text" name="merk" class="form-control" value="{{ old('merk') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select w-full" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(['Amenitis', 'Perkakas Rumah Tangga', 'Elektronik', 'Perlengkapan Dapur', 'Perlengkapan Makan'] as $kategori)
                                <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jenis Barang</label>
                        <select name="jenis" class="form-select w-full" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Barang Habis Pakai" {{ old('jenis') == 'Barang Habis Pakai' ? 'selected' : '' }}>Barang Habis Pakai</option>
                            <option value="Barang Tidak Habis Pakai" {{ old('jenis') == 'Barang Tidak Habis Pakai' ? 'selected' : '' }}>Barang Tidak Habis Pakai</option>
                        </select>
                    </div>

                    

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">catatan</label>
                        <input type="text" name="catatan" class="form-control @error('catatan') is-invalid @enderror" value="{{ old('catatan') }}" required>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">nama_toko</label>
                        <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko') }}" required>
                        @error('nama_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">link_toko</label>
                        <input type="text" name="link_toko" class="form-control @error('link_toko') is-invalid @enderror" value="{{ old('link_toko') }}" required>
                        @error('link_toko')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">maps</label>
                        <input type="text" name="maps" class="form-control @error('maps') is-invalid @enderror" value="{{ old('maps') }}" required>
                        @error('maps')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('master_inventori.index') }}" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
