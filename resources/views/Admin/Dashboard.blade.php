@extends('layouts.Admin')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Admin Overview</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Manajemen kontrol dan statistik sistem Cutflow.</p>
        </div>
       <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="pr-4">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Active Cashier</p>
                <p class="text-sm font-bold text-[#0B224E]">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Total Pengguna</p>
                <h3 class="text-4xl font-black text-[#0B224E] tracking-tighter">{{ number_format($totalUsers) }}</h3>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-500 text-[#0B224E]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>
        </div>

        <!-- Total Paket -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Paket Aktif</p>
                <h3 class="text-4xl font-black text-[#0B224E] tracking-tighter">{{ number_format($totalPackages) }}</h3>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-500 text-[#0B224E]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6 10H6v-2h8v2zm4-4H6v-2h12v2z" />
                </svg>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-[#0B224E] rounded-[32px] p-8 shadow-lg shadow-indigo-900/10 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 md:col-span-2 lg:col-span-2">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-indigo-100 uppercase tracking-[0.2em] mb-4">Total Akumulasi Pendapatan</p>
                <div class="flex items-center gap-4">
                    <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-4xl font-black text-white tracking-tighter">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <p class="text-xs text-indigo-100/70 font-medium italic mt-1">Total dari {{ $totalTransactions }} transaksi sistem.</p>
                    </div>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 bg-white opacity-[0.05] w-48 h-48 rounded-full pointer-events-none group-hover:scale-125 transition-transform duration-700"></div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Monthly Transactions Chart -->
        <div class="lg:col-span-2 bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-[#0B224E]">Kinerja Transaksi</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Statistik volume transaksi bulanan {{ date('Y') }}</p>
                </div>
            </div>
            <div class="h-[350px]">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Payment Status Distribution -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <div class="mb-8 text-center">
                <h3 class="text-lg font-bold text-[#0B224E]">Aliran Kas</h3>
                <p class="text-xs text-gray-400 mt-0.5">Distribusi status pembayaran global</p>
            </div>
            <div class="h-[280px] flex items-center justify-center">
                <canvas id="paymentStatusChart"></canvas>
            </div>
            <div class="mt-8 space-y-3">
                @php
                    $statuses = [
                        'unpaid' => ['label' => 'Unpaid', 'color' => 'bg-red-500'],
                        'down_payment' => ['label' => 'Down Payment', 'color' => 'bg-yellow-500'],
                        'paid_off' => ['label' => 'Paid Off', 'color' => 'bg-green-500']
                    ];
                @endphp
                @foreach($statuses as $key => $info)
                <div class="flex items-center justify-between p-3 bg-gray-50/50 rounded-2xl border border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full {{ $info['color'] }}"></div>
                        <span class="text-xs font-bold text-gray-600">{{ $info['label'] }}</span>
                    </div>
                    <span class="text-sm font-black text-[#0B224E]">{{ $paymentStatusData[$key] ?? 0 }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Payment Status Chart
    const paymentCtx = document.getElementById('paymentStatusChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Unpaid', 'Down Payment', 'Paid Off'],
            datasets: [{
                data: [
                    {{ $paymentStatusData['unpaid'] ?? 0 }},
                    {{ $paymentStatusData['down_payment'] ?? 0 }},
                    {{ $paymentStatusData['paid_off'] ?? 0 }}
                ],
                backgroundColor: ['#EF4444', '#F59E0B', '#10B981'],
                borderWidth: 0,
                hoverOffset: 12
            }]
        },
        options: {
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });

    // Monthly Transactions Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const gradient = monthlyCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(11, 34, 78, 1)');
    gradient.addColorStop(1, 'rgba(11, 34, 78, 0.1)');

    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyTransactions)) !!},
            datasets: [{
                label: 'Transaksi',
                data: {!! json_encode(array_values($monthlyTransactions)) !!},
                backgroundColor: gradient,
                borderRadius: 12,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0B224E',
                    padding: 12,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#F3F4F6' },
                    ticks: { color: '#9CA3AF', font: { weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { weight: 'bold' } }
                }
            }
        }
    });
</script>
@endsection

