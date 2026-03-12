<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Edit Fasilitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .swal2-shown { padding-right: 0 !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-slate-800">
    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 blur-[120px] rounded-full opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-indigo-100 blur-[120px] rounded-full opacity-50"></div>
    </div>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex justify-center items-center">
        <div class="w-full max-w-4xl bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.08)] border border-white overflow-hidden transition-all duration-500 hover:shadow-blue-200/40">
            
            <div class="pt-10 pb-2 px-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 bg-blue-50/50 rounded-full border border-blue-100 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1d6fa5]"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1d6fa5]">BOE-Space Management</span>
                </div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">
                    Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1d6fa5] to-blue-400">Facility</span> Data
                </h2>
                <div class="h-1 w-12 bg-gradient-to-r from-[#1d6fa5] to-blue-400 mx-auto mt-4 rounded-full"></div>
            </div>

            <form action="#" method="POST" class="p-8 lg:p-12 pt-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Fasilitas / Asrama</label>
                            <input type="text" name="nama_fasilitas" value="Asrama Tunggul Ametung" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none transition-all duration-300 shadow-sm font-semibold" required>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Deskripsi & Detail</label>
                            <textarea name="deskripsi" rows="9" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none transition-all duration-300 shadow-sm resize-none font-medium leading-relaxed" required>Fasilitas penginapan dengan standar kenyamanan tinggi untuk peserta diklat atau tamu umum.</textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Biaya Sewa</label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5]">Rp</span>
                                <input type="number" name="harga" value="250000" class="w-full pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-lg transition-all" required>
                            </div>
                        </div>

                        <div class="relative group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Thumbnail Fasilitas</label>
                            <div id="dropzone" class="relative overflow-hidden rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-slate-50/50 hover:border-[#1d6fa5] transition-all duration-500 h-64 flex items-center justify-center group/drop cursor-pointer">
                                <img id="preview" class="absolute inset-0 w-full h-full object-cover z-0" src="/image/pictures/booking/tunggul_ametung/ametung.png" alt="Preview Facility" />
                                
                                <div id="ui-content" class="relative z-10 flex flex-col items-center justify-center opacity-0 group-hover/drop:opacity-100 transition-opacity duration-300">
                                    <div class="p-4 bg-white/90 backdrop-blur rounded-2xl shadow-lg mb-2 transform group-hover/drop:scale-110 transition-all duration-500">
                                        <svg class="w-6 h-6 text-[#1d6fa5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-[10px] font-black uppercase text-slate-700 bg-white/80 px-4 py-1.5 rounded-full">Ganti Foto Fasilitas</p>
                                </div>
                                <input type="file" id="fileInput" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20">
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit" id="btnSimpan" class="group relative flex-[2] flex items-center justify-center gap-3 py-5 rounded-2xl bg-[#1d6fa5] hover:bg-slate-800 transition-all duration-500 active:scale-[0.95] overflow-hidden border-none cursor-pointer shadow-lg">
                                <span id="text-simpan" class="text-xs font-black uppercase tracking-[0.2em] text-white">Update Data Fasilitas</span>
                            </button>

                            <a href="javascript:void(0)" id="btn-batal-venue" class="flex-1 flex items-center justify-center py-5 rounded-2xl border-2 border-slate-100 bg-white hover:border-red-100 hover:bg-red-50 transition-all duration-500 no-underline group">
                                <span class="text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-red-500">Batal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="loadingOverlay" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-white/70 backdrop-blur-md">
        <div class="flex flex-col items-center">
            <div class="relative w-14 h-14 mb-4">
                <div class="absolute inset-0 border-4 border-slate-100 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-[#1d6fa5] border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-600">Processing Data...</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('fileInput');
            const preview = document.getElementById('preview');
            const urlAsal = "/admin/dashboard/dataFasilitas"; 

            // Logika Preview Gambar
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => preview.src = e.target.result;
                    reader.readAsDataURL(file);
                }
            });

            // Form Submission
            document.querySelector('form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: "Data fasilitas akan diperbarui di sistem.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1d6fa5',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: { popup: 'rounded-[2rem]' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('loadingOverlay').classList.remove('hidden');
                        
                        // Simulasi proses simpan
                        setTimeout(() => {
                            document.getElementById('loadingOverlay').classList.add('hidden');
                            
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data telah diperbarui.',
                                icon: 'success',
                                iconColor: '#22c55e',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                customClass: { popup: 'rounded-[2rem]' }
                            }).then(() => {
                                window.location.href = urlAsal;
                            });
                        }, 1200);
                    }
                });
            });

            // Logika Tombol Batal
            document.getElementById('btn-batal-venue').addEventListener('click', () => {
                Swal.fire({
                    title: 'Batalkan Edit?',
                    text: "Perubahan yang belum disimpan akan hilang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Kembali',
                    reverseButtons: true,
                    customClass: { popup: 'rounded-[2rem]' }
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = urlAsal;
                });
            });
        });
    </script>
</body>
</html>