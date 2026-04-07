@extends('Admin.lokasi.index')

@section('drawer')
<div class="fixed inset-0 z-50 overflow-hidden" x-data="{ open: true }" x-show="open" x-cloak>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity" @click="window.location.href='{{ route('admin.lokasi.index') }}'"></div>

    <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
        <div class="w-screen max-w-md"
            x-show="open"
            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">
            
            <form action="{{ route('admin.lokasi.update', $lokasi_edit->id) }}" method="POST" class="h-full flex flex-col bg-white shadow-2xl border-l border-gray-100 uppercase tracking-tight">
                @csrf
                @method('PUT')
                <div class="flex-1 h-0 overflow-y-auto">
                    <!-- Drawer Header -->
                    <div class="px-8 py-6 bg-white border-b border-gray-50 flex items-center justify-between sticky top-0 z-10">
                        <h2 class="text-lg font-bold text-[#0B224E]">Form Update Lokasi</h2>
                        <button type="button" @click="window.location.href='{{ route('admin.lokasi.index') }}'" class="p-2 text-gray-400 hover:text-[#0B224E] transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Content -->
                    <div class="px-8 py-10 space-y-8">
                        <!-- Input Group -->
                        <div class="space-y-2">
                            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Lokasi</label>
                            <input type="text" name="name" id="name" placeholder="Tulis Nama Lokasi" value="{{ old('name', $lokasi_edit->name) }}"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/20 focus:border-[#1A337E] transition-all" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Group -->
                        <div class="space-y-2">
                            <label for="Kabupaten" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Kabupaten</label>
                            <input type="text" name="Kabupaten" id="Kabupaten" placeholder="Tulis Nama Kabupaten" value="{{ old('Kabupaten', $lokasi_edit->Kabupaten) }}"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/20 focus:border-[#1A337E] transition-all" required>
                            @error('Kabupaten') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="flex-shrink-0 px-8 py-6 border-t border-gray-50 flex items-center gap-3">
                    <button type="button" @click="window.location.href='{{ route('admin.lokasi.index') }}'"
                        class="flex-1 px-6 py-3 bg-[#D1D5DB] text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-400 transition-all uppercase tracking-widest">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-[2] px-6 py-3 bg-[#1A337E] text-white rounded-xl text-sm font-bold hover:bg-[#0B224E] transition-all shadow-lg shadow-blue-900/20 active:scale-[0.98] uppercase tracking-widest">
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
