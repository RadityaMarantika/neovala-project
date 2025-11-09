<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center">Laporan Absensi Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Denda Masuk (Telat)</th>
                <th>Denda Masuk (Alfa)</th>
                <th>Denda Pulang (Telat)</th>
                <th>Denda Pulang (Tidak Absen)</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $row)
                <tr>
                    <td>{{ $row['nama'] }}</td>
                    <td>Rp {{ number_format($row['denda_masuk_telat'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row['denda_masuk_alfa'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row['denda_pulang_telat'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row['denda_pulang_kosong'], 0, ',', '.') }}</td>
                    <td><b>Rp {{ number_format($row['total_denda'], 0, ',', '.') }}</b></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
