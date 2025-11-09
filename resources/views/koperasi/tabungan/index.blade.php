@extends('layouts.base')

@section('content')
<x-app-layout>

    {{-- Header --}}

    {{-- HERO CARD --}}
    <div class="card border-0 shadow-sm mb-5 hero-card text-white">
        <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                My Savings
            </h5>

            <a  href="{{ route('layout-menus.karyawan') }}"
                class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                style="transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>

    <div class="">

        {{-- Alert Section --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        {{-- Main Card --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                
            @if($account)
            <a href="{{ route('koperasi.tabungan.create', $account->id) }}" class="btn btn-primary">
                Ajukan Tabungan
            </a>
            @else
                <div class="alert alert-warning">
                    Akun tabungan belum tersedia, hubungi HR.
                </div>
            @endif

                {{-- Wrapper scroll --}}
                <div class="table-responsive" style="max-height: 70vh; overflow-x:auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Bukti</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tabungans as $t)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $t->tanggal_input }}</td>
                                    <td class="whitespace-nowrap">{{ number_format($t->jumlah,0,',','.') }}</td>
                                    <td class="whitespace-nowrap">
                                        <span class="badge text-light 
                                            @if($t->status=='approved') bg-success
                                            @elseif($t->status=='rejected') bg-danger
                                            @else bg-warning
                                            @endif">
                                            {{ ucfirst($t->status) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if($t->upload_bukti)
                                            <a href="{{ asset('storage/'.$t->upload_bukti) }}" target="_blank">Lihat</a>
                                        @else -
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap">{{ $t->saldo_after ? number_format($t->saldo_after,0,',','.') : '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">Belum ada transaksi tabungan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
