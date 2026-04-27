{{-- Reservation Modals for Available Cars --}}
@foreach($availableCars as $car)
<div class="modal fade" id="reserveModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="fw-bold text-gray-900 mb-0">Confirm Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bookings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                <div class="modal-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4 bg-gray-50 p-3 rounded-4 border">
                        <div class="rounded-3 overflow-hidden border bg-white" style="width: 80px; height: 60px;">
                            @if($car->image_path)
                                <img src="{{ asset('storage/' . $car->image_path) }}" class="w-100 h-100 object-cover">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <i class="bi bi-car-front text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $car->brand }} {{ $car->model }}</h6>
                            <span class="text-blue-600 fw-bold small">${{ number_format($car->daily_rate, 2) }} / day</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Pickup Date</label>
                            <input type="date" name="start_date" class="form-control border-gray-200 py-2" required min="{{ date('Y-m-d') }}" style="border-radius: 0.5rem;">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Return Date</label>
                            <input type="date" name="end_date" class="form-control border-gray-200 py-2" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="border-radius: 0.5rem;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light fw-bold px-4 border" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Cancel</button>
                    <button type="submit" class="btn btn-dark fw-bold px-4 flex-grow-1" style="border-radius: 0.75rem;">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Unified Booking Modals --}}
@foreach($myBookings as $booking)
    <div class="modal fade" id="manageJourneyModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold text-gray-900 mb-0">Journey Management</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-2">
                            <div class="list-group-item bg-transparent d-flex justify-content-between py-3 border-0">
                                <span class="text-muted small fw-bold text-uppercase" style="font-size: 10px;">Payment Status</span>
                                
                                @if($booking->payment && $booking->payment->payment_status === 'paid')
                                    <span class="badge bg-light border text-dark fw-bold rounded-pill px-3">PAID</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge bg-danger-subtle border border-danger text-danger fw-bold rounded-pill px-3">CANCELLED</span>
                                @else
                                    <span class="badge bg-warning-subtle border border-warning text-dark fw-bold rounded-pill px-3">PENDING</span>
                                @endif
                            </div>
                        </div>
                        <h4 class="fw-bold mb-1 text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</h4>
                        <p class="text-muted font-monospace small mb-0">{{ $booking->car->plate_number }}</p>
                    </div>

                    <div class="list-group list-group-flush border-top border-bottom mb-4">
                        <div class="list-group-item bg-transparent d-flex justify-content-between py-3 border-0">
                            <span class="text-muted small fw-bold text-uppercase" style="font-size: 10px;">Total Charged</span>
                            <span class="fw-bold text-blue-600">${{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        <div class="list-group-item bg-transparent d-flex justify-content-between py-3 border-0">
                            <span class="text-muted small fw-bold text-uppercase" style="font-size: 10px;">Payment Status</span>
                            @if($booking->payment_status === 'paid')
                                <span class="badge bg-light border text-dark fw-bold rounded-pill px-3">PAID</span>
                            @else
                                <span class="badge bg-warning-subtle border border-warning text-dark fw-bold rounded-pill px-3">PENDING</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-3 bg-gray-50 border rounded-4 mb-3 d-flex align-items-center gap-3">
                        <div class="bg-white rounded-3 p-2 border shadow-sm">
                            <i class="bi bi-wallet2 text-dark"></i>
                        </div>
                        <div>
                            <p class="small fw-bold mb-0 text-dark">Pay Onsite Available</p>
                            <p class="text-muted mb-0" style="font-size: 11px;">You may settle your payment via cash or card at our physical branch upon arrival.</p>
                        </div>
                    </div>

                    <div class="p-3 bg-blue-50 border border-blue-100 rounded-4 d-flex align-items-start gap-3">
                        <i class="bi bi-info-circle-fill text-blue-600"></i>
                        <p class="small mb-0 text-blue-800">For security reasons, plate numbers must match the vehicle registered in your app during pickup.</p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    @if($booking->status === 'pending')
                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="w-100">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 fw-bold py-2" style="border-radius: 0.75rem;">Cancel Journey</button>
                        </form>
                    @else
                        <button class="btn btn-dark w-100 fw-bold py-2" style="border-radius: 0.75rem;">Download Receipt</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="invoiceModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold text-gray-900 mb-0">Invoice Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p class="text-muted small mb-1 uppercase fw-bold" style="font-size: 10px;">Invoice To</p>
                            <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                            <span class="text-muted small">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="text-end">
                            <p class="text-muted small mb-1 uppercase fw-bold" style="font-size: 10px;">Booking Ref</p>
                            <h6 class="fw-bold mb-0 text-uppercase">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h6>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-4 p-3 mb-4 border border-dashed">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-dark">{{ $booking->car->brand }} {{ $booking->car->model }}</span>
                            <span class="text-muted small">{{ $booking->car->plate_number }}</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="text-muted small fw-bold text-uppercase pb-3" style="font-size: 9px;">Description</th>
                                    <th class="text-muted small fw-bold text-uppercase pb-3 text-end" style="font-size: 9px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3">
                                        <span class="d-block fw-bold text-dark">Rental Fee</span>
                                        <span class="text-muted small">
                                            ${{ number_format($booking->car->daily_rate, 2) }} x 
                                            {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) ?: 1 }} Days
                                        </span>
                                    </td>
                                    <td class="py-3 text-end fw-bold text-dark">${{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-muted small">Tax (VAT 0%)</td>
                                    <td class="py-2 text-end text-muted small">$0.00</td>
                                </tr>
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td class="pt-3 fw-bold text-gray-900" style="font-size: 1.1rem;">Total Amount</td>
                                    <td class="pt-3 text-end fw-bold text-blue-600" style="font-size: 1.1rem;">${{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button class="btn btn-light w-100 fw-bold py-2 border" onclick="window.print()" style="border-radius: 0.75rem;">
                        <i class="bi bi-printer me-2"></i> Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach