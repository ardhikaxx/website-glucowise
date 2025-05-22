<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Kesehatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">

    <!-- CSS untuk tampilan cetak -->
    <style>
        @media print {
            /* Menyembunyikan elemen selain tabel saat cetak */
            body * {
                visibility: hidden;
            }

            /* Menampilkan hanya tabel yang ada dalam wrapper */
            .table-wrapper, .table-wrapper * {
                visibility: visible;
            }

            /* Menempatkan tabel di bagian atas halaman cetak */
            .table-wrapper {
                position: absolute;
                top: 0;
                left: 0;
            }

            /* Menyembunyikan elemen yang tidak perlu dicetak */
            .header, .footer, .sidebar, .search-form, .pagination-container {
                display: none;
            }

            /* Mengatur ukuran font untuk judul saat dicetak */
            .page-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header" style="text-align: center; font-weight: bold; margin-bottom: 20px;">
        <h2>Data Kesehatan</h2>
        <h3>Dinas Kesehatan Posyandu Rambipuji</h3>
        <hr>
    </div>
    <!-- Tabel Riwayat Kesehatan -->
    <div class="table-wrapper" style="margin: 0 10px;">
        <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 10px; text-align: left;">No</th>
                    <th style="border: 1px solid black; padding: 10px; text-align: left;">Nama Lengkap</th>
                    <th style="border: 1px solid black; padding: 10px; text-align: left;">Gula Darah (mg/dl)</th>
                    <th style="border: 1px solid black; padding: 10px; text-align: left;">Tanggal Pemeriksaan</th>
                    <th style="border: 1px solid black; padding: 10px; text-align: left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatKesehatan as $data)
                    <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black; padding: 10px;">{{ $data->id_riwayat }}</td>
                        <td style="border: 1px solid black; padding: 10px;">
                            {{ $data->dataKesehatan && $data->dataKesehatan->pengguna ? $data->dataKesehatan->pengguna->nama_lengkap : 'N/A' }}
                        </td>
                        <td style="border: 1px solid black; padding: 10px;">
                            {{ $data->dataKesehatan ? $data->dataKesehatan->gula_darah : 'N/A' }}
                        </td>
                        <td style="border: 1px solid black; padding: 10px;">
                            @if($data->dataKesehatan && $data->dataKesehatan->tanggal_pemeriksaan)
                                {{ \Carbon\Carbon::parse($data->dataKesehatan->tanggal_pemeriksaan)->format('d M Y') }}
                            @else
                                Tanggal tidak tersedia
                            @endif
                        </td>
                        <td style="border: 1px solid black; padding: 10px;">
                            @if ($data->kategori_risiko == 'Rendah')
                                <span class="badge badge-success p-2">Rendah</span>
                            @elseif ($data->kategori_risiko == 'Sedang')
                                <span class="badge badge-warning p-2">Sedang</span>
                            @elseif ($data->kategori_risiko == 'Tinggi')
                                <span class="badge badge-danger p-2">Tinggi</span>
                            @else
                                <span class="badge badge-secondary p-2">Menunggu Proses</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer" style="text-align: center; margin-top: 30px; font-size: 12px;">
        <p>Posyandu Kampung Gudang, Situbondo</p>
    </div>

</body>
</html>