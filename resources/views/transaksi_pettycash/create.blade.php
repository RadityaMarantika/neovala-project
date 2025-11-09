@extends('layouts.base')

@section('content')
    <x-app-layout>

        {{-- ================= HEADER ================= --}}
        <x-slot name="header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold text-primary mb-0">
                    <i class="bi bi-wallet2 me-2"></i> Tambah Transaksi Petty Cash
                </h2>
                <a href="{{ route('transaksi-pettycash.index') }}" class="btn btn-sm btn-secondary shadow-sm">
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
        <div class="card shadow border-0 mt-4 mb-5 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white py-3 px-4 d-flex align-items-center">
                <i class="bi bi-journal-plus me-2 fs-5"></i>
                <h6 class="mb-0 fw-bold">Form Input Transaksi Petty Cash</h6>
            </div>

            <div class="card-body px-4 py-4">
                <form action="{{ route('transaksi-pettycash.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

                        {{-- Petty Cash --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pilih Petty Cash <span
                                    class="text-danger">*</span></label>
                            @if ($pettycash_user)
                                <input type="hidden" name="pettycash_id" value="{{ $pettycash_user->id }}">
                                <input type="text" class="form-control form-control-custom"
                                    value="{{ $pettycash_user->nama_pettycash }}" readonly>
                            @else
                                <select name="pettycash_id"
                                    class="form-select form-control-custom w-full @error('pettycash_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Petty Cash --</option>
                                    @foreach ($pettycashs as $cash)
                                        <option value="{{ $cash->id }}"
                                            {{ old('pettycash_id') == $cash->id ? 'selected' : '' }}>
                                            {{ $cash->nama_pettycash }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @error('pettycash_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Region --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Region <span class="text-danger">*</span></label>
                            <select name="region"
                                class="form-select form-control-custom w-full @error('region') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Region --</option>
                                <option value="Transpark Juanda"
                                    {{ old('region') == 'Transpark Juanda' ? 'selected' : '' }}>Transpark Juanda</option>
                                <option value="Ayam Keshwari" {{ old('region') == 'Ayam Keshwari' ? 'selected' : '' }}>Ayam
                                    Keshwari</option>
                            </select>
                            @error('region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Transaksi --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Transaksi <span class="text-danger">*</span></label>
                            <select name="jenis_transaksi"
                                class="form-select form-control-custom w-full @error('jenis_transaksi') is-invalid @enderror"
                                required readonly>
                                <option value="Cash Out" selected>Cash Out</option>
                            </select>
                            @error('jenis_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Metode Transaksi --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Metode Transaksi <span
                                    class="text-danger">*</span></label>
                            <select name="metode_transaksi"
                                class="form-select form-control-custom w-full @error('metode_transaksi') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Metode Transaksi --</option>
                                <option value="Cash" {{ old('metode_transaksi') == 'Cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="Transfer" {{ old('metode_transaksi') == 'Transfer' ? 'selected' : '' }}>
                                    Transfer</option>
                            </select>
                            @error('metode_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori & Sub Kategori --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori"
                                class="form-select form-control-custom @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->kategori }}"
                                        {{ old('kategori') == $kategori->kategori ? 'selected' : '' }}>
                                        {{ $kategori->kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sub Kategori <span class="text-danger">*</span></label>
                            <select name="sub_kategori" id="sub_kategori"
                                class="form-select form-control-custom @error('sub_kategori') is-invalid @enderror"
                                required>
                                <option value="">-- Pilih Sub Kategori --</option>
                            </select>
                            @error('sub_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nominal <span class="text-danger">*</span></label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="text" id="nominal_display"
                                    class="form-control text-end @error('nominal') is-invalid @enderror"
                                    value="{{ old('nominal') ? number_format(old('nominal'), 0, ',', '.') : '' }}"
                                    placeholder="Masukkan nominal" required oninput="formatRupiahNominal(this)"
                                    autocomplete="off">
                                <input type="hidden" name="nominal" id="nominal_hidden">
                                @error('nominal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <script>
                            function formatRupiahNominal(input) {
                                const cursorPos = input.selectionStart;
                                let value = input.value.replace(/\D/g, ''); // hanya angka

                                // format ribuan
                                const formatted = new Intl.NumberFormat('id-ID').format(value);
                                input.value = formatted;

                                // simpan nilai asli di hidden input
                                document.getElementById('nominal_hidden').value = value;

                                // kembalikan posisi kursor agar tidak loncat
                                input.setSelectionRange(cursorPos, cursorPos);
                            }
                        </script>


                        {{-- Bukti Foto --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bukti Foto</label>
                            <input type="file" name="bukti_foto"
                                class="form-control form-control-custom @error('bukti_foto') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted fst-italic">Opsional, format jpg/png/pdf (max 2MB)</small>
                            @error('bukti_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keperluan --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keperluan <span class="text-danger">*</span></label>
                            <textarea name="keperluan" class="form-control form-control-custom @error('keperluan') is-invalid @enderror"
                                rows="3" placeholder="Tuliskan keperluan transaksi..." required>{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-success px-4 shadow-sm me-2">
                            <i class="bi bi-save me-2"></i> Simpan
                        </button>
                        <a href="{{ route('transaksi-pettycash.index') }}"
                            class="btn btn-outline-secondary px-4 shadow-sm">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </x-app-layout>

    {{-- ===== STYLE SERAGAM UNTUK SEMUA FIELD ===== --}}
    <style>
        .form-control-custom {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            box-shadow: 0 .1rem .3rem rgba(0, 0, 0, .08);
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        textarea.form-control-custom {
            min-height: 80px;
            resize: vertical;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 4px 8px;
            background-color: #fff;
            box-shadow: 0 .1rem .3rem rgba(0, 0, 0, .08);
        }

        .select2-container {
            width: 100% !important;
        }
    </style>

    {{-- ===== SELECT2 ===== --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kategori, #sub_kategori').select2({
                placeholder: '-- Pilih --',
                allowClear: true,
                width: '100%'
            });

            $('#kategori').on('change', function() {
                const kategori = $(this).val();
                $('#sub_kategori').html('<option value="">Memuat...</option>').trigger('change');

                if (kategori) {
                    fetch(`/api/subkategori/${kategori}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Sub Kategori --</option>';
                            data.forEach(sub => {
                                options +=
                                    `<option value="${sub.sub_kategori}">${sub.sub_kategori}</option>`;
                            });
                            $('#sub_kategori').html(options).trigger('change');
                        })
                        .catch(() => {
                            $('#sub_kategori').html('<option value="">Gagal memuat</option>').trigger(
                                'change');
                        });
                } else {
                    $('#sub_kategori').html('<option value="">-- Pilih Sub Kategori --</option>').trigger(
                        'change');
                }
            });
        });
    </script>
@endsection
