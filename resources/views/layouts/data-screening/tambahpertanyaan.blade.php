@extends('layouts.main')

@section('title', isset($pertanyaan) ? 'Edit Data Screening' : 'Tambah Data Screening')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center text-primary font-weight-bold mb-5">{{ isset($pertanyaan) ? 'Edit Data Screening' : 'Tambah Data Screening' }}</h1>
            </div>
        </div>

        <!-- Form Tambah/Edit Screening -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <!-- Form -->
                        <form action="{{ isset($pertanyaan) ? route('screening.update', $pertanyaan->id_pertanyaan) : route('screening.store') }}" method="POST">
                            @csrf
                            @if(isset($pertanyaan))
                                @method('PUT') <!-- Menandakan bahwa ini adalah request PUT untuk update -->
                            @endif
                            <div class="row">
                                <!-- ID Pertanyaan -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="id_pertanyaan" class="form-label text-muted">ID Pertanyaan</label>
                                        <input type="hidden" name="id_pertanyaan" id="id_pertanyaan" value="{{ isset($pertanyaan) ? $pertanyaan->id_pertanyaan : $id_pertanyaan }}">
                                        <input type="text" class="form-control" value="{{ isset($pertanyaan) ? $pertanyaan->id_pertanyaan : $id_pertanyaan }}" disabled>
                                    </div>
                                </div>
                        
                                <!-- Pertanyaan -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="pertanyaan" class="form-label text-muted">Pertanyaan</label>
                                        <input type="text" name="pertanyaan" id="pertanyaan" class="form-control" placeholder="Masukkan Pertanyaan" value="{{ isset($pertanyaan) ? $pertanyaan->pertanyaan : old('pertanyaan') }}" required>
                                    </div>
                                </div>
                        
                                <!-- Jawaban dan Skoring -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="jawaban" class="me-2">Jawaban</label>
                                        <button type="button" class="btn btn-outline-primary mt-2 mb-3" id="add-jawaban">Tambah Jawaban</button>
                                        <div id="jawaban-container">
                                            @if(isset($pertanyaan))
                                                @foreach($pertanyaan->jawabanScreening as $jawaban)
                                                    <div class="jawaban-item mb-3 d-flex">
                                                        <select name="jawaban[]" class="form-select mb-2" required>
                                                            <option value="Tidak Pernah" {{ $jawaban->jawaban == 'Tidak Pernah' ? 'selected' : '' }}>Tidak Pernah</option>
                                                            <option value="Jarang" {{ $jawaban->jawaban == 'Jarang' ? 'selected' : '' }}>Jarang</option>
                                                            <option value="Sering" {{ $jawaban->jawaban == 'Sering' ? 'selected' : '' }}>Sering</option>
                                                            <option value="Selalu" {{ $jawaban->jawaban == 'Selalu' ? 'selected' : '' }}>Selalu</option>
                                                        </select>
                                                        <input type="number" name="skoring[]" class="form-control me-2" placeholder="Skoring" value="{{ explode('(', rtrim($jawaban->jawaban, ')'))[1] ?? '' }}" required>
                                                        <!-- Tombol minus untuk menghapus jawaban -->
                                                        <button type="button" class="btn btn-danger btn-sm remove-jawaban">-</button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="jawaban-item mb-3 d-flex">
                                                    <select name="jawaban[]" class="form-select mb-2" required>
                                                        <option value="Tidak Pernah">Tidak Pernah</option>
                                                        <option value="Jarang">Jarang</option>
                                                        <option value="Sering">Sering</option>
                                                        <option value="Selalu">Selalu</option>
                                                    </select>
                                                    <input type="number" name="skoring[]" class="form-control me-2" placeholder="Skoring" required>
                                                    <!-- Tombol minus untuk menghapus jawaban -->
                                                    <button type="button" class="btn btn-danger btn-sm remove-jawaban" style="display:none;">-</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Tombol Simpan -->
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary w-50">{{ isset($pertanyaan) ? 'Update' : 'Simpan' }}</button>
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

    <!-- JavaScript untuk menambah dan menghapus jawaban -->
    <script>
      document.getElementById('add-jawaban').addEventListener('click', function() {
    var jawabanContainer = document.getElementById('jawaban-container');
    var newJawabanItem = document.createElement('div');
    newJawabanItem.classList.add('jawaban-item');
    newJawabanItem.innerHTML = `
        <select name="jawaban[]" class="form-select mb-2" required>
            <option value="Tidak Pernah">Tidak Pernah</option>
            <option value="Jarang">Jarang</option>
            <option value="Sering">Sering</option>
            <option value="Selalu">Selalu</option>
        </select>
        <input type="number" name="skoring[]" class="form-control mb-2" placeholder="Skoring" required>
        <button type="button" class="btn btn-danger btn-sm remove-jawaban">-</button>
    `;
    jawabanContainer.appendChild(newJawabanItem);

    // Menampilkan tombol minus jika lebih dari satu jawaban
    var jawabanItems = document.querySelectorAll('.jawaban-item');
    jawabanItems.forEach(function(item, index) {
        if (jawabanItems.length > 1) {
            item.querySelector('.remove-jawaban').style.display = 'inline-block';
        }
    });
});

// Menghapus jawaban saat tombol minus diklik
document.getElementById('jawaban-container').addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-jawaban')) {
        e.target.closest('.jawaban-item').remove();

        // Menyembunyikan tombol minus jika hanya ada satu jawaban
        var jawabanItems = document.querySelectorAll('.jawaban-item');
        jawabanItems.forEach(function(item, index) {
            if (jawabanItems.length <= 1) {
                item.querySelector('.remove-jawaban').style.display = 'none';
            }
        });
    }
});
    </script>
@endsection