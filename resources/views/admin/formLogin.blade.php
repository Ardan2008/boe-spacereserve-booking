<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #f1f5f9 100%);
            height: 100vh;
            width: 100vw;
            margin: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 1);
        }

        .blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.2) 0%, rgba(79, 70, 229, 0.15) 100%);
            filter: blur(100px);
            border-radius: 50%;
            z-index: -1;
            animation: float 18s infinite alternate ease-in-out;
        }

        @keyframes float {
            from { transform: translate(-20px, -20px); }
            to { transform: translate(60px, 40px); }
        }
    </style>
</head>
<body>
    <div class="blob top-[-5%] left-[-10%]"></div>
    <div class="blob bottom-[-5%] right-[-10%]" style="animation-delay: -4s;"></div>

    <div class="w-full max-w-[580px] px-6">
        <div class="glass-card rounded-[3rem] p-10 md:p-12 shadow-2xl shadow-indigo-900/10">
            
            <div class="text-center mb-8">
                <div class="inline-flex relative mb-4">
                    <div class="absolute -inset-4 bg-blue-500 rounded-full blur-2xl opacity-20"></div>
                    <div class="relative w-16 h-16 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0-8v4m-2.357-5.921L4.572 5.457A2 2 0 003 7.343v6.75a10 10 0 005.101 8.71l4.242 2.357a1 1 0 001.314 0l4.242-2.356A10 10 0 0021 14.092V7.343a2 2 0 00-1.572-1.886l-5.071-1.378a2 2 0 00-1.357 0z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Admin Portal</h1>
                <p class="text-slate-500 text-sm mt-2 font-medium">Sistem Keamanan Otomatis Aktif</p>
            </div>

            <form id="staticLoginForm" class="space-y-6" onsubmit="return false;">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 ml-1 uppercase tracking-widest">Identitas Admin</label>
                    <input id="userInput" type="text" placeholder="Masukkan Username" 
                            class="w-full px-7 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none transition-all text-base font-medium" required>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input id="pwInput" type="password" placeholder="••••••••" 
                            class="w-full px-7 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none transition-all text-base font-medium" required>
                        
                        <div id="capsLockAlert" class="absolute right-5 top-1/2 -translate-y-1/2 hidden">
                            <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-md border border-amber-200">CAPS ON</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-2">
                    <button type="button" id="btnCancel" onclick="processCancel()" 
                        class="group relative px-10 py-4 text-slate-500 font-bold rounded-2xl hover:bg-slate-100 transition-all text-xs tracking-widest uppercase active:scale-95 text-center overflow-hidden">
                        
                        <div class="loader-container-cancel absolute inset-0 flex items-center justify-center opacity-0 translate-y-4 transition-all duration-300">
                            <svg class="animate-spin h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <span class="btn-text-cancel inline-block transition-all duration-300">Batal</span>
                    </button>

                    <button type="button" id="btnLogin" onclick="processLogin()" disabled
                        class="flex-1 relative py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl opacity-50 cursor-not-allowed transition-all active:scale-[0.98] text-xs tracking-widest uppercase text-center overflow-hidden">
                        
                        <div class="loader-container absolute inset-0 flex items-center justify-center opacity-0 translate-y-4 transition-all duration-300">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <span class="btn-text inline-block transition-all duration-300">Masuk Sistem</span>
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center mt-6 text-slate-500 text-[10px] tracking-[0.3em] uppercase font-bold opacity-80">
            &copy; 2026 Admin Management System
        </p>
    </div>

    <div id="cancelModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md opacity-0 invisible transition-all duration-300">
        <div class="bg-white rounded-[2.5rem] p-10 max-w-sm w-full shadow-2xl transform transition-all scale-95 duration-300">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6">
                    <svg class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 17c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Konfirmasi Batal</h3>
                <p class="text-slate-500 text-sm mb-10 leading-relaxed">Apakah Anda yakin ingin membatalkan proses login ini?</p>
                <div class="flex flex-col gap-3">
                    <button onclick="handleActualCancel(this)" class="w-full py-4 bg-red-500 text-white font-bold rounded-2xl hover:bg-red-600 shadow-lg shadow-red-200 transition-all text-xs tracking-widest uppercase">
                        Ya, Batal
                    </button>
                    <button onclick="hideModal('cancelModal')" class="w-full py-4 bg-slate-100 text-slate-500 font-bold rounded-2xl hover:bg-slate-200 transition-all text-xs tracking-widest uppercase">Tidak, Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmLoginModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md opacity-0 invisible transition-all duration-300">
        <div class="bg-white rounded-[2.5rem] p-10 max-w-sm w-full shadow-2xl transform transition-all scale-95 duration-300">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-blue-50 mb-6">
                    <svg class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Verifikasi Data</h3>
                <p class="text-slate-500 text-sm mb-10 leading-relaxed">Apakah Anda yakin data yang dimasukkan sudah benar?</p>
                <div id="errorMessage" class="text-red-500 text-xs mb-4 hidden"></div>
                <div class="flex flex-col gap-3">
                    <button onclick="finalSubmit(this)" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl hover:shadow-xl hover:shadow-blue-500/40 transition-all text-xs tracking-widest uppercase text-center flex items-center justify-center">
                        Ya, Masuk Sekarang
                    </button>
                    <button onclick="hideModal('confirmLoginModal')" class="w-full py-4 bg-slate-100 text-slate-500 font-bold rounded-2xl hover:bg-slate-200 transition-all text-xs tracking-widest uppercase">Cek Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const pwInput = document.getElementById('pwInput');
        const capsAlert = document.getElementById('capsLockAlert');
        const userInput = document.getElementById('userInput');
        const loginBtn = document.getElementById('btnLogin');
        let hideTimeout;

        // Validasi Form
        function validateForm() {
            const isUserFilled = userInput.value.trim().length > 0;
            const isPwFilled = pwInput.value.trim().length > 0;

            if (isUserFilled && isPwFilled) {
                loginBtn.disabled = false;
                loginBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                loginBtn.classList.add('hover:shadow-xl', 'hover:shadow-blue-500/40');
            } else {
                loginBtn.disabled = true;
                loginBtn.classList.add('opacity-50', 'cursor-not-allowed');
                loginBtn.classList.remove('hover:shadow-xl', 'hover:shadow-blue-500/40');
            }
        }

        userInput.addEventListener('input', validateForm);
        pwInput.addEventListener('input', validateForm);

        // Preview Password Otomatis
        pwInput.addEventListener('input', () => {
            pwInput.type = 'text';
            clearTimeout(hideTimeout);
            hideTimeout = setTimeout(() => {
                pwInput.type = 'password';
            }, 800);
        });

        // Deteksi Caps Lock
        pwInput.addEventListener('keyup', (e) => {
            if (e.getModifierState('CapsLock')) {
                capsAlert.classList.remove('hidden');
            } else {
                capsAlert.classList.add('hidden');
            }
        });

        // Modal Utility
        function showModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('invisible', 'opacity-0');
            modal.querySelector('div').classList.replace('scale-95', 'scale-100');
        }

        function hideModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.replace('scale-100', 'scale-95');
            setTimeout(() => modal.classList.add('invisible'), 300);
        }

        // Proses Login Utama
        function processLogin() {
            const btn = document.getElementById('btnLogin');
            const text = btn.querySelector('.btn-text');
            const loader = btn.querySelector('.loader-container');

            text.classList.add('opacity-0', '-translate-y-4');
            loader.classList.remove('opacity-0', 'translate-y-4');
            btn.classList.add('pointer-events-none', 'brightness-90');

            setTimeout(() => {
                showModal('confirmLoginModal');
                setTimeout(() => {
                    text.classList.remove('opacity-0', '-translate-y-4');
                    loader.classList.add('opacity-0', 'translate-y-4');
                    btn.classList.remove('pointer-events-none', 'brightness-90');
                }, 500);
            }, 800);
        }

        // Final Submit (Simulasi)
        function finalSubmit(el) {
            el.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-white inline mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                MEMPROSES...
            `;
            el.classList.add('pointer-events-none', 'opacity-80');

            setTimeout(() => {
                hideModal('confirmLoginModal'); 

                Swal.fire({
                    title: 'Akses Diterima!',
                    text: 'Identitas admin terverifikasi. Mengalihkan ke dashboard...',
                    icon: 'success',
                    iconColor: '#22c55e', 
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#ffffff',
                    color: '#1e293b',
                    willOpen: () => {
                        // Mengubah warna progress bar secara dinamis
                        const progressBar = Swal.getTimerProgressBar();
                        if (progressBar) {
                            progressBar.style.backgroundColor = '#22c55e';
                        }
                    },
                    customClass: {
                        popup: 'rounded-[2rem] p-8',
                        title: 'text-2xl font-bold pt-4 text-slate-800',
                        htmlContainer: 'text-slate-500 font-medium'
                    }
                }).then(() => {
                    window.location.href = '/admin/dashboard/master';
                });
            }, 1500);
        }

        // Proses Batal
        function processCancel() {
            const btn = document.getElementById('btnCancel');
            const text = btn.querySelector('.btn-text-cancel');
            const loader = btn.querySelector('.loader-container-cancel');

            text.classList.add('opacity-0', '-translate-y-4');
            loader.classList.remove('opacity-0', 'translate-y-4');
            
            setTimeout(() => {
                showModal('cancelModal');
                text.classList.remove('opacity-0', '-translate-y-4');
                loader.classList.add('opacity-0', 'translate-y-4');
            }, 600);
        }

        function handleActualCancel(el) {
            el.innerHTML = "MEMBATALKAN...";
            el.classList.add('pointer-events-none', 'opacity-80');
            setTimeout(() => {
                window.location.href = '/';
            }, 800);
        }
    </script>
</body>
</html>