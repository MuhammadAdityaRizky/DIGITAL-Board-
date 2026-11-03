<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Properti - {{ $lab->nama_lab }} - Digital Board</title>
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Dokumen Lab: {{ $lab->nama_lab }}</h2>
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

                <!-- Header Actions & Multi-Filter Bar -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <a href="{{ route('admin.properti.fakultas', $lab->fakultas_id) }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-arrow-left text-xs"></i>
                                    <span>Kembali ke {{ $lab->fakultas->nama_fakultas ?? 'Fakultas' }}</span>
                                </a>
                                <span class="text-slate-300">•</span>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $lab->nama_lab }} (Ruang {{ $lab->lokasi ?: '-' }})</span>
                            </div>
                            <h3 class="font-extrabold text-base text-slate-800">Dokumen Inventarisasi Properti</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola berkas dokumen inventarisasi fasilitas & properti laboratorium.</p>
                        </div>

                        <!-- 2 Tombol Aksi Sesuai Layout 3 -->
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <!-- Tombol 1: Kelola Kategori (Layout 3/1) -->
                            <a href="{{ route('admin.properti.kategori.index') }}" class="px-3.5 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                                <i class="fa-solid fa-tags text-xs"></i> Kelola Kategori
                            </a>

                            <!-- Tombol 2: Tambah Data Dokumen -->
                            <button type="button" onclick="openModalDokumen()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-xs cursor-pointer">
                                <i class="fa-solid fa-plus text-xs"></i> Tambah Data Dokumen
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabel Dokumen Properti Lab -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                        <h4 class="font-bold text-sm text-slate-800">Daftar Berkas Dokumen Inventaris</h4>
                        <span class="px-2.5 py-0.5 bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg">
                            {{ $dokumenList->count() }} Dokumen
                        </span>
                    </div>

                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left text-slate-650">
                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                                <tr>
                                    <th class="p-3.5 text-center w-12">No</th>
                                    <th class="p-3.5">Nama Dokumen</th>
                                    <th class="p-3.5">No. Dokumen</th>
                                    <th class="p-3.5">Revisi</th>
                                    <th class="p-3.5">Tanggal Pendataan</th>
                                    <th class="p-3.5 text-center">Total Item</th>
                                    <th class="p-3.5">Dibuat Oleh</th>
                                    <th class="p-3.5 text-center w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($dokumenList as $index => $doc)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-3.5 text-center text-slate-400 font-bold">{{ $index + 1 }}</td>
                                        <td class="p-3.5 font-bold text-slate-900">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-file-lines text-teal-700"></i>
                                                <span>{{ $doc->nama_dokumen }}</span>
                                            </div>
                                        </td>
                                        <td class="p-3.5">
                                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono text-[11px] font-bold border border-slate-200">
                                                {{ $doc->nomor_dokumen }}
                                            </span>
                                        </td>
                                        <td class="p-3.5 font-semibold text-slate-600">{{ $doc->nomor_revisi }}</td>
                                        <td class="p-3.5 text-slate-600 font-medium">
                                            {{ \Carbon\Carbon::parse($doc->tanggal_pendataan)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="p-3.5 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                {{ $doc->items_count }} Unit
                                            </span>
                                        </td>
                                        <td class="p-3.5 text-slate-500">
                                            {{ $doc->creator->username ?? 'Admin' }}
                                        </td>
                                        <td class="p-3.5 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <!-- Tombol Buka Data (Layout 4) -->
                                                <a href="{{ route('admin.properti.dokumen.show', $doc->id) }}" class="px-3 py-1.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                                                    <i class="fa-solid fa-folder-open text-[11px]"></i>
                                                    <span>Buka Data</span>
                                                </a>
                                                
                                                <!-- Tombol Hapus Dokumen -->
                                                <form action="{{ route('admin.properti.dokumen.destroy', $doc->id) }}" method="POST" onsubmit="return confirmHapusDokumen(event, this)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 border border-slate-200 flex items-center justify-center transition cursor-pointer" title="Hapus Dokumen">
                                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-10 text-center text-slate-400">
                                            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-lg mb-2">
                                                <i class="fa-solid fa-folder-open"></i>
                                            </div>
                                            <p class="font-bold text-xs text-slate-600">Belum Ada Dokumen Properti</p>
                                            <p class="text-[11px] text-slate-400 mt-0.5">Klik tombol "Tambah Data Dokumen" di atas untuk membuat berkas formulir baru.</p>
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

    <!-- Modal Tambah Dokumen Baru -->
    <div id="modalDokumen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden transition-opacity opacity-0 duration-200">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl border border-slate-100 overflow-hidden transform scale-95 transition-transform duration-200" id="modalDokumenContainer">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-file-circle-plus text-sm"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-800">Tambah Dokumen Inventaris Properti</h3>
                </div>
                <button type="button" onclick="closeModalDokumen()" class="w-8 h-8 rounded-lg hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('admin.properti.dokumen.store', $lab->id) }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Dokumen / Berkas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_dokumen" required placeholder="Contoh: DAFTAR FASILITAS DAN PROPERTI LAB 2026" value="DAFTAR FASILITAS DAN PROPERTI {{ strtoupper($lab->nama_lab) }} {{ date('Y') }}" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-700 font-semibold">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">No. Dokumen <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_dokumen" required value="FT-SPR-INS-F-01" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-700 font-mono font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">No. Revisi <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_revisi" required value="0" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-700 font-semibold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Pendataan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pendataan" required value="{{ date('Y-m-d') }}" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-700 font-semibold">
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalDokumen()" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 font-bold text-xs transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-save"></i>
                        <span>Simpan & Buka Formulir</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        function openModalDokumen() {
            const modal = document.getElementById('modalDokumen');
            const container = document.getElementById('modalDokumenContainer');
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                container.classList.remove('scale-95');
                container.classList.add('scale-100');
            });
        }

        function closeModalDokumen() {
            const modal = document.getElementById('modalDokumen');
            const container = document.getElementById('modalDokumenContainer');
            modal.classList.add('opacity-0');
            container.classList.remove('scale-100');
            container.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        function confirmHapusDokumen(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Dokumen?',
                text: 'Seluruh data properti dan fasilitas di dalam dokumen ini akan ikut terhapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Dokumen',
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
