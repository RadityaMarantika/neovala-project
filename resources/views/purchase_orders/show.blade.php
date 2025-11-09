@extends('layouts.base')

@section('content')
    <div class="py-4">
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0">Detail Purchase Order - {{ $purchaseOrder->kode_po }}</h5>
                <a href="{{ route('po.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            <span
                                class="badge 
                            @if ($purchaseOrder->status == 'Pending') bg-warning 
                            @elseif($purchaseOrder->status == 'Ongoing') bg-info 
                            @elseif($purchaseOrder->status == 'Receive') bg-success 
                            @else bg-secondary @endif">
                                {{ $purchaseOrder->status }}
                            </span>
                        </p>
                        <p><strong>Tanggal PO:</strong>
                            {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d M Y') }}</p>
                        <p><strong>Dibuat Oleh:</strong> {{ $purchaseOrder->user->name ?? '-' }}</p>
                    </div>
                </div>

                <table class="table table-bordered align-middle mb-4">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Qty Dipesan</th>
                            <th>Qty Diterima</th>
                            <th>Status Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrder->items as $detail)
                            <tr>
                                <td>{{ $detail->inventory->nama_barang }}</td>
                                <td>{{ $detail->qty_po }}</td>
                                <td>{{ $detail->qty_diterima ?? '-' }}</td>
                                <td>{{ $detail->inventory->status_stok ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Aksi sesuai status --}}
                @if ($purchaseOrder->status == 'Pending')
                    <form action="{{ route('po.approve', $purchaseOrder->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Approve
                            PO</button>
                    </form>
                @elseif ($purchaseOrder->status == 'Approved')
                    <form action="{{ route('po.purchase', $purchaseOrder->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Tanggal Pembelian</label>
                            <input type="date" name="tanggal_pembelian" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Bukti Pembelian</label>
                            <input type="file" name="bukti_pembelian" class="form-control" required>
                        </div>
                        <button class="btn btn-info fw-semibold">Simpan Pembelian</button>
                    </form>
                @elseif ($purchaseOrder->status == 'Ongoing')
                    <form action="{{ route('po.receive', $purchaseOrder->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Tanggal Diterima</label>
                            <input type="date" name="tanggal_diterima" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Bukti Barang Sampai</label>
                            <input type="file" name="bukti_sampai" class="form-control" required>
                        </div>

                        <table class="table table-bordered mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Qty Dipesan</th>
                                    <th>Qty Aktual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchaseOrder->items as $detail)
                                    <tr>
                                        <td>{{ $detail->inventory->nama_barang }}</td>
                                        <td>{{ $detail->qty_po }}</td>
                                        <td>
                                            <input type="number" name="qty_diterima[{{ $detail->id }}]"
                                                class="form-control form-control-sm" min="0" required>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button class="btn btn-success mt-3 fw-semibold">Simpan Penerimaan</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
