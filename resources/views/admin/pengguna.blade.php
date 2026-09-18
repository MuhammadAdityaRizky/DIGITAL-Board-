<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Digital Board</title>
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
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Manajemen Akun Pengguna</h2>
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

            <div class="max-w-7xl mx-auto space-y-6 w-full">

                <!-- Compact Multi-Filter Bar -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    <form id="filterForm" action="{{ route('admin.pengguna') }}" method="GET" class="space-y-3.5 text-xs">
                        <input type="hidden" name="sort_by" value="{{ request('sort_by', 'created_at') }}">
                        <input type="hidden" name="sort_order" value="{{ request('sort_order', 'desc') }}">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">

                        <!-- Row 1: Search & Role Filters -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            
                            <!-- Search Input -->
                            <div class="lg:col-span-2">
                                <label class="block text-slate-700 font-extrabold mb-1">Cari Pengguna</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama lengkap, NIM, NIP, atau username..." class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400"></i>
                                </div>
                            </div>

                            <!-- Fakultas Filter -->
                            @if(auth()->user()->isSuperAdmin())
                                <div>
                                    <label class="block text-slate-700 font-extrabold mb-1">Fakultas</label>
                                    <select name="fakultas_id" onchange="this.form.submit()" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                        <option value="">Semua Fakultas</option>
                                        @foreach($fakultas as $f)
                                            <option value="{{ $f->id }}" {{ request('fakultas_id') == $f->id ? 'selected' : '' }}>{{ $f->nama_fakultas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div>
                                    <label class="block text-slate-700 font-extrabold mb-1">Fakultas Naungan</label>
                                    <input type="text" readonly value="{{ auth()->user()->fakultas?->nama_fakultas ?? 'Fakultas Anda' }}" class="w-full py-2 px-3 rounded-xl bg-slate-100 border border-slate-200 font-bold text-slate-500 cursor-not-allowed">
                                </div>
                            @endif

                            <!-- Role Filter -->
                            <div>
                                <label class="block text-slate-700 font-extrabold mb-1">Role Akun</label>
                                <select name="role" id="filterRole" onchange="handleRoleChange(this)" class="w-full py-2 px-3 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="">Semua Role</option>
                                    @if(auth()->user()->isSuperAdmin())
                                        <option value="super_admin" {{ strtolower(request('role')) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    @endif
                                    <option value="admin" {{ strtolower(request('role')) === 'admin' ? 'selected' : '' }}>Admin Fakultas</option>
                                    <option value="dosen" {{ strtolower(request('role')) === 'dosen' ? 'selected' : '' }}>Dosen</option>
                                    <option value="mahasiswa" {{ strtolower(request('role')) === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 2: Mahasiswa Filters (Dynamic Hide when Dosen/Admin) -->
                        @php
                            $selectedRoleVal = strtolower(trim(request('role') ?? ''));
                            $isNonMhs = in_array($selectedRoleVal, ['super_admin', 'admin', 'dosen']);
                        @endphp
                        
                        <div id="mhsFiltersRow" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 pt-2 border-t border-slate-100 transition-all duration-200 {{ $isNonMhs ? 'hidden' : '' }}">
                            <div>
                                <label class="block text-slate-600 font-bold mb-1 text-[11px]">Program Kuliah</label>
                                <select name="program_kuliah" {{ $isNonMhs ? 'disabled' : '' }} onchange="this.form.submit()" class="w-full py-1.5 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="">Semua Program</option>
                                    @foreach($availablePrograms as $prog)
                                        <option value="{{ $prog }}" {{ (request('program_kuliah') === $prog || strtolower(request('program_kuliah')) === strtolower($prog) || (in_array(strtolower(request('program_kuliah')), ['reguler', 'reg']) && in_array(strtolower($prog), ['reguler', 'reg']))) ? 'selected' : '' }}>{{ $prog }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-slate-600 font-bold mb-1 text-[11px]">Semester</label>
                                <select name="semester" {{ $isNonMhs ? 'disabled' : '' }} onchange="this.form.submit()" class="w-full py-1.5 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="">Semua Semester</option>
                                    @foreach($availableSemesters as $sem)
                                        <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>Semester {{ $sem }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-slate-600 font-bold mb-1 text-[11px]">Kelas</label>
                                <select name="kelas" {{ $isNonMhs ? 'disabled' : '' }} onchange="this.form.submit()" class="w-full py-1.5 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelases as $kls)
                                        @php $klsVal = is_object($kls) ? $kls->nama_kelas : $kls; @endphp
                                        <option value="{{ $klsVal }}" {{ request('kelas') === $klsVal ? 'selected' : '' }}>Kelas {{ $klsVal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-slate-600 font-bold mb-1 text-[11px]">Status Mahasiswa</label>
                                <select name="status_mahasiswa" {{ $isNonMhs ? 'disabled' : '' }} onchange="this.form.submit()" class="w-full py-1.5 px-3 rounded-xl bg-slate-50 border border-slate-200 font-medium text-slate-700 focus:ring-2 focus:ring-teal-700/30 outline-none cursor-pointer">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status_mahasiswa') === 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                                    <option value="cuti" {{ request('status_mahasiswa') === 'cuti' ? 'selected' : '' }}>🟡 Cuti</option>
                                    <option value="lulus" {{ request('status_mahasiswa') === 'lulus' ? 'selected' : '' }}>🔵 Lulus</option>
                                    <option value="do" {{ request('status_mahasiswa') === 'do' ? 'selected' : '' }}>🔴 Drop Out</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Controls Row -->
                        <div class="flex items-center justify-between pt-2">
                            <div class="flex items-center gap-2">
                                <button type="submit" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-extrabold transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-solid fa-filter text-xs"></i> Terapkan Filter
                                </button>
                                
                                @if(request()->hasAny(['search', 'role', 'program_kuliah', 'semester', 'kelas', 'status_mahasiswa', 'fakultas_id']))
                                    <a href="{{ route('admin.pengguna') }}" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/80 rounded-xl font-bold transition text-center flex items-center gap-1.5 cursor-pointer shadow-xs">
                                        <i class="fa-solid fa-rotate-left"></i> Reset Filter
                                    </a>
                                @endif
                            </div>

                            <p class="text-[11px] text-slate-500 font-medium hidden sm:block">
                                <i class="fa-solid fa-info-circle text-teal-700 mr-1"></i> Filter Role otomatis menyesuaikan opsi akademik yang tersedia.
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Floating Bulk Action Toolbar (Appears when rows are selected) -->
                <div id="bulkToolbar" class="hidden bg-slate-900 text-white border border-slate-800 rounded-2xl p-4 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-3 animate-in fade-in slide-in-from-top-2 duration-200">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-teal-500/20 text-teal-300 font-extrabold flex items-center justify-center text-xs border border-teal-500/30" id="selectedCountBadge">0</span>
                        <div>
                            <p class="font-extrabold text-xs text-white"><span id="selectedCountText">0</span> Pengguna Terpilih</p>
                            <p class="text-[10px] text-slate-400">Pilih tindakan massal yang ingin diterapkan pada pengguna yang ditandai.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 w-full sm:w-auto">
                        <button type="button" onclick="executeBulkPromote()" class="flex-1 sm:flex-initial px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-arrow-up-right-dots"></i> Naik Semester Massal
                        </button>
                        <button type="button" onclick="executeBulkDelete()" class="flex-1 sm:flex-initial px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-trash-can"></i> Hapus Massal
                        </button>
                    </div>
                </div>

                <!-- Main Full-Width Data Table -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full">
                    
                    <!-- Table Action Bar & Header Tools -->
                    <div class="bg-slate-50/70 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-800 border border-teal-200/80 flex items-center justify-center font-bold text-sm shadow-xs">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-sm text-slate-800">Daftar Pengguna Terdaftar</h3>
                                <p class="text-[11px] text-slate-500 font-medium">Total <span class="font-extrabold text-teal-800">{{ $users->total() }}</span> akun pengguna aktif di sistem.</p>
                            </div>
                        </div>

                        <!-- Header Action Buttons -->
                        <div class="flex items-center gap-2 flex-wrap">
                            
                            <!-- Per Page Selector -->
                            <form action="{{ route('admin.pengguna') }}" method="GET" class="flex items-center gap-1.5">
                                @foreach(request()->except(['per_page', 'page']) as $k => $v)
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                @endforeach
                                <span class="text-[11px] font-bold text-slate-500 hidden md:inline">Tampilkan:</span>
                                <select name="per_page" onchange="this.form.submit()" class="py-1.5 px-2.5 rounded-xl bg-white border border-slate-200 font-bold text-xs text-slate-700 outline-none shadow-2xs cursor-pointer">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 Baris</option>
                                    <option value="25" {{ (request('per_page', 25) == 25) ? 'selected' : '' }}>25 Baris</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Baris</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Baris</option>
                                </select>
                            </form>

                            <button type="button" onclick="toggleModal('modal-fitur-auto')" class="px-3 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300/80 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                                <i class="fa-solid fa-circle-question text-teal-700"></i> Panduan
                            </button>
                            <button type="button" onclick="toggleModal('modal-promote-semester')" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                                <i class="fa-solid fa-arrow-up-right-dots"></i> Naik Semester
                            </button>
                            <button type="button" onclick="toggleModal('modal-import-dosen')" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-xl text-xs font-bold transition items-center gap-1.5 shadow-xs hidden sm:flex cursor-pointer">
                                <i class="fa-solid fa-file-import text-teal-700"></i> Import Dosen
                            </button>
                            <button type="button" onclick="toggleModal('modal-import-mahasiswa')" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-xl text-xs font-bold transition items-center gap-1.5 shadow-xs hidden sm:flex cursor-pointer">
                                <i class="fa-solid fa-file-import text-teal-700"></i> Import Mhs
                            </button>
                            <button type="button" onclick="openAddUserModal()" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-extrabold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                                <i class="fa-solid fa-plus text-xs"></i> Tambah User Baru
                            </button>
                        </div>
                    </div>

                    <!-- Table View Container -->
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-xs text-left text-slate-700">
                            
                            <!-- Sortable Table Header -->
                            <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-extrabold text-slate-600 uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-3.5 w-10 text-center">
                                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAllUsers(this)" class="w-4 h-4 rounded border-slate-300 text-teal-700 focus:ring-teal-700 cursor-pointer">
                                    </th>
                                    <th class="px-4 py-3.5 w-12 text-center">NO</th>
                                    
                                    <!-- Sortable Column: Nama Lengkap -->
                                    @php
                                        $currSort = request('sort_by', 'created_at');
                                        $currOrder = strtolower(request('sort_order', 'desc'));
                                        $nextOrder = ($currSort === 'nama' && $currOrder === 'asc') ? 'desc' : 'asc';
                                    @endphp
                                    <th class="px-5 py-3.5">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'sort_order' => $nextOrder]) }}" class="flex items-center gap-1.5 hover:text-teal-800 transition">
                                            <span>NAMA LENGKAP</span>
                                            @if($currSort === 'nama')
                                                <i class="fa-solid fa-arrow-{{ $currOrder === 'asc' ? 'up' : 'down' }}-a-z text-teal-700 font-bold"></i>
                                            @else
                                                <i class="fa-solid fa-sort text-slate-300 text-[10px]"></i>
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sortable Column: NIM / NIP -->
                                    @php
                                        $nextOrderNim = ($currSort === 'nim_nip' && $currOrder === 'asc') ? 'desc' : 'asc';
                                    @endphp
                                    <th class="px-5 py-3.5">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nim_nip', 'sort_order' => $nextOrderNim]) }}" class="flex items-center gap-1.5 hover:text-teal-800 transition">
                                            <span>NIM / NIP / USERNAME</span>
                                            @if($currSort === 'nim_nip')
                                                <i class="fa-solid fa-arrow-{{ $currOrder === 'asc' ? 'up' : 'down' }}-1-9 text-teal-700 font-bold"></i>
                                            @else
                                                <i class="fa-solid fa-sort text-slate-300 text-[10px]"></i>
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sortable Column: Role -->
                                    @php
                                        $nextOrderRole = ($currSort === 'role' && $currOrder === 'asc') ? 'desc' : 'asc';
                                    @endphp
                                    <th class="px-5 py-3.5">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'role', 'sort_order' => $nextOrderRole]) }}" class="flex items-center gap-1.5 hover:text-teal-800 transition">
                                            <span>ROLE AKUN</span>
                                            @if($currSort === 'role')
                                                <i class="fa-solid fa-arrow-{{ $currOrder === 'asc' ? 'up' : 'down' }} text-teal-700 font-bold"></i>
                                            @else
                                                <i class="fa-solid fa-sort text-slate-300 text-[10px]"></i>
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sortable Column: Status Akun -->
                                    @php
                                        $nextOrderStatus = ($currSort === 'status' && $currOrder === 'asc') ? 'desc' : 'asc';
                                    @endphp
                                    <th class="px-5 py-3.5">
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status', 'sort_order' => $nextOrderStatus]) }}" class="flex items-center gap-1.5 hover:text-teal-800 transition">
                                            <span>STATUS AKUN</span>
                                            @if($currSort === 'status')
                                                <i class="fa-solid fa-arrow-{{ $currOrder === 'asc' ? 'up' : 'down' }} text-teal-700 font-bold"></i>
                                            @else
                                                <i class="fa-solid fa-sort text-slate-300 text-[10px]"></i>
                                            @endif
                                        </a>
                                    </th>

                                    <th class="px-5 py-3.5 text-center">AKSI & KEAMANAN</th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody class="divide-y divide-slate-100">
                                @if($users->count() > 0)
                                    @foreach($users as $index => $u)
                                        @php
                                            $nama = $u->role === 'dosen' ? ($u->dosen->nama ?? '-') : ($u->role === 'mahasiswa' ? ($u->mahasiswa->nama_lengkap ?? '-') : $u->username);
                                            $userStatus = strtolower($u->status ?? 'aktif');
                                        @endphp
                                        <tr class="hover:bg-slate-50/80 transition {{ $userStatus === 'nonaktif' ? 'bg-rose-50/30' : '' }}">
                                            
                                            <!-- Checkbox Column -->
                                            <td class="px-4 py-3.5 text-center">
                                                @if(auth()->id() !== $u->id)
                                                    <input type="checkbox" name="ids[]" value="{{ $u->id }}" onchange="updateBulkBar()" class="user-checkbox w-4 h-4 rounded border-slate-300 text-teal-700 focus:ring-teal-700 cursor-pointer">
                                                @else
                                                    <span class="text-slate-300 text-[10px]">&bullet;</span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-3.5 text-center text-slate-400 font-bold font-mono text-xs">
                                                {{ $users->firstItem() + $index }}
                                            </td>

                                            <!-- Nama & Detail -->
                                            <td class="px-5 py-3.5">
                                                <span class="font-extrabold text-slate-900 text-sm block">{{ $nama }}</span>
                                                @if($u->role === 'mahasiswa' && $u->mahasiswa)
                                                    <div class="flex items-center gap-1.5 flex-wrap mt-0.5">
                                                        @php
                                                            $mProg = $u->mahasiswa->program_kuliah ?? 'Reguler';
                                                            $mKlsRaw = strtoupper(trim($u->mahasiswa->kelas ?? ''));
                                                            if (strtolower($mProg) === 'karyawan' || $mKlsRaw === 'KAR' || str_contains($mKlsRaw, 'KARYAWAN')) {
                                                                $mKlsLabel = 'KAR';
                                                            } elseif (str_contains($mKlsRaw, 'REG A') || $mKlsRaw === 'A' || str_ends_with($mKlsRaw, '3A') || str_ends_with($mKlsRaw, '-A')) {
                                                                $mKlsLabel = 'Reg A';
                                                            } elseif (str_contains($mKlsRaw, 'REG B') || $mKlsRaw === 'B' || str_ends_with($mKlsRaw, '3B') || str_ends_with($mKlsRaw, '-B')) {
                                                                $mKlsLabel = 'Reg B';
                                                            } elseif (str_contains($mKlsRaw, 'REG C') || $mKlsRaw === 'C' || str_ends_with($mKlsRaw, '3C') || str_ends_with($mKlsRaw, '-C')) {
                                                                $mKlsLabel = 'Reg C';
                                                            } elseif ($mKlsRaw === 'REG' || $mKlsRaw === 'XI-RR') {
                                                                $mKlsLabel = 'REG';
                                                            } else {
                                                                $mKlsLabel = $u->mahasiswa->kelas;
                                                            }
                                                        @endphp
                                                        <span class="text-[10px] text-slate-500 font-medium">
                                                            <i class="fa-solid fa-graduation-cap text-teal-700 mr-0.5"></i> {{ $mProg }} • Kelas {{ $mKlsLabel }}
                                                            @if($u->mahasiswa->semester)
                                                                • Sem {{ $u->mahasiswa->semester }}
                                                            @endif
                                                        </span>
                                                        @php $st = $u->mahasiswa->status ?? 'aktif'; @endphp
                                                        @if($st === 'aktif')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">Aktif</span>
                                                        @elseif($st === 'cuti')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200 uppercase">Cuti</span>
                                                        @elseif($st === 'lulus')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200 uppercase">Lulus</span>
                                                        @elseif($st === 'do')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200 uppercase">DO</span>
                                                        @endif
                                                    </div>
                                                @elseif($u->role === 'dosen' && $u->dosen)
                                                    @if($u->dosen->jabatan)
                                                        <span class="text-[10px] text-slate-500 block mt-0.5"><i class="fa-solid fa-briefcase text-blue-600 mr-1"></i> {{ $u->dosen->jabatan }}</span>
                                                    @endif
                                                @endif
                                            </td>

                                            <!-- NIM / NIP / Username -->
                                            <td class="px-5 py-3.5 font-mono text-teal-800 font-bold">
                                                <span>{{ $u->username }}</span>
                                                @if($u->role === 'mahasiswa' && $u->mahasiswa)
                                                    @if($u->mahasiswa->prodi)
                                                        <span class="text-[10px] text-slate-500 font-sans block font-medium mt-0.5">{{ $u->mahasiswa->prodi->nama_prodi }}</span>
                                                    @endif
                                                @elseif($u->role === 'dosen' && $u->dosen)
                                                    @if($u->dosen->prodi)
                                                        <span class="text-[10px] text-slate-500 font-sans block font-medium mt-0.5">{{ $u->dosen->prodi->nama_prodi }}</span>
                                                    @endif
                                                @endif
                                            </td>

                                            <!-- Role Badge -->
                                            <td class="px-5 py-3.5">
                                                @if($u->role === 'super_admin')
                                                    <span class="px-2.5 py-1 bg-purple-50 text-purple-800 border border-purple-200 rounded-lg text-[10px] font-extrabold uppercase">Super Admin</span>
                                                @elseif($u->role === 'admin')
                                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-[10px] font-extrabold uppercase">Admin Fakultas</span>
                                                @elseif($u->role === 'dosen')
                                                    <span class="px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-200 rounded-lg text-[10px] font-extrabold uppercase">Dosen</span>
                                                @else
                                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-800 border border-indigo-200 rounded-lg text-[10px] font-extrabold uppercase">Mahasiswa</span>
                                                @endif
                                            </td>

                                            <!-- Status Akun Badge -->
                                            <td class="px-5 py-3.5">
                                                @if($userStatus === 'nonaktif')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200/80">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif / Suspended
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Aksi & Keamanan Buttons -->
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    
                                                    <!-- Edit Button -->
                                                    <button type="button" onclick='editUser(@json($u))' class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-teal-50 hover:text-teal-800 border border-slate-200/80 flex items-center justify-center text-slate-700 transition" title="Edit Data Pengguna">
                                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                    </button>

                                                    <!-- Reset Password Button -->
                                                    <form action="{{ route('admin.pengguna.reset-password', $u->id) }}" method="POST" onsubmit="return confirmAction(event, 'Reset password akun \'{{ $u->username }}\' menjadi \'password\'?', 'Reset Password Akun?');">
                                                        @csrf
                                                        <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-amber-50 hover:text-amber-700 border border-slate-200/80 flex items-center justify-center text-amber-600 transition" title="Reset Password ke Default ('password')">
                                                            <i class="fa-solid fa-key text-xs"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Suspend / Aktifkan Toggle Button -->
                                                    @if(auth()->id() !== $u->id)
                                                        <form action="{{ route('admin.pengguna.toggle-status', $u->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin {{ $userStatus === 'aktif' ? 'nonaktifkan (suspend)' : 'mengaktifkan kembali' }} akun \'{{ $u->username }}\'?', 'Ubah Status Akun?');">
                                                            @csrf
                                                            <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 {{ $userStatus === 'aktif' ? 'hover:bg-amber-50 hover:text-amber-700 text-slate-600' : 'hover:bg-emerald-50 hover:text-emerald-700 text-emerald-600' }} border border-slate-200/80 flex items-center justify-center transition" title="{{ $userStatus === 'aktif' ? 'Nonaktifkan Akun (Suspend)' : 'Aktifkan Kembali Akun' }}">
                                                                <i class="fa-solid {{ $userStatus === 'aktif' ? 'fa-user-slash' : 'fa-user-check' }} text-xs"></i>
                                                            </button>
                                                        </form>

                                                        <!-- Hapus Button -->
                                                        <form action="{{ route('admin.pengguna.delete', $u->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus akun \'{{ $u->username }}\' secara permanen?', 'Hapus Akun Pengguna?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-rose-50 hover:text-rose-700 border border-slate-200/80 flex items-center justify-center text-slate-500 transition" title="Hapus Akun Permanen">
                                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center py-10 text-slate-400 italic">
                                            Pengguna tidak ditemukan. Coba sesuaikan kata kunci pencarian atau reset filter.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer & Pagination -->
                    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-slate-500 font-medium">
                            Menampilkan <span class="font-extrabold text-slate-800">{{ $users->firstItem() ?? 0 }}</span> - <span class="font-extrabold text-slate-800">{{ $users->lastItem() ?? 0 }}</span> dari total <span class="font-extrabold text-slate-800">{{ $users->total() }}</span> Pengguna
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </main>

    <!-- Hidden Forms for Bulk Actions -->
    <form id="bulkDeleteForm" action="{{ route('admin.pengguna.bulk-delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <div id="bulkDeleteInputs"></div>
    </form>

    <form id="bulkPromoteForm" action="{{ route('admin.users.promote') }}" method="POST" class="hidden">
        @csrf
        <div id="bulkPromoteInputs"></div>
    </form>

    <!-- USER MODAL (ADD & EDIT) -->
    <div id="modal-user" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-user-title" class="font-bold text-base text-slate-800">Tambah Pengguna Baru</h3>
                <button onclick="toggleModal('modal-user')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <form id="user-form" action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" id="user-method" name="_method" value="POST">
                
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Lengkap</label>
                    <input type="text" id="user-nama_lengkap" name="nama_lengkap" required placeholder="Masukkan nama..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">NIM / NIP / Username</label>
                    <input type="text" id="user-username_or_nim_nip" name="username_or_nim_nip" required placeholder="Masukkan identitas login..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <div id="password-container">
                    <label class="block text-slate-700 font-bold mb-1">Password</label>
                    <input type="password" id="user-password" name="password" required placeholder="Masukkan password..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <div id="role-container">
                    <label class="block text-slate-700 font-bold mb-1">Role Akun</label>
                    <select name="role" id="user-role" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-bold">
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="admin">Admin Fakultas</option>
                        @if(auth()->user()->isSuperAdmin())
                            <option value="super_admin">Super Admin (Akses Penuh)</option>
                        @endif
                    </select>
                </div>
                <div id="admin-fields" class="hidden space-y-4">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Fakultas Naungan Admin <span class="text-rose-500">*</span></label>
                        @if(auth()->user()->isSuperAdmin())
                            <select name="fakultas_admin" id="user-fakultas_admin" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="fakultas_admin" value="{{ auth()->user()->fakultas_id }}">
                            <input type="text" readonly disabled value="{{ auth()->user()->fakultas?->nama_fakultas ?? 'Fakultas Anda' }}" class="w-full p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-500 font-bold cursor-not-allowed">
                        @endif
                    </div>
                </div>
                <div id="mahasiswa-fields" class="hidden space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Fakultas</label>
                            <select name="fakultas" id="user-fakultas" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="">-- Pilih --</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jurusan</label>
                            <select name="jurusan" id="user-jurusan" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="">-- Pilih --</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="class-container" class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Program Kuliah</label>
                            <select name="program_kuliah" id="user-program_kuliah" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="Reguler">Reguler</option>
                                <option value="Karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Kelas</label>
                            <select name="kelas" id="user-kelas" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelases as $kls)
                                    @php $klsVal = is_object($kls) ? $kls->nama_kelas : $kls; @endphp
                                    <option value="{{ $klsVal }}">{{ $klsVal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Semester</label>
                            <select name="semester" id="user-semester" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="">-- Pilih Semester --</option>
                                @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Status Mahasiswa</label>
                            <select name="status_mahasiswa" id="user-status_mahasiswa" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-bold">
                                <option value="aktif">🟢 Aktif</option>
                                <option value="cuti">🟡 Cuti</option>
                                <option value="lulus">🔵 Lulus</option>
                                <option value="do">🔴 Drop Out</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="dosen-fields" class="hidden space-y-4">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Jabatan (Opsional)</label>
                        <input type="text" name="jabatan" id="user-jabatan" placeholder="Contoh: Ketua Program Studi, Dosen..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Kompetensi Dosen</label>
                        <textarea name="kompetensi" id="user-kompetensi" rows="3" placeholder="Contoh: Pemrograman Web, Jaringan, Data Mining..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none"></textarea>
                    </div>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-user')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-bold shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PANDUAN FITUR OTOMATIS -->
    <div id="modal-fitur-auto" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-3xl w-full max-h-[88vh] flex flex-col overflow-hidden text-left">
            <div class="bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white px-6 py-4.5 flex justify-between items-center flex-shrink-0 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-500/20 border border-teal-400/30 flex items-center justify-center text-teal-300 text-base">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base tracking-tight text-white">Panduan Fitur Otomatisasi Sistem</h3>
                        <p class="text-xs text-teal-300/90 font-medium">Otomatisasi Manajemen Mahasiswa, Dosen & Akademik</p>
                    </div>
                </div>
                <button type="button" onclick="toggleModal('modal-fitur-auto')" class="w-8 h-8 rounded-full bg-slate-800/80 hover:bg-rose-500 text-slate-300 hover:text-white flex items-center justify-center text-sm transition cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="px-6 pt-4 pb-1 bg-slate-50/70 border-b border-slate-200/80 flex-shrink-0">
                <div class="grid grid-cols-3 gap-1.5 p-1 bg-slate-200/80 rounded-2xl text-xs">
                    <button type="button" onclick="switchAutoFiturTab('tab-auto-semester')" id="btn-tab-auto-semester" class="tab-btn-fitur-auto py-2.5 px-3 rounded-xl font-bold transition flex items-center justify-center gap-2 bg-white text-teal-950 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-arrow-up-right-dots text-indigo-600"></i>
                        <span class="truncate">1. Kelola Semester</span>
                    </button>
                    <button type="button" onclick="switchAutoFiturTab('tab-auto-import')" id="btn-tab-auto-import" class="tab-btn-fitur-auto py-2.5 px-3 rounded-xl font-medium text-slate-600 hover:text-slate-900 transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-file-excel text-emerald-600"></i>
                        <span class="truncate">2. Auto-Akun & Excel</span>
                    </button>
                    <button type="button" onclick="switchAutoFiturTab('tab-auto-security')" id="btn-tab-auto-security" class="tab-btn-fitur-auto py-2.5 px-3 rounded-xl font-medium text-slate-600 hover:text-slate-900 transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-shield-halved text-teal-600"></i>
                        <span class="truncate">3. Keamanan & DO</span>
                    </button>
                </div>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-xs flex-1 bg-white">
                <div id="tab-auto-semester" class="tab-content-fitur-auto space-y-3.5">
                    <div class="p-3.5 bg-indigo-50/70 border border-indigo-100 rounded-2xl flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 text-xs">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <p class="text-indigo-950 font-medium text-xs leading-snug">
                            Semua fitur di bawah terintegrasi pada tombol <strong class="text-indigo-900 font-bold">"Naik Semester"</strong> untuk memperbarui data mahasiswa massal dalam hitungan detik.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2">
                            <h4 class="font-bold text-slate-900 text-xs">Kenaikan Semester (+1) Massal</h4>
                            <p class="text-slate-600 text-[11px] leading-relaxed">
                                Menaikkan semester seluruh mahasiswa aktif serentak per periode akademik (Ganjil: 1 Sep / Genap: 1 Feb).
                            </p>
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2">
                            <h4 class="font-bold text-slate-900 text-xs">Otomatisasi Kelulusan (>S8)</h4>
                            <p class="text-slate-600 text-[11px] leading-relaxed">
                                Mahasiswa aktif yang naik melewati batas Semester 8 otomatis berubah status menjadi <b>Lulus</b>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL IMPORT DOSEN -->
    <div id="modal-import-dosen" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-base text-slate-800">Import Data Dosen</h3>
                <button onclick="toggleModal('modal-import-dosen')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.pengguna.import-dosen') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV Dosen</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'dosen') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Dosen</a>
                    </div>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-import-dosen')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-lg font-bold shadow-sm">Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL IMPORT MAHASISWA -->
    <div id="modal-import-mahasiswa" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-base text-slate-800">Import Data Mahasiswa</h3>
                <button onclick="toggleModal('modal-import-mahasiswa')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.pengguna.import-mahasiswa') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV Mahasiswa</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'mahasiswa') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Mahasiswa</a>
                    </div>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-import-mahasiswa')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-lg font-bold shadow-sm">Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL NAIK SEMESTER -->
    <div id="modal-promote-semester" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-base text-slate-800">Naik / Turun Semester Massal</h3>
                <button onclick="toggleModal('modal-promote-semester')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.users.promote') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Tindakan Semester</label>
                    <select name="action" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-bold">
                        <option value="promote">Naikkan +1 Semester (Semester Baru)</option>
                        <option value="rollback">Turunkan -1 Semester (Rollback Error)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Filter Angkatan / Semester Awal (Opsional)</label>
                    <input type="number" name="filter_semester" placeholder="Kosongkan untuk semua semester..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-promote-semester')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold shadow-sm">Proses Semester</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <!-- JavaScript Handlers -->
    <script>
        const allProdis = @json($prodis);

        // Checkbox Select All & Bulk Toolbar Handler
        function toggleSelectAllUsers(master) {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = master.checked;
            });
            updateBulkBar();
        }

        function updateBulkBar() {
            const checkboxes = document.querySelectorAll('.user-checkbox:checked');
            const count = checkboxes.length;
            const bulkToolbar = document.getElementById('bulkToolbar');
            const selectedCountText = document.getElementById('selectedCountText');
            const selectedCountBadge = document.getElementById('selectedCountBadge');

            if (count > 0) {
                bulkToolbar.classList.remove('hidden');
                if (selectedCountText) selectedCountText.innerText = count;
                if (selectedCountBadge) selectedCountBadge.innerText = count;
            } else {
                bulkToolbar.classList.add('hidden');
                const masterCb = document.getElementById('selectAllCheckbox');
                if (masterCb) masterCb.checked = false;
            }
        }

        function executeBulkDelete() {
            const checkboxes = document.querySelectorAll('.user-checkbox:checked');
            if (checkboxes.length === 0) return;

            const inputsContainer = document.getElementById('bulkDeleteInputs');
            inputsContainer.innerHTML = '';
            checkboxes.forEach(cb => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'ids[]';
                hiddenInput.value = cb.value;
                inputsContainer.appendChild(hiddenInput);
            });

            const bulkForm = document.getElementById('bulkDeleteForm');
            confirmAction({ target: bulkForm, preventDefault: () => {}, stopPropagation: () => {} }, `Apakah Anda yakin ingin menghapus ${checkboxes.length} akun pengguna yang dipilih?`, `Hapus ${checkboxes.length} Akun Massal?`);
        }

        function executeBulkPromote() {
            const checkboxes = document.querySelectorAll('.user-checkbox:checked');
            if (checkboxes.length === 0) return;

            const inputsContainer = document.getElementById('bulkPromoteInputs');
            inputsContainer.innerHTML = '';
            checkboxes.forEach(cb => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'ids[]';
                hiddenInput.value = cb.value;
                inputsContainer.appendChild(hiddenInput);
            });

            const bulkForm = document.getElementById('bulkPromoteForm');
            confirmAction({ target: bulkForm, preventDefault: () => {}, stopPropagation: () => {} }, `Apakah Anda yakin ingin menaikkan semester untuk ${checkboxes.length} pengguna terpilih?`, `Naik Semester Massal?`);
        }

        function handleRoleChange(selectEl) {
            const val = (selectEl.value || '').toLowerCase();
            const isNonMhs = ['super_admin', 'admin', 'dosen'].includes(val);
            const mhsRow = document.getElementById('mhsFiltersRow');
            const mhsSelects = document.querySelectorAll('select[name="program_kuliah"], select[name="semester"], select[name="kelas"], select[name="status_mahasiswa"]');
            
            mhsSelects.forEach(sel => {
                if (isNonMhs) {
                    sel.value = '';
                    sel.disabled = true;
                } else {
                    sel.disabled = false;
                }
            });

            if (mhsRow) {
                if (isNonMhs) {
                    mhsRow.classList.add('hidden');
                } else {
                    mhsRow.classList.remove('hidden');
                }
            }
            
            selectEl.form.submit();
        }

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        function openAddUserModal() {
            document.getElementById('modal-user-title').innerText = "Tambah Pengguna Baru";
            document.getElementById('user-form').action = "{{ route('admin.users.store') }}";
            document.getElementById('user-method').value = "POST";
            document.getElementById('password-container').style.display = "block";
            document.getElementById('user-password').required = true;
            document.getElementById('role-container').style.display = "block";
            
            document.getElementById('user-nama_lengkap').value = "";
            document.getElementById('user-username_or_nim_nip').value = "";
            document.getElementById('user-role').value = "dosen";
            
            handleRoleFieldsChange();
            toggleModal('modal-user');
        }

        function handleRoleFieldsChange() {
            const role = document.getElementById('user-role').value;
            const mhsFields = document.getElementById('mahasiswa-fields');
            const dosenFields = document.getElementById('dosen-fields');
            const adminFields = document.getElementById('admin-fields');
            
            if (role === 'mahasiswa') {
                mhsFields.classList.remove('hidden');
                dosenFields.classList.add('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            } else if (role === 'dosen') {
                mhsFields.classList.add('hidden');
                dosenFields.classList.remove('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            } else if (role === 'admin') {
                mhsFields.classList.add('hidden');
                dosenFields.classList.add('hidden');
                if (adminFields) adminFields.classList.remove('hidden');
            } else {
                mhsFields.classList.add('hidden');
                dosenFields.classList.add('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            }
        }

        document.getElementById('user-role').addEventListener('change', handleRoleFieldsChange);

        function filterProdis(fakultasId, selectedProdiId = null) {
            const jurusanSelect = document.getElementById('user-jurusan');
            jurusanSelect.innerHTML = '<option value="">-- Pilih --</option>';
            
            const filtered = allProdis.filter(p => p.fakultas_id == fakultasId);
            filtered.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = p.nama_prodi;
                if (selectedProdiId && p.id == selectedProdiId) {
                    opt.selected = true;
                }
                jurusanSelect.appendChild(opt);
            });
        }

        document.getElementById('user-fakultas').addEventListener('change', function() {
            filterProdis(this.value);
        });

        function editUser(user) {
            document.getElementById('modal-user-title').innerText = "Edit Pengguna";
            
            const updateUrl = `/admin/users/${user.id}`;
            document.getElementById('user-form').action = updateUrl;
            document.getElementById('user-method').value = "PUT";
            
            document.getElementById('password-container').style.display = "none";
            document.getElementById('user-password').required = false;
            document.getElementById('role-container').style.display = "none";
            
            let nama = user.username;
            let id_fakultas = "";
            let id_prodi = "";
            let kelas = "";
            let program_kuliah = "Reguler";
            let semester = "";
            let status_mahasiswa = "aktif";
            let jabatan = "";
            let kompetensi = "";
            
            const adminFields = document.getElementById('admin-fields');

            if (user.role === 'dosen') {
                if (user.dosen) {
                    nama = user.dosen.nama;
                    jabatan = user.dosen.jabatan || "";
                    kompetensi = user.dosen.kompetensi || "";
                }
                document.getElementById('mahasiswa-fields').classList.add('hidden');
                document.getElementById('dosen-fields').classList.remove('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            } else if (user.role === 'mahasiswa') {
                if (user.mahasiswa) {
                    nama = user.mahasiswa.nama_lengkap;
                    id_fakultas = user.mahasiswa.id_fakultas || "";
                    id_prodi = user.mahasiswa.id_prodi || "";
                    kelas = user.mahasiswa.kelas || "";
                    program_kuliah = user.mahasiswa.program_kuliah || "Reguler";
                    semester = user.mahasiswa.semester || "";
                    status_mahasiswa = user.mahasiswa.status || "aktif";
                }
                document.getElementById('mahasiswa-fields').classList.remove('hidden');
                document.getElementById('dosen-fields').classList.add('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            } else if (user.role === 'admin') {
                document.getElementById('mahasiswa-fields').classList.add('hidden');
                document.getElementById('dosen-fields').classList.add('hidden');
                if (adminFields) {
                    adminFields.classList.remove('hidden');
                    const fakAdmin = document.getElementById('user-fakultas_admin');
                    if (fakAdmin) fakAdmin.value = user.fakultas_id || "";
                }
            } else {
                document.getElementById('mahasiswa-fields').classList.add('hidden');
                document.getElementById('dosen-fields').classList.add('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            }
            
            document.getElementById('user-nama_lengkap').value = nama;
            document.getElementById('user-username_or_nim_nip').value = user.username;
            document.getElementById('user-fakultas').value = id_fakultas;
            filterProdis(id_fakultas, id_prodi);
            document.getElementById('user-kelas').value = kelas;
            document.getElementById('user-program_kuliah').value = program_kuliah;
            document.getElementById('user-semester').value = semester;
            document.getElementById('user-status_mahasiswa').value = status_mahasiswa;
            document.getElementById('user-jabatan').value = jabatan;
            document.getElementById('user-kompetensi').value = kompetensi;
            
            toggleModal('modal-user');
        }

        function switchAutoFiturTab(tabId) {
            document.querySelectorAll('.tab-content-fitur-auto').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn-fitur-auto').forEach(btn => {
                btn.classList.remove('bg-white', 'text-teal-950', 'font-bold', 'shadow-xs');
                btn.classList.add('text-slate-600', 'font-medium');
            });
            const target = document.getElementById(tabId);
            if (target) target.classList.remove('hidden');
            const activeBtn = document.getElementById('btn-' + tabId);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-600', 'font-medium');
                activeBtn.classList.add('bg-white', 'text-teal-950', 'font-bold', 'shadow-xs');
            }
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
                        title: 'Memproses Data...',
                        text: 'Sedang memproses permintaan Anda ke sistem.',
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
        });
    </script>
</body>
</html>
