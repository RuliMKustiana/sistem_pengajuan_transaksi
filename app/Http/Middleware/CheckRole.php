<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        // 1. Gunakan Facade Auth::check()
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Gunakan Facade Auth::user()
        $user = Auth::user();

        // 3. Hak istimewa Super Admin (bypass semua middleware role)
        if ($user->role && $user->role->name === 'admin') {
            return $next($request);
        }

        // 4. Pengecekan kecocokan role user biasa
        if (in_array($user->role->name, $roles)) {
            return $next($request);
        }

        abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES UNTUK HALAMAN INI.');
    }
}
