<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ketersediaan & Jadwal Lab - Portal Dosen DIGITAL Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex shadow-xl z-20">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-sm leading-tight text-white">DIGITAL Board</h1>
                <p class="text-xs font-bold tracking-wide text-teal-300">Smart Lab Management</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1.5">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl w-full transition font-bold text-sm">
                <i class="fa-solid fa-border-all text-sm"></i>
                <span class="tracking-wide">Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl w-full transition font-bold text-sm">
                <i class="fa-solid fa-calendar-alt text-sm"></i>
                <span class="tracking-wide">Agenda Perkuliahan</span>
            </a>
            <a href="{{ route('dosen.jadwal-lab') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-800 text-white rounded-xl w-full font-extrabold text-sm shadow-md">
                <i class="fa-solid fa-calendar-check text-sm"></i>
                <span class="tracking-wide">Ketersediaan Lab</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl w-full transition font-bold text-sm">
                <i class="fa-solid fa-gear text-sm"></i>
                <span class="tracking-wide">Pengaturan Akun</span>
            </a>
        </nav>

        <!-- Tombol Panduan Dosen di Sidebar -->
        <div class="p-3 border-t border-slate-800 mt-auto">
            <button type="button" onclick="openTutorialDosenModal()" class="flex items-center gap-3 px-3.5 py-2.5 bg-amber-500/15 border border-amber-500/30 text-amber-300 hover:bg-amber-500/25 hover:text-white rounded-xl w-full transition text-xs font-bold cursor-pointer">
                <i class="fa-solid fa-book-open-reader text-sm text-amber-400"></i>
                <span>Panduan Dosen</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-xs z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-teal-800 text-white rounded-xl flex lg:hidden items-center justify-center font-bold shadow-xs">
                    <i class="fa-solid fa-graduation-cap text-base"></i>
                </div>
                <div>
                    <h2 class="font-extrabold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                    <h2 class="font-extrabold text-lg text-slate-900 hidden lg:block">Jadwal & Ketersediaan Ruangan Lab</h2>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <!-- Tombol Panduan / Tutorial Dosen -->
                <button type="button" onclick="openTutorialDosenModal()" class="flex items-center gap-2 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-900 rounded-xl text-xs font-extrabold transition shadow-2xs cursor-pointer" title="Buka Panduan & Tutorial Penggunaan Portal Dosen">
                    <i class="fa-solid fa-circle-question text-amber-600 text-sm"></i>
                    <span class="hidden sm:inline">Panduan Sistem</span>
                </button>

                <!-- Profile Avatar & Dropdown Menu -->
                <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1.5 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="font-extrabold text-xs text-slate-900 group-hover:text-teal-800 transition leading-tight">{{ $dosen->nama }}</p>
                        <p class="text-xs font-bold tracking-wide text-teal-800 mt-0.5">NIP: {{ $dosen->nip }} • Dosen</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-teal-800 group-hover:bg-teal-900 text-white flex items-center justify-center font-extrabold text-xs transition transform group-hover:scale-105 shadow-sm">
                        {{ substr($dosen->nama, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-500 group-hover:text-slate-700 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                        <p class="text-xs font-extrabold text-slate-900 truncate">{{ $dosen->nama }}</p>
                        <p class="text-xs text-slate-600 font-mono font-bold mt-0.5">NIP: {{ $dosen->nip }}</p>
                        <span class="inline-block mt-1.5 px-2.5 py-0.5 bg-teal-100 text-teal-900 border border-teal-200 rounded-md text-xs font-extrabold">
                            Dosen Pengajar
                        </span>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-900 transition font-bold group">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-800 flex items-center justify-center text-slate-600 transition">
                                <i class="fa-solid fa-gear text-xs"></i>
                            </div>
                            <div>
                                <span class="font-extrabold block">Pengaturan Akun</span>
                                <span class="text-xs text-slate-500 block font-medium">Edit profil & ganti password</span>
                            </div>
                        </a>
                    </div>

                    <div class="pt-1 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-rose-700 hover:bg-rose-50 transition font-extrabold text-left group">
                                <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center transition">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                </div>
                                <span>Keluar / Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6">
            
            <!-- Panduan Penggunaan Ramah Dosen Senior -->
            <div class="bg-gradient-to-r from-teal-900 via-teal-800 to-slate-900 text-white rounded-2xl p-5 sm:p-6 shadow-md relative overflow-hidden">
                <div class="relative z-10 max-w-3xl space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-teal-700/80 rounded-full text-xs font-extrabold text-teal-200">
                        <i class="fa-solid fa-circle-info"></i> Petunjuk Kalender Ruangan Lab
                    </div>
                    <h2 class="text-lg sm:text-xl font-extrabold tracking-tight">
                        Cek Jam Kosong & Jadwalkan Kuliah Pengganti
                    </h2>
                    <p class="text-xs sm:text-sm text-teal-100 leading-relaxed font-medium">
                        Halaman ini memudahkan Anda melihat apakah ruang laboratorium sedang dipakai atau kosong. 
                        Pilih <strong class="text-white font-bold underline">Laboratorium</strong> dan <strong class="text-white font-bold underline">Tanggal</strong>, lalu klik kotak hijau <strong class="text-emerald-300 font-bold">[ + Pakai Jam Ini ]</strong> untuk langsung memesan jam tersebut tanpa khawatir bentrok dengan dosen lain.
                    </p>
                </div>
                <div class="absolute right-4 -bottom-6 text-teal-700/20 text-9xl font-black pointer-events-none hidden sm:block">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>

            <!-- Filter Bilah Pilihan Lab & Tanggal -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <form action="{{ route('dosen.jadwal-lab') }}" method="GET" id="filterLabForm" class="flex flex-wrap items-end gap-3 sm:gap-4">
                    
                    <!-- 1. Pilihan Laboratorium -->
                    <div class="flex-1 min-w-[220px]">
                        <label class="block text-xs font-extrabold text-slate-800 mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-door-open text-teal-700"></i> Pilih Laboratorium:
                        </label>
                        <select name="lab_id" onchange="document.getElementById('filterLabForm').submit()" class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-teal-700 focus:border-teal-700 outline-none cursor-pointer">
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}" {{ $selectedLabId == $lab->id ? 'selected' : '' }}>
                                    {{ $lab->nama_lab }} ({{ $lab->lokasi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 2. Pilihan Tanggal -->
                    <div class="w-full sm:w-auto min-w-[190px]">
                        <label class="block text-xs font-extrabold text-slate-800 mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-day text-teal-700"></i> Tanggal Pelaksanaan:
                        </label>
                        <input type="date" name="tanggal" value="{{ $selectedDate }}" onchange="document.getElementById('filterLabForm').submit()" class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-teal-700 focus:border-teal-700 outline-none cursor-pointer">
                    </div>

                    <!-- Tombol Cepat: Hari Ini & Besok -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => date('Y-m-d')]) }}" class="px-3.5 py-2.5 {{ $selectedDate === date('Y-m-d') ? 'bg-teal-800 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} rounded-xl text-xs font-extrabold transition">
                            Hari Ini
                        </a>
                        <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => date('Y-m-d', strtotime('+1 day'))]) }}" class="px-3.5 py-2.5 {{ $selectedDate === date('Y-m-d', strtotime('+1 day')) ? 'bg-teal-800 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} rounded-xl text-xs font-extrabold transition">
                            Besok
                        </a>
                    </div>

                    <!-- Mode Tampilan (Harian vs Matriks Mingguan) -->
                    <div class="ml-auto flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200">
                        <button type="button" onclick="switchViewMode('daily')" id="btn-mode-daily" class="px-3 py-1.5 rounded-lg text-xs font-extrabold bg-white text-teal-900 shadow-xs flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-list-check"></i> Slot Harian
                        </button>
                        <button type="button" onclick="switchViewMode('weekly')" id="btn-mode-weekly" class="px-3 py-1.5 rounded-lg text-xs font-extrabold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-table-cells"></i> Matriks Mingguan
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAMPILAN 1: SLOT HARIAN (PALING MUDAH UNTUK DOSEN SENIOR) -->
            <div id="view-daily-slots" class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">
                            Ketersediaan Jam pada: <span class="text-teal-800">{{ $carbonDate->translatedFormat('l, d F Y') }}</span>
                        </h3>
                        <p class="text-xs text-slate-600 font-medium">
                            Laboratorium: <strong class="text-slate-800 font-bold">{{ $selectedLab->nama_lab ?? 'Lab' }}</strong> ({{ $selectedLab->lokasi ?? '' }})
                        </p>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-900 border border-emerald-300 rounded-full text-xs font-extrabold">
                        {{ collect($slotAvailability)->where('is_occupied', false)->count() }} Slot Jam Kosong
                    </span>
                </div>

                <!-- Grid Slot Waktu -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($slotAvailability as $item)
                        @if(!$item['is_occupied'])
                            <!-- KARTU SLOT KOSONG (HIJAU BESAR & JELAS) -->
                            <div class="p-5 bg-emerald-50/80 border-2 border-emerald-300 rounded-2xl shadow-xs flex flex-col justify-between hover:border-emerald-500 hover:bg-emerald-100/70 transition space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2.5 py-1 bg-emerald-200/80 text-emerald-900 rounded-lg text-xs font-extrabold flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock"></i> {{ $item['slot']['label'] }}
                                        </span>
                                        <span class="px-2 py-0.5 bg-white text-emerald-800 border border-emerald-300 rounded-md text-xs font-extrabold uppercase">
                                            {{ $item['slot']['session'] }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <h4 class="text-base font-extrabold text-emerald-950 flex items-center gap-1.5">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i> KOSONG (BISA DIPAKAI)
                                        </h4>
                                        <p class="text-xs text-emerald-800 font-medium mt-1 leading-relaxed">
                                            Ruangan bebas pada jam ini. Silakan gunakan untuk jadwal kuliah pengganti atau kelas tambahan.
                                        </p>
                                    </div>
                                </div>

                                <button type="button" 
                                        onclick="openBookingModal('{{ $item['slot']['start'] }}', '{{ $item['slot']['end'] }}')" 
                                        class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                                    <i class="fa-solid fa-calendar-plus text-sm"></i> Pakai Jam Ini
                                </button>
                            </div>
                        @else
                            <!-- KARTU SLOT TERISI (MERAH TEGAS & TRANSAPARAN INFORMASI) -->
                            <div class="p-5 {{ $item['is_mine'] ? 'bg-teal-50/80 border-2 border-teal-300' : 'bg-rose-50/80 border-2 border-rose-200' }} rounded-2xl shadow-xs flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2.5 py-1 {{ $item['is_mine'] ? 'bg-teal-200 text-teal-900' : 'bg-rose-200 text-rose-900' }} rounded-lg text-xs font-extrabold flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock"></i> {{ $item['slot']['label'] }}
                                        </span>
                                        @if($item['is_mine'])
                                            <span class="px-2.5 py-0.5 bg-teal-800 text-white rounded-md text-xs font-extrabold">
                                                🌟 Jadwal Anda
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 bg-rose-600 text-white rounded-md text-xs font-extrabold">
                                                ⛔ SUDAH TERISI
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-2 space-y-1">
                                        <h4 class="text-sm font-extrabold text-slate-900 line-clamp-2">
                                            {{ $item['title'] }}
                                        </h4>
                                        <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                                            <span class="px-2 py-0.5 bg-white border border-slate-200 rounded">Kelas {{ $item['kelas'] }}</span>
                                            <span>Jam: {{ $item['exact_time'] }} WIB</span>
                                        </div>
                                        <p class="text-xs font-medium text-slate-600 pt-1 flex items-center gap-1.5">
                                            <i class="fa-solid fa-user-tie text-slate-400"></i> Pengajar: <strong class="text-slate-800">{{ $item['dosen_name'] }}</strong>
                                        </p>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-200/60 flex items-center justify-between text-xs text-slate-500 font-semibold">
                                    <span><i class="fa-solid fa-lock mr-1 text-slate-400"></i> Tidak tersedia</span>
                                    <span class="italic text-[11px] text-slate-400">Sumber: {{ $item['source'] }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- TAMPILAN 2: MATRIKS MINGGUAN (UNTUK MELIHAT SEMUA HARI SENIN - SABTU) -->
            <div id="view-weekly-matrix" class="hidden bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-slate-900 text-white px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-table-cells text-teal-400 text-lg"></i>
                        <div>
                            <h3 class="font-extrabold text-sm uppercase tracking-wide">
                                Matriks Mingguan {{ strtoupper($selectedLab->nama_lab ?? 'Lab') }}
                            </h3>
                            <p class="text-xs text-slate-300 font-medium">Jadwal Penggunaan Rutin Semester Aktif (Senin - Sabtu)</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100 border-b border-slate-200 text-slate-800 font-extrabold uppercase tracking-wider text-center">
                                <th class="p-3 border-r border-slate-200 w-32 bg-slate-200/90 text-xs">Waktu</th>
                                @foreach($hariList as $hari)
                                    <th class="p-3 border-r border-slate-200 min-w-[170px] text-xs {{ $hari === $selectedDayName ? 'bg-teal-50 text-teal-900 font-black' : '' }}">{{ $hari }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($matrixSlots as $slot)
                                @php
                                    list($slotStart, $slotEnd) = explode('-', $slot);
                                    $slotStartClean = str_replace('.', ':', trim($slotStart)) . ':00';
                                    $slotEndClean = str_replace('.', ':', trim($slotEnd)) . ':00';
                                @endphp
                                <tr>
                                    <td class="p-2.5 text-center font-mono font-extrabold text-slate-700 bg-slate-50 border-r border-slate-200 text-xs">
                                        {{ $slot }}
                                    </td>
                                    @foreach($hariList as $hari)
                                        @php
                                            $matches = $rutinJadwals->filter(function($j) use ($hari, $slotStartClean, $slotEndClean) {
                                                return $j->hari === $hari && (
                                                    ($j->jam_mulai <= $slotStartClean && $j->jam_selesai > $slotStartClean) ||
                                                    ($j->jam_mulai >= $slotStartClean && $j->jam_mulai < $slotEndClean)
                                                );
                                            });
                                        @endphp
                                        <td class="p-2 border-r border-slate-200 align-top hover:bg-slate-50 transition {{ $hari === $selectedDayName ? 'bg-teal-50/30' : '' }}">
                                            @if($matches->isNotEmpty())
                                                @foreach($matches as $m)
                                                    @php
                                                        $isMySchedule = ($m->dosen_id == $dosen->id || ($m->dosen_pengampu_id ?? null) == $dosen->id);
                                                    @endphp
                                                    <div class="p-2.5 rounded-xl border {{ $isMySchedule ? 'bg-teal-900 text-white border-teal-800' : 'bg-slate-800 text-white border-slate-700' }} shadow-xs mb-1 text-xs leading-tight">
                                                        @if($isMySchedule)
                                                            <span class="inline-block px-1.5 py-0.5 bg-teal-500 text-slate-950 font-black rounded text-[10px] mb-1">Jadwal Anda</span>
                                                        @endif
                                                        <div class="font-extrabold line-clamp-2 text-xs">{{ $m->mata_kuliah }}</div>
                                                        <div class="text-xs text-teal-200 font-bold mt-1">Kelas {{ $m->kelas }}</div>
                                                        <div class="text-xs text-slate-200 font-medium mt-0.5">
                                                            <i class="fa-solid fa-user-tie text-[10px]"></i> {{ $m->dosen->nama ?? '-' }}
                                                        </div>
                                                        <div class="text-xs font-mono opacity-80 mt-1">
                                                            {{ substr($m->jam_mulai,0,5) }} - {{ substr($m->jam_selesai,0,5) }} WIB
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="p-2 rounded-lg border border-dashed border-emerald-300 bg-emerald-50/50 text-emerald-800 text-center text-xs font-bold py-3">
                                                    <span>Kosong</span>
                                                </div>
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
    </main>

    <!-- MODAL POPUP: BUAT JADWAL / KULIAH PENGGANTI (TERISI OTOMATIS SAAT KLIK SLOT KOSONG) -->
    <div id="modal-booking-slot" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-lg w-full overflow-hidden text-left animate-in fade-in zoom-in duration-150">
            <div class="bg-teal-800 text-white px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-teal-700 flex items-center justify-center font-bold text-white">
                        <i class="fa-solid fa-calendar-check text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm">Pakai Jam Kosong Ini</h3>
                        <p class="text-xs text-teal-200 font-bold">Buat Jadwal Perkuliahan / Kuliah Pengganti</p>
                    </div>
                </div>
                <button type="button" onclick="closeBookingModal()" class="text-teal-200 hover:text-white text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('dosen.agenda.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                @csrf
                <input type="hidden" name="lab_id" value="{{ $selectedLabId }}">
                <input type="hidden" name="tanggal" value="{{ $selectedDate }}">

                <!-- Kotak Info Ringkasan Jam & Lab yang Dipilih -->
                <div class="p-3.5 bg-teal-50 border border-teal-200 rounded-2xl space-y-1">
                    <div class="flex justify-between items-center text-xs font-extrabold text-teal-950">
                        <span><i class="fa-solid fa-door-open mr-1 text-teal-700"></i> {{ $selectedLab->nama_lab ?? 'Lab' }} ({{ $selectedLab->lokasi ?? '' }})</span>
                        <span class="px-2 py-0.5 bg-teal-200 text-teal-900 rounded font-bold">{{ $carbonDate->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="text-xs font-bold text-slate-700 pt-1">
                        Jam Pelaksanaan: <span id="modal-display-jam" class="text-teal-900 font-mono font-black text-sm">-</span>
                    </div>
                </div>

                <!-- Pilihan Mata Kuliah Dosen -->
                <div>
                    <label class="block text-slate-800 font-extrabold mb-1">
                        Pilih Mata Kuliah & Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select name="jadwal_penggunaan_lab_id" id="modal-select-matkul" required onchange="onBookingMatkulChange(this)" class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-teal-700 focus:border-teal-700 outline-none">
                        <option value="">-- Pilih Mata Kuliah Anda --</option>
                        @foreach($myClasses as $mc)
                            <option value="{{ $mc->id }}" 
                                    data-matkul="{{ $mc->mata_kuliah }}" 
                                    data-kelas="{{ $mc->kelas }}"
                                    data-prodi="{{ $mc->prodi->nama_prodi ?? 'Informatika' }}">
                                {{ $mc->mata_kuliah }} - Kelas {{ $mc->kelas }} ({{ $mc->prodi->nama_prodi ?? 'Informatika' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Jam Mulai & Selesai (Otomatis Terisi & Bisa Disesuaikan) -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-800 font-extrabold mb-1">Jam Mulai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_masuk" id="modal-waktu-masuk" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-extrabold text-slate-900 focus:ring-2 focus:ring-teal-700 focus:border-teal-700 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-800 font-extrabold mb-1">Jam Selesai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_keluar" id="modal-waktu-keluar" required class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono font-extrabold text-slate-900 focus:ring-2 focus:ring-teal-700 focus:border-teal-700 outline-none">
                    </div>
                </div>

                <!-- Rencana Pembelajaran / Keterangan -->
                <div>
                    <label class="block text-slate-800 font-extrabold mb-1">Rencana Materi / Keterangan Kuliah Pengganti <span class="text-rose-500">*</span></label>
                    <textarea name="rencana_pembelajaran" rows="3" required placeholder="Contoh: Kuliah Pengganti Pertemuan 4 yang terlewat / Materi Praktikum Lanjutan..." class="w-full p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:ring-2 focus:ring-teal-700 focus:border-teal-700 outline-none"></textarea>
                </div>

                <!-- Bilah Aksi Tombol Simpan -->
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" onclick="closeBookingModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold rounded-xl transition text-xs">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white font-extrabold rounded-xl transition shadow-sm text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Sesi Pengganti
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Bottom Navigation Bar -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 px-6 py-2 flex justify-between items-center z-40 shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-800">
            <i class="fa-solid fa-border-all text-base"></i>
            <span class="text-xs font-bold">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-800">
            <i class="fa-solid fa-calendar-alt text-base"></i>
            <span class="text-xs font-bold">Agenda</span>
        </a>
        <a href="{{ route('dosen.jadwal-lab') }}" class="flex flex-col items-center gap-1 text-teal-850">
            <i class="fa-solid fa-calendar-check text-base"></i>
            <span class="text-xs font-bold">Lab</span>
        </a>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-800">
            <i class="fa-solid fa-gear text-base"></i>
            <span class="text-xs font-bold">Akun</span>
        </a>
    </div>

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

        function openBookingModal(startTime, endTime) {
            const modal = document.getElementById('modal-booking-slot');
            const inMasuk = document.getElementById('modal-waktu-masuk');
            const inKeluar = document.getElementById('modal-waktu-keluar');
            const displayJam = document.getElementById('modal-display-jam');

            if (inMasuk) inMasuk.value = startTime;
            if (inKeluar) inKeluar.value = endTime;
            if (displayJam) displayJam.innerText = startTime + ' - ' + endTime + ' WIB';

            if (modal) modal.classList.remove('hidden');
        }

        function closeBookingModal() {
            const modal = document.getElementById('modal-booking-slot');
            if (modal) modal.classList.add('hidden');
        }

        function onBookingMatkulChange(selectEl) {
            // Optional callback
        }

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
