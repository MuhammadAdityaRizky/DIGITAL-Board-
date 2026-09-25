<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ketersediaan & Jadwal Lab - Portal Dosen DIGITAL Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .smooth-scroll {
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: contain;
        }
        .pulse-live {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.04); }
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex shadow-xl z-20">
        <div class="p-5 flex items-center gap-3 border-b border-slate-800 shrink-0">
            <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-10 h-10 object-contain shrink-0">
            <div>
                <h1 class="font-bold text-sm leading-tight text-white">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">PORTAL DOSEN</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-3 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-border-all text-sm"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-calendar-alt text-sm"></i>
                <span>Agenda Perkuliahan</span>
            </a>
            <a href="{{ route('dosen.jadwal-lab') }}" class="flex items-center gap-3 px-4 py-2.5 bg-teal-800 text-white font-bold shadow-sm rounded-xl w-full text-xs">
                <i class="fa-solid fa-calendar-check text-sm"></i>
                <span>Ketersediaan Lab</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-gear text-sm"></i>
                <span>Pengaturan Akun</span>
            </a>
        </nav>

        <!-- Tombol Panduan Dosen di Sidebar -->
        <div class="p-3 border-t border-slate-800 mt-auto">
            <button type="button" onclick="openTutorialDosenModal()" class="min-h-[44px] flex items-center gap-3 px-4 py-3 bg-amber-500/10 border border-amber-500/30 text-amber-300 hover:bg-amber-500/20 hover:text-white rounded-xl w-full transition text-sm font-bold cursor-pointer">
                <i class="fa-solid fa-book-open-reader text-base text-amber-400"></i>
                <span>Panduan Dosen</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        @include('dosen.partials.header', ['title' => 'Jadwal & Ketersediaan Ruangan Lab'])

        <!-- Main Scrollable Body -->
        <div class="flex-1 overflow-y-auto smooth-scroll p-3.5 sm:p-6 lg:p-8 space-y-4 pb-28 lg:pb-10">
            
            <!-- Header Ringkasan Jadwal & Ketersediaan Lab -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="space-y-0.5">
                    <div class="flex items-center gap-2 text-[11px] font-bold text-teal-800">
                        <span class="w-2 h-2 rounded-full bg-teal-600 inline-block"></span>
                        <span>Portal Ketersediaan Ruangan Laboratorium</span>
                    </div>
                    <h2 class="text-lg sm:text-xl font-black tracking-tight text-slate-900 leading-tight">
                        Jadwal & Ketersediaan Ruangan Lab
                    </h2>
                    <p class="text-xs text-slate-600 leading-relaxed max-w-2xl">
                        Cek jadwal terisi dan slot kosong lab. Klik tombol <strong>+ Pakai</strong> pada jam yang tersedia untuk menjadwalkan kuliah pengganti.
                    </p>
                </div>

                <div class="flex items-center gap-2 pt-1 sm:pt-0">
                    <button type="button" onclick="openBookingModal('08:00', '10:00', '{{ $selectedDate }}', '{{ $selectedLabId }}')" class="w-full sm:w-auto px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-xs flex items-center justify-center gap-2 shadow-xs transition cursor-pointer">
                        <i class="fa-solid fa-plus-circle text-teal-400 text-sm"></i>
                        <span>Buat Kuliah Pengganti</span>
                    </button>
                </div>
            </div>

            <!-- Filter Bilah Pilihan Lab, Tanggal, & Mode View -->
            <div class="bg-white p-3.5 sm:p-4 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <form action="{{ route('dosen.jadwal-lab') }}" method="GET" id="filterLabForm" class="space-y-3">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
                        <!-- 1. Pilihan Laboratorium -->
                        <div class="sm:col-span-1 lg:col-span-5">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-solid fa-door-open text-teal-700"></i> Pilih Laboratorium
                            </label>
                            <select name="lab_id" onchange="document.getElementById('filterLabForm').submit()" class="w-full p-2.5 bg-slate-50 hover:bg-white border border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700/20 outline-none cursor-pointer transition">
                                @foreach($labs as $lab)
                                    <option value="{{ $lab->id }}" {{ $selectedLabId == $lab->id ? 'selected' : '' }}>
                                        {{ $lab->nama_lab }} ({{ $lab->lokasi }}) - {{ $lab->kapasitas ?? '30' }} PC
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. Pilihan Tanggal & Navigasi Cepat -->
                        <div class="sm:col-span-1 lg:col-span-4">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar text-teal-700"></i> Tanggal Pelaksanaan
                            </label>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => $prevDate]) }}" title="Kemarin" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold border border-slate-200 transition flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                </a>

                                <input type="date" name="tanggal" value="{{ $selectedDate }}" onchange="document.getElementById('filterLabForm').submit()" class="flex-1 min-w-0 p-2.5 bg-slate-50 hover:bg-white border border-slate-300 rounded-xl text-xs font-bold text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700/20 outline-none cursor-pointer transition">

                                <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => $nextDate]) }}" title="Besok" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold border border-slate-200 transition flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <!-- 3. Shortcut Cepat & Segmented Switcher -->
                        <div class="sm:col-span-2 lg:col-span-3 flex items-center justify-between sm:justify-end gap-2">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => $todayDate]) }}" class="px-3 py-2 {{ $selectedDate === $todayDate ? 'bg-teal-800 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200' }} rounded-xl text-xs font-bold transition">
                                    Hari Ini
                                </a>
                                <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => date('Y-m-d', strtotime('+1 day'))]) }}" class="px-3 py-2 {{ $selectedDate === date('Y-m-d', strtotime('+1 day')) ? 'bg-teal-800 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200' }} rounded-xl text-xs font-bold transition">
                                    Besok
                                </a>
                            </div>

                            <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
                                <button type="button" onclick="switchViewMode('daily')" id="btn-mode-daily" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-teal-900 shadow-xs flex items-center gap-1 transition">
                                    <i class="fa-solid fa-list-check"></i>
                                    <span>Harian</span>
                                </button>
                                <button type="button" onclick="switchViewMode('weekly')" id="btn-mode-weekly" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1 transition">
                                    <i class="fa-solid fa-table-cells"></i>
                                    <span>Mingguan</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdminFakultas())
                        <div class="w-full pt-2.5 border-t border-slate-200 flex flex-wrap items-center justify-between gap-2.5 bg-amber-50/90 p-2.5 rounded-xl border border-amber-200 mt-1">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user-gear text-amber-600 text-sm"></i>
                                <span class="text-xs font-extrabold text-amber-900">Mode Pratinjau Admin: Dosen Terpilih</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <select name="dosen_id" onchange="document.getElementById('filterLabForm').submit()" class="py-1.5 px-3 rounded-lg bg-white border border-amber-300 text-xs font-bold text-slate-800 outline-none cursor-pointer shadow-xs">
                                    @foreach($dosens as $dsn)
                                        <option value="{{ $dsn->id }}" {{ $dosen->id == $dsn->id ? 'selected' : '' }}>
                                            {{ $dsn->nama }} (NIP: {{ $dsn->nip }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <!-- ========================================== -->
            <!-- TAMPILAN 1: SLOT HARIAN                   -->
            <!-- ========================================== -->
            <div id="view-daily-slots" class="space-y-4">
                
                <!-- Status Strip Harian -->
                <div class="bg-white border border-slate-200 rounded-2xl p-3.5 sm:p-4 shadow-xs flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-800 flex items-center justify-center border border-teal-200 font-bold text-base shrink-0">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                <span>{{ $carbonDate->translatedFormat('l, d F Y') }}</span>
                                @if($isToday)
                                    <span class="px-2 py-0.5 bg-teal-100 text-teal-900 border border-teal-200 rounded-full text-[10px] font-black uppercase">Hari Ini</span>
                                @endif
                            </h3>
                            <p class="text-xs text-slate-500 font-medium">
                                Ruangan: <strong class="text-slate-800 font-bold">{{ $selectedLab->nama_lab ?? 'Lab' }}</strong> ({{ $selectedLab->lokasi ?? '' }})
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @php
                            $emptyCount = collect($slotAvailability)->where('is_occupied', false)->count();
                            $occupiedCount = collect($slotAvailability)->where('is_occupied', true)->count();
                        @endphp
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                            <span>{{ $emptyCount }} Kosong</span>
                        </span>
                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-slate-500 inline-block"></span>
                            <span>{{ $occupiedCount }} Terisi</span>
                        </span>
                    </div>
                </div>

                <!-- DAFTAR TIMELINE SLOT HARIAN (DESAIN BERSIH & TIDAK MONOTON) -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden divide-y divide-slate-100">
                    @foreach($slotAvailability as $item)
                        @php
                            $isOccupied = $item['is_occupied'];
                            $isMine = $item['is_mine'];
                            $isLive = $item['is_live'];
                        @endphp

                        @if(!$isOccupied)
                            <!-- BARIS SLOT KOSONG: Kompak, Rapi, & Elegan -->
                            <div class="p-3.5 sm:p-4 hover:bg-slate-50/70 transition flex items-center justify-between gap-3 group">
                                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="fa-regular fa-clock"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-mono font-black text-xs sm:text-sm text-slate-800">{{ $item['slot']['label'] }}</span>
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">{{ $item['slot']['session'] }}</span>
                                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded text-[10px] font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersedia
                                            </span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 font-normal mt-0.5 hidden sm:block">
                                            Ruangan bebas pada jam ini. Silakan gunakan untuk kuliah pengganti.
                                        </p>
                                    </div>
                                </div>

                                <button type="button" 
                                        onclick="openBookingModal('{{ $item['slot']['start'] }}', '{{ $item['slot']['end'] }}', '{{ $selectedDate }}', '{{ $selectedLabId }}')" 
                                        class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs shrink-0 cursor-pointer">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                    <span>Pakai Jam Ini</span>
                                </button>
                            </div>
                        @else
                            <!-- BARIS SLOT TERISI: Rapi dengan Informasi Lengkap -->
                            <div class="p-3.5 sm:p-4.5 {{ $isMine ? 'bg-teal-50/60' : 'bg-white' }} hover:bg-slate-50/60 transition space-y-2.5">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                                        <div class="w-8 h-8 rounded-xl {{ $isMine ? 'bg-teal-800 text-white' : 'bg-slate-100 text-slate-700 border border-slate-200' }} flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                                            @if($isMine)
                                                <i class="fa-solid fa-star text-amber-300 text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-lock text-xs text-slate-400"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0 space-y-1">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="font-mono font-black text-xs sm:text-sm text-slate-800">{{ $item['slot']['label'] }}</span>
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">{{ $item['slot']['session'] }}</span>
                                                @if($isMine)
                                                    <span class="px-2 py-0.5 bg-teal-800 text-white rounded text-[10px] font-black uppercase">Jadwal Anda</span>
                                                @else
                                                    <span class="px-2 py-0.5 bg-slate-200 text-slate-700 rounded text-[10px] font-bold">Terisi</span>
                                                @endif

                                                @if($isLive)
                                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-800 border border-rose-200 rounded text-[10px] font-black uppercase pulse-live">
                                                        🔴 Live Sekarang
                                                    </span>
                                                @endif
                                            </div>

                                            <h4 class="font-extrabold text-sm text-slate-900 leading-snug">
                                                {{ $item['title'] }}
                                            </h4>

                                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-600 font-medium pt-0.5">
                                                @php
                                                    $isSlotMerged = preg_match('/[&,\/+]/i', $item['kelas']) || stripos($item['kelas'], 'dan') !== false;
                                                @endphp
                                                @if($isSlotMerged)
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-purple-100 border border-purple-200 rounded text-[10px] font-bold text-purple-900">
                                                        <i class="fa-solid fa-layer-group text-[9px] text-purple-700"></i> Gabungan: {{ $item['kelas'] }}
                                                    </span>
                                                @else
                                                    <span>Kelas <strong class="text-slate-900 font-bold">{{ $item['kelas'] }}</strong></span>
                                                @endif
                                                @if($item['prodi_name'])
                                                    <span>·</span>
                                                    <span>{{ $item['prodi_name'] }}</span>
                                                @endif
                                                <span>·</span>
                                                <span class="flex items-center gap-1 text-slate-700">
                                                    <i class="fa-solid fa-user-tie text-slate-400 text-xs"></i>
                                                    <strong>{{ $item['dosen_name'] }}</strong>
                                                </span>
                                                <span>·</span>
                                                <span class="font-mono text-teal-800 font-bold">{{ $item['exact_time'] }} WIB</span>
                                            </div>

                                            @if(!empty($item['materi']))
                                                <p class="text-[11px] text-slate-500 italic line-clamp-1 pt-0.5">
                                                    "{{ $item['materi'] }}"
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi jika Jadwal Sendiri -->
                                    @if($isMine && $item['agenda_id'])
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <a href="{{ route('dosen.agenda') }}" class="px-3 py-1.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-2xs">
                                                <i class="fa-solid fa-qrcode text-[11px]"></i>
                                                <span class="hidden sm:inline">Sesi / QR</span>
                                            </a>
                                            <a href="{{ route('dosen.absensi.input', $item['agenda_id']) }}" class="p-1.5 sm:px-2.5 sm:py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-xl text-xs font-bold transition flex items-center gap-1" title="Input Presensi">
                                                <i class="fa-solid fa-clipboard-user"></i>
                                                <span class="hidden sm:inline">Presensi</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Ringkasan Seluruh Agenda Aktual Hari Ini -->
                @if($agendasOnDate->isNotEmpty())
                    <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-list-ol text-teal-600"></i>
                                <span>Detail Seluruh Agenda Hari Ini di {{ $selectedLab->nama_lab ?? 'Lab' }} ({{ $agendasOnDate->count() }} Kegiatan)</span>
                            </h4>
                        </div>
                        <div class="overflow-x-auto smooth-scroll">
                            <table class="w-full text-xs text-left min-w-[550px]">
                                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                                    <tr>
                                        <th class="p-2.5">Waktu</th>
                                        <th class="p-2.5">Mata Kuliah & Kelas</th>
                                        <th class="p-2.5">Dosen Pengampu</th>
                                        <th class="p-2.5">Program Studi</th>
                                        <th class="p-2.5 text-center">Status</th>
                                        <th class="p-2.5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($agendasOnDate as $ag)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="p-2.5 font-mono font-bold text-slate-800 whitespace-nowrap">
                                                {{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB
                                            </td>
                                            <td class="p-2.5">
                                                <div class="font-bold text-slate-900">{{ $ag->mata_kuliah }}</div>
                                                <div class="text-[11px] text-slate-500">Kelas {{ $ag->kelas }} · {{ $ag->jenis_pertemuan ?? 'Praktikum' }}</div>
                                            </td>
                                            <td class="p-2.5 font-medium text-slate-800">
                                                {{ $ag->dosen->nama ?? '-' }}
                                            </td>
                                            <td class="p-2.5 text-slate-600">
                                                {{ $ag->jurusan ?? '-' }}
                                            </td>
                                            <td class="p-2.5 text-center whitespace-nowrap">
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $ag->status_agenda == 'Selesai' ? 'bg-emerald-100 text-emerald-800' : ($ag->status_agenda == 'Sedang Berlangsung' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                                                    {{ $ag->status_agenda ?? 'Terjadwal' }}
                                                </span>
                                            </td>
                                            <td class="p-2.5 text-right whitespace-nowrap">
                                                @if($ag->dosen_id == $dosen->id || ($ag->dosen_pengampu_id ?? null) == $dosen->id)
                                                    <a href="{{ route('dosen.agenda') }}" class="px-2.5 py-1 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Kelola
                                                    </a>
                                                @else
                                                    <span class="text-slate-400 text-xs font-medium">Hanya Lihat</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- ========================================== -->
            <!-- TAMPILAN 2: MATRIKS MINGGUAN               -->
            <!-- ========================================== -->
            <div id="view-weekly-matrix" class="hidden space-y-4">
                
                <!-- 📱 TAB HARI UNTUK HP (SENIN - SABTU) -->
                <div class="md:hidden bg-white border border-slate-200 rounded-2xl p-3.5 shadow-xs space-y-2.5">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-black text-slate-900 uppercase flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-week text-teal-700"></i> Pilih Hari
                        </h4>
                        <span class="text-[11px] text-slate-500 font-bold">{{ strtoupper($selectedLab->nama_lab ?? 'Lab') }}</span>
                    </div>

                    <!-- Day Pills -->
                    <div class="grid grid-cols-3 gap-1.5">
                        @foreach($hariList as $h)
                            @php
                                $infoH = $weekDays[$h] ?? null;
                                $isCurrentDayTab = ($h === $selectedDayName);
                            @endphp
                            <button type="button" 
                                    onclick="selectMobileDayTab('{{ $h }}')" 
                                    id="btn-day-tab-{{ $h }}" 
                                    class="day-tab-btn py-2 px-2 rounded-xl text-xs font-bold transition flex flex-col items-center justify-center border {{ $isCurrentDayTab ? 'bg-teal-800 text-white border-teal-800 shadow-xs' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 border-slate-200' }}">
                                <span>{{ $h }}</span>
                                <span class="text-[10px] {{ $isCurrentDayTab ? 'text-teal-200 font-bold' : 'text-slate-500' }}">{{ $infoH['formatted'] ?? '' }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 📱 KONTEN SLOT PER HARI UNTUK HP (TIMELINE COMPACT UNIFIED CARD) -->
                <div class="md:hidden space-y-3">
                    @foreach($hariList as $hari)
                        @php
                            $infoHari = $weekDays[$hari] ?? null;
                            $tglHari = $infoHari['date'] ?? $selectedDate;
                            $isCurrentDayTab = ($hari === $selectedDayName);
                        @endphp
                        <div id="mobile-day-content-{{ $hari }}" class="mobile-day-panel {{ $isCurrentDayTab ? '' : 'hidden' }} space-y-3">
                            
                            <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-xs flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-extrabold text-slate-900">Hari {{ $hari }}, {{ $infoHari['formatted'] ?? '' }}</h4>
                                    <p class="text-[11px] text-slate-500">Laboratorium: {{ $selectedLab->nama_lab ?? 'Lab' }}</p>
                                </div>
                                <span class="px-2.5 py-1 bg-teal-50 text-teal-900 border border-teal-200 rounded-lg text-xs font-bold">
                                    {{ $selectedLab->lokasi ?? '' }}
                                </span>
                            </div>

                            <!-- Single Unified Timeline List Card for the Selected Day -->
                            <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden divide-y divide-slate-100">
                                @foreach($matrixSlots as $slot)
                                    @php
                                        list($slotStart, $slotEnd) = explode('-', $slot);
                                        $slotStartClean = str_replace('.', ':', trim($slotStart)) . ':00';
                                        $slotEndClean = str_replace('.', ':', trim($slotEnd)) . ':00';
                                        $startFmt = str_replace('.', ':', trim($slotStart));
                                        $endFmt = str_replace('.', ':', trim($slotEnd));

                                        // 1. Cek agenda aktual
                                        $matchesAgenda = $weekAgendas->filter(function($a) use ($tglHari, $slotStartClean, $slotEndClean) {
                                            return $a->tanggal === $tglHari && ($a->jam_mulai < $slotEndClean && $a->jam_selesai > $slotStartClean);
                                        });

                                        // 2. Cek jadwal rutin
                                        $matchesRutin = $rutinJadwals->filter(function($j) use ($hari, $slotStartClean, $slotEndClean) {
                                            return $j->hari === $hari && ($j->jam_mulai < $slotEndClean && $j->jam_selesai > $slotStartClean);
                                        });

                                        $hasOccupant = ($matchesAgenda->isNotEmpty() || $matchesRutin->isNotEmpty());
                                    @endphp

                                    @if(!$hasOccupant)
                                        <!-- BARIS KOSONG: Kompak & Elegan -->
                                        <div class="p-3 sm:p-3.5 hover:bg-slate-50/70 transition flex items-center justify-between gap-3">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <span class="font-mono font-bold text-xs text-slate-800">{{ $slot }}</span>
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded text-[10px] font-bold">
                                                    Tersedia
                                                </span>
                                            </div>

                                            <button type="button" 
                                                    onclick="openBookingModal('{{ $startFmt }}', '{{ $endFmt }}', '{{ $tglHari }}', '{{ $selectedLabId }}')" 
                                                    class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-1 shadow-2xs shrink-0 cursor-pointer">
                                                <i class="fa-solid fa-plus text-[10px]"></i>
                                                <span>Pakai</span>
                                            </button>
                                        </div>
                                    @else
                                        <!-- BARIS TERISI -->
                                        <div class="p-3.5 bg-slate-50/50 hover:bg-slate-50 transition space-y-1.5">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="font-mono font-black text-xs text-slate-800 flex items-center gap-1">
                                                    <i class="fa-regular fa-clock text-slate-400"></i> {{ $slot }} WIB
                                                </span>
                                            </div>

                                            @if($matchesAgenda->isNotEmpty())
                                                @foreach($matchesAgenda as $m)
                                                    @php
                                                        $isMySchedule = ($m->dosen_id == $dosen->id || ($m->dosen_pengampu_id ?? null) == $dosen->id);
                                                    @endphp
                                                    <div class="p-2.5 rounded-xl border {{ $isMySchedule ? 'bg-teal-50 border-teal-300' : 'bg-white border-slate-200' }} space-y-1">
                                                        <div class="flex items-center justify-between">
                                                            @if($isMySchedule)
                                                                <span class="px-1.5 py-0.5 bg-teal-800 text-white rounded text-[9px] font-black uppercase">Jadwal Anda</span>
                                                            @else
                                                                <span class="px-1.5 py-0.5 bg-slate-100 text-slate-700 rounded text-[9px] font-bold">Agenda</span>
                                                            @endif
                                                            <span class="font-mono text-[11px] font-bold text-teal-800">{{ substr($m->jam_mulai,0,5) }}-{{ substr($m->jam_selesai,0,5) }}</span>
                                                        </div>
                                                        <h5 class="font-bold text-xs text-slate-900 leading-snug">{{ $m->mata_kuliah }}</h5>
                                                        <p class="text-[11px] text-slate-600">Kelas {{ $m->kelas }} · {{ $m->jurusan ?? '-' }}</p>
                                                        <p class="text-[11px] text-slate-700 font-medium">
                                                            <i class="fa-solid fa-user-tie text-slate-400 text-[10px]"></i> {{ $m->dosen->nama ?? '-' }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            @else
                                                @foreach($matchesRutin as $m)
                                                    @php
                                                        $isMySchedule = ($m->dosen_id == $dosen->id || ($m->dosen_pengampu_id ?? null) == $dosen->id);
                                                    @endphp
                                                    <div class="p-2.5 rounded-xl border {{ $isMySchedule ? 'bg-teal-50 border-teal-300' : 'bg-white border-slate-200' }} space-y-1">
                                                        <div class="flex items-center justify-between">
                                                            @if($isMySchedule)
                                                                <span class="px-1.5 py-0.5 bg-teal-800 text-white rounded text-[9px] font-black uppercase">Jadwal Anda</span>
                                                            @else
                                                                <span class="px-1.5 py-0.5 bg-slate-100 text-slate-700 rounded text-[9px] font-bold">Rutin</span>
                                                            @endif
                                                            <span class="font-mono text-[11px] font-bold text-teal-800">{{ substr($m->jam_mulai,0,5) }}-{{ substr($m->jam_selesai,0,5) }}</span>
                                                        </div>
                                                        <h5 class="font-bold text-xs text-slate-900 leading-snug">{{ $m->mata_kuliah }}</h5>
                                                        <p class="text-[11px] text-slate-600">Kelas {{ $m->kelas }} · {{ $m->prodi->nama_prodi ?? '-' }}</p>
                                                        <p class="text-[11px] text-slate-700 font-medium">
                                                            <i class="fa-solid fa-user-tie text-slate-400 text-[10px]"></i> {{ $m->dosen->nama ?? '-' }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- 🖥️ TABEL MATRIKS MINGGUAN LENGKAP (DESKTOP) -->
                <div class="hidden md:block bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden">
                    <div class="bg-slate-900 text-white px-5 py-4 flex flex-wrap justify-between items-center gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center border border-teal-500/30 font-bold">
                                <i class="fa-solid fa-table-cells text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-sm uppercase tracking-wide text-white">
                                    Tabel Matriks Mingguan {{ strtoupper($selectedLab->nama_lab ?? 'Lab') }}
                                </h3>
                                <p class="text-xs text-slate-300 font-medium">Jadwal Penggunaan Rutin & Agenda Semester Aktif (Senin - Sabtu)</p>
                            </div>
                        </div>

                        <span class="px-2.5 py-1 bg-teal-800 text-teal-100 rounded-lg text-xs font-bold border border-teal-600 inline-flex items-center gap-1">
                            <i class="fa-solid fa-hand-pointer text-amber-300"></i> Klik slot kosong untuk booking
                        </span>
                    </div>

                    <div class="overflow-x-auto smooth-scroll">
                        <table class="w-full text-xs border-collapse min-w-[850px]">
                            <thead>
                                <tr class="bg-slate-100 border-b border-slate-200 text-slate-800 font-black uppercase tracking-wider text-center">
                                    <th class="p-3 border-r border-slate-200 w-28 sticky left-0 bg-slate-200/90 z-10 text-xs">
                                        Waktu
                                    </th>
                                    @foreach($hariList as $hari)
                                        @php
                                            $infoHari = $weekDays[$hari] ?? null;
                                            $isTodayCol = $infoHari['is_today'] ?? false;
                                            $isSelectedCol = $infoHari['is_selected'] ?? false;
                                        @endphp
                                        <th class="p-3 border-r border-slate-200 min-w-[160px] text-xs {{ $isTodayCol ? 'bg-teal-100 text-teal-950 font-black ring-2 ring-teal-600 ring-inset' : ($isSelectedCol ? 'bg-teal-50 text-teal-900 font-extrabold' : 'bg-slate-100 text-slate-800') }}">
                                            <div class="flex flex-col items-center">
                                                <span>{{ $hari }}</span>
                                                @if($infoHari)
                                                    <span class="text-[10px] font-semibold {{ $isTodayCol ? 'text-teal-800' : 'text-slate-500' }} mt-0.5">
                                                        {{ $infoHari['formatted'] }}
                                                        @if($isTodayCol) <strong class="text-teal-900 font-black">(Hari Ini)</strong> @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach($matrixSlots as $slot)
                                    @php
                                        list($slotStart, $slotEnd) = explode('-', $slot);
                                        $slotStartClean = str_replace('.', ':', trim($slotStart)) . ':00';
                                        $slotEndClean = str_replace('.', ':', trim($slotEnd)) . ':00';
                                        $startFmt = str_replace('.', ':', trim($slotStart));
                                        $endFmt = str_replace('.', ':', trim($slotEnd));
                                    @endphp
                                    <tr>
                                        <!-- Kolom Jam Sticky -->
                                        <td class="p-2.5 text-center font-mono font-black text-slate-700 bg-slate-50 border-r border-slate-200 text-xs sticky left-0 z-10">
                                            {{ $slot }}
                                        </td>

                                        <!-- Kolom Masing-masing Hari -->
                                        @foreach($hariList as $hari)
                                            @php
                                                $infoHari = $weekDays[$hari] ?? null;
                                                $tglHari = $infoHari['date'] ?? $selectedDate;
                                                $isTodayCol = $infoHari['is_today'] ?? false;

                                                // 1. Cek agenda aktual
                                                $matchesAgenda = $weekAgendas->filter(function($a) use ($tglHari, $slotStartClean, $slotEndClean) {
                                                    return $a->tanggal === $tglHari && ($a->jam_mulai < $slotEndClean && $a->jam_selesai > $slotStartClean);
                                                });

                                                // 2. Cek jadwal rutin
                                                $matchesRutin = $rutinJadwals->filter(function($j) use ($hari, $slotStartClean, $slotEndClean) {
                                                    return $j->hari === $hari && ($j->jam_mulai < $slotEndClean && $j->jam_selesai > $slotStartClean);
                                                });

                                                $hasOccupant = ($matchesAgenda->isNotEmpty() || $matchesRutin->isNotEmpty());
                                            @endphp
                                            
                                            <td class="p-2 border-r border-slate-200 align-top transition {{ $isTodayCol ? 'bg-teal-50/40' : '' }}">
                                                @if($hasOccupant)
                                                    @foreach($matchesAgenda as $m)
                                                        @php
                                                            $isMySchedule = ($m->dosen_id == $dosen->id || ($m->dosen_pengampu_id ?? null) == $dosen->id);
                                                        @endphp
                                                        <div class="p-2.5 rounded-xl border {{ $isMySchedule ? 'bg-teal-900 text-white border-teal-700 shadow-2xs' : 'bg-slate-800 text-white border-slate-700' }} mb-1 text-xs leading-tight">
                                                            <div class="flex items-center justify-between mb-1">
                                                                @if($isMySchedule)
                                                                    <span class="px-1.5 py-0.5 bg-teal-400 text-slate-950 font-black rounded text-[9px] uppercase">Jadwal Anda</span>
                                                                @else
                                                                    <span class="px-1.5 py-0.5 bg-slate-700 text-slate-200 rounded text-[9px]">Agenda</span>
                                                                @endif
                                                                <span class="font-mono text-[10px] text-teal-300 font-bold">{{ substr($m->jam_mulai,0,5) }}-{{ substr($m->jam_selesai,0,5) }}</span>
                                                            </div>
                                                            <div class="font-bold line-clamp-2 text-xs text-white">{{ $m->mata_kuliah }}</div>
                                                            @php
                                                                $isMKelasMerged = preg_match('/[&,\/+]/i', $m->kelas) || stripos($m->kelas, 'dan') !== false;
                                                            @endphp
                                                            @if($isMKelasMerged)
                                                                <div class="mt-0.5">
                                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.2 bg-purple-500/30 border border-purple-300/40 rounded text-[9.5px] font-bold text-purple-100">
                                                                        <i class="fa-solid fa-layer-group text-[8.5px]"></i> Gabungan: {{ $m->kelas }}
                                                                    </span>
                                                                </div>
                                                            @else
                                                                <div class="text-[11px] text-teal-200 font-semibold mt-0.5">Kelas {{ $m->kelas }}</div>
                                                            @endif
                                                            <div class="text-[11px] text-slate-300 font-normal mt-0.5 truncate">
                                                                <i class="fa-solid fa-user-tie text-[9px]"></i> {{ $m->dosen->nama ?? '-' }}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    @if($matchesAgenda->isEmpty())
                                                        @foreach($matchesRutin as $m)
                                                            @php
                                                                $isMySchedule = ($m->dosen_id == $dosen->id || ($m->dosen_pengampu_id ?? null) == $dosen->id);
                                                                $isMKelasMerged = preg_match('/[&,\/+]/i', $m->kelas) || stripos($m->kelas, 'dan') !== false;
                                                            @endphp
                                                            <div class="p-2.5 rounded-xl border {{ $isMySchedule ? 'bg-teal-900 text-white border-teal-700 shadow-2xs' : 'bg-slate-800 text-white border-slate-700' }} mb-1 text-xs leading-tight">
                                                                <div class="flex items-center justify-between mb-1">
                                                                    @if($isMySchedule)
                                                                        <span class="px-1.5 py-0.5 bg-teal-400 text-slate-950 font-black rounded text-[9px] uppercase">Jadwal Anda</span>
                                                                    @else
                                                                        <span class="px-1.5 py-0.5 bg-slate-700 text-slate-200 rounded text-[9px]">Rutin</span>
                                                                    @endif
                                                                    <span class="font-mono text-[10px] text-teal-300 font-bold">{{ substr($m->jam_mulai,0,5) }}-{{ substr($m->jam_selesai,0,5) }}</span>
                                                                </div>
                                                                <div class="font-bold line-clamp-2 text-xs text-white">{{ $m->mata_kuliah }}</div>
                                                                @if($isMKelasMerged)
                                                                    <div class="mt-0.5">
                                                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.2 bg-purple-500/30 border border-purple-300/40 rounded text-[9.5px] font-bold text-purple-100">
                                                                            <i class="fa-solid fa-layer-group text-[8.5px]"></i> Gabungan: {{ $m->kelas }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="text-[11px] text-teal-200 font-semibold mt-0.5">Kelas {{ $m->kelas }}</div>
                                                                @endif
                                                                <div class="text-[11px] text-slate-300 font-normal mt-0.5 truncate">
                                                                    <i class="fa-solid fa-user-tie text-[9px]"></i> {{ $m->dosen->nama ?? '-' }}
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    <!-- SLOT KOSONG DI MATRIKS DESKTOP (BISA LANGSUNG DIKLIK) -->
                                                    <button type="button" 
                                                            onclick="openBookingModal('{{ $startFmt }}', '{{ $endFmt }}', '{{ $tglHari }}', '{{ $selectedLabId }}')" 
                                                            class="w-full h-full min-h-[64px] p-2 rounded-xl border border-dashed border-emerald-300 hover:border-emerald-600 bg-emerald-50/50 hover:bg-emerald-100 text-emerald-800 hover:text-emerald-950 text-center text-xs font-bold transition flex flex-col items-center justify-center gap-1 group cursor-pointer"
                                                            title="Klik untuk jadwalkan kuliah pengganti pada {{ $hari }} ({{ $infoHari['formatted'] ?? '' }}) jam {{ $slot }}">
                                                        <span class="text-xs group-hover:scale-110 transition-transform">Kosong</span>
                                                        <span class="text-[10px] font-semibold text-emerald-700 group-hover:text-emerald-900 flex items-center gap-1">
                                                            <i class="fa-solid fa-plus text-[9px]"></i> Pakai
                                                        </span>
                                                    </button>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- ============================================================== -->
    <!-- MODAL POPUP: BUAT JADWAL / KULIAH PENGGANTI (ANTI-BENTROK)   -->
    <!-- ============================================================== -->
    <div id="modal-booking-slot" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-3 sm:p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto smooth-scroll text-left animate-in fade-in zoom-in-95 duration-150">
            <!-- Modal Header -->
            <div class="bg-slate-900 text-white px-5 py-4 flex justify-between items-center sticky top-0 z-10">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-calendar-plus text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm text-white">Jadwalkan Kuliah Pengganti</h3>
                        <p class="text-[11px] text-slate-300 font-normal">Pesan jam kosong lab untuk jadwal perkuliahan</p>
                    </div>
                </div>
                <button type="button" onclick="closeBookingModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 flex items-center justify-center transition" title="Tutup">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form action="{{ route('dosen.agenda.store') }}" method="POST" id="bookingForm" class="p-4 sm:p-6 space-y-4 text-xs">
                @csrf
                <input type="hidden" name="lab_id" id="modal-input-lab-id" value="{{ $selectedLabId }}">
                <input type="hidden" name="tanggal" id="modal-input-tanggal" value="{{ $selectedDate }}">

                <!-- Panel Spesifikasi Ruang & Waktu Terpilih -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <div class="flex justify-between items-center text-xs text-slate-800">
                        <span class="text-slate-500 font-medium">Laboratorium:</span>
                        <span id="modal-display-lab" class="font-bold text-slate-900">{{ $selectedLab->nama_lab ?? 'Lab' }} ({{ $selectedLab->lokasi ?? '' }})</span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-slate-800">
                        <span class="text-slate-500 font-medium">Hari & Tanggal:</span>
                        <span id="modal-display-tanggal" class="font-bold text-slate-900">{{ $carbonDate->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-slate-800 pt-1.5 border-t border-slate-200">
                        <span class="text-slate-500 font-medium">Alokasi Jam:</span>
                        <span id="modal-display-jam" class="font-mono font-black text-xs text-teal-800">-</span>
                    </div>
                </div>

                <!-- Pilihan Mata Kuliah & Kelas (COMBOBOX) -->
                <div>
                    <label class="block text-xs font-bold text-slate-900 mb-1.5">
                        Pilih Mata Kuliah & Kelas <span class="text-rose-600">*</span>
                    </label>
                    
                    <input type="hidden" name="jadwal_penggunaan_lab_id" id="modal-select-matkul-val" required>

                    <!-- Combobox Input & Dropdown -->
                    <div class="relative" id="combobox-wrapper">
                        <div class="relative flex items-center">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-xs pointer-events-none"></i>
                            <input type="text" 
                                   id="combobox-search-input" 
                                   autocomplete="off"
                                   placeholder="Ketik untuk mencari mata kuliah atau kelas..."
                                   class="w-full pl-9 pr-14 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-normal focus:border-teal-700 focus:ring-2 focus:ring-teal-700/20 outline-none transition"
                                   onfocus="openComboboxDropdown()"
                                   oninput="filterComboboxOptions(this.value)">
                            <div class="absolute right-2 flex items-center gap-1">
                                <button type="button" 
                                        id="combobox-clear-btn" 
                                        onclick="clearComboboxSelection(event)" 
                                        class="hidden text-slate-400 hover:text-slate-600 w-5 h-5 rounded flex items-center justify-center transition"
                                        title="Hapus pilihan">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                                <button type="button" 
                                        onclick="toggleComboboxDropdown(event)" 
                                        class="text-slate-500 hover:text-slate-800 w-6 h-6 rounded flex items-center justify-center transition">
                                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-150" id="combobox-chevron"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Dropdown List Panel -->
                        <div id="combobox-dropdown" 
                             class="hidden absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-xl shadow-xl max-h-52 overflow-y-auto z-50 divide-y divide-slate-100 py-1">
                            @forelse($myClasses as $mc)
                                <div class="combobox-item px-3.5 py-2.5 hover:bg-teal-50/60 cursor-pointer transition flex items-center justify-between group"
                                     data-id="{{ $mc->id }}"
                                     data-title="{{ $mc->mata_kuliah }}"
                                     data-kelas="{{ $mc->kelas }}"
                                     data-prodi="{{ $mc->prodi->nama_prodi ?? 'Informatika' }}"
                                     data-search="{{ strtolower($mc->mata_kuliah . ' ' . $mc->kelas . ' ' . ($mc->prodi->nama_prodi ?? '') . ' ' . $mc->hari) }}"
                                     onclick="selectComboboxOption(this)">
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 group-hover:text-teal-900">
                                            {{ $mc->mata_kuliah }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                            <span class="font-bold text-slate-700">Kelas {{ $mc->kelas ?: '-' }}</span>
                                            <span>·</span>
                                            <span>{{ $mc->prodi->nama_prodi ?? 'Informatika' }}</span>
                                            <span>·</span>
                                            <span>Hari {{ $mc->hari }} ({{ substr($mc->jam_mulai,0,5) }}-{{ substr($mc->jam_selesai,0,5) }})</span>
                                        </div>
                                    </div>
                                    <div class="combobox-check hidden text-teal-800 font-bold text-xs pl-2">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                            @empty
                                <div class="px-3 py-4 text-center text-xs text-slate-500">
                                    Belum ada jadwal kelas aktif terdaftar untuk akun Anda.
                                </div>
                            @endforelse
                            <div id="combobox-no-results" class="hidden px-3 py-4 text-center text-xs text-slate-500">
                                Tidak ada mata kuliah yang cocok dengan kata kunci.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input Jam Mulai & Selesai -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-900 mb-1.5">Jam Mulai <span class="text-rose-600">*</span></label>
                        <input type="time" name="waktu_masuk" id="modal-waktu-masuk" onchange="validateClashRealtime()" required class="w-full p-2.5 bg-white border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-900 mb-1.5">Jam Selesai <span class="text-rose-600">*</span></label>
                        <input type="time" name="waktu_keluar" id="modal-waktu-keluar" onchange="validateClashRealtime()" required class="w-full p-2.5 bg-white border border-slate-300 rounded-xl text-xs font-mono font-bold text-slate-900 focus:border-teal-700 focus:ring-2 focus:ring-teal-700/20 outline-none">
                    </div>
                </div>

                <!-- Area Pesan Bentrok Real-time -->
                <div id="clash-alert-box" class="hidden p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs flex items-start gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 mt-0.5"></i>
                    <div id="clash-alert-message" class="font-medium leading-relaxed"></div>
                </div>

                <!-- Materi Praktikum / Keterangan -->
                <div>
                    <label class="block text-xs font-bold text-slate-900 mb-1.5">Materi Praktikum / Topik <span class="text-slate-500 font-normal text-[11px]">(Opsional)</span></label>
                    <textarea name="materi_pembelajaran" rows="2" placeholder="Tuliskan materi praktikum atau topik perkuliahan pengganti..." class="w-full p-2.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700/20 outline-none leading-relaxed"></textarea>
                </div>

                <!-- Bilah Aksi Tombol Simpan -->
                <div class="flex justify-end items-center gap-2.5 pt-3 border-t border-slate-200">
                    <button type="button" onclick="closeBookingModal()" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 font-bold rounded-xl border border-slate-300 transition text-xs">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit-booking" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition shadow-xs text-xs flex items-center gap-2">
                        <i class="fa-solid fa-check text-teal-400 text-xs"></i>
                        <span>Simpan Sesi Pengganti</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('dosen.partials.bottom_nav')

    <!-- JavaScript Handlers -->
    <script>
        function toggleProfileDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('profileDropdownWrapper');
            const menu = document.getElementById('profileDropdownMenu');
            if (menu && wrapper && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        function switchViewMode(mode) {
            const daily = document.getElementById('view-daily-slots');
            const weekly = document.getElementById('view-weekly-matrix');
            const btnDaily = document.getElementById('btn-mode-daily');
            const btnWeekly = document.getElementById('btn-mode-weekly');

            if (mode === 'daily') {
                daily.classList.remove('hidden');
                weekly.classList.add('hidden');
                btnDaily.classList.add('bg-white', 'text-teal-900', 'shadow-xs');
                btnDaily.classList.remove('text-slate-600');
                btnWeekly.classList.remove('bg-white', 'text-teal-900', 'shadow-xs');
                btnWeekly.classList.add('text-slate-600');
            } else {
                daily.classList.add('hidden');
                weekly.classList.remove('hidden');
                btnWeekly.classList.add('bg-white', 'text-teal-900', 'shadow-xs');
                btnWeekly.classList.remove('text-slate-600');
                btnDaily.classList.remove('bg-white', 'text-teal-900', 'shadow-xs');
                btnDaily.classList.add('text-slate-600');
            }
        }

        // Mobile Day Tab Switcher for Weekly Matrix
        function selectMobileDayTab(hariName) {
            document.querySelectorAll('.day-tab-btn').forEach(btn => {
                btn.classList.remove('bg-teal-800', 'text-white', 'border-teal-800', 'shadow-xs');
                btn.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-200');
                const sub = btn.querySelector('span:last-child');
                if (sub) {
                    sub.classList.remove('text-teal-200', 'font-bold');
                    sub.classList.add('text-slate-500');
                }
            });

            const activeBtn = document.getElementById('btn-day-tab-' + hariName);
            if (activeBtn) {
                activeBtn.classList.remove('bg-slate-50', 'text-slate-700', 'border-slate-200');
                activeBtn.classList.add('bg-teal-800', 'text-white', 'border-teal-800', 'shadow-xs');
                const sub = activeBtn.querySelector('span:last-child');
                if (sub) {
                    sub.classList.remove('text-slate-500');
                    sub.classList.add('text-teal-200', 'font-bold');
                }
            }

            document.querySelectorAll('.mobile-day-panel').forEach(panel => {
                panel.classList.add('hidden');
            });
            const activePanel = document.getElementById('mobile-day-content-' + hariName);
            if (activePanel) {
                activePanel.classList.remove('hidden');
            }
        }

        function openBookingModal(startTime, endTime, targetDate, targetLabId) {
            const modal = document.getElementById('modal-booking-slot');
            const inMasuk = document.getElementById('modal-waktu-masuk');
            const inKeluar = document.getElementById('modal-waktu-keluar');
            const displayJam = document.getElementById('modal-display-jam');
            const inTanggal = document.getElementById('modal-input-tanggal');
            const inLabId = document.getElementById('modal-input-lab-id');
            const displayTanggal = document.getElementById('modal-display-tanggal');

            if (inMasuk) inMasuk.value = startTime;
            if (inKeluar) inKeluar.value = endTime;
            if (displayJam) displayJam.innerText = startTime + ' - ' + endTime + ' WIB';

            if (targetDate && inTanggal) {
                inTanggal.value = targetDate;
                if (displayTanggal) {
                    displayTanggal.innerText = targetDate;
                }
            }

            if (targetLabId && inLabId) {
                inLabId.value = targetLabId;
            }

            hideClashAlert();

            if (modal) modal.classList.remove('hidden');
        }

        function closeBookingModal() {
            const modal = document.getElementById('modal-booking-slot');
            if (modal) modal.classList.add('hidden');
            closeComboboxDropdown();
            hideClashAlert();
        }

        /* --- Combobox Searchable Dropdown Logic --- */
        function openComboboxDropdown() {
            const dd = document.getElementById('combobox-dropdown');
            const chevron = document.getElementById('combobox-chevron');
            if (dd) dd.classList.remove('hidden');
            if (chevron) chevron.classList.add('rotate-180');
        }

        function closeComboboxDropdown() {
            const dd = document.getElementById('combobox-dropdown');
            const chevron = document.getElementById('combobox-chevron');
            if (dd) dd.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }

        function toggleComboboxDropdown(e) {
            if (e) e.stopPropagation();
            const dd = document.getElementById('combobox-dropdown');
            if (dd && dd.classList.contains('hidden')) {
                openComboboxDropdown();
                document.getElementById('combobox-search-input')?.focus();
            } else {
                closeComboboxDropdown();
            }
        }

        function filterComboboxOptions(keyword) {
            openComboboxDropdown();
            const q = (keyword || '').toLowerCase().trim();
            const items = document.querySelectorAll('.combobox-item');
            let visibleCount = 0;

            items.forEach(el => {
                const searchData = el.getAttribute('data-search') || '';
                if (!q || searchData.includes(q)) {
                    el.classList.remove('hidden');
                    visibleCount++;
                } else {
                    el.classList.add('hidden');
                }
            });

            const noResults = document.getElementById('combobox-no-results');
            if (noResults) {
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }

            const clearBtn = document.getElementById('combobox-clear-btn');
            if (clearBtn) {
                if (q.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }
        }

        function selectComboboxOption(el) {
            const id = el.getAttribute('data-id');
            const title = el.getAttribute('data-title');
            const kelas = el.getAttribute('data-kelas');
            const prodi = el.getAttribute('data-prodi');

            const hiddenInput = document.getElementById('modal-select-matkul-val');
            if (hiddenInput) hiddenInput.value = id;

            const searchInput = document.getElementById('combobox-search-input');
            if (searchInput) searchInput.value = title + ' - Kelas ' + (kelas || '-') + ' (' + prodi + ')';

            document.querySelectorAll('.combobox-check').forEach(c => c.classList.add('hidden'));
            el.querySelector('.combobox-check')?.classList.remove('hidden');

            document.getElementById('combobox-clear-btn')?.classList.remove('hidden');

            closeComboboxDropdown();

            const rencanaTextarea = document.querySelector('textarea[name="materi_pembelajaran"]') || document.querySelector('textarea[name="rencana_pembelajaran"]');
            if (rencanaTextarea && !rencanaTextarea.value.trim()) {
                rencanaTextarea.value = 'Kuliah Pengganti ' + title + ' (Kelas ' + (kelas || '-') + ')';
            }

            validateClashRealtime();
        }

        function clearComboboxSelection(e) {
            if (e) e.stopPropagation();
            const hiddenInput = document.getElementById('modal-select-matkul-val');
            const searchInput = document.getElementById('combobox-search-input');
            const clearBtn = document.getElementById('combobox-clear-btn');

            if (hiddenInput) hiddenInput.value = '';
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
            }
            if (clearBtn) clearBtn.classList.add('hidden');

            document.querySelectorAll('.combobox-check').forEach(c => c.classList.add('hidden'));
            filterComboboxOptions('');
            openComboboxDropdown();
        }

        function showClashAlert(message) {
            const box = document.getElementById('clash-alert-box');
            const msg = document.getElementById('clash-alert-message');
            if (box && msg) {
                msg.innerHTML = message;
                box.classList.remove('hidden');
            }
        }

        function hideClashAlert() {
            const box = document.getElementById('clash-alert-box');
            if (box) box.classList.add('hidden');
        }

        // Real-time Clash Validation against API
        async function validateClashRealtime() {
            const labId = document.getElementById('modal-input-lab-id')?.value;
            const tanggal = document.getElementById('modal-input-tanggal')?.value;
            const waktuMasuk = document.getElementById('modal-waktu-masuk')?.value;
            const waktuKeluar = document.getElementById('modal-waktu-keluar')?.value;

            if (!labId || !tanggal || !waktuMasuk || !waktuKeluar) return;

            try {
                const url = `{{ route('dosen.jadwal-lab.check-availability') }}?lab_id=${labId}&tanggal=${tanggal}&waktu_masuk=${waktuMasuk}&waktu_keluar=${waktuKeluar}`;
                const res = await fetch(url);
                const data = await res.json();

                if (!data.available) {
                    showClashAlert(data.message || 'Jadwal bentrok dengan kegiatan lain.');
                } else {
                    hideClashAlert();
                }
            } catch (err) {
                console.error('Error checking clash:', err);
            }
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('combobox-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeComboboxDropdown();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeComboboxDropdown();
                closeBookingModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonColor: '#0f766e',
                    customClass: {
                        popup: 'rounded-3xl p-6 shadow-2xl',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian!',
                    text: @json($errors->first()),
                    confirmButtonColor: '#e11d48',
                    customClass: {
                        popup: 'rounded-3xl p-6 shadow-2xl',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif
        });
    </script>

    @include('dosen.partials.modal_tutorial')
</body>
</html>
