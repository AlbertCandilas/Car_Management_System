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
        $myBookings = Booking::with(['car', 'payment'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->latest()
            ->get();

        $availableCars = Car::where('status', 'available')->latest()->get();

        return view('customer.portal', compact('myBookings', 'availableCars'));
    }

    public function bookingHistory()
    {
        $bookings = Auth::user()->bookings()
            ->with(['car', 'payment'])
            ->latest()
            ->paginate(10);

        return view('customer.bookings', compact('bookings'));
    }
}