@extends('layouts.base')

@section('content')
    <x-app-layout>

        {{-- ================= HEADER ================= --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-primary">
                    <i class="bi bi-people-fill text-blue-600 me-2"></i>
                    Atur Karyawan Bekerja ({{ $shift->kode_shift }})
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
                    <form action="{{ route('shifts.update', $shift->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-5 align-items-start">

                            {{-- ========== KIRI: DETAIL SHIFT ========== --}}
                            <div class="col-md-6">
                                <h5 class="mb-4 fw-bold text-gray-800">Detail Shift</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Lokasi</label>
                                    <div class="form-control bg-gray-50">
                                        {{ $shift->lokasi ?? '-' }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Kode Shift</label>
                                    <div class="form-control bg-gray-50">
                                        {{ $shift->kode_shift }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal</label>
                                    <div class="form-control bg-gray-50">
                                        {{ \Carbon\Carbon::parse($shift->jadwal_tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Jam Kerja</label>
                                    <div class="form-control bg-gray-50">
                                        {{ $shift->jam_masuk_kerja }} - {{ $shift->jam_pulang_kerja }}
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-4 text-sm text-gray-500">
                                    Terakhir diperbarui:
                                    <span class="text-gray-700 fw-semibold">
                                        {{ $shift->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            {{-- ========== KANAN: PILIH KARYAWAN ========== --}}
                            <div class="col-md-6">
                                @if ($masterShift->status_shift === 'Libur')
                                    <h5 class="mb-4 fw-bold text-gray-800">Pilih Karyawan yang Libur</h5>
                                    <div id="listKaryawan"
                                        class="border border-gray-200 rounded-xl p-4 bg-gray-50 overflow-y-auto"
                                        style="max-height: 360px;">
                                        @forelse ($karyawans as $k)
                                            @php
                                                $isChecked =
                                                    $shift->karyawans
                                                        ->where('id', $k->id)
                                                        ->where('pivot.status', 'libur')
                                                        ->count() > 0;
                                            @endphp
                                            <label
                                                class="flex items-start gap-3 py-2 border-b border-gray-100 last:border-none cursor-pointer hover:bg-gray-100 rounded-md px-2 transition karyawan-item">
                                                <input type="checkbox" name="libur[]" value="{{ $k->id }}"
                                                    class="rounded text-blue-600 focus:ring-blue-500 mt-0.5"
                                                    @checked($isChecked)>
                                                <div>
                                                    <span class="font-semibold text-gray-800 text-sm nama-karyawan">
                                                        {{ $k->nama_lengkap }}
                                                    </span>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $k->jabatan ?? '-' }}
                                                    </p>
                                                </div>
                                            </label>
                                        @empty
                                            <p class="text-sm text-gray-500 italic">Semua karyawan sudah masuk shift hari
                                                ini.</p>
                                        @endforelse
                                    </div>
                                @else
                                    <h5 class="mb-4 fw-bold text-gray-800">Pilih Karyawan yang Bekerja</h5>

                                    {{-- 🔍 Search Bar --}}
                                    <div class="mb-3">
                                        <input type="text" id="searchKaryawan" placeholder="Cari nama karyawan..."
                                            class="form-control border-gray-300 rounded-lg text-sm" />
                                    </div>

                                    {{-- 🧑‍💼 List Karyawan --}}
                                    <div id="listKaryawan"
                                        class="border border-gray-200 rounded-xl p-4 bg-gray-50 overflow-y-auto"
                                        style="max-height: 360px;">
                                        @forelse ($karyawans as $k)
                                            @php
                                                $isChecked =
                                                    $shift->karyawans
                                                        ->where('id', $k->id)
                                                        ->where('pivot.status', 'bekerja')
                                                        ->count() > 0;
                                            @endphp
                                            <label
                                                class="flex items-start gap-3 py-2 border-b border-gray-100 last:border-none cursor-pointer hover:bg-gray-100 rounded-md px-2 transition karyawan-item">
                                                <input type="checkbox" name="bekerja[]" value="{{ $k->id }}"
                                                    class="rounded text-blue-600 focus:ring-blue-500 mt-0.5"
                                                    @checked($isChecked)>
                                                <div>
                                                    <span class="font-semibold text-gray-800 text-sm nama-karyawan">
                                                        {{ $k->nama_lengkap }}
                                                    </span>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $k->jabatan ?? '-' }}
                                                    </p>
                                                </div>
                                            </label>
                                        @empty
                                            <p class="text-sm text-gray-500 italic">Semua karyawan sudah masuk shift hari
                                                ini.</p>
                                        @endforelse
                                    </div>
                                @endif

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('shifts.index') }}" class="btn btn-light">Batal</a>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>


                            {{-- ============ SCRIPT FILTERING ============ --}}
                            <script>
                                document.getElementById('searchKaryawan').addEventListener('input', function() {
                                    const filter = this.value.toLowerCase();
                                    const items = document.querySelectorAll('.karyawan-item');

                                    items.forEach(item => {
                                        const nama = item.querySelector('.nama-karyawan').textContent.toLowerCase();
                                        item.style.display = nama.includes(filter) ? '' : 'none';
                                    });
                                });
                            </script>

                        </div> {{-- end row --}}
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
