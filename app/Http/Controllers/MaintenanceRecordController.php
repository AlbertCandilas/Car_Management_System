<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRecord;
use App\Models\Car;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    public function store(Request $request) {
        MaintenanceRecord::create($request->all());
        
        // Mark car as under maintenance
        Car::where('id', $request->car_id)->update(['status' => 'maintenance']);

        return redirect()->back();
    }
}