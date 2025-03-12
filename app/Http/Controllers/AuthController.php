<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

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
}
