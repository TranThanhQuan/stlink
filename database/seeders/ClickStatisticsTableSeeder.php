<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClickStatistic; // Import model ClickStatistic nếu có

class ClickStatisticsTableSeeder extends Seeder
{
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng click_statistics
        ClickStatistic::create([
            'link_id' => 1, // Liên kết với link "Google"
            'user_id' => 1,
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
            'referrer' => 'google',
            'device_type' => 'pc',
            'os' => 'Windows',
            'country' => 'USA',
            'clicked_at' => now()
        ]);
        ClickStatistic::create([
            'link_id' => 2, // Liên kết với link "Facebook"
            'user_id' => 1,
            'ip_address' => '192.168.1.2',
            'user_agent' => 'Mozilla/5.0',
            'referrer' => 'facebook',
            'device_type' => 'mobile',
            'os' => 'Android',
            'country' => 'Vietnam',
            'clicked_at' => now()
        ]);
    }
}
