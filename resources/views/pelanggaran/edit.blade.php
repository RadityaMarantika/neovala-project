@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="fw-bold text-primary mb-0">Edit Warnong Letter</h2>
            <a href="{{ route('pelanggaran.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-base text-center text-gray-800 font-bold mb-4">Edit Form</h2>
            <hr>
            <br>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('pelanggaran.update', $pelanggaran->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

                <div class="mb-3">
                    <label class="block font-medium">Jenis Pelanggaran</label>
                    <select name="status_pelanggaran" class="w-full border rounded-lg p-2" required>
                        @foreach(['Aktif','Tidak Aktif'] as $status_pelanggaran)
                            <option value="{{ $status_pelanggaran }}" {{ $pelanggaran->status_pelanggaran == $status_pelanggaran ? 'selected' : '' }}>{{ $status_pelanggaran }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Pilih Karyawan</label>
                    <select name="karyawan_id" class="w-full border rounded-lg p-2" required>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}" {{ $pelanggaran->karyawan_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Jenis Pelanggaran</label>
                    <select name="jenis" class="w-full border rounded-lg p-2" required>
                        @foreach(['Surat Teguran','SP1','SP2','SP3'] as $jenis)
                            <option value="{{ $jenis }}" {{ $pelanggaran->jenis == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ $pelanggaran->tanggal_mulai->format('Y-m-d') }}" class="w-full border rounded-lg p-2" required>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Keterangan</label>
                    <textarea name="keterangan" class="w-full border rounded-lg p-2">{{ $pelanggaran->keterangan }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Upload Surat Baru (Opsional)</label>
                    <input type="file" name="file_surat" class="w-full border rounded-lg p-2">
                    @if($pelanggaran->file_surat)
                        <div class="mt-4">
                            <strong>File Surat Sebelumnya:</strong> <br>

                            @php
                                $ext = strtolower(pathinfo($pelanggaran->file_surat, PATHINFO_EXTENSION));
                                $fileUrl = route('pelanggaran.viewFile', $pelanggaran->id);
                            @endphp

                            @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                {{-- kalau gambar --}}
                                <img src="{{ $fileUrl }}" 
                                    alt="File Surat" 
                                    class="mt-2 border rounded-lg max-w-md">

                            @elseif($ext === 'pdf')
                                {{-- kalau pdf --}}
                                <iframe src="{{ $fileUrl }}" 
                                        width="100%" 
                                        height="600px" 
                                        style="border: none;"></iframe>

                            @else
                                {{-- fallback link download --}}
                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600">Lihat File</a>
                            @endif
                        </div>
                    @endif
                </div>
                <br>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
@endsection
