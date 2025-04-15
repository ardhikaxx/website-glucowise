@extends('layouts.main')

@section('title', 'Detail Riwayat Screening')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Data-kesehatan/detail-kesehatan.css') }}">
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Detail Riwayat Screening - NIK: {{ $data->id_screening }}</h1>
        </div>
    </div>

    <!-- Tabel Detail Screening -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-animated">
                       

                    <!-- Display Screening Questions and Answers -->
                    <h4>Riwayat Screening</h4>
                    @foreach ($data->hasilScreening as $screening)
                        <div class="card mt-4">
                            <div class="card-header" data-toggle="collapse" data-target="#collapse{{ $screening->id_hasil }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link">
                                        Pertanyaan: {{ $screening->pertanyaanScreening->pertanyaan }}
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse{{ $screening->id_hasil }}" class="collapse">
                                <div class="card-body">
                                    <p><strong>Jawaban:</strong> {{ $screening->jawabanScreening->jawaban }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <a href="{{ route('dataKesehatan.index') }}" class="btn btn-secondary btn-animated mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Data-kesehatan/detail-kesehatan.js') }}"></script>

<script>
    // Custom JS to apply animations or enhance UI if necessary
    $(document).ready(function () {
        // Add animation to reveal collapsed sections
        $('.collapse').on('show.bs.collapse', function () {
            $(this).parent().find(".card-header").addClass('animated fadeIn');
        });

        $('.collapse').on('hide.bs.collapse', function () {
            $(this).parent().find(".card-header").removeClass('animated fadeIn');
        });
    });
</script>

@endsection
