<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bert Car Management - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true, currentPage: 'dashboard' }">

    <div class="h-screen flex overflow-hidden">
        
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" 
             class="bg-gradient-to-b from-[#1a1f36] to-[#0f1420] text-white transition-all duration-300 flex flex-col shadow-2xl z-20">
            
            <div class="p-6 border-b border-white/10">
                <template x-if="sidebarOpen">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3 flex-1 pr-2">
                            <img src="{{ asset('image/Bert_Car_Logo.png') }}" alt="Logo" class="w-12 h-12 object-contain flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h1 class="text-sm font-bold text-white leading-tight">Bert Car Management</h1>
                                <p class="text-[10px] text-gray-400 mt-0.5 uppercase tracking-wider">System Dashboard</p>
                            </div>
                        </div>
                        <button @click="sidebarOpen = false" class="p-1.5 hover:bg-white/10 rounded-lg transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                </template>
                <template x-if="!sidebarOpen">
                    <div class="flex flex-col items-center gap-3">
                        <img src="{{ asset('image/Bert_Car_Logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        <button @click="sidebarOpen = true" class="p-1.5 hover:bg-white/10 rounded-lg transition-colors">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                    </div>
                </template>
            </div>

            <nav class="flex-1 p-4 space-y-1 mt-2">
                <button @click="currentPage = 'dashboard'" 
                        :class="currentPage === 'dashboard' ? 'bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg shadow-blue-500/50 scale-105' : 'hover:bg-white/10'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group">
                    <i data-lucide="layout-dashboard" class="w-5 h-5" :class="currentPage === 'dashboard' ? 'text-white' : 'text-gray-400 group-hover:text-white'"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium" :class="currentPage === 'dashboard' ? 'text-white' : 'text-gray-300 group-hover:text-white'">Dashboard</span>
                </button>

                <button @click="currentPage = 'cars'" 
                        :class="currentPage === 'cars' ? 'bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg shadow-blue-500/50 scale-105' : 'hover:bg-white/10'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group">
                    <i data-lucide="car" class="w-5 h-5" :class="currentPage === 'cars' ? 'text-white' : 'text-gray-400 group-hover:text-white'"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium" :class="currentPage === 'cars' ? 'text-white' : 'text-gray-300 group-hover:text-white'">Cars</span>
                </button>

                <button @click="currentPage = 'customers'" 
                        :class="currentPage === 'customers' ? 'bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg shadow-blue-500/50 scale-105' : 'hover:bg-white/10'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group">
                    <i data-lucide="users" class="w-5 h-5" :class="currentPage === 'customers' ? 'text-white' : 'text-gray-400 group-hover:text-white'"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium" :class="currentPage === 'customers' ? 'text-white' : 'text-gray-300 group-hover:text-white'">Customers</span>
                </button>

                <button @click="currentPage = 'booking'" 
                        :class="currentPage === 'booking' ? 'bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg shadow-blue-500/50 scale-105' : 'hover:bg-white/10'"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group">
                    <i data-lucide="calendar" class="w-5 h-5" :class="currentPage === 'booking' ? 'text-white' : 'text-gray-400 group-hover:text-white'"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium" :class="currentPage === 'booking' ? 'text-white' : 'text-gray-300 group-hover:text-white'">Booking</span>
                </button>

                <div class="pt-4 mt-4 border-t border-white/10">
                    <form action="{{ route('login') }}" method="GET">
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-500/10 group transition-all">
                            <i data-lucide="log-out" class="w-5 h-5 text-gray-400 group-hover:text-red-500"></i>
                            <span x-show="sidebarOpen" class="text-sm font-medium text-gray-300 group-hover:text-red-500">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <div x-show="sidebarOpen" class="p-4 border-t border-white/10">
                <p class="text-[10px] text-gray-500 text-center uppercase tracking-widest">© 2026 Bert Car</p>
            </div>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shrink-0">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" x-text="currentPage.charAt(0).toUpperCase() + currentPage.slice(1) + ' Overview'"></h2>
                    <p class="text-sm text-gray-500">Complete overview of your business operations</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="relative hidden lg:block">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 bg-gray-100 border-none rounded-xl text-sm w-64 focus:ring-2 focus:ring-blue-500 transition-all">
                    </div>
                    <button class="p-2 text-gray-400 hover:bg-gray-100 rounded-full relative">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 uppercase font-bold">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold border-2 border-blue-200">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                
                <div x-show="currentPage === 'dashboard'" x-cloak class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                                <i data-lucide="car" class="w-8 h-8"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Total Cars</p>
                                <h3 class="text-2xl font-bold text-gray-800">248</h3>
                                <p class="text-xs text-green-500 font-bold mt-1">↑ 12% <span class="text-gray-400 font-normal">vs last month</span></p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600">
                                <i data-lucide="users" class="w-8 h-8"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Customers</p>
                                <h3 class="text-2xl font-bold text-gray-800">1,856</h3>
                                <p class="text-xs text-green-500 font-bold mt-1">↑ 18% <span class="text-gray-400 font-normal">Active users</span></p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600">
                                <i data-lucide="calendar" class="w-8 h-8"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Bookings</p>
                                <h3 class="text-2xl font-bold text-gray-800">127</h3>
                                <p class="text-xs text-green-500 font-bold mt-1">↑ 5% <span class="text-gray-400 font-normal">This week</span></p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
                            <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
                                <i data-lucide="dollar-sign" class="w-8 h-8"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Revenue</p>
                                <h3 class="text-2xl font-bold text-gray-800">$84,420</h3>
                                <p class="text-xs text-green-500 font-bold mt-1">↑ 23% <span class="text-gray-400 font-normal">vs last month</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-1 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                            <div class="flex justify-between items-center mb-6">
                                <h4 class="font-bold text-gray-800">Recent Bookings</h4>
                                <button class="text-blue-600 text-xs font-bold hover:underline">View All</button>
                            </div>
                            <div class="space-y-4">
                                <template x-for="i in 3">
                                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-2xl transition-all border border-transparent hover:border-gray-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-200">MC</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">Mark Cruz</p>
                                                <p class="text-[10px] text-gray-400 font-medium">Apr 15, 2026</p>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold">Confirmed</span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="lg:col-span-1 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                            <div class="flex justify-between items-center mb-6">
                                <h4 class="font-bold text-gray-800">Maintenance</h4>
                                <span class="px-2 py-0.5 bg-orange-100 text-orange-600 rounded text-[10px] font-bold">4 DUE</span>
                            </div>
                            <div class="p-4 border border-gray-100 rounded-2xl mb-4 bg-gray-50/50">
                                <div class="flex justify-between mb-2">
                                    <h5 class="text-sm font-bold text-gray-800">Tesla Model S</h5>
                                    <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold">HIGH</span>
                                </div>
                                <p class="text-xs text-gray-500 mb-4">TLA-8934 • 45,230 mi</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-700">Battery Check</span>
                                    <span class="text-xs text-orange-500 font-bold">Apr 18</span>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-1 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                            <h4 class="font-bold text-gray-800 mb-6">Top Performers</h4>
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-bold text-gray-800">Tesla Model 3</span>
                                            <span class="text-xs text-yellow-500 font-bold">★ 4.9</span>
                                        </div>
                                        <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-blue-500 h-full w-[90%]"></div>
                                        </div>
                                        <div class="flex justify-between mt-2 text-[10px] font-bold text-gray-400">
                                            <span>89 bookings</span>
                                            <span class="text-green-500">$12,450</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-bold text-gray-800">BMW X5</span>
                                            <span class="text-xs text-yellow-500 font-bold">★ 4.8</span>
                                        </div>
                                        <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-blue-500 h-full w-[75%]"></div>
                                        </div>
                                        <div class="flex justify-between mt-2 text-[10px] font-bold text-gray-400">
                                            <span>76 bookings</span>
                                            <span class="text-green-500">$11,240</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="currentPage === 'cars'" x-cloak>
                    </div>

            </main>
        </div>
    </div>

    <script>
        // Re-initialize Lucide icons kapag nag-switch ng page (sa Alpine.js)
        document.addEventListener('alpine:init', () => {
            lucide.createIcons();
        });
        
        // Watch for page changes to re-trigger icons
        document.addEventListener('click', () => {
            setTimeout(() => lucide.createIcons(), 10);
        });
    </script>
</body>
</html>