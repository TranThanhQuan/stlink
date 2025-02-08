<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $guard = null): Response
    {
        // nếu đã đăng nhập và là admin hoặc moderator
        if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'moderator')) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Access Denied, you are not an administrator');

    }
}
