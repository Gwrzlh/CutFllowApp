@extends('layouts.Admin')

@section('content')
<div x-data="{ 
    openDrawer: @if($errors->any()) true @else false @endif, 
    mode: 'create',
    formData: {
        id: '{{ old('id') }}',
        name: '{{ old('name') }}',
        Kabupaten: '{{ old('Kabupaten') }}'
    },
    actionUrl: '{{ old('id') ? route('admin.lokasi.update', old('id')) : route('admin.lokasi.store') }}',
    editItem(item) {
        this.mode = 'edit';
        this.formData = { id: item.id, name: item.name, Kabupaten: item.Kabupaten };
        this.actionUrl = '{{ route('admin.lokasi.index') }}/' + item.id;
        this.openDrawer = true;
    },
    createItem() {
        this.mode = 'create';
        this.formData = { id: '', name: '', Kabupaten: '' };
        this.actionUrl = '{{ route('admin.lokasi.store') }}';
        this.openDrawer = true;
    }
}" class="space-y-10">
    <!-- Page Header -->
    <div class="flex items-start gap-4">
        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#0B224E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 015.656 0l4 4a4 4 0 01-5.656 5.656l-1.102-1.101" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l.01 0" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-[#0B224E] tracking-tight whitespace-nowrap">Dashboard Link</h1>
            <p class="text-sm text-gray-400 mt-1 whitespace-nowrap">Page Master Lokasi</p>
        </div>
    </div>

    <!-- Data Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-sm uppercase tracking-tight">
        <div class="px-8 py-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white">
            <div class="flex flex-col md:flex-row items-center gap-4 flex-1">
                <h2 class="font-bold text-[#0B224E] whitespace-nowrap">List Lokasi</h2>
                
                <!-- Search Form -->
                <form action="{{ route('admin.lokasi.index') }}" method="GET" class="flex items-center gap-3 w-full max-w-xl">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or kabupaten..." 
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
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Lokasi
            </button>
        </div>

        <div class="p-0">
            <div class="overflow-x-auto text-[13px]">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 italic">
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100">No</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100">Nama Lokasi</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100 uppercase tracking-widest">Kabupaten</th>
                            <th class="px-8 py-4 font-bold uppercase tracking-widest border-b border-gray-100 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 whitespace-nowrap font-bold">
                        @forelse ($lokasi as $item)
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="px-8 py-5 text-gray-400 font-medium">{{ ($lokasi->currentPage() - 1) * $lokasi->perPage() + $loop->iteration }}</td>
                            <td class="px-8 py-5 text-[#0B224E] font-bold capitalize">{{ $item->name }}</td>
                            <td class="px-8 py-5 text-gray-500 font-medium uppercase tracking-widest">{{ $item->Kabupaten }}</td>
                            <td class="px-8 py-5 text-right font-normal">
                                <div class="flex items-center justify-end gap-3 font-normal">
                                    <button @click="editItem({{ json_encode($item) }})" class="p-2.5 text-gray-300 hover:text-[#1A337E] hover:bg-white rounded-lg transition-all shadow-sm border border-transparent hover:border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#1A337E]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.lokasi.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lokasi ini?')">
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
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-gray-400 italic">No locations found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-8 py-6 bg-white border-t border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-[11px] text-gray-400 font-medium italic uppercase tracking-wider">
                    Showing {{ $lokasi->firstItem() ?? 0 }} to {{ $lokasi->lastItem() ?? 0 }} of {{ $lokasi->total() }} entities
                </p>
                <div class="custom-pagination">
                    {{ $lokasi->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Drawer Section -->
    <div class="fixed inset-0 z-[60] overflow-hidden uppercase tracking-tight" 
        x-show="openDrawer" 
        x-cloak>
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity" 
            x-show="openDrawer"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="openDrawer = false"></div>

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
                            <h2 class="text-lg font-bold text-[#0B224E]" x-text="mode === 'create' ? 'Form Add Lokasi' : 'Form Update Lokasi'"></h2>
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
                                <label for="name" class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest">Nama Lokasi</label>
                                <input type="text" name="name" id="name" placeholder="Tulis Nama Lokasi" x-model="formData.name"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E]" required>
                                @error('name') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="Kabupaten" class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Kabupaten</label>
                                <input type="text" name="Kabupaten" id="Kabupaten" placeholder="Tulis Nama Kabupaten" x-model="formData.Kabupaten"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E]" required>
                                @error('Kabupaten') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
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


