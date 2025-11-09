<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Saldo Petty Cash</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>Laporan Saldo Petty Cash</h2>
    <p>Periode:
        {{ $tanggal_awal ? \Carbon\Carbon::parse($tanggal_awal)->translatedFormat('d F Y') : '-' }}
        s/d
        {{ $tanggal_akhir ? \Carbon\Carbon::parse($tanggal_akhir)->translatedFormat('d F Y') : '-' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ ucfirst($t->jenis_transaksi) }}</td>
                    <td>{{ $t->asal->nama_pettycash ?? '-' }}</td>
                    <td>{{ $t->tujuan->nama_pettycash ?? '-' }}</td>
                    <td class="right">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                    <td>{{ $t->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
