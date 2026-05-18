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
                    <input type="text" id="tableSearch" placeholder="Search payments..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="w-full">
                <table class="w-full text-left border-collapse table-fixed" id="paymentsTable">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="w-[18%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Transaction Date</th>
                            <th class="w-[20%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Customer & Booking</th>
                            <th class="w-[15%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Method</th>
                            <th class="w-[12%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Amount</th>
                            <th class="w-[13%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Status</th>
                            <th class="w-[13%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($payments as $payment)
                        @php $booking = $payment->booking; @endphp
                        <tr class="hover:bg-gray-50/50 transition-all table-row-item">
                            <td class="px-5 py-3 whitespace-nowrap">
                                <p class="text-xs font-bold text-gray-800 leading-none searchable-field">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                </p>
                                <p class="text-[9px] text-gray-400">{{ \Carbon\Carbon::parse($payment->payment_date)->format('h:i A') }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex flex-col min-w-0">
                                    <p class="text-xs font-bold text-gray-800 searchable-field">{{ $payment->booking->user->name }}</p>
                                    <p class="text-[10px] text-blue-600 font-medium searchable-field">
                                        Booking #{{ $payment->booking_id }} — {{ $payment->booking->car->brand }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded uppercase tracking-tighter whitespace-nowrap searchable-field">
                                        {{ $payment->payment_method }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <p class="text-xs font-bold text-gray-800 whitespace-nowrap searchable-field">₱{{ number_format($payment->amount, 2) }}</p>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="px-2 py-1 rounded-full text-[9px] font-bold whitespace-nowrap searchable-field
                                    @if($payment->payment_status === 'paid') 
                                        bg-green-100 text-green-600 
                                    @elseif($payment->payment_status === 'verifying') 
                                        bg-sky-100 text-sky-700 
                                    @elseif($payment->payment_status === 'cancelled') 
                                        bg-red-100 text-red-600 
                                    @else 
                                        bg-yellow-100 text-yellow-600 
                                    @endif">
                                    {{ strtoupper($payment->payment_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button 
                                        type="button"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#invoiceModal{{ $booking->id }}" 
                                        class="p-1.5 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-all" 
                                        title="View Receipt"
                                    >
                                        <i class="bi bi-receipt"></i>
                                    </button>

                                    @if($payment->payment_status === 'verifying' || $payment->payment_status === 'paid' || $payment->payment_status === 'cancelled')
                                        <button 
                                            type="button"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#verifyModal{{ $payment->id }}" 
                                            class="p-1.5 text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-lg transition-all relative" 
                                            title="View Verification Details">
                                            <i class="bi bi-shield-check"></i>
                                            
                                            @if($payment->payment_status === 'verifying')
                                                <span class="absolute top-1 right-1 flex h-1.5 w-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-sky-500"></span>
                                                </span>
                                            @endif
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="noResultsRow">
                            <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-xs">No records found.</td>
                        </tr>
                        @endforelse
                        <tr id="jsNoResultsRow" class="hidden">
                            <td colspan="6" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="bi bi-search text-3xl text-gray-200"></i>
                                    <p class="text-xs text-gray-400">No matching payments found.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-3 bg-gray-50/30 border-t border-gray-100 flex items-center justify-between">
                @if(method_exists($payments, 'total'))
                    @if($payments->total() > 0)
                        <p class="text-[10px] text-gray-400 font-bold uppercase">
                            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} Payments
                        </p>
                    @else
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Showing 0 Payments</p>
                    @endif
                @else
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Showing {{ $payments->count() }} Payments</p>
                @endif
                
                <div class="flex gap-1">
                    @if(method_exists($payments, 'onFirstPage'))
                        @if($payments->onFirstPage())
                            <button class="px-2 py-1 border border-gray-100 rounded-lg text-[10px] text-gray-300 cursor-not-allowed" disabled>Prev</button>
                        @else
                            <a href="{{ $payments->previousPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] text-gray-600 hover:bg-white transition-all">Prev</a>
                        @endif

                        @if($payments->hasMorePages())
                            <a href="{{ $payments->nextPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] text-gray-600 hover:bg-white transition-all">Next</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@include('components.admin-verify-modal')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('tableSearch');
    const tableRows = document.querySelectorAll('.table-row-item');
    const jsNoResultsRow = document.getElementById('jsNoResultsRow');
    const nativeNoResultsRow = document.getElementById('noResultsRow');

    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const query = e.target.value.toLowerCase().trim();
            let hasVisibleRows = false;

            tableRows.forEach(row => {
                const searchableElements = row.querySelectorAll('.searchable-field');
                let matchFound = false;

                searchableElements.forEach(element => {
                    if (element.textContent.toLowerCase().includes(query)) {
                        matchFound = true;
                    }
                });

                if (matchFound) {
                    row.classList.remove('hidden');
                    hasVisibleRows = true;
                } else {
                    row.classList.add('hidden');
                }
            });

            if (nativeNoResultsRow) {
                if (query !== '') {
                    nativeNoResultsRow.classList.add('hidden');
                } else if (tableRows.length === 0) {
                    nativeNoResultsRow.classList.remove('hidden');
                }
            }

            if (!hasVisibleRows && tableRows.length > 0) {
                jsNoResultsRow.classList.remove('hidden');
            } else {
                jsNoResultsRow.classList.add('hidden');
            }
        });
    }
});
</script>
@endsection