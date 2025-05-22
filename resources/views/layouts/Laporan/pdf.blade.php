<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Riwayat Kesehatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h4 {
            text-align: center;
            color: #34B3A0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .bold {
            font-weight: bold;
        }
        .border-table {
            width: 100%;
            border-collapse: collapse;
        }

        .border-table, .border-table th, .border-table td {
            border: 1px solid black;  /* Menambahkan border di sekitar tabel dan sel */
        }

        .border-table th, .border-table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h1>Detail Riwayat Kesehatan - NIK: {{ $pengguna->nik }}</h1>

    <table>
        <tr>
            <th class="bold">NIK</th>
            <td>{{ $pengguna->nik }}</td>
        </tr>
        <tr>
            <th class="bold">Nama Lengkap</th>
            <td>{{ $pengguna->nama_lengkap }}</td>
        </tr>
        <tr>
            <th class="bold">Alamat Lengkap</th>
            <td>{{ $pengguna->alamat_lengkap }}</td>
        </tr>
        <tr>
            <th class="bold">Umur</th>
            <td>{{ $umur }}</td>
        </tr>
    </table>

    <h4>Detail Kesehatan</h4>
    @foreach ($latestDataPerMonth as $month => $dataPerMonth)
        <h4>Bulan: {{ $month }}</h4>
        <table class="border-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pemeriksaan</th>
                    <th>Tinggi Badan</th>
                    <th>Berat Badan</th>
                    <th>Gula Darah</th>
                    <th>Lingkar Pinggang</th>
                    <th>Tensi Darah</th>
                    <th>Kategori Resiko</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @php
                $counter = 1;
                @endphp
                @foreach ($dataPerMonth as $data)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $data->tanggal_pemeriksaan }}</td>
                    <td>{{ $data->tinggi_badan }}</td>
                    <td>{{ $data->berat_badan }}</td>
                    <td>{{ $data->gula_darah }}</td>
                    <td>{{ $data->lingkar_pinggang }}</td>
                    <td>{{ $data->tensi_darah }}</td>
                    <td>{{ $data->kategori_risiko }}</td>
                    <td>{{ $data->catatan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>
