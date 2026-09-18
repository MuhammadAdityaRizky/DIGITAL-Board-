<!-- Bottom Navigation Bar (Mobile Only - 5 Equal Symmetrical Flex Slots) -->
<nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t-2 border-slate-200 flex items-center justify-between px-1 z-40 lg:hidden shadow-xl">
    <!-- 1. Dashboard -->
    <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center flex-1 py-1 {{ request()->routeIs('dosen.dashboard') ? 'text-teal-800 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-bold' }}">
        <i class="fa-solid fa-border-all text-base"></i>
        <span class="text-[10px] tracking-tight mt-0.5">Dashboard</span>
    </a>

    <!-- 2. Agenda -->
    <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center flex-1 py-1 {{ request()->routeIs('dosen.agenda*') ? 'text-teal-800 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-bold' }}">
        <i class="fa-solid fa-calendar-alt text-base"></i>
        <span class="text-[10px] tracking-tight mt-0.5">Agenda</span>
    </a>

    <!-- 3. Dead Center Floating QR Button -->
    <div class="flex-1 flex justify-center items-center">
        <div class="relative flex-shrink-0 flex justify-center items-center -mt-6">
            <button type="button" onclick="startDosenQRScanner()" class="w-13 h-13 rounded-2xl bg-teal-800 hover:bg-teal-900 text-white flex items-center justify-center shadow-lg border-4 border-white transition-all transform active:scale-95 cursor-pointer" title="Scan QR Presensi Board">
                <i class="fa-solid fa-qrcode text-xl text-white"></i>
            </button>
        </div>
    </div>

    <!-- 4. Jadwal Lab -->
    <a href="{{ route('dosen.jadwal-lab') }}" class="flex flex-col justify-center items-center flex-1 py-1 {{ request()->routeIs('dosen.jadwal-lab*') ? 'text-teal-800 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-bold' }}">
        <i class="fa-solid fa-calendar-check text-base"></i>
        <span class="text-[10px] tracking-tight mt-0.5">Jadwal Lab</span>
    </a>

    <!-- 5. Panduan Sistem -->
    <button type="button" onclick="openTutorialDosenModal()" class="flex flex-col justify-center items-center flex-1 py-1 text-slate-500 hover:text-slate-800 font-bold cursor-pointer">
        <i class="fa-solid fa-circle-question text-base text-amber-600"></i>
        <span class="text-[10px] tracking-tight mt-0.5">Panduan</span>
    </button>
</nav>
