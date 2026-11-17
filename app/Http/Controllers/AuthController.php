<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;

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

        $identifier = trim($request->username_or_nim_nip);
        $password = (string) $request->password;

        // 1. Coba temukan user langsung berdasarkan kolom 'username' (case-insensitive & trimmed)
        $user = User::where('username', $identifier)->first();

        // 2. Jika tidak ditemukan, cari dosen berdasarkan NIP
        if (!$user) {
            $dosen = Dosen::where('nip', $identifier)
                ->orWhere('nip', ltrim($identifier, '0'))
                ->first();
            if ($dosen && $dosen->user) {
                $user = $dosen->user;
            }
        }

        // 3. Jika tidak ditemukan, cari mahasiswa berdasarkan NIM
        if (!$user) {
            $mhs = Mahasiswa::where('nim', $identifier)
                ->orWhere('nim', ltrim($identifier, '0'))
                ->first();
            if ($mhs && $mhs->user) {
                $user = $mhs->user;
            }
        }

        // 4. Verifikasi user dan password
        if ($user && Hash::check($password, $user->password)) {
            $remember = $request->boolean('remember');
            try {
                Auth::login($user, $remember);
            } catch (\Throwable $e) {
                // Jika error karena kolom remember_token belum ada di database server, coba buat kolomnya
                if (str_contains($e->getMessage(), 'remember_token')) {
                    try {
                        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users ADD COLUMN remember_token VARCHAR(100) NULL");
                        Auth::login($user, $remember);
                    } catch (\Throwable $ex) {
                        // Fallback aman: jika ALTER TABLE tidak diizinkan, tetap izinkan login tanpa remember me
                        Auth::login($user, false);
                    }
                } else {
                    throw $e;
                }
            }
            $request->session()->regenerate();

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


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
