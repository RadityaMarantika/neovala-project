@extends('layouts.base')

@section('content')
    <x-app-layout>

        {{-- ================= HEADER ================= --}}
        <div class="card shadow-sm border-0 mb-4 hero-card text-white rounded-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center p-4">
                <h5 class="fw-bold mb-2 mb-sm-0 d-flex align-items-center">
                    <i class="fas fa-calendar-check me-2"></i> Check Absent Shift
                </h5>
                <div class="d-flex align-items-center flex-wrap gap-2">

                    <a  href="{{ route('layout-menus.karyawan') }}" class="btn btn-outline-light btn-sm fw-semibold rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- ================= FILTER PANEL ================= --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('karyawan.jadwal') }}" class="row g-3 align-items-end">

                    {{-- RANGE PILIHAN --}}
                    <div class="col-12 d-flex flex-wrap align-items-center justify-content-between mb-2">
                        <div class="btn-group" role="group">
                            <a href="{{ route('karyawan.jadwal', array_merge(request()->query(), ['range' => 7])) }}"
                                class="btn btn-light btn-sm fw-bold {{ $range == 7 ? 'active' : '' }}">
                                7 Hari
                            </a>
                            <a href="{{ route('karyawan.jadwal', array_merge(request()->query(), ['range' => 14])) }}"
                                class="btn btn-light btn-sm fw-semibold {{ $range == 14 ? 'active' : '' }}">
                                14 Hari
                            </a>
                        </div>
                        <small class="text-muted">Pilih jangkauan jadwal yang ingin ditampilkan</small>
                    </div>

                    {{-- KOLOM FILTER --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-gray-700">
                            <i class="fas fa-map-marker-alt me-1 text-secondary"></i> Lokasi
                        </label>
                        <select name="lokasi" class="form-select form-select-sm rounded shadow-sm">
                            <option value="">Semua Lokasi</option>
                            @foreach ($lokasiList as $lok)
                                <option value="{{ $lok }}" {{ request('lokasi') == $lok ? 'selected' : '' }}>
                                    {{ $lok }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-gray-700">
                            <i class="fas fa-calendar-day me-1 text-secondary"></i> Jadwal
                        </label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="form-control form-control-sm rounded shadow-sm" />
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-gray-700">
                            <i class="fas fa-user me-1 text-secondary"></i> Karyawan
                        </label>
                        <input type="text" name="nama" value="{{ request('nama') }}"
                            placeholder="Ketik nama karyawan..." class="form-control form-control-sm rounded shadow-sm" />
                    </div>

                    <div class="col-md-3 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary btn-sm fw-semibold shadow-sm">
                                <i class="fas fa-filter me-1"></i> Terapkan
                            </button>
                            <a href="{{ route('karyawan.jadwal') }}"
                                class="btn btn-light btn-sm fw-semibold border shadow-sm">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= BODY ================= --}}
        <div class="py-3" id="jadwalContainer">
            @forelse ($shifts as $lokasi => $shiftGroup)
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-primary mb-0">
                            <i class="fas fa-map-marker-alt me-2 text-info"></i> Lokasi: {{ $lokasi }}
                        </h6>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 550px;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary sticky-top">
                                    <tr>
                                        <th class="px-3 py-2">Nama</th>
                                        <th class="px-3 py-2">Divisi</th>
                                        @for ($date = $startDate->copy(); $date <= $endDate; $date->addDay())
                                            <th class="px-3 py-2 text-center">
                                                {{ $date->format('d M') }}
                                            </th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody id="karyawanTableBody">
                                    @foreach ($karyawans->where('penempatan', $lokasi) as $k)
                                        <tr class="border-bottom hover-bg-light karyawan-row">
                                            <td class="px-3 py-2 fw-semibold text-gray-800 nama-karyawan">
                                                {{ $k->nama_lengkap }}
                                            </td>
                                            <td class="px-3 py-2 text-gray-600">{{ $k->jabatan }}</td>

                                            @for ($date = $startDate->copy(); $date <= $endDate; $date->addDay())
                                                @php
                                                    $tanggalKey = $date->format('Y-m-d');
                                                    $shiftHariIni = null;
                                                    $shiftStatus = null;

                                                    if (isset($shiftGroup[$tanggalKey])) {
                                                        foreach ($shiftGroup[$tanggalKey] as $shift) {
                                                            foreach ($shift->karyawans as $ka) {
                                                                if ($ka->id === $k->id) {
                                                                    $shiftHariIni = $shift;
                                                                    $shiftStatus = $ka->pivot->status ?? null;
                                                                    break 2;
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp

                                                <td class="px-3 py-2 text-center">
                                                    @if ($shiftHariIni)
                                                        <div class="fw-bold text-dark small">
                                                            {{ $shiftHariIni->kode_shift }}
                                                        </div>
                                                        <div class="text-xs text-muted">
                                                            {{ $shiftHariIni->jenis }}<br>
                                                            {{ substr($shiftHariIni->jam_masuk_kerja, 0, 5) }} -
                                                            {{ substr($shiftHariIni->jam_pulang_kerja, 0, 5) }}
                                                        </div>
                                                        <div class="text-xs fw-semibold text-primary mt-1 cursor-pointer ubah-status"
                                                            data-pivot-id="{{ $ka->pivot->id }}">
                                                            {{ ucfirst($shiftStatus ?? '-') }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted border rounded-3 bg-light">
                    <i class="fas fa-inbox me-2"></i> Tidak ada jadwal shift ditemukan untuk periode ini.
                </div>
            @endforelse
        </div>

        {{-- ================= MODAL UBAH STATUS ================= --}}
        <div class="modal fade" id="ubahStatusModal" tabindex="-1" aria-labelledby="ubahStatusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header bg-primary text-white py-3">
                        <h5 class="modal-title fw-semibold mb-0">
                            <i class="fas fa-edit me-2"></i>Ubah Status Shift
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formUbahStatus">@csrf
                            <input type="hidden" name="pivot_id" id="pivot_id">

                            <div class="bg-light rounded p-3 mb-3">
                                <small class="text-muted d-block">Nama Karyawan</small>
                                <p id="modalNamaKaryawan" class="fw-semibold mb-2">-</p>

                                <small class="text-muted d-block">Detail Shift</small>
                                <p id="modalShiftDetail" class="fw-semibold mb-0">-</p>
                            </div>

                            <label class="form-label fw-semibold text-dark mb-2">Pilih Status</label>

                            <div class="d-grid gap-2">
                                @foreach (['bekerja', 'libur', 'izin', 'sakit'] as $status)
                                    <label class="status-option">
                                        <input type="radio" name="status" value="{{ $status }}">
                                        <span>{{ ucfirst($status) }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-light border me-2" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-1"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= STYLE ================= --}}
        <style>
            .status-option {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 14px;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                background-color: #f9fafb;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .status-option:hover {
                background-color: #eef4ff;
                border-color: #cdd9ff;
            }

            .status-option input[type="radio"] {
                appearance: none;
                width: 18px;
                height: 18px;
                border: 2px solid #6b7cff;
                border-radius: 50%;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .status-option input[type="radio"]:checked {
                background-color: #4f46e5;
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            }

            .status-option span {
                font-weight: 500;
                color: #1f2937;
                font-size: 0.95rem;
            }
        </style>

        {{-- ================= SCRIPT ================= --}}
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const searchInput = document.getElementById("searchKaryawan");
                if (searchInput) {
                    searchInput.addEventListener("keyup", function() {
                        const val = this.value.toLowerCase();
                        document.querySelectorAll(".karyawan-row").forEach(row => {
                            const nama = row.querySelector(".nama-karyawan")?.textContent
                                .toLowerCase() || "";
                            row.style.display = nama.includes(val) ? "" : "none";
                        });
                    });
                }

                const modalElement = document.getElementById("ubahStatusModal");
                const form = document.getElementById("formUbahStatus");
                const pivotInput = document.getElementById("pivot_id");
                const modalNama = document.getElementById("modalNamaKaryawan");
                const modalShift = document.getElementById("modalShiftDetail");
                const modal = new bootstrap.Modal(modalElement);

                document.querySelectorAll(".ubah-status").forEach(el => {
                    el.addEventListener("click", function() {
                        const pivotId = this.dataset.pivotId;
                        const row = this.closest("tr");
                        const nama = row.querySelector(".nama-karyawan")?.textContent.trim() || "-";
                        const shiftKode = this.closest("td").querySelector(".fw-bold")?.textContent
                            .trim() || "-";

                        pivotInput.value = pivotId;
                        modalNama.textContent = nama;
                        modalShift.textContent = shiftKode;
                        modal.show();
                    });
                });

                form.addEventListener("submit", async e => {
                    e.preventDefault();
                    const pivotId = pivotInput.value;
                    const status = document.querySelector('input[name="status"]:checked')?.value;

                    if (!status) return alert("Pilih status terlebih dahulu!");

                    try {
                        const response = await fetch("{{ route('karyawan.updateStatus') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                "Accept": "application/json",
                            },
                            body: JSON.stringify({
                                pivot_id: pivotId,
                                status
                            }),
                        });
                        const result = await response.json();
                        if (result.success) {
                            modal.hide();
                            alert(result.message);
                            location.reload();
                        } else alert("Gagal: " + (result.message || "Terjadi kesalahan."));
                    } catch (error) {
                        console.error(error);
                        alert("Terjadi kesalahan koneksi ke server!");
                    }
                });
            });
        </script>

    </x-app-layout>
@endsection
