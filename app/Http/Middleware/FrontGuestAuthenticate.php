<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Request;

class FrontGuestAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard('persons')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(Request::segment(1).'/catalog');
            }
        }

        return $next($request);
    }
}
