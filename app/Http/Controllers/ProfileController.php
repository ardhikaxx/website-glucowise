<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private $firebaseAuth;

    public function __construct()
    {
        try {
            $serviceAccountPath = Storage::path(env('FIREBASE_CREDENTIALS'));

            if (!file_exists($serviceAccountPath)) {
                throw new \Exception('Firebase service account file not found at: ' . $serviceAccountPath);
            }

            $factory = (new Factory)
                ->withServiceAccount($serviceAccountPath)
                ->withDatabaseUri('https://' . env('FIREBASE_PROJECT_ID') . '.firebaseio.com');

            $this->firebaseAuth = $factory->createAuth();
        } catch (\Exception $e) {
            Log::error('Firebase initialization failed: ' . $e->getMessage());
            throw new \Exception('Firebase initialization failed. Please check your configuration.');
        }
    }

    public function showProfile()
    {
        // Gunakan find() untuk mendapatkan instance model yang fresh
        $admin = Admin::find(Auth::id());
        return view('layouts.Profile-admin.profile-admin', compact('admin'));
    }

    public function editProfile()
    {
        // Gunakan find() untuk mendapatkan instance model yang fresh
        $admin = Admin::find(Auth::id());
        return view('layouts.Profile-admin.edit-profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        // Gunakan find() untuk mendapatkan instance model yang fresh
        $admin = Admin::find(Auth::id());
        
        if (!$admin) {
            return redirect()->back()
                ->withErrors(['error' => 'User tidak ditemukan.'])
                ->withInput();
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $admin->id_admin . ',id_admin',
            'nomor_telepon' => 'nullable|string|max:15|regex:/^[0-9]+$/',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'nomor_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'nomor_telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 digit.',
            'current_password.required_with' => 'Password saat ini harus diisi jika ingin mengubah password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
            'new_password.min' => 'Password baru harus minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update Firebase Authentication
            try {
                $firebaseUser = $this->firebaseAuth->getUserByEmail($admin->email);

                $updateProperties = [];

                // Update email jika berubah
                if ($admin->email !== $request->email) {
                    $updateProperties['email'] = $request->email;
                }

                // Update password jika diisi
                if ($request->new_password) {
                    // Verifikasi password saat ini
                    if (!Hash::check($request->current_password, $admin->password)) {
                        return redirect()->back()
                            ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                            ->withInput();
                    }

                    $updateProperties['password'] = $request->new_password;
                }

                $updateProperties['displayName'] = $request->nama_lengkap;

                if (!empty($updateProperties)) {
                    $this->firebaseAuth->updateUser($firebaseUser->uid, $updateProperties);
                }
            } catch (UserNotFound $e) {
                Log::warning('Firebase user not found for email: ' . $admin->email);
                // Lanjutkan dengan update database lokal saja
            }

            // Update database lokal - gunakan fill() untuk mass assignment
            $updateData = [
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
            ];

            if ($request->new_password) {
                if (!Hash::check($request->current_password, $admin->password)) {
                    return redirect()->back()
                        ->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])
                        ->withInput();
                }
                $updateData['password'] = Hash::make($request->new_password);
            }

            // Gunakan fill() dan kemudian save()
            $admin->fill($updateData);
            
            if ($admin->save()) {
                return redirect()->route('profile.show')
                    ->with('success', 'Profil berhasil diperbarui!');
            } else {
                throw new \Exception('Gagal menyimpan data ke database.');
            }

        } catch (FirebaseException $e) {
            Log::error('Firebase update profile error: ' . $e->getMessage());
            
            $errorMessage = 'Gagal mengupdate profil. Terjadi kesalahan pada sistem authentication.';
            
            if (strpos($e->getMessage(), 'EMAIL_EXISTS') !== false) {
                $errorMessage = 'Email sudah terdaftar di sistem authentication.';
            }

            return redirect()->back()
                ->withErrors(['email' => $errorMessage])
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Update profile error: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi. ' . $e->getMessage()])
                ->withInput();
        }
    }
}