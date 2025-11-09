@extends('layouts.base')

@section('content')
    <x-app-layout>

        {{-- ================= HEADER ================= --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-primary">
                    <i class="bi bi-calendar2-week text-blue-600 me-2"></i>
                    Generate Shift Karyawan (Periode)
                </h2>
                <a href="{{ route('shifts.index') }}"
                    class="inline-flex items-center px-3 py-2 text-sm bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </x-slot>

        {{-- ================= BODY ================= --}}
        <div class="py-8">
            <div class="max-w-6xl mx-auto px-6">
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">

                    {{-- ================= NOTIFIKASI ERROR ================= --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-md bg-red-50 border border-red-200 p-4">
                            <div class="font-semibold text-red-700 mb-2">Terjadi kesalahan input:</div>
                            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ================= FORM ================= --}}
                    <form action="{{ route('shifts.storeGenerate') }}" method="POST">
                        @csrf

                        <div class="row g-5 align-items-start">
                            {{-- ========== KIRI: DETAIL PERIODE ========== --}}
                            <div class="col-md-6">
                                <h5 class="mb-4 fw-bold text-gray-800">Detail Periode</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Lokasi</label>
                                    <select name="lokasi" class="form-select w-full">
                                        <option value="">-- Pilih Lokasi --</option>
                                        <option value="Transpark Juanda">Transpark Juanda</option>
                                        <option value="Grand Kamala Lagoon">Grand Kamala Lagoon</option>
                                        <option value="Ayam Keshwari">Ayam Keshwari</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" class="form-control">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control">
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('shifts.index') }}" class="btn btn-light">Batal</a>
                                    <button type="submit" class="btn btn-primary">Generate Shift</button>
                                </div>
                            </div>

                            {{-- ========== KANAN: PILIH SHIFT ========== --}}
                            <div class="col-md-6">
                                <h5 class="mb-4 fw-bold text-gray-800">Pilih Shift yang Akan Dgenerate</h5>

                                <div class="border border-gray-200 rounded-xl p-4 bg-gray-50 overflow-y-auto"
                                    style="max-height: 240px;">
                                    @forelse (\App\Models\MasterShift::all() as $mShift)
                                        <label
                                            class="flex items-start gap-3 py-2 border-b border-gray-100 last:border-none cursor-pointer hover:bg-gray-100 rounded-md px-2 transition">
                                            <input type="checkbox" name="shifts[]" value="{{ $mShift->id }}"
                                                class="rounded text-blue-600 focus:ring-blue-500 mt-0.5">
                                            <div>
                                                <span class="font-semibold text-gray-800 text-sm">
                                                    {{ $mShift->buat_kode_shift }}
                                                </span>
                                                <p class="text-xs text-gray-500">
                                                    {{ $mShift->jenis_shift }} • {{ $mShift->jam_masuk }} -
                                                    {{ $mShift->jam_pulang }}
                                                </p>
                                            </div>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-500 italic">Belum ada master shift terdaftar.</p>
                                    @endforelse
                                </div>

                            </div>
                        </div> {{-- end row --}}
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
