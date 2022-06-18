<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsGuru
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->is_guru == 1) {
            return $next($request);
        }
        return back()->with('errors', "Anda Tidak Bisa Mengakses Halaman ini !!");
    }
}
