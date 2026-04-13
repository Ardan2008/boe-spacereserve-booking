<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Edit Fasilitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Alpine.js CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .swal2-shown { padding-right: 0 !important; }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-slate-800">
    {{-- Background Ornaments --}}
    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 blur-[120px] rounded-full opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-indigo-100 blur-[120px] rounded-full opacity-50"></div>
    </div>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex justify-center items-center" x-data="facilityEditor()">
        <div class="w-full max-w-5xl bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.08)] border border-white overflow-hidden transition-all duration-500">
            
            {{-- Header --}}
            <div class="pt-10 pb-6 px-10 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 bg-blue-50/50 rounded-full border border-blue-100 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1265A8]"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1265A8]" x-text="'Update Mode | ' + tipe">Update Mode</span>
                </div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight uppercase">
                    Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1265A8] to-blue-400" x-text="tipe === 'asrama' ? 'Asrama' : 'Aula'">Facility</span> Data
                </h2>
                <div class="h-1.5 w-12 bg-gradient-to-r from-[#1265A8] to-blue-400 mx-auto mt-4 rounded-full"></div>

                {{-- Type Switcher --}}
                <div class="flex justify-center gap-4 mt-8">
                    <button type="button" @click="confirmTypeChange('asrama')" :class="tipe === 'asrama' ? 'bg-[#1265A8] text-white shadow-lg' : 'bg-slate-100 text-slate-400 hover:bg-slate-200'" class="px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all duration-300">Asrama</button>
                    <button type="button" @click="confirmTypeChange('aula')" :class="tipe === 'aula' ? 'bg-[#1265A8] text-white shadow-lg' : 'bg-slate-100 text-slate-400 hover:bg-slate-200'" class="px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all duration-300">Aula</button>
                    <input type="hidden" name="tipe" :value="tipe">
                </div>
            </div>

            <form action="{{ route('fasilitas.update', $fasilitas->id) }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-12 pt-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipe" :value="tipe">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Fasilitas</label>
                            <input type="text" name="nama" value="{{ old('nama', $fasilitas->nama) }}" 
                                class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold" required>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" 
                                class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm resize-none font-medium leading-relaxed" required>{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Detail Fasilitas</label>
                            <textarea name="detail" rows="5" 
                                class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm resize-none font-medium leading-relaxed">{{ old('detail', $fasilitas->detail) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Jam Operasional</label>
                                <input type="text" name="jam_operasional" value="{{ old('jam_operasional', $fasilitas->jam_operasional) }}" placeholder="08.00 - 22.00" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold">
                            </div>
                            <div x-show="tipe === 'asrama'">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Max Durasi (Hari)</label>
                                <input type="number" name="max_durasi_harian" value="{{ old('max_durasi_harian', $fasilitas->max_durasi_harian) }}" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold">
                            </div>
                            <div x-show="tipe === 'aula'">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kapasitas (Orang)</label>
                                <input type="number" name="max_dewasa" value="{{ old('max_dewasa', $fasilitas->max_dewasa) }}" placeholder="Total" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold">
                            </div>
                        </div>

                        <div x-show="tipe === 'asrama'" class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Cap. Dewasa (Kamar)</label>
                                <input type="number" name="max_dewasa" value="{{ old('max_dewasa', $fasilitas->max_dewasa) }}" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Cap. Anak (Kamar)</label>
                                <input type="number" name="max_anak" value="{{ old('max_anak', $fasilitas->max_anak) }}" class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none transition-all duration-300 shadow-sm font-semibold">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Labels / Fitur</label>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <template x-for="label in labels[tipe]" :key="label">
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="labels[]" :value="label" x-model="selectedLabels" class="hidden">
                                        <span :class="selectedLabels.includes(label) ? 'bg-[#1265A8] text-white border-[#1265A8]' : 'bg-white text-slate-400 border-slate-200'" class="px-4 py-2 rounded-xl border text-[10px] font-black uppercase tracking-widest transition-all duration-300 block" x-text="label"></span>
                                    </label>
                                </template>
                            </div>
                            <div class="flex gap-2">
                                <input type="text" x-model="customLabel" @keydown.enter.prevent="addCustomLabel()" placeholder="Tambah fitur custom..." class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[10px] font-bold outline-none focus:border-[#1265A8] transition-all">
                                <button type="button" @click="addCustomLabel()" class="px-4 py-2 bg-[#1265A8] text-white rounded-xl hover:bg-slate-800 transition-all font-black text-sm">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Biaya Harian</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-[#1265A8]">Rp</span>
                                    <input type="text" id="hargaDisplay" value="{{ number_format(old('harga', $fasilitas->harga), 0, ',', '.') }}" 
                                        class="w-full pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none font-bold transition-all" required>
                                    <input type="hidden" name="harga" id="hargaReal" value="{{ old('harga', $fasilitas->harga) }}">
                                </div>
                            </div>
                            <div x-show="tipe === 'asrama'">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Biaya Bulanan</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-[#1265A8]">Rp</span>
                                    <input type="number" name="harga_bulanan" value="{{ old('harga_bulanan', $fasilitas->harga_bulanan) }}" 
                                        class="w-full pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1265A8] outline-none font-bold transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            {{-- Thumbnail Upload --}}
                            <div class="w-full">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Thumbnail Cards</label>
                                <div id="dropzone" class="relative overflow-hidden rounded-[2rem] border-2 border-dashed border-slate-200 bg-slate-50/50 hover:border-[#1265A8] transition-all duration-500 h-48 flex items-center justify-center group/drop cursor-pointer">
                                    <img id="preview" src="{{ $fasilitas->image ? asset('storage/fasilitas/' . $fasilitas->image) : '' }}" class="absolute inset-0 w-full h-full object-cover z-10">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/drop:opacity-100 transition-opacity duration-300 z-20 flex flex-col items-center justify-center text-white">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Change Photo</span>
                                    </div>
                                    <input type="file" id="fileInput" name="image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-30">
                                </div>
                            </div>
                            
                            {{-- Preview Gallery (3 slots) --}}
                            <div class="w-full">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Preview Gallery (3 Foto)</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <template x-for="i in [0, 1, 2]" :key="i">
                                        <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:border-[#1265A8] transition-all duration-500 h-32 flex items-center justify-center group/gal cursor-pointer">
                                            <img :src="galleryPreviews[i]" class="absolute inset-0 w-full h-full object-cover z-10" x-show="galleryPreviews[i]">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/gal:opacity-100 transition-opacity duration-300 z-20 flex flex-col items-center justify-center text-white" x-show="galleryPreviews[i]">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </div>
                                            <div class="relative z-20 flex flex-col items-center" x-show="!galleryPreviews[i]">
                                                <svg class="w-5 h-5 text-slate-300 group-hover/gal:text-[#1265A8] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                            </div>
                                            <input :id="'galleryInput' + i" :name="'gallery[' + i + ']'" type="file" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-35" 
                                                @change="
                                                    const file = $event.target.files[0];
                                                    if (file) {
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => galleryPreviews[i] = e.target.result;
                                                        reader.readAsDataURL(file);
                                                    }
                                                ">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit" class="group relative flex-[2] flex items-center justify-center gap-3 py-5 rounded-2xl bg-[#1265A8] hover:bg-slate-900 text-white transition-all duration-500 active:scale-[0.97] shadow-lg shadow-blue-900/10">
                                <span class="text-xs font-black uppercase tracking-[0.2em]">Simpan Perubahan</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>

                            <button type="button" id="btn-batal" class="flex-1 flex items-center justify-center py-5 rounded-2xl border-2 border-slate-100 bg-white hover:border-red-100 hover:bg-red-50 transition-all duration-500 group">
                                <span class="text-xs font-black uppercase tracking-widest text-slate-400 group-hover:text-red-500">Batal</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Overlay Loading --}}
    <div id="loadingOverlay" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-white/80 backdrop-blur-md">
        <div class="flex flex-col items-center">
            <div class="relative w-16 h-16 mb-4">
                <div class="absolute inset-0 border-4 border-slate-100 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-[#1265A8] border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1265A8] animate-pulse">Menyimpan Perubahan...</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('facilityEditor', () => ({
                tipe: '{{ $fasilitas->tipe ?? 'asrama' }}',
                labels: {
                    asrama: [...new Set(['Shower', 'AC', 'Wifi', 'Parkir', 'TV', 'Lemari', ...@json($fasilitas->labels ?? [])])],
                    aula: [...new Set(['Wifi', 'Sound System', 'AC', 'Kursi', 'Meja', 'Panggung', 'Proyektor', ...@json($fasilitas->labels ?? [])])]
                },
                selectedLabels: @json($fasilitas->labels ?? []),
                customLabel: '',
                galleryPreviews: [
                    @if(isset($fasilitas->gallery[0])) '{{ asset('storage/fasilitas/gallery/' . $fasilitas->gallery[0]) }}' @else null @endif,
                    @if(isset($fasilitas->gallery[1])) '{{ asset('storage/fasilitas/gallery/' . $fasilitas->gallery[1]) }}' @else null @endif,
                    @if(isset($fasilitas->gallery[2])) '{{ asset('storage/fasilitas/gallery/' . $fasilitas->gallery[2]) }}' @else null @endif
                ],
                addCustomLabel() {
                    if (this.customLabel.trim() !== '') {
                        const label = this.customLabel.trim();
                        if (!this.labels[this.tipe].includes(label)) {
                            this.labels[this.tipe].push(label);
                        }
                        if (!this.selectedLabels.includes(label)) {
                            this.selectedLabels.push(label);
                        }
                        this.customLabel = '';
                    }
                },
                confirmTypeChange(newType) {
                    if (this.tipe === newType) return;
                    
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Data yang telah anda isi akan otomatis terhapus, Apakah anda yakin ingin mengubah type fasilitas?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1265A8',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Ubah Type',
                        cancelButtonText: 'Batalkan',
                        reverseButtons: true,
                        customClass: { popup: 'rounded-[2.5rem] p-8' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.tipe = newType;
                            this.selectedLabels = [];
                        }
                    });
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('fileInput');
            const preview = document.getElementById('preview');
            const urlAsal = "/admin/dashboard/dataFasilitas"; // Sesuaikan route list Anda

            // 1. Preview Gambar
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.classList.add('animate-fadeIn');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // 2. Currency Masking & Sync
            const hargaDisplay = document.getElementById('hargaDisplay');
            const hargaReal = document.getElementById('hargaReal');

            hargaDisplay.addEventListener('input', function(e) {
                // Remove all non-digits
                let value = this.value.replace(/\D/g, "");
                
                // Update hidden real value
                hargaReal.value = value;
                
                // Format display as currency (dots separator)
                if (value === "") {
                    this.value = "";
                    return;
                }
                
                this.value = new Intl.NumberFormat('id-ID').format(value);
            });

            // 3. Handle Submit Form
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Konfirmasi Update',
                    text: "Apakah data yang Anda masukkan sudah benar?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1265A8',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Cek Lagi',
                    reverseButtons: true,
                    customClass: { popup: 'rounded-[2.5rem] p-8' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('loadingOverlay').classList.remove('hidden');
                        form.submit(); // Kirim form asli ke server
                    }
                });
            });

            // 3. Handle Tombol Batal
            document.getElementById('btn-batal').addEventListener('click', () => {
                Swal.fire({
                    title: 'Batalkan Perubahan?',
                    text: "Ketikan Anda tidak akan disimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Tetap di Sini',
                    reverseButtons: true,
                    customClass: { popup: 'rounded-[2.5rem] p-8' }
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = urlAsal;
                });
            });
        });
    </script>
</body>
</html>