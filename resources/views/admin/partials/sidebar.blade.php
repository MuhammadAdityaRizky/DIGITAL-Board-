<!-- Sidebar Admin -->
<aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 h-screen sticky top-0 hidden lg:flex">
    <div class="p-5 flex items-center gap-3 border-b border-slate-800 shrink-0">
        <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white shrink-0 shadow-sm">
            <i class="fa-solid fa-user-shield text-lg"></i>
        </div>
        <div>
            <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
            <p class="text-[10px] font-semibold text-teal-400 tracking-wider">ADMIN CONTROL PANEL</p>
        </div>
    </div>
    
    <nav class="flex-1 min-h-0 px-3 py-3 space-y-1 overflow-y-auto custom-sidebar-scroll">
        <!-- 1. Dashboard Overview -->
        @php
            $isDashboard = request()->routeIs('admin.dashboard');
        @endphp
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isDashboard ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-chart-line"></i>
            <span class="text-xs">Dashboard Overview</span>
        </a>

        <!-- 2. Manajemen Pengguna -->
        @php
            $isPengguna = request()->routeIs('admin.pengguna*');
        @endphp
        <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isPengguna ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-users-gear"></i>
            <span class="text-xs">Manajemen Pengguna</span>
        </a>

        <!-- 3. Manajemen Lab -->
        @php
            $isLab = request()->routeIs('admin.laboratorium*');
        @endphp
        <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isLab ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-door-open"></i>
            <span class="text-xs">Manajemen Lab</span>
        </a>

        <!-- 4. Jadwal & Agenda -->
        @php
            $isAgenda = request()->routeIs('admin.agenda*') || request()->routeIs('admin.jadwal-lab*');
        @endphp
        <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isAgenda ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-calendar-days"></i>
            <span class="text-xs">Jadwal & Agenda</span>
        </a>

        <!-- 5. Laporan Absensi -->
        @php
            $isAbsensi = request()->routeIs('admin.absensi*');
        @endphp
        <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isAbsensi ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-file-invoice"></i>
            <span class="text-xs">Laporan Absensi</span>
        </a>

        <!-- 6. Statistik Kehadiran -->
        @php
            $isStatistik = request()->routeIs('admin.statistik*');
        @endphp
        <a href="{{ route('admin.statistik') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isStatistik ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-chart-pie"></i>
            <span class="text-xs">Statistik Kehadiran</span>
        </a>

        <!-- 7. Data Akademik -->
        @php
            $isAkademik = request()->routeIs('admin.akademik*');
        @endphp
        <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isAkademik ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-graduation-cap"></i>
            <span class="text-xs">Data Akademik</span>
        </a>

        <!-- 8. Pengumuman Lab -->
        @php
            $isPengumuman = request()->routeIs('admin.pengumuman*');
        @endphp
        <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isPengumuman ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-bullhorn"></i>
            <span class="text-xs">Pengumuman Lab</span>
        </a>
        
        <!-- 9. Riwayat Aktivitas -->
        @php
            $isAktivitas = request()->routeIs('admin.aktivitas*');
        @endphp
        <a href="{{ route('admin.aktivitas') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isAktivitas ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span class="text-xs">Riwayat Aktivitas</span>
        </a>

        <!-- External Link: Portal Display Board -->
        <div class="pt-2 border-t border-slate-800/80 my-2"></div>
        <a href="{{ route('board') }}" target="_blank" class="flex items-center justify-between px-4 py-2.5 bg-[#0c4ea6]/40 hover:bg-[#0c4ea6] text-teal-300 hover:text-white rounded-xl w-full transition font-bold border border-teal-500/20">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-desktop text-emerald-400"></i>
                <span class="text-xs">Portal Display Board</span>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
        </a>
    </nav>
</aside>
