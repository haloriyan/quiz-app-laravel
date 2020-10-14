<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $myData = Auth::guard('participant')->user();
        if ($myData == "") {
            return redirect()->route('login')->withErrors(['Maaf, Anda harus login terlebih dahulu']);
        }
        return $next($request);
    }
}
