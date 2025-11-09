@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Data Riwayat PettyCash</h2>
            <a href="{{ route('transaksi_saldo_pettycash.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Buat Transaksi
            </a>
        </div>
    </x-slot>


    <div class="py-6">
        {{-- Alert Section --}}
        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
        @endif

        {{-- Main Card --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $t)
                        <tr>
                            <td>{{ $t->tanggal }}</td>
                            <td>{{ ucfirst($t->jenis_transaksi) }}</td>
                            <td>{{ $t->asal?->nama_pettycash ?? '-' }}</td>
                            <td>{{ $t->tujuan?->nama_pettycash }}</td>
                            <td>Rp{{ number_format($t->nominal, 0, ',', '.') }}</td>
                            <td>{{ $t->keterangan }}</td>
                            <td>
                                <a href="{{ route('transaksi_saldo_pettycash.edit', $t->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('transaksi_saldo_pettycash.destroy', $t->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
