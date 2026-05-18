@foreach($payments as $payment)
    @php $booking = $payment->booking; @endphp
    
    <div class="modal" id="invoiceModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
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
                            <h6 class="fw-bold mb-0">{{ $booking->user->name }}</h6>
                            <span class="text-muted small">{{ $booking->user->email }}</span>
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
                            <thead>
                                <tr class="border-bottom">
                                    <th class="text-muted small fw-bold text-uppercase pb-3" style="font-size: 9px;">Description</th>
                                    <th class="text-muted small fw-bold text-uppercase pb-3 text-end" style="font-size: 9px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3">
                                        <span class="d-block fw-bold text-dark">Rental Fee</span>
                                        <span class="text-muted small">
                                            ₱{{ number_format($booking->car->daily_rate, 2) }} x 
                                            {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) ?: 1 }} Days
                                        </span>
                                    </td>
                                    <td class="py-3 text-end fw-bold text-dark">₱{{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-muted small">Tax (VAT 0%)</td>
                                    <td class="py-2 text-end text-muted small">₱0.00</td>
                                </tr>
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td class="pt-3 fw-bold text-gray-900" style="font-size: 1.1rem;">Total Amount</td>
                                    <td class="pt-3 text-end fw-bold text-blue-600" style="font-size: 1.1rem;">₱{{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4">
                    <button type="button" class="btn btn-light w-100 fw-bold border" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Close Details</button>
                </div>
            </div>
        </div>
    </div>

    @if($payment->payment_status === 'verifying' || $payment->payment_status === 'paid' || $payment->payment_status === 'cancelled')
    <div class="modal" id="verifyModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold text-gray-900 mb-0">Verify GCash Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4">
                    @if($payment->payment_status === 'verifying')
                        <p class="text-muted mb-4" style="font-size: 11px;">Please check the GCash merchant wallet to confirm the payment matches before updating the status.</p>
                    @else
                        <p class="text-muted mb-4" style="font-size: 11px;">This payment has already been processed and cannot be changed.</p>
                    @endif
                    
                    <div class="vstack gap-3 mb-4">
                        <div class="bg-gray-50 rounded-4 p-3 border border-dashed">
                            <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 9px; letter-spacing: 0.05em;">Stated Reference Number</span>
                            <span class="font-monospace fw-bold text-dark fs-6 tracking-wide">{{ $payment->transaction_id ?? 'NOT SUBMITTED' }}</span>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <div class="p-3 border border-dashed rounded-4 bg-gray-50">
                                    <span class="text-muted d-block uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.05em;">Expected Balance</span>
                                    <span class="fw-bold text-dark" style="font-size: 13px;">₱{{ number_format($payment->amount, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border border-dashed rounded-4 bg-gray-50">
                                    <span class="text-muted d-block uppercase fw-bold mb-1" style="font-size: 9px; letter-spacing: 0.05em;">Payer Identity</span>
                                    <span class="fw-bold text-dark d-block text-truncate" style="font-size: 13px;">{{ $booking->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 9px; letter-spacing: 0.05em;">Receipt Image File</span>
                        @if($payment->proof_path)
                            <div class="border border-dashed rounded-4 overflow-hidden bg-gray-50 p-2 text-center">
                                <img src="{{ asset('storage/' . $payment->proof_path) }}" alt="Proof of Payment" class="img-fluid rounded-3 mx-auto" style="max-height: 240px; object-fit: contain;">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $payment->proof_path) }}" target="_blank" class="btn btn-sm btn-link text-decoration-none text-primary p-0 fw-bold" style="font-size: 11px;">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Open full image viewport
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="border border-dashed rounded-4 p-4 text-center bg-gray-50">
                                <i class="bi bi-image-alt text-muted fs-3 d-block mb-1"></i>
                                <span class="d-block small text-muted font-italic">No uploaded screenshot image discovered</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2 justify-content-between">
                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="flex-fill m-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                            class="btn btn-danger btn-sm w-100 fw-bold py-2" 
                            style="border-radius: 0.75rem;"
                            @if($payment->payment_status !== 'verifying') disabled @endif
                        >
                            Reject
                        </button>
                    </form>

                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="flex-fill m-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                            class="btn btn-success btn-sm w-100 fw-bold py-2" 
                            style="border-radius: 0.75rem;"
                            @if($payment->payment_status !== 'verifying') disabled @endif
                        >
                            Approve
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endforeach