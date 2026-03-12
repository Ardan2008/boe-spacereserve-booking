<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }

        .hide-scrollbar::-webkit-scrollbar { 
            display: none; 
        }

        .hide-scrollbar { 
            -ms-overflow-style: none; 
            scrollbar-width: none; 
        }

        .custom-scrollbar::-webkit-scrollbar { 
            width: 4px; 
        }

        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 10px; 
        }
        
        /* Utility untuk animasi manual via JS */
        .animate-content {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen p-4 md:p-8">

    <div id="confirmModal" class="fixed inset-0 z-[999] hidden">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div id="modalContent" class="relative bg-white w-full max-w-sm rounded-[32px] p-8 shadow-2xl transform transition-all scale-95 opacity-0 duration-300">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-50 mb-6">
                        <svg class="h-8 w-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-2">Tinggalkan Halaman?</h3>
                    <p class="text-sm text-slate-500 mb-8 leading-relaxed">Pastikan perubahan Anda telah disimpan.</p>
                    <div class="flex flex-col gap-3">
                        <button onclick="executeBack(this)" class="w-full py-4 bg-red-500 hover:bg-red-600 text-white font-bold rounded-2xl shadow-lg transition-all active:scale-95">Ya, Tinggalkan</button>
                        <button onclick="toggleModal(false)" class="w-full py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <button onclick="toggleModal(true)" class="group flex items-center gap-3 px-5 py-2.5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-red-200 transition-all">
                <div class="p-1 bg-slate-50 group-hover:bg-red-50 rounded-lg">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="text-sm font-bold text-slate-600 group-hover:text-red-600">Kembali</span>
            </button>
        </div>

        <div class="flex items-center gap-3">
            <div class="bg-[#1265A8] p-1.5 rounded-full shadow-lg">
                <svg class="w-3.5 h-3.5 text-white fill-current" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </div>
            <h2 class="text-[#1265A8] font-extrabold text-lg uppercase tracking-wider">Schedule Pembookingan</h2>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-4 flex flex-col md:flex-row items-center justify-between gap-6">
            
            <div class="flex items-center w-full lg:max-w-[700px] overflow-hidden">
                <div class="flex items-center flex-shrink-0 bg-white z-10 pr-2">
                    <div class="relative w-10 h-10 group">
                        <input type="date" id="calendarPicker" value="2026-03-05" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                        <div class="absolute inset-0 p-2 border border-slate-200 rounded-xl bg-white flex items-center justify-center group-hover:bg-slate-50 transition-colors z-10">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="h-10 w-px bg-slate-100 mx-4"></div>
                </div>

                <div id="dateList" class="flex items-center gap-2 overflow-x-auto hide-scrollbar scroll-smooth flex-grow py-2">
                    </div>
            </div>

            <div class="flex items-center gap-6 w-full md:w-auto border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6">
                <div class="relative inline-block text-left w-full" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="w-full group flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md hover:border-[#1265A8]/30 transition-all duration-300">
                        <div class="flex items-center justify-center w-8 h-8 rounded-xl bg-blue-50 group-hover:bg-[#1265A8] transition-colors">
                            <svg class="w-4 h-4 text-[#1265A8] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                        </div>
                        <div class="flex flex-col items-start leading-none">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Fasilitas</span>
                            <span id="dropdownLabel" class="text-sm font-extrabold text-slate-700 group-hover:text-[#1265A8]">Asrama Tunggul Ametung</span>
                        </div>
                        <div class="ml-auto pl-3 border-l border-slate-100">
                            <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-64 origin-top-right bg-white border border-slate-100 rounded-2xl shadow-2xl z-50 overflow-hidden">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-slate-50 mb-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Daftar Fasilitas</p>
                            </div>
                            <button @click="open = false" onclick="pilihFasilitas('asrama_a')" class="w-full text-left flex items-center px-4 py-3 text-xs font-bold text-slate-600 hover:bg-blue-50 hover:text-[#1265A8] transition-all">Asrama Tunggul Ametung</button>
                            <button @click="open = false" onclick="pilihFasilitas('asrama_b')" class="w-full text-left flex items-center px-4 py-3 text-xs font-bold text-slate-600 hover:bg-blue-50 hover:text-[#1265A8] transition-all">Asrama Ken Umang</button>
                            <button @click="open = false" onclick="pilihFasilitas('asrama_c')" class="w-full text-left flex items-center px-4 py-3 text-xs font-bold text-slate-600 hover:bg-blue-50 hover:text-[#1265A8] transition-all">Asrama Kendedes</button>
                            <button @click="open = false" onclick="pilihFasilitas('asrama_d')" class="w-full text-left flex items-center px-4 py-3 text-xs font-bold text-slate-600 hover:bg-blue-50 hover:text-[#1265A8] transition-all">Asrama Ken Arok</button>
                            <button @click="open = false" onclick="pilihFasilitas('asrama_e')" class="w-full text-left flex items-center px-4 py-3 text-xs font-bold text-slate-600 hover:bg-blue-50 hover:text-[#1265A8] transition-all">Asrama Kertajaya</button>
                            <button @click="open = false" onclick="pilihFasilitas('aula')" class="w-full text-left flex items-center px-4 py-3 text-xs font-bold text-slate-600 hover:bg-blue-50 hover:text-[#1265A8] transition-all">Aula Utama</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[40px] shadow-xl overflow-hidden border border-slate-100 flex flex-col lg:flex-row min-h-[500px]">
            
            <div class="lg:w-[45%] relative p-6 overflow-hidden">
                <div id="imageWrapper" class="w-full h-full min-h-[300px] lg:min-h-full relative overflow-hidden rounded-[30px] group animate-content">
                    <img id="displayImage" src="/image/pictures/booking/tunggul_ametung/ametung.png" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Fasilitas">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                    <div class="absolute bottom-6 left-6">
                        <span id="displayID" class="px-4 py-2 bg-white/20 backdrop-blur-md border border-white/30 rounded-full text-white text-[10px] font-bold uppercase tracking-widest">ID: #ASR-A01</span>
                    </div>
                </div>
            </div>

            <div class="lg:w-[55%] p-8 md:p-10 flex flex-col justify-between">
                <div id="textWrapper" class="space-y-6 animate-content">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h1 id="displayTitle" class="text-2xl md:text-3xl font-extrabold text-slate-800 leading-tight">Asrama Tunggul Ametung</h1>
                            <span id="displayFloor" class="flex-shrink-0 px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold uppercase rounded-lg">Gedung A</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#1265A8]"></div>
                            <p class="text-[#9BB7D9] text-[11px] font-bold uppercase tracking-widest">Jadwal Operasional • 05 Maret 2026</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                        
                        <div class="p-4 border-2 rounded-[24px] bg-white border-slate-50 hover:border-[#1265A8] transition-all cursor-pointer group/slot">
                            <span class="block text-[9px] font-bold mb-1 text-[#1265A8]">STATUS</span>
                            <h4 class="font-extrabold text-base text-slate-800">Unit 01</h4>
                            <div class="flex items-center gap-1.5 mt-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                <p class="text-[9px] font-bold uppercase text-green-600">Tersedia</p>
                            </div>
                        </div>

                        <div class="p-4 border-2 rounded-[24px] bg-slate-50 border-slate-100 opacity-60 cursor-not-allowed">
                            <span class="block text-[9px] font-bold mb-1 text-slate-400">STATUS</span>
                            <h4 class="font-extrabold text-base text-slate-800">Unit 02</h4>
                            <div class="flex items-center gap-1.5 mt-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-red-400"></div>
                                <p class="text-[9px] font-bold uppercase text-red-400">Penuh</p>
                            </div>
                        </div>

                        </div>
                </div>
            </div>
        </div>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        const dataFasilitas = {
            asrama_a: { nama: "Asrama Tunggul Ametung", id: "#ASR-A01", lantai: "Gedung A", img: "/image/pictures/booking/tunggul_ametung/ametung.png" },
            asrama_b: { nama: "Asrama Ken Umang", id: "#ASR-A02", lantai: "Gedung B", img: "/image/pictures/booking/ken_umang/umang.png" },
            asrama_c: { nama: "Asrama Kendedes", id: "#ASR-A03", lantai: "Gedung C", img: "/image/pictures/booking/kendedes/dedes.png" },
            asrama_d: { nama: "Asrama Ken Arok", id: "#ASR-A04", lantai: "Gedung D", img: "/image/pictures/booking/ken_arok/arok.png" },
            asrama_e: { nama: "Asrama Kertajaya", id: "#ASR-A05", lantai: "Gedung E", img: "/image/pictures/booking/kertajaya/jaya.png" },
            aula: { nama: "Aula Utama", id: "#AUL-A01", lantai: "Lantai Dasar", img: "/image/pictures/booking/aula/la.png" }
        };

        function pilihFasilitas(key) {
            const item = dataFasilitas[key];
            if(!item) return;

            const imgWrap = document.getElementById('imageWrapper');
            const textWrap = document.getElementById('textWrapper');

            // Fade Out & Slide Down
            imgWrap.style.opacity = '0';
            imgWrap.style.transform = 'translateY(15px)';
            textWrap.style.opacity = '0';
            textWrap.style.transform = 'translateY(15px)';

            setTimeout(() => {
                // Ganti Konten
                document.getElementById('displayTitle').innerText = item.nama;
                document.getElementById('dropdownLabel').innerText = item.nama;
                document.getElementById('displayID').innerText = "ID: " + item.id;
                document.getElementById('displayFloor').innerText = item.lantai;
                document.getElementById('displayImage').src = item.img;

                // Fade In & Slide Up
                imgWrap.style.opacity = '1';
                imgWrap.style.transform = 'translateY(0)';
                textWrap.style.opacity = '1';
                textWrap.style.transform = 'translateY(0)';
            }, 300);
        }

        // Logic Modal
        function toggleModal(show) {
            const modal = document.getElementById('confirmModal');
            const content = document.getElementById('modalContent');
            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => { content.classList.remove('scale-95', 'opacity-0'); }, 10);
            } else {
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => { modal.classList.add('hidden'); }, 200);
            }
        }

        function executeBack(btn) { btn.innerHTML = "Memuat..."; window.location.href = "/"; }

        // Render Daftar Tanggal (Ikon Fixed)
        function renderDateList() {
            const container = document.getElementById('dateList');
            container.innerHTML = '';
            const today = new Date();
            for (let i = 0; i < 14; i++) {
                const d = new Date();
                d.setDate(today.getDate() + i);
                const active = i === 0;
                const div = document.createElement('div');
                div.className = `px-5 py-3 text-center min-w-[85px] rounded-2xl cursor-pointer transition-all flex-shrink-0 ${active ? 'bg-[#1265A8] text-white shadow-lg' : 'hover:bg-slate-100 text-slate-800'}`;
                div.innerHTML = `
                    <p class="text-[10px] font-bold uppercase ${active ? 'text-blue-200' : 'text-slate-400'}">${d.toLocaleDateString('id-ID', {weekday: 'short'})}</p>
                    <p class="text-lg font-extrabold">${d.getDate()} ${d.toLocaleDateString('id-ID', {month: 'short'})}</p>
                `;
                container.appendChild(div);
            }
        }
        renderDateList();
    </script>
</body>
</html>