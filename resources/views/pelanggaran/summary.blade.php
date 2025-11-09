@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold text-primary mb-0">Summary Warning Letter</h2>
    </x-slot>

    <div class="py-6">
        <div class="mt-8 bg-white p-6 rounded-xl shadow">
            <h3 class="font-base text-lg"></h3>
            <table class="table-auto w-full text-xs border">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="px-4 py-2 border whitespace-nowrap">No</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Karyawan</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Total Pelanggaran</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Surat Teguran</th>
                        <th class="px-4 py-2 border whitespace-nowrap">SP1</th>
                        <th class="px-4 py-2 border whitespace-nowrap">SP2</th>
                        <th class="px-4 py-2 border whitespace-nowrap">SP3</th>
                        <th class="px-4 py-2 border whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($perKaryawan as $index => $pk)
                    @php
                        $riwayatKaryawan = $riwayat->where('karyawan_id', $pk->karyawan_id);

                        // Cek status tiap surat
                        $cekStatus = function($jenis) use ($riwayatKaryawan) {
                            return $riwayatKaryawan->where('jenis', $jenis)
                                ->where('status_pelanggaran', 'Aktif')
                                ->count() > 0 ? 'Aktif' : 'Tidak Aktif';
                        };
                    @endphp
                    <tr class="text-center">
                        <td class="border px-4 py-2 whitespace-nowrap">{{ $index+1 }}</td>
                        <td class="border px-4 py-2 text-left whitespace-nowrap">{{ $pk->karyawan->nama_lengkap ?? '-' }}</td>
                        <td class="border px-4 py-2 font-bold text-red-600 whitespace-nowrap">{{ $pk->total }}</td>

                        {{-- Surat Teguran --}}
                        <td class="border px-4 py-2 whitespace-nowrap">
                            @if($cekStatus('Surat Teguran') == 'Aktif')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Tidak Aktif</span>
                            @endif
                        </td>

                        {{-- SP1 --}}
                        <td class="border px-4 py-2 whitespace-nowrap">
                            @if($cekStatus('SP1') == 'Aktif')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Tidak Aktif</span>
                            @endif
                        </td>

                        {{-- SP2 --}}
                        <td class="border px-4 py-2 whitespace-nowrap">
                            @if($cekStatus('SP2') == 'Aktif')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Tidak Aktif</span>
                            @endif
                        </td>

                        {{-- SP3 --}}
                        <td class="border px-4 py-2 whitespace-nowrap">
                            @if($cekStatus('SP3') == 'Aktif')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Tidak Aktif</span>
                            @endif
                        </td>

                        <td class="border px-4 py-2 text-center whitespace-nowrap">
                            <button class="text-blue-600 font-semibold"
                                data-toggle="collapse"
                                data-target="#detail-{{ $pk->karyawan_id }}">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>

                    {{-- Detail --}}
                    <tr id="detail-{{ $pk->karyawan_id }}" class="collapse bg-gray-50">
                        <td colspan="8" class="p-4">
                            <h4 class="font-semibold mb-2">Detail Pelanggaran:</h4>
                            <table class="table-auto w-full text-xs border">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="px-2 py-1 border whitespace-nowrap">Jenis</th>
                                        <th class="px-2 py-1 border whitespace-nowrap">Tanggal Mulai</th>
                                        <th class="px-2 py-1 border whitespace-nowrap">Tanggal Selesai</th>
                                        <th class="px-2 py-1 border whitespace-nowrap">Status</th>
                                        <th class="px-2 py-1 border whitespace-nowrap">Keterangan</th>
                                        <th class="px-2 py-1 border whitespace-nowrap">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatKaryawan as $r)
                                        <tr>
                                            <td class="border px-2 py-1 whitespace-nowrap">{{ $r->jenis }}</td>
                                            <td class="border px-2 py-1 whitespace-nowrap">{{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d-m-Y') }}</td>
                                            <td class="border px-2 py-1 whitespace-nowrap">{{ $r->tanggal_selesai ? \Carbon\Carbon::parse($r->tanggal_selesai)->format('d-m-Y') : '-' }}</td>
                                            <td class="border px-2 py-1 whitespace-nowrap">
                                                <span class="px-2 py-1 {{ $r->status_pelanggaran == 'Aktif' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} rounded">
                                                    {{ $r->status_pelanggaran }}
                                                </span>
                                            </td>
                                            <td class="border px-2 py-1 whitespace-nowrap">{{ $r->keterangan }}</td>
                                            <td class="border px-2 py-1">
                                                @if($r->file_surat)
                                                    <a href="{{ route('pelanggaran.viewFile', $r->id) }}" target="_blank" class="text-blue-600">File</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
@endsection
