<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Add New Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fbfbfd;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .input-glow:focus {
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
        }

        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 20px;
            height: 20px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .pop-in {
            animation: popIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @keyframes popIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .input-group label { 
            transition: all 0.2s ease; 
        }

        .input-group:focus-within label { 
            color: #007aff; 
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 sm:p-12">
    <div class="relative w-full max-w-3xl glass-card rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden transition-all duration-700">
        
        <div id="successOverlay" class="absolute inset-0 z-50 bg-white/90 backdrop-blur-2xl flex flex-col items-center justify-center hidden opacity-0 transition-all duration-500">
            <div class="pop-in flex flex-col items-center text-center px-10">
                <div class="w-20 h-20 bg-[#007aff] text-white rounded-[2rem] flex items-center justify-center shadow-2xl shadow-blue-200 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-900 mb-2">Admin Ditambahkan</h3>
                <p class="text-slate-500 font-medium">Sistem telah diperbarui dengan personil baru.</p>
                <button onclick="handleBackNavigation()" class="mt-8 px-12 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-black transition-all active:scale-95">
                    Selesai
                </button>
            </div>
        </div>

        <div class="px-8 sm:px-14 pt-16 pb-10 bg-white relative">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                        </span>
                        
                        <span class="text-[11px] font-bold tracking-[0.2em] text-blue-600 uppercase">Management</span>
                    </div>
                </div>
                <h2 class="text-slate-900 text-4xl sm:text-5xl font-extrabold tracking-tight">
                    Add Admin<span class="text-blue-600">.</span>
                </h2>
                <div class="mt-8 h-[1px] w-full bg-slate-100"></div>
            </div>
        </div>

        <form class="px-8 sm:px-14 pb-16 space-y-8" id="adminForm" onsubmit="handleFormSubmit(event)">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="input-group space-y-2">
                    <label class="text-[12px] font-bold text-slate-400 uppercase tracking-widest block ml-1">Nama Lengkap</label>
                    <input type="text" placeholder="John Doe" 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all text-slate-700 font-medium input-glow" required>
                </div>

                <div class="input-group space-y-2">
                    <label class="text-[12px] font-bold text-slate-400 uppercase tracking-widest block ml-1">Username</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 font-bold">@</span>
                        <input type="text" placeholder="username" 
                            class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all text-slate-700 font-medium input-glow" required>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="input-group space-y-2">
                    <label class="text-[12px] font-bold text-slate-400 uppercase tracking-widest block ml-1">Password</label>
                    <input id="passInput" type="password" placeholder="••••••••" 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all text-slate-700 font-medium input-glow" required>
                </div>

                <div class="input-group space-y-2">
                    <label class="text-[12px] font-bold text-slate-400 uppercase tracking-widest block ml-1">Konfirmasi</label>
                    <input id="confirmInput" type="password" placeholder="••••••••" 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all text-slate-700 font-medium input-glow" required>
                </div>
            </div>

            <div class="pt-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-start gap-4 order-2 sm:order-1 max-w-[320px]">
                    <div class="flex-shrink-0 w-11 h-11 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>

                    <div class="flex flex-col gap-1">
                        <h4 class="text-slate-950 text-[12px] font-extrabold tracking-[0.05em] uppercase flex items-center gap-2">
                            Konfirmasi Keamanan
                        </h4>
                        
                        <p class="text-slate-500 text-[13px] font-medium leading-[1.6] tracking-tight antialiased">
                            Tinjau kembali data Anda. Perubahan hak akses sistem akan 
                            <span class="text-blue-600 font-bold bg-blue-50 px-1.5 py-0.5 rounded-md">langsung aktif</span> 
                            setelah pendaftaran berhasil diverifikasi.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-4 w-full sm:w-auto order-1 sm:order-2">
                    <button type="button" onclick="showModal()" 
                        class="group relative px-10 py-4 rounded-2xl font-bold transition-all duration-500 active:scale-95">
                        
                        <div class="absolute inset-0 bg-slate-200/40 rounded-2xl border border-slate-200/50 backdrop-blur-sm transition-all duration-500 group-hover:bg-white group-hover:shadow-[0_10px_30px_-5px_rgba(0,0,0,0.08)] group-hover:border-white"></div>
                        
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-md bg-gradient-to-tr from-slate-200/50 to-white/20"></div>

                        <span class="relative z-10 text-[12px] uppercase tracking-[0.2em] text-slate-500 transition-colors duration-500 group-hover:text-slate-900">
                            Batal
                        </span>
                    </button>
                    
                    <button type="submit" id="btnTambah" class="min-w-[200px] relative flex items-center justify-center py-4 px-8 rounded-2xl font-bold text-white bg-[#007aff] hover:bg-[#0062cc] shadow-xl shadow-blue-100 transition-all text-sm uppercase tracking-widest active:scale-95">
                        <span id="btnText">Daftarkan</span>
                        <div id="btnLoading" class="hidden"><div class="spinner"></div></div>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="confirmModal" class="fixed inset-0 z-[60] flex items-center justify-center p-6 bg-slate-900/40 backdrop-blur-sm hidden opacity-0 transition-all duration-300">
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-10 shadow-2xl scale-95 transition-all duration-300" id="modalContent">
            <div class="text-center">
                <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Batalkan?</h3>
                <p class="text-slate-500 font-medium mb-10 leading-relaxed">Input yang sudah Anda masukkan akan hilang.</p>
                <div class="space-y-3">
                    <button id="btnYaBatal" onclick="handleBackNavigation()" class="w-full py-4 rounded-2xl font-bold text-white bg-rose-500 hover:bg-rose-600 transition-all active:scale-95">Ya, Batalkan</button>
                    <button onclick="hideModal()" class="w-full py-4 rounded-2xl font-bold text-slate-400 bg-slate-50 hover:bg-slate-100 transition-all">Lanjutkan Mengisi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleFormSubmit(e) {
            e.preventDefault();
            
            // Ambil nilai input untuk validasi sederhana
            const pass = document.getElementById('passInput').value;
            const confirmPass = document.getElementById('confirmInput').value;

            // Validasi kecocokan password sebelum lanjut
            if (pass !== confirmPass) {
                alert("Konfirmasi password tidak cocok!");
                return;
            }

            showConfirmDaftar();
        }

        // Fungsi Menampilkan Modal Konfirmasi Custom
        function showConfirmDaftar() {
            const modal = document.getElementById('confirmModal');
            const modalContent = document.getElementById('modalContent');
            
            // Ubah teks modal untuk konfirmasi pendaftaran
            modalContent.querySelector('h3').innerText = "Daftarkan Admin?";
            modalContent.querySelector('p').innerText = "Pastikan data username dan hak akses sudah benar.";
            
            const btnYa = document.getElementById('btnYaBatal');
            btnYa.innerText = "Ya, Daftarkan";
            btnYa.className = "w-full py-4 rounded-2xl font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all active:scale-95";
            
            btnYa.onclick = eksekusiPendaftaran;

            showModal();
        }

        // Fungsi Eksekusi & Animasi Sedang Memproses
        function eksekusiPendaftaran() {
            hideModal(); // Tutup modal konfirmasi

            const btn = document.getElementById('btnTambah');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const overlay = document.getElementById('successOverlay');

            // Tombol Loading
            btn.disabled = true;
            btnText.innerText = "Memproses...";
            btnLoading.classList.remove('hidden');

            // Simulasi pengiriman data ke server
            setTimeout(() => {
                // Efek Outro Form
                document.getElementById('adminForm').style.opacity = "0.3";
                document.getElementById('adminForm').style.filter = "blur(4px)";
                document.getElementById('adminForm').style.transition = "all 0.8s ease";

                // Overlay Sukses
                overlay.classList.remove('hidden');
                setTimeout(() => { 
                    overlay.classList.add('opacity-100'); 
                }, 50);
            }, 2000); 
        }

        // Fungsi Navigasi Pintar (Untuk Tombol Batal & Selesai)
        function handleBackNavigation() {
            const btnYaBatal = document.getElementById('btnYaBatal');
            if (btnYaBatal) {
                btnYaBatal.innerHTML = '<div class="spinner mx-auto"></div>';
            }

            setTimeout(() => {
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.href = "/admin/dashboard";
                }
            }, 500);
        }

        // Fungsi Modal Batal
        const modal = document.getElementById('confirmModal');
        const modalContent = document.getElementById('modalContent');
        
        function showModal() { 
            modal.classList.remove('hidden'); 
            setTimeout(() => { 
                modal.classList.add('opacity-100'); 
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100'); 
            }, 10); 
        }
        
        function hideModal() { 
            modal.classList.remove('opacity-100'); 
            modalContent.classList.remove('scale-100'); 
            modalContent.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300); 
        }

        // Fitur Intip Password 
        const passInputs = [document.getElementById('passInput'), document.getElementById('confirmInput')];
        passInputs.forEach(input => {
            input.addEventListener('input', () => {
                input.type = 'text';
                clearTimeout(input.timeout);
                input.timeout = setTimeout(() => { input.type = 'password'; }, 700);
            });
        });
    </script>
</body>
</html>