@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5">
    <section class="mb-5 mt-4">
        <div class="d-flex align-items-center justify-content-between mb-4 border-start border-blue-600 border-4 ps-3">
            <div>
                <h2 class="fw-bold text-gray-900 mb-0 tracking-tight" style="font-size: 1.5rem;">Active Journeys</h2>
                <p class="text-muted small mb-0">Your current rentals and reservation details.</p>
            </div>
        </div>
        
        <div class="row g-4">
            @forelse($myBookings as $booking)
                <div class="col-12 col-xl-6">
                    <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <div class="rounded-3 bg-gray-50 border d-flex align-items-center justify-content-center overflow-hidden" style="height: 140px;">
                                        @if($booking->car->image_path)
                                            <img src="{{ asset('storage/' . $booking->car->image_path) }}" class="w-100 h-100 object-cover">
                                        @else
                                            <i class="bi bi-car-front text-gray-300 display-4"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge 
                                            @if($booking->status === 'confirmed') bg-success-subtle border border-success text-success 
                                            @elseif($booking->status === 'completed') bg-light border text-dark 
                                            @elseif($booking->status === 'cancelled') bg-danger-subtle border border-danger text-danger 
                                            @else bg-warning-subtle border border-warning text-dark 
                                            @endif 
                                            px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.65rem;">
                                            {{ $booking->status }}
                                        </span>
                                        <p class="text-muted small mb-0 font-monospace" style="font-size: 0.7rem;">{{ $booking->car->plate_number }}</p>
                                    </div>
                                    
                                    <h4 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">{{ $booking->car->brand }} {{ $booking->car->model }}</h4>
                                    
                                    <div class="d-flex gap-4 mb-3 border-bottom pb-3">
                                        <div class="small">
                                            <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 8px; letter-spacing: 0.05em;">Pickup</span>
                                            <span class="fw-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="small">
                                            <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 8px; letter-spacing: 0.05em;">Return</span>
                                            <span class="fw-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="text-muted d-block text-uppercase fw-bold" style="font-size: 8px; letter-spacing: 0.05em;">Charged</span>
                                            <span class="text-blue-600 fw-bold">${{ number_format($booking->total_price, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button class="btn btn-dark btn-sm flex-grow-1 py-2 fw-bold" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#manageJourneyModal{{ $booking->id }}"
                                                style="border-radius: 0.75rem;">
                                            Manage Journey
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm py-2 px-3 border" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#invoiceModal{{ $booking->id }}"
                                                style="border-radius: 0.75rem;">
                                            <i class="bi bi-receipt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="bg-white rounded-4 p-5 text-center border shadow-sm">
                        <i class="bi bi-calendar4-week text-gray-200 display-1"></i>
                        <p class="text-muted mt-3 fw-medium">No active rentals found.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <section>
        <div class="d-flex align-items-center justify-content-between mb-4 border-start border-gray-400 border-4 ps-3">
            <div>
                <h2 class="fw-bold text-gray-900 mb-0 tracking-tight" style="font-size: 1.5rem;">Available Fleet</h2>
                <p class="text-muted small mb-0">Select a vehicle for your next destination.</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($availableCars as $car)
                <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                    <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius: 1.25rem;">
                        <div class="p-3">
                            <div class="position-relative rounded-3 overflow-hidden bg-gray-50 border" style="aspect-ratio: 4/3;">
                                @if($car->image_path)
                                    <img src="{{ asset('storage/' . $car->image_path) }}" class="w-100 h-100 object-cover transition-img">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-image text-gray-200 display-5"></i>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 start-0 p-3">
                                    <span class="badge bg-white text-dark shadow-sm border py-2 px-3 fw-bold" style="font-size: 0.7rem; border-radius: 0.6rem;">
                                        {{ $car->year }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body pt-0 px-4 pb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold text-gray-900 mb-0" style="font-size: 1rem;">{{ $car->brand }}</h5>
                                    <p class="text-muted mb-0 small">{{ $car->model }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="text-blue-600 fw-bold d-block h5 mb-0" style="font-size: 1.1rem;">${{ number_format($car->daily_rate, 0) }}</span>
                                    <span class="text-muted" style="font-size: 0.65rem; font-weight: 600; text-uppercase;">per day</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 py-3 border-top border-bottom border-gray-100 mb-4">
                                <div class="text-center">
                                    <i class="bi bi-fuel-pump text-gray-400 d-block small"></i>
                                    <span class="fw-bold text-gray-700" style="font-size: 9px; text-uppercase;">Petrol</span>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-gear text-gray-400 d-block small"></i>
                                    <span class="fw-bold text-gray-700" style="font-size: 9px; text-uppercase;">Auto</span>
                                </div>
                                <div class="ms-auto text-end">
                                    <span class="badge bg-blue-50 text-blue-600 px-2 py-1 rounded-2 border border-blue-100" style="font-size: 8px; font-weight: 800;">
                                        {{ strtoupper($car->status) }}
                                    </span>
                                </div>
                            </div>

                            <button class="btn btn-dark w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#reserveModal{{ $car->id }}"
                                    style="border-radius: 0.75rem; font-size: 0.85rem;">
                                Reserve Vehicle <i class="bi bi-arrow-right small"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

@include('components.modals')

<style>
    /* Design Language Overrides */
    .text-blue-600 { color: #2563eb; }
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-gray-100 { background-color: #f3f4f6; }
    .text-gray-900 { color: #111827; }
    .text-gray-400 { color: #9ca3af; }
    .text-gray-300 { color: #d1d5db; }
    .text-gray-200 { color: #e5e7eb; }

    .hover-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease !important;
        background: #ffffff;
    }

    .hover-card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.08) !important;
    }

    .transition-img { transition: transform 0.5s ease; }
    .hover-card:hover .transition-img { transform: scale(1.05); }
    .object-cover { object-fit: cover; }
    .tracking-tight { letter-spacing: -0.02em; }
    
    .btn-dark {
        background: #111827;
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn-dark:hover {
        background: #1f2937;
        transform: scale(1.02);
    }
</style>
@endsection