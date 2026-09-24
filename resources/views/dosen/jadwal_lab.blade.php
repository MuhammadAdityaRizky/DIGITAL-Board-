<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

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
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6">
            
            <!-- Header Ringkasan Jadwal & Ketersediaan Lab -->
            <div class="bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-2xs">
                <div class="max-w-3xl space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                        <span class="w-2 h-2 rounded-full bg-slate-900 inline-block"></span>
                        <span>Portal Ketersediaan Ruangan Laboratorium</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                        Jadwal & Ketersediaan Ruangan Lab
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Pilih laboratorium dan tanggal pelaksanaan untuk memeriksa jam kosong. Klik tombol <strong>Pakai Jam Ini</strong> pada slot yang tersedia untuk langsung menjadwalkan kelas perkuliahan atau kuliah pengganti.
                    </p>
                </div>
            </div>

            <!-- Filter Bilah Pilihan Lab & Tanggal -->
            <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-2xs space-y-4">
                <form action="{{ route('dosen.jadwal-lab') }}" method="GET" id="filterLabForm" class="flex flex-wrap items-end gap-3 sm:gap-4">
                    
                    <!-- 1. Pilihan Laboratorium -->
                    <div class="flex-1 min-w-[220px]">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-door-open text-slate-500"></i> Pilih laboratorium
                        </label>
                        <select name="lab_id" onchange="document.getElementById('filterLabForm').submit()" class="w-full p-2.5 bg-white border border-slate-300 rounded-lg text-xs font-semibold text-slate-900 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none cursor-pointer">
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}" {{ $selectedLabId == $lab->id ? 'selected' : '' }}>
                                    {{ $lab->nama_lab }} ({{ $lab->lokasi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 2. Pilihan Tanggal -->
                    <div class="w-full sm:w-auto min-w-[190px]">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-slate-500"></i> Tanggal pelaksanaan
                        </label>
                        <input type="date" name="tanggal" value="{{ $selectedDate }}" onchange="document.getElementById('filterLabForm').submit()" class="w-full p-2.5 bg-white border border-slate-300 rounded-lg text-xs font-semibold text-slate-900 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none cursor-pointer">
                    </div>

                    <!-- Tombol Cepat: Hari Ini & Besok -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => date('Y-m-d')]) }}" class="px-3.5 py-2.5 {{ $selectedDate === date('Y-m-d') ? 'bg-slate-900 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200' }} rounded-lg text-xs font-semibold transition">
                            Hari ini
                        </a>
                        <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $selectedLabId, 'tanggal' => date('Y-m-d', strtotime('+1 day'))]) }}" class="px-3.5 py-2.5 {{ $selectedDate === date('Y-m-d', strtotime('+1 day')) ? 'bg-slate-900 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200' }} rounded-lg text-xs font-semibold transition">
                            Besok
                        </a>
                    </div>

                    <!-- Mode Tampilan (Harian vs Matriks Mingguan) -->
                    <div class="ml-auto flex items-center gap-1 bg-slate-100 p-1 rounded-lg border border-slate-200">
                        <button type="button" onclick="switchViewMode('daily')" id="btn-mode-daily" class="px-3 py-1.5 rounded-md text-xs font-semibold bg-white text-slate-900 shadow-xs flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-list-check"></i> Slot harian
                        </button>
                        <button type="button" onclick="switchViewMode('weekly')" id="btn-mode-weekly" class="px-3 py-1.5 rounded-md text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-table-cells"></i> Matriks mingguan
                        </button>
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdminFakultas())
                        <div class="w-full pt-3 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3 bg-amber-50/90 p-3 rounded-xl border border-amber-200">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user-gear text-amber-600 text-sm"></i>
                                <span class="text-xs font-extrabold text-amber-900">Mode Pratinjau Admin: Pilih Dosen</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <select name="dosen_id" onchange="document.getElementById('filterLabForm').submit()" class="py-1.5 px-3 rounded-lg bg-white border border-amber-300 text-xs font-bold text-slate-800 outline-none cursor-pointer shadow-2xs">
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

            <!-- TAMPILAN 1: SLOT HARIAN -->
            <div id="view-daily-slots" class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">
                            Ketersediaan Jam: <span>{{ $carbonDate->translatedFormat('l, d F Y') }}</span>
                        </h3>
                        <p class="text-xs text-slate-500 font-normal mt-0.5">
                            Ruangan: <strong class="text-slate-800 font-semibold">{{ $selectedLab->nama_lab ?? 'Lab' }}</strong> ({{ $selectedLab->lokasi ?? '' }})
                        </p>
                    </div>
                    <span class="px-3 py-1 bg-slate-100 text-slate-800 border border-slate-200 rounded-md text-xs font-semibold">
                        {{ collect($slotAvailability)->where('is_occupied', false)->count() }} slot kosong
                    </span>
                </div>

                <!-- Grid Slot Waktu -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($slotAvailability as $item)
                        @if(!$item['is_occupied'])
                            <!-- KARTU SLOT KOSONG -->
                            <div class="p-5 bg-white border border-slate-200 hover:border-slate-800 rounded-xl shadow-2xs flex flex-col justify-between transition space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-mono font-semibold text-slate-800 flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-slate-400"></i> {{ $item['slot']['label'] }}
                                        </span>
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded text-[11px] font-medium">
                                            {{ $item['slot']['session'] }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-700 inline-block"></span> Ruangan Kosong
                                        </h4>
                                        <p class="text-xs text-slate-600 font-normal mt-1 leading-relaxed">
                                            Ruangan bebas pada jam ini. Silakan gunakan untuk jadwal kuliah pengganti atau kelas tambahan.
                                        </p>
                                    </div>
                                </div>

                                <button type="button" 
                                        onclick="openBookingModal('{{ $item['slot']['start'] }}', '{{ $item['slot']['end'] }}')" 
                                        class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center gap-2 shadow-2xs cursor-pointer">
                                    <i class="fa-regular fa-calendar-plus text-xs"></i> Pakai Jam Ini
                                </button>
                            </div>
                        @else
                            <!-- KARTU SLOT TERISI -->
                            <div class="p-5 bg-slate-50/70 border border-slate-200 rounded-xl shadow-2xs flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-mono font-semibold text-slate-600 flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock text-slate-400"></i> {{ $item['slot']['label'] }}
                                        </span>
                                        @if($item['is_mine'])
                                            <span class="px-2 py-0.5 bg-amber-100 text-amber-900 border border-amber-200 rounded text-[11px] font-semibold">
                                                Jadwal Anda
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 bg-slate-200/80 text-slate-700 border border-slate-300 rounded text-[11px] font-medium">
                                                Terisi
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-2 space-y-1">
                                        <h4 class="text-sm font-bold text-slate-900 line-clamp-2">
                                            {{ $item['title'] }}
                                        </h4>
                                        <div class="flex items-center gap-2 text-xs text-slate-600">
                                            <span class="font-medium">Kelas {{ $item['kelas'] }}</span>
                                            <span>·</span>
                                            <span>{{ $item['exact_time'] }} WIB</span>
                                        </div>
                                        <p class="text-xs text-slate-600 pt-0.5 flex items-center gap-1.5">
                                            <i class="fa-regular fa-user text-slate-400"></i> Pengajar: <strong class="text-slate-800 font-semibold">{{ $item['dosen_name'] }}</strong>
                                        </p>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                                    <span><i class="fa-solid fa-lock mr-1 text-slate-400"></i> Tidak tersedia</span>
                                    <span class="text-[11px] text-slate-400">Sumber: {{ $item['source'] }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
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

    <!-- MODAL POPUP: BUAT JADWAL / KULIAH PENGGANTI (COMBOBOX DENGAN DESAIN AKADEMIK OTENTIK) -->
    <div id="modal-booking-slot" class="fixed inset-0 bg-slate-900/40 backdrop-blur-[2px] z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-xl border border-slate-300 shadow-xl max-w-lg w-full overflow-hidden text-left animate-in fade-in zoom-in-95 duration-100">
            <!-- Modal Header Bersih (Non-AI, Gaya Institusi Akademik) -->
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-base text-slate-900">Jadwalkan Kuliah Pengganti</h3>
                    <p class="text-xs text-slate-500 mt-0.5 font-normal">Pesan jam kosong lab untuk jadwal perkuliahan atau praktikum</p>
                </div>
                <button type="button" onclick="closeBookingModal()" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-800 hover:bg-slate-200/60 flex items-center justify-center transition" title="Tutup">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form action="{{ route('dosen.agenda.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                @csrf
                <input type="hidden" name="lab_id" value="{{ $selectedLabId }}">
                <input type="hidden" name="tanggal" value="{{ $selectedDate }}">

                <!-- Panel Spesifikasi Ruang & Waktu Terpilih -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-lg space-y-2">
                    <div class="flex justify-between items-center text-xs text-slate-800">
                        <span class="text-slate-500">Laboratorium:</span>
                        <span class="font-semibold text-slate-900">{{ $selectedLab->nama_lab ?? 'Lab' }} ({{ $selectedLab->lokasi ?? '' }})</span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-slate-800">
                        <span class="text-slate-500">Hari & Tanggal:</span>
                        <span class="font-semibold text-slate-900">{{ $carbonDate->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-slate-800 pt-1.5 border-t border-slate-200">
                        <span class="text-slate-500">Alokasi Jam:</span>
                        <span id="modal-display-jam" class="font-mono font-bold text-xs text-slate-900">-</span>
                    </div>
                </div>

                <!-- Pilihan Mata Kuliah & Kelas (COMBOBOX) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-900 mb-1.5">
                        Pilih mata kuliah & kelas <span class="text-rose-600">*</span>
                    </label>
                    
                    <!-- Hidden input penampung value untuk submit form -->
                    <input type="hidden" name="jadwal_penggunaan_lab_id" id="modal-select-matkul-val" required>

                    <!-- Combobox Input & Dropdown -->
                    <div class="relative" id="combobox-wrapper">
                        <div class="relative flex items-center">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-xs pointer-events-none"></i>
                            <input type="text" 
                                   id="combobox-search-input" 
                                   autocomplete="off"
                                   placeholder="Ketik untuk mencari mata kuliah atau kelas..."
                                   class="w-full pl-9 pr-14 py-2.5 bg-white border border-slate-300 rounded-lg text-xs font-semibold text-slate-900 placeholder:text-slate-400 placeholder:font-normal focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition"
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
                             class="hidden absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl max-h-56 overflow-y-auto z-50 divide-y divide-slate-100 py-1">
                            @forelse($myClasses as $mc)
                                <div class="combobox-item px-3.5 py-2.5 hover:bg-slate-50 cursor-pointer transition flex items-center justify-between group"
                                     data-id="{{ $mc->id }}"
                                     data-title="{{ $mc->mata_kuliah }}"
                                     data-kelas="{{ $mc->kelas }}"
                                     data-prodi="{{ $mc->prodi->nama_prodi ?? 'Informatika' }}"
                                     data-search="{{ strtolower($mc->mata_kuliah . ' ' . $mc->kelas . ' ' . ($mc->prodi->nama_prodi ?? '') . ' ' . $mc->hari) }}"
                                     onclick="selectComboboxOption(this)">
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 group-hover:text-black">
                                            {{ $mc->mata_kuliah }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                            <span class="font-medium text-slate-700">Kelas {{ $mc->kelas ?: '-' }}</span>
                                            <span>·</span>
                                            <span>{{ $mc->prodi->nama_prodi ?? 'Informatika' }}</span>
                                            <span>·</span>
                                            <span>Hari {{ $mc->hari }} ({{ substr($mc->jam_mulai,0,5) }}-{{ substr($mc->jam_selesai,0,5) }})</span>
                                        </div>
                                    </div>
                                    <div class="combobox-check hidden text-slate-900 font-bold text-xs pl-2">
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
                        <label class="block text-xs font-semibold text-slate-900 mb-1.5">Jam mulai <span class="text-rose-600">*</span></label>
                        <input type="time" name="waktu_masuk" id="modal-waktu-masuk" required class="w-full p-2.5 bg-white border border-slate-300 rounded-lg text-xs font-mono font-bold text-slate-900 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-900 mb-1.5">Jam selesai <span class="text-rose-600">*</span></label>
                        <input type="time" name="waktu_keluar" id="modal-waktu-keluar" required class="w-full p-2.5 bg-white border border-slate-300 rounded-lg text-xs font-mono font-bold text-slate-900 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                    </div>
                </div>

                <!-- Materi Praktikum / Keterangan -->
                <div>
                    <label class="block text-xs font-semibold text-slate-900 mb-1.5">Materi Praktikum <span class="text-slate-500 font-normal text-[11px]">(Opsional)</span></label>
                    <textarea name="materi_pembelajaran" rows="3" placeholder="Tuliskan materi praktikum atau topik perkuliahan pengganti (Opsional)..." class="w-full p-2.5 bg-white border border-slate-300 rounded-lg text-xs font-medium text-slate-900 placeholder:text-slate-400 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none leading-relaxed"></textarea>
                </div>

                <!-- Bilah Aksi Tombol Simpan -->
                <div class="flex justify-end items-center gap-2.5 pt-3 border-t border-slate-200">
                    <button type="button" onclick="closeBookingModal()" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 font-semibold rounded-lg border border-slate-300 transition text-xs">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg transition shadow-2xs text-xs flex items-center gap-2">
                        <i class="fa-solid fa-check text-xs"></i> Simpan Sesi Pengganti
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical Layout with Center QR) -->
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
            closeComboboxDropdown();
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

            // Set hidden value for form submission
            const hiddenInput = document.getElementById('modal-select-matkul-val');
            if (hiddenInput) hiddenInput.value = id;

            // Set display text on search input
            const searchInput = document.getElementById('combobox-search-input');
            if (searchInput) searchInput.value = title + ' - Kelas ' + (kelas || '-') + ' (' + prodi + ')';

            // Show checkmark on selected item
            document.querySelectorAll('.combobox-check').forEach(c => c.classList.add('hidden'));
            el.querySelector('.combobox-check')?.classList.remove('hidden');

            // Show clear button
            document.getElementById('combobox-clear-btn')?.classList.remove('hidden');

            // Close dropdown
            closeComboboxDropdown();

            // Auto-fill textarea placeholder / initial note if empty
            const rencanaTextarea = document.querySelector('textarea[name="materi_pembelajaran"]') || document.querySelector('textarea[name="rencana_pembelajaran"]');
            if (rencanaTextarea && !rencanaTextarea.value.trim()) {
                rencanaTextarea.value = 'Kuliah Pengganti ' + title + ' (Kelas ' + (kelas || '-') + ')';
            }
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

        // Close combobox when clicking outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('combobox-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeComboboxDropdown();
            }
        });

        // Close on Escape key
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
