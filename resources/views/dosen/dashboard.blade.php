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
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold tracking-wider text-teal-400">Smart Lab Management</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full">
                <i class="fa-solid fa-border-all"></i>
                <span class="text-xs font-semibold tracking-wide">Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-alt"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-gear"></i>
                <span class="text-xs font-semibold tracking-wide">Pengaturan Akun</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Dashboard Dosen</h2>
            </div>

            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ $dosen->nama }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIP: {{ $dosen->nip }} • Dosen</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ substr($dosen->nama, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $dosen->nama }}</p>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">NIP: {{ $dosen->nip }}</p>
                        <span class="inline-block mt-1.5 px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200/60 rounded-md text-[9px] font-bold">
                            Dosen Pengajar
                        </span>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800 transition font-medium group">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-700 flex items-center justify-center text-slate-500 transition">
                                <i class="fa-solid fa-gear text-xs"></i>
                            </div>
                            <div>
                                <span class="font-bold block">Pengaturan Akun</span>
                                <span class="text-[10px] text-slate-400 block font-normal">Edit profil & ganti password</span>
                            </div>
                        </a>
                    </div>

                    <div class="pt-1 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 transition font-bold text-left group">
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
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Welcome Header (Figma Green Style) -->
            <div class="bg-gray-900 text-white rounded-2xl p-6 shadow-md relative overflow-hidden flex flex-col justify-between gap-4">
                <div class="space-y-1 z-10">
                    <p class="text-xs font-medium text-teal-200 uppercase tracking-widest">DOSEN PORTAL</p>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight">Selamat Datang, {{ $dosen->nama }}</h2>
                    <p class="text-xs text-teal-200/90 font-mono">NIP: {{ $dosen->nip }}</p>
                    @if($dosen->kompetensi)
                        <div class="pt-1 text-[10px] text-emerald-100 flex items-center gap-1.5">
                            <i class="fa-solid fa-star text-amber-400 animate-pulse"></i>
                            <span>Kompetensi: <strong class="text-white">{{ $dosen->kompetensi }}</strong></span>
                        </div>
                    @endif
                </div>
                <div class="z-10 self-start px-3 py-1.5 @if($activeOrNextAgenda && $activeOrNextAgenda->dosen_waktu_masuk) bg-emerald-950/40 border-emerald-500/30 @else bg-rose-950/40 border-rose-500/30 @endif border rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span class="w-2.5 h-2.5 @if($activeOrNextAgenda && $activeOrNextAgenda->dosen_waktu_masuk) bg-emerald-400 @else bg-rose-400 @endif rounded-full animate-pulse"></span>
                    Status: @if($activeOrNextAgenda && $activeOrNextAgenda->dosen_waktu_masuk) Sudah Check-in ({{ date('H:i', strtotime($activeOrNextAgenda->dosen_waktu_masuk)) }} WIB) @else Belum Check-in @endif
                </div>
                <i class="fa-solid fa-chalkboard-user absolute right-6 bottom-4 text-white/5 text-8xl pointer-events-none hidden md:block"></i>
            </div>

            <!-- Auto-Detect Sesi Hari Ini Banner (Analyst Automation #2) -->
            @if(isset($todayScheduledJadwal))
            <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white rounded-2xl p-5 shadow-lg border border-emerald-500/30 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 bg-emerald-500 text-white rounded-full text-[10px] font-extrabold uppercase tracking-wide animate-pulse">
                            <i class="fa-solid fa-bolt mr-1"></i> Sesi Praktikum Hari Ini Ditemukan
                        </span>
                        <span class="text-xs text-emerald-300 font-semibold font-mono">{{ $todayScheduledJadwal->hari }}, {{ substr($todayScheduledJadwal->jam_mulai,0,5) }} - {{ substr($todayScheduledJadwal->jam_selesai,0,5) }} WIB</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mt-1">{{ $todayScheduledJadwal->mata_kuliah }}</h3>
                    <p class="text-xs text-slate-300">
                        <i class="fa-solid fa-door-open text-teal-400 mr-1"></i> {{ $todayScheduledJadwal->lab->nama_lab ?? 'Lab' }} • Kelas {{ $todayScheduledJadwal->kelas }} (Semester {{ $todayScheduledJadwal->semester }})
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <form action="{{ route('dosen.agenda.store') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="jadwal_penggunaan_lab_id" value="{{ $todayScheduledJadwal->id }}">
                        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="waktu_masuk" value="{{ substr($todayScheduledJadwal->jam_mulai,0,5) }}">
                        <input type="hidden" name="waktu_keluar" value="{{ substr($todayScheduledJadwal->jam_selesai,0,5) }}">
                        <input type="hidden" name="rencana_pembelajaran" value="Sesi Praktikum Regular - {{ $todayScheduledJadwal->mata_kuliah }}">
                        <button type="submit" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-play"></i>
                            <span>1-Click Start Agenda Hari Ini</span>
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Announcements -->
            @if(isset($pengumuman) && $pengumuman->count() > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex gap-4 items-start shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <h3 class="font-bold text-amber-800 text-sm flex items-center gap-2">
                        PENGUMUMAN RESMI LAB
                        <span class="text-[10px] font-normal text-amber-600/80">({{ date('d M Y', strtotime($pengumuman->first()->created_at)) }})</span>
                    </h3>
                    <p class="text-amber-700 text-xs mt-1">
                        <strong>{{ $pengumuman->first()->judul }}:</strong> {{ $pengumuman->first()->isi_pengumuman }}
                    </p>
                </div>
            </div>
            @endif

            <!-- Top Header & Quick Create Agenda Section (Replaces Absensi Dosen) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Bento 1: Agenda Hari Ini Stat -->
                <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between relative overflow-hidden">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-sm border border-teal-100">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Agenda Hari Ini</span>
                        </div>
                        <span class="px-2 py-0.5 bg-teal-50 text-teal-800 border border-teal-200 rounded text-[10px] font-bold">
                            {{ \Carbon\Carbon::today()->translatedFormat('d M Y') }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-extrabold text-slate-800">{{ $todayAgendas->count() }}</span>
                            <span class="text-xs font-bold text-slate-500">Sesi Pertemuan</span>
                        </div>
                        <p class="text-[11px] text-slate-450 mt-1 font-medium">Praktikum Aktif Terjadwal</p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('dosen.agenda') }}" class="text-[11px] font-bold text-teal-800 hover:text-teal-900 transition flex items-center gap-1">
                            <span>Kelola Semua Agenda</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                        <span class="text-[10px] font-mono text-slate-400">Total: {{ $agendas->count() }} Agenda</span>
                    </div>
                </div>

                <!-- Bento 2: Buat Agenda Mata Kuliah Form (Moved from right column, replacing Absensi Dosen) -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-teal-800 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                                <i class="fa-solid fa-calendar-plus"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xs text-slate-800">Buat Agenda Mata Kuliah Baru</h3>
                                <p class="text-[10px] text-slate-400 font-medium">Pilih mata kuliah & buat jadwal sesi praktikum secara cepat</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-200 rounded-lg text-[10px] font-bold hidden sm:inline-block">
                            <i class="fa-solid fa-bolt mr-1 text-teal-600"></i> Buat Agenda Cepat
                        </span>
                    </div>

                    <form action="{{ route('dosen.agenda.store') }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- 1. Combobox Mata Kuliah Berdasarkan Jadwal -->
                            <div class="space-y-1">
                                <label class="block text-slate-700 font-bold text-[11px]">Mata Kuliah & Kelas <span class="text-rose-500">*</span></label>
                                @if(isset($jadwalPenggunaanLab) && $jadwalPenggunaanLab->count() > 0)
                                    <!-- Hidden input for form submission -->
                                    <input type="hidden" name="jadwal_penggunaan_lab_id" id="dashboard_jadwal_id" required>

                                    <!-- Custom Searchable Combobox Component -->
                                    <div class="relative" id="combobox_container_dashboard">
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-magnifying-glass absolute left-3 text-slate-400 text-xs pointer-events-none"></i>
                                            <input type="text" 
                                                   id="combobox_search_dashboard" 
                                                   placeholder="-- Cari / Pilih Mata Kuliah Terjadwal --" 
                                                   autocomplete="off"
                                                   onclick="toggleComboboxDashboard(true)"
                                                   onfocus="toggleComboboxDashboard(true)"
                                                   oninput="filterComboboxDashboard(this.value)"
                                                   class="w-full pl-8 pr-8 py-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 font-bold text-xs focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none transition placeholder:font-normal placeholder:text-slate-400 cursor-pointer" />
                                            <button type="button" 
                                                    onclick="toggleComboboxDashboard()" 
                                                    class="absolute right-2 text-slate-400 hover:text-slate-600 p-1 focus:outline-none">
                                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" id="combobox_arrow_dashboard"></i>
                                            </button>
                                        </div>

                                        <!-- Dropdown Options Menu -->
                                        <div id="combobox_menu_dashboard" 
                                             class="hidden absolute z-30 left-0 right-0 mt-1 max-h-56 overflow-y-auto bg-white border border-slate-200 rounded-xl shadow-xl divide-y divide-slate-100">
                                            @foreach($jadwalPenggunaanLab as $j)
                                                <div class="combobox-item p-2.5 hover:bg-teal-50/80 cursor-pointer transition flex flex-col gap-0.5"
                                                     data-id="{{ $j->id }}"
                                                     data-title="{{ $j->mata_kuliah }} - {{ $j->kelas }} ({{ $j->hari }}, {{ substr($j->jam_mulai,0,5) }}-{{ substr($j->jam_selesai,0,5) }})"
                                                     data-search="{{ strtolower($j->mata_kuliah . ' ' . $j->kelas . ' ' . $j->hari . ' ' . ($j->lab->nama_lab ?? '') . ' ' . ($j->prodi->nama_prodi ?? '')) }}"
                                                     data-lab="{{ strtoupper($j->lab->nama_lab ?? 'Lab') }}"
                                                     data-kelas="{{ $j->kelas ?? 'Reg A' }}"
                                                     data-semester="{{ $j->semester ?? '1' }}"
                                                     data-prodi="{{ $j->prodi->nama_prodi ?? 'Sistem Informasi' }}"
                                                     data-hari="{{ $j->hari }}"
                                                     data-jam-mulai="{{ substr($j->jam_mulai, 0, 5) }}"
                                                     data-jam-selesai="{{ substr($j->jam_selesai, 0, 5) }}"
                                                     onclick="selectComboboxDashboard(this)">
                                                    <div class="flex items-center justify-between font-bold text-slate-800 text-xs">
                                                        <span class="text-teal-900 font-extrabold truncate max-w-[200px]">{{ $j->mata_kuliah }}</span>
                                                        <span class="px-2 py-0.5 bg-teal-100 text-teal-800 rounded-full text-[10px] font-bold">Kelas {{ $j->kelas }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between text-[10px] text-slate-500 font-medium mt-0.5">
                                                        <span><i class="fa-regular fa-clock mr-1 text-slate-400"></i>{{ $j->hari }}, {{ substr($j->jam_mulai,0,5) }}-{{ substr($j->jam_selesai,0,5) }}</span>
                                                        <span class="text-teal-700 font-semibold"><i class="fa-solid fa-door-open mr-1"></i>{{ $j->lab->nama_lab ?? 'Lab' }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div id="combobox_empty_dashboard" class="hidden p-3 text-center text-slate-400 text-xs italic">
                                                Tidak ada mata kuliah yang cocok dengan kata kunci pencarian.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail Box -->
                                    <div id="jadwal-info-box" class="hidden mt-1.5 p-2 bg-teal-50/80 border border-teal-200 rounded-lg space-y-0.5 text-[10px]">
                                        <div class="flex justify-between items-center font-bold text-teal-900">
                                            <span id="info-lab"><i class="fa-solid fa-door-open mr-1 text-teal-600"></i> Lab</span>
                                            <span id="info-kelas" class="px-1.5 py-0.5 bg-teal-200/60 rounded text-[9px]">Kelas</span>
                                        </div>
                                        <div class="text-slate-600 truncate">
                                            <span>Jadwal: <strong id="info-rutin" class="text-slate-800">-</strong></span>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-2 bg-amber-50 border border-amber-200 text-amber-800 rounded-lg text-[11px]">
                                        Belum ada jadwal mata kuliah yang di-plotting.
                                    </div>
                                @endif
                            </div>

                            <!-- 2. Rencana Pembelajaran -->
                            <div class="space-y-1">
                                <label class="block text-slate-700 font-bold text-[11px]">Rencana Pembelajaran / Materi <span class="text-rose-500">*</span></label>
                                <textarea name="rencana_pembelajaran" rows="2" required placeholder="Tuliskan materi pembelajaran pada pertemuan ini..." class="w-full p-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 text-xs focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none resize-none"></textarea>
                            </div>
                        </div>

                        <!-- Row 2: Date, Waktu & Submit -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end pt-1">
                            <div>
                                <label class="block text-slate-700 font-bold text-[11px] mb-1">Tanggal <span class="text-rose-500">*</span></label>
                                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 text-xs font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-700 font-bold text-[11px] mb-1">Jam Mulai <span class="text-rose-500">*</span></label>
                                <input type="time" name="waktu_masuk" id="input_waktu_masuk" required value="08:00" class="w-full p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 text-xs font-mono font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-700 font-bold text-[11px] mb-1">Jam Selesai <span class="text-rose-500">*</span></label>
                                <input type="time" name="waktu_keluar" id="input_waktu_keluar" required value="10:30" class="w-full p-1.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 text-xs font-mono font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            </div>
                            <div>
                                <button type="submit" class="w-full py-2 bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold rounded-lg shadow-sm transition flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    <span>Buat Agenda</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Features Split Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Today's Classes list -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                        <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-2">
                            <h3 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-check text-teal-800"></i>
                                <span>Prioritas Agenda & Kelas</span>
                                <span class="text-xs text-slate-450 font-semibold hidden sm:inline">({{ \Carbon\Carbon::today()->translatedFormat('l, d M Y') }})</span>
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] bg-teal-50 text-teal-800 font-bold px-2.5 py-1 rounded-full border border-teal-200">{{ $agendas->count() }} Prioritas (Max 10)</span>
                                <a href="{{ route('dosen.agenda') }}" class="text-[10px] text-teal-850 hover:underline font-bold flex items-center gap-1">Lihat Semua <i class="fa-solid fa-arrow-right"></i></a>
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
                                        <div class="flex items-center justify-between pb-1.5 border-b border-slate-200">
                                            <div class="flex items-center gap-2">
                                                <div class="px-3 py-1 bg-teal-800 text-white font-extrabold text-xs rounded-lg shadow-sm flex items-center gap-1.5 tracking-wide">
                                                    <i class="fa-solid fa-graduation-cap text-teal-300 text-xs"></i>
                                                    <span>{{ strtoupper($semesterName) }}</span>
                                                </div>
                                                <span class="text-[11px] text-slate-400 font-bold">({{ $semesterAgendas->count() }} Sesi Pertemuan)</span>
                                            </div>
                                        </div>

                                        <!-- Agenda Cards List for this Semester -->
                                        <div class="space-y-4">
                                            @foreach($semesterAgendas as $ag)
                                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-4 hover:border-teal-300 transition-all shadow-sm">
                                                <div class="flex flex-col md:flex-row gap-5 items-start">
                                                    <!-- Time block -->
                                                    <div class="bg-teal-900 text-white rounded-xl p-3 flex flex-col items-center justify-center min-w-[80px] shadow-sm">
                                                        <span class="text-xl font-bold leading-none">{{ substr($ag->jam_mulai,0,2) }}</span>
                                                        <span class="text-[9px] font-semibold uppercase tracking-wider text-teal-300 mt-1">{{ substr($ag->jam_mulai,3,2) }} WIB</span>
                                                    </div>
                                                    
                                                    <!-- Details -->
                                                    <div class="flex-1 space-y-3 w-full">
                                                        <div>
                                                            <div class="flex flex-wrap items-center gap-2">
                                                                @if($ag->status_agenda === 'Berlangsung')
                                                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded text-[9px] font-bold uppercase tracking-wider">Berlangsung</span>
                                                                @elseif($ag->status_agenda === 'Selesai')
                                                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-650 border border-slate-200 rounded text-[9px] font-bold uppercase tracking-wider">Selesai</span>
                                                                @elseif($ag->status_agenda === 'Dibatalkan')
                                                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded text-[9px] font-bold uppercase tracking-wider">Dibatalkan</span>
                                                                @else
                                                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded text-[9px] font-bold uppercase tracking-wider">Mendatang</span>
                                                                @endif
                                                                <span class="px-2 py-0.5 bg-teal-50 text-teal-800 border border-teal-200 rounded text-[9px] font-extrabold uppercase">
                                                                    {{ str_contains(strtolower($ag->semester ?? ''), 'semester') ? $ag->semester : 'Semester ' . ($ag->semester ?? '1') }}
                                                                </span>
                                                                @if($ag->kelas)
                                                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 border border-slate-200 rounded text-[9px] font-bold">
                                                                        Kelas: {{ $ag->kelas }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <h4 class="font-bold text-slate-800 text-lg mt-1.5">{{ $ag->mata_kuliah }}</h4>
                                                            <p class="text-xs text-slate-500 mt-1">Catatan/Materi: <span class="text-slate-650 font-medium">{{ $ag->catatan ?? 'Tidak ada catatan.' }}</span></p>
                                                            <p class="text-[11px] text-slate-450 mt-0.5 flex flex-wrap items-center gap-2">
                                                                <span><i class="fa-solid fa-location-dot mr-1"></i>{{ $ag->lab->nama_lab }}</span>
                                                                <span class="px-2 py-0.5 bg-slate-100 border border-slate-200 rounded text-[10px] font-extrabold font-mono text-teal-850 select-all" title="Kode Token Agenda">ID AGENDA: AGENDA_ID_{{ $ag->id }}</span>
                                                            </p>
                                                        </div>
                                                        
                                                         <!-- Actions -->
                                                         <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-200 w-full">
                                                             @php
                                                                 $isPastOrSelesai = ($ag->tanggal < date('Y-m-d')) || ($ag->status_agenda === 'Selesai');
                                                                 $canAccessFeatures = !empty($ag->dosen_waktu_masuk) || $isPastOrSelesai;
                                                             @endphp

                                                             @if($canAccessFeatures)
                                                                 <div class="flex flex-wrap items-center gap-2">
                                                                     @if($ag->dosen_waktu_masuk)
                                                                         <span class="px-2.5 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold flex items-center gap-1.5 mr-1" title="Waktu Absen Masuk Dosen">
                                                                             <i class="fa-solid fa-circle-check text-emerald-600"></i> Hadir: {{ date('H:i', strtotime($ag->dosen_waktu_masuk)) }} WIB
                                                                         </span>
                                                                     @endif

                                                                     <!-- 1. Tombol Absensi Mahasiswa -->
                                                                     <a href="{{ route('dosen.absensi.input', $ag->id) }}" 
                                                                        class="px-3 py-1.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm"
                                                                        title="Input & Kelola Absensi Mahasiswa">
                                                                         <i class="fa-solid fa-users-viewfinder"></i> Absensi Mahasiswa
                                                                     </a>

                                                                     <!-- 2. Tombol Realisasi Pembelajaran -->
                                                                     <button type="button" 
                                                                             onclick="toggleModal('modal-dashboard-realisasi-{{ $ag->id }}')" 
                                                                             class="px-3 py-1.5 {{ $ag->materi_realisasi ? 'bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300' : 'bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200' }} rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-xs"
                                                                             title="Isi/Edit Realisasi Pembelajaran">
                                                                         <i class="fa-solid fa-book-open"></i> Realisasi
                                                                         @if($ag->materi_realisasi)
                                                                             <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                                                         @endif
                                                                     </button>

                                                                     <!-- 3. Tombol Berita Acara -->
                                                                     <button type="button" 
                                                                             onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')" 
                                                                             class="px-3 py-1.5 {{ $ag->berita_acara ? 'bg-indigo-100 hover:bg-indigo-200 text-indigo-900 border border-indigo-300' : 'bg-indigo-50 hover:bg-indigo-100 text-indigo-800 border border-indigo-200' }} rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-xs"
                                                                             title="Isi/Edit Berita Acara Perkuliahan">
                                                                         <i class="fa-solid fa-file-signature"></i> Berita Acara
                                                                         @if($ag->berita_acara)
                                                                             <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                                                         @endif
                                                                     </button>
                                                                 </div>
                                                             @else
                                                                 <div class="flex flex-wrap items-center gap-2">
                                                                      <button type="button" onclick="startDosenQRScanner()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-2" title="Lakukan Absensi QR Dosen di Board Kelas">
                                                                          <i class="fa-solid fa-camera"></i> Absen QR Board
                                                                      </button>

                                                                      <form action="{{ route('dosen.absensi.submit') }}" method="POST" class="inline" onsubmit="return confirm('Emergency Check-in: Gunakan fitur ini jika QR Board / Scanner TV bermasalah?')">
                                                                          @csrf
                                                                          <input type="hidden" name="agenda_id" value="{{ $ag->id }}">
                                                                          <button type="submit" class="px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-1.5" title="Emergency Check-in Manual tanpa scan QR Board">
                                                                              <i class="fa-solid fa-hand-pointer"></i> Emergency Check-in
                                                                          </button>
                                                                      </form>

                                                                      <span class="text-[11px] text-amber-800 font-medium bg-amber-50 border border-amber-200 px-2.5 py-1.5 rounded-lg flex items-center gap-1.5">
                                                                          <i class="fa-solid fa-circle-info text-amber-600"></i> Absen QR / Emergency Check-in untuk membuka fitur perkuliahan.
                                                                      </span>
                                                                  </div>
                                                             @endif

                                                            <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1.5 rounded-lg shrink-0 ml-auto">
                                                                <i class="fa-solid fa-user-check"></i>
                                                                {{ $ag->absensi->count() }} Mahasiswa Hadir
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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
                                                                        <p class="text-[10px] text-slate-500 font-semibold">{{ $ag->mata_kuliah }}</p>
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
                                                                    <label class="block text-slate-700 font-bold mb-1">Rencana Materi Sebelumnya</label>
                                                                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-600 text-xs italic">
                                                                        {{ $ag->catatan ?: 'Tidak ada catatan rencana.' }}
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-slate-700 font-bold mb-1">Materi / Realisasi yang Disampaikan <span class="text-rose-500">*</span></label>
                                                                    <textarea name="realisasi_pembelajaran" rows="4" required placeholder="Contoh: Praktikum manipulasi DOM dan asynchronous fetch data API, latihan mandiri membuat tabel interaktif..." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-amber-500/30 focus:border-amber-600 outline-none text-xs">{{ $ag->materi_realisasi }}</textarea>
                                                                </div>
                                                                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                                                    <button type="button" onclick="toggleModal('modal-dashboard-realisasi-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                                                                    <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg transition shadow-sm">
                                                                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Realisasi
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- MODAL: Berita Acara Perkuliahan Dashboard -->
                                                <div id="modal-dashboard-berita-acara-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                                                    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')"></div>
                                                    <div class="relative min-h-screen flex items-center justify-center p-4">
                                                        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden text-left border border-slate-100">
                                                            <div class="bg-indigo-50 border-b border-indigo-100 px-6 py-4 flex justify-between items-center text-slate-800">
                                                                <div class="flex items-center gap-2.5">
                                                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center">
                                                                        <i class="fa-solid fa-file-signature"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h3 class="font-bold text-sm text-slate-800">Berita Acara Perkuliahan</h3>
                                                                        <p class="text-[10px] text-slate-500 font-semibold">{{ $ag->mata_kuliah }}</p>
                                                                    </div>
                                                                </div>
                                                                <button type="button" onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')" class="text-slate-400 hover:text-slate-600 text-lg">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('dosen.agenda.berita-acara', $ag->id) }}" method="POST" class="p-6 space-y-4">
                                                                @csrf
                                                                @method('PUT')
                                                                <div>
                                                                    <label class="block text-slate-700 font-bold mb-1">Catatan / Berita Acara Pelaksanaan Kuliah <span class="text-rose-500">*</span></label>
                                                                    <textarea name="berita_acara" rows="5" required placeholder="Tuliskan berita acara (e.g. Perkuliahan praktikum berjalan tertib, seluruh mahasiswa hadir tepat waktu, software IDE berjalan lancar tanpa kendala perangkat lab)..." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-600 outline-none text-xs">{{ $ag->berita_acara }}</textarea>
                                                                </div>
                                                                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                                                    <button type="button" onclick="toggleModal('modal-dashboard-berita-acara-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                                                                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition shadow-sm">
                                                                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Berita Acara
                                                                    </button>
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
                                                                        <a href="{{ route('dosen.agenda.export-kehadiran', $ag->id) }}" target="_blank" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded text-[10px] font-bold uppercase flex items-center gap-1 transition">
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
                                                                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold rounded text-[10px] uppercase">
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
                    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="font-bold text-xs text-slate-800 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-check text-teal-800"></i> Jadwal Mengajar Lab Anda
                                </h3>
                                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Jadwal rutin mingguan dari Admin</p>
                            </div>
                            <span class="px-2 py-0.5 bg-teal-50 text-teal-800 border border-teal-200 rounded text-[10px] font-bold">
                                {{ isset($jadwalPenggunaanLab) ? $jadwalPenggunaanLab->count() : 0 }} Jadwal
                            </span>
                        </div>

                        @if(isset($jadwalPenggunaanLab) && $jadwalPenggunaanLab->count() > 0)
                            <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                                @foreach($jadwalPenggunaanLab as $j)
                                    @php
                                        $createdSessions = \App\Models\Agenda::where('jadwal_penggunaan_lab_id', $j->id)->count();
                                    @endphp
                                    <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl space-y-2 hover:border-teal-300 transition">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-xs text-slate-800 truncate max-w-[180px]">{{ $j->mata_kuliah }}</span>
                                            <span class="px-2 py-0.5 bg-teal-100 text-teal-800 rounded text-[9px] font-bold">Kelas {{ $j->kelas }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-[10px] text-slate-500 font-medium">
                                            <span><i class="fa-regular fa-clock mr-1 text-slate-400"></i>{{ $j->hari }}, {{ substr($j->jam_mulai,0,5) }}-{{ substr($j->jam_selesai,0,5) }}</span>
                                            <span class="text-teal-700 font-semibold"><i class="fa-solid fa-door-open mr-1"></i>{{ $j->lab->nama_lab ?? 'Lab' }}</span>
                                        </div>
                                        <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between text-[10px]">
                                            <span class="text-slate-500 font-medium">Status Pertemuan:</span>
                                            @if($createdSessions >= 16)
                                                <span class="font-bold text-emerald-700 flex items-center gap-1 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                                    <i class="fa-solid fa-circle-check text-emerald-600"></i> 16 Sesi Siap
                                                </span>
                                            @elseif($createdSessions > 0)
                                                <span class="font-bold text-teal-700 flex items-center gap-1 bg-teal-50 px-2 py-0.5 rounded border border-teal-200">
                                                    <i class="fa-solid fa-calendar-days text-teal-600"></i> {{ $createdSessions }} dari 16 Sesi
                                                </span>
                                            @else
                                                <span class="text-slate-400 italic bg-slate-100 px-2 py-0.5 rounded">
                                                    Disiapkan Admin
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-slate-400 text-xs italic">
                                Belum ada plotting jadwal lab untuk akun Anda.
                            </div>
                        @endif
                    </div>

                    <!-- Widget 2: Panduan Alur Perkuliahan Digital Board -->
                    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 space-y-3">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-2.5">
                            <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-800 flex items-center justify-center font-bold text-xs border border-teal-200">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <h4 class="font-bold text-xs text-slate-800">Alur Perkuliahan Digital Board</h4>
                        </div>
                        <ul class="space-y-2.5 text-[11px] text-slate-650 font-medium">
                            <li class="flex items-start gap-2.5 p-2 bg-teal-50/60 border border-teal-100 rounded-xl">
                                <span class="w-5 h-5 rounded-full bg-teal-800 text-white flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5 shadow-xs">1</span>
                                <div>
                                    <strong class="text-teal-900 font-bold block text-xs">Absen QR Board</strong>
                                    <span class="text-slate-600">Lakukan scan QR di papan lab untuk membuka fitur perkuliahan hari ini.</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-2.5 p-2 bg-indigo-50/60 border border-indigo-100 rounded-xl">
                                <span class="w-5 h-5 rounded-full bg-indigo-800 text-white flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5 shadow-xs">2</span>
                                <div>
                                    <strong class="text-indigo-900 font-bold block text-xs">Absensi Mahasiswa</strong>
                                    <span class="text-slate-600">Cek & input kehadiran, izin WhatsApp, atau alpa mahasiswa.</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-2.5 p-2 bg-amber-50/60 border border-amber-100 rounded-xl">
                                <span class="w-5 h-5 rounded-full bg-amber-800 text-white flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5 shadow-xs">3</span>
                                <div>
                                    <strong class="text-amber-900 font-bold block text-xs">Realisasi & Berita Acara</strong>
                                    <span class="text-slate-600">Catat pokok materi dan tuliskan Berita Acara perkuliahan resmi.</span>
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
                    <p class="text-[10px] text-slate-400 italic">Gunakan ini jika kamera HP Anda bermasalah atau tidak dapat diakses.</p>
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
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-bold">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-medium">Agenda</span>
        </a>
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-800 text-white rounded-2xl shadow-xl border-4 border-white">
            <button type="button" onclick="startDosenQRScanner()" class="flex items-center justify-center w-full h-full text-white bg-teal-800 rounded-xl hover:bg-teal-900 transition-all" title="Scan QR Presensi">
                <i class="fa-solid fa-qrcode text-2xl text-white"></i>
            </button>
        </div>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
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
</body>
</html>
