<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'plan_id', 'start_date', 'end_date'];

    // Một user có thể có nhiều subscription
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Một subscription thuộc về một gói
    public function plan() {
        return $this->belongsTo(Plan::class);
    }
}
