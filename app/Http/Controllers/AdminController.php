<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // If search query is present
        $search = $request->search;
        $admins = Admin::when($search, function ($query, $search) {
            return $query->where('nama_lengkap', 'like', '%' . $search . '%');
        })->paginate(10); // Change to your pagination size if needed

        return view('layouts.Data-admin.data_admin', compact('admins'));
    }
    // Show form to create a new admin
    public function create()
{
    return view('layouts.Data-admin.tambah_admin'); // No need to pass $admin here
}
    // Store a newly created admin in storage
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|string|min:8|confirmed',
            'jenis_kelamin' => 'required|string',
            'hak_akses' => 'nullable|string', // Handle nullable hak_akses
        ]);

        // Create the admin
        Admin::create([
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'hak_akses' => $validatedData['hak_akses'] ?? null, // If hak_akses is not provided, it will be null
        ]);

        // Redirect to the admin index with a success message
        return redirect()->route('admin.index')->with('success', 'Admin created successfully');
    }

    // Show the form for editing the specified admin
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        return view('layouts.Data-admin.tambah_admin', compact('admin')); // Pass the admin to the view for editing
    }

    // Update the specified admin in storage
    public function update(Request $request, $id_admin)
    {
        // Cari admin berdasarkan id_admin
        $admin = Admin::findOrFail($id_admin);  // Pastikan mencari berdasarkan id_admin
    
        // Validasi input
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $id_admin . ',id_admin', // Perbaikan di sini, pastikan memakai id_admin untuk pengecualian
            'password' => 'nullable|string|min:8|confirmed',
            'jenis_kelamin' => 'required|string',
            'hak_akses' => 'nullable|string',
        ]);
        
    
        // Update data admin
        if ($request->password) {
            $admin->password = bcrypt($request->password);
        }
        $admin->nama_lengkap = $validatedData['nama_lengkap'];
        $admin->email = $validatedData['email'];
        $admin->jenis_kelamin = $validatedData['jenis_kelamin'];
        $admin->hak_akses = $validatedData['hak_akses'] ?? $admin->hak_akses;
    
        // Simpan data yang sudah diupdate
        $admin->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('admin.index')->with('success', 'Admin updated successfully');
    }
    
    

    public function destroy($id)
{
    $admin = Admin::findOrFail($id);
    $admin->delete();
    return redirect()->route('admin.index')->with('success', 'Admin deleted successfully');
}
}
