<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CanAdmin
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
        if (optional(Auth::user())->is_super_admin != 1) {
            return redirect()
                ->back()
                ->withErrors(['You do not have admin access']);
        }
        return $next($request);
    }
}
