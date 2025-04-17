<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'original_url', 'short_code', 'expires_at'];

    // Một link thuộc về một user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Một link có nhiều lượt click
    public function clickStatistics() {
        return $this->hasMany(ClickStatistic::class);
    }
}
