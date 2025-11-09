@extends('layouts.base')
@section('content')
<div class="py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-info text-white">
            <h5>Detail Gudang</h5>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th>Nama Gudang</th>
                    <td>: {{ $gudang->nama_gudang }}</td>
                </tr>
                <tr>
                    <th>Region</th>
                    <td>: {{ $gudang->region }}</td>
                </tr>
                <tr>
                    <th>Kepala Gudang</th>
                    <td>: {{ $gudang->kepala_gudang }}</td>
                </tr>
            </table>
            <div class="d-flex justify-content-end">
                <a href="{{ route('master_gudang.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
