{{-- Customer View Modal --}}
@isset($customers)
@foreach($customers as $customer)
<div class="modal" id="viewCustomerModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="fw-bold text-gray-900 mb-0">Customer Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="w-20 h-20 rounded-full bg-gray-900 mx-auto flex items-center justify-center text-white text-2xl font-bold shadow-md mb-3">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </div>
                    <h4 class="fw-bold text-gray-800 mb-1">{{ $customer->name }}</h4>
                    <span class="badge bg-blue-50 text-blue-600 border border-blue-100 rounded-pill px-3 py-2 text-uppercase tracking-wider" style="font-size: 10px;">{{ $customer->role }}</span>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 p-3 rounded-2xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-2">Account Information</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-[10px] text-gray-500 mb-0">Email Address</p>
                                <p class="text-xs font-bold text-gray-800">{{ $customer->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 mb-0">Phone Number</p>
                                <p class="text-xs font-bold text-gray-800">{{ $customer->phone ?? 'Not Linked' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-2xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-2">Verification</p>
                        <div>
                            <p class="text-[10px] text-gray-500 mb-0">Driver's License Number</p>
                            <p class="text-xs font-mono font-bold text-gray-800 uppercase tracking-widest">
                                {{ $customer->driver_license ?? 'UNVERIFIED' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4">
                <button type="button" class="btn btn-light w-100 fw-bold border" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Close Details</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endisset

{{-- Booking View Modal --}}
@isset($bookings)
@foreach($bookings as $booking)
<div class="modal" id="viewBookingModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="fw-bold text-gray-900 mb-0">Booking Details</h5>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0">Ref: #BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    {{-- Left Column: Customer & Car --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded-2xl border border-gray-100 bg-gray-50/50 mb-3">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-3">Customer</p>
                            <div class="flex items-center gap-3">
                                 <div class="w-9 h-9 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-[10px] shadow-sm flex-shrink-0">
                                    {{ strtoupper(substr($booking->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 mb-0">{{ $booking->user->name }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded-2xl border border-gray-100 bg-gray-50/50">
                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-3">Rented Vehicle</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white">
                                    <i class="bi bi-car-front"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 mb-0">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                    <p class="text-[10px] text-gray-500 font-mono">{{ $booking->car->plate_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Schedule & Pricing --}}
                    <div class="col-md-6">
                        <div class="p-3 rounded-2xl border border-blue-100 bg-blue-50/30 mb-3">
                            <p class="text-[10px] text-blue-400 font-bold uppercase mb-3 text-center">Rental Period</p>
                            <div class="flex justify-between items-center px-2">
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase">Pickup</p>
                                    <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</p>
                                </div>
                                <i class="bi bi-arrow-right text-blue-300"></i>
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase">Return</p>
                                    <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded-2xl border border-gray-100 bg-gray-50">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs text-gray-500">Rental Status</span>
                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'green' : 'yellow' }}-100 text-{{ $booking->status === 'confirmed' ? 'green' : 'yellow' }}-600 rounded-pill px-2 py-1 text-[9px] font-bold uppercase">
                                    {{ $booking->status }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 mt-2 pt-2">
                                <span class="text-sm font-bold text-gray-800">Total Amount</span>
                                <span class="text-lg font-black text-blue-600">${{ number_format($booking->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endisset