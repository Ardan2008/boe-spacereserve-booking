<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $fillable = ['nama', 'whatsapp', 'email'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
