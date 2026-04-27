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
        // 1. Validate
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // 2. Get Car details for price calculation
        $car = Car::findOrFail($request->car_id);
        
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) ?: 1; // Minimum 1 day
        $totalPrice = $days * $car->daily_rate;

        // 3. Create Booking
        Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
        
        // 4. Update car status
        $car->update(['status' => 'rented']);

        return redirect()->route('customer.portal')->with('success', 'Booking successful!');
    }

    public function destroy(Booking $booking)
    {
        // Check if the booking belongs to the user and is still pending
        if ($booking->user_id !== auth()->id() || $booking->status !== 'pending') {
            return redirect()->back()->with('error', 'You cannot cancel this booking.');
        }

        // 1. Update booking status
        $booking->update(['status' => 'cancelled']);

        // 2. Set the car back to available
        $booking->car->update(['status' => 'available']);

        // 3. Update the payment status (if a payment record exists)
        // Note: If you haven't updated the Migration yet, use 'pending' here.
        // If you have updated the Migration, use 'cancelled'.
        if ($booking->payment) {
            $booking->payment->update(['payment_status' => 'pending']); 
        }

        return redirect()->route('customer.portal')->with('success', 'Journey cancelled successfully.');
    }
}