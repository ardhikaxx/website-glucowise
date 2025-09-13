@extends('layouts.main')

@section('title', 'Riwayat Kesehatan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;"><i
                        class="fa fa-clipboard-list me-1" style="color: #34B3A0;"></i>Rekam Medis</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('riwayatKesehatan.search') }}" method="GET"
                                    class="search-form float-right">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control search-input"
                                            placeholder="Cari Data Kesehatan" value="{{ request()->search }}">
                                        <button type="submit" class="btn btn-search">
                                            <i class="fa fa-search me-1"></i>Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Gula Darah(mg/dl)</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($riwayatKesehatan->count() > 0)
                                        @foreach ($riwayatKesehatan as $data)
                                            <tr class="table-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->nama_lengkap }}</td>
                                                <td>{{ $data->gula_darah }} mg/dl</td>
                                                <td>
                                                    @if ($data->tanggal_pemeriksaan)
                                                        {{ \Carbon\Carbon::parse($data->tanggal_pemeriksaan)->locale('id')->translatedFormat('d F Y') }}
                                                    @else
                                                        Tanggal tidak tersedia
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->kategori_risiko == 'Rendah')
                                                        <span class="badge badge-success p-2">Rendah</span>
                                                    @elseif ($data->kategori_risiko == 'Sedang')
                                                        <span class="badge badge-warning p-2">Sedang</span>
                                                    @elseif ($data->kategori_risiko == 'Tinggi')
                                                        <span class="badge badge-danger p-2">Tinggi</span>
                                                    @else
                                                        <span class="badge badge-secondary p-2"><i
                                                                class="fa fa-clock me-1"></i>Menunggu Proses</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('riwayatKesehatan.show', $data->nik) }}"
                                                        class="btn btn-info"> <i
                                                            class="fa fa-info-circle me-1"></i>Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="no-data-message">
                                                    <i class="fa fa-file-medical-alt fa-3x mb-3"
                                                        style="color: #34B3A0;"></i>
                                                    <h4 style="color: #34B3A0;">Tidak Ada Data Rekam Medis</h4>
                                                    @if (request()->search)
                                                        <p>Pencarian untuk "<strong>{{ request()->search }}</strong>" tidak
                                                            ditemukan.</p>
                                                        <a href="{{ route('riwayatKesehatan.index') }}"
                                                            class="btn btn-primary mt-2">
                                                            <i class="fa fa-arrow-left me-1"></i>Kembali ke Semua Data
                                                        </a>
                                                    @else
                                                        <p>Belum ada data rekam medis yang tersedia dalam sistem.</p>
                                                        <p class="small text-muted">Data rekam medis akan muncul setelah
                                                            pengguna melakukan pemeriksaan kesehatan dan data diproses.</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination - Hanya tampilkan jika ada data -->
                        @if ($riwayatKesehatan->count() > 0)
                            <div class="pagination-container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item {{ $riwayatKesehatan->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $riwayatKesehatan->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        @foreach ($riwayatKesehatan->links()->elements[0] as $page => $url)
                                            <li
                                                class="page-item {{ $riwayatKesehatan->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <li class="page-item {{ $riwayatKesehatan->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $riwayatKesehatan->nextPageUrl() }}"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                iconColor: '#34B3A0',
                showCancelButton: true,
                confirmButtonColor: '#34B3A0',
                cancelButtonColor: '#6c757d',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        </script>
    @endif

    <script src="{{ asset('js/Data-kesehatan/Data-kesehatan.js') }}"></script>
@endsection
