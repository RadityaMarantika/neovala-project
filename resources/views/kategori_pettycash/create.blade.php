@extends('layouts.base')

@section('content')
    <div class="py-4">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-primary text-white fw-bold">Tambah Kategori Petty Cash</div>
            <div class="card-body">
                <form action="{{ route('kategori_pettycash.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" name="kategori" class="form-control" required
                                placeholder="Masukkan kategori">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sub Kategori</label>
                            <input type="text" name="sub_kategori" class="form-control" required
                                placeholder="Masukkan sub kategori">
                        </div>
                    </div>
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kategori_pettycash.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
