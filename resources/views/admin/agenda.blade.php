<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Agenda - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
    <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 h-screen sticky top-0 hidden lg:flex">
        <div class="p-5 flex items-center gap-3 border-b border-slate-800 shrink-0">
            <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white shrink-0">
                <i class="fa-solid fa-user-shield text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">ADMIN CONTROL PANEL</p>
            </div>
        </div>
        
        <nav class="flex-1 min-h-0 px-3 py-3 space-y-1 overflow-y-auto custom-sidebar-scroll">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-line"></i>
                <span class="text-xs">Dashboard Overview</span>
            </a>
            <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-users-gear"></i>
                <span class="text-xs">Manajemen Pengguna</span>
            </a>
            <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-door-open"></i>
                <span class="text-xs">Manajemen Lab</span>
            </a>
            <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 bg-teal-850 text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs">Jadwal & Agenda</span>
            </a>
            <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="text-xs">Laporan Absensi</span>
            </a>
            <a href="{{ route('admin.statistik') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="text-xs">Statistik Kehadiran</span>
            </a>
            <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="text-xs">Data Akademik</span>
            </a>
            <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-bullhorn"></i>
                <span class="text-xs">Pengumuman Lab</span>
            </a>
            
                        <a href="{{ route('admin.aktivitas') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="text-xs">Riwayat Aktivitas</span>
            </a>

            
            
            <div class="pt-2 border-t border-slate-800/80 my-2"></div>
            <a href="{{ route('board') }}" target="_blank" class="flex items-center justify-between px-4 py-2.5 bg-[#0c4ea6]/40 hover:bg-[#0c4ea6] text-teal-300 hover:text-white rounded-xl w-full transition font-bold border border-teal-500/20">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-desktop text-emerald-400"></i>
                    <span class="text-xs">Portal Display Board</span>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </nav>
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Monitoring Jadwal & Agenda Praktikum</h2>
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

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-850 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-5xl">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search & Filter Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm max-w-5xl">
                <form action="{{ route('admin.agenda') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end text-xs">
                    <div class="flex-grow w-full">
                        <label class="block text-slate-655 font-bold mb-1.5">Cari Agenda / Dosen</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama mata kuliah, nama dosen..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                        </div>
                    </div>
                    <div class="w-full sm:w-48">
                        <label class="block text-slate-650 font-bold mb-1.5">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="flex-grow sm:flex-grow-0 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'tanggal']))
                            <a href="{{ route('admin.agenda') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-all border border-slate-200 text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Agendas List -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden max-w-5xl">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Agenda Mengajar Seluruh Dosen</h3>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] bg-teal-50 text-teal-800 font-bold px-2.5 py-1 rounded-full hidden sm:inline-block">{{ $agendas->total() }} Sesi Mengajar</span>
                        <button onclick="openAddModal()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-plus"></i> Tambah Agenda
                        </button>
                        <button onclick="toggleModal('modal-import-agenda')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-file-import"></i> Import Agenda
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    @if($agendas->count() > 0)
                        <form id="bulk-delete-form" action="{{ route('admin.agenda.bulk-delete') }}" method="POST" onsubmit="return confirmAction(event, 'Semua data agenda terpilih akan terhapus!', 'Hapus Agenda Terpilih?');">
                            @csrf
                            @method('DELETE')

                            <div id="btn-bulk-delete" class="hidden mb-3 p-3 bg-rose-50 border border-rose-200 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-bold text-rose-800"><span id="bulk-count">0</span> agenda terpilih</span>
                                <button type="submit" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
                                </button>
                            </div>

                            <div class="overflow-x-auto border border-slate-100 rounded-xl">
                                <table class="w-full text-xs text-left text-slate-650">
                                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                        <tr>
                                            <th class="p-4 w-10 text-center">
                                                <input type="checkbox" id="select-all" onclick="toggleSelectAll(this)" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer">
                                            </th>
                                            <th class="p-4">Tanggal / Waktu</th>
                                            <th class="p-4">Mata Kuliah / Detail</th>
                                            <th class="p-4">Dosen Pengampu</th>
                                            <th class="p-4">Ruang Lab</th>
                                            <th class="p-4 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($agendas as $ag)
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="p-4 text-center">
                                                    <input type="checkbox" name="ids[]" value="{{ $ag->id }}" class="agenda-checkbox rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer" onclick="updateBulkDeleteBtn()">
                                                </td>
                                                <td class="p-4">
                                                    <span class="font-bold text-slate-800 block">{{ date('d M Y', strtotime($ag->tanggal)) }}</span>
                                                    <span class="text-[10px] font-mono text-slate-450">{{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB</span>
                                                </td>
                                                <td class="p-4">
                                                    <span class="font-bold text-teal-900 block text-sm">{{ $ag->mata_kuliah }}</span>
                                                    <span class="text-[10px] text-slate-450 uppercase font-semibold">
                                                        Status: <span class="px-1.5 py-0.5 rounded text-[9px] font-bold @if($ag->status_agenda == 'Berlangsung') bg-amber-100 text-amber-800 @elseif($ag->status_agenda == 'Selesai') bg-emerald-100 text-emerald-800 @elseif($ag->status_agenda == 'Dibatalkan') bg-rose-100 text-rose-800 @else bg-slate-100 text-slate-700 @endif">{{ $ag->status_agenda }}</span> 
                                                        | Program: {{ $ag->program_kuliah ?? 'Reguler' }} 
                                                        | Kelas: {{ $ag->kelas ?: '-' }}
                                                    </span>
                                                </td>
                                                <td class="p-4 font-semibold text-slate-700">{{ $ag->dosen->nama ?? '-' }}</td>
                                                <td class="p-4 text-slate-500">
                                                    <span class="block font-semibold">{{ $ag->lab->nama_lab ?? '-' }}</span>
                                                    <span class="text-[10px] text-slate-450">{{ $ag->lab->lokasi ?? '-' }}</span>
                                                </td>
                                                <td class="p-4">
                                                    <div class="flex justify-center items-center gap-1.5">
                                                        <button type="button" onclick='openEditModal(@json($ag))' class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg font-bold transition flex items-center gap-1 text-xs">
                                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                                        </button>
                                                        <button type="button" onclick="confirmDeleteAgenda('{{ route('admin.agenda.delete', $ag->id) }}')" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-650 border border-rose-200 rounded-lg font-bold transition flex items-center gap-1 text-xs">
                                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="pt-4">
                            {{ $agendas->links() }}
                        </div>
                    @else
                        <p class="text-center py-10 text-slate-400 italic">Jadwal agenda praktikum tidak ditemukan.</p>
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
        <a href="{{ route('admin.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-855 font-bold">
            <i class="fa-solid fa-calendar-days text-lg"></i>
            <span>Agenda</span>
        </a>
        <a href="{{ route('admin.absensi') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-file-invoice text-lg"></i>
            <span>Absen</span>
        </a>
    </nav>

    <!-- MODAL TAMBAH / EDIT AGENDA -->
    <div id="modal-agenda" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-agenda-title" class="font-bold text-base text-slate-800">Tambah Agenda Praktikum</h3>
                <button type="button" onclick="toggleModal('modal-agenda')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <form id="agenda-form" action="{{ route('admin.agenda.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" id="agenda-method" name="_method" value="POST">
                <input type="hidden" id="agenda_id" name="agenda_id" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Dosen Pengampu -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Dosen Pengampu <span class="text-rose-500">*</span></label>
                        <select id="form_dosen_id" name="dosen_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }} (NIP: {{ $d->nip }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ruang Laboratorium -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Ruang Laboratorium <span class="text-rose-500">*</span></label>
                        <select id="form_lab_id" name="lab_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="">-- Pilih Laboratorium --</option>
                            @foreach($labs as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lab }} ({{ $l->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Kuliah / Judul Agenda -->
                    <div class="md:col-span-2">
                        <label class="block text-slate-700 font-bold mb-1">Mata Kuliah / Judul Agenda <span class="text-rose-500">*</span></label>
                        <input type="text" id="form_judul_agenda" name="judul_agenda" placeholder="Contoh: Pemrograman Web Lanjut" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>

                    <!-- Program Kuliah & Tipe Pertemuan -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Program Kuliah <span class="text-rose-500">*</span></label>
                            <select id="form_program_kuliah" name="program_kuliah" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="Reguler">Reguler</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Tipe Pertemuan <span class="text-rose-500">*</span></label>
                            <select id="form_jenis_pertemuan" name="jenis_pertemuan" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="Praktikum">Praktikum</option>
                                <option value="Teori">Teori</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Kelas <span class="text-slate-400 font-normal text-[10px]">(Opsional)</span></label>
                        <input type="text" id="form_kelas" name="kelas" placeholder="Contoh: TI-3A (Kosongkan jika tidak ada)" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none" list="kelas_list">
                        <datalist id="kelas_list">
                            @foreach($kelases as $k)
                                <option value="{{ $k->nama_kelas }}">
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Semester -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Semester <span class="text-rose-500">*</span></label>
                        <input type="text" id="form_semester" name="semester" placeholder="Contoh: Semester 3" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>

                    <!-- Status Agenda -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Status Agenda <span class="text-rose-500">*</span></label>
                        <select id="form_status_agenda" name="status_agenda" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="Akan Datang">Akan Datang</option>
                            <option value="Berlangsung">Berlangsung</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Jurusan / Prodi -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Jurusan / Program Studi <span class="text-rose-500">*</span></label>
                        <input type="text" id="form_jurusan" name="jurusan" placeholder="Contoh: Teknik Informatika" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none" list="prodi_list">
                        <datalist id="prodi_list">
                            @foreach($prodis as $p)
                                <option value="{{ $p->nama_prodi }}">
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Fakultas -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Fakultas <span class="text-rose-500">*</span></label>
                        <input type="text" id="form_fakultas" name="fakultas" placeholder="Contoh: Fakultas Teknik & Sains" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none" list="fakultas_list">
                        <datalist id="fakultas_list">
                            @foreach($fakultas as $f)
                                <option value="{{ $f->nama_fakultas }}">
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Tanggal Praktikum <span class="text-rose-500">*</span></label>
                        <input type="date" id="form_tanggal" name="tanggal" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>

                    <!-- Jam Mulai & Jam Selesai -->
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Mulai <span class="text-rose-500">*</span></label>
                            <input type="time" id="form_waktu_masuk" name="waktu_masuk" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Selesai <span class="text-rose-500">*</span></label>
                            <input type="time" id="form_waktu_keluar" name="waktu_keluar" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                    </div>

                    <!-- Catatan / Rencana Pembelajaran -->
                    <div class="md:col-span-2">
                        <label class="block text-slate-700 font-bold mb-1">Catatan / Rencana Pembelajaran</label>
                        <textarea id="form_rencana_pembelajaran" name="rencana_pembelajaran" rows="3" placeholder="Rencana materi pembelajaran atau catatan praktikum..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none"></textarea>
                    </div>
                </div>

                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-agenda')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-bold shadow-sm">Simpan Agenda</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL IMPORT AGENDA -->
    <div id="modal-import-agenda" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-base text-slate-800">Import Data Agenda</h3>
                <button onclick="toggleModal('modal-import-agenda')" class="text-slate-400 hover:text-slate-660 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.agenda.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-import-agenda')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-lg font-bold shadow-sm">Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- GLOBAL IMPORT LOADING OVERLAY -->
    <div id="global-import-loading-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[9999] flex flex-col items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl space-y-5">
            <div class="relative w-16 h-16 mx-auto flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-teal-500/20 border-t-teal-400 animate-spin"></div>
                <i class="fa-solid fa-cloud-arrow-up text-2xl text-teal-400"></i>
            </div>
            <div class="space-y-1.5">
                <h3 class="text-base font-extrabold text-white tracking-tight">Mengimpor Data...</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem sedang membaca dan memproses file Excel/CSV. Mohon tunggu sejenak dan jangan menutup halaman ini.
                </p>
            </div>
            <div class="pt-3 border-t border-slate-800 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-notch animate-spin text-teal-400 text-xs"></i>
                <span class="text-[11px] font-bold tracking-wider text-teal-300 uppercase">Memproses Database</span>
            </div>
        </div>
    </div>

    <script>
        function toggleSelectAll(master) {
            const checkboxes = document.querySelectorAll('.agenda-checkbox');
            checkboxes.forEach(cb => cb.checked = master.checked);
            updateBulkDeleteBtn();
        }

        function updateBulkDeleteBtn() {
            const checked = document.querySelectorAll('.agenda-checkbox:checked');
            const bulkBtn = document.getElementById('btn-bulk-delete');
            const bulkCount = document.getElementById('bulk-count');
            if (checked.length > 0) {
                bulkBtn.classList.remove('hidden');
                if (bulkCount) bulkCount.innerText = checked.length;
            } else {
                bulkBtn.classList.add('hidden');
            }
        }

        function confirmDeleteAgenda(actionUrl) {
            Swal.fire({
                title: 'Hapus Agenda Praktikum?',
                text: 'Semua data absensi kelas ini akan terhapus!',
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
                    form.action = actionUrl;
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function openAddModal() {
            document.getElementById('modal-agenda-title').innerText = 'Tambah Agenda Praktikum';
            const form = document.getElementById('agenda-form');
            form.action = "{{ route('admin.agenda.store') }}";
            document.getElementById('agenda-method').value = 'POST';
            
            document.getElementById('agenda_id').value = '';
            document.getElementById('form_dosen_id').value = '';
            document.getElementById('form_lab_id').value = '';
            document.getElementById('form_judul_agenda').value = '';
            document.getElementById('form_program_kuliah').value = 'Reguler';
            document.getElementById('form_jenis_pertemuan').value = 'Praktikum';
            document.getElementById('form_kelas').value = '';
            document.getElementById('form_semester').value = '';
            document.getElementById('form_jurusan').value = '';
            document.getElementById('form_fakultas').value = '';
            document.getElementById('form_tanggal').value = '';
            document.getElementById('form_waktu_masuk').value = '';
            document.getElementById('form_waktu_keluar').value = '';
            document.getElementById('form_status_agenda').value = 'Akan Datang';
            document.getElementById('form_rencana_pembelajaran').value = '';
            
            toggleModal('modal-agenda');
        }

        function openEditModal(ag) {
            document.getElementById('modal-agenda-title').innerText = 'Edit Agenda Praktikum';
            const form = document.getElementById('agenda-form');
            form.action = "{{ url('/admin/agenda') }}/" + ag.id;
            document.getElementById('agenda-method').value = 'PUT';
            
            document.getElementById('agenda_id').value = ag.id;
            document.getElementById('form_dosen_id').value = ag.dosen_id;
            document.getElementById('form_lab_id').value = ag.lab_id;
            document.getElementById('form_judul_agenda').value = ag.mata_kuliah;
            document.getElementById('form_program_kuliah').value = ag.program_kuliah || 'Reguler';
            document.getElementById('form_jenis_pertemuan').value = ag.jenis_pertemuan || 'Praktikum';
            document.getElementById('form_kelas').value = ag.kelas || '';
            document.getElementById('form_semester').value = ag.semester || '';
            document.getElementById('form_jurusan').value = ag.jurusan || '';
            document.getElementById('form_fakultas').value = ag.fakultas || '';
            document.getElementById('form_tanggal').value = ag.tanggal;
            document.getElementById('form_waktu_masuk').value = ag.jam_mulai ? ag.jam_mulai.substring(0,5) : '';
            document.getElementById('form_waktu_keluar').value = ag.jam_selesai ? ag.jam_selesai.substring(0,5) : '';
            document.getElementById('form_status_agenda').value = ag.status_agenda || 'Akan Datang';
            document.getElementById('form_rencana_pembelajaran').value = ag.catatan || '';
            
            toggleModal('modal-agenda');
        }
        function showImportLoading(form) {
            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput && fileInput.files && fileInput.files.length === 0) {
                return true;
            }
            setTimeout(() => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-1"></i> Memproses...';
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            }, 10);
            const overlay = document.getElementById('global-import-loading-overlay');
            if (overlay) {
                overlay.classList.remove('hidden');
            }
            return true;
        }

        window.addEventListener('pageshow', function() {
            const overlay = document.getElementById('global-import-loading-overlay');
            if (overlay) {
                overlay.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('global-import-loading-overlay');
            if (overlay) {
                overlay.classList.add('hidden');
            }
            document.querySelectorAll('form[enctype="multipart/form-data"]').forEach(function(form) {
                form.addEventListener('submit', function() {
                    showImportLoading(this);
                });
            });
        });

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }
    </script>

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
        function confirmAction(event, text, title = 'Apakah Anda yakin?', confirmText = 'Ya, Lanjutkan!') {
            event.preventDefault();
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            
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
    </script>
</body>
</html>




