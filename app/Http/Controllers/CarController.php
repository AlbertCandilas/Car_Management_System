<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index() {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    public function store(Request $request) {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'plate_number' => 'required|unique:cars',
            'daily_rate' => 'required|numeric',
        ]);

        Car::create($request->all());
        return redirect()->route('cars.index')->with('success', 'Car added successfully!');
    }
}
