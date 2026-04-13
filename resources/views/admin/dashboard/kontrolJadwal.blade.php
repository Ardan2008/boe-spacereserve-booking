<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            overflow-x: hidden; 
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
                                Kontrol Jadwal
                            </span>
                            
                            <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#1265A8] border border-blue-100 uppercase tracking-widest animate-pulse">
                                Live
                            </span>
                        </h2>
                        
                        <p class="mt-1 text-slate-400 text-xs md:text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#1265A8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Selamat datang di <span class="text-slate-600 font-semibold mx-1">kontrol jadwal</span>.
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

        <section class="mb-8 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="p-1.5 bg-red-50 rounded-lg">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </span>
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-widest">
                    Block Jadwal
                </h3>
            </div>

            @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-500">Fasilitas</label>
                    <select name="lapangan_id" id="block_lapangan_id" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs outline-none focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer font-medium text-slate-600" required>
                        <option value="" disabled selected>Pilih Fasilitas</option>
                        <option value="1">Asrama Tunggul Ametung</option>
                        <option value="2">Asrama Ken Umang</option>
                        <option value="3">Asrama Kendedes</option>
                        <option value="4">Asrama Ken Arok</option>
                        <option value="5">Asrama Kertajaya</option>
                        <option value="6">Aula BOE</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-500">Tanggal</label>
                    <input type="date" name="tanggal" id="block_tanggal"
                        class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs" required>
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-500">Sesi Waktu</label>
                    <select name="sesi_waktu" id="block_sesi_waktu" class="w-full mt-1 bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer" required>
                        <option value="" disabled selected>Pilih Sesi Penggunaan</option>
                        <option value="pagi">Sesi Pagi (08:00 - 12:00)</option>
                        <option value="siang">Sesi Siang (13:00 - 17:00)</option>
                        <option value="malam">Sesi Malam (19:00 - 22:00)</option>
                        <option value="full_day">Full Day (08:00 - 17:00)</option>
                        <option value="full_event">Full Event (08:00 - 21:00)</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl text-xs font-bold">
                        Block Jadwal
                    </button>
                </div>
            </form>
            @endif
        </section>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Fasilitas</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sesi</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                            <th class="p-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bookingTable" class="divide-y divide-slate-100">
                        <tr class="facility-row hover:bg-slate-50/80 transition-colors">
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">Internal BOE</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Penyewa</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Asrama Tunggul Ametung</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs text-slate-500">10 Mar 2026</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Sesi Pagi (08:00 - 12:00)</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-red-50 text-red-600 border border-red-100">Blocked</span>
                            </td>
                            <td class="p-4 text-center">
                                @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                                <button type="button" 
                                        onclick="openDeleteModal(this)" 
                                        class="group p-2.5 bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-xl transition-all duration-300 border border-slate-100 hover:border-red-100 shadow-sm" 
                                        title="Hapus Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </td>
                        </tr>

                        <tr class="facility-row hover:bg-slate-50/80 transition-colors">
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">Internal BOE</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Penyewa</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Asrama Ken Umang</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs text-slate-500">14 Mar 2026</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Sesi Siang (13:00 - 17:00)</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-red-50 text-red-600 border border-red-100">Blocked</span>
                            </td>
                            <td class="p-4 text-center">
                                @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                                <button type="button" 
                                        onclick="openDeleteModal(this)" 
                                        class="group p-2.5 bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-xl transition-all duration-300 border border-slate-100 hover:border-red-100 shadow-sm" 
                                        title="Hapus Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </td>
                        </tr>

                        <tr class="facility-row hover:bg-slate-50/80 transition-colors">
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">Internal BOE</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Penyewa</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Aula BOE</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs text-slate-500">14 Mar 2026</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Sesi Malam (19:00 - 22:00)</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-red-50 text-red-600 border border-red-100">Blocked</span>
                            </td>
                            <td class="p-4 text-center">
                                @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                                <button type="button" 
                                        onclick="openDeleteModal(this)" 
                                        class="group p-2.5 bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-xl transition-all duration-300 border border-slate-100 hover:border-red-100 shadow-sm" 
                                        title="Hapus Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </td>
                        </tr>

                        <tr class="facility-row hover:bg-slate-50/80 transition-colors">
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">Internal BOE</span>
                                    <span class="text-[10px] text-slate-400 font-medium">Penyewa</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Aula BOE</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs text-slate-500">12 Mar 2026</span>
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-semibold text-slate-600">Full Day (08:00 - 17:00)</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase bg-red-50 text-red-600 border border-red-100">Blocked</span>
                            </td>
                            <td class="p-4 text-center">
                                @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                                <button type="button" 
                                        onclick="openDeleteModal(this)" 
                                        class="group p-2.5 bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-600 rounded-xl transition-all duration-300 border border-slate-100 hover:border-red-100 shadow-sm" 
                                        title="Hapus Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        
        <div class="relative bg-white rounded-3xl p-8 w-full max-w-sm shadow-2xl transform transition-all scale-95 border border-slate-100">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6">
                    <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center animate-pulse">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-black text-slate-800">Hapus Jadwal?</h3>
                <p class="text-sm text-slate-500 mt-3 leading-relaxed">Tindakan ini akan menghapus data secara permanen dari sistem dashboard Anda.</p>
            </div>
            
            <div class="mt-8 flex gap-3">
                <button onclick="closeModal()" class="flex-1 px-5 py-3.5 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all active:scale-95">
                    Batal
                </button>
                <button onclick="executeDelete()" class="flex-1 px-5 py-3.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-2xl font-bold shadow-lg shadow-red-200 hover:shadow-red-300 transition-all active:scale-95">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <div id="toastSuccess" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[110] hidden">
        <div class="bg-slate-900 text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-slate-700/50">
            <div class="bg-green-500 rounded-full p-1">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-sm font-bold tracking-wide">Data berhasil dihapus dari tampilan</span>
        </div>
    </div>

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
        let rowToDelete = null;

        function openDeleteModal(btn) {
            rowToDelete = btn.closest('tr'); // Ambil baris tabelnya
            const modal = document.getElementById('deleteModal');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.querySelector('.transform').classList.add('scale-95');
            modal.querySelector('.transform').classList.remove('scale-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        function executeDelete() {
            closeModal();
            
            if (rowToDelete) {
                rowToDelete.style.transition = "all 0.4s ease";
                rowToDelete.style.opacity = "0";
                rowToDelete.style.transform = "scale(0.95)";
                
                setTimeout(() => {
                    rowToDelete.remove();
                    showToast();
                }, 400);
            }
        }

        function showToast() {
            const toast = document.getElementById('toastSuccess');
            toast.classList.remove('hidden');
            toast.classList.add('animate-bounce-short'); 
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Back to Top Logic
        const backToTopBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove('translate-y-20', 'opacity-0');
                backToTopBtn.classList.add('translate-y-0', 'opacity-100');
            } else {
                backToTopBtn.classList.add('translate-y-20', 'opacity-0');
                backToTopBtn.classList.remove('translate-y-0', 'opacity-100');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>