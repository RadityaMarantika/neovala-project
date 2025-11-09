@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-base text-gray-800">
                Detail Karyawan
            </h2>
            <a href="{{ route('master_karyawan.index') }}" 
               class="bg-gray-500 text-sm rounded-md text-white px-3 py-2 hover:bg-gray-700">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-8 space-y-6">
                
                {{-- Info Umum --}}
                <div class="grid grid-cols-2 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-500 text-sm">Nama Lengkap</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->nama_lengkap }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Nomor KTP</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->nomor_ktp }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Nomor Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->nomor_telp }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->jenis_kelamin }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Tempat, Tanggal Lahir</p>
                        <p class="font-semibold text-gray-800">
                            {{ $master_karyawan->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($master_karyawan->tanggal_lahir)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Status Karyawan</p>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ strtolower($master_karyawan->status_karyawan) == 'aktif' 
                                ? 'bg-green-200 text-green-800 border border-green-400' 
                                : 'bg-red-200 text-red-800 border border-red-400' }}">
                            {{ ucfirst($master_karyawan->status_karyawan) }}
                        </span>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="grid grid-cols-2 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-500 text-sm">Alamat KTP</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->alamat_ktp }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Alamat Domisili</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->alamat_domisili }}</p>
                    </div>
                </div>

                {{-- Info Pekerjaan --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Mulai Bekerja</p>
                        <p class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($master_karyawan->tanggal_mulai_bekerja)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Penempatan</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->penempatan }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Jabatan</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->jabatan }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 text-sm">Posisi</p>
                        <p class="font-semibold text-gray-800">{{ $master_karyawan->posisi }}</p>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <a href="{{ route('master_karyawan.edit', $master_karyawan->id) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm shadow">
                        Edit
                    </a>
                    <form action="{{ route('master_karyawan.destroy', $master_karyawan->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm shadow">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
@endsection
