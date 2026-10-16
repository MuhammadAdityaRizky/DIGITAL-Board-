<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Display Laboratorium - UIKA Smart Lab</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f4f9;
            color: #1e293b;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .card-shadow {
            box-shadow: 0 4px 20px -2px rgba(12, 78, 166, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.04);
        }
        .card-shadow:hover {
            box-shadow: 0 12px 28px -4px rgba(12, 78, 166, 0.12), 0 4px 12px -2px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between p-4 sm:p-6 md:p-8 antialiased selection:bg-[#0c4ea6] selection:text-white">

    <!-- Top Navbar Header -->
    <header class="w-full max-w-6xl mx-auto bg-white border border-slate-200 rounded-2xl p-4 sm:px-6 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4 mb-8">
        <!-- Logo & Campus Info -->
        <div class="flex items-center gap-3.5">
            <img src="{{ asset('images/logo-uika.png') }}" 
                 alt="Logo UIKA" 
                 style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; object-fit: contain;" 
                 class="w-12 h-12 object-contain shrink-0">
            <div>
                <h1 class="font-extrabold text-slate-900 text-sm sm:text-base tracking-wide leading-tight uppercase">
                    UNIVERSITAS IBN KHALDUN BOGOR
                </h1>
                <p class="text-xs font-bold text-[#0c4ea6] tracking-wider uppercase flex items-center gap-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-[#00b87c] inline-block"></span>
                    Digital Information Board Portal
                </p>
            </div>
        </div>

        <!-- Action Button -->
        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
            @auth
                @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-4 py-2.5 rounded-xl border border-teal-200 bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold text-xs transition duration-200 shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-gauge text-teal-700"></i>
                        <span>Panel Admin</span>
                    </a>
                @elseif(auth()->user()->role === 'dosen')
                    <a href="{{ route('dosen.dashboard') }}" 
                       class="px-4 py-2.5 rounded-xl border border-teal-200 bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold text-xs transition duration-200 shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-gauge text-teal-700"></i>
                        <span>Panel Dosen</span>
                    </a>
                @elseif(auth()->user()->role === 'mahasiswa')
                    <a href="{{ route('mahasiswa.dashboard') }}" 
                       class="px-4 py-2.5 rounded-xl border border-teal-200 bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold text-xs transition duration-200 shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-gauge text-teal-700"></i>
                        <span>Panel Mahasiswa</span>
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-3.5 py-2.5 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition duration-200 shadow-sm flex items-center gap-1.5" title="Keluar dari sistem">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="px-4 py-2.5 rounded-xl border border-slate-200 hover:border-[#0c4ea6]/40 bg-slate-50 hover:bg-white text-slate-700 hover:text-[#0c4ea6] font-bold text-xs transition duration-200 shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-user-shield text-[#0c4ea6]"></i>
                    <span>Login Staff / Dosen</span>
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Container -->
    <main class="w-full max-w-6xl mx-auto flex-grow flex flex-col justify-center py-2 sm:py-6">
        
        <!-- Hero Title Section -->
        <div class="text-center max-w-2xl mx-auto mb-8 space-y-2.5">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#00b87c]/10 text-[#0b8a5a] border border-[#00b87c]/20 text-[11px] font-extrabold uppercase tracking-wider rounded-full">
                <i class="fa-solid fa-desktop text-xs"></i> Select Kiosk Monitor
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                Papan Informasi Laboratorium
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                Pilih ruang laboratorium untuk membuka tampilan layar papan informasi perkuliahan, agenda dosen, dan pengumuman secara real-time.
            </p>
        </div>

        <!-- Search & Faculty Filter Control Bar (Compact & Sleek) -->
        <div class="w-full max-w-2xl mx-auto mb-7 space-y-2">
            <div class="flex flex-col sm:flex-row items-center gap-2.5">
                <!-- Search Bar -->
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </div>
                    <input type="text" id="labSearch" placeholder="Cari nama lab atau lokasi ruangan..." 
                           class="w-full pl-9 pr-3.5 py-2 h-10 bg-white border border-slate-200/90 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/15 focus:border-[#0c4ea6] shadow-2xs transition">
                </div>

                <!-- Faculty Filter Dropdown -->
                <div class="relative w-full sm:w-64 shrink-0">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-building-columns text-xs"></i>
                    </div>
                    <select id="fakultasFilter" 
                            class="w-full pl-9 pr-8 py-2 h-10 bg-white border border-slate-200/90 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/15 focus:border-[#0c4ea6] shadow-2xs transition appearance-none cursor-pointer truncate">
                        <option value="all">Semua Fakultas / Gedung</option>
                        @if(isset($fakultas))
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">Fakultas {{ $f->nama_fakultas }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Status & Quick Reset -->
            <div class="flex items-center justify-between text-[11px] text-slate-400 px-1 font-medium">
                <span>
                    Menampilkan <strong id="labCountDisplay" class="text-slate-700 font-bold">{{ $labs->count() }}</strong> dari <span class="font-bold text-slate-700">{{ $labs->count() }}</span> lab
                </span>
                <button type="button" id="btnResetFilter" onclick="resetFilters()" class="text-[#0c4ea6] hover:text-[#093d84] font-bold text-[11px] inline-flex items-center gap-1 transition hidden cursor-pointer">
                    <i class="fa-solid fa-rotate-left text-[10px]"></i>
                    <span>Reset Filter</span>
                </button>
            </div>
        </div>

        <!-- Lab Display Cards Grid -->
        <div id="labGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($labs as $lab)
                <div class="lab-card bg-white border border-slate-200 rounded-3xl p-6 flex flex-col justify-between gap-5 card-shadow transition duration-200 relative overflow-hidden" 
                     data-fakultas-id="{{ $lab->fakultas_id ?? '' }}"
                     data-fakultas-name="{{ strtolower($lab->fakultas->nama_fakultas ?? '') }}"
                     data-location="{{ strtolower($lab->lokasi ?? '') }}" 
                     data-name="{{ strtolower($lab->nama_lab ?? '') }}">
                    
                    <!-- Top Status Bar -->
                    <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0c4ea6] shrink-0">
                                <i class="fa-solid fa-chalkboard-user text-base"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-extrabold text-slate-400 tracking-wider uppercase block">Ruang Laboratorium</span>
                                <h3 class="font-extrabold text-slate-900 text-base tracking-tight leading-snug lab-title-text">{{ $lab->nama_lab }}</h3>
                            </div>
                        </div>

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Display Active
                        </span>
                    </div>

                    <!-- Room Specs & Details -->
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                            @if($lab->fakultas)
                                <span class="px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-200/60 rounded-lg flex items-center gap-1.5 font-bold">
                                    <i class="fa-solid fa-building-columns text-teal-600"></i>
                                    {{ $lab->fakultas->nama_fakultas }}
                                </span>
                            @endif
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg flex items-center gap-1.5 lab-loc-text">
                                <i class="fa-solid fa-location-dot text-rose-500"></i>
                                {{ $lab->lokasi }}
                            </span>
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg flex items-center gap-1.5">
                                <i class="fa-solid fa-chair text-slate-500"></i>
                                {{ $lab->kapasitas ?: 30 }} Kursi
                            </span>
                        </div>

                        <p class="text-slate-500 text-xs leading-relaxed">
                            Monitor papan informasi digital aktif untuk menampilkan jadwal perkuliahan, status presensi dosen, dan pengumuman.
                        </p>
                    </div>

                    <!-- Action Launch Monitor -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <span class="text-[11px] font-bold text-slate-400 flex items-center">
                            <i class="fa-solid fa-desktop text-[#0c4ea6] mr-1.5 text-xs"></i> Live Kiosk Mode
                        </span>
                        
                        <a href="{{ route('board.lab', $lab->id) }}" 
                           class="px-4 py-2.5 bg-[#0c4ea6] hover:bg-[#0a3f86] text-white font-bold text-xs rounded-xl transition duration-200 flex items-center gap-2 shadow-sm hover:shadow-md">
                            <span>Buka Monitor Board</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            <!-- Empty Filter Result State -->
            <div id="emptyFilterState" class="col-span-full py-16 text-center bg-white border border-dashed border-slate-300 rounded-3xl p-8 hidden">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shadow-2xs">
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                </div>
                <h4 class="font-extrabold text-slate-900 text-sm mb-1">Tidak Ada Laboratorium yang Cocok</h4>
                <p class="text-slate-500 text-xs max-w-md mx-auto">
                    Tidak ditemukan laboratorium untuk gedung fakultas atau kata kunci pencarian yang dipilih.
                </p>
                <button type="button" onclick="resetFilters()" class="mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition inline-flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Tampilkan Semua Lab</span>
                </button>
            </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white border border-dashed border-slate-300 rounded-3xl p-8">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm mb-1">Belum Ada Laboratorium</h4>
                    <p class="text-slate-500 text-xs">Silakan tambahkan data laboratorium melalui Dashboard Admin.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-6xl mx-auto border-t border-slate-200 pt-6 mt-8 text-slate-500 text-xs font-semibold flex flex-col sm:flex-row justify-between items-center gap-3">
        <p>&copy; {{ date('Y') }} Universitas Ibn Khaldun Bogor. All Rights Reserved.</p>
        <p class="text-slate-400 text-[11px]">Computer Laboratory Digital Information Board System</p>
    </footer>

    <!-- Interactive Search & Faculty Filter JS -->
    <script>
        const searchInput = document.getElementById('labSearch');
        const fakultasSelect = document.getElementById('fakultasFilter');
        const btnReset = document.getElementById('btnResetFilter');
        const countDisplay = document.getElementById('labCountDisplay');
        const emptyFilterState = document.getElementById('emptyFilterState');
        const cards = document.querySelectorAll('.lab-card');

        function updateDisplay() {
            const query = (searchInput?.value || '').toLowerCase().trim();
            const selectedFakultas = fakultasSelect ? fakultasSelect.value : 'all';
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const location = card.dataset.location || '';
                const fakultasId = card.dataset.fakultasId || '';
                const fakultasName = card.dataset.fakultasName || '';

                const matchesQuery = !query || name.includes(query) || location.includes(query) || fakultasName.includes(query);
                const matchesFakultas = selectedFakultas === 'all' || fakultasId === selectedFakultas;

                if (matchesQuery && matchesFakultas) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (countDisplay) {
                countDisplay.textContent = visibleCount;
            }

            if (emptyFilterState) {
                emptyFilterState.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
            }

            if (btnReset) {
                if (query !== '' || selectedFakultas !== 'all') {
                    btnReset.classList.remove('hidden');
                } else {
                    btnReset.classList.add('hidden');
                }
            }
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (fakultasSelect) fakultasSelect.value = 'all';
            updateDisplay();
        }

        searchInput?.addEventListener('input', updateDisplay);
        fakultasSelect?.addEventListener('change', updateDisplay);
    </script>
</body>
</html>
