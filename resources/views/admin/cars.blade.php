@extends('layouts.admin')

@section('title', 'Car Fleet Management')

@section('content')
<main class="flex-1 p-3 lg:p-5">
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="bi bi-car-front-fill text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Vehicle Inventory</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Manage your fleet</p>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Search plate, brand..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition-all">
                </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 transition-all" 
                            data-bs-toggle="modal" 
                            data-bs-target="#addCarModal">
                        <i class="bi bi-plus-lg"></i> Add Car
                    </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Vehicle Details</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Plate Number</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Daily Rate</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Status</th>
                            <th class="px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($cars as $car)
                        <tr class="hover:bg-gray-50/50 transition-all">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-10 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($car->image_path)
                                            <img src="{{ asset('storage/' . $car->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i class="bi bi-image text-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-800">{{ $car->brand }} {{ $car->model }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $car->year }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-mono font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-md">
                                    {{ $car->plate_number }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <p class="text-xs font-bold text-gray-800">${{ number_format($car->daily_rate, 2) }}</p>
                                <p class="text-[9px] text-gray-400">per day</p>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="px-2 py-1 rounded-full text-[9px] font-bold
                                    @if($car->status === 'available') bg-green-100 text-green-600
                                    @elseif($car->status === 'rented') bg-blue-100 text-blue-600
                                    @else bg-orange-100 text-orange-600 @endif">
                                    {{ strtoupper($car->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCarModal{{ $car->id }}"
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @include('components.admin-edit-modal', ['car' => $car])

                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="bi bi-inbox text-3xl text-gray-200"></i>
                                    <p class="text-xs text-gray-400">No vehicles found in the inventory.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-5 py-3 bg-gray-50/30 border-t border-gray-100 flex items-center justify-between">
                <p class="text-[10px] text-gray-400 font-bold uppercase">Showing {{ $cars->count() }} Vehicles</p>
                <div class="flex gap-1">
                    <button class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] hover:bg-white transition-all">Prev</button>
                    <button class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] hover:bg-white transition-all">Next</button>
                </div>
            </div>
        </div>
    </div>
</main>
@include('components.admin-create-modal')
@endsection