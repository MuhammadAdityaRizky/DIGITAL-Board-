<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request and ensure the user has one of the allowed roles.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$allowedRoles
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Normalize roles: allow comma-separated string or array
        $roles = [];
        foreach ($allowedRoles as $role) {
            foreach (explode(',', $role) as $r) {
                $trimmed = strtolower(trim($r));
                if ($trimmed !== '') {
                    $roles[] = $trimmed;
                }
            }
        }

        $userRole = strtolower(trim($user->role ?? ''));

        // If user's role is not authorized
        if (!in_array($userRole, $roles, true)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Akses ditolak! Anda tidak memiliki izin untuk mengakses area ini.'
                ], 403);
            }

            // Redirect user to their own dedicated dashboard with error message
            if ($userRole === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            }

            if ($userRole === 'dosen') {
                return redirect()->route('dosen.dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            }

            if (in_array($userRole, ['admin', 'super_admin'], true)) {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            }

            abort(403, 'Akses ditolak! Anda tidak memiliki izin untuk mengakses area ini.');
        }

        return $next($request);
    }
}

