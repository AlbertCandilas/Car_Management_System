<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'full_name', 'phone', 'email', 'driver_license'
    ];

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}