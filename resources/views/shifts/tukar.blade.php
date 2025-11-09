@extends('layouts.base')

@section('content')
<x-app-layout>
    <div class="container py-4">
        

    {{-- HERO CARD --}}
    <div class="card border-0 shadow-sm mb-5 hero-card text-white">
        <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                Swap Shift
            </h5>

            <a href="{{ url()->previous() }}"
                class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                style="transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
        <div class="card border-0 shadow-lg rounded-4 p-4">
            <h4 class="fw-bold mb-3 text-primary">Tukar Shift</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('tukar-shift.store') }}" method="POST">
                @csrf

                {{-- ================== SHIFT SAYA ================== --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Shift Kamu</label>
                    <select name="shift_saya" class="form-select select2" required>
                        <option value="">-- Pilih Shift --</option>
                        @foreach ($shiftsSaya as $saya)
                            <option value="{{ $saya->id }}">
                                {{ $saya->shift->kode_shift ?? '-' }} |
                                {{ \Carbon\Carbon::parse($saya->shift->jadwal_tanggal)->translatedFormat('l, d F Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ================== SHIFT TEMAN ================== --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Karyawan & Shift yang Ingin Ditukar</label>
                    <select name="shift_teman" class="form-select select2" required>
                        <option value="">-- Pilih Karyawan dan Shift --</option>
                        @foreach ($shiftsLain as $lain)
                            <option value="{{ $lain->id }}">
                                {{ $lain->karyawan->nama_lengkap ?? $lain->karyawan->nama }} -
                                {{ $lain->shift->kode_shift ?? '-' }}
                                |{{ \Carbon\Carbon::parse($lain->shift->jadwal_tanggal)->translatedFormat('l, d F Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary rounded-3 px-4">Tukar Shift</button>
            </form>
        </div>
    </div>

    {{-- Inisialisasi Select2 --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Cari atau pilih data...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    </x-app-layout>
@endsection
