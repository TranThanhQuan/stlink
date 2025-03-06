<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => 'Admin',
            'permissions' => json_encode([
                "users" => ["view", "add", "edit", "delete"],
                "groups" => ["view", "add", "edit", "delete", "permission"]
            ]),
            // 'user_id' => 1
        ]);

        Group::create([
            'name' => 'User',
            'permissions' => '',
            // 'user_id' => 1
        ]);

        Group::create([
            'name' => 'Premium',
            'permissions' => '',
            // 'user_id' => 1
        ]);

    }
}
