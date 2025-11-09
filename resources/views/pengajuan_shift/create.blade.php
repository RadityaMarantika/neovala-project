@extends('layouts.base')

@section('content')
<x-app-layout>
        

    {{-- HERO CARD --}}
    <div class="card border-0 shadow-sm mb-5 hero-card text-white">
        <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                Shift Request
            </h5>

            <a href="{{ url()->previous() }}"
                class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                style="transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
    <div class="">
        <div class="mx-auto px-4">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('pengajuan-shift.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Pilih Shift</label>
                        <select name="shift_id" class="w-full border-gray-300 rounded">
                            @foreach($shifts as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->kode_shift }} - {{ \Carbon\Carbon::parse($s->jadwal_tanggal)->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jenis Pengajuan</label>
                        <select name="jenis_pengajuan" class="w-full border-gray-300 rounded">
                            <option value="izin">Izin</option>
                            <option value="backup">Backup</option>
                            <option value="sakit">Sakit</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Keterangan</label>
                        <textarea name="keterangan" class="w-full border-gray-300 rounded"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Upload Foto Alasan</label>
                        <input type="file" name="foto" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Upload Foto Bukti</label>
                        <input type="file" name="foto_bukti" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="flex justify-end">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
