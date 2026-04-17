<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create() {
        $cars = Car::where('status', 'available')->get();
        $customers = Customer::all();
        return view('bookings.create', compact('cars', 'customers'));
    }

    public function store(Request $request) {
        Booking::create($request->all());
        
        // Update car status to 'rented'
        Car::where('id', $request->car_id)->update(['status' => 'rented']);

        return redirect()->route('bookings.index');
    }
}