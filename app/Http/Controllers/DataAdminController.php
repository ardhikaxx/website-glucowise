<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class DataAdminController extends Controller
{
    // Menampilkan semua admin
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('layouts.Data-admin.data_admin', compact('admins'));
    }

    // Menampilkan form untuk tambah admin
    public function create()
    {
        return view('layouts.Data-admin.tambah_admin'); // Jika tidak ada admin, halaman create akan kosong
    }

    // Menyimpan data admin baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'jenis_kelamin' => 'required|string',
        ]);

        Admin::create($validated);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    // Menampilkan form untuk edit admin
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('layouts.Data-admin.tambah_admin', compact('admin')); // Gunakan view yang sama untuk edit
    }

    // Mengupdate data admin
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'jenis_kelamin' => 'required|string',
        ]);

        $admin->update($validated);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui');
    }

    // Menghapus admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
    }
}
