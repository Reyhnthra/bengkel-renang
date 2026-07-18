<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Dashboard Pelatih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F4F9FD] min-h-screen">

    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>
    <aside id="sidebar" class="hidden md:flex flex-col justify-between fixed inset-y-0 left-0 z-50 w-64 bg-[#032B53] text-white py-6 px-4 shadow-xl transition-all duration-300">
        
        <div class="flex flex-col">
            <div class="flex items-center space-x-3 px-2 mb-8">
                <div class="w-10 h-10 rounded-full border border-[#FDB813] overflow-hidden flex items-center justify-center bg-slate-800 shrink-0">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="font-bold text-sm tracking-wide block">Bengkel Renang</h2>
                    <span class="text-[10px] text-slate-400 block tracking-wider -mt-0.5">Dashboard Mr Iqbal</span>
                </div>
            </div>

            <div class="space-y-1.5">
                <a href="{{ route('coach.dashboard') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition {{ request()->routeIs('coach.dashboard') ? 'bg-white text-[#032B53] shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    <span>Overview</span>
                </a>
                <a href="{{ route('coach.students') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition {{ request()->routeIs('coach.students') ? 'bg-white text-[#032B53] shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <span>Daftar Siswa</span>
                </a>
                <a href="{{ route('coach.attendance') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition {{ request()->routeIs('coach.attendance') ? 'bg-white text-[#032B53] shadow-md' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    <span>Absensi & Nilai</span>
                </a>
            </div>
        </div>

        <div class="px-2">
            <form action="{{ route('coach.logout') }}" method="POST" id="logout-form" class="hidden">
                @csrf
            </form>
            <a href="{{ route('coach.logout') }}" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
            class="flex items-center space-x-3 px-4 py-3.5 rounded-2xl font-bold text-sm transition text-red-200/70 hover:bg-red-500/10 hover:text-red-400 border-t border-white/5 pt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
            </a>
        </div>
    </aside>
    <main class="flex-1 md:ml-64 p-4 md:p-8 min-h-screen transition-all duration-300">
        
        <button id="menu-btn" class="md:hidden p-2 bg-[#032B53] text-white rounded-lg mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>

        @if(session('success'))
            <div class="fixed top-6 right-6 z-50 bg-teal-500 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-lg border border-teal-400 flex items-center space-x-2">
                <span>✓</span> <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            // Toggle sidebar
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('flex');
            // Toggle overlay
            overlay.classList.toggle('hidden');
        }

        if(menuBtn) {
            menuBtn.addEventListener('click', toggleSidebar);
        }

        // Klik overlay untuk menutup
        if(overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }
    </script>
</body>
</html>