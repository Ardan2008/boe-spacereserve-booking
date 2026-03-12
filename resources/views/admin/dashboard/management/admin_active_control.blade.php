<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Admin Control</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; background-color: #f8fafc; 
        }

        .card-shadow { 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); 
        }

        @keyframes modern-pulse {
            0% { transform: scale(1); opacity: 1; }
            70% { transform: scale(2.5); opacity: 0; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        .animate-ping-slow {
            animation: modern-pulse 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animate-fadeIn { 
            animation: fadeIn 0.3s ease-out forwards; 
        }

        .animate-slideUp { 
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
        }
    </style>
</head>
<body class="antialiased text-slate-800 p-4 md:p-10">
    <div class="max-w-6xl mx-auto space-y-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 p-4 bg-slate-50 rounded-3xl border border-slate-200/60 shadow-sm">
    
            <div class="relative bg-gradient-to-br from-blue-600 to-blue-700 text-white px-6 py-5 rounded-2xl flex items-center gap-8 shadow-xl shadow-blue-200/50 min-w-[320px] overflow-hidden group">
                
                <div class="flex-1 z-10">
                    <p class="text-[10px] font-black opacity-70 tracking-[0.2em] uppercase mb-1">Status Panel</p>
                    <h2 class="text-2xl font-black tracking-tight uppercase italic">Admin Aktif</h2>
                </div>

                <div class="relative z-10">
                    <div class="absolute -top-2 -right-2 flex h-5 w-5 z-20">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-5 w-5 bg-green-500 border-2 border-blue-600 shadow-sm"></span>
                    </div>

                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl border border-white/30 flex items-center justify-center text-3xl font-black shadow-inner">
                        2
                    </div>
                </div>
            </div>
            
            <button onclick="openCancelModal()" class="group relative flex items-center gap-4 bg-white border border-slate-200 px-10 py-4 rounded-[1.5rem] font-black text-slate-400 transition-all duration-500 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50/50 shadow-sm active:scale-95">
                <div class="flex items-center justify-center w-7 h-7 rounded-xl bg-slate-100 group-hover:bg-rose-100 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </div>
                <span class="tracking-[0.3em] text-[11px] uppercase">Batal</span>
            </button>

            <div id="cancelModal" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm animate-fadeIn"></div>
                
                <div id="modalContent" class="relative bg-white w-full max-w-sm rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] overflow-hidden animate-slideUp">
                    <div class="p-8 text-center flex flex-col items-center">
                        <div class="w-20 h-20 rounded-3xl bg-rose-50 flex items-center justify-center text-rose-500 mb-6 icon-warning">
                            <i class="fas fa-exclamation-triangle text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 mb-2">Konfirmasi Batal</h3>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">Apakah anda yakin ingin membatalkannya?</p>
                        
                        <div id="modalActions" class="w-full flex gap-3">
                            <button onclick="closeCancelModal()" class="flex-1 py-4 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 transition-all text-xs uppercase tracking-widest">Tidak</button>
                            <button onclick="startFinalLoading(this)" class="flex-1 py-4 rounded-2xl bg-rose-500 text-white font-bold shadow-lg shadow-rose-200 hover:bg-rose-600 transition-all active:scale-95 text-xs uppercase tracking-widest">Ya, Batal</button>
                        </div>

                        <div id="modalLoading" class="hidden py-4 flex flex-col items-center gap-4">
                            <svg class="animate-spin h-10 w-10 text-rose-500" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs font-black text-rose-500 uppercase tracking-[0.3em]">Memproses...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4 flex flex-col gap-6">
                <div class="bg-white rounded-[2.5rem] p-2 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100/80 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)]">
                    
                    <div class="flex items-center justify-between px-7 py-6 relative overflow-hidden">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-indigo-500 to-blue-500 rounded-r-full"></div>

                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <h3 class="text-slate-800 font-black text-sm tracking-[0.25em] uppercase">Account</h3>
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[9px] font-bold">DB v1.0</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <span class="text-[11px] text-slate-400 font-bold tracking-tight">2 Active Administrators</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1 px-2 pb-2">
                        <div class="group flex items-center gap-4 p-4 rounded-[2rem] transition-all duration-300 hover:bg-rose-50/50 cursor-pointer border border-transparent hover:border-rose-100/50">
                            <div class="relative group/avatar">
                                <div class="w-14 h-14 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-rose-500 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500 ease-out">
                                    <i class="fas fa-user-shield text-xl"></i>
                                </div>

                                <div class="absolute -top-1.5 -right-1.5 flex h-6 w-6 items-center justify-center">
                                    <div class="relative flex h-5 w-5 items-center justify-center rounded-full bg-white shadow-sm ring-2 ring-white">
                                        
                                        <span class="relative flex h-3 w-3 rounded-full bg-rose-500">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-rose-400 opacity-75"></span>
                                        </span>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col flex-1">
                                <span class="text-[10px] font-bold text-rose-400 uppercase tracking-[0.15em]">Admin 1</span>
                                <span class="text-[15px] font-bold text-slate-700 tracking-tight">MyAdmin01@gmail.com</span>
                            </div>
                            
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity pr-4">
                                <i class="fas fa-chevron-right text-rose-300 text-xs"></i>
                            </div>
                        </div>

                        <div class="group flex items-center gap-4 p-4 rounded-[2rem] transition-all duration-300 hover:bg-blue-50/50 cursor-pointer border border-transparent hover:border-blue-100/50">
                            <div class="relative group/avatar">
                                <div class="w-14 h-14 rounded-2xl bg-white shadow-sm border border-slate-100 flex items-center justify-center text-blue-500 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ease-out">
                                    <i class="fas fa-user-tie text-xl"></i>
                                </div>

                                <div class="absolute -top-1.5 -right-1.5 flex h-6 w-6 items-center justify-center">
                                    <div class="relative flex h-5 w-5 items-center justify-center rounded-full bg-white shadow-sm ring-2 ring-white">
                                        
                                        <span class="relative flex h-3 w-3 rounded-full bg-blue-500">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                        </span>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col flex-1">
                                <span class="text-[10px] font-bold text-blue-400 uppercase tracking-[0.15em]">Admin 2</span>
                                <span class="text-[15px] font-bold text-slate-700 tracking-tight">MyAdmin02@gmail.com</span>
                            </div>

                            <div class="opacity-0 group-hover:opacity-100 transition-opacity pr-4">
                                <i class="fas fa-chevron-right text-blue-300 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <a href="/admin/dashboard/management/add_new_admin" onclick="btnLoadingAction(this, event)" class="relative w-full flex items-center justify-center gap-2 py-4 rounded-[1.5rem] bg-slate-50 text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] transition-all duration-500 hover:bg-slate-100 hover:text-slate-700 overflow-hidden group/btn">
                            <div class="flex items-center gap-2 transition-all duration-700 ease-in-out group-[.is-loading]/btn:opacity-0 group-[.is-loading]/btn:scale-95 group-[.is-loading]/btn:-translate-y-4">
                                <i class="fas fa-plus-circle text-xs opacity-60"></i>
                                <span>Add New Member</span>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center gap-3 opacity-0 translate-y-4 transition-all duration-700 ease-in-out group-[.is-loading]/btn:opacity-100 group-[.is-loading]/btn:translate-y-0">
                                <svg class="animate-spin h-5 w-5 text-slate-600" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-slate-600 lowercase italic font-medium tracking-normal">Processing...</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl overflow-hidden card-shadow border border-slate-100">
                    <div class="flex items-center justify-between px-7 py-6 relative overflow-hidden bg-white rounded-t-[2rem] border-b border-slate-100">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-10 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-r-full"></div>

                        <div class="flex items-center gap-5">
                            <div class="relative flex items-center justify-center w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 text-slate-400">
                                <i class="fas fa-cog animate-[spin_10s_linear_infinite] text-lg"></i>
                            </div>

                            <div class="flex flex-col gap-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-slate-800 font-black text-sm tracking-[0.3em] uppercase">Control Panel</h3>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[9px] font-black border border-slate-200/60 tracking-[0.15em] uppercase transition-all">
                                        Admin
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-bold tracking-tight uppercase opacity-80">System Management Active</span>
                                </div>
                            </div>
                        </div>

                        <div class="hidden md:flex items-center justify-center">
                            <div class="w-12 h-12 flex items-center justify-center rounded-2xl border border-blue-100 bg-blue-50/80 shadow-sm shadow-blue-100/30">
                                <i class="fas fa-shield-alt text-xl text-blue-500"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 bg-slate-50/50">
                        
                        <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-wrap md:flex-nowrap items-center gap-4 hover:border-blue-300 transition-colors shadow-sm">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-red-500 shrink-0">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                            
                            <div class="flex-1 min-w-[200px]">
                                <div class="bg-slate-50 rounded-xl px-4 py-2 border border-slate-100 flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-600 truncate mr-2">MyAdmin01@gmail.com</span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-green-50 text-green-600 border border-green-100">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                        ONLINE
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <a href="/admin/dashboard/management/view_admin" 
                                onclick="btnLoading(event, this)"
                                class="btn-view flex-1 md:flex-none flex flex-col items-center justify-center gap-1 bg-blue-50 text-blue-600 px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-blue-600 hover:text-white transition-all no-underline overflow-hidden">
                                    
                                    <div class="loader-container flex items-center justify-center transition-all duration-300">
                                        <i class="fas fa-eye icon-default"></i> 
                                        
                                        <svg class="icon-loading hidden animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    
                                    <span class="text-default">View</span>
                                </a>
                                <a href="/admin/dashboard/management/manage_admin_control" 
                                onclick="handleLoading(event, this)"
                                class="relative flex-1 md:flex-none flex flex-col items-center justify-center gap-1 bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-emerald-600 hover:text-white transition-all overflow-hidden min-w-[70px]">
                                    
                                    <div class="flex flex-col items-center gap-1 btn-content">
                                        <i class="fas fa-user-edit"></i> 
                                        <span>Manage</span>
                                    </div>

                                    <div class="loading-content hidden absolute inset-0 flex items-center justify-center bg-emerald-600 text-white">
                                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </a>
                                <button onclick="openLogoutModal()" class="flex-1 md:flex-none flex flex-col items-center justify-center gap-1 bg-rose-50 text-rose-600 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fas fa-power-off"></i> 
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-wrap md:flex-nowrap items-center gap-4 hover:border-blue-300 transition-colors shadow-sm opacity-80">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-blue-500 shrink-0">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                            
                            <div class="flex-1 min-w-[200px]">
                                <div class="bg-slate-50 rounded-xl px-4 py-2 border border-slate-100 flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-600 truncate mr-2">MyAdmin02@gmail.com</span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-slate-50 text-slate-400 border border-slate-200/60">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-slate-300 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-400"></span>
                                        </span>
                                        OFFLINE
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <a href="/admin/dashboard/management/view_admin" 
                                onclick="btnLoading(event, this)"
                                class="btn-view flex-1 md:flex-none flex flex-col items-center justify-center gap-1 bg-blue-50 text-blue-600 px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-blue-600 hover:text-white transition-all no-underline overflow-hidden">
                                    
                                    <div class="loader-container flex items-center justify-center transition-all duration-300">
                                        <i class="fas fa-eye icon-default"></i> 
                                        
                                        <svg class="icon-loading hidden animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    
                                    <span class="text-default">View</span>
                                </a>
                                <a href="/admin/dashboard/management/manage_admin_control" 
                                onclick="handleLoading(event, this)"
                                class="relative flex-1 md:flex-none flex flex-col items-center justify-center gap-1 bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-emerald-600 hover:text-white transition-all overflow-hidden min-w-[70px]">
                                    
                                    <div class="flex flex-col items-center gap-1 btn-content">
                                        <i class="fas fa-user-edit"></i> 
                                        <span>Manage</span>
                                    </div>

                                    <div class="loading-content hidden absolute inset-0 flex items-center justify-center bg-emerald-600 text-white">
                                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </a>
                                <button onclick="openLogoutModal()" class="flex-1 md:flex-none flex flex-col items-center justify-center gap-1 bg-rose-50 text-rose-600 px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fas fa-power-off"></i> 
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="logoutModal" class="fixed inset-0 z-[999] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>
        
        <div id="logoutContent" class="relative bg-white w-full max-w-sm rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] overflow-hidden scale-95 opacity-0 transition-all duration-300">
            <div class="p-8 text-center flex flex-col items-center">
                
                <div id="logoutMainUI" class="flex flex-col items-center">
                    <div class="w-16 h-16 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500 mb-5">
                        <i class="fas fa-sign-out-alt text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-2 uppercase tracking-tight">Konfirmasi Logout</h3>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">Apakah anda yakin ingin mengakhiri sesi ini?</p>
                    
                    <div class="w-full flex gap-3">
                        <button onclick="closeLogoutModal()" class="flex-1 py-3.5 rounded-xl font-bold text-slate-400 hover:bg-slate-100 transition-all text-[11px] uppercase tracking-widest">Tidak</button>
                        <button onclick="processLogout()" class="flex-1 py-3.5 rounded-xl bg-slate-900 text-white font-bold shadow-lg hover:bg-rose-600 transition-all text-[11px] uppercase tracking-widest">Ya, Keluar</button>
                    </div>
                </div>

                <div id="logoutLoading" class="hidden py-6 flex flex-col items-center gap-4">
                    <div class="w-12 h-12 border-4 border-rose-100 border-t-rose-500 rounded-full animate-spin"></div>
                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-[0.3em] animate-pulse">Menghapus Sesi...</span>
                </div>

                <div id="logoutSuccess" class="hidden py-6 flex flex-col items-center gap-4 animate-slideUp">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-100">
                        <i class="fas fa-check text-2xl"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Berhasil Keluar</h3>
                        <p class="text-[11px] text-slate-500 font-medium mt-1">Anda akan segera dialihkan...</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('cancelModal');
            const modalActions = document.getElementById('modalActions');
            const modalLoading = document.getElementById('modalLoading');
            const modalElements = document.querySelectorAll('#modalContent h3, #modalContent p, #modalContent .icon-warning');

            // selektor modal logout
            const logoutModal = document.getElementById('logoutModal');
            const logoutContent = document.getElementById('logoutContent');
            const logoutMainUI = document.getElementById('logoutMainUI');
            const logoutLoading = document.getElementById('logoutLoading');

            // fungsi modal logout
            window.openLogoutModal = function() {
                if (logoutModal) {
                    logoutModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    setTimeout(() => {
                        logoutContent.classList.remove('scale-95', 'opacity-0');
                        logoutContent.classList.add('scale-100', 'opacity-100');
                    }, 10);
                }
            };

            window.closeLogoutModal = function() {
                if (logoutContent) {
                    logoutContent.classList.add('scale-95', 'opacity-0');
                    logoutContent.classList.remove('scale-100', 'opacity-100');
                    setTimeout(() => {
                        logoutModal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }, 300);
                }
            };

            window.processLogout = function() {
                const logoutSuccess = document.getElementById('logoutSuccess');
                
                // Loading
                logoutMainUI.classList.add('hidden');
                logoutLoading.classList.remove('hidden');

                // Simulasi Proses 
                setTimeout(() => {
                    // Sembunyikan Loading, Munculkan Sukses
                    logoutLoading.classList.add('hidden');
                    logoutSuccess.classList.remove('hidden');

                    setTimeout(() => {
                        window.location.href = "/admin/dashboard/management/admin_active_control"; 
                    }, 1500);
                    
                }, 2000);
            };

            // Klik di luar modal logout untuk menutup
            if (logoutModal) {
                logoutModal.addEventListener('click', (e) => {
                    if (e.target === logoutModal || e.target.classList.contains('backdrop-blur-sm')) {
                        closeLogoutModal();
                    }
                });
            }

            window.btnLoading = function(event, element) {
                event.preventDefault();
                const url = element.getAttribute('href');
                
                // Seleksi ikon DAN teks
                const iconDefault = element.querySelector('.icon-default');
                const iconLoading = element.querySelector('.icon-loading');
                const textDefault = element.querySelector('.text-default');

                if (iconDefault && iconLoading) {
                    // Sembunyikan ikon mata
                    iconDefault.classList.add('hidden');
                    
                    // Sembunyikan teks (View)
                    if (textDefault) {
                        textDefault.classList.add('hidden');
                    }
                    
                    // Munculkan ikon loading
                    iconLoading.classList.remove('hidden');
                    
                    element.classList.add('opacity-80', 'pointer-events-none');
                    element.style.cursor = 'wait';

                    setTimeout(() => {
                        window.location.href = url;
                    }, 800);
                } else {
                    window.location.href = url;
                }
            };

            window.handleLoading = function(event, element) {
                event.preventDefault();
                
                const targetUrl = element.getAttribute('href');
                const content = element.querySelector('.btn-content');
                const loading = element.querySelector('.loading-content');

                // memastikan elemen ada sebelum dimanipulasi
                if (content && loading) {
                    content.classList.add('opacity-0');
                    loading.classList.remove('hidden');
                    element.classList.add('pointer-events-none'); 

                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 1800);
                } else {
                    window.location.href = targetUrl;
                }
            };

            window.openCancelModal = function() {
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            };

            window.closeCancelModal = function() {
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            };

            window.startFinalLoading = function() {
                modalActions.classList.add('hidden');
                modalElements.forEach(el => el.classList.add('hidden'));
                modalLoading.classList.remove('hidden');
                setTimeout(() => {
                    window.location.href = "/admin/dashboard/master";
                }, 1800);
            };

            // fungsi add member loading
            window.btnLoadingAction = function(el, e) {
                e.preventDefault();
                const targetUrl = el.getAttribute('href');
                el.classList.add('is-loading');
                el.style.pointerEvents = 'none';
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 1800);
            };
        });
    </script>
</body>
</html>