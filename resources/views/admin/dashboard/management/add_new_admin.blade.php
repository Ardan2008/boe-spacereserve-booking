<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOE-Space Reserve | Tambah Admin Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-slate-800">
    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 blur-[120px] rounded-full opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-indigo-100 blur-[120px] rounded-full opacity-50"></div>
    </div>

    <div class="min-h-screen py-12 px-4 flex justify-center items-center">
        <div class="w-full max-w-4xl bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.08)] border border-white overflow-hidden transition-all duration-500 hover:shadow-blue-200/40">
            
            <div class="pt-10 pb-6 px-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 bg-blue-50/50 rounded-full border border-blue-100 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1265A8]"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1265A8]">Secure Access</span>
                </div>
                <h2 class="text-3xl md:text-3xl font-black text-slate-900 tracking-tight uppercase">
                    Register <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1265A8] to-blue-400">New Admin</span>
                </h2>
                <div class="h-1 w-12 bg-gradient-to-r from-[#1265A8] to-blue-400 mx-auto mt-4 rounded-full"></div>
            </div>

            <form action="{{ route('admin.store') }}" method="POST" class="p-8 lg:p-12 pt-6" id="addAdminForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold" required placeholder="John Doe">
                    </div>

                    <div class="group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Username</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-400">@</span>
                            <input type="text" name="username" class="w-full pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold lowercase" required placeholder="johndoe">
                        </div>
                    </div>

                    <div class="group md:col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold" required placeholder="••••••••">
                    </div>

                    <div class="group md:col-span-2 p-6 bg-slate-50 border border-slate-200 rounded-[2rem]">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wider">Izin Edit (Can Edit)</h4>
                                <p class="text-[11px] text-slate-500 mt-1">Jika aktif, admin ini dapat mengunggah dan mengubah data fasilitas, harga, dll.</p>
                            </div>
                            <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="can_edit" id="toggle" class="absolute block w-6 h-6 rounded-full bg-white border-4 border-slate-300 appearance-none cursor-pointer z-10 transition-transform duration-300 ease-in-out left-0" onchange="this.classList.toggle('right-0'); this.classList.toggle('left-0'); this.classList.toggle('border-[#1265A8]'); this.nextElementSibling.classList.toggle('bg-[#1265A8]');" value="1">
                                <label for="toggle" class="block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer transition-colors duration-300"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row-reverse gap-4 pt-6 mt-4 border-t border-slate-100/50">
                    <button type="submit" class="group relative w-full sm:w-2/3 overflow-hidden rounded-2xl bg-[#1265A8] px-8 py-5 transition-all duration-300 hover:bg-[#0d548a] hover:shadow-[0_20px_40px_-12px_rgba(18,101,168,0.35)] active:scale-[0.98]">
                        <div class="relative flex items-center justify-center gap-3">
                            <span class="text-sm font-black uppercase tracking-[0.2em] text-white">Buat Admin</span>
                        </div>
                    </button>
                    <a href="{{ route('admin.active.list') }}" class="group w-full sm:w-1/3 flex items-center justify-center gap-2 py-5 px-8 rounded-2xl border-2 border-slate-100 bg-white hover:border-slate-300 hover:bg-slate-50 active:scale-[0.98] transition-all">
                        <span class="text-xs font-black uppercase tracking-widest text-slate-500">Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('addAdminForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            
            // convert can_edit to boolean properly
            if (!formData.has('can_edit')) formData.append('can_edit', false);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Admin baru telah ditambahkan.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-[2rem]' }
                    }).then(() => {
                        window.location.href = "{{ route('admin.active.list') }}";
                    });
                } else {
                    Swal.fire('Error', data.message || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Gagal menambahkan admin', 'error');
            });
        });
    </script>
</body>
</html>