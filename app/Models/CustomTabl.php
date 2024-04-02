<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTabl extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function user()
    {
        return $this->hasOne(User::class, "user_id", "id");
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, "table_id", "id");
    }
}
