<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kartu Riwayat Alat - {{ $dokumen->laboratorium->nama_lab ?? 'Lab' }} | DIGITAL Board</title>
    
    <!-- Google Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F7F9FB;
        }
        .sheet-font {
            font-family: 'Times New Roman', Times, serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .sheet-inline-input {
            border: 1px solid transparent;
            background: transparent;
            outline: none;
            transition: all 0.15s ease;
        }
        .sheet-inline-input:hover {
            border-color: #cbd5e1;
            background-color: #f8fafc;
        }
        .sheet-inline-input:focus {
            border-color: #0f766e;
            background-color: #ffffff;
            box-shadow: 0 0 0 2px rgba(15, 118, 110, 0.15);
        }
        @media print {
            @page {
                size: 105mm 148mm portrait; /* A6 portrait (UIKA standard) */
                margin: 4mm 6mm;
            }
            html, body {
                width: 105mm !important;
                height: 148mm !important;
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            /* Hide background page elements, sidebar, and modal chrome */
            body > *:not(#modal-kartu-sheet),
            header,
            aside,
            nav,
            #modal-kartu-sheet > div > *:not(.overflow-y-auto),
            #modal-kartu-sheet .overflow-y-auto > *:not(#sheet-paper),
            .no-print {
                display: none !important;
            }
            #modal-kartu-sheet {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                background: transparent !important;
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
                overflow: visible !important;
            }
            #modal-kartu-sheet > div {
                border: none !important;
                box-shadow: none !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                background: transparent !important;
                overflow: visible !important;
            }
            #modal-kartu-sheet .overflow-y-auto {
                overflow: visible !important;
                padding: 0 !important;
                background: transparent !important;
            }
            #sheet-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                page-break-inside: avoid !important;
                page-break-after: avoid !important;
            }
            .print-date-text {
                display: inline-block !important;
            }
            .no-print-input {
                display: none !important;
            }
            .print-kondisi-text {
                display: inline-block !important;
            }
            .sheet-inline-input {
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            table, tr {
                page-break-inside: avoid !important;
                page-break-after: avoid !important;
            }
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleAdminMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition focus:outline-none cursor-pointer" title="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Kartu Riwayat Alat: {{ $dokumen->laboratorium->nama_lab ?? 'Laboratorium' }}</h2>
            </div>
            
            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ auth()->user()->username }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500 uppercase">{{ auth()->user()->isSuperAdmin() ? 'SUPER ADMIN' : 'ADMIN FAKULTAS' }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ strtoupper(substr(auth()->user()->username ?? 'AD', 0, 2)) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->username ?? 'Administrator' }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-md text-[9px] font-bold uppercase tracking-wider">
                            {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : (auth()->user()->fakultas?->nama_fakultas ?? 'Admin Fakultas') }}
                        </span>
                    </div>

                    <div class="p-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold text-left group cursor-pointer">
                                <div class="w-7 h-7 rounded-lg bg-rose-50 group-hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                </div>
                                <span>Keluar / Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6 custom-scrollbar">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs flex items-center gap-3 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
                    <p class="font-bold flex-1">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs flex items-center gap-3 shadow-xs">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base shrink-0"></i>
                    <p class="font-bold flex-1">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Navigation & Breadcrumb -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                        <a href="{{ route('admin.properti.dokumen.show', $dokumen->id) }}" class="inline-flex items-center gap-1.5 text-teal-800 hover:text-teal-900 transition font-bold">
                            <i class="fa-solid fa-arrow-left text-[11px]"></i> Kembali ke Formulir Properti
                        </a>
                        <span>•</span>
                        <span>{{ $dokumen->laboratorium->nama_lab ?? 'Lab 209' }}</span>
                        <span>•</span>
                        <span>{{ $dokumen->nomor_dokumen }}</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                        <i class="fa-solid fa-microchip text-teal-700"></i>
                        <span>Kartu Riwayat Alat Elektronik</span>
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Pencatatan riwayat pemeliharaan, servis, dan tindakan perangkat elektronik laboratorium sesuai standar mutu UIKA.
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('admin.properti.dokumen.show', $dokumen->id) }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition border border-slate-200 flex items-center gap-1.5 shadow-2xs">
                        <i class="fa-solid fa-table-list text-slate-500"></i> Lihat Tabel 11 Kolom
                    </a>
                </div>
            </div>

            <!-- TOP OBLONG SEARCH & FILTER BAR (Matches Wireframe Top Pill) -->
            <div class="bg-white border border-slate-200 rounded-3xl p-3 sm:p-4 shadow-sm">
                <form action="{{ route('admin.properti.riwayat-alat.index', $dokumen->id) }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
                    <div class="relative flex-1 w-full">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari alat berdasarkan nama, spesifikasi, atau no. inventaris (contoh: Komputer, Ryzen, PC/SI/209)..." class="w-full pl-10 pr-4 py-2.5 sm:py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-slate-800 text-xs sm:text-sm transition placeholder:text-slate-400">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto shrink-0 flex-wrap">
                        <select name="filter" onchange="this.form.submit()" class="py-2.5 sm:py-3 px-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs sm:text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-teal-700/30 cursor-pointer">
                            <option value="elektronik" {{ $filterMode === 'elektronik' ? 'selected' : '' }}>Semua Alat Elektronik</option>
                            <option value="rusak" {{ $filterMode === 'rusak' ? 'selected' : '' }}>🚨 Hanya Alat Rusak ({{ $totalRusak ?? 0 }})</option>
                        </select>

                        @if($search || $filterMode !== 'elektronik')
                            <a href="{{ route('admin.properti.riwayat-alat.index', $dokumen->id) }}" class="px-3.5 py-2.5 sm:py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl text-xs font-bold transition">
                                Reset
                            </a>
                        @endif

                        @if(($totalRusak ?? 0) > 0)
                            <a href="{{ route('admin.properti.riwayat-alat.index', ['dokumenId' => $dokumen->id, 'filter' => 'rusak']) }}" class="px-3.5 py-2.5 sm:py-3 {{ $filterMode === 'rusak' ? 'bg-rose-600 text-white' : 'bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-300' }} rounded-2xl text-xs font-black whitespace-nowrap transition flex items-center gap-1.5 shadow-2xs" title="Lihat hanya alat yang berstatus rusak">
                                <i class="fa-solid fa-triangle-exclamation {{ $filterMode === 'rusak' ? 'text-white' : 'text-rose-600 animate-pulse' }}"></i>
                                <span>{{ $totalRusak }} Alat Rusak</span>
                            </a>
                        @endif

                        <span class="px-3.5 py-2.5 sm:py-3 bg-teal-50 text-teal-800 border border-teal-200/80 rounded-2xl text-xs font-bold whitespace-nowrap">
                            <i class="fa-solid fa-cube text-teal-600 mr-1"></i> {{ $items->count() }} Alat Ditampilkan
                        </span>
                    </div>
                </form>
            </div>

            <!-- ACTION BAR: SELECT ALL ON LEFT, EXPORT & TAMBAH BUTTONS ON RIGHT (Matches Wireframe Image 2) -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-4 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <!-- Left: Checkbox Select All ("kotak kecil banget nah itu tu fitur select all gitu") -->
                <div class="flex items-center gap-3">
                    <label class="inline-flex items-center gap-2.5 cursor-pointer select-none px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition">
                        <input type="checkbox" id="selectAllTools" class="w-4.5 h-4.5 rounded text-teal-700 focus:ring-teal-600 cursor-pointer">
                        <span class="text-xs font-extrabold text-slate-800">Pilih Semua Alat</span>
                    </label>
                    <span id="selectedCountBadge" class="hidden text-xs font-bold text-teal-800 bg-teal-50 px-2.5 py-1 rounded-lg border border-teal-200/80">
                        <span id="selectedCount">0</span> alat dipilih
                    </span>
                </div>

                <!-- Right: Dua Button (Export & Simpan/Tambah Riwayat) -->
                <div class="flex items-center gap-2.5 self-end sm:self-auto flex-wrap">
                    <!-- Button 1: Export (.docx) -->
                    <div class="relative inline-block text-left" id="exportDocxDropdown">
                        <button type="button" onclick="toggleExportDocxMenu()" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-800 font-extrabold text-xs rounded-xl transition flex items-center gap-2 border border-slate-200 shadow-2xs cursor-pointer">
                            <i class="fa-solid fa-file-word text-blue-600 text-sm"></i>
                            <span>Export Kartu Riwayat (.docx)</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>
                        <div id="exportDocxMenu" class="absolute right-0 top-full mt-1.5 w-60 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-40 hidden origin-top-right">
                            <div class="px-3.5 py-1.5 border-b border-slate-100 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                                Pilihan Unduhan Word
                            </div>
                            <button type="button" onclick="exportSelectedDocx()" class="w-full text-left flex items-center gap-2.5 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-teal-50 hover:text-teal-900 transition">
                                <i class="fa-solid fa-check-double text-teal-600 text-sm"></i>
                                <div>
                                    <p class="leading-tight">Export Alat yang Dipilih</p>
                                    <p class="text-[10px] font-normal text-slate-400">Unduh kartu untuk barang tercentang</p>
                                </div>
                            </button>
                            <a href="{{ route('admin.properti.riwayat-alat.export', ['dokumenId' => $dokumen->id]) }}" class="w-full text-left flex items-center gap-2.5 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-teal-50 hover:text-teal-900 transition">
                                <i class="fa-solid fa-layer-group text-blue-600 text-sm"></i>
                                <div>
                                    <p class="leading-tight">Export Seluruh Alat (Semua)</p>
                                    <p class="text-[10px] font-normal text-slate-400">Unduh semua kartu riwayat dalam satu berkas</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Button 2: Catat / Tambah Riwayat Tindakan -->
                    <button type="button" onclick="openTambahRiwayatModal()" class="px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white font-extrabold text-xs rounded-xl transition flex items-center gap-2 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>+ Catat Riwayat Tindakan</span>
                    </button>
                </div>
            </div>

            <!-- LIST OF ELECTRONIC EQUIPMENT CARDS (Matches Horizontal Bars in Wireframe Image 2) -->
            <div class="space-y-3">
                @forelse($items as $item)
                    @php
                        $namaLower = strtolower($item->nama_properti);
                        $kondisi = strtolower($item->kondisi ?? 'baik');
                        $isRusak = ($kondisi === 'rusak');
                        $isSedang = ($kondisi === 'sedang');

                        $iconClass = 'fa-desktop text-teal-700';
                        $iconBg = 'bg-teal-50 border-teal-200/80';
                        if (str_contains($namaLower, 'printer')) {
                            $iconClass = 'fa-print text-indigo-700';
                            $iconBg = 'bg-indigo-50 border-indigo-200/80';
                        } elseif (str_contains($namaLower, 'cctv') || str_contains($namaLower, 'kamera')) {
                            $iconClass = 'fa-video text-amber-700';
                            $iconBg = 'bg-amber-50 border-amber-200/80';
                        } elseif (str_contains($namaLower, 'ac')) {
                            $iconClass = 'fa-snowflake text-sky-700';
                            $iconBg = 'bg-sky-50 border-sky-200/80';
                        } elseif (str_contains($namaLower, 'server') || str_contains($namaLower, 'switch') || str_contains($namaLower, 'router')) {
                            $iconClass = 'fa-server text-purple-700';
                            $iconBg = 'bg-purple-50 border-purple-200/80';
                        }

                        if ($isRusak) {
                            $cardStyle = 'bg-rose-50/25 hover:bg-rose-50/50 border-2 border-rose-300 border-l-4 border-l-rose-600 shadow-sm shadow-rose-100';
                            $iconBg = 'bg-rose-100 border-rose-300 text-rose-700';
                        } elseif ($isSedang) {
                            $cardStyle = 'bg-amber-50/15 hover:bg-amber-50/30 border border-amber-300 border-l-4 border-l-amber-500 shadow-2xs shadow-amber-100';
                            $iconBg = 'bg-amber-100 border-amber-300 text-amber-700';
                        } else {
                            $cardStyle = 'bg-white hover:bg-slate-50/50 border border-slate-200/90 hover:border-teal-400/90 shadow-xs hover:shadow-md';
                        }

                        $riwayats = $item->riwayats;
                        $latestRiwayat = $riwayats->sortByDesc('tanggal_mulai')->first();
                    @endphp

                    <div id="tool-card-{{ $item->id }}" onclick="openKartuSheetModalById({{ $item->id }})" class="{{ $cardStyle }} rounded-2xl p-4 sm:p-5 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 cursor-pointer group">
                        
                        <!-- Left Side: Checkbox + Icon + Identity -->
                        <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                            <!-- Checkbox for batch action -->
                            <div class="pt-0.5 sm:pt-0 shrink-0" onclick="event.stopPropagation()">
                                <input type="checkbox" value="{{ $item->id }}" class="tool-checkbox w-4.5 h-4.5 rounded text-teal-700 focus:ring-teal-600 cursor-pointer" onchange="updateSelectedCount()">
                            </div>

                            <!-- Icon Badge -->
                            <div id="card-icon-{{ $item->id }}" class="w-11 h-11 rounded-2xl {{ $iconBg }} border flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition relative">
                                <i class="fa-solid {{ $iconClass }} text-base"></i>
                                @if($isRusak)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-600 text-white flex items-center justify-center text-[9px] font-black border-2 border-white shadow-xs" title="Perangkat Rusak">!</span>
                                @endif
                            </div>

                            <!-- Text Details -->
                            <div class="min-w-0 space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 id="card-nama-{{ $item->id }}" class="font-black text-sm sm:text-base {{ $isRusak ? 'text-rose-950' : 'text-slate-900' }} group-hover:text-teal-900 transition truncate">
                                        {{ $item->nama_properti }}
                                    </h3>
                                    @if($item->nomor_inventaris)
                                        <span id="card-inv-{{ $item->id }}" class="px-2.5 py-0.5 bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-mono font-bold rounded-md">
                                            {{ $item->nomor_inventaris }}
                                        </span>
                                    @endif
                                    
                                    <!-- Kondisi Badge -->
                                    <span id="card-kondisi-{{ $item->id }}" class="px-2.5 py-0.5 text-[10px] font-black rounded-md uppercase flex items-center gap-1 shadow-2xs {{ $isRusak ? 'bg-rose-100 text-rose-800 border border-rose-300' : ($isSedang ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-emerald-50 text-emerald-700 border border-emerald-200/80') }}">
                                        @if($isRusak)
                                            <i class="fa-solid fa-triangle-exclamation text-rose-600 animate-pulse"></i> RUSAK
                                        @elseif($isSedang)
                                            <i class="fa-solid fa-circle-exclamation text-amber-600"></i> SEDANG
                                        @else
                                            ✓ BAIK
                                        @endif
                                    </span>
                                </div>

                                <p class="text-xs text-slate-600 font-medium line-clamp-1">
                                    <span class="font-bold text-slate-700">Spesifikasi:</span> <span id="card-spec-{{ $item->id }}">{{ $item->merk_type ?: '-' }}</span>
                                </p>

                                <div class="flex items-center gap-3 text-[11px] text-slate-400">
                                    <span><i class="fa-solid fa-door-open text-slate-400 mr-1"></i> Ruang: <b class="text-slate-600">{{ $item->ruang ?? '209' }}</b></span>
                                    <span>•</span>
                                    <span><i class="fa-solid fa-clock-rotate-left text-slate-400 mr-1"></i> Pemeliharaan: <b class="text-slate-600">{{ $item->frekuensi_pemeliharaan ?? '6 Bulan' }}</b></span>
                                </div>

                                <!-- Indikator Banner Jika Rusak -->
                                <div id="card-banner-rusak-{{ $item->id }}" class="{{ $isRusak ? '' : 'hidden' }} pt-1">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-rose-100/90 text-rose-800 border border-rose-300 text-[11px] font-extrabold shadow-2xs">
                                        <i class="fa-solid fa-triangle-exclamation text-rose-600 animate-pulse"></i>
                                        <span>PERANGKAT RUSAK — Memerlukan Perbaikan / Servis Segera</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Riwayat Info & Action Buttons (Matches Right side of Wireframe) -->
                        <div class="flex items-center justify-between md:justify-end gap-3.5 border-t md:border-t-0 pt-3 md:pt-0 border-slate-100 shrink-0">
                            <!-- Status Tindakan Terakhir -->
                            <div class="text-left md:text-right" id="card-latest-{{ $item->id }}">
                                @if($latestRiwayat)
                                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Tindakan Terakhir</span>
                                    <p class="text-xs font-bold text-slate-800">
                                        {{ $latestRiwayat->tanggal_mulai ? $latestRiwayat->tanggal_mulai->format('d/m/Y H:i') : '-' }}
                                    </p>
                                    <p class="text-[11px] text-teal-800 font-semibold max-w-[200px] truncate" title="{{ $latestRiwayat->tindakan }}">
                                        {{ $latestRiwayat->tindakan }}
                                    </p>
                                @else
                                    <span class="text-[11px] text-slate-400 italic">Belum ada riwayat tercatat</span>
                                @endif
                            </div>

                            <!-- Count Badge -->
                            <span id="card-count-{{ $item->id }}" class="px-3 py-1.5 rounded-xl {{ $riwayats->count() > 0 ? 'bg-teal-50 text-teal-800 border-teal-200' : 'bg-slate-100 text-slate-500 border-slate-200' }} border text-xs font-extrabold whitespace-nowrap shadow-2xs">
                                {{ $riwayats->count() }} Tindakan
                            </span>

                            <!-- Action: Catat Tindakan (CRUD) -->
                            <button id="card-btn-action-{{ $item->id }}" type="button" onclick="event.stopPropagation(); openTambahRiwayatModal({{ $item->id }})" class="px-3 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer {{ $isRusak ? 'bg-rose-600 hover:bg-rose-700 text-white font-black animate-pulse' : 'bg-teal-50 hover:bg-teal-100 text-teal-900 border border-teal-200/80' }}" title="{{ $isRusak ? 'Perangkat rusak! Klik untuk mencatat tindakan servis/perbaikan' : 'Catat tindakan baru lewat form CRUD' }}">
                                <i class="fa-solid {{ $isRusak ? 'fa-wrench' : 'fa-plus' }} text-[10px]"></i>
                                <span>{{ $isRusak ? 'Perbaiki Alat' : 'Catat Tindakan' }}</span>
                            </button>

                            <!-- Direct Action: Buka Kartu Button -->
                            <button type="button" onclick="event.stopPropagation(); openKartuSheetModalById({{ $item->id }})" class="px-3.5 py-2 bg-slate-100 group-hover:bg-teal-800 text-slate-700 group-hover:text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                                <span>Buka Kartu</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center text-slate-400 space-y-3 shadow-xs">
                        <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center mx-auto text-2xl border border-slate-200">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h4 class="font-extrabold text-base text-slate-700">Belum Ada Alat Elektronik Ditemukan</h4>
                        <p class="text-xs text-slate-400 max-w-md mx-auto">
                            Tidak ada fasilitas lab yang cocok dengan pencarian atau filter yang dipilih. Silakan ubah filter ke "Semua Fasilitas Lab" atau tambahkan data barang baru.
                        </p>
                        <a href="{{ route('admin.properti.riwayat-alat.index', ['dokumenId' => $dokumen->id, 'filter' => 'all']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-800 text-white rounded-xl text-xs font-bold hover:bg-teal-900 transition">
                            Tampilkan Semua Fasilitas
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <!-- ============================================================== -->
    <!-- MODAL: KARTU RIWAYAT ALAT (DETAIL SHEET SESUAI DOKUMEN UIKA)    -->
    <!-- ============================================================== -->
    <div id="modal-kartu-sheet" onclick="if(event.target === this) closeKartuSheetModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-3 sm:p-5 hidden transition-all">
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-2xl max-w-4xl w-full max-h-[94vh] flex flex-col overflow-hidden animate-in fade-in zoom-in duration-150">
            
            <!-- Modal Top Bar -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-800 border border-teal-200/60 flex items-center justify-center text-base shrink-0 shadow-xs">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-base text-slate-800 tracking-tight">Kartu Riwayat Alat Resmi UIKA</h3>
                        <p class="text-[11px] text-teal-800 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-pen-to-square text-teal-600"></i>
                            <span>Klik langsung sel tabel atau identitas alat di bawah untuk mengubah data (*inline edit* otomatis tersimpan)</span>
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2.5">
                    <!-- Save Status Indicator -->
                    <div id="sheetSaveIndicator" class="hidden items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border transition-all">
                        <i id="sheetSaveIcon" class="fa-solid fa-spinner fa-spin text-teal-700"></i>
                        <span id="sheetSaveText" class="text-teal-800">Menyimpan...</span>
                    </div>

                    <!-- Paper Size A6 Badge -->
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-teal-50 text-teal-900 border border-teal-200/80 rounded-xl text-xs font-bold shadow-2xs">
                        <i class="fa-solid fa-file-lines text-teal-700"></i>
                        <span>Ukuran: A6 (105 × 148 mm)</span>
                    </span>

                    <!-- Cetak Langsung (A6) -->
                    <button type="button" onclick="window.print()" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs" title="Cetak langsung ke ukuran kertas A6">
                        <i class="fa-solid fa-print text-teal-700"></i>
                        <span>Cetak (A6)</span>
                    </button>

                    <button type="button" id="btn-export-single-docx" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs rounded-xl border border-slate-200 transition flex items-center gap-1.5 cursor-pointer shadow-2xs" title="Unduh berkas Word resmi UIKA (Ukuran A6)">
                        <i class="fa-solid fa-file-word text-blue-600"></i>
                        <span>Export Word (.docx)</span>
                    </button>
                    <button type="button" onclick="closeKartuSheetModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer" title="Tutup">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Scrollable Document Sheet Wrapper -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-100/70 custom-scrollbar">
                
                <!-- Alert Banner Jika Alat Rusak / Sedang -->
                <div id="sheet-kondisi-alert" class="max-w-3xl mx-auto mb-4 p-4 rounded-2xl border transition-all animate-in fade-in slide-in-from-top-2 hidden">
                    <div class="flex items-start gap-3.5">
                        <div id="sheet-kondisi-alert-icon-box" class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-base shadow-xs">
                            <i id="sheet-kondisi-alert-icon" class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <h4 id="sheet-kondisi-alert-title" class="font-black text-sm"></h4>
                                <span id="sheet-kondisi-alert-badge" class="px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider"></span>
                            </div>
                            <p id="sheet-kondisi-alert-desc" class="text-xs mt-1 leading-relaxed"></p>
                        </div>
                    </div>
                </div>

                <!-- THE SHEET PAPER (Visual match to UIKA Word Document - Format A6 105 x 148 mm) -->
                <div id="sheet-paper" class="bg-white border border-slate-300 shadow-xl p-6 sm:p-8 rounded-2xl max-w-3xl w-full mx-auto space-y-4 sheet-font text-slate-900">
                    
                    <!-- Document Header -->
                    <div class="text-center space-y-0.5 pb-2 border-b-2 border-slate-900">
                        <h2 class="text-sm sm:text-base font-bold tracking-wider uppercase">KARTU RIWAYAT ALAT</h2>
                        <h3 class="text-xs sm:text-sm font-bold uppercase">{{ strtoupper($dokumen->laboratorium->nama_lab ?? 'LABORATORIUM SISTEM INFORMASI 209') }}</h3>
                        <p class="text-[10px] sm:text-xs uppercase font-normal">
                            PROGRAM STUDI SISTEM INFORMASI | {{ strtoupper($dokumen->laboratorium->fakultas->nama_fakultas ?? 'FAKULTAS TEKNIK DAN SAINS') }} |
                        </p>
                        <p class="text-[10px] sm:text-xs uppercase font-normal">UNIV. IBN KHALDUN BOGOR</p>
                    </div>

                    <!-- Equipment Identity Block (Inline Editable) -->
                    <div class="text-xs space-y-1.5 font-normal pt-1">
                        <div class="flex items-center">
                            <span class="w-32 font-bold shrink-0">Nama Alat</span>
                            <span class="font-bold mr-1">:</span>
                            <input type="text" id="sheet-nama-alat" onblur="updateToolIdentityInline('nama_properti', this.value)" class="sheet-inline-input font-bold text-slate-900 text-xs px-2 py-0.5 rounded border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent flex-1" value="" placeholder="Nama alat (misal: Komputer, Printer...)">
                        </div>
                        <div class="flex items-center">
                            <span class="w-32 font-normal shrink-0">Spesifikasi</span>
                            <span class="mr-1">:</span>
                            <input type="text" id="sheet-spesifikasi" onblur="updateToolIdentityInline('merk_type', this.value)" class="sheet-inline-input font-normal text-slate-900 text-xs px-2 py-0.5 rounded border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent flex-1" value="" placeholder="Spesifikasi / Merk / Tipe...">
                        </div>
                        <div class="flex items-center">
                            <span class="w-32 font-normal shrink-0">No. Inventarisasi</span>
                            <span class="mr-1">:</span>
                            <input type="text" id="sheet-no-inventaris" onblur="updateToolIdentityInline('nomor_inventaris', this.value)" class="sheet-inline-input font-normal text-slate-900 text-xs px-2 py-0.5 rounded border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent flex-1 font-mono" value="" placeholder="Nomor inventarisasi...">
                        </div>
                        <!-- Kondisi Alat (Editable Inline Dropdown on Screen, Pure Text on Print) -->
                        <div class="flex items-center">
                            <span class="w-32 font-bold shrink-0">Kondisi Alat</span>
                            <span class="font-bold mr-1">:</span>
                            <div class="flex items-center gap-2 flex-1">
                                <!-- Print only static text -->
                                <span id="sheet-kondisi-print-text" class="hidden print-kondisi-text font-bold text-xs">BAIK</span>
                                <!-- Screen interactive dropdown -->
                                <select id="sheet-kondisi-select" onchange="updateToolConditionInline(this.value)" class="no-print text-xs font-black px-2.5 py-1 rounded-lg border cursor-pointer outline-none transition shadow-2xs">
                                    <option value="baik">✓ BAIK (Normal)</option>
                                    <option value="sedang">⚠️ SEDANG (Perlu Perhatian)</option>
                                    <option value="rusak">🚨 RUSAK (Perlu Servis/Perbaikan)</option>
                                </select>
                                <span id="sheet-kondisi-hint" class="no-print text-[11px] text-slate-400 italic">Status: Normal / Baik</span>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance History Table (Exact 4 Columns from UIKA + Subtle Action Column) -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-black text-xs text-left">
                            <thead>
                                <tr class="bg-slate-100 text-center font-bold">
                                    <th class="border border-black p-2 w-[42%]">Tindakan</th>
                                    <th class="border border-black p-2 w-[22%]">Tanggal Dan Waktu<br>(Mulai)</th>
                                    <th class="border border-black p-2 w-[22%]">Tanggal Dan Waktu<br>(Berakhir)</th>
                                    <th class="border border-black p-2 w-[14%]">Paraf</th>
                                    <th class="border border-black p-1 w-[46px] no-print text-center text-slate-400" title="Aksi"><i class="fa-solid fa-gear text-xs"></i></th>
                                </tr>
                            </thead>
                            <tbody id="sheet-table-body">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Signature Block (Right Aligned matching Word) -->
                    <div class="pt-4 flex justify-end">
                        <div class="w-56 text-center text-xs space-y-1.5">
                            <p class="font-bold">Kepala Laboratorium</p>
                            <!-- Ruang kosong untuk tanda tangan / paraf fisik Kepala Lab -->
                            <div class="h-16 flex items-center justify-center"></div>
                            <p class="font-bold underline">{{ $dokumen->laboratorium->nama_kepala_lab ?: 'Jejen Jaenudin S.kom., M.kom' }}</p>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Modal Footer Controls -->
            <div class="px-6 py-3.5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-slate-50/70 shrink-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" onclick="addNewRiwayatInline()" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs rounded-xl transition flex items-center gap-1.5 shadow-xs cursor-pointer" title="Tambah baris kosong langsung di tabel">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>+ Tambah Baris Cepat (Tabel)</span>
                    </button>
                    <button type="button" onclick="openTambahRiwayatForCurrentTool()" class="px-3.5 py-2 bg-white hover:bg-teal-50 text-teal-800 border-2 border-teal-600 rounded-xl font-bold text-xs transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Buka formulir pencatatan tindakan lengkap">
                        <i class="fa-solid fa-file-circle-plus text-xs text-teal-700"></i>
                        <span>+ Form Catat Tindakan</span>
                    </button>
                </div>

                <button type="button" onclick="closeKartuSheetModal()" class="px-5 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl font-bold text-xs transition cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MODAL: FORM CATAT RIWAYAT TINDAKAN BARU                        -->
    <!-- ============================================================== -->
    <div id="modal-tambah-riwayat" onclick="if(event.target === this) closeTambahRiwayatModal()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-3 sm:p-4 hidden transition-all">
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-2xl max-w-xl w-full max-h-[92vh] flex flex-col overflow-hidden animate-in fade-in zoom-in duration-150">
            
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-800 border border-teal-200/60 flex items-center justify-center text-base shrink-0 shadow-xs">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                    <div>
                        <h3 id="modal-riwayat-title" class="font-black text-base text-slate-800 tracking-tight">Catat Tindakan Pemeliharaan Alat</h3>
                        <p class="text-[11px] text-slate-400 font-medium">Rekam pemeliharaan, servis, atau perbaikan pada perangkat</p>
                    </div>
                </div>
                <button type="button" onclick="closeTambahRiwayatModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form id="form-riwayat-alat" action="{{ route('admin.properti.riwayat-alat.store', $dokumen->id) }}" method="POST" class="flex-1 flex flex-col overflow-hidden text-xs">
                @csrf
                <input type="hidden" name="_method" id="form-riwayat-method" value="POST">
                
                <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                    <!-- Target Alat Elektronik (Sesuai Pilihan Multi-Choose di Halaman Utama) -->
                    <div id="modal-hidden-item-ids"></div>
                    <div class="p-3 bg-teal-50/70 border border-teal-200/80 rounded-2xl flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-xl bg-teal-800 text-white flex items-center justify-center text-xs shrink-0 shadow-xs">
                                <i class="fa-solid fa-microchip"></i>
                            </div>
                            <div class="min-w-0">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-700 block">Target Alat Yang Ditindak</span>
                                <p id="modal-target-tools-label" class="font-bold text-xs text-slate-800 truncate">
                                    Memuat pilihan alat...
                                </p>
                            </div>
                        </div>
                        <span id="modal-target-count-badge" class="px-2.5 py-1 bg-teal-100 text-teal-800 border border-teal-300 rounded-lg text-[11px] font-black shrink-0">
                            1 Alat
                        </span>
                    </div>

                    <!-- Alert Notice Jika Alat Rusak Dilewati Otomatis Sesuai Aturan -->
                    <div id="modal-skipped-rusak-alert" class="hidden p-3.5 bg-amber-50 border-2 border-amber-300 rounded-2xl animate-in fade-in transition-all shadow-xs">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-amber-600 text-base mt-0.5 shrink-0 animate-bounce"></i>
                            <div class="text-[11px] leading-relaxed text-amber-950 flex-1">
                                <p class="font-black text-amber-900" id="modal-skipped-rusak-title">Pemisahan Alat Rusak:</p>
                                <p id="modal-skipped-rusak-text" class="text-amber-800 font-medium mt-0.5"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Uraian Tindakan -->
                    <div>
                        <label class="block text-slate-800 font-extrabold text-xs mb-1.5">
                            Uraian Tindakan Pemeliharaan / Servis <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="tindakan" rows="3" required placeholder="Contoh: Pembersihan debu & penggantian thermal paste prosesor, instalasi ulang Windows 11 dan aplikasi Lab..." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none font-medium text-slate-800 text-xs transition leading-relaxed placeholder:text-slate-400 resize-y"></textarea>
                    </div>

                    <!-- Tanggal Mulai & Berakhir -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-slate-800 font-extrabold text-xs mb-1.5">
                                Tanggal &amp; Waktu (Mulai) <span class="text-rose-500">*</span>
                            </label>
                            <input type="datetime-local" name="tanggal_mulai" required value="{{ date('Y-m-d\TH:i') }}" class="w-full h-[42px] px-3.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                        </div>
                        <div>
                            <label class="block text-slate-800 font-extrabold text-xs mb-1.5">
                                Tanggal &amp; Waktu (Berakhir) <span class="text-[10px] text-slate-400 font-normal">(opsional)</span>
                            </label>
                            <input type="datetime-local" name="tanggal_selesai" class="w-full h-[42px] px-3.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                        </div>
                    </div>
                </div>

                <div class="px-6 py-3.5 border-t border-slate-100 flex items-center justify-end gap-2.5 bg-slate-50/70 shrink-0">
                    <button type="button" onclick="closeTambahRiwayatModal()" class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl font-bold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold text-xs shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        <span id="btn-submit-riwayat-text">Simpan Riwayat Tindakan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Form for Exporting Selected Items -->
    <form id="exportSelectedForm" action="{{ route('admin.properti.riwayat-alat.export', $dokumen->id) }}" method="GET" class="hidden">
        <input type="hidden" name="item_ids" id="exportSelectedInput">
    </form>

    <script>
        let currentItemForSheet = null;
        const itemsMap = @json($items->keyBy('id'));

        function openKartuSheetModalById(id) {
            const item = itemsMap[id];
            if (item) {
                openKartuSheetModal(item);
            } else {
                console.warn('Item not found in itemsMap for id:', id);
            }
        }

        // Toggle Export Docx Dropdown
        function toggleExportDocxMenu() {
            const menu = document.getElementById('exportDocxMenu');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('exportDocxDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                const menu = document.getElementById('exportDocxMenu');
                if (menu) menu.classList.add('hidden');
            }
        });

        // Select All Tools Checkbox
        const selectAllTools = document.getElementById('selectAllTools');
        const toolCheckboxes = document.querySelectorAll('.tool-checkbox');
        const selectedCount = document.getElementById('selectedCount');
        const selectedCountBadge = document.getElementById('selectedCountBadge');

        if (selectAllTools) {
            selectAllTools.addEventListener('change', function() {
                toolCheckboxes.forEach(cb => cb.checked = selectAllTools.checked);
                updateSelectedCount();
            });
        }

        function updateSelectedCount() {
            const checked = Array.from(document.querySelectorAll('.tool-checkbox:checked'));
            const count = checked.length;
            if (selectedCount) selectedCount.innerText = count;

            if (selectedCountBadge) {
                if (count > 0) {
                    selectedCountBadge.classList.remove('hidden');

                    let rusakCount = 0;
                    let nonRusakCount = 0;
                    checked.forEach(cb => {
                        const it = itemsMap[parseInt(cb.value)];
                        if ((it?.kondisi || 'baik').toLowerCase() === 'rusak') {
                            rusakCount++;
                        } else {
                            nonRusakCount++;
                        }
                    });

                    if (nonRusakCount > 0 && rusakCount > 0) {
                        selectedCountBadge.innerHTML = `<span id="selectedCount">${count}</span> alat dipilih <span class="ml-1 text-[10px] text-amber-900 bg-amber-100/90 px-2 py-0.5 rounded-md font-bold border border-amber-300">(${nonRusakCount} Normal, ${rusakCount} Rusak dilewati saat catat tindakan)</span>`;
                    } else if (rusakCount > 0 && nonRusakCount === 0) {
                        selectedCountBadge.innerHTML = `<span id="selectedCount">${count}</span> alat RUSAK dipilih <span class="ml-1 text-[10px] text-rose-800 bg-rose-100 px-2 py-0.5 rounded-md font-bold border border-rose-300">(Khusus Servis/Perbaikan)</span>`;
                    } else {
                        selectedCountBadge.innerHTML = `<span id="selectedCount">${count}</span> alat dipilih`;
                    }
                } else {
                    selectedCountBadge.classList.add('hidden');
                }
            }

            if (selectAllTools) {
                selectAllTools.checked = (count === toolCheckboxes.length && count > 0);
            }
        }

        // Export Selected Items
        function exportSelectedDocx() {
            const checked = document.querySelectorAll('.tool-checkbox:checked');
            if (checked.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Alat Terlebih Dahulu',
                    text: 'Centang setidaknya satu kotak alat elektronik pada daftar untuk diexport.',
                    confirmButtonColor: '#0f766e',
                });
                return;
            }

            const ids = Array.from(checked).map(cb => cb.value).join(',');
            const form = document.getElementById('exportSelectedForm');
            document.getElementById('exportSelectedInput').value = ids;
            form.submit();
        }

        // Auto-save Indicator Helper
        let saveTimeout = null;
        function showSaveIndicator(state, message) {
            const el = document.getElementById('sheetSaveIndicator');
            const icon = document.getElementById('sheetSaveIcon');
            const txt = document.getElementById('sheetSaveText');
            if (!el || !icon || !txt) return;

            clearTimeout(saveTimeout);
            el.className = 'flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border transition-all';

            if (state === 'saving') {
                el.classList.add('bg-teal-50', 'text-teal-800', 'border-teal-200');
                icon.className = 'fa-solid fa-spinner fa-spin text-teal-700';
                txt.innerText = message || 'Menyimpan...';
            } else if (state === 'saved') {
                el.classList.add('bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
                icon.className = 'fa-solid fa-circle-check text-emerald-600';
                txt.innerText = message || 'Tersimpan otomatis';
                saveTimeout = setTimeout(() => {
                    el.classList.add('hidden');
                    el.classList.remove('flex');
                }, 2200);
            } else if (state === 'error') {
                el.classList.add('bg-rose-50', 'text-rose-800', 'border-rose-200');
                icon.className = 'fa-solid fa-circle-exclamation text-rose-600';
                txt.innerText = message || 'Gagal menyimpan';
            }
        }

        // Helper: Convert Date String to YYYY-MM-DDTHH:mm for datetime-local
        function toDatetimeLocalValue(dateStr) {
            if (!dateStr) return '';
            try {
                const d = new Date(dateStr);
                if (isNaN(d.getTime())) return '';
                const pad = (n) => String(n).padStart(2, '0');
                const year = d.getFullYear();
                const month = pad(d.getMonth() + 1);
                const day = pad(d.getDate());
                const hours = pad(d.getHours());
                const mins = pad(d.getMinutes());
                return `${year}-${month}-${day}T${hours}:${mins}`;
            } catch (e) {
                return '';
            }
        }

        // Helper: Auto resize textarea based on content
        function autoResizeTextarea(el) {
            if (!el) return;
            el.style.height = 'auto';
            el.style.height = (el.scrollHeight) + 'px';
        }

        // Update Tool Identity (Nama Alat, Spesifikasi, No. Inventarisasi) Inline via AJAX
        function updateToolIdentityInline(field, value) {
            if (!currentItemForSheet) return;
            showSaveIndicator('saving', 'Menyimpan...');

            fetch(`/admin/properti/item/${currentItemForSheet.id}/inline-update`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ field: field, value: value })
            })
            .then(async res => {
                const data = await res.json().catch(() => null);
                if (!res.ok) {
                    throw new Error(data?.message || `Gagal menyimpan (Kode: ${res.status})`);
                }
                return data;
            })
            .then(data => {
                if (data && data.status === 'success') {
                    showSaveIndicator('saved', 'Tersimpan otomatis');
                    currentItemForSheet[field] = value;
                    if (itemsMap[currentItemForSheet.id]) {
                        itemsMap[currentItemForSheet.id][field] = value;
                    }
                    updateToolCardDisplay(currentItemForSheet.id);
                } else {
                    showSaveIndicator('error', (data && data.message) || 'Gagal menyimpan');
                }
            })
            .catch(err => {
                console.error(err);
                showSaveIndicator('error', err.message || 'Koneksi bermasalah');
            });
        }

        // Update Tool Condition (Baik / Sedang / Rusak) Inline via AJAX
        function updateToolConditionInline(value) {
            if (!currentItemForSheet) return;
            const itemId = currentItemForSheet.id;
            showSaveIndicator('saving', 'Memperbarui kondisi...');

            fetch(`/admin/properti/item/${itemId}/inline-update`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ field: 'kondisi', value: value })
            })
            .then(async res => {
                const data = await res.json().catch(() => null);
                if (!res.ok) {
                    throw new Error(data?.message || `Gagal mengubah kondisi (Kode: ${res.status})`);
                }
                return data;
            })
            .then(data => {
                if (data && data.status === 'success') {
                    showSaveIndicator('saved', 'Kondisi alat tersimpan');
                    currentItemForSheet.kondisi = value;
                    if (itemsMap[itemId]) {
                        itemsMap[itemId].kondisi = value;
                    }
                    renderSheetConditionAlert(value);
                    updateToolCardDisplay(itemId);
                } else {
                    showSaveIndicator('error', (data && data.message) || 'Gagal mengubah kondisi');
                }
            })
            .catch(err => {
                console.error(err);
                showSaveIndicator('error', err.message || 'Koneksi bermasalah');
            });
        }

        // Render Sheet Condition Alert Banner & Dropdown Styling
        function renderSheetConditionAlert(kondisiRaw) {
            const kondisi = (kondisiRaw || 'baik').toLowerCase();
            const alertBox = document.getElementById('sheet-kondisi-alert');
            const alertIconBox = document.getElementById('sheet-kondisi-alert-icon-box');
            const alertIcon = document.getElementById('sheet-kondisi-alert-icon');
            const alertTitle = document.getElementById('sheet-kondisi-alert-title');
            const alertBadge = document.getElementById('sheet-kondisi-alert-badge');
            const alertDesc = document.getElementById('sheet-kondisi-alert-desc');
            const select = document.getElementById('sheet-kondisi-select');
            const hint = document.getElementById('sheet-kondisi-hint');

            if (select) {
                select.value = kondisi;
                if (kondisi === 'rusak') {
                    select.className = 'no-print text-xs font-black px-2.5 py-1 rounded-lg border border-rose-300 bg-rose-50 text-rose-800 cursor-pointer outline-none transition shadow-2xs focus:ring-2 focus:ring-rose-500/20';
                } else if (kondisi === 'sedang') {
                    select.className = 'no-print text-xs font-black px-2.5 py-1 rounded-lg border border-amber-300 bg-amber-50 text-amber-800 cursor-pointer outline-none transition shadow-2xs focus:ring-2 focus:ring-amber-500/20';
                } else {
                    select.className = 'no-print text-xs font-black px-2.5 py-1 rounded-lg border border-emerald-300 bg-emerald-50 text-emerald-800 cursor-pointer outline-none transition shadow-2xs focus:ring-2 focus:ring-emerald-500/20';
                }
            }

            const printText = document.getElementById('sheet-kondisi-print-text');
            if (printText) {
                if (kondisi === 'rusak') {
                    printText.innerText = 'RUSAK (MEMERLUKAN PERBAIKAN)';
                    printText.className = 'hidden print-kondisi-text font-bold text-xs text-rose-700';
                } else if (kondisi === 'sedang') {
                    printText.innerText = 'SEDANG (PERLU PERAWATAN)';
                    printText.className = 'hidden print-kondisi-text font-bold text-xs text-amber-700';
                } else {
                    printText.innerText = 'BAIK (NORMAL)';
                    printText.className = 'hidden print-kondisi-text font-bold text-xs text-slate-900';
                }
            }

            if (!alertBox) return;

            if (kondisi === 'rusak') {
                alertBox.className = 'max-w-3xl mx-auto mb-4 p-4 rounded-2xl border-2 border-rose-300 bg-rose-50/90 text-rose-950 transition-all animate-in fade-in slide-in-from-top-2 shadow-sm shadow-rose-100';
                if (alertIconBox) alertIconBox.className = 'w-10 h-10 rounded-xl bg-rose-100 text-rose-700 border border-rose-300 flex items-center justify-center shrink-0 text-base shadow-xs';
                if (alertIcon) alertIcon.className = 'fa-solid fa-triangle-exclamation text-rose-600 animate-pulse text-lg';
                if (alertTitle) alertTitle.innerText = 'PERINGATAN: PERANGKAT DALAM KONDISI RUSAK';
                if (alertBadge) {
                    alertBadge.className = 'px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-rose-600 text-white shadow-2xs animate-pulse';
                    alertBadge.innerText = 'RUSAK / PERLU SERVIS';
                }
                if (alertDesc) alertDesc.innerText = 'Alat ini tercatat rusak pada formulir fasilitas lab. Segera lakukan pemeriksaan, catat tindakan perbaikan/servis di bawah, dan ubah kondisi menjadi BAIK setelah alat berhasil diperbaiki.';
                if (hint) hint.innerText = 'Status: RUSAK (Perlu Servis)';
                alertBox.classList.remove('hidden');
            } else if (kondisi === 'sedang') {
                alertBox.className = 'max-w-3xl mx-auto mb-4 p-4 rounded-2xl border border-amber-300 bg-amber-50/80 text-amber-950 transition-all animate-in fade-in slide-in-from-top-2 shadow-xs';
                if (alertIconBox) alertIconBox.className = 'w-10 h-10 rounded-xl bg-amber-100 text-amber-700 border border-amber-300 flex items-center justify-center shrink-0 text-base shadow-xs';
                if (alertIcon) alertIcon.className = 'fa-solid fa-circle-exclamation text-amber-600 text-lg';
                if (alertTitle) alertTitle.innerText = 'PERHATIAN: PERANGKAT DALAM KONDISI SEDANG';
                if (alertBadge) {
                    alertBadge.className = 'px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-amber-600 text-white shadow-2xs';
                    alertBadge.innerText = 'KONDISI SEDANG';
                }
                if (alertDesc) alertDesc.innerText = 'Kondisi alat memerlukan perawatan berkala atau pengecekan komponen.';
                if (hint) hint.innerText = 'Status: SEDANG (Perlu Perawatan)';
                alertBox.classList.remove('hidden');
            } else {
                alertBox.classList.add('hidden');
                if (hint) hint.innerText = 'Status: Normal / Baik';
            }
        }

        // Update Riwayat Single Field Inline via AJAX
        function updateRiwayatInline(riwayatId, field, value) {
            if (!riwayatId) return;
            showSaveIndicator('saving', 'Menyimpan...');

            fetch(`/admin/properti/riwayat-alat/${riwayatId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ field: field, value: value })
            })
            .then(async res => {
                const data = await res.json().catch(() => null);
                if (!res.ok) {
                    throw new Error(data?.message || `Gagal menyimpan (Kode: ${res.status})`);
                }
                return data;
            })
            .then(data => {
                if (data && data.status === 'success') {
                    showSaveIndicator('saved', 'Tersimpan otomatis');
                    // Update in-memory item
                    if (currentItemForSheet && currentItemForSheet.riwayats) {
                        const r = currentItemForSheet.riwayats.find(x => x.id == riwayatId);
                        if (r) {
                            r[field] = value;
                        }
                    }
                    if (itemsMap[currentItemForSheet?.id]?.riwayats) {
                        const r = itemsMap[currentItemForSheet.id].riwayats.find(x => x.id == riwayatId);
                        if (r) {
                            r[field] = value;
                        }
                    }
                    if (currentItemForSheet) {
                        updateToolCardDisplay(currentItemForSheet.id);
                    }
                } else {
                    showSaveIndicator('error', (data && data.message) || 'Gagal menyimpan');
                }
            })
            .catch(err => {
                console.error(err);
                showSaveIndicator('error', err.message || 'Koneksi bermasalah');
            });
        }

        // Add New Action Row Directly to Tool
        function addNewRiwayatInline(itemId) {
            if (!itemId) {
                if (currentItemForSheet) itemId = currentItemForSheet.id;
                else return;
            }
            showSaveIndicator('saving', 'Menambah baris...');

            const now = new Date();
            const pad = (n) => String(n).padStart(2, '0');
            const nowFormatted = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())} ${pad(now.getHours())}:${pad(now.getMinutes())}`;

            fetch(`/admin/properti/riwayat-alat/item/${itemId}/quick-store`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tindakan: '',
                    tanggal_mulai: nowFormatted
                })
            })
            .then(async res => {
                const data = await res.json().catch(() => null);
                if (!res.ok) {
                    throw new Error(data?.message || `Gagal menambah baris (Kode: ${res.status})`);
                }
                return data;
            })
            .then(data => {
                if (data && data.status === 'success' && data.riwayat) {
                    showSaveIndicator('saved', 'Baris berhasil ditambahkan');
                    if (!itemsMap[itemId].riwayats) itemsMap[itemId].riwayats = [];
                    itemsMap[itemId].riwayats.push(data.riwayat);
                    if (currentItemForSheet && currentItemForSheet.id == itemId) {
                        currentItemForSheet.riwayats = itemsMap[itemId].riwayats;
                    }
                    openKartuSheetModal(itemsMap[itemId]);
                    updateToolCardDisplay(itemId);

                    // Auto-focus on new row's tindakan input
                    setTimeout(() => {
                        const targetInput = document.getElementById(`riwayat-tindakan-${data.riwayat.id}`);
                        if (targetInput) {
                            targetInput.focus();
                        }
                    }, 120);
                } else {
                    showSaveIndicator('error', (data && data.message) || 'Gagal menambah baris');
                }
            })
            .catch(err => {
                console.error(err);
                showSaveIndicator('error', err.message || 'Koneksi bermasalah');
            });
        }

        // Delete Action Row Directly with Confirmation
        function hapusRiwayatRow(riwayatId, itemId) {
            Swal.fire({
                title: 'Hapus baris tindakan ini?',
                text: 'Data riwayat pemeliharaan ini akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showSaveIndicator('saving', 'Menghapus...');

                    fetch(`/admin/properti/riwayat-alat/${riwayatId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(async res => {
                        const data = await res.json().catch(() => null);
                        if (!res.ok) {
                            throw new Error(data?.message || `Gagal menghapus baris (Kode: ${res.status})`);
                        }
                        return data;
                    })
                    .then(data => {
                        if (data && data.status === 'success') {
                            showSaveIndicator('saved', 'Baris berhasil dihapus');
                            if (itemsMap[itemId] && itemsMap[itemId].riwayats) {
                                itemsMap[itemId].riwayats = itemsMap[itemId].riwayats.filter(x => x.id != riwayatId);
                            }
                            if (currentItemForSheet && currentItemForSheet.id == itemId) {
                                currentItemForSheet.riwayats = (currentItemForSheet.riwayats || []).filter(x => x.id != riwayatId);
                                openKartuSheetModal(currentItemForSheet);
                            } else if (itemsMap[itemId]) {
                                openKartuSheetModal(itemsMap[itemId]);
                            }
                            updateToolCardDisplay(itemId);
                        } else {
                            showSaveIndicator('error', (data && data.message) || 'Gagal menghapus');
                        }
                    })
                    .catch(err => {
                        console.error('Error hapus riwayat:', err);
                        showSaveIndicator('error', err.message || 'Koneksi bermasalah');
                    });
                }
            });
        }

        // Update Card Display in Main Background View
        function updateToolCardDisplay(itemId) {
            const item = itemsMap[itemId];
            if (!item) return;

            const elNama = document.getElementById(`card-nama-${itemId}`);
            if (elNama) elNama.innerText = item.nama_properti || '';

            const elInv = document.getElementById(`card-inv-${itemId}`);
            if (elInv) elInv.innerText = item.nomor_inventaris || '';

            const elSpec = document.getElementById(`card-spec-${itemId}`);
            if (elSpec) elSpec.innerText = item.merk_type || '-';

            const kondisi = (item.kondisi || 'baik').toLowerCase();
            const isRusak = (kondisi === 'rusak');
            const isSedang = (kondisi === 'sedang');

            // 1. Update Card Border and Background
            const cardEl = document.getElementById(`tool-card-${itemId}`);
            if (cardEl) {
                if (isRusak) {
                    cardEl.className = 'bg-rose-50/25 hover:bg-rose-50/50 border-2 border-rose-300 border-l-4 border-l-rose-600 shadow-sm shadow-rose-100 rounded-2xl p-4 sm:p-5 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 cursor-pointer group';
                } else if (isSedang) {
                    cardEl.className = 'bg-amber-50/15 hover:bg-amber-50/30 border border-amber-300 border-l-4 border-l-amber-500 shadow-2xs shadow-amber-100 rounded-2xl p-4 sm:p-5 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 cursor-pointer group';
                } else {
                    cardEl.className = 'bg-white hover:bg-slate-50/50 border border-slate-200/90 hover:border-teal-400/90 shadow-xs hover:shadow-md rounded-2xl p-4 sm:p-5 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 cursor-pointer group';
                }
            }

            // 2. Update Card Icon Box
            const iconBox = document.getElementById(`card-icon-${itemId}`);
            if (iconBox) {
                const namaLower = (item.nama_properti || '').toLowerCase();
                let iconClass = 'fa-desktop text-teal-700';
                if (namaLower.includes('printer')) iconClass = 'fa-print text-indigo-700';
                else if (namaLower.includes('cctv') || namaLower.includes('kamera')) iconClass = 'fa-video text-amber-700';
                else if (namaLower.includes('ac')) iconClass = 'fa-snowflake text-sky-700';
                else if (namaLower.includes('server') || namaLower.includes('switch') || namaLower.includes('router')) iconClass = 'fa-server text-purple-700';

                let bgClass = 'bg-teal-50 border-teal-200/80';
                if (isRusak) {
                    bgClass = 'bg-rose-100 border-rose-300 text-rose-700';
                } else if (isSedang) {
                    bgClass = 'bg-amber-100 border-amber-300 text-amber-700';
                }

                iconBox.className = `w-11 h-11 rounded-2xl ${bgClass} border flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition relative`;
                iconBox.innerHTML = `
                    <i class="fa-solid ${iconClass} text-base"></i>
                    ${isRusak ? '<span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-600 text-white flex items-center justify-center text-[9px] font-black border-2 border-white shadow-xs" title="Perangkat Rusak">!</span>' : ''}
                `;
            }

            // 3. Update Title Color
            if (elNama) {
                elNama.className = `font-black text-sm sm:text-base ${isRusak ? 'text-rose-950' : 'text-slate-900'} group-hover:text-teal-900 transition truncate`;
            }

            // 4. Update Kondisi Badge
            const elKondisi = document.getElementById(`card-kondisi-${itemId}`);
            if (elKondisi) {
                if (isRusak) {
                    elKondisi.className = 'px-2.5 py-0.5 text-[10px] font-black rounded-md uppercase flex items-center gap-1 shadow-2xs bg-rose-100 text-rose-800 border border-rose-300';
                    elKondisi.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-rose-600 animate-pulse"></i> RUSAK';
                } else if (isSedang) {
                    elKondisi.className = 'px-2.5 py-0.5 text-[10px] font-black rounded-md uppercase flex items-center gap-1 shadow-2xs bg-amber-100 text-amber-800 border border-amber-300';
                    elKondisi.innerHTML = '<i class="fa-solid fa-circle-exclamation text-amber-600"></i> SEDANG';
                } else {
                    elKondisi.className = 'px-2.5 py-0.5 text-[10px] font-black rounded-md uppercase flex items-center gap-1 shadow-2xs bg-emerald-50 text-emerald-700 border border-emerald-200/80';
                    elKondisi.innerHTML = '✓ BAIK';
                }
            }

            // 5. Update Banner Rusak
            const bannerRusak = document.getElementById(`card-banner-rusak-${itemId}`);
            if (bannerRusak) {
                if (isRusak) {
                    bannerRusak.classList.remove('hidden');
                } else {
                    bannerRusak.classList.add('hidden');
                }
            }

            // 6. Update Action Button
            const btnAction = document.getElementById(`card-btn-action-${itemId}`);
            if (btnAction) {
                if (isRusak) {
                    btnAction.className = 'px-3 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer bg-rose-600 hover:bg-rose-700 text-white font-black animate-pulse';
                    btnAction.title = 'Perangkat rusak! Klik untuk mencatat tindakan servis/perbaikan';
                    btnAction.innerHTML = '<i class="fa-solid fa-wrench text-[10px]"></i> <span>Perbaiki Alat</span>';
                } else {
                    btnAction.className = 'px-3 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer bg-teal-50 hover:bg-teal-100 text-teal-900 border border-teal-200/80';
                    btnAction.title = 'Catat tindakan baru lewat form CRUD';
                    btnAction.innerHTML = '<i class="fa-solid fa-plus text-[10px]"></i> <span>Catat Tindakan</span>';
                }
            }

            // 7. Update Riwayat Info & Count
            const riwayats = item.riwayats || [];
            const count = riwayats.length;

            const elCount = document.getElementById(`card-count-${itemId}`);
            if (elCount) {
                elCount.innerText = `${count} Tindakan`;
                if (count > 0) {
                    elCount.className = 'px-3 py-1.5 rounded-xl bg-teal-50 text-teal-800 border-teal-200 border text-xs font-extrabold whitespace-nowrap shadow-2xs';
                } else {
                    elCount.className = 'px-3 py-1.5 rounded-xl bg-slate-100 text-slate-500 border-slate-200 border text-xs font-extrabold whitespace-nowrap shadow-2xs';
                }
            }

            const elLatest = document.getElementById(`card-latest-${itemId}`);
            if (elLatest) {
                if (count > 0) {
                    const sortedDesc = riwayats.slice().sort((a, b) => {
                        const dateA = a.tanggal_mulai ? new Date(a.tanggal_mulai).getTime() : 0;
                        const dateB = b.tanggal_mulai ? new Date(b.tanggal_mulai).getTime() : 0;
                        if (dateA === dateB) return (b.id || 0) - (a.id || 0);
                        return dateB - dateA;
                    });
                    const latest = sortedDesc[0];
                    const tgl = latest.tanggal_mulai ? formatDateTime(latest.tanggal_mulai) : '-';
                    elLatest.innerHTML = `
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 block">Tindakan Terakhir</span>
                        <p class="text-xs font-bold text-slate-800">${tgl}</p>
                        <p class="text-[11px] text-teal-800 font-semibold max-w-[200px] truncate" title="${escapeHtml(latest.tindakan || '')}">${escapeHtml(latest.tindakan || '')}</p>
                    `;
                } else {
                    elLatest.innerHTML = `<span class="text-[11px] text-slate-400 italic">Belum ada riwayat tercatat</span>`;
                }
            }
        }

        // Modal Sheet Display (Visual match to UIKA Word Document with Inline Editing)
        function openKartuSheetModal(item) {
            currentItemForSheet = item;

            // Set Equipment Identity in Inline Inputs
            const inputNama = document.getElementById('sheet-nama-alat');
            if (inputNama) inputNama.value = item.nama_properti || '';

            const inputSpec = document.getElementById('sheet-spesifikasi');
            if (inputSpec) inputSpec.value = item.merk_type || '';

            const inputInv = document.getElementById('sheet-no-inventaris');
            if (inputInv) inputInv.value = item.nomor_inventaris || '';

            // Render Condition Alert Banner & Dropdown
            renderSheetConditionAlert(item.kondisi || 'baik');

            // Set single export url
            const exportBtn = document.getElementById('btn-export-single-docx');
            exportBtn.onclick = function() {
                window.location.href = `{{ url('/admin/properti/dokumen/' . $dokumen->id . '/riwayat-alat/export') }}?item_ids=${item.id}`;
            };

            // Render Rows (Data lama di atas, data baru di bawah sesuai urutan kronologis)
            const tbody = document.getElementById('sheet-table-body');
            tbody.innerHTML = '';

            const riwayats = (item.riwayats || []).slice().sort((a, b) => {
                const dateA = a.tanggal_mulai ? new Date(a.tanggal_mulai).getTime() : 0;
                const dateB = b.tanggal_mulai ? new Date(b.tanggal_mulai).getTime() : 0;
                if (dateA === dateB) return (a.id || 0) - (b.id || 0);
                return dateA - dateB;
            });
            let rowCount = 0;

            if (riwayats.length > 0) {
                riwayats.forEach((r, idx) => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-slate-50 transition group';

                    tr.innerHTML = `
                        <td class="border border-black p-1.5 align-middle">
                            <textarea id="riwayat-tindakan-${r.id}" rows="1" class="sheet-inline-input w-full p-1 rounded text-xs font-medium text-slate-900 resize-none overflow-hidden leading-snug"
                                placeholder="Tuliskan tindakan pemeliharaan / perbaikan..."
                                oninput="autoResizeTextarea(this)"
                                onblur="updateRiwayatInline(${r.id}, 'tindakan', this.value)">${escapeHtml(r.tindakan || '')}</textarea>
                        </td>
                        <td class="border border-black p-1 text-center align-middle">
                            <span class="hidden print-date-text text-xs font-medium">${r.tanggal_mulai ? formatDateTime(r.tanggal_mulai) : '-'}</span>
                            <input type="datetime-local" class="sheet-inline-input no-print-input w-full p-1 rounded text-xs text-center font-medium text-slate-900 cursor-pointer"
                                value="${toDatetimeLocalValue(r.tanggal_mulai)}"
                                title="Klik untuk ubah tanggal & waktu mulai"
                                onchange="updateRiwayatInline(${r.id}, 'tanggal_mulai', this.value)">
                        </td>
                        <td class="border border-black p-1 text-center align-middle">
                            <span class="hidden print-date-text text-xs font-medium">${r.tanggal_selesai ? formatDateTime(r.tanggal_selesai) : '-'}</span>
                            <input type="datetime-local" class="sheet-inline-input no-print-input w-full p-1 rounded text-xs text-center font-medium text-slate-900 cursor-pointer"
                                value="${toDatetimeLocalValue(r.tanggal_selesai)}"
                                title="Klik untuk ubah tanggal & waktu berakhir (opsional)"
                                onchange="updateRiwayatInline(${r.id}, 'tanggal_selesai', this.value)">
                        </td>
                        <td class="border border-black p-1 text-center align-middle">
                            <input type="text" class="sheet-inline-input w-full p-1 rounded text-xs text-center font-bold text-slate-900"
                                placeholder=""
                                value="${escapeHtml(r.paraf || '')}"
                                title="Paraf / Petugas (dapat dikosongkan untuk paraf fisik)"
                                onblur="updateRiwayatInline(${r.id}, 'paraf', this.value)">
                        </td>
                        <td class="border border-black p-1 text-center align-middle no-print">
                            <div class="flex items-center justify-center gap-1">
                                <button type="button" onclick="openEditRiwayatModalById(${r.id}, ${item.id})" class="w-6 h-6 rounded hover:bg-teal-50 text-slate-400 hover:text-teal-700 inline-flex items-center justify-center transition cursor-pointer" title="Ubah data tindakan ini">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button type="button" onclick="hapusRiwayatRow(${r.id}, ${item.id})" class="w-6 h-6 rounded hover:bg-rose-50 text-slate-400 hover:text-rose-600 inline-flex items-center justify-center transition cursor-pointer" title="Hapus baris tindakan ini">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                    rowCount++;
                });
            }

            // Interactive "Add Row" Row (Hidden on print)
            const addTr = document.createElement('tr');
            addTr.className = 'group hover:bg-teal-50/50 transition cursor-pointer no-print';
            addTr.onclick = function(e) {
                if (e.target.tagName !== 'BUTTON') {
                    addNewRiwayatInline(item.id);
                }
            };
            addTr.innerHTML = `
                <td class="border border-black p-2 text-slate-400 group-hover:text-teal-700 italic text-xs flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-plus text-xs text-teal-600"></i>
                    <span>+ Klik di sini untuk mencatat tindakan baru pada alat ini...</span>
                </td>
                <td class="border border-black p-2 text-center text-slate-300 text-xs">&nbsp;</td>
                <td class="border border-black p-2 text-center text-slate-300 text-xs">&nbsp;</td>
                <td class="border border-black p-2 text-center text-slate-300 text-xs">&nbsp;</td>
                <td class="border border-black p-1 text-center no-print text-slate-300 group-hover:text-teal-600">
                    <i class="fa-solid fa-plus text-xs"></i>
                </td>
            `;
            tbody.appendChild(addTr);
            rowCount++;

            // Fill empty rows to make 8 rows total (fits exactly in 1 page A6)
            const emptyRows = Math.max(0, 8 - rowCount);
            for (let i = 0; i < emptyRows; i++) {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50/30 cursor-pointer';
                tr.onclick = function() {
                    addNewRiwayatInline(item.id);
                };
                tr.innerHTML = `
                    <td class="border border-black p-2.5">&nbsp;</td>
                    <td class="border border-black p-2.5">&nbsp;</td>
                    <td class="border border-black p-2.5">&nbsp;</td>
                    <td class="border border-black p-2.5">&nbsp;</td>
                    <td class="border border-black p-1 text-center no-print">&nbsp;</td>
                `;
                tbody.appendChild(tr);
            }

            // Trigger auto resize on all textareas
            setTimeout(() => {
                document.querySelectorAll('#sheet-table-body textarea').forEach(ta => autoResizeTextarea(ta));
            }, 60);

            document.getElementById('modal-kartu-sheet').classList.remove('hidden');
        }

        function closeKartuSheetModal() {
            document.getElementById('modal-kartu-sheet').classList.add('hidden');
        }

        // Open Add Action Modal (CRUD Form)
        function openTambahRiwayatModal(preselectedId = null) {
            let targetItemIds = [];

            if (preselectedId) {
                targetItemIds = [preselectedId];
            } else {
                const checkedBoxes = Array.from(document.querySelectorAll('.tool-checkbox:checked'));
                if (checkedBoxes.length > 0) {
                    targetItemIds = checkedBoxes.map(cb => parseInt(cb.value));
                } else {
                    Swal.fire({
                        title: 'Pilih Alat Terlebih Dahulu',
                        text: 'Silakan centang kotak pilihan (multi-choose) di sebelah kiri kartu alat yang ingin Anda catat tindakannya.',
                        icon: 'info',
                        confirmButtonColor: '#0f766e',
                        confirmButtonText: 'Mengerti'
                    });
                    return;
                }
            }

            // Pisahkan target berdasarkan kondisi alat
            let nonRusakIds = [];
            let rusakIds = [];
            targetItemIds.forEach(id => {
                const it = itemsMap[id];
                const cond = (it?.kondisi || 'baik').toLowerCase();
                if (cond === 'rusak') {
                    rusakIds.push(id);
                } else {
                    nonRusakIds.push(id);
                }
            });

            let effectiveItemIds = [];
            let skippedRusakIds = [];

            if (!preselectedId && nonRusakIds.length > 0 && rusakIds.length > 0) {
                // ATURAN: Jika terdapat campuran alat Baik/Sedang dan Rusak:
                // Data TIDAK BOLEH masuk ke alat rusak (hanya masuk ke alat baik/sedang).
                // Kecuali jika seluruh alat yang dipilih adalah alat rusak saja.
                effectiveItemIds = nonRusakIds;
                skippedRusakIds = rusakIds;
            } else if (!preselectedId && nonRusakIds.length === 0 && rusakIds.length > 0) {
                // SEMUA ALAT YANG DIPILIH BERSTATUS RUSAK
                effectiveItemIds = rusakIds;
                skippedRusakIds = [];
            } else {
                // SEMUA ALAT BAIK/SEDANG ATAU PRESELECTED TUNGGAL
                effectiveItemIds = targetItemIds;
                skippedRusakIds = [];
            }

            // Populate hidden inputs ONLY with effectiveItemIds
            const hiddenContainer = document.getElementById('modal-hidden-item-ids');
            if (hiddenContainer) {
                hiddenContainer.innerHTML = effectiveItemIds.map(id => `<input type="hidden" name="item_ids[]" value="${id}">`).join('');
            }

            // Update Target Label, Badge & Skipped Alert
            const labelEl = document.getElementById('modal-target-tools-label');
            const countBadge = document.getElementById('modal-target-count-badge');
            const skippedAlert = document.getElementById('modal-skipped-rusak-alert');
            const skippedText = document.getElementById('modal-skipped-rusak-text');

            if (skippedRusakIds.length > 0) {
                if (skippedAlert) {
                    skippedAlert.classList.remove('hidden');
                    const skippedNames = skippedRusakIds.map(id => {
                        const it = itemsMap[id];
                        return it ? `${it.nama_properti} (${it.nomor_inventaris || 'ID:'+id})` : `ID:${id}`;
                    }).join(', ');
                    if (skippedText) {
                        skippedText.innerHTML = `<b>${skippedRusakIds.length} alat berstatus RUSAK dilewati otomatis:</b> <span class="underline font-bold text-rose-700">${escapeHtml(skippedNames)}</span>.<br>Data tindakan ini <b>hanya akan masuk ke ${effectiveItemIds.length} alat normal (Baik/Sedang)</b>, karena tindakan pemeliharaan alat baik/sedang tidak dapat dicampur dengan alat rusak.`;
                    }
                }
            } else {
                if (skippedAlert) skippedAlert.classList.add('hidden');
            }

            if (effectiveItemIds.length === 1) {
                const item = itemsMap[effectiveItemIds[0]];
                const isItemRusak = ((item?.kondisi || '').toLowerCase() === 'rusak');
                if (labelEl) {
                    labelEl.innerText = item ? `${item.nama_properti} ${item.nomor_inventaris ? '(' + item.nomor_inventaris + ')' : ''}` : '1 Alat Terpilih';
                }
                if (countBadge) {
                    countBadge.innerText = isItemRusak ? '1 Alat Rusak' : '1 Alat';
                    countBadge.className = isItemRusak 
                        ? 'px-2.5 py-1 bg-rose-100 text-rose-800 border border-rose-300 rounded-lg text-[11px] font-black shrink-0 animate-pulse'
                        : 'px-2.5 py-1 bg-teal-100 text-teal-800 border border-teal-300 rounded-lg text-[11px] font-black shrink-0';
                }
            } else {
                const isAllRusak = (nonRusakIds.length === 0 && rusakIds.length > 0);
                const names = effectiveItemIds.slice(0, 3).map(id => itemsMap[id]?.nama_properti || `ID:${id}`).join(', ');
                const moreText = effectiveItemIds.length > 3 ? ` +${effectiveItemIds.length - 3} lainnya` : '';
                if (labelEl) {
                    if (skippedRusakIds.length > 0) {
                        labelEl.innerText = `${effectiveItemIds.length} Alat Normal: ${names}${moreText}`;
                    } else if (isAllRusak) {
                        labelEl.innerText = `${effectiveItemIds.length} Alat Rusak: ${names}${moreText}`;
                    } else {
                        labelEl.innerText = `${effectiveItemIds.length} Alat Terpilih: ${names}${moreText}`;
                    }
                }
                if (countBadge) {
                    if (isAllRusak) {
                        countBadge.innerText = `${effectiveItemIds.length} Alat Rusak (Servis)`;
                        countBadge.className = 'px-2.5 py-1 bg-rose-100 text-rose-800 border border-rose-300 rounded-lg text-[11px] font-black shrink-0 animate-pulse';
                    } else {
                        countBadge.innerText = `${effectiveItemIds.length} Alat Serentak`;
                        countBadge.className = 'px-2.5 py-1 bg-teal-100 text-teal-800 border border-teal-300 rounded-lg text-[11px] font-black shrink-0';
                    }
                }
            }

            const modal = document.getElementById('modal-tambah-riwayat');
            const form = document.getElementById('form-riwayat-alat');
            const title = document.getElementById('modal-riwayat-title');
            const methodInput = document.getElementById('form-riwayat-method');
            const submitText = document.getElementById('btn-submit-riwayat-text');

            if (title) title.innerText = 'Catat Tindakan Pemeliharaan Alat';
            if (submitText) submitText.innerText = 'Simpan Riwayat Tindakan';
            if (form) form.action = "{{ route('admin.properti.riwayat-alat.store', $dokumen->id) }}";
            if (methodInput) methodInput.value = 'POST';

            // Reset fields
            if (form) {
                const ta = form.querySelector('[name="tindakan"]');
                if (ta) ta.value = '';
                const now = new Date();
                const pad = (n) => String(n).padStart(2, '0');
                const tglM = form.querySelector('[name="tanggal_mulai"]');
                if (tglM) tglM.value = `${now.getFullYear()}-${pad(now.getMonth()+1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;
                const tglS = form.querySelector('[name="tanggal_selesai"]');
                if (tglS) tglS.value = '';
            }

            modal.classList.remove('hidden');
        }

        // Open Edit Action Modal
        function openEditRiwayatModalById(riwayatId, itemId) {
            const item = itemsMap[itemId];
            if (!item || !item.riwayats) return;
            const r = item.riwayats.find(x => x.id == riwayatId);
            if (!r) return;

            closeKartuSheetModal();

            const skippedAlert = document.getElementById('modal-skipped-rusak-alert');
            if (skippedAlert) skippedAlert.classList.add('hidden');

            // Populate hidden inputs
            const hiddenContainer = document.getElementById('modal-hidden-item-ids');
            if (hiddenContainer) {
                hiddenContainer.innerHTML = `<input type="hidden" name="item_ids[]" value="${itemId}">`;
            }

            // Update Target Label & Badge
            const labelEl = document.getElementById('modal-target-tools-label');
            const countBadge = document.getElementById('modal-target-count-badge');
            if (labelEl) {
                labelEl.innerText = `${item.nama_properti} ${item.nomor_inventaris ? '(' + item.nomor_inventaris + ')' : ''}`;
            }
            if (countBadge) countBadge.innerText = '1 Alat';

            const modal = document.getElementById('modal-tambah-riwayat');
            const form = document.getElementById('form-riwayat-alat');
            const title = document.getElementById('modal-riwayat-title');
            const methodInput = document.getElementById('form-riwayat-method');
            const submitText = document.getElementById('btn-submit-riwayat-text');

            if (title) title.innerText = 'Ubah Tindakan Pemeliharaan Alat';
            if (submitText) submitText.innerText = 'Simpan Perubahan';
            if (form) form.action = `/admin/properti/riwayat-alat/${r.id}`;
            if (methodInput) methodInput.value = 'PUT';

            // Populate form fields
            if (form) {
                const ta = form.querySelector('[name="tindakan"]');
                if (ta) ta.value = r.tindakan || '';
                const tglM = form.querySelector('[name="tanggal_mulai"]');
                if (tglM) tglM.value = toDatetimeLocalValue(r.tanggal_mulai);
                const tglS = form.querySelector('[name="tanggal_selesai"]');
                if (tglS) tglS.value = toDatetimeLocalValue(r.tanggal_selesai);
            }

            modal.classList.remove('hidden');
        }

        function openTambahRiwayatForCurrentTool() {
            if (currentItemForSheet) {
                closeKartuSheetModal();
                openTambahRiwayatModal(currentItemForSheet.id);
            }
        }

        function closeTambahRiwayatModal() {
            document.getElementById('modal-tambah-riwayat').classList.add('hidden');
        }

        // Helper date formatter
        function formatDateTime(str) {
            try {
                const d = new Date(str);
                const day = String(d.getDate()).padStart(2, '0');
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const year = d.getFullYear();
                const hours = String(d.getHours()).padStart(2, '0');
                const mins = String(d.getMinutes()).padStart(2, '0');
                return `${day}/${month}/${year} ${hours}:${mins}`;
            } catch (e) {
                return str;
            }
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
        }
    </script>
</body>
</html>

