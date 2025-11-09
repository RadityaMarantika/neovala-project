@extends('layouts.base')

@section('content')
    <x-app-layout>
        {{-- Header --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="fw-bold text-primary mb-0">Input Item Inventory Warehouse</h2>
                <a href="{{ route('master_inventori_gudang.index') }}"
                    class="bg-gray-500 text-white text-xs px-3 py-2 rounded">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </x-slot>

        <div class="py-4">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Checklist Item Inventory</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('master_inventori_gudang.store') }}" method="POST">
                        @csrf

                        {{-- ===================== PILIH GUDANG ===================== --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Gudang</label>
                            <select name="gudang_id" id="gudangSelect" class="form-select shadow-sm w-full" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach ($gudangs as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama_gudang }} - {{ $g->region }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ===================== PILIH BARANG ===================== --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">
                                    Pilih Barang
                                </label>

                                {{-- SEARCH BAR --}}
                                <div class="col-md-4">
                                    <input type="text" id="searchBarang" class="form-control form-control-sm shadow-sm"
                                        placeholder="Cari nama atau kode barang...">
                                </div>
                            </div>

                            <div class="table-responsive border rounded shadow-sm">
                                <table class="table table-sm table-striped align-middle mb-0" id="barangTable">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 5%;">#</th>
                                            <th>Nama Barang</th>
                                            <th>Kode</th>
                                            <th>Satuan</th>
                                            <th>Merk</th>
                                            <th>Stok Aktual</th>
                                            <th>Minimum Stok</th>
                                            <th>Kode Rak</th>
                                            <th>Penanggung Jawab</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center text-muted" id="barangTbody">
                                        <tr>
                                            <td colspan="7">Silakan pilih gudang terlebih dahulu.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ===================== TOMBOL AKSI ===================== --}}
                        <div class="d-flex justify-content-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>

    {{-- ===================== SCRIPT ===================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gudangSelect = document.getElementById('gudangSelect');
            const tbody = document.getElementById('barangTbody');
            const searchInput = document.getElementById('searchBarang');

            // Load barang ketika gudang dipilih
            gudangSelect.addEventListener('change', function() {
                const gudangId = this.value;
                tbody.innerHTML = `<tr><td colspan="7">Memuat data barang...</td></tr>`;
                if (!gudangId) return;

                fetch(`{{ route('get.barang.belumdimiliki') }}?gudang_id=${gudangId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            tbody.innerHTML =
                                `<tr><td colspan="7" class="text-muted">Semua barang sudah dimiliki oleh gudang ini.</td></tr>`;
                            return;
                        }
                        tbody.innerHTML = '';
                        data.forEach(b => {
                            tbody.innerHTML += `
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="barang_id[]" value="${b.id}" class="form-check-input barang-check">
                            </td>
                            <td class="nama-barang">${b.nama_barang}</td>
                            <td class="kode-barang">${b.kode_barang}</td>
                            <td>${b.satuan ?? '-'}</td>
                            <td>${b.merk ?? '-'}</td>
                            <td><input type="number" name="stok_aktual[${b.id}]" class="form-control form-control-sm text-center stok-input" min="0" placeholder="0" disabled></td>
                            <td><input type="number" name="minimum_stok[${b.id}]" class="form-control form-control-sm text-center minstok-input" min="0" placeholder="0" disabled></td>
                            <td><input type="text" name="kode_rak[${b.id}]" class="form-control form-control-sm text-center kode-input" placeholder="-" disabled></td>
                            <td><input type="text" name="penanggung_jawab[${b.id}]" class="form-control form-control-sm text-center penanggung-input" placeholder="-" disabled></td>
                        </tr>`;
                        });

                        // aktif/nonaktif input stok saat centang
                        document.querySelectorAll('.barang-check').forEach(function(checkbox) {
                            checkbox.addEventListener('change', function() {
                                const id = this.value;
                                const stokInput = document.querySelector(
                                    `[name="stok_aktual[${id}]"]`);
                                const minInput = document.querySelector(
                                    `[name="minimum_stok[${id}]"]`);
                                const kodeInput = document.querySelector(
                                    `[name="kode_rak[${id}]"]`);
                                const penanggungInput = document.querySelector(
                                    `[name="penanggung_jawab[${id}]"]`);
                                stokInput.disabled = !this.checked;
                                minInput.disabled = !this.checked;
                                kodeInput.disabled = !this.checked;
                                penanggungInput.disabled = !this.checked;
                                if (!this.checked) {
                                    stokInput.value = '';
                                    minInput.value = '';
                                    kodeInput.value = '';
                                    penanggungInput.value = '';
                                }
                            });
                        });
                    });
            });

            // Filter search
            searchInput.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();
                document.querySelectorAll('#barangTable tbody tr').forEach(row => {
                    const nama = row.querySelector('.nama-barang')?.textContent.toLowerCase() || '';
                    const kode = row.querySelector('.kode-barang')?.textContent.toLowerCase() || '';
                    row.style.display = (nama.includes(searchText) || kode.includes(searchText)) ?
                        '' : 'none';
                });
            });
        });
    </script>
@endsection
