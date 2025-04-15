<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidString implements Rule
{
    protected $type;

    // Thêm thuộc tính static để Laravel hiểu đây là rule "tên cụ thể"
    public static $implicit = true;

    public function __construct($type = 'Trường')
    {
        $this->type = $type;
    }

    public function passes($attribute, $value)
    {
        return preg_match('/^[a-z0-9]+$/', $value);
    }

    public function message()
    {
        // fallback nếu không có custom message
        return "{$this->type} không hợp lệ!<br/> Chỉ cho phép: chữ thường không dấu và số.";
    }

    // Đặt tên cho rule để dùng trong custom message
    public function __toString()
    {
        return 'valid_string'; // tên này dùng trong key custom message
    }
}

