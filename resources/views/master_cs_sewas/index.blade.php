@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Data Sewa Customer (CS Sewa)</h2>
            <a href="{{ route('master_cs_sewas.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="card p-4 mt-3 shadow-sm rounded-3">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Agen</th>
                    <th>Customer</th>
                    <th>Unit</th>
                    <th>Periode</th>
                    <th>Tgl Pengambilan Kunci</th>
                    <th>Total Hutang</th>
                    <th>Total Profit</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($master_cs_sewas as $sewa)
                    <tr>
                        <td>{{ $sewa->agen->nama_lengkap ?? '-' }}</td>
                        <td>{{ $sewa->customer->nama_lengkap ?? '-' }}</td>
                        <td>{{ $sewa->unit->no_unit ?? '-' }}</td>
                        <td>{{ $sewa->periode_sewa }}</td>
                        <td>{{ $sewa->pengambilan_kunci }}</td>
                        <td>Rp {{ number_format($sewa->total_hutang, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($sewa->total_profit, 0, ',', '.') }}</td>
                        <td>
                            @if($sewa->total_profit > 0)
                                <span class="badge bg-success">Profit</span>
                            @else
                                <span class="badge bg-danger">Rugi</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('master_cs_sewas.edit', $sewa->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('master_cs_sewas.destroy', $sewa->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Belum ada data sewa customer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
@endsection
