<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    //...$roles -> untuk mengubah data string yang dikirim ke middleware menjadi bentuk array
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // cek apakah di dalam array $roles (parameter) yang dikirim dr route tadi terdapat role yang dimiliki user yg login
        // kalau ya, dibolehkan akses
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }
        // kalau tidak bakal diarahkan ke halaman yang memunculkan error not found
        return redirect('/error');
    }
}
