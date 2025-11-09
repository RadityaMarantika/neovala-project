@extends('layouts.base')

@section('content')

<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">List Work Overtime</h2>
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
        <div class="card shadow-sm -0">
            <div class="card-body">

                {{-- Wrapper scroll --}}
                <div class="table-responsive" style="max-height: 75vh; overflow-x: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                    <th class=" px-3 py-2">Nama Karyawan</th>
                                    <th class=" px-3 py-2">Tanggal</th>
                                    <th class=" px-3 py-2">Jam Mulai</th>
                                    <th class=" px-3 py-2">Jam Selesai</th>
                                    <th class=" px-3 py-2">Durasi</th>
                                    <th class=" px-3 py-2">Alasan</th>
                                    <th class=" px-3 py-2">Status</th>
                                    <th class=" px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lemburs as $lembur)
                                <tr class="text-sm">
                                    <td class=" px-3 py-2">{{ $lembur->karyawan->nama_lengkap ?? '-' }}</td>
                                    <td class=" px-3 py-2">{{ $lembur->tanggal_lembur }}</td>
                                    <td class=" px-3 py-2">{{ $lembur->jam_mulai_lembur }}</td>
                                    <td class=" px-3 py-2">{{ $lembur->jam_selesai_lembur }}</td>
                                    <td class=" px-3 py-2">{{ $lembur->durasi_jam_lembur }}</td>
                                    <td class=" px-3 py-2">{{ $lembur->alasan_lembur }}</td>
                                    <td class=" px-3 py-2">
                                        <span class="
                                            px-2 py-1 rounded text-xs
                                            @if($lembur->status_lembur == 'Request') bg-yellow-300 text-yellow-800
                                            @elseif($lembur->status_lembur == 'Accepted') bg-green-300 text-green-800
                                            @elseif($lembur->status_lembur == 'Rejected') bg-red-300 text-red-800
                                            @elseif($lembur->status_lembur == 'Ongoing') bg-blue-300 text-blue-800
                                            @elseif($lembur->status_lembur == 'Done') bg-gray-300 text-gray-800
                                            @endif
                                        ">
                                            {{ $lembur->status_lembur }}
                                    </span>
                                </td>
                               <td class="px-3 py-2 text-center">
                                    @if($lembur->status_lembur == 'Request')
                                        <button class="btn btn-sm btn-primary shadow-sm d-inline-flex align-items-center"
                                            data-toggle="modal"
                                            data-target="#modalCheck{{ $lembur->id }}">
                                            <i class="fas fa-check-circle me-1"></i>
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                            </tr>

                            {{-- Modal Check --}}
                            <div class="modal fade" id="modalCheck{{ $lembur->id }}" tabindex="-1" aria-labelledby="modalCheckLabel{{ $lembur->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalCheckLabel{{ $lembur->id }}">Detail Lembur</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-sm">
                                            <p><strong>Nama:</strong> {{ $lembur->karyawan->nama_lengkap ?? '-'  }}</p>
                                            <p><strong>Tanggal:</strong> {{ $lembur->tanggal_lembur }}</p>
                                            <p><strong>Jam Mulai:</strong> {{ $lembur->jam_mulai_lembur }}</p>
                                            <p><strong>Jam Selesai:</strong> {{ $lembur->jam_selesai_lembur }}</p>
                                            <p><strong>Durasi:</strong> {{ $lembur->durasi_jam_lembur }}</p>
                                            <p><strong>Alasan:</strong> {{ $lembur->alasan_lembur }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('lembur.reject', $lembur->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded">Reject</button>
                                            </form>
                                            <form action="{{ route('lembur.accept', $lembur->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs rounded">Accept</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Modal --}}

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
