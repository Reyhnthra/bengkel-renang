<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel Renang - Gajahdepa Akuatik Sumedang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F4F9FD] text-slate-800 antialiased">

    <!-- 1. NAVBAR SECTION (FIXED ALIGNMENT) -->
    <nav class="bg-[#032B53] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-6 h-20 flex flex-row justify-between items-center">
            
            <!-- Kiri: Gabungan Logo Bulat + Tulisan (Satu Kesatuan Flex) -->
            <div class="flex items-center space-x-3">
                <!-- Lingkaran Berbingkai Kuning Emas Sesuai Desain Figma -->
                <div class="w-12 h-12 rounded-full border-2 border-[#FDB813] overflow-hidden flex items-center justify-center bg-slate-800 shadow-md shrink-0">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Bengkel Renang" class="w-full h-full object-cover">
                </div>
                <!-- Tulisan Brand -->
                <div class="leading-tight">
                    <span class="font-extrabold text-lg block tracking-wide text-white">Bengkel</span>
                    <span class="font-bold text-xs block text-[#FDB813] tracking-widest -mt-0.5">RENANG</span>
                </div>
            </div>

            <!-- Tengah: Menu Navigasi (Tetap Center dan Sejajar) -->
            <div class="hidden md:flex flex-row items-center space-x-8 font-semibold text-sm text-slate-200">
                <a href="#programs" class="hover:text-[#FDB813] transition duration-200">Our Programs</a>
                <a href="#pricing" class="hover:text-[#FDB813] transition duration-200">Pricing</a>
                <a href="#how-it-works" class="hover:text-[#FDB813] transition duration-200">How It Works</a>
            </div>

            <!-- Kanan: Tombol WhatsApp (Ukurannya Proporsional, Tidak Melar) -->
            <div class="flex items-center shrink-0">
                <a href="https://wa.me/089526772978" target="_blank" class="bg-[#FDB813] hover:bg-[#e0a20b] text-[#032B53] font-extrabold px-5 py-2.5 rounded-full text-xs flex items-center space-x-2 shadow-md transition duration-200 transform hover:scale-105">
                    <!-- Ikon WhatsApp -->
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397 0 11.948 0c3.179.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.239 3.482 8.42-.003 6.55-5.339 11.896-11.893 11.896-2.007-.001-3.982-.51-5.735-1.486L0 24zm6.59-4.846c1.666.988 3.311 1.485 5.308 1.486 5.589 0 10.134-4.52 10.137-10.074.001-2.692-1.047-5.222-2.951-7.127C17.237 2.533 14.711 1.48 12.003 1.48c-5.594 0-10.142 4.519-10.145 10.075a9.9 9.9 0 0 0 1.523 5.251l-.973 3.55 3.64-.954zm10.512-7.23c-.279-.14-1.651-.814-1.906-.907-.256-.094-.442-.14-.628.14-.186.279-.717.907-.88 1.093-.163.186-.326.21-.605.07-1.127-.563-1.941-.973-2.695-2.262-.196-.336.196-.312.56-.1.326-.175.442-.21.605-.489.163-.279.081-.523-.041-.663-.122-.14-1.025-2.47-1.404-3.38-.37-.889-.744-.768-.1025-.772h-.88c-.279 0-.733.105-1.117.523-.384.419-1.466 1.433-1.466 3.493 0 2.06 1.5 4.048 1.71 4.328.209.279 2.953 4.51 7.154 6.326 2.457 1.063 3.393 1.157 4.606.977 1.137-.17 2.47-.1 3.238-.928.767-.828.767-1.542.535-1.682-.232-.14-.814-.407-1.093-.547z"/>
                    </svg>
                    <span>Book via WhatsApp</span>
                </a>
            </div>

        </div>
    </nav>

    <header class="relative bg-[#032B53] text-white overflow-hidden pt-16 lg:pt-24 pb-28 lg:pb-36">
        
        <div class="absolute inset-0 opacity-25 bg-cover bg-center z-0" style="background-image: url('{{ asset('images/gambar1.jpeg') }}');"></div>
        
        <div class="absolute inset-0 bg-[#032B53]/50 z-0"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6">
                <span class="inline-flex items-center space-x-2 bg-blue-950 text-blue-300 font-bold text-xs px-4 py-2 rounded-full border border-blue-800">
                    <span class="text-[#FDB813]">★</span>
                    <span>Eksklusif Member Gajah Depa Akuatik Sumedang</span>
                </span>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    Master Swimming <br>Skills with <br><span class="text-[#FDB813]">Private Coaching</span>
                </h1>
                
                <p class="text-slate-300 text-lg max-w-xl leading-relaxed">
                    Safe, fun, and fully trackable progress. <br> Investasikan masa depan anak dengan tutoring privat yang intensif dan terstruktur. Setiap sesi latihan akan dicatat secara digital untuk memantau perkembangan kemampuan renang anak Anda.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="#pricing" class="bg-[#FDB813] hover:bg-[#e0a20b] text-[#032B53] font-bold px-6 py-3 rounded-xl shadow-lg text-sm transition">
                        Daftar Privat Sekarang
                    </a>
                    <a href="#how-it-works" class="border border-slate-400 hover:bg-white hover:text-[#032B53] font-bold px-6 py-3 rounded-xl text-sm transition">
                        How it works
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 flex justify-center lg:justify-end">
                <div class="bg-white p-8 rounded-3xl shadow-2xl border border-slate-100 text-slate-800 w-full max-w-md relative">
                    
                    <div class="absolute -top-6 -right-4 w-14 h-14 bg-slate-200 border-4 border-white rounded-full overflow-hidden shadow-md hidden sm:block">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Coach Bengkel Renang" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="p-2.5 bg-[#E6F0FA] rounded-xl text-[#032B53]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-extrabold text-[#032B53]">Track Child's Progress</h2>
                    </div>
                    
                    <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                        Masukkan ID Unik (Contoh: BR-XXX) yang diberikan oleh Mr Iqbal untuk melihat grafik kemampuan, absensi, dan jurnal latihan harian anak Anda.
                    </p>

                    @if(session('error'))
                        <div class="bg-red-50 text-red-600 text-xs p-3.5 rounded-xl mb-4 border border-red-200 font-semibold flex items-center space-x-2 shadow-sm animate-pulse">
                            <span>⚠️</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    <form action="{{ route('track.search') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" 
                                name="id_tracking" 
                                value="{{ old('id_tracking') }}"
                                placeholder="Masukkan ID (misal: BR-XXX)" 
                                class="w-full bg-[#E6F0FA] border-2 border-[#00A79D] pl-11 pr-4 py-3.5 rounded-2xl text-xs font-bold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase tracking-wide transition-all" 
                                required>
                        </div>
                        
                        @error('id_tracking')
                            <div class="bg-red-50 text-red-600 font-bold text-[11px] p-3 rounded-xl border border-red-100 text-center animate-pulse whitespace-pre-line">
                                ⚠ {{ $message }}
                            </div>
                        @enderror

                        <button type="submit" class="w-full bg-[#032B53] hover:bg-[#021d3a] text-white font-black py-4 rounded-2xl text-xs uppercase tracking-widest shadow-md transition-all flex items-center justify-center space-x-1 hover:shadow-lg cursor-pointer">
                            <span>Lihat Progress</span>
                            <span class="text-sm font-medium leading-none mb-0.5">→</span>
                        </button>
                    </form>

                    <script>
                            // Gunakan fetch latar belakang agar halaman landing page asli tidak melakukan reload/pindah
                            fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            })
                            .then(response => {
                                if (!response.ok) return response.json().then(err => { throw err; });
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Ambil isi HTML murni komponen kartu dari controller show
                                    return fetch(`/track/${data.id_tracking}`, {
                                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                    });
                                }
                            })
                            .then(res => res.text())
                            .then(html => {
                                // Suntikkan isi kartu ke dalam container, lalu nyalakan blurnya secara live!
                                document.getElementById('modal-content-container').innerHTML = html;
                                const modal = document.getElementById('progress-modal');
                                modal.classList.remove('hidden');
                                modal.classList.add('flex');
                            })
                            .catch(err => {
                                errorBox.innerText = '⚠ ' + (err.message || 'ID Tracking salah atau tidak terdaftar.');
                                errorBox.classList.remove('hidden');
                            });
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0] z-20 pointer-events-none">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="relative block w-full h-[65px] fill-[#F4F9FD] scale-x-105 scale-y-110 origin-bottom">
                <path d="M0,32L60,42.7C120,53,240,75,360,74.7C480,75,600,53,720,48C840,43,960,53,1080,58.7C1200,64,1320,64,1380,64L1440,64L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z"></path>
            </svg>
        </div>
    </header>

{{--
    <section class="bg-[#021F3C] text-white border-t border-blue-950 py-6">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-3 text-center gap-4">
            <div>
                <h4 class="text-xl sm:text-2xl font-extrabold text-[#FDB813]">200+</h4>
                <p class="text-[11px] sm:text-xs text-slate-400">Happy Students</p>
            </div>
            <div class="border-x border-blue-900">
                <h4 class="text-xl sm:text-2xl font-extrabold text-[#FDB813]">5★</h4>
                <p class="text-[11px] sm:text-xs text-slate-400">Average Rating</p>
            </div>
            <div>
                <h4 class="text-xl sm:text-2xl font-extrabold text-[#FDB813]">100%</h4>
                <p class="text-[11px] sm:text-xs text-slate-400">Trackable Progress</p>
            </div>
        </div>
    </section> --}}

    <section id="programs" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center space-y-2 mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-blue-600">What we offer</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#032B53]">Programs for Every Level</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-amber-50/40 p-8 rounded-3xl border border-amber-100 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                <div class="space-y-4">
                    <span class="bg-white text-xs font-bold px-3 py-1 rounded-md shadow-sm border text-slate-500 inline-block">Beginner</span>
                    <div class="text-3xl">🐣</div>
                    <h3 class="text-xl font-bold text-slate-900">Toddler Splash</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Pengenalan air dasar dan membangun rasa percaya diri anak di dalam kolam renang secara perlahan dengan suasana riang.</p>
                </div>
            </div>
            <div class="bg-white p-8 rounded-3xl border-2 border-teal-500 relative flex flex-col justify-between shadow-md">
                <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-teal-500 text-white text-[10px] font-extrabold px-4 py-1 rounded-full uppercase tracking-wider">★ Most Popular</span>
                <div class="space-y-4 mt-2">
                    <div class="text-3xl">🐬</div>
                    <h3 class="text-xl font-bold text-slate-900">Junior Swimmer</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Fokus pada pendalaman teknik 4 gaya dasar (bebas, dada, punggung, kupu-kupu) secara privat dan intensif.</p>
                </div>
            </div>
            <div class="bg-blue-50/40 p-8 rounded-3xl border border-blue-100 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                <div class="space-y-4">
                    <span class="bg-white text-xs font-bold px-3 py-1 rounded-md shadow-sm border text-slate-500 inline-block">Advanced</span>
                    <div class="text-3xl">🏆</div>
                    <h3 class="text-xl font-bold text-slate-900">Competitive Edge</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Perbaikan teknik, pengaturan napas efisien, latihan kecepatan, dan persiapan mental kompetisi/kejuaraan.</p>
                </div>
            </div>
        </div>
    </section>
    <div class="w-full overflow-hidden leading-[0] bg-[#F4F9FD] -mt-1">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="relative block w-full h-[60px] fill-[#032B53] scale-x-105 scale-y-110 origin-top">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>

    <section id="pricing" class="bg-[#032B53] text-white py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center space-y-2 mb-16">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-300">Investment</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold">Simple, Transparent Pricing</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch max-w-5xl mx-auto text-slate-800">
                <div class="bg-slate-900/40 text-white p-8 rounded-3xl border border-blue-900 flex flex-col justify-between shadow-lg">
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold">Registration Fee</h3>
                        <div class="flex items-baseline">
                            <span class="text-3xl font-extrabold text-[#FDB813]">Rp 250k</span>
                            <span class="text-xs text-slate-300 ml-1">/sekali daftar</span>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed border-b border-blue-900 pb-4">Biaya awal pendaftaran keanggotaan Gajah Depa Akuatik Sumedang.</p>
                        <ul class="space-y-3 text-xs text-slate-200">
                            <li class="flex items-center space-x-2">
                                <span class="text-[#FDB813]">✓</span> <span>Include Papan Renang</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-[#FDB813]">✓</span> <span>Include Pullboy</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-[#FDB813]">✓</span> <span>Include Jersey Eksklusif</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span class="text-[#FDB813]">✓</span> <span>Diskon Tiket Masuk Kolam</span>
                            </li>
                        </ul>
                    </div>
                    <a href="https://wa.me/089526772978" class="bg-blue-950 hover:bg-blue-900 text-white font-bold text-center py-3 rounded-xl text-xs mt-8 block border border-blue-800 transition">Hubungi WA</a>
                </div>

                <div class="bg-[#FDB813] p-8 rounded-3xl flex flex-col justify-between shadow-xl relative scale-100 lg:scale-105 z-10">
                    <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#032B53] text-white text-[9px] font-extrabold px-4 py-1 rounded-full uppercase tracking-wider">Per Sesi</span>
                    <div class="space-y-4 text-[#032B53]">
                        <h3 class="text-xl font-bold uppercase tracking-wide">Sesi Latihan</h3>
                        <div class="flex items-baseline">
                            <span class="text-4xl font-black">Rp 60k</span>
                            <span class="text-xs font-bold ml-1">/pertemuan</span>
                        </div>
                        <p class="text-xs font-medium text-amber-950 leading-relaxed border-b border-amber-400 pb-4">Bayar per kehadiran.</p>
                        <ul class="space-y-3 text-xs font-bold">
                            <li class="flex items-center space-x-2">
                                <span>✓</span> <span>1-on-1 Full Private Session</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span>✓</span> <span>Skill Tech Assessment harian</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <span>✓</span> <span>Digital Progress Tracking Record</span>
                            </li>
                        </ul>
                    </div>
                    <a href="https://wa.me/089526772978" class="bg-[#032B53] hover:bg-blue-900 text-white font-bold text-center py-3 rounded-xl text-xs mt-8 block shadow-md transition">Book Now</a>
                </div>

                <div class="bg-slate-900/40 text-white p-8 rounded-3xl border border-blue-900 flex flex-col justify-between shadow-lg">
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold">Membership Info</h3>
                        <div class="text-sm font-bold text-amber-400">Eksklusif Terbatas</div>
                        <p class="text-xs text-slate-300 leading-relaxed border-b border-blue-900 pb-4">Harap diperhatikan kembali syarat utama keanggotaan Bengkel Renang ini.</p>
                        <ul class="space-y-3 text-xs text-slate-300">
                            <li class="flex items-start space-x-2">
                                <span class="text-red-400 mt-0.5">ℹ</span> 
                                <span>Hanya ditujukan untuk pra-member dan member <strong>Club Gajah Depa Akuatik Sumedang</strong>.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <span class="text-teal-400 mt-0.5">ℹ</span> 
                                <span>Jadwal privat dikoordinasikan langsung bersama Mr Iqbal melalui WhatsApp.</span>
                            </li>
                        </ul>
                    </div>
                    <a href="https://wa.me/089526772978" class="bg-blue-950 hover:bg-blue-900 text-white font-bold text-center py-3 rounded-xl text-xs mt-8 block border border-blue-800 transition">Ambil Kesempatan 1x Trial</a>
                </div>
            </div>
        </div>
    </section>
    <div class="w-full overflow-hidden leading-[0] bg-[#032B53] -mt-1">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="relative block w-full h-[60px] fill-[#F4F9FD] scale-x-105 scale-y-110 origin-top">
            <path d="M0,96L60,85.3C120,75,240,53,360,48C480,43,600,53,720,64C840,75,960,85,1080,80C1200,75,1320,53,1380,42.7L1440,32L1440,120L1380,120C1320,120,1200,120,1080,120C960,120,840,120,720,120C600,120,480,120,360,120C240,120,120,120,60,120L0,120Z"></path>
        </svg>
    </div>

    <section id="how-it-works" class="py-20 px-6 max-w-7xl mx-auto">
        <div class="text-center space-y-2 mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-blue-600">Simple Process</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#032B53]">3 Steps to Dive In</h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto">Mulai belajar renang privat bersama Mr Iqbal.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-4 relative">
                <div class="w-12 h-12 bg-teal-500 text-white rounded-xl flex items-center justify-center text-lg font-bold shadow-md">01</div>
                <h3 class="text-lg font-bold text-slate-900">Book via WhatsApp</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Hubungi Mr Iqbal untuk menentukan jadwal latihan, hari, dan lokasi kolam.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-4 relative">
                <div class="w-12 h-12 bg-[#FDB813] text-[#032B53] rounded-xl flex items-center justify-center text-lg font-bold shadow-md">02</div>
                <h3 class="text-lg font-bold text-slate-900">Get Student ID</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Setelah pendaftaran dikonfirmasi, pelatih akan diberikan tracking progress ID (contoh, BR-A83K).</p>
            </div>
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-4 relative">
                <div class="w-12 h-12 bg-[#032B53] text-white rounded-xl flex items-center justify-center text-lg font-bold shadow-md">03</div>
                <h3 class="text-lg font-bold text-slate-900">Track Progress Online</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Masukkan ID tersebut di box 'Tracking Child's Progress' untuk melihat progres kemampuan anak.</p>
            </div>
        </div>
    </section>

    <section class="relative bg-cover bg-center py-24 text-center text-white" style="background-image: linear-gradient(rgba(3, 43, 83, 0.85), rgba(3, 43, 83, 0.85)), url('{{ asset('images/gambar2.jpeg') }}');">
        <div class="max-w-4xl mx-auto px-6 space-y-6">
            <h2 class="text-3xl sm:text-4xl font-extrabold">Ready to Make a Splash?</h2>
            <p class="text-slate-300 max-w-md mx-auto text-sm">Konsultasikan kemampuan renang awal anak Anda kepada Mr Iqbal secara gratis.</p>
            <a href="https://wa.me/089526772978" target="_blank" class="inline-flex bg-[#FDB813] hover:bg-[#e0a20b] text-[#032B53] font-bold px-8 py-3.5 rounded-xl text-sm space-x-2 shadow-xl transition">
                <span>Start Today — Message Us</span>
            </a>
        </div>
    </section>

    <!-- 8. FOOTER SECTION (3-COLUMN PERFECT ALIGNMENT) -->
    <footer class="bg-[#021F3C] text-slate-400 py-12 px-6 border-t border-blue-950 text-xs">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 items-center gap-6 text-center md:text-left">
            
            <!-- KOLOM 1 (KIRI): Logo Bulat Berbingkai Mas & Nama Brand -->
            <div class="flex items-center justify-center md:justify-start space-x-3">
                <div class="w-9 h-9 rounded-full border border-[#FDB813] overflow-hidden flex items-center justify-center bg-slate-800 shrink-0 shadow-sm">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Bengkel Renang" class="w-full h-full object-cover">
                </div>
                <span class="font-bold text-white text-sm tracking-wide">Bengkel Renang</span>
            </div>

            <!-- KOLOM 2 (TENGAH): Tagline Utama (Tepat Berada di Tengah Halaman) -->
            <div class="text-slate-300 font-medium text-center md:text-center tracking-normal">
                Private swimming lessons · Progress tracked every session
            </div>

            <!-- KOLOM 3 (KANAN): Deretan Ikon Sosial Media Efek Hover Kuning Emas -->
            <div class="flex items-center justify-center md:justify-end space-x-5">
                <!-- 1. Instagram Logo -->
                <a href="https://instagram.com/bengkelrenang" target="_blank" class="text-slate-400 hover:text-[#FDB813] transition duration-200 transform hover:scale-110" title="Instagram @bengkelrenang">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69 0 7.051c-.059 1.282-.073 1.689-.073 4.949 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </a>

                <!-- 2. TikTok Logo -->
                <a href="https://tiktok.com/@bengkelrenang" target="_blank" class="text-slate-400 hover:text-[#FDB813] transition duration-200 transform hover:scale-110" title="TikTok @bengkelrenang">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.525.02c1.31-.03 2.61-.01 3.91-.02.08 1.53.63 3.02 1.62 4.17 1.22 1.32 2.97 2.02 4.75 2.07v3.9c-1.92-.05-3.79-.81-5.18-2.14-.07-.07-.12-.14-.21-.24v6.8c.03 2.11-.64 4.22-1.97 5.85-1.91 2.4-5.06 3.63-8.08 3.08-3.14-.49-5.83-2.84-6.6-5.96-.86-3.23.23-6.85 2.82-8.89 1.94-1.57 4.54-2.13 6.98-1.55v4.03c-1.38-.45-2.94-.13-4.01.81-1.24 1.01-1.74 2.76-1.19 4.28.53 1.56 2.11 2.61 3.76 2.5 1.76.02 3.34-1.23 3.64-2.97.09-.45.09-.91.09-1.36V0z"/>
                    </svg>
                </a>

                <!-- 3. WhatsApp Logo -->
                <a href="https://wa.me/089526772978" target="_blank" class="text-slate-400 hover:text-[#FDB813] transition duration-200 transform hover:scale-110" title="Hubungi WhatsApp">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.004 22c-2.007-.001-3.982-.51-5.735-1.486L0 24l1.687-6.163C.646 16.033.1 13.988.101 11.891 1.01 5.348 5.347 0 11.898 0c3.179.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.239 3.482 8.42-.003 6.55-5.339 11.896-11.893 11.896zm6.59-4.846c1.666.988 3.311 1.485 5.308 1.486 5.589 0 10.134-4.52 10.137-10.074.001-2.692-1.047-5.222-2.951-7.127C17.237 2.533 14.711 1.48 12.003 1.48c-5.594 0-10.142 4.519-10.145 10.075a9.9 9.9 0 0 0 1.523 5.251l-.973 3.55 3.64-.954zm10.512-7.23c-.279-.14-1.651-.814-1.906-.907-.256-.094-.442-.14-.628.14-.186.279-.717.907-.88 1.093-.163.186-.326.21-.605.07-1.127-.563-1.941-.973-2.695-2.262-.196-.336.196-.312.56-.1.326-.175.442-.21.605-.489.163-.279.081-.523-.041-.663-.122-.14-1.025-2.47-1.404-3.38-.37-.889-.744-.768-.1025-.772h-.88c-.279 0-.733.105-1.117.523-.384.419-1.466 1.433-1.466 3.493 0 2.06 1.5 4.048 1.71 4.328.209.279 2.953 4.51 7.154 6.326 2.457 1.063 3.393 1.157 4.606.977 1.137-.17 2.47-.1 3.238-.928.767-.828.767-1.542.535-1.682-.232-.14-.814-.407-1.093-.547z"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Bagian Copyright Bawah -->
        <div class="max-w-7xl mx-auto border-t border-blue-900/50 mt-8 pt-6 text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2 text-center sm:text-left">
            <div>
                &copy; 2026 Bengkel Renang. All rights reserved.
            </div>

            <div>
                <a href="{{ route('coach.login') }}" class="text-slate-600 hover:text-[#FDB813] font-medium transition duration-200 text-[11px] uppercase tracking-wider">
                    Mr Iqbal's
                </a> 
            </div> 
        </div>
    </footer>
</body>
</html>
