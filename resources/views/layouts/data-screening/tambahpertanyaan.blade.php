@extends('layouts.main')

@section('title', 'Tambah Data Screening')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center text-primary font-weight-bold mb-5">Tambah Data Screening</h1>
            </div>
        </div>

        <!-- Form Tambah Screening -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <form action="{{ route('screening.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- ID Pertanyaan -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="id_pertanyaan" class="form-label text-muted">ID Pertanyaan</label>
                                        <input type="text" name="id_pertanyaan" id="id_pertanyaan" class="form-control" value="{{ $id_pertanyaan }}" disabled>
                                    </div>
                                </div>

                                <!-- Pertanyaan -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="pertanyaan" class="form-label text-muted">Pertanyaan</label>
                                        <input type="text" name="pertanyaan" id="pertanyaan" class="form-control" placeholder="Masukkan Pertanyaan" required>
                                    </div>
                                </div>

                                <!-- Jawaban dan Jenis Jawaban (berada dalam satu baris) -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="jawaban" class="me-2">Jawaban</label>
                                        <!-- Tombol Tambah Jawaban diletakkan di bawah label Jawaban -->
                                        <button type="button" class="btn btn-outline-primary mt-2 mb-3" id="add-jawaban">Tambah Jawaban</button>
                                        <div id="jawaban-container">
                                            <div class="jawaban-item mb-3 d-flex">
                                                <input type="text" name="jawaban[]" class="form-control me-2" placeholder="Jawaban 1" required>
                                                <select name="jenis_jawaban[]" class="form-select" required>
                                                    <option value="Pilih">Pilih</option>
                                                    <option value="Tidak Paham">Tidak Paham</option>
                                                    <option value="Jelas">Jelas</option>
                                                    <option value="Kurang Jelas">Kurang Jelas</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Simpan -->
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary w-50">{{ isset($admin) ? 'Update' : 'Simpan' }}</button>
                                    <a href="{{ route('screening.index') }}" class="btn btn-secondary w-50">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Styling -->
    <style>
        .page-title {
            color: #199A8E !important;
            font-size: 32px;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-body {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 20px;
        }

        .form-label {
            font-size: 18px;
            font-weight: 600;
            color: #199A8E;
        }

        .form-control,
        .form-select {
            font-size: 16px;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease;
            margin-bottom: 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #199A8E;
            box-shadow: 0 0 10px rgba(25, 154, 142, 0.2);
        }

        .btn-primary {
            background-color: #199A8E;
            border-color: #199A8E;
            color: white;
            font-size: 18px;
            padding: 14px 28px;
            border-radius: 30px;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #15867D;
            border-color: #15867D;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #f2f6f9;
            border-color: #f2f6f9;
            color: #199A8E;
            font-size: 16px;
            border-radius: 30px;
            padding: 12px 20px;
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            color: #199A8E;
            background-color: #e6f7f3;
            border-color: #e6f7f3;
            transform: translateY(-2px);
        }

        .btn-secondary:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(25, 154, 142, 0.3);
        }

        /* Styling untuk Jawaban */
        #jawaban-container {
            margin-top: 20px;
        }

        .jawaban-item {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .jawaban-item input,
        .jawaban-item select {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
        }

        /* Tombol "Tambah Jawaban" */
        .btn-outline-primary {
            font-size: 14px;
            border-radius: 25px;
            padding: 5px 15px;
            height: auto;
            border-color: #199A8E;
            color: #199A8E;
            font-weight: bold;
        }

        .btn-outline-primary:hover {
            background-color: #e0f7ff;
            color: #199A8E;
            border-color: #199A8E;
        }

        /* Mengatur jarak antar jawaban */
        .jawaban-item + .jawaban-item {
            margin-top: 15px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .btn-primary,
            .btn-secondary {
                font-size: 14px;
                width: 100%;
                padding: 12px;
            }

            .jawaban-item {
                flex-direction: column;
            }
        }
    </style>

    <!-- JavaScript untuk menambah jawaban -->
    <script>
        document.getElementById('add-jawaban').addEventListener('click', function() {
            var jawabanContainer = document.getElementById('jawaban-container');
            var newJawabanItem = document.createElement('div');
            newJawabanItem.classList.add('jawaban-item');
            newJawabanItem.innerHTML = `
                <input type="text" name="jawaban[]" class="form-control mb-2" placeholder="Jawaban Baru" required>
                <select name="jenis_jawaban[]" class="form-select mb-2" required>
                    <option value="Pilih">Pilih</option>
                    <option value="Tidak Paham">Tidak Paham</option>
                    <option value="Jelas">Jelas</option>
                    <option value="Kurang Jelas">Kurang Jelas</option>
                </select>
            `;
            jawabanContainer.appendChild(newJawabanItem);
        });
    </script>
@endsection
