@extends('layouts.base')

@section('content')
    <x-app-layout>
        <div class="container-fluid px-3 px-md-4 py-4">

            {{-- HERO CARD HEADER --}}
            <div class="card border-0 shadow-sm mb-3 hero-card bg-primary text-white rounded-3">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center p-4">
                    <h5 class="fw-bold mb-2 mb-sm-0 d-flex align-items-center">
                        <i class="fas fa-calendar-check me-2"></i> Check Absent Shift
                    </h5>

                    <a  href="{{ route('layout-menus.karyawan') }}"
                        class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                        style="transition: all 0.3s ease;">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>

            {{-- FILTER BAR --}}
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-body py-3 px-4">
                    <form method="GET" class="row gy-2 gx-2 align-items-center">
                        <div class="col-12 col-md-auto">
                            <label for="tanggal" class="form-label mb-1 text-muted small fw-semibold">Tanggal Absen</label>
                            <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}"
                                class="form-control form-control-sm text-sm rounded-3 shadow-sm" />
                        </div>

                        <div class="col-auto mt-3 mt-md-4">
                            <button type="submit"
                                class="btn btn-primary btn-sm fw-semibold d-flex align-items-center gap-1 shadow-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>

                        <div class="col-auto mt-3 mt-md-4">
                            <a href="{{ route('absensi.index') }}"
                                class="btn btn-light btn-sm fw-semibold d-flex align-items-center gap-1 shadow-sm border">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ALERT SECTION --}}
            @if (session('success'))
                <div class="alert alert-success shadow-sm">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger shadow-sm">
                    <i class="fas fa-times-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            {{-- MAIN TABLE CARD --}}
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-3 p-md-4">

                    {{-- TABLE WRAPPER --}}
                    <div class="table-responsive" style="max-height: 75vh; overflow-x: auto;">
                        <table class="table table-hover align-middle mb-0 table-sm text-sm" style="font-size: 12px;">
                            <thead class="table-light">
                                <tr class="text-center text-nowrap">
                                    <th class="px-3 py-2">Tanggal</th>
                                    <th class="px-3 py-2">Karyawan</th>
                                    <th class="px-3 py-2">Shift</th>
                                    <th class="px-3 py-2">Masuk</th>
                                    <th class="px-3 py-2">Pulang</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absensis as $a)
                                    <tr class="align-middle">
                                        <td class="text-center fw-semibold">{{ $a->shift->jadwal_tanggal->format('d-m-Y') }}
                                        </td>
                                        <td class="text-center text-truncate" style="max-width: 140px;">
                                            {{ $a->karyawan->nama_lengkap ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="fw-semibold">{{ $a->shift->kode_shift }}</div>
                                            <small class="text-muted">
                                                {{ substr($a->shift->jam_masuk_kerja, 0, 5) }} -
                                                {{ substr($a->shift->jam_pulang_kerja, 0, 5) }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            {{ $a->waktu_masuk?->format('H:i') ?? '-' }}<br>
                                            <small class="text-muted">{{ $a->status_absen_masuk ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            {{ $a->waktu_pulang?->format('H:i') ?? '-' }}<br>
                                            <small class="text-muted">{{ $a->status_absen_pulang ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $isTelat =
                                                    $a->status_absen_masuk == 'Telat' ||
                                                    $a->status_absen_pulang == 'Telat';
                                                $isAlfa =
                                                    $a->status_absen_masuk == 'Alfa' ||
                                                    $a->status_absen_pulang == 'Tidak Absen Pulang';
                                            @endphp
                                            <span
                                                class="badge px-2 py-1 rounded-pill
                                        @if ($isTelat) bg-warning text-dark
                                        @elseif($isAlfa) bg-danger text-white
                                        @else bg-success text-white @endif">
                                                {{ $a->status_absen_masuk ?? '-' }} / {{ $a->status_absen_pulang ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('absensi.show', $a->id) }}"
                                                class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1 shadow-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-info-circle me-1"></i> Belum ada data absen.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if ($absensis->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $absensis->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
