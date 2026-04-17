<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $table = 'maintenance_records';

    protected $fillable = [
        'car_id', 'service_type', 'cost', 'scheduled_date', 'notes'
    ];

    public function car() {
        return $this->belongsTo(Car::class);
    }
}
