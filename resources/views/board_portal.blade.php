<!DOCTYPE html>
<html lang="id">
<head>
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
            <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
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
            <a href="{{ route('login') }}" 
               class="px-4 py-2.5 rounded-xl border border-slate-200 hover:border-[#0c4ea6]/40 bg-slate-50 hover:bg-white text-slate-700 hover:text-[#0c4ea6] font-bold text-xs transition duration-200 shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-user-shield text-[#0c4ea6]"></i>
                <span>Login Staff / Dosen</span>
            </a>
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

        <!-- Filter & Search Control Bar -->
        <div class="w-full max-w-3xl mx-auto mb-8 flex flex-col sm:flex-row items-center gap-3">
            <!-- Search Bar -->
            <div class="relative flex-grow w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" id="labSearch" placeholder="Cari nama lab atau lokasi gedung..." 
                       class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/20 focus:border-[#0c4ea6] shadow-sm transition">
            </div>

            <!-- Quick Filter Badges -->
            <div class="flex items-center gap-1.5 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0 shrink-0 text-xs font-bold">
                <button type="button" onclick="filterLab('all')" class="filter-btn active-filter px-3.5 py-2.5 rounded-xl bg-[#0c4ea6] text-white transition shadow-sm" data-filter="all">Semua</button>
                <button type="button" onclick="filterLab('lantai 1')" class="filter-btn px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition shadow-sm" data-filter="lantai 1">Lantai 1</button>
                <button type="button" onclick="filterLab('lantai 2')" class="filter-btn px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition shadow-sm" data-filter="lantai 2">Lantai 2</button>
            </div>
        </div>

        <!-- Lab Display Cards Grid -->
        <div id="labGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($labs as $lab)
                <div class="lab-card bg-white border border-slate-200 rounded-3xl p-6 flex flex-col justify-between gap-5 card-shadow transition duration-200 relative overflow-hidden" 
                     data-location="{{ strtolower($lab->lokasi) }}" data-name="{{ strtolower($lab->nama_lab) }}">
                    
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
                            <i class="fa-solid fa-[#0c4ea6] fa-desktop text-slate-400 mr-1"></i> Live Kiosk Mode
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
        let currentFilter = 'all';

        function updateDisplay() {
            const query = searchInput.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.lab-card');

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const location = card.dataset.location || '';

                const matchesSearch = name.includes(query) || location.includes(query);
                const matchesFilter = (currentFilter === 'all') || location.includes(currentFilter);

                if (matchesSearch && matchesFilter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchInput?.addEventListener('input', updateDisplay);

        function filterLab(filter) {
            currentFilter = filter;
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.dataset.filter === filter) {
                    btn.className = 'filter-btn active-filter px-3.5 py-2.5 rounded-xl bg-[#0c4ea6] text-white transition shadow-sm';
                } else {
                    btn.className = 'filter-btn px-3.5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition shadow-sm';
                }
            });
            updateDisplay();
        }
    </script>
</body>
</html>
