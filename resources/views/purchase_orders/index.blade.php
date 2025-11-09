@extends('layouts.base')

@section('content')
    <div class="py-6">
        <div class="card border-0 shadow rounded-4">

            {{-- HEADER --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">Daftar Purchase Order</h5>
                <a href="{{ route('purchase-orders.create') }}" class="btn btn-light btn-sm fw-semibold">+ Buat PO Baru</a>
            </div>

            <div class="card-body p-4">

                {{-- NOTIFIKASI --}}
                @if (session('success'))
                    <div class="alert alert-success rounded-3">{{ session('success') }}</div>
                @endif

                {{-- TABEL --}}
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode PO</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total Item</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrders as $po)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold text-primary">{{ $po->kode_po }}</td>

                                <td>{{ \Carbon\Carbon::parse($po->tanggal_po)->format('d/m/Y H:i') }}</td>

                                <td>
                                    <span
                                        class="badge 
                                    @if ($po->status == 'Pending') bg-warning 
                                    @elseif($po->status == 'Approved') bg-info 
                                    @elseif($po->status == 'Ongoing') bg-primary 
                                    @elseif($po->status == 'Receive') bg-success @endif">
                                        {{ $po->status }}
                                    </span>
                                </td>

                                <td>{{ $po->items->count() }}</td>

                                <td>
                                    {{-- BUTTON DALAM STATUS --}}
                                    @if ($po->status == 'Pending')
                                        <form action="{{ route('purchase-orders.approve', $po->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @elseif($po->status == 'Approved')
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#pembelianModal{{ $po->id }}">
                                            Input Pembelian
                                        </button>
                                    @elseif($po->status == 'Ongoing')
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#terimaModal{{ $po->id }}">
                                            Terima Barang
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                {{-- ================================================================= --}}
                {{-- ========================== SEMUA MODAL =========================== --}}
                {{-- ================================================================= --}}

                @foreach ($purchaseOrders as $po)
                    {{-- ========================= MODAL INPUT PEMBELIAN ========================= --}}
                    <div class="modal fade" id="pembelianModal{{ $po->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow">

                                <form action="{{ route('purchase-orders.pembelian', $po->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Input Pembelian — {{ $po->kode_po }}</h5>
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal Pembelian</label>
                                            <input type="datetime-local" name="tanggal_pembelian" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Bukti Pembelian (opsional)</label>
                                            <input type="file" name="bukti_pembelian" class="form-control">
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Pembelian</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>



                    {{-- ========================= MODAL TERIMA BARANG ========================= --}}
                    <div class="modal fade" id="terimaModal{{ $po->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow">

                                <form action="{{ route('purchase-orders.terima', $po->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">Terima Barang — {{ $po->kode_po }}</h5>
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tanggal Diterima</label>
                                            <input type="datetime-local" name="tanggal_diterima" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Bukti Barang Sampai (opsional)</label>
                                            <input type="file" name="bukti_sampai" class="form-control">
                                        </div>

                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nama Barang</th>
                                                    <th>Qty Dipesan</th>
                                                    <th>Qty Diterima</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($po->items as $item)
                                                    <tr>
                                                        <td>{{ $item->inventory->nama_barang }}</td>
                                                        <td>{{ $item->qty_request }}</td>

                                                        <td style="width: 180px;">
                                                            {{-- qty_received pakai ID item --}}
                                                            <input type="number" name="qty_received[{{ $item->id }}]"
                                                                class="form-control form-control-sm" min="0"
                                                                max="{{ $item->qty_request }}" required>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan & Terima Barang</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- ========================== END MODAL =============================== --}}

            </div>
        </div>
    </div>
@endsection
