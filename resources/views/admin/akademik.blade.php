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
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0" x-data="{ activeTab: 'fakultas' }">

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
            <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
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
            <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-2.5 bg-teal-850 text-white rounded-xl w-full font-bold">
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

        <div class="p-5 border-t border-slate-800 shrink-0">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-rose-400 hover:text-rose-300 text-xs font-bold w-full transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Manajemen Parameter Akademik</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ auth()->user()->username }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">SUPER ADMIN</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr(auth()->user()->username, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-850 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-4xl">
                    <i class="fa-solid fa-circle-check class-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-4xl">
                    <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal memproses data:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabs selector -->
            <div class="flex border-b border-slate-200 text-xs font-bold uppercase tracking-wider bg-white px-4 pt-2 rounded-t-xl border-x max-w-4xl">
                <button @click="activeTab = 'fakultas'" 
                        :class="activeTab === 'fakultas' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2">
                    <i class="fa-solid fa-building"></i>
                    Fakultas
                </button>
                <button @click="activeTab = 'prodi'" 
                        :class="activeTab === 'prodi' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Program Studi
                </button>
                <button @click="activeTab = 'kelas'" 
                        :class="activeTab === 'kelas' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                        class="px-5 py-3 transition focus:outline-none flex items-center gap-2">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Kelas
                </button>
            </div>

            <!-- Tab Content: FAKULTAS -->
            <div x-show="activeTab === 'fakultas'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 max-w-4xl">
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
            <div x-show="activeTab === 'prodi'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 max-w-4xl" style="display: none;">
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
            <div x-show="activeTab === 'kelas'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-6 max-w-4xl" style="display: none;">
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

        </div>
    </main>

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
                </div>
                <button type="submit" class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold transition shadow-sm">Import Data</button>
            </form>
        </div>
    </div>

    <!-- KELAS -->
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
                </div>
                <button type="submit" class="w-full py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold transition shadow-sm">Import Data</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
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

                    const isImport = form.getAttribute('enctype') === 'multipart/form-data';
                    const loadingTitle = isImport ? 'Mengimpor Data...' : 'Menyimpan Data...';
                    const loadingText = isImport 
                        ? 'Sistem sedang membaca dan memproses file Excel/CSV.' 
                        : 'Sedang memproses dan menyimpan data ke sistem.';

                    Swal.fire({
                        title: loadingTitle,
                        text: loadingText,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl p-8',
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




