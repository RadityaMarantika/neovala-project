@extends('layouts.base')

@section('content')
    <style>
        body,
        * {
            font-size: 12px !important;
        }

        .unit-card {
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            transition: .25s;
            border: none;
        }

        .unit-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.10);
        }

        .period-header {
            cursor: pointer;
            padding: 12px 16px;
            border-radius: 10px;
            background: #f3f6ff;
            border: 1px solid #d8def5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: .2s;
        }

        .period-header:hover {
            background: #e8edff;
        }

        .period-status {
            font-size: 10px !important;
            padding: 3px 8px !important;
            border-radius: 6px;
        }

        .rotate {
            transition: .3s;
        }

        .rotate.open {
            transform: rotate(180deg);
        }

        /* TABLE STYLE */
        .styled-table {
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
            width: 100%;
        }

        .styled-table thead tr {
            background-color: #eef2ff;
            border-radius: 10px;
        }

        .styled-table thead th {
            padding: 10px;
        }

        .styled-table tbody tr {
            background: #ffffff;
            border-radius: 8px;
            transition: 0.2s;
        }

        .styled-table tbody tr:hover {
            background: #f8f9ff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .styled-table td {
            padding: 10px;
            border-top: 1px solid #f0f0f5;
        }

        .badge {
            padding: 4px 8px !important;
            font-size: 11px !important;
            border-radius: 6px;
        }

        .btn-sm {
            padding: 4px 10px !important;
            font-size: 11px !important;
            border-radius: 6px !important;
        }

        .search-box {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #cfd6ea;
        }
    </style>


    <x-app-layout>

        {{-- Header --}}
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="fw-bold text-primary mb-0">List Data Hutang</h2>
            </div>
        </x-slot>
        <br>

        {{-- SEARCH --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <input id="searchInput" type="text" class="form-control search-box"
                    placeholder="🔍 Cari unit / nama / periode / status...">
            </div>
        </div>


        @php
            $groupedUnits = $hutangs->groupBy(fn($h) => $h->sewa->unit->no_unit);
        @endphp

        @foreach ($groupedUnits as $unitNumber => $list)
            @php
                $unit = $list->first()->sewa->unit;
                $groupByPeriode = $list->groupBy(function ($i) {
                    return \Carbon\Carbon::parse($i->tempo_unit)->format('Y-m');
                });
            @endphp

            <div class="card unit-card mb-4 unit-card-wrapper">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Unit {{ $unitNumber }} — {{ $unit->nama_lengkap }}</h5>
                </div>

                <div class="card-body">

                    @foreach ($groupByPeriode as $periode => $items)
                        @php
                            $row = $items->first();
                            $periodeTxt = \Carbon\Carbon::parse($periode . '-01')->translatedFormat('F Y');
                            $collapseId = 'collapse_' . $unitNumber . '_' . $periode;

                            // STATUS DONE / UNDONE
                            $allPaid =
                                $row->pay_unit == 'Paid' &&
                                $row->pay_utl == 'Paid' &&
                                $row->pay_ipl == 'Paid' &&
                                $row->pay_wifi == 'Paid';
                        @endphp

                        {{-- HEADER PERIODE --}}
                        <div class="period-header mb-2" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}">
                            <span class="fw-semibold">{{ $periodeTxt }}</span>

                            <div class="d-flex align-items-center gap-2">
                                @if ($allPaid)
                                    <span class="badge bg-success text-white period-status">DONE</span>
                                @else
                                    <span class="badge bg-danger text-white period-status">UNDONE</span>
                                @endif
                                <i class="bi bi-chevron-down rotate"></i>
                            </div>
                        </div>

                        {{-- DETAIL --}}
                        <div id="{{ $collapseId }}" class="collapse mb-3">

                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Tempo</th>
                                        <th>Status</th>
                                        <th width="130">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    {{-- UNIT --}}
                                    <tr>
                                        <td><b>Unit</b></td>
                                        <td
                                            class="{{ \Carbon\Carbon::parse($row->tempo_unit)->isPast() ? 'text-danger fw-bold' : '' }}">
                                            {{ $row->tempo_unit }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $row->pay_unit == 'Paid' ? 'success' : 'danger' }}">
                                                {{ $row->pay_unit }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('master_unit_hutangs.edit', $row->id) }}"
                                                class="btn btn-primary btn-sm w-100">Bayar</a>
                                        </td>
                                    </tr>

                                    {{-- UTL --}}
                                    <tr>
                                        <td><b>UTL</b></td>
                                        <td
                                            class="{{ \Carbon\Carbon::parse($row->tempo_utl)->isPast() ? 'text-danger fw-bold' : '' }}">
                                            {{ $row->tempo_utl }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $row->pay_utl == 'Paid' ? 'success' : 'danger' }}">
                                                {{ $row->pay_utl }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('master_unit_hutangs.edit', $row->id) }}"
                                                class="btn btn-primary btn-sm w-100">Bayar</a>
                                        </td>
                                    </tr>

                                    {{-- IPL --}}
                                    <tr>
                                        <td><b>IPL</b></td>
                                        <td
                                            class="{{ \Carbon\Carbon::parse($row->tempo_ipl)->isPast() ? 'text-danger fw-bold' : '' }}">
                                            {{ $row->tempo_ipl }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $row->pay_ipl == 'Paid' ? 'success' : 'danger' }}">
                                                {{ $row->pay_ipl }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('master_unit_hutangs.edit', $row->id) }}"
                                                class="btn btn-primary btn-sm w-100">Bayar</a>
                                        </td>
                                    </tr>

                                    {{-- WIFI --}}
                                    <tr>
                                        <td><b>Wifi</b></td>
                                        <td
                                            class="{{ \Carbon\Carbon::parse($row->tempo_wifi)->isPast() ? 'text-danger fw-bold' : '' }}">
                                            {{ $row->tempo_wifi }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $row->pay_wifi == 'Paid' ? 'success' : 'danger' }}">
                                                {{ $row->pay_wifi }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('master_unit_hutangs.edit', $row->id) }}"
                                                class="btn btn-primary btn-sm w-100">Bayar</a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach


        <script>
            // SEARCH
            document.getElementById('searchInput').addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();

                document.querySelectorAll('.unit-card-wrapper').forEach(card => {
                    card.style.display = card.innerText.toLowerCase().includes(keyword) ? "" : "none";
                });
            });

            // ROTATE ICON WHEN COLLAPSED
            document.querySelectorAll('.period-header').forEach(header => {
                header.addEventListener('click', function() {
                    this.querySelector('.rotate').classList.toggle('open');
                });
            });
        </script>

    </x-app-layout>
@endsection
