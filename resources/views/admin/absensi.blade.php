<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white">
                <i class="fa-solid fa-user-shield text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">ADMIN CONTROL PANEL</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-line"></i>
                <span class="text-xs">Dashboard Overview</span>
            </a>
            <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-users-gear"></i>
                <span class="text-xs">Manajemen Pengguna</span>
            </a>
            <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-door-open"></i>
                <span class="text-xs">Manajemen Lab</span>
            </a>
            <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs">Jadwal & Agenda</span>
            </a>
            <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-3 bg-[#0d5c58] text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="text-xs">Laporan Absensi</span>
            </a>
            <a href="{{ route('admin.statistik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="text-xs">Statistik Kehadiran</span>
            </a>
            <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="text-xs">Data Akademik</span>
            </a>
            <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-bullhorn"></i>
                <span class="text-xs">Pengumuman Lab</span>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-rose-400 hover:text-rose-300 text-xs font-bold w-full transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Laporan Presensi Mahasiswa</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ auth()->user()->username }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">SUPER ADMIN</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr(auth()->user()->username, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Search & Filter Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm max-w-5xl">
                <form action="{{ route('admin.absensi') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end text-xs">
                    <div class="flex-grow w-full">
                        <label class="block text-slate-655 font-bold mb-1.5">Cari Agenda / Dosen</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mata kuliah atau nama dosen..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                        </div>
                    </div>
                    <div class="w-full sm:w-40">
                        <label class="block text-slate-650 font-bold mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div class="w-full sm:w-40">
                        <label class="block text-slate-650 font-bold mb-1.5">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="flex-grow sm:flex-grow-0 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'start_date', 'end_date', 'tanggal']))
                            <a href="{{ route('admin.absensi') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-all border border-slate-200 text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Attendance Logs Grouped Per Agenda -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden max-w-5xl">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Laporan Kehadiran Per Sesi Praktikum</h3>
                    <a href="{{ route('admin.absensi.export', request()->all()) }}" target="_blank" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-print"></i> Cetak/Ekspor Range Laporan
                    </a>
                </div>
                <div class="p-6 space-y-8">
                    @if($agendas->count() > 0)
                        @foreach($agendas as $ag)
                            <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50/20">
                                <!-- Agenda Info Header -->
                                <div class="bg-slate-100/70 border-b border-slate-200 px-5 py-3.5 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                            {{ $ag->mata_kuliah }}
                                            <span class="px-2 py-0.5 bg-teal-55 text-teal-800 border border-teal-100 rounded text-[9px] font-bold uppercase">Kelas {{ $ag->kelas ?: '-' }}</span>
                                        </h4>
                                        <p class="text-[10px] text-slate-500 font-semibold mt-1">
                                            Dosen: <span class="text-slate-700 font-bold">{{ $ag->dosen->nama }}</span>
                                            @if($ag->dosen_waktu_masuk)
                                                <span class="ml-1 px-1.5 py-0.5 bg-emerald-55 text-emerald-700 border border-emerald-100 rounded-md font-bold uppercase tracking-wider text-[8px]">
                                                    <i class="fa-solid fa-circle-check"></i> Masuk: {{ date('H:i:s', strtotime($ag->dosen_waktu_masuk)) }} WIB
                                                </span>
                                            @else
                                                <span class="ml-1 px-1.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded-md font-bold uppercase tracking-wider text-[8px]">
                                                    <i class="fa-solid fa-circle-xmark"></i> Belum Check-in
                                                </span>
                                            @endif
                                            • {{ $ag->lab->nama_lab }} ({{ $ag->lab->lokasi }})
                                        </p>
                                    </div>
                                    <div class="text-right text-[10px] font-semibold text-slate-500 bg-white border border-slate-200 rounded-lg px-3 py-1.5 shadow-xs">
                                        <i class="fa-solid fa-calendar-day text-teal-700 mr-1"></i>{{ date('d F Y', strtotime($ag->tanggal)) }} | {{ substr($ag->jam_mulai, 0, 5) }} - {{ substr($ag->jam_selesai, 0, 5) }} WIB
                                    </div>
                                </div>
                                
                                <!-- Students attendance table -->
                                <div class="p-4 bg-white">
                                    @if($ag->absensi->count() > 0)
                                        <div class="overflow-x-auto rounded-lg border border-slate-100 text-xs">
                                            <table class="w-full text-left text-slate-655">
                                                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                                    <tr>
                                                        <th class="p-3">No</th>
                                                        <th class="p-3">Mahasiswa (NIM)</th>
                                                        <th class="p-3">Waktu Masuk</th>
                                                        <th class="p-3 text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-100">
                                                    @foreach($ag->absensi as $index => $abs)
                                                        <tr class="hover:bg-slate-50/50 transition">
                                                            <td class="p-3 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                                            <td class="p-3">
                                                                <span class="font-bold text-slate-800 block text-xs">{{ $abs->mahasiswa->nama_lengkap }}</span>
                                                                <span class="text-[10px] font-mono text-teal-800 font-semibold">NIM: {{ $abs->mahasiswa->nim }}</span>
                                                            </td>
                                                            <td class="p-3 font-mono text-slate-500">{{ date('H:i:s', strtotime($abs->waktu_masuk)) }} WIB</td>
                                                            <td class="p-3 text-center">
                                                                <span class="px-2 py-0.5 border font-bold rounded text-[9px] uppercase tracking-wider
                                                                    @if(strtolower($abs->status_kehadiran) === 'hadir') bg-emerald-50 text-emerald-700 border-emerald-100
                                                                    @elseif(strtolower($abs->status_kehadiran) === 'terlambat') bg-amber-50 text-amber-700 border-amber-100
                                                                    @elseif(strtolower($abs->status_kehadiran) === 'izin' || strtolower($abs->status_kehadiran) === 'sakit') bg-blue-50 text-blue-755 border-blue-100
                                                                    @else bg-rose-50 text-rose-750 border-rose-100
                                                                    @endif">
                                                                    {{ $abs->status_kehadiran }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-center py-4 text-[11px] text-slate-400 italic"><i class="fa-solid fa-triangle-exclamation mr-1 text-amber-500"></i> Belum ada mahasiswa yang melakukan absensi pada sesi ini.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-4">
                            {{ $agendas->links() }}
                        </div>
                    @else
                        <p class="text-center py-10 text-slate-400 italic">Data agenda praktikum tidak ditemukan.</p>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg text-[9px] font-medium text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-chart-line text-lg"></i>
            <span>Overview</span>
        </a>
        <a href="{{ route('admin.pengguna') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-users-gear text-lg"></i>
            <span>Pengguna</span>
        </a>
        <a href="{{ route('admin.laboratorium') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-door-open text-lg"></i>
            <span>Lab</span>
        </a>
        <a href="{{ route('admin.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-calendar-days text-lg"></i>
            <span>Agenda</span>
        </a>
        <a href="{{ route('admin.absensi') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-855 font-bold">
            <i class="fa-solid fa-file-invoice text-lg"></i>
            <span>Absen</span>
        </a>
    </nav>

</body>
</html>
