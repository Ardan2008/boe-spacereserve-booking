<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BOE-Sport Space | Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            overflow-x: hidden; 
        }

        #sidebar { 
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
        }

        #overlay { 
            display: block; 
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s;
            backdrop-filter: blur(0px);
        }

        #overlay.active { 
            opacity: 1;
            visibility: visible;
            backdrop-filter: blur(4px); 
        }

        .sidebar-active { 
            background: rgba(18, 101, 168, 0.1); 
            border-right: 4px solid #1265A8; 
            color: #1265A8; 
        }

        .btn-close-sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-close-sidebar:hover {
            background-color: #fee2e2; 
            color: #ef4444; 
            transform: rotate(90deg);
        }
    </style>
</head>
<body>
    <div id="sidebar-overlay" 
        onclick="toggleSidebar()" 
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden opacity-0 transition-opacity duration-300 md:hidden">
    </div>
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 z-30 md:pointer-events-none"></div>

    <aside id="sidebar-container" class="w-64 bg-white border-r border-slate-100 flex flex-col fixed h-full z-40 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0" id="sidebar">
        <div class="p-8 relative">
            <h1 class="text-2xl font-black text-[#1265A8] leading-tight tracking-tighter">
                BOE-Sport<br><span class="text-slate-400">Space</span>
            </h1>

            <button onclick="toggleSidebar()" 
                class="md:hidden absolute top-6 right-2 btn-close-sidebar w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl shadow-sm border border-slate-100"
                aria-label="Close Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <p class="px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Main Menu</p>
            
            <a href="/admin/dashboard/master" class="{{ request()->is('admin/dashboard/master') ? 'sidebar-active' : 'text-slate-500 hover:text-[#1265A8] hover:bg-slate-50' }} flex items-center px-4 py-3 rounded-xl font-bold transition-all">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            <a href="/admin/dashboard/dataFasilitas" class="{{ request()->is('admin/dashboard/dataFasilitas') ? 'sidebar-active' : 'text-slate-500 hover:text-[#1265A8] hover:bg-slate-50' }} flex items-center px-4 py-3 rounded-xl transition-all font-semibold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Data Fasilitas
            </a>

            <a href="/admin/dashboard/dataHargaSewa" class="{{ request()->is('admin/dashboard/dataHargaSewa') ? 'sidebar-active' : 'text-slate-500 hover:text-[#1265A8] hover:bg-slate-50' }} flex items-center px-4 py-3 rounded-xl transition-all font-semibold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Data Harga Sewa
            </a>

            <a href="/admin/dashboard/dataPenyewa" class="{{ request()->is('admin/dashboard/dataPenyewa') ? 'sidebar-active' : 'text-slate-500 hover:text-[#1265A8] hover:bg-slate-50' }} flex items-center px-4 py-3 rounded-xl transition-all font-semibold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Data Penyewa
            </a>

            <a href="/admin/dashboard/kontrolJadwal" class="{{ request()->is('admin/dashboard/kontrolJadwal') ? 'sidebar-active' : 'text-slate-500 hover:text-[#1265A8] hover:bg-slate-50' }} flex items-center px-4 py-3 rounded-xl transition-all font-semibold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Kontrol Jadwal
            </a>

            <a href="/admin/dashboard/jadwalBooking" class="{{ request()->is('admin/dashboard/jadwalBooking') ? 'sidebar-active' : 'text-slate-500 hover:text-[#1265A8] hover:bg-slate-50' }} flex items-center px-4 py-3 rounded-xl transition-all font-semibold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Jadwal Booking
            </a>

            <a href="/admin/dashboard/historyBooking" class="{{ request()->is('admin/dashboard/historyBooking') ? 'sidebar-active' : 'text-slate-500 hover:text-[#1265A8] hover:bg-slate-50' }} flex items-center px-4 py-3 rounded-xl transition-all font-semibold">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                History Booking
            </a>

            <div class="pt-4 mt-4 border-t border-slate-50">
                <a href="javascript:void(0)" onclick="confirmLogout(this)" id="btnLogout" class="flex items-center px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition-all font-bold group relative overflow-hidden">
                    <svg id="logoutSpinner" class="hidden animate-spin h-5 w-5 mr-3 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <svg id="logoutIcon" class="w-5 h-5 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    
                    <span id="logoutText">Keluar Sistem</span>
                </a>
            </div>
        </nav>

        <div class="p-6 mt-auto border-t border-slate-50">
            <div class="flex items-center gap-3 mb-4">
                <img src="/image/logo/tutwuri-logo.svg" class="w-8 h-8 opacity-80" alt="Logo">
                <p class="text-[10px] leading-tight text-slate-400 font-medium">Powered By<br><span class="text-slate-600 font-bold uppercase">BBPPMPV BOE MALANG</span></p>
            </div>
            <p class="text-[10px] text-slate-400">&copy; 2026 BOE. All Rights Reserved.</p>
        </div>
    </aside>

    <script>
        // Sidebar Toggle Logic
        function toggleSidebar() {
            const sidebar = document.querySelector('aside') || document.getElementById('sidebar-container');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (!sidebar || !overlay) return;

            // Periksa apakah sidebar sedang tertutup
            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                // MUNCULKAN SIDEBAR
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                
                // MUNCULKAN OVERLAY (SMOOTH)
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100', 'pointer-events-auto');
                
                // Kunci scroll layar utama
                document.body.style.overflow = 'hidden';
            } else {
                // SEMBUNYIKAN SIDEBAR
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                
                // SEMBUNYIKAN OVERLAY (SMOOTH)
                overlay.classList.remove('opacity-100', 'pointer-events-auto');
                overlay.classList.add('opacity-0', 'pointer-events-none');
                
                // Aktifkan kembali scroll
                document.body.style.overflow = 'auto';
            }
        }

        // Fungsi Logout
        function confirmLogout(element) {
            const icon = document.getElementById('logoutIcon');
            const spinner = document.getElementById('logoutSpinner');
            const text = document.getElementById('logoutText');

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Keluar Sistem?',
                    text: "Anda harus login kembali untuk mengakses dashboard.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', 
                    cancelButtonColor: '#cbd5e1',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => { 
                    if (result.isConfirmed) {
                        startLogoutLoading(element, icon, spinner, text);
                    } 
                });
            } else {
                if(confirm("Keluar dari sistem?")) {
                    startLogoutLoading(element, icon, spinner, text);
                }
            }
        }

        function startLogoutLoading(btn, icon, spinner, text) {
            // Nonaktifkan klik
            btn.style.pointerEvents = 'none';
            
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            
            // Ubah Teks
            text.innerText = "Keluar...";
            btn.classList.add('bg-red-50');

            setTimeout(() => {
                window.location.href = '/';
            }, 800);
        }
    </script>
</body>
</html>