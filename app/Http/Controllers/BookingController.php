<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create() {
        $cars = Car::where('status', 'available')->get();
        $customers = Customer::all();
        return view('bookings.create', compact('cars', 'customers'));
    }

    public function store(Request $request) {

        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);
        
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $days = $startDate->diffInDays($endDate) ?: 1;
        $totalPrice = $days * $car->daily_rate;

        // 1. Create Booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $totalPrice,
            'payment_method' => 'onsite',
            'payment_status' => 'pending',
        ]);
        
        $car->update(['status' => 'rented']);

        return redirect()->route('customer.portal')->with('success', 'Booking successful!');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== 'pending') {
            return redirect()->back()->with('error', 'You cannot cancel this booking.');
        }

        $booking->update(['status' => 'cancelled']);

        $booking->car->update(['status' => 'available']);

        if ($booking->payment) {
            $booking->payment->update(['payment_status' => 'cancelled']); 
        }

        return redirect()->route('customer.portal')->with('success', 'Journey cancelled successfully.');
    }
}