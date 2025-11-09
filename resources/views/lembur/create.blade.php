@extends('layouts.base')

@section('content')

<x-app-layout>
    {{-- Header --}}

    {{-- HERO CARD --}}
    <div class="card border-0 shadow-sm mb-5 hero-card text-white">
        <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                Overtime Form
            </h5>

            <a href="{{ url()->previous() }}"
                class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                style="transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
    <div class="">
        <div class=" mx-auto px-4">
            <div class="bg-white shadow rounded-lg p-6">

                {{-- Error message umum --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-600 font-semibold">
                        Terjadi kesalahan:
                        <ul class="list-disc list-inside text-sm text-red-500 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('lembur.store') }}" method="POST">
                    @csrf

                    {{-- Tanggal Lembur --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Tanggal Lembur</label>
                        <input type="date" name="tanggal_lembur" class="w-full border rounded p-2" required>
                    </div>

                    {{-- Durasi --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Durasi Jam Lembur</label>
                        <input type="time" id="durasi_jam_lembur" name="durasi_jam_lembur" class="w-full border rounded p-2" required>
                    </div>

                    {{-- Jam Mulai --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Jam Mulai</label>
                        <input type="time" id="jam_mulai_lembur" name="jam_mulai_lembur" class="w-full border rounded p-2" required>
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Jam Selesai</label>
                        <input type="time" id="jam_selesai_lembur" name="jam_selesai_lembur" class="w-full border rounded p-2" required>
                    </div>

                    {{-- Alasan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Alasan Lembur</label>
                        <textarea name="alasan_lembur" class="w-full border rounded p-2" rows="3" required></textarea>
                    </div>

                    {{-- Button --}}
                    <div class="flex justify-end">
                        <a href="{{ route('lembur.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded mr-2">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script otomatis hitung jam selesai --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jamMulaiInput = document.getElementById('jam_mulai_lembur');
        const durasiInput = document.getElementById('durasi_jam_lembur');
        const jamSelesaiInput = document.getElementById('jam_selesai_lembur');

        function hitungJamSelesai() {
            if (!jamMulaiInput.value || !durasiInput.value) return;

            let [jamMulai, menitMulai] = jamMulaiInput.value.split(':').map(Number);
            let [durasiJam, durasiMenit] = durasiInput.value.split(':').map(Number);

            let totalMenit = (jamMulai * 60 + menitMulai) + (durasiJam * 60 + durasiMenit);

            let jamSelesai = Math.floor(totalMenit / 60) % 24; 
            let menitSelesai = totalMenit % 60;

            // Format ke HH:MM
            jamSelesaiInput.value = 
                String(jamSelesai).padStart(2, '0') + ':' + String(menitSelesai).padStart(2, '0');
        }

        jamMulaiInput.addEventListener('input', hitungJamSelesai);
        durasiInput.addEventListener('input', hitungJamSelesai);
    });
</script>

@endsection
