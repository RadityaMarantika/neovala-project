@extends('layouts.base')
@section('content')
<div class="py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-info text-white">
            <h5>Detail Inventori Gudang</h5>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th>Gudang</th>
                    <td>: {{ $data->gudang->nama_gudang ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Barang</th>
                    <td>: {{ $data->barang->nama_barang ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Stok Aktual</th>
                    <td>: {{ $data->stok_aktual }}</td>
                </tr>
                <tr>
                    <th>Minimum Stok</th>
                    <td>: {{ $data->minimum_stok }}</td>
                </tr>
                <tr>
                    <th>Status Stok</th>
                    <td>: 
                        <span class="badge 
                            @if($data->status_stok == 'Habis') bg-danger 
                            @elseif($data->status_stok == 'Perlu Purchase') bg-warning 
                            @else bg-success 
                            @endif">
                            {{ $data->status_stok }}
                        </span>
                    </td>
                </tr>
            </table>
            <div class="d-flex justify-content-end">
                <a href="{{ route('master_inventori_gudang.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
