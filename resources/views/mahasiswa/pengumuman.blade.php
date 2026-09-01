<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Lab - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
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
            <a href="{{ route('mahasiswa.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-gear"></i>
                <span class="text-xs font-semibold tracking-wide">Pengaturan</span>
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

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-user-graduate text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Pengumuman Laboratorium</h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ $mahasiswa->nama_lengkap }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIM: {{ $mahasiswa->nim }} • {{ $mahasiswa->prodi->nama_prodi ?? 'Mahasiswa' }}</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr($mahasiswa->nama_lengkap, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
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
                        <span class="font-bold">Gagal Absen:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif



            <!-- Main Content (Pengumuman) -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4">
                    <h3 class="font-bold text-sm text-slate-800"><i class="fa-solid fa-bullhorn mr-2 text-teal-600"></i> Daftar Pengumuman Laboratorium</h3>
                </div>
                <div class="p-6 divide-y divide-slate-100">
                    @if(isset($pengumuman) && count($pengumuman) > 0)
                        @foreach($pengumuman as $p)
                            <div class="py-5 first:pt-0 last:pb-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-[10px] font-bold rounded-lg tracking-wide">
                                        {{ date('d M Y', strtotime($p->created_at)) }}
                                    </span>
                                    @if(now()->diffInDays($p->created_at) <= 3)
                                        <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[10px] font-bold rounded animate-pulse">Baru</span>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-800 text-base mb-1">{{ $p->judul }}</h4>
                                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">{{ $p->isi_pengumuman }}</p>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-3">
                                    <p class="text-[10px] text-slate-400 italic">Diterbitkan oleh: {{ $p->admin->name ?? 'Admin' }}</p>
                                    @if($p->laboratoriums && count($p->laboratoriums) > 0)
                                        <p class="text-[10px] text-slate-500 font-medium">
                                            <i class="fa-solid fa-desktop mr-1 text-slate-400"></i>
                                            Lab: 
                                            @foreach($p->laboratoriums as $lab)
                                                <span class="bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded ml-0.5">{{ $lab->nama_lab }}</span>
                                            @endforeach
                                        </p>
                                    @else
                                        <p class="text-[10px] text-slate-500 font-medium">
                                            <i class="fa-solid fa-desktop mr-1 text-slate-400"></i>
                                            Lab: <span class="bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded ml-0.5">Semua Lab</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-300 mb-3">
                                <i class="fa-solid fa-inbox text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-700 text-sm">Belum ada pengumuman</h4>
                            <p class="text-xs text-slate-500 mt-1">Saat ini tidak ada pengumuman laboratorium yang aktif.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Floating Center Scan QR) -->
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
        <a href="{{ route('mahasiswa.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>
</body>
</html>
