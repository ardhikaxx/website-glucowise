<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
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

        $remember = $request->has('remember'); // Cek apakah "Ingat Saya" dicentang

        if (Auth::attempt($credentials, $remember)) { // Gunakan $remember di sini
            $user = Auth::user();

            if ($user->hak_akses == 'Bidan') {
                return redirect()->route('dashboard');
            } elseif ($user->hak_akses == 'Kader') {
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                return redirect('/login')->withErrors(['error' => 'Hak akses tidak valid.']);
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.lupa-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kirimkan link reset password
        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Reset link sent to your email.');
        }

        return back()->withErrors(['email' => 'We could not find a user with that email address.']);
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        // Proses reset password
        $response = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Your password has been reset!');
        }

        return back()->withErrors(['email' => 'Failed to reset password.']);
    }
}
