<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }} - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">{{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
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
            <div class="max-w-2xl mx-auto space-y-6">

                <!-- Header Card Form -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <a href="{{ route('admin.properti.kategori.index') }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-arrow-left text-xs"></i>
                                    <span>Kembali ke Master Kategori</span>
                                </a>
                            </div>
                            <h3 class="font-extrabold text-base text-slate-800">
                                {{ $isEdit ? 'Edit Kategori / Sub Kategori' : 'Form Tambah Kategori Baru' }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Pilih jenis kategori dan isi informasi nama beserta kode singkatannya.</p>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <form action="{{ $isEdit ? route('admin.properti.kategori.update', $kategori->id) : route('admin.properti.kategori.store') }}" method="POST" class="space-y-4 pt-1">
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif

                        <!-- Pilihan 2 Button Sesuai Layout 3/1/1 -->
                        <div>
                            <label class="block text-slate-700 font-extrabold text-xs mb-1.5">Pilih Jenis <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-3 p-1 bg-slate-100 rounded-xl border border-slate-200">
                                <button type="button" onclick="setJenis('kategori')" id="btnJenisKategori" class="py-2 px-3 rounded-lg font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer bg-white text-teal-900 shadow-xs border border-slate-200/80">
                                    <i class="fa-solid fa-folder text-teal-700"></i>
                                    <span>Kategori Utama</span>
                                </button>
                                <button type="button" onclick="setJenis('sub_kategori')" id="btnJenisSubKategori" class="py-2 px-3 rounded-lg font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer text-slate-600 hover:text-slate-900">
                                    <i class="fa-solid fa-folder-tree text-slate-400"></i>
                                    <span>Sub Kategori</span>
                                </button>
                            </div>
                            <input type="hidden" name="jenis" id="inputJenis" value="{{ old('jenis', $kategori->jenis ?? 'kategori') }}">
                        </div>

                        <!-- Dropdown Kategori Induk -->
                        <div id="wrapperParent" class="{{ old('jenis', $kategori->jenis ?? 'kategori') === 'sub_kategori' ? '' : 'hidden' }}">
                            <label class="block text-slate-700 font-extrabold text-xs mb-1">
                                Kategori Induk <span class="text-red-500">*</span>
                            </label>
                            <select name="parent_id" id="selectParentId" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-teal-700 font-medium">
                                <option value="">-- Pilih Salah Satu Kategori Induk --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ (old('parent_id', $kategori->parent_id) == $parent->id) ? 'selected' : '' }}>
                                        {{ $parent->nama }} (Kode: {{ $parent->kode ?: '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Nama -->
                        <div>
                            <label class="block text-slate-700 font-extrabold text-xs mb-1">
                                Nama Kategori / Sub Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" required value="{{ old('nama', $kategori->nama) }}" placeholder="Contoh: Komputer, Meja, Kursi" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-teal-700 font-semibold">
                        </div>

                        <!-- Input Kode Singkatan -->
                        <div>
                            <label class="block text-slate-700 font-extrabold text-xs mb-1">
                                Kode Singkatan Barang <span class="text-slate-400 font-normal">(Format kode otomatis)</span>
                            </label>
                            <input type="text" name="kode" value="{{ old('kode', $kategori->kode) }}" placeholder="Contoh: PC, M, K, PR, MD, PT, C, AC" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:ring-2 focus:ring-teal-700 font-mono font-bold uppercase text-teal-900">
                            <p class="text-[10px] text-slate-400 mt-1">
                                Digunakan pada formula penomoran inventaris: <span class="font-mono bg-slate-100 px-1 py-0.5 rounded text-teal-800">[KODE]/SI/209/{{ date('m') }}/{{ date('y') }}/01</span>
                                <span class="block text-[9px] text-slate-400 mt-0.5">*(Format: [KODE]/[PRODI]/[RUANG]/[BULAN]/[TAHUN]/[NOMOR_URUT]. Bagian bulan &amp; tahun otomatis ter-update sesuai tanggal pembuatan dokumen)*</span>
                            </p>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                            <a href="{{ route('admin.properti.kategori.index') }}" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold text-xs transition">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-save text-xs"></i>
                                <span>{{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Kategori' }}</span>
                            </button>
                        </div>
                    </form>
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

        function setJenis(jenis) {
            document.getElementById('inputJenis').value = jenis;
            const btnKategori = document.getElementById('btnJenisKategori');
            const btnSubKategori = document.getElementById('btnJenisSubKategori');
            const wrapperParent = document.getElementById('wrapperParent');

            if (jenis === 'kategori') {
                btnKategori.className = 'py-2 px-3 rounded-lg font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer bg-white text-teal-900 shadow-xs border border-slate-200/80';
                btnSubKategori.className = 'py-2 px-3 rounded-lg font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer text-slate-600 hover:text-slate-900';
                wrapperParent.classList.add('hidden');
            } else {
                btnSubKategori.className = 'py-2 px-3 rounded-lg font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer bg-white text-teal-900 shadow-xs border border-slate-200/80';
                btnKategori.className = 'py-2 px-3 rounded-lg font-bold text-xs transition flex items-center justify-center gap-2 cursor-pointer text-slate-600 hover:text-slate-900';
                wrapperParent.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const currentJenis = document.getElementById('inputJenis').value;
            setJenis(currentJenis);
        });
    </script>

</body>
</html>
