@extends('layouts.base')

@section('content')
    <div class="py-4">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-header bg-warning text-white fw-bold">Edit Kategori Petty Cash</div>
            <div class="card-body">
                <form action="{{ route('kategori_pettycash.update', $kategori_pettycash->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" name="kategori" value="{{ $kategori_pettycash->kategori }}"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sub Kategori</label>
                            <input type="text" name="sub_kategori" value="{{ $kategori_pettycash->sub_kategori }}"
                                class="form-control" required>
                        </div>
                    </div>
                    <button class="btn btn-warning text-white">Update</button>
                    <a href="{{ route('kategori_pettycash.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
