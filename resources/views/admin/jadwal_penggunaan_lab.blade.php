<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Penggunaan Lab - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleAdminMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition focus:outline-none cursor-pointer" title="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Pusat Jadwal & Perkuliahan</h2>
                <!-- Tab Switching Navigation (Analyst Recommendation #4) -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs">
                    <a href="{{ route('admin.jadwal-lab') }}" class="px-3.5 py-1.5 bg-teal-800 text-white font-bold rounded-lg shadow-sm flex items-center gap-1.5">
                        <i class="fa-solid fa-table-cells text-teal-300"></i> Matriks Jadwal Lab
                    </a>
                    <a href="{{ route('admin.agenda') }}" class="px-3.5 py-1.5 text-slate-600 hover:text-slate-900 font-medium rounded-lg transition flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days text-slate-400"></i> Agenda & Realisasi
                    </a>
                </div>
            </div>
            
            <!-- User Info & Logout -->
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-medium">Semester Aktif: <strong class="text-slate-800">{{ $tahunAkademik }}</strong></span>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-full">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-full">
                    <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal Menyimpan:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Controls & Lab Filter -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <form action="{{ route('admin.jadwal-lab') }}" method="GET" class="flex flex-wrap items-center gap-3 text-xs w-full sm:w-auto">
                    <div>
                        <label class="block text-slate-500 font-bold mb-1">Pilih Laboratorium:</label>
                        <select name="lab_id" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            @if($labs->isEmpty())
                                <option value="">-- Belum Ada Lab --</option>
                            @else
                                @foreach($labs as $l)
                                    <option value="{{ $l->id }}" {{ $selectedLabId == $l->id ? 'selected' : '' }}>
                                        {{ strtoupper($l->nama_lab) }} ({{ $l->lokasi }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-500 font-bold mb-1">Tahun Akademik:</label>
                        <select name="tahun_akademik" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="2026/2027 Ganjil" {{ $tahunAkademik == '2026/2027 Ganjil' ? 'selected' : '' }}>2026/2027 Ganjil</option>
                            <option value="2026/2027 Genap" {{ $tahunAkademik == '2026/2027 Genap' ? 'selected' : '' }}>2026/2027 Genap</option>
                        </select>
                    </div>
                </form>

                <div class="flex items-center gap-2.5">
                    @if($labs->isNotEmpty())
                        <button type="button" onclick="openImportModal()" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer" title="Import jadwal dari file template Excel">
                            <i class="fa-solid fa-file-import"></i> Impor Excel
                        </button>
                        <a href="{{ route('admin.jadwal-lab.export', ['lab_id' => $selectedLabId, 'tahun_akademik' => $tahunAkademik]) }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer" title="Export format Excel (sesuai template)">
                            <i class="fa-solid fa-file-excel"></i> Export Excel
                        </a>
                        <button type="button" id="btn-bulk-delete" onclick="confirmBulkDelete()" class="hidden px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-trash"></i> Hapus Terpilih (<span id="bulk-delete-count">0</span>)
                        </button>
                        <button type="button" onclick="openAddModal()" class="px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-plus"></i> Tambah Slot Jadwal
                        </button>
                    @else
                        <a href="{{ route('admin.laboratorium') }}" class="px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-plus"></i> Tambah Laboratorium Baru
                        </a>
                    @endif
                </div>
            </div>

            @if($labs->isEmpty())
                <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200/80 flex items-center justify-center mx-auto mb-4 text-2xl shadow-xs">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                    <h3 class="font-extrabold text-base text-slate-800">Fakultas Anda Belum Memiliki Laboratorium</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mt-1.5 leading-relaxed">
                        Saat ini belum ada ruang laboratorium yang terdaftar di bawah naungan fakultas Anda. Silakan tambahkan laboratorium baru terlebih dahulu sebelum mengatur jadwal perkuliahan atau mengimpor file spreadsheet.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.laboratorium') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-xl text-xs transition shadow-sm">
                            <i class="fa-solid fa-plus"></i> Tambah Laboratorium Sekarang
                        </a>
                    </div>
                </div>
            @else
            <!-- Matriks Visual Tabel Excel Mingguan -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-slate-800 text-white px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-calendar-week text-teal-400 text-lg"></i>
                        <div>
                            <h3 class="font-extrabold text-sm uppercase tracking-wide">
                                Jadwal Penggunaan {{ strtoupper($labs->firstWhere('id', $selectedLabId)->nama_lab ?? 'Laboratorium') }}
                            </h3>
                            <p class="text-[11px] text-slate-300">Tahun Akademik {{ $tahunAkademik }} • Format Matriks Jadwal Mingguan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="px-2.5 py-1 bg-teal-600/90 text-white font-bold rounded-lg">{{ $jadwals->count() }} Sesi Terjadwal</span>
                    </div>
                </div>

                <!-- Table Grid -->
                <div class="overflow-x-auto">
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px] text-center">
                                <th class="p-3 border-r border-slate-200 w-32 bg-slate-200/80">Waktu</th>
                                @foreach($hariList as $hari)
                                    <th class="p-3 border-r border-slate-200 min-w-[170px]">{{ $hari }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @php
                                $skipSlots = [];
                                foreach($hariList as $h) {
                                    $skipSlots[$h] = 0;
                                }
                            @endphp
                            @foreach($timeSlots as $slot)
                                @php
                                    list($slotStart, $slotEnd) = explode('-', $slot);
                                    $slotStartClean = str_replace('.', ':', trim($slotStart)) . ':00';
                                    $slotEndClean = str_replace('.', ':', trim($slotEnd)) . ':00';
                                @endphp
                                <tr>
                                    <td class="p-2.5 text-center font-mono font-bold text-slate-600 bg-slate-50 border-r border-slate-200 text-[11px]">
                                        {{ $slot }}
                                    </td>
                                    @foreach($hariList as $hari)
                                        @php
                                            if ($skipSlots[$hari] > 0) {
                                                $skipSlots[$hari]--;
                                                continue;
                                            }

                                            // Find items that overlap or start in this slot
                                            $matches = $jadwals->filter(function($j) use ($hari, $slotStartClean, $slotEndClean) {
                                                return $j->hari === $hari && (
                                                    ($j->jam_mulai <= $slotStartClean && $j->jam_selesai > $slotStartClean) ||
                                                    ($j->jam_mulai >= $slotStartClean && $j->jam_mulai < $slotEndClean)
                                                );
                                            });

                                            $rowspan = 1;
                                            if ($matches->isNotEmpty()) {
                                                $maxEnd = $matches->max('jam_selesai');
                                                $counting = false;
                                                $span = 0;
                                                foreach ($timeSlots as $ts) {
                                                    list($tsStart, $tsEnd) = explode('-', $ts);
                                                    $tsStartClean = str_replace('.', ':', trim($tsStart)) . ':00';
                                                    
                                                    if ($tsStartClean === $slotStartClean) {
                                                        $counting = true;
                                                    }
                                                    
                                                    if ($counting) {
                                                        if ($maxEnd > $tsStartClean) {
                                                            $span++;
                                                        } else {
                                                            break;
                                                        }
                                                    }
                                                }
                                                $rowspan = $span > 0 ? $span : 1;
                                                $skipSlots[$hari] = $rowspan - 1;
                                            }
                                        @endphp
                                        
                                        <td class="p-1 border-r border-slate-200 hover:bg-slate-50/50 transition h-[1px]" @if($rowspan > 1) rowspan="{{ $rowspan }}" @endif>
                                            @if($matches->isNotEmpty())
                                                <div class="h-full flex flex-col gap-1 w-full">
                                                @foreach($matches as $m)
                                                    @php
                                                        // Determine background color based on Prodi
                                                        $prodiName = strtolower($m->prodi->nama_prodi ?? '');
                                                        $bgColor = 'bg-teal-900 text-white border-teal-800';
                                                        if (str_contains($prodiName, 'informasi')) {
                                                            $bgColor = 'bg-[#1b325f] text-white border-[#132547]'; // Biru dongker
                                                        } elseif (str_contains($prodiName, 'sipil')) {
                                                            $bgColor = 'bg-emerald-800 text-white border-emerald-900'; // Hijau
                                                        } elseif (str_contains($prodiName, 'mesin')) {
                                                            $bgColor = 'bg-amber-600 text-white border-amber-700'; // Kuning/oranye
                                                        } elseif (str_contains($prodiName, 'elektro')) {
                                                            $bgColor = 'bg-rose-800 text-white border-rose-900'; // Merah
                                                        }
                                                    @endphp
                                                    <div class="flex-1 min-h-[4rem] p-2.5 rounded-lg border {{ $bgColor }} shadow-xs text-[11px] leading-tight relative group jadwal-card cursor-pointer flex flex-col" onmousedown="startDragSelect(event, {{ $m->id }})" onmouseenter="enterDragSelect(event, {{ $m->id }})">
                                                        <div class="font-extrabold line-clamp-2">{{ $m->mata_kuliah }}</div>
                                                        <div class="text-[10px] text-teal-200 mt-1.5 font-semibold">
                                                            Kelas {{ $m->kelas ?: 'A' }} @if($m->program_kuliah)• {{ $m->program_kuliah }}@endif @if($m->semester)• Sem {{ $m->semester }}@endif
                                                        </div>
                                                        <div class="text-[10px] text-slate-200 mt-0.5 font-medium flex items-center gap-1">
                                                            <i class="fa-solid fa-user-tie text-[9px]"></i> {{ $m->dosen->nama ?? '-' }}
                                                        </div>
                                                        @if($m->dosenPengampu && $m->dosen_pengampu_id != $m->dosen_id)
                                                            <div class="text-[9.5px] text-amber-200 mt-0.5 font-medium flex items-center gap-1 truncate" title="Dosen Instruktur/Pengampu: {{ $m->dosenPengampu->nama }}">
                                                                <i class="fa-solid fa-chalkboard-user text-[9px]"></i> Pengampu: {{ $m->dosenPengampu->nama }}
                                                            </div>
                                                        @endif
                                                        <div class="text-[9px] font-mono opacity-80 mt-auto pt-2">
                                                            {{ substr($m->jam_mulai,0,5) }} - {{ substr($m->jam_selesai,0,5) }}
                                                        </div>

                                                        <!-- Action buttons on hover -->
                                                        <div class="absolute right-1.5 top-1.5 flex items-center gap-1 z-20 opacity-0 group-hover:opacity-100 transition-opacity" id="jadwal_actions_{{ $m->id }}">
                                                            <input type="checkbox" value="{{ $m->id }}" class="jadwal-checkbox w-4 h-4 rounded border-white/40 bg-white/20 text-rose-500 focus:ring-rose-500 focus:ring-1 cursor-pointer shadow-sm" onchange="toggleBulkDeleteButton(this, {{ $m->id }})" title="Pilih untuk hapus massal">
                                                            <button type="button" onclick="openEditModal({{ json_encode($m) }})" class="w-6 h-6 rounded bg-white/30 hover:bg-white/50 text-white flex items-center justify-center text-[10px] shadow-sm cursor-pointer" title="Edit">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <button type="button" onclick="confirmDeleteJadwal({{ $m->id }}, {{ json_encode($m->mata_kuliah) }})" class="w-6 h-6 rounded bg-rose-600/90 hover:bg-rose-700 text-white flex items-center justify-center text-[10px] shadow-sm cursor-pointer" title="Hapus">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>
                                            @else
                                                <button onclick="openAddModalWith('{{ $hari }}', '{{ substr($slotStartClean, 0, 5) }}', '{{ substr($slotEndClean, 0, 5) }}')" class="w-full h-8 rounded border border-dashed border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-slate-300 hover:text-teal-600 flex items-center justify-center text-[10px] transition group" title="Tambah slot di sini">
                                                    <i class="fa-solid fa-plus opacity-0 group-hover:opacity-100 transition"></i>
                                                </button>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Legend (Warna Prodi) -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-2 text-slate-500 font-bold">
                        <i class="fa-solid fa-palette"></i> Keterangan Warna Prodi:
                    </div>
                    <div class="flex flex-wrap items-center gap-4 text-[11px] font-semibold">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-[#1b325f]"></span> Sistem Informasi (Biru Dongker)
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-emerald-800"></span> Teknik Sipil (Hijau)
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-amber-600"></span> Teknik Mesin (Kuning/Oranye)
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-rose-800"></span> Teknik Elektro (Merah)
                        </span>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <!-- Modal Tambah / Edit Jadwal Master -->
    <div id="modal-jadwal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden text-xs transition-all duration-200" style="background-color: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl w-full max-w-xl max-h-[92vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden">
            <!-- Modal Header -->
            <div class="px-6 py-4 flex justify-between items-center border-b border-slate-800 shrink-0" style="background-color: #0f172a !important; color: #ffffff !important;">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm border" style="background-color: rgba(13, 148, 136, 0.25); color: #2dd4bf; border-color: rgba(13, 148, 136, 0.4);">
                        <i class="fa-solid fa-calendar-plus"></i>
                    </div>
                    <div>
                        <h4 id="modal-jadwal-title" class="font-bold text-sm leading-tight text-white" style="color: #ffffff !important;">Tambah Slot Jadwal Penggunaan Lab</h4>
                        <p class="text-[10px] mt-0.5 text-slate-300" style="color: #94a3b8 !important;">Atur alokasi ruang lab, mata kuliah, dosen, dan kelas</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-lg flex items-center justify-center transition cursor-pointer hover:bg-slate-800" style="color: #94a3b8;">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="form-jadwal" action="{{ route('admin.jadwal-lab.store') }}" method="POST" class="p-6 space-y-4 overflow-y-auto flex-1 custom-scrollbar">
                @csrf
                <input type="hidden" id="method-field" name="_method" value="POST">
                <input type="hidden" name="tahun_akademik" value="{{ $tahunAkademik }}">

                <!-- Row 1: Lab & Hari -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 relative" style="z-index: 50;">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-door-open text-teal-600 text-[11px]"></i>
                            <span>Ruang Laboratorium <span class="text-rose-500">*</span></span>
                        </label>
                        <div class="relative">
                            <select name="lab_id" id="form_lab_id" required class="w-full p-2.5 pl-3 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition appearance-none cursor-pointer">
                                @foreach($labs as $l)
                                    <option value="{{ $l->id }}" {{ $selectedLabId == $l->id ? 'selected' : '' }}>{{ strtoupper($l->nama_lab) }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-day text-teal-600 text-[11px]"></i>
                            <span>Hari Praktikum <span class="text-rose-500">*</span></span>
                        </label>
                        <div class="relative">
                            <select name="hari" id="form_hari" required class="w-full p-2.5 pl-3 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition appearance-none cursor-pointer">
                                @foreach($hariList as $h)
                                    <option value="{{ $h }}">{{ $h }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Program Studi (Pilih Dulu) & Semester -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 relative" style="z-index: 40;">
                    <!-- Program Studi Combobox -->
                    <div class="relative" id="prodi_combobox_wrapper">
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-building-columns text-teal-600 text-[11px]"></i>
                                <span>Program Studi <span class="text-rose-500">*</span></span>
                            </span>
                            <span class="text-[10px] text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded font-medium border border-teal-100">Pilih Terlebih Dahulu</span>
                        </label>
                        <input type="hidden" name="id_prodi" id="form_id_prodi" value="">
                        <div class="relative flex items-center">
                            <input type="text" 
                                   id="form_prodi_name" 
                                   autocomplete="off" 
                                   placeholder="Pilih prodi untuk memfilter matkul..." 
                                   onclick="openProdiDropdown()" 
                                   onfocus="openProdiDropdown()" 
                                   oninput="handleProdiInput(this.value)" 
                                   class="w-full p-2.5 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition cursor-pointer">
                            <button type="button" 
                                    onclick="toggleProdiDropdown(event)" 
                                    tabindex="-1" 
                                    class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                                <i id="prodi_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                        </div>

                        <!-- Dropdown Menu for Program Studi -->
                        <div id="prodi_dropdown_menu" 
                             class="hidden absolute z-50 left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-2xl p-2 max-h-56 overflow-y-auto custom-scrollbar flex flex-col space-y-1.5" 
                             style="background-color: #ffffff !important;">
                            
                            <!-- Search filter input within dropdown -->
                            <div class="relative shrink-0">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" 
                                       id="prodi_search_input" 
                                       oninput="filterProdiList(this.value)" 
                                       placeholder="Cari nama prodi atau fakultas..." 
                                       autocomplete="off" 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                            </div>

                            <!-- Option Semua / Umum -->
                            <div class="prodi-item-option px-2.5 py-1.5 text-xs text-slate-600 rounded-lg hover:bg-slate-100 cursor-pointer transition flex items-center justify-between" 
                                 data-id="" 
                                 data-name="-- Semua Program Studi --" 
                                 data-search="semua umum all" 
                                 onclick="selectProdiItem('', '-- Semua Program Studi --')">
                                <span class="font-medium italic text-slate-500">-- Semua Program Studi --</span>
                                <span class="text-[10px] text-slate-400">Tampilkan Semua</span>
                            </div>

                            @php
                                $groupedProdis = $prodis->groupBy(function($item) {
                                    return $item->fakultas->nama_fakultas ?? 'Fakultas Lain / Umum';
                                });
                            @endphp
                            @foreach($groupedProdis as $fakultasName => $items)
                                <div class="prodi-group-header px-2 pt-2 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 border-t border-slate-100 mt-1" 
                                     data-fakultas="{{ strtolower($fakultasName) }}">
                                    <i class="fa-solid fa-building-columns text-teal-600 text-[10px]"></i>
                                    <span>{{ $fakultasName }}</span>
                                </div>
                                @foreach($items as $p)
                                    <div class="prodi-item-option px-2.5 py-1.5 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                         data-id="{{ $p->id }}" 
                                         data-name="{{ $p->nama_prodi }}" 
                                         data-search="{{ strtolower($p->nama_prodi . ' ' . $fakultasName) }}" 
                                         onclick="selectProdiItem('{{ $p->id }}', '{{ addslashes($p->nama_prodi) }}')">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <i class="fa-solid fa-check opacity-0 group-hover:opacity-100 text-teal-600 text-[10px] shrink-0 transition-opacity"></i>
                                            <span class="font-semibold truncate">{{ $p->nama_prodi }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                            <div id="prodi_no_results" class="hidden px-3 py-2 text-xs text-slate-400 italic text-center">
                                Program studi tidak ditemukan.
                            </div>
                        </div>
                    </div>

                    <!-- Semester -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-layer-group text-teal-600 text-[11px]"></i>
                            <span>Semester</span>
                        </label>
                        <div class="relative">
                            <select name="semester" id="form_semester" class="w-full p-2.5 pl-3 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition appearance-none cursor-pointer">
                                @for($i=1; $i<=8; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Mata Kuliah Combobox (Filtered by Selected Prodi) -->
                <div class="relative" id="matkul_combobox_wrapper" style="z-index: 30;">
                    <label class="block text-slate-700 font-bold mb-1.5 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-book-bookmark text-teal-600 text-[11px]"></i>
                            <span>Mata Kuliah <span class="text-rose-500">*</span></span>
                        </span>
                        <div class="flex items-center gap-2">
                            <span id="matkul_prodi_badge" class="hidden text-[10px] bg-teal-50 text-teal-800 border border-teal-200 px-2 py-0.5 rounded-full font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-filter text-[9px] text-teal-600"></i> Filter Prodi: <b id="matkul_prodi_badge_text"></b>
                            </span>
                            <span class="text-[10px] text-slate-400 font-normal">Pilih opsi atau ketik manual</span>
                        </div>
                    </label>
                    
                    <div class="relative flex items-center">
                        <input type="text" 
                               name="mata_kuliah" 
                               id="form_mata_kuliah" 
                               required 
                               autocomplete="off" 
                               placeholder="Cari atau ketik nama mata kuliah..." 
                               onclick="openMatkulDropdown()" 
                               onfocus="openMatkulDropdown()" 
                               oninput="handleMatkulInput(this.value)" 
                               class="w-full p-2.5 pr-9 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition-all">
                        <button type="button" 
                                onclick="toggleMatkulDropdown(event)" 
                                tabindex="-1" 
                                class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                            <i id="matkul_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                    </div>

                    <!-- Dropdown Menu Box for Mata Kuliah -->
                    <div id="matkul_dropdown_menu" 
                         class="hidden absolute z-50 left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-2xl p-2.5 max-h-56 flex flex-col space-y-2" 
                         style="background-color: #ffffff !important;">
                        
                        <!-- Search Bar within Dropdown -->
                        <div class="relative shrink-0">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" 
                                   id="matkul_search_input" 
                                   oninput="filterMatkulSearch(this.value)" 
                                   placeholder="Filter mata kuliah..." 
                                   autocomplete="off" 
                                   class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                        </div>

                        <!-- Custom Direct Input Option -->
                        <div class="border-b border-slate-100 pb-1 shrink-0">
                            <button type="button" 
                                    onclick="selectCustomMatkulMode()" 
                                    class="w-full text-left px-2.5 py-1.5 text-xs font-semibold text-teal-700 hover:bg-teal-50 rounded-lg flex items-center justify-between transition-colors cursor-pointer">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-pen-to-square text-teal-600 text-xs"></i>
                                    <span>Gunakan teks yang sedang diketik</span>
                                </span>
                                <span class="text-[10px] bg-teal-100 text-teal-800 px-1.5 py-0.5 rounded font-bold">Manual</span>
                            </button>
                        </div>

                        <!-- Options List -->
                        <div id="matkul_options_container" class="overflow-y-auto flex-1 space-y-0.5 max-h-40 pr-1 custom-scrollbar">
                            @if(isset($mataKuliahs) && count($mataKuliahs) > 0)
                                @foreach($mataKuliahs as $mk)
                                    <div class="matkul-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition-colors flex items-center justify-between group" 
                                         data-name="{{ $mk->nama_mk }}" 
                                         data-code="{{ $mk->kode_mk ?? '' }}" 
                                         data-prodi="{{ $mk->id_prodi ?? '' }}" 
                                         data-prodi-name="{{ $mk->prodi->nama_prodi ?? '' }}" 
                                         onclick="selectMatkulItem('{{ addslashes($mk->nama_mk) }}', '{{ $mk->id_prodi ?? '' }}')">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <i class="fa-solid fa-graduation-cap text-slate-300 group-hover:text-teal-600 text-xs shrink-0"></i>
                                            <span class="font-semibold truncate">{{ $mk->nama_mk }}</span>
                                            @if($mk->prodi)
                                                <span class="text-[9px] text-slate-400 bg-slate-100 px-1.5 py-0.2 rounded group-hover:bg-teal-100 group-hover:text-teal-700 font-medium shrink-0">{{ $mk->prodi->nama_prodi }}</span>
                                            @endif
                                        </div>
                                        @if($mk->kode_mk)
                                            <span class="text-[10px] text-slate-400 bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-800 px-1.5 py-0.5 rounded font-mono ml-2 shrink-0">{{ $mk->kode_mk }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="px-3 py-3 text-xs text-slate-400 italic text-center">Belum ada data mata kuliah. Silakan ketik manual.</div>
                            @endif
                            <div id="matkul_no_results" class="hidden px-3 py-3 text-xs text-slate-400 italic text-center">
                                Mata kuliah tidak ditemukan untuk prodi ini. Anda dapat langsung mengetikkan namanya.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Dosen Pengampu & Dosen Pengajar Comboboxes -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 relative" style="z-index: 20;">
                    <!-- Dosen Pengampu / Instruktur (Koordinator MK) -->
                    <div class="relative" id="dosen_pengampu_combobox_wrapper">
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-chalkboard-user text-teal-600 text-[11px]"></i>
                                <span>Dosen Instruktur / Pengampu</span>
                            </span>
                            <span class="text-[10px] text-slate-400 font-normal">Penanggung Jawab MK</span>
                        </label>
                        <input type="hidden" name="dosen_pengampu_id" id="form_dosen_pengampu_id" value="">
                        <div class="relative flex items-center">
                            <input type="text" 
                                   id="form_dosen_pengampu_name" 
                                   autocomplete="off" 
                                   placeholder="Pilih dosen pengampu MK (opsional)..." 
                                   onclick="openDosenPengampuDropdown()" 
                                   onfocus="openDosenPengampuDropdown()" 
                                   oninput="handleDosenPengampuInput(this.value)" 
                                   class="w-full p-2.5 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition cursor-pointer">
                            <button type="button" 
                                    onclick="toggleDosenPengampuDropdown(event)" 
                                    tabindex="-1" 
                                    class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                                <i id="dosen_pengampu_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                        </div>

                        <!-- Dropdown Menu for Dosen Pengampu -->
                        <div id="dosen_pengampu_dropdown_menu" 
                             class="hidden absolute z-50 left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-2xl p-2.5 max-h-56 flex flex-col space-y-1.5" 
                             style="background-color: #ffffff !important;">
                            
                            <!-- Search Bar within Dropdown -->
                            <div class="relative shrink-0">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" 
                                       id="dosen_pengampu_search_input" 
                                       oninput="filterDosenPengampuSearch(this.value)" 
                                       placeholder="Cari nama dosen / NIDN..." 
                                       autocomplete="off" 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                            </div>

                            <!-- Option Sama Dengan Pengajar -->
                            <div class="dosen-pengampu-item-option px-2.5 py-1.5 text-xs text-slate-600 rounded-lg hover:bg-slate-100 cursor-pointer transition flex items-center justify-between" 
                                 data-id="" 
                                 data-name="" 
                                 onclick="selectDosenPengampuItem('', '')">
                                <span class="font-medium italic text-slate-500">-- Sama Dengan Dosen Pengajar --</span>
                                <span class="text-[10px] text-slate-400">Default</span>
                            </div>

                            <div id="dosen_pengampu_options_container" class="space-y-0.5 overflow-y-auto flex-1 max-h-40 custom-scrollbar pr-1">
                                @foreach($dosens as $d)
                                    <div class="dosen-pengampu-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                         data-id="{{ $d->id }}" 
                                         data-name="{{ $d->nama }}" 
                                         data-prodi="{{ $d->id_prodi ?? '' }}" 
                                         onclick="selectDosenPengampuItem('{{ $d->id }}', '{{ addslashes($d->nama) }}')">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <i class="fa-solid fa-chalkboard-user text-slate-300 group-hover:text-teal-600 text-xs shrink-0"></i>
                                            <span class="font-semibold truncate">{{ $d->nama }}</span>
                                        </div>
                                        @if($d->nidn)
                                            <span class="text-[10px] text-slate-400 bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-800 px-1.5 py-0.5 rounded font-mono shrink-0">NIDN: {{ $d->nidn }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div id="dosen_pengampu_no_results" class="hidden px-3 py-2 text-xs text-slate-400 italic text-center">
                                Dosen tidak ditemukan.
                            </div>
                        </div>
                    </div>

                    <!-- Dosen Pengajar Combobox -->
                    <div class="relative" id="dosen_combobox_wrapper">
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-user-tie text-teal-600 text-[11px]"></i>
                                <span>Dosen Pengajar / Asisten <span class="text-rose-500">*</span></span>
                            </span>
                            <div class="flex items-center gap-2">
                                <span id="dosen_prodi_badge" class="hidden text-[10px] bg-teal-50 text-teal-800 border border-teal-200 px-2 py-0.5 rounded-full font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-filter text-[9px] text-teal-600"></i> <b id="dosen_prodi_badge_text"></b>
                                </span>
                            </div>
                        </label>
                        <input type="hidden" name="dosen_id" id="form_dosen_id" required value="">
                        <div class="relative flex items-center">
                            <input type="text" 
                                   id="form_dosen_name" 
                                   required 
                                   autocomplete="off" 
                                   placeholder="Pilih dosen pengajar..." 
                                   onclick="openDosenDropdown()" 
                                   onfocus="openDosenDropdown()" 
                                   oninput="handleDosenInput(this.value)" 
                                   class="w-full p-2.5 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition cursor-pointer">
                            <button type="button" 
                                    onclick="toggleDosenDropdown(event)" 
                                    tabindex="-1" 
                                    class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                                <i id="dosen_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                        </div>

                        <!-- Dropdown Menu for Dosen Pengajar -->
                        <div id="dosen_dropdown_menu" 
                             class="hidden absolute z-50 left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-2xl p-2.5 max-h-56 flex flex-col space-y-1.5" 
                             style="background-color: #ffffff !important;">
                            
                            <!-- Search Bar within Dropdown -->
                            <div class="relative shrink-0">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" 
                                       id="dosen_search_input" 
                                       oninput="filterDosenSearch(this.value)" 
                                       placeholder="Cari nama dosen / NIDN..." 
                                       autocomplete="off" 
                                       class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                            </div>

                            <div id="dosen_options_container" class="space-y-0.5 overflow-y-auto flex-1 max-h-40 custom-scrollbar pr-1">
                                @foreach($dosens as $d)
                                    <div class="dosen-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                         data-id="{{ $d->id }}" 
                                         data-name="{{ $d->nama }}" 
                                         data-prodi="{{ $d->id_prodi ?? '' }}" 
                                         data-prodi-name="{{ $d->prodi->nama_prodi ?? '' }}" 
                                         onclick="selectDosenItem('{{ $d->id }}', '{{ addslashes($d->nama) }}', '{{ $d->id_prodi ?? '' }}')">
                                        <div class="flex items-center gap-2 overflow-hidden">
                                            <i class="fa-solid fa-user-check text-slate-300 group-hover:text-teal-600 text-xs shrink-0"></i>
                                            <span class="font-semibold truncate">{{ $d->nama }}</span>
                                            @if($d->prodi)
                                                <span class="text-[9px] text-slate-400 bg-slate-100 px-1.5 py-0.2 rounded group-hover:bg-teal-100 group-hover:text-teal-700 font-medium shrink-0">{{ $d->prodi->nama_prodi }}</span>
                                            @endif
                                        </div>
                                        @if($d->nidn)
                                            <span class="text-[10px] text-slate-400 bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-800 px-1.5 py-0.5 rounded font-mono shrink-0">NIDN: {{ $d->nidn }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div id="dosen_no_results" class="hidden px-3 py-2 text-xs text-slate-400 italic text-center">
                                Dosen tidak ditemukan untuk prodi ini.
                            </div>
                            <!-- Toggle view all dosens button -->
                            <div class="border-t border-slate-100 pt-1 shrink-0 text-center">
                                <button type="button" 
                                        id="dosen_toggle_all_btn" 
                                        onclick="toggleShowAllDosens(event)" 
                                        class="hidden text-[10px] text-teal-700 hover:text-teal-900 font-bold px-2 py-1 rounded hover:bg-teal-50 transition cursor-pointer">
                                    Lihat Dosen Semua Prodi →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 5: Kelas Combobox & Program Kuliah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 relative" style="z-index: 10;">
                    <!-- Kelas Combobox (Database Aligned: A, B, C) -->
                    <div class="relative" id="kelas_combobox_wrapper">
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-users text-teal-600 text-[11px]"></i>
                            <span>Kelas <span class="text-rose-500">*</span></span>
                        </label>
                        <div class="relative flex items-center">
                            <input type="text" 
                                   name="kelas" 
                                   id="form_kelas" 
                                   value="A" 
                                   placeholder="Contoh: A" 
                                   autocomplete="off" 
                                   onclick="openKelasDropdown()" 
                                   onfocus="openKelasDropdown()" 
                                   oninput="handleKelasInput(this.value)" 
                                   class="w-full p-2.5 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition">
                            <button type="button" 
                                    onclick="toggleKelasDropdown(event)" 
                                    tabindex="-1" 
                                    class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                                <i id="kelas_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                        </div>

                        <!-- Dropdown Menu for Kelas (Pure Database Classes: A, B, C & Combinations) -->
                        <div id="kelas_dropdown_menu" 
                             class="hidden absolute z-50 left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-2xl p-2 max-h-56 overflow-y-auto custom-scrollbar flex flex-col space-y-1" 
                             style="background-color: #ffffff !important;">
                            <div class="px-2 py-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 bg-slate-50 rounded">
                                <i class="fa-solid fa-graduation-cap text-teal-600 text-[10px]"></i> Kelas Tunggal
                            </div>
                            @if(isset($kelas) && count($kelas) > 0)
                                @foreach($kelas as $k)
                                    <div class="kelas-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                         data-name="{{ $k->nama_kelas }}" 
                                         onclick="selectKelasItem('{{ $k->nama_kelas }}')">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-md bg-teal-100/80 text-teal-800 flex items-center justify-center font-bold text-xs group-hover:bg-teal-700 group-hover:text-white transition">
                                                {{ $k->nama_kelas }}
                                            </span>
                                            <span class="font-bold text-slate-800">Kelas {{ $k->nama_kelas }}</span>
                                        </div>
                                        <span class="text-[10px] text-slate-400 group-hover:text-teal-700 font-medium">Pilih</span>
                                    </div>
                                @endforeach

                                @if(count($kelas) >= 2)
                                    <div class="px-2 py-1 mt-1 text-[10px] font-bold text-purple-800 uppercase tracking-wider flex items-center gap-1 bg-purple-50 rounded">
                                        <i class="fa-solid fa-layer-group text-purple-600 text-[10px]"></i> Kelas Gabungan (Multi-Class)
                                    </div>
                                    @php
                                        $kNames = collect($kelas)->pluck('nama_kelas')->toArray();
                                    @endphp
                                    @for($i = 0; $i < count($kNames); $i++)
                                        @for($j = $i + 1; $j < count($kNames); $j++)
                                            @php $comboVal = $kNames[$i] . ' & ' . $kNames[$j]; @endphp
                                            <div class="kelas-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-purple-50 hover:text-purple-950 cursor-pointer transition flex items-center justify-between group" 
                                                 data-name="{{ $comboVal }}" 
                                                 onclick="selectKelasItem('{{ $comboVal }}')">
                                                <div class="flex items-center gap-2">
                                                    <span class="px-2 py-0.5 rounded-md bg-purple-100 text-purple-900 font-bold text-[11px] group-hover:bg-purple-700 group-hover:text-white transition">
                                                        {{ $comboVal }}
                                                    </span>
                                                    <span class="font-bold text-slate-800">Gabungan: Kelas {{ $comboVal }}</span>
                                                </div>
                                                <span class="text-[10px] text-purple-600 font-medium">Pilih</span>
                                            </div>
                                        @endfor
                                    @endfor
                                    @if(count($kNames) > 2)
                                        @php $allComboVal = implode(', ', $kNames); @endphp
                                        <div class="kelas-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-purple-50 hover:text-purple-950 cursor-pointer transition flex items-center justify-between group" 
                                             data-name="{{ $allComboVal }}" 
                                             onclick="selectKelasItem('{{ $allComboVal }}')">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-md bg-purple-100 text-purple-900 font-bold text-[11px] group-hover:bg-purple-700 group-hover:text-white transition">
                                                    Semua
                                                </span>
                                                <span class="font-bold text-slate-800">Gabungan: Semua ({{ $allComboVal }})</span>
                                            </div>
                                            <span class="text-[10px] text-purple-600 font-medium">Pilih</span>
                                        </div>
                                    @endif
                                @endif
                            @else
                                <div class="kelas-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                     data-name="A" 
                                     onclick="selectKelasItem('A')">
                                    <span class="font-bold">Kelas A</span>
                                    <span class="text-[10px] text-slate-400">Pilih</span>
                                </div>
                                <div class="kelas-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                     data-name="B" 
                                     onclick="selectKelasItem('B')">
                                    <span class="font-bold">Kelas B</span>
                                    <span class="text-[10px] text-slate-400">Pilih</span>
                                </div>
                                <div class="kelas-item-option px-2.5 py-2 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                     data-name="C" 
                                     onclick="selectKelasItem('C')">
                                    <span class="font-bold">Kelas C</span>
                                    <span class="text-[10px] text-slate-400">Pilih</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Program Kuliah -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-graduation-cap text-teal-600 text-[11px]"></i>
                            <span>Program Kuliah</span>
                        </label>
                        <div class="relative">
                            <select name="program_kuliah" id="form_program_kuliah" class="w-full p-2.5 pl-3 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition appearance-none cursor-pointer">
                                <option value="Reguler">Reguler</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Row 6: Waktu Jam Mulai & Selesai -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 relative" style="z-index: 5;">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-teal-600 text-[11px]"></i>
                            <span>Jam Mulai <span class="text-rose-500">*</span></span>
                        </label>
                        <input type="time" name="jam_mulai" id="form_jam_mulai" required value="08:00" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-mono font-bold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock-rotate-left text-teal-600 text-[11px]"></i>
                            <span>Jam Selesai <span class="text-rose-500">*</span></span>
                        </label>
                        <input type="time" name="jam_selesai" id="form_jam_selesai" required value="10:30" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 font-mono font-bold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/20 focus:border-teal-700 outline-none transition">
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="pt-4 mt-2 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 font-bold rounded-xl text-xs transition cursor-pointer hover:bg-slate-200" style="background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #cbd5e1 !important;">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 font-bold rounded-xl text-xs transition shadow-md hover:opacity-95 flex items-center gap-2 cursor-pointer" style="background-color: #0f766e !important; color: #ffffff !important;">
                        <i class="fa-solid fa-floppy-disk" style="color: #ffffff !important;"></i>
                        <span style="color: #ffffff !important;">Simpan Jadwal</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import Excel Matriks Jadwal Lab -->
    <div id="modal-import-jadwal-lab" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-100 animate-in fade-in zoom-in-95 duration-150">
            <!-- Header -->
            <div class="bg-slate-900 text-white px-6 py-4.5 flex items-center justify-between border-b border-slate-800 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-500/20 border border-teal-500/30 flex items-center justify-center text-teal-400 shrink-0">
                        <i class="fa-solid fa-file-excel text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-white tracking-tight">Impor Matriks Jadwal Lab</h3>
                        <p class="text-xs text-slate-300 mt-0.5">Format matriks mingguan (.xlsx / .xls)</p>
                    </div>
                </div>
                <button type="button" onclick="closeImportModal()" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition cursor-pointer border border-slate-700 shadow-sm" title="Tutup Modal">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Form -->
            <form id="form-import-jadwal" action="{{ route('admin.jadwal-lab.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs" onsubmit="handleImportSubmit(event)">
                @csrf

                <!-- Lab Destination -->
                <div>
                    <label class="block text-slate-700 font-bold mb-1.5">
                        Laboratorium Target <span class="text-rose-500">*</span>
                    </label>
                    <select name="lab_id" id="import_lab_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        @foreach($labs as $l)
                            <option value="{{ $l->id }}" {{ $selectedLabId == $l->id ? 'selected' : '' }}>
                                {{ strtoupper($l->nama_lab) }} ({{ $l->lokasi }}) {{ $l->fakultas ? '— ' . $l->fakultas->nama_fakultas : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun Akademik -->
                <div>
                    <label class="block text-slate-700 font-bold mb-1.5">
                        Tahun Akademik Target <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="tahun_akademik" id="import_tahun_akademik" value="{{ $tahunAkademik }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none" placeholder="Contoh: 2026/2027 Ganjil">
                </div>

                <!-- Mode Impor -->
                <div>
                    <label class="block text-slate-700 font-bold mb-2">Metode Impor Jadwal:</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <label class="relative flex items-start gap-2.5 p-3 rounded-xl border border-teal-300 bg-teal-50/50 cursor-pointer hover:bg-teal-50 transition">
                            <input type="radio" name="mode" value="replace" checked class="mt-0.5 text-teal-700 focus:ring-teal-700">
                            <div>
                                <span class="font-bold text-slate-800 block text-xs">Ganti Seluruhnya</span>
                                <span class="text-[11px] text-slate-500 leading-tight block mt-0.5">Bersihkan jadwal lama lab ini, lalu isi dengan data baru.</span>
                            </div>
                        </label>
                        <label class="relative flex items-start gap-2.5 p-3 rounded-xl border border-slate-200 bg-slate-50/50 cursor-pointer hover:bg-slate-50 transition">
                            <input type="radio" name="mode" value="append" class="mt-0.5 text-teal-700 focus:ring-teal-700">
                            <div>
                                <span class="font-bold text-slate-800 block text-xs">Tambahkan (Append)</span>
                                <span class="text-[11px] text-slate-500 leading-tight block mt-0.5">Sisipkan jadwal baru jika jam tidak bentrok.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- File Dropzone -->
                <div>
                    <label class="block text-slate-700 font-bold mb-1.5">
                        Pilih / Tarik Berkas Excel (.xlsx, .xls) <span class="text-rose-500">*</span>
                    </label>
                    <div id="dropzone_import" class="border-2 border-dashed border-slate-300 hover:border-teal-600 rounded-2xl p-5 text-center bg-slate-50/60 hover:bg-teal-50/40 transition cursor-pointer group" onclick="document.getElementById('excel_import_file').click()">
                        <div id="import_icon_container" class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 group-hover:scale-110 group-hover:bg-teal-100 flex items-center justify-center mx-auto mb-2.5 transition transform shadow-xs">
                            <i id="import_file_icon" class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-700 group-hover:text-teal-800 transition" id="import_file_label">Klik atau Tarik (Drag & Drop) file Excel ke sini</p>
                        <p class="text-[11px] text-slate-400 mt-1" id="import_file_sublabel">Format .xlsx atau .xls (Maksimal 10MB)</p>
                        <input type="file" name="file" id="excel_import_file" accept=".xlsx,.xls" required class="hidden" onchange="handleImportFileSelect(this)">
                    </div>
                </div>

                <!-- Help & Download Template Box -->
                <div class="bg-blue-50/80 border border-blue-200/80 rounded-xl p-3 flex items-start gap-2.5 text-[11px] text-blue-900 leading-relaxed">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5 text-sm shrink-0"></i>
                    <div>
                        <span>File harus berformat matriks mingguan (Senin s/d Sabtu, Jam Mulai - Selesai per baris, dan warna background sesuai Prodi).</span>
                        <div class="mt-1.5">
                            <a href="{{ route('admin.jadwal-lab.export', ['lab_id' => $selectedLabId, 'tahun_akademik' => $tahunAkademik]) }}" class="inline-flex items-center gap-1.5 font-bold text-blue-700 hover:text-blue-900 hover:underline">
                                <i class="fa-solid fa-download"></i> Unduh Contoh Format Excel Matriks
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeImportModal()" class="px-5 py-2.5 font-bold rounded-xl text-xs transition cursor-pointer hover:bg-slate-200" style="background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #cbd5e1 !important;">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit-import" class="px-6 py-2.5 font-bold rounded-xl text-xs transition shadow-md hover:opacity-95 flex items-center gap-2 cursor-pointer bg-teal-700 hover:bg-teal-800 text-white">
                        <i class="fa-solid fa-file-import"></i>
                        <span>Mulai Impor Data</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal-jadwal');
        const form = document.getElementById('form-jadwal');
        const title = document.getElementById('modal-jadwal-title');
        const methodField = document.getElementById('method-field');
        const modalImport = document.getElementById('modal-import-jadwal-lab');

        function resetImportDropzone() {
            const dropzone = document.getElementById('dropzone_import');
            const iconContainer = document.getElementById('import_icon_container');
            const icon = document.getElementById('import_file_icon');
            const label = document.getElementById('import_file_label');
            const sublabel = document.getElementById('import_file_sublabel');
            const fileInput = document.getElementById('excel_import_file');

            if (fileInput) fileInput.value = "";
            if (dropzone) {
                dropzone.className = "border-2 border-dashed border-slate-300 hover:border-teal-600 rounded-2xl p-5 text-center bg-slate-50/60 hover:bg-teal-50/40 transition cursor-pointer group";
            }
            if (iconContainer) {
                iconContainer.className = "w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 group-hover:scale-110 group-hover:bg-teal-100 flex items-center justify-center mx-auto mb-2.5 transition transform shadow-xs";
            }
            if (icon) {
                icon.className = "fa-solid fa-cloud-arrow-up text-2xl";
            }
            if (label) {
                label.textContent = "Klik atau Tarik (Drag & Drop) file Excel ke sini";
                label.className = "text-xs font-bold text-slate-700 group-hover:text-teal-800 transition";
            }
            if (sublabel) {
                sublabel.textContent = "Format .xlsx atau .xls (Maksimal 10MB)";
                sublabel.className = "text-[11px] text-slate-400 mt-1";
            }
        }

        function openImportModal() {
            resetImportDropzone();
            if (modalImport) {
                modalImport.classList.remove('hidden');
            }
        }

        function closeImportModal() {
            resetImportDropzone();
            if (modalImport) {
                modalImport.classList.add('hidden');
            }
        }

        function handleImportFileSelect(input) {
            const dropzone = document.getElementById('dropzone_import');
            const iconContainer = document.getElementById('import_icon_container');
            const icon = document.getElementById('import_file_icon');
            const label = document.getElementById('import_file_label');
            const sublabel = document.getElementById('import_file_sublabel');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Active / Success Dropzone Styling
                if (dropzone) {
                    dropzone.className = "border-2 border-solid border-emerald-500 rounded-2xl p-5 text-center bg-emerald-50/90 transition cursor-pointer shadow-sm";
                }
                if (iconContainer) {
                    iconContainer.className = "w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-2.5 transition transform shadow-xs";
                }
                if (icon) {
                    icon.className = "fa-solid fa-file-circle-check text-2xl text-emerald-600";
                }
                if (label) {
                    label.textContent = file.name;
                    label.className = "text-xs font-extrabold text-emerald-950 truncate block max-w-full px-2";
                }
                if (sublabel) {
                    const size = (file.size / 1024).toFixed(1) + ' KB';
                    sublabel.innerHTML = `<span class="inline-flex items-center gap-1 font-bold text-emerald-800 bg-emerald-200/70 px-2.5 py-1 rounded-lg mt-1 text-[11px]"><i class="fa-solid fa-circle-check text-emerald-600"></i> ${size} • Berkas Terpasang & Siap Diimpor</span> <span class="block text-[10px] text-slate-500 mt-1">(Klik di sini jika ingin mengganti berkas)</span>`;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('dropzone_import');
            const fileInput = document.getElementById('excel_import_file');
            const label = document.getElementById('import_file_label');

            if (dropzone && fileInput) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }, false);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzone.addEventListener(eventName, function() {
                        if (!fileInput.files || !fileInput.files.length) {
                            dropzone.classList.add('border-teal-500', 'bg-teal-50', 'scale-[1.02]', 'shadow-md');
                            dropzone.classList.remove('border-slate-300', 'bg-slate-50/60');
                            if (label) label.textContent = "Lepaskan berkas Excel di sini...";
                        }
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, function() {
                        if (!fileInput.files || !fileInput.files.length) {
                            dropzone.classList.remove('border-teal-500', 'scale-[1.02]', 'shadow-md');
                            dropzone.classList.add('border-slate-300', 'bg-slate-50/60');
                            dropzone.classList.remove('bg-teal-50');
                            if (label) label.textContent = "Klik atau Tarik (Drag & Drop) file Excel ke sini";
                        }
                    }, false);
                });

                dropzone.addEventListener('drop', function(e) {
                    const dt = e.dataTransfer;
                    if (dt && dt.files && dt.files.length > 0) {
                        fileInput.files = dt.files;
                        handleImportFileSelect(fileInput);
                    }
                }, false);
            }
        });

        function handleImportSubmit(e) {
            const btn = document.getElementById('btn-submit-import');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Mengimpor Data...</span>';
            Swal.fire({
                title: 'Sedang Mengimpor Jadwal...',
                text: 'Mohon tunggu sebentar, sistem sedang membaca dan memetakan matriks jadwal excel ke database.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        // Helper: Close All Combobox Dropdowns
        function closeAllDropdowns() {
            closeMatkulDropdown();
            closeKelasDropdown();
            closeDosenDropdown();
            closeDosenPengampuDropdown();
            closeProdiDropdown();
        }

        let activeProdiFilterId = '';
        let isShowingAllDosens = false;

        // ==========================================
        // 1. PROGRAM STUDI COMBOBOX (STEP 1: ROOT FILTER)
        // ==========================================
        function openProdiDropdown() {
            closeMatkulDropdown();
            closeDosenDropdown();
            closeKelasDropdown();
            const menu = document.getElementById('prodi_dropdown_menu');
            const icon = document.getElementById('prodi_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeProdiDropdown() {
            const menu = document.getElementById('prodi_dropdown_menu');
            const icon = document.getElementById('prodi_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleProdiDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('prodi_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openProdiDropdown();
                const searchInput = document.getElementById('prodi_search_input');
                if (searchInput) searchInput.focus();
            } else {
                closeProdiDropdown();
            }
        }

        function filterProdiList(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.prodi-item-option');
            const headers = document.querySelectorAll('.prodi-group-header');
            const noResults = document.getElementById('prodi_no_results');
            let visibleCount = 0;

            items.forEach(item => {
                const searchStr = (item.getAttribute('data-search') || '').toLowerCase();
                if (searchStr.includes(q)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            headers.forEach(h => {
                h.style.display = (q === '') ? '' : 'none';
            });

            if (noResults) {
                noResults.style.display = (visibleCount === 0 && items.length > 0) ? 'block' : 'none';
            }
        }

        function selectProdiItem(id, name) {
            activeProdiFilterId = id ? String(id) : '';
            isShowingAllDosens = false;

            document.getElementById('form_id_prodi').value = activeProdiFilterId;
            document.getElementById('form_prodi_name').value = name || '';

            // Reset search inputs
            const matkulSearch = document.getElementById('matkul_search_input');
            if (matkulSearch) matkulSearch.value = '';
            const dosenSearch = document.getElementById('dosen_search_input');
            if (dosenSearch) dosenSearch.value = '';

            // Run cascading filters
            filterMatkulByProdi(activeProdiFilterId);
            filterDosenByProdi(activeProdiFilterId, false);

            // Check if existing matkul matches the new prodi
            const matkulInput = document.getElementById('form_mata_kuliah');
            if (matkulInput && matkulInput.value.trim() && activeProdiFilterId) {
                let matchFound = false;
                document.querySelectorAll('.matkul-item-option').forEach(opt => {
                    if (opt.style.display !== 'none' && opt.getAttribute('data-name').toLowerCase() === matkulInput.value.trim().toLowerCase()) {
                        matchFound = true;
                    }
                });
                if (!matchFound) {
                    matkulInput.value = '';
                }
            }

            // Check if existing dosen matches the new prodi
            const dosenIdInput = document.getElementById('form_dosen_id');
            if (dosenIdInput && dosenIdInput.value && activeProdiFilterId) {
                const currentDosenOpt = document.querySelector(`.dosen-item-option[data-id="${dosenIdInput.value}"]`);
                if (currentDosenOpt && currentDosenOpt.getAttribute('data-prodi') !== activeProdiFilterId) {
                    dosenIdInput.value = '';
                    document.getElementById('form_dosen_name').value = '';
                }
            }

            closeProdiDropdown();
        }

        function handleProdiInput(val) {
            openProdiDropdown();
            const searchInput = document.getElementById('prodi_search_input');
            if (searchInput) searchInput.value = val;
            filterProdiList(val);
        }

        // ==========================================
        // 2. MATA KULIAH COMBOBOX (STEP 2: FILTERED BY PRODI)
        // ==========================================
        function openMatkulDropdown() {
            closeKelasDropdown();
            closeDosenDropdown();
            closeProdiDropdown();
            const menu = document.getElementById('matkul_dropdown_menu');
            const icon = document.getElementById('matkul_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeMatkulDropdown() {
            const menu = document.getElementById('matkul_dropdown_menu');
            const icon = document.getElementById('matkul_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleMatkulDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('matkul_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openMatkulDropdown();
                const searchInput = document.getElementById('matkul_search_input');
                if (searchInput) searchInput.focus();
            } else {
                closeMatkulDropdown();
            }
        }

        function filterMatkulByProdi(prodiId) {
            const pid = prodiId ? String(prodiId) : '';
            const items = document.querySelectorAll('.matkul-item-option');
            const badge = document.getElementById('matkul_prodi_badge');
            const badgeText = document.getElementById('matkul_prodi_badge_text');
            const noResults = document.getElementById('matkul_no_results');
            const searchVal = (document.getElementById('matkul_search_input')?.value || '').toLowerCase().trim();

            if (badge && badgeText) {
                if (pid) {
                    const matchedProdi = document.querySelector(`.prodi-item-option[data-id="${pid}"]`);
                    badgeText.textContent = matchedProdi ? matchedProdi.getAttribute('data-name') : '';
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }

            let visibleCount = 0;
            items.forEach(item => {
                const itemProdi = item.getAttribute('data-prodi') || '';
                const name = (item.getAttribute('data-name') || '').toLowerCase();
                const code = (item.getAttribute('data-code') || '').toLowerCase();

                const matchProdi = !pid || itemProdi === pid;
                const matchSearch = !searchVal || name.includes(searchVal) || code.includes(searchVal);

                if (matchProdi && matchSearch) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (noResults) {
                if (visibleCount === 0) {
                    noResults.textContent = pid 
                        ? 'Belum ada master mata kuliah untuk prodi ini. Silakan ketik nama mata kuliah secara manual.' 
                        : 'Mata kuliah tidak ditemukan. Silakan ketik manual.';
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            }
        }

        function filterMatkulSearch(query) {
            filterMatkulByProdi(activeProdiFilterId);
        }

        function selectMatkulItem(name, prodiId) {
            const mainInput = document.getElementById('form_mata_kuliah');
            if (mainInput) mainInput.value = name;

            // Auto-align prodi if not yet selected
            if (prodiId && !activeProdiFilterId) {
                const prodiOption = document.querySelector(`.prodi-item-option[data-id="${prodiId}"]`);
                const prodiName = prodiOption ? prodiOption.getAttribute('data-name') : '';
                selectProdiItem(prodiId, prodiName);
            }

            closeMatkulDropdown();
        }

        function selectCustomMatkulMode() {
            closeMatkulDropdown();
            const mainInput = document.getElementById('form_mata_kuliah');
            if (mainInput) {
                mainInput.focus();
                mainInput.select();
            }
        }

        function handleMatkulInput(val) {
            openMatkulDropdown();
            const searchInput = document.getElementById('matkul_search_input');
            if (searchInput) {
                searchInput.value = val;
            }
            filterMatkulByProdi(activeProdiFilterId);
        }

        // ==========================================
        // 3A. DOSEN PENGAMPU COMBOBOX
        // ==========================================
        function openDosenPengampuDropdown() {
            closeMatkulDropdown();
            closeKelasDropdown();
            closeProdiDropdown();
            closeDosenDropdown();
            const menu = document.getElementById('dosen_pengampu_dropdown_menu');
            const icon = document.getElementById('dosen_pengampu_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeDosenPengampuDropdown() {
            const menu = document.getElementById('dosen_pengampu_dropdown_menu');
            const icon = document.getElementById('dosen_pengampu_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleDosenPengampuDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('dosen_pengampu_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openDosenPengampuDropdown();
                const searchInput = document.getElementById('dosen_pengampu_search_input');
                if (searchInput) searchInput.focus();
            } else {
                closeDosenPengampuDropdown();
            }
        }

        function filterDosenPengampuSearch(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.dosen-pengampu-item-option');
            const noResults = document.getElementById('dosen_pengampu_no_results');
            let count = 0;
            items.forEach(item => {
                const name = (item.getAttribute('data-name') || '').toLowerCase();
                if (!q || name.includes(q)) {
                    item.style.display = '';
                    count++;
                } else {
                    item.style.display = 'none';
                }
            });
            if (noResults) {
                noResults.style.display = count === 0 ? 'block' : 'none';
            }
        }

        function selectDosenPengampuItem(id, name) {
            document.getElementById('form_dosen_pengampu_id').value = id;
            document.getElementById('form_dosen_pengampu_name').value = name;
            closeDosenPengampuDropdown();
        }

        function handleDosenPengampuInput(val) {
            openDosenPengampuDropdown();
            const searchInput = document.getElementById('dosen_pengampu_search_input');
            if (searchInput) searchInput.value = val;
            filterDosenPengampuSearch(val);
        }

        // ==========================================
        // 3B. DOSEN PENGAJAR COMBOBOX (STEP 3: FILTERED BY PRODI)
        // ==========================================
        function openDosenDropdown() {
            closeMatkulDropdown();
            closeKelasDropdown();
            closeProdiDropdown();
            closeDosenPengampuDropdown();
            const menu = document.getElementById('dosen_dropdown_menu');
            const icon = document.getElementById('dosen_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeDosenDropdown() {
            const menu = document.getElementById('dosen_dropdown_menu');
            const icon = document.getElementById('dosen_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleDosenDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('dosen_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openDosenDropdown();
                const searchInput = document.getElementById('dosen_search_input');
                if (searchInput) searchInput.focus();
            } else {
                closeDosenDropdown();
            }
        }

        function filterDosenByProdi(prodiId, forceShowAll = false) {
            const pid = prodiId ? String(prodiId) : '';
            const items = document.querySelectorAll('.dosen-item-option');
            const badge = document.getElementById('dosen_prodi_badge');
            const badgeText = document.getElementById('dosen_prodi_badge_text');
            const noResults = document.getElementById('dosen_no_results');
            const toggleBtn = document.getElementById('dosen_toggle_all_btn');
            const searchVal = (document.getElementById('dosen_search_input')?.value || '').toLowerCase().trim();

            if (badge && badgeText) {
                if (pid && !forceShowAll) {
                    const matchedProdi = document.querySelector(`.prodi-item-option[data-id="${pid}"]`);
                    badgeText.textContent = matchedProdi ? matchedProdi.getAttribute('data-name') : '';
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }

            let count = 0;
            items.forEach(item => {
                const itemProdi = item.getAttribute('data-prodi') || '';
                const name = (item.getAttribute('data-name') || '').toLowerCase();

                const matchProdi = forceShowAll || !pid || itemProdi === pid;
                const matchSearch = !searchVal || name.includes(searchVal);

                if (matchProdi && matchSearch) {
                    item.style.display = '';
                    count++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (toggleBtn) {
                if (pid) {
                    toggleBtn.classList.remove('hidden');
                    toggleBtn.textContent = forceShowAll ? '← Tampilkan Hanya Dosen Prodi Ini' : 'Lihat Dosen Semua Prodi →';
                } else {
                    toggleBtn.classList.add('hidden');
                }
            }

            if (noResults) {
                if (count === 0) {
                    noResults.textContent = pid && !forceShowAll 
                        ? 'Belum ada dosen untuk prodi ini. Klik tombol di bawah untuk melihat semua dosen.' 
                        : 'Dosen tidak ditemukan.';
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            }
        }

        function filterDosenSearch(query) {
            filterDosenByProdi(activeProdiFilterId, isShowingAllDosens);
        }

        function toggleShowAllDosens(e) {
            if (e) e.stopPropagation();
            isShowingAllDosens = !isShowingAllDosens;
            filterDosenByProdi(activeProdiFilterId, isShowingAllDosens);
        }

        function selectDosenItem(id, name, prodiId) {
            document.getElementById('form_dosen_id').value = id;
            document.getElementById('form_dosen_name').value = name;

            // Auto-align prodi if not yet selected
            if (prodiId && !activeProdiFilterId) {
                const prodiOption = document.querySelector(`.prodi-item-option[data-id="${prodiId}"]`);
                const prodiName = prodiOption ? prodiOption.getAttribute('data-name') : '';
                selectProdiItem(prodiId, prodiName);
            }

            closeDosenDropdown();
        }

        function handleDosenInput(val) {
            openDosenDropdown();
            const searchInput = document.getElementById('dosen_search_input');
            if (searchInput) searchInput.value = val;
            filterDosenByProdi(activeProdiFilterId, isShowingAllDosens);
        }

        // ==========================================
        // 4. KELAS COMBOBOX
        // ==========================================
        function openKelasDropdown() {
            closeMatkulDropdown();
            closeDosenDropdown();
            closeProdiDropdown();
            const menu = document.getElementById('kelas_dropdown_menu');
            const icon = document.getElementById('kelas_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeKelasDropdown() {
            const menu = document.getElementById('kelas_dropdown_menu');
            const icon = document.getElementById('kelas_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleKelasDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('kelas_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openKelasDropdown();
            } else {
                closeKelasDropdown();
            }
        }

        function filterKelasList(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.kelas-item-option');
            items.forEach(item => {
                const val = (item.getAttribute('data-name') || '').toLowerCase();
                if (val.includes(q)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function selectKelasItem(val) {
            document.getElementById('form_kelas').value = val;
            closeKelasDropdown();
        }

        function handleKelasInput(val) {
            openKelasDropdown();
            filterKelasList(val);
        }

        // ==========================================
        // GLOBAL EVENT LISTENERS (OUTSIDE CLICK & ESC)
        // ==========================================
        document.addEventListener('click', function(e) {
            const prodiWrapper = document.getElementById('prodi_combobox_wrapper');
            if (prodiWrapper && !prodiWrapper.contains(e.target)) {
                closeProdiDropdown();
            }
            const matkulWrapper = document.getElementById('matkul_combobox_wrapper');
            if (matkulWrapper && !matkulWrapper.contains(e.target)) {
                closeMatkulDropdown();
            }
            const dosenPengampuWrapper = document.getElementById('dosen_pengampu_combobox_wrapper');
            if (dosenPengampuWrapper && !dosenPengampuWrapper.contains(e.target)) {
                closeDosenPengampuDropdown();
            }
            const dosenWrapper = document.getElementById('dosen_combobox_wrapper');
            if (dosenWrapper && !dosenWrapper.contains(e.target)) {
                closeDosenDropdown();
            }
            const kelasWrapper = document.getElementById('kelas_combobox_wrapper');
            if (kelasWrapper && !kelasWrapper.contains(e.target)) {
                closeKelasDropdown();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const prodiMenu = document.getElementById('prodi_dropdown_menu');
                const matkulMenu = document.getElementById('matkul_dropdown_menu');
                const dosenPengampuMenu = document.getElementById('dosen_pengampu_dropdown_menu');
                const dosenMenu = document.getElementById('dosen_dropdown_menu');
                const kelasMenu = document.getElementById('kelas_dropdown_menu');
                if (prodiMenu && !prodiMenu.classList.contains('hidden')) {
                    closeProdiDropdown();
                } else if (matkulMenu && !matkulMenu.classList.contains('hidden')) {
                    closeMatkulDropdown();
                } else if (dosenPengampuMenu && !dosenPengampuMenu.classList.contains('hidden')) {
                    closeDosenPengampuDropdown();
                } else if (dosenMenu && !dosenMenu.classList.contains('hidden')) {
                    closeDosenDropdown();
                } else if (kelasMenu && !kelasMenu.classList.contains('hidden')) {
                    closeKelasDropdown();
                } else if (modal && !modal.classList.contains('hidden')) {
                    closeModal();
                } else if (modalImport && !modalImport.classList.contains('hidden')) {
                    closeImportModal();
                }
            }
        });

        // ==========================================
        // MODAL OPEN / CLOSE CONTROLLERS
        // ==========================================
        let currentEditingJadwal = null;

        function confirmDeleteJadwal(jadwalId, matkulName) {
            Swal.fire({
                title: 'Hapus Jadwal Lab?',
                text: 'Apakah Anda yakin ingin menghapus slot jadwal untuk: ' + matkulName + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ url("admin/jadwal-lab") }}/' + jadwalId;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function toggleBulkDeleteButton(checkbox, id) {
            const actionsDiv = document.getElementById('jadwal_actions_' + id);
            if (checkbox.checked) {
                actionsDiv.classList.remove('opacity-0', 'group-hover:opacity-100');
                actionsDiv.classList.add('opacity-100');
            } else {
                actionsDiv.classList.remove('opacity-100');
                actionsDiv.classList.add('opacity-0', 'group-hover:opacity-100');
            }

            const checkedBoxes = document.querySelectorAll('.jadwal-checkbox:checked');
            const btnBulkDelete = document.getElementById('btn-bulk-delete');
            const bulkDeleteCount = document.getElementById('bulk-delete-count');
            
            if (checkedBoxes.length > 0) {
                btnBulkDelete.classList.remove('hidden');
                btnBulkDelete.classList.add('flex');
                bulkDeleteCount.textContent = checkedBoxes.length;
            } else {
                btnBulkDelete.classList.add('hidden');
                btnBulkDelete.classList.remove('flex');
            }
        }

        function confirmBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.jadwal-checkbox:checked');
            if (checkedBoxes.length === 0) return;

            const ids = Array.from(checkedBoxes).map(cb => cb.value);

            Swal.fire({
                title: 'Hapus ' + ids.length + ' Jadwal Lab?',
                text: 'Apakah Anda yakin ingin menghapus slot jadwal yang dipilih? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("admin.jadwal-lab.bulk-delete") }}';
                    form.innerHTML = '@csrf @method("DELETE")';
                    
                    ids.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // ==========================================
        // DRAG TO SELECT (BLOCK MULTIPLE)
        // ==========================================
        let isDragging = false;
        let dragSelectState = false;

        function startDragSelect(e, id) {
            // Ignore if clicking on a button
            if (e.target.tagName === 'BUTTON' || e.target.closest('button')) return;

            isDragging = true;
            const checkbox = document.querySelector(`.jadwal-checkbox[value="${id}"]`);
            if (checkbox) {
                if (e.target.tagName === 'INPUT' && e.target.type === 'checkbox') {
                    // Checkbox clicked: it will toggle itself, so we capture the FUTURE state
                    dragSelectState = !checkbox.checked; 
                } else {
                    // Card clicked: we toggle the checkbox manually
                    checkbox.checked = !checkbox.checked;
                    toggleBulkDeleteButton(checkbox, id);
                    dragSelectState = checkbox.checked;
                    // Prevent text selection while dragging
                    e.preventDefault();
                }
            }
        }

        function enterDragSelect(e, id) {
            if (!isDragging) return;
            const checkbox = document.querySelector(`.jadwal-checkbox[value="${id}"]`);
            if (checkbox && checkbox.checked !== dragSelectState) {
                checkbox.checked = dragSelectState;
                toggleBulkDeleteButton(checkbox, id);
            }
        }

        document.addEventListener('mouseup', function() {
            isDragging = false;
        });

        function openAddModal() {
            currentEditingJadwal = null;

            title.textContent = 'Tambah Slot Jadwal Penggunaan Lab';
            form.action = "{{ route('admin.jadwal-lab.store') }}";
            methodField.value = 'POST';
            form.reset();

            activeProdiFilterId = '';
            isShowingAllDosens = false;

            document.getElementById('form_id_prodi').value = '';
            document.getElementById('form_prodi_name').value = '';
            document.getElementById('form_mata_kuliah').value = '';
            document.getElementById('form_dosen_pengampu_id').value = '';
            document.getElementById('form_dosen_pengampu_name').value = '';
            document.getElementById('form_dosen_id').value = '';
            document.getElementById('form_dosen_name').value = '';
            document.getElementById('form_kelas').value = 'A';
            document.getElementById('form_semester').value = '1';
            document.getElementById('form_program_kuliah').value = 'Reguler';
            document.getElementById('form_jam_mulai').value = '08:00';
            document.getElementById('form_jam_selesai').value = '10:30';

            // Reset filters to show all
            filterMatkulByProdi('');
            filterDosenByProdi('', true);

            closeAllDropdowns();
            modal.classList.remove('hidden');
        }

        function openAddModalWith(hari, jamMulai, jamSelesai) {
            openAddModal();
            document.getElementById('form_hari').value = hari;
            document.getElementById('form_jam_mulai').value = jamMulai;
            document.getElementById('form_jam_selesai').value = jamSelesai;
        }

        function openEditModal(jadwal) {
            currentEditingJadwal = jadwal;

            title.textContent = 'Edit Slot Jadwal Penggunaan Lab';
            form.action = "{{ url('admin/jadwal-lab') }}/" + jadwal.id;
            methodField.value = 'PUT';

            document.getElementById('form_lab_id').value = jadwal.lab_id;
            document.getElementById('form_hari').value = jadwal.hari;

            // 1. Set Program Studi first!
            activeProdiFilterId = jadwal.id_prodi ? String(jadwal.id_prodi) : '';
            isShowingAllDosens = false;
            document.getElementById('form_id_prodi').value = activeProdiFilterId;

            const matchedProdi = document.querySelector(`.prodi-item-option[data-id="${activeProdiFilterId}"]`);
            if (matchedProdi) {
                document.getElementById('form_prodi_name').value = matchedProdi.getAttribute('data-name');
            } else {
                document.getElementById('form_prodi_name').value = '';
            }

            // 2. Set Semester
            document.getElementById('form_semester').value = jadwal.semester || '1';

            // 3. Apply cascading filters for matkul & dosen
            filterMatkulByProdi(activeProdiFilterId);
            filterDosenByProdi(activeProdiFilterId, false);

            // 4. Set Mata Kuliah
            document.getElementById('form_mata_kuliah').value = jadwal.mata_kuliah || '';

            // 5. Set Dosen Pengampu / Instruktur
            document.getElementById('form_dosen_pengampu_id').value = jadwal.dosen_pengampu_id || '';
            const matchedPengampu = document.querySelector(`.dosen-pengampu-item-option[data-id="${jadwal.dosen_pengampu_id}"]`);
            if (matchedPengampu) {
                document.getElementById('form_dosen_pengampu_name').value = matchedPengampu.getAttribute('data-name');
            } else if (jadwal.dosen_pengampu) {
                document.getElementById('form_dosen_pengampu_name').value = jadwal.dosen_pengampu.nama;
            } else {
                document.getElementById('form_dosen_pengampu_name').value = '';
            }

            // 6. Set Dosen Pengajar
            document.getElementById('form_dosen_id').value = jadwal.dosen_id || '';
            const matchedDosen = document.querySelector(`.dosen-item-option[data-id="${jadwal.dosen_id}"]`);
            if (matchedDosen) {
                document.getElementById('form_dosen_name').value = matchedDosen.getAttribute('data-name');
            } else if (jadwal.dosen) {
                document.getElementById('form_dosen_name').value = jadwal.dosen.nama;
            } else {
                document.getElementById('form_dosen_name').value = '';
            }

            // 7. Set Kelas & Program Kuliah
            document.getElementById('form_kelas').value = jadwal.kelas ? jadwal.kelas.replace(/^(Reg|Karyawan)\s+/i, '') : 'A';
            document.getElementById('form_program_kuliah').value = jadwal.program_kuliah || 'Reguler';

            // 8. Set Jam
            document.getElementById('form_jam_mulai').value = jadwal.jam_mulai ? jadwal.jam_mulai.substr(0, 5) : '08:00';
            document.getElementById('form_jam_selesai').value = jadwal.jam_selesai ? jadwal.jam_selesai.substr(0, 5) : '10:30';

            closeAllDropdowns();
            modal.classList.remove('hidden');
        }

        function closeModal() {
            closeAllDropdowns();
            modal.classList.add('hidden');
        }

        // SweetAlert2 Alerts for Session & Form Submits
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

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
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
        });
    </script>
</body>
</html>
