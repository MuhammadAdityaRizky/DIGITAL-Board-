<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Administrator Console</h2>
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
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold text-left group">
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

        <!-- Content scrollable -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Operational Cockpit Header -->
            <div class="bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white rounded-2xl p-5 sm:p-6 shadow-md border border-slate-800 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-teal-500/20 text-teal-300 border border-teal-400/30 tracking-wider uppercase flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                            {{ auth()->user()->isSuperAdmin() ? 'SUPER ADMIN COCKPIT' : 'ADMIN FAKULTAS • ' . strtoupper(auth()->user()->fakultas->nama_fakultas ?? 'FAKULTAS') }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">• {{ $todayFormatted }}</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white flex items-center gap-2">
                        <span>Menara Kontrol Operasional Laboratorium</span>
                    </h2>
                    <p class="text-xs text-slate-300 font-medium">
                        Pemantauan real-time ketersediaan lab, kehadiran dosen, jadwal sesi praktikum, dan Smart Board TV kampus.
                    </p>
                </div>

                <!-- Header Actions -->
                <div class="flex items-center gap-2.5 flex-wrap self-stretch sm:self-auto">
                    <button type="button" onclick="toggleModal('modal-quick-announcement')" class="px-3.5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                        <i class="fa-solid fa-bullhorn"></i> Siarkan ke TV Lab
                    </button>
                    <a href="{{ route('board') }}" target="_blank" class="px-3.5 py-2.5 bg-teal-700 hover:bg-teal-600 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                        <i class="fa-solid fa-tv"></i> Buka Smart Board
                    </a>
                </div>
            </div>

            <!-- 4 Metrik Operasional Real-Time -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                <!-- Lab Aktif Sekarang -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-slate-300 transition flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl {{ $labAktifSaatIni > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center font-bold text-lg shrink-0">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ruang Lab Aktif</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-800 leading-tight">{{ $labAktifSaatIni }} <span class="text-xs font-semibold text-slate-400">/ {{ $laboratoriums->count() }} Lab</span></p>
                        <p class="text-[10px] font-medium {{ $labAktifSaatIni > 0 ? 'text-emerald-600' : 'text-slate-500' }}">
                            {{ $labAktifSaatIni > 0 ? '● Sedang dipakai perkuliahan' : 'Semua lab sedang standby' }}
                        </p>
                    </div>
                </div>

                <!-- Sesi Praktikum Hari Ini -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-slate-300 transition flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg shrink-0">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sesi Hari Ini</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-800 leading-tight">{{ $totalSesiHariIni }} <span class="text-xs font-semibold text-slate-400">Sesi</span></p>
                        <p class="text-[10px] font-medium text-slate-500">
                            {{ $agendasToday->count() > 0 ? 'Sesi mulai ' . substr($agendasToday->first()->jam_mulai, 0, 5) : 'Tidak ada jadwal hari ini' }}
                        </p>
                    </div>
                </div>

                <!-- Kehadiran Mahasiswa -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-slate-300 transition flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-lg shrink-0">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Presensi Mahasiswa</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-800 leading-tight">{{ $todayHadir }} <span class="text-xs font-semibold text-teal-600 font-bold">({{ $attendanceRate }}%)</span></p>
                        <p class="text-[10px] font-medium text-slate-500">
                            {{ $todayIzin }} Izin • {{ $todayAlpa }} Alpa
                        </p>
                    </div>
                </div>

                <!-- Siaran TV Lab Aktif -->
                <a href="{{ route('admin.pengumuman') }}" class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs hover:border-slate-300 transition flex items-center gap-3.5 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 group-hover:bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-lg shrink-0 transition">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Siaran TV Lab</p>
                        <p class="text-xl sm:text-2xl font-black text-slate-800 leading-tight">{{ $pengumumanAktifCount }} <span class="text-xs font-semibold text-slate-400">Aktif</span></p>
                        <p class="text-[10px] font-medium text-slate-500">
                            {{ $pengumumanAktifCount > 0 ? 'Sedang tayang di TV lab' : 'Tidak ada siaran aktif' }}
                        </p>
                    </div>
                </a>
            </div>

            <!-- Dashboard Split Layout -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Left 2 Columns: Live Lab Occupancy & Timeline -->
                <div class="xl:col-span-2 space-y-6">

                    <!-- SECTION 1: Status Real-Time Laboratorium -->
                    <div class="bg-white border border-slate-200/90 shadow-sm rounded-2xl overflow-hidden">
                        <div class="bg-slate-50/70 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-network-wired"></i>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-sm text-slate-800">Status Real-Time Laboratorium</h3>
                                    <p class="text-[10px] text-slate-400">Kondisi fisik ruangan & sesi kuliah yang sedang aktif saat ini</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-slate-100 text-slate-600 border border-slate-200">
                                {{ $laboratoriums->count() }} Total Lab
                            </span>
                        </div>

                        <div class="p-6">
                            @if(count($labStatusList) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($labStatusList as $item)
                                        @php
                                            $lab = $item['lab'];
                                            $isOccupied = $item['is_occupied'];
                                            $cur = $item['current_agenda'];
                                            $nxt = $item['next_agenda'];
                                        @endphp
                                        <div class="rounded-2xl border p-4.5 transition relative overflow-hidden flex flex-col justify-between gap-4 {{ $isOccupied ? 'border-emerald-300 bg-emerald-50/20 shadow-xs' : 'border-slate-200 bg-slate-50/40 hover:border-slate-300' }}">
                                            <div>
                                                <!-- Lab Header & Live Badge -->
                                                <div class="flex items-center justify-between pb-3 border-b border-slate-200/60">
                                                    <div>
                                                        <h4 class="font-black text-sm text-slate-800 flex items-center gap-2">
                                                            <span>{{ $lab->nama_lab }}</span>
                                                            @if($lab->fakultas)
                                                                <span class="text-[9px] font-semibold text-slate-400">({{ $lab->fakultas->nama_fakultas }})</span>
                                                            @endif
                                                        </h4>
                                                        <span class="text-[10px] text-slate-500 font-medium">
                                                            <i class="fa-solid fa-desktop text-slate-400 mr-1"></i> Kapasitas: <b>{{ $lab->kapasitas ?? 40 }} PC</b>
                                                        </span>
                                                    </div>
                                                    @if($isOccupied)
                                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300 flex items-center gap-1.5 uppercase tracking-wide">
                                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                                            Sedang Kuliah
                                                        </span>
                                                    @else
                                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-200/70 text-slate-600 border border-slate-300/60 uppercase tracking-wide">
                                                            Standby / Kosong
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Lab Content Detail -->
                                                <div class="pt-3 text-xs space-y-2">
                                                    @if($isOccupied && $cur)
                                                        <div>
                                                            <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Mata Kuliah Berjalan:</span>
                                                            <strong class="text-slate-900 font-bold text-xs block mt-0.5">{{ $cur->mata_kuliah }}</strong>
                                                            <span class="text-[11px] text-slate-600 font-medium">
                                                                Kelas {{ $cur->kelas }} • {{ $cur->program_kuliah ?? 'Reguler' }}
                                                            </span>
                                                        </div>
                                                        <div class="p-2.5 bg-white rounded-xl border border-slate-200/70 space-y-1 text-[11px]">
                                                            <div class="flex items-center justify-between">
                                                                <span class="text-slate-500">Dosen Pengampu:</span>
                                                                <span class="font-bold text-slate-800">{{ $cur->dosen?->nama ?? 'Dosen Pengampu' }}</span>
                                                            </div>
                                                            <div class="flex items-center justify-between">
                                                                <span class="text-slate-500">Waktu Praktikum:</span>
                                                                <span class="font-bold text-slate-800 font-mono">{{ substr($cur->jam_mulai, 0, 5) }} - {{ substr($cur->jam_selesai, 0, 5) }} WIB</span>
                                                            </div>
                                                            <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                                                                <span class="text-slate-500">Check-in Dosen:</span>
                                                                @if($cur->dosen_waktu_masuk)
                                                                    <span class="px-1.5 py-0.2 rounded text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                                        <i class="fa-solid fa-check mr-0.5"></i> Hadir ({{ substr($cur->dosen_waktu_masuk, 11, 5) }})
                                                                    </span>
                                                                @else
                                                                    <span class="px-1.5 py-0.2 rounded text-[9px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                                                        <i class="fa-solid fa-clock mr-0.5"></i> Belum Check-in
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="py-2 space-y-1.5">
                                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Agenda Terdekat Berikutnya:</span>
                                                            @if($nxt)
                                                                <div class="p-2.5 bg-white rounded-xl border border-slate-200/70 text-[11px]">
                                                                    <strong class="text-slate-800 font-bold block">{{ $nxt->mata_kuliah }}</strong>
                                                                    <div class="flex items-center justify-between text-slate-500 mt-1">
                                                                        <span><i class="fa-regular fa-calendar text-teal-600 mr-1"></i> {{ $nxt->tanggal == date('Y-m-d') ? 'Hari Ini' : \Carbon\Carbon::parse($nxt->tanggal)->format('d M Y') }}</span>
                                                                        <span class="font-bold font-mono text-slate-700">{{ substr($nxt->jam_mulai, 0, 5) }} - {{ substr($nxt->jam_selesai, 0, 5) }}</span>
                                                                    </div>
                                                                    <span class="text-[10px] text-slate-500 block mt-0.5">Dosen: {{ $nxt->dosen?->nama ?? '-' }}</span>
                                                                </div>
                                                            @else
                                                                <p class="text-slate-400 italic text-[11px]">Tidak ada jadwal perkuliahan terdekat untuk lab ini.</p>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Lab Card Footer Actions -->
                                            <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between">
                                                <a href="{{ route('board.lab', $lab->id) }}" target="_blank" class="text-xs text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1">
                                                    <i class="fa-solid fa-tv"></i> Buka Layar Lab <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                                </a>
                                                <a href="{{ route('admin.agenda', ['lab_id' => $lab->id]) }}" class="text-[11px] text-slate-500 hover:text-slate-800 font-medium">
                                                    Jadwal Lab &rarr;
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-slate-400">
                                    <i class="fa-solid fa-door-closed text-3xl mb-2 text-slate-300"></i>
                                    <p class="font-medium text-xs">Belum ada laboratorium terdaftar dalam sistem.</p>
                                    <a href="{{ route('admin.laboratorium') }}" class="inline-block mt-2 px-3.5 py-1.5 bg-teal-800 text-white rounded-lg font-bold text-xs">Tambah Laboratorium</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- SECTION 2: Timeline Jadwal Praktikum Hari Ini & Terdekat -->
                    <div class="bg-white border border-slate-200/90 shadow-sm rounded-2xl overflow-hidden">
                        <div class="bg-slate-50/70 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-timeline"></i>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-sm text-slate-800">Timeline Perkuliahan Praktikum</h3>
                                    <p class="text-[10px] text-slate-400">Urutan sesi kuliah hari ini & jadwal terdekat mendatang</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.agenda') }}" class="text-xs text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1">
                                Kelola Semua Agenda &rarr;
                            </a>
                        </div>

                        <div class="p-6">
                            @if($agendasToday->count() > 0)
                                <div class="space-y-3">
                                    @foreach($agendasToday as $agenda)
                                        @php
                                            $nowTime = date('H:i:s');
                                            $isLive = ($agenda->jam_mulai <= $nowTime && $agenda->jam_selesai >= $nowTime);
                                            $isPassed = ($agenda->jam_selesai < $nowTime);
                                        @endphp
                                        <div class="p-4 rounded-2xl border transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 {{ $isLive ? 'border-emerald-300 bg-emerald-50/30 ring-1 ring-emerald-200' : ($isPassed ? 'border-slate-200 bg-slate-50/50 opacity-75' : 'border-slate-200 bg-white hover:border-slate-300') }}">
                                            <div class="flex items-start gap-3">
                                                <div class="p-2.5 rounded-xl {{ $isLive ? 'bg-emerald-600 text-white' : ($isPassed ? 'bg-slate-200 text-slate-600' : 'bg-indigo-50 text-indigo-600') }} font-mono font-bold text-xs text-center shrink-0">
                                                    <span>{{ substr($agenda->jam_mulai, 0, 5) }}</span>
                                                    <span class="block text-[9px] opacity-75">- {{ substr($agenda->jam_selesai, 0, 5) }}</span>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <h4 class="font-extrabold text-xs text-slate-900">{{ $agenda->mata_kuliah }}</h4>
                                                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                            <i class="fa-solid fa-location-dot text-teal-600 mr-0.5"></i> {{ $agenda->lab?->nama_lab ?? 'Lab' }}
                                                        </span>
                                                        <span class="text-[10px] text-slate-500 font-medium">Kelas {{ $agenda->kelas }}</span>
                                                    </div>
                                                    <p class="text-[11px] text-slate-600 mt-1">
                                                        Dosen: <b>{{ $agenda->dosen?->nama ?? 'Dosen Pengampu' }}</b>
                                                        @if($agenda->dosen_waktu_masuk)
                                                            <span class="text-emerald-700 font-semibold ml-2"><i class="fa-solid fa-circle-check"></i> Hadir ({{ substr($agenda->dosen_waktu_masuk, 11, 5) }})</span>
                                                        @else
                                                            <span class="text-amber-700 font-semibold ml-2"><i class="fa-solid fa-clock"></i> Belum Check-in</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="shrink-0 flex items-center gap-2">
                                                @if($isLive)
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1 uppercase">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> Live Now
                                                    </span>
                                                @elseif($isPassed)
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600 uppercase">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase">
                                                        Akan Datang
                                                    </span>
                                                @endif
                                                <a href="{{ route('admin.absensi') }}" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                                    Absensi
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Empty state for today + Upcoming Schedule preview -->
                                <div class="space-y-4">
                                    <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl text-center space-y-1">
                                        <p class="text-xs font-bold text-slate-700">Hari ini tidak ada sesi praktikum yang terjadwal.</p>
                                        <p class="text-[11px] text-slate-500">Seluruh ruangan laboratorium saat ini berada dalam status standby / bebas praktikum.</p>
                                    </div>

                                    @if($agendasUpcoming->count() > 0)
                                        <div class="space-y-2">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Jadwal Praktikum Terdekat Berikutnya:</span>
                                            <div class="divide-y divide-slate-100 rounded-xl border border-slate-200 overflow-hidden">
                                                @foreach($agendasUpcoming as $up)
                                                    <div class="p-3 bg-white hover:bg-slate-50 flex items-center justify-between gap-3 text-xs transition">
                                                        <div class="flex items-center gap-3">
                                                            <div class="p-2 rounded-lg bg-teal-50 text-teal-800 font-bold font-mono text-[11px] shrink-0 text-center">
                                                                {{ \Carbon\Carbon::parse($up->tanggal)->format('d M') }}
                                                                <span class="block text-[9px] text-slate-500 font-sans">{{ substr($up->jam_mulai, 0, 5) }}</span>
                                                            </div>
                                                            <div>
                                                                <h5 class="font-bold text-slate-800">{{ $up->mata_kuliah }}</h5>
                                                                <p class="text-[10px] text-slate-500">
                                                                    {{ $up->lab?->nama_lab }} • Kelas {{ $up->kelas }} • Dosen: {{ $up->dosen?->nama ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('admin.agenda') }}" class="text-[11px] text-teal-700 font-bold hover:underline">Detail</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- SECTION 3: Aktivitas Presensi Terbaru -->
                    <div class="bg-white border border-slate-200/90 shadow-sm rounded-2xl overflow-hidden">
                        <div class="bg-slate-50/70 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                            <div>
                                <h3 class="font-extrabold text-sm text-slate-800">Log Presensi Mahasiswa Hari Ini</h3>
                                <p class="text-[10px] text-slate-400">Catatan mahasiswa yang memindai QR code Smart Board di laboratorium</p>
                            </div>
                            <a href="{{ route('admin.absensi') }}" class="text-xs text-teal-700 hover:text-teal-900 font-bold">Lihat Semua Laporan &rarr;</a>
                        </div>
                        <div class="p-6">
                            @if($recentAbsensi->count() > 0)
                                <div class="overflow-x-auto text-xs">
                                    <table class="w-full text-left text-slate-600">
                                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                                            <tr>
                                                <th class="p-3">Nama / NIM</th>
                                                <th class="p-3">Mata Kuliah / Lab</th>
                                                <th class="p-3">Waktu Scan</th>
                                                <th class="p-3 text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($recentAbsensi as $abs)
                                                <tr class="hover:bg-slate-50/50 transition">
                                                    <td class="p-3">
                                                        <span class="font-bold text-slate-800 block">{{ $abs->mahasiswa->nama_lengkap ?? ($abs->mahasiswa->user->username ?? '-') }}</span>
                                                        <span class="text-[9px] font-mono text-slate-400">{{ $abs->mahasiswa->nim ?? '-' }}</span>
                                                    </td>
                                                    <td class="p-3">
                                                        <span class="font-semibold text-slate-700 block">{{ $abs->agenda->mata_kuliah ?? '-' }}</span>
                                                        <span class="text-[9px] text-slate-450"><i class="fa-solid fa-location-dot mr-1"></i> {{ $abs->agenda->lab->nama_lab ?? 'Lab' }}</span>
                                                    </td>
                                                    <td class="p-3 font-mono text-slate-500">{{ $abs->waktu_masuk ?? '-' }}</td>
                                                    <td class="p-3 text-center">
                                                        @php
                                                            $st = strtolower($abs->status_kehadiran);
                                                        @endphp
                                                        @if($st === 'hadir')
                                                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold rounded text-[9px] uppercase">Hadir</span>
                                                        @elseif($st === 'izin')
                                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-800 border border-blue-200 font-bold rounded text-[9px] uppercase">Izin</span>
                                                        @else
                                                            <span class="px-2 py-0.5 bg-rose-100 text-rose-800 border border-rose-200 font-bold rounded text-[9px] uppercase">Alpa</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center py-6 text-slate-400 italic text-xs">Belum ada aktivitas presensi masuk mahasiswa hari ini.</p>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Right 1 Column: Action Center & Alerts -->
                <div class="space-y-6">

                    <!-- PUSAT AKSI TANGGAP CEPAT (ACTION CENTER) -->
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-sm space-y-4">
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                            <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-sm text-slate-800">Pusat Aksi Cepat Lab</h3>
                                <p class="text-[10px] text-slate-400">Tindakan operasional harian lapangan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-2.5 text-xs font-semibold">
                            <!-- 1. Siaran Pengumuman Cepat -->
                            <button type="button" onclick="toggleModal('modal-quick-announcement')" class="p-3 bg-amber-500/10 hover:bg-amber-500/20 text-amber-900 border border-amber-300/60 rounded-xl flex items-center justify-between transition cursor-pointer text-left group">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs shrink-0">
                                        <i class="fa-solid fa-bullhorn"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold block text-slate-800">Siarkan Pengumuman TV Lab</span>
                                        <span class="text-[10px] font-normal text-slate-500">Tampilkan teks darurat di layar lab</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-slate-400 group-hover:translate-x-0.5 transition"></i>
                            </button>

                            <!-- 2. Tambah Jadwal Lab Darurat -->
                            <a href="{{ route('admin.agenda') }}" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition text-slate-800 group">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs shrink-0">
                                        <i class="fa-solid fa-calendar-plus"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold block">Tambah / Atur Jadwal Lab</span>
                                        <span class="text-[10px] font-normal text-slate-500">Booking sesi praktikum baru</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-slate-400 group-hover:translate-x-0.5 transition"></i>
                            </a>

                            <!-- 3. Buka Display Smart Board TV -->
                            <a href="{{ route('board') }}" target="_blank" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition text-slate-800 group">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-teal-700 text-white flex items-center justify-center text-xs shrink-0">
                                        <i class="fa-solid fa-tv"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold block">Buka Portal Display Board</span>
                                        <span class="text-[10px] font-normal text-slate-500">Layar interaktif Smart Board lab</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                            </a>

                            <!-- 4. Laporan Kehadiran & Berita Acara -->
                            <a href="{{ route('admin.absensi') }}" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition text-slate-800 group">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs shrink-0">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold block">Laporan & Rekap Kehadiran</span>
                                        <span class="text-[10px] font-normal text-slate-500">Cetak berita acara & absensi</span>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-slate-400 group-hover:translate-x-0.5 transition"></i>
                            </a>
                        </div>
                    </div>

                    <!-- RINGKASAN STATUS SISTEM & SERVER -->
                    <div class="bg-slate-900 text-white rounded-2xl p-5 shadow-sm space-y-3 text-xs">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2.5">
                            <span class="text-[10px] font-bold text-teal-400 uppercase tracking-wider">Status Server Smart Board</span>
                            <span class="px-2 py-0.5 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded text-[9px] font-bold">ONLINE</span>
                        </div>
                        <div class="space-y-1.5 text-[11px] text-slate-300">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Total Akun Terdaftar:</span>
                                <span class="font-bold font-mono text-white">{{ $usersCount }} User</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Dosen Pengajar:</span>
                                <span class="font-bold font-mono text-white">{{ $dosenCount }} Dosen</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Mahasiswa Terdaftar:</span>
                                <span class="font-bold font-mono text-white">{{ $mhsCount }} Mahasiswa</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <!-- MODAL SIARAN PENGUMUMAN CEPAT KE TV LAB -->
    <div id="modal-quick-announcement" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 space-y-4 text-left animate-in fade-in zoom-in duration-150">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm text-slate-800">Siarkan Pengumuman ke TV Lab</h3>
                        <p class="text-[10px] text-slate-400">Teks akan langsung tampil di layar Smart Board laboratorium</p>
                    </div>
                </div>
                <button type="button" onclick="toggleModal('modal-quick-announcement')" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">&times;</button>
            </div>

            <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-3.5 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Judul Pengumuman</label>
                    <input type="text" name="judul" required placeholder="Contoh: Perhatian Praktikum Diundur / Ruangan AC Maintenance" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none font-medium">
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Isi Pengumuman</label>
                    <textarea name="isi_pengumuman" required rows="3" placeholder="Tulis rincian pesan yang ingin ditampilkan ke mahasiswa di layar TV lab..." class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none font-medium"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Mulai Tayang</label>
                        <input type="date" name="tanggal_mulai" value="{{ date('Y-m-d') }}" class="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Selesai Tayang</label>
                        <input type="date" name="tanggal_selesai" value="{{ date('Y-m-d') }}" class="w-full p-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-amber-500/20 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Target Laboratorium (Pilih Lab TV Tujuan)</label>
                    <div class="space-y-1.5 max-h-32 overflow-y-auto p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                        @foreach($laboratoriums as $lb)
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-white p-1 rounded-lg transition">
                                <input type="checkbox" name="laboratorium_ids[]" value="{{ $lb->id }}" checked class="rounded text-amber-600 focus:ring-amber-500">
                                <span class="font-bold text-slate-700">{{ $lb->nama_lab }}</span>
                                @if($lb->fakultas)
                                    <span class="text-[10px] text-slate-400">({{ $lb->fakultas->nama_fakultas }})</span>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-quick-announcement')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-paper-plane"></i> Siarkan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle Modal Helper Script -->
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }
    </script>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

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

            @if(isset($errors) && $errors->any() && !session('success') && !session('error') && !session('failed'))
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

                    const fileInput = form.querySelector('input[type="file"]');
                    if (fileInput && fileInput.required && fileInput.files && fileInput.files.length === 0) {
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

        // Profile Dropdown Handler
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const menu = document.getElementById('profileDropdownMenu');
            const button = event.target.closest('button[onclick="toggleProfileDropdown(event)"]');
            if (menu && !menu.classList.contains('hidden') && !button && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>




