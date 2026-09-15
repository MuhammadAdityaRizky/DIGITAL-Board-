<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-5 flex items-center gap-3 border-b border-slate-800 shrink-0">
            <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white shrink-0 shadow-sm">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight text-white">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">PORTAL DOSEN</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-3 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 bg-teal-800 text-white font-bold shadow-sm rounded-xl w-full text-xs">
                <i class="fa-solid fa-border-all text-sm"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-calendar-alt text-sm"></i>
                <span>Agenda Perkuliahan</span>
            </a>
            <a href="{{ route('dosen.jadwal-lab') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-calendar-check text-sm"></i>
                <span>Ketersediaan Lab</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-gear text-sm"></i>
                <span>Pengaturan Akun</span>
            </a>
        </nav>

        <!-- Tombol Panduan Dosen di Sidebar -->
        <div class="p-3 border-t border-slate-800 mt-auto">
            <button type="button" onclick="openTutorialDosenModal()" class="min-h-[44px] flex items-center gap-3 px-4 py-3 bg-amber-500/10 border border-amber-500/30 text-amber-300 hover:bg-amber-500/20 hover:text-white rounded-xl w-full transition text-sm font-bold cursor-pointer">
                <i class="fa-solid fa-book-open-reader text-base text-amber-400"></i>
                <span>Panduan Dosen</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-teal-800 text-white rounded-xl flex lg:hidden items-center justify-center font-bold shadow-xs">
                    <i class="fa-solid fa-graduation-cap text-base"></i>
                </div>
                <div>
                    <h2 class="font-extrabold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                    <h2 class="font-extrabold text-lg text-slate-900 hidden lg:block">Portal Dosen Pengajar</h2>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <!-- Tombol Panduan / Tutorial Dosen -->
                <button type="button" onclick="openTutorialDosenModal()" class="flex items-center gap-2 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-900 rounded-xl text-xs font-extrabold transition shadow-2xs cursor-pointer" title="Buka Panduan & Tutorial Penggunaan Portal Dosen">
                    <i class="fa-solid fa-circle-question text-amber-600 text-sm"></i>
                    <span class="hidden sm:inline">Panduan Sistem</span>
                </button>

                <!-- Single Global Scan QR Button for Desktop -->
                <button type="button" onclick="startDosenQRScanner()" class="hidden md:flex items-center gap-2 px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition shadow-sm cursor-pointer" title="Pindai QR Code di Layar Digital Board Lab">
                    <i class="fa-solid fa-qrcode text-teal-400"></i>
                    <span>Scan QR Board</span>
                </button>

                <!-- Profile Avatar & Dropdown Menu -->
                <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1.5 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="font-extrabold text-sm text-slate-900 group-hover:text-teal-800 transition">{{ $dosen->nama }}</p>
                        <p class="text-xs font-bold text-slate-600">NIP: {{ $dosen->nip }} • Dosen Pengajar</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border-2 border-teal-300 flex items-center justify-center font-extrabold text-sm transition transform group-hover:scale-105 shadow-xs">
                        {{ substr($dosen->nama, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-500 group-hover:text-slate-800 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-72 bg-white border-2 border-slate-200 rounded-2xl shadow-2xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-5 py-3.5 border-b border-slate-100 bg-slate-50/70">
                        <p class="text-sm font-extrabold text-slate-900 truncate">{{ $dosen->nama }}</p>
                        <p class="text-xs font-bold text-slate-600 font-mono mt-0.5">NIP: {{ $dosen->nip }}</p>
                        <span class="inline-block mt-2 px-2.5 py-0.5 bg-teal-100 text-teal-900 border border-teal-300 rounded-md text-xs font-extrabold">
                            <i class="fa-solid fa-chalkboard-user mr-1"></i> Dosen Pengajar
                        </span>
                    </div>

                    <div class="py-1.5 px-1">
                        <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-800 hover:bg-teal-50 hover:text-teal-900 rounded-xl transition font-bold group">
                            <div class="w-8 h-8 rounded-lg bg-teal-100 group-hover:bg-teal-200 text-teal-800 flex items-center justify-center transition">
                                <i class="fa-solid fa-gear text-sm"></i>
                            </div>
                            <div>
                                <span class="font-extrabold block">Pengaturan Akun</span>
                                <span class="text-xs text-slate-500 block font-normal">Edit profil & ganti password</span>
                            </div>
                        </a>
                    </div>

                    <div class="pt-1.5 border-t border-slate-100 px-1">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-700 hover:bg-rose-50 rounded-xl transition font-extrabold text-left group cursor-pointer">
                                <div class="w-8 h-8 rounded-lg bg-rose-100 group-hover:bg-rose-200 text-rose-700 flex items-center justify-center transition">
                                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                                </div>
                                <span>Keluar / Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Welcome Header (Clean Institutional Style, No AI Slop) -->
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-6 sm:p-7 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2 text-sm font-bold text-slate-500">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-900 inline-block"></span>
                        <span>Portal Dosen Pengajar</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">
                        Selamat Datang, {{ $dosen->nama }}
                    </h2>
                    <div class="flex items-center gap-3 flex-wrap text-base font-bold text-slate-700">
                        <span class="font-mono bg-slate-100 border border-slate-300 px-3 py-1 rounded-lg text-slate-900">
                            NIP: {{ $dosen->nip }}
                        </span>
                        @if($dosen->kompetensi)
                            <span class="text-slate-400">•</span>
                            <span class="text-slate-800 font-semibold">Kompetensi: <strong class="text-slate-900 font-black">{{ $dosen->kompetensi }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="self-start md:self-center">
                    @if($activeOrNextAgenda && $activeOrNextAgenda->dosen_waktu_masuk)
                        <div class="px-5 py-2.5 bg-emerald-50 border-2 border-emerald-500 text-emerald-950 rounded-xl text-base font-black flex items-center gap-2.5 shadow-xs">
                            <span class="w-3 h-3 bg-emerald-600 rounded-full inline-block"></span>
                            <span>Sudah Check-in ({{ date('H:i', strtotime($activeOrNextAgenda->dosen_waktu_masuk)) }} WIB)</span>
                        </div>
                    @else
                        <div class="px-5 py-2.5 bg-rose-50 border-2 border-rose-400 text-rose-950 rounded-xl text-base font-black flex items-center gap-2.5 shadow-xs">
                            <span class="w-3 h-3 bg-rose-600 rounded-full inline-block"></span>
                            <span>Belum Check-in Hari Ini</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Auto-Detect Sesi Hari Ini Banner (Institutional High-Contrast Callout) -->
            @if(isset($todayScheduledJadwal))
            <div class="bg-teal-50/60 border-2 border-teal-800 rounded-2xl p-6 sm:p-7 shadow-xs flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="px-3.5 py-1.5 bg-teal-800 text-white rounded-lg text-sm sm:text-base font-black">
                            Jadwal Praktikum Hari Ini
                        </span>
                        <span class="text-sm sm:text-base text-slate-800 font-bold font-mono bg-white border border-slate-300 px-3 py-1 rounded-lg">
                            {{ $todayScheduledJadwal->hari }}, {{ substr($todayScheduledJadwal->jam_mulai,0,5) }} - {{ substr($todayScheduledJadwal->jam_selesai,0,5) }} WIB
                        </span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        {{ $todayScheduledJadwal->mata_kuliah }}
                    </h3>
                    <p class="text-base text-slate-700 font-bold flex items-center gap-2 flex-wrap">
                        <span><i class="fa-solid fa-door-open text-teal-700 mr-1"></i> {{ $todayScheduledJadwal->lab->nama_lab ?? 'Lab' }}</span>
                        <span class="text-slate-400">•</span>
                        <span>Kelas {{ $todayScheduledJadwal->kelas }} (Semester {{ $todayScheduledJadwal->semester }})</span>
                    </p>
                </div>
                <div class="w-full lg:w-auto flex-shrink-0">
                    <form action="{{ route('dosen.agenda.store') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="jadwal_penggunaan_lab_id" value="{{ $todayScheduledJadwal->id }}">
                        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="waktu_masuk" value="{{ substr($todayScheduledJadwal->jam_mulai,0,5) }}">
                        <input type="hidden" name="waktu_keluar" value="{{ substr($todayScheduledJadwal->jam_selesai,0,5) }}">
                        <input type="hidden" name="rencana_pembelajaran" value="Sesi Praktikum Regular - {{ $todayScheduledJadwal->mata_kuliah }}">
                        <button type="submit" class="w-full sm:w-auto min-h-[48px] px-7 py-3.5 bg-teal-800 hover:bg-teal-900 active:scale-98 text-white font-black text-base rounded-xl shadow-xs transition flex items-center justify-center gap-2.5 cursor-pointer">
                            <i class="fa-solid fa-play text-base"></i>
                            <span>Buka Sesi Praktikum Hari Ini</span>
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border-2 border-emerald-400 text-emerald-950 p-5 rounded-xl text-base flex items-start gap-3 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-700 mt-0.5 text-xl flex-shrink-0"></i>
                    <div>
                        <span class="font-black">Berhasil!</span>
                        <p class="mt-0.5 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Announcements -->
            @if(isset($pengumuman) && $pengumuman->count() > 0)
            <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-5 sm:p-6 shadow-xs">
                <h3 class="font-black text-amber-950 text-base sm:text-lg flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-amber-700"></i>
                    <span>Pengumuman Resmi Laboratorium</span>
                    <span class="text-sm font-bold text-amber-800">({{ date('d M Y', strtotime($pengumuman->first()->created_at)) }})</span>
                </h3>
                <p class="text-amber-950 text-base mt-2 font-medium leading-relaxed">
                    <strong class="font-bold">{{ $pengumuman->first()->judul }}:</strong> {{ $pengumuman->first()->isi_pengumuman }}
                </p>
            </div>
            @endif

            <!-- Top Header & Quick Create Agenda Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Bento 1: Agenda Hari Ini Stat -->
                <div class="lg:col-span-1 bg-white rounded-2xl border-2 border-slate-200 p-6 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                            <span class="text-sm font-bold text-slate-700">Jadwal Mengajar Hari Ini</span>
                            <span class="px-3 py-1 bg-slate-100 border border-slate-300 text-slate-900 rounded-lg text-sm font-bold">
                                {{ \Carbon\Carbon::today()->translatedFormat('d M Y') }}
                            </span>
                        </div>

                        <div class="mt-5">
                            <div class="flex items-baseline gap-3">
                                <span class="text-4xl font-black text-slate-900">{{ $todayAgendas->count() }}</span>
                                <span class="text-lg font-bold text-slate-700">Sesi Pertemuan</span>
                            </div>
                            <p class="text-sm text-slate-600 mt-1 font-semibold leading-relaxed">Sesi Praktikum Terjadwal Hari Ini</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between text-base">
                        <a href="{{ route('dosen.agenda') }}" class="font-bold text-teal-800 hover:text-teal-900 hover:underline flex items-center gap-1.5">
                            <span>Kelola Semua Sesi</span> <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>
                        <span class="font-bold text-slate-600">Total: {{ $agendas->count() }} Sesi</span>
                    </div>
                </div>

                <!-- Bento 2: Mulai Sesi Praktikum / Buka Kelas Lab Form -->
                <div class="lg:col-span-2 bg-white rounded-2xl border-2 border-slate-200 p-6 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200">
                        <div>
                            <h3 class="font-black text-lg sm:text-xl text-slate-900">Mulai Sesi Mengajar / Praktikum Hari Ini</h3>
                            <p class="text-sm sm:text-base text-slate-600 font-medium mt-0.5 leading-relaxed">Pilih jadwal Anda untuk mengaktifkan info di Digital Board Lab & membuka presensi mahasiswa</p>
                        </div>
                        <span class="px-3 py-1.5 bg-emerald-50 text-emerald-900 border border-emerald-300 rounded-lg text-sm font-bold hidden sm:inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-tv text-emerald-700"></i> Terkoneksi ke Board Lab
                        </span>
                    </div>

                    <form action="{{ route('dosen.agenda.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- 1. Combobox Mata Kuliah Berdasarkan Jadwal -->
                            <div class="space-y-2">
                                <label class="block text-slate-900 font-bold text-sm sm:text-base flex items-center justify-between">
                                    <span>Mata Kuliah & Kelas <span class="text-rose-600">*</span></span>
                                    <span class="text-xs sm:text-sm text-slate-500 font-medium">Pilih Jadwal Rutin</span>
                                </label>
                                @if(isset($jadwalPenggunaanLab) && $jadwalPenggunaanLab->count() > 0)
                                    <!-- Hidden input for form submission -->
                                    <input type="hidden" name="jadwal_penggunaan_lab_id" id="dashboard_jadwal_id" required>

                                    <!-- Custom Searchable Combobox Component -->
                                    <div class="relative" id="combobox_container_dashboard">
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-magnifying-glass absolute left-4 text-slate-400 text-base pointer-events-none"></i>
                                            <input type="text" 
                                                   id="combobox_search_dashboard" 
                                                   placeholder="-- Klik untuk Pilih Mata Kuliah --" 
                                                   autocomplete="off"
                                                   onclick="toggleComboboxDashboard(true)"
                                                   onfocus="toggleComboboxDashboard(true)"
                                                   oninput="filterComboboxDashboard(this.value)"
                                                   class="w-full pl-11 pr-11 py-3 rounded-xl bg-white border-2 border-slate-300 text-slate-900 font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition placeholder:font-normal placeholder:text-slate-400 cursor-pointer" />
                                            <button type="button" 
                                                    onclick="toggleComboboxDashboard()" 
                                                    class="absolute right-3.5 text-slate-500 hover:text-slate-700 p-1 focus:outline-none cursor-pointer">
                                                <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200" id="combobox_arrow_dashboard"></i>
                                            </button>
                                        </div>

                                        <!-- Dropdown Options Menu -->
                                        <div id="combobox_menu_dashboard" 
                                             class="hidden absolute z-30 left-0 right-0 mt-1 max-h-80 overflow-y-auto bg-white border-2 border-slate-300 rounded-xl shadow-xl divide-y divide-slate-100">
                                            @foreach($jadwalPenggunaanLab as $j)
                                                @php
                                                    $semLabel = str_contains(strtolower($j->semester ?? ''), 'semester') 
                                                        ? $j->semester 
                                                        : 'Semester ' . ($j->semester ?? '1');
                                                @endphp
                                                <div class="combobox-item p-4 hover:bg-slate-50 cursor-pointer transition flex flex-col gap-1.5"
                                                     data-id="{{ $j->id }}"
                                                     data-title="{{ $j->mata_kuliah }} - Kelas {{ $j->kelas }} ({{ $semLabel }}, Setiap {{ $j->hari }})"
                                                     data-search="{{ strtolower($j->mata_kuliah . ' ' . $j->kelas . ' ' . $j->hari . ' ' . ($j->lab->nama_lab ?? '') . ' ' . ($j->prodi->nama_prodi ?? '') . ' ' . $semLabel) }}"
                                                     data-lab="{{ strtoupper($j->lab->nama_lab ?? 'Lab') }}"
                                                     data-kelas="{{ $j->kelas ?? 'Reg A' }}"
                                                     data-semester="{{ $j->semester ?? '1' }}"
                                                     data-prodi="{{ $j->prodi->nama_prodi ?? 'Sistem Informasi' }}"
                                                     data-hari="{{ $j->hari }}"
                                                     data-jam-mulai="{{ substr($j->jam_mulai, 0, 5) }}"
                                                     data-jam-selesai="{{ substr($j->jam_selesai, 0, 5) }}"
                                                     onclick="selectComboboxDashboard(this)">
                                                    <div class="flex items-center justify-between gap-2 font-bold text-slate-900 text-base">
                                                        <span class="font-black text-slate-900">{{ $j->mata_kuliah }}</span>
                                                        <div class="flex items-center gap-2 shrink-0">
                                                            <span class="px-2.5 py-0.5 bg-slate-100 text-slate-900 border border-slate-300 rounded-md text-sm font-bold">
                                                                {{ $semLabel }}
                                                            </span>
                                                            <span class="px-2.5 py-0.5 bg-slate-200 text-slate-900 rounded-md text-sm font-bold">Kelas {{ $j->kelas }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-between text-sm text-slate-600 font-semibold mt-1">
                                                        <span><i class="fa-regular fa-calendar-check mr-1.5 text-slate-700"></i>Setiap {{ $j->hari }}, {{ substr($j->jam_mulai,0,5) }} - {{ substr($j->jam_selesai,0,5) }} WIB</span>
                                                        <span class="text-slate-900 font-bold bg-slate-100 px-2.5 py-0.5 rounded border border-slate-300"><i class="fa-solid fa-door-open mr-1 text-slate-700"></i>{{ $j->lab->nama_lab ?? 'Lab' }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div id="combobox_empty_dashboard" class="hidden p-4 text-center text-slate-500 text-sm font-medium italic">
                                                Tidak ada jadwal mata kuliah yang cocok dengan pencarian.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail Box -->
                                    <div id="jadwal-info-box" class="hidden mt-2 p-3 bg-slate-50 border border-slate-300 rounded-xl space-y-1 text-sm">
                                        <div class="flex justify-between items-center font-bold text-slate-900">
                                            <span id="info-lab"><i class="fa-solid fa-door-open mr-1 text-slate-700"></i> Lab</span>
                                            <span id="info-kelas" class="px-2.5 py-0.5 bg-slate-200 rounded text-xs font-bold">Kelas</span>
                                        </div>
                                        <div class="text-slate-700 truncate font-semibold text-sm">
                                            <span>Jadwal: <strong id="info-rutin" class="text-slate-900">-</strong></span>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-4 bg-amber-50 border-2 border-amber-300 text-amber-950 rounded-xl text-sm font-semibold">
                                        Belum ada jadwal mata kuliah yang di-plotting oleh Admin.
                                    </div>
                                @endif
                            </div>

                            <!-- 2. Materi Praktikum -->
                            <div class="space-y-2">
                                <label class="block text-slate-900 font-bold text-sm sm:text-base">Materi Praktikum <span class="text-slate-500 font-normal text-xs">(Opsional)</span></label>
                                <textarea name="materi_pembelajaran" rows="3" placeholder="Contoh: Pengenalan Sintaks C++, Variabel & Tipe Data... (Opsional)" class="w-full p-3 rounded-xl bg-white border-2 border-slate-300 text-slate-900 text-base font-medium focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none resize-none placeholder:text-slate-400"></textarea>
                            </div>
                        </div>

                        <!-- Row 2: Date, Waktu & Submit -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end pt-2">
                            <div>
                                <label class="block text-slate-900 font-bold text-sm sm:text-base mb-1.5">Tanggal Pertemuan <span class="text-rose-600">*</span></label>
                                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full py-2.5 px-3 rounded-xl bg-white border-2 border-slate-300 text-slate-900 text-base font-bold focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-900 font-bold text-sm sm:text-base mb-1.5">Jam Masuk <span class="text-rose-600">*</span></label>
                                <input type="time" name="waktu_masuk" id="input_waktu_masuk" required value="08:00" class="w-full py-2.5 px-3 rounded-xl bg-white border-2 border-slate-300 text-slate-900 text-base font-mono font-bold focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-900 font-bold text-sm sm:text-base mb-1.5">Jam Selesai <span class="text-rose-600">*</span></label>
                                <input type="time" name="waktu_keluar" id="input_waktu_keluar" required value="10:30" class="w-full py-2.5 px-3 rounded-xl bg-white border-2 border-slate-300 text-slate-900 text-base font-mono font-bold focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                            </div>
                            <div>
                                <button type="submit" class="w-full min-h-[48px] py-2.5 px-5 bg-slate-900 hover:bg-slate-800 active:scale-98 text-white text-base font-bold rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer">
                                    <i class="fa-solid fa-play text-sm"></i>
                                    <span>Buka Sesi & Presensi</span>
                                </button>
                            </div>
                        </div>

                        <!-- Microcopy Hint -->
                        <div class="pt-1 flex items-center gap-2 text-sm text-slate-600 font-medium">
                            <i class="fa-solid fa-circle-info text-slate-700 shrink-0"></i>
                            <span>Sesi yang dibuka otomatis tayang di monitor lab dan mahasiswa dapat melakukan presensi kehadiran.</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Features Split Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Today's Classes list -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                            <h3 class="font-black text-base text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-check text-teal-700"></i>
                                <span>Daftar Sesi Mengajar & Kelas</span>
                                <span class="text-sm text-slate-500 font-bold hidden sm:inline">({{ \Carbon\Carbon::today()->translatedFormat('l, d M Y') }})</span>
                            </h3>
                            <div class="flex items-center gap-3">
                                <span class="text-sm bg-slate-100 text-slate-900 font-bold px-3.5 py-1 rounded-full border border-slate-300">{{ $agendas->count() }} Sesi Terjadwal</span>
                                <a href="{{ route('dosen.agenda') }}" class="text-sm text-teal-800 hover:text-teal-900 hover:underline font-black flex items-center gap-1.5 ml-1">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                        
                        <div class="p-4 md:p-6 space-y-6">
                            @if($agendas->count() > 0)
                                @php
                                    $groupedDashboardAgendas = $agendas->groupBy(function($item) {
                                        $sem = trim($item->semester ?? '1');
                                        return is_numeric($sem) ? 'Semester ' . $sem : (str_contains(strtolower($sem), 'semester') ? $sem : 'Semester ' . $sem);
                                    })->sortKeys();
                                @endphp

                                @foreach($groupedDashboardAgendas as $semesterName => $semesterAgendas)
                                    <div class="space-y-4">
                                        <!-- Group Header: Semester -->
                                        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                                             <div class="flex items-center gap-2.5">
                                                 <div class="px-3.5 py-1.5 bg-slate-900 text-white font-black text-sm rounded-lg shadow-xs flex items-center gap-2">
                                                     <i class="fa-solid fa-graduation-cap text-teal-400 text-sm"></i>
                                                     <span>{{ $semesterName }}</span>
                                                 </div>
                                                 <span class="text-sm text-slate-600 font-bold">({{ $semesterAgendas->count() }} Sesi Pertemuan)</span>
                                             </div>
                                        </div>

                                        <!-- Agenda Cards List for this Semester -->
                                        <div class="space-y-4">
                                            @foreach($semesterAgendas as $ag)
                                            @php
                                                $carbonTgl = \Carbon\Carbon::parse($ag->tanggal);
                                                $isToday = $ag->tanggal === date('Y-m-d');
                                                $isFuture = $ag->tanggal > date('Y-m-d');
                                            @endphp
                                            <div class="bg-white border-2 border-slate-200 rounded-xl p-5 sm:p-6 space-y-4 hover:border-slate-300 transition-all shadow-xs">
                                                <div class="flex flex-col md:flex-row gap-5 items-start">
                                                    <!-- Real Calendar Date & Time Block -->
                                                    <div class="rounded-xl p-3 flex flex-col items-center justify-center min-w-[115px] shadow-xs text-center {{ $isToday ? 'bg-slate-900 text-white border-2 border-teal-600' : 'bg-slate-800 text-white' }}">
                                                        <span class="text-xs font-black uppercase tracking-wider {{ $isToday ? 'text-teal-400' : 'text-slate-300' }}">
                                                            {{ $carbonTgl->translatedFormat('l') }}
                                                        </span>
                                                        <span class="text-3xl font-black leading-tight my-0.5">
                                                            {{ $carbonTgl->format('d') }}
                                                        </span>
                                                        <span class="text-xs font-bold uppercase {{ $isToday ? 'text-slate-200' : 'text-slate-300' }}">
                                                            {{ $carbonTgl->translatedFormat('M Y') }}
                                                        </span>
                                                        <div class="mt-1 pt-1 border-t {{ $isToday ? 'border-slate-700 text-slate-200' : 'border-slate-700 text-slate-300' }} w-full text-xs font-mono font-bold">
                                                            {{ substr($ag->jam_mulai,0,5) }} WIB
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Details -->
                                                    <div class="flex-1 space-y-3 w-full">
                                                        <div>
                                                            <div class="flex flex-wrap items-center gap-2">
                                                                @if($isToday)
                                                                    <span class="px-3 py-1 bg-amber-100 text-amber-950 border-2 border-amber-400 rounded-lg text-xs font-black uppercase tracking-wider flex items-center gap-1.5">
                                                                        <span class="w-2 h-2 rounded-full bg-amber-600"></span> Hari Ini
                                                                    </span>
                                                                @endif
                                                                @if($ag->status_agenda === 'Berlangsung')
                                                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-950 border-2 border-emerald-500 rounded-lg text-xs font-black">● Berlangsung</span>
                                                                @elseif($ag->status_agenda === 'Selesai')
                                                                    <span class="px-3 py-1 bg-slate-100 text-slate-800 border-2 border-slate-300 rounded-lg text-xs font-bold">● Selesai</span>
                                                                @elseif($ag->status_agenda === 'Dibatalkan')
                                                                    <span class="px-3 py-1 bg-rose-100 text-rose-950 border-2 border-rose-300 rounded-lg text-xs font-bold">✕ Dibatalkan</span>
                                                                @else
                                                                    <span class="px-3 py-1 bg-slate-100 text-slate-800 border border-slate-300 rounded-lg text-xs font-bold">○ Mendatang</span>
                                                                @endif
                                                                <span class="px-3 py-1 bg-slate-100 text-slate-900 border border-slate-300 rounded-lg text-xs font-bold">
                                                                    {{ str_contains(strtolower($ag->semester ?? ''), 'semester') ? $ag->semester : 'Semester ' . ($ag->semester ?? '1') }}
                                                                </span>
                                                                @if($ag->kelas)
                                                                    <span class="px-3 py-1 bg-slate-200 text-slate-900 rounded-lg text-xs font-bold">
                                                                        Kelas: {{ $ag->kelas }}
                                                                    </span>
                                                                @endif
                                                                <span class="text-sm font-bold text-slate-700 ml-auto flex items-center gap-1.5 bg-slate-50 border border-slate-200 px-3 py-1 rounded-lg">
                                                                    <i class="fa-regular fa-clock text-slate-600"></i>
                                                                    {{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB
                                                                </span>
                                                            </div>

                                                            <h4 class="font-black text-slate-900 text-xl sm:text-2xl mt-2 tracking-tight">{{ $ag->mata_kuliah }}</h4>
                                                            
                                                            <!-- Explicit Date & Location Line -->
                                                            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-700 mt-1.5 font-bold">
                                                                <span class="text-slate-900 flex items-center gap-1.5">
                                                                    <i class="fa-regular fa-calendar-days text-slate-600"></i>
                                                                    {{ $carbonTgl->translatedFormat('l, d F Y') }}
                                                                </span>
                                                                <span class="text-slate-300">•</span>
                                                                <span class="flex items-center gap-1 text-slate-900">
                                                                    <i class="fa-solid fa-location-dot text-slate-600"></i>
                                                                    {{ $ag->lab->nama_lab ?? 'Lab' }}
                                                                </span>
                                                            </div>

                                                            <p class="text-sm sm:text-base text-slate-700 mt-2 font-medium leading-relaxed">Catatan / Materi: <strong class="text-slate-900 font-bold">{{ $ag->catatan ?: 'Belum ada catatan.' }}</strong></p>
                                                        </div>
                                                        
                                                         <!-- Direct Actions -->
                                                         <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-200 w-full">
                                                             <div class="flex flex-wrap items-center gap-2.5">
                                                                 @if($isFuture)
                                                                     <span class="min-h-[44px] px-4 py-2 bg-slate-100 text-slate-600 border border-slate-300 rounded-xl text-sm font-bold flex items-center gap-2 cursor-not-allowed select-none" title="Presensi hanya dapat dibuka pada hari H pelaksanaan perkuliahan">
                                                                         <i class="fa-solid fa-lock text-sm text-slate-500"></i>
                                                                         <span>Presensi Dibuka Hari H</span>
                                                                     </span>
                                                                     <span class="text-sm text-slate-500 font-medium italic">
                                                                         (Perkuliahan belum dimulai)
                                                                     </span>
                                                                 @else
                                                                     @if($ag->dosen_waktu_masuk)
                                                                         <span class="min-h-[44px] px-3.5 py-2 bg-emerald-50 text-emerald-950 border border-emerald-400 rounded-xl text-sm font-black flex items-center gap-1.5 mr-1 shadow-2xs" title="Waktu Absen Masuk Dosen">
                                                                             <i class="fa-solid fa-circle-check text-emerald-700"></i> Hadir: {{ date('H:i', strtotime($ag->dosen_waktu_masuk)) }} WIB
                                                                         </span>
                                                                     @endif

                                                                     <!-- 1. Tombol Absensi Mahasiswa -->
                                                                     <a href="{{ route('dosen.absensi.input', $ag->id) }}" 
                                                                        class="min-h-[44px] px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition flex items-center gap-2 shadow-xs cursor-pointer"
                                                                        title="Input & Kelola Absensi Mahasiswa">
                                                                         <i class="fa-solid fa-users-viewfinder text-base"></i>
                                                                         <span>{{ $isToday ? 'Absensi Mahasiswa' : 'Edit Rekap Absensi' }}</span>
                                                                     </a>

                                                                     <!-- 2. Tombol Realisasi Pembelajaran -->
                                                                     <button type="button" 
                                                                             onclick="toggleModal('modal-dashboard-realisasi-{{ $ag->id }}')" 
                                                                             class="min-h-[44px] px-5 py-2.5 {{ $ag->materi_realisasi ? 'bg-amber-100 hover:bg-amber-200 text-amber-950 border border-amber-300' : 'bg-amber-50 hover:bg-amber-100 text-amber-950 border-2 border-amber-300' }} rounded-xl text-sm font-bold transition flex items-center gap-2 shadow-2xs cursor-pointer"
                                                                             title="Isi atau perbarui realisasi pembelajaran">
                                                                         <i class="fa-solid fa-book-open text-amber-700"></i> 
                                                                         <span>{{ $ag->materi_realisasi ? 'Realisasi' : 'Isi Realisasi' }}</span>
                                                                         @if($ag->materi_realisasi)
                                                                             <i class="fa-solid fa-circle-check text-emerald-700 text-sm"></i>
                                                                         @endif
                                                                     </button>

                                                                     <!-- 3. Tombol Berita Acara -->
                                                                     <button type="button" 
                                                                             onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')" 
                                                                             class="min-h-[44px] px-5 py-2.5 {{ $ag->berita_acara ? 'bg-slate-100 hover:bg-slate-200 text-slate-900 border border-slate-300' : 'bg-white hover:bg-slate-100 text-slate-900 border-2 border-slate-300' }} rounded-xl text-sm font-bold transition flex items-center gap-2 shadow-2xs cursor-pointer"
                                                                             title="Tuliskan berita acara perkuliahan">
                                                                         <i class="fa-solid fa-file-signature text-slate-700"></i> 
                                                                         <span>{{ $ag->berita_acara ? 'Berita Acara' : 'Isi Berita Acara' }}</span>
                                                                         @if($ag->berita_acara)
                                                                             <i class="fa-solid fa-circle-check text-emerald-700 text-xs"></i>
                                                                         @endif
                                                                     </button>
                                                                 @endif
                                                             </div>

                                                             <div class="flex items-center gap-1.5 text-xs font-extrabold {{ $isFuture ? 'text-slate-500 bg-slate-100 border-slate-300' : 'text-emerald-900 bg-emerald-50 border border-emerald-300' }} px-3 py-2 rounded-xl shrink-0 ml-auto shadow-2xs">
                                                                  <i class="fa-solid {{ $isFuture ? 'fa-calendar-clock text-slate-500' : 'fa-user-check text-emerald-700' }}"></i>
                                                                  {{ $isFuture ? 'Sesi Terjadwal' : $ag->absensi->count() . ' Mahasiswa Hadir' }}
                                                             </div>
                                                         </div>
                                                    </div>
                                                </div>

                                                @if(!$isFuture)
                                                <!-- MODAL: Realisasi Pembelajaran Dashboard -->
                                                <div id="modal-dashboard-realisasi-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                                                    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-dashboard-realisasi-{{ $ag->id }}')"></div>
                                                    <div class="relative min-h-screen flex items-center justify-center p-4">
                                                        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden text-left border border-slate-100">
                                                            <div class="bg-amber-50 border-b border-amber-100 px-6 py-4 flex justify-between items-center text-slate-800">
                                                                <div class="flex items-center gap-2.5">
                                                                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                                                                        <i class="fa-solid fa-book-open"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h3 class="font-bold text-sm text-slate-800">Realisasi Pembelajaran</h3>
                                                                        <p class="text-xs text-slate-600 font-bold">{{ $ag->mata_kuliah }}</p>
                                                                    </div>
                                                                </div>
                                                                <button type="button" onclick="toggleModal('modal-dashboard-realisasi-{{ $ag->id }}')" class="text-slate-400 hover:text-slate-600 text-lg">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('dosen.agenda.realisasi', $ag->id) }}" method="POST" class="p-6 space-y-4">
                                                                @csrf
                                                                @method('PUT')
                                                                <div>
                                                                    <label class="block text-slate-700 font-bold mb-1">Catatan Materi</label>
                                                                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-600 text-xs italic">
                                                                        {{ $ag->catatan ?: 'Tidak ada catatan rencana.' }}
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-slate-700 font-bold mb-1">Materi Praktikum <span class="text-rose-500">*</span></label>
                                                                    <textarea name="realisasi_pembelajaran" rows="4" required placeholder="Contoh: Praktikum manipulasi DOM dan asynchronous fetch data API, latihan mandiri membuat tabel interaktif..." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-amber-500/30 focus:border-amber-600 outline-none text-xs">{{ $ag->materi_realisasi }}</textarea>
                                                                </div>
                                                                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                                                                    <button type="button" onclick="toggleModal('modal-dashboard-realisasi-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                                                                    <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg transition shadow-sm">
                                                                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Realisasi
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- MODAL: Berita Acara Perkuliahan Dashboard (FTS-LAB-P03-F-01) -->
                                                @php
                                                    $baDetails = $ag->berita_acara_details;
                                                @endphp
                                                <div id="modal-dashboard-berita-acara-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                                                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')"></div>
                                                    <div class="relative min-h-screen flex items-center justify-center p-4">
                                                        <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden text-left border border-slate-200">
                                                            
                                                            <!-- Modal Header -->
                                                            <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-sky-900 px-6 py-4 flex justify-between items-center text-white">
                                                                <div class="flex items-center gap-3">
                                                                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white text-lg shadow-inner">
                                                                        <i class="fa-solid fa-file-signature"></i>
                                                                    </div>
                                                                    <div>
                                                                        <div class="flex items-center gap-2">
                                                                            <h3 class="font-extrabold text-sm text-white">Berita Acara Praktikum</h3>
                                                                            <span class="px-2 py-0.5 bg-sky-400/20 text-sky-200 border border-sky-300/30 rounded text-[10px] font-bold font-mono">FTS-LAB-P03-F-01</span>
                                                                        </div>
                                                                        <p class="text-xs text-indigo-200 font-medium">{{ $ag->mata_kuliah }} • {{ $baDetails['hari_tanggal_indo'] }}</p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="flex items-center gap-2">
                                                                    <a href="{{ route('dosen.agenda.berita-acara.cetak', $ag->id) }}" 
                                                                       target="_blank" 
                                                                       class="px-3 py-1.5 bg-sky-500 hover:bg-sky-400 text-white rounded-lg font-bold text-xs flex items-center gap-1.5 shadow-sm transition">
                                                                        <i class="fa-solid fa-print"></i>
                                                                        <span class="hidden sm:inline">Cetak / PDF A4</span>
                                                                    </a>
                                                                    <button type="button" onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')" class="text-white/70 hover:text-white text-lg w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 transition">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <form action="{{ route('dosen.agenda.berita-acara', $ag->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                
                                                                <div class="p-6 max-h-[75vh] overflow-y-auto space-y-6">
                                                                    
                                                                    <!-- Form Section & Document Preview Grid -->
                                                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                                                        
                                                                        <!-- Kolom Form Edit (Left: 6 cols) -->
                                                                        <div class="lg:col-span-6 space-y-4">
                                                                            <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-3 flex items-center gap-2.5">
                                                                                <i class="fa-solid fa-circle-info text-indigo-600 text-sm"></i>
                                                                                <p class="text-[11px] text-indigo-900 leading-tight">
                                                                                    Format isian Berita Acara ini disesuaikan 100% dengan lembar resmi <strong>Fakultas Teknik &amp; Sains UIKA Bogor</strong>.
                                                                                </p>
                                                                            </div>

                                                                            <div>
                                                                                <label class="block text-slate-700 font-bold mb-1">Materi Praktikum yang Disampaikan <span class="text-rose-500">*</span></label>
                                                                                <textarea name="materi" rows="3" required placeholder="Contoh: Evaluasi desain DB, data Anomaly, normalisasi tabel relasional..." class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-600 outline-none text-xs">{{ $baDetails['materi'] }}</textarea>
                                                                            </div>

                                                                            <div>
                                                                                <label class="block text-slate-700 font-bold mb-1">Catatan Pelaksanaan Praktikum</label>
                                                                                <textarea name="catatan" rows="3" placeholder="Contoh: Praktikum berjalan lancar, seluruh PC laboratorium berfungsi baik, mahasiswa aktif berdiskusi..." class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-600 outline-none text-xs">{{ $baDetails['catatan'] }}</textarea>
                                                                            </div>

                                                                            <div class="pt-2 border-t border-slate-100">
                                                                                <div class="flex items-center justify-between mb-2">
                                                                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                                                                        <i class="fa-solid fa-lock text-slate-400"></i> Informasi SK &amp; Jadwal Resmi
                                                                                    </span>
                                                                                    <span class="text-[10px] text-slate-400 italic">Sesuai data jadwal (read-only)</span>
                                                                                </div>

                                                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                                                                    <div class="p-2.5 bg-slate-50 border border-slate-200/80 rounded-xl">
                                                                                        <p class="text-[10px] font-bold text-slate-500">Nama Laboran</p>
                                                                                        <p class="text-xs font-extrabold text-slate-800 mt-0.5 truncate">{{ $baDetails['laboran'] }}</p>
                                                                                    </div>
                                                                                    <div class="p-2.5 bg-slate-50 border border-slate-200/80 rounded-xl">
                                                                                        <p class="text-[10px] font-bold text-slate-500">Nama Asisten Praktikum</p>
                                                                                        <p class="text-xs font-extrabold text-slate-800 mt-0.5 truncate">{{ $baDetails['asisten'] }}</p>
                                                                                    </div>
                                                                                    <div class="p-2.5 bg-slate-50 border border-slate-200/80 rounded-xl">
                                                                                        <p class="text-[10px] font-bold text-slate-500">Nama Dosen / Instruktur</p>
                                                                                        <p class="text-xs font-extrabold text-slate-800 mt-0.5 truncate">{{ $baDetails['dosen'] }}</p>
                                                                                    </div>
                                                                                    <div class="p-2.5 bg-slate-50 border border-slate-200/80 rounded-xl">
                                                                                        <p class="text-[10px] font-bold text-slate-500">Tahun Akademik (TA)</p>
                                                                                        <p class="text-xs font-extrabold text-slate-800 mt-0.5 truncate">{{ $baDetails['tahun_ajaran'] }}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Kolom Pratinjau Dokumen Fisik (Right: 6 cols) -->
                                                                        <div class="lg:col-span-6 bg-slate-100 p-3 rounded-2xl border border-slate-200 flex flex-col justify-between">
                                                                            <div>
                                                                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-200">
                                                                                    <span class="text-[11px] font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                                                                        <i class="fa-solid fa-eye text-indigo-600"></i> Pratinjau Dokumen Resmi
                                                                                    </span>
                                                                                    <a href="{{ route('dosen.agenda.berita-acara.cetak', $ag->id) }}" target="_blank" class="text-[11px] font-bold text-sky-700 hover:text-sky-900 flex items-center gap-1">
                                                                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Full A4
                                                                                    </a>
                                                                                </div>

                                                                                <!-- Mini Document Paper Container -->
                                                                                <div class="bg-white p-4 rounded-xl border border-slate-300 shadow-sm relative overflow-hidden text-[10px] space-y-2 select-none">
                                                                                    <!-- Watermark Mockup -->
                                                                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-5 font-black text-2xl tracking-widest text-slate-900 select-none">
                                                                                        IMAN.ILMU.AMAL
                                                                                    </div>

                                                                                    <!-- Mini Kop Surat -->
                                                                                    <div class="flex justify-between items-start border-b border-slate-200 pb-2 relative z-10">
                                                                                        <div class="flex items-center gap-2">
                                                                                            <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                                                                                                 alt="UIKA" class="w-8 h-8 object-contain">
                                                                                            <div>
                                                                                                <p class="font-extrabold text-[10px] text-sky-800 leading-tight">FAKULTAS TEKNIK &amp; SAINS</p>
                                                                                                <p class="font-extrabold text-[9px] text-emerald-700 leading-tight">UNIVERSITAS IBN KHALDUN BOGOR</p>
                                                                                                <p class="text-[7.5px] text-slate-500 tracking-tight">SISTEM INFORMASI • INFORMATIKA • SIPIL • ELEKTRO • MESIN</p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="border border-slate-700 px-1 py-0.5 text-[8px] font-bold font-mono">
                                                                                            FTS-LAB-P03-F-01
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Mini Title -->
                                                                                    <div class="text-center py-1 relative z-10">
                                                                                        <p class="font-black text-[11px] text-slate-900 underline uppercase tracking-wide">BERITA ACARA PRAKTIKUM</p>
                                                                                        <p class="text-[8.5px] text-slate-600 mt-0.5 italic">
                                                                                            Telah Dilaksanakan Praktikum {{ $ag->mata_kuliah }} Semester {{ $ag->semester ?? 'IV' }} TA {{ $baDetails['tahun_ajaran'] }}
                                                                                        </p>
                                                                                    </div>

                                                                                    <!-- Mini Form Lines -->
                                                                                    <div class="space-y-1 text-[9px] text-slate-800 relative z-10">
                                                                                        <div class="flex">
                                                                                            <span class="w-28 font-bold text-slate-600">Hari / Tanggal</span>
                                                                                            <span class="mr-1">:</span>
                                                                                            <span class="flex-1 border-b border-dotted border-slate-400 font-semibold">{{ $baDetails['hari_tanggal_indo'] }}</span>
                                                                                        </div>
                                                                                        <div class="flex">
                                                                                            <span class="w-28 font-bold text-slate-600">Waktu / Durasi</span>
                                                                                            <span class="mr-1">:</span>
                                                                                            <span class="flex-1 border-b border-dotted border-slate-400 font-semibold">{{ $baDetails['waktu_durasi'] }}</span>
                                                                                        </div>
                                                                                        <div class="flex">
                                                                                            <span class="w-28 font-bold text-slate-600">Prodi / Semester</span>
                                                                                            <span class="mr-1">:</span>
                                                                                            <span class="flex-1 border-b border-dotted border-slate-400 font-semibold">{{ $baDetails['prodi_semester_kelas'] }}</span>
                                                                                        </div>
                                                                                        <div class="flex">
                                                                                            <span class="w-28 font-bold text-slate-600">Materi</span>
                                                                                            <span class="mr-1">:</span>
                                                                                            <span class="flex-1 border-b border-dotted border-slate-400 font-semibold truncate">{{ $baDetails['materi'] ?: 'Belum diisi...' }}</span>
                                                                                        </div>
                                                                                        <div class="flex">
                                                                                            <span class="w-28 font-bold text-slate-600">Catatan</span>
                                                                                            <span class="mr-1">:</span>
                                                                                            <span class="flex-1 border-b border-dotted border-slate-400 font-semibold truncate">{{ $baDetails['catatan'] ?: '-' }}</span>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Mini 3 Signatures -->
                                                                                    <div class="grid grid-cols-3 gap-2 text-center pt-3 relative z-10">
                                                                                        <div>
                                                                                            <p class="font-bold text-[8px] text-slate-600">Laboran</p>
                                                                                            <div class="h-6"></div>
                                                                                            <p class="font-bold text-[8.5px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['laboran'] }}</p>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="font-bold text-[8px] text-slate-600">Asissten Praktikum</p>
                                                                                            <div class="h-6"></div>
                                                                                            <p class="font-bold text-[8.5px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['asisten'] }}</p>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p class="font-bold text-[8px] text-slate-600">Dosen / Instruktur</p>
                                                                                            <div class="h-6"></div>
                                                                                            <p class="font-bold text-[8.5px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['dosen'] }}</p>
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Mini Footer Bar -->
                                                                                    <div class="bg-blue-700 text-white p-1 rounded-sm flex justify-between text-[7px] mt-2 relative z-10">
                                                                                        <span class="truncate">Ibn Khaldun Bogor : Jl. KH. Sholeh Iskandar KM. 2</span>
                                                                                        <span class="font-bold">www.ft.uika-bogor.ac.id</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <!-- Modal Footer -->
                                                                <div class="flex items-center justify-between px-6 py-3.5 bg-slate-50 border-t border-slate-200">
                                                                    <a href="{{ route('dosen.agenda.berita-acara.cetak', $ag->id) }}" 
                                                                       target="_blank" 
                                                                       class="px-4 py-2 bg-sky-50 hover:bg-sky-100 text-sky-800 border border-sky-300 font-bold rounded-xl transition flex items-center gap-1.5 shadow-2xs">
                                                                        <i class="fa-solid fa-arrow-up-right-from-square text-sky-600"></i>
                                                                        <span>Cetak / Lembar A4</span>
                                                                    </a>

                                                                    <div class="flex items-center gap-2">
                                                                        <button type="button" onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">Batal</button>
                                                                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-sm flex items-center gap-1.5">
                                                                            <i class="fa-solid fa-floppy-disk"></i>
                                                                            <span>Simpan Berita Acara</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Collapsible Section: Realisasi & Absensi (Collapsible details) -->
                                                <details class="w-full bg-white border border-slate-200 rounded-xl overflow-hidden group">
                                                    <summary class="px-4 py-3 bg-slate-50/50 hover:bg-slate-100/60 font-bold text-xs text-slate-650 cursor-pointer flex items-center justify-between transition-all select-none">
                                                        <span class="flex items-center gap-2">
                                                            <i class="fa-solid fa-folder-open text-teal-700"></i> Kelola Realisasi & Presensi Mahasiswa
                                                        </span>
                                                        <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform"></i>
                                                    </summary>
                                                    <div class="p-4 space-y-4 border-t border-slate-100 text-xs w-full">
                                                        
                                                        <!-- Form Realisasi -->
                                                        <div class="w-full bg-slate-50 p-4 rounded-xl border border-slate-200">
                                                            <h5 class="font-bold text-slate-700 mb-2 flex items-center gap-1.5"><i class="fa-solid fa-check-double text-emerald-600"></i> Realisasi Pembelajaran</h5>
                                                            <form action="{{ route('dosen.agenda.realisasi', $ag->id) }}" method="POST" class="flex gap-2 w-full items-center">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="text" 
                                                                       name="realisasi_pembelajaran" 
                                                                       value="{{ $ag->materi_realisasi }}"
                                                                       placeholder="Contoh: Pembahasan OOP & Inheritance, disusul latihan..." 
                                                                       class="flex-1 p-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                                                                <button type="submit" class="px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-bold transition whitespace-nowrap">
                                                                    Simpan
                                                                </button>
                                                                @if($ag->materi_realisasi)
                                                                    <button type="submit" name="realisasi_pembelajaran" value="" onclick="return confirmAction(event, 'Apakah Anda yakin ingin menghapus realisasi pembelajaran ini?', 'Hapus Realisasi?')" class="px-3 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-250 rounded-lg font-bold transition whitespace-nowrap" title="Hapus Realisasi">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </button>
                                                                @endif
                                                            </form>
                                                        </div>

                                                        <!-- Table Absensi Mahasiswa -->
                                                        <div class="space-y-2">
                                                            <h5 class="font-bold text-slate-700 flex items-center justify-between">
                                                                <span><i class="fa-solid fa-users text-indigo-650"></i> Daftar Kehadiran Mahasiswa</span>
                                                                <div class="flex items-center gap-2.5">
                                                                    @if($ag->absensi->count() > 0)
                                                                        <a href="{{ route('dosen.agenda.export-kehadiran', $ag->id) }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-300 rounded-lg text-xs font-extrabold uppercase flex items-center gap-1.5 transition">
                                                                            <i class="fa-solid fa-print"></i> Cetak Absen
                                                                        </a>
                                                                    @endif
                                                                    <span class="text-xs text-slate-500 font-semibold">Total: {{ $ag->absensi->count() }} Hadir</span>
                                                                </div>
                                                            </h5>
                                                            
                                                            @if($ag->absensi->count() > 0)
                                                                <div class="overflow-x-auto border border-slate-100 rounded-lg">
                                                                    <table class="w-full text-xs text-left text-slate-600">
                                                                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                                                            <tr>
                                                                                <th class="p-2.5">No</th>
                                                                                <th class="p-2.5">Nama Mahasiswa</th>
                                                                                <th class="p-2.5">NIM</th>
                                                                                <th class="p-2.5">Waktu Scan</th>
                                                                                <th class="p-2.5">Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-slate-100">
                                                                            @foreach($ag->absensi as $idx => $abs)
                                                                                <tr class="hover:bg-slate-50/50 transition">
                                                                                    <td class="p-2.5 font-mono text-slate-400">{{ $idx + 1 }}</td>
                                                                                    <td class="p-2.5 font-bold text-slate-800">{{ $abs->mahasiswa->nama_lengkap }}</td>
                                                                                    <td class="p-2.5 font-mono text-teal-800">{{ $abs->mahasiswa->nim }}</td>
                                                                                    <td class="p-2.5 text-slate-550">{{ $abs->waktu_masuk }}</td>
                                                                                    <td class="p-2.5">
                                                                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-900 border border-emerald-300 font-extrabold rounded-md text-xs uppercase">
                                                                                            {{ $abs->status_kehadiran }}
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @else
                                                                <div class="text-center py-6 bg-slate-50 border border-slate-150 border-dashed rounded-xl text-slate-400 italic">
                                                                    Belum ada mahasiswa yang memindai QR Code untuk agenda ini.
                                                                 </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </details>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-10 px-4">
                                    <div class="w-14 h-14 bg-teal-50 border border-teal-100 rounded-2xl flex items-center justify-center mx-auto text-teal-700 mb-3 text-2xl shadow-sm">
                                        <i class="fa-solid fa-umbrella-beach"></i>
                                    </div>
                                    <h4 class="font-bold text-slate-800 text-sm">Libur Semester / Tidak Ada Agenda Aktif</h4>
                                    <p class="text-xs text-slate-500 max-w-md mx-auto mt-1 leading-relaxed">
                                        Saat ini tidak ada agenda praktikum aktif atau perkuliahan semester yang berlangsung. Seluruh riwayat agenda perkuliahan yang telah selesai dari semester sebelumnya tersimpan rapi di menu <span class="font-semibold text-teal-800">Sidebar Agenda</span>.
                                    </p>
                                    <a href="{{ route('dosen.agenda') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs rounded-xl shadow-sm transition-all">
                                        <i class="fa-solid fa-calendar-days text-xs"></i> Buka Riwayat Agenda (Sidebar)
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Right column: Plotting Lab & Panduan Dosen -->
                <div class="space-y-6">
                    <!-- Widget 1: Jadwal Mengajar Lab Dosen -->
                    <div class="bg-white border-2 border-slate-200 shadow-xs rounded-2xl p-5 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                            <div>
                                <h3 class="font-black text-base text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-check text-teal-700"></i> Jadwal Mengajar Lab Anda
                                </h3>
                                <p class="text-sm text-slate-600 font-medium mt-0.5">Jadwal rutin mingguan dari Admin</p>
                            </div>
                            <span class="px-3 py-1 bg-slate-100 text-slate-900 border border-slate-300 rounded-lg text-sm font-bold">
                                {{ isset($jadwalPenggunaanLab) ? $jadwalPenggunaanLab->count() : 0 }} Jadwal
                            </span>
                        </div>

                        @if(isset($jadwalPenggunaanLab) && $jadwalPenggunaanLab->count() > 0)
                            <div class="space-y-3 max-h-84 overflow-y-auto pr-1">
                                @foreach($jadwalPenggunaanLab as $j)
                                    @php
                                        $createdSessions = \App\Models\Agenda::where('jadwal_penggunaan_lab_id', $j->id)->count();
                                    @endphp
                                    <div class="p-4 bg-slate-50 border border-slate-300 rounded-xl space-y-2.5 hover:border-slate-400 transition">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-black text-base text-slate-900 truncate max-w-[220px]">{{ $j->mata_kuliah }}</span>
                                            <div class="flex items-center gap-1.5 shrink-0">
                                                <span class="px-2.5 py-0.5 bg-white text-slate-900 border border-slate-300 rounded text-xs font-bold">
                                                    {{ str_contains(strtolower($j->semester ?? ''), 'semester') ? $j->semester : 'Smt ' . ($j->semester ?? '1') }}
                                                </span>
                                                <span class="px-2.5 py-0.5 bg-slate-200 text-slate-900 rounded text-xs font-bold">Kelas {{ $j->kelas }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-sm text-slate-700 font-bold">
                                            <span><i class="fa-regular fa-clock mr-1.5 text-slate-600"></i>{{ $j->hari }}, {{ substr($j->jam_mulai,0,5) }} - {{ substr($j->jam_selesai,0,5) }} WIB</span>
                                            <span class="text-slate-900 bg-white px-2.5 py-0.5 rounded border border-slate-300"><i class="fa-solid fa-door-open mr-1 text-slate-600"></i>{{ $j->lab->nama_lab ?? 'Lab' }}</span>
                                        </div>
                                        <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-sm font-semibold">
                                            <span class="text-slate-600">Status Pertemuan:</span>
                                            @if($createdSessions >= 16)
                                                <span class="font-black text-emerald-950 flex items-center gap-1.5 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-400">
                                                    <i class="fa-solid fa-circle-check text-emerald-700"></i> 16 Sesi Siap
                                                </span>
                                            @elseif($createdSessions > 0)
                                                <span class="font-black text-slate-900 flex items-center gap-1.5 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-300">
                                                    <i class="fa-solid fa-calendar-days text-slate-600"></i> {{ $createdSessions }} dari 16 Sesi
                                                </span>
                                            @else
                                                <span class="text-slate-600 italic bg-slate-200/70 px-2.5 py-1 rounded-lg">
                                                    Disiapkan Admin
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-slate-600 text-sm italic font-medium">
                                Belum ada plotting jadwal lab untuk akun Anda.
                            </div>
                        @endif
                    </div>

                    <!-- Widget 2: Panduan Alur Perkuliahan Digital Board -->
                    <div class="bg-white border-2 border-slate-200 shadow-xs rounded-2xl p-5 sm:p-6 space-y-4">
                        <div class="flex items-center gap-2.5 border-b border-slate-200 pb-3">
                            <h4 class="font-black text-base text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-teal-700"></i>
                                <span>Alur Perkuliahan Digital Board</span>
                            </h4>
                        </div>
                        <ul class="space-y-3 text-sm text-slate-700 font-medium">
                            <li class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5 shadow-xs">1</span>
                                <div>
                                    <strong class="text-slate-900 font-bold block text-sm">Absen QR Board</strong>
                                    <span class="text-slate-600 leading-relaxed">Lakukan scan QR di layar Digital Board lab untuk verifikasi kehadiran fisik dosen.</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5 shadow-xs">2</span>
                                <div>
                                    <strong class="text-slate-900 font-bold block text-sm">Presensi Mahasiswa</strong>
                                    <span class="text-slate-600 leading-relaxed">Cek dan verifikasi kehadiran mahasiswa, izin, sakit, atau alpa.</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <span class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5 shadow-xs">3</span>
                                <div>
                                    <strong class="text-slate-900 font-bold block text-sm">Realisasi &amp; Berita Acara</strong>
                                    <span class="text-slate-600 leading-relaxed">Catat pokok materi yang diajarkan dan simpan lembar Berita Acara resmi.</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <script>
                    function toggleComboboxDashboard(forceOpen = null) {
                        const menu = document.getElementById('combobox_menu_dashboard');
                        const arrow = document.getElementById('combobox_arrow_dashboard');
                        if (!menu) return;

                        const isOpen = forceOpen !== null ? forceOpen : menu.classList.contains('hidden');
                        if (isOpen) {
                            menu.classList.remove('hidden');
                            if (arrow) arrow.classList.add('rotate-180');
                        } else {
                            menu.classList.add('hidden');
                            if (arrow) arrow.classList.remove('rotate-180');
                        }
                    }

                    function filterComboboxDashboard(query) {
                        toggleComboboxDashboard(true);
                        const q = query.toLowerCase().trim();
                        const items = document.querySelectorAll('#combobox_menu_dashboard .combobox-item');
                        let hasMatch = false;

                        items.forEach(item => {
                            const searchText = item.dataset.search || '';
                            if (!q || searchText.includes(q)) {
                                item.classList.remove('hidden');
                                hasMatch = true;
                            } else {
                                item.classList.add('hidden');
                            }
                        });

                        const emptyMsg = document.getElementById('combobox_empty_dashboard');
                        if (emptyMsg) {
                            if (hasMatch) emptyMsg.classList.add('hidden');
                            else emptyMsg.classList.remove('hidden');
                        }
                    }

                    function selectComboboxDashboard(itemEl) {
                        const hiddenInput = document.getElementById('dashboard_jadwal_id');
                        const searchInput = document.getElementById('combobox_search_dashboard');
                        
                        if (hiddenInput) hiddenInput.value = itemEl.dataset.id;
                        if (searchInput) searchInput.value = itemEl.dataset.title;

                        document.querySelectorAll('#combobox_menu_dashboard .combobox-item').forEach(el => {
                            el.classList.remove('bg-teal-100/80', 'border-l-4', 'border-teal-700');
                        });
                        itemEl.classList.add('bg-teal-100/80', 'border-l-4', 'border-teal-700');

                        const lab = itemEl.dataset.lab || '';
                        const kelas = itemEl.dataset.kelas || '';
                        const semester = itemEl.dataset.semester || '';
                        const prodi = itemEl.dataset.prodi || '';
                        const hari = itemEl.dataset.hari || '';
                        const jamMulai = itemEl.dataset.jamMulai || '';
                        const jamSelesai = itemEl.dataset.jamSelesai || '';

                        const box = document.getElementById('jadwal-info-box');
                        if (box) {
                            box.classList.remove('hidden');
                            const labEl = document.getElementById('info-lab');
                            const kelasEl = document.getElementById('info-kelas');
                            const rutinEl = document.getElementById('info-rutin');
                            const prodiEl = document.getElementById('info-prodi');

                            if (labEl) labEl.innerHTML = `<i class="fa-solid fa-door-open mr-1 text-teal-600"></i> ${lab}`;
                            if (kelasEl) kelasEl.innerText = `Kelas ${kelas} • Smt ${semester}`;
                            if (rutinEl) rutinEl.innerText = `${hari}, ${jamMulai} - ${jamSelesai} WIB`;
                            if (prodiEl) prodiEl.innerText = prodi;
                        }

                        const inMasuk = document.getElementById('input_waktu_masuk');
                        const inKeluar = document.getElementById('input_waktu_keluar');
                        if (inMasuk && jamMulai) inMasuk.value = jamMulai;
                        if (inKeluar && jamSelesai) inKeluar.value = jamSelesai;

                        toggleComboboxDashboard(false);
                    }

                    document.addEventListener('click', function(e) {
                        const containerDashboard = document.getElementById('combobox_container_dashboard');
                        if (containerDashboard && !containerDashboard.contains(e.target)) {
                            toggleComboboxDashboard(false);
                        }
                    });
                </script>

            </div>
            
        </div>
    </main>



    <!-- Profile Dropdown Handler -->
    <script>
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const wrapper = document.getElementById('profileDropdownWrapper');
            const menu = document.getElementById('profileDropdownMenu');
            if (wrapper && menu && !wrapper.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    <!-- Search Select Script -->
    <script>
        function toggleSearchSelect(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        function selectSearchOption(hiddenInputId, labelId, dropdownId, value) {
            const hiddenInput = document.getElementById(hiddenInputId);
            const label = document.getElementById(labelId);
            const dropdown = document.getElementById(dropdownId);
            
            if (hiddenInput && label && dropdown) {
                hiddenInput.value = value;
                label.innerText = value;
                label.classList.remove('text-slate-400');
                label.classList.add('text-slate-700');
                dropdown.classList.add('hidden');
            }
        }

        function onSelectJadwalKuliah(select) {
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption || !selectedOption.value) return;

            const lab = selectedOption.getAttribute('data-lab');
            const kelas = selectedOption.getAttribute('data-kelas');
            const semester = selectedOption.getAttribute('data-semester');
            const prodi = selectedOption.getAttribute('data-prodi');
            const hari = selectedOption.getAttribute('data-hari');
            const jamMulai = selectedOption.getAttribute('data-jam-mulai');
            const jamSelesai = selectedOption.getAttribute('data-jam-selesai');

            const infoLab = document.getElementById('info-lab');
            const infoKelas = document.getElementById('info-kelas');
            const infoRutin = document.getElementById('info-rutin');
            const infoProdi = document.getElementById('info-prodi');
            const box = document.getElementById('jadwal-info-box');

            if (infoLab) infoLab.innerHTML = '<i class="fa-solid fa-door-open mr-1 text-teal-600"></i> ' + (lab || 'Lab');
            if (infoKelas) infoKelas.textContent = 'Kelas ' + (kelas || 'Reg A');
            if (infoRutin) infoRutin.textContent = (hari || '') + ', ' + (jamMulai || '') + ' - ' + (jamSelesai || '') + ' WIB';
            if (infoProdi) infoProdi.textContent = (prodi || 'Sistem Informasi') + ' • Semester ' + (semester || '1');
            if (box) box.classList.remove('hidden');

            const inputMulai = document.getElementById('input_waktu_masuk');
            const inputSelesai = document.getElementById('input_waktu_keluar');
            if (inputMulai && jamMulai) inputMulai.value = jamMulai;
            if (inputSelesai && jamSelesai) inputSelesai.value = jamSelesai;
        }

        function filterSearchSelect(dropdownId, query) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const options = dropdown.getElementsByClassName('select-option-item');
                const lowercaseQuery = query.toLowerCase();
                
                for (let i = 0; i < options.length; i++) {
                    const text = options[i].textContent || options[i].innerText;
                    const matchesSearch = text.toLowerCase().indexOf(lowercaseQuery) > -1;
                    
                    if (matchesSearch) {
                        options[i].classList.remove('hidden-by-search');
                        if (!options[i].classList.contains('hidden-by-fakultas')) {
                            options[i].style.display = "";
                        }
                    } else {
                        options[i].classList.add('hidden-by-search');
                        options[i].style.display = "none";
                    }
                }
            }
        }

        function handleFakultasChange(selectedFakultas, hiddenInputId, labelId, dropdownId) {
            // Reset prodi label & input value
            const hiddenInput = document.getElementById(hiddenInputId);
            const label = document.getElementById(labelId);
            if (hiddenInput && label) {
                hiddenInput.value = "";
                label.innerText = "Pilih Program Studi";
                label.classList.add('text-slate-400');
                label.classList.remove('text-slate-700');
            }
            
            // Filter options by data-fakultas
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const options = dropdown.getElementsByClassName('select-option-item');
                for (let i = 0; i < options.length; i++) {
                    const optFak = options[i].getAttribute('data-fakultas');
                    if (!selectedFakultas || optFak === selectedFakultas) {
                        options[i].classList.remove('hidden-by-fakultas');
                        if (!options[i].classList.contains('hidden-by-search')) {
                            options[i].style.display = "";
                        }
                    } else {
                        options[i].classList.add('hidden-by-fakultas');
                        options[i].style.display = "none";
                    }
                }
            }
        }

        // Close search dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideSelect = event.target.closest('.custom-search-select');
            if (!isClickInsideSelect) {
                const dropdowns = document.querySelectorAll('[id^="select-jurusan-dropdown"]');
                dropdowns.forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>

    <!-- Hidden form for QR attendance submission -->
    <form id="dosen-absensi-form" action="{{ route('dosen.absensi.submit') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="qr_code_token" id="dosen-qr-token-input">
    </form>

    <!-- QR Scanner Modal -->
    <div id="modal-qr-scanner" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100 text-slate-800">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i class="fa-solid fa-camera text-teal-800"></i> Pindai QR Code Board
                </h3>
                <button type="button" onclick="closeScannerModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <div class="space-y-4">
                <div id="qr-reader" class="overflow-hidden rounded-xl border border-slate-200" style="width: 100%; min-height: 250px;"></div>
                <div id="qr-reader-results" class="text-center text-xs text-slate-500 font-mono"></div>

                <!-- Fallback manual input inside modal for camera issues -->
                <div class="pt-3 border-t border-slate-100 space-y-2 text-left">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                        <i class="fa-solid fa-keyboard text-teal-800 mr-1"></i> Alternatif: Input Manual Token / ID Agenda
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="modal-dosen-manual-token-input" placeholder="Contoh: AGENDA_ID_1" 
                               class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs uppercase font-bold tracking-widest text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 focus:bg-white">
                        <button type="button" onclick="submitDosenModalManualToken()" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold uppercase transition shadow-sm flex items-center gap-1.5 shrink-0">
                            <i class="fa-solid fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                    <p class="text-xs text-slate-500 font-medium italic">Gunakan input ini jika kamera perangkat Anda bermasalah atau tidak dapat dibuka.</p>
                </div>
            </div>
            
            <div class="flex pt-3 border-t border-slate-100">
                <button type="button" onclick="closeScannerModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <!-- html5-qrcode script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner = null;

        function startDosenQRScanner() {
            document.getElementById('modal-qr-scanner').classList.remove('hidden');
            
            html5QrcodeScanner = new Html5Qrcode("qr-reader");
            const config = { fps: 10, qrbox: { width: 220, height: 220 } };
            
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    let cameraId = devices[0].id;
                    // Try to find the back/rear camera
                    for (let i = 0; i < devices.length; i++) {
                        const label = devices[i].label.toLowerCase();
                        if (label.includes('back') || label.includes('rear') || label.includes('lingkungan') || label.includes('belakang')) {
                            cameraId = devices[i].id;
                            break;
                        }
                    }
                    
                    html5QrcodeScanner.start(
                        cameraId,
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {
                            // parse error, ignore
                        }
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                } else {
                    // Fallback to environment constraints
                    html5QrcodeScanner.start(
                        { facingMode: "environment" },
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {
                            // parse error, ignore
                        }
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                }
            }).catch(err => {
                console.error("Gagal getCameras: ", err);
                // Fallback to environment constraint
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText, decodedResult) => {
                        document.getElementById('dosen-qr-token-input').value = decodedText;
                        document.getElementById('dosen-absensi-form').submit();
                        closeScannerModal();
                    },
                    (errorMessage) => {
                        // parse error, ignore
                    }
                ).catch((err2) => {
                    console.error("Gagal memulai kamera: ", err2);
                    alert("Gagal mengakses kamera. Detail:\n1. " + err + "\n2. " + err2);
                    closeScannerModal();
                });
            });
        }

        function closeScannerModal() {
            document.getElementById('modal-qr-scanner').classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch(err => {
                    console.error("Gagal menghentikan scanner: ", err);
                });
            }
        }

        function submitDosenModalManualToken() {
            const val = document.getElementById('modal-dosen-manual-token-input').value.trim();
            if (!val) {
                alert('Silakan masukkan Kode Token / ID Agenda terlebih dahulu.');
                return;
            }
            document.getElementById('dosen-qr-token-input').value = val;
            document.getElementById('dosen-absensi-form').submit();
            closeScannerModal();
        }

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }
    </script>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical Layout with Center QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t-2 border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-xl">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-extrabold">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-xs font-extrabold">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-600 hover:text-slate-900">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-xs font-bold">Agenda</span>
        </a>
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-800 text-white rounded-2xl shadow-xl border-4 border-white">
            <button type="button" onclick="startDosenQRScanner()" class="flex items-center justify-center w-full h-full text-white bg-teal-800 rounded-xl hover:bg-teal-900 transition-all cursor-pointer" title="Scan QR Presensi">
                <i class="fa-solid fa-qrcode text-2xl text-white"></i>
            </button>
        </div>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-600 hover:text-slate-900">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-xs font-bold">Pengaturan</span>
        </a>
    </nav>

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
        function confirmAction(event, text, title = 'Apakah Anda yakin?', confirmText = 'Ya, Lanjutkan!') {
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            if (form && form.dataset.confirmed === "true") {
                return true;
            }

            event.preventDefault();
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.dataset.confirmed = "true";
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            });
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium'
                    }
                });
            @endif

            @if(session('error') || session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error') ?? session('failed')),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            @if($errors->any() && !session('success') && !session('error') && !session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memproses Data!',
                    text: @json($errors->first()),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            // CRUD & Form Submit Loading Spinner
            document.querySelectorAll('form').forEach(function(form) {
                if (form.method.toUpperCase() === 'GET' || form.classList.contains('no-loading')) {
                    return;
                }

                form.addEventListener('submit', function(e) {
                    if (e.defaultPrevented) return;
                    if (form.checkValidity && !form.checkValidity()) {
                        return;
                    }

                    const isLogout = (form.action && form.action.includes('logout')) || form.classList.contains('logout-form');
                    const isImport = form.getAttribute('enctype') === 'multipart/form-data';
                    
                    let loadingTitle = 'Menyimpan Data...';
                    let loadingText = 'Sedang memproses dan menyimpan data ke sistem.';
                    
                    if (isLogout) {
                        loadingTitle = 'Sedang Keluar...';
                        loadingText = 'Menutup sesi akun Anda dengan aman.';
                    } else if (isImport) {
                        loadingTitle = 'Mengimpor Data...';
                        loadingText = 'Sistem sedang membaca dan memproses file Excel/CSV.';
                    }

                    Swal.fire({
                        title: loadingTitle,
                        text: loadingText,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl p-8 shadow-2xl border border-slate-100',
                            title: 'text-base font-extrabold text-slate-800',
                            htmlContainer: 'text-xs text-slate-500 font-medium'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        }
                    }, 10);
                });
            });
        });

        window.addEventListener('pageshow', function() {
            if (typeof Swal !== 'undefined' && Swal.isVisible() && Swal.isLoading()) {
                Swal.close();
            }
        });
    </script>

    @include('dosen.partials.modal_tutorial')
</body>
</html>
