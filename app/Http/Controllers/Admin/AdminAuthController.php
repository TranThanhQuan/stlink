<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
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


    public function login(Request $request)
    {
        // Lấy người dùng theo email và kiểm tra role_id là admin hoặc moderator
        $user = User::where('email', $request->email)->first();


        // Kiểm tra nếu người dùng tồn tại và mật khẩu hợp lệ
        if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $permissions = json_decode($user->role->permission, true);
            // dd($permissions);

            if (in_array('login', $permissions['admin_dashboard'] ?? [])) {
                return redirect()->route('admin.dashboard');
            } else {
                // Nếu không có quyền truy cập vào admin dashboard
                Auth::logout(); // Đăng xuất nếu không có quyền
                return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập vào trang quản trị.');
            }
        }

        // Nếu thông tin đăng nhập không hợp lệ
        dd('Thông tin đăng nhập không hợp lệ');
        return redirect()->route('admin.login')->with('error', 'Thông tin đăng nhập không hợp lệ');
    }






    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();  // hủy session hiện tại
        return redirect()->route('admin.login');
    }
}
