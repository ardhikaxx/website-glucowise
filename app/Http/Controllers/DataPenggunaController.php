<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class DataPenggunaController extends Controller
{
    // Menampilkan halaman data pengguna
    public function index(Request $request)
    {
        $search = $request->search;
        $jenisKelamin = $request->jenis_kelamin;

        // Pencarian berdasarkan nama, NIK, dan jenis kelamin
        $dataPengguna = Pengguna::query();

        // Kondisi pencarian berdasarkan nama atau NIK
        if ($search) {
            $dataPengguna->where(function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Kondisi pencarian berdasarkan jenis kelamin
        if ($jenisKelamin) {
            $dataPengguna->where('jenis_kelamin', $jenisKelamin);
        }

        // Menyaring data pengguna dan melakukan pagination
        $dataPengguna = $dataPengguna->paginate(10);

        // Menyertakan status jika data tidak ditemukan
        $message = $dataPengguna->isEmpty() ? 'Data tidak ditemukan.' : '';

        return view('layouts.Data-pengguna.data_pengguna', compact('dataPengguna', 'message'));
    }

    // Menampilkan detail data pengguna
    public function show($id)
    {
        $dataPengguna = Pengguna::findOrFail($id);
        return view('layouts.Data-pengguna.detail_pengguna', compact('dataPengguna'));
    }
}
