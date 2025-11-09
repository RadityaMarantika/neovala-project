@extends('layouts.base')

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="text-lg font-semibold text-primary">
                <i class="bi bi-cash-stack me-2 text-success"></i> Laporan Saldo Petty Cash
            </h2>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-sm p-8 border border-gray-100">

                {{-- FILTER FORM --}}
                <form method="GET" class="row g-3 mb-5">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-sm">Dari Tanggal</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-sm">Sampai Tanggal</label>
                        <input type="date" name="tanggal_akhir" class="form-control"
                            value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-sm">Pilih Petty Cash</label>
                        <select name="pettycash_id" class="form-select">
                            <option value="">Semua</option>
                            @foreach ($pettycashes as $p)
                                <option value="{{ $p->id }}" @selected(request('pettycash_id') == $p->id)>
                                    {{ $p->nama_pettycash }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i> Tampilkan
                        </button>
                    </div>
                </form>

                {{-- RINGKASAN --}}
                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div class="bg-green-50 p-4 rounded-xl border border-green-200 text-center">
                        <h6 class="fw-semibold text-green-700 mb-1">Total Top Up</h6>
                        <h3 class="text-green-800 fw-bold">Rp {{ number_format($totalTopup, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-200 text-center">
                        <h6 class="fw-semibold text-yellow-700 mb-1">Total Transfer</h6>
                        <h3 class="text-yellow-800 fw-bold">Rp {{ number_format($totalTransfer, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-200 text-center">
                        <h6 class="fw-semibold text-blue-700 mb-1">Selisih</h6>
                        <h3 class="text-blue-800 fw-bold">
                            Rp {{ number_format($totalTopup - $totalTransfer, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>

                {{-- TABEL LAPORAN --}}
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-sm">
                        <thead class="bg-light text-gray-700">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $t)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('l, d F Y') }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $t->jenis_transaksi === 'topup' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($t->jenis_transaksi) }}
                                        </span>
                                    </td>
                                    <td>{{ $t->asal->nama_pettycash ?? '-' }}</td>
                                    <td>{{ $t->tujuan->nama_pettycash ?? '-' }}</td>
                                    <td>Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                                    <td>{{ $t->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada data transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- TOMBOL CETAK --}}
                <div class="text-end mt-4">
                    <a href="{{ route('transaksi_saldo_pettycash.cetak', request()->all()) }}" target="_blank"
                        class="btn btn-outline-success">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
                    </a>
                </div>

            </div>
        </div>
    </x-app-layout>
@endsection
