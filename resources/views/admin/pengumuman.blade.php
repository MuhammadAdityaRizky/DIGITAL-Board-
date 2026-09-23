<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengumuman - Digital Board</title>
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Pengumuman Laboratorium</h2>
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
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-855 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm w-full">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search, Filter & Action Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm w-full">
                <form action="{{ route('admin.pengumuman') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center text-xs">
                    <div class="relative lg:col-span-4 w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi pengumuman..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-slate-800 transition">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                    </div>

                    <div class="lg:col-span-3 w-full">
                        <select name="status" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-slate-700 font-medium transition cursor-pointer">
                            <option value="">Semua Status & Prioritas</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif Ditampilkan</option>
                            <option value="dijadwalkan" {{ request('status') === 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                            <option value="kedaluwarsa" {{ request('status') === 'kedaluwarsa' ? 'selected' : '' }}>Kedaluwarsa</option>
                            <option value="penting" {{ request('status') === 'penting' ? 'selected' : '' }}>Dipin / Penting / Urgen</option>
                        </select>
                    </div>

                    <div class="lg:col-span-3 w-full">
                        <select name="lab_id" onchange="this.form.submit()" class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-slate-700 font-medium transition cursor-pointer">
                            <option value="">Semua Target Laboratorium</option>
                            <option value="umum" {{ request('lab_id') === 'umum' ? 'selected' : '' }}>Semua Lab / Umum</option>
                            @foreach($laboratoriums as $lab)
                                <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>Lab: {{ $lab->nama_lab }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lg:col-span-2 w-full flex items-center justify-end gap-2">
                        @if(request()->hasAny(['search', 'status', 'lab_id']))
                            <a href="{{ route('admin.pengumuman') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">Reset</a>
                        @endif
                        <button type="button" onclick="toggleModal('modal-announcement')" class="w-full py-2.5 px-4 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm cursor-pointer whitespace-nowrap">
                            <i class="fa-solid fa-plus"></i> Terbitkan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Announcements List -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden w-full">
                <div class="bg-slate-50/60 border-b border-slate-200 px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Daftar Pengumuman Resmi Laboratorium</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola pengumuman resmi yang tampil pada portal informasi dan papan digital display lab.</p>
                    </div>
                    <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                        Total: <span class="font-bold text-slate-800">{{ $pengumumanList->total() }}</span> Pengumuman
                    </div>
                </div>
                <div class="p-6">
                    @if($pengumumanList->count() > 0)
                        <div class="space-y-4">
                            @foreach($pengumumanList as $p)
                                @php
                                    $now = date('Y-m-d H:i:s');
                                    $isAktif = true;
                                    $statusLabel = 'Aktif Ditampilkan';
                                    $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $statusIcon = 'fa-circle-check text-emerald-600';

                                    if ($p->tanggal_mulai && $p->tanggal_mulai > $now) {
                                        $isAktif = false;
                                        $statusLabel = 'Dijadwalkan';
                                        $statusClass = 'bg-amber-50 text-amber-700 border-amber-200';
                                        $statusIcon = 'fa-clock text-amber-600';
                                    } elseif ($p->tanggal_selesai && $p->tanggal_selesai < $now) {
                                        $isAktif = false;
                                        $statusLabel = 'Kedaluwarsa';
                                        $statusClass = 'bg-slate-100 text-slate-600 border-slate-200';
                                        $statusIcon = 'fa-calendar-xmark text-slate-400';
                                    }
                                @endphp
                                <div class="bg-slate-50/80 hover:bg-slate-50 p-5 rounded-2xl border border-slate-200 relative group shadow-xs space-y-4 transition">
                                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                                        @if($p->foto_url)
                                            <div class="shrink-0">
                                                <a href="{{ asset('storage/' . $p->foto_url) }}" target="_blank" title="Klik untuk memperbesar" class="block group/img">
                                                    <img src="{{ asset('storage/' . $p->foto_url) }}" alt="Foto Pengumuman" class="w-28 h-28 sm:w-36 sm:h-36 rounded-xl border border-slate-200 object-cover shadow-xs group-hover/img:opacity-90 transition">
                                                </a>
                                            </div>
                                        @endif

                                        <div class="flex-grow min-w-0 pr-16 sm:pr-24 space-y-2.5">
                                            <!-- Badges & Status Row -->
                                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                                <!-- Pin / Urgency Badge -->
                                                @if($p->is_pinned || in_array($p->prioritas, ['Penting', 'Urgen']))
                                                    <span class="px-2.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 text-[10px] font-extrabold rounded-md inline-flex items-center gap-1 shadow-xs">
                                                        <i class="fa-solid fa-thumbtack text-rose-600 text-[9px]"></i> {{ strtoupper($p->prioritas ?: 'PENTING') }}
                                                    </span>
                                                @endif

                                                <!-- Status Visibilitas Badge -->
                                                <span class="px-2.5 py-0.5 {{ $statusClass }} border text-[10px] font-bold rounded-md inline-flex items-center gap-1">
                                                    <i class="fa-solid {{ $statusIcon }} text-[9px]"></i> {{ $statusLabel }}
                                                </span>

                                                <!-- Target Audiens / Lab Badges -->
                                                @if($p->laboratoriums && $p->laboratoriums->count() > 0)
                                                    @foreach($p->laboratoriums as $targetLab)
                                                        <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-800 border border-indigo-200 text-[10px] font-bold rounded-md inline-flex items-center gap-1">
                                                            <i class="fa-solid fa-flask text-indigo-600 text-[9px]"></i> Lab: {{ $targetLab->nama_lab }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="px-2.5 py-0.5 bg-blue-50 text-blue-800 border border-blue-200 text-[10px] font-bold rounded-md inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-globe text-blue-600 text-[9px]"></i> Semua Lab / Umum
                                                    </span>
                                                @endif
                                            </div>

                                            <h4 class="font-bold text-sm sm:text-base text-slate-800 leading-snug">{{ $p->judul }}</h4>
                                            <p class="text-xs text-slate-650 leading-relaxed whitespace-pre-line">{{ $p->isi_pengumuman }}</p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center gap-2 absolute right-4 top-4">
                                            <button onclick='editAnnouncement(@json($p))' class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-teal-700 hover:bg-teal-50 hover:border-teal-300 text-xs transition flex items-center justify-center shadow-xs cursor-pointer" title="Edit Pengumuman">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button onclick="confirmDelete('{{ route('admin.pengumuman.delete', $p->id) }}')" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 text-xs transition flex items-center justify-center shadow-xs cursor-pointer" title="Hapus Pengumuman">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between text-[11px] text-slate-500 pt-3 border-t border-slate-200/60 gap-1">
                                        <div class="flex items-center gap-3">
                                            <span>Diterbitkan oleh: <strong class="text-slate-700">{{ $p->admin->username ?? 'Admin' }}</strong></span>
                                            <span class="text-slate-300">•</span>
                                            <span><i class="fa-solid fa-clock-rotate-left mr-1 text-slate-400"></i> {{ date('d M Y, H:i', strtotime($p->created_at)) }} WIB</span>
                                        </div>
                                        @if($p->tanggal_mulai || $p->tanggal_selesai)
                                            <div class="flex items-center gap-1.5 text-slate-600 bg-white px-2.5 py-1 rounded-md border border-slate-200 text-[10px] font-medium">
                                                <i class="fa-solid fa-calendar-range text-teal-600"></i>
                                                <span>Berlaku: {{ $p->tanggal_mulai ? date('d/m/Y H:i', strtotime($p->tanggal_mulai)) : 'Sekarang' }} s/d {{ $p->tanggal_selesai ? date('d/m/Y H:i', strtotime($p->tanggal_selesai)) : 'Tanpa Batas' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                            <div>
                                Menampilkan <span class="font-bold text-slate-800">{{ $pengumumanList->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-800">{{ $pengumumanList->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800">{{ $pengumumanList->total() }}</span> pengumuman
                            </div>
                            <div>
                                {{ $pengumumanList->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12 text-slate-400 space-y-2">
                            <i class="fa-solid fa-bullhorn text-3xl text-slate-300"></i>
                            <p class="text-xs italic">Belum ada pengumuman yang sesuai dengan filter pencarian.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <!-- ANNOUNCEMENT MODAL -->
    <div id="modal-announcement" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-ann-title" class="font-bold text-base text-slate-800">Terbitkan Pengumuman Resmi</h3>
                <button onclick="toggleModal('modal-announcement')" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">&times;</button>
            </div>
            
            <form id="ann-form" action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" id="ann-method" name="_method" value="POST">
                
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Judul Pengumuman <span class="text-rose-500">*</span></label>
                    <input type="text" id="ann-judul" name="judul" required placeholder="Masukkan judul pengumuman..." class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Isi Detail Pengumuman <span class="text-rose-500">*</span></label>
                    <textarea id="ann-isi_pengumuman" name="isi_pengumuman" rows="4" required placeholder="Tulis rincian penjelasan pengumuman di sini..." class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-medium text-slate-800 text-xs transition leading-relaxed"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Tingkat Prioritas</label>
                        <select id="ann-prioritas" name="prioritas" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none font-semibold text-slate-800 text-xs transition cursor-pointer">
                            <option value="Normal">Normal</option>
                            <option value="Penting">Penting</option>
                            <option value="Urgen">Urgen / Darurat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Opsi Sematkan</label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-slate-100 transition mt-0.5">
                            <input type="checkbox" id="ann-is_pinned" name="is_pinned" value="1" class="rounded text-teal-600 focus:ring-teal-500 cursor-pointer">
                            <span class="font-bold text-slate-700 text-xs">Pin ke Paling Atas</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Foto / Gambar Pengumuman (Opsional)</label>
                    <input type="file" id="ann-foto" name="foto" accept="image/*" class="w-full p-2 text-xs rounded-xl bg-slate-50 border border-slate-200 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-teal-100 file:text-teal-800 hover:file:bg-teal-200 cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-1">* Format: JPG, PNG, WEBP, GIF, SVG (Maks. 5MB)</p>
                    
                    <div id="ann-foto-preview-container" class="mt-2.5 hidden p-2 bg-slate-100/80 rounded-xl border border-slate-200 flex items-center gap-3">
                        <img id="ann-foto-preview" src="" alt="Pratinjau Foto" class="w-14 h-14 object-cover rounded-lg border border-slate-300 shadow-xs">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold text-slate-700 block">Foto Pengumuman Saat Ini</span>
                            <label class="inline-flex items-center gap-1.5 text-[10px] text-rose-600 font-bold cursor-pointer hover:text-rose-700">
                                <input type="checkbox" id="ann-hapus-foto" name="hapus_foto" value="1" class="rounded text-rose-600 focus:ring-rose-500">
                                <span>Hapus foto saat ini</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Mulai Berlaku (Opsional)</label>
                        <input type="datetime-local" id="ann-tanggal_mulai" name="tanggal_mulai" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-slate-800 transition">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Berakhir Pada (Opsional)</label>
                        <input type="datetime-local" id="ann-tanggal_selesai" name="tanggal_selesai" class="w-full p-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-slate-800 transition">
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-slate-700 font-bold">Target Ruangan Laboratorium</label>
                        <label class="inline-flex items-center gap-1.5 text-[10px] font-bold text-teal-800 cursor-pointer select-none hover:text-teal-900">
                            <input type="checkbox" id="select-all-labs" class="rounded text-teal-600 focus:ring-teal-500 cursor-pointer">
                            <span>Pilih Semua</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto p-2 border border-slate-200 rounded-xl bg-slate-50">
                        @foreach($laboratoriums as $lab)
                        <label class="flex items-center gap-2 cursor-pointer p-1 rounded-lg hover:bg-slate-100 transition">
                            <input type="checkbox" name="laboratorium_ids[]" value="{{ $lab->id }}" class="rounded text-teal-600 focus:ring-teal-500 lab-checkbox cursor-pointer">
                            <span class="font-medium text-slate-800">{{ $lab->nama_lab }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">* Kosongkan jika pengumuman ini ditujukan untuk semua laboratorium / umum.</p>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-announcement')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition cursor-pointer">Batal</button>
                    <button type="submit" id="ann-submit-btn" class="flex-1 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold shadow-sm transition cursor-pointer">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CONFIRM DELETE MODAL -->
    <div id="modal-confirm-delete" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-4 text-center">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div class="space-y-2">
                <h3 class="font-bold text-sm text-slate-800">Konfirmasi Hapus</h3>
                <p class="text-xs text-slate-550 leading-relaxed">Apakah Anda yakin ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <form id="delete-form" action="" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs">Batal</button>
                <button type="submit" class="flex-grow py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold text-xs shadow-sm">Hapus Pengumuman</button>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
            
            if (modalId === 'modal-announcement' && modal.classList.contains('hidden')) {
                // Reset to create mode
                document.getElementById('modal-ann-title').innerText = "Terbitkan Pengumuman Resmi";
                document.getElementById('ann-form').action = "{{ route('admin.pengumuman.store') }}";
                document.getElementById('ann-method').value = "POST";
                document.getElementById('ann-judul').value = "";
                document.getElementById('ann-isi_pengumuman').value = "";
                document.getElementById('ann-prioritas').value = "Normal";
                document.getElementById('ann-is_pinned').checked = false;
                document.getElementById('ann-tanggal_mulai').value = "";
                document.getElementById('ann-tanggal_selesai').value = "";
                document.getElementById('ann-submit-btn').innerText = "Terbitkan";
                document.getElementById('ann-foto').value = "";
                document.getElementById('ann-hapus-foto').checked = false;
                document.getElementById('ann-foto-preview-container').classList.add('hidden');
                document.getElementById('ann-foto-preview').src = "";
                if (document.getElementById('select-all-labs')) {
                    document.getElementById('select-all-labs').checked = false;
                }
                
                // Clear checkboxes
                document.querySelectorAll('input[name="laboratorium_ids[]"]').forEach(cb => cb.checked = false);
            }
        }

        function editAnnouncement(ann) {
            document.getElementById('modal-ann-title').innerText = "Edit Pengumuman Resmi";
            
            const updateUrl = `{{ url('/admin/pengumuman') }}/${ann.id}`;
            document.getElementById('ann-form').action = updateUrl;
            document.getElementById('ann-method').value = "PUT";
            
            document.getElementById('ann-judul').value = ann.judul;
            document.getElementById('ann-isi_pengumuman').value = ann.isi_pengumuman;
            document.getElementById('ann-prioritas').value = ann.prioritas || "Normal";
            document.getElementById('ann-is_pinned').checked = Boolean(ann.is_pinned);
            document.getElementById('ann-tanggal_mulai').value = ann.tanggal_mulai ? ann.tanggal_mulai.substring(0, 16) : "";
            document.getElementById('ann-tanggal_selesai').value = ann.tanggal_selesai ? ann.tanggal_selesai.substring(0, 16) : "";
            document.getElementById('ann-submit-btn').innerText = "Simpan Perubahan";
            
            document.getElementById('ann-foto').value = "";
            document.getElementById('ann-hapus-foto').checked = false;
            
            const previewContainer = document.getElementById('ann-foto-preview-container');
            const previewImg = document.getElementById('ann-foto-preview');
            if (ann.foto_url) {
                previewImg.src = `/storage/${ann.foto_url}`;
                previewContainer.classList.remove('hidden');
            } else {
                previewImg.src = "";
                previewContainer.classList.add('hidden');
            }
            
            // Set checkboxes
            const labIds = ann.laboratoriums ? ann.laboratoriums.map(l => l.id.toString()) : [];
            document.querySelectorAll('input[name="laboratorium_ids[]"]').forEach(cb => {
                cb.checked = labIds.includes(cb.value);
            });
            
            toggleModal('modal-announcement');
        }

        const selectAllLabs = document.getElementById('select-all-labs');
        const labCbs = document.querySelectorAll('.lab-checkbox');
        if (selectAllLabs) {
            selectAllLabs.addEventListener('change', function() {
                labCbs.forEach(cb => cb.checked = selectAllLabs.checked);
            });
        }

        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Hapus Pengumuman?',
                text: 'Apakah Anda yakin ingin menghapus pengumuman ini?',
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
                    const form = document.getElementById('delete-form');
                    if (form) {
                        form.action = deleteUrl;
                        form.dataset.confirmed = "true";
                        form.submit();
                    }
                }
            });
        }

        function closeDeleteModal() {
            document.getElementById('modal-confirm-delete').classList.add('hidden');
        }
    </script>

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
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




