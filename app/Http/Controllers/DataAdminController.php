<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class DataAdminController extends Controller
{
    public function index()
    {
        $admins = Admin::paginate(5);
        return view('layouts.Data-admin.data_admin', compact('admins'));
    }
    
}
