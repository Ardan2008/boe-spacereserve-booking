<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Detail Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .fade-in { 
            animation: fadeIn 0.5s ease-out; 
        }

        @keyframes fadeIn { 
            from { 
                opacity: 0; 
                transform: translateY(10px); 
            } to { 
                opacity: 1; 
                transform: translateY(0); 
            } 
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100 flex items-center justify-center p-6">

    <div class="w-full max-w-2xl fade-in">

        <div class="bg-white rounded-3xl shadow-2xl p-10 relative overflow-hidden border border-white/50 backdrop-blur-sm">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100 rounded-full opacity-40"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-indigo-50 rounded-full opacity-40"></div>

            <div class="flex items-center justify-between mb-8 relative z-10">
                <div>
                    <h1 class="text-3xl font-black text-gray-800 tracking-tight">
                        Detail Admin
                    </h1>
                    <p class="text-sm text-gray-400 mt-1 font-medium">
                        Informasi lengkap akun administrator
                    </p>
                </div>

                <a href="/admin/dashboard/management/admin_active_control"
                onclick="btnLoading(event, this)"
                class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-[#1d6fa5] hover:text-white transition-all duration-300 shadow-sm flex items-center justify-center gap-2 min-w-[100px]">
                    
                    <div class="content-default flex items-center gap-2">
                        <span>←</span> Back
                    </div>

                    <svg class="icon-loading hidden animate-spin h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </a>
            </div>

            <div class="flex items-center gap-6 mb-10 relative z-10">

                <div class="w-24 h-24 rounded-2xl bg-[#1d6fa5] text-white flex items-center justify-center text-4xl font-black shadow-[0_10px_20px_-5px_rgba(29,111,165,0.4)] transform hover:rotate-3 transition-transform cursor-default">
                    A
                </div>

                <div>
                    <h2 class="text-2xl font-black text-gray-800">
                        Ahmad Administrator
                    </h2>
                    <p class="text-gray-500 mt-1">
                        Username: <span class="font-bold text-[#1d6fa5]">admin_boe</span>
                    </p>
                </div>

            </div>

            <div class="border-t border-gray-100 mb-8"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">

                <div class="group bg-gray-50 p-6 rounded-2xl border border-transparent hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <p class="text-[10px] uppercase text-gray-400 font-black tracking-[0.15em]">
                        ID Log / Admin
                    </p>
                    <p class="text-lg font-bold text-gray-800 mt-1 group-hover:text-[#1d6fa5] transition-colors">
                        #ADM-2024001
                    </p>
                </div>

                <div class="group bg-gray-50 p-6 rounded-2xl border border-transparent hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <p class="text-[10px] uppercase text-gray-400 font-black tracking-[0.15em]">
                        Nama Lengkap
                    </p>
                    <p class="text-lg font-bold text-gray-800 mt-1 group-hover:text-[#1d6fa5] transition-colors">
                        Ahmad Administrator
                    </p>
                </div>

                <div class="group bg-gray-50 p-6 rounded-2xl border border-transparent hover:border-blue-200 hover:bg-white hover:shadow-xl transition-all duration-300 md:col-span-2">
                    <p class="text-[10px] uppercase text-gray-400 font-black tracking-[0.15em]">
                        Role Akses
                    </p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-black rounded-full uppercase">Super Admin</span>
                        <span class="text-sm text-gray-400 font-medium italic">— Full Access</span>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        window.btnLoading = function(event, element) {
            event.preventDefault();
            const url = element.getAttribute('href');
            
            const contentDefault = element.querySelector('.content-default');
            const iconLoading = element.querySelector('.icon-loading');

            if (contentDefault && iconLoading) {
                // Sembunyikan seluruh isi tombol (Panah + Teks)
                contentDefault.classList.add('hidden');
                
                // Munculkan Spinner
                iconLoading.classList.remove('hidden');
                
                // Beri efek visual sedang diproses
                element.classList.add('opacity-80', 'pointer-events-none');
                element.style.cursor = 'wait';

                // Pindah halaman setelah delay
                setTimeout(() => {
                    window.location.href = url;
                }, 800);
            } else {
                window.location.href = url;
            }
        };
    </script>
</body>
</html>