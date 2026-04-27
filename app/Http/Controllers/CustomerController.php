<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        // Get cars currently rented by THIS user
        $myBookings = Booking::with('car')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->latest()
            ->get();

        // Get cars available for rent
        $availableCars = Car::where('status', 'available')->latest()->get();

        return view('customer.portal', compact('myBookings', 'availableCars'));
    }

        public function bookingHistory()
    {
        $bookings = Auth::user()->bookings()
            ->with('car')
            ->latest()
            ->paginate(10); // Pagination is better for history

        return view('customer.bookings', compact('bookings'));
    }
}