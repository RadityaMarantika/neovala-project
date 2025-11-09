@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="fw-bold text-primary mb-0">List Warning Letter</h2>
            <a href="{{ route('pelanggaran.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> New</a>
        </div>
    </x-slot>

    <div class="py-6">
            @if(session('success'))
                <div class="mb-3 text-green-700 bg-green-100 p-3 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif


       {{-- Main Card --}}
        <div class="card shadow-sm -0">
            <div class="card-body">

                {{-- Wrapper scroll --}}
                <div class="table-responsive" style="max-height: 75vh; overflow-x: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="p-2 ">#</th>
                                <th class="p-2 ">Karyawan</th>
                                <th class="p-2 ">Jenis</th>
                                <th class="p-2 ">Tanggal Mulai</th>
                                <th class="p-2 ">Tanggal Selesai</th>
                                <th class="p-2 ">Status</th>
                                <th class="p-2 ">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelanggaran as $p)
                                <tr>
                                    <td class="p-2 ">{{ $loop->iteration }}</td>
                                    <td class="p-2 ">{{ $p->karyawan->nama_lengkap ?? '-' }}</td>
                                    <td class="p-2 ">{{ $p->jenis }}</td>
                                    <td class="p-2 ">
                                        {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d/m/Y') }}
                                    </td>
                                    <td class="p-2 ">
                                        {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d/m/Y') }}
                                    </td>
                                    <td class="p-2 ">{{ $p->status_pelanggaran }}</td>
                                    <td class="p-2  flex space-x-2">
                                        <a href="{{ route('pelanggaran.show', $p->id) }}" 
                                            class="btn btn-sm btn-primary text-white"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('pelanggaran.edit', $p->id) }}"
                                            class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('pelanggaran.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></button>
                                        </form>
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
