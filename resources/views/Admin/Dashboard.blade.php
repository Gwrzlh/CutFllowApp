@extends('layouts.Admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-3 mb-1">
        <div class="p-2 bg-white rounded-lg shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#0B224E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-[#0B224E]">Dashboard</h1>
    </div>
    <p class="text-gray-400 text-sm">Halaman dashboard Cutflow</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Total Transaksi -->
    <div class="bg-[#0B224E] rounded-2xl p-6 text-white flex items-center justify-between shadow-xl">
        <div>
            <h2 class="text-4xl font-bold mb-1">2</h2>
            <p class="text-gray-300 text-sm">Total Transaksi</p>
        </div>
        <div class="bg-white/10 p-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-[#4CAF50] rounded-2xl p-6 text-white flex items-center justify-between shadow-xl">
        <div>
            <h2 class="text-4xl font-bold mb-1">Rp 8.000.000</h2>
            <p class="text-gray-100 text-sm">Total Pendapatan Transaksi</p>
        </div>
        <div class="bg-white/10 p-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
</div>

<!-- Charts Row (Placeholders) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Status Pembayaran -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-[#0B224E] mb-6">Status Pembayaran</h3>
        <div class="flex items-center justify-center h-64 border-2 border-dashed border-gray-100 rounded-xl">
            <p class="text-gray-300">Chart Placeholder (Doughnut)</p>
        </div>
    </div>

    <!-- Total Transaksi Bulanan -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-[#0B224E] mb-6">Total Transaksi Berdasarkan Bulan</h3>
        <div class="flex items-center justify-center h-64 border-2 border-dashed border-gray-100 rounded-xl">
            <p class="text-gray-300">Chart Placeholder (Bar/Line)</p>
        </div>
    </div>
</div>
@endsection
