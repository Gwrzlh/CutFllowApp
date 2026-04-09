@extends('layouts.Kasir')

@section('content')
<div class="space-y-6" x-data="{ 
    search: '',
    isModalOpen: false,
    txDetail: null,
    openDetail(tx) {
        this.txDetail = tx;
        this.isModalOpen = true;
    }
}">
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
                            <button type="button" @click="openDetail({{ json_encode($tx) }})" 
                                class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-yellow-500 hover:text-white transition-all tooltip" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <a href="{{ route('admin.transactions.print', $tx->id) }}" target="_blank" 
                                class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-[#1A337E] hover:text-white transition-all tooltip" title="Cetak Struk">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Detail Modal -->
    <div x-show="isModalOpen" style="display: none" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="isModalOpen = false">
                <div class="absolute inset-0 bg-gray-900 opacity-40 backdrop-blur-sm"></div>
            </div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Panel -->
            <div x-show="isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-flex flex-col align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full max-h-[90vh]">
                
                <div class="bg-[#1A337E] px-8 py-5 border-b border-[#0B224E]/20 flex justify-between items-center shrink-0">
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-widest leading-6">Detail Transaksi</h3>
                        <p class="text-blue-200 text-[10px] font-bold italic mt-0.5" x-text="txDetail ? txDetail.invoice_number : ''"></p>
                    </div>
                    <button type="button" @click="isModalOpen = false" class="text-blue-200 hover:text-white transition-colors bg-blue-900/40 p-2 rounded-xl">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="bg-gray-50 px-8 py-8 space-y-6 overflow-y-auto flex-1">
                    <template x-if="txDetail">
                        <div class="space-y-6">
                            <!-- Customer & Package Info -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                                    <p class="text-[9px] uppercase tracking-widest text-gray-400 font-black mb-1">Customer</p>
                                    <p class="text-xs font-bold text-[#0B224E]" x-text="txDetail.customer_name"></p>
                                </div>
                                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                                    <p class="text-[9px] uppercase tracking-widest text-gray-400 font-black mb-1">Status Pembayaran</p>
                                    <span class="px-2 py-1 inline-block rounded-lg text-[10px] font-bold uppercase tracking-wider"
                                        :class="txDetail.payment_status === 'paid_off' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'"
                                        x-text="txDetail.payment_status === 'paid_off' ? 'LUNAS' : 'DP (MENUNGGU)'">
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Master Data details -->
                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                                <h4 class="text-[10px] font-black text-[#1A337E] uppercase tracking-widest border-b border-gray-50 pb-2">Informasi Layanan</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[9px] text-gray-400 italic font-bold">Paket Terpilih</p>
                                        <p class="text-xs font-bold text-gray-800" x-text="txDetail.package ? txDetail.package.name : 'Paket Terhapus'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] text-gray-400 italic font-bold">Tgl. Pelaksanaan</p>
                                        <p class="text-xs font-bold text-gray-800" x-text="new Date(txDetail.execution_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})"></p>
                                    </div>
                                    <div>
                                        <!-- No location sync anymore, so show photographer name -->
                                        <p class="text-[9px] text-gray-400 italic font-bold">Photographer (PIC)</p>
                                        <p class="text-xs font-bold text-gray-800" x-text="txDetail.photographer ? txDetail.photographer.name : 'PIC Terhapus'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] text-gray-400 italic font-bold">Lokasi</p>
                                        <p class="text-xs font-bold text-gray-800" x-text="txDetail.lokasi ? txDetail.lokasi.name : 'Data Lama / Terhapus'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Details -->
                            <div class="bg-[#1A337E]/5 p-5 rounded-2xl border border-[#1A337E]/10 space-y-3">
                                <h4 class="text-[10px] font-black text-[#1A337E] uppercase tracking-widest border-b border-[#1A337E]/10 pb-2">Rincian Finansial</h4>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-500 font-medium">Total Harga</span>
                                    <span class="font-bold text-[#0B224E]" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(txDetail.total_amount)"></span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-500 font-medium pt-1">Total Sudah Dibayar</span>
                                    <span class="font-bold text-[#10B981] pt-1" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(txDetail.amount_paid)"></span>
                                </div>
                                <div class="flex justify-between items-center text-xs border-t border-[#1A337E]/10 pt-3 mt-1">
                                    <span class="text-[#0B224E] font-black uppercase tracking-widest">SISA KEKURANGAN</span>
                                    <span class="font-black text-red-500 text-sm" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(txDetail.total_amount - txDetail.amount_paid)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection