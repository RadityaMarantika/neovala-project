@extends('layouts.base')

@section('content')
<x-app-layout>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800">
                Work Order / Show
            </h2>
            <a href="{{ route('orders.index') }}" class="bg-blue-500 text-sm rounded-md text-white px-3 py-2 hover:bg-blue-700">
                ← Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
            {{-- Judul WO --}}
            <div class="mb-6 text-center"> 
                <h2 class="text-2xl font-bold">Detail Work Order</h2>
                <p class="text-lg text-gray-600">
                    Kode WO: <span class="font-semibold">{{ $order->kode_wo }}</span> |
                    Tanggal WO: <span class="font-semibold">{{ \Carbon\Carbon::parse($order->tanggal_wo)->translatedFormat('d F Y') }}</span>
                </p>
            </div>

            <!-- Informasi Utama -->
            <div class="grid md:grid-cols-2 gap-6 text-sm">
                <table class="w-full text-left border border-gray-200 rounded">
                    <tbody>
                        <tr><th class="bg-gray-100 px-4 py-2">Customer</th><td class="px-4 py-2">{{ $order->customer->company_name }}</td></tr>
                        <tr><th class="bg-gray-100 px-4 py-2">Muatan</th><td class="px-4 py-2">{{ $order->muatan->model_muatan }} ({{ $order->muatan->jenis_muatan }})</td></tr>
                        <tr><th class="bg-gray-100 px-4 py-2">Serial Number</th><td class="px-4 py-2">{{ $order->serial_number }}</td></tr>
                        <tr><th class="bg-gray-100 px-4 py-2">Lokasi Muat</th><td class="px-4 py-2">{{ $order->lokasi_muat }}</td></tr>
                        <tr><th class="bg-gray-100 px-4 py-2">Lokasi Bongkar</th><td class="px-4 py-2">{{ $order->lokasi_bongkar }}</td></tr>
                    </tbody>
                </table>

                <table class="w-full text-left border border-gray-200 rounded">
                    <tbody>
                        <tr><th class="bg-gray-100 px-4 py-2">Kode Faktur PPN</th><td class="px-4 py-2">{{ $order->kode_ppn }}</td></tr>
                        <tr><th class="bg-gray-100 px-4 py-2">Status WO</th>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                    {{ $order->status_wo === 'Cancelled' ? 'bg-red-200 text-red-800 border border-red-400' : 
                                    ($order->status_wo === 'Close' ? 'bg-green-200 text-green-800 border border-green-400' : 'bg-yellow-200 text-yellow-800 border border-yellow-400') }}">
                                    {{ $order->status_wo }}
                                </span>
                            </td>
                        </tr>
                        <tr><th class="bg-gray-100 px-4 py-2">Status Dokumen</th>
                            <td class="px-4 py-2">
                                @php
                                    $highlighted = ['Dokumen Belum Kembali', 'Dokumen Hilang', 'Kurang PO', 'Kurang Polis Asuransi', 'Kurang Surat Jalan', 'Kurang Tanda Tangan Penerima'];
                                    $badgeClass = in_array($order->status_dokumen, $highlighted) 
                                        ? 'bg-yellow-200 border border-yellow-500 text-yellow-800' 
                                        : 'bg-green-200 text-green-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold whitespace-nowrap {{ $badgeClass }}">
                                    {{ $order->status_dokumen }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Garis -->
            <hr class="my-6 border-t border-gray-300">

            <!-- Financial Summary -->
            <div class="text-sm">
                <h2 class="text-lg font-semibold mb-3 text-gray-800">Financial Summary</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <table class="w-full text-left border border-gray-200 rounded">
                        <tbody>
                            <tr><th class="bg-gray-100 px-4 py-2">Nilai Tagihan</th><td class="px-4 py-2">{{ number_format($order->nilai_tagihan, 0, ',', '.') }}</td></tr>
                            <tr><th class="bg-gray-100 px-4 py-2">PPN</th><td class="px-4 py-2">{{ number_format($order->ppn, 0, ',', '.') }}</td></tr>
                            <tr><th class="bg-gray-100 px-4 py-2">Total Tagihan</th><td class="px-4 py-2">{{ number_format($order->total_tagihan, 0, ',', '.') }}</td></tr>
                        </tbody>
                    </table>

                    <table class="w-full text-left border border-gray-200 rounded">
                        <tbody>
                            <tr><th class="bg-gray-100 px-4 py-2">Nilai Unit</th><td class="px-4 py-2">{{ number_format($order->nilai_unit, 0, ',', '.') }}</td></tr>
                            <tr><th class="bg-gray-100 px-4 py-2">Rate</th><td class="px-4 py-2">{{ number_format($order->rate_asuransi, 0, ',', '.') }}</td></tr>
                            <tr><th class="bg-gray-100 px-4 py-2">Adm</th><td class="px-4 py-2">{{ number_format($order->adm_asuransi, 0, ',', '.') }}</td></tr>
                            <tr><th class="bg-gray-100 px-4 py-2">Tagihan Asuransi</th><td class="px-4 py-2">{{ number_format($order->tagihan_asuransi, 0, ',', '.') }}</td></tr>
                        </tbody>
                    </table>

                    <table class="w-full text-left border border-gray-200 rounded">
                        <tbody>
                            <tr><th class="bg-gray-100 px-4 py-2">PPh 23</th><td class="px-4 py-2">{{ number_format($order->pph23, 0, ',', '.') }}</td></tr>
                            <tr><th class="bg-gray-100 px-4 py-2">Nilai Pembayaran</th><td class="px-4 py-2">{{ number_format($order->nilai_pembayaran, 0, ',', '.') }}</td></tr>
                            <tr><th class="bg-gray-100 px-4 py-2">Profit</th><td class="px-4 py-2 font-bold text-green-700">{{ number_format($order->profit, 0, ',', '.') }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Biaya Total Keseluruhan 
            <div class="grid grid-cols-3 md:grid-cols-4 gap-4 text-gray-800">
                <div>
                </div>
                <div>
                </div>
                <div>
                </div>
                
                <div class="bg-gray-900 text-white p-4 rounded-lg shadow">
                    <p class="text-gray-300 text-sm">Total Profit </p>
                    <p class="text-lg font-bold">{{ number_format($order->profit, 0, ',', '.') }}</p>
                </div>
                -->
            </div>
        </div>
    </div>
</x-app-layout>
@endsection


