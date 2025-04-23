<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickStatistic extends Model {

    use HasFactory;
    protected $fillable = ['link_id','user_id', 'ip_address', 'os', 'country', 'browser', 'referrer', 'platform'];

    // public $timestamps = false;

    // Một lượt click thuộc về một link
    public function shortLink() {
        return $this->belongsTo(ShortLink::class);
    }
}
