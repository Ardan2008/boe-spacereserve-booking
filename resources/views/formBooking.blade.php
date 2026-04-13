<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Form Reservasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style> 
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        .step-transition { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-gray-100 min-h-screen font-['Poppins']">

{{-- Navbar Hidden during booking process as requested --}}
{{-- <x-layout.navbar /> --}}

<main class="flex flex-col items-center justify-start pt-32 pb-20 px-4" 
    x-data="{
        step: 1,
        packageType: '',
        duration: 1,
        adults: 1,
        children: 0,
        childAges: [],
        rooms: 1,
        selectedDate: null,
        name: '',
        email: '',
        whatsapp: '',
        facilities: {{ $facilities->toJson() }},
        selectedFacilityId: '{{ $selectedId ?? '' }}',

        // Calendar state
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        daysInMonth: [],

        init() {
            this.updateDaysInMonth();
            this.$watch('children', val => {
                const count = parseInt(val) || 0;
                if (count > this.childAges.length) {
                    for (let i = this.childAges.length; i < count; i++) this.childAges.push('');
                } else {
                    this.childAges = this.childAges.slice(0, count);
                }
            });
            this.$watch('adults', val => { 
                if (this.currentFacility?.tipe === 'asrama' && this.rooms > val) this.rooms = val; 
            });
        },

        get currentFacility() {
            return this.facilities.find(f => f.id == this.selectedFacilityId) || null;
        },

        // Step Navigation
        nextStep() { 
            if (this.step === 2) {
                if (this.currentFacility?.tipe === 'asrama') {
                    if (this.packageType === 'harian' && this.duration > (this.currentFacility.max_durasi_harian || 999)) {
                        Swal.fire('Peringatan', `Maksimal durasi harian untuk asrama ini adalah ${this.currentFacility.max_durasi_harian} hari.`, 'warning');
                        return;
                    }
                }
            }
            if (this.step < 4) this.step++; 
        },
        prevStep() { if (this.step > 1) this.step--; },

        confirmCancel() {
            Swal.fire({
                title: 'Batal Booking?',
                text: 'Semua progres pengisian akan hilang.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak'
            }).then(result => { if (result.isConfirmed) window.location.href = '/'; });
        },

        // Stepper Logic
        inc(field, max = null) {
            const f = this.currentFacility;
            
            if (field === 'duration') {
                if (this.packageType === 'harian') {
                    const limit = f?.max_durasi_harian || 999;
                    if (this.duration >= limit) {
                        Swal.fire({
                            title: 'Peringatan',
                            text: `Maksimal durasi harian untuk ${f?.nama || 'fasilitas ini'} adalah ${limit} hari.`,
                            icon: 'warning',
                            confirmButtonColor: '#276AD7'
                        });
                        return;
                    }
                }
            }

            if (field === 'rooms') {
                if (f?.tipe === 'aula') return; // No rooms for aula
                if (this.rooms >= this.adults) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Maksimal 1 orang 1 kamar, mohon tambah jumlah orang/dewasa untuk menambah 1 kamar lagi',
                        icon: 'warning',
                        confirmButtonColor: '#276AD7'
                    });
                    return;
                }
            }
            
            if (field === 'adults') {
                const limit = f?.max_dewasa || 999;
                if (this.adults >= limit) {
                    Swal.fire('Peringatan', `Maksimal kapasitas dewasa adalah ${limit}`, 'warning');
                    return;
                }
            }
            
            if (field === 'children') {
                const limit = f?.max_anak || 0;
                if (this.children >= limit) {
                    Swal.fire('Peringatan', `Maksimal kapasitas anak adalah ${limit}`, 'warning');
                    return;
                }
            }

            if (max !== null && this[field] >= max) return;
            this[field]++;
        },
        dec(field, min = 0) { if (this[field] > min) this[field]--; },

        // Calendar Logic
        updateDaysInMonth() {
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            const startDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
            this.daysInMonth = [];
            for (let i = 0; i < startDay; i++) this.daysInMonth.push({ day: null, date: null });
            for (let i = 1; i <= lastDay; i++) {
                this.daysInMonth.push({ day: i, date: new Date(this.currentYear, this.currentMonth, i) });
            }
        },

        getDateStatus(date) {
            if (!date) return 'closed';
            const today = new Date(); today.setHours(0,0,0,0);
            if (date < today) return 'closed';
            // Placeholder for mock/real status
            const day = date.getDay();
            if (day === 0) return 'maintenance'; // Sunday maintenance
            if (day === 6) return 'blocked'; // Saturday blocked
            return 'ready';
        },

        isInRange(date) {
            if (!this.selectedDate || !date) return false;
            const start = new Date(this.selectedDate);
            const end = new Date(start);
            if (this.packageType === 'harian') end.setDate(start.getDate() + this.duration - 1);
            else end.setMonth(start.getMonth() + this.duration);
            return date >= start && date <= end;
        },

        selectDate(date) {
            if (!date || this.getDateStatus(date) === 'closed') return;
            this.selectedDate = date;
        },

        get monthName() {
            return new Intl.DateTimeFormat('id-ID', { month: 'long' }).format(new Date(this.currentYear, this.currentMonth));
        },

        submitBooking() {
            Swal.fire({ title: 'Mengirim Reservasi...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('whatsapp', this.whatsapp);
            formData.append('email', this.email);
            formData.append('fasilitas_id', this.selectedFacilityId);
            formData.append('package_type', this.packageType);
            formData.append('duration', this.duration);
            formData.append('adults', this.adults);
            formData.append('children_count', this.children);
            formData.append('rooms_count', this.rooms);
            this.childAges.forEach(age => formData.append('child_age[]', age));
            formData.append('tgl_mulai', this.selectedDate ? this.selectedDate.toISOString().split('T')[0] : '');
            if (this.packageType === 'bulanan') {
                const end = new Date(this.selectedDate);
                end.setMonth(end.getMonth() + this.duration);
                formData.append('tgl_selesai', end.toISOString().split('T')[0]);
            }
            // Add CSRF
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('bookings.store') }}', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    sessionStorage.setItem('booking_success', 'true');
                    window.location.href = '/';
                } else {
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                }
            });
        }
    }">

    <div class="w-full max-w-2xl bg-white/80 backdrop-blur-xl p-8 md:p-12 rounded-[3.5rem] shadow-2xl border border-white/60 relative overflow-hidden">
        
        {{-- Progress Bar --}}
        <div class="absolute top-0 left-0 w-full h-2 bg-gray-100">
            <div class="h-full bg-blue-600 transition-all duration-700" :style="'width: ' + (step * 25) + '%'"></div>
        </div>

        {{-- Step 1: Initial Choice --}}
        <div x-show="step === 1" x-transition class="step-transition">
            <div class="text-center mb-10">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">Langkah 1/4</span>
                <h2 class="text-3xl font-black text-gray-900 mt-6 uppercase leading-tight">Pilih Tipe Pilihan</h2>
                <p class="text-sm text-gray-400 font-medium mt-2">Tentukan durasi pemesanan Anda di BOE Malang.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <button @click="packageType = 'harian'; nextStep()" 
                    class="group relative p-8 bg-white border-2 border-gray-100 rounded-[2.5rem] hover:border-blue-600 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                        <svg class="w-8 h-8 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Booking-Harian</h3>
                    <p class="text-xs text-gray-400 mt-2 font-medium">Cocok untuk kebutuhan jangka pendek atau harian.</p>
                </button>

                <button @click="packageType = 'bulanan'; nextStep()" 
                    class="group relative p-8 bg-white border-2 border-gray-100 rounded-[2.5rem] hover:border-blue-600 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Booking-Bulanan</h3>
                    <p class="text-xs text-gray-400 mt-2 font-medium">Lebih hemat untuk kebutuhan jangka panjang (Bulanan).</p>
                </button>
            </div>
            
            <div class="mt-12 flex justify-center">
                <button @click="confirmCancel()" class="text-gray-400 hover:text-red-500 font-bold uppercase tracking-widest text-xs transition-colors">Batal Booking</button>
            </div>
        </div>

        {{-- Step 2: Configuration --}}
        <div x-show="step === 2" x-transition class="step-transition">
            <div class="text-center mb-10">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">Langkah 2/4</span>
                <h2 class="text-3xl font-black text-gray-900 mt-6 uppercase leading-tight">Konfigurasi Paket</h2>
                <p class="text-sm text-gray-400 font-medium mt-2" x-text="'Tipe: ' + packageType.toUpperCase()"></p>
            </div>

            <div class="space-y-6">
                {{-- Duration --}}
                <div class="flex items-center justify-between p-6 bg-gray-50 rounded-3xl border border-gray-100">
                    <div>
                        <h4 class="font-black text-gray-800 uppercase tracking-tighter">Durasi Booking</h4>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest" x-text="packageType === 'harian' ? 'Satuan: Hari' : 'Satuan: Bulan'"></p>
                    </div>
                    <div class="flex items-center gap-6">
                        <button @click="dec('duration', 1)" class="w-12 h-12 bg-white shadow-sm rounded-2xl flex items-center justify-center font-black text-xl text-blue-600 hover:bg-blue-600 hover:text-white transition-all">-</button>
                        <span class="text-2xl font-black text-gray-800" x-text="duration"></span>
                        <button @click="inc('duration')" class="w-12 h-12 bg-white shadow-sm rounded-2xl flex items-center justify-center font-black text-xl text-blue-600 hover:bg-blue-600 hover:text-white transition-all">+</button>
                    </div>
                </div>

                {{-- Guests --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-gray-50 rounded-3xl border border-gray-100">
                        <h4 class="font-black text-gray-800 uppercase tracking-tighter mb-4" x-text="currentFacility?.tipe === 'aula' ? 'Total Kapasitas' : 'Dewasa'">Dewasa</h4>
                        <div class="flex items-center justify-between">
                            <button @click="dec('adults', 1)" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-blue-600 shadow-sm">-</button>
                            <span class="text-xl font-black text-gray-800" x-text="adults"></span>
                            <button @click="inc('adults')" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-blue-600 shadow-sm">+</button>
                        </div>
                    </div>
                    {{-- Hide children for Aula --}}
                    <div x-show="currentFacility?.tipe === 'asrama'" class="p-6 bg-gray-50 rounded-3xl border border-gray-100">
                        <h4 class="font-black text-gray-800 uppercase tracking-tighter mb-4">Anak</h4>
                        <div class="flex items-center justify-between">
                            <button @click="dec('children', 0)" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-blue-600 shadow-sm">-</button>
                            <span class="text-xl font-black text-gray-800" x-text="children"></span>
                            <button @click="inc('children')" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center font-black text-blue-600 shadow-sm">+</button>
                        </div>
                    </div>
                </div>

                {{-- Child Ages --}}
                <div x-show="currentFacility?.tipe === 'asrama' && children > 0" x-transition class="p-6 bg-blue-50/20 rounded-3xl border border-blue-100">
                    <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-4">Umur Anak (Tahun)</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <template x-for="(age, idx) in childAges" :key="idx">
                            <input type="number" x-model="childAges[idx]" placeholder="0" class="w-full p-3 bg-white border border-gray-200 rounded-xl text-center font-bold text-sm outline-none focus:border-blue-400">
                        </template>
                    </div>
                </div>

                {{-- Rooms --}}
                <div x-show="currentFacility?.tipe === 'asrama'" class="p-6 bg-gray-50 rounded-3xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <h4 class="font-black text-gray-800 uppercase tracking-tighter">Jumlah Kamar</h4>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest italic">* 1 Kamar Max 1 Dewasa</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <button @click="dec('rooms', 1)" class="w-12 h-12 bg-white shadow-sm rounded-2xl flex items-center justify-center font-black text-xl text-blue-600">-</button>
                        <span class="text-2xl font-black text-gray-800" x-text="rooms"></span>
                        <button @click="inc('rooms')" class="w-12 h-12 bg-white shadow-sm rounded-2xl flex items-center justify-center font-black text-xl text-blue-600 transition-all"
                            :class="rooms >= adults ? 'opacity-30 cursor-not-allowed' : 'hover:bg-blue-600 hover:text-white'">+</button>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex justify-between gap-4">
                <button @click="prevStep()" class="flex-1 py-4 px-6 bg-slate-100 text-slate-400 font-bold rounded-2xl uppercase tracking-widest text-xs">Kembali</button>
                <button @click="nextStep()" class="flex-[2] py-4 px-6 bg-blue-600 text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-lg shadow-blue-200">Lanjut ke Kalender</button>
            </div>
        </div>

        {{-- Step 3: Calendar Selection --}}
        <div x-show="step === 3" x-transition class="step-transition">
            <div class="text-center mb-10">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">Langkah 3/4</span>
                <h2 class="text-3xl font-black text-gray-900 mt-6 uppercase leading-tight">Pilih Tanggal</h2>
                <p class="text-sm text-gray-400 font-medium mt-2">Kalender Ketersediaan Unit</p>
            </div>

            <div class="bg-white rounded-[2.5rem] overflow-hidden border-2 border-black/10 shadow-xl">
                {{-- Header --}}
                <div class="p-8 flex items-center justify-between bg-white border-b border-gray-100">
                    <div>
                        <h3 class="text-2xl font-black uppercase tracking-tighter text-gray-900" x-text="monthName"></h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]" x-text="currentYear"></p>
                    </div>
                    <div class="flex gap-3">
                        <button @click="prevMonth()" class="w-10 h-10 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-all text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="nextMonth()" class="w-10 h-10 bg-gray-50 border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-all text-gray-900">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

                {{-- Status Legend --}}
                <div class="px-8 py-4 flex flex-wrap gap-4 bg-gray-50/50 border-b border-gray-100">
                    <template x-for="item in [{c:'bg-green-500',t:'Ready'}, {c:'bg-yellow-400',t:'Pending'}, {c:'bg-blue-400',t:'Booked'}, {c:'bg-black',t:'Blocked'}, {c:'bg-orange-400',t:'Maint'}, {c:'bg-gray-300',t:'Closed'}]">
                        <div class="flex items-center gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full shadow-sm" :class="item.c"></div>
                            <span class="text-[8px] font-black text-gray-500 uppercase tracking-widest" x-text="item.t"></span>
                        </div>
                    </template>
                </div>

                <div class="grid grid-cols-7 bg-gray-200 gap-px">
                    <template x-for="d in ['MIN', 'SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB']">
                        <div class="bg-gray-100 py-4 text-center text-[9px] font-black text-gray-400 uppercase tracking-widest" x-text="d"></div>
                    </template>
                    <template x-for="(item, idx) in daysInMonth" :key="idx">
                        <div class="h-16 sm:h-24 relative group cursor-pointer transition-all flex items-center justify-center border-white/10"
                            :class="{
                                'bg-green-500': item.day && getDateStatus(item.date) === 'ready',
                                'bg-yellow-400': item.day && getDateStatus(item.date) === 'pending',
                                'bg-blue-400': item.day && getDateStatus(item.date) === 'booked',
                                'bg-black': item.day && getDateStatus(item.date) === 'blocked',
                                'bg-orange-400': item.day && getDateStatus(item.date) === 'maintenance',
                                'bg-gray-300': item.day && getDateStatus(item.date) === 'closed',
                                'bg-white': !item.day
                            }"
                            @click="selectDate(item.date)">
                            
                            {{-- Date Number Centered --}}
                            <div x-show="item.day" class="relative z-10 text-sm font-black transition-all duration-300"
                                :class="{
                                    'text-white': item.day && ['blocked', 'ready', 'booked', 'maintenance'].includes(getDateStatus(item.date)),
                                    'text-gray-900': item.day && ['pending', 'closed'].includes(getDateStatus(item.date)),
                                    'ring-4 ring-white/50 rounded-full w-8 h-8 flex items-center justify-center bg-gray-900 text-white': selectedDate && item.date && item.date.getTime() === selectedDate.getTime()
                                }"
                                x-text="item.day">
                            </div>

                            {{-- Selection Bubble (Around the number) --}}
                            <div x-show="item.day && isInRange(item.date)" 
                                x-transition
                                class="absolute w-10 h-10 sm:w-14 sm:h-14 rounded-full border-[3px] border-white/30 bg-white/10 flex items-center justify-center z-0">
                            </div>

                            {{-- Selection Ping for Start Date --}}
                            <div x-show="selectedDate && item.date && item.date.getTime() === selectedDate.getTime()" 
                                 class="absolute w-10 h-10 sm:w-14 sm:h-14 rounded-full border-4 border-white animate-ping opacity-20 z-0"></div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="mt-12 flex justify-between gap-4">
                <button @click="prevStep()" class="flex-1 py-4 px-6 bg-slate-100 text-slate-400 font-bold rounded-2xl uppercase tracking-widest text-xs">Kembali</button>
                <button x-show="selectedDate" @click="nextStep()" class="flex-[2] py-4 px-6 bg-blue-600 text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-lg shadow-blue-200">Konfirmasi Data Diri</button>
            </div>
        </div>

        {{-- Step 4: Personal Data & Confirmation --}}
        <div x-show="step === 4" x-transition class="step-transition">
            <div class="text-center mb-10">
                <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em] bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">Langkah Akhir</span>
                <h2 class="text-3xl font-black text-gray-900 mt-6 uppercase leading-tight">Konfirmasi Data</h2>
                <p class="text-sm text-gray-400 font-medium mt-2">Detail Pemohon</p>
            </div>

            <div class="space-y-6">
                {{-- Form Inputs --}}
                <div class="space-y-4">
                    <div class="relative">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2 block">Nama Lengkap</label>
                        <input type="text" x-model="name" placeholder="Masukan nama lengkap Anda" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-3xl outline-none focus:border-blue-600 font-medium text-sm">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2 block">Nomor HP / WhatsApp</label>
                            <input type="text" x-model="whatsapp" placeholder="08xxxxx" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-3xl outline-none focus:border-blue-600 font-medium text-sm">
                        </div>
                        <div class="relative">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-4 mb-2 block">Email Aktif</label>
                            <input type="email" x-model="email" placeholder="example@mail.com" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-3xl outline-none focus:border-blue-600 font-medium text-sm">
                        </div>
                    </div>
                </div>

                {{-- Summary Card --}}
                <div class="p-8 bg-gray-900 rounded-[2.5rem] text-white">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-blue-500 mb-6 underline underline-offset-8 decoration-2">Ringkasan Reservasi</h4>
                    <div class="grid grid-cols-2 gap-y-4">
                        <div>
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest">Fasilitas</p>
                            <p class="text-sm font-bold truncate" x-text="currentFacility?.nama"></p>
                        </div>
                        <div>
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest">Paket</p>
                            <p class="text-sm font-bold" x-text="packageType.toUpperCase()"></p>
                        </div>
                        <div>
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest">Check-In</p>
                            <p class="text-sm font-bold" x-text="selectedDate ? new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium' }).format(selectedDate) : '-'"></p>
                        </div>
                        <div>
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest">Durasi</p>
                            <p class="text-sm font-bold" x-text="duration + (packageType === 'harian' ? ' Hari' : ' Bulan')"></p>
                        </div>
                        <div class="col-span-2 pt-4 border-t border-white/5">
                            <div class="flex justify-between items-center">
                                <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest">Kamar & Tamu</p>
                                <p class="text-[10px] font-bold text-blue-400" x-text="rooms + ' Kamar, ' + adults + ' Dewasa' + (children > 0 ? ', ' + children + ' Anak' : '')"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 space-y-4">
                <div class="flex justify-between gap-4">
                    <button @click="prevStep()" class="flex-1 py-4 px-6 bg-slate-100 text-slate-400 font-bold rounded-2xl uppercase tracking-widest text-xs">Kembali</button>
                    <button @click="submitBooking()" class="flex-[2] py-4 px-6 bg-blue-600 text-white font-black rounded-2xl uppercase tracking-widest text-xs shadow-lg shadow-blue-200 hover:bg-black transition-all">Submit Reservasi</button>
                </div>
                <button @click="confirmCancel()" class="w-full py-4 text-red-500 font-bold uppercase tracking-widest text-[10px] bg-red-50 rounded-2xl border border-red-100 transition-colors">Batal Booking</button>
            </div>
        </div>

    </div>

    {{-- Footer Info --}}
    <div class="mt-12 text-center">
        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.4em]">© 2026 BBPPMPV BOE MALANG</p>
    </div>
</main>

</body>
</html>