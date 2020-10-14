<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Admin
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
        $myData = Auth::guard('admin')->user();
        if ($myData == "") {
            return redirect()->route('admin.loginPage')->withErrors(['Maaf, Anda harus login terlebih dahulu']);
        }
        return $next($request);
    }
}
