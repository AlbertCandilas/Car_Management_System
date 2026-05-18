@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<main class="flex-1 p-3 lg:p-5"> <div id="content-dashboard" class="space-y-5"> <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"> <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between gap-3">
                <div class="shrink-0 w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="bi bi-car-front-fill text-xl"></i>
                </div>
                <div class="min-w-0 text-right"> <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Cars</p>
                    <h3 class="text-lg font-bold text-gray-800 truncate">{{ number_format($stats['total_cars']) }}</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between gap-3">
                <div class="shrink-0 w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                    <i class="bi bi-people-fill text-xl"></i>
                </div>
                <div class="min-w-0 text-right"> <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Customers</p>
                    <h3 class="text-lg font-bold text-gray-800 truncate">{{ number_format($stats['total_customers']) }}</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between gap-3">
                <div class="shrink-0 w-11 h-11 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="bi bi-calendar-event-fill text-xl"></i>
                </div>
                <div class="min-w-0 text-right"> <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Bookings</p>
                    <h3 class="text-lg font-bold text-gray-800 truncate">{{ number_format($stats['total_bookings']) }}</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between gap-3">
                <div class="shrink-0 w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                    <i class="bi bi-currency-dollar text-xl"></i>
                </div>
                <div class="min-w-0 text-right"> <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Revenue</p>
                    <h3 class="text-lg font-bold text-gray-800 break-all leading-tight">
                        ₱{{ number_format($stats['total_revenue']) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-clock-history text-blue-600"></i> Recent Bookings
                </h4>
                <div class="space-y-2"> @forelse($recentBookings as $booking)
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-xl transition-all border border-transparent hover:border-gray-100">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-[10px] font-bold">
                                    {{ strtoupper(substr($booking->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800 leading-none">{{ $booking->user->name }}</p>
                                    <p class="text-[9px] text-gray-400">{{ $booking->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                                <span class="px-2 py-1 rounded-full text-[9px] font-bold whitespace-nowrap
                                    @if($booking->status === 'confirmed') bg-green-100 text-green-600
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-600
                                    @elseif($booking->status === 'completed') bg-blue-100 text-blue-600
                                    @else bg-red-100 text-red-600 @endif">
                                    {{ strtoupper($booking->status) }}
                                </span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">No bookings yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="bi bi-tools text-orange-600"></i> Upcoming Maintenance
                </h4>
                @forelse($maintenanceRecords as $record)
                    <div class="p-3 border border-gray-100 rounded-xl mb-3 bg-gray-50/50">
                        <div class="flex justify-between items-start mb-1">
                            <h5 class="text-xs font-bold text-gray-800">{{ $record->car->brand }} {{ $record->car->model }}</h5>
                            <span class="text-[9px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded font-bold uppercase">{{ $record->service_type }}</span>
                        </div>
                        <p class="text-[10px] text-gray-500 mb-2 flex items-center gap-1">
                            <i class="bi bi-hash"></i> {{ $record->car->plate_number }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-gray-700">₱{{ number_format($record->cost, 2) }}</span>
                            <span class="text-[10px] text-orange-500 font-bold flex items-center gap-1">
                                <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($record->scheduled_date)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">No maintenance scheduled.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection