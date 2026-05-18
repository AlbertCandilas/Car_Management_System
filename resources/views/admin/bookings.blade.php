@extends('layouts.admin')

@section('title', 'Booking Management')

@section('content')
<main class="flex-1 p-3 lg:p-5">
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="bi bi-calendar-check-fill text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Rental Bookings</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Monitor and Update Status</p>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" id="tableSearch" placeholder="Search customer or car..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="w-full">
                <table class="w-full text-left border-collapse table-fixed" id="bookingsTable">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="w-[22%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="w-[20%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Vehicle</th>
                            <th class="w-[18%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Duration</th>
                            <th class="w-[15%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Total Price</th>
                            <th class="w-[12%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Status</th>
                            <th class="w-[13%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50/50 transition-all table-row-item">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2 min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-[10px] shadow-sm flex-shrink-0">
                                        {{ strtoupper(substr($booking->user->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-gray-800 leading-none searchable-field">{{ $booking->user->name }}</p>
                                        <p class="text-[9px] text-gray-500 searchable-field">{{ $booking->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-gray-800 searchable-field">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                    <p class="text-[10px] text-gray-500 searchable-field">{{ $booking->car->plate_number }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2 text-xs">
                                    <div class="text-gray-600">
                                        <p class="font-bold leading-none searchable-field">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }}</p>
                                        <p class="text-[9px] text-gray-400">Start</p>
                                    </div>
                                    <i class="bi bi-arrow-right text-gray-300"></i>
                                    <div class="text-gray-600">
                                        <p class="font-bold leading-none searchable-field">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d') }}</p>
                                        <p class="text-[9px] text-gray-400">End</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <p class="text-xs font-bold text-gray-800 whitespace-nowrap searchable-field">₱{{ number_format($booking->total_price, 2) }}</p>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="px-2 py-1 rounded-full text-[9px] font-bold whitespace-nowrap searchable-field
                                    @if($booking->status === 'confirmed') bg-green-100 text-green-600
                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-600
                                    @elseif($booking->status === 'completed') bg-blue-100 text-blue-600
                                    @else bg-red-100 text-red-600 @endif">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#viewBookingModal{{ $booking->id }}" class="p-1.5 text-gray-400 hover:text-blue-600">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @if($booking->status === 'pending')
                                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="inline" 
                                            onsubmit="return confirm('Confirm this booking? This will set the vehicle status to Rented.')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all" title="Confirm Booking">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline" 
                                            onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Cancel Booking">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="noResultsRow">
                            <td colspan="6" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="bi bi-calendar-x text-3xl text-gray-200"></i>
                                    <p class="text-xs text-gray-400">No booking records found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                        <tr id="jsNoResultsRow" class="hidden">
                            <td colspan="6" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="bi bi-search text-3xl text-gray-200"></i>
                                    <p class="text-xs text-gray-400">No matching booking records found.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-3 bg-gray-50/30 border-t border-gray-100 flex items-center justify-between">
                @if(method_exists($bookings, 'total'))
                    @if($bookings->total() > 0)
                        <p class="text-[10px] text-gray-400 font-bold uppercase">
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} Bookings
                        </p>
                    @else
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Showing 0 Bookings</p>
                    @endif
                @else
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Showing {{ $bookings->count() }} Bookings</p>
                @endif
                
                <div class="flex gap-1">
                    @if(method_exists($bookings, 'onFirstPage'))
                        @if($bookings->onFirstPage())
                            <button class="px-2 py-1 border border-gray-100 rounded-lg text-[10px] text-gray-300 cursor-not-allowed" disabled>Prev</button>
                        @else
                            <a href="{{ $bookings->previousPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] text-gray-600 hover:bg-white transition-all">Prev</a>
                        @endif

                        @if($bookings->hasMorePages())
                            <a href="{{ $bookings->nextPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] text-gray-600 hover:bg-white transition-all">Next</a>
                        @else
                            <button class="px-2 py-1 border border-gray-100 rounded-lg text-[10px] text-gray-300 cursor-not-allowed" disabled>Next</button>
                        @endif
                    @else
                        <button class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] hover:bg-white transition-all">Prev</button>
                        <button class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] hover:bg-white transition-all">Next</button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</main>
@include('components.admin-view-modals')

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