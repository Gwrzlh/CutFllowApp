@extends('layouts.Kasir')

@section('content')
<div class="space-y-6" x-data="{ search: '' }">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-[#0B224E]">Riwayat Transaksi</h1>
            <p class="text-xs text-gray-400">Daftar seluruh transaksi yang pernah dilakukan</p>
        </div>
        
        <div class="relative w-64">
            <input type="text" x-model="search" placeholder="Cari invoice/customer..." 
                class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#1A337E] outline-none">
            <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-[10px] uppercase tracking-widest text-gray-400">
                <tr>
                    <th class="px-8 py-4">Invoice & Tanggal</th>
                    <th class="px-8 py-4">Customer & Paket</th>
                    <th class="px-8 py-4">Total</th>
                    <th class="px-8 py-4 text-center">Status</th>
                    <th class="px-8 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-[12px]">
                @foreach($transactions as $tx)
                <tr x-show="'{{ strtolower($tx->invoice_number . ' ' . $tx->customer_name) }}'.includes(search.toLowerCase())">
                    <td class="px-8 py-4">
                        <div class="font-bold text-[#0B224E]">{{ $tx->invoice_number }}</div>
                        <div class="text-[10px] text-gray-400">{{ $tx->created_at->format('d M Y, H:i') }}</div>
                    </td>
                    <td class="px-8 py-4">
                        <div class="font-bold">{{ $tx->customer_name }}</div>
                        <div class="text-[10px] italic text-blue-500">{{ $tx->package->name }}</div>
                    </td>
                    <td class="px-8 py-4 font-black">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                    <td class="px-8 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[9px] font-bold {{ $tx->payment_status == 'paid_off' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                            {{ strtoupper($tx->payment_status) }}
                        </span>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.transactions.print', $tx->id) }}" target="_blank" 
                                class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-[#1A337E] hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" stroke-width="2"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection