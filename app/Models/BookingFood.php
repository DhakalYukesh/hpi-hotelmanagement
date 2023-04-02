<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFood extends Model
{
    use HasFactory;

    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }
}