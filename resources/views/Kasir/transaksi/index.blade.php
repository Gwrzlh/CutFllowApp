@extends('layouts.Kasir')

@section('content')
<div x-data="{ 
    mode: 'create',
    selectedTx: null,
    customerName: '',
    selectedPackage: '',
    selectedPackageName: '',
    selectedPhotographer: '',
    executionDate: '',
    selectedPrice: 0,
    isDP: false,
    amountToPay: 0,
    cashReceived: 0,
    locationId: '',
    
    get change() { return this.cashReceived - this.amountToPay; },

    preparePelunasan(tx) {
        this.mode = 'edit';
        this.selectedTx = tx;
        this.customerName = tx.customer_name;
        this.selectedPackage = tx.package_id;
        this.selectedPackageName = tx.package ? tx.package.name : 'Paket Dihapus';
        this.selectedPhotographer = tx.photographer_id;
        this.executionDate = tx.execution_date;
        this.selectedPrice = tx.total_amount;
        
        // Sisa yang harus dibayar
        this.amountToPay = tx.total_amount - tx.amount_paid; 
        this.cashReceived = 0;
        this.isDP = false; 
        this.locationId = tx.location_id || '';
    },
    
    resetForm() {
        this.mode = 'create';
        this.selectedTx = null;
        this.customerName = '';
        this.selectedPackage = '';
        this.selectedPackageName = '';
        this.selectedPhotographer = '';
        this.executionDate = '';
        this.selectedPrice = 0;
        this.amountToPay = 0;
        this.cashReceived = 0;
        this.isDP = false;
        this.locationId = '';
    },

    selectPackage(pkg) {
        if(this.mode === 'edit') return;
        if(this.selectedPackage === pkg.id) {
            // Deselect
            this.selectedPackage = '';
            this.selectedPackageName = '';
            this.selectedPrice = 0;
        } else {
            this.selectedPackage = pkg.id;
            this.selectedPackageName = pkg.name;
            this.selectedPrice = pkg.price;
        }
        this.calculateTotal();
    },

    togglePaymentMode() {
        if(this.mode === 'edit') {
            this.isDP = false; // Paksa lunas jika mode edit
            return;
        }
        this.calculateTotal();
    },

    calculateTotal() {
        if(this.mode === 'create') {
            this.amountToPay = this.isDP ? this.selectedPrice * 0.5 : this.selectedPrice;
        }
    }
}" class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-start gap-4">
        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-100 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#0B224E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-[#0B224E]">Point of Sales</h1>
            <p class="text-[11px] text-gray-400 mt-1 font-normal uppercase tracking-widest">Kelola transaksi, pilih paket, dan lunaskan DP di satu panel teringkas</p>
        </div>
    </div>

    <!-- Main Grid: 3 Columns POS Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left Panel: Pending DP (3/12 width) -->
        <div class="lg:col-span-3 bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col h-[calc(100vh-160px)] sticky top-24 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h2 class="font-black text-[#0B224E] text-[11px] uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                    Menunggu Pelunasan
                </h2>
                <p class="text-[9px] text-gray-400 mt-1 italic">Pilih transaksi untuk dilunaskan</p>
            </div>
            <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50/30">
                @php
                    $pendingTxs = $transactions->where('payment_status', 'down_payment')->where('booking_status', '!=', 'cancelled');
                @endphp
                
                @forelse($pendingTxs as $tx)
                <div class="bg-white border rounded-2xl p-4 transition-all cursor-pointer shadow-sm hover:shadow-md"
                     :class="selectedTx && selectedTx.id === {{ $tx->id }} ? 'border-[#1A337E] ring-2 ring-[#1A337E]/20' : 'border-gray-100 hover:border-gray-300'"
                     @click="preparePelunasan({{ json_encode($tx) }})">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-black text-[#0B224E]">{{ $tx->invoice_number }}</span>
                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-600 rounded text-[8px] font-bold uppercase">DP Aktif</span>
                    </div>
                    <p class="text-xs font-bold text-gray-800">{{ $tx->customer_name }}</p>
                    <p class="text-[9px] text-gray-400 italic mb-3">{{ $tx->package->name ?? 'Paket Terhapus' }} - {{ date('d M Y', strtotime($tx->execution_date)) }}</p>
                    
                    <div class="flex justify-between items-center bg-gray-50 p-2 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-[8px] text-gray-400 uppercase font-black">Sisa Tagihan</p>
                            <p class="text-[11px] font-bold text-red-500">Rp {{ number_format($tx->total_amount - $tx->amount_paid, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center p-8 text-center opacity-60 h-full">
                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tidak ada DP</p>
                    <p class="text-[9px] text-gray-400 italic mt-1 leading-relaxed">Semua transaksi telah lunas atau belum ada jadwal tertunda.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Middle Panel: Package Selection (5/12 width) -->
        <div class="lg:col-span-5 space-y-4" :class="mode === 'edit' ? 'opacity-50 pointer-events-none transition-opacity' : 'transition-opacity'">
            <div class="flex items-center justify-between">
                <h2 class="font-black text-[#0B224E] text-[11px] uppercase tracking-widest pl-2">Pilih Paket Layanan</h2>
                <span class="text-[10px] text-[#1A337E] font-bold italic" x-show="mode === 'edit'">*Mode Pelunasan Aktif (Paket Terkunci)</span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($packages->where('is_active', true) as $pkg)
                <div class="relative bg-white rounded-3xl border transition-all duration-200 cursor-pointer overflow-hidden group"
                     :class="selectedPackage === {{ $pkg->id }} ? 'border-[#1A337E] ring-4 ring-[#1A337E]/10 shadow-lg' : 'border-gray-100 hover:border-gray-300 hover:shadow-md'"
                     @click="selectPackage({{ json_encode($pkg) }})">
                     
                    <!-- Checkmark Icon Overlay -->
                    <div class="absolute top-4 right-4 text-[#1A337E] transition-transform duration-200"
                        :class="selectedPackage === {{ $pkg->id }} ? 'scale-100 opacity-100' : 'scale-0 opacity-0'">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    </div>

                    <div class="p-6">
                        <div class="w-10 h-10 rounded-2xl mb-4 flex items-center justify-center transition-colors shadow-sm"
                             :class="selectedPackage === {{ $pkg->id }} ? 'bg-[#1A337E] text-white' : 'bg-gray-50 text-[#1A337E] group-hover:bg-[#1A337E] group-hover:text-white'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="font-black text-[#0B224E] text-sm mb-1">{{ $pkg->name }}</h3>
                        <p class="text-[10px] text-gray-400 italic mb-4 line-clamp-2 h-7 leading-snug">{{ $pkg->description ?? 'Tidak ada deskripsi' }}</p>
                        
                        <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-[#1A337E] font-black text-xs">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Panel: Transaction Form (4/12 width) -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 flex flex-col sticky top-24 transition-all"
                 :class="mode === 'edit' ? 'ring-2 ring-yellow-400' : ''">
                
                <!-- Form Header -->
                <div class="px-6 py-5 border-b border-gray-50 rounded-t-[2rem] flex items-center justify-between transition-colors"
                     :class="mode === 'edit' ? 'bg-yellow-400' : 'bg-[#1A337E]'">
                    <div>
                        <h2 class="font-black text-xs uppercase tracking-[0.2em]" :class="mode === 'edit' ? 'text-yellow-900' : 'text-white'" x-text="mode === 'edit' ? 'Form Pelunasan' : 'Form Booking Baru'"></h2>
                        <p class="text-[9px] font-bold italic mt-0.5" :class="mode === 'edit' ? 'text-yellow-800' : 'text-blue-200'" x-text="mode === 'edit' ? 'Melunaskan invoice ' + selectedTx.invoice_number : 'Lengkapi data pelanggan'"></p>
                    </div>
                    <button type="button" x-show="mode === 'edit'" @click="resetForm()" class="p-1.5 bg-yellow-500 rounded-lg text-yellow-900 hover:bg-yellow-600 transition-colors tooltip items-center justify-center flex" title="Batal Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
               <form 
                    :action="mode === 'create' ? '{{ route('admin.transactions.store') }}' : '/kasir/transaksi/' + (selectedTx ? selectedTx.id : '')" 
                    method="POST" 
                    class="p-6 space-y-5"
                >
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <input type="hidden" name="package_id" x-model="selectedPackage">

                    <!-- Customer & Execution Date -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-gray-400 uppercase italic">Customer Name</label>
                            <input type="text" name="customer_name" x-model="customerName" required 
                                :readonly="mode === 'edit'"
                                class="w-full px-4 py-3 bg-gray-50 rounded-xl text-[12px] font-bold text-[#0B224E] border border-transparent focus:bg-white focus:border-[#1A337E] outline-none transition-all"
                                :class="mode === 'edit' ? 'opacity-70 cursor-not-allowed' : ''">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-gray-400 uppercase italic">Pelaksanaan</label>
                            <input type="date" name="execution_date" x-model="executionDate" required 
                                :readonly="mode === 'edit'"
                                class="w-full px-4 py-3 bg-gray-50 rounded-xl text-[12px] font-bold text-[#0B224E] border border-transparent focus:bg-white focus:border-[#1A337E] outline-none transition-all"
                                :class="mode === 'edit' ? 'opacity-70 cursor-not-allowed' : ''">
                        </div>
                    </div>

                    <!-- Selected Package Summary Card -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-blue-100 flex items-center justify-between"
                         x-show="selectedPackage">
                         <div class="flex items-center gap-3">
                             <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-[#1A337E]">
                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                             </div>
                             <div>
                                 <p class="text-[9px] font-black text-gray-400 uppercase italic leading-none">Paket Terpilih</p>
                                 <p class="text-[11px] font-bold text-[#0B224E] mt-1 line-clamp-1" x-text="selectedPackageName"></p>
                             </div>
                         </div>
                         <div class="text-right">
                             <p class="text-[12px] font-black text-[#1A337E]" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedPrice)"></p>
                         </div>
                    </div>
                    
                    <div class="bg-red-50 text-red-500 rounded-xl p-4 text-center border border-red-100 text-[10px] font-bold tracking-widest uppercase" x-show="mode==='create' && !selectedPackage">
                        MOHON PILIH PAKET TERLEBIH DAHULU<br><span class="opacity-70 italic font-normal text-[9px]">Pilih dari daftar paket di tengah</span>
                    </div>

                    <!-- Photographer & Location Selection -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-gray-400 uppercase italic">Photographer</label>
                           <select name="photographer_id" x-model="selectedPhotographer" required 
                                :disabled="mode === 'edit'"
                            class="w-full px-4 py-3 bg-gray-50 rounded-xl text-[11px] font-bold text-[#0B224E] focus:bg-white border-transparent focus:border-[#1A337E] border outline-none transition-all"
                            :class="mode === 'edit' ? 'opacity-70 cursor-not-allowed' : ''">
                            <option value="">Pilih...</option>
                            @foreach($photographers as $pt)
                                <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[9px] font-black text-gray-400 uppercase italic">Lokasi</label>
                            <!-- Updated Location Selection (Manual & Decoupled) -->
                            <select name="location_id" x-model="locationId" required
                                :disabled="mode === 'edit'"
                                class="w-full px-4 py-3 bg-gray-50 rounded-xl text-[11px] font-bold text-[#0B224E] focus:bg-white border-transparent focus:border-[#1A337E] border outline-none transition-all"
                                :class="mode === 'edit' ? 'opacity-70 cursor-not-allowed' : ''">
                                <option value="">Pilih Lokasi...</option>
                                @foreach($locations as $lc)
                                    <option value="{{ $lc->id }}">{{ $lc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-black text-[#0B224E] uppercase italic">Opsi Bayar:</span>
                            <div class="flex items-center gap-2">
                                <span class="text-[8px] font-bold" :class="!isDP ? 'text-[#1A337E]' : 'text-gray-300'">LUNAS</span>
                                <!-- Toggle button visually disabled on edit -->
                                <button type="button" @click="isDP = !isDP; togglePaymentMode()" 
                                    :disabled="mode === 'edit'"
                                    class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors" 
                                    :class="[isDP ? 'bg-yellow-400' : 'bg-[#1A337E]', mode === 'edit' ? 'opacity-50 cursor-not-allowed' : '']">
                                    <span class="h-3 w-3 transform rounded-full bg-white transition-transform" :class="isDP ? 'translate-x-5' : 'translate-x-1'"></span>
                                </button>
                                <span class="text-[8px] font-bold" :class="isDP ? 'text-yellow-600' : 'text-gray-300'">DP</span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-gray-400 uppercase">Nominal Tagihan</label>
                            <input type="number" name="amount_paid" x-model.number="amountToPay" readonly
                                class="w-full px-4 py-2.5 rounded-xl text-sm font-black border-2 transition-all outline-none cursor-not-allowed"
                                :class="[
                                    isDP ? 'bg-yellow-50 border-yellow-400 text-yellow-600' : 'bg-gray-100 border-transparent text-[#1A337E]',
                                    mode === 'edit' ? 'border-red-400 bg-red-50 text-red-600' : ''
                                ]">
                            
                            <p class="text-[8px] mt-1 font-bold italic" :class="mode === 'edit' ? 'text-red-500' : (isDP ? 'text-yellow-600' : 'text-blue-500')">
                                <span x-show="mode === 'create' && isDP">*Bayar DP 50% dari total</span>
                                <span x-show="mode === 'create' && !isDP">*Bayar Lunas (Full)</span>
                                <span x-show="mode === 'edit'">*Sisa Hutang DP yang harus ditutup</span>
                            </p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-gray-400 uppercase">Uang Tunai (Cash)</label>
                            <input type="number" name="cash_received" x-model.number="cashReceived" class="w-full px-4 py-2.5 bg-white border-2 border-[#10B981] rounded-xl text-sm font-black text-[#10B981] outline-none" placeholder="0">
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-[9px] font-black text-gray-400 uppercase">Kembalian</span>
                            <span class="text-xs font-black" :class="change < 0 ? 'text-red-500' : 'text-[#10B981]'">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(change)"></span>
                            </span>
                        </div>
                    </div>

                    <button type="submit" 
                        :disabled="amountToPay <= 0 || change < 0 || !selectedPackage" 
                        class="w-full py-4 disabled:opacity-50 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl transition-all active:scale-95"
                        :class="mode === 'edit' ? 'bg-yellow-500 hover:bg-yellow-600 shadow-yellow-500/20' : 'bg-[#1A337E] hover:bg-[#0B224E] shadow-[#1A337E]/20'">
                        <span x-text="mode === 'edit' ? 'Lunaskan Tagihan' : 'Submit Booking'"></span>
                    </button>

                    <!-- Cancel button wrapper -->
                    <div x-show="mode === 'edit'" class="mt-4 text-center">
                        <button type="button" @click="$refs.cancelForm.submit()" class="text-[10px] text-red-500 hover:text-red-700 font-bold uppercase tracking-wider underline underline-offset-2 transition-colors">
                            Batalkan Booking Ini
                        </button>
                    </div>
                </form>

                <!-- Hidden form for Cancel -->
                <form x-ref="cancelForm" :action="'/kasir/transaksi/' + (selectedTx ? selectedTx.id : '') + '/cancel'" method="POST" class="hidden" onsubmit="return confirm('Bagian Kasir: Batalkan booking ini? Dana DP dikembalikan 75% untuk customer.')">
                    @csrf
                    @method('PUT')
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('print_id'))
            // Delay render untuk SweetAlert jika diblokir
            setTimeout(function() {
                const url = "{{ route('admin.transactions.print', session('print_id')) }}";
                const win = window.open(url, '_blank');
                
                if (!win || win.closed || typeof win.closed == 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pop-up Diblokir',
                        text: "Pencetakan struk otomatis diblokir browser. Silakan klik 'Izinkan', atau cetak manual melalui fitur Detail Riwayat.",
                        customClass: {
                            confirmButton: 'bg-[#0B224E] rounded-xl text-xs font-bold px-6 py-3 uppercase tracking-widest'
                        }
                    });
                }
            }, 500); 
        @endif
    });
</script>
@endsection
