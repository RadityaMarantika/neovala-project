@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="fw-bold text-primary mb-0">Form Warnong Letter</h2>
            <a href="{{ route('pelanggaran.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class=" mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-base text-center text-gray-800 font-bold mb-4">Input Form</h2>
            <hr>
            <br>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="mb-3">
                    <label class="block font-medium">Pilih Karyawan</label>
                    <select name="karyawan_id" class="w-full border rounded-lg p-2" required>
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Jenis Pelanggaran</label>
                    <select name="jenis" class="w-full border rounded-lg p-2" required>
                        <option value="Surat Teguran">Surat Teguran</option>
                        <option value="SP1">SP1</option>
                        <option value="SP2">SP2</option>
                        <option value="SP3">SP3</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="w-full border rounded-lg p-2" required>
                </div>

                <div class="mb-4">
                    <label for="durasi" class="block text-sm font-medium text-gray-700">Durasi (minggu)</label>
                    <select name="durasi" id="durasi" class="form-select mt-1 block w-full">
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}">{{ $i }} Minggu</option>
                        @endfor
                    </select>
                </div>


                <div class="mb-3">
                    <label class="block font-medium">Keterangan</label>
                    <textarea name="keterangan" class="w-full border rounded-lg p-2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Status Pelanggaran</label>
                    <select name="status_pelanggaran" class="w-full border rounded-lg p-2" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block font-medium">Upload Surat</label>
                    <input type="file" name="file_surat" class="w-full border rounded-lg p-2">
                </div>

                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">
                    Simpan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
@endsection
