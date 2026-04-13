<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    
                    @forelse($pendingBookings as $booking)
                    <div id="booking-card-{{ $booking->id }}" 
                        onclick="showBookingDetail({
                            id: '{{ $booking->id }}',
                            nama: '{{ $booking->penyewa->nama }}',
                            whatsapp: '{{ $booking->penyewa->whatsapp }}',
                            email: '{{ $booking->penyewa->email }}',
                            fasilitas: '{{ $booking->fasilitas->nama }}',
                            mulai: '{{ \Carbon\Carbon::parse($booking->tgl_mulai)->format('d M Y') }}',
                            selesai: '{{ \Carbon\Carbon::parse($booking->tgl_selesai)->format('d M Y') }}',
                            total: 'Rp {{ number_format($booking->total_harga, 0, ',', '.') }}'
                        })"
                        class="booking-card min-w-[240px] md:min-w-[260px] p-4 rounded-2xl bg-white border border-slate-100 transition-all duration-300 ease-out snap-center shadow-sm cursor-pointer hover:shadow-md hover:border-blue-100 select-none group relative overflow-hidden">
                        
                        <div class="content-wrapper transition-opacity duration-500">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-100 to-blue-50 flex items-center justify-center text-[#1265A8] shadow-sm group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-black text-slate-800 truncate">{{ $booking->penyewa->nama }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">{{ $booking->fasilitas->nama }}</p>
                                    <div class="mt-0.5 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Menunggu Approval</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 text-[10px] space-y-1 font-medium text-slate-500">
                                <p><span class="font-bold">Mulai:</span> {{ \Carbon\Carbon::parse($booking->tgl_mulai)->format('d M Y') }}</p>
                                <p><span class="font-bold">Selesai:</span> {{ \Carbon\Carbon::parse($booking->tgl_selesai)->format('d M Y') }}</p>
                                <p><span class="font-bold">Total:</span> Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                            </div>

                            @if(session('role') === 'owner' || filter_var(session('can_edit'), FILTER_VALIDATE_BOOLEAN))
                            <div class="flex gap-2 mt-4" onclick="event.stopPropagation()">
                                <button onclick="openRejectModal({{ $booking->id }}, '{{ $booking->penyewa->nama }}')" 
                                    class="flex-1 py-2 px-3 bg-rose-50 border border-rose-100 text-rose-500 rounded-xl text-[10px] font-bold uppercase hover:bg-rose-500 hover:text-white transition-colors">
                                    Reject
                                </button>
                                <button onclick="confirmAction('approve', {{ $booking->id }})" 
                                    class="flex-1 py-2 px-3 bg-[#1265A8] text-white rounded-xl text-[10px] font-bold uppercase shadow-md shadow-blue-100 hover:bg-[#0d548a] transition-colors">
                                    Approve
                                </button>
                            </div>
                            @endif
                        </div>

                        <div id="loader-{{ $booking->id }}" class="loading-overlay absolute inset-0 bg-white/80 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500 pointer-events-none">
                            <div class="w-5 h-5 border-2 border-[#1265A8] border-t-transparent rounded-full animate-spin mb-1"></div>
                            <span class="text-[8px] font-bold text-[#1265A8] uppercase tracking-widest">Processing...</span>
                        </div>
                    </div>
                    @empty
                    <div class="min-w-[240px] p-6 text-center text-slate-400">
                        <p class="text-xs font-medium uppercase tracking-widest italic">Tidak ada permintaan booking</p>
                    </div>
                    @endforelse

                </div>
                    
                    <p class="text-center text-[10px] text-slate-400 mt-2 font-medium italic">Geser untuk melihat request lainnya •</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-center">
                    <h4 class="text-slate-800 text-xs font-black mb-4 uppercase tracking-widest">
                        Status Legend
                    </h4>
                    
                    <div class="flex flex-wrap items-center justify-center gap-6">
                        <div class="flex items-center gap-2 group">
                            <div class="relative">
                                <span class="block w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.3)]"></span>
                            </div>
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-wider">Booked</span>
                        </div>

                        <div class="flex items-center gap-2 group">
                            <span class="w-3 h-3 rounded-full bg-slate-200 border border-slate-300"></span>
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-wider">Not Available</span>
                        </div>

                        <div class="flex items-center gap-2 group">
                            <span class="w-3 h-3 rounded-full bg-white border-2 border-slate-200"></span>
                            <span class="text-[10px] text-slate-600 font-bold uppercase tracking-wider">Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAIL BOOKING MODAL --}}
        <div id="bookingDetailModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white w-full max-w-lg rounded-[2.5rem] overflow-hidden shadow-2xl transform transition-all scale-95 opacity-0 duration-300" id="detailModalContent">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Detail Penyewa</h3>
                            <p class="text-[10px] font-bold text-[#1265A8] mt-1 uppercase tracking-widest">Informasi Lengkap Reservasi</p>
                        </div>
                        <button onclick="closeDetailModal()" class="p-2 hover:bg-slate-100 rounded-xl transition-colors">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                            <div class="space-y-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-[#1265A8] shadow-sm flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Nama Lengkap</label>
                                        <p id="detailName" class="text-sm font-bold text-slate-800"></p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-500 shadow-sm flex-shrink-0">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.94 3.659 1.437 5.634 1.437h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Kontak WhatsApp</label>
                                        <p id="detailWhatsApp" class="text-sm font-bold text-slate-800"></p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-400 shadow-sm flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Alamat Email</label>
                                        <p id="detailEmail" class="text-sm font-bold text-slate-800 lowercase"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 flex items-center justify-between">
                            <div>
                                <label class="block text-[9px] font-black text-[#1265A8] uppercase tracking-widest mb-0.5">Fasilitas Pilihan</label>
                                <p id="detailFacility" class="text-base font-black text-slate-800"></p>
                                <p id="detailPeriod" class="text-[10px] text-slate-500 font-bold mt-1"></p>
                            </div>
                            <div class="text-right">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Harga</label>
                                <p id="detailTotal" class="text-lg font-black text-[#1265A8]"></p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button onclick="closeDetailModal()" 
                            class="w-full py-4 bg-slate-800 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-slate-900 transition-all active:scale-95 shadow-lg">
                            Tutup Detail
                        </button>
                    </div>
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
        function openRejectModal(bookingId, userName) {
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
                    processBookingAction('reject', bookingId, result.value.reason);
                }
            });
        }

        function confirmAction(type, bookingId) {
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
                    processBookingAction(type, bookingId);
                }
            });
        }

        function processBookingAction(type, bookingId, reason = null) {
            const loader = document.getElementById(`loader-${bookingId}`);
            const card = document.getElementById(`booking-card-${bookingId}`);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (loader) loader.classList.add('opacity-100');
            
            const url = type === 'approve' 
                ? `/admin/bookings/${bookingId}/approve` 
                : `/admin/bookings/${bookingId}/reject`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ reason: reason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (type === 'approve') {
                        Swal.fire({
                            title: 'Berhasil Disetujui!',
                            text: data.message,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Download Kwitansi',
                            cancelButtonText: 'Tutup',
                            confirmButtonColor: '#1265A8',
                            customClass: { popup: 'rounded-[2rem]' }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `/admin/bookings/${bookingId}/receipt`;
                            }
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.9)';
                            setTimeout(() => card.remove(), 500);
                        });
                    } else {
                        Swal.fire({
                            title: 'Berhasil Ditolak!',
                            text: data.message,
                            icon: 'success',
                            showCancelButton: true,
                            showConfirmButton: false,
                            cancelButtonText: 'Tutup',
                            cancelButtonColor: '#94A3B8',
                            customClass: { popup: 'rounded-[2rem]' }
                        }).then(() => {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.9)';
                            setTimeout(() => card.remove(), 500);
                        });
                    }
                } else {
                    if (loader) loader.classList.remove('opacity-100');
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (loader) loader.classList.remove('opacity-100');
                Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
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

        function showBookingDetail(data) {
            document.getElementById('detailName').innerText = data.nama;
            document.getElementById('detailWhatsApp').innerText = data.whatsapp;
            document.getElementById('detailEmail').innerText = data.email;
            document.getElementById('detailFacility').innerText = data.fasilitas;
            document.getElementById('detailPeriod').innerText = `${data.mulai} - ${data.selesai}`;
            document.getElementById('detailTotal').innerText = data.total;

            const modal = document.getElementById('bookingDetailModal');
            const content = document.getElementById('detailModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDetailModal() {
            const modal = document.getElementById('bookingDetailModal');
            const content = document.getElementById('detailModalContent');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
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