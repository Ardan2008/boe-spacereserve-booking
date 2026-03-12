<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            overflow-x: hidden; 
        }

        /* Menghilangkan scrollbar tapi tetap bisa di-scroll di tabel mobile */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        .facility-row {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Overlay untuk mobile saat sidebar terbuka */
        #sidebar-overlay {
            display: none;
        }
        body.sidebar-open #sidebar-overlay {
            display: block;
        }

        .filter-btn.active {
            background-color: #1265A8;
            color: white;
            border-color: #1265A8;
            box-shadow: 0 10px 20px -5px rgba(18, 101, 168, 0.4);
        }

        .facility-row {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="flex min-h-screen">
    @include('admin.dashboard.layouts.sidebar')

    <main class="flex-1 w-full md:ml-64 p-4 md:p-10 transition-all duration-500 min-h-screen">
        <header class="mb-8 md:mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center justify-between md:justify-start gap-4 flex-1">
                    <div class="relative">
                        <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-[#1265A8] to-transparent rounded-full opacity-50 hidden md:block"></div>
                        <h2 class="text-2xl md:text-3xl font-black tracking-tight text-slate-800 flex items-center gap-3">
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-[#1265A8] to-[#4292DC]">
                                Data Penyewa
                            </span>
                            <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#1265A8] border border-blue-100 uppercase tracking-widest animate-pulse">
                                Live
                            </span>
                        </h2>
                        <p class="mt-1 text-slate-400 text-xs md:text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#1265A8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Selamat datang di <span class="text-slate-600 font-semibold mx-1">manajemen data penyewa</span>.
                        </p>
                    </div>

                    <button onclick="toggleSidebar()" class="md:hidden p-3 bg-white rounded-xl border border-slate-100 text-[#1265A8] hover:bg-blue-50 transition-all active:scale-95 group">
                        <svg class="w-6 h-6 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                @include('admin.dashboard.search.searchBar')
            </div>
        </header>

        <?php
        $myData = [
            ['no' => '01', 'nama' => 'Yanto Sholeh', 'whatsapp' => '08934678010', 'email' => 'yanto.sholeh76@gmail.com', 'facility' => 'Asrama Tunggul Ametung'],
            ['no' => '02', 'nama' => 'Siti Aminah', 'whatsapp' => '08123456789', 'email' => 'siti.aminah34@gmail.com', 'facility' => 'Asrama Ken Umang'],
            ['no' => '03', 'nama' => 'Budi Santoso', 'whatsapp' => '08776543210', 'email' => 'budi.san62@gmail.com', 'facility' => 'Asrama Kendedes'],
            ['no' => '04', 'nama' => 'Dewi Sartika', 'whatsapp' => '08521122334', 'email' => 'dewi.sartika90@gmail.com', 'facility' => 'Asrama Ken Arok'],
        ];

        $uniqueFacilities = array_unique(array_column($myData, 'facility'));
        ?>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-8">
            <div class="relative flex-1 max-w-md">
                <select id="facilityFilter" onchange="filterTable(this.value)" 
                    class="w-full px-5 py-3 md:px-6 md:py-4 rounded-2xl border-none ring-1 ring-gray-200 focus:ring-2 focus:ring-[#1265A8] appearance-none bg-white shadow-sm text-sm font-bold text-slate-600 outline-none">
                    <option value="all">Semua Fasilitas</option>
                    <?php foreach ($uniqueFacilities as $facility): ?>
                        <option value="<?= $facility ?>"><?= $facility ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <button onclick="refreshFilter()" 
                class="flex items-center justify-center p-3.5 md:p-4 bg-white ring-1 ring-gray-200 rounded-2xl text-[#1265A8] hover:bg-[#1265A8] hover:text-white transition-all active:scale-90 shadow-sm" 
                title="Refresh Data">
                <svg id="refreshIcon" class="w-5 h-5 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span class="ml-2 sm:hidden font-bold text-sm">Refresh Data</span>
            </button>
        </div>

        <section class="mb-12">
            <div class="overflow-hidden bg-white rounded-[1.5rem] md:rounded-[2.5rem] border border-slate-100 shadow-sm">
                
                <div class="overflow-x-auto">
                    
                    <table class="w-full border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-6 py-5 md:px-8 md:py-6 text-left text-[11px] uppercase tracking-widest text-slate-400 font-black border-b border-slate-100 w-20">NO</th>
                                <th class="px-6 py-5 md:px-8 md:py-6 text-left text-[11px] uppercase tracking-widest text-slate-400 font-black border-b border-slate-100">Informasi Penyewa</th>
                                <th class="px-6 py-5 md:px-8 md:py-6 text-left text-[11px] uppercase tracking-widest text-slate-400 font-black border-b border-slate-100">Kontak WhatsApp</th>
                                <th class="px-6 py-5 md:px-8 md:py-6 text-center text-[11px] uppercase tracking-widest text-slate-400 font-black border-b border-slate-100 w-36">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php $no = 1; foreach ($myData as $data): ?>
                            <tr class="group hover:bg-blue-50/40 transition-all duration-500 facility-row" data-facility="<?= $data['facility'] ?>">
                                <td class="px-6 py-4 md:px-8 md:py-5">
                                    <span class="text-sm font-black text-slate-400 group-hover:text-[#1265A8]">
                                        <?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 md:px-8 md:py-5">
                                    <h4 class="text-sm font-black text-slate-800 mb-0.5"><?= $data['nama'] ?></h4>
                                    <p class="text-[10px] lowercase text-slate-400 font-bold"><?= $data['email'] ?></p>
                                </td>
                                <td class="px-6 py-4 md:px-8 md:py-5">
                                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        <span class="text-sm font-black text-slate-700"><?= $data['whatsapp'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 md:px-8 md:py-5">
                                    <div class="flex items-center justify-center gap-2 flex-nowrap">
                                        <button onclick="confirmDelete(this)" class="p-2.5 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all active:scale-90">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <a href="/admin/dashboard/detail/detailPenyewa" class="p-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-900 transition-all active:scale-95 shadow-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const isBlueBtn = el.classList.contains('bg-[#1265A8]');
        const spinnerColor = (isDarkBtn || isBlueBtn) ? 'text-white' : 'text-blue-500';

        function handleNavClick(event, el) {
            const targetUrl = el.getAttribute('href');
            if (!targetUrl || targetUrl === '#') return;

            event.preventDefault();

            const content = el.querySelector('.btn-content');
            content.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="animate-pulse tracking-wide text-[11px] font-black uppercase">Memuat...</span>
            `;

            el.classList.add('pointer-events-none', 'opacity-80');

            setTimeout(() => {
                window.location.href = targetUrl;
            }, 800);
        }

        // Fungsi Filter
        function filterTable(facility) {
            const rows = document.querySelectorAll('.facility-row');
            rows.forEach(row => {
                const rowFac = row.getAttribute('data-facility');
                if (facility === 'all' || rowFac === facility) {
                    row.style.display = '';
                    setTimeout(() => { row.style.opacity = '1'; row.style.transform = 'translateY(0)'; }, 10);
                } else {
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(-10px)';
                    setTimeout(() => { row.style.display = 'none'; }, 300);
                }
            });
        }

        // Fungsi Refresh
        function refreshFilter() {
            // Animasi putar ikon
            const icon = document.getElementById('refreshIcon');
            icon.style.transform = 'rotate(360deg)';
            
            // Reset Dropdown ke "all"
            document.getElementById('facilityFilter').value = 'all';
            
            // Tampilkan semua data
            filterTable('all');

            // Reset rotasi setelah animasi selesai
            setTimeout(() => { icon.style.transform = 'rotate(0deg)'; }, 500);
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data booking ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1265A8', 
                cancelButtonColor: '#ef4444',  
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Logika penghapusan visual baris tabel
                    const card = button.closest('.group');
                    if (card) {
                        card.style.transform = 'scale(0.95)';
                        card.style.opacity = '0';
                        card.style.transition = 'all 0.5s ease';
                        setTimeout(() => card.remove(), 500);
                    }

                    // Notifikasi sukses dengan ikon hijau kustom
                    Swal.fire({
                        title: 'Terhapus!',
                        text: 'Data telah berhasil dihapus.',
                        icon: 'success',
                        iconColor: '#10b981', 
                        showConfirmButton: false, 
                        timer: 1500,               
                        timerProgressBar: true,   
                        didOpen: () => {
                            const progressBar = Swal.getTimerProgressBar();
                            if (progressBar) {
                                progressBar.style.backgroundColor = '#10b981';
                            }
                        }, 
                        customClass: {
                            popup: 'rounded-[2rem]'
                        }
                    });
                }
            })
        }

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