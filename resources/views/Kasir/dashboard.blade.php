@extends('layouts.Kasir')

@section('content')
<div class="space-y-10">
    <!-- Page Header -->
    <div class="flex items-start gap-4">
        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#0B224E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-[#0B224E]">Dashboard</h1>
            <p class="text-xs text-gray-400 mt-1 font-normal uppercase tracking-widest">Halaman dashboard Cutflow</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-5">
        <!-- Total Transaksi -->
        <div class="bg-[#0B224E] rounded-[2rem] p-10 text-white flex items-center justify-between shadow-2xl relative overflow-hidden group transition-all hover:scale-[1.02]">
            <div class="relative z-10">
                <h2 class="text-5xl font-black mb-2 tracking-tighter">2</h2>
                <p class="text-gray-300 text-sm font-medium uppercase tracking-[0.2em]">Total Transaksi</p>
            </div>
            <div class="bg-white/10 p-6 rounded-3xl relative z-10 transition-transform group-hover:rotate-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <!-- Decorative Circle -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full pointer-events-none"></div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-[#4CAF50] rounded-[2rem] p-10 text-white flex items-center justify-between shadow-2xl relative overflow-hidden group transition-all hover:scale-[1.02]">
            <div class="relative z-10">
                <h2 class="text-4xl font-black mb-2 tracking-tighter">Rp 8.000.000</h2>
                <p class="text-gray-100/80 text-sm font-medium uppercase tracking-[0.2em]">Total Pendapatan Transaksi</p>
            </div>
            <div class="bg-white/10 p-6 rounded-3xl relative z-10 transition-transform group-hover:-rotate-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <!-- Decorative Icon (Anchor-like from design) -->
            <div class="absolute -right-5 bottom-0 text-white/5 pointer-events-none">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                   <path d="M12 2C10.34 2 9 3.34 9 5s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm0 18c-4.41 0-8-3.59-8-8 0-1.55.45-3 1.23-4.23L12 11l6.77-3.23c.78 1.23 1.23 2.68 1.23 4.23 0 4.41-3.59 8-8 8z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Status Pembayaran Card -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-50 flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-black text-[#0B224E] text-lg uppercase tracking-wider">Status Pembayaran</h3>
                <div class="flex gap-2">
                    <input type="date" class="px-3 py-2 bg-gray-50 rounded-lg text-xs font-medium border border-gray-100 text-gray-400 focus:outline-none">
                    <input type="date" class="px-3 py-2 bg-gray-50 rounded-lg text-xs font-medium border border-gray-100 text-gray-400 focus:outline-none">
                </div>
            </div>
            <div class="relative flex-1 min-h-[300px] flex items-center justify-center">
                <canvas id="paymentStatusChart"></canvas>
            </div>
            <!-- Legend (Custom) -->
            <div class="mt-8 space-y-4 font-bold text-xs uppercase tracking-widest">
                <div class="flex items-center justify-between p-3 bg-gray-50/50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#FF1E56]"></span>
                        <span class="text-gray-400">Not Paid</span>
                    </div>
                    <span class="text-[#0B224E]">1</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50/50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#4CAF50]"></span>
                        <span class="text-gray-400">Paid</span>
                    </div>
                    <span class="text-[#0B224E]">1</span>
                </div>
            </div>
        </div>

        <!-- Monthly Transactions Card -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-50 flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-black text-[#0B224E] text-lg uppercase tracking-wider">Total Transaksi Berdasarkan Bulan</h3>
                <select class="px-3 py-2 bg-gray-50 rounded-lg text-xs font-medium border border-gray-100 text-gray-400 focus:outline-none">
                    <option>Tahun</option>
                    <option>2026</option>
                    <option>2025</option>
                </select>
            </div>
            <div class="relative flex-1 min-h-[300px] flex items-center justify-center">
                <canvas id="monthlyTransactionChart"></canvas>
            </div>
            <!-- Legend (Custom) -->
            <div class="mt-8 space-y-4 font-bold text-xs uppercase tracking-widest">
                <div class="flex items-center justify-between p-2">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#8E97A1]"></span>
                        <span class="text-gray-400">Januari</span>
                    </div>
                    <span class="text-[#0B224E]">1</span>
                </div>
                <div class="flex items-center justify-between p-2">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#FFD369]"></span>
                        <span class="text-gray-400">Februari</span>
                    </div>
                    <span class="text-[#0B224E]">1</span>
                </div>
                <div class="flex items-center justify-between p-2">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#4CAF50]"></span>
                        <span class="text-gray-400">Maret</span>
                    </div>
                    <span class="text-[#0B224E]">1</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment Status Chart
        const paymentCtx = document.getElementById('paymentStatusChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [1, 1],
                    backgroundColor: ['#FF1E56', '#4CAF50'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Monthly Transaction Chart
        const monthlyCtx = document.getElementById('monthlyTransactionChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [1, 1, 1],
                    backgroundColor: ['#8E97A1', '#FFD369', '#4CAF50'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endsection
