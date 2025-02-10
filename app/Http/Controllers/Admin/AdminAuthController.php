<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm(){
        // hiển thị giao diện login bằng vue (/resource/js/Pages/Admin/Auth)
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request) {
        $user = \App\Models\User::where('email', $request->email)
            ->whereIn('role', ['admin', 'moderator'])
            ->first();


        if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');

        }
        dd('Thông tin đăng nhập không hợp lệ');
        return redirect()->route('admin.login')->with('error', 'Thông tin đăng nhập không hợp lệ');
    }



    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();  // hủy session hiện tại
        return redirect()->route('admin.login');
    }
}
