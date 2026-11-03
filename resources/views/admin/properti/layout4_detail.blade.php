<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Fasilitas dan Properti - {{ $dokumen->nomor_dokumen }} - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        
        /* Gaya Khusus Cetak Sesuai Format Lembar Fisik */
        @media print {
            aside, header, #sidebarWrapper, #formTambahWrapper, #actionButtons, .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
            main {
                overflow: visible !important;
                height: auto !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            #printPaper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                width: 100% !important;
            }
            table {
                font-size: 10px !important;
            }
            table th, table td {
                border: 1px solid #000 !important;
                padding: 4px 6px !important;
            }
            .inline-cell-input {
                border: none !important;
                background: transparent !important;
                padding: 0 !important;
                box-shadow: none !important;
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
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 flex-shrink-0 no-print">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleAdminMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition focus:outline-none cursor-pointer" title="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Formulir Properti: {{ $dokumen->nomor_dokumen }}</h2>
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
        <div class="flex-grow overflow-auto p-6 space-y-6">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Header Actions & Multi-Filter Bar (No-Print) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4 no-print">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <a href="{{ route('admin.properti.lab', $dokumen->lab_id) }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-arrow-left text-xs"></i>
                                    <span>Kembali ke Dokumen Lab</span>
                                </a>
                                <span class="text-slate-300">•</span>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $dokumen->laboratorium->nama_lab ?? '-' }}</span>
                            </div>
                            <h3 class="font-extrabold text-base text-slate-800">Daftar Fasilitas dan Properti (FT-SPR-INS-F-01)</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Seluruh data pada tabel di bawah dapat langsung diubah di tempat (*inline edit*).</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2.5 flex-wrap" id="actionButtons">
                            <button type="button" onclick="window.print()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-1.5 border border-slate-200 cursor-pointer">
                                <i class="fa-solid fa-print text-xs"></i> Cetak Dokumen
                            </button>

                            <button type="button" onclick="toggleFormTambah()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs rounded-xl transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                                <i class="fa-solid fa-plus text-xs"></i> Tambah Data Properti
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card Widget: Ringkasan Total Barang (No-Print) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-3 no-print">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-teal-700 text-sm"></i>
                            <h4 class="font-extrabold text-sm text-slate-800">Ringkasan Total Barang</h4>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-500 font-semibold">Total Keseluruhan:</span>
                            <span class="px-3 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-extrabold text-xs border border-emerald-200">
                                {{ $totalKeseluruhan }} Unit
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5">
                        @forelse($summary as $label => $jumlah)
                            <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/80 flex flex-col justify-between">
                                <span class="text-[11px] font-semibold text-slate-600 leading-tight truncate" title="{{ $label }}">
                                    ● {{ $label }}
                                </span>
                                <span class="text-sm font-extrabold text-teal-800 mt-1">
                                    {{ $jumlah }} Unit
                                </span>
                            </div>
                        @empty
                            <div class="col-span-full py-2 text-xs text-slate-400 italic">
                                Belum ada barang yang didata dalam dokumen ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Form Tambah Data Properti (Card Collapsible) -->
                <div id="formTambahWrapper" class="hidden bg-white border border-teal-700 rounded-2xl p-5 shadow-md space-y-4 no-print transition-all">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-800 flex items-center justify-center font-bold text-xs">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-800">Form Tambah Data Properti</h4>
                                <p class="text-[11px] text-slate-400">Nomor dan Ruang otomatis terisi dan dapat disesuaikan.</p>
                            </div>
                        </div>
                        <button type="button" onclick="toggleFormTambah()" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center transition">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <form id="formTambahItem" action="{{ route('admin.properti.item.store', $dokumen->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                            <!-- 1. Kategori Barang -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Kategori Barang <span class="text-red-500">*</span></label>
                                <select name="kategori_id" id="inputKategoriId" required onchange="handleKategoriChange()" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat->id }}" data-kode="{{ $kat->kode }}" data-nama="{{ $kat->nama }}">
                                            {{ $kat->nama }} {{ $kat->kode ? "({$kat->kode})" : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 2. Sub Kategori Barang -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Sub Kategori Barang</label>
                                <select name="sub_kategori_id" id="inputSubKategoriId" onchange="handleSubKategoriChange()" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="">-- Pilih Sub Kategori --</option>
                                    @foreach($subKategoriList as $sub)
                                        <option value="{{ $sub->id }}" data-parent="{{ $sub->parent_id }}" data-kode="{{ $sub->kode }}" data-nama="{{ $sub->nama }}">
                                            {{ $sub->nama }} {{ $sub->kode ? "({$sub->kode})" : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 3. Nama Properti -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Nama Properti <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_properti" id="inputNamaProperti" required placeholder="Contoh: AC, Komputer, Meja" onblur="fetchAutoCode()" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium focus:ring-2 focus:ring-teal-700/30 outline-none">
                            </div>

                            <!-- 4. Merk / Type -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Merk / Type</label>
                                <input type="text" name="merk_type" placeholder="Contoh: Sharp 1pk, Ryzen 7 3700X" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium focus:ring-2 focus:ring-teal-700/30 outline-none">
                            </div>

                            <!-- 5. Nomor (Otomatis Terisi) -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="text-slate-700 font-extrabold">Nomor (Kode Barang)</label>
                                    <span class="text-[10px] text-teal-700 font-bold cursor-pointer hover:underline" onclick="fetchAutoCode()">Refresh</span>
                                </div>
                                <input type="text" name="nomor_inventaris" id="inputNomorInventaris" value="{{ $defaultNomor }}" class="w-full py-2 px-3 rounded-xl bg-slate-100 border border-slate-200 font-mono font-bold text-teal-900 focus:ring-2 focus:ring-teal-700/30 outline-none">
                            </div>

                            <!-- 6. Ruang (Otomatis Terisi) -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Ruang (Otomatis)</label>
                                <input type="text" name="ruang" id="inputRuang" value="{{ $defaultRuang }}" class="w-full py-2 px-3 rounded-xl bg-slate-100 border border-slate-200 font-bold text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none">
                            </div>

                            <!-- 7. Harga -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Harga (Rp)</label>
                                <input type="number" name="harga" placeholder="Contoh: 15000000" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium focus:ring-2 focus:ring-teal-700/30 outline-none">
                            </div>

                            <!-- 8. Tahun -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Tahun Pengadaan</label>
                                <input type="text" name="tahun" value="{{ date('Y') }}" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium focus:ring-2 focus:ring-teal-700/30 outline-none">
                            </div>

                            <!-- 9. Kondisi -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Kondisi <span class="text-red-500">*</span></label>
                                <select name="kondisi" required class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="baik">Baik ✓</option>
                                    <option value="sedang">Sedang</option>
                                    <option value="rusak">Rusak ✗</option>
                                </select>
                            </div>

                            <!-- 10. Frekuensi Pemeliharaan -->
                            <div class="sm:col-span-2 lg:col-span-3">
                                <label class="block text-slate-700 font-extrabold mb-1">Frekuensi Pemeliharaan</label>
                                <input type="text" name="frekuensi_pemeliharaan" value="6 Bulan" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium focus:ring-2 focus:ring-teal-700/30 outline-none">
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                            <button type="button" onclick="toggleFormTambah()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-xs transition">
                                Tutup
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Simpan ke Tabel Dokumen</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- LEMBAR KERJA FISIK DOKUMEN (FT-SPR-INS-F-01) -->
                <div id="printPaper" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
                    
                    <!-- HEADER DOKUMEN RESMI UIKA (Persis Foto 2) -->
                    <div class="border border-slate-800 rounded-lg overflow-hidden">
                        <div class="grid grid-cols-12 divide-x divide-slate-800">
                            <!-- Logo & Kop Kiri -->
                            <div class="col-span-3 sm:col-span-2 p-3 flex flex-col items-center justify-center bg-slate-50">
                                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-14 h-14 object-contain">
                                <span class="text-[9px] font-extrabold text-slate-800 text-center mt-1 uppercase tracking-tight">UIKA BOGOR</span>
                            </div>

                            <!-- Judul Dokumen Tengah -->
                            <div class="col-span-6 sm:col-span-7 p-4 flex flex-col items-center justify-center text-center">
                                <span class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">FORMULIR MUTU</span>
                                <h1 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-tight">
                                    DAFTAR FASILITAS DAN PROPERTI
                                </h1>
                                <p class="text-[11px] font-semibold text-teal-800 mt-0.5">
                                    {{ strtoupper($dokumen->laboratorium->nama_lab ?? 'LABORATORIUM') }}
                                </p>
                            </div>

                            <!-- Metadata Kanan (No Dokumen, No Revisi, Tanggal, Halaman) -->
                            <div class="col-span-3 sm:col-span-3 text-[10px] sm:text-[11px] divide-y divide-slate-800 font-medium">
                                <div class="p-1.5 px-2 flex justify-between">
                                    <span class="text-slate-500">No. Dokumen:</span>
                                    <span class="font-bold text-slate-800 font-mono">{{ $dokumen->nomor_dokumen }}</span>
                                </div>
                                <div class="p-1.5 px-2 flex justify-between">
                                    <span class="text-slate-500">No. Revisi:</span>
                                    <span class="font-bold text-slate-800">{{ $dokumen->nomor_revisi }}</span>
                                </div>
                                <div class="p-1.5 px-2 flex justify-between">
                                    <span class="text-slate-500">Tgl. Pendataan:</span>
                                    <span class="font-bold text-slate-800">
                                        {{ \Carbon\Carbon::parse($dokumen->tanggal_pendataan)->format('d-m-Y') }}
                                    </span>
                                </div>
                                <div class="p-1.5 px-2 flex justify-between">
                                    <span class="text-slate-500">Halaman:</span>
                                    <span class="font-bold text-slate-800">1 dari 1</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifikasi / Petunjuk Ubah Langsung (No-Print) -->
                    <div class="flex items-center justify-between text-xs text-slate-600 bg-slate-50 p-2.5 px-4 rounded-xl border border-slate-200 no-print">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-teal-700"></i>
                            <span><b>Ubah Langsung Aktif:</b> Edit nilai di sel tabel di bawah, perubahan akan otomatis tersimpan ke sistem.</span>
                        </span>
                        <span id="saveStatusIndicator" class="text-[11px] font-bold text-emerald-600 hidden">
                            <i class="fa-solid fa-check"></i> Tersimpan
                        </span>
                    </div>

                    <!-- TABEL 11 KOLOM INTERAKTIF (DENGAN INLINE EDITING) -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border border-slate-800 border-collapse">
                            <thead>
                                <tr class="bg-slate-100 text-slate-900 font-bold uppercase tracking-wider text-[10px] text-center border-b border-slate-800">
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2 w-10">No</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2.5 min-w-[130px]">Kategori Barang</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2.5 min-w-[130px]">Sub Kategori Barang</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2.5 min-w-[120px]">Nama Properti</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2.5 min-w-[130px]">Merk / Type</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2.5 min-w-[160px]">Nomor</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2 min-w-[90px]">Ruang</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2 min-w-[90px]">Harga (Rp)</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2 w-14">Tahun</th>
                                    <th colspan="3" class="border border-slate-800 py-1.5 px-2 text-center">Kondisi</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2.5 min-w-[110px]">Frekuensi Pemeliharaan</th>
                                    <th rowspan="2" class="border border-slate-800 py-2 px-2 w-12 text-center no-print">Aksi</th>
                                </tr>
                                <tr class="bg-slate-100 text-slate-900 font-bold uppercase text-[9px] text-center border-b border-slate-800">
                                    <th class="border border-slate-800 py-1 px-1.5 w-11">Baik</th>
                                    <th class="border border-slate-800 py-1 px-1.5 w-11">Sedang</th>
                                    <th class="border border-slate-800 py-1 px-1.5 w-11">Rusak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($items as $index => $item)
                                    <tr class="hover:bg-slate-50 transition text-slate-800" data-item-id="{{ $item->id }}">
                                        <!-- 1. No -->
                                        <td class="border border-slate-800 py-1.5 px-2 text-center font-bold text-slate-600">
                                            {{ $index + 1 }}
                                        </td>

                                        <!-- 2. Kategori Barang -->
                                        <td class="border border-slate-800 p-1">
                                            <select onchange="updateInline({{ $item->id }}, 'kategori_id', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input font-medium">
                                                <option value="">-</option>
                                                @foreach($kategoriList as $k)
                                                    <option value="{{ $k->id }}" {{ $item->kategori_id == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <!-- 3. Sub Kategori Barang -->
                                        <td class="border border-slate-800 p-1">
                                            <select onchange="updateInline({{ $item->id }}, 'sub_kategori_id', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input font-medium">
                                                <option value="">-</option>
                                                @foreach($subKategoriList as $s)
                                                    <option value="{{ $s->id }}" {{ $item->sub_kategori_id == $s->id ? 'selected' : '' }}>
                                                        {{ $s->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <!-- 4. Nama Properti -->
                                        <td class="border border-slate-800 p-1">
                                            <input type="text" value="{{ $item->nama_properti }}" onblur="updateInline({{ $item->id }}, 'nama_properti', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input font-bold text-slate-900">
                                        </td>

                                        <!-- 5. Merk / Type -->
                                        <td class="border border-slate-800 p-1">
                                            <input type="text" value="{{ $item->merk_type }}" onblur="updateInline({{ $item->id }}, 'merk_type', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input">
                                        </td>

                                        <!-- 6. Nomor (Kode Inventaris Otomatis) -->
                                        <td class="border border-slate-800 p-1">
                                            <input type="text" value="{{ $item->nomor_inventaris }}" onblur="updateInline({{ $item->id }}, 'nomor_inventaris', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent font-mono text-[11px] font-semibold text-teal-900 inline-cell-input">
                                        </td>

                                        <!-- 7. Ruang -->
                                        <td class="border border-slate-800 p-1">
                                            <input type="text" value="{{ $item->ruang }}" onblur="updateInline({{ $item->id }}, 'ruang', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input text-center">
                                        </td>

                                        <!-- 8. Harga -->
                                        <td class="border border-slate-800 p-1">
                                            <input type="text" value="{{ number_format($item->harga, 0, ',', '.') }}" onblur="updateInline({{ $item->id }}, 'harga', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent text-right inline-cell-input font-medium">
                                        </td>

                                        <!-- 9. Tahun -->
                                        <td class="border border-slate-800 p-1">
                                            <input type="text" value="{{ $item->tahun }}" onblur="updateInline({{ $item->id }}, 'tahun', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent text-center inline-cell-input">
                                        </td>

                                        <!-- 10. Kondisi: 3 Kolom Ceklis (Baik, Sedang, Rusak) Sesuai Lembar Fisik UIKA -->
                                        <!-- Baik -->
                                        <td class="border border-slate-800 p-1 text-center cursor-pointer hover:bg-teal-50/60 transition group/cell" onclick="setKondisi({{ $item->id }}, 'baik')" title="Klik untuk pilih Kondisi: Baik">
                                            <span id="kondisi-baik-{{ $item->id }}" class="text-sm font-black text-slate-900 select-none {{ $item->kondisi === 'baik' ? '' : 'hidden' }}">✓</span>
                                        </td>

                                        <!-- Sedang -->
                                        <td class="border border-slate-800 p-1 text-center cursor-pointer hover:bg-amber-50/60 transition group/cell" onclick="setKondisi({{ $item->id }}, 'sedang')" title="Klik untuk pilih Kondisi: Sedang">
                                            <span id="kondisi-sedang-{{ $item->id }}" class="text-sm font-black text-slate-900 select-none {{ $item->kondisi === 'sedang' ? '' : 'hidden' }}">✓</span>
                                        </td>

                                        <!-- Rusak -->
                                        <td class="border border-slate-800 p-1 text-center cursor-pointer hover:bg-rose-50/60 transition group/cell" onclick="setKondisi({{ $item->id }}, 'rusak')" title="Klik untuk pilih Kondisi: Rusak">
                                            <span id="kondisi-rusak-{{ $item->id }}" class="text-sm font-black text-slate-900 select-none {{ $item->kondisi === 'rusak' ? '' : 'hidden' }}">✓</span>
                                        </td>

                                        <!-- 11. Frekuensi Pemeliharaan -->
                                        <td class="border border-slate-800 p-1">
                                            <input type="text" value="{{ $item->frekuensi_pemeliharaan }}" onblur="updateInline({{ $item->id }}, 'frekuensi_pemeliharaan', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input">
                                        </td>

                                        <!-- Aksi Hapus (No-Print) -->
                                        <td class="border border-slate-800 p-1 text-center no-print">
                                            <button type="button" onclick="hapusBaris({{ $item->id }})" class="w-7 h-7 rounded-md hover:bg-rose-50 text-slate-400 hover:text-rose-600 inline-flex items-center justify-center transition cursor-pointer" title="Hapus Baris Ini">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="border border-slate-800 py-10 text-center text-slate-400 italic">
                                            Belum ada fasilitas/properti yang diinput. Klik "+ Tambah Data Properti" untuk menambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Lembar Kerja (Tanda Tangan) -->
                    <div class="pt-8 grid grid-cols-2 text-center text-xs text-slate-800 font-medium">
                        <div>
                            <p>Mengetahui,</p>
                            <p class="font-bold">Kepala Laboratorium</p>
                            <div class="h-20"></div>
                            <p class="font-bold underline">{{ $dokumen->laboratorium->nama_kepala_lab ?? '( .............................................. )' }}</p>
                            <p class="text-[10px] text-slate-500">NIP: {{ $dokumen->laboratorium->nip_kepala_lab ?? '-' }}</p>
                        </div>
                        <div>
                            <p>Bogor, {{ \Carbon\Carbon::parse($dokumen->tanggal_pendataan)->translatedFormat('d F Y') }}</p>
                            <p class="font-bold">Laboran / Pengelola Lab</p>
                            <div class="h-20"></div>
                            <p class="font-bold underline">{{ $dokumen->laboratorium->nama_laboran ?? '( .............................................. )' }}</p>
                            <p class="text-[10px] text-slate-500">Petugas Pendataan</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const DOKUMEN_ID = {{ $dokumen->id }};

        function toggleProfileDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileDropdownMenu');
            const wrapper = document.getElementById('profileDropdownWrapper');
            if (menu && wrapper && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        function toggleFormTambah() {
            const formWrapper = document.getElementById('formTambahWrapper');
            formWrapper.classList.toggle('hidden');
            if (!formWrapper.classList.contains('hidden')) {
                formWrapper.scrollIntoView({ behavior: 'smooth' });
                document.getElementById('inputNamaProperti').focus();
            }
        }

        function handleKategoriChange() {
            const katSelect = document.getElementById('inputKategoriId');
            const selectedKatId = katSelect.value;
            const subSelect = document.getElementById('inputSubKategoriId');
            const options = subSelect.querySelectorAll('option');

            options.forEach(opt => {
                if (!opt.value) return;
                const parentId = opt.getAttribute('data-parent');
                if (!selectedKatId || parentId === selectedKatId) {
                    opt.style.display = 'block';
                } else {
                    opt.style.display = 'none';
                }
            });

            const selectedOpt = katSelect.options[katSelect.selectedIndex];
            const namaInput = document.getElementById('inputNamaProperti');
            if (!namaInput.value && selectedOpt && selectedOpt.getAttribute('data-nama')) {
                namaInput.value = selectedOpt.getAttribute('data-nama');
            }

            fetchAutoCode();
        }

        function handleSubKategoriChange() {
            const subSelect = document.getElementById('inputSubKategoriId');
            const selectedOpt = subSelect.options[subSelect.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                const parentId = selectedOpt.getAttribute('data-parent');
                if (parentId) {
                    document.getElementById('inputKategoriId').value = parentId;
                }
            }
            fetchAutoCode();
        }

        function fetchAutoCode() {
            const katId = document.getElementById('inputKategoriId').value;
            const subId = document.getElementById('inputSubKategoriId').value;
            const nama = document.getElementById('inputNamaProperti').value;

            const url = `{{ route('admin.properti.dokumen.generate-kode', $dokumen->id) }}?kategori_id=${katId}&sub_kategori_id=${subId}&nama_properti=${encodeURIComponent(nama)}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.nomor) {
                            document.getElementById('inputNomorInventaris').value = data.nomor;
                        }
                        if (data.ruang) {
                            document.getElementById('inputRuang').value = data.ruang;
                        }
                    }
                })
                .catch(err => console.error('Error auto-generating code:', err));
        }

        function setKondisi(itemId, val) {
            ['baik', 'sedang', 'rusak'].forEach(k => {
                const el = document.getElementById(`kondisi-${k}-${itemId}`);
                if (el) {
                    if (k === val) {
                        el.classList.remove('hidden');
                    } else {
                        el.classList.add('hidden');
                    }
                }
            });
            updateInline(itemId, 'kondisi', val);
        }

        function updateInline(itemId, field, value) {
            const saveIndicator = document.getElementById('saveStatusIndicator');
            saveIndicator.classList.remove('hidden');
            saveIndicator.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-teal-700"></i> Menyimpan...';

            fetch(`/admin/properti/item/${itemId}/inline-update`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ field: field, value: value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    saveIndicator.innerHTML = '<i class="fa-solid fa-check text-emerald-600"></i> Tersimpan';
                    setTimeout(() => {
                        saveIndicator.classList.add('hidden');
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: data.message || 'Terjadi kesalahan.',
                        timer: 2500,
                        showConfirmButton: false
                    });
                }
            })
            .catch(err => {
                console.error(err);
                saveIndicator.innerHTML = '<i class="fa-solid fa-xmark text-rose-500"></i> Gagal';
            });
        }

        function hapusBaris(itemId) {
            Swal.fire({
                title: 'Hapus Properti Ini?',
                text: 'Baris fasilitas properti ini akan dihapus dari tabel dokumen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl shadow-xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/properti/item/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const row = document.querySelector(`tr[data-item-id="${itemId}"]`);
                            if (row) {
                                row.remove();
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: 'Data properti berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        </script>
    @endif

</body>
</html>
