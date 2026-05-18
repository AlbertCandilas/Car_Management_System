<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\MaintenanceRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'Bert Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $customer = User::create([
            'name' => 'John Doe',
            'email' => 'customer@test.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '09123456789',
            'driver_license' => 'D01-12-345678',
        ]);

        // 1. Create 20 Users (Mix of Customers and Staff)
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => "Customer User $i",
                'email' => "customer$i@example.com",
                'password' => Hash::make('password'),
                'role' => $i <= 2 ? 'admin' : 'customer',
                'phone' => '09' . rand(100000000, 999999999),
                'driver_license' => 'DL-' . rand(10000, 99999),
            ]);
        }

        // 2. Create 20 Cars (Varied Status and Brands)
        $brands = ['Toyota', 'Honda', 'Mitsubishi', 'Nissan', 'Ford', 'Hyundai', 'Mazda', 'Suzuki'];
        $models = ['Sedan', 'SUV', 'Hatchback', 'Pickup', 'Luxury'];
        
        for ($i = 1; $i <= 20; $i++) {
            Car::create([
                'brand' => $brands[array_rand($brands)],
                'model' => $models[array_rand($models)] . " Gen $i",
                'year' => rand(2018, 2024),
                'plate_number' => 'ABC-' . rand(1000, 9999),
                'status' => ['available', 'rented', 'maintenance'][rand(0, 2)],
                'daily_rate' => rand(1200, 6000),
                'image_path' => null, // You can manually add paths if you have dummy assets
            ]);
        }

        // // 3. Create 20 Bookings (Linking random users and cars)
        // $userIds = User::where('role', 'customer')->pluck('id')->toArray();
        // $carIds = Car::pluck('id')->toArray();

        // for ($i = 1; $i <= 20; $i++) {
        //     $startDate = Carbon::now()->addDays(rand(-10, 10));
        //     $endDate = (clone $startDate)->addDays(rand(1, 7));
        //     $car = Car::find($carIds[array_rand($carIds)]);
            
        //     $days = $startDate->diffInDays($endDate);
        //     $totalPrice = $days * $car->daily_rate;

        //     $booking = Booking::create([
        //         'user_id' => $userIds[array_rand($userIds)],
        //         'car_id' => $car->id,
        //         'start_date' => $startDate,
        //         'end_date' => $endDate,
        //         'total_price' => $totalPrice > 0 ? $totalPrice : $car->daily_rate,
        //         'status' => ['pending', 'confirmed', 'completed', 'cancelled'][rand(0, 3)],
        //     ]);

        //     // 4. Create 20 Payments (One for each booking)
        //     Payment::create([
        //         'booking_id' => $booking->id,
        //         'amount' => $booking->total_price,
        //         'payment_method' => 'onsite',
        //         'payment_status' => match($booking->status) {
        //             'completed', 'confirmed' => 'paid',
        //             'cancelled'              => 'cancelled',
        //             default                  => 'pending',
        //         },
        //     ]);
        // }

        // // 5. Create 20 Maintenance Records
        // $serviceTypes = ['Oil Change', 'Tire Rotation', 'Brake Inspection', 'Engine Tune-up', 'Body Paint Fix'];
        
        // for ($i = 1; $i <= 20; $i++) {
        //     MaintenanceRecord::create([
        //         'car_id' => $carIds[array_rand($carIds)],
        //         'service_type' => $serviceTypes[array_rand($serviceTypes)],
        //         'cost' => rand(500, 15000),
        //         'scheduled_date' => Carbon::now()->addDays(rand(-30, 30)),
        //         'notes' => 'Bulk maintenance testing record #' . $i,
        //     ]);
        // }
    }
}