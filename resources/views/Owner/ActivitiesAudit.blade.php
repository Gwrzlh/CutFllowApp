@extends('layouts.Owner')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Log Activities</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Riwayat aktivitas pengguna sistem secara real-time.</p>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-gray-100">
        <form action="{{ route('owner.audit.activities') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari aksi, modul, atau nama user..." 
                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-medium">
            </div>
            
            <div class="flex-none relative">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-medium text-gray-500">
            </div>
            
            <div class="flex-none relative flex items-center justify-center px-2 text-gray-400 font-bold">
                -
            </div>
            
            <div class="flex-none relative">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-medium text-gray-500">
            </div>

            <button type="submit" class="px-8 py-3.5 bg-[#0B224E] text-white rounded-2xl font-bold text-sm hover:bg-indigo-900 transition-all shadow-lg shadow-indigo-900/10 active:scale-95">
                Filter
            </button>
            @if(request('search') || request('start_date') || request('end_date'))
                <a href="{{ route('owner.audit.activities') }}" class="px-6 py-3.5 bg-gray-100 text-gray-500 rounded-2xl font-bold text-sm hover:bg-gray-200 transition-all text-center flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">No</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Waktu</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">User</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Aktivitas</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Modul</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($activities as $log)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6 text-sm font-bold text-gray-400">
                                {{ $loop->iteration + ($activities->currentPage() - 1) * $activities->perPage() }}
                            </td>
                            <td class="px-8 py-6 text-[12px] font-bold text-gray-500">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-xs border border-indigo-100">
                                        {{ $log->user ? strtoupper(substr($log->user->name, 0, 1)) : '?' }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-[#0B224E] tracking-tight">{{ $log->user->name ?? 'User Deleted' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm font-bold text-[#0B224E]">{{ $log->action }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-[#D4AF37]/10 text-[#D4AF37] rounded-lg text-[10px] font-black uppercase tracking-widest border border-[#D4AF37]/20">
                                    {{ $log->module }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center opacity-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-xl font-black uppercase tracking-widest">Aktivitas Tidak Ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
