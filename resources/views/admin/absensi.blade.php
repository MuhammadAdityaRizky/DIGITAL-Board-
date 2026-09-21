<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Laporan Presensi Mahasiswa</h2>
            </div>
            
            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ auth()->user()->username }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500 uppercase">SUPER ADMIN</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ strtoupper(substr(auth()->user()->username ?? 'AD', 0, 2)) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->username ?? 'Administrator' }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-md text-[9px] font-bold uppercase tracking-wider">
                            Super Admin
                        </span>
                    </div>

                    <div class="p-1">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold text-left group">
                                <div class="w-7 h-7 rounded-lg bg-rose-50 group-hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                </div>
                                <span>Keluar / Logout</span>
                            </button>
                        </form>
                    </div>
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
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center flex-wrap gap-3">
                    <h3 class="font-bold text-sm text-slate-800">Laporan Kehadiran Per Sesi Praktikum</h3>
                    <div class="flex gap-2">
                        <button onclick="document.getElementById('modal-import-global').classList.remove('hidden')" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white border border-blue-700 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-file-excel"></i> Import Excel Global
                        </button>
                        <button type="button" onclick="document.getElementById('modal-cetak-absensi').classList.remove('hidden')" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-print"></i> Cetak Presensi Per Matkul (1-16)
                        </button>
                    </div>
                </div>

                <!-- Modal Selection Cetak Absensi Per Mata Kuliah (1-16) -->
                <div id="modal-cetak-absensi" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 relative text-left">
                        <button onclick="document.getElementById('modal-cetak-absensi').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg">
                                <i class="fa-solid fa-print"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-800">Cetak Presensi Per Mata Kuliah</h3>
                                <p class="text-xs text-slate-500">Pilih Mata Kuliah & Kelas untuk mencetak Lembar Isi Presensi Mahasiswa (Format Resmi UIKA A4 Landscape, Pertemuan 1 - 16).</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.absensi.export') }}" method="GET" target="_blank" class="mt-4 space-y-4">
                            <div>
                                <div class="flex justify-between items-center mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700">Pilih Mata Kuliah & Kelas (Bisa Pilih Banyak)</label>
                                    <label class="inline-flex items-center gap-1.5 text-xs text-indigo-600 font-semibold cursor-pointer">
                                        <input type="checkbox" id="select-all-cetak-mk" onchange="toggleSelectAllCetakMk(this)" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                        Pilih Semua
                                    </label>
                                </div>
                                <div class="max-h-56 overflow-y-auto border border-slate-200 rounded-lg p-2.5 bg-slate-50/50 space-y-2 text-xs">
                                    @if(isset($uniqueClasses) && $uniqueClasses->count() > 0)
                                        @foreach($uniqueClasses as $item)
                                            <label class="flex items-start gap-2.5 p-2 bg-white rounded border border-slate-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition cursor-pointer">
                                                <input type="checkbox" name="agenda_ids[]" value="{{ $item->id }}" class="item-cetak-mk mt-0.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <div class="flex-1">
                                                    <span class="font-bold text-slate-800 block">{{ $item->mata_kuliah }}</span>
                                                    <span class="text-[11px] text-slate-500">Kelas: <strong class="text-slate-700">{{ $item->kelas ?: '-' }}</strong> | Dosen: {{ $item->dosen->nama ?? '-' }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    @else
                                        <p class="text-slate-400 italic text-center py-4">Tidak ada data mata kuliah yang tersedia.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Dari Tanggal (Opsional)</label>
                                    <input type="date" name="start_date" class="w-full text-xs rounded-lg border-slate-300 py-2 px-3">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Sampai Tanggal (Opsional)</label>
                                    <input type="date" name="end_date" class="w-full text-xs rounded-lg border-slate-300 py-2 px-3">
                                </div>
                            </div>

                            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                                <button type="button" onclick="document.getElementById('modal-cetak-absensi').classList.add('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                    Batal
                                </button>
                                <button type="submit" onclick="document.getElementById('modal-cetak-absensi').classList.add('hidden')" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-2 shadow-md">
                                    <i class="fa-solid fa-print"></i> Cetak Lembar Presensi (A4)
                                </button>
                            </div>
                        </form>
                        <script>
                        function toggleSelectAllCetakMk(master) {
                            const checkboxes = document.querySelectorAll('.item-cetak-mk');
                            checkboxes.forEach(cb => cb.checked = master.checked);
                        }
                        </script>
                    </div>
                </div>

                <!-- Modal Import Global -->
                <div id="modal-import-global" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative">
                        <button onclick="document.getElementById('modal-import-global').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Import Absensi Excel (Semua Agenda)</h3>
                        <p class="text-xs text-slate-500 mb-6">Pilih kelas dan unggah file Excel. Sistem akan memproses seluruh jadwal pertemuan untuk kelas yang Anda pilih.</p>
                        
                        <form action="{{ route('admin.absensi.import-global') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Mata Kuliah & Kelas</label>
                                <select name="mata_kuliah_kelas" required class="w-full text-sm p-2.5 rounded-lg border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                    @foreach($uniqueClasses as $uc)
                                        <option value="{{ $uc->mata_kuliah }}|{{ $uc->kelas }}|{{ $uc->dosen_id }}">
                                            {{ $uc->mata_kuliah }} {{ $uc->kelas ? '('.$uc->kelas.')' : '' }} - Dosen: {{ $uc->dosen->nama ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Upload File Excel (.xlsx, .xls)</label>
                                <input type="file" name="file_excel" accept=".xlsx, .xls" required class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 transition
                                "/>
                                <div class="mt-2 text-right">
                                    <a href="{{ route('template.download', 'absensi') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 mt-6">
                                <button type="button" onclick="document.getElementById('modal-import-global').classList.add('hidden')" class="px-4 py-2 text-sm font-bold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition"><i class="fa-solid fa-cloud-arrow-up mr-2"></i> Import Data</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    @if(isset($groupedAgendas) && $groupedAgendas->count() > 0)
                        @foreach($groupedAgendas as $groupKey => $groupItems)
                            @php
                                $firstAgenda = $groupItems->first();
                            @endphp
                            <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                                <!-- HEADER JUDUL MATA KULIAH & KELAS -->
                                <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-teal-950 text-white px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-teal-500/20 border border-teal-400/30 flex items-center justify-center text-teal-300 font-bold text-lg">
                                            <i class="fa-solid fa-book-bookmark"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h3 class="font-extrabold text-base text-white tracking-tight">{{ $firstAgenda->mata_kuliah }}</h3>
                                                <span class="px-2.5 py-0.5 bg-teal-500/30 text-teal-200 border border-teal-400/40 rounded-md text-[10px] font-bold uppercase">
                                                    Kelas {{ $firstAgenda->kelas ?: '-' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-300 mt-0.5">
                                                Dosen: <strong class="text-white">{{ $firstAgenda->dosen->nama ?? 'Dosen Pengampu' }}</strong> • {{ $firstAgenda->lab->nama_lab ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                                        <span class="px-3 py-1.5 bg-white/10 text-slate-200 border border-white/20 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-list-check mr-1 text-teal-300"></i> {{ $groupItems->count() }} Pertemuan
                                        </span>
                                        <form action="{{ route('admin.absensi.export') }}" method="GET" target="_blank" class="inline">
                                            @foreach($groupItems as $agItem)
                                                <input type="hidden" name="agenda_ids[]" value="{{ $agItem->id }}">
                                            @endforeach
                                            <button type="submit" class="px-3.5 py-1.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-extrabold rounded-lg text-xs transition flex items-center gap-1.5 shadow-md cursor-pointer">
                                                <i class="fa-solid fa-print"></i> Cetak Presensi Matkul Ini (1-16)
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                 <!-- DAFTAR PERTEMUAN KE-N & LAPORAN ABSENSINYA -->
                                <div class="p-5 space-y-3 bg-slate-50/40">
                                    @foreach($groupItems as $meetIndex => $ag)
                                        <div class="pertemuan-accordion-item border border-slate-200 rounded-xl overflow-hidden bg-white shadow-2xs">
                                            <!-- Sub-Header: PERTEMUAN KE-N (ACCORDION TOGGLE HEADER) -->
                                            <div onclick="togglePertemuanAccordion(this)" class="pertemuan-header bg-slate-100/90 hover:bg-slate-200/80 border-b border-slate-200 px-5 py-3 flex flex-col md:flex-row justify-between items-start md:items-center gap-2 cursor-pointer select-none transition">
                                                <div class="flex items-center gap-2.5">
                                                    <span class="w-7 h-7 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                        {{ $meetIndex + 1 }}
                                                    </span>
                                                    <div>
                                                        <h4 class="font-bold text-slate-800 text-xs flex items-center gap-2 flex-wrap">
                                                            <span>Pertemuan ke-{{ $meetIndex + 1 }}</span>
                                                            <span class="text-slate-400 font-normal">|</span>
                                                            <span class="text-slate-600 font-semibold"><i class="fa-regular fa-calendar-check text-teal-700 mr-1"></i>{{ date('d F Y', strtotime($ag->tanggal)) }}</span>
                                                            <span class="text-slate-500 font-mono text-[11px]">({{ substr($ag->jam_mulai, 0, 5) }} - {{ substr($ag->jam_selesai, 0, 5) }} WIB)</span>
                                                        </h4>
                                                        <div class="text-[10px] text-slate-500 mt-0.5">
                                                            @if($ag->dosen_waktu_masuk)
                                                                <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded font-bold">
                                                                    <i class="fa-solid fa-circle-check"></i> Check-in Dosen: {{ date('H:i:s', strtotime($ag->dosen_waktu_masuk)) }} WIB
                                                                </span>
                                                            @else
                                                                <span class="px-1.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded font-bold">
                                                                    <i class="fa-solid fa-circle-xmark"></i> Dosen Belum Check-in
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex items-center gap-3 self-end md:self-center">
                                                    @if($ag->tanggal > date('Y-m-d'))
                                                        <span onclick="event.stopPropagation()" class="text-[10px] bg-slate-100 text-slate-400 border border-slate-200 font-semibold py-1 px-2.5 rounded-lg select-none" title="Sesi perkuliahan belum berlangsung">
                                                            <i class="fa-solid fa-lock text-[9px]"></i> Belum Diberlakukan
                                                        </span>
                                                    @else
                                                        <a href="{{ route('admin.absensi.input', $ag->id) }}" onclick="event.stopPropagation()" class="text-[10px] bg-teal-600 hover:bg-teal-700 text-white font-bold py-1 px-3 rounded-lg transition shadow-2xs flex items-center gap-1.5">
                                                            <i class="fa-solid fa-pen-to-square"></i> {{ $ag->tanggal === date('Y-m-d') ? 'Input Absensi Manual' : 'Edit Rekap Absensi' }}
                                                        </a>
                                                    @endif
                                                    <div class="w-6 h-6 rounded-full bg-slate-200/60 flex items-center justify-center text-slate-600 transition">
                                                        <i class="fa-solid fa-chevron-down accordion-icon text-xs transition-transform duration-200 {{ $meetIndex === 0 ? 'rotate-180' : '' }}"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- LAPORAN ABSENSINYA (COLLAPSIBLE CONTENT BODY) -->
                                            <div class="pertemuan-body p-4 bg-white {{ $meetIndex === 0 ? '' : 'hidden' }}">
                                                @if($ag->absensi->count() > 0)
                                                    <div class="overflow-x-auto rounded-lg border border-slate-150 text-xs">
                                                        <table class="w-full text-left text-slate-700">
                                                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                                                <tr>
                                                                    <th class="p-2.5 w-12 text-center">No</th>
                                                                    <th class="p-2.5">Mahasiswa (NIM)</th>
                                                                    <th class="p-2.5">Waktu Masuk</th>
                                                                    <th class="p-2.5 text-center">Status Kehadiran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-slate-100">
                                                                @foreach($ag->absensi as $index => $abs)
                                                                    <tr class="hover:bg-slate-50/60 transition">
                                                                        <td class="p-2.5 text-slate-400 font-mono text-center">{{ $index + 1 }}</td>
                                                                        <td class="p-2.5">
                                                                            <span class="font-bold text-slate-800 block text-xs">{{ $abs->mahasiswa->nama_lengkap }}</span>
                                                                            <span class="text-[10px] font-mono text-teal-800 font-semibold">NIM: {{ $abs->mahasiswa->nim }}</span>
                                                                        </td>
                                                                        <td class="p-2.5 font-mono text-slate-500 text-xs">{{ date('H:i:s', strtotime($abs->waktu_masuk)) }} WIB</td>
                                                                        <td class="p-2.5 text-center">
                                                                            <span class="px-2.5 py-0.5 border font-extrabold rounded text-[9px] uppercase tracking-wider
                                                                                @if(strtolower($abs->status_kehadiran) === 'hadir') bg-emerald-50 text-emerald-700 border-emerald-200
                                                                                @elseif(strtolower($abs->status_kehadiran) === 'terlambat') bg-amber-50 text-amber-700 border-amber-200
                                                                                @elseif(strtolower($abs->status_kehadiran) === 'izin' || strtolower($abs->status_kehadiran) === 'sakit') bg-blue-50 text-blue-700 border-blue-200
                                                                                @else bg-rose-50 text-rose-700 border-rose-200
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
                                                    <p class="text-center py-3 text-[11px] text-slate-400 italic">
                                                        <i class="fa-solid fa-info-circle mr-1 text-slate-400"></i> Belum ada rekaman data presensi pada Pertemuan ke-{{ $meetIndex + 1 }}.
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
                            <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-2 block"></i>
                            <p class="text-slate-500 font-bold text-sm">Data agenda praktikum tidak ditemukan.</p>
                            <p class="text-slate-400 text-xs mt-1">Coba sesuaikan kata kunci pencarian atau filter tanggal.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
        function confirmAction(event, text, title = 'Apakah Anda yakin?', confirmText = 'Ya, Lanjutkan!') {
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            if (form && form.dataset.confirmed === "true") {
                return true;
            }

            event.preventDefault();
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.dataset.confirmed = "true";
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            });
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium'
                    }
                });
            @endif

            @if(session('error') || session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error') ?? session('failed')),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            @if($errors->any() && !session('success') && !session('error') && !session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memproses Data!',
                    text: @json($errors->first()),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            // CRUD & Form Submit Loading Spinner
            document.querySelectorAll('form').forEach(function(form) {
                if (form.method.toUpperCase() === 'GET' || form.classList.contains('no-loading')) {
                    return;
                }

                form.addEventListener('submit', function(e) {
                    if (e.defaultPrevented) return;
                    if (form.checkValidity && !form.checkValidity()) {
                        return;
                    }

                    const fileInput = form.querySelector('input[type="file"]');
                    if (fileInput && fileInput.required && fileInput.files && fileInput.files.length === 0) {
                        return;
                    }

                    const isLogout = (form.action && form.action.includes('logout')) || form.classList.contains('logout-form');
                    const isImport = form.getAttribute('enctype') === 'multipart/form-data';
                    
                    let loadingTitle = 'Menyimpan Data...';
                    let loadingText = 'Sedang memproses dan menyimpan data ke sistem.';
                    
                    if (isLogout) {
                        loadingTitle = 'Sedang Keluar...';
                        loadingText = 'Menutup sesi akun Anda dengan aman.';
                    } else if (isImport) {
                        loadingTitle = 'Mengimpor Data...';
                        loadingText = 'Sistem sedang membaca dan memproses file Excel/CSV.';
                    }

                    Swal.fire({
                        title: loadingTitle,
                        text: loadingText,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl p-8 shadow-2xl border border-slate-100',
                            title: 'text-base font-extrabold text-slate-800',
                            htmlContainer: 'text-xs text-slate-500 font-medium'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        }
                    }, 10);
                });
            });
        });

        window.addEventListener('pageshow', function() {
            if (typeof Swal !== 'undefined' && Swal.isVisible() && Swal.isLoading()) {
                Swal.close();
            }
        });

        // Pertemuan Accordion Handler (Buka/Tutup Pertemuan secara Otomatis)
        function togglePertemuanAccordion(headerElement) {
            const parentContainer = headerElement.closest('.space-y-3');
            const currentItem = headerElement.closest('.pertemuan-accordion-item');
            const currentBody = currentItem.querySelector('.pertemuan-body');
            const currentIcon = headerElement.querySelector('.accordion-icon');

            if (!currentBody) return;
            const isAlreadyOpen = !currentBody.classList.contains('hidden');

            // Tutup semua pertemuan lain di mata kuliah ini
            if (parentContainer) {
                const allItems = parentContainer.querySelectorAll('.pertemuan-accordion-item');
                allItems.forEach(item => {
                    const body = item.querySelector('.pertemuan-body');
                    const icon = item.querySelector('.accordion-icon');
                    if (body && icon) {
                        body.classList.add('hidden');
                        icon.classList.remove('rotate-180');
                    }
                });
            }

            // Buka jika sebelumnya tertutup
            if (!isAlreadyOpen) {
                currentBody.classList.remove('hidden');
                if (currentIcon) currentIcon.classList.add('rotate-180');
            }
        }

        // Profile Dropdown Handler
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const menu = document.getElementById('profileDropdownMenu');
            const button = event.target.closest('button[onclick="toggleProfileDropdown(event)"]');
            if (menu && !menu.classList.contains('hidden') && !button && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>




