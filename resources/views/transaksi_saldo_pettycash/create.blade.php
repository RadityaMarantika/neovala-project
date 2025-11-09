@extends('layouts.base')

@section('content')
<x-app-layout>

    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-primary mb-0">
                <i class="bi bi-wallet2 me-2"></i> Tambah Transaksi Petty Cash
            </h2>
            <a href="{{ route('transaksi_saldo_pettycash.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    {{-- ================= ALERT ================= --}}
    <div class="mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- ================= FORM CARD ================= --}}
    <div class="card shadow border-0 mt-4 mb-5">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-journal-plus me-2"></i>
            <h6 class="mb-0 fw-bold">Form Input Transaksi Petty Cash</h6>
        </div>

        <div class="card-body px-4 py-4">
            <form action="{{ route('transaksi_saldo_pettycash.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- ================= KIRI ================= --}}
                    <div class="col-md-6">
                        {{-- Tanggal --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>

                        {{-- Jenis Transaksi --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Transaksi</label>
                            <select name="jenis_transaksi" id="jenis_transaksi" class="form-select w-full" required>
                                <option value="topup">Top Up</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>

                    {{-- ================= KANAN ================= --}}
                    <div class="col-md-6">
                        {{-- Petty Cash Asal --}}
                        <div class="mb-3" id="asal-container" style="display:none;">
                            <label class="form-label fw-semibold">Petty Cash Asal</label>
                            <select name="pettycash_asal_id" class="form-select w-full">
                                <option value="">-- Pilih Asal --</option>
                                @foreach($pettycashes as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pettycash }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Petty Cash Tujuan --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Petty Cash Tujuan</label>
                            <select name="pettycash_tujuan_id" class="form-select w-full" required>
                                <option value="">-- Pilih Tujuan --</option>
                                @foreach($pettycashes as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pettycash }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- ================= KIRI ================= --}}
                    <div class="col-md-6">
                        {{-- Keterangan --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Opsional"></textarea>
                        </div>
                        
                        {{-- Bukti Transfer --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bukti Transfer</label>
                            <input type="file" name="bukti_transfer" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                        </div>
                    </div>
                    

                    {{-- ================= KANAN ================= --}}
                    <div class="col-md-6">
                        {{-- Nominal --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal</label>
                            <input type="text" name="nominal_display" id="nominal_display" class="form-control" required
                                placeholder="Masukkan jumlah" oninput="formatRupiahGlobal(this, 'nominal_hidden')">

                            {{-- Hidden input untuk simpan nilai asli ke database --}}
                            <input type="hidden" name="nominal" id="nominal_hidden">
                        </div>

                    </div>
                </div>

                {{-- ================= TOMBOL ================= --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('transaksi_saldo_pettycash.index') }}" class="btn btn-secondary px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save2 me-1"></i> Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>

{{-- ================= SCRIPT ================= --}}
<script>
    document.getElementById('jenis_transaksi').addEventListener('change', function() {
        const asalContainer = document.getElementById('asal-container');
        asalContainer.style.display = this.value === 'transfer' ? 'block' : 'none';
    });
</script>
<script>
function formatRupiahGlobal(input, hiddenId) {
    // Ambil posisi kursor (optional tapi biar smooth)
    const cursorPos = input.selectionStart;

    // Hapus semua karakter non-digit
    let value = input.value.replace(/\D/g, '');

    // Format angka ke format ribuan Indonesia
    input.value = new Intl.NumberFormat('id-ID').format(value);

    // Simpan nilai asli (tanpa titik) ke hidden input
    document.getElementById(hiddenId).value = value;

    // Kembalikan posisi kursor (optional)
    input.setSelectionRange(cursorPos, cursorPos);
}
</script>

@endsection
