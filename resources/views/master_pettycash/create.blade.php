@extends('layouts.base')

@section('content')
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="fw-bold text-primary mb-0">Buat Data PettyCash</h2>
            <a href="{{ route('master-pettycash.index') }}" class="btn btn-success">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    {{-- Alert Section --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="py-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header">
                <h4 class="fw-bold mb-0">Tambah Petty Cash</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('master-pettycash.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Petty Cash</label>
                        <input type="text" name="nama_pettycash" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dikelola Oleh</label>
                        <select name="dikelola_oleh_id" class="form-select w-full">
                            <option value="">-- Tidak ada / Kosongkan --</option>
                            @foreach ($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                   <div class="mb-3">
                        <label class="form-label">Saldo Awal</label>
                        <input 
                            type="text" 
                            name="saldo_awal" 
                            id="saldo_awal" 
                            class="form-control text-end" 
                            placeholder="0" 
                            required 
                            oninput="formatRupiah(this)">
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary rounded-3">Simpan</button>
                        <a href="{{ route('master-pettycash.index') }}" class="btn btn-secondary rounded-3">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
function formatRupiah(input) {
    // Simpan posisi kursor
    let cursorPos = input.selectionStart;
    let value = input.value;

    // Hilangkan semua karakter selain angka
    value = value.replace(/\D/g, '');

    // Format angka dengan titik pemisah ribuan
    let formatted = new Intl.NumberFormat('id-ID').format(value);

    // Update nilai yang ditampilkan
    input.value = formatted;

    // Simpan nilai angka murni di input hidden (agar tersimpan benar di database)
    let hiddenInput = document.getElementById('saldo_awal_hidden');
    if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'saldo_awal';
        hiddenInput.id = 'saldo_awal_hidden';
        input.parentNode.appendChild(hiddenInput);
    }
    hiddenInput.value = value;

    // Kembalikan posisi kursor
    input.setSelectionRange(cursorPos, cursorPos);
}
</script>

@endsection
