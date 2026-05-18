@isset($car)
<div class="modal" id="editCarModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl d-flex align-items-center justify-content-center text-blue-600">
                        <i class="bi bi-pencil-square fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-gray-900 mb-0">Edit Vehicle</h5>
                        <p class="text-muted small mb-0">Update information for {{ $car->brand }} {{ $car->model }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Brand</label>
                            <input type="text" name="brand" class="form-control border-gray-200 py-2" value="{{ $car->brand }}" required style="border-radius: 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Model</label>
                            <input type="text" name="model" class="form-control border-gray-200 py-2" value="{{ $car->model }}" required style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Year</label>
                            <input type="number" name="year" class="form-control border-gray-200 py-2" min="1900" max="{{ date('Y') + 1 }}" value="{{ $car->year }}" required style="border-radius: 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Plate Number</label>
                            <input type="text" name="plate_number" class="form-control border-gray-200 py-2 font-monospace" value="{{ $car->plate_number }}" required style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Daily Rental Rate (₱)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-gray-50 border-gray-200 text-muted" style="border-radius: 0.75rem 0 0 0.75rem;">₱</span>
                                <input type="number" step="0.01" name="daily_rate" class="form-control border-gray-200 py-2" value="{{ $car->daily_rate }}" required style="border-radius: 0 0.75rem 0.75rem 0;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Status</label>
                            <select name="status" class="form-select border-gray-200 py-2" style="border-radius: 0.75rem;">
                                <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="maintenance" {{ $car->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="rented" {{ $car->status == 'rented' ? 'selected' : '' }}>Rented</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Update Image</label>
                            <div class="border border-dashed rounded-4 p-4 text-center bg-gray-50">
                                @if($car->image_path)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $car->image_path) }}" class="rounded-3 border" style="height: 60px; width: 80px; object-fit: cover;">
                                        <p class="text-muted mt-1 mb-0" style="font-size: 10px;">Current Image</p>
                                    </div>
                                @endif
                                <input type="file" name="image_path" class="form-control form-control-sm mx-auto" accept="image/*" style="max-width: 280px; border-radius: 0.5rem;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                    <button type="button" class="btn btn-light fw-bold px-4 border" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Cancel</button>
                    <button type="submit" class="btn btn-blue-600 text-white fw-bold px-4 flex-grow-1 border-0" style="border-radius: 0.75rem; background-color: #2563eb;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endisset

@isset($record)
<div class="modal" id="editMaintenanceModal{{ $record->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl d-flex align-items-center justify-content-center text-orange-600">
                        <i class="bi bi-tools fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-gray-900 mb-0">Update Service Log</h5>
                        <p class="text-muted small mb-0">Modify maintenance details</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.maintenance.update', $record->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Vehicle</label>
                            <input type="text" class="form-control border-gray-200 py-2 bg-gray-50 text-muted fw-bold" value="{{ $record->car->brand }} {{ $record->car->model }}" disabled style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Service Type</label>
                            <input type="text" name="service_type" class="form-control border-gray-200 py-2" value="{{ $record->service_type }}" required style="border-radius: 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Scheduled Date</label>
                            <input type="date" name="scheduled_date" class="form-control border-gray-200 py-2" value="{{ $record->scheduled_date }}" required style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Cost (₱)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-gray-50 border-gray-200 text-muted" style="border-radius: 0.75rem 0 0 0.75rem;">₱</span>
                                <input type="number" step="0.01" name="cost" class="form-control border-gray-200 py-2" value="{{ $record->cost }}" required style="border-radius: 0 0.75rem 0.75rem 0;">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Service Notes</label>
                            <textarea name="notes" class="form-control border-gray-200 py-2" rows="3" style="border-radius: 0.75rem;">{{ $record->notes }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                    <button type="button" class="btn btn-light fw-bold px-4 border" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Cancel</button>
                    <button type="submit" class="btn btn-orange text-white fw-bold px-4 flex-grow-1 border-0" style="border-radius: 0.75rem; background-color: #ea580c;">Update Log</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endisset