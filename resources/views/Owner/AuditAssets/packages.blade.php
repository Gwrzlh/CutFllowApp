@extends('layouts.Owner')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Audit Assets: Paket Foto</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Monitoring performa dan popularitas paket foto yang tersedia.</p>
        </div>
    </div>

    <!-- Search Card -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-gray-100">
        <form action="{{ route('owner.audit.packages') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama paket..." 
                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-medium">
            </div>
            <button type="submit" class="px-8 py-3.5 bg-[#0B224E] text-white rounded-2xl font-bold text-sm hover:bg-indigo-900 transition-all shadow-lg active:scale-95">
                Filter
            </button>
        </form>
    </div>

    <!-- Stats Overview for Assets -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Total Variasi Paket</p>
                <h4 class="text-2xl font-black text-[#0B224E]">{{ $packages->total() }}</h4>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Package Info</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Harga</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Terjual</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 uppercase tracking-tighter">
                    @forelse ($packages as $package)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-[#0B224E] tracking-tight uppercase">{{ $package->name }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium normal-case italic">{{ Str::limit($package->description, 50) }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-[#0B224E]">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-black">
                                        {{ $package->transaction_count }}
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Kali</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($package->is_active)
                                    <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-green-100">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-red-100">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-gray-400 text-sm font-medium italic">
                                Tidak ada data paket ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($packages->hasPages())
            <div class="px-8 py-6 border-t border-gray-50">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
