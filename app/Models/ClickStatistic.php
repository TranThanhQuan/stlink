<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickStatistic extends Model {
    use HasFactory;

    protected $fillable = ['short_link_id', 'ip', 'country', 'device', 'browser', 'referrer', 'clicked_at'];

    public $timestamps = false; // Không cần timestamps vì đã có 'clicked_at'

    // Một lượt click thuộc về một link
    public function shortLink() {
        return $this->belongsTo(ShortLink::class);
    }
}
