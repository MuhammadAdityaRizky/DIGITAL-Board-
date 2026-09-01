<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white">
                <i class="fa-solid fa-user-shield text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">ADMIN CONTROL PANEL</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-line"></i>
                <span class="text-xs">Dashboard Overview</span>
            </a>
            <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-users-gear"></i>
                <span class="text-xs">Manajemen Pengguna</span>
            </a>
            <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-door-open"></i>
                <span class="text-xs">Manajemen Lab</span>
            </a>
            <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs">Jadwal & Agenda</span>
            </a>
            <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="text-xs">Laporan Absensi</span>
            </a>
            <a href="{{ route('admin.statistik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="text-xs">Statistik Kehadiran</span>
            </a>
            <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="text-xs">Data Akademik</span>
            </a>
            <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-bullhorn"></i>
                <span class="text-xs">Pengumuman Lab</span>
            </a>
            
            <div class="pt-2 border-t border-slate-800/80 my-2"></div>
            <a href="{{ route('board') }}" target="_blank" class="flex items-center justify-between px-4 py-3 bg-[#0c4ea6]/40 hover:bg-[#0c4ea6] text-teal-300 hover:text-white rounded-xl w-full transition font-bold border border-teal-500/20">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-desktop text-emerald-400"></i>
                    <span class="text-xs">Portal Display Board</span>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-800">
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Manajemen Akun Pengguna</h2>
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
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
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

            <!-- Search & Filter Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm max-w-4xl">
                <form action="{{ route('admin.pengguna') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end text-xs">
                    <div class="flex-grow w-full">
                        <label class="block text-slate-655 font-bold mb-1.5">Cari Pengguna</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama lengkap, username, NIM, NIP..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                        </div>
                    </div>
                    <div class="w-full sm:w-44">
                        <label class="block text-slate-650 font-bold mb-1.5">Role Akun</label>
                        <select name="role" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dosen" {{ request('role') === 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="mahasiswa" {{ request('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="flex-grow sm:flex-grow-0 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'role']))
                            <a href="{{ route('admin.pengguna') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-all border border-slate-200 text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Users Management Card -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden max-w-4xl">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Pengguna Sistem</h3>
                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.users.promote') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menaikkan semester seluruh mahasiswa? Semester semua mahasiswa akan naik 1 tingkat.');" class="inline">
                            @csrf
                            <button type="submit" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-arrow-up-right-dots"></i> Naik Semester
                            </button>
                        </form>
                        <button onclick="toggleModal('modal-import-dosen')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm hidden sm:flex">
                            <i class="fa-solid fa-file-import"></i> Import Dosen
                        </button>
                        <button onclick="toggleModal('modal-import-mahasiswa')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm hidden sm:flex">
                            <i class="fa-solid fa-file-import"></i> Import Mhs
                        </button>
                        <button onclick="openAddUserModal()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-plus"></i> Tambah User Baru
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full text-xs text-left text-slate-650">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="p-4">Nama Lengkap</th>
                                    <th class="p-4">NIM / NIP</th>
                                    <th class="p-4">Role</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @if($users->count() > 0)
                                    @foreach($users as $u)
                                        @php
                                            $nama = $u->role === 'dosen' ? ($u->dosen->nama ?? '-') : ($u->role === 'mahasiswa' ? ($u->mahasiswa->nama_lengkap ?? '-') : $u->username);
                                        @endphp
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="p-4">
                                                <span class="font-bold text-slate-800 text-sm block">{{ $nama }}</span>
                                                @if($u->role === 'mahasiswa' && $u->mahasiswa && $u->mahasiswa->kelas)
                                                    <span class="text-[10px] text-slate-455 block mt-0.5">
                                                        <i class="fa-solid fa-graduation-cap"></i> Program: {{ $u->mahasiswa->program_kuliah ?? 'Reguler' }} • Kelas: {{ $u->mahasiswa->kelas }}
                                                        @if($u->mahasiswa->semester)
                                                            • Semester: {{ $u->mahasiswa->semester }}
                                                        @endif
                                                    </span>
                                                @elseif($u->role === 'dosen' && $u->dosen)
                                                    @if($u->dosen->jabatan)
                                                    <span class="text-[10px] text-slate-500 block mt-1"><i class="fa-solid fa-briefcase text-blue-500 mr-1"></i>Jabatan: <span class="font-medium text-slate-600">{{ $u->dosen->jabatan }}</span></span>
                                                    @endif
                                                    @if($u->dosen->kompetensi)
                                                    <span class="text-[10px] text-slate-500 block mt-1"><i class="fa-solid fa-star text-amber-500 mr-1"></i>Kompetensi: <span class="font-medium text-slate-600">{{ $u->dosen->kompetensi }}</span></span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="p-4 font-mono text-teal-850 font-semibold">
                                                <span>{{ $u->username }}</span>
                                                @if($u->role === 'mahasiswa' && $u->mahasiswa)
                                                    @if($u->mahasiswa->prodi)
                                                        <span class="text-[9px] text-slate-450 font-sans block font-medium mt-0.5">{{ $u->mahasiswa->prodi->nama_prodi }}</span>
                                                    @endif
                                                    @if($u->mahasiswa->fakultas)
                                                        <span class="text-[9px] text-slate-400 font-sans block font-medium mt-0.5">{{ $u->mahasiswa->fakultas->nama_fakultas }}</span>
                                                    @endif
                                                @elseif($u->role === 'dosen' && $u->dosen)
                                                    @if($u->dosen->prodi)
                                                        <span class="text-[9px] text-slate-450 font-sans block font-medium mt-0.5">{{ $u->dosen->prodi->nama_prodi }}</span>
                                                    @endif
                                                    @if($u->dosen->fakultas)
                                                        <span class="text-[9px] text-slate-400 font-sans block font-medium mt-0.5">{{ $u->dosen->fakultas->nama_fakultas }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                @if($u->role === 'admin')
                                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-750 border border-amber-100 rounded-lg text-[10px] font-bold uppercase tracking-wider">Admin</span>
                                                @elseif($u->role === 'dosen')
                                                    <span class="px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-100 rounded-lg text-[10px] font-bold uppercase tracking-wider">Dosen</span>
                                                @else
                                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg text-[10px] font-bold uppercase tracking-wider">Mahasiswa</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                <div class="flex items-center justify-center gap-3">
                                                    <button onclick='editUser(@json($u))' class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                                    
                                                     @if(auth()->id() !== $u->id)
                                                        <form action="{{ route('admin.pengguna.delete', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-8 text-slate-400 italic">Pengguna tidak ditemukan.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- USER MODAL (ADD & EDIT) -->
    <div id="modal-user" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-user-title" class="font-bold text-base text-slate-800">Tambah Pengguna Baru</h3>
                <button onclick="toggleModal('modal-user')" class="text-slate-400 hover:text-slate-660 text-lg">&times;</button>
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
                    <select name="role" id="user-role" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        <option value="dosen">Dosen</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="admin">Admin</option>
                    </select>
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
                    <div id="class-container" class="grid grid-cols-3 gap-4">
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
                                    <option value="{{ $kls->nama_kelas }}">{{ $kls->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Semester</label>
                            <select name="semester" id="user-semester" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="">-- Pilih --</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
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

    <!-- MODAL IMPORT DOSEN -->
    <div id="modal-import-dosen" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-base text-slate-800">Import Data Dosen</h3>
                <button onclick="toggleModal('modal-import-dosen')" class="text-slate-400 hover:text-slate-660 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.pengguna.import-dosen') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel[]" accept=".xlsx, .xls, .csv" required multiple class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
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
                <button onclick="toggleModal('modal-import-mahasiswa')" class="text-slate-400 hover:text-slate-660 text-lg">&times;</button>
            </div>
            <form action="{{ route('admin.pengguna.import-mahasiswa') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel[]" accept=".xlsx, .xls, .csv" required multiple class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-import-mahasiswa')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-slate-700 hover:bg-slate-800 text-white rounded-lg font-bold shadow-sm">Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg text-[9px] font-medium text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-chart-line text-lg"></i>
            <span>Overview</span>
        </a>
        <a href="{{ route('admin.pengguna') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-855 font-bold">
            <i class="fa-solid fa-users-gear text-lg"></i>
            <span>Pengguna</span>
        </a>
        <a href="{{ route('admin.laboratorium') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-door-open text-lg"></i>
            <span>Lab</span>
        </a>
        <a href="{{ route('admin.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-calendar-days text-lg"></i>
            <span>Agenda</span>
        </a>
        <a href="{{ route('admin.absensi') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-file-invoice text-lg"></i>
            <span>Absen</span>
        </a>
    </nav>

    <script>
        const allProdis = [
            @foreach($prodis as $p)
                { id: "{{ $p->id }}", fakultasId: "{{ $p->fakultas_id }}", nama: "{{ $p->nama_prodi }}" },
            @endforeach
        ];

        function filterProdis(selectedFakultasId, selectedProdiId = "") {
            const prodiSelect = document.getElementById('user-jurusan');
            prodiSelect.innerHTML = '<option value="">-- Pilih --</option>';
            
            const filtered = allProdis.filter(p => !selectedFakultasId || p.fakultasId == selectedFakultasId);
            filtered.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.nama;
                if (p.id == selectedProdiId) {
                    option.selected = true;
                }
                prodiSelect.appendChild(option);
            });
        }

        document.getElementById('user-fakultas').addEventListener('change', function() {
            filterProdis(this.value);
        });

        function updateRequiredFields(role) {
            const fakultasSelect = document.getElementById('user-fakultas');
            const prodiSelect = document.getElementById('user-jurusan');
            if (role === 'dosen' || role === 'mahasiswa') {
                fakultasSelect.required = true;
                prodiSelect.required = true;
            } else {
                fakultasSelect.required = false;
                prodiSelect.required = false;
            }
        }

        document.getElementById('user-role').addEventListener('change', function() {
            const extraFields = document.getElementById('mahasiswa-fields');
            const classField = document.getElementById('class-container');
            const dosenFields = document.getElementById('dosen-fields');
            
            updateRequiredFields(this.value);

            if (this.value === 'mahasiswa') {
                extraFields.classList.remove('hidden');
                classField.classList.remove('hidden');
                dosenFields.classList.add('hidden');
            } else if (this.value === 'dosen') {
                extraFields.classList.remove('hidden');
                classField.classList.add('hidden');
                dosenFields.classList.remove('hidden');
            } else {
                extraFields.classList.add('hidden');
                dosenFields.classList.add('hidden');
            }
        });

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function openAddUserModal() {
            document.getElementById('modal-user-title').innerText = "Tambah Pengguna Baru";
            document.getElementById('user-form').action = "{{ route('admin.users.store') }}";
            document.getElementById('user-method').value = "POST";
            document.getElementById('user-nama_lengkap').value = "";
            document.getElementById('user-username_or_nim_nip').value = "";
            document.getElementById('user-password').required = true;
            document.getElementById('password-container').classList.remove('hidden');
            document.getElementById('role-container').classList.remove('hidden');
            document.getElementById('mahasiswa-fields').classList.add('hidden');
            document.getElementById('dosen-fields').classList.add('hidden');
            document.getElementById('user-role').value = "dosen";
            document.getElementById('user-fakultas').value = "";
            document.getElementById('user-jurusan').value = "";
            document.getElementById('user-program_kuliah').value = "Reguler";
            document.getElementById('user-kelas').value = "";
            document.getElementById('user-semester').value = "";
            document.getElementById('user-jabatan').value = "";
            document.getElementById('user-kompetensi').value = "";
            
            updateRequiredFields("dosen");
            
            // Show Dosen fields by default
            document.getElementById('mahasiswa-fields').classList.remove('hidden');
            document.getElementById('class-container').classList.add('hidden');
            document.getElementById('dosen-fields').classList.remove('hidden');
            
            filterProdis("");
            toggleModal('modal-user');
        }

        function editUser(user) {
            document.getElementById('modal-user-title').innerText = "Edit Akun Pengguna";
            
            const updateUrl = `{{ url('admin/users') }}/${user.id}`;
            document.getElementById('user-form').action = updateUrl;
            document.getElementById('user-method').value = "PUT";
            
            document.getElementById('user-username_or_nim_nip').value = user.username;
            
            document.getElementById('user-password').required = false;
            document.getElementById('role-container').classList.add('hidden');
            
            let nama = user.username;
            let id_fakultas = "";
            let id_prodi = "";
            let kelas = "";
            let program_kuliah = "Reguler";
            let semester = "";
            let jabatan = "";
            let kompetensi = "";
            
            updateRequiredFields(user.role);

            if (user.role === 'dosen') {
                if (user.dosen) {
                    nama = user.dosen.nama;
                    id_fakultas = user.dosen.id_fakultas || "";
                    id_prodi = user.dosen.id_prodi || "";
                    jabatan = user.dosen.jabatan || "";
                    kompetensi = user.dosen.kompetensi || "";
                }
                document.getElementById('mahasiswa-fields').classList.remove('hidden');
                document.getElementById('class-container').classList.add('hidden');
                document.getElementById('dosen-fields').classList.remove('hidden');
            } else if (user.role === 'mahasiswa') {
                if (user.mahasiswa) {
                    nama = user.mahasiswa.nama_lengkap;
                    id_fakultas = user.mahasiswa.id_fakultas || "";
                    id_prodi = user.mahasiswa.id_prodi || "";
                    kelas = user.mahasiswa.kelas || "";
                    program_kuliah = user.mahasiswa.program_kuliah || "Reguler";
                    semester = user.mahasiswa.semester || "";
                }
                document.getElementById('mahasiswa-fields').classList.remove('hidden');
                document.getElementById('class-container').classList.remove('hidden');
                document.getElementById('dosen-fields').classList.add('hidden');
            } else {
                document.getElementById('mahasiswa-fields').classList.add('hidden');
                document.getElementById('dosen-fields').classList.add('hidden');
            }
            
            document.getElementById('user-nama_lengkap').value = nama;
            document.getElementById('user-fakultas').value = id_fakultas;
            filterProdis(id_fakultas, id_prodi);
            document.getElementById('user-kelas').value = kelas;
            document.getElementById('user-program_kuliah').value = program_kuliah;
            document.getElementById('user-semester').value = semester;
            document.getElementById('user-jabatan').value = jabatan;
            document.getElementById('user-kompetensi').value = kompetensi;
            
            toggleModal('modal-user');
        }
    </script>
</body>
</html>
