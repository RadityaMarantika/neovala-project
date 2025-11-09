@extends('layouts.base')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-3">Edit Transaksi Petty Cash</h4>

    <form action="{{ route('transaksi_saldo_pettycash.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $transaksi->tanggal) }}" required>
        </div>

        <div class="mb-3">
            <label>Jenis Transaksi</label>
            <input type="text" class="form-control" value="{{ ucfirst($transaksi->jenis_transaksi) }}" readonly>
        </div>

        @if($transaksi->jenis_transaksi === 'transfer')
        <div class="mb-3">
            <label>Petty Cash Asal</label>
            <input type="text" class="form-control" value="{{ $transaksi->asal?->nama_pettycash }}" readonly>
        </div>
        @endif

        <div class="mb-3">
            <label>Petty Cash Tujuan</label>
            <input type="text" class="form-control" value="{{ $transaksi->tujuan?->nama_pettycash }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nominal</label>
            <input type="text" class="form-control" value="Rp{{ number_format($transaksi->nominal, 0, ',', '.') }}" readonly>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('transaksi_saldo_pettycash.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
