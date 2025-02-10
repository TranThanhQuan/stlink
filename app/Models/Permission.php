<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    use HasFactory;

    protected $fillable = ['name', 'code'];

    // Một quyền có thể thuộc nhiều vai trò
    public function roles() {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
