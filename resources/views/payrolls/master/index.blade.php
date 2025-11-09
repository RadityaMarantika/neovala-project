@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Master Payroll</h2>
            <a href="{{ route('master-payroll.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> New
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

                {{-- Wrapper scroll --}}
                <div class="table-responsive" style="max-height: 75vh; overflow-x: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-2 px-3 whitespace-nowrap">#</th>
                                <th class="py-2 px-3 whitespace-nowrap">Karyawan</th>
                                <th class="py-2 px-3 whitespace-nowrap text-center">Basic Salary</th>
                                <th class="py-2 px-3 whitespace-nowrap text-center">Leader Fee</th>
                                <th class="py-2 px-3 whitespace-nowrap text-center">Insentive Fee</th>
                                <th class="py-2 px-3 whitespace-nowrap">Bank</th>
                                <th class="py-2 px-3 whitespace-nowrap">No. Rekening</th>
                                <th class="py-2 px-3 whitespace-nowrap">No. WA</th>
                                <th class="py-2 px-3 whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $i)
                                <tr>
                                    <td class="text-center py-2 px-3">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-3">{{ optional($i->karyawan)->nama_lengkap ?? '-' }}</td>
                                    <td class="py-2 px-3 text-center">{{ number_format($i->basic_salary, 0, ',', '.') }}</td>
                                    <td class="py-2 px-3 text-center">{{ number_format($i->leader_fee, 0, ',', '.') }}</td>
                                    <td class="py-2 px-3 text-center">{{ number_format($i->insentive_fee, 0, ',', '.') }}</td>
                                    <td class="py-2 px-3">{{ $i->nama_bank ?? '-' }}</td>
                                    <td class="py-2 px-3">{{ $i->nomor_rekening ?? '-' }}</td>
                                    <td class="py-2 px-3">{{ $i->no_wa ?? '-' }}</td>
                                    <td class="py-2 px-3 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('master-payroll.edit', $i->id) }}"
                                            class="btn btn-sm btn-warning text-white">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('master-payroll.destroy', $i->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-4 text-center text-muted">
                                        <i class="fas fa-info-circle me-1"></i> Belum ada data payroll.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table> 
                </div>

            </div>

            {{-- Pagination --}}
            @if ($items->hasPages())
                <div class="p-4 border-t bg-gray-50 flex justify-center">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
@endsection
