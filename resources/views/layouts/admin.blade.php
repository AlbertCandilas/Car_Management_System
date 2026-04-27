<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bert Car Management - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .sidebar-expanded { width: 16rem; }
        .sidebar-collapsed { width: 5rem; }
        .hidden-content { display: none !important; }
        
        .sidebar-gradient {
            background: linear-gradient(to bottom, #1a1f36, #0f1420);
        }
        .active-link {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.5);
            transform: scale(1.05);
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .sidebar-collapsed .nav-link-item {
            justify-content: center;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .sidebar-collapsed .nav-text {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="h-screen flex overflow-hidden">
        <div id="sidebar" class="sidebar-gradient text-white flex flex-col shadow-2xl z-20 sidebar-expanded">
            
            <div class="p-6 border-b border-white/10 h-24 flex items-center">
                
                <div id="header-expanded" class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4 flex-1 pr-2">
                        <img src="{{ asset('image/Bert_Car_Logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-sm font-bold text-white leading-tight">Bert Car Management</h1>
                            <p class="text-[9px] text-gray-400 mt-0.5 uppercase tracking-wider">System Dashboard</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="p-1.5 hover:bg-white/10 rounded-lg shrink-0">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>

                <div id="header-collapsed" class="hidden-content flex flex-col items-center justify-center w-full gap-2">
                    <img src="{{ asset('image/Bert_Car_Logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    <button onclick="toggleSidebar()" class="p-1.5 hover:bg-white/10 rounded-lg">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1 mt-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link-item w-full gap-3 px-4 py-3 rounded-xl group {{ request()->routeIs('admin.dashboard') ? 'active-link' : 'hover:bg-white/10' }}">
                    <i class="bi bi-speedometer2 text-xl"></i>
                    <span class="nav-text text-sm font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.cars') }}" 
                   class="nav-link-item w-full gap-3 px-4 py-3 rounded-xl group {{ request()->routeIs('admin.cars') ? 'active-link' : 'hover:bg-white/10' }}">
                    <i class="bi bi-car-front text-xl"></i>
                    <span class="nav-text text-sm font-medium">Car Fleet</span>
                </a>

                <a href="{{ route('admin.bookings') }}"
                   class="nav-link-item w-full gap-3 px-4 py-3 rounded-xl group {{ request()->routeIs('admin.bookings') ? 'active-link' : 'hover:bg-white/10' }}">
                    <i class="bi bi-calendar-check text-xl"></i>
                    <span class="nav-text text-sm font-medium">Bookings</span>
                </a>

                <a href="{{ route('admin.customers') }}"
                   class="nav-link-item w-full gap-3 px-4 py-3 rounded-xl group {{ request()->routeIs('admin.customers') ? 'active-link' : 'hover:bg-white/10' }}">
                    <i class="bi bi-people text-xl"></i>
                    <span class="nav-text text-sm font-medium">Customers</span>
                </a>

                <a href="{{ route('admin.payments') }}"
                   class="nav-link-item w-full gap-3 px-4 py-3 rounded-xl group {{ request()->routeIs('admin.payments') ? 'active-link' : 'hover:bg-white/10' }}">
                    <i class="bi bi-cash-stack text-xl"></i>
                    <span class="nav-text text-sm font-medium">Payments</span>
                </a>

                <a href="{{ route('admin.maintenance') }}"
                   class="nav-link-item w-full gap-3 px-4 py-3 rounded-xl group {{ request()->routeIs('admin.maintenance') ? 'active-link' : 'hover:bg-white/10' }}">
                    <i class="bi bi-tools text-xl"></i>
                    <span class="nav-text text-sm font-medium">Maintenance</span>
                </a>

                <div class="pt-4 mt-4 border-t border-white/10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link-item w-full gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 group">
                            <i class="bi bi-box-arrow-right text-xl text-gray-400 group-hover:text-red-500"></i>
                            <span class="nav-text text-sm font-medium text-gray-300 group-hover:text-red-500">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div>
                    <h2 id="page-title" class="text-2xl font-bold text-gray-800">@yield('title')</h2>
                </div>
                <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-500 uppercase font-bold">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold border-2 border-blue-200">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const headerExp = document.getElementById('header-expanded');
            const headerCol = document.getElementById('header-collapsed');

            if (sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.replace('sidebar-expanded', 'sidebar-collapsed');
                headerExp.classList.add('hidden-content');
                headerCol.classList.remove('hidden-content');
            } else {
                sidebar.classList.replace('sidebar-collapsed', 'sidebar-expanded');
                headerExp.classList.remove('hidden-content');
                headerCol.classList.add('hidden-content');
            }
        }
    </script>
</body>
</html>