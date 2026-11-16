<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        // Rate Limiter khusus Login
        // Dibuat ramah untuk jaringan kampus / Lab Komputer (NAT / 1 Public IP untuk banyak komputer)
        RateLimiter::for('login', function (Request $request) {
            $username = (string) $request->input('username_or_nim_nip');
            return [
                // Batasi per akun spesifik: maksimal 10x percobaan salah per menit
                Limit::perMinute(10)->by($username . '|' . $request->ip()),
                // Kuota IP lab sangat longgar (300 request/menit) agar puluhan mahasiswa di lab tidak saling blokir
                Limit::perMinute(300)->by($request->ip()),
            ];
        });

        // Rate Limiter khusus Submit Presensi Mahasiswa
        // Dibatasi per akun user yang sedang login, BUKAN per IP lab
        RateLimiter::for('absensi', function (Request $request) {
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip());
        });
    }
}
