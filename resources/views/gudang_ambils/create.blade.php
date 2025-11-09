@extends('layouts.base')

@section('content')
    <div class="py-6">
        <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-primary text-white fw-semibold">
                Transfer Barang Dari Gudang Pusat
            </div>

            <div class="card-body">

                {{-- ALERT --}}
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('gudang-ambils.store') }}" method="POST">
                    @csrf

                    {{-- PILIH GUDANG --}}
                    <div class="mb-3">
                        <label class="fw-semibold">Pilih Gudang Tujuan</label>
                        <select name="gudang_tujuan" class="form-select" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach ($gudangs as $g)
                                <option value="{{ $g->id }}">{{ $g->nama_gudang }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TABEL ITEM --}}
                    <table class="table table-bordered" id="itemTable">
                        <thead class="table-light">
                            <tr>
                                <th width="60%">Barang</th>
                                <th width="20%">Qty</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <select name="barang_id[]" class="form-select" required>
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($barangs as $b)
                                            <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="number" name="qty_transfer[]" class="form-control" min="1"
                                        required>
                                </td>

                                <td>
                                    <button type="button" class="btn btn-danger remove-row">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button id="addRow" type="button" class="btn btn-outline-primary btn-sm">+ Tambah Barang</button>

                    <div class="mt-4 text-end">
                        <button class="btn btn-primary">Simpan Transfer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT DINAMIS --}}
    <script>
        document.getElementById('addRow').addEventListener('click', function() {

            let row = `
                <tr>
                    <td>
                        <select name="barang_id[]" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($barangs as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="number" name="qty_transfer[]" class="form-control"
                               min="1" required>
                    </td>

                    <td>
                        <button type="button" class="btn btn-danger remove-row">Hapus</button>
                    </td>
                </tr>
            `;

            document.querySelector('#itemTable tbody').insertAdjacentHTML('beforeend', row);
        });

        // HAPUS BARIS
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
