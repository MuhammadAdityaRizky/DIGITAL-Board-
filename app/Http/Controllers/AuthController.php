<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username_or_nim_nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username_or_nim_nip,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'dosen' => redirect()->route('dosen.dashboard'),
                'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'username_or_nim_nip' => 'Username/NIP/NIM atau password salah.',
        ])->withInput();
    }

    public function demoLogin(string $role)
    {
        if (Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        $user = User::where('role', $role)->first();

        if ($user) {
            Auth::login($user);
            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'dosen' => redirect()->route('dosen.dashboard'),
                'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
                default => redirect('/'),
            };
        }

        return redirect('/login')->withErrors(['msg' => 'Demo user not found.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
