@extends('layouts.Owner')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Audit Users</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Manajemen status aktifasi pengguna sistem.</p>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-gray-100">
        <form action="{{ route('owner.audit.users') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama atau email user..." 
                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all font-medium">
            </div>
            <button type="submit" class="px-8 py-3.5 bg-[#0B224E] text-white rounded-2xl font-bold text-sm hover:bg-indigo-900 transition-all shadow-lg shadow-indigo-900/10 active:scale-95">
                Cari User
            </button>
            @if(request('search'))
                <a href="{{ route('owner.audit.users') }}" class="px-6 py-3.5 bg-gray-100 text-gray-500 rounded-2xl font-bold text-sm hover:bg-gray-200 transition-all text-center">
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
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">User Details</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Role</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em] text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6 text-sm font-bold text-gray-400">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm border border-indigo-100">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-[#0B224E] tracking-tight">{{ $user->name }}</p>
                                        <p class="text-[11px] text-gray-400 font-medium italic lowercase">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-[10px] font-black uppercase tracking-widest border border-gray-200">
                                    {{ $user->role->name }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                @if($user->status === 'active')
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                        <span class="text-[11px] font-bold text-green-600 uppercase tracking-widest">Active</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                        <span class="text-[11px] font-bold text-red-600 uppercase tracking-widest">Inactive</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('owner.audit.users.toggle', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status user ini?')">
                                    @csrf
                                    @if($user->status === 'active')
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-[11px] font-bold hover:bg-red-600 hover:text-white transition-all border border-red-100 uppercase tracking-widest">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Deactivate
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 rounded-xl text-[11px] font-bold hover:bg-green-600 hover:text-white transition-all border border-green-100 uppercase tracking-widest">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Activate
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center opacity-20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-xl font-black uppercase tracking-widest">Data User Tidak Ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
