@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-base text-gray-800">Reporting Absensi Karyawan</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            
             {{-- 🔎 Filter & Tombol Export --}}
                <div class="flex flex-wrap justify-between items-end mb-6">
                    
                    {{-- 🔎 Form Filter Bulan --}}
                    <form action="{{ route('karyawan.reporting') }}" method="GET" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label for="bulan" class="block text-sm font-medium text-gray-700">Pilih Bulan</label>
                            <input type="month" name="bulan" id="bulan" 
                                value="{{ request('bulan', now()->format('Y-m')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                                Tampilkan
                            </button>
                            <a href="{{ route('karyawan.reporting') }}" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                                Reset
                            </a>
                        </div>
                    </form>

                    {{-- 🔽 Tombol Export --}}
                    <div class="flex space-x-3 mt-4 sm:mt-0">
                        <a href="{{ route('karyawan.reporting.excel', ['bulan' => $bulan]) }}" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                            Export Excel
                        </a>
                        <a href="{{ route('karyawan.reporting.pdf', ['bulan' => $bulan]) }}" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
                            Export PDF
                        </a>
                    </div>
                </div>

                {{-- 📊 Tabel --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr class="text-xs font-semibold text-gray-700 text-center">
                                <th class="border p-2">Nama Karyawan</th>
                                <th class="border p-2">Total Absen Masuk</th>
                                <th class="border p-2">Total Absen Pulang</th>
                                <th class="border p-2 text-red-600">Denda Masuk (Telat)</th>
                                <th class="border p-2 text-red-600">Denda Masuk (Alfa)</th>
                                <th class="border p-2 text-red-600">Denda Pulang (Telat)</th>
                                <th class="border p-2 text-red-600">Denda Pulang (Tidak Absen)</th>
                                <th class="border p-2 font-bold text-red-700">Total Denda</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs text-center">
                            @foreach ($reportData as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-2 text-left font-medium">{{ $row['nama'] }}</td>
                                    <td class="border p-2">{{ $row['total_masuk'] }}</td>
                                    <td class="border p-2">{{ $row['total_pulang'] }}</td>
                                    <td class="border p-2 text-right">Rp {{ number_format($row['denda_masuk_telat'], 0, ',', '.') }}</td>
                                    <td class="border p-2 text-right">Rp {{ number_format($row['denda_masuk_alfa'], 0, ',', '.') }}</td>
                                    <td class="border p-2 text-right">Rp {{ number_format($row['denda_pulang_telat'], 0, ',', '.') }}</td>
                                    <td class="border p-2 text-right">Rp {{ number_format($row['denda_pulang_kosong'], 0, ',', '.') }}</td>
                                    <td class="border p-2 font-bold text-red-600 text-right">
                                        Rp {{ number_format($row['total_denda'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
@endsection
