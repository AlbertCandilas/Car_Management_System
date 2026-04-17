<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Rental Portal - Bert Car Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white">
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h1 class="display-6 fw-bold">Ready to drive?</h1>
                <p class="text-muted">Choose from our premium selection of cars below.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-outline-primary"><i data-lucide="history" size="18"></i> My Bookings</button>
                <a href="/" class="btn btn-danger ms-2">Logout</a>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 border shadow-sm">
                    <div class="p-4 text-center bg-light">
                        <i data-lucide="car" size="48" class="text-primary"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Toyota Vios 2024</h5>
                        <p class="card-text text-muted mb-4">$45.00 / day</p>
                        <button class="btn btn-dark w-100 rounded-pill">Rent Now</button>
                    </div>
                </div>
            </div>
            </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>