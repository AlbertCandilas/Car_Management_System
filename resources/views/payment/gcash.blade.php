@extends('layouts.app')

@section('content')
<div class="container py-4">
    <form action="{{ route('payment.gcash.submit', $booking->id) }}" method="POST" enctype="multipart/form-data" class="m-0">
        @csrf
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 1rem;">
            <div class="row g-0">
                
                <div class="col-lg-5 bg-white p-4 d-flex flex-column justify-content-between border-end">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center progress-icon" style="width: 32px; height: 32px; background-color: #007dfe;">
                                    <i class="bi bi-wallet2 text-white small"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">GCash Transfer</h6>
                            </div>
                            <span class="font-monospace text-muted small" style="font-size: 0.75rem;">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div class="mb-4">
                            <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.05em;">Amount Due</span>
                            <h2 class="fw-bold mb-2" style="color: #007dfe; letter-spacing: -0.02em;">${{ number_format($booking->total_price, 2) }}</h2>
                            <p class="text-muted small mb-0 d-flex align-items-center gap-1">
                                <i class="bi bi-car-front text-primary"></i> {{ $booking->car->brand }} {{ $booking->car->model }}
                            </p>
                        </div>

                        <div class="pt-2">
                            <span class="text-muted text-uppercase fw-bold d-block mb-3" style="font-size: 10px; letter-spacing: 0.05em;">How to pay</span>
                            <div class="vstack gap-2">
                                <div class="d-flex gap-2 align-items-center p-2 rounded-3 step-card">
                                    <span class="badge bg-light text-dark border rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px;">1</span>
                                    <p class="mb-0 small text-muted">Open your <strong class="text-dark">GCash App</strong></p>
                                </div>
                                <div class="d-flex gap-2 align-items-center p-2 rounded-3 step-card">
                                    <span class="badge bg-light text-dark border rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px;">2</span>
                                    <p class="mb-0 small text-muted">Send money to: <strong class="text-dark">0912-345-6789</strong></p>
                                </div>
                                <div class="d-flex gap-2 align-items-center p-2 rounded-3 step-card">
                                    <span class="badge bg-light text-dark border rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px;">3</span>
                                    <p class="mb-0 small text-muted">Copy the <strong class="text-dark">13-digit Reference No.</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top mt-4 d-flex align-items-center gap-2 text-muted" style="font-size: 11px;">
                        <i class="bi bi-shield-check text-success fs-6"></i>
                        <span>Secure encrypted verification gateway</span>
                    </div>
                </div>

                <div class="col-lg-7 bg-white p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-bold text-dark mb-0">Payment Settlement</h6>
                            <a href="{{ route('customer.bookings') }}" class="btn btn-sm btn-link-custom text-muted p-0 text-decoration-none small d-inline-flex align-items-center gap-1">
                                <i class="bi bi-arrow-left"></i> Return to Bookings
                            </a>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.05em;">
                                Reference Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group custom-input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted transition-all"><i class="bi bi-hash"></i></span>
                                <input type="text" name="reference_number" class="form-control bg-light border-start-0 custom-control @error('reference_number') is-invalid @enderror" required placeholder="Enter the 13-digit sequence" autocomplete="off" value="{{ old('reference_number') }}">
                            </div>
                            @error('reference_number')
                                <div class="invalid-feedback d-block mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-bold text-muted text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.05em;">
                                Receipt Attachment <span class="text-danger">*</span>
                            </label>
                            <div class="upload-zone border border-dashed rounded-3 p-3 text-center bg-light position-relative">
                                <input type="file" name="proof_of_payment" id="proof_of_payment" class="file-input-overlay @error('proof_of_payment') is-invalid @enderror" required>
                                <div class="upload-content">
                                    <i class="bi bi-cloud-arrow-up text-muted fs-3 mb-1 d-block upload-icon"></i>
                                    <span class="d-block small text-dark fw-bold file-name-text">Click to add snapshot file</span>
                                    <span class="d-block text-muted info-subtext" style="font-size: 11px;">Supports PNG, JPG, JPEG up to 2MB</span>
                                </div>
                            </div>
                            @error('proof_of_payment')
                                <div class="invalid-feedback d-block mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-4">
                        <span class="text-muted" style="font-size: 11px;"><span class="text-danger">*</span> Required input entries</span>
                        <button type="submit" class="btn btn-primary-custom fw-bold px-4 py-2 d-flex align-items-center gap-2">
                            Submit Processing Clearance <i class="bi bi-arrow-right small"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<style>
    .transition-all {
        transition: all 0.2s ease-in-out;
    }
    .border-dashed { 
        border-style: dashed !important; 
        border-width: 1.5px !important; 
    }
    .step-card {
        transition: background-color 0.2s ease;
    }
    .step-card:hover {
        background-color: #f8f9fa;
    }
    .custom-control {
        border: 1px solid #dee2e6;
        transition: all 0.2s ease-in-out;
    }
    .custom-control:focus {
        background-color: #fff !important;
        box-shadow: none;
        border-color: #007dfe;
    }
    .custom-input-group:focus-within .input-group-text {
        background-color: #fff !important;
        border-color: #007dfe;
        color: #007dfe !important;
    }
    .btn-link-custom {
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .btn-link-custom:hover {
        color: #007dfe !important;
        transform: translateX(-2px);
    }
    .upload-zone {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }
    .upload-zone:hover {
        background-color: #f1f3f5 !important;
        border-color: #007dfe !important;
    }
    .upload-zone:hover .upload-icon {
        color: #007dfe !important;
        transform: translateY(-2px);
    }
    .upload-zone.has-file {
        border-color: #198754 !important;
        background-color: #f0fdf4 !important;
    }
    .upload-icon {
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .file-input-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }
    .btn-primary-custom {
        background-color: #007dfe;
        color: #fff;
        border: none;
        font-size: 0.85rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 125, 254, 0.15);
    }
    .btn-primary-custom:hover {
        background-color: #006ae0;
        box-shadow: 0 4px 8px rgba(0, 125, 254, 0.25);
        transform: translateY(-1px);
    }
    .btn-primary-custom:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 125, 254, 0.15);
    }
</style>

<script>
    document.getElementById('proof_of_payment').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : "Click to add snapshot file";
        const zone = this.closest('.upload-zone');
        const textDisplay = zone.querySelector('.file-name-text');
        const subtextDisplay = zone.querySelector('.info-subtext');
        const icon = zone.querySelector('.upload-icon');
        
        if(e.target.files[0]) {
            zone.classList.add('has-file');
            textDisplay.textContent = fileName;
            textDisplay.classList.replace('text-dark', 'text-success');
            subtextDisplay.textContent = "File staged successfully";
            icon.className = "bi bi-check-circle-fill text-success fs-3 mb-1 d-block upload-icon";
        } else {
            zone.classList.remove('has-file');
            textDisplay.textContent = "Click to add snapshot file";
            textDisplay.classList.replace('text-success', 'text-dark');
            subtextDisplay.textContent = "Supports PNG, JPG, JPEG up to 2MB";
            icon.className = "bi bi-cloud-arrow-up text-muted fs-3 mb-1 d-block upload-icon";
        }
    });
</script>
@endsection