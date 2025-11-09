@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Input Item Inventory Warehouse</h2>
            <a href="{{ route('master_inventori_gudang.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">

                {{-- Alert sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Filter Gudang + Tombol Edit --}}
                <form method="GET" class="mb-4 d-flex align-items-center gap-2" id="filterForm">
                    <label for="gudang_id" class="fw-semibold mb-0">Pilih Gudang:</label>
                    <select name="gudang_id" id="gudang_id" class="form-select w-full" onchange="handleGudangChange(this)">
                        <option value="">-- Semua Gudang --</option>
                        @foreach($gudangs as $gudang)
                            <option value="{{ $gudang->id }}" {{ $gudangId == $gudang->id ? 'selected' : '' }}>
                                {{ $gudang->nama_gudang }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Tombol Edit dinamis --}}
                    @if($gudangId)
                        <a href="{{ route('master_inventori_gudang.edit', $gudangId) }}" 
                           id="btnEditGudang" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Gudang
                        </a>
                    @else
                        <a href="#" id="btnEditGudang" class="btn btn-warning btn-sm d-none">
                            <i class="fas fa-edit"></i> Edit Gudang
                        </a>
                    @endif
                </form>

                {{-- Tabel Data --}}
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Gudang</th>
                            <th>Kode Barang</th>
                            <th>Kode Rak</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Stok</th>
                            <th>Min Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventoriGudangs as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->gudang->nama_gudang ?? '-' }}</td>
                            <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                            <td>{{ $item->kode_rak ?? '-' }}</td>
                            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $item->stok_aktual ?? 0 }}</td>
                            <td>{{ $item->minimum_stok ?? 0 }}</td>
                            <td>{{ $item->status_stok ?? 0 }}</td>
                            <td class="text-center">
                                <form action="{{ route('master_inventori_gudang.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus data ini?')" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data inventori untuk gudang ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $inventoriGudangs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script --}}
<script>
function handleGudangChange(select) {
    const gudangId = select.value;
    const btnEdit = document.getElementById('btnEditGudang');

    // Update tombol edit
    if (gudangId) {
        btnEdit.classList.remove('d-none');
        btnEdit.href = `/master_inventori_gudang/${gudangId}/edit`;
    } else {
        btnEdit.classList.add('d-none');
        btnEdit.href = '#';
    }

    // Submit form untuk filter (sekali saja)
    document.getElementById('filterForm').submit();
}
</script>
@endsection
