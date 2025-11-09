@extends('layouts.base')

@section('content')
    <x-app-layout>
        {{-- Header --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="fw-bold text-primary mb-0">Management Shifting</h2>
                <a href="{{ route('master_shifts.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> New
                </a>
            </div>
        </x-slot>

        <div class="py-6">
            {{-- Alert Section --}}
            @if (session('success'))
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
                                    <th class="border p-2">Kode Shift</th>
                                    <th class="border p-2">Jenis</th>
                                    <th class="border p-2">Jam Masuk</th>
                                    <th class="border p-2">Jam Pulang</th>
                                    <th class="border p-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masterShifts as $shift)
                                    <tr>
                                        <td class="border p-2">{{ $shift->buat_kode_shift }}</td>
                                        <td class="border p-2">{{ $shift->status_shift }}</td>
                                        <td class="border p-2">{{ \Carbon\Carbon::parse($shift->jam_masuk)->format('H:i') }}
                                        </td>
                                        <td class="border p-2">
                                            {{ \Carbon\Carbon::parse($shift->jam_pulang)->format('H:i') }}</td>
                                        <td class="border p-2 flex gap-2">
                                            <a href="{{ route('master_shifts.edit', $shift->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('master_shifts.destroy', $shift->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($masterShifts->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center p-3 text-gray-500">Belum ada master shift.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </x-app-layout>
@endsection
