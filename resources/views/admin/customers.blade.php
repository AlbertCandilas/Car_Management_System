@extends('layouts.admin')

@section('title', 'Customer Management')

@section('content')
<main class="flex-1 p-3 lg:p-5">
    <div class="space-y-5">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                    <i class="bi bi-people-fill text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Customer Directory</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Manage Registered Clients</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Search name, email, or license..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="w-full">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="w-[25%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Customer Info</th>
                            <th class="w-[27%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Contact Details</th>
                            <th class="w-[20%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Driver's License</th>
                            <th class="w-[15%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Joined Date</th>
                            <th class="w-[15%] px-5 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50/50 transition-all">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gray-900 flex items-center justify-center text-white font-bold text-[10px] shadow-sm flex-shrink-0">
                                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-gray-800 mb-0">{{ $customer->name }}</p>
                                        <p class="text-[9px] text-gray-400 font-medium">ID: #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex flex-col gap-0.5 min-w-0">
                                    <span class="text-xs text-gray-600"><i class="bi bi-envelope me-1 text-[10px]"></i> {{ $customer->email }}</span>
                                    <span class="text-[10px] text-gray-400"><i class="bi bi-telephone me-1"></i> {{ $customer->phone ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-block text-[10px] bg-gray-50 text-gray-700 font-mono font-bold px-2 py-1 rounded border border-gray-100 uppercase">
                                    {{ $customer->driver_license ?? 'Not Provided' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="text-[10px] text-gray-500 font-bold whitespace-nowrap">{{ $customer->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#viewCustomerModal{{ $customer->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="bi bi-people text-3xl text-gray-200"></i>
                                    <p class="text-xs text-gray-400 font-medium">No customers registered yet.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@include('components.admin-view-modals')
@endsection