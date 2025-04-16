<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Inertia::share([
            'auth.user' => function () {
                return Auth::check() ? [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    // thêm các thông tin khác nếu cần
                ] : null;
            },
        ]);
    }
}
