<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f9fafb;
        }

        .navbar-custom {
            background: #ffffff;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .nav-link {
            color: #4b5563 !important; 
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.6rem 1.25rem !important;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: #2563eb !important;
            background: #f3f4f6;
        }

        .active-link {
            background: #eff6ff !important;
            color: #2563eb !important;
            border: 1px solid #dbeafe;
        }

        .user-profile-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            transition: background 0.2s;
        }

        .user-profile-box:hover {
            background: #f3f4f6;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: #2563eb;
            color: white;
            border-radius: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        .portal-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 2rem 0;
            margin-bottom: 2.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.025em;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1.25rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            margin-top: auto;
        }

        * {
            transition: none !important;
            animation: none !important;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('customer.portal') }}">
                <img src="{{ asset('image/Bert_Car_Logo.png') }}" alt="Logo">
                <div class="d-none d-sm-block">
                    <h1 class="mb-0" style="font-size: 1rem; font-weight: 800; color: #111827;">Bert Car</h1>
                    <p class="text-uppercase tracking-widest mb-0" style="font-size: 10px; color: #6b7280; font-weight: 700;">Customer Portal</p>
                </div>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.portal') ? 'active-link' : '' }}" href="{{ route('customer.portal') }}">
                            <i class="bi bi-house-door me-2"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.bookings') ? 'active-link' : '' }}" 
                            href="{{ route('customer.bookings') }}">
                                <i class="bi bi-calendar-event me-2"></i> My Bookings
                        </a>
                    </li>
                </ul>

                <div class="dropdown">
                    <button class="btn user-profile-box d-flex align-items-center gap-3 border-1" type="button" data-bs-toggle="dropdown">
                        <div class="text-end d-none d-md-block">
                            <p class="mb-0 fw-bold" style="font-size: 0.8rem; color: #111827;">{{ Auth::user()->name }}</p>
                            <p class="text-uppercase mb-0" style="font-size: 10px; color: #6b7280; font-weight: 700;">Client</p>
                        </div>
                        <div class="user-avatar">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2 mt-2" style="border-radius: 1rem;">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2 fw-bold" style="font-size: 0.85rem;">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 pb-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="py-5">
        <div class="container text-center">
            <p class="text-muted mb-0 fw-medium" style="font-size: 0.85rem;">
                © 2026 Bert Car Management. Designed for excellence.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>