@extends('layouts.base')

@section('content')
    <div class="container py-4">
        <h4 class="fw-bold text-primary mb-3">Edit Sewa Unit</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('master_unit_sewas.update', $masterUnitSewa->id) }}" method="POST" id="sewaEditForm">
            @csrf
            @method('PUT')

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">Data Sewa</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Unit</label>
                        <select name="unit_id" class="form-select" required>
                            <option value="">-- Pilih Unit --</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}"
                                    {{ $masterUnitSewa->unit_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->no_unit }} - {{ $u->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Periode Sewa</label>
                        <select name="periode_sewa" class="form-select" required>
                            <option value="3 bulan" {{ $masterUnitSewa->periode_sewa == '3 bulan' ? 'selected' : '' }}>3 bulan
                            </option>
                            <option value="6 bulan" {{ $masterUnitSewa->periode_sewa == '6 bulan' ? 'selected' : '' }}>6 bulan
                            </option>
                            <option value="12 bulan" {{ $masterUnitSewa->periode_sewa == '12 bulan' ? 'selected' : '' }}>12 bulan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis Tempo</label>
                        <select name="jenis_tempo" class="form-select" required>
                            <option value="monthly" {{ $masterUnitSewa->jenis_tempo == 'monthly' ? 'selected' : '' }}>Monthly
                            </option>
                            <option value="quarterly" {{ $masterUnitSewa->jenis_tempo == 'quarterly' ? 'selected' : '' }}>
                                Quarterly</option>
                            <option value="semi-annually"
                                {{ $masterUnitSewa->jenis_tempo == 'semi-annually' ? 'selected' : '' }}>Semi-annually</option>
                            <option value="annually" {{ $masterUnitSewa->jenis_tempo == 'annually' ? 'selected' : '' }}>Annually
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis IPL</label>
                        <select name="jenis_ipl" class="form-select jenis-toggle" data-target="ipl">
                            <option value="Include" {{ $masterUnitSewa->jenis_ipl == 'Include' ? 'selected' : '' }}>Include
                            </option>
                            <option value="Exclude" {{ $masterUnitSewa->jenis_ipl == 'Exclude' ? 'selected' : '' }}>Exclude
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis UTL</label>
                        <select name="jenis_utl" class="form-select jenis-toggle" data-target="utl">
                            <option value="Include" {{ $masterUnitSewa->jenis_utl == 'Include' ? 'selected' : '' }}>Include
                            </option>
                            <option value="Exclude" {{ $masterUnitSewa->jenis_utl == 'Exclude' ? 'selected' : '' }}>Exclude
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis WIFI</label>
                        <select name="jenis_wifi" class="form-select jenis-toggle" data-target="wifi">
                            <option value="Include" {{ $masterUnitSewa->jenis_wifi == 'Include' ? 'selected' : '' }}>Include
                            </option>
                            <option value="Exclude" {{ $masterUnitSewa->jenis_wifi == 'Exclude' ? 'selected' : '' }}>Exclude
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Pengambilan Kunci</label>
                        <input type="date" name="pengambilan_kunci" value="{{ $masterUnitSewa->pengambilan_kunci }}"
                            class="form-control">
                    </div>
                </div>
            </div>

            {{-- Biaya Unit --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white fw-bold">Detail Biaya Unit</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Dibayar Oleh</label>
                        <select name="bayar_unit" class="form-select" required>
                            <option value="Owner" {{ $masterUnitSewa->bayar_unit == 'Owner' ? 'selected' : '' }}>Owner</option>
                            <option value="Marketing" {{ $masterUnitSewa->bayar_unit == 'Marketing' ? 'selected' : '' }}>
                                Marketing</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Biaya Unit</label>
                        <input type="number" name="biaya_unit" value="{{ $masterUnitSewa->biaya_unit }}"
                            class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Tempo Unit</label>
                        <input type="number" name="tanggal_unit" value="{{ $masterUnitSewa->tanggal_unit }}"
                            class="form-control" min="1" max="31" required>
                    </div>
                </div>
            </div>

            {{-- UTL --}}
            <div class="card shadow-sm mb-4 box-utl d-none">
                <div class="card-header bg-dark text-white fw-bold">Detail Biaya UTL</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Dibayar Oleh (UTL)</label>
                        <select name="bayar_utl" class="form-select">
                            <option value="Owner" {{ $masterUnitSewa->bayar_utl == 'Owner' ? 'selected' : '' }}>Owner</option>
                            <option value="Marketing" {{ $masterUnitSewa->bayar_utl == 'Marketing' ? 'selected' : '' }}>Marketing
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Biaya UTL</label>
                        <input type="number" name="biaya_utl" value="{{ $masterUnitSewa->biaya_utl }}"
                            class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Tempo UTL</label>
                        <input type="number" name="tanggal_utl" value="{{ $masterUnitSewa->tanggal_utl }}"
                            class="form-control" min="1" max="31">
                    </div>
                </div>
            </div>

            {{-- IPL --}}
            <div class="card shadow-sm mb-4 box-ipl d-none">
                <div class="card-header bg-dark text-white fw-bold">Detail Biaya IPL</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Dibayar Oleh (IPL)</label>
                        <select name="bayar_ipl" class="form-select">
                            <option value="Owner" {{ $masterUnitSewa->bayar_ipl == 'Owner' ? 'selected' : '' }}>Owner</option>
                            <option value="Marketing" {{ $masterUnitSewa->bayar_ipl == 'Marketing' ? 'selected' : '' }}>
                                Marketing</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Biaya IPL</label>
                        <input type="number" name="biaya_ipl" value="{{ $masterUnitSewa->biaya_ipl }}"
                            class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Tempo IPL</label>
                        <input type="number" name="tanggal_ipl" value="{{ $masterUnitSewa->tanggal_ipl }}"
                            class="form-control" min="1" max="31">
                    </div>
                </div>
            </div>

            {{-- WIFI --}}
            <div class="card shadow-sm mb-4 box-wifi d-none">
                <div class="card-header bg-dark text-white fw-bold">Detail Biaya WIFI</div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Dibayar Oleh (WIFI)</label>
                        <select name="bayar_wifi" class="form-select">
                            <option value="Owner" {{ $masterUnitSewa->bayar_wifi == 'Owner' ? 'selected' : '' }}>Owner</option>
                            <option value="Marketing" {{ $masterUnitSewa->bayar_wifi == 'Marketing' ? 'selected' : '' }}>
                                Marketing</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Provider Wifi</label>
                        <input type="text" name="provider_wifi" value="{{ $masterUnitSewa->provider_wifi }}"
                            class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Biaya Wifi</label>
                        <input type="number" name="biaya_wifi" value="{{ $masterUnitSewa->biaya_wifi }}"
                            class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Tempo Wifi</label>
                        <input type="number" name="tanggal_wifi" value="{{ $masterUnitSewa->tanggal_wifi }}"
                            class="form-control" min="1" max="31">
                    </div>
                </div>
            </div>

            <button class="btn btn-primary px-4">Update</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleBox(type, value) {
                const box = document.querySelector('.box-' + type);
                const inputs = box ? box.querySelectorAll('input, select') : [];
                if (value === 'Exclude') {
                    box.classList.remove('d-none');
                } else {
                    if (box) {
                        box.classList.add('d-none');
                        inputs.forEach(i => {
                            if (i.tagName === 'SELECT') i.selectedIndex = 0;
                            else i.value = '';
                        });
                    }
                }
            }

            document.querySelectorAll('.jenis-toggle').forEach(select => {
                select.addEventListener('change', function() {
                    toggleBox(this.dataset.target, this.value);
                });
                toggleBox(select.dataset.target, select.value);
            });
        });
    </script>
@endsection
