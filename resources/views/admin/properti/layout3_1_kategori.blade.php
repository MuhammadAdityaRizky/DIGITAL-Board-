<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori Properti - Digital Board</title>
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Master Kategori Properti</h2>
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

                <!-- Header Actions & 3 Filter Buttons (Layout 3/1) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <a href="{{ (url()->previous() && url()->previous() !== url()->current()) ? url()->previous() : route('admin.properti.index') }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-arrow-left text-xs"></i>
                                    <span>Kembali ke Properti Lab</span>
                                </a>
                            </div>
                            <h3 class="font-extrabold text-base text-slate-800">Kumpulan Kategori & Sub Kategori</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Saring jenis kategori untuk penomoran otomatis dan pengelompokan inventaris fasilitas lab.</p>
                        </div>

                        <!-- 3 Tombol Utama: [Kategori] [Sub Kategori] [+ Tambah] -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <a href="{{ route('admin.properti.kategori.index', ['tab' => 'kategori']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $tab === 'kategori' ? 'bg-teal-800 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                                <i class="fa-solid fa-folder text-xs"></i>
                                <span>Kategori</span>
                            </a>

                            <a href="{{ route('admin.properti.kategori.index', ['tab' => 'sub_kategori']) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $tab === 'sub_kategori' ? 'bg-teal-800 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                                <i class="fa-solid fa-folder-tree text-xs"></i>
                                <span>Sub Kategori</span>
                            </a>

                            <a href="{{ route('admin.properti.kategori.create') }}" class="px-3.5 py-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs ml-1">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Tambah Kategori</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data Kategori / Sub Kategori -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                        <h4 class="font-bold text-sm text-slate-800">
                            Daftar Master Kategori
                            @if($tab === 'kategori')
                                <span class="text-teal-700 font-semibold">(Hanya Kategori Utama)</span>
                            @elseif($tab === 'sub_kategori')
                                <span class="text-teal-700 font-semibold">(Hanya Sub Kategori)</span>
                            @endif
                        </h4>
                        <span class="px-2.5 py-0.5 bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg">
                            {{ $categories->count() }} Data
                        </span>
                    </div>

                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left text-slate-650">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                                <tr>
                                    <th class="p-3.5 text-center w-14">No</th>
                                    <th class="p-3.5">Nama</th>
                                    <th class="p-3.5">Kode Singkatan</th>
                                    <th class="p-3.5">Jenis</th>
                                    <th class="p-3.5">Induk Kategori</th>
                                    <th class="p-3.5 text-center w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($categories as $index => $cat)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-3.5 text-center text-slate-400 font-bold">{{ $index + 1 }}</td>
                                        <td class="p-3.5 font-bold text-slate-900">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid {{ $cat->jenis === 'kategori' ? 'fa-folder text-teal-700' : 'fa-folder-tree text-slate-500' }}"></i>
                                                <span>{{ $cat->nama }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3.5">
                                            @if($cat->kode)
                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 font-mono font-bold border border-slate-200">
                                                    {{ $cat->kode }}
                                                </span>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="p-3.5">
                                            @if($cat->jenis === 'kategori')
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    Kategori Utama
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                    Sub Kategori
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3.5 text-slate-600 font-medium">
                                            {{ $cat->parent->nama ?? '-' }}
                                        </td>
                                        <td class="p-3.5 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <a href="{{ route('admin.properti.kategori.edit', $cat->id) }}" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-teal-50 text-slate-600 hover:text-teal-800 border border-slate-200 flex items-center justify-center transition" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </a>

                                                <form action="{{ route('admin.properti.kategori.destroy', $cat->id) }}" method="POST" onsubmit="return confirmHapusKategori(event, this)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 border border-slate-200 flex items-center justify-center transition cursor-pointer" title="Hapus">
                                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-400">
                                            Belum ada data kategori yang cocok dengan saringan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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

        function confirmHapusKategori(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Kategori?',
                text: 'Kategori ini akan dihapus dari sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl shadow-xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }
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
