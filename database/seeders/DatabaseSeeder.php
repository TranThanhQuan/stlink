<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $this->call([
        //     GroupsTableSeeder::class,
        //     UsersTableSeeder::class,
        //     LinksTableSeeder::class,
        //     ClickStatisticsTableSeeder::class,
        // ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Tạo Group: Admin
        $adminGroupId = DB::table('groups')->insertGetId([
            'name' => 'Admin',
            'user_id' => 1,
            'permissions' => json_encode([
                "users" => ["view", "add", "edit", "delete"],
                "groups" => ["view", "add", "edit", "delete", "permission"],
                "links" => ["view", "add", "edit", "delete"],
            ]),
            'isAdmin' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo Group: User (giống Admin nhưng isAdmin = 0)
        $userGroupId = DB::table('groups')->insertGetId([
            'name' => 'User',
            'user_id' => 1,
            'permissions' => json_encode([
                "users" => ["view", "add", "edit", "delete"],
                "groups" => ["view", "add", "edit", "delete", "permission"],
                "links" => ["view", "add", "edit", "delete"],
            ]),
            'isAdmin' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Tạo user Admin
        $userId = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'prefix' => 'ad',
            'group_id' => $adminGroupId,
            'provider' => 'email',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Thêm links
        $links = [
            [
                'title' => 'Google',
                'user_id' => $userId,
                'short_code' => 'googl123',
                'original_url' => 'https://www.google.com',
                'status' => 1,
                'expires_at' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Facebook',
                'user_id' => $userId,
                'short_code' => 'fb12345',
                'original_url' => 'https://www.facebook.com',
                'status' => 1,
                'expires_at' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('links')->insert($links);

        // Lấy ID các links vừa tạo
        $linkIds = DB::table('links')->pluck('id');

        // Tạo click_statistics giả lập
        foreach ($linkIds as $linkId) {
            DB::table('click_statistics')->insert([
                [
                    'link_id' => $linkId,
                    'user_id' => 1,
                    'ip_address' => '192.168.1.1',
                    'referrer' => 'google',
                    'os' => 'Windows',
                    'browser' => 'Edge',
                    'platform' => 'Desktop',
                    'country' => 'Vietnam',
                    'created_at' => Carbon::now()->subDays(1),
                    'updated_at' => Carbon::now()->subDays(1),
                ],
                [
                    'link_id' => $linkId,
                    'user_id' => 1,
                    'ip_address' => '192.168.1.2',
                    'referrer' => 'facebook',
                    'os' => 'ios',
                    'browser' => 'Chrome',
                    'platform' => 'Mobile',
                    'country' => 'United States',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]);
        }

        // Thêm modules
        DB::table('modules')->insert([
            ['name' => 'users', 'title' => 'Quản lý người dùng', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'groups', 'title' => 'Quản lý nhóm', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'links', 'title' => 'Quản lý link', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
