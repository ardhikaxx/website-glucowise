<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataPenggunaController extends Controller
{
    public function index()
    {
        return view('layouts.Data-pengguna.data_pengguna');
    }
    
}
