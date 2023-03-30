<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Defining the belongsTo relation with booking and customer models.
    function customer(){
        return $this->belongsTo(Customer::class);
    }

    // Defining the belongsTo relation with booking and room models.
    function room(){
        return $this->belongsTo(Room::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
