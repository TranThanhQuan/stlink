<?php

namespace Database\Seeders;

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

        $groupId = DB::table('groups')->insertGetId([
            'name' => 'Admin',
            'user_id' => 1,
            'permissions' => json_encode([
                "users" => ["view", "add", "edit", "delete"],
                "groups" => ["view", "add", "edit", "delete", "permission"]
            ]),
            'isAdmin' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        if ($groupId > 0) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456789'),
                'prefix' => 'ad',
                'group_id' => $groupId,
                'provider' => 'email',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($userId > 0) {
                DB::table('links')->insert([
                    [
                        'title' => 'Google',
                        'user_id' => $userId,
                        'short_code' => 'googl123',
                        'original_url' => 'https://www.google.com',
                        'status' => 'active',
                        'expires_at' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title' => 'Facebook',
                        'user_id' => $userId,
                        'short_code' => 'fb12345',
                        'original_url' => 'https://www.facebook.com',
                        'status' => 1,
                        'expires_at' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                ]);
            }
        }


        DB::table('Modules')->insert([
            'name' => 'users',
            'title' => 'Quản lý người dùng',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('Modules')->insert([
            'name' => 'groups',
            'title' => 'Quản lý nhóm',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('Modules')->insert([
            'name' => 'links',
            'title' => 'Quản lý link',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
