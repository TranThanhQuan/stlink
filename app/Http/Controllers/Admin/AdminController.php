<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){

        return Inertia::render('Admin/Dashboard');
    }

    public function showLoginForm(){
        return 'login';
        // hiển thị giao diện login bằng vue (/resource/js/Pages/Admin/Auth)
        return Inertia::render('Admin/Auth/Login');
    }

    // public function login(Request $request){
    //     //check if user is an admin and redirect
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' =>true])){
    //         return redirect()->route('admin.dashboard');
    //     }

    //     return redirect()->route('admin.login')->with('error', 'Thông tin đăng nhập không hợp lệ');
    // }

    // public function logout(Request $request){
    //     Auth::guard('web')->logout();
    //     $request->session()->invalidate();  // hủy session hiện tại
    //     return redirect()->route('admin.login');
    // }
}
