@extends('layouts.base')

@section('content')
<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-primary mb-0"> Cooperative Account
            </h2>
            <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#createAccountModal">
                <i class="fas fa-plus-circle me-1"></i> Account
            </button>
        </div>
    </x-slot>

    <div class="py-4">

        {{-- Alert Section --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        {{-- Main Card --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                {{-- Wrapper scroll --}}
                <div class="table-responsive" style="max-height: 70vh; overflow-x:auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Karyawan</th>
                                <th>Jenis</th>
                                <th>Tanggal Buat</th>
                                <th>Dibuat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accounts as $a)
                                <tr>
                                    <td><span class="fw-bold text-primary">{{ $a->kode_koperasi }}</span></td>
                                    <td>{{ $a->karyawan->nama_lengkap ?? '-' }}</td>
                                    <td>
                                        <span class="badge text-white bg-{{ $a->jenis == 'tabungan' ? 'success' : 'warning' }}">
                                            {{ ucfirst($a->jenis) }}
                                        </span>
                                    </td>
                                    <td>{{ $a->tanggal_buat }}</td>
                                    <td>{{ $a->creator->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle me-1"></i> Belum ada akun koperasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal: Create Account --}}
    <div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="createAccountModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Buat Akun Koperasi
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('koperasi.account.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="row">
    {{-- Jenis Akun --}}
    <div class="col-md-6 mb-3">
        <label for="jenis" class="form-label fw-semibold">Jenis Akun</label>
        <select name="jenis" id="jenis" class="form-control" required>
            <option value="">-- Pilih Jenis Akun --</option>
            <option value="tabungan">tabungan</option>
            <option value="pinjaman">pinjaman</option>
        </select>
    </div>

    {{-- Karyawan --}}
    <div class="col-md-6 mb-3">
        <label for="karyawan_id" class="form-label fw-semibold">Karyawan</label>
        <select name="karyawan_id" id="karyawan_id" class="form-control" required>
            <option value="">-- Pilih Jenis Akun Dulu --</option>
        </select>
    </div>
</div>

<script>
document.getElementById('jenis').addEventListener('change', function() {
    let jenis = this.value;
    let karyawanSelect = document.getElementById('karyawan_id');
    karyawanSelect.innerHTML = '<option value="">Memuat data...</option>';

    if (jenis) {
        fetch(`{{ url('/koperasi/available-karyawan') }}/${jenis}`)
            .then(response => response.json())
            .then(data => {
                karyawanSelect.innerHTML = '<option value="">-- Pilih Karyawan --</option>';
                if (data.length > 0) {
                    data.forEach(k => {
                        karyawanSelect.innerHTML += `<option value="${k.id}">${k.nama_lengkap}</option>`;
                    });
                } else {
                    karyawanSelect.innerHTML = '<option value="">Tidak ada karyawan tersedia</option>';
                }
            })
            .catch(error => {
                console.error(error);
                karyawanSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    } else {
        karyawanSelect.innerHTML = '<option value="">-- Pilih Jenis Akun Dulu --</option>';
    }
});
</script>



                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
@endsection
