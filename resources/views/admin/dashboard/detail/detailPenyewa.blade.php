<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Detail Penyewa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body.swal2-shown {
            overflow: unset !important;
            padding-right: 0 !important;
        }

        @keyframes shining {
            100% { 
                transform: translateX(100%); 
            }
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4 font-sans text-slate-900">
            <div class="bg-white rounded-[2.3rem] p-8 sm:p-10 border border-slate-100 flex flex-col md:flex-row gap-10">
                
                {{-- Profile Section --}}
                <div class="flex-1">
                    <div class="mb-10 text-center md:text-left">
                        <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-[0.2em] px-3 py-1.5 rounded-full mb-3">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                            </span>
                            Profil Penyewa
                        </div>

                        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Informasi Dasar</h2>
                        <p class="text-slate-400 text-sm mt-1 font-medium">Detail identitas penyewa terdaftar</p>
                    </div>

                    <form action="#" id="detailBooking" class="grid grid-cols-1 gap-6">
                        <div class="relative group">
                            <label class="absolute -top-2.5 left-4 bg-white px-2 text-[11px] font-bold text-blue-600 uppercase tracking-wider z-10">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ $penyewa->nama }}" readonly
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all duration-300 font-semibold text-slate-700">
                        </div>

                        <div class="relative group">
                            <label class="absolute -top-2.5 left-4 bg-white px-2 text-[11px] font-bold text-blue-600 uppercase tracking-wider z-10">Nomor WhatsApp</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-5 text-slate-400 font-bold text-sm">+62</span>
                                <input type="tel" name="whatsapp" value="{{ substr($penyewa->whatsapp, 1) }}"  readonly
                                    class="w-full pl-14 pr-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all duration-300 font-semibold text-slate-700">
                            </div>
                        </div>

                        <div class="relative group">
                            <label class="absolute -top-2.5 left-4 bg-white px-2 text-[11px] font-bold text-blue-600 uppercase tracking-wider z-10">Alamat Email</label>
                            <input type="email" name="email" value="{{ $penyewa->email }}" readonly
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-500 focus:bg-white outline-none transition-all duration-300 font-semibold text-slate-700">
                        </div>

                        <div class="pt-8">
                            <button type="button" onclick="kembali()" 
                                class="w-full py-4 rounded-2xl text-slate-500 font-black tracking-[0.2em] border-2 border-slate-100 hover:border-slate-200 hover:bg-slate-50 hover:text-slate-800 transition-all duration-300 active:scale-[0.98] flex items-center justify-center group shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                KEMBALI
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Booking History Section --}}
                <div class="flex-1 border-t md:border-t-0 md:border-l border-slate-100 pt-10 md:pt-0 md:pl-10">
                    <div class="mb-8">
                        <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-[0.2em] px-3 py-1.5 rounded-full mb-3">
                            Riwayat Fasilitas
                        </div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Daftar Booking</h3>
                    </div>

                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 scrollbar-hide">
                        @forelse($penyewa->bookings as $booking)
                        <div class="p-5 rounded-[1.5rem] bg-slate-50 border border-slate-100 hover:border-blue-200 transition-all group">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-black text-slate-700 text-sm group-hover:text-blue-600 transition-colors uppercase tracking-tight">
                                    {{ $booking->fasilitas->nama ?? 'Fasilitas Terhapus' }}
                                </h4>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $booking->tgl_selesai < now() ? 'bg-slate-200 text-slate-500' : 'bg-green-100 text-green-600' }}">
                                    {{ $booking->tgl_selesai < now() ? 'Selesai' : 'Aktif' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 font-medium mb-1 flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($booking->tgl_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tgl_selesai)->format('d M Y') }}
                            </p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </p>
                        </div>
                        @empty
                        <div class="py-10 text-center opacity-40 italic text-sm">
                            Belum ada riwayat booking.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <script>
        function kembali() {
            console.log("Fungsi kembali dipicu"); 
            Swal.fire({
                title: '<span class="text-xl font-black text-slate-800 uppercase tracking-[0.2em]">Data Penyewa</span>',
                html: '<p class="text-slate-500 font-medium text-sm px-4 leading-relaxed tracking-wide">Apakah Anda ingin kembali ke halaman daftar data penyewa?</p>',
                icon: 'info',
                iconColor: '#2563eb',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', 
                cancelButtonColor: '#1e293b', 
                confirmButtonText: 'YA, KEMBALI',
                cancelButtonText: 'TETAP DI SINI',
                reverseButtons: true,
                borderRadius: '2.5rem',
                customClass: {
                    confirmButton: 'rounded-2xl px-8 py-4 font-black tracking-widest text-[10px]',
                    cancelButton: 'rounded-2xl px-8 py-4 font-black tracking-widest text-[10px] text-white'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/admin/dashboard/dataPenyewa";
                }
            });
        }
    </script>
</body>
</html>