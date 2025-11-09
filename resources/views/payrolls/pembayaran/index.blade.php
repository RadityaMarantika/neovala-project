@extends('layouts.base')

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="fw-bold text-primary mb-0">Pembayaran Payroll</h2>
                <a href="{{ route('pembayaran-payroll.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Buat Pembayaran
                </a>
            </div>
        </x-slot>

        <div class="py-6">
            {{-- Alert Section --}}
            @if (session('success'))
                <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
            @endif

            {{-- Main Card --}}
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:25%">Karyawan</th>
                                <th style="width:15%">Tanggal</th>
                                <th class="text-end" style="width:20%">Take Home Pay</th>
                                <th class="text-center" style="width:10%">Status</th>
                                <th class="text-center" style="width:25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $i)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="whitespace-nowrap">{{ optional($i->master->karyawan)->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($i->tanggal_pembayaran)->format('d M Y') }}</td>
                                    <td class="text-end whitespace-nowrap">Rp
                                        {{ number_format($i->take_home_pay, 0, ',', '.') }}</td>
                                    <td class="text-center whitespace-nowrap">
                                        @switch($i->status_payroll)
                                            @case('Approve')
                                                <span class="badge bg-success px-3 py-2">Approved</span>
                                            @break

                                            @case('Pending')
                                                <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                            @break

                                            @case('Done')
                                                <span class="badge bg-primary px-3 py-2">Done</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary px-3 py-2">{{ $i->status_payroll }}</span>
                                        @endswitch
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('pembayaran-payroll.edit', $i) }}"
                                                class="btn btn-sm btn-outline-primary mx-1" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            {{-- Tombol Delete --}}
                                            <form action="{{ route('pembayaran-payroll.destroy', $i) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger mx-1"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                    title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            {{-- Tombol Approve --}}
                                            @if ($i->status_payroll != 'Approve' && $i->status_payroll != 'Done')
                                                <form action="{{ route('pembayaran-payroll.approve', $i->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success mx-1"
                                                        onclick="return confirm('Setujui dan lunasi cicilan koperasi untuk karyawan ini?')"
                                                        title="Approve">
                                                        <i class="fa-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Tombol Transfer --}}
                                            @if ($i->status_payroll == 'Approve')
                                                <button type="button" class="btn btn-sm btn-primary mx-1"
                                                    data-toggle="modal" data-target="#modalTransfer{{ $i->id }}">
                                                    <i class="fas fa-money-bill-wave"></i> Transfer
                                                </button>
                                            @endif
                                        </div>

                                        {{-- ==================== MODAL TRANSFER ==================== --}}
                                        <div class="modal fade" id="modalTransfer{{ $i->id }}" tabindex="-1"
                                            aria-labelledby="modalTransferLabel{{ $i->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">

                                                    {{-- Header --}}
                                                    <div
                                                        class="modal-header bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                                                        <h5 class="modal-title fw-bold"
                                                            id="modalTransferLabel{{ $i->id }}">
                                                            Transfer Gaji —
                                                            {{ optional($i->master->karyawan)->nama_lengkap ?? '-' }}
                                                        </h5>
                                                        <button type="button" class="btn-close text-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    {{-- Form --}}
                                                    <form action="{{ route('pembayaran-payrolls.transfer', $i->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body text-sm">

                                                            {{-- Data Utama --}}
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <p><strong>Payroll ID:</strong>
                                                                        {{ $i->payroll_id ?? '-' }}</p>
                                                                    <p><strong>Tanggal Pembayaran:</strong>
                                                                        {{ \Carbon\Carbon::parse($i->tanggal_pembayaran)->format('d M Y') }}
                                                                    </p>
                                                                    <p><strong>Nama Bank:</strong>
                                                                        {{ $i->nama_bank ?? '-' }}</p>
                                                                    <p><strong>Nama Rekening:</strong>
                                                                        {{ $i->nama_rekening ?? '-' }}</p>
                                                                    <p><strong>Nomor Rekening:</strong>
                                                                        {{ $i->nomor_rekening ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Basic Salary:</strong> Rp
                                                                        {{ number_format($i->basic_salary, 0, ',', '.') }}
                                                                    </p>
                                                                    <p><strong>Leader Fee:</strong> Rp
                                                                        {{ number_format($i->leader_fee, 0, ',', '.') }}
                                                                    </p>
                                                                    <p><strong>Incentive Fee:</strong> Rp
                                                                        {{ number_format($i->insentive_fee, 0, ',', '.') }}
                                                                    </p>
                                                                    <p><strong>PH Allowance:</strong> Rp
                                                                        {{ number_format($i->ph_allowance, 0, ',', '.') }}
                                                                    </p>
                                                                    <p><strong>Other Allowance:</strong> Rp
                                                                        {{ number_format($i->other_allowance, 0, ',', '.') }}
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            {{-- Summary --}}
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <p><strong>Total Earning:</strong> Rp
                                                                        {{ number_format($i->total_earning, 0, ',', '.') }}
                                                                    </p>
                                                                    <p><strong>Loan Repayment:</strong> Rp
                                                                        {{ number_format($i->loan_repayment, 0, ',', '.') }}
                                                                    </p>
                                                                    <p><strong>Remaining Loan:</strong> Rp
                                                                        {{ number_format($i->remaining_loan, 0, ',', '.') }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Penalties:</strong> Rp
                                                                        {{ number_format($i->penalties, 0, ',', '.') }}</p>
                                                                    <p><strong>Total Deduction:</strong> Rp
                                                                        {{ number_format($i->total_deduction, 0, ',', '.') }}
                                                                    </p>
                                                                    <p><strong>Take Home Pay:</strong>
                                                                        <span class="fw-bold text-success">Rp
                                                                            {{ number_format($i->take_home_pay, 0, ',', '.') }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            {{-- Upload Bukti --}}
                                                            <div class="form-group mt-3">
                                                                <label for="bukti_transfer" class="fw-semibold">Upload Bukti
                                                                    Transfer</label>
                                                                <input type="file" name="bukti_transfer"
                                                                    class="form-control" accept=".jpg,.jpeg,.png,.pdf"
                                                                    required>
                                                                <small class="text-muted">Format: jpg, jpeg, png, atau pdf
                                                                    (maks 2MB)</small>
                                                            </div>
                                                        </div>

                                                        {{-- Footer --}}
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm fw-semibold">Kirim & Tandai
                                                                Selesai</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ==================== END MODAL ==================== --}}

                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fa-inbox fs-4"></i> <br>
                                            Belum ada data pembayaran payroll.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </x-app-layout>
    @endsection
