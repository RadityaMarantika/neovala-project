<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Petty Cash - {{ $pettycash->nama_pettycash }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
            margin: 20px;
        }

        .kop {
            text-align: center;
            border-bottom: 2px solid #111;
            margin-bottom: 12px;
            padding-bottom: 6px;
        }

        .kop img {
            width: 55px;
            vertical-align: middle;
            margin-right: 10px;
            opacity: 0.9;
        }

        .company {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .address {
            font-size: 10px;
            color: #555;
        }

        .title {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            margin-bottom: 10px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 10.5px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 8px;
        }

        th {
            background: #f3f3f3;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 9px;
            color: #777;
        }

        .no-data {
            text-align: center;
            padding: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="kop">
        @php
            $logoPath = public_path('assets/img/logo_ldp.png');
            $logoBase64 = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
        @endphp
        @if ($logoBase64)
            <img src="data:image/png;base64,{{ $logoBase64 }}" alt="logo">
        @endif
        <div class="company">PT Lavanaa Deva Perkasa</div>
        <div class="address">Pondok Pekayon Indah, CC No.42/16, RT.04/RW.018, Pekayon Jaya, Kec. Bekasi Sel., Kota Bks,
            Jawa Barat 17148</div>
    </div>

    <div class="title">LAPORAN PETTY CASH</div>
    <div class="subtitle">
        <strong>{{ strtoupper($pettycash->nama_pettycash) }}</strong><br>
        Periode: {{ $periodeAwal }} s.d {{ $periodeAkhir }}
    </div>

    {{-- Rangkuman --}}
    <table style="margin-bottom:10px;">
        <tr>
            <th>Saldo Awal</th>
            <th>Total Pemasukan</th>
            <th>Total Pengeluaran</th>
            <th>Saldo Akhir</th>
        </tr>
        <tr>
            <td class="text-right">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($totalIn, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($totalOut, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- Tabel transaksi --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Nominal (Rp)</th>
                <th>Saldo Berjalan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $idx => $it)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $it->date->translatedFormat('d M Y') }}</td>
                    <td class="text-center">{{ $it->jenis }}</td>
                    <td>{{ $it->keterangan }}</td>
                    <td class="text-right">{{ number_format($it->nominal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($it->saldo_berjalan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-data">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada: {{ $printedAt }}</div>
</body>

</html>
