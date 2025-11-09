@extends('layouts.base')

@section('content')

<x-app-layout>
    <div class="card border-0 shadow-sm mb-5 hero-card text-white">
        <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center">
                Saving Request Form
            </h5>

            <a href="{{ url()->previous() }}"
                class="btn btn-outline-light btn-sm px-3 py-2 fw-semibold rounded-pill d-flex align-items-center mt-3 mt-sm-0"
                style="transition: all 0.3s ease;">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>

    <div class="">
        <div class=" mx-auto px-4">
            <div class="bg-white shadow rounded-lg p-6">

                {{-- Error message umum --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-600 font-semibold">
                        Terjadi kesalahan:
                        <ul class="list-disc list-inside text-sm text-red-500 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('koperasi.tabungan.store', $account->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Tanggal Input</label>
                        <input type="date" name="tanggal_input" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light">Rp</span>
                            <input 
                                type="text" 
                                id="jumlah_display"
                                class="form-control text-end @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah') ? number_format(old('jumlah'), 0, ',', '.') : '' }}"
                                placeholder="Masukkan jumlah"
                                required
                                oninput="formatRupiahJumlah(this)"
                                autocomplete="off"
                            >
                            <input type="hidden" name="jumlah" id="jumlah_hidden">
                            @error('jumlah')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3">
                        <label>Upload Bukti</label>
                        <input type="file" name="upload_bukti" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
function formatRupiahJumlah(input) {
    const cursorPos = input.selectionStart;
    let value = input.value.replace(/\D/g, ''); // hanya angka

    // Format angka ke ribuan (contoh: 1000000 → 1.000.000)
    const formatted = new Intl.NumberFormat('id-ID').format(value);
    input.value = formatted;

    // Simpan nilai asli ke input hidden agar bisa dikirim ke server
    document.getElementById('jumlah_hidden').value = value;

    // Kembalikan posisi kursor biar gak loncat
    input.setSelectionRange(cursorPos, cursorPos);
}
</script>

@endsection
