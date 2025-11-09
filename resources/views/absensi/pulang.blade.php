@extends('layouts.base')

@section('content')
    <x-app-layout>
        {{-- HERO CARD --}}
        <div class="card border-0 shadow-sm mb-5 hero-card text-white">
            <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                    Clock Out Absent
                </h5>

                <a  href="{{ route('layout-menus.karyawan') }}"
                    class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                    style="transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Card Absen -->
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
                <div {{-- Alert Error --}}
                    @if ($errors->any()) <div class="mb-5 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div> @endif
                    <form action="{{ route('absensi.pulang.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                    <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

                    {{-- Shift Info --}}
                    <div class="bg-gray-50 border rounded-lg p-4">
                        <label class="block text-gray-600 text-sm font-semibold mb-1">Shift Hari Ini</label>
                        <div class="text-sm text-gray-800 leading-relaxed">
                            <span class="font-bold">{{ $shift->kode_shift }}</span> — {{ $shift->lokasi }} <br>
                            {{ $shift->jadwal_tanggal->format('d-m-Y') }}<br>
                            <span class="text-xs text-gray-500">
                                Jam kerja: {{ substr($shift->jam_masuk_kerja, 0, 5) }} -
                                {{ substr($shift->jam_pulang_kerja, 0, 5) }}
                            </span>
                        </div>
                    </div>

                    {{-- Karyawan --}}
                    <div class="bg-gray-50 border rounded-lg p-4">
                        <label class="block text-gray-600 text-sm font-semibold mb-1">Nama Karyawan</label>
                        <p class="text-sm text-gray-800 font-medium">{{ $karyawan->nama_lengkap }}</p>
                    </div>

                    {{-- Foto Selfie Pulang --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Selfie Pulang (kamera langsung)</label>
                        <div class="border border-gray-300 rounded-lg p-3 bg-gray-50 hover:bg-gray-100 transition">
                            <input type="file" name="foto_selfi_pulang" accept="image/*" capture="environment"
                                class="block w-full text-sm text-gray-700 cursor-pointer focus:outline-none" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Ambil foto selfie setelah selesai bekerja.</p>
                    </div>

                    {{-- Lokasi Pulang --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Share Live Location</label>
                        <div class="flex gap-2">
                            <input id="locPulang" type="text" name="share_live_location_pulang"
                                class="flex-1 border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-lg text-sm"
                                placeholder="Tempel link / koordinat" required>
                            <button type="button" onclick="getLocation('locPulang')"
                                class="px-4 py-2 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                <i class="fas fa-location-arrow mr-1"></i> Ambil
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Klik tombol "Ambil" untuk otomatis isi koordinat lokasi
                            Anda.</p>
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white text-sm px-5 py-2 rounded-lg font-medium transition duration-200 shadow-sm">
                            <i class="fas fa-save mr-1"></i> Simpan Absen Pulang
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <x-slot name="script">
            {{-- Font Awesome Icons --}}
            <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

            {{-- Script Lokasi --}}
            <script>
                function getLocation(targetId) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(pos) {
                            const lat = pos.coords.latitude.toFixed(6);
                            const lon = pos.coords.longitude.toFixed(6);
                            document.getElementById(targetId).value = `${lat},${lon}`;
                        }, function(err) {
                            alert('Tidak bisa mengambil lokasi: ' + err.message);
                        });
                    } else {
                        alert('Geolocation tidak didukung di perangkat ini.');
                    }
                }
            </script>
        </x-slot>
    </x-app-layout>
@endsection
