@extends('layouts.Owner')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0B224E] tracking-tight">Audit Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Monitoring riwayat dan performa transaksi Cutflow.</p>
        </div>
        <div>
            <a href="{{ route('owner.audit.transactions.export', request()->all()) }}" 
               class="inline-flex items-center gap-2 px-6 py-3.5 bg-green-600 text-white rounded-2xl font-bold text-sm hover:bg-green-700 transition-all shadow-lg shadow-green-900/10 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel (CSV)
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
        <form action="{{ route('owner.audit.transaksi') }}" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Search Input -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest pl-1">Pencarian</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Invoice atau Nama..." 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-transparent rounded-xl text-sm focus:bg-white focus:border-indigo-500 transition-all font-medium h-12">
                    </div>
                </div>

                <!-- Start Date -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest pl-1">Range Awal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                        class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl text-sm focus:bg-white focus:border-indigo-500 transition-all font-bold h-12">
                </div>

                <!-- End Date -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest pl-1">Range Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" 
                        class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl text-sm focus:bg-white focus:border-indigo-500 transition-all font-bold h-12">
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 pt-2 border-t border-gray-50">
                <button type="submit" class="flex-1 md:flex-none px-12 py-3.5 bg-[#0B224E] text-white rounded-2xl font-bold text-sm hover:bg-indigo-900 transition-all shadow-lg shadow-indigo-900/10 active:scale-95 uppercase tracking-widest">
                    Terapkan Filter
                </button>
                @if(request()->anyFilled(['search', 'start_date', 'end_date']))
                    <a href="{{ route('owner.audit.transaksi') }}" class="px-8 py-3.5 bg-gray-100 text-gray-500 rounded-2xl font-bold text-sm hover:bg-gray-200 transition-all text-center uppercase tracking-widest">
                        Reset Filter
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Transaksi</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Customer</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Layanan & Aset</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Pembayaran</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 italic">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50/50 transition-colors group not-italic">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded w-fit mb-1">{{ $transaction->invoice_number }}</span>
                                    <span class="text-xs text-gray-400 font-medium">{{ Carbon\Carbon::parse($transaction->execution_date)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col text-sm font-black text-[#0B224E] tracking-tight">
                                    {{ $transaction->customer_name }}
                                    <span class="text-[10px] font-medium text-gray-400 mt-0.5 lowercase">Kasir: {{ $transaction->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div>
                                        <span class="text-sm font-bold text-gray-600 tracking-tight">{{ $transaction->package->name ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-orange-400"></div>
                                        <span class="text-xs font-medium text-gray-400 italic">By {{ $transaction->photographer->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-[#0B224E]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                    <span class="text-[10px] font-bold text-green-600 mt-1 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Masuk: Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right space-y-2">
                                <div>
                                    @php
                                        $pColor = [
                                            'paid_off' => 'bg-green-50 text-green-600 border-green-100',
                                            'down_payment' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                            'unpaid' => 'bg-red-50 text-red-600 border-red-100'
                                        ][$transaction->payment_status] ?? 'bg-gray-50 text-gray-400 border-gray-100';
                                    @endphp
                                    <span class="px-2.5 py-1 {{ $pColor }} rounded-lg text-[9px] font-black uppercase tracking-widest border">
                                        {{ str_replace('_', ' ', $transaction->payment_status) }}
                                    </span>
                                </div>
                                <div>
                                    @php
                                        $bColor = [
                                            'completed' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'scheduled' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                            'cancelled' => 'bg-gray-100 text-gray-500 border-gray-200'
                                        ][$transaction->booking_status] ?? 'bg-gray-50 text-gray-400 border-gray-100';
                                    @endphp
                                    <span class="px-2.5 py-1 {{ $bColor }} rounded-lg text-[9px] font-black uppercase tracking-widest border">
                                        {{ $transaction->booking_status }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center opacity-30">
                                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <p class="text-xl font-black uppercase tracking-[0.2em] text-[#0B224E]">Tidak Ada Transaksi</p>
                                    <p class="text-xs text-gray-400 mt-2 font-medium italic">Silakan coba filter atau pencarian lain.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="px-8 py-8 bg-gray-50/30 border-t border-gray-50 shadow-inner">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
