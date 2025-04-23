<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm(){
        if (Auth::check()) {
            $user = Auth::user();

            //kiểm tra quyền admin
            if ($user->group && $user->group->isAdmin) {
                return redirect()->route('admin.dashboard');
            } else {
                //nếu không phải admin thì chuyển về trang chủ
                dd('Bạn không có quyền truy cập');
            }
        }
        return Inertia::render('Admin/Auth/Login');
    }


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // Kiểm tra nếu không tìm thấy người dùng
        if (!$user) {
            return back()->with('error', 'Thông tin đăng nhập không đúng. Mã lỗi: 1001');
        }

        // Kiểm tra nếu không có nhóm người dùng hoặc nhóm không phải là admin
        if (!$user->group || !$user->group->isAdmin) {
            return back()->with('error', 'Thông tin đăng nhập không đúng. Mã lỗi: 1002');
        }

        // Kiểm tra mật khẩu không chính xác
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Thông tin đăng nhập không đúng. Mã lỗi: 1003');
        }

        // Đăng nhập thành công
        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }










    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();  // hủy session hiện tại
        return redirect()->route('admin.login');
    }
}
