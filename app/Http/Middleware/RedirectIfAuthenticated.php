<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/settings');
        }

        return $next($request);
    }
}
