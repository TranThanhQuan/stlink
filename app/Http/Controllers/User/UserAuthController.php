<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm(){

        return Inertia::render('User/Auth/Login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // Kiểm tra nếu không tìm thấy người dùng
        if (!$user) {
            return back()->with('error', 'Thông tin đăng nhập không đúng. Mã lỗi: 2001');
        }

        // Kiểm tra nếu không có nhóm người dùng hoặc nhóm không phải là admin
        if (!$user->group || $user->group->isAdmin) {
            return back()->with('error', 'Thông tin đăng nhập không đúng. Mã lỗi: 2002');
        }

        // Kiểm tra mật khẩu không chính xác
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Thông tin đăng nhập không đúng. Mã lỗi: 2003');
        }

        // Kiểm tra nếu tài khoản đã bị khóa
        if ($user->status == 0) {
            return back()->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với quản trị viên để biết thêm thông tin.');
        }

        // Đăng nhập thành công
        Auth::login($user);
        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request){

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->route('home1');
    }
}
