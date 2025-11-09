@extends('layouts.base')

@section('content')

<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Data Self Sewa</h2>
            <a href="{{ route('master_self_sewas.create') }}" class="bg-green-500 text-white text-xs px-3 py-2 rounded">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="p-4 bg-white rounded shadow">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Agen</th>
                    <th>Unit</th>
                    <th>Periode Sewa</th>
                    <th>Total Hutang</th>
                    <th>Fee Agen</th>
                    <th>Deposit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($master_self_sewas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->agen->nama_lengkap ?? '-' }}</td>
                        <td>{{ $item->unit->no_unit ?? '-' }}</td>
                        <td>{{ $item->periode_sewa }}</td>
                        <td>{{ number_format($item->total_hutang, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->fee_agen, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->deposit, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('master_self_sewas.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('master_self_sewas.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

@endsection
