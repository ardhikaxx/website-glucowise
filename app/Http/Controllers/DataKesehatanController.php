<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataKesehatanController extends Controller
{
    public function index()
    {
        return view('layouts.Data-kesehatan.data_kesehatan');
    }
    
}
