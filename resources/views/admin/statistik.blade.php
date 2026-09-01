<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Kehadiran - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
            <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="text-xs">Laporan Absensi</span>
            </a>
            <a href="{{ route('admin.statistik') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Statistik Kehadiran Mahasiswa</h2>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left: Selector Card (Checkboxes of Agendas) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm"><i class="fa-solid fa-filter text-teal-700 mr-1.5"></i> Pilih Jadwal / Agenda</h3>
                        <p class="text-[10px] text-slate-450 mt-0.5">Centang satu atau lebih kelas untuk membandingkan statistik kehadiran secara real-time.</p>
                    </div>

                    <form action="{{ route('admin.statistik') }}" method="GET" class="space-y-4">
                        <div class="max-h-[350px] overflow-y-auto space-y-2.5 border border-slate-100 p-3 rounded-xl bg-slate-50/50">
                            @if($allAgendas->count() > 0)
                                @foreach($allAgendas as $ag)
                                    <label class="flex items-start gap-3 p-2 rounded-lg bg-white border border-slate-200 hover:border-teal-700 transition cursor-pointer text-xs">
                                        <input type="checkbox" name="agenda_ids[]" value="{{ $ag->id }}" 
                                               {{ in_array($ag->id, $selectedAgendaIds) ? 'checked' : '' }}
                                               class="mt-0.5 rounded text-teal-800 border-slate-300 focus:ring-teal-700/30">
                                        <div class="min-w-0 flex-1">
                                            <span class="font-bold text-slate-800 block truncate">{{ $ag->mata_kuliah }}</span>
                                            <span class="text-[10px] text-slate-500 font-semibold block mt-0.5">
                                                Kelas: {{ $ag->kelas ?: '-' }} • Semester: {{ $ag->semester ?: '1' }}
                                            </span>
                                            <span class="text-[9px] text-slate-400 font-mono block">
                                                {{ date('d M Y', strtotime($ag->tanggal)) }} | {{ substr($ag->jam_mulai,0,5) }} WIB
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            @else
                                <p class="text-slate-400 italic text-center py-8 text-xs">Belum ada agenda terdaftar.</p>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="flex-grow py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition shadow-sm font-semibold">
                                Terapkan Analisis
                            </button>
                            <a href="{{ route('admin.statistik') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center justify-center">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Right: Summary Dashboard -->
                <div class="lg:col-span-2 space-y-6">
                    @if(!empty($selectedAgendaIds))
                        <!-- Statistics Bento Cards -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                <div class="p-3 bg-teal-50 text-teal-700 rounded-xl"><i class="fa-solid fa-chart-line text-base"></i></div>
                                <div>
                                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Tingkat Kehadiran</p>
                                    <p class="text-lg font-bold text-slate-800">{{ $summary['rate'] }}%</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                <div class="p-3 bg-emerald-50 text-emerald-700 rounded-xl"><i class="fa-solid fa-circle-check text-base"></i></div>
                                <div>
                                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Total Hadir</p>
                                    <p class="text-lg font-bold text-slate-800">{{ $summary['hadir'] }} Scan</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                <div class="p-3 bg-rose-50 text-rose-700 rounded-xl"><i class="fa-solid fa-circle-xmark text-base"></i></div>
                                <div>
                                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Total Alpa</p>
                                    <p class="text-lg font-bold text-slate-800">{{ $summary['alpa'] }} Sesi</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                <div class="p-3 bg-blue-50 text-blue-700 rounded-xl"><i class="fa-solid fa-user-clock text-base"></i></div>
                                <div>
                                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Total Izin</p>
                                    <p class="text-lg font-bold text-slate-800">{{ $summary['izin'] }} Sesi</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3 col-span-2 sm:col-span-1">
                                <div class="p-3 bg-amber-50 text-amber-700 rounded-xl"><i class="fa-solid fa-hand-holding-medical text-base"></i></div>
                                <div>
                                    <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider">Total Sakit</p>
                                    <p class="text-lg font-bold text-slate-800">{{ $summary['sakit'] }} Sesi</p>
                                </div>
                            </div>
                        </div>

                        <!-- Graph Progress Chart -->
                        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm space-y-4">
                            <h4 class="font-bold text-slate-800 text-xs">Proporsi Kehadiran Mahasiswa</h4>
                            <div class="space-y-3.5">
                                @php
                                    $totalAll = $summary['hadir'] + $summary['izin'] + $summary['sakit'] + $summary['alpa'];
                                    $hadirPct = $totalAll > 0 ? round(($summary['hadir'] / $totalAll) * 100) : 0;
                                    $izinPct = $totalAll > 0 ? round(($summary['izin'] / $totalAll) * 100) : 0;
                                    $sakitPct = $totalAll > 0 ? round(($summary['sakit'] / $totalAll) * 100) : 0;
                                    $alpaPct = $totalAll > 0 ? round(($summary['alpa'] / $totalAll) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-[10px] font-semibold mb-1 text-slate-600">
                                        <span>Hadir ({{ $summary['hadir'] }})</span>
                                        <span>{{ $hadirPct }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-teal-700 h-full rounded-full transition-all duration-500" style="width: {{ $hadirPct }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[10px] font-semibold mb-1 text-slate-600">
                                        <span>Izin ({{ $summary['izin'] }})</span>
                                        <span>{{ $izinPct }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-blue-600 h-full rounded-full transition-all duration-500" style="width: {{ $izinPct }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[10px] font-semibold mb-1 text-slate-600">
                                        <span>Sakit ({{ $summary['sakit'] }})</span>
                                        <span>{{ $sakitPct }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-[#e99c1c] h-full rounded-full transition-all duration-500" style="width: {{ $sakitPct }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-[10px] font-semibold mb-1 text-slate-600">
                                        <span>Alpa ({{ $summary['alpa'] }})</span>
                                        <span>{{ $alpaPct }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-rose-500 h-full rounded-full transition-all duration-500" style="width: {{ $alpaPct }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-16 text-center shadow-sm">
                            <i class="fa-solid fa-chart-line text-slate-300 text-5xl block mb-3"></i>
                            <h4 class="font-bold text-slate-700 text-sm">Tidak Ada Data Yang Ditampilkan</h4>
                            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Silakan pilih satu atau beberapa jadwal perkuliahan pada panel filter di sebelah kiri untuk menganalisis statistik absensi.</p>
                        </div>
                    @endif
                </div>
            </div>

            @if(!empty($selectedAgendaIds) && $agendas->count() > 0)
            <!-- Agenda breakdown table -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4">
                    <h3 class="font-bold text-xs text-slate-800">Detail Performa Kehadiran Per Kelas</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full text-xs text-left text-slate-650">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="p-3.5">Mata Kuliah / Agenda</th>
                                    <th class="p-3.5">Kelas & Sem</th>
                                    <th class="p-3.5">Dosen Pengajar</th>
                                    <th class="p-3.5 text-center">Hadir</th>
                                    <th class="p-3.5 text-center">Izin</th>
                                    <th class="p-3.5 text-center">Sakit</th>
                                    <th class="p-3.5 text-center">Alpa</th>
                                    <th class="p-3.5 text-center">Rasio</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($agendas as $ag)
                                    @php
                                        $h = $ag->absensi->whereIn('status_kehadiran', ['Hadir', 'Terlambat'])->count();
                                        $i = $ag->absensi->where('status_kehadiran', 'Izin')->count();
                                        $s = $ag->absensi->where('status_kehadiran', 'Sakit')->count();
                                        $a = $ag->absensi->where('status_kehadiran', 'Alpa')->count();
                                        $tot = $h + $i + $s + $a;
                                        $ratio = $tot > 0 ? round(($h / $tot) * 100, 1) : 100;
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="p-3.5">
                                            <span class="font-bold text-slate-800 block text-xs">{{ $ag->mata_kuliah }}</span>
                                            <span class="text-[9px] text-slate-400 font-mono block mt-0.5">{{ date('d F Y', strtotime($ag->tanggal)) }}</span>
                                        </td>
                                        <td class="p-3.5 font-medium text-slate-700">Kelas {{ $ag->kelas ?: '-' }} • S{{ $ag->semester ?: '1' }}</td>
                                        <td class="p-3.5 text-slate-600 font-semibold">{{ $ag->dosen->nama }}</td>
                                        <td class="p-3.5 text-center font-bold text-emerald-600">{{ $h }}</td>
                                        <td class="p-3.5 text-center font-bold text-blue-600">{{ $i }}</td>
                                        <td class="p-3.5 text-center font-bold text-[#d89115]">{{ $s }}</td>
                                        <td class="p-3.5 text-center font-bold text-rose-500">{{ $a }}</td>
                                        <td class="p-3.5 text-center font-mono font-extrabold text-teal-850">{{ $ratio }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Student analytics list -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4">
                    <h3 class="font-bold text-xs text-slate-800">Analisis Kehadiran Per Mahasiswa</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full text-xs text-left text-slate-650">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="p-3.5">Nama Mahasiswa</th>
                                    <th class="p-3.5">NIM</th>
                                    <th class="p-3.5">Kelas & Semester</th>
                                    <th class="p-3.5 text-center">Hadir</th>
                                    <th class="p-3.5 text-center">Izin</th>
                                    <th class="p-3.5 text-center">Sakit</th>
                                    <th class="p-3.5 text-center">Alpa</th>
                                    <th class="p-3.5 text-center">Total Sesi</th>
                                    <th class="p-3.5 text-center">Kehadiran (%)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($studentStats as $stat)
                                    @php
                                        $ratio = $stat['total'] > 0 ? round(($stat['hadir'] / $stat['total']) * 100, 1) : 100;
                                        $m = $stat['mahasiswa'];
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="p-3.5">
                                            <span class="font-bold text-slate-800 block text-xs">{{ $m->nama_lengkap }}</span>
                                            <span class="text-[9px] text-slate-400 block mt-0.5">{{ $m->prodi->nama_prodi ?? '-' }}</span>
                                        </td>
                                        <td class="p-3.5 font-mono text-teal-855 font-semibold">NIM: {{ $m->nim }}</td>
                                        <td class="p-3.5 text-slate-600 font-medium">Kelas {{ $m->kelas }} • Sem {{ $m->semester }}</td>
                                        <td class="p-3.5 text-center font-bold text-emerald-600">{{ $stat['hadir'] }}</td>
                                        <td class="p-3.5 text-center font-bold text-blue-600">{{ $stat['izin'] }}</td>
                                        <td class="p-3.5 text-center font-bold text-[#d89115]">{{ $stat['sakit'] }}</td>
                                        <td class="p-3.5 text-center font-bold text-rose-500">{{ $stat['alpa'] }}</td>
                                        <td class="p-3.5 text-center font-bold text-slate-700 font-mono">{{ $stat['total'] }}</td>
                                        <td class="p-3.5 text-center font-mono">
                                            <span class="px-2 py-0.5 rounded font-extrabold text-[10px] 
                                                @if($ratio >= 80) bg-emerald-50 text-emerald-705 border border-emerald-100
                                                @elseif($ratio >= 50) bg-amber-50 text-amber-705 border border-amber-100
                                                @else bg-rose-50 text-rose-700 border border-rose-100
                                                @endif">
                                                {{ $ratio }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </main>

</body>
</html>
