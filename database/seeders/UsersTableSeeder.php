<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng users
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'isAdmin' => 1,
            'group_id' => 1,
            'provider' => 'email',
            'status' => 'active'
        ]);
        User::create([
            'name' => 'User1',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
            'isAdmin' => 0,
            'group_id' => 2,
            'provider' => 'email',
            'status' => 'active'
        ]);
    }
}
