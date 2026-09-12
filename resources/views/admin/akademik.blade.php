<!DOCTYPE html>
<html lang="en">
<head>
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
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
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
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-850 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-5xl">
                    <i class="fa-solid fa-circle-check class-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-5xl">
                    <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal memproses data:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabs selector -->
            <div class="flex border-b border-slate-200 text-xs font-bold uppercase tracking-wider bg-white px-4 pt-2 rounded-t-xl border-x max-w-5xl">
                <button @click="activeTab = 'fakultas'; window.location.hash = 'fakultas'" 
                        :class="activeTab === 'fakultas' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-building"></i>
                    Fakultas
                </button>
                <button @click="activeTab = 'prodi'; window.location.hash = 'prodi'" 
                        :class="activeTab === 'prodi' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Program Studi
                </button>
                <button @click="activeTab = 'kelas'; window.location.hash = 'kelas'" 
                        :class="activeTab === 'kelas' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Kelas
                </button>
                <button @click="activeTab = 'matkul'; window.location.hash = 'matkul'" 
                        :class="activeTab === 'matkul' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-book"></i>
                    Mata Kuliah
                </button>
            </div>

            <!-- Tab Content: FAKULTAS -->
            <div x-show="activeTab === 'fakultas'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 max-w-5xl">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Fakultas</h3>
                    <div class="flex items-center gap-2">
                        <button onclick="openModal('modal-import-fakultas')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-file-import"></i> Import Fakultas
                        </button>
                        <button onclick="openModal('modal-add-fakultas')" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
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
                                        <button onclick="openEditFakultasModal({{ $fak->id }}, '{{ addslashes($fak->nama_fakultas) }}')" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                        <form action="{{ route('admin.akademik.fakultas.delete', $fak->id) }}" method="POST" onsubmit="return confirmAction(event, 'Semua Prodi dan User terkait akan terpengaruh.', 'Hapus Fakultas?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1"><i class="fa-solid fa-trash-can"></i> Hapus</button>
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
            <div x-show="activeTab === 'prodi'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 max-w-5xl" style="display: none;">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Program Studi / Jurusan</h3>
                    <div class="flex items-center gap-2">
                        <button onclick="openModal('modal-import-prodi')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-file-import"></i> Import Prodi
                        </button>
                        <button onclick="openModal('modal-add-prodi')" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
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
                                        <button onclick="openEditProdiModal({{ $prod->id }}, '{{ addslashes($prod->nama_prodi) }}', {{ $prod->fakultas_id }})" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                        <form action="{{ route('admin.akademik.prodi.delete', $prod->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus Prodi ini?', 'Hapus Prodi?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1"><i class="fa-solid fa-trash-can"></i> Hapus</button>
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
            <div x-show="activeTab === 'kelas'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 max-w-5xl" style="display: none;">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Kelas</h3>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="submitBulkDeleteKelas()" id="btn-bulk-delete-kelas" class="px-3.5 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm hidden">
                            <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="bulk-delete-count-kelas">0</span>)
                        </button>
                        <button onclick="openModal('modal-import-kelas')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-file-import"></i> Import Kelas
                        </button>
                        <button onclick="openModal('modal-add-kelas')" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
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
                                        <input type="checkbox" id="select-all-kelas" class="rounded border-slate-300 text-teal-700 focus:ring-teal-700">
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
                                        <input type="checkbox" name="ids[]" value="{{ $k->id }}" class="checkbox-kelas rounded border-slate-300 text-teal-700 focus:ring-teal-700">
                                    </td>
                                    <td class="p-3 font-mono text-slate-400">{{ $k->id }}</td>
                                    <td class="p-3 font-bold text-slate-800 text-sm">{{ $k->nama_kelas }}</td>
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <button type="button" onclick="openEditKelasModal({{ $k->id }}, '{{ addslashes($k->nama_kelas) }}')" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                            <form id="delete-kelas-{{ $k->id }}" action="{{ url('admin/akademik/kelas') }}/{{ $k->id }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmAction(event, 'Apakah Anda yakin ingin menghapus Kelas ini?', 'Hapus Kelas?')" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
                @foreach($kelas as $k)
                <form id="delete-kelas-{{ $k->id }}" action="{{ route('admin.akademik.kelas.delete', $k->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach
            </div>

    @php
        $groupedProdisAkademik = $prodis->groupBy(function($item) {
            return $item->fakultas->nama_fakultas ?? 'Fakultas Lain / Umum';
        });
    @endphp

            <!-- Tab Content: MATA KULIAH -->
            <div x-show="activeTab === 'matkul'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-4 max-w-5xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Daftar Mata Kuliah</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola daftar mata kuliah dan pemetaan program studi.</p>
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

                <!-- Minimalist Search & Filter Bar -->
                <div class="flex flex-col sm:flex-row items-center gap-2 pt-1">
                    <div class="relative flex-1 w-full">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" 
                               id="filter_matkul_search" 
                               oninput="filterMatkulTable()" 
                               placeholder="Cari nama mata kuliah atau kode..." 
                               class="w-full pl-8 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 text-slate-800 transition">
                    </div>
                    <div class="w-full sm:w-64">
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
                    <button type="button" 
                            id="btn_reset_matkul" 
                            onclick="resetMatkulFilter()" 
                            class="hidden px-3 py-2 text-xs text-slate-500 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-lg transition font-medium cursor-pointer">
                        Reset
                    </button>
                </div>

                <!-- Clean Table -->
                <div class="overflow-x-auto rounded-xl border border-slate-100 text-xs">
                    <table class="w-full text-left text-slate-650">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="p-3 w-28">Kode MK</th>
                                <th class="p-3">Nama Mata Kuliah</th>
                                <th class="p-3">Program Studi</th>
                                <th class="p-3 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @if(isset($mataKuliahs) && count($mataKuliahs) > 0)
                                @foreach($mataKuliahs as $mk)
                                <tr class="matkul-row hover:bg-slate-50/50 transition"
                                    data-nama="{{ strtolower($mk->nama_mk) }}"
                                    data-kode="{{ strtolower($mk->kode_mk ?? '') }}"
                                    data-prodi-id="{{ $mk->id_prodi ?? 'umum' }}"
                                    data-prodi-name="{{ strtolower(($mk->prodi->nama_prodi ?? 'semua umum') . ' ' . ($mk->prodi->fakultas->nama_fakultas ?? '')) }}">
                                    <td class="p-3 font-mono text-slate-400 font-bold">{{ $mk->kode_mk ?: '-' }}</td>
                                    <td class="p-3 font-bold text-slate-800 text-sm">{{ $mk->nama_mk }}</td>
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
                                    <td class="p-3 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <button type="button" 
                                                    onclick="openEditMatkulModal({{ $mk->id }}, '{{ addslashes($mk->nama_mk) }}', '{{ addslashes($mk->kode_mk ?? '') }}', '{{ $mk->id_prodi ?? '' }}')" 
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
                                    <td colspan="4" class="p-6 text-center text-slate-400 italic">
                                        Tidak ada mata kuliah yang cocok dengan filter pencarian.
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-400 italic">Belum ada data mata kuliah.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
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
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
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

        function openEditMatkulModal(id, nama, kode, prodiId) {
            document.getElementById('edit-matkul-form').action = `/admin/akademik/matkul/${id}`;
            document.getElementById('edit-matkul-nama').value = nama;
            document.getElementById('edit-matkul-kode').value = kode;
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
        // REALTIME FILTER & SEARCH FOR MATA KULIAH
        // ==========================================
        function filterMatkulTable() {
            const search = (document.getElementById('filter_matkul_search')?.value || '').toLowerCase().trim();
            const prodi = document.getElementById('filter_matkul_prodi')?.value || '';
            
            const rows = document.querySelectorAll('.matkul-row');
            const emptyState = document.getElementById('matkul_empty_state');
            const resetBtn = document.getElementById('btn_reset_matkul');
            
            let visibleCount = 0;
            
            rows.forEach(row => {
                const rowNama = row.getAttribute('data-nama') || '';
                const rowKode = row.getAttribute('data-kode') || '';
                const rowProdiId = row.getAttribute('data-prodi-id') || '';
                const rowProdiName = row.getAttribute('data-prodi-name') || '';
                
                const matchSearch = !search || rowNama.includes(search) || rowKode.includes(search) || rowProdiName.includes(search);
                const matchProdi = !prodi || (prodi === 'umum' ? rowProdiId === 'umum' : rowProdiId === prodi);
                
                if (matchSearch && matchProdi) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            if (emptyState) emptyState.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            
            if (resetBtn) {
                if (search || prodi) {
                    resetBtn.classList.remove('hidden');
                } else {
                    resetBtn.classList.add('hidden');
                }
            }
        }

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




