<!-- Mobile Bottom Navigation for Admin -->
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-40 flex justify-around items-center text-slate-500 text-[10px] shadow-lg">
    @php
        $isDashboard = request()->routeIs('admin.dashboard');
        $isPengguna = request()->routeIs('admin.pengguna*');
        $isLab = request()->routeIs('admin.laboratorium*');
        $isAgenda = request()->routeIs('admin.agenda*') || request()->routeIs('admin.jadwal-lab*');
        $isAbsensi = request()->routeIs('admin.absensi*');
    @endphp

    <a href="{{ route('admin.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 {{ $isDashboard ? 'text-teal-700 font-bold' : 'hover:text-slate-800' }}">
        <i class="fa-solid fa-chart-line text-lg"></i>
        <span>Overview</span>
    </a>
    <a href="{{ route('admin.pengguna') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 {{ $isPengguna ? 'text-teal-700 font-bold' : 'hover:text-slate-800' }}">
        <i class="fa-solid fa-users-gear text-lg"></i>
        <span>Pengguna</span>
    </a>
    <a href="{{ route('admin.laboratorium') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 {{ $isLab ? 'text-teal-700 font-bold' : 'hover:text-slate-800' }}">
        <i class="fa-solid fa-door-open text-lg"></i>
        <span>Lab</span>
    </a>
    <a href="{{ route('admin.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 {{ $isAgenda ? 'text-teal-700 font-bold' : 'hover:text-slate-800' }}">
        <i class="fa-solid fa-calendar-days text-lg"></i>
        <span>Agenda</span>
    </a>
    <a href="{{ route('admin.absensi') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 {{ $isAbsensi ? 'text-teal-700 font-bold' : 'hover:text-slate-800' }}">
        <i class="fa-solid fa-file-invoice text-lg"></i>
        <span>Absen</span>
    </a>
</nav>
