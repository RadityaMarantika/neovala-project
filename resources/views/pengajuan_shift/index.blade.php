@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">List Permission Attending</h2>
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

                {{-- Wrapper scroll --}}
                <div class="table-responsive" style="max-height: 75vh; overflow-x: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class=" px-3 py-2">Karyawan</th>
                                <th class=" px-3 py-2">Shift</th>
                                <th class=" px-3 py-2">Tanggal</th>
                                <th class=" px-3 py-2">Jenis</th>
                                <th class=" px-3 py-2">Keterangan</th>
                                <th class=" px-3 py-2">Foto</th>
                                <th class=" px-3 py-2">Foto Bukti</th>
                                <th class=" px-3 py-2">Status</th>
                                <th class=" px-3 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengajuans as $p)
                            <tr>
                                <td class=" px-3 py-2">{{ $p->karyawan->nama_lengkap }}</td>
                                <td class=" px-3 py-2">{{ $p->shift->kode_shift }}</td>
                                <td class=" px-3 py-2">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                <td class=" px-3 py-2">{{ ucfirst($p->jenis_pengajuan) }}</td>
                                <td class=" px-3 py-2">{{ $p->keterangan }}</td>
                                <td class=" px-3 py-2">
                                    @if($p->foto)
                                        <a href="{{ Storage::url($p->foto) }}" target="_blank" class="text-blue-600">Lihat</a>
                                    @endif
                                </td>
                                <td class=" px-3 py-2">
                                    @if($p->foto_bukti)
                                        <a href="{{ Storage::url($p->foto_bukti) }}" target="_blank" class="text-blue-600">Lihat</a>
                                    @endif
                                </td>
                                <td class=" px-3 py-2">{{ ucfirst($p->status) }}</td>
                                <td class=" px-3 py-2 text-center">
                                    @if($p->status == 'pending')
                                    <form action="{{ route('pengajuan-shift.approve', $p->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button class="bg-green-600 text-white px-2 py-1 rounded text-xs">Approve</button>
                                    </form>
                                    <form action="{{ route('pengajuan-shift.reject', $p->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button class="bg-red-600 text-white px-2 py-1 rounded text-xs">Reject</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
