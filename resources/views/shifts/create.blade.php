@extends('layouts.base')

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-base text-gray-800">Buat Shift</h2>
                <a href="{{ route('shifts.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">Kembali</a>
            </div>
        </x-slot>

        <div class="py-6">
            <div class="max-w-3xl mx-auto px-4">
                <div class="bg-white shadow rounded-lg p-6">
                    @if ($errors->any())
                        <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('shifts.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700">Kode Shift</label>
                                <input type="text" name="kode_shift" id="kode_shift"
                                    class="w-full border-gray-300 rounded mt-1" placeholder="PG01 / SG02" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700">Pilih Master Shift</label>
                                <select name="master_shift_id" id="master_shift_id"
                                    class="w-full border-gray-300 rounded mt-1">
                                    <option value="">-- Pilih Master Shift --</option>
                                    @foreach ($masterShifts as $ms)
                                        <option value="{{ $ms->id }}" data-kode="{{ $ms->buat_kode_shift }}"
                                            data-jam-masuk="{{ $ms->jam_masuk }}" data-jam-pulang="{{ $ms->jam_pulang }}"
                                            data-jenis="{{ $ms->jenis_shift }}">
                                            {{ $ms->buat_kode_shift }} — {{ $ms->jenis_shift }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700">Jenis</label>
                                <input type="text" name="jenis" id="jenis_shift"
                                    class="w-full border-gray-300 rounded mt-1" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700">Jam Masuk</label>
                                <input type="time" name="jam_masuk_kerja" id="jam_masuk_kerja"
                                    class="w-full border-gray-300 rounded mt-1" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700">Jam Pulang</label>
                                <input type="time" name="jam_pulang_kerja" id="jam_pulang_kerja"
                                    class="w-full border-gray-300 rounded mt-1" readonly>
                            </div>

                            <div>
                                <label class="block text-gray-700">Jam Kerja (jam)</label>
                                <input type="number" name="jam_kerja" id="jam_kerja"
                                    class="w-full border-gray-300 rounded mt-1" readonly>
                            </div>

                            <script>
                                document.getElementById('master_shift_id').addEventListener('change', function() {
                                    const selected = this.options[this.selectedIndex];
                                    if (!selected.value) return;

                                    const kode = selected.dataset.kode;
                                    const jamMasuk = selected.dataset.jamMasuk;
                                    const jamPulang = selected.dataset.jamPulang;
                                    const jenis = selected.dataset.jenis;

                                    document.getElementById('kode_shift').value = kode;
                                    document.getElementById('jenis_shift').value = jenis;
                                    document.getElementById('jam_masuk_kerja').value = jamMasuk;
                                    document.getElementById('jam_pulang_kerja').value = jamPulang;

                                    // Hitung durasi jam kerja
                                    if (jamMasuk && jamPulang) {
                                        let masuk = jamMasuk.split(':');
                                        let pulang = jamPulang.split(':');
                                        let jamMasukNum = parseInt(masuk[0]) + parseInt(masuk[1]) / 60;
                                        let jamPulangNum = parseInt(pulang[0]) + parseInt(pulang[1]) / 60;
                                        let durasi = jamPulangNum - jamMasukNum;
                                        if (durasi <= 0) durasi += 24; // handle shift malam
                                        document.getElementById('jam_kerja').value = durasi;
                                    }
                                });
                            </script>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700">Tanggal</label>
                                <input type="date" name="jadwal_tanggal" class="w-full border-gray-300 rounded mt-1">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700">Lokasi</label>
                                <select name="lokasi" class="w-full border-gray-300 rounded mt-1">
                                    <option value="">-- Pilih --</option>
                                    <option value="Transpark Juanda">Transpark Juanda</option>
                                    <option value="Grand Kamala Lagoon">Grand Kamala Lagoon</option>
                                    <option value="Ayam Keshwari">Ayam Keshwari</option>

                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 mb-2">Pilih Karyawan</label>
                                <div class="grid grid-cols-2 gap-2 max-h-64 overflow-y-auto border p-2 rounded">
                                    @foreach ($karyawans as $k)
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" name="karyawan_ids[]" value="{{ $k->id }}"
                                                class="form-checkbox">
                                            <span>{{ $k->nama_lengkap }} — {{ $k->jabatan }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <p class="text-[11px] text-gray-500 mt-1">Centang karyawan yang ingin dijadwalkan di shift
                                    ini.</p>
                            </div>

                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('shifts.index') }}"
                                class="px-3 py-2 rounded bg-gray-400 text-white text-xs">Batal</a>
                            <button class="px-3 py-2 rounded bg-blue-600 text-white text-xs">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
