<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataAdminController extends Controller
{
    public function index()
    {
        return view('layouts.Data-admin.data_admin');
    }
    
}
