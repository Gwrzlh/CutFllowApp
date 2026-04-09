<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - Cutflow</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS (via Vite) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F4F7FE] text-[#2D3436]" x-data="{ sidebarOpen: true, masterDataOpen: {{ request()->is('admin/lokasi*', 'admin/pic*', 'admin/package*', 'admin/users*') ? 'true' : 'false' }}, transactionOpen: {{ request()->is('admin/booking*') ? 'true' : 'false' }} }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="bg-[#0B224E] text-white transition-all duration-300 ease-in-out z-30"
            :class="sidebarOpen ? 'w-64' : 'w-20'">
            <div class="h-full flex flex-col p-4">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3 mb-10 px-2">
                    {{-- <div class="bg-[#D4AF37] p-2 rounded-lg flex-shrink-0">
                        <span class="text-white font-bold text-xl">C</span>
                    </div> --}}
                    <div x-show="sidebarOpen" x-transition:enter.duration.300ms
                        class="overflow-hidden whitespace-nowrap">
                        <h1 class="text-[#D4AF37] font-bold text-lg leading-tight">CUTFLOW</h1>
                        <p class="text-[10px] text-gray-400 tracking-widest uppercase">Web Photography</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-2">

                    <!-- Dashboard Link -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-[#D4AF37] text-white shadow-lg' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                    </a>

                    <!-- Master Data Dropdown -->
                    <div class="space-y-1">
                        <button @click="masterDataOpen = !masterDataOpen"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-white/10 hover:text-white transition-all group"
                            :class="{ 'text-white': masterDataOpen }">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Master Data</span>
                            </div>
                            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 transition-transform duration-200"
                                :class="masterDataOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="masterDataOpen && sidebarOpen" x-cloak x-transition.origin.top
                            class="pl-12 space-y-1">
                            <a href="{{ route('admin.lokasi.index') }}"
                                class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/lokasi*') ? 'text-[#D4AF37] font-semibold' : '' }}">Lokasi</a>
                            <a href="{{ route('admin.pic.index') }}"
                                class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/pic*') ? 'text-[#D4AF37] font-semibold' : '' }}">Photographer</a>
                            <a href="{{ route('admin.package.index') }}"
                                class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/package*') ? 'text-[#D4AF37] font-semibold' : '' }}">Package
                                List</a>
                            <a href="{{ route('admin.users.index') }}"
                                class="block py-2 text-sm text-gray-400 hover:text-white transition-colors {{ request()->is('admin/users*') ? 'text-[#D4AF37] font-semibold' : '' }}">User
                                Management</a>
                        </div>
                    </div>

                </nav>

                <!-- Logout -->
                <div class="mt-auto px-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-500 rounded-xl transition-all w-full group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-gray-400">Hi,</p>
                        <p class="text-sm font-semibold text-[#0B224E]">{{ Auth::user()->name }}</p>
                    </div>
                    <div
                        class="w-10 h-10 bg-[#0B224E] rounded-full flex items-center justify-center text-white border-2 border-[#D4AF37]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                <!-- Session Alerts (MIGRATED TO SWEETALERT in JS) -->
                @yield('content')
            </main>
            <!-- Drawer Overlay (For Create/Edit) -->
            @yield('drawer')
        </div>
    </div>

    <!-- Alert System Global -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert for Session Success
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0B224E',
                    background: '#ffffff',
                    color: '#0B224E',
                    customClass: {
                        popup: 'rounded-3xl shadow-xl border border-gray-100',
                        confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    }
                });
            @endif

            // SweetAlert for Session Error
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#0B224E',
                    background: '#ffffff',
                    color: '#0B224E',
                    customClass: {
                        popup: 'rounded-3xl shadow-xl border border-gray-100',
                        confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    }
                });
            @endif

            // Global Confirmation Delete Alert
            document.querySelectorAll('form').forEach(form => {
                if (form.getAttribute('onsubmit') && form.getAttribute('onsubmit').includes('confirm')) {
                    let confirmText = form.getAttribute('onsubmit').match(/'([^']+)'/);
                    let message = confirmText ? confirmText[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                    
                    form.removeAttribute('onsubmit');
                    
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#0B224E', // Brand color
                            cancelButtonColor: '#EF4444', // Red for cancel
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak',
                            customClass: {
                                popup: 'rounded-3xl shadow-xl border border-gray-100 pb-4',
                                confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-wider text-xs',
                                cancelButton: 'rounded-xl px-6 py-3 font-bold uppercase tracking-wider text-xs'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const buttons = form.querySelectorAll('button[type="submit"]');
                                buttons.forEach(btn => {
                                    btn.disabled = true;
                                    btn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
                                });
                                form.submit();
                            }
                        });
                    });
                } else if(form.method.toLowerCase() === 'post') {
                    // Overload Request Protection
                    form.addEventListener('submit', function() {
                        if (!form.hasAttribute('data-submitting')) {
                            form.setAttribute('data-submitting', 'true');
                            const buttons = form.querySelectorAll('button[type="submit"]:not(.ignore-loading)');
                            buttons.forEach(btn => {
                                btn.disabled = true;
                                const originalText = btn.innerHTML;
                                btn.setAttribute('data-original', originalText);
                                btn.innerHTML = '<span class="flex items-center gap-2 justify-center"><svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
