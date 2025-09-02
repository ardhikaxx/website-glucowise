<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekam Medis - {{ $pengguna->nama_lengkap }}</title>
    <style>
        @page {
            margin: 1.2cm;
            size: A4 portrait;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #2c3e50;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .container {
            position: relative;
            max-width: 100%;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            opacity: 0.03;
            color: #199A8E;
            pointer-events: none;
            z-index: -1;
            font-weight: bold;
            font-family: 'Arial', sans-serif;
        }

        .qr-top-right {
            position: absolute;
            top: -20px;
            right: 0;
            text-align: center;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
            width: 100px;
            z-index: 10;
        }

        .qr-title {
            font-weight: bold;
            color: #199A8E;
            margin-bottom: 5px;
            font-size: 9px;
            text-transform: uppercase;
        }

        .qr-info {
            font-size: 7px;
            color: #7f8c8d;
            margin-top: 5px;
            line-height: 1.2;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #199A8E;
            padding-right: 110px;
        }

        .clinic-info {
            flex: 2;
            margin-bottom: 10px;
        }

        .clinic-name {
            font-size: 20px;
            font-weight: bold;
            color: #199A8E;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .clinic-address {
            font-size: 11px;
            color: #7f8c8d;
            margin-bottom: 3px;
        }

        .clinic-contact {
            font-size: 11px;
            color: #7f8c8d;
        }

        .document-title {
            flex: 1;
            text-align: left;
        }

        .document-title h1 {
            color: #2c3e50;
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .document-title h2 {
            color: #199A8E;
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .header-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .header-detail-item {
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: #f9f9f9;
            min-width: 160px;
            margin-bottom: 8px;
        }

        .header-detail-label {
            font-size: 10px;
            color: #7f8c8d;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-detail-value {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
        }

        .patient-info-section {
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .section-header {
            background-color: #199A8E;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
        }

        .patient-info {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-info tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .patient-info th {
            background-color: #f1f9f8;
            text-align: left;
            padding: 10px 12px;
            width: 18%;
            border: 1px solid #e0e0e0;
            font-weight: 600;
            color: #199A8E;
        }

        .patient-info td {
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
        }

        .medical-data-section {
            margin: 25px 0;
        }

        .month-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .month-header {
            background-color: #147a70;
            color: white;
            padding: 8px 12px;
            margin-bottom: 12px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 4px;
        }

        .medical-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .medical-table th {
            background-color: #e6f3f2;
            color: #147a70;
            padding: 10px 8px;
            text-align: center;
            border: 1px solid #d0e6e3;
            font-weight: bold;
        }

        .medical-table td {
            padding: 10px 8px;
            border: 1px solid #e0e0e0;
            text-align: center;
            vertical-align: top;
        }

        .medical-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .medical-note {
            text-align: left;
            padding: 8px;
            background-color: #f8f9fa;
            border-left: 3px solid #199A8E;
            margin: 5px 0;
            border-radius: 0 4px 4px 0;
        }

        .risk-low {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 20px;
            display: inline-block;
            font-size: 10px;
        }

        .risk-medium {
            background-color: #fff3cd;
            color: #856404;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 20px;
            display: inline-block;
            font-size: 10px;
        }

        .risk-high {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 20px;
            display: inline-block;
            font-size: 10px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            font-style: italic;
            color: #95a5a6;
            border: 1px dashed #d0e6e3;
            margin: 20px 0;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .document-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }

        .page-number {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            padding: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="watermark">GLUCOWISE</div>
        <div class="qr-top-right">
            <div class="qr-title">KODE VERIFIKASI</div>
            <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code Rekam Medis" width="100"
                height="100">
            <div class="qr-info">
                Scan untuk verifikasi keaslian dokumen
            </div>
        </div>

        <div class="header">
            <div class="clinic-info">
                <div class="clinic-name">GLUCOWISE MEDICAL CLINIC</div>
                <div class="clinic-address">Jl. Kesehatan No. 123, Jakarta Selatan</div>
                <div class="clinic-contact">Telp: (021) 765-4321 | Email: info@glucowise.com</div>
            </div>
            <div class="document-title">
                <h1>LAPORAN REKAM MEDIS</h1>
                <h2>Detail Riwayat Kesehatan Pasien</h2>
            </div>
        </div>

        <div class="header-details">
            <div class="header-detail-item">
                <div class="header-detail-label">NOMOR REKAM MEDIS</div>
                <div class="header-detail-value">RM{{ date('Y') }}{{ sprintf('%04d', $pengguna->nik) }}</div>
            </div>
            <div class="header-detail-item">
                <div class="header-detail-label">TANGGAL CETAK</div>
                <div class="header-detail-value">{{ date('d F Y') }}</div>
            </div>
            <div class="header-detail-item">
                <div class="header-detail-label">DOKUMEN</div>
                <div class="header-detail-value">Laporan Medis Digital</div>
            </div>
        </div>

        <div class="patient-info-section">
            <div class="section-header">INFORMASI PASIEN</div>
            <table class="patient-info">
                <tr>
                    <th>NIK</th>
                    <td>{{ $pengguna->nik }}</td>
                    <th>Jenis Kelamin</th>
                    <td>{{ $pengguna->jenis_kelamin ?? 'Tidak tercantum' }}</td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $pengguna->nama_lengkap }}</td>
                    <th>Email</th>
                    <td>{{ $pengguna->email ?? 'Tidak tercantum' }}</td>
                </tr>
                <tr>
                    <th>Alamat Lengkap</th>
                    <td>{{ $pengguna->alamat_lengkap }}</td>
                    <th>Usia</th>
                    <td>{{ $umur }} tahun</td>
                </tr>
            </table>
        </div>

        <div class="medical-data-section">
            <div class="section-header">DATA PEMERIKSAAN MEDIS</div>

            @if (count($latestDataPerMonth) > 0)
                @foreach ($latestDataPerMonth as $month => $dataPerMonth)
                    @php
                        $dateObj = \Carbon\Carbon::createFromFormat('Y-m', $month)->locale('id');
                        $formattedMonth = $dateObj->translatedFormat('F Y');
                    @endphp


                    <div class="month-section">
                        <div class="month-header">Bulan: {{ $formattedMonth }}</div>

                        <table class="medical-table">
                            <thead>
                                <tr>
                                    <th width="4%">No</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="8%">Tinggi (cm)</th>
                                    <th width="8%">Berat (kg)</th>
                                    <th width="8%">IMT</th>
                                    <th width="10%">Gula Darah</th>
                                    <th width="10%">Lingkar Pinggang</th>
                                    <th width="10%">Tensi Darah</th>
                                    <th width="12%">Kategori Resiko</th>
                                    <th width="20%">Catatan Medis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($dataPerMonth as $data)
                                    @php
                                        // Hitung IMT
                                        $tinggi_m = $data->tinggi_badan / 100;
                                        $imt =
                                            $tinggi_m > 0
                                                ? number_format($data->berat_badan / ($tinggi_m * $tinggi_m), 1)
                                                : 0;

                                        // Tentukan kelas risiko untuk styling
                                        $riskClass = 'risk-low';
                                        if (strpos(strtolower($data->kategori_risiko), 'sedang') !== false) {
                                            $riskClass = 'risk-medium';
                                        } elseif (strpos(strtolower($data->kategori_risiko), 'tinggi') !== false) {
                                            $riskClass = 'risk-high';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>{{ date('d M Y', strtotime($data->tanggal_pemeriksaan)) }}</td>
                                        <td>{{ $data->tinggi_badan }}</td>
                                        <td>{{ $data->berat_badan }}</td>
                                        <td>{{ $imt }}</td>
                                        <td>{{ $data->gula_darah }} mg/dL</td>
                                        <td>{{ $data->lingkar_pinggang }} cm</td>
                                        <td>{{ $data->tensi_darah }} mmHg</td>
                                        <td><span class="{{ $riskClass }}">{{ $data->kategori_risiko }}</span></td>
                                        <td>
                                            <div class="medical-note">
                                                {{ $data->catatan ?: 'Tidak ada catatan' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @else
                <div class="no-data">
                    Tidak ada data pemeriksaan medis untuk pasien ini.
                </div>
            @endif
        </div>

        <div class="document-footer">
            Dokumen ini dicetak secara elektronik dan tidak memerlukan tanda tangan basah.<br>
            Hak Cipta © {{ date('Y') }} GlucoWise Medical Clinic - All Rights Reserved.
        </div>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $size = 9;
            $font = $fontMetrics->getFont("Segoe UI");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 25;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>
