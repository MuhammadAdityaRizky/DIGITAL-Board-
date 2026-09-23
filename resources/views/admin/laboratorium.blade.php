<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Laboratorium - Digital Board</title>
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
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleAdminMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition focus:outline-none cursor-pointer" title="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Manajemen Laboratorium</h2>
            </div>
            
            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ auth()->user()->username }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500 uppercase">{{ auth()->user()->isSuperAdmin() ? 'SUPER ADMIN' : 'ADMIN FAKULTAS' }}</p>
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
                            {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : (auth()->user()->fakultas?->nama_fakultas ?? 'Admin Fakultas') }}
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
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-850 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-7xl mx-auto">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Header Actions & Multi-Filter Bar -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <h3 class="font-extrabold text-base text-slate-800">Manajemen & Status Laboratorium</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola data ruang laboratorium, kapasitas, status ketersediaan, dan jadwal praktikum.</p>
                        </div>
                        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                            <button onclick="toggleModal('modal-import-lab')" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 shadow-xs">
                                <i class="fa-solid fa-file-import text-teal-700"></i> Import Lab
                            </button>
                            <button onclick="toggleModal('modal-lab')" class="px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-plus text-xs"></i> Tambah Lab Baru
                            </button>
                        </div>
                    </div>

                    <!-- Filter Controls -->
                    <form action="{{ route('admin.laboratorium') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
                        
                        <!-- Search Box -->
                        <div class="relative lg:col-span-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lab, gedung, atau lokasi..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400"></i>
                        </div>

                        <!-- Fakultas Filter (Super Admin) -->
                        @if(auth()->user()->isSuperAdmin())
                            <div>
                                <select name="fakultas_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none">
                                    <option value="">Semua Fakultas</option>
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}" {{ request('fakultas_id') == $f->id ? 'selected' : '' }}>{{ $f->nama_fakultas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div>
                                <input type="text" readonly value="{{ auth()->user()->fakultas?->nama_fakultas ?? 'Fakultas Anda' }}" class="w-full px-3 py-2 rounded-xl bg-slate-100 border border-slate-200 font-bold text-slate-500 cursor-not-allowed">
                            </div>
                        @endif

                        <!-- Kapasitas Filter -->
                        <div>
                            <select name="kapasitas" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none">
                                <option value="">Semua Kapasitas</option>
                                <option value="small" {{ request('kapasitas') == 'small' ? 'selected' : '' }}>&lt; 30 Kursi (Kecil)</option>
                                <option value="medium" {{ request('kapasitas') == 'medium' ? 'selected' : '' }}>30 - 50 Kursi (Sedang)</option>
                                <option value="large" {{ request('kapasitas') == 'large' ? 'selected' : '' }}>&gt; 50 Kursi (Besar)</option>
                            </select>
                        </div>

                        <!-- Status Filter & Reset -->
                        <div class="flex gap-2">
                            <select name="status" onchange="this.form.submit()" class="flex-1 px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none">
                                <option value="">Semua Status</option>
                                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>🟢 Tersedia</option>
                                <option value="sedang dipakai" {{ request('status') == 'sedang dipakai' ? 'selected' : '' }}>🔵 Sedang Dipakai</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>🟠 Maintenance</option>
                            </select>

                            @if(request()->hasAny(['search', 'fakultas_id', 'kapasitas', 'status']))
                                <a href="{{ route('admin.laboratorium') }}" class="px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 whitespace-nowrap shadow-xs" title="Reset Semua Filter">
                                    <i class="fa-solid fa-rotate-left"></i> Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Counter Bar & Toggle View Switcher -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-800 border border-teal-200/80 flex items-center justify-center font-bold text-sm shadow-xs">
                            <i class="fa-solid fa-flask"></i>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-800">
                                Menampilkan {{ $labs->firstItem() ?? 0 }} - {{ $labs->lastItem() ?? 0 }} dari total {{ $labs->total() }} Laboratorium
                            </p>
                            <p class="text-[11px] text-slate-500 font-medium">Ubah format tampilan antara mode Card Grid dan Mode Tabel melalui tombol di kanan.</p>
                        </div>
                    </div>

                    <!-- View Switcher -->
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl border border-slate-200/80 self-end sm:self-auto">
                        <button type="button" id="btn-view-grid" onclick="switchLabView('grid')" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-white text-teal-800 shadow-xs">
                            <i class="fa-solid fa-border-all text-xs"></i> Card Grid
                        </button>
                        <button type="button" id="btn-view-list" onclick="switchLabView('list')" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-600 hover:text-slate-900">
                            <i class="fa-solid fa-list text-xs"></i> Tabel List
                        </button>
                    </div>
                </div>

                <!-- LABS DISPLAY CONTAINER -->
                @if($labs->count() > 0)
                    
                    <!-- 1. GRID VIEW CONTAINER -->
                    <div id="lab-grid-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($labs as $l)
                            <div class="bg-white border border-slate-200/90 hover:border-teal-600/40 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group space-y-4">
                                
                                <!-- Card Header: Badges -->
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between gap-2">
                                        <!-- Status Badge -->
                                        @if($l->computed_status === 'Sedang Dipakai')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200/80 shadow-xs">
                                                <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span> Sedang Dipakai
                                            </span>
                                        @elseif($l->computed_status === 'Maintenance')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200/80 shadow-xs">
                                                <i class="fa-solid fa-wrench text-[10px]"></i> Maintenance
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-xs">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Tersedia
                                            </span>
                                        @endif

                                        <!-- Fakultas Badge -->
                                        <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold rounded-lg truncate max-w-[140px]" title="{{ $l->fakultas?->nama_fakultas ?? 'Fakultas Umum' }}">
                                            <i class="fa-solid fa-building-columns text-slate-400 mr-1 text-[10px]"></i> {{ $l->fakultas?->nama_fakultas ?? 'Umum' }}
                                        </span>
                                    </div>

                                    <!-- Lab Title & Location -->
                                    <div>
                                        <h4 onclick='openLabDetail(@json($l))' class="font-extrabold text-slate-900 text-base group-hover:text-teal-800 transition cursor-pointer flex items-center justify-between">
                                            <span>{{ $l->nama_lab }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs text-slate-300 group-hover:text-teal-600 transition"></i>
                                        </h4>
                                        <div class="mt-2 text-xs text-slate-600 space-y-1">
                                            <p class="flex items-center gap-2 font-medium">
                                                <i class="fa-solid fa-location-dot text-slate-400 w-4 text-center"></i> {{ $l->lokasi }}
                                            </p>
                                            <p class="flex items-center gap-2 font-medium">
                                                <i class="fa-solid fa-chair text-slate-400 w-4 text-center"></i> <span class="font-bold text-slate-700">{{ $l->kapasitas }}</span> Kursi Workstation
                                            </p>
                                            <p class="flex items-center gap-2 font-medium">
                                                <i class="fa-solid fa-user-gear text-teal-600 w-4 text-center"></i> Laboran: <span class="font-bold text-slate-800">{{ $l->nama_laboran ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Active Session Preview (If In Use) -->
                                    @if($l->computed_status === 'Sedang Dipakai' && isset($l->active_agenda))
                                        <div class="p-3 bg-blue-50/80 border border-blue-100 rounded-xl text-xs space-y-1">
                                            <p class="text-[10px] uppercase tracking-wider font-extrabold text-blue-800 flex items-center gap-1.5">
                                                <i class="fa-solid fa-clock text-[10px]"></i> Sesi Aktif Hari Ini:
                                            </p>
                                            <p class="font-bold text-blue-950 truncate">{{ $l->active_agenda->matakuliah ?? 'Praktikum Komputer' }}</p>
                                            <p class="text-[11px] text-blue-700 truncate flex items-center gap-1 font-medium">
                                                <i class="fa-solid fa-user-tie text-[10px]"></i> {{ $l->active_agenda->dosen?->nama ?? 'Dosen Pengampu' }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Card Footer Actions -->
                                <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                                    <button type="button" onclick='openLabDetail(@json($l))' class="flex-1 py-2 px-3 bg-slate-100 hover:bg-teal-50 hover:text-teal-800 text-slate-700 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 border border-slate-200/70">
                                        <i class="fa-solid fa-circle-info text-teal-700"></i> Detail Lab
                                    </button>

                                    <button type="button" onclick='editLab(@json($l))' class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-teal-50 hover:text-teal-800 border border-slate-200/80 flex items-center justify-center text-slate-600 transition shadow-xs cursor-pointer" title="Edit Laboratorium">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.laboratorium.delete', $l->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus laboratorium ini? Semua agenda/jadwal penggunaan terkait lab ini akan ikut terhapus.', 'Hapus Laboratorium?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 border border-slate-200/80 flex items-center justify-center text-slate-500 transition shadow-xs cursor-pointer" title="Hapus Laboratorium">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- 2. TABLE VIEW CONTAINER -->
                    <div id="lab-list-container" class="hidden bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-slate-700">
                                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                                    <tr>
                                        <th class="px-5 py-3.5">#</th>
                                        <th class="px-5 py-3.5">Nama Laboratorium</th>
                                        <th class="px-5 py-3.5">Fakultas</th>
                                        <th class="px-5 py-3.5">Lokasi / Ruang</th>
                                        <th class="px-5 py-3.5">Laboran Penanggung Jawab</th>
                                        <th class="px-5 py-3.5">Kapasitas</th>
                                        <th class="px-5 py-3.5">Status Saat Ini</th>
                                        <th class="px-5 py-3.5 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($labs as $index => $l)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="px-5 py-3.5 font-bold text-slate-400">{{ $labs->firstItem() + $index }}</td>
                                            <td class="px-5 py-3.5">
                                                <button type="button" onclick='openLabDetail(@json($l))' class="font-extrabold text-slate-900 hover:text-teal-700 text-left transition">
                                                    {{ $l->nama_lab }}
                                                </button>
                                            </td>
                                            <td class="px-5 py-3.5">
                                                <span class="px-2.5 py-0.5 bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] rounded-md">
                                                    {{ $l->fakultas?->nama_fakultas ?? 'Umum' }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3.5 font-medium text-slate-600">
                                                <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> {{ $l->lokasi }}
                                            </td>
                                            <td class="px-5 py-3.5 font-bold text-slate-800">
                                                <div class="flex items-center gap-1.5">
                                                    <i class="fa-solid fa-user-gear text-teal-600 text-xs"></i>
                                                    <span>{{ $l->nama_laboran ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3.5 font-bold text-slate-800">
                                                {{ $l->kapasitas }} Kursi
                                            </td>
                                            <td class="px-5 py-3.5">
                                                @if($l->computed_status === 'Sedang Dipakai')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200/80">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-ping"></span> Sedang Dipakai
                                                    </span>
                                                @elseif($l->computed_status === 'Maintenance')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200/80">
                                                        <i class="fa-solid fa-wrench text-[9px]"></i> Maintenance
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersedia
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <button type="button" onclick='openLabDetail(@json($l))' class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-teal-50 hover:text-teal-700 border border-slate-200 flex items-center justify-center text-slate-600 transition" title="Detail Lab">
                                                        <i class="fa-solid fa-eye text-xs"></i>
                                                    </button>
                                                    <button type="button" onclick='editLab(@json($l))' class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-teal-50 hover:text-teal-700 border border-slate-200 flex items-center justify-center text-slate-600 transition" title="Edit Lab">
                                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                    </button>
                                                    <form action="{{ route('admin.laboratorium.delete', $l->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus laboratorium ini? Semua agenda/jadwal penggunaan terkait lab ini akan ikut terhapus.', 'Hapus Laboratorium?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-600 border border-slate-200 flex items-center justify-center text-slate-500 transition" title="Hapus Lab">
                                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination Links -->
                    <div class="pt-4">
                        {{ $labs->links() }}
                    </div>

                @else
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center space-y-3 shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl">
                            <i class="fa-solid fa-flask font-bold"></i>
                        </div>
                        <h4 class="font-extrabold text-slate-800 text-sm">Laboratorium Tidak Ditemukan</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                            Tidak ada data laboratorium yang sesuai dengan pencarian atau filter yang Anda pilih. Coba sesuaikan kata kunci pencarian atau reset filter.
                        </p>
                        @if(request()->hasAny(['search', 'fakultas_id', 'kapasitas', 'status']))
                            <div class="pt-2">
                                <a href="{{ route('admin.laboratorium') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                                    <i class="fa-solid fa-rotate-left"></i> Clear / Reset Filter
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

            </div>

        </div>
    </main>

    <!-- MODAL DETAIL & PIC LABORATORIUM -->
    <div id="modal-detail-lab" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 space-y-5 overflow-hidden max-h-[90vh] flex flex-col">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-start pb-4 border-b border-slate-100 flex-shrink-0">
                <div class="space-y-1">
                    <div class="flex items-center gap-2.5">
                        <h3 id="detail-lab-nama" class="font-extrabold text-lg text-slate-900">LAB. Sistem Informasi</h3>
                        <div id="detail-lab-status-badge"></div>
                    </div>
                    <p id="detail-lab-fakultas" class="text-xs text-slate-500 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-building-columns text-slate-400"></i> Fakultas Teknik & Sains
                    </p>
                </div>
                <button onclick="toggleModal('modal-detail-lab')" class="text-slate-400 hover:text-slate-600 text-xl font-bold p-1">&times;</button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="overflow-y-auto space-y-5 flex-grow pr-1 text-xs">
                
                <!-- Quick Metric Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                        <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Gedung / Ruang</p>
                        <p id="detail-lab-lokasi" class="font-bold text-slate-800 truncate">Gedung FTS / 209</p>
                    </div>
                    <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1">
                        <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Kapasitas Kursi</p>
                        <p id="detail-lab-kapasitas" class="font-bold text-slate-800">40 Workstation</p>
                    </div>
                    <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-1 col-span-2 sm:col-span-1">
                        <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Laboran / Penanggung Jawab</p>
                        <p id="detail-lab-pic" class="font-bold text-slate-800 truncate">-</p>
                    </div>
                </div>

                <!-- Inventaris PC & Fasilitas Lab -->
                <div class="bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 space-y-3">
                    <h4 class="font-extrabold text-slate-800 text-xs flex items-center gap-2">
                        <i class="fa-solid fa-desktop text-teal-700"></i> Inventaris Perangkat & Fasilitas Lab
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px]">
                        <div class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-slate-200/60 shadow-xs">
                            <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-microchip"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Spesifikasi Workstation</p>
                                <p class="text-[10px] text-slate-500">PC Core i7 / 16GB RAM / SSD 512GB</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-slate-200/60 shadow-xs">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-video"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Proyektor & Sound System</p>
                                <p class="text-[10px] text-slate-500">EPSON High Lumen + Screen 120"</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-slate-200/60 shadow-xs">
                            <div class="w-7 h-7 rounded-lg bg-cyan-50 text-cyan-700 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-snowflake"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Pendingin Ruangan</p>
                                <p class="text-[10px] text-slate-500">2 Unit AC Split 2 PK</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-slate-200/60 shadow-xs">
                            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-wifi"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Jaringan & Internet</p>
                                <p class="text-[10px] text-slate-500">Gigabit LAN Switch + Wi-Fi AP 1Gbps</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal / Agenda Hari Ini -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <h4 class="font-extrabold text-slate-800 text-xs flex items-center gap-2">
                            <i class="fa-solid fa-calendar-day text-teal-700"></i> Jadwal Agenda Praktikum Hari Ini
                        </h4>
                        <span class="text-[10px] font-bold text-slate-400">{{ date('d M Y') }}</span>
                    </div>

                    <div id="detail-lab-agendas" class="space-y-2">
                        <!-- Populated by JS -->
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-between gap-3 pt-3 border-t border-slate-100 flex-shrink-0">
                <button type="button" onclick="toggleModal('modal-detail-lab')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs transition">
                    Tutup
                </button>
                <a href="{{ route('admin.jadwal-lab') }}" class="px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-extrabold text-xs shadow-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days"></i> Lihat Jadwal Penggunaan Lab
                </a>
            </div>
        </div>
    </div>

    <!-- LAB MODAL (ADD & EDIT) -->
    <div id="modal-lab" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-lab-title" class="font-bold text-base text-slate-800">Tambah Laboratorium</h3>
                <button onclick="toggleModal('modal-lab')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <form id="lab-form" action="{{ route('admin.labs.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" id="lab-method" name="_method" value="POST">
                
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Laboratorium</label>
                    <input type="text" id="lab-nama_lab" name="nama_lab" required placeholder="Contoh: Lab Komputer 1" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Fakultas Naungan</label>
                    @if(auth()->user()->isSuperAdmin())
                        <select id="lab-fakultas_id" name="fakultas_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="hidden" name="fakultas_id" value="{{ auth()->user()->fakultas_id }}">
                        <input type="text" readonly disabled value="{{ auth()->user()->fakultas?->nama_fakultas ?? 'Fakultas Anda' }}" class="w-full p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-500 font-bold cursor-not-allowed">
                    @endif
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Lokasi Gedung / Ruang</label>
                    <input type="text" id="lab-lokasi" name="lokasi" required placeholder="Contoh: Gedung B Lantai 2" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Kapasitas (Jumlah Kursi Workstation)</label>
                    <input type="number" id="lab-kapasitas" name="kapasitas" required placeholder="Contoh: 30" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Laboran / Teknisi Penanggung Jawab Ruangan</label>
                    <input type="text" id="lab-nama_laboran" name="nama_laboran" placeholder="Contoh: Kurniawan, S.T." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Nama ini akan otomatis digunakan pada tanda tangan lembar Berita Acara & Realisasi Praktikum di lab ini.</span>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-lab')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-bold shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <!-- MODAL IMPORT LAB -->
    <div id="modal-import-lab" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-base text-slate-800">Import Data Laboratorium</h3>
                <button onclick="toggleModal('modal-import-lab')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.laboratorium.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'laboratorium') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                    </div>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-import-lab')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
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
        // Toggle View Logic (Grid vs Table List)
        function switchLabView(mode) {
            const gridContainer = document.getElementById('lab-grid-container');
            const listContainer = document.getElementById('lab-list-container');
            const btnGrid = document.getElementById('btn-view-grid');
            const btnList = document.getElementById('btn-view-list');

            if (!gridContainer || !listContainer) return;

            if (mode === 'list') {
                gridContainer.classList.add('hidden');
                listContainer.classList.remove('hidden');

                btnGrid.className = "px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-600 hover:text-slate-900";
                btnList.className = "px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-white text-teal-800 shadow-xs";
                localStorage.setItem('digitalboard_lab_view', 'list');
            } else {
                listContainer.classList.add('hidden');
                gridContainer.classList.remove('hidden');

                btnList.className = "px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-600 hover:text-slate-900";
                btnGrid.className = "px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-white text-teal-800 shadow-xs";
                localStorage.setItem('digitalboard_lab_view', 'grid');
            }
        }

        // Open Detail Modal
        function openLabDetail(lab) {
            document.getElementById('detail-lab-nama').innerText = lab.nama_lab || 'Laboratorium';
            document.getElementById('detail-lab-lokasi').innerText = lab.lokasi || '-';
            document.getElementById('detail-lab-kapasitas').innerText = (lab.kapasitas || '30') + ' Workstation';
            document.getElementById('detail-lab-fakultas').innerHTML = `<i class="fa-solid fa-building-columns text-slate-400"></i> ${lab.fakultas ? lab.fakultas.nama_fakultas : 'Fakultas Umum'}`;
            document.getElementById('detail-lab-pic').innerText = lab.nama_laboran ? `${lab.nama_laboran} (Laboran)` : (lab.fakultas ? 'Admin Lab ' + lab.fakultas.nama_fakultas : 'Belum Ditentukan');

            // Status Badge
            const statusContainer = document.getElementById('detail-lab-status-badge');
            const status = lab.computed_status || 'Tersedia';

            if (status === 'Sedang Dipakai') {
                statusContainer.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-blue-50 text-blue-700 border border-blue-200/80 shadow-xs"><span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span> Sedang Dipakai</span>`;
            } else if (status === 'Maintenance') {
                statusContainer.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 text-amber-700 border border-amber-200/80 shadow-xs"><i class="fa-solid fa-wrench text-xs"></i> Maintenance</span>`;
            } else {
                statusContainer.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-xs"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Tersedia</span>`;
            }

            // Populate Today Agendas List
            const agendaContainer = document.getElementById('detail-lab-agendas');
            if (lab.today_agendas && lab.today_agendas.length > 0) {
                let html = '';
                lab.today_agendas.forEach(ag => {
                    const jamMulai = ag.jam_mulai ? ag.jam_mulai.substring(0, 5) : '08:00';
                    const jamSelesai = ag.jam_selesai ? ag.jam_selesai.substring(0, 5) : '10:00';
                    const dosenNama = ag.dosen ? ag.dosen.nama : 'Dosen Pengampu';
                    const matkul = ag.matakuliah || 'Praktikum';

                    html += `
                        <div class="p-3 bg-white border border-slate-200/80 rounded-xl flex items-center justify-between shadow-xs">
                            <div class="space-y-0.5">
                                <p class="font-extrabold text-slate-900 text-xs">${matkul}</p>
                                <p class="text-[11px] text-slate-500 flex items-center gap-1"><i class="fa-solid fa-user-tie text-[10px] text-slate-400"></i> ${dosenNama}</p>
                            </div>
                            <span class="px-2.5 py-1 bg-teal-50 border border-teal-200/60 text-teal-800 text-[10px] font-extrabold rounded-lg">
                                ${jamMulai} - ${jamSelesai}
                            </span>
                        </div>
                    `;
                });
                agendaContainer.innerHTML = html;
            } else {
                agendaContainer.innerHTML = `
                    <div class="p-4 bg-slate-50 border border-slate-200/60 rounded-xl text-center text-slate-500 italic text-xs">
                        Tidak ada agenda praktikum/kuliah terdaftar di laboratorium ini hari ini.
                    </div>
                `;
            }

            toggleModal('modal-detail-lab');
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
            const savedView = localStorage.getItem('digitalboard_lab_view');
            if (savedView === 'list') {
                switchLabView('list');
            }

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
            if (modal) {
                modal.classList.toggle('hidden');
            }
            
            if (modalId === 'modal-lab' && modal && modal.classList.contains('hidden') === false) {
                document.getElementById('modal-lab-title').innerText = "Tambah Laboratorium";
                document.getElementById('lab-form').action = "{{ route('admin.labs.store') }}";
                document.getElementById('lab-method').value = "POST";
                document.getElementById('lab-nama_lab').value = "";
                document.getElementById('lab-lokasi').value = "";
                document.getElementById('lab-kapasitas').value = "30";
                document.getElementById('lab-nama_laboran').value = "";
                if (document.getElementById('lab-fakultas_id')) {
                    const fakSelect = document.getElementById('lab-fakultas_id');
                    if (fakSelect.options.length > 1) {
                        fakSelect.selectedIndex = 1;
                    } else {
                        fakSelect.value = "";
                    }
                }
            }
        }

        function editLab(lab) {
            document.getElementById('modal-lab-title').innerText = "Edit Detail Laboratorium";
            
            const updateUrl = `{{ url('/admin/laboratorium') }}/${lab.id}`;
            document.getElementById('lab-form').action = updateUrl;
            document.getElementById('lab-method').value = "PUT";
            
            document.getElementById('lab-nama_lab').value = lab.nama_lab;
            document.getElementById('lab-lokasi').value = lab.lokasi;
            document.getElementById('lab-kapasitas').value = lab.kapasitas || "30";
            document.getElementById('lab-nama_laboran').value = lab.nama_laboran || "";
            if (document.getElementById('lab-fakultas_id')) {
                document.getElementById('lab-fakultas_id').value = lab.fakultas_id || "";
            }
            
            toggleModal('modal-lab');
        }
    </script>

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
        function confirmAction(event, text, title = 'Apakah Anda yakin?', confirmText = 'Ya, Lanjutkan!') {
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            if (form && form.dataset.confirmed === "true") {
                return true;
            }

            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
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

                    Swal.fire({
                        title: 'Menghapus Data...',
                        text: 'Sedang memproses penghapusan data dari sistem.',
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

                    form.submit();
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
                if (typeof Swal !== 'undefined' && Swal.isVisible()) {
                    Swal.close();
                }
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
    </script>
</body>
</html>
