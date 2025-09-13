@extends('layouts.main')

@section('title', isset($dataEdukasi->id_edukasi) ? 'Edit Edukasi' : 'Tambah Edukasi')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/edukasi/edit-edukasi.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .custom-swal-popup {
            border-radius: 15px;
        }

        .swal2-icon.swal2-error {
            border-color: #dc3545;
            color: #dc3545;
        }

        .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
            background-color: #dc3545;
        }

        .swal2-confirm {
            background-color: #34B3A0 !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center">{{ isset($dataEdukasi->id_edukasi) ? 'Edit Edukasi' : 'Tambah Edukasi' }}
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ isset($dataEdukasi->id_edukasi) ? route('edukasi.update', $dataEdukasi->id_edukasi) : route('edukasi.store') }}"
                            method="POST" enctype="multipart/form-data" id="edukasi-form">
                            @csrf
                            @if (isset($dataEdukasi->id_edukasi))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="judul" class="form-label">Judul Edukasi</label>
                                        <input type="text" name="judul" id="judul" class="form-control"
                                            value="{{ old('judul', $dataEdukasi->judul ?? '') }}"
                                            placeholder="Masukkan Judul Edukasi">
                                        @error('judul')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi" class="form-label">Deskripsi Edukasi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" placeholder="Masukkan Deskripsi Edukasi">{{ old('deskripsi', $dataEdukasi->deskripsi ?? '') }}</textarea>
                                        @error('deskripsi')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control">
                                            <option value="">Pilih Kategori</option>
                                            <option value="Dasar Diabetes"
                                                {{ old('kategori', $dataEdukasi->kategori ?? '') == 'Dasar Diabetes' ? 'selected' : '' }}>
                                                Dasar Diabetes</option>
                                            <option value="Manajemen Diabetes"
                                                {{ old('kategori', $dataEdukasi->kategori ?? '') == 'Manajemen Diabetes' ? 'selected' : '' }}>
                                                Manajemen Diabetes</option>
                                        </select>
                                        @error('kategori')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="form-group text-left mt-3" id="button-container">
                                        <button type="submit" class="btn btn-primary" id="submit-button">
                                            {{ isset($dataEdukasi->id_edukasi) ? 'Simpan Perubahan' : 'Tambah Edukasi' }}
                                        </button>
                                        <a href="{{ route('edukasi.index') }}" class="btn btn-secondary"
                                            style="margin-left: 10px;">Kembali</a>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gambar" class="form-label">Upload Gambar</label>
                                        <input type="file" name="gambar" id="gambar" class="form-control-file"
                                            accept="image/*" onchange="validateImageSize(event)">
                                        <small id="image-warning" class="form-text text-danger" style="display:none;">Ukuran
                                            gambar tidak boleh lebih dari 2MB.</small>
                                        @error('gambar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Preview Gambar -->
                                    <div class="form-group">
                                        <div id="image-container">
                                            @if (isset($dataEdukasi->gambar) && $dataEdukasi->gambar)
                                                <img id="preview" src="{{ asset($dataEdukasi->gambar) }}"
                                                    alt="Foto Edukasi" class="img-fluid"
                                                    style="width: 100%; border-radius: 8px;">
                                            @else
                                                <img id="preview" src="" alt="No image available"
                                                    class="img-fluid"
                                                    style="width: 100%; border-radius: 8px; display: none;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        // Validasi ukuran gambar
        function validateImageSize(event) {
            const file = event.target.files[0];
            const warningElement = document.getElementById('image-warning');
            const preview = document.getElementById('preview');

            if (file && file.size > 2 * 1024 * 1024) { // 2MB
                warningElement.style.display = 'block';
                event.target.value = ''; // Clear the file input

                // SweetAlert untuk error
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Gambar Terlalu Besar',
                    text: 'Ukuran gambar tidak boleh lebih dari 2MB. Silakan pilih gambar lain.',
                    confirmButtonColor: '#34B3A0',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            } else {
                warningElement.style.display = 'none';

                // Preview gambar
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            }
        }

        // Validasi form sebelum submit
        document.getElementById('edukasi-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const judul = document.getElementById('judul').value.trim();
            const deskripsi = document.getElementById('deskripsi').value.trim();
            const kategori = document.getElementById('kategori').value;
            const fileInput = document.getElementById('gambar');
            const isEditMode = {{ isset($dataEdukasi->id_edukasi) ? 'true' : 'false' }};
            const hasExistingImage = {{ isset($dataEdukasi->gambar) && $dataEdukasi->gambar ? 'true' : 'false' }};

            // Validasi judul
            if (!judul) {
                Swal.fire({
                    icon: 'error',
                    title: 'Judul Harus Diisi',
                    text: 'Silakan masukkan judul edukasi',
                    confirmButtonColor: '#34B3A0',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                document.getElementById('judul').focus();
                return;
            }

            // Validasi deskripsi
            if (!deskripsi) {
                Swal.fire({
                    icon: 'error',
                    title: 'Deskripsi Harus Diisi',
                    text: 'Silakan masukkan deskripsi edukasi',
                    confirmButtonColor: '#34B3A0',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                document.getElementById('deskripsi').focus();
                return;
            }

            // Validasi kategori
            if (!kategori) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kategori Harus Dipilih',
                    text: 'Silakan pilih kategori edukasi',
                    confirmButtonColor: '#34B3A0',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                document.getElementById('kategori').focus();
                return;
            }

            // Validasi gambar (hanya untuk tambah data atau jika mengubah gambar)
            if ((!isEditMode || fileInput.files.length > 0) && fileInput.files.length === 0 && !hasExistingImage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gambar Harus Diupload',
                    text: 'Silakan upload gambar untuk edukasi',
                    confirmButtonColor: '#34B3A0',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return;
            }

            // Validasi ukuran gambar
            if (fileInput.files.length > 0 && fileInput.files[0].size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Gambar Terlalu Besar',
                    text: 'Ukuran gambar tidak boleh lebih dari 2MB. Silakan pilih gambar lain.',
                    confirmButtonColor: '#34B3A0',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return;
            }

            // Jika form edit, cek apakah ada perubahan
            if (isEditMode) {
                const originalJudul = "{{ addslashes($dataEdukasi->judul ?? '') }}";
                const originalDeskripsi = "{{ addslashes($dataEdukasi->deskripsi ?? '') }}";
                const originalKategori = "{{ $dataEdukasi->kategori ?? '' }}";

                const isChanged = originalJudul !== judul ||
                    originalDeskripsi !== deskripsi ||
                    originalKategori !== kategori ||
                    fileInput.files.length > 0;

                if (!isChanged) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Perubahan',
                        text: 'Tidak ada perubahan yang dilakukan pada data edukasi.',
                        confirmButtonColor: '#34B3A0',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('edukasi.index') }}";
                        }
                    });
                    return;
                }
            }

            // Jika semua validasi berhasil, submit form
            this.submit();
        });
    </script>
@endsection
