<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properti Lab - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Properti Lab (Inventaris)</h2>
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
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold text-left group cursor-pointer">
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
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Header Actions & Info Bar (Format Standar Sama Persis Seperti Manajemen Lab) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <h3 class="font-extrabold text-base text-slate-800">Kumpulan Fakultas UIKA</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pilih salah satu fakultas untuk melihat daftar laboratorium dan dokumen inventaris propertinya.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-3.5 py-1.5 bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold rounded-xl">
                                <i class="fa-solid fa-building-columns text-slate-400 mr-1.5"></i> Total {{ $fakultas->count() }} Fakultas
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Grid Kartu Fakultas (Sama Persis dengan Format Kartu di Manajemen Lab) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($fakultas as $f)
                        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-md hover:border-slate-300 transition duration-200 flex flex-col justify-between group">
                            <div>
                                <!-- Top Badges -->
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/80 shadow-xs">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                    <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-bold rounded-lg truncate">
                                        <i class="fa-solid fa-graduation-cap text-slate-400 mr-1 text-[10px]"></i> {{ $f->prodi_count }} Program Studi
                                    </span>
                                </div>

                                <!-- Title & Details -->
                                <div>
                                    <h4 class="font-extrabold text-slate-900 text-base group-hover:text-teal-800 transition">
                                        {{ $f->nama_fakultas }}
                                    </h4>
                                    <div class="mt-2 text-xs text-slate-600 space-y-1.5">
                                        <p class="flex items-center gap-2 font-medium">
                                            <i class="fa-solid fa-building-columns text-slate-400 w-4 text-center"></i> Universitas Ibn Khaldun Bogor
                                        </p>
                                        <p class="flex items-center gap-2 font-medium">
                                            <i class="fa-solid fa-door-open text-teal-600 w-4 text-center"></i> <span class="font-bold text-slate-800">{{ $f->total_lab }}</span> Ruang Laboratorium
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer Action -->
                            <div class="pt-4 mt-4 border-t border-slate-100">
                                <a href="{{ route('admin.properti.fakultas', $f->id) }}" class="w-full py-2 px-3 bg-slate-100 hover:bg-teal-800 hover:text-white text-slate-700 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 border border-slate-200/70 cursor-pointer">
                                    <span>Pilih Fakultas & Buka Lab</span>
                                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center">
                            <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mb-3">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <h4 class="font-bold text-base text-slate-700 mb-1">Belum Ada Data Fakultas</h4>
                            <p class="text-xs text-slate-500">Silakan tambahkan data fakultas terlebih dahulu di menu Data Akademik.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>

    <script>
        function toggleProfileDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileDropdownMenu');
            const wrapper = document.getElementById('profileDropdownWrapper');
            if (menu && wrapper && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                customClass: { popup: 'rounded-2xl shadow-xl' }
            });
        </script>
    @endif

</body>
</html>
