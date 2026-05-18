<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show the GCash manual payment gateway view.
     */
    public function showGcashCheckout(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load('car');

        return view('payment.gcash', compact('booking'));
    }

    /**
     * Handle the form submission containing GCash reference number / proof of payment
     */
    public function submitGcashProof(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'reference_number' => 'required|string|unique:payments,transaction_id',
            'proof_of_payment' => 'required|image|max:2048',
        ]);

        $path = $request->file('proof_of_payment') 
            ? $request->file('proof_of_payment')->store('proofs', 'public') 
            : null;

        $booking->payment()->updateOrCreate(
        [
            'booking_id' => $booking->id 
        ],
        [
            'payment_method' => 'gcash',
            'payment_status' => 'verifying',
            'transaction_id' => $request->reference_number,
            'proof_path'     => $path,
        ]
    );

        return redirect()->route('customer.bookings')->with('success', 'GCash payment submitted for verification.');
    }
}