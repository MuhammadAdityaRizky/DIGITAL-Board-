<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Agenda Dosen - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-5 flex items-center gap-3 border-b border-slate-800 shrink-0">
            <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-10 h-10 object-contain shrink-0">
            <div>
                <h1 class="font-bold text-sm leading-tight text-white">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">PORTAL DOSEN</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-3 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-border-all text-sm"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 bg-teal-800 text-white font-bold shadow-sm rounded-xl w-full text-xs">
                <i class="fa-solid fa-calendar-alt text-sm"></i>
                <span>Agenda Perkuliahan</span>
            </a>
            <a href="{{ route('dosen.jadwal-lab') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-calendar-check text-sm"></i>
                <span>Ketersediaan Lab</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-gear text-sm"></i>
                <span>Pengaturan Akun</span>
            </a>
        </nav>

        <!-- Nav Links -->
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        @include('dosen.partials.header', ['title' => 'Riwayat Agenda Perkuliahan'])

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border-2 border-emerald-400 text-emerald-950 p-5 rounded-xl text-base flex items-start gap-3 shadow-xs mb-4">
                    <i class="fa-solid fa-circle-check text-emerald-700 mt-0.5 text-xl flex-shrink-0"></i>
                    <div>
                        <span class="font-black">Berhasil!</span>
                        <p class="mt-0.5 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-2 border-rose-300 text-rose-950 p-5 rounded-xl text-base flex items-start gap-3 shadow-xs mb-4">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5 text-xl flex-shrink-0"></i>
                    <div>
                        <span class="font-black">Terjadi Kendala:</span>
                        <p class="mt-0.5 font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Comprehensive Multi-Parameter Filter Bar -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-2xs">
                <form action="{{ route('dosen.agenda') }}" method="GET" class="space-y-3.5 text-xs">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 items-end">
                        <!-- 1. Search Query -->
                        <div class="md:col-span-5 w-full">
                            <label class="block text-slate-700 font-bold text-xs mb-1">Cari Sesi / Mata Kuliah</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama mata kuliah, kelas, catatan..." class="w-full pl-9 pr-3.5 py-2 rounded-xl bg-white border border-slate-300 focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none text-xs sm:text-sm font-semibold text-slate-800 placeholder:text-slate-400 placeholder:font-normal">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs sm:text-sm"></i>
                            </div>
                        </div>

                        <!-- 2. Tanggal Pelaksanaan -->
                        <div class="md:col-span-3 w-full">
                            <label class="block text-slate-700 font-bold text-xs mb-1">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full py-2 px-3 rounded-xl bg-white border border-slate-300 focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none text-xs sm:text-sm font-semibold text-slate-800">
                        </div>

                        <!-- 3. Status Sesi -->
                        <div class="md:col-span-4 w-full">
                            <label class="block text-slate-700 font-bold text-xs mb-1">Status Sesi Agenda</label>
                            <select name="status_agenda" class="w-full py-2 px-3 rounded-xl bg-white border border-slate-300 focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none text-xs sm:text-sm font-semibold text-slate-800 cursor-pointer">
                                <option value="">Semua Status Sesi</option>
                                <option value="Berlangsung" {{ request('status_agenda') == 'Berlangsung' ? 'selected' : '' }}>● Berlangsung</option>
                                <option value="Selesai" {{ request('status_agenda') == 'Selesai' ? 'selected' : '' }}>● Selesai</option>
                                <option value="Akan Datang" {{ request('status_agenda') == 'Akan Datang' ? 'selected' : '' }}>○ Mendatang / Akan Datang</option>
                                <option value="Dibatalkan" {{ request('status_agenda') == 'Dibatalkan' ? 'selected' : '' }}>✕ Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 items-end pt-0.5">
                        <!-- 4. Filter Ruang Lab -->
                        <div class="md:col-span-4 w-full">
                            <label class="block text-slate-700 font-bold text-xs mb-1">Ruang Laboratorium</label>
                            <select name="lab_id" class="w-full py-2 px-3 rounded-xl bg-white border border-slate-300 focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none text-xs sm:text-sm font-semibold text-slate-800 cursor-pointer">
                                <option value="">Semua Ruang Lab</option>
                                @foreach($labs as $l)
                                    <option value="{{ $l->id }}" {{ request('lab_id') == $l->id ? 'selected' : '' }}>{{ $l->nama_lab }} (Fakultas {{ $l->fakultas->nama_fakultas ?? 'FTS' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 5. Filter Kelas -->
                        <div class="md:col-span-4 w-full">
                            <label class="block text-slate-700 font-bold text-xs mb-1">Filter Kelas / Peminatan</label>
                            <select name="kelas" class="w-full py-2 px-3 rounded-xl bg-white border border-slate-300 focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none text-xs sm:text-sm font-semibold text-slate-800 cursor-pointer">
                                <option value="">Semua Kelas</option>
                                @foreach($uniqueClasses as $uc)
                                    @if($uc->kelas)
                                        <option value="{{ $uc->kelas }}" {{ request('kelas') == $uc->kelas ? 'selected' : '' }}>Kelas {{ $uc->kelas }} ({{ $uc->mata_kuliah }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- 6. Urutkan Tanggal -->
                        <div class="md:col-span-4 w-full flex items-end gap-2">
                            <div class="flex-1 min-w-[160px]">
                                <label class="block text-slate-700 font-bold text-xs mb-1">Urutkan Tanggal</label>
                                <select name="sort" class="w-full min-w-[160px] py-2 px-3 rounded-xl bg-white border border-slate-300 focus:border-slate-800 focus:ring-1 focus:ring-slate-800 outline-none text-xs sm:text-sm font-semibold text-slate-800 cursor-pointer">
                                    <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru Lebih Dahulu</option>
                                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama Lebih Dahulu</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-1.5 shrink-0">
                                <button type="submit" class="h-[38px] px-4 sm:px-5 bg-slate-900 hover:bg-slate-800 active:scale-98 text-white rounded-xl font-bold text-xs sm:text-sm transition shadow-2xs cursor-pointer flex items-center justify-center">
                                    Filter
                                </button>
                                @if(request()->anyFilled(['search', 'tanggal', 'sort', 'lab_id', 'status_agenda', 'kelas']))
                                    <a href="{{ route('dosen.agenda') }}" class="h-[38px] px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-xs sm:text-sm transition border border-slate-300 flex items-center justify-center cursor-pointer" title="Reset Semua Filter">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdminFakultas())
                        <div class="mt-3 pt-3 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3 bg-amber-50/90 p-3 rounded-xl border border-amber-200">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user-gear text-amber-600 text-sm"></i>
                                <span class="text-xs font-extrabold text-amber-900">Mode Pratinjau Admin: Pilih Dosen</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <select name="dosen_id" onchange="this.form.submit()" class="py-1.5 px-3 rounded-lg bg-white border border-amber-300 text-xs font-bold text-slate-800 outline-none cursor-pointer shadow-2xs">
                                    @foreach($dosens as $dsn)
                                        <option value="{{ $dsn->id }}" {{ $dosen->id == $dsn->id ? 'selected' : '' }}>
                                            {{ $dsn->nama }} (NIP: {{ $dsn->nip }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Agendas List -->
            <div class="bg-white border border-slate-200 shadow-2xs rounded-2xl overflow-hidden">
                <div class="bg-slate-50 border-b border-slate-200 px-5 py-3.5 flex flex-wrap justify-between items-center gap-3">
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-slate-900">Daftar Agenda Perkuliahan &amp; Pertemuan</h3>
                        <span class="text-xs bg-white text-slate-700 border border-slate-300 font-bold px-2.5 py-0.5 rounded-lg mt-1 inline-block">{{ $groupedAgendas->count() }} Mata Kuliah ({{ $agendas->total() }} Sesi Pertemuan)</span>
                    </div>
                    
                    <div class="flex items-center gap-2 ml-auto flex-wrap">
                        @if($agendas->count() > 0)
                            <button type="button" onclick="toggleAllCourseAccordions(this)" id="btn-toggle-all-courses" class="h-[36px] px-3.5 bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Buka atau tutup semua daftar pertemuan">
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" id="icon-toggle-all-courses"></i>
                                <span id="text-toggle-all-courses">Buka Semua</span>
                            </button>
                            <button type="button" id="btn-toggle-select" class="h-[36px] px-3.5 bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                                <i class="fa-solid fa-square-check text-slate-600"></i>
                                <span>Pilih Banyak</span>
                            </button>
                            <div id="container-check-all" class="flex items-center gap-2 mr-1 border-r border-slate-300 pr-3 hidden">
                                <input type="checkbox" id="check-all" class="rounded text-slate-900 focus:ring-0 w-4 h-4 cursor-pointer">
                                <label for="check-all" class="text-xs text-slate-800 font-bold cursor-pointer select-none">Pilih Semua</label>
                            </div>
                            <button type="button" onclick="submitBulkDelete()" id="btn-bulk-delete" class="h-[36px] px-3.5 bg-rose-50 hover:bg-rose-100 border border-rose-300 text-rose-900 text-xs font-bold rounded-xl transition hidden flex items-center gap-1.5 shadow-2xs cursor-pointer">
                                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                            </button>
                        @endif
                        <button type="button" onclick="toggleModal('modal-add-agenda')" class="h-[36px] px-4 bg-teal-800 hover:bg-teal-900 active:scale-98 text-white text-xs sm:text-sm font-bold rounded-xl shadow-2xs transition flex items-center gap-1.5 cursor-pointer flex-shrink-0 whitespace-nowrap">
                            <i class="fa-solid fa-calendar-plus text-xs"></i> Buat Agenda Baru
                        </button>
                    </div>
                </div>
                
                <!-- Sticky Bulk Delete Action Bar -->
                <div id="sticky-bulk-bar" class="hidden mx-6 mt-4 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center justify-between shadow-sm sticky top-4 z-40">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-rose-900 block"><span id="sticky-selected-count">0</span> agenda terpilih</span>
                            <span class="text-xs text-rose-700 font-semibold">Data sesi dan absensi agenda terpilih akan dihapus permanen</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="printSelectedDosenAgendasBa()" class="px-3.5 py-2 bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer" title="Cetak Berita Acara untuk Sesi yang Dicentang">
                            <i class="fa-regular fa-file-lines text-slate-600"></i>
                            <span>Cetak BA Terpilih</span>
                        </button>
                        <button type="button" onclick="cancelBulkSelection()" class="px-3.5 py-1.5 bg-white hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-xs font-bold transition cursor-pointer">
                            Batal Pilih
                        </button>
                        <button type="button" onclick="submitBulkDelete()" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-trash-can"></i> Hapus Terpilih
                        </button>
                    </div>
                </div>

                <div id="agenda-list-container" class="p-6 space-y-4">
                    @include('dosen.agenda_partial')
                </div>
            </div>
        </div>
            
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical Layout with Center QR) -->
    @include('dosen.partials.bottom_nav')

    <!-- Profile Dropdown Handler -->
    <script>
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
    </script>

    <!-- MODAL CETAK BERITA ACARA PER MK / PILIH PERTEMUAN -->
    <div id="modal-print-ba" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-150 text-left">
            <!-- Header Modal -->
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/75">
                <div class="min-w-0 pr-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-800 flex items-center justify-center text-xs">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                        <h3 class="font-bold text-sm text-slate-800 tracking-tight">Cetak Berita Acara (BA)</h3>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 truncate" id="modal-ba-subtitle">Pilih pertemuan yang ingin dicetak</p>
                </div>
                <button type="button" onclick="closePrintBaModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <!-- Controls Bar in Modal: Select All & Count Badge -->
            <div class="px-5 py-2.5 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between text-xs text-slate-600">
                <label class="inline-flex items-center gap-2 cursor-pointer font-medium select-none">
                    <input type="checkbox" id="modal-ba-select-all" onchange="toggleModalBaSelectAll(this)" class="rounded border-slate-300 text-teal-800 focus:ring-teal-700/30 cursor-pointer">
                    <span>Pilih Semua Pertemuan</span>
                </label>
                <span id="modal-ba-count-badge" class="font-medium text-slate-500">0 dipilih</span>
            </div>

            <!-- Scrollable Meeting List -->
            <div class="p-5 overflow-y-auto space-y-2 flex-1 divide-y divide-slate-100" id="modal-ba-list">
                <!-- Dynamically populated rows by JS -->
            </div>

            <!-- Footer Actions -->
            <div class="px-5 py-3.5 bg-slate-50/75 border-t border-slate-100 flex items-center justify-between gap-3">
                <button type="button" onclick="closePrintBaModal()" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition cursor-pointer">
                    Batal
                </button>
                <div class="flex items-center gap-2">
                    <button type="button" id="btn-modal-ba-print-all" onclick="printAllBaForGroup()" class="px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 rounded-lg text-xs font-semibold transition flex items-center gap-1.5 cursor-pointer" title="Cetak seluruh pertemuan pada mata kuliah ini">
                        <i class="fa-solid fa-print text-slate-400"></i>
                        <span>Cetak Semua</span>
                    </button>
                    <button type="button" id="btn-modal-ba-print-selected" onclick="printSelectedModalBa()" class="px-4 py-1.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-xs cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-print"></i>
                        <span id="text-modal-ba-print-btn">Cetak Terpilih (0)</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Agenda (Buat Agenda Mata Kuliah) -->
    <div id="modal-add-agenda" class="fixed inset-0 z-50 overflow-y-auto hidden text-sm">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-add-agenda')"></div>
        
        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-xl bg-white rounded-2xl shadow-2xl overflow-hidden text-left border-2 border-slate-200">
                <!-- Header -->
                <div class="bg-slate-50 border-b-2 border-slate-200 px-6 py-5 flex justify-between items-center text-slate-900">
                    <h3 class="font-black text-lg flex items-center gap-2.5">
                        <i class="fa-solid fa-calendar-plus text-teal-700"></i>
                        <span>Buat Agenda Mata Kuliah Baru</span>
                    </h3>
                    <button type="button" onclick="toggleModal('modal-add-agenda')" class="w-10 h-10 rounded-xl bg-white border border-slate-300 text-slate-600 hover:text-slate-900 flex items-center justify-center text-xl transition cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                
                <!-- Body -->
                <form action="{{ route('dosen.agenda.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <!-- 1. Combobox Mata Kuliah Berdasarkan Jadwal Lab -->
                    <div>
                        <label class="block text-base font-bold text-slate-900 mb-1.5">Mata Kuliah &amp; Kelas <span class="text-rose-600">*</span></label>
                        @if(isset($jadwalPenggunaanLab) && $jadwalPenggunaanLab->count() > 0)
                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="jadwal_penggunaan_lab_id" id="modal_jadwal_id" required>

                            <!-- Custom Searchable Combobox Component -->
                            <div class="relative" id="combobox_container_modal">
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-magnifying-glass absolute left-4 text-slate-400 text-base pointer-events-none"></i>
                                    <input type="text" 
                                           id="combobox_search_modal" 
                                           placeholder="-- Cari / Pilih Mata Kuliah Terjadwal --" 
                                           autocomplete="off"
                                           onclick="toggleComboboxModal(true)"
                                           onfocus="toggleComboboxModal(true)"
                                           oninput="filterComboboxModal(this.value)"
                                           class="w-full pl-11 pr-11 py-3 rounded-xl bg-white border-2 border-slate-300 text-slate-900 font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition placeholder:font-normal placeholder:text-slate-400 cursor-pointer" />
                                    <button type="button" 
                                            onclick="toggleComboboxModal()" 
                                            class="absolute right-3 text-slate-500 hover:text-slate-700 p-1 focus:outline-none cursor-pointer">
                                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200" id="combobox_arrow_modal"></i>
                                    </button>
                                </div>

                                <!-- Dropdown Options Menu -->
                                <div id="combobox_menu_modal" 
                                     class="hidden absolute z-30 left-0 right-0 mt-1 max-h-72 overflow-y-auto bg-white border-2 border-slate-300 rounded-xl shadow-xl divide-y divide-slate-100">
                                    @foreach($jadwalPenggunaanLab as $j)
                                        @php
                                            $semLabel = str_contains(strtolower($j->semester ?? ''), 'semester') 
                                                ? $j->semester 
                                                : 'Semester ' . ($j->semester ?? '1');
                                            $isKaryawan = strcasecmp($j->program_kuliah ?? '', 'karyawan') === 0;
                                            $progLabel = $isKaryawan ? 'Karyawan' : 'Reguler';
                                        @endphp
                                        <div class="combobox-item p-3.5 hover:bg-slate-50 cursor-pointer transition flex flex-col gap-1.5"
                                             data-id="{{ $j->id }}"
                                             data-title="{{ $j->mata_kuliah }} - Kelas {{ $j->kelas }} ({{ $progLabel }}, {{ $semLabel }}, {{ $j->hari }})"
                                             data-search="{{ strtolower($j->mata_kuliah . ' ' . $j->kelas . ' ' . $progLabel . ' ' . $j->hari . ' ' . ($j->lab->nama_lab ?? '') . ' ' . ($j->prodi->nama_prodi ?? '') . ' ' . $semLabel) }}"
                                             data-lab="{{ strtoupper($j->lab->nama_lab ?? 'Lab') }}"
                                             data-lab-id="{{ $j->lab_id }}"
                                             data-kelas="{{ $j->kelas ?? 'A' }}"
                                             data-program="{{ $progLabel }}"
                                             data-semester="{{ $j->semester ?? '1' }}"
                                             data-prodi="{{ $j->prodi->nama_prodi ?? 'Sistem Informasi' }}"
                                             data-hari="{{ $j->hari }}"
                                             data-jam-mulai="{{ substr($j->jam_mulai, 0, 5) }}"
                                             data-jam-selesai="{{ substr($j->jam_selesai, 0, 5) }}"
                                             onclick="selectComboboxModal(this)">
                                            <div class="flex items-center justify-between font-bold text-slate-900 text-sm sm:text-base gap-2">
                                                <span class="font-extrabold text-slate-900">{{ $j->mata_kuliah }}</span>
                                                <div class="flex items-center gap-1.5 shrink-0 flex-wrap">
                                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-800 border border-slate-300 rounded text-xs font-bold">
                                                        {{ $semLabel }}
                                                    </span>
                                                    @if($isKaryawan)
                                                        <span class="px-2 py-0.5 bg-purple-100 text-purple-900 border border-purple-300 rounded text-xs font-extrabold flex items-center gap-1">
                                                            <i class="fa-solid fa-briefcase text-[10px] text-purple-700"></i> Karyawan
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-0.5 bg-blue-50 text-blue-900 border border-blue-200 rounded text-xs font-bold flex items-center gap-1">
                                                            <i class="fa-solid fa-graduation-cap text-[10px] text-blue-700"></i> Reguler
                                                        </span>
                                                    @endif
                                                    <span class="px-2 py-0.5 bg-slate-200 text-slate-900 rounded text-xs font-bold">Kelas {{ $j->kelas }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between text-xs sm:text-sm text-slate-600 font-semibold mt-0.5">
                                                <span>
                                                    <i class="fa-regular fa-clock mr-1.5 text-slate-500"></i>{{ $j->hari }}, {{ substr($j->jam_mulai,0,5) }} - {{ substr($j->jam_selesai,0,5) }} WIB
                                                    @if($isKaryawan)
                                                        <span class="text-purple-700 font-bold ml-1">(Kelas Malam)</span>
                                                    @endif
                                                </span>
                                                <span class="text-slate-900 font-bold bg-slate-100 px-2 py-0.5 rounded border border-slate-300"><i class="fa-solid fa-door-open mr-1 text-slate-600"></i>{{ $j->lab->nama_lab ?? 'Lab' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="combobox_empty_modal" class="hidden p-4 text-center text-slate-500 text-sm italic">
                                        Tidak ada mata kuliah yang cocok dengan kata kunci pencarian.
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Box of Selected Matkul -->
                            <div id="modal-jadwal-info-box" class="hidden mt-2.5 p-3.5 bg-slate-50 border border-slate-300 rounded-xl space-y-1 text-sm">
                                <div class="flex justify-between items-center font-bold text-slate-900">
                                    <span id="modal-info-lab"><i class="fa-solid fa-door-open mr-1.5 text-slate-700"></i> Lab</span>
                                    <span id="modal-info-kelas" class="px-2.5 py-0.5 bg-slate-200 text-slate-900 rounded text-xs font-bold">Kelas</span>
                                </div>
                                <div class="text-slate-700 font-semibold">
                                    <span>Jadwal Rutin: <strong id="modal-info-rutin" class="text-slate-900 font-bold">-</strong></span>
                                </div>
                                <div class="text-sm text-slate-600 font-medium" id="modal-info-prodi">-</div>
                            </div>
                        @else
                            <div class="p-4 bg-amber-50 border-2 border-amber-300 text-amber-950 rounded-xl text-sm font-semibold">
                                Belum ada jadwal mata kuliah yang di-plotting untuk Anda.
                            </div>
                        @endif
                    </div>

                    <!-- 2. Tanggal Pelaksanaan -->
                    <div>
                        <label class="block text-base font-bold text-slate-900 mb-1.5">Tanggal Pertemuan <span class="text-rose-600">*</span></label>
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" onchange="checkLiveModalClash()" class="w-full py-3 px-3.5 rounded-xl bg-white border-2 border-slate-300 text-slate-900 font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                    </div>

                    <!-- 3. Jam Mulai & Jam Selesai -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-base font-bold text-slate-900 mb-1.5">Jam Mulai <span class="text-rose-600">*</span></label>
                            <input type="time" name="waktu_masuk" id="modal_input_waktu_masuk" required value="08:00" onchange="checkLiveModalClash()" class="w-full py-3 px-3.5 rounded-xl bg-white border-2 border-slate-300 text-slate-900 font-mono font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                        </div>
                        <div>
                            <label class="block text-base font-bold text-slate-900 mb-1.5">Jam Selesai <span class="text-rose-600">*</span></label>
                            <input type="time" name="waktu_keluar" id="modal_input_waktu_keluar" required value="10:30" onchange="checkLiveModalClash()" class="w-full py-3 px-3.5 rounded-xl bg-white border-2 border-slate-300 text-slate-900 font-mono font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none">
                        </div>
                    </div>

                    <!-- Peringatan Otomatis Real-Time Jika Bentrok -->
                    <div id="modal-live-clash-box" class="hidden p-4 bg-rose-50 border-2 border-rose-300 rounded-xl text-sm font-bold text-rose-950 space-y-1">
                        <div class="flex items-center gap-2 text-rose-950 font-black">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                            <span id="modal-clash-title">Bentrok Ruangan Terdeteksi!</span>
                        </div>
                        <p id="modal-clash-msg" class="text-rose-800 font-medium"></p>
                        <a href="{{ route('dosen.jadwal-lab') }}" target="_blank" class="inline-flex items-center gap-1.5 text-teal-800 hover:text-teal-900 hover:underline font-bold text-sm pt-1">
                            <i class="fa-solid fa-calendar-days"></i> Buka Kalender Jam Kosong Lab &rarr;
                        </a>
                    </div>

                    <!-- 4. Materi Praktikum -->
                    <div>
                        <label class="block text-base font-bold text-slate-900 mb-1.5">Materi Praktikum <span class="text-slate-500 font-normal text-xs">(Opsional)</span></label>
                        <textarea name="materi_pembelajaran" rows="3" placeholder="Tuliskan materi praktikum pada pertemuan ini (Opsional)..." class="w-full p-3.5 rounded-xl bg-white border-2 border-slate-300 text-slate-900 text-base font-medium focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none placeholder:text-slate-400"></textarea>
                    </div>

                    <!-- Fallback Collapsible: Pengaturan Ruangan Lain -->
                    <details class="bg-slate-50 border border-slate-300 rounded-xl overflow-hidden group">
                        <summary class="px-4 py-3 text-sm font-bold text-slate-700 hover:text-slate-900 cursor-pointer flex items-center justify-between select-none">
                            <span><i class="fa-solid fa-sliders mr-1.5 text-slate-600"></i> Pengaturan Tambahan / Ganti Ruang Lab</span>
                            <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <div class="p-4 border-t border-slate-200 space-y-3 bg-white">
                            <div>
                                <label class="block text-sm font-bold text-slate-900 mb-1">Ganti Laboratorium (Opsional)</label>
                                <select name="lab_id" class="w-full py-2.5 px-3 rounded-lg bg-white border border-slate-300 text-slate-800 text-sm font-semibold">
                                    <option value="">Gunakan Lab Bawaan Jadwal</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}">{{ $lab->nama_lab }} ({{ $lab->lokasi }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-900 mb-1">Dosen Pengampu (Opsional)</label>
                                <select name="dosen_pengampu_id" class="w-full py-2.5 px-3 rounded-lg bg-white border border-slate-300 text-slate-800 text-sm font-semibold">
                                    <option value="">Gunakan Pengampu Bawaan Jadwal</option>
                                    @foreach($dosens as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }} (NIP: {{ $d->nip }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </details>

                    <div class="flex justify-end gap-3 pt-3 border-t border-slate-200 bg-white">
                        <button type="button" onclick="toggleModal('modal-add-agenda')" class="min-h-[44px] px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-base rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="min-h-[44px] px-6 py-2.5 bg-slate-900 hover:bg-slate-800 active:scale-98 text-white font-bold text-base rounded-xl transition shadow-xs flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Buat Agenda</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Toggle & Search Select Script -->
    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        function onSelectJadwalKuliahModal(selectEl) {
            const selected = selectEl.options[selectEl.selectedIndex];
            if (!selected || !selected.value) return;

            const lab = selected.dataset.lab || '';
            const kelas = selected.dataset.kelas || '';
            const semester = selected.dataset.semester || '';
            const prodi = selected.dataset.prodi || '';
            const hari = selected.dataset.hari || '';
            const jamMulai = selected.dataset.jamMulai || '';
            const jamSelesai = selected.dataset.jamSelesai || '';

            const box = document.getElementById('modal-jadwal-info-box');
            if (box) {
                box.classList.remove('hidden');
                const labEl = document.getElementById('modal-info-lab');
                const kelasEl = document.getElementById('modal-info-kelas');
                const rutinEl = document.getElementById('modal-info-rutin');
                const prodiEl = document.getElementById('modal-info-prodi');

                if (labEl) labEl.innerHTML = `<i class="fa-solid fa-door-open mr-1 text-teal-600"></i> ${lab}`;
                if (kelasEl) kelasEl.innerText = `Kelas ${kelas} • Smt ${semester}`;
                if (rutinEl) rutinEl.innerText = `${hari}, ${jamMulai} - ${jamSelesai} WIB`;
                if (prodiEl) prodiEl.innerText = prodi;
            }

            const inMasuk = document.getElementById('modal_input_waktu_masuk');
            const inKeluar = document.getElementById('modal_input_waktu_keluar');
            if (inMasuk && jamMulai) inMasuk.value = jamMulai;
            if (inKeluar && jamSelesai) inKeluar.value = jamSelesai;
        }

        function toggleSearchSelect(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        function selectSearchOption(hiddenInputId, labelId, dropdownId, value) {
            const hiddenInput = document.getElementById(hiddenInputId);
            const label = document.getElementById(labelId);
            const dropdown = document.getElementById(dropdownId);
            
            if (hiddenInput && label && dropdown) {
                hiddenInput.value = value;
                label.innerText = value;
                label.classList.remove('text-slate-400');
                label.classList.add('text-slate-700');
                dropdown.classList.add('hidden');
            }
        }

        function filterSearchSelect(dropdownId, query) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const options = dropdown.getElementsByClassName('select-option-item');
                const lowercaseQuery = query.toLowerCase();
                
                for (let i = 0; i < options.length; i++) {
                    const text = options[i].textContent || options[i].innerText;
                    const matchesSearch = text.toLowerCase().indexOf(lowercaseQuery) > -1;
                    
                    if (matchesSearch) {
                        options[i].classList.remove('hidden-by-search');
                        if (!options[i].classList.contains('hidden-by-fakultas')) {
                            options[i].style.display = "";
                        }
                    } else {
                        options[i].classList.add('hidden-by-search');
                        options[i].style.display = "none";
                    }
                }
            }
        }

        function handleFakultasChange(selectedFakultas, hiddenInputId, labelId, dropdownId) {
            // Reset prodi label & input value
            const hiddenInput = document.getElementById(hiddenInputId);
            const label = document.getElementById(labelId);
            if (hiddenInput && label) {
                hiddenInput.value = "";
                label.innerText = "Pilih Program Studi";
                label.classList.add('text-slate-400');
                label.classList.remove('text-slate-700');
            }
            
            // Filter options by data-fakultas
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                const options = dropdown.getElementsByClassName('select-option-item');
                for (let i = 0; i < options.length; i++) {
                    const optFak = options[i].getAttribute('data-fakultas');
                    if (!selectedFakultas || optFak === selectedFakultas) {
                        options[i].classList.remove('hidden-by-fakultas');
                        if (!options[i].classList.contains('hidden-by-search')) {
                            options[i].style.display = "";
                        }
                    } else {
                        options[i].classList.add('hidden-by-fakultas');
                        options[i].style.display = "none";
                    }
                }
            }
        }

        // Close search dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideSelect = event.target.closest('.custom-search-select');
            if (!isClickInsideSelect) {
                const dropdowns = document.querySelectorAll('[id^="select-jurusan-dropdown"]');
                dropdowns.forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                });
            }
        });
    </script>

    <!-- Hidden form for bulk delete -->
    <form id="bulk-delete-form" action="{{ route('dosen.agenda.bulk-delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- Bulk delete checkboxes & Accordion Script -->
    <script>
        let selectModeActive = false;

        // ==========================================
        // ACCORDION EXPAND / COLLAPSE CONTROLLERS
        // ==========================================
        function toggleCourseAccordion(slug) {
            const content = document.getElementById('content-' + slug);
            const chevron = document.getElementById('chevron-' + slug);
            const header = document.getElementById('header-' + slug);

            if (!content) return;

            const isHidden = content.classList.contains('hidden');

            if (isHidden) {
                content.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180', 'text-teal-800');
                if (header) header.setAttribute('aria-expanded', 'true');
            } else {
                content.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180', 'text-teal-800');
                if (header) header.setAttribute('aria-expanded', 'false');
            }

            syncGlobalCourseExpandBtn();
        }

        function toggleAllCourseAccordions(btn) {
            const allContents = document.querySelectorAll('.course-accordion-content');
            if (allContents.length === 0) return;

            const anyClosed = Array.from(allContents).some(c => c.classList.contains('hidden'));

            allContents.forEach(c => {
                const slug = c.id.replace('content-', '');
                const chevron = document.getElementById('chevron-' + slug);
                const header = document.getElementById('header-' + slug);

                if (anyClosed) {
                    c.classList.remove('hidden');
                    if (chevron) chevron.classList.add('rotate-180', 'text-teal-800');
                    if (header) header.setAttribute('aria-expanded', 'true');
                } else {
                    c.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180', 'text-teal-800');
                    if (header) header.setAttribute('aria-expanded', 'false');
                }
            });

            syncGlobalCourseExpandBtn();
        }

        function syncGlobalCourseExpandBtn() {
            const allContents = document.querySelectorAll('.course-accordion-content');
            if (allContents.length === 0) return;

            const allOpen = Array.from(allContents).every(c => !c.classList.contains('hidden'));
            const textEl = document.getElementById('text-toggle-all-courses');
            const iconEl = document.getElementById('icon-toggle-all-courses');

            if (textEl) {
                textEl.innerText = allOpen ? 'Tutup Semua' : 'Buka Semua';
            }
            if (iconEl) {
                if (allOpen) {
                    iconEl.classList.add('rotate-180');
                } else {
                    iconEl.classList.remove('rotate-180');
                }
            }
        }

        function toggleCourseGroup(master, slug) {
            const content = document.getElementById('content-' + slug);
            if (content && content.classList.contains('hidden') && master.checked) {
                toggleCourseAccordion(slug);
            }
            const checkboxes = document.querySelectorAll('.item-' + slug + ' .agenda-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = master.checked;
            });
            updateBulkDeleteButton();
        }

        function handleSingleCheckboxChange() {
            updateBulkDeleteButton();
        }

        function toggleSelectMode() {
            selectModeActive = !selectModeActive;
            applySelectModeUI();
        }

        function cancelBulkSelection() {
            selectModeActive = false;
            applySelectModeUI();
        }

        function applySelectModeUI() {
            const btnToggleSelect = document.getElementById('btn-toggle-select');
            const containerCheckAll = document.getElementById('container-check-all');
            const checkAll = document.getElementById('check-all');
            const containerCheckboxes = document.querySelectorAll('.container-checkbox');
            const innerContainers = document.querySelectorAll('.inner-agenda-container');

            if (selectModeActive) {
                if (containerCheckAll) containerCheckAll.classList.remove('hidden');
                containerCheckboxes.forEach(cb => {
                    cb.classList.remove('hidden');
                    if (cb.classList.contains('items-center')) {
                        cb.classList.add('flex');
                    }
                });
                innerContainers.forEach(container => {
                    container.classList.remove('pl-0');
                    container.classList.add('pl-7');
                });
                if (btnToggleSelect) {
                    btnToggleSelect.innerHTML = `<i class="fa-solid fa-xmark"></i> Selesai Pilih`;
                    btnToggleSelect.classList.remove('bg-slate-100', 'hover:bg-slate-200', 'text-slate-700');
                    btnToggleSelect.classList.add('bg-slate-200', 'text-slate-800');
                }
            } else {
                if (containerCheckAll) containerCheckAll.classList.add('hidden');
                containerCheckboxes.forEach(cb => {
                    cb.classList.add('hidden');
                    if (cb.classList.contains('flex')) {
                        cb.classList.remove('flex');
                    }
                });
                innerContainers.forEach(container => {
                    container.classList.remove('pl-7');
                    container.classList.add('pl-0');
                });
                if (btnToggleSelect) {
                    btnToggleSelect.innerHTML = `<i class="fa-solid fa-square-check"></i> Pilih Banyak`;
                    btnToggleSelect.classList.remove('bg-slate-200', 'text-slate-800');
                    btnToggleSelect.classList.add('bg-slate-100', 'hover:bg-slate-200', 'text-slate-700');
                }
                if (checkAll) checkAll.checked = false;
                document.querySelectorAll('.agenda-checkbox').forEach(cb => cb.checked = false);
                document.querySelectorAll('.course-master-checkbox').forEach(cb => cb.checked = false);
            }
            updateBulkDeleteButton();
        }

        function updateBulkDeleteButton() {
            const allCheckboxes = document.querySelectorAll('.agenda-checkbox');
            const checkedBoxes = document.querySelectorAll('.agenda-checkbox:checked');
            const checkedCount = checkedBoxes.length;

            const selectedCount = document.getElementById('selected-count');
            const stickySelectedCount = document.getElementById('sticky-selected-count');
            const btnBulkDelete = document.getElementById('btn-bulk-delete');
            const stickyBulkBar = document.getElementById('sticky-bulk-bar');
            const checkAll = document.getElementById('check-all');

            if (selectedCount) selectedCount.innerText = checkedCount;
            if (stickySelectedCount) stickySelectedCount.innerText = checkedCount;

            if (checkedCount > 0 && selectModeActive) {
                if (btnBulkDelete) btnBulkDelete.classList.remove('hidden');
                if (stickyBulkBar) stickyBulkBar.classList.remove('hidden');
            } else {
                if (btnBulkDelete) btnBulkDelete.classList.add('hidden');
                if (stickyBulkBar) stickyBulkBar.classList.add('hidden');
            }

            if (checkAll && allCheckboxes.length > 0) {
                checkAll.checked = (checkedCount === allCheckboxes.length);
            }

            // Sync each course master checkbox
            document.querySelectorAll('.course-master-checkbox').forEach(master => {
                const slug = master.getAttribute('data-course');
                if (slug) {
                    const groupCbs = document.querySelectorAll('.item-' + slug + ' .agenda-checkbox');
                    if (groupCbs.length > 0) {
                        const allGroupChecked = Array.from(groupCbs).every(cb => cb.checked);
                        master.checked = allGroupChecked;
                    }
                }
            });
        }

        function submitBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.agenda-checkbox:checked');
            if (checkedBoxes.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Pilih Agenda Terlebih Dahulu',
                    text: 'Silakan centang setidaknya satu agenda untuk dihapus.',
                    confirmButtonColor: '#0f766e',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }
            
            Swal.fire({
                title: 'Hapus ' + checkedBoxes.length + ' Agenda Terpilih?',
                text: 'Semua data dari ' + checkedBoxes.length + ' agenda perkuliahan terpilih beserta absensinya akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus ' + checkedBoxes.length + ' Agenda!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('bulk-delete-form');
                    form.querySelectorAll('input[name="agenda_ids[]"]').forEach(el => el.remove());
                    checkedBoxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'agenda_ids[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });
                    form.dataset.confirmed = "true";
                    form.submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const btnToggleSelect = document.getElementById('btn-toggle-select');
            if (btnToggleSelect) {
                btnToggleSelect.addEventListener('click', toggleSelectMode);
            }

            const checkAll = document.getElementById('check-all');
            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    const currentCheckboxes = document.querySelectorAll('.agenda-checkbox');
                    currentCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    document.querySelectorAll('.course-master-checkbox').forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateBulkDeleteButton();
                });
            }

            // Real-time dynamic polling for student check-ins
            function pollAgendas() {
                // If bulk selection mode is active or any checkbox is checked, do NOT poll
                if (selectModeActive || document.querySelectorAll('.agenda-checkbox:checked').length > 0) return;

                // If any modal (edit agenda, add agenda) is open, do not poll
                const openModal = document.querySelector('div[id^="modal-"]:not(.hidden)');
                if (openModal) return;

                // Check if any input/textarea in details has focus
                const activeEl = document.activeElement;
                if (activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'TEXTAREA')) {
                    return;
                }

                // Backup which course accordions and details are open/closed
                const openCourseSlugs = [];
                const closedCourseSlugs = [];
                document.querySelectorAll('.course-accordion-content').forEach(el => {
                    const slug = el.id.replace('content-', '');
                    if (!el.classList.contains('hidden')) {
                        openCourseSlugs.push(slug);
                    } else {
                        closedCourseSlugs.push(slug);
                    }
                });

                const openDetailsIndices = [];
                document.querySelectorAll('#agenda-list-container details').forEach((details, index) => {
                    if (details.open) {
                        openDetailsIndices.push(index);
                    }
                });

                fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) return response.json();
                    throw new Error('Network error');
                })
                .then(data => {
                    if (data.html) {
                        const container = document.getElementById('agenda-list-container');
                        if (container.innerHTML !== data.html) {
                            container.innerHTML = data.html;

                            // Restore accordion open/closed state
                            openCourseSlugs.forEach(slug => {
                                const content = document.getElementById('content-' + slug);
                                const chevron = document.getElementById('chevron-' + slug);
                                const header = document.getElementById('header-' + slug);
                                if (content) content.classList.remove('hidden');
                                if (chevron) chevron.classList.add('rotate-180', 'text-teal-800');
                                if (header) header.setAttribute('aria-expanded', 'true');
                            });
                            closedCourseSlugs.forEach(slug => {
                                const content = document.getElementById('content-' + slug);
                                const chevron = document.getElementById('chevron-' + slug);
                                const header = document.getElementById('header-' + slug);
                                if (content) content.classList.add('hidden');
                                if (chevron) chevron.classList.remove('rotate-180', 'text-teal-800');
                                if (header) header.setAttribute('aria-expanded', 'false');
                            });
                            syncGlobalCourseExpandBtn();

                            // Restore open state for details
                            document.querySelectorAll('#agenda-list-container details').forEach((details, index) => {
                                if (openDetailsIndices.includes(index)) {
                                    details.open = true;
                                }
                            });

                            // Re-apply select mode UI if active
                            if (selectModeActive) {
                                applySelectModeUI();
                            }
                        }
                    }
                })
                .catch(err => console.error("Error polling agendas: ", err));
            }

            // Sync global button on initial load
            syncGlobalCourseExpandBtn();

            // Start polling every 5 seconds
            setInterval(pollAgendas, 5000);
        });
    </script>

    <!-- Hidden form for QR attendance submission -->
    <form id="dosen-absensi-form" action="{{ route('dosen.absensi.submit') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="qr_code_token" id="dosen-qr-token-input">
    </form>

    <!-- QR Scanner Modal -->
    <div id="modal-qr-scanner" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100 text-slate-800">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i class="fa-solid fa-camera text-teal-800"></i> Pindai QR Code Board
                </h3>
                <button type="button" onclick="closeScannerModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <div class="space-y-4">
                <div id="qr-reader" class="overflow-hidden rounded-xl border border-slate-200" style="width: 100%; min-height: 250px;"></div>
                <div id="qr-reader-results" class="text-center text-xs text-slate-500 font-mono"></div>
            </div>
            
            <div class="flex pt-3 border-t border-slate-100">
                <button type="button" onclick="closeScannerModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <!-- html5-qrcode script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner = null;

        function startDosenQRScanner() {
            document.getElementById('modal-qr-scanner').classList.remove('hidden');
            
            html5QrcodeScanner = new Html5Qrcode("qr-reader");
            const config = { fps: 10, qrbox: { width: 220, height: 220 } };
            
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    let cameraId = devices[0].id;
                    for (let i = 0; i < devices.length; i++) {
                        const label = devices[i].label.toLowerCase();
                        if (label.includes('back') || label.includes('rear') || label.includes('lingkungan') || label.includes('belakang')) {
                            cameraId = devices[i].id;
                            break;
                        }
                    }
                    
                    html5QrcodeScanner.start(
                        cameraId,
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {}
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                } else {
                    html5QrcodeScanner.start(
                        { facingMode: "environment" },
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {}
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                }
            }).catch(err => {
                console.error("Gagal getCameras: ", err);
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText, decodedResult) => {
                        document.getElementById('dosen-qr-token-input').value = decodedText;
                        document.getElementById('dosen-absensi-form').submit();
                        closeScannerModal();
                    },
                    (errorMessage) => {}
                ).catch((err2) => {
                    console.error("Gagal memulai kamera: ", err2);
                    alert("Gagal mengakses kamera. Detail:\n1. " + err + "\n2. " + err2);
                    closeScannerModal();
                });
            });
        }

        function closeScannerModal() {
            document.getElementById('modal-qr-scanner').classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch(err => {
                    console.error("Gagal menghentikan scanner: ", err);
                });
            }
        }

        // Combobox Modal Handlers
        function toggleComboboxModal(forceOpen = null) {
            const menu = document.getElementById('combobox_menu_modal');
            const arrow = document.getElementById('combobox_arrow_modal');
            if (!menu) return;

            const isOpen = forceOpen !== null ? forceOpen : menu.classList.contains('hidden');
            if (isOpen) {
                menu.classList.remove('hidden');
                if (arrow) arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        }

        function filterComboboxModal(query) {
            toggleComboboxModal(true);
            const q = query.toLowerCase().trim();
            const items = document.querySelectorAll('#combobox_menu_modal .combobox-item');
            let hasMatch = false;

            items.forEach(item => {
                const searchText = item.dataset.search || '';
                if (!q || searchText.includes(q)) {
                    item.classList.remove('hidden');
                    hasMatch = true;
                } else {
                    item.classList.add('hidden');
                }
            });

            const emptyMsg = document.getElementById('combobox_empty_modal');
            if (emptyMsg) {
                if (hasMatch) emptyMsg.classList.add('hidden');
                else emptyMsg.classList.remove('hidden');
            }
        }

        function selectComboboxModal(itemEl) {
            const hiddenInput = document.getElementById('modal_jadwal_id');
            const searchInput = document.getElementById('combobox_search_modal');
            
            if (hiddenInput) hiddenInput.value = itemEl.dataset.id;
            if (searchInput) searchInput.value = itemEl.dataset.title;

            document.querySelectorAll('#combobox_menu_modal .combobox-item').forEach(el => {
                el.classList.remove('bg-teal-100/80', 'border-l-4', 'border-teal-700');
            });
            itemEl.classList.add('bg-teal-100/80', 'border-l-4', 'border-teal-700');

            const lab = itemEl.dataset.lab || '';
            const kelas = itemEl.dataset.kelas || '';
            const semester = itemEl.dataset.semester || '';
            const prodi = itemEl.dataset.prodi || '';
            const hari = itemEl.dataset.hari || '';
            const jamMulai = itemEl.dataset.jamMulai || '';
            const jamSelesai = itemEl.dataset.jamSelesai || '';

            const box = document.getElementById('modal-jadwal-info-box');
            if (box) {
                box.classList.remove('hidden');
                const labEl = document.getElementById('modal-info-lab');
                const kelasEl = document.getElementById('modal-info-kelas');
                const rutinEl = document.getElementById('modal-info-rutin');
                const prodiEl = document.getElementById('modal-info-prodi');

                if (labEl) labEl.innerHTML = `<i class="fa-solid fa-door-open mr-1 text-teal-600"></i> ${lab}`;
                if (kelasEl) kelasEl.innerText = `Kelas ${kelas} • Smt ${semester}`;
                if (rutinEl) rutinEl.innerText = `${hari}, ${jamMulai} - ${jamSelesai} WIB`;
                if (prodiEl) prodiEl.innerText = prodi;
            }

            const inMasuk = document.getElementById('modal_input_waktu_masuk');
            const inKeluar = document.getElementById('modal_input_waktu_keluar');
            if (inMasuk && jamMulai) inMasuk.value = jamMulai;
            if (inKeluar && jamSelesai) inKeluar.value = jamSelesai;

            toggleComboboxModal(false);
            checkLiveModalClash();
        }

        function checkLiveModalClash() {
            const warningBox = document.getElementById('modal-live-clash-box');
            const warningTitle = document.getElementById('modal-clash-title');
            const warningMsg = document.getElementById('modal-clash-msg');
            const inMasuk = document.getElementById('modal_input_waktu_masuk');
            const inKeluar = document.getElementById('modal_input_waktu_keluar');
            const tglInput = document.querySelector('input[name="tanggal"]');
            const labSelect = document.querySelector('select[name="lab_id"]');

            if (!inMasuk || !inKeluar || !tglInput) return;

            let labId = labSelect && labSelect.value ? labSelect.value : null;
            if (!labId) {
                const activeItem = document.querySelector('#combobox_menu_modal .combobox-item.bg-teal-100\\/80');
                if (activeItem && activeItem.dataset.labId) {
                    labId = activeItem.dataset.labId;
                }
            }

            const tanggal = tglInput.value;
            const waktuMasuk = inMasuk.value;
            const waktuKeluar = inKeluar.value;

            if (!tanggal || !waktuMasuk || !waktuKeluar || !labId) {
                if (warningBox) warningBox.classList.add('hidden');
                return;
            }

            const url = `{{ route('dosen.jadwal-lab.check-availability') }}?lab_id=${labId}&tanggal=${tanggal}&waktu_masuk=${waktuMasuk}&waktu_keluar=${waktuKeluar}`;

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    if (data.available === false) {
                        if (warningBox) warningBox.classList.remove('hidden');
                        if (warningTitle) warningTitle.innerText = data.title;
                        if (warningMsg) warningMsg.innerText = data.message;
                    } else {
                        if (warningBox) warningBox.classList.add('hidden');
                    }
                })
                .catch(err => console.error("Gagal memeriksa bentrok jadwal: ", err));
        }

        document.addEventListener('click', function(e) {
            const containerModal = document.getElementById('combobox_container_modal');
            if (containerModal && !containerModal.contains(e.target)) {
                toggleComboboxModal(false);
            }
        });
    </script>

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
        function confirmAction(event, text, title = 'Apakah Anda yakin?', confirmText = 'Ya, Lanjutkan!') {
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            if (form && form.dataset.confirmed === "true") {
                return true;
            }

            event.preventDefault();
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.dataset.confirmed = "true";
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            });
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium'
                    }
                });
            @endif

            @if(session('error') || session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error') ?? session('failed')),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            @if($errors->any() && !session('success') && !session('error') && !session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memproses Data!',
                    text: @json($errors->first()),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            // CRUD & Form Submit Loading Spinner
            document.querySelectorAll('form').forEach(function(form) {
                if (form.method.toUpperCase() === 'GET' || form.classList.contains('no-loading')) {
                    return;
                }

                form.addEventListener('submit', function(e) {
                    if (e.defaultPrevented) return;
                    if (form.checkValidity && !form.checkValidity()) {
                        return;
                    }

                    const isLogout = (form.action && form.action.includes('logout')) || form.classList.contains('logout-form');
                    const isImport = form.getAttribute('enctype') === 'multipart/form-data';
                    
                    let loadingTitle = 'Menyimpan Data...';
                    let loadingText = 'Sedang memproses dan menyimpan data ke sistem.';
                    
                    if (isLogout) {
                        loadingTitle = 'Sedang Keluar...';
                        loadingText = 'Menutup sesi akun Anda dengan aman.';
                    } else if (isImport) {
                        loadingTitle = 'Mengimpor Data...';
                        loadingText = 'Sistem sedang membaca dan memproses file Excel/CSV.';
                    }

                    Swal.fire({
                        title: loadingTitle,
                        text: loadingText,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl p-8 shadow-2xl border border-slate-100',
                            title: 'text-base font-extrabold text-slate-800',
                            htmlContainer: 'text-xs text-slate-500 font-medium'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        }
                    }, 10);
                });
            });
        });

        // ==========================================
        // BERITA ACARA PRINT (PER MK & BULK SELECT)
        // ==========================================
        let currentPrintBaFirstId = null;
        let currentPrintBaGroupSlug = null;

        function printSelectedDosenAgendasBa() {
            const checked = document.querySelectorAll('.agenda-checkbox:checked');
            if (checked.length === 0) {
                Swal.fire({
                    title: 'Pilih Agenda Terlebih Dahulu',
                    text: 'Silakan centang minimal satu sesi agenda untuk mencetak Berita Acara.',
                    icon: 'info',
                    confirmButtonColor: '#0f766e',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }
            const ids = Array.from(checked).map(cb => cb.value);
            const firstId = ids[0];
            const baseUrl = "{{ route('dosen.agenda.berita-acara.cetak', ':id') }}".replace(':id', firstId);
            window.open(`${baseUrl}?ids=${ids.join(',')}`, '_blank');
        }

        function openPrintBaModal(groupSlug, courseTitle, className, firstId) {
            currentPrintBaFirstId = firstId;
            currentPrintBaGroupSlug = groupSlug;

            const modal = document.getElementById('modal-print-ba');
            const subtitle = document.getElementById('modal-ba-subtitle');
            const listContainer = document.getElementById('modal-ba-list');
            const selectAllCb = document.getElementById('modal-ba-select-all');

            if (subtitle) {
                subtitle.textContent = `${courseTitle} • Kelas ${className}`;
            }
            if (listContainer) {
                listContainer.innerHTML = '';
            }

            const rows = document.querySelectorAll(`div.item-${groupSlug}`);
            if (rows.length === 0) {
                if (listContainer) {
                    listContainer.innerHTML = '<div class="text-center py-6 text-slate-400 text-xs">Tidak ada pertemuan pada mata kuliah ini.</div>';
                }
            } else {
                rows.forEach(row => {
                    const id = row.dataset.agendaId;
                    const pertemuan = row.dataset.pertemuan;
                    const tanggal = row.dataset.tanggal;
                    const jam = row.dataset.jam;
                    const status = row.dataset.status;
                    const materi = row.dataset.materi;
                    const printUrl = row.dataset.printUrl;

                    const isFinished = (status === 'Selesai');
                    const badgeClass = isFinished 
                        ? 'bg-slate-100 text-slate-600' 
                        : (status === 'Berlangsung' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-50 text-slate-500 border border-slate-200');

                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'py-2.5 flex items-center justify-between gap-3 text-xs';
                    itemDiv.innerHTML = `
                        <label class="flex items-start gap-3 cursor-pointer select-none flex-1 min-w-0">
                            <input type="checkbox" value="${id}" class="modal-ba-item-cb rounded border-slate-300 text-teal-800 focus:ring-teal-700/30 mt-0.5 cursor-pointer" checked onchange="updateModalBaCount()">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold text-slate-800">Pertemuan ${pertemuan}</span>
                                    <span class="text-slate-400">•</span>
                                    <span class="text-slate-600 font-medium">${tanggal}</span>
                                    <span class="text-slate-400 font-mono text-[11px]">${jam}</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium ${badgeClass}">${status}</span>
                                </div>
                                ${materi && materi !== '-' ? `<div class="text-slate-500 text-[11px] truncate mt-0.5"><span class="font-medium text-slate-600">Materi:</span> ${materi}</div>` : ''}
                            </div>
                        </label>
                        <a href="${printUrl}" target="_blank" class="shrink-0 px-2.5 py-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded text-[11px] font-medium transition inline-flex items-center gap-1 border border-slate-200" title="Cetak Berita Acara Khusus Pertemuan ${pertemuan}">
                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i> Satuan
                        </a>
                    `;
                    listContainer.appendChild(itemDiv);
                });
            }

            if (selectAllCb) selectAllCb.checked = true;
            updateModalBaCount();

            if (modal) modal.classList.remove('hidden');
        }

        function closePrintBaModal() {
            const modal = document.getElementById('modal-print-ba');
            if (modal) modal.classList.add('hidden');
        }

        function toggleModalBaSelectAll(masterCb) {
            const itemCbs = document.querySelectorAll('.modal-ba-item-cb');
            itemCbs.forEach(cb => cb.checked = masterCb.checked);
            updateModalBaCount();
        }

        function updateModalBaCount() {
            const itemCbs = document.querySelectorAll('.modal-ba-item-cb');
            const checked = Array.from(itemCbs).filter(cb => cb.checked);
            const countBadge = document.getElementById('modal-ba-count-badge');
            const printBtn = document.getElementById('btn-modal-ba-print-selected');
            const printBtnText = document.getElementById('text-modal-ba-print-btn');
            const selectAllCb = document.getElementById('modal-ba-select-all');

            if (countBadge) countBadge.textContent = `${checked.length} dari ${itemCbs.length} dipilih`;
            if (printBtnText) printBtnText.textContent = `Cetak Terpilih (${checked.length})`;
            if (printBtn) printBtn.disabled = (checked.length === 0);
            if (selectAllCb) selectAllCb.checked = (checked.length === itemCbs.length && itemCbs.length > 0);
        }

        function printSelectedModalBa() {
            const itemCbs = document.querySelectorAll('.modal-ba-item-cb');
            const checkedIds = Array.from(itemCbs).filter(cb => cb.checked).map(cb => cb.value);
            if (checkedIds.length === 0) {
                alert('Silakan pilih minimal 1 pertemuan untuk dicetak.');
                return;
            }
            const baseUrl = "{{ route('dosen.agenda.berita-acara.cetak', ':id') }}".replace(':id', currentPrintBaFirstId);
            window.open(`${baseUrl}?ids=${checkedIds.join(',')}`, '_blank');
        }

        function printAllBaForGroup() {
            const baseUrl = "{{ route('dosen.agenda.berita-acara.cetak', ':id') }}".replace(':id', currentPrintBaFirstId);
            window.open(`${baseUrl}?all_mk=1`, '_blank');
        }
    </script>

    @include('dosen.partials.modal_tutorial')
</body>
</html>
