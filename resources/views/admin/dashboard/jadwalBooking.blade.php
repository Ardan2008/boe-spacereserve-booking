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

        .calendar-animate {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .calendar-fade-out {
            opacity: 0;
            transform: translateY(10px);
        }

        .calendar-fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        #calendarDays {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        }

        .slide-out-left {
            transform: translateX(-20px);
            opacity: 0;
        }

        .slide-out-right {
            transform: translateX(20px);
            opacity: 0;
        }

        .slide-in-start-right {
            transform: translateX(20px);
            opacity: 0;
        }

        .slide-in-start-left {
            transform: translateX(-20px);
            opacity: 0;
        }

        .slide-active {
            transform: translateX(0);
            opacity: 1;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="flex min-h-screen">
    @include('admin.dashboard.layouts.sidebar')

    <main class="flex-1 md:ml-64 p-4 md:p-8 lg:p-10">
        <header class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center justify-between md:justify-start gap-4 flex-1">
                    <div class="relative">
                        <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-[#1265A8] to-transparent rounded-full opacity-50 hidden md:block"></div>
                        <h2 class="text-2xl md:text-3xl font-black tracking-tight text-slate-800 flex items-center gap-3">
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-[#1265A8] to-[#4292DC]">
                                Jadwal Booking
                            </span>
                            <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#1265A8] border border-blue-100 uppercase tracking-widest animate-pulse">
                                Live
                            </span>
                        </h2>
                        <p class="mt-1 text-slate-400 text-xs md:text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#1265A8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Selamat datang di <span class="text-slate-600 font-semibold mx-1">pengelolaan jadwal booking</span> lapangan.
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
                @include('admin.dashboard.search.searchBar')
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-gradient-to-r from-white to-slate-50">
                        <button id="prevMonth" class="p-2 hover:bg-white hover:shadow-md rounded-xl transition-all text-slate-400 hover:text-[#1265A8]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        
                        <div class="text-center">
                            <h3 id="currentMonthYear" class="text-xl font-bold text-slate-800 tracking-tight">Februari 2024</h3>
                        </div>

                        <button id="nextMonth" class="p-2 hover:bg-white hover:shadow-md rounded-xl transition-all text-slate-400 hover:text-[#1265A8]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>

                    <div class="p-6 md:p-8 overflow-hidden">
                        <div class="grid grid-cols-7 gap-2 mb-4">
                            <div class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Sen</div>
                            <div class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Sel</div>
                            <div class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Rab</div>
                            <div class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Kam</div>
                            <div class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Jum</div>
                            <div class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Sab</div>
                            <div class="text-center text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Min</div>
                        </div>
                        
                        <div id="calendarDays" class="calendar-animate grid grid-cols-7 gap-2 md:gap-4 text-sm md:text-base font-semibold">
                            </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 w-full max-w-4xl">
                    <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-[#1265A8] rounded-full"></span>
                        Booking Request
                    </h4>
                    
                    <div id="scrollContainer" class="flex gap-3 overflow-x-auto pb-4 cursor-grab active:cursor-grabbing snap-x snap-mandatory no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
                    
                    @foreach(range(1, 5) as $i)
                    <div onclick="delayedNavigation(this, '/admin/dashboard/edit/editDataLapangan')" 
                        class="booking-card min-w-[240px] md:min-w-[260px] p-4 rounded-2xl bg-white border border-slate-100 transition-all duration-500 ease-out snap-center shadow-sm cursor-pointer hover:shadow-md active:scale-95 select-none group relative overflow-hidden">
                        
                        <div class="content-wrapper transition-opacity duration-500">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-100 to-blue-50 flex items-center justify-center text-[#1265A8] shadow-sm group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-black text-slate-800 truncate">User_Pemain_{{ $i }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">Tennis Court #{{ $i }}</p>
                                    <div class="mt-0.5 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Waiting Approval</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <button onclick="event.stopPropagation(); openRejectModal(this, 'User_Pemain_{{ $i }}')" 
                                    class="flex-1 py-2 px-3 bg-rose-50 border border-rose-100 text-rose-500 rounded-xl text-[10px] font-bold uppercase hover:bg-rose-500 hover:text-white transition-colors">
                                    Reject
                                </button>
                                <button onclick="event.stopPropagation(); confirmAction('approve')" 
                                    class="flex-1 py-2 px-3 bg-[#1265A8] text-white rounded-xl text-[10px] font-bold uppercase shadow-md shadow-blue-100 hover:bg-[#0d548a] transition-colors">
                                    Approve
                                </button>
                            </div>
                        </div>

                        <div class="loading-overlay absolute inset-0 bg-white/80 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500 pointer-events-none">
                            <div class="w-5 h-5 border-2 border-[#1265A8] border-t-transparent rounded-full animate-spin mb-1"></div>
                            <span class="text-[8px] font-bold text-[#1265A8] uppercase tracking-widest">Loading...</span>
                        </div>
                    </div>
                    @endforeach

                </div>
                    
                    <p class="text-center text-[10px] text-slate-400 mt-2 font-medium italic">Geser untuk melihat request lainnya •</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <h4 class="text-slate-800 text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-[#1265A8] rounded-full"></span>
                        Status Legend
                    </h4>
                    
                    <ul class="space-y-4">
                        <li class="flex items-center gap-4 group p-1">
                            <div class="relative">
                                <span class="block w-4 h-4 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.3)]"></span>
                                <span class="absolute inset-0 w-4 h-4 rounded-full bg-emerald-500 animate-ping opacity-20"></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm text-slate-700 font-bold leading-none">Already Booked</span>
                                <span class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">Terisi</span>
                            </div>
                        </li>

                        <li class="flex items-center gap-4 group p-1">
                            <span class="w-4 h-4 rounded-full bg-slate-200 border border-slate-300"></span>
                            <div class="flex flex-col">
                                <span class="text-sm text-slate-700 font-bold leading-none">Schedule Not Available</span>
                                <span class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">Libur/Tutup</span>
                            </div>
                        </li>

                        <li class="flex items-center gap-4 group p-1">
                            <span class="w-4 h-4 rounded-full bg-white border-2 border-slate-300 shadow-inner"></span>
                            <div class="flex flex-col">
                                <span class="text-sm text-slate-700 font-bold leading-none">Schedule Is Available</span>
                                <span class="text-[10px] text-slate-400 mt-1 uppercase tracking-wider">Tersedia</span>
                            </div>
                        </li>
                    </ul>
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
        // Logika Back to Top
        const backToTopBtn = document.getElementById('backToTop');
        const calendarDays = document.getElementById('calendarDays');
        const monthYearText = document.getElementById('currentMonthYear');
        const prevBtn = document.getElementById('prevMonth');
        const nextBtn = document.getElementById('nextMonth');

        let currentDate = new Date();
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        function updateCalendarWithAnimation(direction) {
            // Tentukan arah keluar
            if (direction === 'next') {
                calendarDays.className = "grid grid-cols-7 gap-2 md:gap-4 text-sm md:text-base font-semibold slide-out-left";
            } else {
                calendarDays.className = "grid grid-cols-7 gap-2 md:gap-4 text-sm md:text-base font-semibold slide-out-right";
            }

            // Efek pada teks bulan 
            monthYearText.classList.add('opacity-0');

            setTimeout(() => {
                if (direction === 'next') {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    // Siapkan posisi awal masuk dari kanan
                    calendarDays.className = "grid grid-cols-7 gap-2 md:gap-4 text-sm md:text-base font-semibold slide-in-start-right";
                } else {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    // Siapkan posisi awal masuk dari kiri
                    calendarDays.className = "grid grid-cols-7 gap-2 md:gap-4 text-sm md:text-base font-semibold slide-in-start-left";
                }
                
                renderCalendar();

                requestAnimationFrame(() => {
                    calendarDays.classList.add('slide-active');
                    calendarDays.classList.remove('slide-in-start-right', 'slide-in-start-left');
                    monthYearText.classList.remove('opacity-0');
                });

            }, 300);
        }

        function renderCalendar() {
            calendarDays.innerHTML = "";
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            monthYearText.innerText = `${months[month]} ${year}`;

            let firstDay = new Date(year, month, 1).getDay();
            firstDay = firstDay === 0 ? 6 : firstDay - 1; 

            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = "h-12 md:h-16"; 
                calendarDays.appendChild(emptyDiv);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = "h-12 md:h-16 flex items-center justify-center rounded-2xl transition-all cursor-pointer border border-transparent hover:scale-105 active:scale-95";
                dayElement.innerText = day;

                // Logika Warna Dummy
                if ([5, 12, 18, 24].includes(day)) {
                    dayElement.classList.add('bg-emerald-500', 'text-white', 'shadow-lg', 'shadow-emerald-100');
                } else if ([1, 2].includes(day)) {
                    dayElement.classList.add('text-slate-300', 'bg-slate-50/50');
                } else {
                    dayElement.classList.add('text-slate-800', 'bg-white', 'hover:bg-blue-50', 'hover:border-blue-200', 'shadow-sm');
                }

                calendarDays.appendChild(dayElement);
            }
        }

        prevBtn.addEventListener('click', () => updateCalendarWithAnimation('prev'));
        nextBtn.addEventListener('click', () => updateCalendarWithAnimation('next'));

        renderCalendar();

        // Fungsi Khusus Reject dengan Input
        function openRejectModal(button, userName) {
            Swal.fire({
                title: `<span class="text-xl font-black text-rose-600">REJECT REQUEST</span>`,
                html: `
                    <p class="text-slate-500 text-sm mb-4">Berikan alasan penolakan untuk <b>${userName}</b>:</p>
                    <textarea id="rejectReason" class="w-full p-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-rose-500 outline-none text-sm font-medium" placeholder="Contoh: Jadwal bertabrakan dengan maintenance..."></textarea>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Submit Reject',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#F43F5E', 
                cancelButtonColor: '#94A3B8',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem] border-none shadow-2xl',
                    confirmButton: 'rounded-xl px-5 py-2.5 text-xs font-bold uppercase tracking-wider',
                    cancelButton: 'rounded-xl px-5 py-2.5 text-xs font-bold uppercase tracking-wider'
                },
                preConfirm: () => {
                    const reason = Swal.getPopup().querySelector('#rejectReason').value;
                    if (!reason) {
                        Swal.showValidationMessage(`Harap masukkan alasan penolakan!`);
                    }
                    return { reason: reason };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Animasi Sukses
                    Swal.fire({
                        title: 'Berhasil Ditolak!',
                        text: 'Notifikasi alasan telah dikirim ke user.',
                        icon: 'success',
                        iconColor: '#10B981', 
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            // Mewarnai progress bar menjadi hijau
                            const progressBar = Swal.getTimerProgressBar();
                            if (progressBar) progressBar.style.backgroundColor = '#10B981';
                        },
                        customClass: {
                            popup: 'rounded-[2rem]'
                        }
                    });

                    console.log(`Rejecting ${userName} with reason: ${result.value.reason}`);
                }
            });
        }

        function confirmAction(type) {
            const isApprove = type === 'approve';
            
            Swal.fire({
                title: `<span class="text-xl font-black ${isApprove ? 'text-emerald-600' : 'text-rose-600'}">${isApprove ? 'APPROVE BOOKING?' : 'REJECT BOOKING?'}</span>`,
                html: `<p class="text-slate-500 text-sm">Apakah Anda yakin ingin <b>${isApprove ? 'menyetujui' : 'menolak'}</b> permintaan jadwal ini?</p>`,
                icon: isApprove ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonText: isApprove ? 'Ya, Approve!' : 'Ya, Reject!',
                cancelButtonText: 'Batal',
                confirmButtonColor: isApprove ? '#10B981' : '#F43F5E',
                cancelButtonColor: '#94A3B8',
                reverseButtons: true,
                scrollbarPadding: false,
                customClass: {
                    popup: 'rounded-[2rem] border-none shadow-2xl',
                    confirmButton: 'rounded-xl px-5 py-2.5 text-xs font-bold uppercase tracking-wider',
                    cancelButton: 'rounded-xl px-5 py-2.5 text-xs font-bold uppercase tracking-wider'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `Booking telah di-${type}.`,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-[2rem]'
                        }
                    });
                    
                    console.log(`Action: ${type} dikirim ke server...`);
                }
            });
        }

        const slider = document.getElementById('scrollContainer');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.replace('cursor-grab', 'cursor-grabbing');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.replace('cursor-grabbing', 'cursor-grab');
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.replace('cursor-grabbing', 'cursor-grab');
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return; 
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; 
            slider.scrollLeft = scrollLeft - walk;
        });

        function delayedNavigation(element, url) {
            const content = element.querySelector('.content-wrapper');
            const overlay = element.querySelector('.loading-overlay');

            content.style.opacity = "0.3";
            content.style.filter = "blur(1px)";

            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');

            setTimeout(() => {
                window.location.href = url;
            }, 600);
        }

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>