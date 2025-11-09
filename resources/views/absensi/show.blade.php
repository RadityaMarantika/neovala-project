@extends('layouts.base')

@section('content')
    <x-app-layout>

        {{-- Hero Section --}}
        <div class="card border-0 shadow-sm mb-4 text-white hero-card">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="fas fa-calendar-check me-2"></i> Check Detail Absent
                </h5>
                <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm rounded-pill px-3 py-2 mt-2 mt-md-0">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="container-fluid px-3">
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- ===== GRID 2 KOLOM (BOOTSTRAP) ===== --}}
                    <div class="row g-4">
                        {{-- =================== KOLOM KIRI: MASUK =================== --}}
                        <div class="col-md-6">
                            <h5 class="fw-bold text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i> Absensi Masuk
                            </h5>

                            <div class="mb-3">
                                <label class="text-muted small mb-1">Karyawan</label>
                                <p class="fw-semibold">{{ $absensi->karyawan->nama_lengkap }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small mb-1">Shift</label>
                                <p class="fw-semibold">{{ $absensi->shift->kode_shift }} ({{ $absensi->shift->lokasi }})</p>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small mb-1">Waktu Masuk</label>
                                <p class="fw-semibold">{{ $absensi->waktu_masuk?->format('d-m-Y H:i') ?? '-' }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted small mb-1">Status Masuk</label><br>
                                <span
                                    class="badge 
                                @switch($absensi->status_absen_masuk)
                                    @case('Masuk') bg-success @break
                                    @case('Telat') bg-warning text-dark @break
                                    @case('Alfa') bg-danger @break
                                    @default bg-secondary
                                @endswitch">
                                    {{ $absensi->status_absen_masuk ?? '-' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small mb-1">Selfie Masuk</label><br>
                                @if ($absensi->foto_selfi_masuk)
                                    <img src="{{ asset('storage/' . $absensi->foto_selfi_masuk) }}"
                                        class="img-fluid rounded shadow-sm border" style="max-height: 250px;">
                                @else
                                    <p class="text-muted small fst-italic">Tidak ada foto</p>
                                @endif
                            </div>

                            <div>
                                <label class="text-muted small mb-1">Live Location Masuk</label><br>
                                @if ($absensi->share_live_location_masuk)
                                    <a href="{{ $absensi->share_live_location_masuk }}" target="_blank"
                                        class="text-primary small">
                                        <i class="fas fa-map-marker-alt me-1"></i> Lihat Lokasi
                                    </a>
                                @else
                                    <p class="text-muted small fst-italic">Tidak ada lokasi</p>
                                @endif
                            </div>
                        </div>

                        {{-- =================== KOLOM KANAN: PULANG =================== --}}
                        <div class="col-md-6">
                            <h5 class="fw-bold text-danger border-bottom pb-2 mb-3">
                                <i class="fas fa-sign-out-alt me-2"></i> Absensi Pulang
                            </h5>

                            <div class="mb-3">
                                <label class="text-muted small mb-1">Waktu Pulang</label>
                                <p class="fw-semibold">{{ $absensi->waktu_pulang?->format('d-m-Y H:i') ?? '-' }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted small mb-1">Status Pulang</label><br>
                                <span
                                    class="badge 
                                @switch($absensi->status_absen_pulang)
                                    @case('Tepat Waktu') bg-success @break
                                    @case('Telat') bg-warning text-dark @break
                                    @case('Tidak Absen Pulang') bg-danger @break
                                    @default bg-secondary
                                @endswitch">
                                    {{ $absensi->status_absen_pulang ?? '-' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted small mb-1">Selfie Pulang</label><br>
                                @if ($absensi->foto_selfi_pulang)
                                    <img src="{{ asset('storage/' . $absensi->foto_selfi_pulang) }}"
                                        class="img-fluid rounded shadow-sm border" style="max-height: 250px;">
                                @else
                                    <p class="text-muted small fst-italic">Tidak ada foto</p>
                                @endif
                            </div>

                            <div>
                                <label class="text-muted small mb-1">Live Location Pulang</label><br>
                                @if ($absensi->share_live_location_pulang)
                                    <a href="{{ $absensi->share_live_location_pulang }}" target="_blank"
                                        class="text-primary small">
                                        <i class="fas fa-map-marker-alt me-1"></i> Lihat Lokasi
                                    </a>
                                @else
                                    <p class="text-muted small fst-italic">Tidak ada lokasi</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </x-app-layout>
@endsection
