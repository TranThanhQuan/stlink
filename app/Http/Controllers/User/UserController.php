<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Group;
use App\Rules\ValidString;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $userInfo = new \stdClass(); // Khởi tạo object trống
        $userInfo->name = $user->name;
        $userInfo->email = $user->email;
        $userInfo->prefix = $user->prefix;

        return Inertia::render('User/User/Index', [
            'user' => $userInfo,
        ]);
    }

    public function home(){
        $user = auth()->user();
        if ($user) {
            if ($user->group && $user->group->isAdmin) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        } else {
            // Người dùng chưa đăng nhập
            // trả về 404
            return Inertia::render('Errors/NotFound')->toResponse(request())->setStatusCode(404);
        }
    }


}
