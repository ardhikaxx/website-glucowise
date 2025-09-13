<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\Auth\EmailNotFound;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
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

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        try {
            // 1. Coba autentikasi dengan Firebase
            $signInResult = $this->firebaseAuth->signInWithEmailAndPassword(
                $credentials['email'],
                $credentials['password']
            );

            // 2. Jika berhasil di Firebase, cek user di database lokal
            $user = Admin::where('email', $credentials['email'])->first();

            if ($user) {
                // 3. Login user ke Laravel
                Auth::login($user, $remember);

                if ($user->hak_akses == 'Dokter' || $user->hak_akses == 'Perawat') {
                    return redirect()->route('dashboard')->with('success', 'Login berhasil!');
                } else {
                    Auth::logout();
                    return redirect('/login')->withErrors(['error' => 'Hak akses tidak valid.']);
                }
            } else {
                return back()->withErrors(['email' => 'Email tidak terdaftar dalam sistem.'])->withInput();
            }

        } catch (FirebaseException $e) {
            $errorMessage = 'Email atau password salah.';

            if (strpos($e->getMessage(), 'INVALID_LOGIN_CREDENTIALS') !== false) {
                $errorMessage = 'Email atau password salah.';
            } elseif (strpos($e->getMessage(), 'TOO_MANY_ATTEMPTS_TRY_LATER') !== false) {
                $errorMessage = 'Terlalu banyak percobaan login. Silakan coba lagi nanti.';
            } elseif (strpos($e->getMessage(), 'INVALID_EMAIL') !== false) {
                $errorMessage = 'Format email tidak valid.';
            }

            Log::error('Firebase login error: ' . $e->getMessage());
            return back()->withErrors(['email' => $errorMessage])->withInput();
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            // Logout dari Firebase juga jika diperlukan
            // $idToken = $request->session()->get('firebase_id_token');
            // if ($idToken) {
            //     $this->firebaseAuth->revokeRefreshTokens($idToken);
            // }
        } catch (\Exception $e) {
            Log::error('Firebase logout error: ' . $e->getMessage());
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda telah keluar.');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.lupa-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.'
        ]);

        try {
            // Periksa apakah email terdaftar di Firebase
            $user = $this->firebaseAuth->getUserByEmail($request->email);

            // Periksa juga apakah email terdaftar di database lokal
            $localUser = Admin::where('email', $request->email)->first();

            if (!$localUser) {
                // Jika tidak ditemukan di database lokal, tetap tampilkan pesan sukses untuk keamanan
                return back()->with('status', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek inbox atau folder spam.');
            }

            // Kirim email reset password menggunakan Firebase
            $this->firebaseAuth->sendPasswordResetLink($request->email);

            return back()->with('status', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek inbox atau folder spam.');

        } catch (UserNotFound $e) {
            // Email tidak ditemukan di Firebase, tapi tetap tampilkan pesan sukses untuk keamanan
            return back()->with('status', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek inbox atau folder spam.');
        } catch (FirebaseException $e) {
            Log::error('Firebase send reset link error: ' . $e->getMessage());

            // Tetap tampilkan pesan sukses untuk keamanan
            return back()->with('status', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek inbox atau folder spam.');
        } catch (\Exception $e) {
            Log::error('Send reset link error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        }
    }

    public function showResetPasswordForm(Request $request)
    {
        try {
            // Ambil token dari query parameter 'oobCode'
            $token = $request->query('oobCode');

            if (!$token) {
                return redirect()->route('forgot-password')
                    ->withErrors(['email' => 'Token reset password tidak valid.']);
            }

            // Verifikasi bahwa token valid
            $email = $this->firebaseAuth->verifyPasswordResetCode($token);

            // Pastikan email juga ada di database lokal
            $user = Admin::where('email', $email)->first();
            if (!$user) {
                return redirect()->route('forgot-password')
                    ->withErrors(['email' => 'Email tidak terdaftar dalam sistem.']);
            }

            return view('auth.reset-password', [
                'token' => $token,
                'email' => $email
            ]);

        } catch (FirebaseException $e) {
            Log::error('Firebase verify token error: ' . $e->getMessage());

            $errorMessage = 'Token reset password tidak valid atau telah kedaluwarsa.';

            if (strpos($e->getMessage(), 'INVALID_OOB_CODE') !== false) {
                $errorMessage = 'Token reset password tidak valid.';
            } elseif (strpos($e->getMessage(), 'EXPIRED_OOB_CODE') !== false) {
                $errorMessage = 'Token reset password telah kedaluwarsa.';
            }

            return redirect()->route('forgot-password')->withErrors(['email' => $errorMessage]);
        } catch (\Exception $e) {
            Log::error('Show reset form error: ' . $e->getMessage());
            return redirect()->route('forgot-password')
                ->withErrors(['email' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ], [
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password harus minimal 6 karakter.',
        ]);

        try {
            // Verifikasi token dan email cocok
            $verifiedEmail = $this->firebaseAuth->verifyPasswordResetCode($request->token);

            if ($verifiedEmail !== $request->email) {
                return back()->withErrors(['email' => 'Email tidak sesuai dengan token reset.']);
            }

            // Pastikan email ada di database lokal
            $user = Admin::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors(['email' => 'Email tidak terdaftar dalam sistem.']);
            }

            // 1. Reset password di Firebase
            $this->firebaseAuth->confirmPasswordReset($request->token, $request->password);

            // 2. Update password di database lokal juga
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login')->with('status', 'Password berhasil diperbarui! Silahkan login dengan password baru.');

        } catch (FirebaseException $e) {
            Log::error('Firebase reset password error: ' . $e->getMessage());

            $errorMessage = 'Gagal mereset password. Token mungkin tidak valid atau telah kedaluwarsa.';

            if (strpos($e->getMessage(), 'INVALID_OOB_CODE') !== false) {
                $errorMessage = 'Token reset password tidak valid. Silakan minta link reset password lagi.';
            } elseif (strpos($e->getMessage(), 'EXPIRED_OOB_CODE') !== false) {
                $errorMessage = 'Token reset password telah kedaluwarsa. Silakan minta link reset password lagi.';
            } elseif (strpos($e->getMessage(), 'USER_NOT_FOUND') !== false) {
                $errorMessage = 'Email tidak ditemukan dalam sistem.';
            }

            return back()->withErrors(['email' => $errorMessage]);
        } catch (\Exception $e) {
            Log::error('Reset password error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        }
    }

    /**
     * Helper method untuk mengecek koneksi Firebase
     */
    public function checkFirebaseConnection()
    {
        try {
            $users = $this->firebaseAuth->listUsers($maxResults = 1);
            return response()->json([
                'status' => 'success',
                'message' => 'Firebase connected successfully',
                'users_count' => iterator_count($users)
            ]);
        } catch (\Exception $e) {
            Log::error('Firebase connection check failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}