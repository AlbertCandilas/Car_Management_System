@extends('layouts.admin')

@section('title', 'Payment Management')

@section('content')
<main class="flex-1 p-3 lg:p-5">
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                    <i class="bi bi-cash-stack text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Financial Records</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Transaction History</p>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Search payments..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="w-full">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="w-[18%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Transaction Date</th>
                            <th class="w-[20%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Customer & Booking</th>
                            <th class="w-[15%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Method</th>
                            <th class="w-[12%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Amount</th>
                            <th class="w-[13%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Status</th>
                            <th class="w-[13%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($payments as $payment)
                        @php $booking = $payment->booking; @endphp
                        <tr class="hover:bg-gray-50/50 transition-all">
                            <td class="px-5 py-3 whitespace-nowrap">
                                <p class="text-xs font-bold text-gray-800 leading-none">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                </p>
                                <p class="text-[9px] text-gray-400">{{ \Carbon\Carbon::parse($payment->payment_date)->format('h:i A') }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex flex-col min-w-0">
                                    <p class="text-xs font-bold text-gray-800">{{ $payment->booking->user->name }}</p>
                                    <p class="text-[10px] text-blue-600 font-medium">
                                        Booking #{{ $payment->booking_id }} — {{ $payment->booking->car->brand }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded uppercase tracking-tighter whitespace-nowrap">
                                        {{ $payment->payment_method }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <p class="text-xs font-bold text-gray-800 whitespace-nowrap">₱{{ number_format($payment->amount, 2) }}</p>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="px-2 py-1 rounded-full text-[9px] font-bold whitespace-nowrap
                                    @if($payment->payment_status === 'paid') 
                                        bg-green-100 text-green-600 
                                    @elseif($payment->payment_status === 'cancelled') 
                                        bg-red-100 text-red-600 
                                    @else 
                                        bg-yellow-100 text-yellow-600 
                                    @endif">
                                    {{ strtoupper($payment->payment_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button 
                                        type="button"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#invoiceModal{{ $booking->id }}" 
                                        class="p-1.5 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all" 
                                        title="View Receipt"
                                    >
                                        <i class="bi bi-receipt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-xs">No records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
                    <div class="modal-footer border-0 pt-0 pb-4 px-4">
                        <button class="btn btn-light w-100 fw-bold py-2 border" onclick="window.print()" style="border-radius: 0.75rem;">
                            <i class="bi bi-printer me-2"></i> Print Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</main>
@endsection