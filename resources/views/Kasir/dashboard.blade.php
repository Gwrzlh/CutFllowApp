@extends('layouts.Kasir')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Kasir Performance</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Monitoring produktivitas kerja dan hasil transaksi personal.</p>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Personal Transactions -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Transaksi Saya</p>
                <h3 class="text-4xl font-black text-[#0B224E] tracking-tighter">{{ number_format($totalTransactions) }}</h3>
                <p class="text-[10px] text-gray-400 font-medium mt-2">Total transaksi yang Anda tangani.</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-500 text-[#0B224E]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
                </svg>
            </div>
        </div>

        <!-- Personal Revenue -->
        <div class="bg-[#4CAF50] rounded-[32px] p-8 shadow-lg shadow-green-900/10 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 md:col-span-2 lg:col-span-2">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-green-50 uppercase tracking-[0.2em] mb-4">Total Pendapatan Terkelola</p>
                <div class="flex items-center gap-4">
                    <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-4xl font-black text-white tracking-tighter">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <p class="text-xs text-green-50/70 font-medium italic mt-1">Estimasi pendapatan dari transaksi yang Anda input.</p>
                    </div>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 bg-white opacity-[0.05] w-48 h-48 rounded-full pointer-events-none group-hover:scale-125 transition-transform duration-700"></div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Monthly Performance Charts -->
        <div class="lg:col-span-2 bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-[#0B224E]">Statistik Bulanan Saya</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Ringkasan aktivitas transaksi per bulan</p>
                </div>
            </div>
            <div class="h-[350px]">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Payment Status (Personal) -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <div class="mb-8 text-center">
                <h3 class="text-lg font-bold text-[#0B224E]">Proporsi Pembayaran</h3>
                <p class="text-xs text-gray-400 mt-0.5">Status pembayaran dari transaksi Anda</p>
            </div>
            <div class="h-[280px] flex items-center justify-center">
                <canvas id="paymentStatusChart"></canvas>
            </div>
            <div class="mt-8 space-y-3">
                @php
                    $personalStatuses = [
                        'unpaid' => ['label' => 'Unpaid', 'color' => 'bg-red-500'],
                        'down_payment' => ['label' => 'Down Payment', 'color' => 'bg-yellow-500'],
                        'paid_off' => ['label' => 'Paid Off', 'color' => 'bg-green-500']
                    ];
                @endphp
                @foreach($personalStatuses as $key => $info)
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
    // Payment Status Chart (Doughnut)
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

    // Monthly Performance Chart (Line)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($monthlyTransactions)) !!},
            datasets: [{
                label: 'Sesi Foto',
                data: {!! json_encode(array_values($monthlyTransactions)) !!},
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4CAF50',
                pointBorderWidth: 2,
                pointRadius: 4
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

