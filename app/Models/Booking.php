<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function user() {
        return $this->hasOne(User::class, "user_id", "id");
    }

    public function table() {
        return $this->hasOne(CustomTabl::class, "table_id", "id");
    }

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];
}
