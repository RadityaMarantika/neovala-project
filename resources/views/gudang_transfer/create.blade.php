@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Data Transaction</h2>
        <a href="{{ route('gudang_transfer.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> From Transaction Item</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('gudang_transfer.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Gudang Asal</label>
                            <select name="gudang_asal_id" class="form-select w-full" required>
                                <option value="">Pilih...</option>
                                @foreach($gudangs as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Gudang Tujuan</label>
                            <select name="gudang_tujuan_id" class="form-select w-full" required>
                                <option value="">Pilih...</option>
                                @foreach($gudangs as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Tanggal Transfer</label>
                            <input type="date" name="tanggal_transfer" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>

                    <h6 class="fw-bold mt-4">Item yang Ditransfer</h6>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemTable">
                            <tr>
                                <td>
                                    <select name="barang_id[]" class="form-select">
                                        @foreach($barangs as $b)
                                            <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="jumlah[]" class="form-control" min="1" value="1"></td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" class="btn btn-secondary btn-sm" onclick="addRow()">+ Tambah Item</button>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('gudang_transfer.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function addRow() {
    const table = document.getElementById('itemTable');
    const newRow = table.rows[0].cloneNode(true);
    newRow.querySelectorAll('input').forEach(i => i.value = '');
    table.appendChild(newRow);
}
function removeRow(btn) {
    const row = btn.closest('tr');
    if (document.querySelectorAll('#itemTable tr').length > 1) row.remove();
}
</script>
@endsection
