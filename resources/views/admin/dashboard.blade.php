<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Digital Board</title>
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
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
            <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Administrator Console</h2>
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

        <!-- Content scrollable -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-slate-900 to-teal-950 text-white rounded-2xl p-6 shadow-md relative overflow-hidden flex flex-col justify-between gap-4">
                <div class="space-y-1 z-10">
                    <p class="text-xs font-medium text-teal-400 uppercase tracking-widest">CONTROL PANEL</p>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight">Selamat Datang, {{ auth()->user()->username }}</h2>
                    <p class="text-xs text-slate-300 font-medium">Sistem Digital Display Board - Manajemen Cerdas Laboratorium</p>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 text-xs">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl"><i class="fa-solid fa-users text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Total Users</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $usersCount }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-teal-50 text-teal-600 rounded-xl"><i class="fa-solid fa-chalkboard-user text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Dosen</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $dosenCount }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl"><i class="fa-solid fa-user-graduate text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Mahasiswa</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $mhsCount }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl"><i class="fa-solid fa-door-open text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Labs</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $labCount }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4 col-span-2 lg:col-span-1">
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-xl"><i class="fa-solid fa-calendar-check text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Agendas</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $agendaCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Dashboard Split Layout -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Left Section: Today Attendance Summary -->
                <div class="xl:col-span-2 space-y-6">
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden p-6 space-y-4">
                        <h3 class="font-bold text-sm text-slate-800 flex items-center gap-2"><i class="fa-solid fa-chart-simple text-teal-850"></i> Statistik Presensi Hari Ini ({{ date('d F Y') }})</h3>
                        
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
                                <span class="block text-xl font-bold text-emerald-800">{{ $todayHadir }}</span>
                                <span class="text-[10px] font-semibold text-emerald-600 uppercase tracking-wider">Hadir</span>
                            </div>
                            <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl">
                                <span class="block text-xl font-bold text-blue-800">{{ $todayIzin }}</span>
                                <span class="text-[10px] font-semibold text-blue-600 uppercase tracking-wider">Izin</span>
                            </div>
                            <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl">
                                <span class="block text-xl font-bold text-rose-800">{{ $todayAlpa }}</span>
                                <span class="text-[10px] font-semibold text-rose-600 uppercase tracking-wider">Alpa</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Attendance Log -->
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                        <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                            <h3 class="font-bold text-sm text-slate-800">Aktivitas Presensi Terbaru</h3>
                            <a href="{{ route('admin.absensi') }}" class="text-xs text-teal-700 hover:underline font-bold">Lihat Semua</a>
                        </div>
                        <div class="p-6">
                            @if($recentAbsensi->count() > 0)
                                <div class="overflow-x-auto text-xs">
                                    <table class="w-full text-left text-slate-600">
                                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b">
                                            <tr>
                                                <th class="p-3">Nama / NIM</th>
                                                <th class="p-3">Mata Kuliah / Lab</th>
                                                <th class="p-3">Waktu Scan</th>
                                                <th class="p-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($recentAbsensi as $abs)
                                                <tr class="hover:bg-slate-50/50 transition">
                                                    <td class="p-3">
                                                        <span class="font-bold text-slate-800 block">{{ $abs->mahasiswa->nama_lengkap }}</span>
                                                        <span class="text-[9px] font-mono text-slate-400">{{ $abs->mahasiswa->nim }}</span>
                                                    </td>
                                                    <td class="p-3">
                                                        <span class="font-semibold text-slate-700 block">{{ $abs->agenda->mata_kuliah }}</span>
                                                        <span class="text-[9px] text-slate-450"><i class="fa-solid fa-location-dot mr-1"></i> {{ $abs->agenda->lab->nama_lab }}</span>
                                                    </td>
                                                    <td class="p-3 font-mono text-slate-500">{{ $abs->waktu_masuk }}</td>
                                                    <td class="p-3">
                                                        <span class="px-2 py-0.5 {{ strtolower($abs->status_kehadiran) === 'hadir' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-blue-50 text-blue-700 border-blue-100' }} border font-bold rounded text-[9px] uppercase">
                                                            {{ $abs->status_kehadiran }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center py-6 text-slate-400 italic">Belum ada aktivitas presensi hari ini.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Section: Quick Links -->
                <div class="space-y-6">
                    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm space-y-4">
                        <h3 class="font-bold text-sm text-slate-800 border-b pb-3 flex items-center gap-1.5"><i class="fa-solid fa-link text-teal-850"></i> Navigasi Cepat</h3>
                        
                        <div class="grid grid-cols-1 gap-2.5 text-xs font-semibold">
                            <a href="{{ route('admin.pengguna') }}" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition">
                                <span class="flex items-center gap-2 text-slate-800"><i class="fa-solid fa-users-gear text-teal-700 text-sm"></i> Kelola Pengguna</span>
                                <i class="fa-solid fa-chevron-right text-slate-400"></i>
                            </a>
                            <a href="{{ route('admin.laboratorium') }}" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition">
                                <span class="flex items-center gap-2 text-slate-800"><i class="fa-solid fa-door-open text-teal-700 text-sm"></i> Kelola Laboratorium</span>
                                <i class="fa-solid fa-chevron-right text-slate-400"></i>
                            </a>
                            <a href="{{ route('admin.agenda') }}" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition">
                                <span class="flex items-center gap-2 text-slate-800"><i class="fa-solid fa-calendar-days text-teal-700 text-sm"></i> Monitoring Agenda Dosen</span>
                                <i class="fa-solid fa-chevron-right text-slate-400"></i>
                            </a>
                            <a href="{{ route('admin.absensi') }}" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition">
                                <span class="flex items-center gap-2 text-slate-800"><i class="fa-solid fa-file-invoice text-teal-700 text-sm"></i> Laporan Kehadiran</span>
                                <i class="fa-solid fa-chevron-right text-slate-400"></i>
                            </a>
                            <a href="{{ route('admin.pengumuman') }}" class="p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-between transition">
                                <span class="flex items-center gap-2 text-slate-800"><i class="fa-solid fa-bullhorn text-teal-700 text-sm"></i> Terbitkan Pengumuman</span>
                                <i class="fa-solid fa-chevron-right text-slate-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg text-[9px] font-medium text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-855 font-bold">
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
        <a href="{{ route('admin.absensi') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-file-invoice text-lg"></i>
            <span>Absen</span>
        </a>
    </nav>

</body>
</html>
