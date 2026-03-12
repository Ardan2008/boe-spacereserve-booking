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
            background: #fdfdfe;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.7);
            transition: all 0.3s ease;
        }

        .data-card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .data-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05), 0 8px 10px -6px rgb(0 0 0 / 0.05);
        }
        
        /* State saat terpilih */
        .card-selected {
            ring: 4px;
            ring-color: rgba(18, 101, 168, 0.1);
            border-color: rgba(18, 101, 168, 0.4) !important;
            background-color: rgba(239, 246, 255, 0.5) !important;
        }
    </style>
</head>

<body class="flex min-h-screen">
    @include('admin.dashboard.layouts.sidebar')

    <main class="flex-1 md:ml-64 p-6 md:p-10 transition-all duration-500">
        <header class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center justify-between md:justify-start gap-4 flex-1">
                    <div class="relative">
                        <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-[#1265A8] to-transparent rounded-full opacity-50 hidden md:block"></div>
                        <h2 class="text-2xl md:text-3xl font-black tracking-tight text-slate-800 flex items-center gap-3">
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-[#1265A8] to-[#4292DC]">
                                Data Harga Sewa
                            </span>
                            <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#1265A8] border border-blue-100 uppercase tracking-widest animate-pulse">
                                Live
                            </span>
                        </h2>
                        <p class="mt-1 text-slate-400 text-xs md:text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2 text-[#1265A8]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Selamat datang di <span class="text-slate-600 font-semibold mx-1">manajemen data harga sewa</span>.
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

        {{-- Filter Section --}}
        <section class="mb-8 flex flex-wrap items-center justify-between gap-4 bg-white/60 backdrop-blur-md px-6 py-4 rounded-[2rem] border border-slate-200/60 shadow-sm">
            <div class="flex flex-wrap items-center gap-4">
                <form id="filterForm" class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <input type="date" name="tanggal" id="filterTanggal"
                            class="pl-4 pr-4 py-2.5 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 focus:ring-2 focus:ring-[#1265A8]/20 transition-all cursor-pointer shadow-inner">
                    </div>

                    <div class="relative group">
                        <select name="lapangan_id" id="filterLapangan"
                            class="pl-4 pr-10 py-2.5 bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-700 appearance-none focus:ring-2 focus:ring-[#1265A8]/20 transition-all cursor-pointer shadow-inner min-w-[180px]">
                            <option value="">Semua Fasilitas</option>
                            <option value="1">Asrama Tunggul Ametung</option>
                            <option value="2">Asrama Ken Umang</option>
                            <option value="3">Asrama Kendedes</option>
                            <option value="4">Asrama Ken Arok</option>
                            <option value="5">Asrama Kertajaya</option>
                            <option value="6">Aula BOE</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5"></path></svg>
                        </div>
                    </div>

                    <button type="button" id="btnResetManual" class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Reset Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <label class="flex items-center gap-3 cursor-pointer group bg-slate-50 px-4 py-2 rounded-2xl border border-transparent hover:border-slate-200 transition-all">
                    <span id="selectLabel" class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest group-hover:text-[#1265A8]">Pilih Semua</span>
                    <input type="checkbox" id="selectAll" class="peer hidden">
                    <div class="w-5 h-5 border-2 border-slate-300 rounded-lg peer-checked:bg-[#1265A8] peer-checked:border-[#1265A8] flex items-center justify-center transition-all">
                        <svg class="w-3.5 h-3.5 text-white scale-0 peer-checked:scale-100 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                            <path d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </label>

                <div id="bulkActions" class="hidden items-center animate-in zoom-in duration-300">
                    <button id="btnBulkDelete" class="flex items-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-2xl text-[10px] font-black shadow-lg shadow-red-200 hover:bg-red-600 transition-all uppercase tracking-tighter">
                        Hapus <span id="selectedCount" class="bg-white/20 px-1.5 py-0.5 rounded ml-1">0</span> Data
                    </button>
                </div>
            </div>
        </section>

        <div id="dataContainer"></div>

        <button id="backToTop" class="fixed bottom-8 right-8 z-50 p-4 rounded-2xl bg-white/90 backdrop-blur-md border border-slate-200 text-[#1265A8] shadow-2xl transition-all duration-500 translate-y-20 opacity-0 hover:bg-[#1265A8] hover:text-white group active:scale-90">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path>
            </svg>
        </button>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterForm = document.getElementById('filterForm');
            const filterTanggal = document.getElementById('filterTanggal');
            const filterLapangan = document.getElementById('filterLapangan');
            const selectAllBtn = document.getElementById('selectAll');
            const selectLabel = document.getElementById('selectLabel');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            const backToTopBtn = document.getElementById('backToTop');
            const btnBulkDelete = document.getElementById('btnBulkDelete');
            
            // Modal & Toast Elements
            const modal = document.getElementById('deleteModal');
            const modalContainer = document.getElementById('modalContainer');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');

            let deleteCallback = null;

            // --- DATA UTAMA ---
            let myData = [
                { id: "10293", lapar_id: "1", nama: "Asrama Tunggul Ametung", tanggal: "2026-05-24", displayTanggal: "24 Mei 2026", hargaLama: "Rp 400.000", hargaBaru: "Rp 780.000", persen: "15%" },
                { id: "10294", lapar_id: "2", nama: "Asrama Ken Umang", tanggal: "2026-05-25", displayTanggal: "25 Mei 2026", hargaLama: "Rp 359.000", hargaBaru: "Rp 2.200.000", persen: "10%" },
                { id: "10295", lapar_id: "3", nama: "Asrama Kendedes", tanggal: "2026-05-26", displayTanggal: "26 Mei 2026", hargaLama: "Rp 500.000", hargaBaru: "Rp 600.000", persen: "20%" },
                { id: "10296", lapar_id: "4", nama: "Asrama Ken Arok", tanggal: "2026-05-27", displayTanggal: "27 Mei 2026", hargaLama: "Rp 200.000", hargaBaru: "Rp 467.000", persen: "25%" },
                { id: "10297", lapar_id: "5", nama: "Asrama Kertajaya", tanggal: "2026-05-28", displayTanggal: "28 Mei 2026", hargaLama: "Rp 246.000", hargaBaru: "Rp 578.000", persen: "35%" },
                { id: "10298", lapar_id: "6", nama: "Aula BOE", tanggal: "2026-05-29", displayTanggal: "29 Mei 2026", hargaLama: "Rp 550.000", hargaBaru: "Rp 670.000", persen: "30%" },
            ];

            // --- RENDER ENGINE ---
            const renderData = (dataToRender) => {
                const container = document.getElementById('dataContainer');
                
                if (!dataToRender || dataToRender.length === 0) {
                    container.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-20 opacity-50">
                            <svg class="w-20 h-20 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5"></path>
                            </svg>
                            <p class="font-bold text-slate-500 tracking-tight">Data tidak ditemukan</p>
                        </div>`;
                    return;
                }

                // Mapping menggunakan parameter dataToRender agar hasil filter muncul
                container.innerHTML = dataToRender.map(item => `
                    <section class="max-w-5xl mx-auto my-10 px-4 group/card" data-id="${item.id}">
                        <div class="data-card-hover glass-card rounded-[2.5rem] overflow-hidden transition-all duration-300">
                            <div class="px-8 py-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex items-center gap-6">
                                    <div class="relative">
                                        <input type="checkbox" class="itemCheckbox peer hidden" id="cb-${item.id}">
                                        <label for="cb-${item.id}" class="w-6 h-6 border-2 border-slate-200 rounded-xl peer-checked:bg-[#1265A8] peer-checked:border-[#1265A8] flex items-center justify-center transition-all cursor-pointer shadow-sm">
                                            <svg class="w-4 h-4 text-white scale-0 peer-checked:scale-100 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                                                <path d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 bg-gradient-to-br from-slate-50 to-slate-100 rounded-[1.25rem] flex items-center justify-center text-[#1265A8] border border-slate-200 shadow-sm transition-transform group-hover/card:rotate-3">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">${item.nama}</h3>
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-[10px] font-bold text-[#1265A8] bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100 uppercase">#TRX${item.id}</span>
                                                <span class="text-slate-400 text-[11px] font-medium flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" stroke-width="2"></path></svg>
                                                    ${item.displayTanggal}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="delete-single p-3 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all border border-transparent hover:border-red-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div class="p-8 rounded-[2rem] bg-slate-50/50 border border-slate-100">
                                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-slate-300"></span> Data Sebelumnya
                                    </h4>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-slate-500 font-medium mb-1">Harga Sewa</span>
                                        <span class="text-2xl font-bold text-slate-700">${item.hargaLama}</span>
                                    </div>
                                </div>

                                <div class="p-8 rounded-[2rem] bg-gradient-to-br from-blue-50/40 to-white border border-blue-100 shadow-sm relative overflow-hidden">
                                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-100/30 rounded-full blur-3xl"></div>
                                    <h4 class="text-[10px] font-black text-[#1265A8] uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#1265A8] animate-pulse"></span> Data Terbaru
                                    </h4>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-blue-600/70 font-bold mb-1 uppercase tracking-tighter">Harga Sewa Baru</span>
                                        <div class="flex items-baseline gap-3">
                                            <span class="text-3xl font-black text-slate-900 tracking-tighter">${item.hargaBaru}</span>
                                            <span class="flex items-center text-[10px] font-black text-green-600 bg-green-100/80 px-2 py-0.5 rounded-lg border border-green-200">
                                                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"></path></svg>
                                                ${item.persen}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                `).join('');
            };

            // --- FILTER ENGINE (FIXED) ---
            const applyFilters = () => {
                const tglValue = document.getElementById('filterTanggal').value; 
                const fslValue = document.getElementById('filterLapangan').value; 

                const filtered = myData.filter(item => {
                    const matchTanggal = (tglValue === "") || (item.tanggal === tglValue);
                    const matchFasilitas = (fslValue === "") || (item.lapar_id === fslValue);
                    return matchTanggal && matchFasilitas;
                });

                renderData(filtered);
            };

            // Pastikan event listener terpasang
            document.getElementById('filterTanggal').addEventListener('change', applyFilters);
            document.getElementById('filterLapangan').addEventListener('change', applyFilters);
            document.getElementById('btnResetManual').addEventListener('click', () => {
                document.getElementById('filterForm').reset();
                renderData(myData);
            });

            // --- CHECKBOX & BULK ACTIONS ---
            const getItemCheckboxes = () => document.querySelectorAll('.itemCheckbox');

            const updateCardUI = (checkbox) => {
                const cardWrapper = checkbox.closest('.glass-card');
                if (!cardWrapper) return;
                cardWrapper.classList.toggle('ring-4', checkbox.checked);
                cardWrapper.classList.toggle('ring-[#1265A8]/10', checkbox.checked);
            };

            const toggleBulkActions = () => {
                const checkedCount = Array.from(getItemCheckboxes()).filter(cb => cb.checked).length;
                if (selectedCount) selectedCount.innerText = checkedCount;
                if (bulkActions) {
                    bulkActions.classList.toggle('hidden', checkedCount === 0);
                    bulkActions.classList.toggle('flex', checkedCount > 0);
                }
            };

            selectAllBtn?.addEventListener('change', function() {
                getItemCheckboxes().forEach(cb => {
                    cb.checked = this.checked;
                    updateCardUI(cb);
                });
                if (selectLabel) selectLabel.innerText = this.checked ? "Batalkan Semua" : "Pilih Semua";
                toggleBulkActions();
            });

            document.addEventListener('change', (e) => {
                if (e.target.classList.contains('itemCheckbox')) {
                    updateCardUI(e.target);
                    toggleBulkActions();
                }
            });

            // --- DELETE ENGINE ---
            const showModal = (callback) => {
                deleteCallback = callback;
                modal?.classList.remove('hidden');
                modal?.classList.add('flex');
                setTimeout(() => modalContainer?.classList.remove('scale-95', 'opacity-0'), 10);
            };

            const hideModal = () => {
                modalContainer?.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal?.classList.replace('flex', 'hidden');
                    deleteCallback = null;
                }, 300);
            };

            cancelBtn?.addEventListener('click', hideModal);
            confirmDeleteBtn?.addEventListener('click', async () => {
                if (deleteCallback) await deleteCallback();
            });

            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.delete-single');
                if (btn) {
                    const card = btn.closest('section.group\\/card');
                    if (card) showModal(() => performDelete([card.dataset.id], [card]));
                }
            });

            btnBulkDelete?.addEventListener('click', () => {
                const selected = Array.from(getItemCheckboxes()).filter(cb => cb.checked);
                const ids = selected.map(cb => cb.closest('section.group\\/card').dataset.id);
                const cards = selected.map(cb => cb.closest('section.group\\/card'));
                if (ids.length > 0) showModal(() => performDelete(ids, cards));
            });

            async function performDelete(ids, elements) {
                const spinner = document.getElementById('deleteSpinner');
                const btnText = document.getElementById('btnText');

                confirmDeleteBtn.disabled = true;
                cancelBtn?.classList.add('opacity-0', 'pointer-events-none');
                spinner?.classList.remove('hidden');
                btnText.innerText = "Memproses...";
                confirmDeleteBtn.classList.replace('bg-red-500', 'bg-slate-400');

                await new Promise(r => setTimeout(r, 2000));
                btnText.innerText = "Menghapus Data...";
                await new Promise(r => setTimeout(r, 2000));

                elements.forEach((el, i) => {
                    setTimeout(() => {
                        el.style.transform = 'translateX(100px) scale(0.9)'; 
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 600);
                    }, i * 150); 
                });

                myData = myData.filter(item => !ids.includes(item.id));

                await new Promise(r => setTimeout(r, 500));
                hideModal();
                showToast(`${ids.length} data berhasil dibersihkan.`);

                setTimeout(() => {
                    confirmDeleteBtn.disabled = false;
                    cancelBtn?.classList.remove('opacity-0', 'pointer-events-none');
                    spinner?.classList.add('hidden');
                    btnText.innerText = "Ya, Hapus";
                    confirmDeleteBtn.classList.replace('bg-slate-400', 'bg-red-500');
                    toggleBulkActions();
                }, 500);
            }

            function showToast(message) {
                if (!toast) return;
                toastMessage.innerText = message;
                toast.classList.remove('opacity-0', 'translate-y-10');
                toast.classList.add('opacity-100', 'translate-y-0');
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-y-10');
                    toast.classList.remove('opacity-100', 'translate-y-0');
                }, 3000);
            }

            // --- INITIAL RENDER & BACK TO TOP ---
            renderData(myData);

            window.addEventListener('scroll', () => {
                const isVisible = window.scrollY > 400;
                backToTopBtn?.classList.toggle('opacity-100', isVisible);
                backToTopBtn?.classList.toggle('translate-y-0', isVisible);
                backToTopBtn?.classList.toggle('opacity-0', !isVisible);
                backToTopBtn?.classList.toggle('translate-y-20', !isVisible);
            });

            backToTopBtn?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        });

        function toggleSidebar() {
            document.querySelector('aside')?.classList.toggle('-translate-x-full');
        }
    </script>

    <div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[200] pointer-events-none opacity-0 translate-y-10 transition-all duration-500">
        <div class="bg-slate-800 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 border border-white/10">
            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span id="toastMessage" class="font-medium text-sm">Data berhasil dihapus</span>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
        
        <div class="relative bg-white/90 backdrop-blur-xl rounded-[2.5rem] border border-white/50 shadow-2xl w-full max-w-md p-8 transform transition-all scale-95 opacity-0 duration-300" id="modalContainer">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center text-red-500 mb-6 ring-8 ring-red-50/50">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight mb-2">Hapus Data?</h3>
                <p class="text-slate-500 font-medium leading-relaxed mb-8">
                    Tindakan ini tidak dapat dibatalkan. Semua data terkait akan dihapus secara permanen dari sistem.
                </p>
                
                <div class="flex gap-3 w-full">
                    <button id="cancelBtn" class="flex-1 py-4 px-6 rounded-2xl text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition-all active:scale-95">
                        Batalkan
                    </button>
                    <button id="confirmDeleteBtn" class="flex-1 py-4 px-6 rounded-2xl text-sm font-bold text-white bg-red-500 hover:bg-red-600 shadow-lg shadow-red-200 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg id="deleteSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="btnText">Ya, Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>