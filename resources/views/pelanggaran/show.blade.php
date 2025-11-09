@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Detail Warning Letter</h2>
            <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="card border-0 shadow-lg rounded-4 p-4 mb-5">
            <h5 class="fw-bold text-primary mb-4">Detail Warning Letter</h5>

            {{-- Detail Data Pelanggaran --}}
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0" style="width: 100%;">
                    <tbody>
                        <tr>
                            <td class="text-end fw-semibold" style="width: 20%;">Karyawan :</td>
                            <td style="width: 30%;">{{ $pelanggaran->karyawan->nama_lengkap ?? '-' }}</td>

                            <td class="text-end fw-semibold" style="width: 20%;">Jenis :</td>
                            <td style="width: 30%;">{{ $pelanggaran->jenis }}</td>
                        </tr>

                        <tr>
                            <td class="text-end fw-semibold">Status :</td>
                            <td>
                                <span class="badge text-white px-3 py-1
                                    @if($pelanggaran->status_pelanggaran == 'Aktif') bg-danger
                                    @elseif($pelanggaran->status_pelanggaran == 'Tidak Aktif') bg-success
                                    @else bg-secondary @endif">
                                    {{ ucfirst($pelanggaran->status_pelanggaran) }}
                                </span>
                            </td>

                            <td class="text-end fw-semibold">Tanggal Mulai :</td>
                            <td>{{ $pelanggaran->tanggal_mulai->format('d/m/Y') }}</td>
                        </tr>

                        <tr>
                            <td class="text-end fw-semibold">Tanggal Selesai :</td>
                            <td>{{ $pelanggaran->tanggal_selesai->format('d/m/Y') }}</td>

                            <td class="text-end fw-semibold">Keterangan :</td>
                            <td>
                                <div class="border rounded p-3 bg-light">
                                    {!! nl2br(e($pelanggaran->keterangan ?? '-')) !!}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- File Surat --}}
            @if($pelanggaran->file_surat)
                <hr class="my-4">
                <h6 class="fw-semibold text-primary">Lampiran File Surat</h6>

                @php
                    $ext = strtolower(pathinfo($pelanggaran->file_surat, PATHINFO_EXTENSION));
                    $fileUrl = route('pelanggaran.viewFile', $pelanggaran->id);
                @endphp

                <div class="mt-3 text-center">
                    @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                        <img src="{{ $fileUrl }}" 
                            alt="File Surat" 
                            class="img-fluid rounded border shadow-sm" 
                            style="max-width: 400px;">
                    @elseif($ext === 'pdf')
                        <iframe src="{{ $fileUrl }}" 
                                width="100%" 
                                height="600px" 
                                style="border: none;"></iframe>
                    @else
                        <a href="{{ $fileUrl }}" 
                            target="_blank" 
                            class="text-primary fw-semibold">
                            <i class="fas fa-paperclip me-1"></i> Lihat File
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
@endsection
