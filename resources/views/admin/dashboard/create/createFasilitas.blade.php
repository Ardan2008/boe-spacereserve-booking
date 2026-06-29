<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/image/logo/tutwuri-logo.svg">
    <title>BOE-Space Reserve | Add Fasilitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @keyframes vShake {
            0%,100% { transform: translateX(0); }
            20%      { transform: translateX(-5px); }
            40%      { transform: translateX(5px); }
            60%      { transform: translateX(-4px); }
            80%      { transform: translateX(4px); }
        }

        @keyframes toastIn {
            from { transform: translateX(110%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        @keyframes toastOut {
            from { transform: translateX(0);    opacity: 1; }
            to   { transform: translateX(110%); opacity: 0; }
        }
        @keyframes toastProgress {
            from { width: 100%; }
            to   { width: 0;    }
        }

        .v-field {
            transition: border-color .2s, box-shadow .2s, background-color .2s;
        }
        .v-field.v-error {
            border-color: #E24B4A !important;
            background-color: #fff9f9 !important;
            box-shadow: 0 0 0 4px rgba(226,75,74,.10) !important;
            animation: vShake .35s ease;
        }
        .v-field.v-success {
            border-color: #97C459 !important;
            background-color: #fafffe !important;
            box-shadow: 0 0 0 4px rgba(97,196,89,.10) !important;
        }

        .v-hint {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding-left: 2px;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height .25s ease, opacity .2s ease, margin-top .2s ease;
        }
        .v-hint.show {
            max-height: 40px;
            opacity: 1;
            margin-top: 6px;
        }
        .v-hint.hint-error   { color: #A32D2D; }
        .v-hint.hint-warning { color: #854F0B; }
        .v-hint.hint-success { color: #3B6D11; }

        .v-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }
        .v-icon.show { opacity: 1; }

        .v-progress-wrap {
            height: 3px;
            border-radius: 99px;
            background: #e2e8f0;
            margin-top: 8px;
            overflow: hidden;
            opacity: 0;
            transition: opacity .2s;
        }
        .v-progress-wrap.show { opacity: 1; }
        .v-progress-bar {
            height: 100%;
            border-radius: 99px;
            width: 0%;
            transition: width .3s ease, background-color .3s ease;
        }

        .v-char-counter {
            position: absolute;
            right: 14px;
            bottom: 12px;
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            pointer-events: none;
            transition: color .2s;
        }
        .v-char-counter.warn   { color: #BA7517; }
        .v-char-counter.danger { color: #E24B4A; }

        #v-toast-stack {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 9999;
            pointer-events: none;
        }
        .v-toast {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #ffffff;
            border-radius: 18px;
            padding: 14px 16px;
            min-width: 290px;
            max-width: 350px;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 8px 32px rgba(0,0,0,.10);
            pointer-events: all;
            position: relative;
            overflow: hidden;
            animation: toastIn .3s cubic-bezier(.34,1.56,.64,1) forwards;
        }
        .v-toast.removing { animation: toastOut .25s ease forwards; }
        .v-toast-progress {
            position: absolute;
            bottom: 0; left: 0;
            height: 3px;
            border-radius: 0 0 18px 18px;
            animation: toastProgress linear forwards;
        }
        .v-toast-icon    { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
        .v-toast-body    { flex: 1; }
        .v-toast-title   { font-size: 13px; font-weight: 700; margin-bottom: 2px; }
        .v-toast-msg     { font-size: 11.5px; color: #64748b; line-height: 1.5; }
        .v-toast-close   {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; font-size: 16px; flex-shrink: 0;
            margin-top: 1px; transition: color .15s; padding: 0;
        }
        .v-toast-close:hover { color: #1e293b; }

        .v-toast.toast-error   .v-toast-icon     { color: #E24B4A; }
        .v-toast.toast-error   .v-toast-progress { background: #E24B4A; }
        .v-toast.toast-error   .v-toast-title    { color: #A32D2D; }
        .v-toast.toast-success .v-toast-icon     { color: #639922; }
        .v-toast.toast-success .v-toast-progress { background: #97C459; }
        .v-toast.toast-success .v-toast-title    { color: #3B6D11; }
        .v-toast.toast-warning .v-toast-icon     { color: #BA7517; }
        .v-toast.toast-warning .v-toast-progress { background: #EF9F27; }
        .v-toast.toast-warning .v-toast-title    { color: #854F0B; }

        #v-confirm-overlay {
            position: fixed; inset: 0;
            background: rgba(15,23,42,.45);
            backdrop-filter: blur(6px);
            z-index: 10000;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .2s;
        }
        #v-confirm-overlay.show { opacity: 1; pointer-events: all; }
        #v-confirm-box {
            background: #fff;
            border-radius: 28px;
            padding: 36px 32px 28px;
            max-width: 380px; width: 90%;
            box-shadow: 0 32px 64px rgba(0,0,0,.14);
            transform: scale(.92) translateY(12px);
            transition: transform .25s cubic-bezier(.34,1.56,.64,1);
            text-align: center;
        }
        #v-confirm-overlay.show #v-confirm-box { transform: scale(1) translateY(0); }
        .v-confirm-icon-wrap {
            width: 56px; height: 56px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 26px;
        }
        .v-confirm-title { font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        .v-confirm-text  { font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 24px; }
        .v-confirm-btns  { display: flex; gap: 10px; }
        .v-confirm-btns button {
            flex: 1; padding: 12px 0;
            border-radius: 14px; border: none;
            font-size: 12px; font-weight: 800;
            letter-spacing: .08em; text-transform: uppercase;
            cursor: pointer; transition: opacity .15s, transform .1s;
        }
        .v-confirm-btns button:active { transform: scale(.97); }
        .v-confirm-btn-cancel { background: #f1f5f9; color: #64748b; }
        .v-confirm-btn-cancel:hover { background: #e2e8f0; }
        .v-confirm-btn-ok     { background: #1d6fa5; color: #fff; }
        .v-confirm-btn-ok:hover { background: #155d8a; }
        .v-confirm-btn-ok.danger { background: #E24B4A; }
        .v-confirm-btn-ok.danger:hover { background: #A32D2D; }

        #dropzone.v-dz-error { border-color: #E24B4A !important; box-shadow: 0 0 0 4px rgba(226,75,74,.10); }

        .swal2-shown { padding-right: 0 !important; }

        .kamar-stepper-wrap {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: border-color .2s, box-shadow .2s;
        }
        .kamar-stepper-wrap:focus-within {
            border-color: #1d6fa5;
            box-shadow: 0 0 0 4px rgba(29,111,165,.10);
        }
        .kamar-stepper-wrap.v-error {
            border-color: #E24B4A !important;
            box-shadow: 0 0 0 4px rgba(226,75,74,.10) !important;
            animation: vShake .35s ease;
        }
        .kamar-stepper-btn {
            flex-shrink: 0;
            width: 52px;
            height: 56px;
            background: #f8fafc;
            border: none;
            font-size: 22px;
            font-weight: 900;
            color: #1d6fa5;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s, color .15s, transform .1s;
            user-select: none;
            line-height: 1;
        }
        .kamar-stepper-btn:hover  { background: #dbeafe; color: #1558a0; }
        .kamar-stepper-btn:active { transform: scale(.90); }
        .kamar-stepper-btn:disabled {
            color: #cbd5e1;
            cursor: not-allowed;
            background: #f8fafc;
        }
        .kamar-stepper-input {
            flex: 1;
            min-width: 0;
            border: none;
            border-left: 1.5px solid #e2e8f0;
            border-right: 1.5px solid #e2e8f0;
            text-align: center;
            font-size: 22px;
            font-weight: 900;
            color: #0f172a;
            background: transparent;
            outline: none;
            padding: 0;
            height: 56px;
            -moz-appearance: textfield;
        }
        .kamar-stepper-input::-webkit-outer-spin-button,
        .kamar-stepper-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

        .kamar-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            padding: 5px 12px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .05em;
            background: #f0f9ff;
            color: #0369a1;
            border: 1px solid #bae6fd;
            transition: all .2s;
        }

        /* â”€â”€ Room Slider â”€â”€ */
        .room-section {
            border-radius: 2rem;
            border: 2px dashed #e2e8f0;
            background: #fafcff;
            padding: 2rem;
            transition: border-color .3s, box-shadow .3s;
        }
        .room-section:hover {
            border-color: #bae6fd;
            box-shadow: 0 4px 24px rgba(29,111,165,0.04);
        }
        .room-slider-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .room-nav-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 1rem;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            font-size: 11px;
            font-weight: 800;
            color: #1d6fa5;
            cursor: pointer;
            transition: all .2s;
            user-select: none;
            white-space: nowrap;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
        .room-nav-btn:hover:not(:disabled) {
            background: #dbeafe;
            border-color: #93c5fd;
        }
        .room-nav-btn:active:not(:disabled) { transform: scale(.96); }
        .room-nav-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
        .room-dots {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .room-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #dbe0e8;
            transition: all .3s;
            cursor: pointer;
        }
        .room-dot.active {
            width: 28px;
            border-radius: 99px;
            background: #1d6fa5;
        }
        .room-dot:hover:not(.active) {
            background: #94a3b8;
        }
        .room-card {
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 1.75rem;
            transition: all .3s;
        }
        .room-card:focus-within {
            border-color: #1d6fa5;
            box-shadow: 0 0 0 4px rgba(29,111,165,.06);
        }

        /* Hybrid dropdown */
        .room-type-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.875rem 1.25rem;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 1rem;
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s;
        }
        .room-type-btn:hover {
            border-color: #93c5fd;
        }
        .room-type-btn:focus {
            outline: none;
            border-color: #1d6fa5;
            box-shadow: 0 0 0 4px rgba(29,111,165,.10);
        }
        .room-type-dropdown {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 12px 32px rgba(0,0,0,.08);
            z-index: 50;
            overflow: hidden;
        }
        .room-type-option {
            display: block;
            width: 100%;
            padding: 0.75rem 1.25rem;
            border: none;
            background: transparent;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            text-align: left;
            transition: background .1s;
        }
        .room-type-option:hover {
            background: #f1f5f9;
        }
        .room-type-option:not(:last-child) {
            border-bottom: 1px solid #f1f5f9;
        }
        .room-type-option.lainnya {
            border-top: 1.5px dashed #e2e8f0;
            color: #1d6fa5;
            font-weight: 800;
        }

    </style>
</head>
<body class="bg-[#F8FAFC] font-sans antialiased text-slate-800">

    {{-- Background blobs --}}
    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 blur-[120px] rounded-full opacity-50"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-indigo-100 blur-[120px] rounded-full opacity-50"></div>
    </div>

    <div class="py-12 px-4 sm:px-6 lg:px-8" x-data="facilityCreator()">
        <div class="w-full max-w-5xl mx-auto bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.08)] border border-white transition-all duration-500 hover:shadow-blue-200/40">

            {{-- Header --}}
            <div class="pt-16 pb-10 px-10 text-center">
                <div class="inline-flex items-center gap-3 px-6 py-2 mb-6 bg-blue-50/50 rounded-full border border-blue-100 shadow-sm">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-[#1d6fa5]"></span>
                    </span>
                    <span class="text-sm font-black uppercase tracking-[0.2em] text-[#1d6fa5]" x-text="'Management Portal | ' + tipe"></span>
                </div>
                <h2 class="text-5xl font-black text-slate-900 tracking-tight uppercase">
                    Add <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1d6fa5] to-blue-400" x-text="tipe === 'asrama' ? 'Asrama' : 'Aula'"></span> Data
                </h2>
                <div class="h-1 w-16 bg-gradient-to-r from-[#1d6fa5] to-blue-400 mx-auto mt-6 rounded-full"></div>

                {{-- Type Switcher --}}
                <div class="flex justify-center gap-4 mt-10">
                    <button type="button"
                        @click="switchTipe('asrama')"
                        :class="tipe === 'asrama' ? 'bg-[#1d6fa5] text-white shadow-lg' : 'bg-slate-100 text-slate-400 hover:bg-slate-200'"
                        class="px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all duration-300">Asrama</button>
                    <button type="button"
                        @click="switchTipe('aula')"
                        :class="tipe === 'aula' ? 'bg-[#1d6fa5] text-white shadow-lg' : 'bg-slate-100 text-slate-400 hover:bg-slate-200'"
                        class="px-8 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all duration-300">Aula</button>
                </div>
            </div>

            <form id="mainForm" action="/admin/fasilitas/store" method="POST" enctype="multipart/form-data"
                  class="p-10 lg:p-14 pt-8 space-y-10" novalidate>
                @csrf
                <input type="hidden" name="tipe" :value="tipe">
                <input type="hidden" name="paket_harian" id="paketHarianInput" value="">
                <input type="hidden" name="rooms_data" id="roomsDataInput" value="">
                <input type="hidden" name="jumlah_kamar" id="jumlahKamarAulaInput" :value="tipe === 'aula' ? 1 : null">
                <div id="labelsHiddenContainer"></div>

                {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
                     SECTION 1 - MAIN FACILITY INFO (single column)
                â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}

                {{-- 1. Nama Fasilitas --}}
                <div>
                    <label class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 ml-1">Nama Fasilitas</label>
                    <div class="relative">
                        <input type="text" name="nama" id="namaFasilitas" maxlength="60"
                            class="v-field w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm font-semibold"
                            required>
                        <svg id="icon-nama-ok" class="v-icon text-green-500 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <svg id="icon-nama-err" class="v-icon text-red-500 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div class="v-progress-wrap" id="pb-nama-wrap">
                        <div class="v-progress-bar" id="pb-nama"></div>
                    </div>
                    <p class="v-hint" id="hint-nama"></p>
                </div>

                {{-- 2. Deskripsi Singkat --}}
                <div>
                    <label class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 ml-1">Deskripsi Singkat</label>
                    <div class="relative">
                        <textarea name="deskripsi" id="deskripsiFasilitas" rows="3" maxlength="200"
                            class="v-field w-full px-6 py-4 pb-8 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm resize-none font-medium leading-relaxed"
                            required></textarea>
                        <span class="v-char-counter" id="cc-desc">200</span>
                    </div>
                    <p class="v-hint" id="hint-desc"></p>
                </div>

                {{-- 3. Detail Fasilitas --}}
                <div>
                    <label class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 ml-1">Detail Fasilitas</label>
                    <textarea name="detail" rows="5"
                        class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm resize-none font-medium leading-relaxed"></textarea>
                </div>

                {{-- 4. Jam Operasional --}}
                <div>
                    <label class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 ml-1">Jam Operasional</label>
                    <div class="relative">
                        <input type="text" name="jam_operasional" id="jamOperasional"
                            placeholder="08.00 - 22.00"
                            class="v-field w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm font-semibold"
                            required>
                    </div>
                    <p class="v-hint" id="hint-jam"></p>
                </div>

                {{-- 5. Thumbnail --}}
                <div>
                    <label class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 ml-1">Thumbnail Cards</label>
                    <div id="dropzone"
                        class="relative overflow-hidden rounded-[2rem] border-2 border-dashed border-slate-200 bg-slate-50/50 hover:border-[#1d6fa5] transition-all duration-500 h-48 flex items-center justify-center group/drop cursor-pointer">
                        <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden z-10" src="" alt="Preview thumbnail">
                        <div id="ui-content" class="relative z-20 flex flex-col items-center transition-opacity duration-300">
                            <div class="p-4 bg-white/90 backdrop-blur rounded-2xl shadow-lg mb-2 transform group-hover/drop:scale-110 transition-all duration-500">
                                <svg class="w-6 h-6 text-[#1d6fa5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-500">Pilih Foto Utama</p>
                        </div>
                        <input type="file" id="fileInput" name="image" accept="image/*"
                            class="absolute inset-0 opacity-0 cursor-pointer z-30" required>
                    </div>
                    <p class="v-hint" id="hint-thumb"></p>
                </div>

                {{-- 6. Gallery (3 Foto) --}}
                <div>
                    <label class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 ml-1">Preview Gallery (3 Foto)</label>
                    <div class="grid grid-cols-3 gap-3">
                        <template x-for="i in [0, 1, 2]" :key="i">
                            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:border-[#1d6fa5] transition-all duration-500 h-32 flex items-center justify-center group/gal cursor-pointer">
                                <img :src="galleryPreviews[i]" class="absolute inset-0 w-full h-full object-cover z-10" x-show="galleryPreviews[i]" alt="">
                                <div class="relative z-20 flex flex-col items-center" x-show="!galleryPreviews[i]">
                                    <svg class="w-5 h-5 text-slate-300 group-hover/gal:text-[#1d6fa5] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <input :id="'galleryInput' + i" :name="'gallery[' + i + ']'"
                                    type="file" accept="image/*"
                                    class="absolute inset-0 opacity-0 cursor-pointer z-30"
                                    @change="handleGalleryChange($event, i)">
                            </div>
                        </template>
                    </div>
                </div>

                {{-- 7. Jumlah Kamar Tersedia - stepper --}}
                <div x-show="tipe === 'asrama'" x-cloak>
                    <label class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 ml-1">
                        Jumlah Kamar Tersedia
                    </label>

                    <div class="kamar-stepper-wrap" id="kamarStepperWrap">

                        <button type="button"
                            id="btnKamarMinus"
                            class="kamar-stepper-btn"
                            onclick="window.kamarStep(-1)"
                            aria-label="Kurangi kamar">
                            −
                        </button>

                        <input
                            type="number"
                            name="jumlah_kamar"
                            id="jumlahKamar"
                            min="1"
                            max="999"
                            value="1"
                            class="kamar-stepper-input"
                            oninput="window.kamarOnInput(this)"
                            aria-label="Jumlah kamar">

                        <button type="button"
                            id="btnKamarPlus"
                            class="kamar-stepper-btn"
                            onclick="window.kamarStep(1)"
                            aria-label="Tambah kamar">
                            +
                        </button>

                    </div>

                    <div class="kamar-badge">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span id="kamarBadgeText">1 kamar tersedia</span>
                    </div>

                    <p class="v-hint" id="hint-kamar"></p>
                </div>

                {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
                     SECTION 2 - ROOM SPECIFICATIONS (conditional)
                â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}

                <div x-show="tipe === 'asrama' && jumlahKamar >= 1" x-cloak class="room-section w-full">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-black uppercase tracking-[0.15em] text-slate-400">
                            Spesifikasi Kamar
                        </h3>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#1d6fa5] bg-blue-50 px-3 py-1 rounded-full border border-blue-100"
                            x-text="'Total ' + jumlahKamar + ' kamar'"></span>
                    </div>

                    {{-- Slider Navigation - hanya tampil jika lebih dari 1 kamar --}}
                    <div class="room-slider-nav" x-show="jumlahKamar > 1" x-cloak>
                        <button type="button" @click="prevRoom()" :disabled="currentRoomIndex === 0" class="room-nav-btn">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </button>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black text-slate-500 whitespace-nowrap" x-text="'Kamar ' + (currentRoomIndex + 1) + ' / ' + rooms.length"></span>
                            <div class="room-dots">
                                <template x-for="(_, dIdx) in rooms" :key="dIdx">
                                    <button type="button"
                                        @click="currentRoomIndex = dIdx; showTypeDropdown = false"
                                        :class="dIdx === currentRoomIndex ? 'active' : ''"
                                        class="room-dot"></button>
                                </template>
                            </div>
                        </div>
                        <button type="button" @click="nextRoom()" :disabled="currentRoomIndex === rooms.length - 1" class="room-nav-btn">
                            Next
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    {{-- SATU template untuk semua kamar (fix duplikasi input file) --}}
                    <div x-show="jumlahKamar === 1 || true">
                        <template x-for="(room, rIdx) in rooms" :key="rIdx">
                            <div class="room-card space-y-5" x-show="jumlahKamar === 1 || currentRoomIndex === rIdx">
                                {{-- Room header --}}
                                <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Kamar</span>
                                    <span class="text-xs font-black text-[#1d6fa5]" x-text="rIdx + 1"></span>
                                </div>

                                {{-- Tipe Kamar - global dropdown --}}
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tipe Kamar</label>
                                    @include('admin.dashboard.partials._room_type_dropdown', ['roomIndex' => 'rIdx', 'roomsVar' => 'rooms'])
                                </div>

                                {{-- Keunggulan Tipe Kamar --}}
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Keunggulan Tipe Kamar</label>
                                    <textarea x-model="room.keunggulan" rows="2"
                                        placeholder="Deskripsi singkat keunggulan tipe kamar ini..."
                                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-medium text-sm resize-none"></textarea>
                                </div>

                                {{-- Ukuran (Panjang x Lebar) & Konfigurasi Ranjang --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ukuran Kamar</label>
                                        <div class="flex items-center gap-2">
                                            <div class="relative flex-1">
                                                <input type="number" x-model="room.panjang" min="0" step="0.1"
                                                    placeholder="0"
                                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm text-center">
                                            </div>
                                            <span class="text-lg font-black text-slate-400 flex-shrink-0">×</span>
                                            <div class="relative flex-1">
                                                <input type="number" x-model="room.lebar" min="0" step="0.1"
                                                    placeholder="0"
                                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm text-center">
                                            </div>
                                            <span class="text-xs font-black text-slate-400 flex-shrink-0 whitespace-nowrap">m²</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Konfigurasi Ranjang</label>
                                        <input type="text" x-model="room.ranjang"
                                            placeholder="Contoh: 1 King Bed"
                                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                    </div>
                                </div>

                                {{-- Jumlah Kamar + Kode Blok/Lantai --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Kamar</label>
                                        <input type="number" x-model.number="room.jumlah" min="1"
                                            :name="'rooms[' + rIdx + '][jumlah]'"
                                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                    </div>
                                </div>

                                {{-- Nomor Kamar Tagging --}}
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Kamar</label>
                                    <div class="flex gap-2">
                                        <input type="text"
                                            x-model="rooms[rIdx].temp_input"
                                            @keydown.enter.prevent="addNomorKamar(rIdx)"
                                            :disabled="rooms[rIdx].nomor_kamar.length >= rooms[rIdx].jumlah"
                                            :class="rooms[rIdx].nomor_kamar.length >= rooms[rIdx].jumlah ? 'bg-gray-100 cursor-not-allowed text-gray-400' : 'bg-white'"
                                            placeholder="Ketik nomor lalu Enter..."
                                            class="flex-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm transition-all">
                                        <button type="button"
                                            @click="addNomorKamar(rIdx)"
                                            :disabled="rooms[rIdx].nomor_kamar.length >= rooms[rIdx].jumlah"
                                            :class="rooms[rIdx].nomor_kamar.length >= rooms[rIdx].jumlah ? 'bg-gray-100 cursor-not-allowed text-gray-400' : 'bg-[#1d6fa5] text-white hover:bg-slate-800'"
                                            class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center transition-all font-black text-lg">
                                            +
                                        </button>
                                    </div>
                                    <div class="mt-1.5 text-[10px] font-bold">
                                        <span x-show="rooms[rIdx].nomor_kamar.length < rooms[rIdx].jumlah" class="text-red-500">
                                            🔴 Input Belum Selesai (<span x-text="rooms[rIdx].nomor_kamar.length"></span> dari <span x-text="rooms[rIdx].jumlah"></span>)
                                        </span>
                                        <span x-show="rooms[rIdx].nomor_kamar.length >= rooms[rIdx].jumlah && rooms[rIdx].jumlah > 0" class="text-green-600">
                                            🟢 Semua Nomor Kamar Telah Di-input (<span x-text="rooms[rIdx].jumlah"></span> dari <span x-text="rooms[rIdx].jumlah"></span>)
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                        <template x-for="(tag, tagIdx) in rooms[rIdx].nomor_kamar" :key="tagIdx">
                                            <span @click="removeNomorKamar(rIdx, tagIdx)"
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[#1d6fa5] text-[10px] font-black cursor-pointer hover:bg-red-50 hover:border-red-200 hover:text-red-500 transition-all select-none">
                                                <span x-text="tag"></span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </span>
                                        </template>
                                    </div>
                                </div>

                                {{-- Cap. Dewasa + Anak --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Cap. Dewasa (Kamar)</label>
                                        <input type="number" x-model.number="room.max_dewasa" min="1"
                                            :name="'rooms[' + rIdx + '][max_dewasa]'"
                                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Cap. Anak (Kamar)</label>
                                        <input type="number" x-model.number="room.max_anak" min="0"
                                            :name="'rooms[' + rIdx + '][max_anak]'"
                                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                    </div>
                                </div>

                                {{-- Foto Kamar (maks 3) --}}
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Foto Kamar (maks 3)</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <template x-for="fIdx in [0, 1, 2]" :key="fIdx">
                                            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:border-[#1d6fa5] transition-all duration-500 h-32 flex items-center justify-center group/gal cursor-pointer">
                                                <img :src="rooms[rIdx].fotoPreviews[fIdx]" class="absolute inset-0 w-full h-full object-cover z-10" x-show="rooms[rIdx].fotoPreviews[fIdx]" alt="">
                                                <div class="relative z-20 flex flex-col items-center" x-show="!rooms[rIdx].fotoPreviews[fIdx]">
                                                    <svg class="w-5 h-5 text-slate-300 group-hover/gal:text-[#1d6fa5] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </div>
                                                <input type="file" accept="image/*"
                                                    :name="'room_fotos[' + rIdx + '][' + fIdx + ']'"
                                                    class="absolute inset-0 opacity-0 cursor-pointer z-30"
                                                    @change="handleRoomFoto($event, rIdx, fIdx)">
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                        {{-- Fasilitas Kamar - 10 icon cards with micro-inputs --}}
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Fasilitas Kamar</label>
                                            <div class="grid grid-cols-5 sm:grid-cols-5 gap-2">
                                                <template x-if="room.fasShow.ac"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">AC</span>
                                                    <input type="number" x-model.number="room.fasilitas.ac" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.ac = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.kipas_angin"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Kipas Angin</span>
                                                    <input type="number" x-model.number="room.fasilitas.kipas_angin" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.kipas_angin = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.meja_kursi"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Meja & Kursi</span>
                                                    <input type="number" x-model.number="room.fasilitas.meja_kursi" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.meja_kursi = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.lemari_locker"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Lemari / Locker</span>
                                                    <input type="number" x-model.number="room.fasilitas.lemari_locker" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.lemari_locker = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.stopkontak"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Stopkontak</span>
                                                    <input type="number" x-model.number="room.fasilitas.stopkontak" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.stopkontak = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.kamar_mandi_dalam"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">K. Mandi Dalam</span>
                                                    <input type="number" x-model.number="room.fasilitas.kamar_mandi_dalam" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.kamar_mandi_dalam = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.water_heater"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Water Heater</span>
                                                    <input type="number" x-model.number="room.fasilitas.water_heater" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.water_heater = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.bantal_set_sprei"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Bantal & Sprei</span>
                                                    <input type="number" x-model.number="room.fasilitas.bantal_set_sprei" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.bantal_set_sprei = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.gantungan_baju"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Gantungan Baju</span>
                                                    <input type="number" x-model.number="room.fasilitas.gantungan_baju" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.gantungan_baju = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                <template x-if="room.fasShow.kaca_rias"><div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center">Kaca Rias</span>
                                                    <input type="number" x-model.number="room.fasilitas.kaca_rias" min="0" placeholder="0"
                                                        class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                    <button type="button" @click="room.fasShow.kaca_rias = false"
                                                        class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                </div></template>
                                                {{-- Custom Fasilitas --}}
                                                <template x-for="(cf, cfIdx) in room.customFasilitas" :key="cfIdx">
                                                    <div class="relative group/label flex flex-col items-center bg-white border border-slate-200 rounded-xl px-2 py-3 transition-all duration-200 hover:border-[#1d6fa5] hover:shadow-sm">
                                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-wider mb-1 leading-tight text-center" x-text="cf.nama"></span>
                                                        <input type="number" x-model.number="cf.jumlah" min="0" placeholder="0"
                                                            class="w-12 h-7 text-center bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-xs">
                                                        <button type="button" @click="removeCustomFasilitas(rIdx, cfIdx)"
                                                            class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-sm font-bold opacity-0 group-hover/label:opacity-100 pointer-events-none group-hover/label:pointer-events-auto transition-opacity duration-200">&times;</button>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="flex gap-2 mt-3">
                                                <input type="text" x-model="room.customFasNama" @keydown.enter.prevent="addCustomFasilitas(rIdx)"
                                                    placeholder="Tambah fasilitas (contoh: Lampu)..."
                                                    class="flex-1 px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[10px] font-bold outline-none focus:border-[#1d6fa5] transition-all">
                                                <button type="button" @click="addCustomFasilitas(rIdx)"
                                                    class="px-4 py-2 bg-[#1d6fa5] text-white rounded-xl hover:bg-slate-800 transition-all font-black text-sm">+</button>
                                            </div>
                                        </div>

                                        {{-- Harga - 2x2 grid --}}
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        {{-- Harian --}}
                                        <div>
                                            <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Harian</span>
                                            <div class="relative">
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                                <input type="text"
                                                    @input="
                                                        const raw = $event.target.value.replace(/\D/g, '');
                                                        room.harga_harian = raw;
                                                        $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                                    "
                                                    class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                                <input type="hidden" :name="'rooms[' + rIdx + '][harga_harian]'" :value="room.harga_harian">
                                            </div>
                                        </div>
                                        {{-- Mingguan --}}
                                        <div>
                                            <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Mingguan</span>
                                            <div class="relative">
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                                <input type="text"
                                                    @input="
                                                        const raw = $event.target.value.replace(/\D/g, '');
                                                        room.harga_mingguan = raw;
                                                        $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                                    "
                                                    class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                                <input type="hidden" :name="'rooms[' + rIdx + '][harga_mingguan]'" :value="room.harga_mingguan">
                                            </div>
                                        </div>
                                        {{-- Bulanan --}}
                                        <div>
                                            <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Bulanan</span>
                                            <div class="relative">
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                                <input type="text"
                                                    @input="
                                                        const raw = $event.target.value.replace(/\D/g, '');
                                                        room.harga_bulanan = raw;
                                                        $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                                    "
                                                    class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                                <input type="hidden" :name="'rooms[' + rIdx + '][harga_bulanan]'" :value="room.harga_bulanan">
                                            </div>
                                        </div>
                                        {{-- Tahunan --}}
                                        <div>
                                            <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Tahunan</span>
                                            <div class="relative">
                                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                                <input type="text"
                                                    @input="
                                                        const raw = $event.target.value.replace(/\D/g, '');
                                                        room.harga_tahunan = raw;
                                                        $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                                    "
                                                    class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm">
                                                <input type="hidden" :name="'rooms[' + rIdx + '][harga_tahunan]'" :value="room.harga_tahunan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>



                {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
                     ADDITIONAL FIELDS
                â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}

                {{-- Max Durasi / Kapasitas --}}
                {{-- Max Durasi Sewa (4-column grid, asrama only) --}}
                <div x-show="tipe === 'asrama'" x-cloak>
                    <label class="block pt-10 text-sm font-black text-slate-400 uppercase tracking-widest mb-6 ml-1">Max Durasi Sewa</label>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

                        {{-- Max Durasi Hari --}}
                        <div>
                            <label class="block text-xs font-black text-[#1265A8] uppercase tracking-widest mb-3 ml-1">Hari</label>
                            <input type="number" name="max_durasi_hari" min="0" value="0"
                                class="w-full px-6 py-4 text-center bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm font-semibold text-gray-800 transition-all duration-300">
                        </div>

                        {{-- Max Durasi Minggu --}}
                        <div>
                            <label class="block text-xs font-black text-[#1265A8] uppercase tracking-widest mb-3 ml-1">Minggu</label>
                            <input type="number" name="max_durasi_minggu" min="0" value="0"
                                class="w-full px-6 py-4 text-center bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm font-semibold text-gray-800 transition-all duration-300">
                        </div>

                        {{-- Max Durasi Bulan --}}
                        <div>
                            <label class="block text-xs font-black text-[#1265A8] uppercase tracking-widest mb-3 ml-1">Bulan</label>
                            <input type="number" name="max_durasi_bulan" min="0" value="0"
                                class="w-full px-6 py-4 text-center bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm font-semibold text-gray-800 transition-all duration-300">
                        </div>

                        {{-- Max Durasi Tahun --}}
                        <div>
                            <label class="block text-xs font-black text-[#1265A8] uppercase tracking-widest mb-3 ml-1">Tahun</label>
                            <input type="number" name="max_durasi_tahun" min="0" value="0"
                                class="w-full px-6 py-4 text-center bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none shadow-sm font-semibold text-gray-800 transition-all duration-300">
                        </div>

                    </div>
                </div>

                {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
                     SECTION AULA - Spesifikasi Aula
                â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}

                <div x-show="tipe === 'aula'" x-cloak class="aula-section w-full">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-black uppercase tracking-[0.15em] text-slate-400">
                            Spesifikasi Aula
                        </h3>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#1d6fa5] bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                            Ruang Serbaguna
                        </span>
                    </div>

                    <div class="space-y-8">

                        {{-- Ukuran Aula --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ukuran Aula</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="aula_panjang" id="aulaPanjang" min="0" step="0.1" placeholder="0"
                                    @input="aulaHitungLuas()"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm text-center shadow-sm">
                                <span class="text-lg font-black text-slate-400 flex-shrink-0">×</span>
                                <input type="number" name="aula_lebar" id="aulaLebar" min="0" step="0.1" placeholder="0"
                                    @input="aulaHitungLuas()"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm text-center shadow-sm">
                                <span class="text-xs font-black text-slate-400 flex-shrink-0 whitespace-nowrap">m²</span>
                            </div>
                            <div class="mt-2 px-4 py-2 bg-blue-50/50 border border-blue-100 rounded-xl font-bold text-sm text-[#1d6fa5] shadow-sm">
                                <span x-text="aulaLuas ? 'Luas: ' + Number(aulaLuas).toLocaleString('id-ID') + ' m²' : '—'"></span>
                            </div>
                        </div>

                        {{-- Kapasitas Aula --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kapasitas (Orang)</label>
                            <input type="number" name="max_dewasa_aula" id="maxDewasaAula" min="1" placeholder="Contoh: 200"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm"
                                :required="tipe === 'aula'">
                            <p class="v-hint" id="hint-kap-aula"></p>
                        </div>

                        {{-- Fasilitas Aula --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Fasilitas Aula</label>

                            {{-- List fasilitas yang sudah ditambah --}}
                            <div class="space-y-2 mb-3" x-show="aulaFasilitas.length > 0">
                                <template x-for="(fas, fasIdx) in aulaFasilitas" :key="fasIdx">
                                    <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-2.5 hover:border-[#1d6fa5] transition-all group/fas">
                                        <span class="flex-1 text-xs font-black text-slate-700 uppercase tracking-wide" x-text="fas.nama"></span>
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <button type="button" @click="fas.jumlah > 1 && fas.jumlah--"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-black text-base flex items-center justify-center transition-all">−</button>
                                            <span class="w-8 text-center text-sm font-black text-slate-800" x-text="fas.jumlah"></span>
                                            <button type="button" @click="fas.jumlah++"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-black text-base flex items-center justify-center transition-all">+</button>
                                        </div>
                                        <button type="button" @click="aulaFasilitas.splice(fasIdx, 1)"
                                            class="w-7 h-7 rounded-lg bg-red-50 hover:bg-red-500 text-red-400 hover:text-white font-black text-base flex items-center justify-center transition-all opacity-0 group-hover/fas:opacity-100 flex-shrink-0">×</button>
                                    </div>
                                </template>
                            </div>

                            {{-- Form tambah: nama + jumlah + tombol + --}}
                            <div class="flex items-center gap-2">
                                <input type="text" x-model="aulaFasNama"
                                    @keydown.enter.prevent="if(aulaFasNama.trim() && aulaFasJumlah >= 1){ aulaFasilitas.push({nama:aulaFasNama.trim(), jumlah:aulaFasJumlah}); aulaFasNama=''; aulaFasJumlah=1; }"
                                    placeholder="Nama fasilitas (misal: AC)"
                                    class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none focus:border-[#1d6fa5] transition-all">
                                <input type="number" x-model.number="aulaFasJumlah" min="1"
                                    @keydown.enter.prevent="if(aulaFasNama.trim() && aulaFasJumlah >= 1){ aulaFasilitas.push({nama:aulaFasNama.trim(), jumlah:aulaFasJumlah}); aulaFasNama=''; aulaFasJumlah=1; }"
                                    placeholder="Jml"
                                    class="w-20 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-black text-center outline-none focus:border-[#1d6fa5] transition-all">
                                <button type="button"
                                    @click="if(aulaFasNama.trim() && aulaFasJumlah >= 1){ aulaFasilitas.push({nama:aulaFasNama.trim(), jumlah:aulaFasJumlah}); aulaFasNama=''; aulaFasJumlah=1; }"
                                    class="px-4 py-2.5 bg-[#1d6fa5] text-white rounded-xl hover:bg-slate-800 transition-all font-black text-sm flex-shrink-0">+</button>
                            </div>
                            <p class="text-[9px] text-slate-400 font-medium mt-1.5 ml-1">Isi nama dan jumlah, lalu tekan Enter atau klik +. Hover item untuk hapus.</p>
                        </div>

                        {{-- Harga Sewa Aula --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga Sewa</label>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Per Hari</span>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                        <input type="text" id="aulaHargaHarian"
                                            @input="
                                                const raw = $event.target.value.replace(/\D/g, '');
                                                aulaHargaHarian = raw;
                                                $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                            "
                                            placeholder="0"
                                            class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                        <input type="hidden" name="aula_harga_harian" :value="aulaHargaHarian">
                                    </div>
                                </div>
                                <div>
                                    <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Per Minggu</span>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                        <input type="text" id="aulaHargaMingguan"
                                            @input="
                                                const raw = $event.target.value.replace(/\D/g, '');
                                                aulaHargaMingguan = raw;
                                                $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                            "
                                            placeholder="0"
                                            class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                        <input type="hidden" name="aula_harga_mingguan" :value="aulaHargaMingguan">
                                    </div>
                                </div>
                                <div>
                                    <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Per Bulan</span>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                        <input type="text" id="aulaHargaBulanan"
                                            @input="
                                                const raw = $event.target.value.replace(/\D/g, '');
                                                aulaHargaBulanan = raw;
                                                $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                            "
                                            placeholder="0"
                                            class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                        <input type="hidden" name="aula_harga_bulanan" :value="aulaHargaBulanan">
                                    </div>
                                </div>
                                <div>
                                    <span class="block text-[9px] font-bold text-slate-500 mb-1 ml-1 uppercase tracking-wider">Per Tahun</span>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-[#1d6fa5] text-xs pointer-events-none">Rp</span>
                                        <input type="text" id="aulaHargaTahunan"
                                            @input="
                                                const raw = $event.target.value.replace(/\D/g, '');
                                                aulaHargaTahunan = raw;
                                                $event.target.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                            "
                                            placeholder="0"
                                            class="w-full pl-9 pr-3 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                        <input type="hidden" name="aula_harga_tahunan" :value="aulaHargaTahunan">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Max Durasi Sewa --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Max Durasi Sewa</label>
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Hari</label>
                                    <input type="number" name="max_durasi_hari" min="0" value="0"
                                        class="w-full px-4 py-3 text-center bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Minggu</label>
                                    <input type="number" name="max_durasi_minggu" min="0" value="0"
                                        class="w-full px-4 py-3 text-center bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Bulan</label>
                                    <input type="number" name="max_durasi_bulan" min="0" value="0"
                                        class="w-full px-4 py-3 text-center bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tahun</label>
                                    <input type="number" name="max_durasi_tahun" min="0" value="0"
                                        class="w-full px-4 py-3 text-center bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-[#1d6fa5] outline-none font-bold text-sm shadow-sm">
                                </div>
                            </div>
                        </div>

                        {{-- Labels / Fitur Aula --}}
                        <div>
                            <label class="block text-sm font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Labels / Fitur</label>
                            <div class="flex flex-wrap gap-3 mb-4">
                                <template x-for="label in labels['aula']" :key="label">
                                    <div class="relative group/label">
                                        <label class="cursor-pointer">
                                            <input type="checkbox" :value="label" x-model="selectedLabelsAula" class="hidden">
                                            <span :class="selectedLabelsAula.includes(label) ? 'bg-[#1d6fa5] text-white border-[#1d6fa5]' : 'bg-white text-slate-400 border-slate-200'"
                                                class="relative px-5 py-3 rounded-xl border text-xs font-black uppercase tracking-widest transition-all duration-300 inline-flex items-center"
                                                x-text="label"></span>
                                            <button type="button" @click="removeLabelAula(label)"
                                                class="absolute top-0 right-0 bg-red-500/20 text-red-600 text-lg font-bold opacity-0 group-hover/label:opacity-100 transition-opacity duration-200 rounded-xl"
                                                x-show="labels['aula'].length > 1">&times;</button>
                                        </label>
                                    </div>
                                </template>
                            </div>
                            <div class="flex gap-3">
                                <input type="text" x-model="customLabelAula" @keydown.enter.prevent="addCustomLabelAula()"
                                    placeholder="Tambah fitur custom..."
                                    class="flex-1 px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none focus:border-[#1d6fa5] transition-all">
                                <button type="button" @click="addCustomLabelAula()"
                                    class="px-5 py-3 bg-[#1d6fa5] text-white rounded-xl hover:bg-slate-800 transition-all font-black text-sm">+</button>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Labels / Fitur Asrama --}}
                <div x-show="tipe === 'asrama'" x-cloak>
                    <label class="block pt-10 text-sm font-black text-slate-400 uppercase tracking-widest mb-6 ml-1">Labels / Fitur</label>
                    <div class="flex flex-wrap gap-3 mb-4">
                        <template x-for="label in labels['asrama']" :key="label">
                            <div class="relative group/label">
                                <label class="cursor-pointer">
                                    <input type="checkbox" :value="label" x-model="selectedLabelsAsrama" class="hidden">
                                    <span :class="selectedLabelsAsrama.includes(label) ? 'bg-[#1d6fa5] text-white border-[#1d6fa5]' : 'bg-white text-slate-400 border-slate-200'"
                                        class="relative px-5 py-3 rounded-xl border text-xs font-black uppercase tracking-widest transition-all duration-300 inline-flex items-center"
                                        x-text="label"></span>
                                    <button type="button" @click="removeLabelAsrama(label)"
                                        class="absolute top-0 right-0 bg-red-500/20 text-red-600 text-lg font-bold opacity-0 group-hover/label:opacity-100 transition-opacity duration-200 rounded-xl"
                                        x-show="labels['asrama'].length > 1">&times;</button>
                                </label>
                            </div>
                        </template>
                    </div>
                    <div class="flex gap-3">
                        <input type="text" x-model="customLabelAsrama" @keydown.enter.prevent="addCustomLabelAsrama()"
                            placeholder="Tambah fitur custom..."
                            class="flex-1 px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none focus:border-[#1d6fa5] transition-all">
                        <button type="button" @click="addCustomLabelAsrama()"
                            class="px-5 py-3 bg-[#1d6fa5] text-white rounded-xl hover:bg-slate-800 transition-all font-black text-sm">+</button>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex flex-col sm:flex-row-reverse gap-4 pt-8 mt-6 border-t border-slate-100/50">
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

                    <div class="w-full sm:w-1/3">
                        <a href="#" id="btn-batal-venue"
                            class="group w-full flex items-center justify-center gap-2 py-5 px-8 rounded-2xl border-2 border-slate-100 bg-white transition-all duration-300 hover:border-red-100 hover:bg-red-50 active:scale-[0.98] relative overflow-hidden cursor-pointer no-underline">
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
            </form>
        </div>
    </div>

    {{-- Loading overlay --}}
    <div id="loadingOverlay" class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-slate-50/60 backdrop-blur-sm transition-all duration-500">
        <div class="flex flex-col items-center">
            <div class="relative w-16 h-16 mb-8">
                <div class="absolute inset-0 border-4 border-slate-200 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-[#1d6fa5] border-t-transparent rounded-full animate-spin"></div>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-slate-800 tracking-tight">Memproses data</h3>
                <div class="flex justify-center gap-1 mt-2">
                    <span class="w-1.5 h-1.5 bg-[#1d6fa5] rounded-full animate-bounce [animation-delay:-0.3s]"></span>
                    <span class="w-1.5 h-1.5 bg-[#1d6fa5] rounded-full animate-bounce [animation-delay:-0.15s]"></span>
                    <span class="w-1.5 h-1.5 bg-[#1d6fa5] rounded-full animate-bounce"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast stack --}}
    <div id="v-toast-stack" aria-live="polite" aria-label="Notifikasi"></div>

    {{-- Custom confirm dialog --}}
    <div id="v-confirm-overlay" role="dialog" aria-modal="true" aria-labelledby="v-confirm-title">
        <div id="v-confirm-box">
            <div class="v-confirm-icon-wrap" id="v-confirm-icon-wrap"></div>
            <div class="v-confirm-title" id="v-confirm-title"></div>
            <div class="v-confirm-text"  id="v-confirm-text"></div>
            <div class="v-confirm-btns">
                <button class="v-confirm-btn-cancel" id="v-confirm-cancel"></button>
                <button class="v-confirm-btn-ok"     id="v-confirm-ok"></button>
            </div>
        </div>
    </div>

    <script>
    window.kamarStep = function (delta) {
        const input  = document.getElementById('jumlahKamar');
        if (!input) return;
        const cur  = parseInt(input.value) || 1;
        const next = Math.min(999, Math.max(1, cur + delta));
        input.value = next;
        window.kamarSyncUI(next);
    };

    window.kamarOnInput = function (el) {
        let val = parseInt(el.value);
        if (isNaN(val) || val < 1) val = 1;
        if (val > 999) val = 999;
        el.value = val;
        window.kamarSyncUI(val);
    };

    window.kamarSyncUI = function (val) {
        const btnMin = document.getElementById('btnKamarMinus');
        const badge  = document.getElementById('kamarBadgeText');
        const hint   = document.getElementById('hint-kamar');
        const wrap   = document.getElementById('kamarStepperWrap');

        if (btnMin) btnMin.disabled = (val <= 1);
        if (badge)  badge.textContent = val + ' kamar tersedia';

        if (wrap && val >= 1) {
            wrap.classList.remove('v-error');
        }
        if (hint && val >= 1) {
            hint.className = 'v-hint';
        }

        document.dispatchEvent(new CustomEvent('kamar-changed', { detail: { value: val } }));
    };

    document.addEventListener('DOMContentLoaded', () => {

        const MAX_FILE_SIZE = 2 * 1024 * 1024;
        const MAX_POST_SIZE = 8 * 1024 * 1024;

        const $ = id => document.getElementById(id);

        function formatBytes(bytes) {
            const k = 1024, s = ['Bytes','KB','MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return `${parseFloat((bytes / Math.pow(k, i)).toFixed(2))} ${s[i]}`;
        }

        function checkTotalSize() {
            let total = 0;
            if ($('fileInput').files[0]) total += $('fileInput').files[0].size;
            for (let i = 0; i < 3; i++) {
                const g = $('galleryInput' + i);
                if (g && g.files[0]) total += g.files[0].size;
            }
            document.querySelectorAll('input[name^="room_fotos"]').forEach(el => {
                if (el.files[0]) total += el.files[0].size;
            });
            return total;
        }

        window.kamarSyncUI(1);

        function showToast(type, title, msg, duration = 4500) {
            const stack = $('v-toast-stack');
            const icons = {
                error:   `<svg class="v-toast-icon" style="color:#E24B4A" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>`,
                success: `<svg class="v-toast-icon" style="color:#639922" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`,
                warning: `<svg class="v-toast-icon" style="color:#BA7517" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`,
            };
            const t = document.createElement('div');
            t.className = `v-toast toast-${type}`;
            t.innerHTML = `
                ${icons[type]}
                <div class="v-toast-body">
                    <div class="v-toast-title">${title}</div>
                    <div class="v-toast-msg">${msg}</div>
                </div>
                <button class="v-toast-close" aria-label="Tutup">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div class="v-toast-progress" style="animation-duration:${duration}ms"></div>
            `;
            stack.appendChild(t);
            const close = () => {
                t.classList.add('removing');
                setTimeout(() => t.remove(), 280);
            };
            t.querySelector('.v-toast-close').onclick = close;
            setTimeout(close, duration);
        }

        function showConfirm({ icon, iconBg, iconColor, title, text, okLabel, okDanger, cancelLabel }) {
            return new Promise(resolve => {
                const overlay  = $('v-confirm-overlay');
                const iconWrap = $('v-confirm-icon-wrap');

                const svgs = {
                    question: `<svg width="28" height="28" fill="none" stroke="${iconColor}" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><circle cx="12" cy="17" r=".5" fill="${iconColor}"/></svg>`,
                    warning:  `<svg width="28" height="28" fill="none" stroke="${iconColor}" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
                };

                iconWrap.style.background = iconBg;
                iconWrap.innerHTML = svgs[icon] || svgs.question;
                $('v-confirm-title').textContent = title;
                $('v-confirm-text').textContent  = text;

                const btnOk     = $('v-confirm-ok');
                const btnCancel = $('v-confirm-cancel');
                btnOk.textContent     = okLabel     || 'OK';
                btnCancel.textContent = cancelLabel || 'Batal';
                btnOk.className = 'v-confirm-btn-ok' + (okDanger ? ' danger' : '');

                overlay.classList.add('show');

                const onOk = () => { cleanup(); resolve(true);  };
                const onNo = () => { cleanup(); resolve(false); };
                const onBg = (e) => { if (e.target === overlay) onNo(); };

                btnOk.addEventListener('click', onOk);
                btnCancel.addEventListener('click', onNo);
                overlay.addEventListener('click', onBg);

                function cleanup() {
                    overlay.classList.remove('show');
                    btnOk.removeEventListener('click', onOk);
                    btnCancel.removeEventListener('click', onNo);
                    overlay.removeEventListener('click', onBg);
                }
            });
        }

        function setFieldState(inputEl, state, hintEl, hintText, hintClass, iconOkEl, iconErrEl) {
            inputEl.classList.remove('v-error', 'v-success');
            if (iconOkEl) iconOkEl.classList.remove('show');
            if (iconErrEl) iconErrEl.classList.remove('show');

            if (state === 'error') {
                inputEl.classList.add('v-error');
                if (iconErrEl) iconErrEl.classList.add('show');
            } else if (state === 'success') {
                inputEl.classList.add('v-success');
                if (iconOkEl) iconOkEl.classList.add('show');
            }

            if (hintEl) {
                hintEl.className = 'v-hint';
                if (hintText) {
                    hintEl.textContent = hintText;
                    hintEl.classList.add('show', hintClass || 'hint-error');
                }
            }
        }

        function clearField(inputEl, hintEl, iconOkEl, iconErrEl) {
            inputEl.classList.remove('v-error', 'v-success');
            if (hintEl)    { hintEl.className = 'v-hint'; }
            if (iconOkEl)  iconOkEl.classList.remove('show');
            if (iconErrEl) iconErrEl.classList.remove('show');
        }

        /* â”€â”€ NAMA FASILITAS â”€â”€ */
        const namaInput   = $('namaFasilitas');
        const hintNama    = $('hint-nama');
        const iconNamaOk  = $('icon-nama-ok');
        const iconNamaErr = $('icon-nama-err');
        const pbWrap      = $('pb-nama-wrap');
        const pb          = $('pb-nama');
        const rgxNama     = /^[a-zA-Z0-9\s.\-',()&\/]+$/;

        namaInput.addEventListener('input', function () {
            const val = this.value;
            const len = val.trim().length;

            if (!val) {
                clearField(namaInput, hintNama, iconNamaOk, iconNamaErr);
                pbWrap.classList.remove('show');
                return;
            }

            pbWrap.classList.add('show');
            pb.style.width = Math.min(len / 60 * 100, 100) + '%';

            if (!rgxNama.test(val)) {
                pb.style.backgroundColor = '#E24B4A';
                setFieldState(namaInput, 'error', hintNama, 'Hanya huruf, angka, spasi, dan tanda baca umum yang diperbolehkan.', 'hint-error', iconNamaOk, iconNamaErr);
            } else if (len < 2) {
                pb.style.backgroundColor = '#EF9F27';
                setFieldState(namaInput, 'error', hintNama, 'Minimal 2 karakter.', 'hint-warning', iconNamaOk, iconNamaErr);
            } else {
                pb.style.backgroundColor = '#97C459';
                setFieldState(namaInput, 'success', hintNama, 'Nama terlihat bagus!', 'hint-success', iconNamaOk, iconNamaErr);
            }
        });

        /* â”€â”€ DESKRIPSI â”€â”€ */
        const descInput = $('deskripsiFasilitas');
        const hintDesc  = $('hint-desc');
        const ccDesc    = $('cc-desc');

        descInput.addEventListener('input', function () {
            const left = 200 - this.value.length;
            ccDesc.textContent = left;
            ccDesc.className = 'v-char-counter' + (left < 10 ? ' danger' : left < 30 ? ' warn' : '');

            if (this.value.trim()) {
                setFieldState(descInput, 'success', hintDesc, '', '');
            } else {
                clearField(descInput, hintDesc, null, null);
            }
        });

        /* â”€â”€ THUMBNAIL â”€â”€ */
        const fileInput  = $('fileInput');
        const preview    = $('preview');
        const uiContent  = $('ui-content');
        const dropzone   = $('dropzone');
        const hintThumb  = $('hint-thumb');

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            if (file.size > MAX_FILE_SIZE) {
                showToast('warning', 'File terlalu besar',
                    `Ukuran (${formatBytes(file.size)}) melebihi batas 2MB. Pilih file yang lebih kecil.`);
                this.value = '';
                dropzone.classList.add('v-dz-error');
                setFieldState(dropzone, 'error', hintThumb, 'File melebihi 2MB.', 'hint-error', null, null);
                return;
            }

            dropzone.classList.remove('v-dz-error');
            clearField(dropzone, hintThumb, null, null);

            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                uiContent.classList.add('opacity-0');
                dropzone.classList.remove('border-dashed');
                dropzone.classList.add('border-solid', 'border-[#1d6fa5]');
            };
            reader.readAsDataURL(file);
        });

        /* â”€â”€ GALLERY VALIDATION â”€â”€ */
        window.validateGalleryFile = function (input, index) {
            const file = input.files[0];
            if (file && file.size > MAX_FILE_SIZE) {
                showToast('warning', `Foto galeri ${index + 1} terlalu besar`,
                    `Ukuran (${formatBytes(file.size)}) melebihi batas 2MB.`);
                input.value = '';
                return false;
            }
            return true;
        };

        window.validateRoomFoto = function (input, roomIndex, fotoIndex) {
            const file = input.files[0];
            if (file && file.size > MAX_FILE_SIZE) {
                showToast('warning', `Foto kamar ${fotoIndex + 1} terlalu besar`,
                    `Ukuran (${formatBytes(file.size)}) melebihi batas 2MB.`);
                input.value = '';
                return false;
            }
            return true;
        };

        /* â”€â”€ FORM SUBMIT â”€â”€ */
        $('mainForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const currentTipe = this.querySelector('input[name="tipe"]').value;
            let errors = [];

            // Nama
            const namaVal = namaInput.value.trim();
            if (!namaVal || !rgxNama.test(namaVal) || namaVal.length < 2) {
                const msg = !namaVal ? 'Nama wajib diisi.'
                          : !rgxNama.test(namaVal) ? 'Nama hanya boleh berisi huruf, angka, spasi, dan tanda baca.'
                          : 'Nama minimal 2 karakter.';
                setFieldState(namaInput, 'error', hintNama, msg, 'hint-error', iconNamaOk, iconNamaErr);
                errors.push('Nama Fasilitas');
            }

            // Deskripsi
            if (!descInput.value.trim()) {
                setFieldState(descInput, 'error', hintDesc, 'Deskripsi singkat wajib diisi.', 'hint-error', null, null);
                errors.push('Deskripsi Singkat');
            }

            // Jam Operasional
            const jamInput = $('jamOperasional');
            const hintJam  = $('hint-jam');
            if (!jamInput.value.trim()) {
                setFieldState(jamInput, 'error', hintJam, 'Jam operasional wajib diisi.', 'hint-error', null, null);
                errors.push('Jam Operasional');
            } else {
                setFieldState(jamInput, 'success', hintJam, '', '');
            }

            // Kapasitas & Kamar (khusus Asrama)
            if (currentTipe === 'asrama') {

                const kamarInput = $('jumlahKamar');
                const kamarWrap  = $('kamarStepperWrap');
                const hintKamar  = $('hint-kamar');
                const kamarVal   = parseInt(kamarInput?.value);
                if (!kamarInput || isNaN(kamarVal) || kamarVal < 1) {
                    kamarWrap.classList.add('v-error');
                    if (hintKamar) {
                        hintKamar.textContent = 'Jumlah kamar minimal 1.';
                        hintKamar.className   = 'v-hint show hint-error';
                    }
                    errors.push('Jumlah Kamar');
                }
            }

            // Kapasitas Aula
            if (currentTipe === 'aula') {
                const kaInput = $('maxDewasaAula');
                const hintKa  = $('hint-kap-aula');
                if (!kaInput || !kaInput.value || parseInt(kaInput.value) < 1) {
                    setFieldState(kaInput, 'error', hintKa, 'Kapasitas orang minimal 1.', 'hint-error', null, null);
                    errors.push('Kapasitas Aula');
                } else {
                    setFieldState(kaInput, 'success', hintKa, '', '');
                }
            }

            // Foto utama
            if (!fileInput.files[0]) {
                dropzone.classList.add('v-dz-error');
                setFieldState(dropzone, 'error', hintThumb, 'Foto utama (thumbnail) wajib diunggah.', 'hint-error', null, null);
                errors.push('Foto Utama');
            }

            // Total ukuran file
            const totalSize = checkTotalSize();
            if (totalSize > MAX_POST_SIZE) {
                showToast('error', 'Total file terlalu besar',
                    `Total (${formatBytes(totalSize)}) melebihi batas server 8MB. Perkecil ukuran foto.`, 6000);
                errors.push('Ukuran File');
            }

            // Room nomor kamar completeness (asrama only)
            if (currentTipe === 'asrama') {
                const alpineRoot = window.__alpineRoot;
                if (alpineRoot && alpineRoot.rooms) {
                    const incomplete = alpineRoot.rooms.filter(r => r.nomor_kamar.length < r.jumlah);
                    if (incomplete.length > 0) {
                        showToast('error', 'Nomor Kamar Belum Lengkap',
                            `${incomplete.length} tipe kamar masih memiliki nomor kamar yang belum di-input.`);
                        errors.push('Nomor Kamar');
                    }
                }
            }

            if (errors.length > 0) {
                showToast('error',
                    `${errors.length} field belum valid`,
                    'Periksa: ' + errors.join(', ') + '.');
                const firstErr = document.querySelector('.v-error, .v-dz-error');
                if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            const confirmed = await showConfirm({
                icon: 'question',
                iconBg: '#e6f1fb',
                iconColor: '#1d6fa5',
                title: 'Simpan Data?',
                text: 'Pastikan semua informasi venue sudah benar sebelum disimpan.',
                okLabel: 'Ya, Simpan',
                cancelLabel: 'Periksa Lagi',
            });

            if (confirmed) eksekusiSimpanData();
        });

        function eksekusiSimpanData() {
            // Sync latest room data to hidden inputs before serializing
            if (window.__alpineRoot?.syncPaketHarian) {
                window.__alpineRoot.syncPaketHarian();
            }

            // Sync selected labels ke hidden inputs
            const root = window.__alpineRoot;
            const labelsContainer = $('labelsHiddenContainer');
            if (labelsContainer && root) {
                labelsContainer.innerHTML = '';
                const activeLabels = root.tipe === 'aula'
                    ? (root.selectedLabelsAula || [])
                    : (root.selectedLabelsAsrama || []);
                activeLabels.forEach(lbl => {
                    const inp = document.createElement('input');
                    inp.type  = 'hidden';
                    inp.name  = 'labels[]';
                    inp.value = lbl;
                    labelsContainer.appendChild(inp);
                });

                // Sync aula fasilitas ke hidden input
                if (root.tipe === 'aula') {
                    const inp = document.createElement('input');
                    inp.type  = 'hidden';
                    inp.name  = 'aula_fasilitas';
                    inp.value = JSON.stringify(root.aulaFasilitas || []);
                    labelsContainer.appendChild(inp);
                }
            }

            const form      = $('mainForm');
            const formData  = new FormData(form);
            const overlay   = $('loadingOverlay');
            const btnSimpan = $('btnSimpan');
            const btnText   = $('btnText');
            const btnIcon   = $('btnIcon');
            const spinner   = $('spinner');

            overlay.classList.remove('hidden');
            btnSimpan.disabled = true;
            spinner.classList.remove('hidden');
            btnText.textContent = 'Menyimpan...';
            btnIcon.classList.add('hidden');

            fetch('/admin/fasilitas/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const ct   = response.headers.get('content-type') || '';
                const data = ct.includes('application/json') ? await response.json() : null;
                if (!response.ok) throw new Error(data?.message || `Server error: ${response.status}`);
                return data;
            })
            .then(data => {
                overlay.classList.add('hidden');
                if (data?.success) {
                    showToast('success', 'Data tersimpan!', data.message || 'Fasilitas berhasil ditambahkan.');
                    setTimeout(() => { window.location.href = '/admin/dashboard/dataFasilitas'; }, 1500);
                }
            })
            .catch(error => {
                overlay.classList.add('hidden');
                showToast('error', 'Gagal menyimpan', error.message || 'Terjadi kesalahan sistem.', 6000);
                btnSimpan.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = 'Simpan Data';
                btnIcon.classList.remove('hidden');
            });
        }

        /* â”€â”€ TOMBOL BATAL â”€â”€ */
        const btnBatal = $('btn-batal-venue');

        if (btnBatal) {
            btnBatal.addEventListener('click', async function (e) {
                e.preventDefault();

                const confirmed = await showConfirm({
                    icon: 'warning',
                    iconBg: '#FCEBEB',
                    iconColor: '#E24B4A',
                    title: 'Batalkan Pengisian?',
                    text: 'Data yang sudah diisi tidak akan tersimpan.',
                    okLabel: 'Ya, Batalkan',
                    okDanger: true,
                    cancelLabel: 'Kembali',
                });

                if (confirmed) {
                    const loader = $('loader-batal-venue');
                    const text   = $('text-batal-venue');
                    text.classList.add('opacity-0', 'scale-95');
                    loader.classList.remove('invisible', 'opacity-0');
                    this.classList.add('pointer-events-none');

                    setTimeout(() => {
                        if (history.length > 1) {
                            history.back();
                        } else {
                            window.location.href = '/admin/dashboard/dataFasilitas';
                        }
                    }, 700);
                }
            });
        }

    });

    document.addEventListener('alpine:init', () => {

        Alpine.data('facilityCreator', () => ({
            tipe: 'asrama',
            labels: {
                asrama: ['Shower', 'AC', 'Wifi', 'Parkir', 'TV', 'Lemari'],
                aula:   ['Wifi', 'Sound System', 'AC', 'Kursi', 'Meja', 'Panggung', 'Proyektor']
            },
            selectedLabelsAsrama: ['Shower', 'AC', 'Wifi', 'Parkir', 'TV', 'Lemari'],
            selectedLabelsAula:   ['Wifi', 'Sound System', 'AC', 'Kursi', 'Meja', 'Panggung', 'Proyektor'],
            customLabelAsrama: '',
            customLabelAula: '',
            galleryPreviews: [null, null, null],

            aulaHargaHarian: '',
            aulaHargaMingguan: '',
            aulaHargaBulanan: '',
            aulaHargaTahunan: '',
            aulaPanjang: '',
            aulaLebar: '',
            aulaLuas: 0,
            aulaFasilitas: [],
            aulaFasNama: '',
            aulaFasJumlah: 1,

            jumlahKamar: 1,
            rooms: [{ tipe: '', jumlah: 1, nomor_kamar: [], temp_input: '', kode_blok: '', max_dewasa: 1, max_anak: 0, foto: [], fotoPreviews: [null, null, null], harga_harian: '', harga_mingguan: '', harga_bulanan: '', harga_tahunan: '', keunggulan: '', panjang: '', lebar: '', ranjang: '', fasilitas: { ac: 0, kipas_angin: 0, meja_kursi: 0, lemari_locker: 0, stopkontak: 0, kamar_mandi_dalam: 0, water_heater: 0, bantal_set_sprei: 0, gantungan_baju: 0, kaca_rias: 0 }, fasShow: { ac: true, kipas_angin: true, meja_kursi: true, lemari_locker: true, stopkontak: true, kamar_mandi_dalam: true, water_heater: true, bantal_set_sprei: true, gantungan_baju: true, kaca_rias: true }, customFasilitas: [], customFasNama: '' }],
            currentRoomIndex: 0,
            roomTypes: @json($roomTypes->toArray()),

            init() {
                window.__alpineRoot = this;
                // Auto-trim nomor_kamar tags when per-room jumlah is decreased
                this.$watch('rooms', () => {
                    this.rooms.forEach(r => {
                        if (r.nomor_kamar.length > r.jumlah) {
                            r.nomor_kamar.splice(r.jumlah);
                        }
                    });
                    this.syncPaketHarian();
                }, { deep: true });
                document.addEventListener('kamar-changed', (e) => {
                    this.jumlahKamar = e.detail.value;
                    this.initRooms();
                });
                this.$nextTick(() => {
                    const kamarInput = document.getElementById('jumlahKamar');
                    if (kamarInput) {
                        this.jumlahKamar = parseInt(kamarInput.value) || 1;
                        this.initRooms();
                    }
                });
            },

            initRooms() {
                const target = this.jumlahKamar;
                while (this.rooms.length < target) {
                    this.rooms.push({ tipe: '', jumlah: 1, nomor_kamar: [], temp_input: '', kode_blok: '', max_dewasa: 1, max_anak: 0, foto: [], fotoPreviews: [null, null, null], harga_harian: '', harga_mingguan: '', harga_bulanan: '', harga_tahunan: '', keunggulan: '', panjang: '', lebar: '', ranjang: '', fasilitas: { ac: 0, kipas_angin: 0, meja_kursi: 0, lemari_locker: 0, stopkontak: 0, kamar_mandi_dalam: 0, water_heater: 0, bantal_set_sprei: 0, gantungan_baju: 0, kaca_rias: 0 }, fasShow: { ac: true, kipas_angin: true, meja_kursi: true, lemari_locker: true, stopkontak: true, kamar_mandi_dalam: true, water_heater: true, bantal_set_sprei: true, gantungan_baju: true, kaca_rias: true }, customFasilitas: [], customFasNama: '' });
                }
                while (this.rooms.length > target) {
                    this.rooms.pop();
                }
                if (this.currentRoomIndex >= this.rooms.length) {
                    this.currentRoomIndex = Math.max(0, this.rooms.length - 1);
                }
                this.syncPaketHarian();
            },

            syncPaketHarian() {
                const payload = this.rooms.map(r => {
                    const { fotoPreviews, customFasNama, fasShow, temp_input, ...rest } = r;
                    rest.harga_harian   = rest.harga_harian   !== '' && rest.harga_harian   != null ? Number(rest.harga_harian)   : 0;
                    rest.harga_mingguan = rest.harga_mingguan !== '' && rest.harga_mingguan != null ? Number(rest.harga_mingguan) : 0;
                    rest.harga_bulanan  = rest.harga_bulanan  !== '' && rest.harga_bulanan  != null ? Number(rest.harga_bulanan)  : 0;
                    rest.harga_tahunan  = rest.harga_tahunan  !== '' && rest.harga_tahunan  != null ? Number(rest.harga_tahunan)  : 0;
                    return rest;
                });
                const el = document.getElementById('paketHarianInput');
                if (el) el.value = JSON.stringify(payload);
                const rd = document.getElementById('roomsDataInput');
                if (rd) rd.value = JSON.stringify(payload);
                // Update submit guard - show warning only, never disable button
                const btnSimpan = document.getElementById('btnSimpan');
                if (btnSimpan) {
                    btnSimpan.disabled = false;
                }
            },

            prevRoom() {
                if (this.currentRoomIndex > 0) {
                    this.currentRoomIndex--;
                }
            },

            nextRoom() {
                if (this.currentRoomIndex < this.rooms.length - 1) {
                    this.currentRoomIndex++;
                }
            },

            switchTipe(newTipe) {
                if (this.tipe === newTipe) return;
                this.tipe = newTipe;

                // Reset labels ke default sesuai tipe baru
                this.selectedLabelsAsrama = ['Shower', 'AC', 'Wifi', 'Parkir', 'TV', 'Lemari'];
                this.selectedLabelsAula   = ['Wifi', 'Sound System', 'AC', 'Kursi', 'Meja', 'Panggung', 'Proyektor'];

                this.$nextTick(() => {
                    const d = id => document.getElementById(id);

                    // Reset field teks umum
                    const namaEl = d('namaFasilitas');
                    if (namaEl) { namaEl.value = ''; namaEl.dispatchEvent(new Event('input')); }

                    const descEl = d('deskripsiFasilitas');
                    if (descEl) { descEl.value = ''; descEl.dispatchEvent(new Event('input')); }

                    const detailEl = document.querySelector('textarea[name="detail"]');
                    if (detailEl) detailEl.value = '';

                    const jamEl = d('jamOperasional');
                    if (jamEl) { jamEl.value = ''; jamEl.classList.remove('v-error','v-success'); }
                    const hintJam = d('hint-jam');
                    if (hintJam) hintJam.className = 'v-hint';

                    // Reset thumbnail
                    const fileInput = d('fileInput');
                    if (fileInput) fileInput.value = '';
                    const preview = d('preview');
                    if (preview) { preview.src = ''; preview.classList.add('hidden'); }
                    const uiContent = d('ui-content');
                    if (uiContent) uiContent.classList.remove('opacity-0');
                    const dropzone = d('dropzone');
                    if (dropzone) {
                        dropzone.classList.remove('v-dz-error','border-solid','border-[#1d6fa5]');
                        dropzone.classList.add('border-dashed');
                    }
                    const hintThumb = d('hint-thumb');
                    if (hintThumb) hintThumb.className = 'v-hint';

                    // Reset gallery
                    this.galleryPreviews = [null, null, null];
                    for (let i = 0; i < 3; i++) {
                        const g = d('galleryInput' + i);
                        if (g) g.value = '';
                    }

                    // Reset aula-specific fields
                    this.aulaHargaHarian  = '';
                    this.aulaHargaMingguan = '';
                    this.aulaHargaBulanan  = '';
                    this.aulaHargaTahunan  = '';
                    this.aulaLuas = 0;
                    this.aulaFasilitas = [];
                    this.aulaFasNama = '';
                    this.aulaFasJumlah = 1;
                    const aulaPanjang = d('aulaPanjang');
                    if (aulaPanjang) aulaPanjang.value = '';
                    const aulaLebar = d('aulaLebar');
                    if (aulaLebar) aulaLebar.value = '';
                    const maxDewasaAula = d('maxDewasaAula');
                    if (maxDewasaAula) { maxDewasaAula.value = ''; maxDewasaAula.classList.remove('v-error','v-success'); }
                    ['aulaHargaHarian','aulaHargaMingguan','aulaHargaBulanan','aulaHargaTahunan'].forEach(id => {
                        const el = d(id);
                        if (el) el.value = '';
                    });

                    // Reset asrama-specific fields
                    const kamarInput = d('jumlahKamar');
                    if (kamarInput) {
                        kamarInput.value = 1;
                        window.kamarSyncUI(1);
                    }
                    this.jumlahKamar = 1;
                    this.rooms = [{ tipe: '', jumlah: 1, nomor_kamar: [], temp_input: '', kode_blok: '', max_dewasa: 1, max_anak: 0, foto: [], fotoPreviews: [null, null, null], harga_harian: '', harga_mingguan: '', harga_bulanan: '', harga_tahunan: '', keunggulan: '', panjang: '', lebar: '', ranjang: '', fasilitas: { ac: 0, kipas_angin: 0, meja_kursi: 0, lemari_locker: 0, stopkontak: 0, kamar_mandi_dalam: 0, water_heater: 0, bantal_set_sprei: 0, gantungan_baju: 0, kaca_rias: 0 }, fasShow: { ac: true, kipas_angin: true, meja_kursi: true, lemari_locker: true, stopkontak: true, kamar_mandi_dalam: true, water_heater: true, bantal_set_sprei: true, gantungan_baju: true, kaca_rias: true }, customFasilitas: [], customFasNama: '' }];
                    this.currentRoomIndex = 0;
                });
            },

            addCustomLabelAsrama() {
                if (this.customLabelAsrama.trim() !== '') {
                    const label = this.customLabelAsrama.trim();
                    if (!this.labels['asrama'].includes(label)) this.labels['asrama'].push(label);
                    if (!this.selectedLabelsAsrama.includes(label)) this.selectedLabelsAsrama.push(label);
                    this.customLabelAsrama = '';
                }
            },

            removeLabelAsrama(label) {
                this.selectedLabelsAsrama = this.selectedLabelsAsrama.filter(l => l !== label);
            },

            addCustomLabelAula() {
                if (this.customLabelAula.trim() !== '') {
                    const label = this.customLabelAula.trim();
                    if (!this.labels['aula'].includes(label)) this.labels['aula'].push(label);
                    if (!this.selectedLabelsAula.includes(label)) this.selectedLabelsAula.push(label);
                    this.customLabelAula = '';
                }
            },

            removeLabelAula(label) {
                this.selectedLabelsAula = this.selectedLabelsAula.filter(l => l !== label);
            },

            addCustomFasilitas(ri) {
                const room = this.rooms[ri];
                if (!room || !room.customFasNama.trim()) return;
                room.customFasilitas.push({ nama: room.customFasNama.trim(), jumlah: 1 });
                room.customFasNama = '';
            },

            removeCustomFasilitas(ri, index) {
                const room = this.rooms[ri];
                if (!room) return;
                room.customFasilitas.splice(index, 1);
            },

            aulaHitungLuas() {
                const p = parseFloat(document.getElementById('aulaPanjang')?.value) || 0;
                const l = parseFloat(document.getElementById('aulaLebar')?.value) || 0;
                this.aulaLuas = p > 0 && l > 0 ? p * l : 0;
            },

            addNomorKamar(ri) {
                const room = this.rooms[ri];
                if (!room) return;
                const val = (room.temp_input || '').trim();
                if (!val) return;
                if (room.nomor_kamar.includes(val)) return;
                if (room.nomor_kamar.length >= room.jumlah) return;
                room.nomor_kamar.push(val);
                room.temp_input = '';
                this.syncPaketHarian();
            },

            removeNomorKamar(ri, idx) {
                const room = this.rooms[ri];
                if (!room) return;
                const removed = room.nomor_kamar.splice(idx, 1);
                if (removed.length > 0) {
                    room.temp_input = removed[0];
                }
                this.syncPaketHarian();
            },

            handleGalleryChange(event, index) {
                if (!window.validateGalleryFile(event.target, index)) return;
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    const p = [...this.galleryPreviews];
                    p[index] = e.target.result;
                    this.galleryPreviews = p;
                };
                reader.readAsDataURL(file);
            },

            handleRoomFoto(event, roomIndex, fotoIndex) {
                if (!window.validateRoomFoto(event.target, roomIndex, fotoIndex)) return;
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    const previews = this.rooms[roomIndex].fotoPreviews
                        ? [...this.rooms[roomIndex].fotoPreviews]
                        : [null, null, null];
                    previews[fotoIndex] = e.target.result;
                    this.rooms[roomIndex].fotoPreviews = previews;
                };
                reader.readAsDataURL(file);
            },

        }));

        Alpine.data('roomTypeDropdown', (roomIndex, roomsVar) => {
            const csrf = '{{ csrf_token() }}';
            return {
                // â”€â”€ State â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                open:         false,   // dropdown panel visibility
                addMode:      false,   // add-new-type form visibility
                editingId:    null,    // ID of type being edited (null = none)
                editingName:  '',      // input value during edit
                newTypeName:  '',      // input value during add
                saving:       false,   // POST/PUT in flight
                deleting:     null,    // ID of type being deleted (null = none)
                errorMessage: '',      // inline error shown inside dropdown
                // Local reactive copy of the selected tipe - keeps button text
                // in sync without depending on window.__alpineRoot reactivity.
                selectedTipe: '',

                // â”€â”€ Data bridge â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                rVar: roomsVar,
                rIdx: roomIndex,
                get hiddenName() { return `${this.rVar}[${this.rIdx}][tipe]`; },

                init() {
                    const arr = window.__alpineRoot?.[this.rVar];
                    this.selectedTipe = arr?.[this.rIdx]?.tipe ?? '';
                },

                // â”€â”€ Core access â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                allTypes() {
                    return window.__alpineRoot?.roomTypes ?? [];
                },

                currentTipe() {
                    return this.selectedTipe;
                },

                setTipe(val) {
                    this.selectedTipe = val;
                    const arr = window.__alpineRoot?.[this.rVar];
                    if (arr?.[this.rIdx] !== undefined) {
                        arr[this.rIdx].tipe = val;
                        if (window.__alpineRoot?.syncPaketHarian) {
                            window.__alpineRoot.syncPaketHarian();
                        }
                    }
                },

                // â”€â”€ Panel control â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

                toggle() {
                    this.open = !this.open;
                    if (!this.open) { this.addMode = false; this.editingId = null; this.errorMessage = ''; }
                },

                close() {
                    this.open = false; this.addMode = false; this.editingId = null; this.errorMessage = '';
                },

                selectType(name) { this.setTipe(name); this.close(); },

                handleEscape() { this.close(); },

                // â”€â”€ Add mode â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

                startAdd() {
                    this.addMode = true; this.newTypeName = ''; this.errorMessage = '';
                    this.$nextTick(() => this.$refs.newInput?.focus());
                },

                async saveNew() {
                    const name = this.newTypeName.trim();
                    if (!name || this.saving) return;
                    this.saving = true; this.errorMessage = '';
                    try {
                        const res  = await fetch('/admin/room-types', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                            body: JSON.stringify({ name }),
                        });
                        const data = await res.json();
                        if (res.ok) {
                            window.__alpineRoot?.roomTypes.push({ id: data.id, name: data.name });
                            this.selectType(data.name);
                            this.newTypeName = ''; this.addMode = false;
                        } else if (res.status === 422) {
                            const errors = data.errors?.name ?? [];
                            this.errorMessage = errors.some(m => String(m).toLowerCase().includes('unique'))
                                ? 'Tipe kamar ini sudah ada.' : (data.message || 'Validasi gagal.');
                        } else {
                            this.errorMessage = data.message || 'Gagal menyimpan tipe kamar.';
                        }
                    } catch { this.errorMessage = 'Terjadi kesalahan jaringan.'; }
                    finally  { this.saving = false; }
                },

                // â”€â”€ Edit mode â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

                startEdit(id, name) { this.editingId = id; this.editingName = name; this.errorMessage = ''; },

                async saveEdit(id) {
                    const name = this.editingName.trim();
                    if (!name || this.saving) return;
                    this.saving = true; this.errorMessage = '';
                    try {
                        const res  = await fetch('/admin/room-types/' + id, {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                            body: JSON.stringify({ name }),
                        });
                        const data = await res.json();
                        if (res.ok) {
                            const types = window.__alpineRoot?.roomTypes ?? [];
                            const idx   = types.findIndex(t => t.id === id);
                            if (idx !== -1) {
                                const old = types[idx].name;
                                types[idx].name = data.name;
                                if (this.currentTipe() === old) this.setTipe(data.name);
                            }
                            this.editingId = null;
                        } else if (res.status === 422) {
                            this.errorMessage = String(data.message || '').toLowerCase().includes('unique')
                                ? 'Nama sudah digunakan.' : (data.message || 'Validasi gagal.');
                        } else {
                            this.errorMessage = data.message || 'Gagal mengubah tipe kamar.';
                        }
                    } catch { this.errorMessage = 'Terjadi kesalahan jaringan.'; }
                    finally  { this.saving = false; }
                },

                // â”€â”€ Delete â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

                async deleteType(index) {
                    const types = window.__alpineRoot?.roomTypes ?? [];
                    const t     = types[index];
                    if (!t) return;
                    const result = await Swal.fire({
                        title: `Hapus "${t.name}"?`,
                        text: `Tipe kamar "${t.name}" akan dihapus permanen.`,
                        icon: 'warning', showCancelButton: true,
                        confirmButtonColor: '#E24B4A', cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal',
                        reverseButtons: true, customClass: { popup: 'rounded-[2.5rem] p-8' },
                    });
                    if (!result.isConfirmed) return;
                    this.deleting = index;
                    this.errorMessage = '';
                    try {
                        if (t.id) {
                            await window.axios.delete(`/admin/room-types/${t.id}`, {
                                headers: { 'X-CSRF-TOKEN': csrf },
                            });
                        }
                        if (this.currentTipe() === t.name) this.setTipe('');
                        types.splice(index, 1);
                    } catch {
                        this.errorMessage = 'Gagal menghapus tipe kamar.';
                    } finally {
                        this.deleting = null;
                    }
                },
            };
        });
    });
    </script>
</body>
</html>