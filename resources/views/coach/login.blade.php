<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelatih - Bengkel Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link class="cursor-pointer" rel="preconnect" href="https://fonts.googleapis.com">
    <link class="cursor-pointer" rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#032B53] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-[32px] shadow-2xl p-8 sm:p-10 border border-slate-100 flex flex-col items-center">
        
        <div class="w-16 h-16 bg-[#032B53] rounded-2xl flex items-center justify-center shadow-lg mb-6">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#032B53] text-center tracking-tight">Dashboard Pelatih</h1>
        <p class="text-slate-500 text-sm font-medium text-center mt-1.5 mb-8">Masukkan akun untuk accessing dashboard</p>

        @if(session('error'))
            <div class="w-full bg-red-50 text-red-600 text-xs p-3 rounded-xl mb-4 border border-red-100 font-semibold">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('coach.login.submit') }}" method="POST" class="w-full space-y-5">
            @csrf
            
            <div class="space-y-1.5">
                <label for="email" class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Email Pelatih</label>
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full bg-[#E6F0FA] text-slate-800 font-bold placeholder-slate-400 rounded-2xl px-5 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>
                @error('email')
                    <span class="text-red-500 text-[10px] font-semibold block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label for="pin" class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">PIN Akses</label>
                <div class="relative">
                    <input type="password" id="pin" name="pin" maxlength="6" class="w-full bg-[#E6F0FA] text-slate-800 font-bold placeholder-slate-400 text-center tracking-[0.5em] rounded-2xl pl-12 pr-12 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                    
                    <button type="button" onclick="togglePinVisibility()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('pin')
                    <span class="text-red-500 text-[10px] font-semibold block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#032B53] hover:bg-blue-900 text-white font-bold py-4 rounded-2xl text-sm shadow-md transition duration-200 flex items-center justify-center space-x-2 transform hover:scale-[1.02] cursor-pointer focus:outline-none">
                <span>Masuk</span>
            </button>
        </form>

        <a href="{{ route('landing') }}" class="w-full border border-slate-200 text-slate-500 hover:text-slate-700 hover:bg-slate-50 font-extrabold py-3.5 rounded-2xl text-xs uppercase tracking-wider transition-all flex items-center justify-center space-x-1 mt-3 cursor-pointer">
            <span>Kembali ke Beranda</span>
        </a>

    </div>

    <script>
        function togglePinVisibility() {
            const pinInput = document.getElementById('pin');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (pinInput.type === 'password') {
                pinInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
            } else {
                pinInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
</body>
</html>