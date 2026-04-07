@extends('Admin.pic.index')

@section('drawer')
<div class="fixed inset-0 z-50 overflow-hidden uppercase tracking-tight" x-data="{ open: true }" x-show="open" x-cloak>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity" @click="window.location.href='{{ route('admin.pic.index') }}'"></div>

    <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
        <div class="w-screen max-w-md shadow-2xl"
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">
            
            <form action="{{ route('admin.pic.store') }}" method="POST" class="h-full flex flex-col bg-white">
                @csrf
                <div class="flex-1 h-0 overflow-y-auto font-bold">
                    <!-- Drawer Header -->
                    <div class="px-8 py-6 bg-white border-b border-gray-100 flex items-center justify-between sticky top-0 z-10">
                        <h2 class="text-lg font-bold text-[#0B224E]">Form Add Photographer</h2>
                        <button type="button" @click="window.location.href='{{ route('admin.pic.index') }}'" class="p-2 text-gray-400 hover:text-[#0B224E] transition-colors rounded-lg hover:bg-gray-50">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Content -->
                    <div class="px-8 py-10 space-y-8 font-normal">
                        <!-- Input Group -->
                        <div class="space-y-2 uppercase tracking-widest">
                            <label for="name" class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Nama PIC</label>
                            <input type="text" name="name" id="name" placeholder="Tulis Nama Photographer" value="{{ old('name') }}"
                                class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E]" required>
                            @error('name') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Group -->
                        <div class="space-y-2 uppercase tracking-widest">
                            <label for="phone" class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" placeholder="Contoh: 08123456789" value="{{ old('phone') }}"
                                class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] tracking-widest" required>
                            @error('phone') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Group -->
                        <div class="space-y-2 uppercase tracking-widest">
                            <label for="location_id" class="block text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Lokasi</label>
                            <select name="location_id" id="location_id" 
                                class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] appearance-none" required>
                                <option value="" disabled selected>Pilih Lokasi</option>
                                @foreach ($lokasi as $item)
                                    <option value="{{ $item->id }}" {{ old('location_id') == $item->id ? 'selected' : '' }}>{{ $item->name }} - {{ $item->Kabupaten }}</option>
                                @endforeach
                            </select>
                            @error('location_id') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="flex-shrink-0 px-8 py-6 border-t border-gray-50 flex items-center gap-3 bg-gray-50/30 font-bold">
                    <button type="button" @click="window.location.href='{{ route('admin.pic.index') }}'"
                        class="flex-1 px-6 py-4 bg-gray-200 text-gray-500 rounded-xl text-xs font-bold hover:bg-gray-300 transition-all uppercase tracking-widest active:scale-95">
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
@endsection