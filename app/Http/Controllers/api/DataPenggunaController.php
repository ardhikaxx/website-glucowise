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
        try {
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
                'status' => 'success',
                'message' => 'Registrasi berhasil',
                'data' => $pengguna
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registrasi gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $pengguna = Pengguna::where('email', strtolower($request->email))->first();

            if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email atau password salah.'
                ], 401);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'nik' => $pengguna->nik,
                'user' => $pengguna,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $request->validate([
                'nik' => 'required|numeric',
            ]);

            $nik = $request->input('nik');
            $pengguna = Pengguna::where('nik', $nik)->first();

            if (!$pengguna) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengguna tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data profil ditemukan',
                'data' => $pengguna
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editProfile(Request $request)
    {
        try {
            $nik = $request->header('Nik') ?? $request->input('nik');

            if (!$nik) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'NIK diperlukan'
                ], 400);
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
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengguna tidak ditemukan'
                ], 404);
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
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui',
                'data' => $pengguna
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email'
            ]);

            $pengguna = Pengguna::where('email', $request->email)->first();

            if (!$pengguna) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Email valid, silakan lanjutkan ke halaman ubah password',
                'nik' => $pengguna->nik
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memverifikasi email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'nik' => 'required|string|size:16',
                'password' => 'required|string|min:6|confirmed'
            ]);

            $pengguna = Pengguna::where('nik', $request->nik)->first();

            if (!$pengguna) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengguna tidak ditemukan'
                ], 404);
            }

            if (Hash::check($request->password, $pengguna->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gunakan password yang berbeda dari sebelumnya'
                ], 400);
            }

            $pengguna->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui password',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}