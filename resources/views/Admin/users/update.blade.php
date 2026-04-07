@extends('Admin.users.index')

@section('drawer')
<div class="fixed inset-0 z-50 overflow-hidden uppercase tracking-tight" x-data="{ open: true }" x-show="open" x-cloak>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity" @click="window.location.href='{{ route('admin.users.index') }}'"></div>

    <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
        <div class="w-screen max-w-md shadow-2xl transition-all">
            <div class="h-full flex flex-col bg-white"
                x-show="open"
                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full">
            
                <form action="{{ route('admin.users.update', $user_edit->id) }}" method="POST" class="h-full flex flex-col">
                    @csrf
                    @method('PUT')
                    <div class="flex-1 h-0 overflow-y-auto font-bold uppercase tracking-widest">
                        <!-- Drawer Header -->
                        <div class="px-8 py-6 bg-white border-b border-gray-100 flex items-center justify-between sticky top-0 z-10 font-bold uppercase tracking-widest border-b border-gray-100">
                            <h2 class="text-lg font-bold text-[#0B224E]">Form Update User</h2>
                            <button type="button" @click="window.location.href='{{ route('admin.users.index') }}'" class="p-2 text-gray-400 hover:text-[#0B224E] transition-colors rounded-lg hover:bg-gray-50">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Form Content -->
                        <div class="px-8 py-10 space-y-8 font-normal">
                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="name" class="block text-[11px] font-bold text-gray-400">Nama Lengkap</label>
                                <input type="text" name="name" id="name" placeholder="Tulis Nama Lengkap" value="{{ old('name', $user_edit->name) }}"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E]" required>
                                @error('name') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="email" class="block text-[11px] font-bold text-gray-400">Email Address</label>
                                <input type="email" name="email" id="email" placeholder="Contoh: user@mail.com" value="{{ old('email', $user_edit->email) }}"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] lowercase italic tracking-normal" required>
                                @error('email') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="password" class="block text-[11px] font-bold text-gray-400">New Password <span class="text-[9px] font-normal italic normal-case text-gray-300">(Kosongkan jika tidak ganti)</span></label>
                                <input type="password" name="password" id="password" placeholder="Min. 8 Karakter"
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] tracking-widest">
                                @error('password') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Input Group -->
                            <div class="space-y-2 uppercase tracking-[0.2em]">
                                <label for="role_id" class="block text-[11px] font-bold text-gray-400">Assign Role</label>
                                <select name="role_id" id="role_id" 
                                    class="w-full px-5 py-4 bg-gray-50/50 border border-gray-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1A337E]/10 focus:border-[#1A337E] transition-all font-semibold text-[#0B224E] appearance-none" required>
                                    <option value="" disabled>Pilih Role</option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->id }}" {{ old('role_id', $user_edit->role_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <p class="text-red-500 text-[11px] mt-1 italic font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Drawer Footer -->
                    <div class="flex-shrink-0 px-8 py-6 border-t border-gray-50 flex items-center gap-3 bg-gray-50/30 font-bold uppercase tracking-widest">
                        <button type="button" @click="window.location.href='{{ route('admin.users.index') }}'"
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