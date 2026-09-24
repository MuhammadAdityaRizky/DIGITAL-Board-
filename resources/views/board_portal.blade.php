<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Kiosk Digital Board - Universitas Ibn Khaldun Bogor</title>

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

        <!-- Admin Info & Navigation Actions -->
        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end flex-wrap">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="px-3 py-1.5 bg-blue-50 border border-blue-200 rounded-xl flex items-center gap-2 text-xs font-bold text-[#0c4ea6]">
                    <i class="fa-solid fa-user-gear"></i>
                    <span>Admin: {{ auth()->user()->name ?: (auth()->user()->username ?: 'Administrator') }}</span>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-4 py-2 bg-[#0c4ea6] hover:bg-[#0a3f86] text-white font-bold text-xs rounded-xl transition shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Dashboard Admin</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 font-bold text-xs rounded-xl transition flex items-center gap-1">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                   class="px-4 py-2.5 rounded-xl border border-slate-200 hover:border-[#0c4ea6]/40 bg-slate-50 hover:bg-white text-slate-700 hover:text-[#0c4ea6] font-bold text-xs transition duration-200 shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-user-shield text-[#0c4ea6]"></i>
                    <span>Login Administrator</span>
                </a>
            @endif
        </div>
    </header>

    <!-- Main Container -->
    <main class="w-full max-w-6xl mx-auto flex-grow flex flex-col justify-center py-2 sm:py-6">
        
        <!-- Hero Title Section -->
        <div class="text-center max-w-2xl mx-auto mb-8 space-y-2.5">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-[#00b87c]/10 text-[#0b8a5a] border border-[#00b87c]/20 text-[11px] font-extrabold uppercase tracking-wider rounded-full">
                <i class="fa-solid fa-desktop text-xs"></i> Portal Kiosk Monitor Digital Board
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                Papan Informasi Digital Per Fakultas
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                Pilih ruang laboratorium atau gunakan filter fakultas di bawah ini untuk membuka layar monitor papan informasi perkuliahan &amp; pengumuman secara real-time.
            </p>
        </div>

        <!-- Filter & Search Controls -->
        <div class="w-full max-w-4xl mx-auto mb-8 space-y-3.5">
            <!-- Search Bar & Dropdown Select -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Search Input -->
                <div class="relative sm:col-span-2">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" id="labSearch" placeholder="Cari nama lab, lokasi gedung, atau fakultas..." 
                           class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/20 focus:border-[#0c4ea6] shadow-sm transition">
                </div>

                <!-- Fakultas Dropdown Select -->
                <div class="relative">
                    <i class="fa-solid fa-building-columns absolute left-3.5 top-1/2 -translate-y-1/2 text-[#0c4ea6] text-xs pointer-events-none"></i>
                    <select id="fakultasFilter" 
                            class="w-full pl-9 pr-8 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/20 focus:border-[#0c4ea6] shadow-sm appearance-none cursor-pointer transition">
                        <option value="">🏢 Semua Fakultas</option>
                        @foreach($fakultas as $f)
                            <option value="{{ strtolower($f->nama_fakultas) }}">{{ $f->nama_fakultas }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
            </div>

            <!-- Quick Filter Pills for Fakultas -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none text-xs font-semibold">
                <span class="text-slate-400 text-[11px] font-bold uppercase tracking-wider shrink-0 mr-1">Filter Fakultas:</span>
                <button type="button" onclick="setFakultasFilter('')" class="fakultas-pill px-3 py-1.5 rounded-xl border border-[#0c4ea6] bg-[#0c4ea6] text-white font-bold transition shrink-0 cursor-pointer" data-val="">
                    Semua
                </button>
                @foreach($fakultas as $f)
                    @php
                        preg_match('/\(([^)]+)\)/', $f->nama_fakultas, $matches);
                        $shortName = $matches[1] ?? $f->nama_fakultas;
                    @endphp
                    <button type="button" onclick="setFakultasFilter('{{ strtolower($f->nama_fakultas) }}')" 
                            class="fakultas-pill px-3 py-1.5 rounded-xl border border-slate-200 bg-white text-slate-700 hover:border-[#0c4ea6]/40 hover:text-[#0c4ea6] font-bold transition shrink-0 cursor-pointer" 
                            data-val="{{ strtolower($f->nama_fakultas) }}">
                        {{ $shortName }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Lab Display Cards Grid -->
        <div id="labGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($labs as $lab)
                <div class="lab-card bg-white border border-slate-200 rounded-3xl p-6 flex flex-col justify-between gap-5 card-shadow transition duration-200 relative overflow-hidden" 
                     data-location="{{ strtolower($lab->lokasi) }}" 
                     data-name="{{ strtolower($lab->nama_lab) }}"
                     data-fakultas="{{ strtolower($lab->fakultas?->nama_fakultas ?? '') }}">
                    
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
                        <span class="text-[11px] font-bold text-slate-400">
                            <i class="fa-solid fa-desktop text-slate-400 mr-1"></i> Live Kiosk Mode
                        </span>
                        
                        <a href="{{ route('board.lab', $lab->id) }}" 
                           class="px-4 py-2.5 bg-[#0c4ea6] hover:bg-[#0a3f86] text-white font-bold text-xs rounded-xl transition duration-200 flex items-center gap-2 shadow-sm hover:shadow-md">
                            <span>Buka Monitor Board</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
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

            <!-- No Filter Result Message -->
            <div id="noFilterResult" class="hidden col-span-full py-14 text-center bg-white border border-dashed border-slate-300 rounded-3xl p-8">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-blue-50 text-[#0c4ea6] flex items-center justify-center text-xl">
                    <i class="fa-solid fa-filter"></i>
                </div>
                <h4 class="font-bold text-slate-800 text-sm mb-1">Tidak Ada Laboratorium Ditemukan</h4>
                <p class="text-slate-500 text-xs">Tidak ada laboratorium yang sesuai dengan pencarian atau filter fakultas yang dipilih.</p>
                <button type="button" onclick="setFakultasFilter(''); if(document.getElementById('labSearch')) document.getElementById('labSearch').value='';" 
                        class="mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Reset Filter &amp; Pencarian
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-6xl mx-auto border-t border-slate-200 pt-6 mt-8 text-slate-500 text-xs font-semibold flex flex-col sm:flex-row justify-between items-center gap-3">
        <p>&copy; {{ date('Y') }} Universitas Ibn Khaldun Bogor. All Rights Reserved.</p>
        <p class="text-slate-400 text-[11px]">Computer Laboratory Digital Information Board System</p>
    </footer>

    <!-- Interactive Search & Filter JS -->
    <script>
        const searchInput = document.getElementById('labSearch');
        const fakultasFilter = document.getElementById('fakultasFilter');
        let activeFakultas = '';

        function setFakultasFilter(val) {
            activeFakultas = val.toLowerCase().trim();
            if (fakultasFilter) {
                fakultasFilter.value = activeFakultas;
            }
            document.querySelectorAll('.fakultas-pill').forEach(pill => {
                if ((pill.dataset.val || '').toLowerCase() === activeFakultas) {
                    pill.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
                    pill.classList.add('bg-[#0c4ea6]', 'text-white', 'border-[#0c4ea6]');
                } else {
                    pill.classList.remove('bg-[#0c4ea6]', 'text-white', 'border-[#0c4ea6]');
                    pill.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
                }
            });
            updateDisplay();
        }

        function updateDisplay() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const selectedFakultas = activeFakultas || (fakultasFilter ? fakultasFilter.value.toLowerCase().trim() : '');
            const cards = document.querySelectorAll('.lab-card');
            let countVisible = 0;

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const location = card.dataset.location || '';
                const fakultas = card.dataset.fakultas || '';

                const matchQuery = !query || name.includes(query) || location.includes(query) || fakultas.includes(query);
                const matchFakultas = !selectedFakultas || fakultas.includes(selectedFakultas);

                if (matchQuery && matchFakultas) {
                    card.style.display = 'flex';
                    countVisible++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noResultEl = document.getElementById('noFilterResult');
            if (noResultEl) {
                noResultEl.style.display = (countVisible === 0 && cards.length > 0) ? 'block' : 'none';
            }
        }

        searchInput?.addEventListener('input', updateDisplay);
        fakultasFilter?.addEventListener('change', function() {
            setFakultasFilter(this.value);
        });
    </script>
</body>
</html>
