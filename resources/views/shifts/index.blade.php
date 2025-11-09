@extends('layouts.base')

@section('content')
    <x-app-layout>

        {{-- HERO CARD --}}
        <div class="card border-0 shadow-sm mb-5 hero-card text-white">
            <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                    Management Shift
                </h5>

                <a href="{{ route('layout-menus.hr') }}"
                    class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                    style="transition: all 0.3s ease;">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="">
            {{-- ================= ALERT SECTION ================= --}}
            @if (session('success'))
                <div class="alert alert-success shadow-sm mb-4">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger shadow-sm mb-4">{{ session('error') }}</div>
            @endif

            {{-- ================= MAIN CARD ================= --}}
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- ================= FILTER SECTION ================= --}}
                    <div class="flex flex-wrap items-center justify-between mb-5 gap-3">
                        {{-- === FILTER LOKASI === --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-semibold text-gray-700 mr-2">Filter Lokasi:</span>

                            {{-- Tombol Semua Lokasi --}}
                            <a href="{{ route('shifts.index', array_filter(['tanggal' => $tanggalDipilih])) }}"
                                class="px-3 py-1.5 rounded-full text-sm font-medium border transition
                           {{ !$lokasiDipilih ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                Semua Lokasi
                            </a>

                            {{-- Tombol Lokasi Dinamis --}}
                            @foreach ($lokasiList as $lokasi)
                                <a href="{{ route('shifts.index', array_filter(['lokasi' => $lokasi, 'tanggal' => $tanggalDipilih])) }}"
                                    class="px-3 py-1.5 rounded-full text-sm font-medium border transition
                               {{ $lokasiDipilih === $lokasi ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                                    {{ $lokasi }}
                                </a>
                            @endforeach
                        </div>

                        {{-- === FILTER TANGGAL === --}}
                        <form method="GET" action="{{ route('shifts.index') }}" class="flex items-center gap-2">
                            {{-- Pertahankan lokasi --}}
                            @if ($lokasiDipilih)
                                <input type="hidden" name="lokasi" value="{{ $lokasiDipilih }}">
                            @endif

                            <input type="date" name="tanggal" value="{{ $tanggalDipilih }}"
                                class="form-control text-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" />

                            <button type="submit"
                                class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>

                            {{-- Tombol reset filter tanggal --}}
                            @if ($tanggalDipilih)
                                <a href="{{ route('shifts.index', array_filter(['lokasi' => $lokasiDipilih])) }}"
                                    class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                                    title="Reset tanggal">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    @php
                        // Grup berdasarkan tanggal
                        $groupedShifts = $shifts->groupBy(
                            fn($s) => \Carbon\Carbon::parse($s->jadwal_tanggal)->format('Y-m-d'),
                        );
                    @endphp

                    {{-- ================= DATA TABEL SHIFT ================= --}}
                    <div class="space-y-6 max-h-[75vh] overflow-y-auto pr-2">
                        @forelse ($groupedShifts as $tanggal => $shiftGroup)
                            <div class="border rounded-3xl shadow-sm bg-white">
                                {{-- Header Tanggal --}}
                                <div class="px-4 py-3 border-b bg-gray-50 rounded-t-3xl flex justify-between items-center">
                                    <h5 class="font-semibold text-gray-800 mb-0 flex items-center gap-2">
                                        <i class="bi bi-calendar3 text-blue-500"></i>
                                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                                    </h5>
                                    <span class="text-sm text-gray-500">{{ $shiftGroup->count() }} Shift</span>
                                </div>

                                {{-- Table per Tanggal --}}
                                <div class="overflow-x-auto">
                                    <table class="table table-hover align-middle mb-0 w-full">
                                        <thead class="table-light text-sm text-gray-600">
                                            <tr>
                                                <th class="px-3 py-2 text-left">#</th>
                                                <th class="px-3 py-2 text-left">Kode</th>
                                                <th class="px-3 py-2 text-left">Masuk</th>
                                                <th class="px-3 py-2 text-left">Pulang</th>
                                                <th class="px-3 py-2 text-left">Lokasi</th>
                                                <th class="px-3 py-2 text-center">Karyawan</th>
                                                <th class="px-3 py-2 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shiftGroup as $shift)
                                                <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                                                    <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                                    <td class="px-3 py-2 font-medium text-gray-800">
                                                        {{ $shift->kode_shift }}</td>
                                                    <td class="px-3 py-2">
                                                        {{ \Str::of($shift->jam_masuk_kerja)->substr(0, 5) }}</td>
                                                    <td class="px-3 py-2">
                                                        {{ \Str::of($shift->jam_pulang_kerja)->substr(0, 5) }}</td>
                                                    <td class="px-3 py-2">{{ $shift->lokasi }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        <span
                                                            class="inline-flex items-center justify-center text-sm bg-blue-100 text-blue-700 rounded-full px-3 py-1">
                                                            {{ $shift->karyawans_count }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-center space-x-1">
                                                        <a href="{{ route('shifts.edit', $shift) }}"
                                                            class="px-3 py-1 text-xs bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('shifts.destroy', $shift) }}" method="POST"
                                                            class="inline"
                                                            onsubmit="return confirm('Hapus shift {{ $shift->kode_shift }}?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="px-3 py-1 text-xs bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-500 border rounded-2xl bg-gray-50">
                                <i class="bi bi-inbox me-1"></i> Belum ada shift yang digenerate.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
