@extends('layouts.base')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-base text-gray-800">Edit Petty Cash</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('petty_cash.update', $pettyCash->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $pettyCash->tanggal }}" class="w-full border rounded p-2" required>
                        </div>

                        <div>
                            <label class="block text-sm">Jenis</label>
                            <select name="jenis" class="w-full border rounded p-2" required>
                                <option value="masuk" {{ $pettyCash->jenis == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="keluar" {{ $pettyCash->jenis == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm">Kategori</label>
                            <input type="text" name="kategori" value="{{ $pettyCash->kategori }}" class="w-full border rounded p-2" required>
                        </div>

                        <div>
                            <label class="block text-sm">Sub Kategori</label>
                            <input type="text" name="subkategori" value="{{ $pettyCash->subkategori }}" class="w-full border rounded p-2" required>
                        </div>

                        <div>
                            <label class="block text-sm">Jumlah</label>
                            <input type="number" step="0.01" name="jumlah" value="{{ $pettyCash->jumlah }}" class="w-full border rounded p-2" required>
                        </div>

                        <div>
                            <label class="block text-sm">Diambil Oleh</label>
                            <select name="diambil_oleh" class="w-full border rounded p-2">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawans as $k)
                                    <option value="{{ $k->id }}" {{ $pettyCash->diambil_oleh == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="w-full border rounded p-2">{{ $pettyCash->keterangan }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
