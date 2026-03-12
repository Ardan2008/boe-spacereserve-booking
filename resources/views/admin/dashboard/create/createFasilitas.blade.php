<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Add Fasilitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shining {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .swal2-shown { padding-right: 0 !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-slate-800">
    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 blur-[120px] rounded-full opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-indigo-100 blur-[120px] rounded-full opacity-50"></div>
    </div>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex justify-center items-center">
        <div class="w-full max-w-5xl bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.08)] border border-white overflow-hidden transition-all duration-500 hover:shadow-blue-200/40">
            
            <div class="pt-10 pb-6 px-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 bg-blue-50/50 rounded-full border border-blue-100 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1d6fa5]"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1d6fa5]">Management Portal</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                    Add <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1d6fa5] to-blue-400">Venue</span> Data
                </h2>
                <div class="h-1 w-12 bg-gradient-to-r from-[#1d6fa5] to-blue-400 mx-auto mt-4 rounded-full"></div>
            </div>

            <form action="#" method="POST" class="p-8 lg:p-12 pt-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Fasilitas / Asrama</label>
                            <input type="text" name="nama" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none transition-all duration-300 shadow-sm font-semibold" required>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Deskripsi & Detail</label>
                            <textarea name="deskripsi" rows="9" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none transition-all duration-300 shadow-sm resize-none font-medium leading-relaxed" required></textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Biaya Sewa</label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5]">Rp</span>
                                <input type="number" name="harga" class="w-full pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-lg transition-all" required>
                            </div>
                        </div>

                        <div class="relative group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Thumbnail Fasilitas</label>
                            <div id="dropzone" class="relative overflow-hidden rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-slate-50/50 hover:border-[#1d6fa5] transition-all duration-500 h-64 flex items-center justify-center group/drop cursor-pointer">
                                
                                <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden z-10" src="">

                                <div id="ui-content" class="relative z-20 flex flex-col items-center justify-center transition-opacity duration-300">
                                    <div class="p-4 bg-white/90 backdrop-blur rounded-2xl shadow-lg mb-2 transform group-hover/drop:scale-110 transition-all duration-500">
                                        <svg class="w-6 h-6 text-[#1d6fa5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-[10px] font-black uppercase text-slate-700 bg-white/80 px-4 py-1.5 rounded-full">Pilih Foto Fasilitas</p>
                                </div>
                                
                                <input type="file" id="fileInput" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-30" required>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row-reverse gap-4 pt-6 mt-4 border-t border-slate-100/50">
                            <button type="submit" id="btnSimpan"
                                class="group relative w-full sm:w-2/3 overflow-hidden rounded-2xl bg-[#1d6fa5] px-8 py-5 transition-all duration-300 hover:bg-slate-800 hover:shadow-[0_20px_40px_-12px_rgba(29,111,165,0.35)] active:scale-[0.98]">
                                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
                                <div class="relative flex items-center justify-center gap-3">
                                    <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span id="btnText" class="text-sm font-black uppercase tracking-[0.2em] text-white">Simpan Data</span>
                                    <svg id="btnIcon" class="h-5 w-5 text-blue-400 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </div>
                            </button>

                            <div class="w-full sm:w-1/3 relative">
                                <a href="/admin/dashboard/dataLapangan" id="btn-batal-venue"
                                    class="group w-full flex items-center justify-center gap-2 py-5 px-8 rounded-2xl border-2 border-slate-100 bg-white transition-all duration-300 hover:border-red-100 hover:bg-red-50 active:scale-[0.98] relative overflow-hidden decoration-none cursor-pointer">
                                    <div id="loader-batal-venue" class="absolute inset-0 flex items-center justify-center bg-red-50 opacity-0 invisible transition-all duration-300">
                                        <svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <div id="text-batal-venue" class="flex items-center gap-2 transition-all duration-300">
                                        <span class="text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-red-500">Batal</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="loadingOverlay" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-slate-50/60 backdrop-blur-sm transition-all duration-500">
        <div class="flex flex-col items-center">
            <div class="relative w-16 h-16 mb-8">
                <div class="absolute inset-0 border-4 border-slate-200 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-[#1d6fa5] border-t-transparent rounded-full animate-spin"></div>
            </div>
            <div class="text-center">
                <h3 id="loadingStatus" class="text-lg font-medium text-slate-800 tracking-tight transition-all duration-300">Memproses data</h3>
                <div class="flex justify-center gap-1 mt-2">
                    <span class="w-1.5 h-1.5 bg-[#1d6fa5] rounded-full animate-bounce [animation-delay:-0.3s]"></span>
                    <span class="w-1.5 h-1.5 bg-[#1d6fa5] rounded-full animate-bounce [animation-delay:-0.15s]"></span>
                    <span class="w-1.5 h-1.5 bg-[#1d6fa5] rounded-full animate-bounce"></span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnSimpan = document.getElementById('btnSimpan');
            const fileInput = document.getElementById('fileInput');
            const preview = document.getElementById('preview');
            const uiContent = document.getElementById('ui-content');
            const dropzone = document.getElementById('dropzone');

            // Logika Preview Gambar Utama
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        uiContent.classList.add('opacity-0'); 
                        dropzone.classList.remove('border-dashed');
                        dropzone.classList.add('border-solid', 'border-[#1d6fa5]');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // logika simpan data
            btnSimpan.closest('form').addEventListener('submit', function (e) {
                e.preventDefault(); 

                Swal.fire({
                    title: 'Simpan Data?',
                    text: "Pastikan semua informasi venue sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1d6fa5',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-[2.5rem]',
                        confirmButton: 'rounded-2xl px-8 py-3 font-bold',
                        cancelButton: 'rounded-2xl px-8 py-3 font-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        eksekusiSimpanData();
                    }
                });
            });

            // memproses loading dan sukses
            function eksekusiSimpanData() {
                const overlay = document.getElementById('loadingOverlay');
                const statusText = document.getElementById('loadingStatus');
                
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');

                const sequences = [
                    "Memvalidasi input...",
                    "Mengamankan koneksi...",
                    "Menyimpan perubahan..."
                ];

                let step = 0;
                const interval = setInterval(() => {
                    if (step < sequences.length) {
                        statusText.classList.add('opacity-0', 'translate-y-2');
                        
                        setTimeout(() => {
                            statusText.innerText = sequences[step];
                            statusText.classList.remove('opacity-0', 'translate-y-2');
                            step++;
                        }, 300);
                    }
                }, 800);

                // selesai
                setTimeout(() => {
                    clearInterval(interval);
                    overlay.classList.add('opacity-0');
                    
                    setTimeout(() => {
                        overlay.classList.add('hidden');
                        overlay.classList.remove('flex', 'opacity-0');

                        Swal.fire({
                            title: 'Berhasil Disimpan',
                            text: 'Data venue telah diperbarui.',
                            icon: 'success',
                            iconColor: '#22c55e', 
                            showConfirmButton: false,
                            timer: 2000, 
                            customClass: {
                                popup: 'rounded-3xl border-none shadow-xl',
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer || result.isConfirmed || true) {
                                // Efek Fade Out Body
                                document.body.style.transition = "opacity 0.5s ease"; 
                                document.body.style.opacity = '0';
                                
                                setTimeout(() => {
                                    window.history.back();
                                }, 500);
                            }
                        });
                    }, 500);
                }, 3000);
            }

            // logika konfirmasi batal
            btnBatal.addEventListener('click', () => {
                btnBatal.classList.add('hidden');
                confirmMenu.classList.remove('hidden');
                confirmMenu.classList.add('flex');
            });

            btnBatalTidak.addEventListener('click', () => {
                confirmMenu.classList.add('hidden');
                confirmMenu.classList.remove('flex');
                btnBatal.classList.remove('hidden');
            });
        });

        const btnBatalVenue = document.getElementById('btn-batal-venue');

        if (btnBatalVenue) {
            btnBatalVenue.addEventListener('click', function(e) {
                e.preventDefault();
                const previousPage = document.referrer || '/admin/dashboard';
                const loader = document.getElementById('loader-batal-venue');
                const textContent = document.getElementById('text-batal-venue');

                Swal.fire({
                    title: 'Batalkan Pengisian?',
                    text: "Data yang sudah diisi tidak akan tersimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', 
                    cancelButtonColor: '#94a3b8', 
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl',
                        cancelButton: 'rounded-xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        textContent.classList.add('opacity-0', 'scale-95');
                        loader.classList.remove('invisible', 'opacity-0');
                        this.classList.add('pointer-events-none');

                        setTimeout(() => {
                            window.location.href = previousPage;
                        }, 700);
                    }
                });
            });
        }
    </script>
</body>
</html>