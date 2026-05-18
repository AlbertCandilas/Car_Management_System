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
                <div class="relative flex-1 sm:w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" id="tableSearch" placeholder="Search vehicle, service, or notes..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition-all">
                </div>
                <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 transition-all flex-shrink-0" 
                        data-bs-toggle="modal" 
                        data-bs-target="#scheduleServiceModal">
                    <i class="bi bi-plus-lg"></i> Schedule Service
                </button>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
            <table class="w-full text-left border-collapse table-fixed" id="maintenanceTable">
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
                    <tr class="hover:bg-gray-50/50 transition-all table-row-item">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <p class="text-xs font-bold text-gray-800 searchable-field">
                                {{ \Carbon\Carbon::parse($record->scheduled_date)->format('M d, y') }}
                            </p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-xs font-bold text-gray-800 truncate searchable-field">{{ $record->car->brand }} {{ $record->car->model }}</p>
                            <p class="text-[9px] text-gray-400 font-mono searchable-field">{{ $record->car->plate_number }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-[9px] bg-red-50 text-red-600 px-1.5 py-0.5 rounded font-bold uppercase whitespace-nowrap inline-block searchable-field">
                                {{ $record->service_type }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-[10px] text-gray-500 italic truncate block w-full searchable-field" title="{{ $record->notes }}">
                                {{ $record->notes ?? 'No notes' }}
                            </p>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <p class="text-xs font-bold text-gray-800 whitespace-nowrap searchable-field">₱{{ number_format($record->cost, 0) }}</p>
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
                    <tr id="noResultsRow">
                        <td colspan="6" class="px-5 py-10 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="bi bi-wrench text-3xl text-gray-200"></i>
                                <p class="text-xs text-gray-400 font-medium">No maintenance logs registered yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    <tr id="jsNoResultsRow" class="hidden">
                        <td colspan="6" class="px-5 py-10 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="bi bi-search text-3xl text-gray-200"></i>
                                <p class="text-xs text-gray-400">No matching logs found.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="px-5 py-3 bg-gray-50/30 border-t border-gray-100 flex items-center justify-between">
                @if(method_exists($maintenanceRecords, 'total'))
                    @if($maintenanceRecords->total() > 0)
                        <p class="text-[10px] text-gray-400 font-bold uppercase">
                            Showing {{ $maintenanceRecords->firstItem() }} to {{ $maintenanceRecords->lastItem() }} of {{ $maintenanceRecords->total() }} Records
                        </p>
                    @else
                        <p class="text-[10px] text-gray-400 font-bold uppercase">Showing 0 Records</p>
                    @endif
                @else
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Showing {{ $maintenanceRecords->count() }} Records</p>
                @endif
                
                <div class="flex gap-1">
                    @if(method_exists($maintenanceRecords, 'onFirstPage'))
                        @if($maintenanceRecords->onFirstPage())
                            <button class="px-2 py-1 border border-gray-100 rounded-lg text-[10px] text-gray-300 cursor-not-allowed" disabled>Prev</button>
                        @else
                            <a href="{{ $maintenanceRecords->previousPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] text-gray-600 hover:bg-white transition-all">Prev</a>
                        @endif

                        @if($maintenanceRecords->hasMorePages())
                            <a href="{{ $maintenanceRecords->nextPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded-lg text-[10px] text-gray-600 hover:bg-white transition-all">Next</a>
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
@include('components.admin-create-modal')

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