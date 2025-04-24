<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $guard = null): Response
    {
        // nếu chưa đăng nhập thì chuyển về trang login
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }
        if (Auth::check() && Auth::user()->group->isAdmin == 0){
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Access Denied, you are not an administrator');

    }
}
