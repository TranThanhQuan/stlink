<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class redirectUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $guard = null): Response
    {
        // nếu đã login và là admin thì chuyển về trang admin
        if (Auth::guard($guard)->check() && optional(Auth::user()->group->isAdmin == 1)) {
            return redirect()->route('admin.dashboard');
        }
        // nếu đã login và không phải admin thì chuyển về trang user
        if (Auth::guard($guard)->check() && optional(Auth::user()->group->isAdmin == 0)) {
            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
