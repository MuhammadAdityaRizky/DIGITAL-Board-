<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akademik - Digital Board</title>
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
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0" x-data="{ activeTab: (window.location.hash ? window.location.hash.replace('#', '') : 'matkul') }">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Manajemen Parameter Akademik</h2>
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
        <div class="flex-grow overflow-auto p-6 space-y-6 w-full">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-850 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm w-full">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm w-full">
                    <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal memproses data:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabs selector -->
            <div class="flex border-b border-slate-200 text-xs font-bold uppercase tracking-wider bg-white px-4 pt-2 rounded-t-xl border-x w-full">
                <button @click="activeTab = 'fakultas'; window.location.hash = 'fakultas'" 
                        :class="activeTab === 'fakultas' ? 'border-teal-700 text-teal-800 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-building"></i>
                    Fakultas
                </button>
                <button @click="activeTab = 'prodi'; window.location.hash = 'prodi'" 
                        :class="activeTab === 'prodi' ? 'border-teal-700 text-teal-800 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Program Studi
                </button>
                <button @click="activeTab = 'kelas'; window.location.hash = 'kelas'" 
                        :class="activeTab === 'kelas' ? 'border-teal-700 text-teal-800 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Kelas
                </button>
                <button @click="activeTab = 'matkul'; window.location.hash = 'matkul'" 
                        :class="activeTab === 'matkul' ? 'border-teal-700 text-teal-800 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-book"></i>
                    Mata Kuliah
                </button>
            </div>

            <!-- Tab Content: FAKULTAS -->
            <div x-show="activeTab === 'fakultas'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 w-full">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Fakultas</h3>
                    <div class="flex items-center gap-2">
                        <button onclick="openModal('modal-import-fakultas')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-file-import"></i> Import Fakultas
                        </button>
                        <button onclick="openModal('modal-add-fakultas')" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-plus"></i> Tambah Fakultas
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto rounded-xl border border-slate-100 text-xs">
                    <table class="w-full text-left text-slate-650">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="p-3">ID</th>
                                <th class="p-3">Nama Fakultas</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($fakultas as $fak)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-3 font-mono text-slate-400">{{ $fak->id }}</td>
                                <td class="p-3 font-bold text-slate-800 text-sm">{{ $fak->nama_fakultas }}</td>
                                <td class="p-3 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <button onclick="openEditFakultasModal({{ $fak->id }}, '{{ addslashes($fak->nama_fakultas) }}')" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1 cursor-pointer"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                        <form action="{{ route('admin.akademik.fakultas.delete', $fak->id) }}" method="POST" onsubmit="return confirmAction(event, 'Semua Prodi dan User terkait akan terpengaruh.', 'Hapus Fakultas?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1 cursor-pointer"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Content: PRODI -->
            <div x-show="activeTab === 'prodi'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 w-full" style="display: none;">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Program Studi / Jurusan</h3>
                    <div class="flex items-center gap-2">
                        <button onclick="openModal('modal-import-prodi')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-file-import"></i> Import Prodi
                        </button>
                        <button onclick="openModal('modal-add-prodi')" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-plus"></i> Tambah Prodi
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto rounded-xl border border-slate-100 text-xs">
                    <table class="w-full text-left text-slate-650">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="p-3">ID</th>
                                <th class="p-3">Program Studi</th>
                                <th class="p-3">Fakultas</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($prodis as $prod)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-3 font-mono text-slate-400">{{ $prod->id }}</td>
                                <td class="p-3 font-bold text-slate-800 text-sm">{{ $prod->nama_prodi }}</td>
                                <td class="p-3 text-slate-500 font-medium">{{ $prod->fakultas->nama_fakultas ?? '-' }}</td>
                                <td class="p-3 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <button onclick="openEditProdiModal({{ $prod->id }}, '{{ addslashes($prod->nama_prodi) }}', {{ $prod->fakultas_id }})" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1 cursor-pointer"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                        <form action="{{ route('admin.akademik.prodi.delete', $prod->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus Prodi ini?', 'Hapus Prodi?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1 cursor-pointer"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab Content: KELAS -->
            <div x-show="activeTab === 'kelas'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 w-full" style="display: none;">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Kelas</h3>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="submitBulkDeleteKelas()" id="btn-bulk-delete-kelas" class="px-3.5 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm hidden cursor-pointer">
                            <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulk-delete-count-kelas">0</span>)
                        </button>
                        <button onclick="openModal('modal-import-kelas')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-file-import"></i> Import Kelas
                        </button>
                        <button onclick="openModal('modal-add-kelas')" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-plus"></i> Tambah Kelas
                        </button>
                    </div>
                </div>
                <form id="bulk-delete-kelas-form" action="{{ route('admin.akademik.kelas.bulk-delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="overflow-x-auto rounded-xl border border-slate-100 text-xs">
                        <table class="w-full text-left text-slate-650">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                <tr>
                                    <th class="p-3 w-10 text-center">
                                        <input type="checkbox" id="select-all-kelas" class="rounded border-slate-300 text-teal-700 focus:ring-teal-700 cursor-pointer">
                                    </th>
                                    <th class="p-3">ID</th>
                                    <th class="p-3">Nama Kelas</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($kelas as $k)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3 text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $k->id }}" class="checkbox-kelas rounded border-slate-300 text-teal-700 focus:ring-teal-700 cursor-pointer">
                                    </td>
                                    <td class="p-3 font-mono text-slate-400">{{ $k->id }}</td>
                                    <td class="p-3 font-bold text-slate-800 text-sm">{{ $k->nama_kelas }}</td>
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <button type="button" onclick="openEditKelasModal({{ $k->id }}, '{{ addslashes($k->nama_kelas) }}')" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1 cursor-pointer"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                            <form id="delete-kelas-{{ $k->id }}" action="{{ url('admin/akademik/kelas') }}/{{ $k->id }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmAction(event, 'Apakah Anda yakin ingin menghapus Kelas ini?', 'Hapus Kelas?')" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1 cursor-pointer"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

    @php
        $groupedProdisAkademik = $prodis->groupBy(function($item) {
            return $item->fakultas->nama_fakultas ?? 'Fakultas Lain / Umum';
        });
    @endphp

            <!-- Tab Content: MATA KULIAH -->
            <div x-show="activeTab === 'matkul'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-4 w-full">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Daftar Mata Kuliah</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola daftar mata kuliah, bobot SKS, pemetaan semester, dan kategori kurikulum.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="openModal('modal-import-matkul')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-file-import"></i> Import Mata Kuliah
                        </button>
                        <button onclick="openModal('modal-add-matkul')" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-plus"></i> Tambah Mata Kuliah
                        </button>
                    </div>
                </div>

                <form id="bulk-delete-matkul-form" action="{{ route('admin.akademik.matkul.bulk-delete') }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                <!-- Multi-Parameter Search & Filter Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-2 pt-1">
                    <div class="relative lg:col-span-4 w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input type="text" 
                               id="filter_matkul_search" 
                               oninput="filterMatkulTable()" 
                               placeholder="Cari nama mata kuliah atau kode..." 
                               class="w-full pl-8 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 text-slate-800 transition">
                    </div>
                    <div class="lg:col-span-3 w-full">
                        <select id="filter_matkul_prodi" onchange="filterMatkulTable()" class="w-full py-2 px-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 text-slate-700 transition cursor-pointer">
                            <option value="">Semua Program Studi</option>
                            <option value="umum">Semua Prodi (Mata Kuliah Umum)</option>
                            @foreach($groupedProdisAkademik as $fakultasName => $items)
                                <optgroup label="{{ $fakultasName }}">
                                    @foreach($items as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="lg:col-span-2 w-full">
                        <select id="filter_matkul_semester" onchange="filterMatkulTable()" class="w-full py-2 px-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 text-slate-700 transition cursor-pointer">
                            <option value="">Semua Semester</option>
                            @for($s=1; $s<=8; $s++)
                                <option value="{{ $s }}">Semester {{ $s }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="lg:col-span-2 w-full">
                        <select id="filter_matkul_kategori" onchange="filterMatkulTable()" class="w-full py-2 px-2.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 text-slate-700 transition cursor-pointer">
                            <option value="">Semua Kategori</option>
                            <option value="wajib">Wajib</option>
                            <option value="pilihan">Pilihan</option>
                            <option value="praktikum lab">Praktikum Lab</option>
                            <option value="teori & praktikum">Teori & Praktikum</option>
                        </select>
                    </div>
                    <div class="lg:col-span-1 w-full flex items-center justify-end">
                        <button type="button" 
                                id="btn_reset_matkul" 
                                onclick="resetMatkulFilter()" 
                                class="hidden w-full py-2 px-3 text-xs text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-lg transition font-bold cursor-pointer text-center">
                            Reset
                        </button>
                    </div>
                </div>

                <!-- Clean & Comprehensive Table -->
                <div class="overflow-x-auto rounded-xl border border-slate-100 text-xs">
                    <table class="w-full text-left text-slate-650">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="p-3 w-10 text-center">
                                    <input type="checkbox" id="select-all-matkul" class="rounded border-slate-300 text-teal-700 focus:ring-teal-700 cursor-pointer">
                                </th>
                                <th class="p-3 w-28">Kode MK</th>
                                <th class="p-3">Nama Mata Kuliah</th>
                                <th class="p-3 text-center w-28">Semester</th>
                                <th class="p-3 text-center w-36">Kategori</th>
                                <th class="p-3">Program Studi</th>
                                <th class="p-3 text-center w-20 whitespace-nowrap">SKS</th>
                                <th class="p-3 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="matkul_table_body">
                            @if(isset($mataKuliahs) && count($mataKuliahs) > 0)
                                @foreach($mataKuliahs as $mk)
                                @php
                                    $kat = $mk->kategori ?: 'Wajib';
                                @endphp
                                <tr class="matkul-row hover:bg-slate-50/50 transition"
                                    data-nama="{{ strtolower($mk->nama_mk) }}"
                                    data-kode="{{ strtolower($mk->kode_mk ?? '') }}"
                                    data-prodi-id="{{ $mk->id_prodi ?? 'umum' }}"
                                    data-prodi-name="{{ strtolower(($mk->prodi->nama_prodi ?? 'semua umum') . ' ' . ($mk->prodi->fakultas->nama_fakultas ?? '')) }}"
                                    data-semester="{{ $mk->semester ?: 1 }}"
                                    data-sks="{{ $mk->sks ?: 3 }}"
                                    data-kategori="{{ strtolower($kat) }}">
                                    <td class="p-3 text-center">
                                        <input type="checkbox" value="{{ $mk->id }}" class="checkbox-matkul rounded border-slate-300 text-teal-700 focus:ring-teal-700 cursor-pointer" data-name="{{ $mk->nama_mk }}">
                                    </td>
                                    <td class="p-3 font-mono text-slate-400 font-bold">{{ $mk->kode_mk ?: '-' }}</td>
                                    <td class="p-3 font-bold text-slate-800 text-sm">{{ $mk->nama_mk }}</td>
                                    <td class="p-3 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold rounded-md">
                                            <i class="fa-solid fa-graduation-cap text-[9px] text-slate-400"></i> Sem {{ $mk->semester ?: 1 }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center whitespace-nowrap">
                                        @if($kat === 'Praktikum Lab')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-teal-50 border border-teal-200 text-teal-800 text-[10px] font-bold rounded-md">
                                                <i class="fa-solid fa-flask text-[9px]"></i> Praktikum Lab
                                            </span>
                                        @elseif($kat === 'Pilihan')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-amber-50 border border-amber-200 text-amber-800 text-[10px] font-bold rounded-md">
                                                <i class="fa-solid fa-star text-[9px]"></i> Pilihan
                                            </span>
                                        @elseif($kat === 'Teori & Praktikum')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-cyan-50 border border-cyan-200 text-cyan-800 text-[10px] font-bold rounded-md">
                                                <i class="fa-solid fa-laptop-code text-[9px]"></i> Teori & Lab
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[10px] font-bold rounded-md">
                                                <i class="fa-solid fa-book-bookmark text-[9px]"></i> Wajib
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($mk->prodi)
                                            <span class="text-slate-800 font-medium">{{ $mk->prodi->nama_prodi }}</span>
                                            @if(isset($mk->prodi->fakultas->nama_fakultas))
                                                <span class="text-[11px] text-slate-400 block">{{ $mk->prodi->fakultas->nama_fakultas }}</span>
                                            @endif
                                        @else
                                            <span class="text-slate-400 italic">Semua Prodi (Mata Kuliah Umum)</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center whitespace-nowrap">
                                        <span class="font-bold text-slate-800 text-xs">{{ $mk->sks ?? 3 }}</span>
                                        <span class="text-slate-400 text-[11px] font-medium ml-0.5">SKS</span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <button type="button" 
                                                    onclick="openEditMatkulModal({{ $mk->id }}, '{{ addslashes($mk->nama_mk) }}', '{{ addslashes($mk->kode_mk ?? '') }}', '{{ $mk->id_prodi ?? '' }}', {{ $mk->sks ?? 3 }}, {{ $mk->semester ?? 1 }}, '{{ addslashes($kat) }}')" 
                                                    class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1 cursor-pointer">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.akademik.matkul.delete', $mk->id) }}" method="POST" onsubmit="return confirmAction(event, 'Mata kuliah ini akan dihapus.', 'Hapus Mata Kuliah?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1 cursor-pointer">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                <tr id="matkul_empty_state" style="display: none;">
                                    <td colspan="8" class="p-8 text-center text-slate-400 italic">
                                        Tidak ada mata kuliah yang cocok dengan filter pencarian.
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-slate-400 italic">Belum ada data mata kuliah.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Info Total Data -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 text-xs border-t border-slate-100" id="matkul_pagination_wrapper">
                    <div class="flex items-center gap-3 text-slate-500">
                        <span>Tampilkan</span>
                        <select id="matkul_per_page" onchange="changeMatkulPerPage()" class="py-1 px-2 border border-slate-200 rounded-lg bg-slate-50 text-xs font-bold text-slate-700 outline-none cursor-pointer">
                            <option value="10">10 Baris</option>
                            <option value="25">25 Baris</option>
                            <option value="50">50 Baris</option>
                            <option value="all">Semua</option>
                        </select>
                        <span id="matkul_info_text" class="font-medium text-slate-600">Menampilkan 0 dari 0 data</span>
                    </div>

                    <div class="flex items-center gap-1" id="matkul_pagination_buttons">
                        <!-- Dynamic pagination buttons rendered by JS -->
                    </div>
                </div>
            </div>

            <!-- FLOATING BULK ACTION TOOLBAR FOR MATA KULIAH -->
            <div id="floating-bulk-matkul" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40 bg-slate-900/90 backdrop-blur-md border border-slate-800 text-white px-5 py-3 rounded-2xl shadow-2xl flex items-center gap-4 transition-all duration-300 opacity-0 translate-y-10 pointer-events-none">
                <div class="flex items-center gap-2 pr-3 border-r border-slate-700">
                    <div class="w-6 h-6 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold text-xs">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-100"><span id="bulk-matkul-count-badge">0</span> Terpilih</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="exportSelectedMatkul()" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-teal-400 border border-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-file-excel"></i> Export Terpilih
                    </button>
                    <button type="button" onclick="submitBulkDeleteMatkul()" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                        <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
                    </button>
                    <button type="button" onclick="deselectAllMatkul()" class="p-1.5 text-slate-400 hover:text-white transition cursor-pointer text-xs ml-1" title="Batal Pilih">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <!-- FAKULTAS MODAL (ADD) -->
    <div id="modal-add-fakultas" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Tambah Fakultas Baru</h4>
                <button type="button" onclick="closeModal('modal-add-fakultas')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.fakultas.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Fakultas</label>
                    <input type="text" name="nama_fakultas" required placeholder="Contoh: Fakultas Teknik" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm">Simpan Fakultas</button>
            </form>
        </div>
    </div>

    <!-- FAKULTAS MODAL (EDIT) -->
    <div id="modal-edit-fakultas" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Edit Fakultas</h4>
                <button type="button" onclick="closeModal('modal-edit-fakultas')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="edit-fakultas-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Fakultas</label>
                    <input type="text" id="edit-fakultas-nama" name="nama_fakultas" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <!-- PRODI MODAL (ADD) -->
    <div id="modal-add-prodi" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Tambah Program Studi Baru</h4>
                <button type="button" onclick="closeModal('modal-add-prodi')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.prodi.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Fakultas Penaung</label>
                    <select name="fakultas_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}">{{ $fak->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Program Studi</label>
                    <input type="text" name="nama_prodi" required placeholder="Contoh: Teknik Informatika" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm">Simpan Program Studi</button>
            </form>
        </div>
    </div>

    <!-- PRODI MODAL (EDIT) -->
    <div id="modal-edit-prodi" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Edit Program Studi</h4>
                <button type="button" onclick="closeModal('modal-edit-prodi')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="edit-prodi-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Fakultas Penaung</label>
                    <select id="edit-prodi-fakultas" name="fakultas_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}">{{ $fak->nama_fakultas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Program Studi</label>
                    <input type="text" id="edit-prodi-nama" name="nama_prodi" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <!-- KELAS MODAL (ADD) -->
    <div id="modal-add-kelas" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-855 font-bold">
                <h4 class="font-bold text-sm">Tambah Kelas Baru</h4>
                <button type="button" onclick="closeModal('modal-add-kelas')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.kelas.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Kelas</label>
                    <input type="text" name="nama_kelas" required placeholder="Contoh: TI-4A" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm">Simpan Kelas</button>
            </form>
        </div>
    </div>

    <!-- KELAS MODAL (EDIT) -->
    <div id="modal-edit-kelas" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-855 font-bold">
                <h4 class="font-bold text-sm">Edit Kelas</h4>
                <button type="button" onclick="closeModal('modal-edit-kelas')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="edit-kelas-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Kelas</label>
                    <input type="text" id="edit-kelas-nama" name="nama_kelas" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <!-- IMPORT MODALS -->
    <!-- FAKULTAS -->
    <div id="modal-import-fakultas" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Import Fakultas</h4>
                <button type="button" onclick="closeModal('modal-import-fakultas')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.fakultas.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'fakultas') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold transition shadow-sm">Import Data</button>
            </form>
        </div>
    </div>

    <!-- PRODI -->
    <div id="modal-import-prodi" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Import Program Studi</h4>
                <button type="button" onclick="closeModal('modal-import-prodi')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.prodi.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'prodi') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold transition shadow-sm">Import Data</button>
            </form>
        </div>
    </div>

    <!-- KELAS IMPORT -->
    <div id="modal-import-kelas" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Import Kelas</h4>
                <button type="button" onclick="closeModal('modal-import-kelas')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.kelas.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'kelas') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold transition shadow-sm">Import Data</button>
            </form>
        </div>
    </div>

    <!-- MATA KULIAH IMPORT -->
    <div id="modal-import-matkul" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850">
                <h4 class="font-bold text-sm">Import Mata Kuliah</h4>
                <button type="button" onclick="closeModal('modal-import-matkul')" class="text-slate-400 hover:text-slate-650 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.matkul.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'matkul') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold transition shadow-sm">Import Data</button>
            </form>
        </div>
    </div>

    @php
        $groupedProdisAkademik = $prodis->groupBy(function($item) {
            return $item->fakultas->nama_fakultas ?? 'Fakultas Lain / Umum';
        });
    @endphp

    <!-- MATKUL MODAL (ADD) -->
    <div id="modal-add-matkul" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850 rounded-t-2xl">
                <h4 class="font-bold text-sm">Tambah Mata Kuliah Baru</h4>
                <button type="button" onclick="closeModal('modal-add-matkul')" class="text-slate-400 hover:text-slate-650 text-base cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ route('admin.akademik.matkul.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Kode MK (Opsional)</label>
                    <input type="text" name="kode_mk" placeholder="Contoh: IF201" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Mata Kuliah <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_mk" required placeholder="Contoh: Pemrograman Web" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Bobot SKS <span class="text-rose-500">*</span></label>
                        <input type="number" name="sks" min="1" max="10" value="3" required placeholder="3" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Semester <span class="text-rose-500">*</span></label>
                        <select name="semester" required class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition cursor-pointer">
                            @for($s=1; $s<=8; $s++)
                                <option value="{{ $s }}">Semester {{ $s }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Kategori Kurikulum <span class="text-rose-500">*</span></label>
                    <select name="kategori" required class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition cursor-pointer">
                        <option value="Wajib">Wajib (Mata Kuliah Utama)</option>
                        <option value="Praktikum Lab">Praktikum Lab (Praktikum Laboratorium)</option>
                        <option value="Teori & Praktikum">Teori & Praktikum</option>
                        <option value="Pilihan">Pilihan (Mata Kuliah Peminatan)</option>
                    </select>
                </div>
                <div class="relative" id="add_prodi_combobox_wrapper">
                    <label class="block text-slate-700 font-bold mb-1">Program Studi</label>
                    <input type="hidden" name="id_prodi" id="add_matkul_id_prodi" value="">
                    <div class="relative flex items-center">
                        <input type="text" 
                               id="add_matkul_prodi_name" 
                               autocomplete="off" 
                               placeholder="Pilih atau cari prodi..." 
                               onclick="openAddProdiDropdown()" 
                               onfocus="openAddProdiDropdown()" 
                               oninput="handleInputAddProdi(this.value)" 
                               class="w-full p-2.5 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none transition cursor-pointer">
                        <button type="button" 
                                onclick="toggleAddProdiDropdown(event)" 
                                tabindex="-1" 
                                class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                            <i id="add_prodi_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                    </div>

                    <!-- Dropdown Menu for Add Matkul Prodi -->
                    <div id="add_prodi_dropdown_menu" 
                         class="hidden absolute z-50 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-2xl p-2 max-h-52 overflow-y-auto custom-scrollbar flex flex-col space-y-1" 
                         style="background-color: #ffffff !important;">
                        <div class="relative shrink-0 mb-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <input type="text" 
                                   id="add_prodi_search_input" 
                                   oninput="filterAddProdiList(this.value)" 
                                   placeholder="Cari prodi / fakultas..." 
                                   autocomplete="off" 
                                   class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                        </div>
                        <div class="add-prodi-item-option px-2.5 py-1.5 text-xs text-slate-600 rounded-lg hover:bg-slate-100 cursor-pointer transition flex items-center justify-between" 
                             data-id="" 
                             data-name="-- Semua / Umum --" 
                             data-search="semua umum all default" 
                             onclick="selectAddProdiItem('', '-- Semua / Umum --')">
                            <span class="font-medium italic text-slate-500">-- Semua / Umum --</span>
                            <span class="text-[10px] text-slate-400">Default</span>
                        </div>
                        @foreach($groupedProdisAkademik as $fakultasName => $items)
                            <div class="add-prodi-group-header px-2 pt-2 pb-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 border-t border-slate-100 mt-1">
                                <i class="fa-solid fa-building-columns text-teal-600 text-[10px]"></i>
                                <span>{{ $fakultasName }}</span>
                            </div>
                            @foreach($items as $p)
                                <div class="add-prodi-item-option px-2.5 py-1.5 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                     data-id="{{ $p->id }}" 
                                     data-name="{{ $p->nama_prodi }}" 
                                     data-search="{{ strtolower($p->nama_prodi . ' ' . $fakultasName) }}" 
                                     onclick="selectAddProdiItem('{{ $p->id }}', '{{ addslashes($p->nama_prodi) }}')">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <i class="fa-solid fa-check opacity-0 group-hover:opacity-100 text-teal-600 text-[10px] shrink-0"></i>
                                        <span class="font-semibold truncate">{{ $p->nama_prodi }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                        <div id="add_prodi_no_results" class="hidden px-3 py-2 text-xs text-slate-400 italic text-center">
                            Program studi tidak ditemukan.
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm cursor-pointer">Simpan Mata Kuliah</button>
            </form>
        </div>
    </div>

    <!-- MATKUL MODAL (EDIT) -->
    <div id="modal-edit-matkul" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-850 rounded-t-2xl">
                <h4 class="font-bold text-sm">Edit Mata Kuliah</h4>
                <button type="button" onclick="closeModal('modal-edit-matkul')" class="text-slate-400 hover:text-slate-650 text-base cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="edit-matkul-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Kode MK (Opsional)</label>
                    <input type="text" id="edit-matkul-kode" name="kode_mk" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Nama Mata Kuliah <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit-matkul-nama" name="nama_mk" required class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Bobot SKS <span class="text-rose-500">*</span></label>
                        <input type="number" id="edit-matkul-sks" name="sks" min="1" max="10" required placeholder="Contoh: 3" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Semester <span class="text-rose-500">*</span></label>
                        <select id="edit-matkul-semester" name="semester" required class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition cursor-pointer">
                            @for($s=1; $s<=8; $s++)
                                <option value="{{ $s }}">Semester {{ $s }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Kategori Kurikulum <span class="text-rose-500">*</span></label>
                    <select id="edit-matkul-kategori" name="kategori" required class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition cursor-pointer">
                        <option value="Wajib">Wajib (Mata Kuliah Utama)</option>
                        <option value="Praktikum Lab">Praktikum Lab (Praktikum Laboratorium)</option>
                        <option value="Teori & Praktikum">Teori & Praktikum</option>
                        <option value="Pilihan">Pilihan (Mata Kuliah Peminatan)</option>
                    </select>
                </div>
                <div class="relative" id="edit_prodi_combobox_wrapper">
                    <label class="block text-slate-700 font-bold mb-1">Program Studi</label>
                    <input type="hidden" id="edit-matkul-prodi" name="id_prodi" value="">
                    <div class="relative flex items-center">
                        <input type="text" 
                               id="edit_matkul_prodi_name" 
                               autocomplete="off" 
                               placeholder="Pilih atau cari prodi..." 
                               onclick="openEditProdiDropdown()" 
                               onfocus="openEditProdiDropdown()" 
                               oninput="handleInputEditProdi(this.value)" 
                               class="w-full p-2.5 pr-8 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-800 text-xs focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none transition cursor-pointer">
                        <button type="button" 
                                onclick="toggleEditProdiDropdown(event)" 
                                tabindex="-1" 
                                class="absolute right-2.5 p-1 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                            <i id="edit_prodi_chevron_icon" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                    </div>

                    <!-- Dropdown Menu for Edit Matkul Prodi -->
                    <div id="edit_prodi_dropdown_menu" 
                         class="hidden absolute z-50 left-0 right-0 mt-1 bg-white border border-slate-200 rounded-xl shadow-2xl p-2 max-h-52 overflow-y-auto custom-scrollbar flex flex-col space-y-1" 
                         style="background-color: #ffffff !important;">
                        <div class="relative shrink-0 mb-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-xs">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <input type="text" 
                                   id="edit_prodi_search_input" 
                                   oninput="filterEditProdiList(this.value)" 
                                   placeholder="Cari prodi / fakultas..." 
                                   autocomplete="off" 
                                   class="w-full pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                        </div>
                        <div class="edit-prodi-item-option px-2.5 py-1.5 text-xs text-slate-600 rounded-lg hover:bg-slate-100 cursor-pointer transition flex items-center justify-between" 
                             data-id="" 
                             data-name="-- Semua / Umum --" 
                             data-search="semua umum all default" 
                             onclick="selectEditProdiItem('', '-- Semua / Umum --')">
                            <span class="font-medium italic text-slate-500">-- Semua / Umum --</span>
                            <span class="text-[10px] text-slate-400">Default</span>
                        </div>
                        @foreach($groupedProdisAkademik as $fakultasName => $items)
                            <div class="edit-prodi-group-header px-2 pt-2 pb-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1 border-t border-slate-100 mt-1">
                                <i class="fa-solid fa-building-columns text-teal-600 text-[10px]"></i>
                                <span>{{ $fakultasName }}</span>
                            </div>
                            @foreach($items as $p)
                                <div class="edit-prodi-item-option px-2.5 py-1.5 text-xs text-slate-700 rounded-lg hover:bg-teal-50 hover:text-teal-900 cursor-pointer transition flex items-center justify-between group" 
                                     data-id="{{ $p->id }}" 
                                     data-name="{{ $p->nama_prodi }}" 
                                     data-search="{{ strtolower($p->nama_prodi . ' ' . $fakultasName) }}" 
                                     onclick="selectEditProdiItem('{{ $p->id }}', '{{ addslashes($p->nama_prodi) }}')">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <i class="fa-solid fa-check opacity-0 group-hover:opacity-100 text-teal-600 text-[10px] shrink-0"></i>
                                        <span class="font-semibold truncate">{{ $p->nama_prodi }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                        <div id="edit_prodi_no_results" class="hidden px-3 py-2 text-xs text-slate-400 italic text-center">
                            Program studi tidak ditemukan.
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm cursor-pointer">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            if (id === 'modal-add-matkul') {
                const addProdiId = document.getElementById('add_matkul_id_prodi');
                const addProdiName = document.getElementById('add_matkul_prodi_name');
                if (addProdiId) addProdiId.value = '';
                if (addProdiName) addProdiName.value = '-- Semua / Umum --';
                closeAddProdiDropdown();
            }
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            if (id === 'modal-add-matkul') closeAddProdiDropdown();
            if (id === 'modal-edit-matkul') closeEditProdiDropdown();
            document.getElementById(id).classList.add('hidden');
        }
        
        function openEditFakultasModal(id, nama) {
            document.getElementById('edit-fakultas-form').action = `/admin/akademik/fakultas/${id}`;
            document.getElementById('edit-fakultas-nama').value = nama;
            openModal('modal-edit-fakultas');
        }

        function openEditProdiModal(id, nama, fakultasId) {
            document.getElementById('edit-prodi-form').action = `/admin/akademik/prodi/${id}`;
            document.getElementById('edit-prodi-nama').value = nama;
            document.getElementById('edit-prodi-fakultas').value = fakultasId;
            openModal('modal-edit-prodi');
        }

        function openEditKelasModal(id, nama) {
            document.getElementById('edit-kelas-form').action = `/admin/akademik/kelas/${id}`;
            document.getElementById('edit-kelas-nama').value = nama;
            openModal('modal-edit-kelas');
        }

        function openEditMatkulModal(id, nama, kode, prodiId, sks, semester, kategori) {
            document.getElementById('edit-matkul-form').action = `/admin/akademik/matkul/${id}`;
            document.getElementById('edit-matkul-nama').value = nama;
            document.getElementById('edit-matkul-kode').value = kode;
            document.getElementById('edit-matkul-sks').value = sks || 3;
            document.getElementById('edit-matkul-semester').value = semester || 1;
            document.getElementById('edit-matkul-kategori').value = kategori || 'Wajib';
            document.getElementById('edit-matkul-prodi').value = prodiId || '';
            
            const matchedOption = document.querySelector(`.edit-prodi-item-option[data-id="${prodiId}"]`);
            if (matchedOption && prodiId) {
                document.getElementById('edit_matkul_prodi_name').value = matchedOption.getAttribute('data-name');
            } else {
                document.getElementById('edit_matkul_prodi_name').value = '-- Semua / Umum --';
            }

            closeEditProdiDropdown();
            openModal('modal-edit-matkul');
        }

        // ==========================================
        // COMBOBOX LOGIC FOR MATA KULIAH (ADD & EDIT)
        // ==========================================
        function openAddProdiDropdown() {
            closeEditProdiDropdown();
            const menu = document.getElementById('add_prodi_dropdown_menu');
            const icon = document.getElementById('add_prodi_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeAddProdiDropdown() {
            const menu = document.getElementById('add_prodi_dropdown_menu');
            const icon = document.getElementById('add_prodi_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleAddProdiDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('add_prodi_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openAddProdiDropdown();
                document.getElementById('add_prodi_search_input')?.focus();
            } else {
                closeAddProdiDropdown();
            }
        }

        function filterAddProdiList(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.add-prodi-item-option');
            const headers = document.querySelectorAll('.add-prodi-group-header');
            const noResults = document.getElementById('add_prodi_no_results');
            let count = 0;
            items.forEach(item => {
                const s = (item.getAttribute('data-search') || '').toLowerCase();
                if (s.includes(q)) {
                    item.style.display = '';
                    count++;
                } else {
                    item.style.display = 'none';
                }
            });
            headers.forEach(h => {
                h.style.display = (q === '') ? '' : 'none';
            });
            if (noResults) noResults.style.display = (count === 0 && items.length > 0) ? 'block' : 'none';
        }

        function selectAddProdiItem(id, name) {
            document.getElementById('add_matkul_id_prodi').value = id;
            document.getElementById('add_matkul_prodi_name').value = name;
            closeAddProdiDropdown();
        }

        function handleInputAddProdi(val) {
            openAddProdiDropdown();
            const s = document.getElementById('add_prodi_search_input');
            if (s) s.value = val;
            filterAddProdiList(val);
        }

        function openEditProdiDropdown() {
            closeAddProdiDropdown();
            const menu = document.getElementById('edit_prodi_dropdown_menu');
            const icon = document.getElementById('edit_prodi_chevron_icon');
            if (menu) menu.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        function closeEditProdiDropdown() {
            const menu = document.getElementById('edit_prodi_dropdown_menu');
            const icon = document.getElementById('edit_prodi_chevron_icon');
            if (menu) menu.classList.add('hidden');
            if (icon) icon.classList.remove('rotate-180');
        }

        function toggleEditProdiDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('edit_prodi_dropdown_menu');
            if (menu && menu.classList.contains('hidden')) {
                openEditProdiDropdown();
                document.getElementById('edit_prodi_search_input')?.focus();
            } else {
                closeEditProdiDropdown();
            }
        }

        function filterEditProdiList(query) {
            const q = (query || '').toLowerCase().trim();
            const items = document.querySelectorAll('.edit-prodi-item-option');
            const headers = document.querySelectorAll('.edit-prodi-group-header');
            const noResults = document.getElementById('edit_prodi_no_results');
            let count = 0;
            items.forEach(item => {
                const s = (item.getAttribute('data-search') || '').toLowerCase();
                if (s.includes(q)) {
                    item.style.display = '';
                    count++;
                } else {
                    item.style.display = 'none';
                }
            });
            headers.forEach(h => {
                h.style.display = (q === '') ? '' : 'none';
            });
            if (noResults) noResults.style.display = (count === 0 && items.length > 0) ? 'block' : 'none';
        }

        function selectEditProdiItem(id, name) {
            document.getElementById('edit-matkul-prodi').value = id;
            document.getElementById('edit_matkul_prodi_name').value = name;
            closeEditProdiDropdown();
        }

        function handleInputEditProdi(val) {
            openEditProdiDropdown();
            const s = document.getElementById('edit_prodi_search_input');
            if (s) s.value = val;
            filterEditProdiList(val);
        }

        document.addEventListener('click', function(e) {
            const addW = document.getElementById('add_prodi_combobox_wrapper');
            if (addW && !addW.contains(e.target)) {
                closeAddProdiDropdown();
            }
            const editW = document.getElementById('edit_prodi_combobox_wrapper');
            if (editW && !editW.contains(e.target)) {
                closeEditProdiDropdown();
            }
        });

        // Bulk Delete Logic for Kelas
        const selectAllKelas = document.getElementById('select-all-kelas');
        const checkboxKelas = document.querySelectorAll('.checkbox-kelas');
        const btnBulkDeleteKelas = document.getElementById('btn-bulk-delete-kelas');
        const bulkDeleteCountKelas = document.getElementById('bulk-delete-count-kelas');

        function updateBulkDeleteBtnKelas() {
            const checkedCount = document.querySelectorAll('.checkbox-kelas:checked').length;
            if(checkedCount > 0) {
                btnBulkDeleteKelas.classList.remove('hidden');
                bulkDeleteCountKelas.innerText = checkedCount;
            } else {
                btnBulkDeleteKelas.classList.add('hidden');
            }
        }

        if(selectAllKelas) {
            selectAllKelas.addEventListener('change', function() {
                checkboxKelas.forEach(cb => {
                    cb.checked = selectAllKelas.checked;
                });
                updateBulkDeleteBtnKelas();
            });
        }

        checkboxKelas.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = document.querySelectorAll('.checkbox-kelas:checked').length === checkboxKelas.length;
                selectAllKelas.checked = allChecked;
                updateBulkDeleteBtnKelas();
            });
        });

        function submitBulkDeleteKelas() {
            Swal.fire({
                title: 'Hapus Kelas Terpilih?',
                text: 'Apakah Anda yakin ingin menghapus kelas yang dipilih?',
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
                    const form = document.getElementById('bulk-delete-kelas-form');
                    if (form) {
                        form.dataset.confirmed = "true";
                        form.submit();
                    }
                }
            });
        }

        // ==========================================
        // BULK ACTION TOOLBAR & LOGIC FOR MATA KULIAH
        // ==========================================
        const selectAllMatkul = document.getElementById('select-all-matkul');
        const floatingMatkulBar = document.getElementById('floating-bulk-matkul');
        const bulkMatkulBadge = document.getElementById('bulk-matkul-count-badge');

        function updateBulkDeleteBtnMatkul() {
            const checkedBoxes = document.querySelectorAll('.checkbox-matkul:checked');
            const checkedCount = checkedBoxes.length;

            if (floatingMatkulBar && bulkMatkulBadge) {
                bulkMatkulBadge.innerText = checkedCount;
                if (checkedCount > 0) {
                    floatingMatkulBar.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');
                    floatingMatkulBar.classList.add('opacity-100', 'translate-y-0');
                } else {
                    floatingMatkulBar.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
                    floatingMatkulBar.classList.remove('opacity-100', 'translate-y-0');
                }
            }
        }

        function deselectAllMatkul() {
            document.querySelectorAll('.checkbox-matkul').forEach(cb => cb.checked = false);
            if (selectAllMatkul) selectAllMatkul.checked = false;
            updateBulkDeleteBtnMatkul();
        }

        function exportSelectedMatkul() {
            const checkedBoxes = document.querySelectorAll('.checkbox-matkul:checked');
            if (checkedBoxes.length === 0) return;

            let csvContent = "data:text/csv;charset=utf-8,ID,Kode MK,Nama Mata Kuliah\n";
            checkedBoxes.forEach(cb => {
                const row = cb.closest('tr');
                const kode = row?.children[1]?.innerText?.trim() || '-';
                const nama = cb.getAttribute('data-name') || row?.children[2]?.innerText?.trim() || '';
                csvContent += `"${cb.value}","${kode}","${nama.replace(/"/g, '""')}"\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `export_mata_kuliah_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        if (selectAllMatkul) {
            selectAllMatkul.addEventListener('change', function() {
                const rows = document.querySelectorAll('.matkul-row');
                rows.forEach(row => {
                    if (row.style.display !== 'none') {
                        const cb = row.querySelector('.checkbox-matkul');
                        if (cb) cb.checked = selectAllMatkul.checked;
                    }
                });
                updateBulkDeleteBtnMatkul();
            });
        }

        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('checkbox-matkul')) {
                const visibleCheckboxes = Array.from(document.querySelectorAll('.matkul-row'))
                    .filter(r => r.style.display !== 'none')
                    .map(r => r.querySelector('.checkbox-matkul'))
                    .filter(Boolean);
                const allChecked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb => cb.checked);
                if (selectAllMatkul) selectAllMatkul.checked = allChecked;
                updateBulkDeleteBtnMatkul();
            }
        });

        function submitBulkDeleteMatkul() {
            const checkedBoxes = document.querySelectorAll('.checkbox-matkul:checked');
            if (checkedBoxes.length === 0) return;

            Swal.fire({
                title: 'Hapus Mata Kuliah Terpilih?',
                text: `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} mata kuliah yang dipilih?`,
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
                    const form = document.getElementById('bulk-delete-matkul-form');
                    if (form) {
                        form.innerHTML = '';
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

                        checkedBoxes.forEach(cb => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = cb.value;
                            form.appendChild(input);
                        });

                        form.dataset.confirmed = "true";
                        form.submit();
                    }
                }
            });
        }

        // ==========================================
        // REALTIME FILTER & PAGINATION FOR MATA KULIAH
        // ==========================================
        let matkulCurrentPage = 1;
        let matkulPerPage = 10;
        let filteredMatkulRows = [];

        function filterMatkulTable() {
            const search = (document.getElementById('filter_matkul_search')?.value || '').toLowerCase().trim();
            const prodi = document.getElementById('filter_matkul_prodi')?.value || '';
            const semester = document.getElementById('filter_matkul_semester')?.value || '';
            const kategori = (document.getElementById('filter_matkul_kategori')?.value || '').toLowerCase();

            const rows = Array.from(document.querySelectorAll('.matkul-row'));
            const emptyState = document.getElementById('matkul_empty_state');
            const resetBtn = document.getElementById('btn_reset_matkul');

            filteredMatkulRows = rows.filter(row => {
                const rowNama = row.getAttribute('data-nama') || '';
                const rowKode = row.getAttribute('data-kode') || '';
                const rowProdiId = row.getAttribute('data-prodi-id') || '';
                const rowProdiName = row.getAttribute('data-prodi-name') || '';
                const rowSemester = row.getAttribute('data-semester') || '1';
                const rowKategori = row.getAttribute('data-kategori') || 'wajib';

                const matchSearch = !search || rowNama.includes(search) || rowKode.includes(search) || rowProdiName.includes(search);
                const matchProdi = !prodi || (prodi === 'umum' ? rowProdiId === 'umum' : rowProdiId === prodi);
                const matchSemester = !semester || rowSemester === semester;
                const matchKategori = !kategori || rowKategori === kategori;

                return matchSearch && matchProdi && matchSemester && matchKategori;
            });

            // Hide all rows initially
            rows.forEach(r => r.style.display = 'none');

            if (emptyState) {
                emptyState.style.display = (filteredMatkulRows.length === 0 && rows.length > 0) ? '' : 'none';
            }

            if (resetBtn) {
                if (search || prodi || semester || kategori) {
                    resetBtn.classList.remove('hidden');
                } else {
                    resetBtn.classList.add('hidden');
                }
            }

            matkulCurrentPage = 1;
            renderMatkulPagination();
        }

        function changeMatkulPerPage() {
            const val = document.getElementById('matkul_per_page')?.value || '10';
            matkulPerPage = (val === 'all') ? 999999 : parseInt(val);
            matkulCurrentPage = 1;
            renderMatkulPagination();
        }

        function renderMatkulPagination() {
            const total = filteredMatkulRows.length;
            const perPage = matkulPerPage;
            const totalPages = Math.ceil(total / perPage) || 1;

            if (matkulCurrentPage > totalPages) matkulCurrentPage = totalPages;

            const startIdx = (matkulCurrentPage - 1) * perPage;
            const endIdx = (perPage === 999999) ? total : Math.min(startIdx + perPage, total);

            // Hide all rows, show slice
            const allRows = document.querySelectorAll('.matkul-row');
            allRows.forEach(r => r.style.display = 'none');

            for (let i = startIdx; i < endIdx; i++) {
                if (filteredMatkulRows[i]) {
                    filteredMatkulRows[i].style.display = '';
                }
            }

            // Update Info Text
            const infoText = document.getElementById('matkul_info_text');
            if (infoText) {
                if (total === 0) {
                    infoText.innerText = 'Menampilkan 0 dari 0 data mata kuliah';
                } else {
                    infoText.innerText = `Menampilkan ${startIdx + 1} - ${endIdx} dari ${total} data mata kuliah`;
                }
            }

            // Render Pagination Buttons
            const btnContainer = document.getElementById('matkul_pagination_buttons');
            if (btnContainer) {
                btnContainer.innerHTML = '';
                if (totalPages <= 1) return;

                // Prev Button
                const prevBtn = document.createElement('button');
                prevBtn.type = 'button';
                prevBtn.className = `px-2.5 py-1 text-xs font-bold rounded-lg border transition ${matkulCurrentPage === 1 ? 'text-slate-300 border-slate-200 cursor-not-allowed' : 'text-slate-700 hover:bg-slate-100 border-slate-200 cursor-pointer'}`;
                prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i>';
                prevBtn.disabled = (matkulCurrentPage === 1);
                prevBtn.onclick = () => { if (matkulCurrentPage > 1) { matkulCurrentPage--; renderMatkulPagination(); } };
                btnContainer.appendChild(prevBtn);

                // Page numbers
                for (let p = 1; p <= totalPages; p++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.type = 'button';
                    pageBtn.className = `px-2.5 py-1 text-xs font-bold rounded-lg border transition ${p === matkulCurrentPage ? 'bg-teal-800 text-white border-teal-800 shadow-xs' : 'text-slate-700 hover:bg-slate-100 border-slate-200 cursor-pointer'}`;
                    pageBtn.innerText = p;
                    pageBtn.onclick = () => { matkulCurrentPage = p; renderMatkulPagination(); };
                    btnContainer.appendChild(pageBtn);
                }

                // Next Button
                const nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.className = `px-2.5 py-1 text-xs font-bold rounded-lg border transition ${matkulCurrentPage === totalPages ? 'text-slate-300 border-slate-200 cursor-not-allowed' : 'text-slate-700 hover:bg-slate-100 border-slate-200 cursor-pointer'}`;
                nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right text-[10px]"></i>';
                nextBtn.disabled = (matkulCurrentPage === totalPages);
                nextBtn.onclick = () => { if (matkulCurrentPage < totalPages) { matkulCurrentPage++; renderMatkulPagination(); } };
                btnContainer.appendChild(nextBtn);
            }

            // Sync select-all checkbox
            const visibleCheckboxes = filteredMatkulRows.slice(startIdx, endIdx).map(r => r.querySelector('.checkbox-matkul')).filter(Boolean);
            if (selectAllMatkul) {
                selectAllMatkul.checked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb => cb.checked);
            }
            updateBulkDeleteBtnMatkul();
        }

        function resetMatkulFilter() {
            const search = document.getElementById('filter_matkul_search');
            const prodi = document.getElementById('filter_matkul_prodi');
            const semester = document.getElementById('filter_matkul_semester');
            const kategori = document.getElementById('filter_matkul_kategori');
            if (search) search.value = '';
            if (prodi) prodi.value = '';
            if (semester) semester.value = '';
            if (kategori) kategori.value = '';
            filterMatkulTable();
        }

        // Initialize table filtering & pagination on DOM load
        document.addEventListener('DOMContentLoaded', function() {
            filterMatkulTable();
        });

        function resetMatkulFilter() {
            const search = document.getElementById('filter_matkul_search');
            const prodi = document.getElementById('filter_matkul_prodi');
            if (search) search.value = '';
            if (prodi) prodi.value = '';
            filterMatkulTable();
        }
    </script>

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
        function showImportLoading(form) {
            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput && fileInput.files && fileInput.files.length === 0) {
                return true;
            }
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-1"></i> Memproses...';
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            }
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
    </script>

    <!-- AlpineJS for Simple Tabs -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>




