<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    function bookings(){
        return $this->hasMany(Booking::class);
    }
    function archived_bookings(){
        return $this->hasMany(ArchivedBooking::class);
    }
}
