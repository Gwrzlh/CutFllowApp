@extends('layouts.Admin')

@section('content')
<div x-data="{ 
    openDrawer: @if($errors->any()) true @else false @endif, 
    mode: 'create',
    formData: {
        id: '{{ old('id') }}',
        name: '{{ old('name') }}',
        price: '{{ old('price') }}',
        description: '{{ old('description') }}',
        status: '{{ old('status') }}'
    },
    actionUrl: '{{ old('id') ? route('admin.package.update', old('id')) : route('admin.package.store') }}',
    editItem(item) {
        this.mode = 'edit';
        this.formData = { id: item.id, name: item.name, price: item.price, description: item.description, status: item.is_active };
        this.actionUrl = '{{ route('admin.package.index') }}/' + item.id;
        this.openDrawer = true;
    },
    createItem() {
        this.mode = 'create';
        this.formData = { id: '', name: '', price: '', description: '', status: '' };
        this.actionUrl = '{{ route('admin.package.store') }}';
        this.openDrawer = true;
    }
}" class="space-y-10">
    <!-- Page Header -->
    <div class="flex items-start gap-4">
        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#0B224E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-[#0B224E] tracking-tight">Packages</h1>
            <p class="text-sm text-gray-400 mt-1">Page Master Paket Layanan</p>
        </div>
    </div>

    <!-- Data Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm uppercase italic">
        <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white not-italic">
            <div class="flex flex-col md:flex-row items-center gap-4 flex-1">
                <h2 class="font-bold text-[#0B224E] whitespace-nowrap">List Package</h2>
                
                <!-- Search Form -->
                <form action="{{ route('admin.package.index') }}" method="GET" class="flex items-center gap-3 w-full max-w-xl text-left">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search package name or description..." 
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-medium">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
            </div>

            <button @click="createItem()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1A337E] text-white rounded-xl text-[11px] font-bold hover:bg-[#0B224E] transition-all shadow-md active:scale-95 uppercase tracking-widest whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Paket
            </button>
        </div>

        <div class="p-0">
            <div class="overflow-x-auto text-[13px] not-italic">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 italic">
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100">No</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100">Nama Paket</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100">Status</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100">Harga</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100">Deskripsi</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 uppercase tracking-tight font-bold whitespace-nowrap">
                        @forelse ($package as $item)
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="px-8 py-5 text-gray-400 font-medium whitespace-normal">{{ ($package->currentPage() - 1) * $package->perPage() + $loop->iteration }}</td>
                            <td class="px-8 py-5 text-[#0B224E] font-bold">{{ $item->name }}</td>
                            <td class="px-8 py-5">
                                @if($item->is_active === 1)
                                    <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-green-100">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-red-100">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-[#1A337E] font-bold tracking-widest uppercase">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-8 py-5 text-gray-500 font-medium normal-case italic line-clamp-1 max-w-[200px] whitespace-normal">{{ $item->description }}</td>
                            <td class="px-8 py-5 text-right font-normal">
                                <div class="flex items-center justify-end gap-3 font-normal">
                                    <button @click="editItem({{ json_encode($item) }})" class="p-2.5 text-gray-300 hover:text-[#1A337E] hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#1A337E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.package.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus paket ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 text-gray-300 hover:text-red-500 hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="not-italic">
                            <td colspan="6" class="px-8 py-10 text-center text-gray-400 italic">No packages found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-8 py-6 bg-white border-t border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4 not-italic">
                <p class="text-[11px] text-gray-400 font-medium italic uppercase tracking-wider">
                    Showing {{ $package->firstItem() ?? 0 }} to {{ $package->lastItem() ?? 0 }} of {{ $package->total() }} entities
                </p>
                <div class="custom-pagination">
                    {{ $package->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Drawer Section -->
    <div class="fixed inset-0 z-[60] overflow-hidden uppercase tracking-tight" x-show="openDrawer" x-cloak>
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity" 
            x-show="openDrawer" @click="openDrawer = false"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <div class="w-screen max-w-md shadow-2xl transition-all"
                x-show="openDrawer"
                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full">
                
                <form :action="actionUrl" method="POST" class="h-full flex flex-col bg-white">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="id" x-model="formData.id">

                    <div class="flex-1 h-0 overflow-y-auto">
                        <!-- Drawer Header -->
                        <div class="px-8 py-6 bg-white border-b border-gray-100 flex items-center justify-between sticky top-0 z-10">
                            <h2 class="text-lg font-bold text-[#0B224E]" x-text="mode === 'create' ? 'Form Add Package' : 'Form Update Package'"></h2>
                            <button type="button" @click="openDrawer = false" class="p-2 text-gray-400 hover:text-[#0B224E] transition-colors rounded-lg hover:bg-gray-50">
                                <svg class="h-5 w-5 text-[#0B224E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Form Content -->
                        <div class="px-8 py-10 space-y-8 font-normal">
                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="pkg_name" class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest">Nama Paket</label>
                                <input type="text" name="name" id="pkg_name" placeholder="Tulis Nama Paket" x-model="formData.name"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E]" required>
                                @error('name') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="price" class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest">Harga (Rp)</label>
                                <input type="number" name="price" id="price" placeholder="Contoh: 500000" x-model="formData.price"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] tracking-widest" required>
                                @error('price') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="description" class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest">Deskripsi</label>
                                <textarea name="description" id="description" rows="5" placeholder="Tulis deskripsi detail paket..." x-model="formData.description"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] normal-case tracking-normal"></textarea>
                                @error('description') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div>
                               <label for="status" class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest">Status</label>
                               <select name="status" id="status" x-model="formData.status" class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] tracking-widest">
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select> 
                            </div>
                        </div>
                    </div>

                    <!-- Drawer Footer -->
                    <div class="flex-shrink-0 px-8 py-6 border-t border-gray-50 flex items-center gap-3 bg-gray-50/30 font-bold">
                        <button type="button" @click="openDrawer = false"
                            class="flex-1 px-6 py-4 bg-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-300 transition-all uppercase tracking-widest active:scale-95 shadow-sm">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-[2] px-6 py-4 bg-[#1A337E] text-white rounded-xl text-xs font-bold hover:bg-[#0B224E] transition-all shadow-lg active:scale-95 uppercase tracking-widest">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection