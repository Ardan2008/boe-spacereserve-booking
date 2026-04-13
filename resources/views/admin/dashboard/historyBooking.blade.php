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

        @keyframes shimmer {
            0% { transform: translateX(-150%) skewX(-12deg); }
            100% { transform: translateX(250%) skewX(-12deg); }
        }

        .animate-shimmer {
            animation: shimmer 1.5s infinite;
        }

        /* Transisi halus untuk baris tabel */
        .facility-row {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1;
            transform: scale(1);
        }

        /* Keadaan saat baris tersembunyi */
        .row-hidden {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
            pointer-events: none;
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
                                History Booking
                            </span>
                            
                            <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#1265A8] border border-blue-100 uppercase tracking-widest animate-pulse">
                                Live
                            </span>
                        </h2>
                        
                        <p class="mt-1 text-slate-400 text-xs md:text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#1265A8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Selamat datang di <span class="text-slate-600 font-semibold mx-1">riwayat booking</span>.
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

        <div class="p-6">
    
            <section class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                
                <div class="flex items-center gap-3">
                    @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                    <label for="selectAll" class="flex items-center gap-3 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:border-blue-300 transition-all cursor-pointer select-none">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" id="selectAll" class="peer appearance-none w-5 h-5 rounded border-2 border-slate-300 checked:bg-[#1265A8] checked:border-[#1265A8] transition-all cursor-pointer">
                            <svg class="absolute w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col leading-tight">
                            <span class="text-[11px] font-black text-slate-800">Pilih Semua</span>
                            <span id="checkSubtitle" class="text-[9px] text-blue-500 font-medium">Semua data terpilih</span>
                        </div>
                        <div id="selectionBadge" class="hidden px-1.5 py-0.5 bg-blue-50 text-[#1265A8] text-[8px] font-bold rounded border border-blue-100 uppercase tracking-tighter">
                            AKTIF
                        </div>
                    </label>
                    @endif

                    <div id="bulkActions" class="hidden opacity-0 transition-all duration-300">
                        <button onclick="confirmBulkDelete()" class="px-4 py-2.5 bg-rose-50 text-rose-600 rounded-xl border border-rose-100 font-bold text-[11px] hover:bg-rose-600 hover:text-white transition-all flex items-center gap-2 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Hapus <span id="selectedCount" class="font-black">0</span> Data</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2">

                    @php
                        $myData = [
                            ['id' => 'BOE-3241', 'facility' => 'Asrama Tunggul Ametung', 'time' => 'Sesi Pagi (08:00 - 12:00)', 'status' => 'Approved', 'date' => '24 Feb 2026'],
                            ['id' => 'BOE-5036', 'facility' => 'Asrama Ken Umang', 'time' => 'Sesi Siang (13:00 - 17:00)', 'status' => 'Approved', 'date' => '25 Feb 2026'],
                            ['id' => 'BOE-3029', 'facility' => 'Asrama Kendedes', 'time' => 'Full Day (08:00 - 17:00)', 'status' => 'Approved', 'date' => '26 Feb 2026'],
                            ['id' => 'BOE-7934', 'facility' => 'Asrama Ken Arok', 'time' => 'Sesi Malam (19:00 - 22:00)', 'status' => 'Approved', 'date' => '27 Feb 2026'],
                            ['id' => 'BOE-1023', 'facility' => 'Asrama Kertajaya', 'time' => 'Full Event (08:00 - 21:00)', 'status' => 'Approved', 'date' => '28 Feb 2026'],
                            ['id' => 'BOE-4039', 'facility' => 'Aula BOE', 'time' => 'Sesi Pagi (08:00 - 12:00)', 'status' => 'Approved', 'date' => '01 Mar 2026'],
                        ];
                        $uniqueFacilities = array_unique(array_column($myData, 'facility'));
                    @endphp
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <select id="facilityFilter" onchange="filterTable(this.value)" 
                                class="pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-100 focus:border-[#1265A8] appearance-none bg-white shadow-sm text-[11px] font-bold text-slate-600 cursor-pointer outline-none transition-all">
                                <option value="all">SEMUA FASILITAS</option>
                                @foreach ($uniqueFacilities as $facility)
                                    <option value="{{ $facility }}">{{ strtoupper($facility) }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <button onclick="refreshFilter()" 
                            class="h-[38px] w-[38px] flex items-center justify-center bg-white border border-slate-200 rounded-xl text-[#1265A8] hover:bg-[#1265A8] hover:text-white hover:border-[#1265A8] shadow-sm transition-all duration-300 active:scale-90 group" 
                            title="Refresh Data">
                            <svg id="refreshIcon" 
                                class="w-4 h-4 transition-transform duration-700 group-hover:rotate-180" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto scrollbar-hide">
                    
                    <table class="w-full border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="p-6 w-16"></th> 
                                <th class="p-6 text-center text-[11px] uppercase tracking-[0.15em] text-slate-400 font-black">Fasilitas & ID</th>
                                <th class="p-6 text-center text-[11px] uppercase tracking-[0.15em] text-slate-400 font-black">Sesi Waktu</th>
                                <th class="p-6 text-center text-[11px] uppercase tracking-[0.15em] text-slate-400 font-black">Status</th>
                                <th class="p-6 text-center text-[11px] uppercase tracking-[0.15em] text-slate-400 font-black">Tanggal</th>
                                <th class="p-6 text-center text-[11px] uppercase tracking-[0.15em] text-slate-400 font-black">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($myData as $item)
                            <tr class="facility-row group hover:bg-slate-50/80 transition-all duration-300" data-facility="{{ $item['facility'] }}">
                                <td class="p-6 text-center">
                                    @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                                    <input type="checkbox" onchange="updateSelectedCount()" class="item-checkbox w-5 h-5 rounded border-slate-300 text-[#1265A8] focus:ring-[#1265A8] cursor-pointer transition-all">
                                    @endif
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-black text-slate-800 group-hover:text-[#1265A8] transition-colors whitespace-nowrap">{{ $item['facility'] }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold tracking-wider mt-0.5 uppercase italic">#{{ $item['id'] }}</span>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-slate-50 rounded-xl border border-dashed border-slate-200 group-hover:bg-white group-hover:border-blue-200 transition-all whitespace-nowrap">
                                        <svg class="w-4 h-4 text-[#1265A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-xs font-black text-[#1265A8]">{{ $item['time'] }}</span>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex justify-center">
                                        <span class="px-4 py-1.5 bg-blue-50 text-[#1265A8] rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-100">
                                            {{ $item['status'] }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-6 text-center text-xs font-bold text-slate-500 italic uppercase whitespace-nowrap">{{ $item['date'] }}</td>
                                <td class="p-6 text-center">
                                    <div class="flex items-center justify-center gap-3 flex-nowrap">
                                        @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                                        <button onclick="confirmDelete(this)" class="p-2.5 rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all border border-rose-100 shadow-sm active:scale-90 flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        @endif
                                        <a href="/admin/dashboard/detail/detailBooking" class="p-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-900 transition-all shadow-md active:scale-90 flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
        // Inisialisasi Element
        const selectAll = document.getElementById('selectAll');
        const bulkActions = document.getElementById('bulkActions');
        const subtitle = document.getElementById('checkSubtitle');
        const badge = document.getElementById('selectionBadge');
        const countBadge = document.getElementById('selectedCount');

        /**
         * 1. Fungsi Utama: Sinkronisasi UI
         * Mengatur status tombol 'Pilih Semua' dan visibilitas 'Bulk Actions' secara otomatis
         */
        function updateUIState() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            const totalVisible = document.querySelectorAll('.facility-row:not([style*="display: none"])').length;
            const totalChecked = checkedBoxes.length;

            // Update angka pada badge tombol hapus
            if (countBadge) countBadge.innerText = totalChecked;

            // A. Logika Panel Hapus Massal
            if (totalChecked > 0) {
                bulkActions.classList.remove('hidden', 'opacity-0', 'scale-95');
                bulkActions.classList.add('flex', 'opacity-100', 'scale-100');
            } else {
                bulkActions.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    if (document.querySelectorAll('.item-checkbox:checked').length === 0) {
                        bulkActions.classList.add('hidden');
                        bulkActions.classList.remove('flex');
                    }
                }, 300);
            }

            // B. Logika Reset Tombol "Pilih Semua" (Subtitle & Badge)
            if (totalChecked === 0 || totalVisible === 0) {
                selectAll.checked = false;
                subtitle.innerText = "Kelola riwayat masal";
                subtitle.classList.remove('text-blue-500');
                subtitle.classList.add('text-slate-400');
                badge.classList.add('hidden');
            } else {
                subtitle.innerText = "Semua data terpilih";
                subtitle.classList.remove('text-slate-400');
                subtitle.classList.add('text-blue-500');
                badge.classList.remove('hidden');
                
                // Sync checkbox utama jika semua item tercentang manual
                selectAll.checked = (totalChecked === totalVisible);
            }
        }

        /**
         * 2. Logika Pilih Semua
         */
        selectAll.addEventListener('change', function() {
            const isChecked = this.checked;
            const visibleRows = document.querySelectorAll('.facility-row:not([style*="display: none"])');
            
            visibleRows.forEach(row => {
                const cb = row.querySelector('.item-checkbox');
                if (cb) {
                    cb.checked = isChecked;
                    updateRowStyle(cb);
                }
            });
            updateUIState();
        });

        /**
         * 3. Logika Checkbox Individual
         */
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-checkbox')) {
                updateRowStyle(e.target);
                updateUIState();
            }
        });

        /**
         * 4. Konfirmasi Hapus Massal
         */
        function confirmBulkDelete() {
            const checkedBoxes = Array.from(document.querySelectorAll('.item-checkbox:checked'));
            const count = checkedBoxes.length;
            
            if (count === 0) return;

            Swal.fire({
                title: `Hapus ${count} Riwayat?`,
                text: "Data yang dipilih akan dihapus permanen dari daftar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus Semua',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    checkedBoxes.forEach((cb, index) => {
                        const row = cb.closest('.facility-row') || cb.closest('tr');
                        
                        setTimeout(() => {
                            row.style.transform = 'scale(0.95)';
                            row.style.opacity = '0';
                            row.style.transition = 'all 0.4s ease';
                            
                            setTimeout(() => {
                                row.remove();
                                // Pemicu Reset UI setelah elemen benar-benar hilang dari DOM
                                updateUIState();
                            }, 400);
                        }, index * 80); 
                    });

                    Swal.fire({
                        title: 'Berhasil!',
                        text: `${count} data telah dibersihkan.`,
                        icon: 'success',
                        iconColor: '#10b981',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-[2rem]' }
                    });
                }
            });
        }

        /**
         * 5. Hapus Satu Per Satu
         */
        function confirmDelete(btn) {
            btn.classList.add('animate-bounce');
            
            Swal.fire({
                title: 'Hapus Riwayat?',
                text: "Data tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Hapus',
                customClass: { popup: 'rounded-[2rem]' }
            }).then((result) => {
                btn.classList.remove('animate-bounce');
                if (result.isConfirmed) {
                    const row = btn.closest('.facility-row') || btn.closest('tr');
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        updateUIState();
                    }, 300);
                }
            });
        }

        /**
         * 6. Fungsi Filter & Refresh
         */
        function filterTable(facility) {
            const rows = document.querySelectorAll('.facility-row');
            
            rows.forEach(row => {
                const rowFac = row.getAttribute('data-facility');
                const isMatch = (facility === 'all' || rowFac === facility);

                if (isMatch) {
                    // 1. Tampilkan display dulu agar animasi bisa berjalan
                    row.style.display = ''; 
                    
                    // 2. Gunakan sedikit delay agar transisi opacity terlihat
                    setTimeout(() => {
                        row.classList.remove('row-hidden');
                    }, 10);
                } else {
                    // 1. Tambahkan class animasi sembunyi
                    row.classList.add('row-hidden');
                    
                    // 2. Uncheck data yang disembunyikan
                    const cb = row.querySelector('.item-checkbox');
                    if(cb) cb.checked = false;

                    // 3. Setelah animasi selesai (400ms), baru ubah display ke none
                    setTimeout(() => {
                        if (row.classList.contains('row-hidden')) {
                            row.style.display = 'none';
                        }
                    }, 400); 
                }
            });

            // Jalankan update UI untuk mereset tombol "Pilih Semua"
            setTimeout(() => updateUIState(), 410);
        }

        function refreshFilter() {
            const icon = document.getElementById('refreshIcon');
            icon.style.transform = 'rotate(360deg)';
            document.getElementById('facilityFilter').value = 'all';
            filterTable('all');
            setTimeout(() => icon.style.transform = 'rotate(0deg)', 500);
        }

        function updateRowStyle(cb) {
            const row = cb.closest('.facility-row') || cb.closest('tr');
            if(cb.checked) {
                row.classList.add('bg-blue-50/50');
            } else {
                row.classList.remove('bg-blue-50/50');
            }
        }

        /**
         * 7. Fitur Tambahan (Invoice Loading & Back to Top)
         */
        function handleInvoiceClick(event, el) {
            event.preventDefault();
            const content = el.querySelector('#btn-content');
            content.innerHTML = `<svg class="animate-spin h-3 w-3 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> <span class="text-[10px]">PROSES...</span>`;
            el.classList.add('pointer-events-none', 'opacity-80');
            setTimeout(() => window.location.href = el.getAttribute('href'), 800); 
        }

        const backToTopBtn = document.getElementById('backToTop');
        if(backToTopBtn) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 400) {
                    backToTopBtn.classList.replace('opacity-0', 'opacity-100');
                    backToTopBtn.classList.replace('translate-y-20', 'translate-y-0');
                } else {
                    backToTopBtn.classList.replace('opacity-100', 'opacity-0');
                    backToTopBtn.classList.replace('translate-y-0', 'translate-y-20');
                }
            });
            backToTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        }
    </script>
</body>
</html>