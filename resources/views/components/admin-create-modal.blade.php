{{-- admin-create-modal.blade.php --}}

<div class="modal" id="addCarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl d-flex align-items-center justify-content-center text-blue-600">
                        <i class="bi bi-car-front-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-gray-900 mb-0">Add New Vehicle</h5>
                        <p class="text-muted small mb-0">Register a new car to the fleet inventory</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Brand</label>
                            <input type="text" name="brand" class="form-control border-gray-200 py-2" placeholder="e.g. Toyota" required style="border-radius: 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Model</label>
                            <input type="text" name="model" class="form-control border-gray-200 py-2" placeholder="e.g. Camry" required style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Year</label>
                            <input type="number" name="year" class="form-control border-gray-200 py-2" min="1900" max="{{ date('Y') + 1 }}" value="{{ date('Y') }}" required style="border-radius: 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Plate Number</label>
                            <input type="text" name="plate_number" class="form-control border-gray-200 py-2 font-monospace" placeholder="ABC-1234" required style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Daily Rental Rate ($)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-gray-50 border-gray-200 text-muted" style="border-radius: 0.75rem 0 0 0.75rem;">$</span>
                                <input type="number" step="0.01" name="daily_rate" class="form-control border-gray-200 py-2" placeholder="0.00" required style="border-radius: 0 0.75rem 0.75rem 0;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Initial Status</label>
                            <select name="status" class="form-select border-gray-200 py-2" style="border-radius: 0.75rem;">
                                <option value="available">Available</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="rented" disabled>Rented</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Vehicle Image</label>
                            <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-gray-50/50">
                                <i class="bi bi-cloud-arrow-up fs-2 text-gray-400 mb-2"></i>
                                <input type="file" name="image_path" class="form-control form-control-sm" accept="image/*">
                                <p class="text-muted mt-2 mb-0" style="font-size: 11px;">Recommended: 800x600px (JPG, PNG)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light fw-bold px-4 border" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Cancel</button>
                    <button type="submit" class="btn btn-blue-600 text-white fw-bold px-4 flex-grow-1" style="border-radius: 0.75rem; background-color: #2563eb;">Register Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="scheduleServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl d-flex align-items-center justify-content-center text-orange-600">
                        <i class="bi bi-wrench-adjustable fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-gray-900 mb-0">Schedule Service</h5>
                        <p class="text-muted small mb-0">Log maintenance for a specific vehicle</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.maintenance.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Select Vehicle</label>
                            <select name="car_id" class="form-select border-gray-200 py-2" required style="border-radius: 0.75rem;">
                                <option value="" selected disabled>Choose a car...</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->brand }} {{ $car->model }} ({{ $car->plate_number }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Service Type</label>
                            <input type="text" name="service_type" class="form-control border-gray-200 py-2" placeholder="e.g. Oil Change" required style="border-radius: 0.75rem;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Scheduled Date</label>
                            <input type="date" name="scheduled_date" class="form-control border-gray-200 py-2" required value="{{ date('Y-m-d') }}" style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Estimated Cost ($)</label>
                            <input type="number" step="0.01" name="cost" class="form-control border-gray-200 py-2" placeholder="0.00" required style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase" style="font-size: 10px;">Service Notes</label>
                            <textarea name="notes" class="form-control border-gray-200 py-2" rows="3" placeholder="Describe the maintenance requirements..." style="border-radius: 0.75rem;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light fw-bold px-4 border" data-bs-dismiss="modal" style="border-radius: 0.75rem;">Cancel</button>
                    <button type="submit" class="btn btn-orange text-white fw-bold px-4 flex-grow-1" style="border-radius: 0.75rem; background-color: #ea580c;">Log Maintenance</button>
                </div>
            </form>
        </div>
    </div>
</div>