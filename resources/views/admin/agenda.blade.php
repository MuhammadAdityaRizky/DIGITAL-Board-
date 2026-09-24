<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Agenda - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Pusat Jadwal & Perkuliahan</h2>
                <!-- Tab Switching Navigation (Analyst Recommendation #4) -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs">
                    <a href="{{ route('admin.jadwal-lab') }}" class="px-3.5 py-1.5 text-slate-600 hover:text-slate-900 font-medium rounded-lg transition flex items-center gap-1.5">
                        <i class="fa-solid fa-table-cells text-slate-400"></i> Matriks Jadwal Lab
                    </a>
                    <a href="{{ route('admin.agenda') }}" class="px-3.5 py-1.5 bg-teal-800 text-white font-bold rounded-lg shadow-sm flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days text-teal-300"></i> Agenda & Realisasi
                    </a>
                </div>
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
                            {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : 'Admin Fakultas' }}
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

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm w-full">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search & Filter Bar -->
            <div class="bg-white border border-slate-200/80 rounded-xl p-4 shadow-xs w-full">
                <form action="{{ route('admin.agenda') }}" method="GET" class="space-y-3 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
                        <!-- Search (col-span-4) -->
                        <div class="lg:col-span-4">
                            <label class="block text-slate-600 font-semibold mb-1">Cari Agenda / Dosen</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mata kuliah, nama dosen..." class="w-full pl-8 pr-3 py-2 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition placeholder:text-slate-400">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Fakultas Filter (col-span-3) -->
                        <div class="lg:col-span-3">
                            <label class="block text-slate-600 font-semibold mb-1">Fakultas</label>
                            @if(auth()->user()->isSuperAdmin())
                                <select name="fakultas_id" onchange="this.form.submit()" class="w-full py-2 px-3 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition font-medium">
                                    <option value="">-- Semua Fakultas --</option>
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}" {{ request('fakultas_id') == $f->id ? 'selected' : '' }}>
                                            {{ $f->nama_fakultas }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <div class="w-full py-2 px-3 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold flex items-center justify-between" title="Fakultas Anda Terkunci">
                                    <span class="truncate">{{ $userFakultas->nama_fakultas ?? 'Fakultas Terkunci' }}</span>
                                    <span class="text-[10px] text-slate-500 bg-slate-200/80 px-1.5 py-0.5 rounded font-mono shrink-0 ml-1">
                                        <i class="fa-solid fa-lock text-[9px] mr-0.5"></i> Locked
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Ruang Lab (col-span-3) -->
                        <div class="lg:col-span-3">
                            <label class="block text-slate-600 font-semibold mb-1">Ruang Lab</label>
                            <select name="lab_id" class="w-full py-2 px-3 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition">
                                <option value="">-- Semua Ruang Lab --</option>
                                @foreach($labs as $l)
                                    <option value="{{ $l->id }}" {{ request('lab_id') == $l->id ? 'selected' : '' }}>
                                        {{ strtoupper($l->nama_lab) }}@if(auth()->user()->isSuperAdmin() && !request('fakultas_id') && $l->fakultas) ({{ $l->fakultas->nama_fakultas }})@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter & Reset Buttons (col-span-2) -->
                        <div class="lg:col-span-2 flex items-center gap-2">
                            <button type="submit" class="flex-1 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-semibold transition-all shadow-xs flex items-center justify-center gap-1 cursor-pointer">
                                <i class="fa-solid fa-filter text-xs"></i> Filter
                            </button>
                            @if(request()->anyFilled(['search', 'fakultas_id', 'lab_id', 'prodi_id', 'status_agenda', 'pertemuan', 'tanggal', 'sort']))
                                <a href="{{ route('admin.agenda') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-semibold transition-all border border-slate-200 text-center flex items-center justify-center" title="Reset Filter">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2 Filters: Prodi, Status, Pertemuan, Tanggal, Urutan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end pt-2.5 border-t border-slate-100">
                        <!-- Program Studi (col-span-3) -->
                        <div class="lg:col-span-3">
                            <label class="block text-slate-600 font-semibold mb-1">Program Studi</label>
                            <select name="prodi_id" class="w-full py-2 px-3 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition">
                                <option value="">-- Semua Prodi --</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->id }}" {{ request('prodi_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_prodi }}@if(auth()->user()->isSuperAdmin() && !request('fakultas_id') && $p->fakultas) ({{ $p->fakultas->nama_fakultas }})@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Agenda (col-span-3) -->
                        <div class="lg:col-span-3">
                            <label class="block text-slate-600 font-semibold mb-1">Status Agenda</label>
                            <select name="status_agenda" class="w-full py-2 px-3 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition font-medium">
                                <option value="">Semua Status</option>
                                <option value="Berlangsung" {{ request('status_agenda') == 'Berlangsung' ? 'selected' : '' }}>🟢 Sedang Berlangsung</option>
                                <option value="hari_ini" {{ request('status_agenda') == 'hari_ini' ? 'selected' : '' }}>📅 Hari Ini</option>
                                <option value="Akan Datang" {{ request('status_agenda') == 'Akan Datang' ? 'selected' : '' }}>⏳ Akan Datang</option>
                            </select>
                        </div>

                        <!-- Filter Pertemuan (col-span-2) -->
                        <div class="lg:col-span-2">
                            <label class="block text-slate-600 font-semibold mb-1">Pertemuan Sesi</label>
                            <select name="pertemuan" class="w-full py-2 px-3 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition">
                                <option value="">Semua (1 - 16)</option>
                                @for($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}" {{ request('pertemuan') == $i ? 'selected' : '' }}>
                                        Pertemuan {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Tanggal (col-span-2) -->
                        <div class="lg:col-span-2">
                            <label class="block text-slate-600 font-semibold mb-1">Tanggal Praktikum</label>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full py-2 px-3 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition">
                        </div>

                        <!-- Urutan (col-span-2) -->
                        <div class="lg:col-span-2">
                            <label class="block text-slate-600 font-semibold mb-1">Urutan Tanggal</label>
                            <select name="sort" onchange="this.form.submit()" class="w-full py-2 px-3 rounded-lg bg-slate-50/80 border border-slate-200 focus:bg-white focus:ring-1 focus:ring-teal-700 focus:border-teal-700 outline-none text-xs transition font-medium cursor-pointer">
                                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>📅 Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>📅 Terlama</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            @php
                $queryParamsWithoutStatus = request()->except(['status_agenda', 'page']);
                $urlSemua = route('admin.agenda', $queryParamsWithoutStatus);
                $urlBerlangsung = route('admin.agenda', array_merge($queryParamsWithoutStatus, ['status_agenda' => 'Berlangsung']));
                $urlHariIni = route('admin.agenda', array_merge($queryParamsWithoutStatus, ['status_agenda' => 'hari_ini']));
                $urlAkanDatang = route('admin.agenda', array_merge($queryParamsWithoutStatus, ['status_agenda' => 'Akan Datang']));
            @endphp

            <!-- QUICK STATUS FILTER BAR WITH BORDER ATAS & BORDER BAWAH -->
            <div class="bg-white border-y border-slate-200/90 py-3.5 px-4 rounded-xl shadow-xs flex flex-wrap items-center justify-between gap-3">
                <!-- Status Filter Pills -->
                <div class="flex items-center gap-1.5 flex-wrap text-xs">
                    <span class="text-slate-500 font-bold text-[11px] uppercase tracking-wider mr-1">Filter Cepat:</span>
                    <a href="{{ $urlSemua }}" 
                       class="px-3 py-1.5 rounded-lg font-semibold transition flex items-center gap-1.5 {{ !request()->filled('status_agenda') ? 'bg-slate-800 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 cursor-pointer' }}"
                       title="Tampilkan Semua Agenda">
                        <span>Semua</span>
                        <span class="px-1.5 py-0.2 text-[10px] rounded-full {{ !request()->filled('status_agenda') ? 'bg-slate-700 text-slate-200' : 'bg-white text-slate-600 border border-slate-200' }}">{{ $counts['total'] ?? 0 }}</span>
                    </a>

                    <a href="{{ $urlBerlangsung }}" 
                       class="px-3 py-1.5 rounded-lg font-semibold transition flex items-center gap-1.5 {{ request('status_agenda') == 'Berlangsung' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/70 cursor-pointer' }}"
                       title="Filter Hanya yang Sedang Berlangsung Saat Ini">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 {{ ($counts['berlangsung'] ?? 0) > 0 ? 'animate-pulse' : '' }}"></span>
                        <span>Sedang Berlangsung</span>
                        <span class="px-1.5 py-0.2 text-[10px] rounded-full {{ request('status_agenda') == 'Berlangsung' ? 'bg-emerald-800 text-emerald-100' : 'bg-white text-emerald-700 border border-emerald-200' }}">{{ $counts['berlangsung'] ?? 0 }}</span>
                    </a>

                    <a href="{{ $urlHariIni }}" 
                       class="px-3 py-1.5 rounded-lg font-semibold transition flex items-center gap-1.5 {{ request('status_agenda') == 'hari_ini' ? 'bg-teal-800 text-white shadow-xs' : 'bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200/70 cursor-pointer' }}"
                       title="Filter Jadwal Kuliah Hari Ini">
                        <i class="fa-regular fa-calendar-check text-[11px]"></i>
                        <span>Hari Ini</span>
                        <span class="px-1.5 py-0.2 text-[10px] rounded-full {{ request('status_agenda') == 'hari_ini' ? 'bg-teal-900 text-teal-100' : 'bg-white text-teal-700 border border-teal-200' }}">{{ $counts['hari_ini'] ?? 0 }}</span>
                    </a>

                    <a href="{{ $urlAkanDatang }}" 
                       class="px-3 py-1.5 rounded-lg font-semibold transition flex items-center gap-1.5 {{ request('status_agenda') == 'Akan Datang' ? 'bg-blue-700 text-white shadow-xs' : 'bg-blue-50 hover:bg-blue-100 text-blue-800 border border-blue-200/70 cursor-pointer' }}"
                       title="Filter Jadwal Mendatang">
                        <i class="fa-regular fa-clock text-[11px]"></i>
                        <span>Akan Datang</span>
                        <span class="px-1.5 py-0.2 text-[10px] rounded-full {{ request('status_agenda') == 'Akan Datang' ? 'bg-blue-800 text-blue-100' : 'bg-white text-blue-700 border border-blue-200' }}">{{ $counts['akan_datang'] ?? 0 }}</span>
                    </a>
                </div>

                <!-- Role & Scope Context Badge -->
                <div class="text-[11px] font-medium flex items-center gap-2">
                    @if(auth()->user()->isSuperAdmin())
                        <span class="px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-200 rounded-lg flex items-center gap-1.5 font-semibold">
                            <i class="fa-solid fa-shield-halved text-teal-700"></i> Super Admin (Akses Seluruh Fakultas & Lab)
                        </span>
                    @else
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-lg flex items-center gap-1.5 font-semibold">
                            <i class="fa-solid fa-building-columns text-slate-500"></i> {{ $userFakultas->nama_fakultas ?? 'Fakultas' }} • {{ $labs->count() }} Lab Naungan
                        </span>
                    @endif
                </div>
            </div>

            <!-- SECTION HIGHLIGHT: MATKUL SEDANG BERLANGSUNG -->
            @if(isset($liveAgendas) && $liveAgendas->count() > 0)
            <div class="bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-emerald-500/10 border-y-2 border-emerald-500/80 rounded-2xl p-4.5 sm:p-5 shadow-xs space-y-3.5">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-600"></span>
                        </span>
                        <h4 class="font-black text-xs sm:text-sm text-emerald-950 uppercase tracking-wide flex items-center gap-2">
                            <span>Mata Kuliah Sedang Berlangsung</span>
                            <span class="px-2 py-0.5 bg-emerald-600 text-white rounded-full text-[10px] font-bold">{{ $liveAgendas->count() }} Kelas Aktif</span>
                        </h4>
                    </div>
                    <span class="text-[11px] text-emerald-800 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-clock text-emerald-600"></i> Live Monitor Realtime
                    </span>
                </div>

                <!-- Live Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3.5">
                    @foreach($liveAgendas as $live)
                        @php
                            $livePertemuan = '-';
                            if ($live->catatan && preg_match('/Pertemuan\s*(?:ke-)?(\d+)/i', $live->catatan, $lm)) {
                                $livePertemuan = $lm[1];
                            }
                            $liveLab = $live->lab;
                            $liveFakultas = $liveLab?->fakultas;
                        @endphp
                        <div class="bg-white border border-emerald-200/90 rounded-xl p-4 shadow-sm hover:shadow-md transition-all space-y-3 flex flex-col justify-between">
                            <div>
                                <!-- Header Badges -->
                                <div class="flex items-center justify-between gap-2 flex-wrap mb-2">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-900 border border-emerald-300 rounded text-[10px] font-extrabold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span> BERLANGSUNG
                                        </span>
                                        @if(auth()->user()->isSuperAdmin() && $liveFakultas)
                                            <span class="px-2 py-0.5 bg-teal-50 text-teal-900 border border-teal-200 rounded text-[10px] font-bold flex items-center gap-1" title="Fakultas {{ $liveFakultas->nama_fakultas }}">
                                                <i class="fa-solid fa-building-columns text-[9px] text-teal-700"></i>
                                                {{ $liveFakultas->nama_fakultas }}
                                            </span>
                                        @endif
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-800 border border-slate-200 rounded text-[10px] font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-flask text-[9px] text-teal-700"></i>
                                            {{ $liveLab->nama_lab ?? 'Lab' }}
                                        </span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                        Kelas {{ $live->kelas ?: '-' }}
                                    </span>
                                </div>

                                <!-- Course Title -->
                                <h5 class="font-bold text-slate-900 text-sm tracking-tight leading-snug line-clamp-2">
                                    {{ $live->mata_kuliah }}
                                </h5>

                                <!-- Info Meta -->
                                <div class="mt-2.5 space-y-1 text-xs text-slate-600">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-user-tie text-[11px] text-slate-400 w-4"></i>
                                        <span class="truncate font-medium text-slate-800">{{ $live->dosenPengampu->nama ?? $live->dosen->nama ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 font-mono text-[11px] text-slate-500">
                                        <i class="fa-regular fa-clock text-[11px] text-teal-600 w-4"></i>
                                        <span class="font-semibold text-teal-800">{{ substr($live->jam_mulai,0,5) }} - {{ substr($live->jam_selesai,0,5) }} WIB</span>
                                        <span>•</span>
                                        <span>Pertemuan {{ $livePertemuan }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Actions -->
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                                <span class="text-[10px] text-slate-400">{{ $live->jurusan ?? 'Prodi' }}</span>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.absensi.input', $live->id) }}" class="px-2.5 py-1 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-xs">
                                        <i class="fa-solid fa-clipboard-user text-[10px]"></i> Absensi
                                    </a>
                                    <a href="{{ route('admin.agenda.berita-acara.cetak', $live->id) }}" target="_blank" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition border border-slate-200" title="Cetak Berita Acara">
                                        <i class="fa-regular fa-file-lines text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Agendas List Grouped by Mata Kuliah, Kelas, & Program Kuliah -->
            @php
                $currentSort = request('sort', 'terbaru');
                $isSortDesc = $currentSort === 'terbaru';
                $groupedAgendas = $allAgendas->groupBy(function($item) {
                    return ($item->mata_kuliah ?: 'Umum') . '___' . ($item->kelas ?: '-') . '___' . ($item->program_kuliah ?: 'Reguler');
                })->map(function($group) use ($isSortDesc) {
                    return $group->sortBy(function($item) {
                        $num = 999;
                        if ($item->catatan && preg_match('/Pertemuan\s*(?:ke-)?(\d+)/i', $item->catatan, $m)) {
                            $num = (int)$m[1];
                        }
                        return ($item->tanggal ?? '') . '_' . sprintf('%04d', $num) . '_' . ($item->jam_mulai ?? '');
                    }, SORT_REGULAR, $isSortDesc)->values();
                });

                if ($isSortDesc) {
                    $groupedAgendas = $groupedAgendas->sortByDesc(function($group) {
                        return ($group->max('tanggal') ?? '') . ' ' . ($group->max('jam_mulai') ?? '');
                    });
                } else {
                    $groupedAgendas = $groupedAgendas->sortBy(function($group) {
                        return ($group->min('tanggal') ?? '') . ' ' . ($group->min('jam_mulai') ?? '');
                    });
                }
            @endphp

            <div class="space-y-4 w-full">
                <!-- Header Card & Data Creation Buttons -->
                <div class="bg-white border border-slate-200/80 rounded-xl px-5 py-3.5 shadow-xs flex flex-wrap justify-between items-center gap-3">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 tracking-tight flex items-center gap-2">
                            <i class="fa-solid fa-list-check text-teal-700"></i>
                            <span>Daftar Agenda Perkuliahan</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $groupedAgendas->count() }} Kelas Mata Kuliah • {{ $allAgendas->count() }} Total Sesi Terjadwal</p>
                    </div>

                    <!-- Creation & Import Actions (Separated from list controls) -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <button onclick="toggleModal('modal-import-agenda')" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                            <i class="fa-solid fa-file-import text-teal-700"></i>
                            <span>Impor Excel</span>
                        </button>
                        <button onclick="openAddModal()" class="px-3.5 py-1.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>+ Tambah Agenda</span>
                        </button>
                    </div>
                </div>

                <!-- Dedicated List Controls Bar (Expand / Select All / Sort Toggle) -->
                @if($groupedAgendas->count() > 0)
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-slate-500 font-semibold text-[11px] uppercase tracking-wider mr-1">Kontrol:</span>
                        <button type="button" onclick="toggleExpandAll(this)" id="btn-toggle-expand-all" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Buka atau Tutup Semua Accordion Sesi">
                            <i class="fa-solid fa-chevron-down text-slate-500 text-[10px] transition-transform duration-200" id="icon-toggle-expand-all"></i>
                            <span id="text-toggle-expand-all">Buka Semua</span>
                        </button>
                        <button type="button" onclick="toggleSelectAllAgendas(this)" id="btn-select-all-global" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Pilih Seluruh Sesi untuk Aksi Massal">
                            <i class="fa-regular fa-square-check text-teal-700 text-xs"></i>
                            <span>Pilih Semua Sesi</span>
                        </button>

                        <!-- Quick Sort Buttons -->
                        <div class="inline-flex items-center bg-white p-0.5 rounded-lg border border-slate-200 shadow-2xs sm:ml-2">
                            <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider hidden md:inline">Urutan:</span>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}" 
                               class="px-2.5 py-1 rounded-md text-xs font-bold transition flex items-center gap-1.5 {{ request('sort', 'terbaru') == 'terbaru' ? 'bg-teal-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                               title="Urutkan dari tanggal terbaru ke terlama">
                                <i class="fa-solid fa-arrow-down-wide-short text-[11px]"></i>
                                <span>Tanggal Terbaru</span>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'terlama']) }}" 
                               class="px-2.5 py-1 rounded-md text-xs font-bold transition flex items-center gap-1.5 {{ request('sort', 'terlama') == 'terlama' ? 'bg-teal-800 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}"
                               title="Urutkan dari tanggal terlama ke terbaru">
                                <i class="fa-solid fa-arrow-up-wide-short text-[11px]"></i>
                                <span>Tanggal Terlama</span>
                            </a>
                        </div>
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium hidden sm:block">
                        Klik judul mata kuliah untuk membuka/menutup sesi pertemuan
                    </div>
                </div>
                @endif

                @if($groupedAgendas->count() > 0)
                    <div id="btn-bulk-delete" class="hidden p-3 bg-rose-50 border border-rose-200 rounded-xl flex items-center justify-between shadow-sm sticky top-4 z-40">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs">
                                <i class="fa-solid fa-trash-can"></i>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-rose-900 block"><span id="bulk-count">0</span> sesi agenda terpilih</span>
                                <span class="text-[11px] text-rose-600">Sesi dan absensi yang dicentang akan dihapus permanen</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="printSelectedAgendasBa()" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Cetak Berita Acara untuk Sesi yang Dicentang">
                                <i class="fa-regular fa-file-lines text-slate-500"></i>
                                <span>Cetak BA Terpilih</span>
                            </button>
                            <button type="button" onclick="clearAllSelections()" class="px-3 py-1.5 bg-white hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-medium transition cursor-pointer">
                                Batal
                            </button>
                            <button type="button" onclick="submitBulkDeleteForm()" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                                <i class="fa-solid fa-trash-can text-xs"></i> Hapus Terpilih
                            </button>
                        </div>
                    </div>

                    @php
                        // Tentukan tahun_akademik terbaru dari semua data yang tampil
                        $latestTahunAkademik = $groupedAgendas->flatten()->max('tahun_akademik');
                    @endphp
                    @foreach($groupedAgendas as $groupKey => $agendasGroup)
                        @php
                            $firstItem = $agendasGroup->first();
                            $namaMatkul = $firstItem->mata_kuliah ?: 'Umum';
                            $isKaryawan = strcasecmp($firstItem->program_kuliah ?? '', 'karyawan') === 0;
                            $progLabel = $isKaryawan ? 'Karyawan' : 'Reguler';
                            $totalPertemuan = $agendasGroup->count();
                            $selesaiCount = $agendasGroup->where('status_agenda', 'Selesai')->count();
                            $berlangsungCount = $agendasGroup->where('status_agenda', 'Berlangsung')->count();
                            $akanDatangCount = $agendasGroup->where('status_agenda', 'Akan Datang')->count();
                            $dibatalkanCount = $agendasGroup->where('status_agenda', 'Dibatalkan')->count();
                            $groupSlug = 'group-' . $loop->index . '-' . Str::slug($namaMatkul . '-' . ($firstItem->kelas ?? 'all') . '-' . $progLabel);
                            $matchedMk = isset($mataKuliahs) ? $mataKuliahs->firstWhere('nama_mk', $namaMatkul) : null;

                            $minTanggal = $agendasGroup->min('tanggal');
                            $maxTanggal = $agendasGroup->max('tanggal');
                            // "Semester Lalu" hanya jika tahun_akademik berbeda dari yang terbaru
                            $courseTahunAkademik = $firstItem->tahun_akademik ?? '';
                            $isPastCourse = $maxTanggal < date('Y-m-d') && $berlangsungCount === 0
                                && $courseTahunAkademik !== $latestTahunAkademik;

                            if ($minTanggal && $maxTanggal) {
                                if ($minTanggal === $maxTanggal) {
                                    $periodeText = date('d M Y', strtotime($minTanggal));
                                } else {
                                    $periodeText = date('d M Y', strtotime($minTanggal)) . ' - ' . date('d M Y', strtotime($maxTanggal));
                                }
                            } else {
                                $periodeText = '-';
                            }

                            $isFiltered = request()->anyFilled(['search', 'tanggal']);
                            $isExpanded = $isFiltered || ($berlangsungCount > 0) || ($loop->first && $groupedAgendas->count() === 1);
                        @endphp
                        <div class="bg-white border border-slate-200/80 rounded-xl shadow-xs overflow-hidden transition-all group-mk-card" id="card-{{ $groupSlug }}">
                            <!-- Clickable Header for Mata Kuliah Group -->
                            <div onclick="toggleAccordion('{{ $groupSlug }}')" 
                                 class="bg-white hover:bg-slate-50/75 px-5 py-3.5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 cursor-pointer select-none transition-colors border-b border-slate-100"
                                 role="button" 
                                 aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
                                 id="header-{{ $groupSlug }}">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-bold text-sm text-slate-800 tracking-tight">{{ $namaMatkul }}</h4>
                                        @if($matchedMk && $matchedMk->kode_mk)
                                            <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 font-mono text-[11px] font-semibold rounded">
                                                {{ $matchedMk->kode_mk }}
                                            </span>
                                        @endif
                                        @if($isKaryawan)
                                            <span class="px-2 py-0.5 bg-purple-100 text-purple-900 border border-purple-300 rounded text-[11px] font-extrabold flex items-center gap-1">
                                                <i class="fa-solid fa-briefcase text-[10px] text-purple-700"></i> Karyawan
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-900 border border-blue-200 rounded text-[11px] font-bold flex items-center gap-1">
                                                <i class="fa-solid fa-graduation-cap text-[10px] text-blue-700"></i> Reguler
                                            </span>
                                        @endif
                                        @if($firstItem->kelas)
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[11px] font-semibold border border-slate-200">
                                                Kelas {{ $firstItem->kelas }}
                                            </span>
                                        @endif
                                        @if($isPastCourse)
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-800 border border-amber-200 rounded text-[10px] font-semibold flex items-center gap-1" title="Agenda semester lalu">
                                                <i class="fa-solid fa-clock-rotate-left text-[9px] text-amber-600"></i> Semester Lalu
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 font-normal mt-1 flex items-center gap-2 flex-wrap">
                                        <span class="inline-flex items-center gap-1 text-slate-600 font-medium">
                                            <i class="fa-regular fa-calendar text-slate-400"></i> {{ $periodeText }}
                                        </span>
                                        <span class="text-slate-300">•</span>
                                        <span>{{ $totalPertemuan }} Pertemuan</span>
                                        <span class="text-slate-300">•</span>
                                        <span>{{ $firstItem->jurusan ?? 'Program Studi' }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="inline-flex items-center gap-1 font-semibold text-slate-700">
                                            <i class="fa-solid fa-flask text-teal-600 text-[10px]"></i>
                                            {{ $firstItem->lab->nama_lab ?? 'Lab' }}
                                        </span>
                                        @if(auth()->user()->isSuperAdmin() && $firstItem->lab && $firstItem->lab->fakultas)
                                            <span class="text-slate-300">•</span>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200/80 rounded font-semibold text-[10px]">
                                                <i class="fa-solid fa-building-columns text-emerald-600 text-[9px]"></i>
                                                {{ $firstItem->lab->fakultas->nama_fakultas }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5 self-end sm:self-center shrink-0">
                                    @if($berlangsungCount > 0)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Berlangsung
                                        </span>
                                    @endif
                                    
                                    <div class="text-xs text-slate-500 font-medium hidden md:flex items-center gap-1.5 mr-1">
                                        @if($selesaiCount > 0)
                                            <span class="text-slate-700 font-medium">{{ $selesaiCount }} Selesai</span>
                                        @endif
                                        @if($selesaiCount > 0 && $akanDatangCount > 0)
                                            <span class="text-slate-300">•</span>
                                        @endif
                                        @if($akanDatangCount > 0)
                                            <span>{{ $akanDatangCount }} Mendatang</span>
                                        @endif
                                    </div>

                                    <!-- Tombol Cetak Realisasi Per MK -->
                                    <a href="{{ route('admin.agenda.realisasi-praktikum.cetak', $firstItem->id) }}" target="_blank" 
                                       onclick="event.stopPropagation()" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-300 hover:border-slate-400 rounded-lg text-xs font-medium transition shadow-2xs"
                                       title="Cetak Lembar Realisasi Praktikum Resmi FT UIKA (Pertemuan 1 s/d {{ $totalPertemuan }})">
                                        <i class="fa-solid fa-print text-slate-400"></i>
                                        <span>Cetak Realisasi</span>
                                    </a>

                                    <!-- Tombol Cetak BA Per MK & Pilihan Pertemuan -->
                                    <button type="button" 
                                            onclick="event.stopPropagation(); openPrintBaModal('{{ $groupSlug }}', '{{ addslashes($namaMatkul) }}', '{{ $firstItem->kelas ?? '-' }}', '{{ $firstItem->id }}')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-300 hover:border-slate-400 rounded-lg text-xs font-medium transition shadow-2xs cursor-pointer"
                                            title="Cetak Berita Acara (Pilih Pertemuan atau Semua)">
                                        <i class="fa-regular fa-file-lines text-slate-400"></i>
                                        <span>Cetak BA</span>
                                        <i class="fa-solid fa-chevron-down text-[9px] text-slate-400"></i>
                                    </button>

                                    <div class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 transition">
                                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 {{ $isExpanded ? 'rotate-180 text-slate-700' : '' }}" id="chevron-{{ $groupSlug }}"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- List Table for Sessions in this Mata Kuliah (Collapsible) -->
                            <div id="content-{{ $groupSlug }}" class="accordion-content {{ $isExpanded ? '' : 'hidden' }}">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs text-left text-slate-600">
                                        <thead class="bg-slate-50/75 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider text-[10px]">
                                            <tr>
                                                <th class="p-3.5 w-10 text-center">
                                                    <input type="checkbox" data-slug="{{ $groupSlug }}" onclick="toggleSelectGroup(this, '{{ $groupSlug }}')" class="master-group-checkbox rounded border-slate-300 text-teal-800 focus:ring-teal-700/30 cursor-pointer" title="Pilih Semua Pertemuan di Kelas Ini">
                                                </th>
                                                <th class="p-3.5">Pertemuan & Waktu</th>
                                                <th class="p-3.5">Detail Kelas & Status</th>
                                                <th class="p-3.5">Dosen Pengampu & Pengajar</th>
                                                <th class="p-3.5">Lokasi Lab</th>
                                                <th class="p-3.5 text-right pr-5">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($agendasGroup as $index => $ag)
                                                @php
                                                    $pertemuanNum = null;
                                                    if ($ag->catatan && preg_match('/Pertemuan\s*(?:ke-)?(\d+)/i', $ag->catatan, $m)) {
                                                        $pertemuanNum = $m[1];
                                                    } else {
                                                        $pertemuanNum = $index + 1;
                                                    }
                                                @endphp
                                                <tr class="hover:bg-slate-50/60 transition-colors item-{{ $groupSlug }}"
                                                    data-agenda-id="{{ $ag->id }}"
                                                    data-pertemuan="{{ $pertemuanNum }}"
                                                    data-tanggal="{{ $ag->hari_tanggal }}"
                                                    data-jam="{{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB"
                                                    data-status="{{ $ag->status_agenda }}"
                                                    data-materi="{{ $ag->catatan ?: ($ag->materi_realisasi ?: '-') }}"
                                                    data-print-url="{{ route('admin.agenda.berita-acara.cetak', $ag->id) }}">
                                                    <td class="p-3.5 text-center">
                                                        <input type="checkbox" name="ids[]" value="{{ $ag->id }}" class="agenda-checkbox rounded border-slate-300 text-teal-800 focus:ring-teal-700/30 cursor-pointer" onclick="updateBulkDeleteBtn()">
                                                    </td>
                                                    <td class="p-3.5">
                                                        <div class="flex items-center gap-2">
                                                            <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-700 font-bold rounded text-[10px]">Pertemuan {{ $pertemuanNum }}</span>
                                                            <span class="font-semibold text-slate-800 text-xs">{{ $ag->hari_tanggal }}</span>
                                                        </div>
                                                        <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                                                            {{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB
                                                        </div>
                                                        @if($ag->catatan)
                                                            <div class="text-[11px] text-slate-600 mt-1 flex items-start gap-1 line-clamp-1 max-w-xs" title="Materi: {{ $ag->catatan }}">
                                                                <i class="fa-solid fa-book-open text-[10px] text-slate-400 mt-0.5 shrink-0"></i>
                                                                <span class="truncate"><span class="font-medium text-slate-700">Materi:</span> {{ $ag->catatan }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="p-3.5 space-y-1">
                                                        <div class="flex items-center gap-1.5 flex-wrap">
                                                            @if($ag->status_agenda == 'Berlangsung')
                                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1">
                                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Berlangsung
                                                                </span>
                                                            @elseif($ag->status_agenda == 'Selesai')
                                                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">Selesai</span>
                                                            @elseif($ag->status_agenda == 'Dibatalkan')
                                                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-100">Dibatalkan</span>
                                                            @else
                                                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-50 text-slate-600 border border-slate-200">Akan Datang</span>
                                                            @endif
                                                        </div>
                                                        <div class="text-[11px] text-slate-500">
                                                            Kelas {{ $ag->kelas ?: '-' }} • Smt {{ $ag->semester ?: '1' }} • {{ $ag->program_kuliah ?? 'Reguler' }} {{ $ag->tahun_ajaran }}
                                                        </div>
                                                    </td>
                                                    <td class="p-3.5">
                                                        @php
                                                            $namaPengampu = $ag->dosenPengampu->nama ?? $ag->dosen->nama ?? '-';
                                                            $hasDistinctPengajar = $ag->dosen_pengampu_id && $ag->dosen_id && ($ag->dosen_pengampu_id != $ag->dosen_id);
                                                        @endphp
                                                        <div class="font-bold text-slate-800 text-xs flex items-center gap-1.5 flex-wrap">
                                                            <span>{{ $namaPengampu }}</span>
                                                            <span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded text-[10px] font-medium">PJMK</span>
                                                        </div>
                                                        @if($hasDistinctPengajar)
                                                            <div class="text-[11px] text-slate-600 mt-1 flex items-center gap-1">
                                                                <span class="text-slate-400 font-medium">Pengajar:</span>
                                                                <span class="font-semibold text-slate-700">{{ $ag->dosen->nama }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="p-3.5">
                                                        <div class="font-bold text-slate-800 text-xs flex items-center gap-1.5">
                                                            <i class="fa-solid fa-flask text-[10px] text-teal-700"></i>
                                                            <span>{{ $ag->lab->nama_lab ?? '-' }}</span>
                                                        </div>
                                                        @if(auth()->user()->isSuperAdmin() && $ag->lab && $ag->lab->fakultas)
                                                            <div class="text-[11px] text-teal-700 font-semibold flex items-center gap-1 mt-0.5">
                                                                <i class="fa-solid fa-building-columns text-[9px] text-teal-600"></i>
                                                                <span>{{ $ag->lab->fakultas->nama_fakultas }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="text-[11px] text-slate-400 mt-0.5">{{ $ag->lab->lokasi ?? '-' }}</div>
                                                    </td>
                                                    <td class="p-3.5 text-right pr-5">
                                                        <div class="inline-flex items-center gap-1.5 justify-end">
                                                            @if(!$ag->dosen_waktu_masuk)
                                                            <form action="{{ route('admin.agenda.absen-dosen', $ag->id) }}" method="POST" class="inline m-0 p-0">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 border border-emerald-200 rounded-md font-medium transition text-xs" title="Tandai Dosen Hadir">
                                                                    <i class="fa-solid fa-user-check text-emerald-500 mr-0.5"></i> Dosen
                                                                </button>
                                                            </form>
                                                            @else
                                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md font-medium text-xs cursor-default" title="Dosen Sudah Hadir">
                                                                <i class="fa-solid fa-check-circle text-emerald-600 mr-0.5"></i> Dosen
                                                            </span>
                                                            @endif
                                                            <a href="{{ route('admin.absensi.input', $ag->id) }}" 
                                                               class="inline-flex items-center gap-1 px-2.5 py-1 text-teal-600 hover:text-teal-900 hover:bg-teal-50 border border-teal-200 rounded-md font-medium transition text-xs" 
                                                               title="Input Absensi Mahasiswa">
                                                                <i class="fa-solid fa-clipboard-user text-teal-500 mr-0.5"></i> Absensi
                                                            </a>
                                                            <a href="{{ route('admin.agenda.berita-acara.cetak', $ag->id) }}" target="_blank" 
                                                               class="inline-flex items-center gap-1 px-2.5 py-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 rounded-md font-medium transition text-xs" 
                                                               title="Cetak Berita Acara Pertemuan {{ $pertemuanNum }}">
                                                                <i class="fa-regular fa-file-lines text-slate-400 mr-0.5"></i> BA
                                                            </a>
                                                            <button type="button" onclick='openEditModal(@json($ag))' 
                                                                    class="inline-flex items-center gap-1 px-2.5 py-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 rounded-md font-medium transition text-xs" 
                                                                    title="Edit Agenda">
                                                                <i class="fa-solid fa-pen-to-square text-slate-400 mr-0.5"></i> Edit
                                                            </button>
                                                            <button type="button" onclick="confirmDeleteAgenda('{{ route('admin.agenda.delete', $ag->id) }}')" 
                                                                    class="inline-flex items-center gap-1 px-2.5 py-1 text-slate-500 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 rounded-md font-medium transition text-xs" 
                                                                    title="Hapus Agenda">
                                                                <i class="fa-solid fa-trash-can text-slate-400 hover:text-rose-500 mr-0.5"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center shadow-xs w-full my-4">
                        <div class="w-16 h-16 rounded-2xl bg-teal-50 text-teal-800 border border-teal-200/80 flex items-center justify-center mx-auto mb-4 text-2xl shadow-xs">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <h3 class="font-extrabold text-base text-slate-800">Jadwal Agenda Praktikum Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto mt-1.5 leading-relaxed">
                            @if(request()->anyFilled(['search', 'lab_id', 'prodi_id', 'pertemuan', 'tanggal', 'sort']))
                                Tidak ada data agenda praktikum yang sesuai dengan filter pilihan Anda. Coba reset filter pencarian atau buat jadwal baru.
                            @else
                                Belum ada data agenda praktikum yang terdaftar di sistem. Silakan tambahkan jadwal agenda baru atau impor dari file spreadsheet Excel.
                            @endif
                        </p>
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                            @if(request()->anyFilled(['search', 'lab_id', 'prodi_id', 'pertemuan', 'tanggal', 'sort']))
                                <a href="{{ route('admin.agenda') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition border border-slate-200">
                                    <i class="fa-solid fa-rotate-left"></i> Reset Filter Pencarian
                                </a>
                            @endif
                            <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-xl text-xs transition shadow-sm cursor-pointer">
                                <i class="fa-solid fa-plus"></i> + Buat Agenda Baru
                            </button>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <!-- MODAL TAMBAH / EDIT AGENDA -->
    <div id="modal-agenda" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-agenda-title" class="font-bold text-base text-slate-800">Tambah Agenda Praktikum</h3>
                <button type="button" onclick="toggleModal('modal-agenda')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <form id="agenda-form" action="{{ route('admin.agenda.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" id="agenda-method" name="_method" value="POST">
                <input type="hidden" id="agenda_id" name="agenda_id" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Dosen Pengampu (PJMK) - Prioritas Utama -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">
                            Dosen Pengampu (PJMK) <span class="text-rose-500">*</span>
                        </label>
                        <select id="form_dosen_pengampu_id" name="dosen_pengampu_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                            <option value="">-- Pilih Dosen Pengampu (PJMK) --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }} (NIP: {{ $d->nip }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dosen Pengajar / Praktikum (Opsional) -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">
                            Dosen Pengajar / Praktikum <span class="text-slate-400 font-normal text-[10px]">(Opsional - sama dg pengampu)</span>
                        </label>
                        <select id="form_dosen_id" name="dosen_id" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                            <option value="">-- Sama dengan Dosen Pengampu --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }} (NIP: {{ $d->nip }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ruang Laboratorium -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Ruang Laboratorium <span class="text-rose-500">*</span></label>
                        <select id="form_lab_id" name="lab_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                            <option value="">-- Pilih Laboratorium --</option>
                            @foreach($labs as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lab }} ({{ $l->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Agenda (Otomatis) -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">
                            Status Agenda <span class="text-emerald-700 font-bold text-[10px]"><i class="fa-solid fa-bolt text-[9px]"></i> Otomatis</span>
                        </label>
                        <select id="form_status_agenda" name="status_agenda" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium text-slate-700">
                            <option value="Otomatis">Otomatis (Sesuai Jam & Tanggal)</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Mata Kuliah -->
                    <div class="md:col-span-2 space-y-1.5 relative" id="matkul_combobox_wrapper">
                        <label class="block text-slate-700 font-bold">Mata Kuliah <span class="text-rose-500">*</span></label>
                        
                        <div class="relative">
                            <!-- Trigger & Input Display -->
                            <div class="relative flex items-center">
                                <input type="text" 
                                       id="form_mata_kuliah" 
                                       name="mata_kuliah" 
                                       placeholder="Pilih atau cari mata kuliah..." 
                                       required 
                                       autocomplete="off"
                                       onclick="openMatkulDropdown()"
                                       onfocus="openMatkulDropdown()"
                                       oninput="handleMatkulDirectInput(this.value)"
                                       class="w-full p-2.5 pr-10 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium text-slate-800 transition-all">
                                <button type="button" 
                                        onclick="toggleMatkulDropdown(event)" 
                                        tabindex="-1"
                                        class="absolute right-2 p-1.5 text-slate-400 hover:text-slate-600 transition-colors">
                                    <i id="matkul_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                                </button>
                            </div>

                            <!-- Dropdown Menu Box -->
                            <div id="matkul_dropdown_menu" 
                                 class="hidden absolute z-50 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-2xl p-2.5 max-h-72 flex flex-col space-y-2">
                                
                                <!-- Search Input Bar -->
                                <div class="relative shrink-0">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    <input type="text" 
                                           id="matkul_search_input" 
                                           oninput="filterMatkulList(this.value)" 
                                           placeholder="Cari nama atau kode mata kuliah..." 
                                           autocomplete="off"
                                           class="w-full pl-8 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                                </div>

                                <!-- Custom Item Option -->
                                <div class="border-b border-slate-100 pb-1.5 shrink-0">
                                    <button type="button" 
                                            onclick="selectCustomMatkulMode()" 
                                            class="w-full text-left px-3 py-1.5 text-xs font-semibold text-teal-700 hover:bg-teal-50 rounded-lg flex items-center justify-between transition-colors">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-pen-to-square text-teal-600"></i> Ketik Mata Kuliah Manual
                                        </span>
                                        <span class="text-[10px] bg-teal-100 text-teal-800 px-1.5 py-0.5 rounded font-medium">Kustom</span>
                                    </button>
                                </div>

                                <!-- Options List -->
                                <div id="matkul_options_container" class="overflow-y-auto flex-1 space-y-0.5 max-h-48 pr-1 custom-scrollbar">
                                    @if(isset($mataKuliahs) && count($mataKuliahs) > 0)
                                        @foreach($mataKuliahs as $mk)
                                            <div class="matkul-item-option px-3 py-2 text-sm text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition-colors flex items-center justify-between group"
                                                 data-name="{{ $mk->nama_mk }}"
                                                 data-code="{{ $mk->kode_mk ?? '' }}"
                                                 data-prodi="{{ $mk->prodi->nama_prodi ?? '' }}"
                                                 data-fakultas="{{ $mk->prodi->fakultas->nama_fakultas ?? '' }}"
                                                 onclick="selectMatkulItem('{{ addslashes($mk->nama_mk) }}', '{{ addslashes($mk->prodi->nama_prodi ?? '') }}', '{{ addslashes($mk->prodi->fakultas->nama_fakultas ?? '') }}')">
                                                <div class="flex items-center gap-2 overflow-hidden">
                                                    <i class="fa-solid fa-book-bookmark text-slate-300 group-hover:text-teal-600 text-xs shrink-0"></i>
                                                    <span class="font-medium truncate text-xs sm:text-sm">{{ $mk->nama_mk }}</span>
                                                </div>
                                                @if($mk->kode_mk)
                                                    <span class="text-[10px] text-slate-400 bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-800 px-1.5 py-0.5 rounded font-mono ml-2 shrink-0">{{ $mk->kode_mk }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div id="matkul_empty_msg" class="px-3 py-3 text-xs text-slate-400 italic text-center">Belum ada mata kuliah terdaftar. Silakan ketik manual.</div>
                                    @endif
                                    <div id="matkul_no_results" class="hidden px-3 py-3 text-xs text-slate-400 italic text-center">Mata kuliah tidak ditemukan. Anda dapat langsung mengetikkan nama mata kuliah.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Kuliah, Tipe Pertemuan & Tahun Akademik -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Program Kuliah <span class="text-rose-500">*</span></label>
                            <select id="form_program_kuliah" name="program_kuliah" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="Reguler">Reguler</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Tahun Akademik <span class="text-rose-500">*</span></label>
                            <select id="form_tahun_akademik" name="tahun_akademik" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="2026/2027 Ganjil">2026/2027 Ganjil</option>
                                <option value="2026/2027 Genap">2026/2027 Genap</option>
                                <option value="2025/2026 Ganjil">2025/2026 Ganjil</option>
                                <option value="2025/2026 Genap">2025/2026 Genap</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Tipe Pertemuan <span class="text-rose-500">*</span></label>
                            <select id="form_jenis_pertemuan" name="jenis_pertemuan" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="Praktikum">Praktikum</option>
                                <option value="Teori">Teori</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kelas Combobox (Database Aligned: A, B, C) -->
                    <div class="relative" id="kelas_combobox_wrapper">
                        <label class="block text-slate-700 font-bold mb-1">
                            Kelas <span class="text-slate-400 font-normal text-[10px]">(Opsional)</span>
                        </label>
                        <div class="relative flex items-center">
                            <input type="text" 
                                   name="kelas" 
                                   id="form_kelas" 
                                   placeholder="Pilih atau ketik kelas..." 
                                   autocomplete="off"
                                   onclick="openAgendaKelasDropdown()"
                                   onfocus="openAgendaKelasDropdown()"
                                   oninput="handleAgendaKelasInput(this.value)"
                                   class="w-full p-2.5 pr-8 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs font-semibold text-slate-800 transition">
                            <button type="button" 
                                    onclick="toggleAgendaKelasDropdown(event)" 
                                    tabindex="-1"
                                    class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                                <i id="kelas_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                        </div>

                        <!-- Dropdown Menu for Kelas (Pure Database Classes: A, B, C) -->
                        <div id="kelas_dropdown_menu" 
                             class="hidden absolute z-50 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-2xl p-2 max-h-48 overflow-y-auto custom-scrollbar flex flex-col space-y-1"
                             style="background-color: #ffffff !important;">
                            <div class="px-2 py-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 bg-slate-50 rounded">
                                <i class="fa-solid fa-graduation-cap text-teal-600 text-[10px]"></i> Data Kelas (Database)
                            </div>
                            @if(isset($kelases) && count($kelases) > 0)
                                @foreach($kelases as $k)
                                    <div class="agenda-kelas-item px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group"
                                         data-name="{{ $k->nama_kelas }}"
                                         onclick="selectAgendaKelasItem('{{ $k->nama_kelas }}')">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-teal-100/80 text-teal-800 flex items-center justify-center font-bold text-xs group-hover:bg-teal-700 group-hover:text-white transition">
                                                {{ $k->nama_kelas }}
                                            </span>
                                            <span class="font-bold text-slate-800">Kelas {{ $k->nama_kelas }}</span>
                                        </div>
                                        <span class="text-[10px] text-slate-400 group-hover:text-teal-700 font-medium">Pilih</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Semester -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Semester <span class="text-rose-500">*</span></label>
                        <select id="form_semester" name="semester" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="">Pilih Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                            <option value="7">Semester 7</option>
                            <option value="8">Semester 8</option>
                            <option value="9">Semester 9</option>
                            <option value="10">Semester 10</option>
                            <option value="11">Semester 11</option>
                            <option value="12">Semester 12</option>
                        </select>
                    </div>

                    <!-- Fakultas -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Fakultas <span class="text-rose-500">*</span></label>
                        <select id="form_fakultas" name="fakultas" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none" onchange="filterJurusan()">
                            <option value="">Pilih Fakultas</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->nama_fakultas }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jurusan / Prodi -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Jurusan / Program Studi <span class="text-rose-500">*</span></label>
                        <select id="form_jurusan" name="jurusan" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="">Pilih Jurusan</option>
                            @foreach($prodis as $p)
                                <option value="{{ $p->nama_prodi }}" data-fakultas="{{ $p->fakultas->nama_fakultas ?? '' }}" class="jurusan-option">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Tanggal Praktikum <span class="text-rose-500">*</span></label>
                        <input type="date" id="form_tanggal" name="tanggal" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>

                    <!-- Jam Mulai & Jam Selesai -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Mulai <span class="text-rose-500">*</span></label>
                            <input type="time" id="form_waktu_masuk" name="waktu_masuk" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Selesai <span class="text-rose-500">*</span></label>
                            <input type="time" id="form_waktu_keluar" name="waktu_keluar" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                    </div>

                    <!-- Materi Praktikum (Opsional) -->
                    <div class="md:col-span-2">
                        <label class="block text-slate-700 font-bold mb-1">
                            Materi Praktikum <span class="text-slate-400 font-normal text-[10px]">(Opsional)</span>
                        </label>
                        <textarea id="form_materi_pembelajaran" name="materi_pembelajaran" rows="3" placeholder="Tuliskan materi praktikum... (Opsional)" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none"></textarea>
                    </div>
                </div>

                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-agenda')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-bold shadow-sm">Simpan Agenda</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL IMPORT AGENDA -->
    <div id="modal-import-agenda" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-base text-slate-800">Import Data Agenda</h3>
                <button onclick="toggleModal('modal-import-agenda')" class="text-slate-400 hover:text-slate-660 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.agenda.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'agenda') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                    </div>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-import-agenda')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-lg font-bold shadow-sm">Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- GLOBAL IMPORT LOADING OVERLAY -->
    <div id="global-import-loading-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[9999] flex flex-col items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl space-y-5">
            <div class="relative w-16 h-16 mx-auto flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-teal-500/20 border-t-teal-400 animate-spin"></div>
                <i class="fa-solid fa-cloud-arrow-up text-2xl text-teal-400"></i>
            </div>
            <div class="space-y-1.5">
                <h3 class="text-base font-extrabold text-white tracking-tight">Mengimpor Data...</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem sedang membaca dan memproses file Excel/CSV. Mohon tunggu sejenak dan jangan menutup halaman ini.
                </p>
            </div>
            <div class="pt-3 border-t border-slate-800 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-notch animate-spin text-teal-400 text-xs"></i>
                <span class="text-[11px] font-bold tracking-wider text-teal-300 uppercase">Memproses Database</span>
            </div>
        </div>
    </div>

    <!-- MODAL CETAK BERITA ACARA PER MK / PILIH PERTEMUAN -->
    <div id="modal-print-ba" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <!-- Header Modal -->
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/75">
                <div class="min-w-0 pr-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-800 flex items-center justify-center text-xs">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                        <h3 class="font-bold text-sm text-slate-800 tracking-tight">Cetak Berita Acara (BA)</h3>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 truncate" id="modal-ba-subtitle">Pilih pertemuan yang ingin dicetak</p>
                </div>
                <button type="button" onclick="closePrintBaModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Controls Bar in Modal: Select All & Count Badge -->
            <div class="px-5 py-2.5 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between text-xs text-slate-600">
                <label class="inline-flex items-center gap-2 cursor-pointer font-medium select-none">
                    <input type="checkbox" id="modal-ba-select-all" onchange="toggleModalBaSelectAll(this)" class="rounded border-slate-300 text-teal-800 focus:ring-teal-700/30 cursor-pointer">
                    <span>Pilih Semua Pertemuan</span>
                </label>
                <span id="modal-ba-count-badge" class="font-medium text-slate-500">0 dipilih</span>
            </div>

            <!-- Scrollable Meeting List -->
            <div class="p-5 overflow-y-auto space-y-2 flex-1 divide-y divide-slate-100" id="modal-ba-list">
                <!-- Dynamically populated rows by JS -->
            </div>

            <!-- Footer Actions -->
            <div class="px-5 py-3.5 bg-slate-50/75 border-t border-slate-100 flex items-center justify-between gap-3">
                <button type="button" onclick="closePrintBaModal()" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition cursor-pointer">
                    Batal
                </button>
                <div class="flex items-center gap-2">
                    <button type="button" id="btn-modal-ba-print-all" onclick="printAllBaForGroup()" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 cursor-pointer" title="Cetak seluruh pertemuan pada mata kuliah ini">
                        <i class="fa-solid fa-print text-slate-400"></i>
                        <span>Cetak Semua</span>
                    </button>
                    <button type="button" id="btn-modal-ba-print-selected" onclick="printSelectedModalBa()" class="px-4 py-1.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-xs cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-print"></i>
                        <span id="text-modal-ba-print-btn">Cetak Terpilih (0)</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="actual-bulk-delete-form" action="{{ route('admin.agenda.bulk-delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // ==========================================
        // ACCORDION EXPAND / COLLAPSE CONTROLLERS
        // ==========================================
        function toggleAccordion(slug) {
            const content = document.getElementById('content-' + slug);
            const chevron = document.getElementById('chevron-' + slug);
            const header = document.getElementById('header-' + slug);

            if (!content) return;

            const isHidden = content.classList.contains('hidden');

            if (isHidden) {
                content.classList.remove('hidden');
                if (chevron) {
                    chevron.classList.add('rotate-180', 'text-teal-800');
                }
                if (header) header.setAttribute('aria-expanded', 'true');
            } else {
                content.classList.add('hidden');
                if (chevron) {
                    chevron.classList.remove('rotate-180', 'text-teal-800');
                }
                if (header) header.setAttribute('aria-expanded', 'false');
            }

            syncGlobalExpandBtn();
        }

        function toggleExpandAll(btn) {
            const allContents = document.querySelectorAll('.accordion-content');
            if (allContents.length === 0) return;

            const anyClosed = Array.from(allContents).some(c => c.classList.contains('hidden'));

            allContents.forEach(c => {
                const slug = c.id.replace('content-', '');
                const chevron = document.getElementById('chevron-' + slug);
                const header = document.getElementById('header-' + slug);

                if (anyClosed) {
                    c.classList.remove('hidden');
                    if (chevron) chevron.classList.add('rotate-180', 'text-teal-800');
                    if (header) header.setAttribute('aria-expanded', 'true');
                } else {
                    c.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180', 'text-teal-800');
                    if (header) header.setAttribute('aria-expanded', 'false');
                }
            });

            syncGlobalExpandBtn();
        }

        function syncGlobalExpandBtn() {
            const allContents = document.querySelectorAll('.accordion-content');
            if (allContents.length === 0) return;

            const allOpen = Array.from(allContents).every(c => !c.classList.contains('hidden'));
            const textEl = document.getElementById('text-toggle-expand-all');
            const iconEl = document.getElementById('icon-toggle-expand-all');

            if (textEl) {
                textEl.innerText = allOpen ? 'Tutup Semua' : 'Buka Semua';
            }
            if (iconEl) {
                if (allOpen) {
                    iconEl.classList.add('rotate-180');
                } else {
                    iconEl.classList.remove('rotate-180');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            syncGlobalExpandBtn();
        });
        function toggleSelectGroup(master, slug) {
            const content = document.getElementById('content-' + slug);
            if (master.checked && content && content.classList.contains('hidden')) {
                toggleAccordion(slug);
            }
            const checkboxes = document.querySelectorAll('.item-' + slug + ' .agenda-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = master.checked;
            });
            updateBulkDeleteBtn();
        }

        function toggleSelectAllAgendas(btn) {
            const checkboxes = document.querySelectorAll('.agenda-checkbox');
            const anyUnchecked = Array.from(checkboxes).some(cb => !cb.checked);
            
            checkboxes.forEach(cb => {
                cb.checked = anyUnchecked;
            });

            document.querySelectorAll('.master-group-checkbox').forEach(master => {
                master.checked = anyUnchecked;
            });

            if (btn) {
                const span = btn.querySelector('span');
                if (span) {
                    span.innerText = anyUnchecked ? 'Batal Pilih Semua' : 'Pilih Semua Sesi';
                }
            }

            updateBulkDeleteBtn();
        }

        function clearAllSelections() {
            document.querySelectorAll('.agenda-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.master-group-checkbox').forEach(master => master.checked = false);
            
            const btn = document.getElementById('btn-select-all-global');
            if (btn) {
                const span = btn.querySelector('span');
                if (span) span.innerText = 'Pilih Semua Sesi';
            }

            updateBulkDeleteBtn();
        }

        function updateBulkDeleteBtn() {
            const checked = document.querySelectorAll('.agenda-checkbox:checked');
            const bulkBtn = document.getElementById('btn-bulk-delete');
            const bulkCount = document.getElementById('bulk-count');
            
            if (checked.length > 0) {
                if (bulkBtn) bulkBtn.classList.remove('hidden');
                if (bulkCount) bulkCount.innerText = checked.length;
            } else {
                if (bulkBtn) bulkBtn.classList.add('hidden');
            }

            // Sync master checkboxes for each group
            document.querySelectorAll('.master-group-checkbox').forEach(master => {
                const slug = master.getAttribute('data-slug');
                if (slug) {
                    const groupCheckboxes = document.querySelectorAll('.item-' + slug + ' .agenda-checkbox');
                    if (groupCheckboxes.length > 0) {
                        const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
                        master.checked = allChecked;
                    }
                }
            });
        }

        function submitBulkDeleteForm() {
            const checked = document.querySelectorAll('.agenda-checkbox:checked');
            if (checked.length === 0) {
                Swal.fire({
                    title: 'Pilih Agenda Terlebih Dahulu',
                    text: 'Silakan centang minimal satu agenda untuk dihapus.',
                    icon: 'info',
                    confirmButtonColor: '#0f766e',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            Swal.fire({
                title: 'Hapus ' + checked.length + ' Agenda Terpilih?',
                text: 'Semua data dari ' + checked.length + ' agenda praktikum yang Anda centang beserta absensinya akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus ' + checked.length + ' Agenda!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('actual-bulk-delete-form');
                    form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
                    checked.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });
                    form.submit();
                }
            });
        }

        // ==========================================
        // BERITA ACARA PRINT (PER MK & BULK SELECT)
        // ==========================================
        let currentPrintBaFirstId = null;
        let currentPrintBaGroupSlug = null;

        function printSelectedAgendasBa() {
            const checked = document.querySelectorAll('.agenda-checkbox:checked');
            if (checked.length === 0) {
                Swal.fire({
                    title: 'Pilih Agenda Terlebih Dahulu',
                    text: 'Silakan centang minimal satu sesi agenda untuk mencetak Berita Acara.',
                    icon: 'info',
                    confirmButtonColor: '#0f766e',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }
            const ids = Array.from(checked).map(cb => cb.value);
            const firstId = ids[0];
            const baseUrl = "{{ route('admin.agenda.berita-acara.cetak', ':id') }}".replace(':id', firstId);
            window.open(`${baseUrl}?ids=${ids.join(',')}`, '_blank');
        }

        function openPrintBaModal(groupSlug, courseTitle, className, firstId) {
            currentPrintBaFirstId = firstId;
            currentPrintBaGroupSlug = groupSlug;

            const modal = document.getElementById('modal-print-ba');
            const subtitle = document.getElementById('modal-ba-subtitle');
            const listContainer = document.getElementById('modal-ba-list');
            const selectAllCb = document.getElementById('modal-ba-select-all');

            if (subtitle) {
                subtitle.textContent = `${courseTitle} • Kelas ${className}`;
            }
            if (listContainer) {
                listContainer.innerHTML = '';
            }

            const rows = document.querySelectorAll(`tr.item-${groupSlug}`);
            if (rows.length === 0) {
                if (listContainer) {
                    listContainer.innerHTML = '<div class="text-center py-6 text-slate-400 text-xs">Tidak ada pertemuan pada mata kuliah ini.</div>';
                }
            } else {
                rows.forEach(row => {
                    const id = row.dataset.agendaId;
                    const pertemuan = row.dataset.pertemuan;
                    const tanggal = row.dataset.tanggal;
                    const jam = row.dataset.jam;
                    const status = row.dataset.status;
                    const materi = row.dataset.materi;
                    const printUrl = row.dataset.printUrl;

                    const isFinished = (status === 'Selesai');
                    const badgeClass = isFinished 
                        ? 'bg-slate-100 text-slate-600' 
                        : (status === 'Berlangsung' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-50 text-slate-500 border border-slate-200');

                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'py-2.5 flex items-center justify-between gap-3 text-xs';
                    itemDiv.innerHTML = `
                        <label class="flex items-start gap-3 cursor-pointer select-none flex-1 min-w-0">
                            <input type="checkbox" value="${id}" class="modal-ba-item-cb rounded border-slate-300 text-teal-800 focus:ring-teal-700/30 mt-0.5 cursor-pointer" checked onchange="updateModalBaCount()">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold text-slate-800">Pertemuan ${pertemuan}</span>
                                    <span class="text-slate-400">•</span>
                                    <span class="text-slate-600 font-medium">${tanggal}</span>
                                    <span class="text-slate-400 font-mono text-[11px]">${jam}</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium ${badgeClass}">${status}</span>
                                </div>
                                ${materi && materi !== '-' ? `<div class="text-slate-500 text-[11px] truncate mt-0.5"><span class="font-medium text-slate-600">Materi:</span> ${materi}</div>` : ''}
                            </div>
                        </label>
                        <a href="${printUrl}" target="_blank" class="shrink-0 px-2 py-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded text-[11px] font-medium transition inline-flex items-center gap-1 border border-slate-200" title="Cetak Berita Acara Khusus Pertemuan ${pertemuan}">
                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i> Satuan
                        </a>
                    `;
                    listContainer.appendChild(itemDiv);
                });
            }

            if (selectAllCb) selectAllCb.checked = true;
            updateModalBaCount();

            if (modal) modal.classList.remove('hidden');
        }

        function closePrintBaModal() {
            const modal = document.getElementById('modal-print-ba');
            if (modal) modal.classList.add('hidden');
        }

        function toggleModalBaSelectAll(masterCb) {
            const itemCbs = document.querySelectorAll('.modal-ba-item-cb');
            itemCbs.forEach(cb => cb.checked = masterCb.checked);
            updateModalBaCount();
        }

        function updateModalBaCount() {
            const itemCbs = document.querySelectorAll('.modal-ba-item-cb');
            const checked = Array.from(itemCbs).filter(cb => cb.checked);
            const countBadge = document.getElementById('modal-ba-count-badge');
            const printBtn = document.getElementById('btn-modal-ba-print-selected');
            const printBtnText = document.getElementById('text-modal-ba-print-btn');
            const selectAllCb = document.getElementById('modal-ba-select-all');

            if (countBadge) countBadge.textContent = `${checked.length} dari ${itemCbs.length} dipilih`;
            if (printBtnText) printBtnText.textContent = `Cetak Terpilih (${checked.length})`;
            if (printBtn) printBtn.disabled = (checked.length === 0);
            if (selectAllCb) selectAllCb.checked = (checked.length === itemCbs.length && itemCbs.length > 0);
        }

        function printSelectedModalBa() {
            const itemCbs = document.querySelectorAll('.modal-ba-item-cb');
            const checkedIds = Array.from(itemCbs).filter(cb => cb.checked).map(cb => cb.value);
            if (checkedIds.length === 0) {
                alert('Silakan pilih minimal 1 pertemuan untuk dicetak.');
                return;
            }
            const baseUrl = "{{ route('admin.agenda.berita-acara.cetak', ':id') }}".replace(':id', currentPrintBaFirstId);
            window.open(`${baseUrl}?ids=${checkedIds.join(',')}`, '_blank');
        }

        function printAllBaForGroup() {
            const baseUrl = "{{ route('admin.agenda.berita-acara.cetak', ':id') }}".replace(':id', currentPrintBaFirstId);
            window.open(`${baseUrl}?all_mk=1`, '_blank');
        }

        function confirmDeleteAgenda(actionUrl) {
            Swal.fire({
                title: 'Hapus Agenda Praktikum?',
                text: 'Semua data absensi kelas ini akan terhapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = actionUrl;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Combobox Dropdown Logic for Mata Kuliah
        function openMatkulDropdown() {
            const menu = document.getElementById('matkul_dropdown_menu');
            const icon = document.getElementById('matkul_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeMatkulDropdown() {
            const menu = document.getElementById('matkul_dropdown_menu');
            const icon = document.getElementById('matkul_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleMatkulDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('matkul_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openMatkulDropdown();
                const searchInput = document.getElementById('matkul_search_input');
                if (searchInput) searchInput.focus();
            } else {
                closeMatkulDropdown();
            }
        }

        function filterMatkulList(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.matkul-item-option');
            const noResults = document.getElementById('matkul_no_results');
            let visibleCount = 0;

            items.forEach(item => {
                const name = (item.getAttribute('data-name') || '').toLowerCase();
                const code = (item.getAttribute('data-code') || '').toLowerCase();
                if (name.includes(q) || code.includes(q)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (noResults) {
                noResults.style.display = (visibleCount === 0 && items.length > 0) ? 'block' : 'none';
            }
        }

        function selectMatkulItem(name, prodiName, fakultasName) {
            const mainInput = document.getElementById('form_mata_kuliah') || document.getElementById('form_judul_agenda');
            if (mainInput) mainInput.value = name;
            if (fakultasName) {
                const fakSelect = document.getElementById('form_fakultas');
                if (fakSelect) {
                    fakSelect.value = fakultasName;
                    if (typeof filterJurusan === 'function') filterJurusan();
                }
            }
            if (prodiName) {
                const jurSelect = document.getElementById('form_jurusan');
                if (jurSelect) jurSelect.value = prodiName;
            }
            closeMatkulDropdown();
        }

        function selectCustomMatkulMode() {
            closeMatkulDropdown();
            const mainInput = document.getElementById('form_mata_kuliah') || document.getElementById('form_judul_agenda');
            if (mainInput) {
                mainInput.focus();
                mainInput.select();
            }
        }

        function handleMatkulDirectInput(val) {
            openMatkulDropdown();
            const searchInput = document.getElementById('matkul_search_input');
            if (searchInput) {
                searchInput.value = val;
                filterMatkulList(val);
            }
        }

        // ==========================================
        // AGEDA KELAS COMBOBOX FUNCTIONS
        // ==========================================
        function openAgendaKelasDropdown() {
            closeMatkulDropdown();
            const menu = document.getElementById('kelas_dropdown_menu');
            const icon = document.getElementById('kelas_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeAgendaKelasDropdown() {
            const menu = document.getElementById('kelas_dropdown_menu');
            const icon = document.getElementById('kelas_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleAgendaKelasDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('kelas_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openAgendaKelasDropdown();
            } else {
                closeAgendaKelasDropdown();
            }
        }

        function filterAgendaKelasList(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.agenda-kelas-item');
            items.forEach(item => {
                const val = (item.getAttribute('data-name') || '').toLowerCase();
                if (val.includes(q)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function selectAgendaKelasItem(val) {
            document.getElementById('form_kelas').value = val;
            closeAgendaKelasDropdown();
        }

        function handleAgendaKelasInput(val) {
            openAgendaKelasDropdown();
            filterAgendaKelasList(val);
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('matkul_combobox_wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeMatkulDropdown();
            }
            const kelasWrapper = document.getElementById('kelas_combobox_wrapper');
            if (kelasWrapper && !kelasWrapper.contains(e.target)) {
                closeAgendaKelasDropdown();
            }
        });

        function openAddModal() {
            document.getElementById('modal-agenda-title').innerText = 'Tambah Agenda Praktikum';
            const form = document.getElementById('agenda-form');
            form.action = "{{ route('admin.agenda.store') }}";
            document.getElementById('agenda-method').value = 'POST';
            
            document.getElementById('agenda_id').value = '';
            document.getElementById('form_dosen_pengampu_id').value = '';
            document.getElementById('form_dosen_id').value = '';
            document.getElementById('form_lab_id').value = '';
            const matkulEl = document.getElementById('form_mata_kuliah');
            if (matkulEl) matkulEl.value = '';
            const searchInputAdd = document.getElementById('matkul_search_input');
            if (searchInputAdd) searchInputAdd.value = '';
            filterMatkulList('');
            closeMatkulDropdown();

            document.getElementById('form_program_kuliah').value = 'Reguler';
            document.getElementById('form_tahun_akademik').value = '2026/2027 Ganjil';
            document.getElementById('form_jenis_pertemuan').value = 'Praktikum';
            document.getElementById('form_kelas').value = '';
            closeAgendaKelasDropdown();
            document.getElementById('form_semester').value = '';
            document.getElementById('form_fakultas').value = '';
            document.getElementById('form_jurusan').value = '';
            filterJurusan();
            document.getElementById('form_tanggal').value = '';
            document.getElementById('form_waktu_masuk').value = '';
            document.getElementById('form_waktu_keluar').value = '';
            document.getElementById('form_status_agenda').value = 'Otomatis';
            const materiEl = document.getElementById('form_materi_pembelajaran');
            if (materiEl) materiEl.value = '';
            
            toggleModal('modal-agenda');
        }

        function openEditModal(ag) {
            document.getElementById('modal-agenda-title').innerText = 'Edit Agenda Praktikum';
            const form = document.getElementById('agenda-form');
            form.action = "{{ url('/admin/agenda') }}/" + ag.id;
            document.getElementById('agenda-method').value = 'PUT';
            
            document.getElementById('agenda_id').value = ag.id;
            document.getElementById('form_dosen_pengampu_id').value = ag.dosen_pengampu_id || ag.dosen_id || '';
            document.getElementById('form_dosen_id').value = (ag.dosen_pengampu_id && ag.dosen_id != ag.dosen_pengampu_id) ? ag.dosen_id : '';
            document.getElementById('form_lab_id').value = ag.lab_id;
            const matkulEl = document.getElementById('form_mata_kuliah');
            if (matkulEl) matkulEl.value = ag.mata_kuliah || '';
            const searchInputEdit = document.getElementById('matkul_search_input');
            if (searchInputEdit) searchInputEdit.value = '';
            filterMatkulList('');
            closeMatkulDropdown();

            document.getElementById('form_program_kuliah').value = ag.program_kuliah || 'Reguler';
            document.getElementById('form_tahun_akademik').value = ag.tahun_akademik || '2026/2027 Ganjil';
            document.getElementById('form_jenis_pertemuan').value = ag.jenis_pertemuan || 'Praktikum';
            document.getElementById('form_kelas').value = ag.kelas || '';
            closeAgendaKelasDropdown();
            document.getElementById('form_semester').value = ag.semester || '';
            document.getElementById('form_fakultas').value = ag.fakultas || '';
            filterJurusan();
            document.getElementById('form_jurusan').value = ag.jurusan || '';
            document.getElementById('form_tanggal').value = ag.tanggal;
            document.getElementById('form_waktu_masuk').value = ag.jam_mulai ? ag.jam_mulai.substring(0,5) : '';
            document.getElementById('form_waktu_keluar').value = ag.jam_selesai ? ag.jam_selesai.substring(0,5) : '';
            document.getElementById('form_status_agenda').value = (ag.status_agenda === 'Dibatalkan') ? 'Dibatalkan' : 'Otomatis';
            const materiEl = document.getElementById('form_materi_pembelajaran');
            if (materiEl) materiEl.value = ag.catatan || '';
            
            toggleModal('modal-agenda');
        }
        function showImportLoading(form) {
            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput && fileInput.files && fileInput.files.length === 0) {
                return true;
            }
            setTimeout(() => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-1"></i> Memproses...';
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            }, 10);
            const overlay = document.getElementById('global-import-loading-overlay');
            if (overlay) {
                overlay.classList.remove('hidden');
            }
            return true;
        }

        window.addEventListener('pageshow', function() {
            const overlay = document.getElementById('global-import-loading-overlay');
            if (overlay) {
                overlay.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('global-import-loading-overlay');
            if (overlay) {
                overlay.classList.add('hidden');
            }
            document.querySelectorAll('form[enctype="multipart/form-data"]').forEach(function(form) {
                form.addEventListener('submit', function() {
                    showImportLoading(this);
                });
            });
        });

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function filterJurusan() {
            const fakultasVal = document.getElementById('form_fakultas').value;
            const jurusanSelect = document.getElementById('form_jurusan');
            const options = document.querySelectorAll('.jurusan-option');
            
            let foundMatch = false;
            
            options.forEach(opt => {
                if (fakultasVal === '' || opt.dataset.fakultas === fakultasVal) {
                    opt.style.display = '';
                    if (opt.value === jurusanSelect.value) foundMatch = true;
                } else {
                    opt.style.display = 'none';
                }
            });
            
            // if current value is hidden, reset selection
            if (!foundMatch && fakultasVal !== '') {
                jurusanSelect.value = '';
            }
        }
    </script>

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
    </script>
</body>
</html>




