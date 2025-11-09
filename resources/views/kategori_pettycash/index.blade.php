@extends('layouts.base')

@section('content')
    <div class="py-4">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Master Kategori Petty Cash</h5>
                <a href="{{ route('kategori_pettycash.create') }}" class="btn btn-light btn-sm fw-semibold">+ Tambah Data</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Sub Kategori</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->kategori }}</td>
                                <td>{{ $row->sub_kategori }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kategori_pettycash.edit', $row->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('kategori_pettycash.destroy', $row->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
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
