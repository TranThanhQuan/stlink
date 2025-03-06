<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Link;

class LinksTableSeeder extends Seeder
{
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng links
        Link::create([
            'title' => 'Google',
            'user_id' => 1, // Liên kết với user "Admin User"
            'short_code' => 'googl123',
            'original_url' => 'https://www.google.com',
            'status' => 'active',
            'expires_at' => null
        ]);
        Link::create([
            'title' => 'Facebook',
            'user_id' => 2, // Liên kết với user "Regular User"
            'short_code' => 'fb12345',
            'original_url' => 'https://www.facebook.com',
            'status' => 'active',
            'expires_at' => null
        ]);
    }
}

