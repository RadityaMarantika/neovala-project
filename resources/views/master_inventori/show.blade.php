@extends('layouts.base')

@section('content')
<div class="py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-info text-white">
            <h5><i class="fas fa-eye me-2"></i>Detail Barang Inventori</h5>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr><th>Kode Barang</th><td>: {{ $inventori->kode_barang }}</td></tr>
                <tr><th>Nama Barang</th><td>: {{ $inventori->nama_barang }}</td></tr>
                <tr><th>Kode Rak</th><td>: {{ $inventori->kode_rak }}</td></tr>
                <tr><th>Satuan</th><td>: {{ $inventori->satuan }}</td></tr>
                <tr><th>Merk</th><td>: {{ $inventori->merk }}</td></tr>
                <tr><th>Kategori</th><td>: {{ $inventori->kategori }}</td></tr>
                <tr><th>Jenis</th><td>: {{ $inventori->jenis }}</td></tr>
                <tr><th>Catatan</th><td>: {{ $inventori->catatan }}</td></tr>
                <tr><th>Nama Toko</th><td>: {{ $inventori->nama_toko }}</td></tr>
                <tr><th>Link Toko</th><td>: {{ $inventori->link_toko }}</td></tr>
                <tr><th>Maps</th><td>: {{ $inventori->maps }}</td></tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('master_inventori.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
