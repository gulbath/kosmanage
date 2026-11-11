<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class EnsureUserHasRole
{
    /**
     * Memeriksa hak akses peran (role) pengguna dan mencatat pelanggaran ke Audit Trail.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika belum login, arahkan ke halaman login
        if (!$user) {
            return redirect()->route('login');
        }

        // 1. Cek apakah role pengguna sesuai dengan izin rute
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 2. Catat jejak pengaksesan ilegal (Audit Trail Log)
        ActivityLog::create([
            'user_id'    => $user->id,
            'action'     => 'Akses Ditolak: Mencoba membuka /' . $request->path(),
            'ip_address' => $request->ip(),
        ]);

        // 3. Pengalihan dengan pesan peringatan hak akses
        if (method_exists($user, 'isOwner') && $user->isOwner()) {
            return redirect()->route('owner.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

        if (method_exists($user, 'isTenant') && $user->isTenant()) {
            return redirect()->route('tenant.dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

        return redirect('/')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
    }
}