@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5">
    <div class="d-flex align-items-center justify-content-between mb-4 mt-4 border-start border-primary border-4 ps-3">
        <div>
            <h2 class="fw-bold text-dark mb-0 tracking-tight">Booking History</h2>
            <p class="text-muted small mb-0">Track and manage all your past and upcoming journeys.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 1.25rem;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-uppercase text-muted" style="font-size: 0.75rem; font-weight: 700;">Vehicle</th>
                        <th class="py-3 border-0 text-uppercase text-muted" style="font-size: 0.75rem; font-weight: 700;">Period</th>
                        <th class="py-3 border-0 text-uppercase text-muted" style="font-size: 0.75rem; font-weight: 700;">Total</th>
                        <th class="py-3 border-0 text-uppercase text-muted" style="font-size: 0.75rem; font-weight: 700;">Status</th>
                        <th class="pe-4 py-3 border-0 text-end text-uppercase text-muted" style="font-size: 0.75rem; font-weight: 700;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        @if($booking->car->image_path)
                                            <img src="{{ asset('storage/' . $booking->car->image_path) }}" class="w-100 h-100 object-cover rounded-3">
                                        @else
                                            <i class="bi bi-car-front text-muted"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold text-dark" style="font-size: 0.9rem;">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                        <p class="text-muted mb-0 font-monospace" style="font-size: 0.7rem;">{{ $booking->car->plate_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium text-dark" style="font-size: 0.85rem;">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                    </span>
                                    <span class="text-muted" style="font-size: 0.75rem;">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) ?: 1 }} days rental
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">${{ number_format($booking->total_price, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($booking->status === 'confirmed') bg-success-subtle border border-success text-success-emphasis 
                                    @elseif($booking->status === 'completed') bg-light border text-dark 
                                    @elseif($booking->status === 'cancelled') bg-danger-subtle border border-danger text-danger-emphasis 
                                    @else bg-warning-subtle border border-warning text-warning-emphasis 
                                    @endif 
                                    px-2 py-1 rounded-pill fw-bold text-uppercase" 
                                    style="font-size: 9px;">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm border rounded-3" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-2">
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2" href="#" data-bs-toggle="modal" data-bs-target="#manageJourneyModal{{ $booking->id }}">
                                                <i class="bi bi-eye me-2"></i> Details
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item rounded-2 py-2" href="#" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $booking->id }}">
                                                <i class="bi bi-receipt me-2"></i> Invoice
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('components.modals')

<style>
    .object-cover { object-fit: cover; }
    .tracking-tight { letter-spacing: -0.025em; }
</style>
@endsection