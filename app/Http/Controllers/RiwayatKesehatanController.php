<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatKesehatanController extends Controller
{
    public function index()
    {
        return view('layouts.Riwayat-kesehatan.riwayat_kesehatan');
    }
}
