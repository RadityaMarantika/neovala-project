@extends('layouts.base')

@section('content')
    <div class="py-6">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-primary text-white fw-semibold">
                Daftar Transfer Barang Gudang
            </div>

            <div class="card-body">
                <a href="{{ route('gudang-ambils.create') }}" class="btn btn-primary mb-3">+ Transfer Baru</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Gudang Tujuan</th>
                            <th>Jumlah Item</th>
                            <th>Tanggal</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfers as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td>{{ $t->gudangTujuan->nama_gudang }}</td>
                                <td>{{ $t->items->count() }}</td>
                                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('gudang-ambils.edit', $t->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('gudang-ambils.destroy', $t->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">
                                            Delete
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
