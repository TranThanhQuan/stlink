<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model {
    use HasFactory;

    protected $fillable = ['name', 'price', 'duration_days'];

    // Một gói có nhiều subscriptions
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
}
