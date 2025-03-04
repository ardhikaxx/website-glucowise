<?php

namespace App\Http\Controllers;

use App\Models\User; // Sesuaikan dengan model yang kamu buat
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;

class DataPenggunaController extends Controller
{
    // Menampilkan halaman data pengguna
    public function index(Request $request)
    {
        $search = $request->search;
        $dataPengguna = User::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('nomor_hp', 'like', "%{$search}%");
        })->paginate(10);

        return view('layouts.Data-pengguna.data_pengguna', compact('dataPengguna'));
    }
    public function search(Request $request)
{
    $search = $request->search;

    // Mengambil data berdasarkan pencarian
    $dataPengguna = AuthUser::when($search, function ($query, $search) {
        return $query->where('nomor_identitas', 'like', "%{$search}%")
                     ->orWhere('nama_lengkap', 'like', "%{$search}%")
                     ->orWhere('alamat', 'like', "%{$search}%")
                     ->orWhere('telepon', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%");
    })->paginate(10);

    return view('layouts.Data-pengguna.data_pengguna', compact('dataPengguna'));
}

    // Menampilkan form edit data pengguna
    public function edit($id)
    {
        $dataPengguna = User::findOrFail($id);
        return view('data-pengguna.edit', compact('dataPengguna'));
    }

    // Menampilkan detail data pengguna
    public function show($id)
    {
        $dataPengguna = User::findOrFail($id);
        return view('data-pengguna.show', compact('dataPengguna'));
    }

    // Untuk update data pengguna
    public function update(Request $request, $id)
    {
        $dataPengguna = User::findOrFail($id);
        $dataPengguna->update($request->all());

        return redirect()->route('dataPengguna.index')->with('success', 'Data berhasil diperbarui!');
    }
}
