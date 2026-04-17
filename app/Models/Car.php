<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';

    protected $fillable = [
        'brand', 'model', 'year', 'plate_number', 'status', 'daily_rate', 'image_path'
    ];

    // Relationships
    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function maintenanceRecords() {
        return $this->hasMany(MaintenanceRecord::class);
    }
}
