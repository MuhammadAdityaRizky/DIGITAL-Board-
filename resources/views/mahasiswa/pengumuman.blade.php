<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Lab - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-10 h-10 object-contain shrink-0">
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold tracking-wider text-teal-400">Portal Mahasiswa</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-qrcode"></i>
                <span class="text-xs font-semibold tracking-wide">Absensi Mandiri</span>
            </a>
            <a href="{{ route('mahasiswa.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda Kuliah</span>
            </a>
            <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="text-xs font-semibold tracking-wide">Riwayat Kehadiran</span>
            </a>
            <a href="{{ route('mahasiswa.pengumuman') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-bullhorn"></i>
                <span class="text-xs font-semibold tracking-wide">Pengumuman</span>
            </a>
        </nav>

        <!-- Tombol Panduan Mahasiswa di Sidebar -->
        <div class="p-3 border-t border-slate-800 mt-auto">
            <button type="button" onclick="openTutorialMahasiswaModal()" class="flex items-center gap-3 px-3.5 py-2.5 bg-amber-500/15 border border-amber-500/30 text-amber-300 hover:bg-amber-500/25 hover:text-white rounded-xl w-full transition text-xs font-bold cursor-pointer">
                <i class="fa-solid fa-book-open-reader text-sm text-amber-400"></i>
                <span>Panduan Mahasiswa</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Pengumuman Laboratorium</h2>
            </div>

            <div class="flex items-center gap-2.5">
                <!-- Tombol Panduan / Tutorial Mahasiswa -->
                <button type="button" onclick="openTutorialMahasiswaModal()" class="flex items-center gap-2 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-900 rounded-xl text-xs font-extrabold transition shadow-2xs cursor-pointer" title="Buka Panduan & Tutorial Mahasiswa">
                    <i class="fa-solid fa-circle-question text-amber-600 text-sm"></i>
                    <span class="hidden sm:inline">Panduan Sistem</span>
                </button>

                <!-- Profile Avatar & Dropdown Menu -->
                <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ $mahasiswa->nama_lengkap }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIM: {{ $mahasiswa->nim }} • {{ $mahasiswa->prodi->nama_prodi ?? 'Mahasiswa' }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ substr($mahasiswa->nama_lengkap, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $mahasiswa->nama_lengkap }}</p>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">NIM: {{ $mahasiswa->nim }}</p>
                        <span class="inline-block mt-1.5 px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200/60 rounded-md text-[9px] font-bold">
                            Mahasiswa • {{ $mahasiswa->kelas ?? 'Reguler' }}
                        </span>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('mahasiswa.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800 transition font-medium group">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-700 flex items-center justify-center text-slate-500 transition">
                                <i class="fa-solid fa-gear text-xs"></i>
                            </div>
                            <div>
                                <span class="font-bold block">Pengaturan Akun</span>
                                <span class="text-[10px] text-slate-400 block font-normal">Edit profil & ganti password</span>
                            </div>
                        </a>
                    </div>

                    <div class="pt-1 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 transition font-bold text-left group">
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
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-5 pb-24">
            
            <!-- Mobile Profile Summary Card -->
            <div class="bg-teal-50 border border-teal-100 rounded-2xl p-4 flex items-center gap-4 lg:hidden shadow-sm">
                <div class="w-12 h-12 rounded-full bg-teal-850 text-white font-bold flex items-center justify-center text-lg shrink-0">
                    {{ substr($mahasiswa->nama_lengkap, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $mahasiswa->nama_lengkap }}</h4>
                    <p class="text-[10px] font-semibold text-slate-500 mt-0.5">NIM: {{ $mahasiswa->nim }}</p>
                    <p class="text-[9px] text-slate-450 mt-1 font-medium">
                        Kelas: {{ $mahasiswa->kelas ?: '-' }} • Semester: {{ $mahasiswa->semester ?: '-' }} • {{ $mahasiswa->prodi->nama_prodi ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Alert Notifications -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-2xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Informasi:</span>
                        <p class="mt-0.5">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-xmark text-red-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Header Title & Compact Search Bar -->
            <div class="flex flex-col sm:flex-row gap-3.5 items-start sm:items-center justify-between">
                <div>
                    <h2 class="font-extrabold text-base text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-teal-700"></i>
                        <span>Pengumuman Laboratorium</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Informasi resmi, agenda kegiatan, dan ketentuan praktikum</p>
                </div>

                <!-- Compact Search Form -->
                <form action="{{ route('mahasiswa.pengumuman') }}" method="GET" class="relative w-full sm:w-80">
                    <div class="relative flex items-center">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-xs pointer-events-none"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari pengumuman, topik, atau lab..." 
                               class="w-full pl-9 pr-9 py-2 bg-white hover:bg-slate-50 focus:bg-white border border-slate-200 focus:border-teal-700 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-700/20 shadow-2xs transition">
                        @if(request('search'))
                            <a href="{{ route('mahasiswa.pengumuman') }}" class="absolute right-3 text-slate-400 hover:text-rose-500 transition text-xs p-0.5" title="Reset pencarian">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Compact List Card Container (Format Baris Horizontal: Paling Rapi & Hemat Ruang di HP) -->
            <div class="space-y-2.5 sm:space-y-3">
                @if(isset($pengumuman) && count($pengumuman) > 0)
                    @foreach($pengumuman as $p)
                        @php
                            $isBaru = now()->diffInDays($p->created_at) <= 3;
                            $isPinned = (bool)$p->is_pinned;
                            $tglSingkat = date('d M Y', strtotime($p->created_at));
                            $tglLengkap = \Carbon\Carbon::parse($p->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
                            $labsArr = $p->laboratoriums->pluck('nama_lab')->toArray();
                        @endphp
                        
                        <div onclick="openPengumumanModal({{ json_encode([
                                'id' => $p->id,
                                'judul' => $p->judul,
                                'isi' => $p->isi_pengumuman,
                                'foto_url' => $p->foto_url ? asset('storage/' . $p->foto_url) : null,
                                'tanggal' => $tglSingkat,
                                'tanggal_lengkap' => $tglLengkap,
                                'admin' => $p->admin->name ?? 'Admin Laboratorium',
                                'prioritas' => $p->prioritas ?? 'Umum',
                                'is_pinned' => $isPinned,
                                'is_baru' => $isBaru,
                                'labs' => $labsArr
                            ]) }})" 
                            class="group bg-white hover:bg-slate-50/80 border border-slate-200/90 hover:border-teal-700/40 rounded-2xl p-2.5 sm:p-3 transition-all duration-200 shadow-2xs hover:shadow-xs cursor-pointer flex items-center gap-3 sm:gap-3.5 relative overflow-hidden"
                            title="Klik untuk membaca pengumuman lengkap">

                            <!-- KIRI: Foto thumbnail kotak kecil (~72x72px atau 80x72px) -->
                            <div class="w-[72px] h-[72px] sm:w-[80px] sm:h-[72px] rounded-xl overflow-hidden relative shrink-0 shadow-2xs border border-slate-200/90 bg-slate-950 flex items-center justify-center">
                                @if($p->foto_url)
                                    <!-- Ambient blurred backdrop (mencegah black bar kaku) -->
                                    <img src="{{ asset('storage/' . $p->foto_url) }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xs opacity-40 scale-125">
                                    <!-- Foto Utama 100% Utuh (object-contain, tidak terpotong) -->
                                    <img src="{{ asset('storage/' . $p->foto_url) }}" 
                                         alt="{{ $p->judul }}" 
                                         class="relative z-10 max-w-full max-h-full object-contain p-0.5 drop-shadow-xs transition-transform duration-300 group-hover:scale-105">
                                    <span class="absolute bottom-1 left-1 z-20 px-1 py-0.2 bg-black/60 backdrop-blur-xs text-white text-[7.5px] font-bold rounded">
                                        Poster
                                    </span>
                                @else
                                    <!-- Fallback jika tanpa foto: gradient card icon UIKA/Megaphone -->
                                    <div class="w-full h-full bg-linear-to-br from-teal-850 to-slate-900 flex flex-col items-center justify-center text-teal-300 p-1">
                                        <i class="fa-solid fa-bullhorn text-lg drop-shadow-xs"></i>
                                        <span class="text-[7.5px] font-bold text-teal-200/80 mt-1 uppercase tracking-wider">Info</span>
                                    </div>
                                @endif
                            </div>

                            <!-- KANAN: Judul tebal, baris teks cuplikan ringkas, badge Baru dan tanggal -->
                            <div class="flex-1 min-w-0 flex flex-col justify-center space-y-1">
                                
                                <!-- Baris Atas: Badge Baru / Wajib & Tanggal & Lab -->
                                <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                                    @if($isPinned)
                                        <span class="px-1.5 py-0.2 bg-rose-50 text-rose-700 border border-rose-200 text-[9px] font-black rounded uppercase tracking-wider">
                                            Wajib
                                        </span>
                                    @endif

                                    @if($isBaru)
                                        <span class="px-1.5 py-0.2 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-black rounded uppercase tracking-wider inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Baru
                                        </span>
                                    @endif

                                    <span class="text-[10.5px] sm:text-[11px] font-semibold text-slate-400 inline-flex items-center gap-1">
                                        <i class="fa-regular fa-calendar text-[9.5px]"></i>
                                        {{ $tglSingkat }}
                                    </span>

                                    @if(count($labsArr) > 0)
                                        <span class="text-[9.5px] font-bold text-slate-500 bg-slate-100 px-1.5 py-0.2 rounded border border-slate-200/80 truncate max-w-[130px]">
                                            {{ implode(', ', $labsArr) }}
                                        </span>
                                    @else
                                        <span class="text-[9.5px] font-medium text-slate-400 bg-slate-50 px-1.5 py-0.2 rounded border border-slate-200/60 hidden sm:inline-block">
                                            Semua Lab
                                        </span>
                                    @endif
                                </div>

                                <!-- Judul Tebal -->
                                <h4 class="font-extrabold text-slate-850 text-xs sm:text-[13.5px] leading-snug line-clamp-1 group-hover:text-teal-850 transition" title="{{ $p->judul }}">
                                    {{ $p->judul }}
                                </h4>

                                <!-- Baris Teks Cuplikan Ringkas -->
                                <p class="text-[11px] text-slate-500 line-clamp-1 leading-normal">
                                    {{ Str::limit(strip_tags($p->isi_pengumuman), 95) }}
                                </p>
                            </div>

                            <!-- Right Chevron Indicator (Desktop & Tablet) -->
                            <div class="shrink-0 text-slate-300 group-hover:text-teal-700 group-hover:translate-x-0.5 transition hidden sm:flex items-center pr-1.5">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </div>

                        </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center space-y-3 shadow-2xs">
                        <div class="w-14 h-14 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center mx-auto text-slate-300">
                            <i class="fa-solid fa-bullhorn text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-700 text-sm">Tidak Ada Pengumuman</h4>
                            <p class="text-xs text-slate-400 mt-1">Saat ini belum ada pengumuman laboratorium yang diterbitkan.</p>
                        </div>
                        @if(request('search'))
                            <div>
                                <a href="{{ route('mahasiswa.pengumuman') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                                    <i class="fa-solid fa-rotate-left text-[10px]"></i> Reset Pencarian
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

        </div>
    </main>

    <!-- Modal Detail Baca Pengumuman Lengkap -->
    <div id="modal-detail-pengumuman" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden" onclick="closePengumumanModal()">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-lg w-full max-h-[90vh] flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200" onclick="event.stopPropagation()">
            
            <!-- Modal Header -->
            <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between shrink-0 bg-slate-50/50">
                <div class="flex items-center gap-2" id="modal-badges-container">
                    <!-- Badges populated by JS -->
                </div>
                <button type="button" onclick="closePengumumanModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="p-5 sm:p-6 overflow-y-auto space-y-4">
                <!-- Full Title -->
                <h3 id="modal-title" class="font-extrabold text-slate-900 text-base sm:text-lg leading-snug"></h3>

                <!-- Meta info: Date & Publisher -->
                <div class="flex items-center justify-between text-xs text-slate-500 pb-3 border-b border-slate-100">
                    <span id="modal-date" class="font-semibold text-slate-600"></span>
                    <span id="modal-admin" class="text-slate-400"></span>
                </div>

                <!-- Full Image Preview (If exists) -->
                <div id="modal-image-wrapper" class="hidden rounded-2xl overflow-hidden border border-slate-200/90 bg-slate-950 max-h-72 flex items-center justify-center relative group">
                    <img id="modal-image-blur" src="" alt="" class="absolute inset-0 w-full h-full object-cover blur-xs opacity-40 scale-125">
                    <img id="modal-image" src="" alt="Poster Pengumuman" class="relative z-10 max-w-full max-h-72 object-contain p-1">
                    <a id="modal-image-link" href="" target="_blank" class="absolute bottom-2.5 right-2.5 z-20 px-2.5 py-1 bg-black/70 hover:bg-black/90 backdrop-blur-xs text-white text-[10px] font-bold rounded-lg transition flex items-center gap-1 shadow-sm">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i> Lihat HD
                    </a>
                </div>

                <!-- Full Text Content -->
                <div class="text-slate-700 text-xs sm:text-sm leading-relaxed whitespace-pre-line font-normal" id="modal-content"></div>

                <!-- Target Lab -->
                <div id="modal-labs-wrapper" class="pt-3 border-t border-slate-100 flex items-center gap-2 flex-wrap text-xs text-slate-500">
                    <span class="font-bold text-slate-600">Ditujukan untuk:</span>
                    <div id="modal-labs-list" class="flex items-center gap-1.5 flex-wrap"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 flex justify-end shrink-0">
                <button type="button" onclick="closePengumumanModal()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical 4-tab layout with Center Scan QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-semibold">Dashboard</span>
        </a>
        <a href="{{ route('mahasiswa.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-medium">Agenda</span>
        </a>
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-800 text-white rounded-2xl shadow-xl border-4 border-white">
            <button type="button" onclick="startMahasiswaQRScanner()" class="flex items-center justify-center w-full h-full text-white bg-teal-800 rounded-xl hover:bg-teal-900 transition-all" title="Scan QR Presensi">
                <i class="fa-solid fa-qrcode text-2xl text-white"></i>
            </button>
        </div>
        <a href="{{ route('mahasiswa.riwayat') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            <span class="text-[9px] font-semibold">Riwayat</span>
        </a>
        <a href="{{ route('mahasiswa.pengumuman') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-bullhorn text-lg"></i>
            <span class="text-[9px] font-bold">Pengumuman</span>
        </a>
    </nav>

    <!-- Hidden form for QR attendance submission -->
    <form id="mahasiswa-absensi-form" action="{{ route('mahasiswa.absensi.submit') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="qr_code_token" id="mahasiswa-qr-token-input">
    </form>

    <!-- QR Scanner Modal -->
    <div id="modal-qr-scanner" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100 text-slate-800">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i class="fa-solid fa-camera text-teal-800"></i> Pindai QR Code Presensi
                </h3>
                <button type="button" onclick="closeScannerModal()" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">&times;</button>
            </div>
            
            <div class="space-y-4">
                <div id="qr-reader" class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 w-full" style="min-height: 250px;"></div>
                
                <p class="text-xs text-slate-500 text-center">
                    Arahkan kamera HP ke QR Code yang ditampilkan pada Digital Board laboratorium.
                </p>
            </div>
            
            <div class="pt-2 flex justify-end">
                <button type="button" onclick="closeScannerModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts: Modal Pengumuman & QR Scanner -->
    <script>
        // Modal Pengumuman Controller
        function openPengumumanModal(data) {
            const modal = document.getElementById('modal-detail-pengumuman');
            if (!modal) return;

            document.getElementById('modal-title').textContent = data.judul || '';
            document.getElementById('modal-content').textContent = data.isi || '';
            document.getElementById('modal-date').textContent = data.tanggal_lengkap || data.tanggal || '';
            document.getElementById('modal-admin').textContent = 'Diterbitkan oleh: ' + (data.admin || 'Admin Lab');

            // Badges
            const badgeContainer = document.getElementById('modal-badges-container');
            let badgesHtml = '';
            if (data.is_pinned) {
                badgesHtml += '<span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 text-[9.5px] font-black rounded uppercase">Wajib</span>';
            }
            if (data.is_baru) {
                badgesHtml += '<span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9.5px] font-black rounded uppercase inline-flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Baru</span>';
            }
            badgesHtml += '<span class="px-2 py-0.5 bg-teal-50 text-teal-800 border border-teal-200/80 text-[9.5px] font-bold rounded uppercase">Pengumuman</span>';
            badgeContainer.innerHTML = badgesHtml;

            // Image
            const imgWrapper = document.getElementById('modal-image-wrapper');
            const imgBlur = document.getElementById('modal-image-blur');
            const imgMain = document.getElementById('modal-image');
            const imgLink = document.getElementById('modal-image-link');
            if (data.foto_url) {
                imgBlur.src = data.foto_url;
                imgMain.src = data.foto_url;
                imgLink.href = data.foto_url;
                imgWrapper.classList.remove('hidden');
            } else {
                imgWrapper.classList.add('hidden');
            }

            // Labs
            const labsWrapper = document.getElementById('modal-labs-wrapper');
            const labsList = document.getElementById('modal-labs-list');
            if (data.labs && data.labs.length > 0) {
                labsList.innerHTML = data.labs.map(lab => `<span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[10px] font-bold border border-slate-200">${lab}</span>`).join('');
                labsWrapper.classList.remove('hidden');
            } else {
                labsList.innerHTML = '<span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[10px] font-bold border border-slate-200">Semua Laboratorium</span>';
                labsWrapper.classList.remove('hidden');
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closePengumumanModal() {
            const modal = document.getElementById('modal-detail-pengumuman');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePengumumanModal();
                closeScannerModal();
            }
        });

        // Profile Dropdown Handler
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const wrapper = document.getElementById('profileDropdownWrapper');
            const menu = document.getElementById('profileDropdownMenu');
            if (wrapper && menu && !wrapper.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // QR Scanner Logic
        let html5QrcodeScanner = null;

        function startMahasiswaQRScanner() {
            const modalEl = document.getElementById('modal-qr-scanner');
            if (!modalEl) return;
            modalEl.classList.remove('hidden');
            
            if (typeof Html5Qrcode === 'undefined') {
                alert("Scanner QR belum siap. Silakan muat ulang halaman.");
                closeScannerModal();
                return;
            }

            html5QrcodeScanner = new Html5Qrcode("qr-reader");
            const config = { fps: 10, qrbox: { width: 220, height: 220 } };
            
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    let cameraId = devices[0].id;
                    for (let i = 0; i < devices.length; i++) {
                        const label = devices[i].label.toLowerCase();
                        if (label.includes('back') || label.includes('belakang') || label.includes('rear') || label.includes('environment')) {
                            cameraId = devices[i].id;
                            break;
                        }
                    }

                    html5QrcodeScanner.start(
                        cameraId,
                        config,
                        (decodedText) => {
                            let inputToken = document.getElementById('mahasiswa-qr-token-input');
                            if (inputToken) inputToken.value = decodedText;
                            document.getElementById('mahasiswa-absensi-form').submit();
                            closeScannerModal();
                        },
                        () => {}
                    ).catch((err) => {
                        console.error("Gagal kamera: ", err);
                        closeScannerModal();
                    });
                }
            }).catch(() => {
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText) => {
                        let inputToken = document.getElementById('mahasiswa-qr-token-input');
                        if (inputToken) inputToken.value = decodedText;
                        document.getElementById('mahasiswa-absensi-form').submit();
                        closeScannerModal();
                    },
                    () => {}
                ).catch(() => {
                    closeScannerModal();
                });
            });
        }

        function closeScannerModal() {
            const modalEl = document.getElementById('modal-qr-scanner');
            if (modalEl) modalEl.classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch(() => {});
            }
        }
    </script>

    @include('mahasiswa.partials.modal_tutorial')
</body>
</html>
