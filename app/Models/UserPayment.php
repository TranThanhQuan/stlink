<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'meta_data',
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
