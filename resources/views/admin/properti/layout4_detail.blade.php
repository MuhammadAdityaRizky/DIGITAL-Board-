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
        
        /* Gaya Khusus Cetak Sesuai Format Lembar Fisik UIKA A4 Landscape */
        @page {
            size: A4 landscape;
            margin: 8mm 8mm 12mm 8mm;
            @bottom-center {
                content: counter(page);
                font-family: Calibri, sans-serif;
                font-size: 8.5pt;
                color: #334155;
            }
        }

        @media print {
            html, body {
                height: auto !important;
                overflow: visible !important;
                background: white !important;
                color: black !important;
            }
            aside, header, #sidebarWrapper, #formTambahWrapper, #actionButtons, .no-print {
                display: none !important;
            }
            main, div, .flex-grow, .overflow-auto, .overflow-x-auto, .overflow-y-auto, .max-w-7xl {
                overflow: visible !important;
                height: auto !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            #printPaper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            table {
                width: 100% !important;
                font-size: 8pt !important;
                border-collapse: collapse !important;
                table-layout: auto !important;
            }
            thead {
                display: table-header-group !important;
            }
            tr {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
            table th, table td {
                border: 1px solid #000 !important;
                padding: 3px 4px !important;
                min-width: 0 !important;
            }
            .print-text {
                display: inline-block !important;
            }
            select.no-print-select {
                display: none !important;
            }
            .inline-cell-input {
                border: none !important;
                background: transparent !important;
                padding: 0 !important;
                box-shadow: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                color: black !important;
                width: 100% !important;
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
                        <div class="flex items-center gap-2 flex-wrap" id="actionButtons">
                            <!-- Kartu Riwayat Alat (Khusus Alat Elektronik) -->
                            <a href="{{ route('admin.properti.riwayat-alat.index', $dokumen->id) }}" class="px-3.5 py-2 bg-white hover:bg-teal-50 rounded-xl transition flex items-center gap-2 border-2 border-teal-600 shadow-xs cursor-pointer group" style="background-color: #ffffff; border-color: #0d9488;" title="Kelola Kartu Riwayat Alat Elektronik (Komputer, PC, Printer, dll)">
                                <i class="fa-solid fa-microchip text-xs" style="color: #0d9488;"></i>
                                <span style="color: #064e3b; font-weight: 800; font-size: 12px;">Kartu Riwayat Alat</span>
                            </a>

                            <!-- Tombol Import Data -->
                            <button type="button" onclick="openImportModal()" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                                <i class="fa-solid fa-file-arrow-up text-xs"></i> Import Data
                            </button>

                            <!-- Dropdown Export Data -->
                            <div class="relative inline-block text-left" id="exportDropdownWrapper">
                                <button type="button" onclick="toggleExportDropdown(event)" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-1.5 border border-slate-200 shadow-xs cursor-pointer">
                                    <i class="fa-solid fa-file-arrow-down text-teal-700 text-xs"></i>
                                    <span>Export</span>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                                </button>
                                <div id="exportDropdownMenu" class="absolute right-0 top-full mt-1.5 w-52 bg-white border border-slate-200 rounded-2xl shadow-xl py-1.5 z-40 hidden origin-top-right">
                                    <div class="px-3 py-1.5 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                        Pilih Format Unduhan
                                    </div>
                                    <a href="{{ route('admin.properti.dokumen.export', ['dokumenId' => $dokumen->id, 'format' => 'docx']) }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-teal-900 transition">
                                        <i class="fa-solid fa-file-word text-blue-600 text-sm"></i>
                                        <div>
                                            <p class="font-bold leading-tight">Dokumen Word (.docx)</p>
                                            <p class="text-[10px] text-slate-400">Format formulir & ringkasan</p>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.properti.dokumen.export', ['dokumenId' => $dokumen->id, 'format' => 'xlsx']) }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-teal-900 transition">
                                        <i class="fa-solid fa-file-excel text-emerald-600 text-sm"></i>
                                        <div>
                                            <p class="font-bold leading-tight">Spreadsheet Excel (.xlsx)</p>
                                            <p class="text-[10px] text-slate-400">Data tabular lengkap</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Cetak Dokumen -->
                            <button type="button" onclick="window.print()" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-1.5 border border-slate-200 cursor-pointer">
                                <i class="fa-solid fa-print text-xs"></i> Cetak Dokumen
                            </button>

                            <!-- Edit Dokumen & No. Revisi -->
                            <button type="button" onclick="openModalEditDokumen()" class="px-3.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs rounded-xl transition flex items-center gap-1.5 border border-amber-300 shadow-2xs cursor-pointer" title="Ubah Nomor Revisi, Nomor Formulir, atau Tanggal Pendataan">
                                <i class="fa-solid fa-file-pen text-amber-700 text-xs"></i> Edit Revisi / Dokumen
                            </button>

                            <!-- Tambah Data Properti -->
                            <button type="button" onclick="toggleFormTambah()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs rounded-xl transition flex items-center gap-1.5 shadow-xs cursor-pointer">
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
                    
                    <!-- HEADER DOKUMEN RESMI UIKA (Persis Format Asli Foto Kertas Fisik) -->
                    <div class="border border-slate-800 rounded-lg overflow-hidden">
                        <div class="grid grid-cols-12 divide-x divide-slate-800">
                            <!-- 1. Logo Kiri -->
                            <div class="col-span-2 p-2 sm:p-3 flex items-center justify-center bg-slate-50/50">
                                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-12 h-12 object-contain">
                            </div>

                            <!-- 2. Metadata Tengah (No Dokumen, No Revisi, Tanggal Pendataan) -->
                            <div class="col-span-5 text-[10px] sm:text-[11px] divide-y divide-slate-800 font-medium flex flex-col justify-center">
                                <div class="grid grid-cols-12 divide-x divide-slate-800">
                                    <div class="col-span-7 p-1.5 px-2 flex justify-between items-center group cursor-pointer hover:bg-teal-50/70 transition" onclick="openModalEditDokumen()" title="Klik untuk ubah No. Dokumen / Revisi">
                                        <span class="text-slate-500">No. Dokumen:</span>
                                        <div class="flex items-center gap-1">
                                            <span id="docNomorDokumenDisplay" class="font-bold text-slate-800 font-mono">{{ $dokumen->nomor_dokumen }}</span>
                                            <i class="fa-solid fa-pen text-[8px] text-teal-600 opacity-0 group-hover:opacity-100 transition no-print"></i>
                                        </div>
                                    </div>
                                    <div class="col-span-5 p-1.5 px-2 flex justify-between items-center group cursor-pointer hover:bg-amber-50 transition" onclick="openModalEditDokumen()" title="Klik untuk ubah / tambah Nomor Revisi">
                                        <span class="text-slate-500">No. Revisi:</span>
                                        <div class="flex items-center gap-1">
                                            <span id="docNomorRevisiDisplay" class="font-bold text-slate-900 px-1 rounded bg-amber-100/70 border border-amber-300/60">{{ $dokumen->nomor_revisi ?: '0' }}</span>
                                            <i class="fa-solid fa-pen text-[8px] text-amber-700 opacity-60 group-hover:opacity-100 transition no-print"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1.5 px-2 flex justify-between items-center group cursor-pointer hover:bg-teal-50/70 transition" onclick="openModalEditDokumen()" title="Klik untuk ubah Tanggal Pendataan">
                                    <span class="text-slate-500">Tanggal Pendataan:</span>
                                    <div class="flex items-center gap-1">
                                        <span id="docTanggalDisplay" class="font-bold text-slate-800">
                                            {{ \Carbon\Carbon::parse($dokumen->tanggal_pendataan)->format('d-m-Y') }}
                                        </span>
                                        <i class="fa-solid fa-pen text-[8px] text-teal-600 opacity-0 group-hover:opacity-100 transition no-print"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Judul Dokumen Kanan -->
                            <div class="col-span-5 p-3 flex flex-col items-center justify-center text-center">
                                <h1 class="text-sm sm:text-base font-black text-slate-900 uppercase tracking-tight">
                                    DAFTAR FASILITAS DAN PROPERTI
                                </h1>
                                <p class="text-[10px] sm:text-[11px] font-bold text-teal-800 mt-0.5">
                                    {{ strtoupper($dokumen->laboratorium->nama_lab ?? 'LABORATORIUM') }}
                                </p>
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
                                            <span id="print-kategori-{{ $item->id }}" class="hidden print-text font-medium text-[8pt]">{{ $item->kategori?->nama ?? '-' }}</span>
                                            <select onchange="updateInline({{ $item->id }}, 'kategori_id', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input font-medium no-print-select">
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
                                            <span id="print-sub_kategori-{{ $item->id }}" class="hidden print-text font-medium text-[8pt]">{{ $item->subKategori?->nama ?? '-' }}</span>
                                            <select onchange="updateInline({{ $item->id }}, 'sub_kategori_id', this.value)" class="w-full text-xs p-1 rounded-md border border-transparent hover:border-slate-300 focus:border-teal-700 bg-transparent inline-cell-input font-medium no-print-select">
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
                            <p class="font-bold underline">{{ !empty($dokumen->laboratorium?->nama_kepala_lab) ? $dokumen->laboratorium->nama_kepala_lab : 'Dr. Jejen Jaenudin, S.Kom., M.Kom.' }}</p>
                            <p class="text-[10px] text-slate-500">NIP: {{ !empty($dokumen->laboratorium?->nip_kepala_lab) ? $dokumen->laboratorium->nip_kepala_lab : '410100470' }}</p>
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

    <!-- MODAL IMPORT DATA PROPERTI (WORD & EXCEL) -->
    <div id="importModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden p-4 transition-all">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-file-arrow-up text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-base text-slate-800">Import Data Inventaris</h3>
                        <p class="text-xs text-slate-500">Mendukung berkas Word (.docx) & Excel (.xlsx, .csv)</p>
                    </div>
                </div>
                <button type="button" onclick="closeImportModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="formImportProperti" action="{{ route('admin.properti.dokumen.import', $dokumen->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

                <!-- File Upload Box -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-2">Pilih Berkas Inventaris <span class="text-red-500">*</span></label>
                    <div id="dropZone" class="border-2 border-dashed border-slate-300 hover:border-emerald-600 bg-slate-50/60 hover:bg-emerald-50/30 rounded-2xl p-6 text-center cursor-pointer transition flex flex-col items-center justify-center group" onclick="document.getElementById('fileInput').click()">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-slate-200 flex items-center justify-center text-slate-500 group-hover:text-emerald-700 group-hover:scale-105 transition mb-3">
                            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-700 mb-1">
                            <span class="text-emerald-700 underline group-hover:text-emerald-800">Klik untuk jelajah berkas</span> atau seret berkas ke sini
                        </p>
                        <p class="text-[11px] text-slate-400">Word (.docx) atau Excel (.xlsx, .xls, .csv) • Maks. 20 MB</p>

                        <!-- Selected File Info -->
                        <div id="selectedFileInfo" class="hidden mt-3 p-2 px-3 bg-white border border-emerald-300 rounded-xl flex items-center gap-2 text-xs font-bold text-emerald-800">
                            <i class="fa-solid fa-check-circle text-emerald-600"></i>
                            <span id="selectedFileName" class="truncate max-w-[260px]">-</span>
                            <span id="selectedFileSize" class="text-[10px] text-slate-400 font-normal">(-)</span>
                        </div>
                    </div>
                    <input type="file" name="file" id="fileInput" accept=".docx,.doc,.xlsx,.xls,.csv" required class="hidden" onchange="handleFileSelected(this)">
                </div>

                <!-- Mode Import Option -->
                <div class="space-y-2">
                    <label class="block text-xs font-extrabold text-slate-700">Mode Impor Data</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <label class="flex items-start gap-2.5 p-3 rounded-xl border border-slate-200 hover:border-teal-700/60 bg-white cursor-pointer transition">
                            <input type="radio" name="mode" value="append" checked class="mt-0.5 text-teal-700 focus:ring-teal-700">
                            <div>
                                <span class="font-bold text-slate-800 block">Tambah Data (Append)</span>
                                <span class="text-[11px] text-slate-400 leading-tight block">Menambahkan barang tanpa menghapus data sebelumnya.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-2.5 p-3 rounded-xl border border-slate-200 hover:border-rose-400 bg-white cursor-pointer transition">
                            <input type="radio" name="mode" value="replace" class="mt-0.5 text-rose-600 focus:ring-rose-500">
                            <div>
                                <span class="font-bold text-slate-800 block text-rose-700">Ganti Semua (Replace)</span>
                                <span class="text-[11px] text-slate-400 leading-tight block">Hapus semua data di dokumen ini lalu isi data dari berkas.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Petunjuk Format -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-3 text-[11px] text-slate-600 space-y-1">
                    <div class="flex items-center gap-1.5 font-bold text-slate-700">
                        <i class="fa-solid fa-circle-info text-teal-700 text-xs"></i>
                        <span>Format Didukung:</span>
                    </div>
                    <p class="leading-relaxed">
                        Mendukung tabel format <b>Daftar Inventaris Barang.docx</b> maupun format mutu fisik <b>FT-SPR-INS-F-01</b> (kategori, sub-kategori, nomor, ruang, dan kondisi ceklis Baik/Sedang/Rusak).
                    </p>
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitImport" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs transition shadow-sm flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-file-arrow-up text-xs"></i>
                        <span id="btnSubmitImportText">Mulai Impor</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT DOKUMEN & NOMOR REVISI -->
    <div id="editDokumenModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden p-4 transition-all">
        <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-file-pen text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-base text-slate-800">Ubah No. Revisi & Info Dokumen</h3>
                        <p class="text-xs text-slate-500">Perbarui nomor revisi, kode dokumen, atau tanggal pendataan</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditDokumenModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body Form -->
            <form id="formEditDokumen" onsubmit="submitEditDokumen(event)" class="p-6 space-y-4">
                <!-- No. Revisi (Utama) -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">
                        Nomor Revisi <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="modalNomorRevisi" name="nomor_revisi" value="{{ $dokumen->nomor_revisi ?: '0' }}" required
                            class="flex-1 text-sm font-bold text-slate-800 px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50/30">
                        <button type="button" onclick="stepUpNomorRevisi()" class="px-3.5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-xs cursor-pointer" title="Naikkan nomor revisi +1">
                            <i class="fa-solid fa-arrow-up"></i> +1 Naik Revisi
                        </button>
                    </div>
                    <!-- Quick Pill Presets -->
                    <div class="flex items-center gap-1.5 mt-2 flex-wrap">
                        <span class="text-[11px] text-slate-400 font-medium">Pilihan Cepat:</span>
                        <button type="button" onclick="setNomorRevisi('0')" class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">0</button>
                        <button type="button" onclick="setNomorRevisi('00')" class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">00</button>
                        <button type="button" onclick="setNomorRevisi('01')" class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">01</button>
                        <button type="button" onclick="setNomorRevisi('02')" class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">02</button>
                        <button type="button" onclick="setNomorRevisi('1')" class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">1</button>
                        <button type="button" onclick="setNomorRevisi('2')" class="px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">2</button>
                    </div>
                </div>

                <!-- No. Dokumen -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">
                        Nomor Dokumen (Formulir Mutu) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="modalNomorDokumen" name="nomor_dokumen" value="{{ $dokumen->nomor_dokumen }}" required
                        class="w-full text-xs font-mono font-bold text-slate-800 px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-700">
                    <p class="text-[10px] text-slate-400 mt-1">Contoh: FT-SPR-INS-F-01 atau format penomoran mutu fakultas.</p>
                </div>

                <!-- Nama Dokumen -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">
                        Nama Dokumen <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="modalNamaDokumen" name="nama_dokumen" value="{{ $dokumen->nama_dokumen }}" required
                        class="w-full text-xs font-semibold text-slate-800 px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-700">
                </div>

                <!-- Tanggal Pendataan -->
                <div>
                    <label class="block text-xs font-extrabold text-slate-700 mb-1.5">
                        Tanggal Pendataan <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="modalTanggalPendataan" name="tanggal_pendataan" value="{{ $dokumen->tanggal_pendataan ? $dokumen->tanggal_pendataan->format('Y-m-d') : '' }}" required
                        class="w-full text-xs font-semibold text-slate-800 px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-700">
                </div>

                <!-- Modal Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeEditDokumenModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitEditDokumen" class="px-5 py-2.5 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs transition shadow-sm flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk text-xs"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        function toggleExportDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('exportDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        function openImportModal() {
            const modal = document.getElementById('importModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeImportModal() {
            const modal = document.getElementById('importModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Handler Modal Edit Dokumen & Revisi
        function openModalEditDokumen() {
            const modal = document.getElementById('editDokumenModal');
            if (modal) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    const input = document.getElementById('modalNomorRevisi');
                    if (input) {
                        input.focus();
                        input.select();
                    }
                }, 100);
            }
        }

        function closeEditDokumenModal() {
            const modal = document.getElementById('editDokumenModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function setNomorRevisi(val) {
            const input = document.getElementById('modalNomorRevisi');
            if (input) {
                input.value = val;
                input.focus();
            }
        }

        function stepUpNomorRevisi() {
            const input = document.getElementById('modalNomorRevisi');
            if (!input) return;
            let val = input.value.trim();
            if (!val || isNaN(val)) {
                input.value = '1';
                return;
            }
            const num = parseInt(val, 10) + 1;
            if (val.length >= 2 && val.startsWith('0')) {
                input.value = String(num).padStart(val.length, '0');
            } else {
                input.value = String(num);
            }
            input.focus();
        }

        function submitEditDokumen(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitEditDokumen');
            const originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i> <span>Menyimpan...</span>';

            const payload = {
                nomor_revisi: document.getElementById('modalNomorRevisi').value,
                nomor_dokumen: document.getElementById('modalNomorDokumen').value,
                nama_dokumen: document.getElementById('modalNamaDokumen').value,
                tanggal_pendataan: document.getElementById('modalTanggalPendataan').value,
            };

            fetch("{{ route('admin.properti.dokumen.update', $dokumen->id) }}", {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal memperbarui info dokumen.');
                return res.json();
            })
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
                closeEditDokumenModal();

                if (data.success) {
                    const revDisplay = document.getElementById('docNomorRevisiDisplay');
                    if (revDisplay) revDisplay.textContent = data.data.nomor_revisi;

                    const docDisplay = document.getElementById('docNomorDokumenDisplay');
                    if (docDisplay) docDisplay.textContent = data.data.nomor_dokumen;

                    const tglDisplay = document.getElementById('docTanggalDisplay');
                    if (tglDisplay && data.data.tanggal_pendataan) tglDisplay.textContent = data.data.tanggal_pendataan;

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diperbarui!',
                        text: `Nomor Revisi berhasil diubah menjadi: ${data.data.nomor_revisi}`,
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-2xl shadow-xl' }
                    });
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: err.message || 'Gagal menyimpan perubahan.',
                    customClass: { popup: 'rounded-2xl shadow-xl' }
                });
            });
        }

        function handleFileSelected(input) {
            const info = document.getElementById('selectedFileInfo');
            const nameEl = document.getElementById('selectedFileName');
            const sizeEl = document.getElementById('selectedFileSize');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                nameEl.textContent = file.name;
                const sizeKB = (file.size / 1024).toFixed(1);
                sizeEl.textContent = `(${sizeKB > 1024 ? (sizeKB/1024).toFixed(2) + ' MB' : sizeKB + ' KB'})`;
                info.classList.remove('hidden');
            } else {
                info.classList.add('hidden');
            }
        }

        // Drag & Drop handlers for file upload
        const dropZone = document.getElementById('dropZone');
        if (dropZone) {
            ['dragenter', 'dragover'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('border-emerald-600', 'bg-emerald-50/40');
                });
            });
            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('border-emerald-600', 'bg-emerald-50/40');
                });
            });
            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                if (dt && dt.files && dt.files.length) {
                    const input = document.getElementById('fileInput');
                    input.files = dt.files;
                    handleFileSelected(input);
                }
            });
        }

        // Form Import Submit Handler
        const formImport = document.getElementById('formImportProperti');
        if (formImport) {
            formImport.addEventListener('submit', function() {
                const btn = document.getElementById('btnSubmitImport');
                const btnText = document.getElementById('btnSubmitImportText');
                if (btn && btnText) {
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                    btnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Mengimpor Data...';
                }
            });
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileDropdownMenu');
            const wrapper = document.getElementById('profileDropdownWrapper');
            if (menu && wrapper && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }

            const exportMenu = document.getElementById('exportDropdownMenu');
            const exportWrapper = document.getElementById('exportDropdownWrapper');
            if (exportMenu && exportWrapper && !exportWrapper.contains(e.target)) {
                exportMenu.classList.add('hidden');
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
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ field: field, value: value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    saveIndicator.innerHTML = '<i class="fa-solid fa-check text-emerald-600"></i> Tersimpan';
                    if (field === 'kategori_id' && data.item?.kategori?.nama) {
                        const printEl = document.getElementById(`print-kategori-${itemId}`);
                        if (printEl) printEl.innerText = data.item.kategori.nama;
                    }
                    if (field === 'sub_kategori_id' && data.item?.sub_kategori?.nama) {
                        const printEl = document.getElementById(`print-sub_kategori-${itemId}`);
                        if (printEl) printEl.innerText = data.item.sub_kategori.nama;
                    }
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
                timer: 3500,
                showConfirmButton: false,
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        </script>
    @endif

    @if(session('error') || $errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Perhatian',
                text: "{{ session('error') ?? $errors->first() }}",
                confirmButtonColor: '#0f766e',
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        </script>
    @endif

</body>
</html>
