@extends('layouts.base')

@section('content')
    <div class="container-fluid py-4">

        {{-- HERO CARD --}}
        <div class="card border-0 shadow-sm mb-5 hero-card text-white">
            <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                    Clock In Absent
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

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('absensi.masuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                    <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

                    {{-- Info Shift --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Shift Hari Ini</label>
                        <div class="bg-light border rounded-3 p-3">
                            <div class="text-dark small">
                                <strong>{{ $shift->kode_shift }}</strong> — {{ $shift->lokasi }} <br>
                                {{ $shift->jadwal_tanggal->format('d-m-Y') }} <br>
                                <span class="text-muted">
                                    Jam kerja: {{ substr($shift->jam_masuk_kerja, 0, 5) }} -
                                    {{ substr($shift->jam_pulang_kerja, 0, 5) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Info Karyawan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Nama Karyawan</label>
                        <div class="bg-light border rounded-3 p-3">
                            <span class="text-dark small fw-semibold">{{ $karyawan->nama_lengkap }}</span>
                        </div>
                    </div>

                    {{-- Foto Selfie --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Selfie (Kamera Langsung)</label>
                        <div class="border rounded-3 p-3 bg-light">
                            <input type="file" name="foto_selfi_masuk" accept="image/*" capture="environment"
                                class="form-control form-control-sm" required>
                            <small class="text-muted d-block mt-2">
                                Pastikan wajah terlihat jelas dengan pencahayaan cukup.
                            </small>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Share Live Location</label>
                        <div class="input-group">
                            <input id="locMasuk" type="text" name="share_live_location_masuk"
                                class="form-control form-control-sm" placeholder="Tempel link / koordinat lokasi" required>
                            <button type="button" onclick="getLocation('locMasuk')" class="btn btn-primary btn-sm">
                                <i class="fas fa-location-arrow me-1"></i> Ambil
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2">
                            Klik tombol “Ambil” untuk otomatis isi koordinat lokasi Anda.
                        </small>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="text-end pt-2">
                        <button type="submit" class="btn btn-success btn-sm px-4 shadow-sm rounded-pill fw-semibold">
                            <i class="fas fa-save me-1"></i> Simpan Absen Masuk
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

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
@endsection
