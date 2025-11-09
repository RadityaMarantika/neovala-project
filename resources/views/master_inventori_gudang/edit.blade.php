@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Edit Item Inventory Warehouse</h2>
        <a href="{{ route('master_inventori_gudang.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        </div>
    </x-slot>

<div class="py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5>Edit Inventori Gudang: {{ $gudang->nama_gudang }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('master_inventori_gudang.update', $gudang->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Search --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label fw-bold">Daftar Barang di Gudang Ini</label>
                    <div style="width: 300px;">
                        <input type="text" id="searchBarang" class="form-control form-control-sm shadow-sm"
                               placeholder="Cari nama atau kode barang...">
                    </div>
                </div>

                <div class="table-responsive border rounded shadow-sm">
                    <table class="table table-sm table-striped align-middle mb-0" id="barangTable">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Kode</th>
                                <th>Satuan</th>
                                <th>Merk</th>
                                <th>Stok Aktual</th>
                                <th>Minimum Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventoriGudang as $inv)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="nama-barang">{{ $inv->barang->nama_barang ?? '-' }}</td>
                                    <td class="kode-barang">{{ $inv->barang->kode_barang ?? '-' }}</td>
                                    <td>{{ $inv->barang->satuan ?? '-' }}</td>
                                    <td>{{ $inv->barang->merk ?? '-' }}</td>
                                    <td>
                                        <input type="number" name="stok_aktual[{{ $inv->barang_id }}]"
                                               class="form-control form-control-sm text-center"
                                               value="{{ $inv->stok_aktual ?? 0 }}">
                                    </td>
                                    <td>
                                        <input type="number" name="minimum_stok[{{ $inv->barang_id }}]"
                                               class="form-control form-control-sm text-center"
                                               value="{{ $inv->minimum_stok ?? 0 }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('master_inventori_gudang.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchBarang').addEventListener('keyup', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#barangTable tbody tr').forEach(row => {
            const nama = row.querySelector('.nama-barang')?.textContent.toLowerCase() || '';
            const kode = row.querySelector('.kode-barang')?.textContent.toLowerCase() || '';
            row.style.display = (nama.includes(q) || kode.includes(q)) ? '' : 'none';
        });
    });
});
</script>
@endsection
