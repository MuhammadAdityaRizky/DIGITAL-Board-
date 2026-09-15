<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Digital Board</title>
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

            <!-- Search & Filter Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm max-w-4xl">
                <form action="{{ route('admin.pengguna') }}" method="GET" class="flex flex-col gap-4 text-xs">
                    <div class="flex flex-col sm:flex-row gap-4 w-full">
                        <div class="flex-grow w-full">
                            <label class="block text-slate-700 font-bold mb-1.5">Cari Pengguna</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama lengkap, username, NIM, NIP..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                            </div>
                        </div>
                        @if(auth()->user()->isSuperAdmin())
                            <div class="w-full sm:w-56">
                                <label class="block text-slate-700 font-bold mb-1.5">Fakultas</label>
                                <select name="fakultas_id" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none cursor-pointer font-medium">
                                    <option value="">Semua Fakultas</option>
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}" {{ request('fakultas_id') == $f->id ? 'selected' : '' }}>
                                            {{ $f->nama_fakultas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="w-full sm:w-48">
                            <label class="block text-slate-700 font-bold mb-1.5">Role Akun</label>
                            <select name="role" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none cursor-pointer">
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
                    
                    <div class="flex flex-col sm:flex-row gap-4 w-full items-end">
                        <div class="w-full sm:w-1/4">
                            <label class="block text-slate-700 font-bold mb-1.5">Program Kuliah</label>
                            <select name="program_kuliah" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none cursor-pointer">
                                <option value="">Semua Program</option>
                                <option value="Reguler" {{ request('program_kuliah') === 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="Karyawan" {{ request('program_kuliah') === 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/4">
                            <label class="block text-slate-700 font-bold mb-1.5">Semester</label>
                            <select name="semester" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none cursor-pointer">
                                <option value="">Semua Semester</option>
                                @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="w-full sm:w-1/4">
                            <label class="block text-slate-700 font-bold mb-1.5">Kelas</label>
                            <select name="kelas" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none cursor-pointer">
                                <option value="">Semua Kelas</option>
                                @foreach($kelases as $kls)
                                    <option value="{{ $kls->nama_kelas }}" {{ request('kelas') === $kls->nama_kelas ? 'selected' : '' }}>Kelas {{ $kls->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-1/4">
                            <label class="block text-slate-700 font-bold mb-1.5">Status Mhs</label>
                            <select name="status_mahasiswa" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status_mahasiswa') === 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                                <option value="cuti" {{ request('status_mahasiswa') === 'cuti' ? 'selected' : '' }}>🟡 Cuti</option>
                                <option value="lulus" {{ request('status_mahasiswa') === 'lulus' ? 'selected' : '' }}>🔵 Lulus</option>
                                <option value="do" {{ request('status_mahasiswa') === 'do' ? 'selected' : '' }}>🔴 Drop Out (DO)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end pt-2 border-t border-slate-100">
                        <div class="flex gap-2">
                            <button type="submit" class="px-5 py-2.5 bg-teal-850 hover:bg-teal-900 text-white rounded-xl font-bold transition shadow-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-filter"></i> Filter
                            </button>
                            @if(request('search') || request('role') || request('program_kuliah') || request('semester') || request('kelas') || request('status_mahasiswa'))
                                <a href="{{ route('admin.pengguna') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition text-center flex items-center gap-1">
                                    <i class="fa-solid fa-rotate-left"></i> Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Main Data Table -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden max-w-4xl">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-sm text-slate-800">Daftar Pengguna Sistem</h3>
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-[11px] font-bold">{{ $users->total() }} User</span>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="button" onclick="toggleModal('modal-fitur-auto')" class="px-3 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300/80 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Pelajari Cara Kerja Fitur Otomatis">
                            <i class="fa-solid fa-circle-question text-teal-700"></i> Panduan Fitur
                        </button>
                        <button type="button" onclick="toggleModal('modal-promote-semester')" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-up-right-dots"></i> Naik Semester
                        </button>
                        <button type="button" onclick="toggleModal('modal-import-dosen')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm hidden sm:flex cursor-pointer">
                            <i class="fa-solid fa-file-import"></i> Import Dosen
                        </button>
                        <button type="button" onclick="toggleModal('modal-import-mahasiswa')" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm hidden sm:flex cursor-pointer">
                            <i class="fa-solid fa-file-import"></i> Import Mhs
                        </button>
                        <button type="button" onclick="openAddUserModal()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-plus"></i> Tambah User Baru
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-100">
                        <table class="w-full text-xs text-left text-slate-650">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                <tr>
                                    <th class="p-4 w-12 text-center">No</th>
                                    <th class="p-4">Nama Lengkap</th>
                                    <th class="p-4">NIM / NIP</th>
                                    <th class="p-4">Role</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @if($users->count() > 0)
                                    @foreach($users as $index => $u)
                                        @php
                                            $nama = $u->role === 'dosen' ? ($u->dosen->nama ?? '-') : ($u->role === 'mahasiswa' ? ($u->mahasiswa->nama_lengkap ?? '-') : $u->username);
                                        @endphp
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="p-4 text-center text-slate-400 font-mono text-xs">{{ $users->firstItem() + $index }}</td>
                                            <td class="p-4">
                                                <span class="font-bold text-slate-800 text-sm block">{{ $nama }}</span>
                                                @if($u->role === 'mahasiswa' && $u->mahasiswa)
                                                    <div class="flex items-center gap-1.5 flex-wrap mt-0.5">
                                                        @if($u->mahasiswa->kelas)
                                                            <span class="text-[10px] text-slate-500">
                                                                <i class="fa-solid fa-graduation-cap text-teal-600"></i> {{ $u->mahasiswa->program_kuliah ?? 'Reguler' }} • Kelas {{ $u->mahasiswa->kelas }}
                                                                @if($u->mahasiswa->semester)
                                                                    • Sem {{ $u->mahasiswa->semester }}
                                                                @endif
                                                            </span>
                                                        @endif
                                                        @php
                                                            $st = $u->mahasiswa->status ?? 'aktif';
                                                        @endphp
                                                        @if($st === 'aktif')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase">Aktif</span>
                                                        @elseif($st === 'cuti')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200 uppercase">Cuti</span>
                                                        @elseif($st === 'lulus')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-blue-100 text-blue-800 border border-blue-200 uppercase">Lulus</span>
                                                        @elseif($st === 'do')
                                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200 uppercase">Drop Out</span>
                                                        @endif
                                                    </div>
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
                                                @if($u->role === 'super_admin')
                                                    <span class="px-2.5 py-1 bg-purple-50 text-purple-750 border border-purple-200 rounded-lg text-[10px] font-bold uppercase tracking-wider">Super Admin</span>
                                                @elseif($u->role === 'admin')
                                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                                                        Admin {{ $u->fakultas?->nama_fakultas ? '('.$u->fakultas->nama_fakultas.')' : 'Fakultas' }}
                                                    </span>
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
                                                        <form action="{{ route('admin.pengguna.delete', $u->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus akun ini?');">
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
                                        <td colspan="5" class="text-center py-8 text-slate-400 italic">Pengguna tidak ditemukan.</td>
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
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 space-y-5">
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
                                    <option value="{{ $kls->nama_kelas }}">{{ $kls->nama_kelas }}</option>
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

    <!-- MODAL PANDUAN FITUR OTOMATIS (UI/UX REDESIGNED) -->
    <div id="modal-fitur-auto" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-3xl w-full max-h-[88vh] flex flex-col overflow-hidden text-left animate-in fade-in zoom-in duration-150">
            
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white px-6 py-4.5 flex justify-between items-center flex-shrink-0 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-500/20 border border-teal-400/30 flex items-center justify-center text-teal-300 text-base shadow-inner">
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

            <!-- Segmented Pill Control (Tanpa Scrollbar, 3 Kolom Simetris) -->
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

            <!-- Tab Contents (2-Column Bento Grid - Nyaman & Ringkas) -->
            <div class="p-6 overflow-y-auto space-y-4 text-xs flex-1 bg-white">
                
                <!-- TAB 1: NAIK & KELOLA SEMESTER -->
                <div id="tab-auto-semester" class="tab-content-fitur-auto space-y-3.5">
                    <!-- Ringkasan Singkat -->
                    <div class="p-3.5 bg-indigo-50/70 border border-indigo-100 rounded-2xl flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 text-xs">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <p class="text-indigo-950 font-medium text-xs leading-snug">
                            Semua fitur di bawah terintegrasi pada tombol <strong class="text-indigo-900 font-bold">"Naik Semester"</strong> untuk memperbarui data mahasiswa massal dalam hitungan detik.
                        </p>
                    </div>

                    <!-- 2 Kolom Kartu Fitur -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Card 1 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-arrow-up"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-100/70 text-indigo-800 border border-indigo-200/60">+1 Semester</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Kenaikan Semester (+1) Massal</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Menaikkan semester seluruh mahasiswa aktif serentak per periode akademik (Ganjil: 1 Sep / Genap: 1 Feb). Bisa difilter per Fakultas, Prodi, atau Angkatan.
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-user-graduate"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-100/70 text-blue-800 border border-blue-200/60">Auto Lulus</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Otomatisasi Kelulusan (>S8)</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Mahasiswa aktif yang naik melewati batas <strong>Semester 8</strong> otomatis berubah status menjadi <b>Lulus</b> dan semesternya dikunci di semester 8.
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-user-clock"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100/70 text-amber-800 border border-amber-200/60">Auto Skip</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Proteksi Status Cuti & Drop Out</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Mahasiswa berstatus <b>Cuti</b> atau <b>Drop Out (DO)</b> secara otomatis dilewati (*auto-exclude*), sehingga data semester mereka tidak akan terpengaruh.
                                </p>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-200 text-slate-700 border border-slate-300/60">-1 Rollback</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Rollback / Pembatalan (-1)</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Jika ada kesalahan klik periode, admin dapat memilih <em>"Turunkan (-1)"</em>. Mahasiswa yang sempat auto-lulus otomatis dikembalikan ke status <b>Aktif</b>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: AUTO GENERATE AKUN & IMPORT EXCEL -->
                <div id="tab-auto-import" class="tab-content-fitur-auto hidden space-y-3.5">
                    <!-- Ringkasan Singkat -->
                    <div class="p-3.5 bg-emerald-50/70 border border-emerald-100 rounded-2xl flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 text-xs">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <p class="text-emerald-950 font-medium text-xs leading-snug">
                            Fitur impor membaca file Excel/CSV dan melakukan registrasi otomatis ribuan akun pengguna secara aman tanpa entri manual.
                        </p>
                    </div>

                    <!-- 2 Kolom Kartu Fitur -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Card 1 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100/70 text-emerald-800 border border-emerald-200/60">Akun Instan</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Auto-Generate Akun & Password</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Username & password awal otomatis diset sama dengan <strong>NIM</strong> (Mahasiswa) atau <strong>NIP/NIDN</strong> (Dosen) dengan enkripsi bcrypt aman.
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-calculator"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-teal-100/70 text-teal-800 border border-teal-200/60">Rumus Angkatan</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Auto-Hitung Semester Berjalan</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Jika kolom semester di Excel kosong, sistem otomatis menghitung semester berjalan berdasarkan tahun angkatan dan kalender akademik saat ini.
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-filter"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100/70 text-amber-800 border border-amber-200/60">Auto Parse</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Deteksi Program & Kelas Otomatis</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Teks kelas seperti <em>"Karyawan A"</em> atau <em>"Reguler B"</em> otomatis diurai menjadi Program Kuliah (Reguler/Karyawan) dan Kode Kelas (A/B/C/D).
                                </p>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-spinner"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-sky-100/70 text-sky-800 border border-sky-200/60">Live Progress</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Live Real-Time Progress Bar</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Proses impor berjalan di background (chunking 50 baris) dengan indikator progress bar live sehingga browser tidak timeout atau freeze.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: MULTI-TENANT & KEAMANAN -->
                <div id="tab-auto-security" class="tab-content-fitur-auto hidden space-y-3.5">
                    <!-- Ringkasan Singkat -->
                    <div class="p-3.5 bg-teal-50/70 border border-teal-100 rounded-2xl flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-teal-700 text-white flex items-center justify-center shrink-0 text-xs">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <p class="text-teal-950 font-medium text-xs leading-snug">
                            Perlindungan hak akses dan isolasi data antar-fakultas bekerja secara otomatis untuk menjamin privasi dan keamanan sistem.
                        </p>
                    </div>

                    <!-- 2 Kolom Kartu Fitur -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Card 1 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-teal-100/70 text-teal-800 border border-teal-200/60">Multi-Tenant</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Isolasi Fakultas Otomatis (Admin FK)</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Admin Fakultas (misal Admin FTS / FKIP) otomatis terkunci hanya dapat melihat, menambah, mengimpor, dan mengelola mahasiswa fakultasnya sendiri.
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-2xl space-y-2 hover:border-slate-300 transition">
                            <div class="flex items-center justify-between">
                                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center font-bold text-xs">
                                    <i class="fa-solid fa-ban"></i>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-100/70 text-rose-800 border border-rose-200/60">Auto-Block</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-xs">Pemblokiran Login Mahasiswa DO</h4>
                                <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">
                                    Mahasiswa yang berstatus <strong>Drop Out (DO)</strong> otomatis ditolak saat mencoba login ke portal Digital Board demi keamanan data akademik.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Modal -->
            <div class="bg-slate-50/90 border-t border-slate-200 px-6 py-3.5 flex items-center justify-between flex-shrink-0">
                <span class="text-[11px] text-slate-500 font-medium flex items-center gap-1.5 hidden sm:flex">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i> Seluruh sistem otomatisasi aktif berjalan di background.
                </span>
                <button type="button" onclick="toggleModal('modal-fitur-auto')" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-xs transition shadow-sm cursor-pointer ml-auto">
                    Tutup Panduan
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL NAIK / KELOLA SEMESTER -->
    <div id="modal-promote-semester" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-arrow-up-right-dots"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Kelola / Naik Semester</h3>
                        <p class="text-[10px] text-slate-400">Naikkan semester mahasiswa aktif atau kembalikan semester sebelumnya.</p>
                    </div>
                </div>
                <button onclick="toggleModal('modal-promote-semester')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>

            <form action="{{ route('admin.users.promote') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1.5">Tindakan</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-indigo-200 bg-indigo-50/50 cursor-pointer">
                            <input type="radio" name="action_type" value="promote" checked class="text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <span class="font-bold text-indigo-900 block text-xs">Naik Semester (+1)</span>
                                <span class="text-[9px] text-indigo-700">Khusus mahasiswa aktif</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
                            <input type="radio" name="action_type" value="revert" class="text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <span class="font-bold text-slate-800 block text-xs">Turunkan (-1)</span>
                                <span class="text-[9px] text-slate-500">Rollback / batalkan</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Target Filter (Opsional - Kosongkan jika untuk semua)</span>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Target Fakultas</label>
                        <select name="target_fakultas" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                            <option value="">Semua Fakultas</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Target Jurusan / Prodi</label>
                        <select name="target_prodi" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                            <option value="">Semua Program Studi</option>
                            @foreach($prodis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Target Angkatan (2 Digit Pertama NIM)</label>
                        <input type="text" name="target_angkatan" placeholder="Contoh: 24 untuk Angkatan 2024 (NIM 24xxx)" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none font-mono">
                    </div>

                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl space-y-2">
                        <label class="flex items-start gap-2 cursor-pointer">
                            <input type="checkbox" name="auto_graduate" value="1" checked class="mt-0.5 rounded text-indigo-600 focus:ring-indigo-500">
                            <div class="text-[11px] text-amber-900 leading-tight">
                                <span class="font-bold block">Tandai Otomatis Mahasiswa Lulus</span>
                                <span>Mahasiswa yang naik melebihi Semester 8 akan otomatis diubah statusnya menjadi <b>Lulus</b> (tidak naik lagi).</span>
                            </div>
                        </label>
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2 text-[10px] text-slate-600">
                        <div class="flex items-center gap-1.5 font-bold text-slate-800 text-[11px]">
                            <i class="fa-regular fa-calendar-check text-indigo-600"></i>
                            <span>Panduan Periode Kalender Akademik:</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 pt-1 border-t border-slate-200/60">
                            <div class="p-2 bg-white rounded-lg border border-slate-100">
                                <span class="font-bold text-indigo-900 block">Semester Ganjil</span>
                                <span class="text-slate-500 block">Mulai <b>1 September</b></span>
                                <span class="text-[9px] text-slate-400">Naik ke S1, S3, S5, S7</span>
                            </div>
                            <div class="p-2 bg-white rounded-lg border border-slate-100">
                                <span class="font-bold text-indigo-900 block">Semester Genap</span>
                                <span class="text-slate-500 block">Mulai <b>1 Februari</b></span>
                                <span class="text-[9px] text-slate-400">Naik ke S2, S4, S6, S8</span>
                            </div>
                        </div>
                        <p class="text-[9px] text-slate-400 italic pt-0.5">
                            *Mahasiswa berstatus <b>Cuti</b> dan <b>Drop Out (DO)</b> otomatis <b>dikecualikan</b> (tidak akan ikut naik semester).
                        </p>
                    </div>
                </div>

                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-promote-semester')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold shadow-sm flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-check"></i> Proses Sekarang
                    </button>
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
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'mahasiswa') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
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
                <button onclick="toggleModal('modal-import-mahasiswa')" class="text-slate-400 hover:text-slate-660 text-lg">&times;</button>
            </div>
            <form id="form-import-mahasiswa" action="{{ route('admin.pengguna.import-mahasiswa') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs no-loading">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">File Excel/CSV</label>
                    <input type="file" name="file_excel[]" accept=".xlsx, .xls, .csv" required multiple class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                    <div class="mt-2 text-right">
                        <a href="{{ route('template.download', 'dosen') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                    </div>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-import-mahasiswa')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
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
                <h3 id="import-title" class="text-base font-extrabold text-white tracking-tight">Mengimpor Data...</h3>
                <p id="import-desc" class="text-xs text-slate-400 leading-relaxed">
                    Sistem sedang membaca dan memproses file Excel/CSV.
                </p>
            </div>
            
            <!-- Real-time Progress Bar -->
            <div id="realtime-progress-container" class="hidden space-y-2 mt-4">
                <div class="w-full bg-slate-800 rounded-full h-2.5">
                    <div id="import-progress-bar" class="bg-teal-500 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
                <div class="flex justify-between text-[10px] font-bold text-slate-400">
                    <span id="import-progress-text">0%</span>
                    <span id="import-progress-count">0 / 0 Baris</span>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-800 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-notch animate-spin text-teal-400 text-xs"></i>
                <span id="import-status-text" class="text-[11px] font-bold tracking-wider text-teal-300 uppercase">Memproses Database</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formMahasiswa = document.getElementById('form-import-mahasiswa');
            if (formMahasiswa) {
                formMahasiswa.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const overlay = document.getElementById('global-import-loading-overlay');
                    const progressContainer = document.getElementById('realtime-progress-container');
                    const progressBar = document.getElementById('import-progress-bar');
                    const progressText = document.getElementById('import-progress-text');
                    const progressCount = document.getElementById('import-progress-count');
                    const statusText = document.getElementById('import-status-text');
                    const importDesc = document.getElementById('import-desc');
                    
                    overlay.classList.remove('hidden');
                    progressContainer.classList.remove('hidden');
                    importDesc.innerText = 'Mohon tunggu, jangan menutup halaman ini selama proses berlangsung.';
                    
                    const formData = new FormData(this);
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            throw new Error(data.error);
                        }
                        
                        const importId = data.import_id;
                        
                        // Start polling
                        const interval = setInterval(() => {
                            fetch(`/batch-status/${importId}`)
                                .then(res => res.json())
                                .then(statusData => {
                                    progressBar.style.width = statusData.percentage + '%';
                                    progressText.innerText = statusData.percentage + '%';
                                    progressCount.innerText = statusData.progress + ' / ' + statusData.total + ' Baris';
                                    
                                    if (statusData.status === 'completed' || statusData.progress >= statusData.total && statusData.total > 0) {
                                        clearInterval(interval);
                                        statusText.innerText = 'SELESAI!';
                                        statusText.classList.replace('text-teal-300', 'text-green-400');
                                        
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1000);
                                    }
                                });
                        }, 1000);
                        
                    })
                    .catch(error => {
                        overlay.classList.add('hidden');
                        Swal.fire('Error!', error.message || 'Gagal mengimpor data.', 'error');
                    });
                });
            }
        });
    </script>

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
    </script>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

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
            const fakultasAdminSelect = document.getElementById('user-fakultas_admin');
            
            if (role === 'admin') {
                if (fakultasAdminSelect) {
                    fakultasAdminSelect.name = 'fakultas';
                    fakultasAdminSelect.required = true;
                }
                if (fakultasSelect) {
                    fakultasSelect.name = 'fakultas_mhs';
                    fakultasSelect.required = false;
                }
                if (prodiSelect) prodiSelect.required = false;
            } else if (role === 'dosen' || role === 'mahasiswa') {
                if (fakultasAdminSelect) {
                    fakultasAdminSelect.name = 'fakultas_admin';
                    fakultasAdminSelect.required = false;
                }
                if (fakultasSelect) {
                    fakultasSelect.name = 'fakultas';
                    fakultasSelect.required = true;
                }
                if (prodiSelect) prodiSelect.required = true;
            } else {
                if (fakultasAdminSelect) {
                    fakultasAdminSelect.name = 'fakultas_admin';
                    fakultasAdminSelect.required = false;
                }
                if (fakultasSelect) {
                    fakultasSelect.name = 'fakultas';
                    fakultasSelect.required = false;
                }
                if (prodiSelect) prodiSelect.required = false;
            }
        }

        document.getElementById('user-role').addEventListener('change', function() {
            const extraFields = document.getElementById('mahasiswa-fields');
            const classField = document.getElementById('class-container');
            const dosenFields = document.getElementById('dosen-fields');
            const adminFields = document.getElementById('admin-fields');
            
            updateRequiredFields(this.value);

            if (this.value === 'mahasiswa') {
                extraFields.classList.remove('hidden');
                classField.classList.remove('hidden');
                dosenFields.classList.add('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            } else if (this.value === 'dosen') {
                extraFields.classList.remove('hidden');
                classField.classList.add('hidden');
                dosenFields.classList.remove('hidden');
                if (adminFields) adminFields.classList.add('hidden');
            } else if (this.value === 'admin') {
                extraFields.classList.add('hidden');
                dosenFields.classList.add('hidden');
                if (adminFields) adminFields.classList.remove('hidden');
            } else {
                extraFields.classList.add('hidden');
                dosenFields.classList.add('hidden');
                if (adminFields) adminFields.classList.add('hidden');
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
            const adminFields = document.getElementById('admin-fields');
            if (adminFields) adminFields.classList.add('hidden');
            const fakAdmin = document.getElementById('user-fakultas_admin');
            if (fakAdmin) fakAdmin.value = "";

            document.getElementById('user-role').value = "dosen";
            document.getElementById('user-fakultas').value = "";
            document.getElementById('user-jurusan').value = "";
            document.getElementById('user-program_kuliah').value = "Reguler";
            document.getElementById('user-kelas').value = "";
            document.getElementById('user-semester').value = "";
            document.getElementById('user-status_mahasiswa').value = "aktif";
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
            
            const updateUrl = `/admin/users/${user.id}`;
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
            let status_mahasiswa = "aktif";
            let jabatan = "";
            let kompetensi = "";
            
            updateRequiredFields(user.role);

            const adminFields = document.getElementById('admin-fields');
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
                document.getElementById('class-container').classList.remove('hidden');
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
</body>
</html>




