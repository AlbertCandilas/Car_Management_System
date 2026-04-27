@extends('layouts.admin')

@section('title', 'Maintenance Management')

@section('content')
<main class="flex-1 p-3 lg:p-5">
    <div class="space-y-5">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600">
                    <i class="bi bi-wrench-adjustable text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Maintenance Logs</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Vehicle Service History</p>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 transition-all" 
                        data-bs-toggle="modal" 
                        data-bs-target="#scheduleServiceModal">
                    <i class="bi bi-plus-lg"></i> Schedule Service
                </button>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-xl border border-gray-100">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="w-[15%] px-4 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="w-[25%] px-4 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Vehicle</th>
                        <th class="w-[15%] px-4 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Service</th>
                        <th class="w-[25%] px-4 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Notes</th>
                        <th class="w-[10%] px-4 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Cost</th>
                        <th class="w-[10%] px-4 py-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($maintenanceRecords as $record)
                    <tr class="hover:bg-gray-50/50 transition-all">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <p class="text-xs font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($record->scheduled_date)->format('M d, y') }}
                            </p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-xs font-bold text-gray-800 truncate">{{ $record->car->brand }} {{ $record->car->model }}</p>
                            <p class="text-[9px] text-gray-400 font-mono">{{ $record->car->plate_number }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-[9px] bg-red-50 text-red-600 px-1.5 py-0.5 rounded font-bold uppercase whitespace-nowrap inline-block">
                                {{ $record->service_type }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-[10px] text-gray-500 italic truncate block w-full" title="{{ $record->notes }}">
                                {{ $record->notes ?? 'No notes' }}
                            </p>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <p class="text-xs font-bold text-gray-800">${{ number_format($record->cost, 0) }}</p>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button 
                                    type="button"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editMaintenanceModal{{ $record->id }}"
                                    class="p-1 text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.maintenance.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Delete this maintenance record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @include('components.admin-edit-modal', ['record' => $record])

                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@include('components.admin-create-modal')
@endsection