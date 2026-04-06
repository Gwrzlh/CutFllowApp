<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - Cutflow</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F4F7FE] text-[#2D3436]" x-data="{ sidebarOpen: true, masterDataOpen: {{ request()->is('admin/lokasi*', 'admin/role*', 'admin/photographer*', 'admin/package*', 'admin/users*') ? 'true' : 'false' }}, transactionOpen: {{ request()->is('admin/booking*') ? 'true' : 'false' }} }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside 
            class="bg-[#0B224E] text-white transition-all duration-300 ease-in-out z-30"
            :class="sidebarOpen ? 'w-64' : 'w-20'"
        >
            <div class="h-full flex flex-col p-4">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3 mb-10 px-2">
                    {{-- <div class="bg-[#D4AF37] p-2 rounded-lg flex-shrink-0">
                        <span class="text-white font-bold text-xl">C</span>
                    </div> --}}
                    <div x-show="sidebarOpen" x-transition:enter.duration.300ms class="overflow-hidden whitespace-nowrap">
                        <h1 class="text-[#D4AF37] font-bold text-lg leading-tight">CUTFLOW</h1>
                        <p class="text-[10px] text-gray-400 tracking-widest uppercase">Web Photography</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-2">
                    
                    <!-- Dashboard Link -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-[#D4AF37] text-white shadow-lg' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                    </a>

                    <!-- Master Data Dropdown -->
                    <div class="space-y-1">
                        <button 
                            @click="masterDataOpen = !masterDataOpen"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-white/10 hover:text-white transition-all group"
                            :class="{ 'text-white': masterDataOpen }"
                        >
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Master Data</span>
                            </div>
                            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200" :class="masterDataOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="masterDataOpen && sidebarOpen" x-cloak x-transition.origin.top class="pl-12 space-y-1">
                            <a href="{{ route('admin.lokasi.index') }}" class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/lokasi*') ? 'text-[#D4AF37] font-semibold' : '' }}">Lokasi</a>
                            <a href="{{ route('admin.role.index') }}" class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/role*') ? 'text-[#D4AF37] font-semibold' : '' }}">Role Management</a>
                            <a href="#" class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/photographer*') ? 'text-[#D4AF37] font-semibold' : '' }}">Photographer</a>
                            <a href="#" class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/package*') ? 'text-[#D4AF37] font-semibold' : '' }}">Package List</a>
                            <a href="{{ route('admin.users.index') }}" class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/users*') ? 'text-[#D4AF37] font-semibold' : '' }}">User Management</a>
                        </div>
                    </div>

                    <!-- Transactions Dropdown -->
                    <div class="space-y-1">
                        <button 
                            @click="transactionOpen = !transactionOpen"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-white/10 hover:text-white transition-all group"
                            :class="{ 'text-white': transactionOpen }"
                        >
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Data Transaction</span>
                            </div>
                            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200" :class="transactionOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="transactionOpen && sidebarOpen" x-cloak x-transition.origin.top class="pl-12 space-y-1">
                            <a href="#" class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/booking*') ? 'text-[#D4AF37] font-semibold' : '' }}">Booking List</a>
                        </div>
                    </div>

                </nav>

                <!-- Logout -->
                <div class="mt-auto px-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-500 rounded-xl transition-all w-full group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span x-show="sidebarOpen" class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 bg-[#F4F7FE] overflow-y-auto">
            
            <!-- Top Navbar -->
            <header class="bg-white px-8 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-gray-400">Hi,</p>
                        <p class="text-sm font-semibold text-[#0B224E]">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 bg-[#0B224E] rounded-full flex items-center justify-center text-white border-2 border-[#D4AF37]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
