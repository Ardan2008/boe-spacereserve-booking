<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Sport Space | Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            overflow-x: hidden; 
        }

        .ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        @keyframes shimmer {
            100% { transform: translateX(250%); }
        }
    </style>
</head>
<body class="flex min-h-screen">
    @include('admin.dashboard.layouts.sidebar')

    <main class="flex-1 md:ml-64 p-6 md:p-10">
        <header class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                
                <div class="flex items-center justify-between md:justify-start gap-4 flex-1">
                    <div class="relative">
                        <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-[#1265A8] to-transparent rounded-full opacity-50 hidden md:block"></div>
                        
                        <h2 class="text-2xl md:text-3xl font-black tracking-tight text-slate-800 flex items-center gap-3">
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-[#1265A8] to-[#4292DC]">
                                Data Fasilitas
                            </span>
                            
                            <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#1265A8] border border-blue-100 uppercase tracking-widest animate-pulse">
                                Live
                            </span>
                        </h2>
                        
                        <p class="mt-1 text-slate-400 text-xs md:text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#1265A8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Selamat datang di <span class="text-slate-600 font-semibold mx-1">manajemen data fasilitas</span>.
                        </p>
                    </div>

                    <button onclick="toggleSidebar()" 
                        class="md:hidden p-3 bg-white rounded-xl border border-slate-100 text-[#1265A8] 
                        transition-all duration-300 ease-out
                        hover:bg-blue-50 hover:border-blue-200 hover:text-[#4292DC] 
                        hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] 
                        active:scale-95 group">
                        
                        <svg class="w-6 h-6 transition-transform duration-300 group-hover:rotate-180" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
                
                {{-- search --}}
                @include('admin.dashboard.search.searchBar')
                
            </div>
        </header>

        @php
            $facilities = [
                ['name' => 'Asrama Tunggul Ametung', 'image' => '/image/pictures/booking/tunggul_ametung/ametung.png', 'location' => 'BOE-Space Reserve'],
                ['name' => 'Asrama Ken Umang', 'image' => '/image/pictures/booking/ken_umang/umang.png', 'location' => 'BOE-Space Reserve'],
                ['name' => 'Asrama Kendedes', 'image' => '/image/pictures/booking/kendedes/dedes.png', 'location' => 'BOE-Space Reserve'],
                ['name' => 'Asrama Ken Arok', 'image' => '/image/pictures/booking/ken_arok/arok.png', 'location' => 'BOE-Space Reserve'],
                ['name' => 'Asrama Kertajaya', 'image' => '/image/pictures/booking/kertajaya/jaya.png', 'location' => 'BOE-Space Reserve'],
                ['name' => 'Aula BOE', 'image' => '/image/pictures/booking/aula/la.png', 'location' => 'BOE-Space Reserve'],
            ];
        @endphp

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <section x-data="{ openPreview: false, previewImg: '', previewTitle: '' }">
            <div class="flex items-center justify-between mb-8">
                <div class="flex flex-col gap-1.5 p-2">
                    <h3 class="text-2xl font-extrabold tracking-tight text-slate-800 leading-none">
                        Daftar Fasilitas
                    </h3>
                    
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1265A8] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1265A8]"></span>
                        </span>
                        <p class="text-[13px] font-medium text-slate-500 uppercase tracking-wider">
                            Total <span class="text-slate-900 font-bold">6</span> Fasilitas <span class="lowercase">tersedia</span>
                        </p>
                    </div>
                </div>
                <a href="/admin/dashboard/create/createFasilitas" id="btnTambah" onclick="handleLoading(event, this)" class="group relative inline-flex items-center gap-2 px-8 py-3.5 bg-[#1265A8] text-white rounded-2xl font-bold text-sm transition-all duration-300 hover:bg-[#0d4d82] hover:shadow-[0_10px_20px_-10px_rgba(18,101,168,0.5)] active:scale-95 overflow-hidden">
                    <div class="absolute inset-0 w-1/2 h-full bg-white/10 skew-x-[-25deg] -translate-x-full group-hover:animate-[shimmer_0.75s_infinite]"></div>
                    
                    <div class="relative flex items-center gap-2">
                        <svg id="iconPlus" class="w-5 h-5 transition-all duration-500 group-hover:rotate-180" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>

                        <svg id="iconLoading" class="hidden w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        
                        <span id="btnText">Tambah Fasilitas</span>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($facilities as $item)
                <div class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    
                    {{-- Bagian Gambar dengan Hover Zoom & Eye Icon --}}
                    <div class="relative h-52 overflow-hidden cursor-pointer" 
                        @click="openPreview = true; previewImg = '{{ $item['image'] }}'; previewTitle = '{{ $item['name'] }}'">
                        
                        <img src="{{ $item['image'] }}" 
                            alt="{{ $item['name'] }}" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125"> <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white/20 backdrop-blur-md p-3 rounded-full border border-white/50">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="mb-6">
                            <h4 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-[#1265A8] transition-colors">
                                {{ $item['name'] }}
                            </h4>
                            <p class="text-xs uppercase tracking-[0.15em] text-slate-500 font-medium">
                                {{ $item['location'] }}
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-50">
                            <button type="button" 
                                onclick="confirmDelete(this)" 
                                class="p-3 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            <a href="/admin/dashboard/edit/editFasilitas" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-200 text-slate-600 hover:border-[#1265A8] hover:text-[#1265A8] transition-all font-medium text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- MODAL PREVIEW (Akan muncul saat gambar diklik) --}}
            <div x-show="openPreview" 
                @keydown.escape.window="openPreview = false"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-10"
                x-cloak>
                
                {{-- Layer Latar Belakang --}}
                <div class="absolute inset-0 bg-black/70 backdrop-blur-xl cursor-pointer" 
                    @click="openPreview = false"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                </div>

                {{-- Layer Konten (Gambar & Judul) --}}
                <div class="relative z-10 w-full max-w-5xl flex flex-col items-center pointer-events-none"
                    x-show="openPreview"
                    x-transition:enter="transition ease-out duration-300 delay-75"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    
                    {{-- Bingkai Gambar (pointer-events-auto agar gambar sendiri tidak 'tembus' klik) --}}
                    <div class="bg-white p-3 rounded-[2.5rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.6)] overflow-hidden pointer-events-auto">
                        <img :src="previewImg" 
                            class="max-h-[70vh] w-auto rounded-[1.8rem] object-contain" 
                            alt="Preview">
                    </div>
                    
                    {{-- Info Box --}}
                    <div class="mt-8 text-center pointer-events-auto">
                        <div class="inline-block px-8 py-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl">
                            <h4 x-text="previewTitle" class="text-white text-2xl font-black tracking-tight uppercase"></h4>
                        </div>
                        
                        {{-- Petunjuk Visual --}}
                        <div class="mt-6 flex items-center justify-center gap-3 opacity-40">
                            <div class="w-10 h-[1px] bg-white"></div>
                            <p class="text-white text-[9px] font-medium tracking-[0.2em] uppercase">Klik di mana saja untuk kembali</p>
                            <div class="w-10 h-[1px] bg-white"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </main>

    {{-- Back to Top Button --}}
    <button id="backToTop" 
        class="fixed bottom-8 right-8 z-50 p-4 rounded-2xl bg-white/80 backdrop-blur-lg border border-slate-200 text-[#1265A8] shadow-2xl transition-all duration-500 translate-y-20 opacity-0 hover:bg-[#1265A8] hover:text-white hover:-translate-y-1 active:scale-90 group"
        aria-label="Back to Top">
        
        <div class="relative">
            <div class="absolute inset-0 bg-blue-400 blur-lg opacity-0 group-hover:opacity-40 transition-opacity"></div>
            
            <svg class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path>
            </svg>
        </div>
    </button>

    <script>
        function handleLoading(event, element) {
            // Mencegah redirect instan
            event.preventDefault();
            const url = element.getAttribute('href');
            
            const iconPlus = element.querySelector('#iconPlus');
            const iconLoading = element.querySelector('#iconLoading');
            const btnText = element.querySelector('#btnText');

            // Ubah State Tombol
            iconPlus.classList.add('hidden');
            iconLoading.classList.remove('hidden');
            btnText.innerText = 'Memuat...';
            element.classList.add('opacity-90', 'cursor-not-allowed');
            element.style.pointerEvents = 'none'; // Mencegah klik ganda

            setTimeout(() => {
                window.location.href = url;
            }, 600); 
        }

        function confirmDelete(button) {
            // Mencari card pembungkus terdekat (elemen dengan class 'group')
            const card = button.closest('.group');
            // Mengambil nama fasilitas dari h4 di dalam card tersebut
            const title = card.querySelector('h4').innerText;

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: `Data "${title}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444', 
                cancelButtonColor: '#64748B', 
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true, 
                customClass: {
                    popup: 'rounded-[2rem] font-sans',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Efek visual menghilang
                    card.style.transition = 'all 0.5s ease';
                    card.classList.add('scale-90', 'opacity-0');
                    
                    setTimeout(() => {
                        card.remove(); // Hapus elemen dari DOM
                        
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data fasilitas berhasil dibersihkan.',
                            icon: 'success',
                            iconColor: '#10B981',
                            timer: 1500,
                            timerProgressBar: true, // Menampilkan garis jalan di bawah
                            showConfirmButton: false,
                            borderRadius: '1.5rem',
                            customClass: {
                                popup: 'rounded-[2rem] font-sans',
                                timerProgressBar: 'bg-emerald-500' 
                            }
                        });
                    }, 500);
                }
            });
        }

        document.getElementById('btnTambah').addEventListener('click', function(e) {
            const btn = this;
            const icon = document.getElementById('iconPlus');
            const spinner = document.getElementById('spinner');
            const text = document.getElementById('btnText');

            // efek ripple
            const ripple = document.createElement('span');
            const rect = btn.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            ripple.classList.add('ripple');
            
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);

            // efek loading
            e.preventDefault(); 
            const targetUrl = btn.getAttribute('href');

            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            text.innerText = 'Memuat...';
            btn.classList.add('opacity-80', 'cursor-wait');

            setTimeout(() => {
                window.location.href = targetUrl;
            }, 500); 
        });

        // Ambil semua elemen dengan class btn-edit
        const editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Stop pindah halaman instan
                
                const targetUrl = this.getAttribute('href');
                const content = this.querySelector('.button-content');
                const spinner = this.querySelector('.loading-spinner');

                // Tampilkan loading
                content.classList.add('hidden');
                spinner.classList.remove('hidden');
                this.classList.add('opacity-70', 'cursor-wait');

                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 600);
            });
        });

        // Logika Back to Top
        const backToTopBtn = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                // Tampilkan tombol saat scroll lebih dari 400px
                backToTopBtn.classList.remove('translate-y-20', 'opacity-0');
                backToTopBtn.classList.add('translate-y-0', 'opacity-100');
            } else {
                // Sembunyikan tombol saat di atas
                backToTopBtn.classList.add('translate-y-20', 'opacity-0');
                backToTopBtn.classList.remove('translate-y-0', 'opacity-100');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>