@extends('layouts.base')

@section('content')

<x-app-layout>
    {{-- Header --}}
    

    {{-- HERO CARD --}}
    <div class="card border-0 shadow-sm mb-5 hero-card text-white">
        <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                My Work Overtime
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
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
        @endif

       {{-- Main Card --}}
        <div class="card shadow-sm -0">
            <div class="card-body">

                {{-- Wrapper scroll --}}
                <div class="table-responsive" style="max-height: 75vh; overflow-x: auto;">
                    <table class="table table-hover align-middle mb-0 text-sm">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-2 whitespace-nowrap">Tanggal</th>
                                <th class="px-4 py-2">Mulai</th>
                                <th class="px-4 py-2">Selesai</th>
                                <th class="px-4 py-2">Durasi</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lemburs as $l)
                                <tr class="text-sm">
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $l->tanggal_lembur }}</td>
                                    <td class="px-4 py-2">{{ $l->jam_mulai_lembur }}</td>
                                    <td class="px-4 py-2">{{ $l->jam_selesai_lembur }}</td>
                                    <td class="px-4 py-2">{{ $l->durasi_jam_lembur }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded 
                                            @if($l->status_lembur=='Request') bg-yellow-100 text-yellow-700
                                            @elseif($l->status_lembur=='Accepted') bg-blue-100 text-blue-700
                                            @elseif($l->status_lembur=='Ongoing') bg-purple-100 text-purple-700
                                            @elseif($l->status_lembur=='Done') bg-green-100 text-green-700
                                            @elseif($l->status_lembur=='Rejected') bg-red-100 text-red-700
                                            @endif">
                                            {{ $l->status_lembur }}
                                        </span>
                                    </td>
                                    {{--
                                    <td class="px-4 py-2 space-x-2">
                                        @if($l->status_lembur == 'Accepted')
                                            <form action="{{ route('lembur.start', $l->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="px-3 py-1 bg-blue-500 text-white text-xs rounded">Mulai</button>
                                            </form>
                                        @endif

                                        @if($l->status_lembur == 'Ongoing')
                                            <form action="{{ route('lembur.done', $l->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="px-3 py-1 bg-green-500 text-white text-xs rounded">Selesai</button>
                                            </form>
                                        @endif
                                    </td>
                                    --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada pengajuan lembur.</td>
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
