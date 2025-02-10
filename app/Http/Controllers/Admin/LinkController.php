<?php

namespace App\Http\Controllers\Admin;

use App\Models\Link;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LinkController extends Controller
{
    // public function index(){
    //     // trỏ đến file view
    //     return Inertia::render('Admin/Link/Index');
    // }

    public function index(){

        $links = Link::with('user')->get();


        $links = Link::with('user')->get()->map(function ($link) {
            return [
                'id' => $link->id,
                'title' => $link->title,
                'user_id' => $link->user_id,
                'user' => [
                    'name' => $link->user->name ?? null,
                ],
                'short_code' => $link->short_code,
                'original_url' => $link->original_url,
                'status' => $link->status,
                'created_at' => Carbon::parse($link->created_at)->format('d/m/Y H:i:s'),
            ];
        });
        // dd($links);

        $users = User::get();
        // $categories = Category::get();
        // render component với tham số là 'links' với giá trị là kết quả lấy từ table
        return Inertia::render('Admin/Link/Index', ['links' => $links, 'users' => $users]);
    }
}
