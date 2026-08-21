<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Informasi Lab - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgb(12, 78, 166) 0%, rgb(4, 30, 66) 90%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glow-button:hover {
            box-shadow: 0 0 20px rgba(0, 184, 124, 0.4);
        }
    </style>
</head>
<body class="min-h-screen text-white flex flex-col justify-between p-6 sm:p-12 relative overflow-hidden">

    <!-- Subtle Background Glows -->
    <div class="absolute w-96 h-96 rounded-full bg-[#00b87c]/10 blur-[120px] top-10 left-10 pointer-events-none"></div>
    <div class="absolute w-[500px] h-[500px] rounded-full bg-[#0c4ea6]/30 blur-[150px] bottom-10 right-10 pointer-events-none"></div>

    <!-- Header -->
    <header class="w-full max-w-6xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4 z-10">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-tr from-[#0c4ea6] to-[#00b87c] rounded-2xl flex items-center justify-center text-white font-extrabold shadow-lg">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-base tracking-wide uppercase leading-tight">UIKA SMART LABS</h1>
                <p class="text-[10px] font-bold tracking-widest text-[#00b87c] uppercase">Digital Information Display</p>
            </div>
        </div>
        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl border border-white/10 hover:bg-white/5 font-semibold text-xs transition duration-300 flex items-center gap-2">
            <i class="fa-solid fa-right-to-bracket text-slate-400"></i> Login Staff / Dosen
        </a>
    </header>

    <!-- Main Content -->
    <main class="w-full max-w-6xl mx-auto py-12 flex-grow flex flex-col justify-center z-10">
        <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
            <span class="px-3 py-1 bg-[#00b87c]/15 text-[#00b87c] border border-[#00b87c]/20 text-[10px] font-bold uppercase tracking-widest rounded-full">Select Monitor Location</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Portal Digital Board</h2>
            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">Pilih laboratorium untuk membuka tampilan papan informasi digital khusus di depan laboratorium masing-masing.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($labs as $lab)
                <div class="glass-panel p-6 rounded-3xl flex flex-col justify-between gap-5 hover:border-white/20 transition duration-300 transform hover:-translate-y-1">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/15 flex items-center justify-center text-teal-400">
                            <i class="fa-solid fa-door-open text-base"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base tracking-wide">{{ $lab->nama_lab }}</h3>
                            <p class="text-[10px] font-semibold text-[#00b87c] tracking-wider uppercase mt-0.5"><i class="fa-solid fa-map-pin mr-1"></i>{{ $lab->lokasi }}</p>
                        </div>
                        <p class="text-slate-400 text-[11px] leading-relaxed">Papan display digital cerdas untuk memantau agenda kelas aktif, realisasi perkuliahan, dan pengumuman.</p>
                    </div>

                    <div class="pt-4 border-t border-white/5 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[10px] font-semibold"><i class="fa-solid fa-users mr-1"></i> Kapasitas: {{ $lab->kapasitas ?: 30 }} Kursi</span>
                        <a href="{{ route('board.lab', $lab->id) }}" class="glow-button px-4 py-2 bg-[#00b87c] hover:bg-[#00a36d] text-slate-900 font-bold rounded-xl transition duration-300 flex items-center gap-1.5 shadow-md">
                            Monitor Board <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-500 italic text-xs">
                    <i class="fa-solid fa-circle-exclamation text-3xl block mb-2"></i>
                    Belum ada laboratorium terdaftar. Tambahkan laboratorium baru di Admin Panel.
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-6xl mx-auto border-t border-white/5 pt-6 text-center text-slate-500 text-[10px] font-semibold tracking-wider uppercase z-10 flex flex-col sm:flex-row justify-between items-center gap-3">
        <p>&copy; {{ date('Y') }} UIKA SMART LAB MANAGEMENT. All Rights Reserved.</p>
        <p>Powered by Laravel & Tailwind CSS</p>
    </footer>

</body>
</html>
