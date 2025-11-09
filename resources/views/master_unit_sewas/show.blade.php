@extends('layouts.base')

@section('content')
    <div class="container py-4">
        <h4 class="fw-bold text-primary mb-3">Detail Sewa Unit</h4>

        <div class="card shadow-sm">
            <div class="card-body">
                <p><b>Unit:</b> {{ $masterUnitSewa->unit->no_unit ?? '-' }} -
                    {{ $masterUnitSewa->unit->nama_lengkap ?? '' }}</p>
                <p><b>Periode:</b> {{ $masterUnitSewa->periode_sewa }} / {{ $masterUnitSewa->jenis_tempo }}</p>
                <p><b>Pengambilan Kunci:</b> {{ $masterUnitSewa->pengambilan_kunci ?? '-' }}</p>
                <hr>
                <h6>Biaya Unit</h6>
                <p>Bayar: {{ $masterUnitSewa->bayar_unit }} - Biaya: {{ $masterUnitSewa->biaya_unit ?? '-' }} - Tanggal:
                    {{ $masterUnitSewa->tanggal_unit ?? '-' }}</p>
                <h6>UTL</h6>
                <p>Jenis: {{ $masterUnitSewa->jenis_utl }} - Bayar: {{ $masterUnitSewa->bayar_utl ?? '-' }} - Biaya:
                    {{ $masterUnitSewa->biaya_utl ?? '-' }} - Tanggal: {{ $masterUnitSewa->tanggal_utl ?? '-' }}</p>
                <h6>IPL</h6>
                <p>Jenis: {{ $masterUnitSewa->jenis_ipl }} - Bayar: {{ $masterUnitSewa->bayar_ipl ?? '-' }} - Biaya:
                    {{ $masterUnitSewa->biaya_ipl ?? '-' }} - Tanggal: {{ $masterUnitSewa->tanggal_ipl ?? '-' }}</p>
                <h6>WIFI</h6>
                <p>Jenis: {{ $masterUnitSewa->jenis_wifi }} - Provider: {{ $masterUnitSewa->provider_wifi ?? '-' }} -
                    Bayar: {{ $masterUnitSewa->bayar_wifi ?? '-' }} - Biaya: {{ $masterUnitSewa->biaya_wifi ?? '-' }} -
                    Tanggal: {{ $masterUnitSewa->tanggal_wifi ?? '-' }}</p>

                <div class="mt-3">
                    <a href="{{ route('master_unit_sewas.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('master_unit_sewas.edit', $masterUnitSewa->id) }}" class="btn btn-warning">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection
