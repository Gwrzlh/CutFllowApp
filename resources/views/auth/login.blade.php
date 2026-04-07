<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cutflow Photography</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#E9ECEF] h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-[1000px] h-[640px] rounded-[32px] flex shadow-2xl overflow-hidden">
        
        <div class="flex-[1.2] p-12 md:p-20 flex flex-col justify-center">
            <div class="mb-10">
                <h1 class="text-[22px] font-bold text-[#2D3436]">Selamat Datang</h1>
                <p class="text-sm text-[#8E8E8E] mt-1">Login to access your cutflow account</p>
            </div>

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-[13px] font-medium text-[#2D3436] mb-2">Masukan Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                        placeholder="Tulis nama Customer" 
                        class="w-full px-4 py-3.5 bg-[#FAFAFA] border border-[#E8E8E8] rounded-xl text-sm outline-none focus:border-[#083A92] focus:ring-1 focus:ring-[#083A92] transition-all"
                        required autofocus>
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-[13px] font-medium text-[#2D3436] mb-2">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" 
                            placeholder="Kata Sandi" 
                            class="w-full px-4 py-3.5 bg-[#FAFAFA] border border-[#E8E8E8] rounded-xl text-sm outline-none focus:border-[#083A92] focus:ring-1 focus:ring-[#083A92] transition-all"
                            required>
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12.a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center space-x-2 py-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-[#083A92] focus:ring-[#083A92]">
                    <label for="remember" class="text-[13px] text-[#2D3436] cursor-pointer">Remember me</label>
                </div>

                <button type="submit" class="w-full bg-[#083A92] hover:bg-[#062d70] text-white py-3.5 rounded-xl font-semibold text-sm transition-colors shadow-lg shadow-blue-900/20">
                    Login
                </button>
            </form>
        </div>

        <div class="hidden md:flex flex-1 bg-[#083A92] items-center justify-center p-12">
            <div class="text-center w-full max-w-[320px]">
                <img src="{{ asset('assets/480b035e892fbbee05ad71e6a2660e529696ac8d.png') }}" alt="Cutflow Logo" class="w-full h-auto drop-shadow-2xl">
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    </script>
</body>
</html>