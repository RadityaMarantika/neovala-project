@extends('layouts.base')

@section('content')
    <div class="container py-5">
        <div class="card border-0 shadow-lg rounded-4 mb-4">
            <div class="card-header bg-gradient text-white fw-semibold"
                style="background: linear-gradient(135deg, #007bff, #0056b3);">
                <h5 class="mb-0"><i class="bi bi-wallet2 me-2"></i> Laporan Petty Cash</h5>
            </div>

            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pilih Petty Cash</label>
                        <select name="pettycash_id" class="form-select shadow-sm" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($pettycashes as $p)
                                <option value="{{ $p->id }}" {{ $pettycashId == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_pettycash }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" value="{{ $tanggalAwal }}"
                            class="form-control shadow-sm">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}"
                            class="form-control shadow-sm">
                    </div>

                    <div class="col-md-2 text-end">
                        <button class="btn btn-primary w-100 shadow-sm">
                            <i class="bi bi-search me-1"></i> Tampilkan
                        </button>
                    </div>
                </form>

            </div>
        </div>

        @if ($laporan)
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-primary mb-0">
                            <i class="bi bi-cash-stack me-2"></i>{{ $laporan['pettycash']->nama_pettycash }}
                        </h5>
                        <span class="badge bg-light text-secondary">Periode:
                            {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }} –
                            {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</span>
                        <a href="{{ route('pettycash.export.pdf', [
                            'pettycash_id' => $pettycashId,
                            'tanggal_awal' => $tanggalAwal,
                            'tanggal_akhir' => $tanggalAkhir,
                        ]) }}"
                            target="_blank" class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>



                    </div>

                    <div class="row text-center border rounded-3 p-3 bg-light mb-3">
                        <div class="col-md-3">
                            <h6 class="text-muted mb-1">Saldo Awal</h6>
                            <h5 class="fw-bold text-dark">Rp {{ number_format($laporan['saldo_awal'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-1">Total Pemasukan</h6>
                            <h5 class="fw-bold text-success">Rp {{ number_format($laporan['total_in'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-1">Total Pengeluaran</h6>
                            <h5 class="fw-bold text-danger">Rp {{ number_format($laporan['total_out'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted mb-1">Saldo Akhir</h6>
                            <h5 class="fw-bold text-primary">Rp {{ number_format($laporan['saldo_akhir'], 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>

                    <h6 class="fw-semibold text-secondary mt-4 mb-2"><i class="bi bi-journal-text me-1"></i> Detail
                        Transaksi</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th>Kategori</th>
                                    <th>Keperluan</th>
                                    <th class="text-end">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporan['transaksi'] as $t)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->translatedFormat('l, d F Y') }}
                                        </td>
                                        <td>{{ $t->jenis_transaksi }}</td>
                                        <td>{{ $t->metode_transaksi }}</td>
                                        <td>{{ $t->kategori }} - {{ $t->sub_kategori }}</td>
                                        <td>{{ $t->keperluan }}</td>
                                        <td class="text-end fw-semibold">{{ number_format($t->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Tidak ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-semibold text-secondary mb-2"><i class="bi bi-arrow-left-right me-1"></i> Mutasi Saldo
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Asal</th>
                                    <th>Tujuan</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporan['mutasi'] as $m)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($m->tanggal)->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ ucfirst($m->jenis_transaksi) }}</td>
                                        <td>{{ $m->asal->nama_pettycash ?? '-' }}</td>
                                        <td>{{ $m->tujuan->nama_pettycash ?? '-' }}</td>
                                        <td>{{ $m->keterangan ?? '-' }}</td>
                                        <td class="text-end fw-semibold">{{ number_format($m->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Tidak ada mutasi saldo</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        @endif
    </div>
@endsection
