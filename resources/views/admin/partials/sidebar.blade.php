@php
    $user = auth()->user();
    $isSuperAdmin = $user?->isSuperAdmin();
    $isAdminFakultas = $user?->isAdminFakultas();
    $fakultasNama = $user?->fakultas->nama_fakultas ?? 'FAKULTAS';

    $isDashboard = request()->routeIs('admin.dashboard');
    $isPengguna = request()->routeIs('admin.pengguna*');
    $isLab = request()->routeIs('admin.laboratorium*');
    $isAgenda = request()->routeIs('admin.agenda*') || request()->routeIs('admin.jadwal-lab*');
    $isAbsensi = request()->routeIs('admin.absensi*');
    $isAkademik = request()->routeIs('admin.akademik*');
    $isPengumuman = request()->routeIs('admin.pengumuman*');
    $isAktivitas = request()->routeIs('admin.aktivitas*');
@endphp

<!-- Desktop Sidebar Admin -->
<aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 h-screen sticky top-0 hidden lg:flex">
    <div class="p-4 flex items-center gap-3 border-b border-slate-800 shrink-0">
        <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-10 h-10 object-contain shrink-0 drop-shadow-sm">
        <div>
            <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
            <p class="text-[10px] font-semibold text-teal-400 tracking-wider">
                @if($isSuperAdmin)
                    SUPER ADMIN
                @elseif($isAdminFakultas)
                    ADMIN {{ strtoupper($fakultasNama) }}
                @else
                    ADMIN CONTROL PANEL
                @endif
            </p>
        </div>
    </div>
    
    <nav class="flex-1 min-h-0 px-3 py-3 space-y-1 overflow-y-auto custom-sidebar-scroll">
        <!-- 1. Dashboard Overview -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isDashboard ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-chart-line"></i>
            <span class="text-xs">Dashboard Overview</span>
        </a>

        <!-- 2. Manajemen Pengguna -->
        <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isPengguna ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-users-gear"></i>
            <span class="text-xs">Manajemen Pengguna</span>
        </a>

        <!-- 3. Manajemen Lab -->
        <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isLab ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-door-open"></i>
            <span class="text-xs">Manajemen Lab</span>
        </a>

        <!-- 4. Jadwal & Agenda -->
        <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isAgenda ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-calendar-days"></i>
            <span class="text-xs">Jadwal & Agenda</span>
        </a>

        <!-- 5. Laporan Absensi -->
        <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isAbsensi ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-file-invoice"></i>
            <span class="text-xs">Laporan Absensi</span>
        </a>

        @if($isSuperAdmin)
        <!-- 7. Data Akademik -->
        <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isAkademik ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-graduation-cap"></i>
            <span class="text-xs">Data Akademik</span>
        </a>
        @endif

        <!-- 8. Pengumuman Lab -->
        <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-2.5 {{ $isPengumuman ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-bullhorn"></i>
            <span class="text-xs">Pengumuman Lab</span>
        </a>
        
        <!-- 9. Riwayat Aktivitas -->
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

<!-- Mobile Sidebar Overlay & Drawer -->
<div id="adminMobileSidebarBackdrop" onclick="toggleAdminMobileSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden lg:hidden transition-opacity opacity-0 duration-300"></div>

<aside id="adminMobileSidebarDrawer" class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-white flex flex-col z-50 shadow-2xl lg:hidden transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-4 flex items-center justify-between border-b border-slate-800 shrink-0">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-9 h-9 object-contain shrink-0 drop-shadow-sm">
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">
                    @if($isSuperAdmin)
                        SUPER ADMIN
                    @elseif($isAdminFakultas)
                        ADMIN {{ strtoupper($fakultasNama) }}
                    @else
                        ADMIN CONTROL PANEL
                    @endif
                </p>
            </div>
        </div>
        <button type="button" onclick="toggleAdminMobileSidebar()" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white flex items-center justify-center transition">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
    
    <nav class="flex-1 min-h-0 px-3 py-3 space-y-1 overflow-y-auto custom-sidebar-scroll">
        <!-- 1. Dashboard Overview -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ $isDashboard ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-chart-line text-sm"></i>
            <span class="text-xs">Dashboard Overview</span>
        </a>

        <!-- 2. Manajemen Pengguna -->
        <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-3 {{ $isPengguna ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-users-gear text-sm"></i>
            <span class="text-xs">Manajemen Pengguna</span>
        </a>

        <!-- 3. Manajemen Lab -->
        <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-3 {{ $isLab ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-door-open text-sm"></i>
            <span class="text-xs">Manajemen Lab</span>
        </a>

        <!-- 4. Jadwal & Agenda -->
        <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-3 {{ $isAgenda ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-calendar-days text-sm"></i>
            <span class="text-xs">Jadwal & Agenda</span>
        </a>

        <!-- 5. Laporan Absensi -->
        <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-3 {{ $isAbsensi ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-file-invoice text-sm"></i>
            <span class="text-xs">Laporan Absensi</span>
        </a>

        @if($isSuperAdmin)
        <!-- 7. Data Akademik -->
        <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-3 {{ $isAkademik ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-graduation-cap text-sm"></i>
            <span class="text-xs">Data Akademik</span>
        </a>
        @endif

        <!-- 8. Pengumuman Lab -->
        <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-3 {{ $isPengumuman ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-bullhorn text-sm"></i>
            <span class="text-xs">Pengumuman Lab</span>
        </a>
        
        <!-- 9. Riwayat Aktivitas -->
        <a href="{{ route('admin.aktivitas') }}" class="flex items-center gap-3 px-4 py-3 {{ $isAktivitas ? 'bg-teal-800 text-white font-bold shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white font-medium' }} rounded-xl w-full transition">
            <i class="fa-solid fa-clock-rotate-left text-sm"></i>
            <span class="text-xs">Riwayat Aktivitas</span>
        </a>

        <!-- External Link: Portal Display Board -->
        <div class="pt-2 border-t border-slate-800/80 my-2"></div>
        <a href="{{ route('board') }}" target="_blank" class="flex items-center justify-between px-4 py-3 bg-[#0c4ea6]/40 hover:bg-[#0c4ea6] text-teal-300 hover:text-white rounded-xl w-full transition font-bold border border-teal-500/20">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-desktop text-emerald-400"></i>
                <span class="text-xs">Portal Display Board</span>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
        </a>
    </nav>
</aside>

<script>
    function toggleAdminMobileSidebar() {
        const backdrop = document.getElementById('adminMobileSidebarBackdrop');
        const drawer = document.getElementById('adminMobileSidebarDrawer');
        if (!backdrop || !drawer) return;
        
        const isHidden = drawer.classList.contains('-translate-x-full');
        if (isHidden) {
            backdrop.classList.remove('hidden');
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                drawer.classList.remove('-translate-x-full');
            });
            document.body.classList.add('overflow-hidden');
        } else {
            backdrop.classList.add('opacity-0');
            drawer.classList.add('-translate-x-full');
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }
    }
</script>
