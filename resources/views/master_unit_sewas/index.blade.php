@extends('layouts.base')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between mb-3">
            <h4 class="fw-bold text-primary">Master Unit Sewas</h4>
            <a href="{{ route('master_unit_sewas.create') }}" class="btn btn-primary">Tambah Sewa</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Unit</th>
                            <th>Periode</th>
                            <th>IPL/UTL/WIFI</th>
                            <th>Pengambilan Kunci</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sewas as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $s->unit->no_unit ?? '-' }}</td>
                                <td>{{ $s->periode_sewa }}</td>
                                <td>
                                    IPL: {{ $s->jenis_ipl }} <br>
                                    UTL: {{ $s->jenis_utl }} <br>
                                    WIFI: {{ $s->jenis_wifi }}
                                </td>
                                <td>{{ $s->pengambilan_kunci }}</td>
                                <td>
                                    <a href="{{ route('master_unit_sewas.edit', $s->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('master_unit_sewas.destroy', $s->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
