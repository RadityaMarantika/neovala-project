@extends('layouts.base')

@section('content')
    <div class="py-6">
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-warning fw-semibold">
                Edit Transfer
            </div>
            <div class="card-body">
                <form action="{{ route('transfer.update', $transfer->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="fw-semibold">Gudang Tujuan</label>
                        <select name="gudang_tujuan" class="form-select" required>
                            @foreach ($gudangs as $g)
                                <option value="{{ $g->id }}"
                                    {{ $transfer->gudang_tujuan == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama_gudang }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-warning">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
