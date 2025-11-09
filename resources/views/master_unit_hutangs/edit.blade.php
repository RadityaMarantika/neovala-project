@extends('layouts.base')

@section('content')
    <div class="container py-4">
        <h4 class="fw-bold text-primary mb-3">Input Pembayaran Hutang</h4>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <p>
                    <b>Unit:</b> {{ $masterUnitHutang->sewa->unit->no_unit }} <br>
                    <b>Pemilik:</b> {{ $masterUnitHutang->sewa->unit->nama_lengkap }}
                </p>
            </div>
        </div>

        <form action="{{ route('master_unit_hutangs.update', $masterUnitHutang->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ====================== PEMBAYARAN UNIT ====================== --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white fw-bold">Pembayaran Unit</div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tempo</label>
                        <input class="form-control" value="{{ $masterUnitHutang->tempo_unit }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pembayaran</label>
                        <input type="number" name="pembayaran_unit" class="form-control" placeholder="Isi pembayaran...">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <input class="form-control" value="{{ $masterUnitHutang->pay_unit }}" disabled>
                    </div>

                </div>
            </div>

            {{-- ====================== PEMBAYARAN UTL ====================== --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white fw-bold">Pembayaran UTL</div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tempo</label>
                        <input class="form-control" value="{{ $masterUnitHutang->tempo_utl }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pembayaran</label>
                        <input type="number" name="pembayaran_utl" class="form-control" placeholder="Isi pembayaran...">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <input class="form-control" value="{{ $masterUnitHutang->pay_utl }}" disabled>
                    </div>

                </div>
            </div>

            {{-- ====================== PEMBAYARAN IPL ====================== --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white fw-bold">Pembayaran IPL</div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tempo</label>
                        <input class="form-control" value="{{ $masterUnitHutang->tempo_ipl }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pembayaran</label>
                        <input type="number" name="pembayaran_ipl" class="form-control" placeholder="Isi pembayaran...">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <input class="form-control" value="{{ $masterUnitHutang->pay_ipl }}" disabled>
                    </div>

                </div>
            </div>

            {{-- ====================== PEMBAYARAN WIFI ====================== --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white fw-bold">Pembayaran Wifi</div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tempo</label>
                        <input class="form-control" value="{{ $masterUnitHutang->tempo_wifi }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pembayaran</label>
                        <input type="number" name="pembayaran_wifi" class="form-control" placeholder="Isi pembayaran...">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Status</label>
                        <input class="form-control" value="{{ $masterUnitHutang->pay_wifi }}" disabled>
                    </div>

                </div>
            </div>

            <button class="btn btn-primary px-4">Simpan Pembayaran</button>

        </form>
    </div>
@endsection
