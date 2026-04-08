@extends('layouts.Owner')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Audit Assets: Photographer</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Monitoring produktivitas dan performa photographer aktif.</p>
        </div>
    </div>

    <!-- Search Card -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-gray-100">
        <form action="{{ route('owner.audit.photographers') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama photographer..." 
                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-medium">
            </div>
            <button type="submit" class="px-8 py-3.5 bg-[#0B224E] text-white rounded-2xl font-bold text-sm hover:bg-indigo-900 transition-all shadow-lg active:scale-95">
                Cari Data
            </button>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Photographer</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Spesialisasi</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Total Sesi Foto</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Lokasi Utama</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($photographers as $pg)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 font-bold text-sm border border-orange-100">
                                        {{ strtoupper(substr($pg->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-[#0B224E] tracking-tight uppercase">{{ $pg->name }}</p>
                                        <p class="text-[11px] text-gray-400 font-medium italic lowercase">Photographer ID: #{{ $pg->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-xs font-bold text-gray-500 italic">{{ $pg->specialization ?? 'Professional' }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-black">
                                        {{ $pg->transaction_count }}
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Selesai</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 0 1 6 0z" />
                                    </svg>
                                    <span class="text-xs font-bold text-[#0B224E]">{{ $pg->lokasi->name ?? '-' }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-gray-400 text-sm font-medium italic">
                                Data photographer tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($photographers->hasPages())
            <div class="px-8 py-6 border-t border-gray-100">
                {{ $photographers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
