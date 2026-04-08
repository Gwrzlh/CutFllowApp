@extends('layouts.Kasir')

@section('content')
   <div x-data="{ 
    mode: 'create',
    selectedTx: null,
    customerName: '',
    selectedPackage: '',
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
        this.selectedPhotographer = tx.photographer_id;
        this.executionDate = tx.execution_date;
        this.selectedPrice = tx.total_amount;
        
        // Sisa yang harus dibayar
        this.amountToPay = tx.total_amount - tx.amount_paid; 
        this.cashReceived = 0;
        this.isDP = false; 
        this.locationId = tx.photographer ? tx.photographer.location_id : '';
    },
    
    resetForm() {
        this.mode = 'create';
        this.selectedTx = null;
        this.customerName = '';
        this.selectedPackage = '';
        this.selectedPhotographer = '';
        this.executionDate = '';
        this.selectedPrice = 0;
        this.amountToPay = 0;
        this.cashReceived = 0;
        this.isDP = false;
        this.locationId = '';
    },

    // Fungsi updatePrice tetap ada untuk mode 'create'
   updatePrice(e) {
        if(this.mode === 'edit') return;
        let price = e.target.options[e.target.selectedIndex].dataset.price;
        this.selectedPrice = parseInt(price) || 0;
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
    },

    updateLocation(e) {
        let locId = e.target.options[e.target.selectedIndex].dataset.locationId;
        this.locationId = locId || '';
    }
}" class="space-y-10">
    <!-- Page Header -->
    <div class="flex items-start gap-4">
        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#0B224E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-[#0B224E]">Transaction & Booking</h1>
            <p class="text-xs text-gray-400 mt-1 font-normal uppercase tracking-widest leading-loose">Manage bookings and process payments in a single unified flow</p>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: List of Transactions (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-white">
                    <h2 class="font-black text-[#0B224E] text-sm uppercase tracking-widest">Recent Transactions</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <div class="px-8 py-4 bg-gray-50/50 flex items-center justify-between">
                        <div class="relative w-full max-w-xs">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input type="text" id="searchInput" placeholder="Cari Nama atau Invoice..." 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl text-[10px] leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#1A337E] focus:border-[#1A337E] transition duration-150 ease-in-out uppercase tracking-widest font-bold">
                        </div>
                    </div>
                    <table class="w-full text-left border-collapse text-[11px] uppercase tracking-widest font-bold">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-400">
                                <th class="px-8 py-4 italic">Invoice</th>
                                <th class="px-8 py-4 italic">Customer</th>
                                <th class="px-8 py-4 italic">Date</th>
                                <th class="px-8 py-4 italic text-center">Status</th>
                                <th class="px-8 py-4 italic text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 font-bold">
                            @foreach ($transactions as $tx)
                            <tr class="hover:bg-gray-50/30 transition-colors group">
                                <td class="px-8 py-5 text-[#0B224E]">{{ $tx->invoice_number }}</td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-[#0B224E]">{{ $tx->customer_name }}</span>
                                        <span class="text-gray-400 text-[9px] font-normal italic lowercase">
                                            {{ $tx->package->name ?? 'Package Deleted' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-gray-400 italic">{{ date('d M Y', strtotime($tx->execution_date)) }}</td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        @if($tx->payment_status === 'paid_off')
                                            <span class="px-2 py-1 bg-[#4CAF50]/10 text-[#4CAF50] rounded-lg text-[8px] uppercase tracking-widest">Lunas</span>
                                        @elseif($tx->payment_status === 'down_payment')
                                            <span class="px-2 py-1 bg-[#FFD369]/10 text-[#FFD369] rounded-lg text-[8px] uppercase tracking-widest">DP</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100/10 text-red-500 rounded-lg text-[8px] uppercase tracking-widest">Batal</span>
                                        @endif

                                        <div class="flex items-center gap-1">
                                            @if($tx->booking_status === 'completed')
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#1A337E]"></span>
                                                <span class="text-[7px] text-gray-300">Completed</span>
                                            @elseif($tx->booking_status === 'cancelled')
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                <span class="text-[7px] text-gray-300">Cancelled</span>
                                            @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#FFD369]"></span>
                                                <span class="text-[7px] text-gray-300">Scheduled</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                               <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($tx->payment_status !== 'paid_off' && $tx->booking_status !== 'cancelled')
                                        <button type="button" @click="preparePelunasan({{ json_encode($tx) }})" 
                                            class="flex items-center gap-2 px-3 py-2 text-white bg-[#10B981] rounded-lg shadow-sm hover:bg-[#059669] active:scale-95 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-[8px] font-black uppercase">Lunaskan</span>
                                        </button>
                                    @endif
                                    
                                    @if($tx->booking_status !== 'cancelled' && $tx->booking_status !== 'completed')
                                    <form action="{{ route('admin.transactions.cancel', $tx->id) }}" method="POST" onsubmit="return confirm('Batalkan booking ini? DP akan dipotong 25% untuk administrasi.')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="p-2 text-white bg-red-500 rounded-lg shadow-sm hover:bg-red-600 active:scale-95 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                            </tr>
                            @endforeach
                            @if($transactions->isEmpty())
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-gray-300 italic font-normal tracking-wide normal-case translate-x-0">Belum ada transaksi hari ini.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: "Add Booking" Form (1/3 width) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2rem] shadow-2xl border border-gray-50 flex flex-col sticky top-28">
                <div class="px-8 py-6 border-b border-gray-50 bg-[#1A337E] rounded-t-[2rem]">
                    <h2 class="font-black text-white text-xs uppercase tracking-[0.2em]">Form Add Booking</h2>
                </div>
                
               <form 
                    :action="mode === 'create' ? '{{ route('admin.transactions.store') }}' : '/kasir/transaksi/' + selectedTx.id" 
                    method="POST" 
                    class="p-8 space-y-6"
                >
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase italic">Customer Name</label>
                        <input type="text" name="customer_name" x-model="customerName" required 
                            :readonly="mode === 'edit'"
                            class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-[13px] font-bold text-[#0B224E] border border-transparent outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase italic">Pilih Paket</label>
                        <select name="package_id" x-model="selectedPackage" @change="updatePrice($event)" required 
                            :disabled="mode === 'edit'"
                            class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-[13px] font-bold text-[#0B224E] outline-none">
                            <option value="">Pilih Paket...</option>
                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}" data-price="{{ $pkg->price }}">{{ $pkg->name }}</option>
                            @endforeach
                                </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase italic">Photographer</label>
                           <select name="photographer_id" x-model="selectedPhotographer" @change="updateLocation($event)" required 
                                :disabled="mode === 'edit'"
                            class="w-full px-4 py-3 bg-gray-50 rounded-xl text-[12px] font-bold text-[#0B224E] outline-none">
                            <option value="">Pilih...</option>
                            @foreach($photographers as $pt)
                                <option value="{{ $pt->id }}" data-location-id="{{ $pt->location_id }}">{{ $pt->name }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase italic">Location</label>
                            <select name="location_id" x-model="locationId" class="w-full px-4 py-3 bg-gray-100 rounded-xl text-[12px] font-bold text-gray-500 pointer-events-none opacity-60">
                                <option value="">Otomatis...</option>
                                @foreach($locations as $lc)
                                    <option value="{{ $lc->id }}">{{ $lc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase italic">Execution Date</label>
                       <input type="date" name="execution_date" x-model="executionDate" required 
                            :readonly="mode === 'edit'"
                            class="w-full px-5 py-3.5 bg-gray-50 rounded-2xl text-[13px] font-bold text-[#1A337E] outline-none">
                    </div>

                    <div class="p-5 bg-gray-50 rounded-[1.5rem] border border-gray-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-black text-[#0B224E] uppercase italic">Opsi Bayar:</span>
                            <div class="flex items-center gap-2">
                                <span class="text-[8px] font-bold" :class="!isDP ? 'text-[#1A337E]' : 'text-gray-300'">LUNAS</span>
                                <button type="button" @click="isDP = !isDP; togglePaymentMode()" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors" :class="isDP ? 'bg-yellow-400' : 'bg-[#1A337E]'">
                                    <span class="h-3 w-3 transform rounded-full bg-white transition-transform" :class="isDP ? 'translate-x-5' : 'translate-x-1'"></span>
                                </button>
                                <span class="text-[8px] font-bold" :class="isDP ? 'text-yellow-600' : 'text-gray-300'">DP</span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-gray-400 uppercase">Nominal Bayar</label>
                            <input type="number" name="amount_paid" x-model.number="amountToPay" readonly
                                class="w-full px-4 py-2.5 rounded-xl text-sm font-black border-2 transition-all outline-none cursor-not-allowed"
                                :class="isDP ? 'bg-yellow-50 border-yellow-400 text-yellow-600' : 'bg-gray-100 border-transparent text-[#1A337E]'">
                            
                            <p class="text-[8px] mt-1 font-bold italic" :class="isDP ? 'text-yellow-600' : 'text-blue-500'">
                                <span x-show="isDP">*Bayar DP 50% dari total</span>
                                <span x-show="!isDP">*Bayar Lunas (Full)</span>
                            </p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-gray-400 uppercase">Uang Tunai (Cash)</label>
                            <input type="number" name="cash_received" x-model.number="cashReceived" class="w-full px-4 py-2.5 bg-white border-2 border-[#10B981] rounded-xl text-sm font-black text-[#10B981] outline-none" placeholder="0">
                        </div>

                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <span class="text-[9px] font-black text-gray-400 uppercase">Kembalian</span>
                            <span class="text-xs font-black" :class="change < 0 ? 'text-red-500' : 'text-[#10B981]'">
                                Rp <span x-text="new Intl.NumberFormat().format(change)"></span>
                            </span>
                        </div>
                    </div>

                    <button type="submit" :disabled="amountToPay <= 0 || change < 0 || !selectedPrice" class="w-full py-4 bg-[#1A337E] disabled:opacity-50 text-white rounded-3xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl hover:bg-[#0B224E] transition-all">
                        Submit Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation messages from session
        @if(session('print_id'))
            // Gunakan sedikit delay agar browser selesai render
            setTimeout(function() {
                const url = "{{ route('admin.transactions.print', session('print_id')) }}";
                const win = window.open(url, '_blank');
                
                // Alert khusus jika popup diblokir
                if (!win || win.closed || typeof win.closed == 'undefined') {
                    alert("Pencetakan struk otomatis diblokir browser. Silakan klik 'Izinkan Pop-up' di pojok kanan atas browser atau cetak manual melalui tabel riwayat.");
                }
            }, 500); 
        @endif
        @if(session('success'))
            alert("{{ session('success') }}");
        @endif
        @if(session('error'))
            alert("{{ session('error') }}");
        @endif
    });

    document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    let rows = document.querySelector("tbody").rows;

    for (let i = 0; i < rows.length; i++) {
        let nameCol = rows[i].cells[1].textContent.toUpperCase();
        let invCol = rows[i].cells[0].textContent.toUpperCase();
        if (nameCol.indexOf(filter) > -1 || invCol.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
});
</script>
@endsection
