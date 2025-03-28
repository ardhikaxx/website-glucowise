<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DataPenggunaController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:pengguna',
            'email' => 'required|string|email|max:100|unique:pengguna',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
        ]);

        $pengguna = Pengguna::create([
            'nik' => $request->nik,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => null,
            'tanggal_lahir' => null,
            'jenis_kelamin' => null,
            'alamat_lengkap' => null,
            'nomor_telepon' => null,
            'nama_ibu_kandung' => null,
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'data' => $pengguna
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $pengguna = Pengguna::where('email', strtolower($request->email))->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'nik' => $pengguna->nik,
            'user' => $pengguna,
        ]);
    }

    public function getProfile(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric',
        ]);

        $nik = $request->input('nik');

        $pengguna = Pengguna::where('nik', $nik)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data profil ditemukan',
            'data' => $pengguna
        ], 200);
    }

    public function editProfile(Request $request)
    {
        $nik = $request->header('Nik') ?? $request->input('nik');

        if (!$nik) {
            return response()->json(['message' => 'NIK diperlukan'], 400);
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat_lengkap' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:15',
            'nama_ibu_kandung' => 'nullable|string|max:100',
        ]);

        $pengguna = Pengguna::where('nik', $nik)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        $pengguna->update($request->only([
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat_lengkap',
            'nomor_telepon',
            'nama_ibu_kandung'
        ]));

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data' => $pengguna
        ]);
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Email valid, silakan lanjutkan ke halaman ubah password',
            'nik' => $pengguna->nik
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $pengguna = Pengguna::where('nik', $request->nik)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        if (Hash::check($request->password, $pengguna->password)) {
            return response()->json(['message' => 'Gunakan password yang berbeda dari sebelumnya'], 400);
        }

        $pengguna->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Password berhasil diperbarui'], 200);
    }
}
