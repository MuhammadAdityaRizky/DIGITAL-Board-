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
            $user = Auth::user();
            return match ($user->role) {
                'super_admin', 'admin' => redirect()->route('admin.dashboard'),
                'dosen' => redirect()->route('dosen.dashboard'),
                'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
                default => redirect()->route('board'),
            };
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

            if (strtolower($user->status ?? 'aktif') === 'nonaktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'username_or_nim_nip' => 'Akun Anda telah dinonaktifkan (suspended). Silakan hubungi Administrator.',
                ])->withInput();
            }

            if ($user->role === 'mahasiswa' && $user->mahasiswa && $user->mahasiswa->status === 'do') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'username_or_nim_nip' => 'Akun Anda tidak aktif (Status: Drop Out / Non-Aktif). Silakan hubungi bagian Akademik.',
                ])->withInput();
            }

            return match ($user->role) {
                'super_admin', 'admin' => redirect()->route('admin.dashboard'),
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

        if ($role === 'dosen') {
            // Akun Real Dosen (Pak Anggra Triawan)
            $user = User::where('username', '0431088705')->first() ?? User::where('role', 'dosen')->first();
        } elseif ($role === 'admin' || $role === 'super_admin') {
            // Akun Real Super Admin (admin1)
            $user = User::where('username', 'admin1')->first() ?? User::whereIn('role', ['super_admin', 'admin'])->first();
        } elseif ($role === 'mahasiswa') {
            // Akun Real Mahasiswa Aktif (Muhammad Irghi Alparizi)
            $user = User::where('username', '251106050005')->first()
                ?? User::where('role', 'mahasiswa')->whereHas('mahasiswa', fn($q) => $q->where('status', 'aktif'))->first();
        } else {
            $user = User::where('role', $role)->first();
        }

        if ($user) {
            if (strtolower($user->status ?? 'aktif') === 'nonaktif') {
                return redirect('/login')->withErrors(['msg' => 'Akun dinonaktifkan (suspended).']);
            }

            Auth::login($user);
            return match ($user->role) {
                'super_admin', 'admin' => redirect()->route('admin.dashboard'),
                'dosen' => redirect()->route('dosen.dashboard'),
                'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
                default => redirect('/'),
            };
        }

        return redirect('/login')->withErrors(['msg' => 'Akun resmi tidak ditemukan.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
