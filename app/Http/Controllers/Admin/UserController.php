<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $users = User::get();

        return Inertia::render('Admin/User/Index', [ 'users' => $users, ]);
    }
}
