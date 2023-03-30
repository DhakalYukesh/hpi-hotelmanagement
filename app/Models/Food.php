<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    public function bookings()
    {
        return $this->belongsToMany(Booking::class)->withPivot('quantity');
    }
}
