@extends('layouts.Owner')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Monitoring real-time aktivitas bisnis Cutflow Photography.</p>
        </div>
        <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                </svg>
            </div>
            <div class="pr-4">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Hari Ini</p>
                <p class="text-sm font-bold text-[#0B224E]">{{ date('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Transaksi -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Total Transaksi</p>
                <div class="flex items-end gap-3">
                    <h3 class="text-4xl font-black text-[#0B224E] tracking-tighter">{{ number_format($totalTransactions) }}</h3>
                    <span class="text-[11px] font-bold text-green-500 mb-1 flex items-center gap-1 bg-green-50 px-2 py-0.5 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                        </svg>
                        All Time
                    </span>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-[#0B224E]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" />
                </svg>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-indigo-600 rounded-[32px] p-8 shadow-lg shadow-indigo-900/10 relative overflow-hidden group hover:shadow-2xl hover:bg-indigo-700 transition-all duration-300 md:col-span-2 lg:col-span-2">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-indigo-100 uppercase tracking-[0.2em] mb-4">Total Pendapatan Terkumpul</p>
                <div class="flex items-center gap-4">
                    <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-4xl font-black text-white tracking-tighter">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <p class="text-xs text-indigo-100/70 font-medium italic mt-1">Berdasarkan total DP & Pelunasan yang sudah dibayar.</p>
                    </div>
                </div>
            </div>
            <div class="absolute -right-10 -top-10 bg-white opacity-[0.05] w-48 h-48 rounded-full pointer-events-none group-hover:scale-125 transition-transform duration-700"></div>
        </div>

        <!-- Role Count Placeholder or Other Stat -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Target Tercapai</p>
                <div class="flex flex-col">
                    <h3 class="text-4xl font-black text-[#0B224E] tracking-tighter">85%</h3>
                    <div class="w-full bg-gray-100 h-1.5 rounded-full mt-3 overflow-hidden">
                        <div class="bg-indigo-600 h-full w-[85%] rounded-full shadow-sm shadow-indigo-200"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Monthly Transactions Chart -->
        <div class="lg:col-span-2 bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-[#0B224E]">Tren Transaksi Bulanan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Statistik transaksi per bulan Tahun {{ date('Y') }}</p>
                </div>
                <div class="px-3 py-1 bg-gray-50 rounded-lg text-[10px] font-bold text-gray-400 uppercase tracking-widest border border-gray-100">
                    Yearly Overview
                </div>
            </div>
            <div class="h-[350px]">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Payment Status Distribution -->
        <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <div class="mb-8 text-center">
                <h3 class="text-lg font-bold text-[#0B224E]">Status Pembayaran</h3>
                <p class="text-xs text-gray-400 mt-0.5">Distribusi total pembayaran masuk</p>
            </div>
            <div class="h-[280px] flex items-center justify-center">
                <canvas id="paymentStatusChart"></canvas>
            </div>
            <div class="mt-8 space-y-3">
                <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-2xl border border-red-100/50">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-xs font-bold text-gray-600">Unpaid</span>
                    </div>
                    <span class="text-sm font-black text-red-600">{{ $paymentStatusData['unpaid'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-yellow-50/50 rounded-2xl border border-yellow-100/50">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <span class="text-xs font-bold text-gray-600">Down Payment</span>
                    </div>
                    <span class="text-sm font-black text-yellow-600">{{ $paymentStatusData['down_payment'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50/50 rounded-2xl border border-green-100/50">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-xs font-bold text-gray-600">Paid Off</span>
                    </div>
                    <span class="text-sm font-black text-green-600">{{ $paymentStatusData['paid_off'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Payment Status Chart (Donut)
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
                hoverOffset: 10
            }]
        },
        options: {
            cutout: '75%',
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Monthly Transactions Chart (Bar Gradient)
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const gradient = monthlyCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 1)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.2)');

    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyTransactions)) !!},
            datasets: [{
                label: 'Total Transaksi',
                data: {!! json_encode(array_values($monthlyTransactions)) !!},
                backgroundColor: gradient,
                borderRadius: 12,
                maxBarThickness: 45
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
                    displayColors: false,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: true, color: '#F3F4F6' },
                    ticks: { color: '#9CA3AF', font: { size: 11, weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11, weight: 'bold' } }
                }
            }
        }
    });
</script>
@endsection
 