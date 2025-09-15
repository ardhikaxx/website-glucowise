@extends('layouts.main')

@section('title', 'Detail Screening Tes')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center" style="color: #34B3A0; font-weight: 700;">Detail Hasil Screening Tes -
                    {{ $tesScreening->pengguna->nama_lengkap }}</h1>
            </div>
        </div>

        <!-- Tabel Detail Screening Tes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg rounded">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column (NIK, Nama Lengkap, Tanggal Pengisian) -->
                            <div class="col-md-8">
                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr class="table-row">
                                            <th>NIK</th>
                                            <td>{{ $tesScreening->pengguna->nik }}</td>
                                        </tr>
                                        <tr class="table-row">
                                            <th>Nama Lengkap</th>
                                            <td>{{ $tesScreening->pengguna->nama_lengkap }}</td>
                                        </tr>
                                        <tr class="table-row">
                                            <th>Tanggal Pengisian</th>
                                            <td>
                                                @if ($tesScreening->tanggal_screening)
                                                    {{ \Carbon\Carbon::parse($tesScreening->tanggal_screening)->locale('id')->translatedFormat('d F Y') }}
                                                @else
                                                    Tanggal tidak tersedia
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Right Column (Skor Risiko) -->
                            <div class="col-md-4">
                                <table class="table table-bordered ">
                                    <tbody>
                                        <!-- Skor Risiko Label -->
                                        <tr class="table-row">
                                            <th>Skor Risiko</th>
                                        </tr>
                                        <!-- Skor Risiko Value Below -->
                                        <tr class="table-row">
                                            <td class="text-center d-flex justify-content-center align-items-center gap-2">
                                                <span style="font-size: 50px; font-weight: bold; color: #34B3A0;">{{ $totalSkor }}</span> <span class="text-sm" style="font-weight: bold; color: #34B3A0;">Skor</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pertanyaan dan Jawaban -->
                        <h4 class="mt-4 text-center" style="color: #34B3A0; font-weight: 700;">Pertanyaan dan Jawaban</h4>
                        <table class="table table-bordered ">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tesScreening->hasilScreening as $index => $hasil)
                                    <tr class="table-row">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $hasil->pertanyaanScreening->pertanyaan }}</td>
                                        <td>{{ $hasil->jawaban }}</td>
                                        <td>{{ $hasil->skor }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Button Kembali (Form) -->
                        <form action="{{ route('screening.update-skor', $tesScreening->id_screening) }}" method="POST">
                            @csrf
                            @method('POST') <!-- Use POST method to trigger the update -->
                            <button type="submit" class="btn btn-primary btn-animated">Kembali</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Page Title */
        .page-title {
            color: #34B3A0;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Card Styling */
        .card {
            border-radius: 15px;
            margin-top: 30px;
        }

        .card-body {
            background-color: #F0F8FF;
            padding: 30px;
        }

        .table {
            background-color: #34B3A0;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #34B3A0;
            color: white;
            font-weight: bold;
        }

        .table td {
            background-color: #f9f9f9;
            color: #333;
            font-size: 14px;
        }

        .table tbody tr:hover {
            background-color: #e6f7f3;
        }

        /* Button Styling */
        .btn-animated {
            background-color: #34B3A0;
            color: white;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-animated:hover {
            background-color: #199A8E;
            transform: scale(1.05);
        }

        /* Table Row Animation */
        .table-row {
            border-radius: 10px;
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .table-row.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animation on Load */
        .btn-animated {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .btn-animated.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Skor Risiko Animation */
        .skor-risiko {
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 1s ease, transform 1s ease;
        }

        .skor-risiko.visible {
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Animating the table rows and buttons
            let rows = document.querySelectorAll('.table-row');
            rows.forEach(function(row, index) {
                setTimeout(function() {
                    row.classList.add('visible');
                }, index * 200);
            });

            // Animating the button
            let button = document.querySelector('.btn-animated');
            setTimeout(function() {
                button.classList.add('visible');
            }, 1000);

            // Animating the Skor Risiko value
            let skorRisiko = document.querySelector('.skor-risiko');
            setTimeout(function() {
                skorRisiko.classList.add('visible');
            }, 1500);

            // Menambahkan kelas 'active' pada menu sidebar yang relevan
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                // Periksa apakah href link mengandung bagian dari URL saat ini
                if (window.location.href.indexOf(link.href) > -1) {
                    link.classList.add('active'); // Menambahkan kelas active jika URL cocok
                } else {
                    link.classList.remove('active'); // Menghapus kelas active jika tidak cocok
                }
            });
        });
    </script>
@endsection
