@extends('layouts.base')

@section('content')

<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Approval Pinjaman</h2>
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

                {{-- Table Wrapper --}}
                <div class="table-responsive" style="max-height: 75vh; overflow-x: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Alasan</th>
                                <th>Cicilan</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pinjamans as $p)
                                <tr>
                                    <td>{{ $p->account->karyawan->nama_lengkap }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($p->jumlah_pinjam, 0, ',', '.') }}</td>
                                    <td>{{ $p->alasan }}</td>
                                    <td>{{ $p->jumlah_cicilan }}x</td>
                                    <td>
                                        @if($p->upload_bukti)
                                            <a href="{{ asset('storage/'.$p->upload_bukti) }}" target="_blank" class="text-decoration-none">
                                                <i class="fas fa-file-image text-primary"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($p->status == 'approved') bg-success 
                                            @elseif($p->status == 'rejected') bg-danger 
                                            @else bg-warning text-dark 
                                            @endif">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($p->status == 'request')
                                            <form action="{{ route('koperasi.pinjaman.approve', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-success btn-sm shadow-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('koperasi.pinjaman.approve', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        Tidak ada pengajuan pinjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
@endsection
