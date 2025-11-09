@extends('layouts.base')

@section('content')
    <div class="py-6">
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-primary text-white fw-semibold">
                Buat Purchase Order Baru
            </div>
            <div class="card-body p-4">
                <form action="{{ route('purchase-orders.store') }}" method="POST">
                    @csrf

                    <table class="table table-bordered align-middle" id="poTable">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th width="20%">Qty Request</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="inventory_id[]" class="form-select" required>
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($inventories as $inv)
                                            <option value="{{ $inv->id }}">{{ $inv->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="qty_request[]" class="form-control" min="1" required>
                                </td>
                                <td><button type="button" class="btn btn-sm btn-danger remove-row">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" class="btn btn-outline-primary btn-sm" id="addRow">+ Tambah Barang</button>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Simpan PO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addRow').addEventListener('click', function() {
            let newRow = `
        <tr>
            <td>
                <select name="inventory_id[]" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($inventories as $inv)
                        <option value="{{ $inv->id }}">{{ $inv->nama_barang }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="qty_request[]" class="form-control" min="1" required></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-row">Hapus</button></td>
        </tr>`;
            document.querySelector('#poTable tbody').insertAdjacentHTML('beforeend', newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
