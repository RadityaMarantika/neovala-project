@extends('layouts.base')

@section('content')

    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-base text-gray-800">Tambah Data Karyawan</h2>
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

                    <form action="{{ route('master_karyawan.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Nama Lengkap -->
                            <div>
                                <label for="nama_lengkap" class="block text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                    value="{{ old('nama_lengkap') }}" pattern="[A-Za-z\s]+"
                                    title="Hanya huruf dan spasi yang diperbolehkan" required
                                    class="w-full border-gray-300 rounded mt-1">
                                @error('nama_lengkap')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor KTP -->
                            <div>
                                <label for="nomor_ktp" class="block text-gray-700">Nomor KTP</label>
                                <input type="text" name="nomor_ktp" id="nomor_ktp" value="{{ old('nomor_ktp') }}"
                                    pattern="\d{16}" maxlength="16" title="Harus 16 digit angka" required
                                    class="w-full border-gray-300 rounded mt-1">
                                @error('nomor_ktp')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="nomor_telp" class="block text-gray-700">Nomor Telepon</label>
                                <input type="text" name="nomor_telp" id="nomor_telp" value="{{ old('nomor_telp') }}"
                                    pattern="^(?:\+62|62|0|https:\/\/wa\.me\/62)\d{9,15}$"
                                    title="Gunakan format 08..., 62..., +62..., atau https://wa.me/62..." required
                                    class="w-full border-gray-300 rounded mt-1">
                                @error('nomor_telp')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="jenis_kelamin" class="block text-gray-700">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="w-full border-gray-300 rounded mt-1 @error('jenis_kelamin') border-red-500 @enderror">
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>
                                        Laki-Laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label for="tempat_lahir" class="block text-gray-700">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}"
                                    class="w-full border-gray-300 rounded mt-1 @error('tempat_lahir') border-red-500 @enderror">
                                @error('tempat_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tanggal_lahir" class="block text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}"
                                    class="w-full border-gray-300 rounded mt-1 @error('tanggal_lahir') border-red-500 @enderror">
                                @error('tanggal_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Karyawan -->
                            <div>
                                <label for="status_karyawan" class="block text-gray-700">Status Karyawan</label>
                                <select name="status_karyawan" id="status_karyawan"
                                    class="w-full border-gray-300 rounded mt-1 @error('status_karyawan') border-red-500 @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Aktif" {{ old('status_karyawan') == 'Aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="Tidak Aktif"
                                        {{ old('status_karyawan') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                                @error('status_karyawan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Mulai Bekerja -->
                            <div>
                                <label for="tanggal_mulai_bekerja" class="block text-gray-700">Tanggal Mulai Bekerja</label>
                                <input type="date" name="tanggal_mulai_bekerja" id="tanggal_mulai_bekerja"
                                    value="{{ old('tanggal_mulai_bekerja') }}"
                                    class="w-full border-gray-300 rounded mt-1 @error('tanggal_mulai_bekerja') border-red-500 @enderror">
                                @error('tanggal_mulai_bekerja')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Penempatan -->
                            <div>
                                <label for="penempatan" class="block text-gray-700">Region</label>
                                <select name="penempatan" id="penempatan"
                                    class="w-full border-gray-300 rounded mt-1 @error('penempatan') border-red-500 @enderror">
                                    <option value="">-- Pilih Region --</option>
                                    <option value="Transpark Juanda"
                                        {{ old('penempatan') == 'Transpark Juanda' ? 'selected' : '' }}>Transpark Juanda
                                    </option>
                                    <option value="Grand Kamala Lagoon"
                                        {{ old('penempatan') == 'Grand Kamala Lagoon' ? 'selected' : '' }}>Grand Kamala
                                        Lagoon</option>
                                    <option value="Ayam Keshwari"
                                        {{ old('penempatan') == 'Ayam Keshwari' ? 'selected' : '' }}>Ayam Keshwari</option>
                                </select>
                                @error('penempatan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jabatan -->
                            <div>
                                <label for="jabatan" class="block text-gray-700">Divisi</label>
                                <select name="jabatan" id="jabatan"
                                    class="w-full border-gray-300 rounded mt-1 @error('jabatan') border-red-500 @enderror">
                                    <option value="">-- Pilih Divisi --</option>
                                    <option value="Staff Housekeeping"
                                        {{ old('jabatan') == 'Staff Housekeeping' ? 'selected' : '' }}>Staff Housekeeping
                                    </option>
                                    <option value="Staff Finance"
                                        {{ old('jabatan') == 'Staff Finance' ? 'selected' : '' }}>Staff Finance</option>
                                    <option value="Staff Kitchen"
                                        {{ old('jabatan') == 'Staff Kitchen' ? 'selected' : '' }}>Staff Kitchen</option>
                                    <option value="Staff Admin" {{ old('jabatan') == 'Staff Admin' ? 'selected' : '' }}>
                                        Staff Admin</option>
                                    <option value="Staff IT" {{ old('jabatan') == 'Staff IT' ? 'selected' : '' }}>Staff IT
                                    </option>
                                </select>
                                @error('jabatan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Posisi 
                        <div>
                            <label for="posisi" class="block text-gray-700">Posisi</label>
                            <select name="posisi" id="posisi"
                                class="w-full border-gray-300 rounded mt-1 @error('posisi') border-red-500 @enderror">
                                <option value="">-- Pilih Posisi --</option>
                                <option value="PIC Staff Housekeeping" {{ old('posisi') == 'PIC Staff Housekeeping' ? 'selected' : '' }}>PIC Staff Housekeeping</option>
                                <option value="Junior Staff Housekeeping" {{ old('posisi') == 'Junior Staff Housekeeping' ? 'selected' : '' }}>Junior Staff Housekeeping</option>
                                <option value="Senior Staff Housekeeping" {{ old('posisi') == 'Senior Staff Housekeeping' ? 'selected' : '' }}>Senior Staff Housekeeping</option>
                                <option value="Akuntan" {{ old('posisi') == 'Akuntan' ? 'selected' : '' }}>Akuntan</option>
                                <option value="Analis Keuangan" {{ old('posisi') == 'Analis Keuangan' ? 'selected' : '' }}>Analis Keuangan</option>
                                <option value="PIC Staff Kitchen" {{ old('posisi') == 'PIC Staff Kitchen' ? 'selected' : '' }}>PIC Staff Kitchen</option>
                                <option value="Cook Helper" {{ old('posisi') == 'Cook Helper' ? 'selected' : '' }}>Cook Helper</option>
                                <option value="Chef" {{ old('posisi') == 'Chef' ? 'selected' : '' }}>Chef</option>
                                <option value="Steward" {{ old('posisi') == 'Steward' ? 'selected' : '' }}>Steward</option>
                            </select>
                            @error('posisi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    --}}

                            <!-- Alamat KTP -->
                            <div>
                                <label for="alamat_ktp" class="block text-gray-700">Alamat KTP</label>
                                <textarea name="alamat_ktp" id="alamat_ktp"
                                    class="w-full border-gray-300 rounded mt-1 @error('alamat_ktp') border-red-500 @enderror">{{ old('alamat_ktp') }}</textarea>
                                @error('alamat_ktp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat Domisili -->
                            <div>
                                <label for="alamat_domisili" class="block text-gray-700">Alamat Domisili</label>
                                <textarea name="alamat_domisili" id="alamat_domisili"
                                    class="w-full border-gray-300 rounded mt-1 @error('alamat_domisili') border-red-500 @enderror">{{ old('alamat_domisili') }}</textarea>
                                @error('alamat_domisili')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tombol -->
                            <div class="flex justify-end">
                                <a href="{{ route('master_karyawan.index') }}"
                                    class="px-4 py-2 bg-gray-400 text-white rounded mr-2">Batal</a>
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </x-app-layout>
    <script>
        document.getElementById('nomor_ktp').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    </script>

@endsection
