@extends('layouts.base')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-base text-gray-800">Daftar Petty Cash</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                
                {{-- Tombol Tambah --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-lg text-gray-700">Transaksi</h3>
                    <a href="{{ route('petty_cash.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded text-sm">+ Tambah</a>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="table-auto border-collapse border border-gray-300 w-full text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-3 py-2">Tanggal</th>
                                <th class="border px-3 py-2">Jenis</th>
                                <th class="border px-3 py-2">Kategori</th>
                                <th class="border px-3 py-2">Sub Kategori</th>
                                <th class="border px-3 py-2">Jumlah</th>
                                <th class="border px-3 py-2">Bukti</th>
                                <th class="border px-3 py-2">Diambil Oleh</th>
                                <th class="border px-3 py-2">Dibuat Oleh</th>
                                <th class="border px-3 py-2">Saldo Berjalan</th>
                                <th class="border px-3 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pettyCashes as $pc)
                                <tr class="border-b">
                                    <td class="border px-3 py-2">{{ $pc->tanggal }}</td>
                                    <td class="border px-3 py-2">
                                        <span class="px-2 py-1 rounded text-xs font-semibold 
                                            {{ $pc->jenis == 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($pc->jenis) }}
                                        </span>
                                    </td>
                                    <td class="border px-3 py-2">{{ $pc->kategori }}</td>
                                    <td class="border px-3 py-2">{{ $pc->subkategori }}</td>
                                    <td class="border px-3 py-2 text-right">Rp {{ number_format($pc->jumlah, 0, ',', '.') }}</td>
                                    <td class="border px-3 py-2">
                                        @if($pc->upload_bukti)
                                            <a href="{{ Storage::url($pc->upload_bukti) }}" target="_blank" class="text-blue-600">Lihat</a>
                                        @endif
                                    </td>
                                    <td class="border px-3 py-2">{{ $pc->karyawan->nama_lengkap ?? '-' }}</td>
                                    <td class="border px-3 py-2">{{ $pc->createdBy->name ?? '-' }}</td>
                                    <td class="border px-3 py-2 text-right">Rp {{ number_format($pc->saldo, 0, ',', '.') }}</td>
                                    <td class="border px-3 py-2 text-center">
                                        <a href="{{ route('petty_cash.edit', $pc->id) }}" class="text-blue-600 text-sm">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500 py-4">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
@endsection
