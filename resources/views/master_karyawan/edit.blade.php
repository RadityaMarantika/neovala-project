@extends('layouts.base')

@section('content')

    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-base text-gray-800">Update Data Karyawan</h2>
                <a href="{{ route('master_karyawan.index') }}"
                    class="bg-gray-500 text-base rounded-md text-white px-3 py-2 hover:bg-gray-700">
                    ← Back
                </a>
            </div>
        </x-slot>

        <div class="py-6">
            <div class="max-w-lg mx-auto px-4">
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

                    <form action="{{ route('master_karyawan.update', $master_karyawan->id) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nama_lengkap" class="block text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                value="{{ old('nama_lengkap', $master_karyawan->nama_lengkap) }}"
                                class="w-full border-gray-300 rounded mt-1 @error('nama_lengkap') border-red-500 @enderror">
                            @error('nama_lengkap')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="nomor_ktp" class="block text-gray-700">Nomor KTP</label>
                            <input type="text" name="nomor_ktp" id="nomor_ktp"
                                value="{{ old('nomor_ktp', $master_karyawan->nomor_ktp) }}"
                                class="w-full border-gray-300 rounded mt-1 @error('nomor_ktp') border-red-500 @enderror">
                            @error('nomor_ktp')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="nomor_telp" class="block text-gray-700">Nomor Telepon</label>
                            <input type="text" name="nomor_telp" id="nomor_telp"
                                value="{{ old('nomor_telp', $master_karyawan->nomor_telp) }}"
                                class="w-full border-gray-300 rounded mt-1 @error('nomor_telp') border-red-500 @enderror">
                            @error('nomor_telp')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border-gray-300 rounded mt-1">
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin', $master_karyawan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $master_karyawan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="tempat_lahir" class="block text-gray-700">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir"
                                value="{{ old('tempat_lahir', $master_karyawan->tempat_lahir) }}"
                                class="w-full border-gray-300 rounded mt-1">
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $master_karyawan->tanggal_lahir) }}"
                                class="w-full border-gray-300 rounded mt-1">
                        </div>

                        <div>
                            <label for="status_karyawan" class="block text-gray-700">Status Karyawan</label>
                            <input type="text" name="status_karyawan" id="status_karyawan"
                                value="{{ old('status_karyawan', $master_karyawan->status_karyawan) }}"
                                class="w-full border-gray-300 rounded mt-1">
                        </div>

                        <div>
                            <label for="tanggal_mulai_bekerja" class="block text-gray-700">Tanggal Mulai Bekerja</label>
                            <input type="date" name="tanggal_mulai_bekerja" id="tanggal_mulai_bekerja"
                                value="{{ old('tanggal_mulai_bekerja', $master_karyawan->tanggal_mulai_bekerja) }}"
                                class="w-full border-gray-300 rounded mt-1">
                        </div>

                        <div>
                            <label for="penempatan" class="block text-gray-700">Region</label>
                            <select name="penempatan" id="penempatan" class="w-full border-gray-300 rounded mt-1">
                                <option value="Transpark Juanda"
                                    {{ old('penempatan', $master_karyawan->penempatan) == 'Transpark Juanda' ? 'selected' : '' }}>
                                    Transpark Juanda</option>
                                <option value="Grand Kamala Lagoon"
                                    {{ old('penempatan', $master_karyawan->penempatan) == 'Grand Kamala Lagoon' ? 'selected' : '' }}>
                                    Grand Kamala Lagoon</option>
                                <option value="Ayam Keshwari"
                                    {{ old('penempatan', $master_karyawan->penempatan) == 'Ayam Keshwari' ? 'selected' : '' }}>
                                    Ayam Keshwari</option>
                            </select>
                        </div>

                        <div>
                            <label for="jabatan" class="block text-gray-700">Divisi</label>
                            <input type="text" name="jabatan" id="jabatan"
                                value="{{ old('jabatan', $master_karyawan->jabatan) }}"
                                class="w-full border-gray-300 rounded mt-1">
                        </div>

                        {{--
                    <div>
                        <label for="posisi" class="block text-gray-700">Posisi</label>
                        <input type="text" name="posisi" id="posisi"
                            value="{{ old('posisi', $master_karyawan->posisi) }}"
                            class="w-full border-gray-300 rounded mt-1">
                    </div>
                    --}}

                        <div>
                            <label for="alamat_ktp" class="block text-gray-700">Alamat KTP</label>
                            <textarea name="alamat_ktp" id="alamat_ktp" class="w-full border-gray-300 rounded mt-1">{{ old('alamat_ktp', $master_karyawan->alamat_ktp) }}</textarea>
                        </div>

                        <div>
                            <label for="alamat_domisili" class="block text-gray-700">Alamat Domisili</label>
                            <textarea name="alamat_domisili" id="alamat_domisili" class="w-full border-gray-300 rounded mt-1">{{ old('alamat_domisili', $master_karyawan->alamat_domisili) }}</textarea>
                        </div>



                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                        <a href="{{ route('master_karyawan.index') }}" class="ml-2 text-gray-600">Batal</a>
                    </form>
                </div>
    </x-app-layout>
    <script>
        document.getElementById('nomor_ktp').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    </script>

@endsection
