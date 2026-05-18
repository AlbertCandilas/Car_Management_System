<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\MaintenanceRecord;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cars'      => Car::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_bookings'  => Booking::count(),
            'total_revenue'   => Payment::where('payment_status', 'paid')->sum('amount'),
        ];

        $recentBookings = Booking::with('user')
            ->latest()
            ->take(5)
            ->get();

        $maintenanceRecords = MaintenanceRecord::with('car')
            ->orderBy('scheduled_date', 'asc')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'maintenanceRecords'));
    }

    public function cars()
    {
        $cars = Car::paginate(10);

        return view('admin.cars', compact('cars'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'car'])
            ->latest()
            ->paginate(10); 

        return view('admin.bookings', compact('bookings'));
    }

    public function customers()
    {
        $customers = User::where('role', 'customer')
            ->latest()
            ->paginate(10);

        return view('admin.customers', compact('customers'));
    }

    public function payments()
    {
        $payments = Payment::with(['booking.user', 'booking.car'])
            ->latest()
            ->paginate(10);

        return view('admin.payments', compact('payments'));
    }

    public function maintenance()
    {
        $maintenanceRecords = MaintenanceRecord::with('car')
            ->orderBy('scheduled_date', 'desc')
            ->paginate(10);

        $cars = Car::orderBy('brand')->get();

        return view('admin.maintenance', compact('maintenanceRecords', 'cars'));
    }

    public function storeCar(Request $request)
    {
        $request->validate([
            'brand'        => 'required|string|max:255',
            'model'        => 'required|string|max:255',
            'year'         => 'required|integer',
            'plate_number' => 'required|string|unique:cars',
            'daily_rate'   => 'required|numeric',
            'image_path'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->back()->with('success', 'Vehicle added successfully!');
    }

    public function storeMaintenance(Request $request)
    {
        $request->validate([
            'car_id'         => 'required|exists:cars,id',
            'service_type'   => 'required|string|max:255',
            'cost'           => 'required|numeric',
            'scheduled_date' => 'required|date',
        ]);

        MaintenanceRecord::create($request->all());

        Car::where('id', $request->car_id)->update(['status' => 'maintenance']);

        return redirect()->back()->with('success', 'Maintenance scheduled successfully!');
    }

    public function destroyCar(Car $car)
    {
        $car->delete();
        return redirect()->back()->with('success', 'Vehicle removed successfully!');
    }

    public function destroyMaintenance(MaintenanceRecord $maintenance)
    {
        $maintenance->delete();
        return redirect()->back()->with('success', 'Maintenance record deleted!');
    }

    public function updateCar(Request $request, Car $car)
    {
        $request->validate([
            'brand'        => 'required|string|max:255',
            'model'        => 'required|string|max:255',
            'year'         => 'required|integer',
            'plate_number' => 'required|string|unique:cars,plate_number,' . $car->id,
            'daily_rate'   => 'required|numeric',
            'image_path'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'       => 'required|in:available,rented,maintenance',
        ]);

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->back()->with('success', 'Vehicle updated successfully!');
    }

    public function updateMaintenance(Request $request, MaintenanceRecord $maintenance)
    {
        $request->validate([
            'service_type'   => 'required|string|max:255',
            'cost'           => 'required|numeric',
            'scheduled_date' => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $maintenance->update($request->all());

        return redirect()->back()->with('success', 'Maintenance record updated!');
    }

    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        
        $booking->car->update(['status' => 'rented']);

        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        $booking->car->update(['status' => 'available']);

        if ($booking->payment) {
            $booking->payment->update(['payment_status' => 'cancelled']);
        }

        return redirect()->back()->with('success', 'Booking has been cancelled.');
    }

    public function approvePayment(Payment $payment)
    {
        $payment->update(['payment_status' => 'paid']);

        if ($payment->booking) {
            $payment->booking->update(['status' => 'confirmed']);
            if ($payment->booking->car) {
                $payment->booking->car->update(['status' => 'rented']);
            }
        }

        return redirect()->back()->with('success', 'Payment verification approved and booking confirmed!');
    }

    public function rejectPayment(Payment $payment)
    {
        $payment->update(['payment_status' => 'cancelled']);

        if ($payment->booking) {
            $payment->booking->update(['status' => 'cancelled']);

            if ($payment->booking->car) {
                $payment->booking->car->update(['status' => 'available']);
            }
        }

        return redirect()->back()->with('success', 'Payment rejected and booking automatically cancelled.');
    }
}