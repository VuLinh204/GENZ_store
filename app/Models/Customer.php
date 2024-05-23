<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
    ];

    // Quan hệ với bảng Cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
