<!DOCTYPE html>
<html lang="en">
<head>
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
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold tracking-wider text-teal-400">Smart Lab Management</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-border-all"></i>
                <span class="text-xs font-semibold tracking-wide">Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-800 text-white rounded-xl w-full shadow-xs">
                <i class="fa-solid fa-calendar-alt"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-gear"></i>
                <span class="text-xs font-semibold tracking-wide">Pengaturan Akun</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Riwayat Agenda Mengajar</h2>
            </div>

            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ $dosen->nama }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIP: {{ $dosen->nip }} • Dosen</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ substr($dosen->nama, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $dosen->nama }}</p>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">NIP: {{ $dosen->nip }}</p>
                        <span class="inline-block mt-1.5 px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200/60 rounded-md text-[9px] font-bold">
                            Dosen Pengajar
                        </span>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800 transition font-medium group">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-700 flex items-center justify-center text-slate-500 transition">
                                <i class="fa-solid fa-gear text-xs"></i>
                            </div>
                            <div>
                                <span class="font-bold block">Pengaturan Akun</span>
                                <span class="text-[10px] text-slate-400 block font-normal">Edit profil & ganti password</span>
                            </div>
                        </a>
                    </div>

                    <div class="pt-1 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 transition font-bold text-left group">
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
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm mb-4">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm mb-4">
                    <i class="fa-solid fa-circle-xmark text-red-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Error!</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Filter Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <form action="{{ route('dosen.agenda') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end text-xs">
                    <div class="flex-grow w-full">
                        <label class="block text-slate-655 font-bold mb-1.5">Cari Sesi / Mata Kuliah</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan mata kuliah, catatan..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-slate-655 font-bold mb-1.5">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-slate-655 font-bold mb-1.5">Urutkan Tanggal</label>
                        <select name="sort" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-grow md:flex-grow-0 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'tanggal', 'sort']))
                            <a href="{{ route('dosen.agenda') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-all border border-slate-200 text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Agendas List -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Daftar Agenda Perkuliahan & Pertemuan</h3>
                        <span class="text-[10px] bg-teal-50 text-teal-800 border border-teal-200 font-bold px-2.5 py-0.5 rounded-full mt-1 inline-block">{{ $groupedAgendas->count() }} Mata Kuliah ({{ $agendas->total() }} Sesi Pertemuan)</span>
                    </div>
                    
                    <div class="flex items-center gap-3 ml-auto">
                        @if($agendas->count() > 0)
                            <button type="button" id="btn-toggle-select" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-bold rounded-lg transition-all flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-square-check"></i> Pilih Banyak
                            </button>
                            <div id="container-check-all" class="flex items-center gap-2 mr-2 border-r border-slate-250 pr-3 hidden">
                                <input type="checkbox" id="check-all" class="rounded text-teal-800 focus:ring-teal-700/30 w-3.5 h-3.5">
                                <label for="check-all" class="text-[11px] text-slate-650 font-bold cursor-pointer">Pilih Semua</label>
                            </div>
                            <button type="button" onclick="submitBulkDelete()" id="btn-bulk-delete" class="px-3 py-2 bg-rose-50 hover:bg-rose-100 border border-rose-250 text-rose-700 text-[10px] font-bold rounded-lg transition-all hidden flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-trash-can"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                            </button>
                        @endif
                        <button onclick="document.getElementById('modal-import-global').classList.remove('hidden')" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-md transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-file-excel"></i> Import Excel Global
                        </button>
                        <button type="button" onclick="startDosenQRScanner()" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-lg shadow-md transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-qrcode"></i> Scan QR
                        </button>
                        <button type="button" onclick="toggleModal('modal-add-agenda')" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold rounded-lg shadow-md transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-plus"></i> Buat Agenda Mata Kuliah
                        </button>
                    </div>
                </div>

                <!-- Modal Import Global -->
                <div id="modal-import-global" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 relative">
                        <button onclick="document.getElementById('modal-import-global').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 transition">
                            <i class="fa-solid fa-xmark fa-xl"></i>
                        </button>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Import Absensi Excel (Semua Agenda)</h3>
                        <p class="text-xs text-slate-500 mb-6">Pilih kelas dan unggah file Excel. Sistem akan memproses seluruh jadwal pertemuan untuk kelas yang Anda pilih.</p>
                        
                        <form action="{{ route('dosen.absensi.import-global') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Mata Kuliah & Kelas</label>
                                <select name="mata_kuliah_kelas" required class="w-full text-sm p-2.5 rounded-lg border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                    @foreach($uniqueClasses as $uc)
                                        <option value="{{ $uc->mata_kuliah }}|{{ $uc->kelas }}|{{ $uc->dosen_id }}">
                                            {{ $uc->mata_kuliah }} {{ $uc->kelas ? '('.$uc->kelas.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Upload File Excel (.xlsx, .xls)</label>
                                <input type="file" name="file_excel" accept=".xlsx, .xls" required class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 transition
                                "/>
                                <div class="mt-2 text-right">
                                    <a href="{{ route('template.download', 'absensi') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium underline"><i class="fa-solid fa-download mr-1"></i> Unduh Template Excel</a>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 mt-6">
                                <button type="button" onclick="document.getElementById('modal-import-global').classList.add('hidden')" class="px-4 py-2 text-sm font-bold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition"><i class="fa-solid fa-cloud-arrow-up mr-2"></i> Import Data</button>
                            </div>
                        </form>
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
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-bold">Agenda</span>
        </a>
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-800 text-white rounded-2xl shadow-xl border-4 border-white">
            <button type="button" onclick="startDosenQRScanner()" class="flex items-center justify-center w-full h-full text-white bg-teal-800 rounded-xl hover:bg-teal-900 transition-all" title="Scan QR Presensi">
                <i class="fa-solid fa-qrcode text-2xl text-white"></i>
            </button>
        </div>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>

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

    <!-- Modal Add Agenda (Buat Agenda Mata Kuliah) -->
    <div id="modal-add-agenda" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-add-agenda')"></div>
        
        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden text-left">
                <!-- Header -->
                <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-800">
                    <h3 class="font-bold text-sm flex items-center gap-2">
                        <i class="fa-solid fa-calendar-plus text-teal-800"></i> Buat Agenda Mata Kuliah
                    </h3>
                    <button type="button" onclick="toggleModal('modal-add-agenda')" class="text-slate-400 hover:text-slate-600 text-base">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                
                <!-- Body -->
                <form action="{{ route('dosen.agenda.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    
                    <!-- 1. Combobox Mata Kuliah Berdasarkan Jadwal Lab -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Mata Kuliah & Kelas <span class="text-rose-500">*</span></label>
                        @if(isset($jadwalPenggunaanLab) && $jadwalPenggunaanLab->count() > 0)
                            <select name="jadwal_penggunaan_lab_id" id="modal_jadwal_select" required onchange="onSelectJadwalKuliahModal(this)" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="" disabled selected>-- Pilih Mata Kuliah Terjadwal --</option>
                                @foreach($jadwalPenggunaanLab as $j)
                                    <option value="{{ $j->id }}"
                                            data-lab="{{ strtoupper($j->lab->nama_lab ?? 'Lab') }}"
                                            data-kelas="{{ $j->kelas ?? 'Reg A' }}"
                                            data-semester="{{ $j->semester ?? '1' }}"
                                            data-prodi="{{ $j->prodi->nama_prodi ?? 'Sistem Informasi' }}"
                                            data-hari="{{ $j->hari }}"
                                            data-jam-mulai="{{ substr($j->jam_mulai, 0, 5) }}"
                                            data-jam-selesai="{{ substr($j->jam_selesai, 0, 5) }}">
                                        {{ $j->mata_kuliah }} - {{ $j->kelas }} ({{ $j->hari }}, {{ substr($j->jam_mulai,0,5) }}-{{ substr($j->jam_selesai,0,5) }})
                                    </option>
                                @endforeach
                            </select>
                            
                            <!-- Detail Box of Selected Matkul -->
                            <div id="modal-jadwal-info-box" class="hidden mt-2.5 p-3 bg-teal-50/80 border border-teal-200 rounded-xl space-y-1 text-[11px]">
                                <div class="flex justify-between items-center font-bold text-teal-900">
                                    <span id="modal-info-lab"><i class="fa-solid fa-door-open mr-1 text-teal-600"></i> Lab</span>
                                    <span id="modal-info-kelas" class="px-2 py-0.5 bg-teal-200/60 rounded text-[10px]">Kelas</span>
                                </div>
                                <div class="text-slate-600">
                                    <span>Jadwal Rutin: <strong id="modal-info-rutin" class="text-slate-800">-</strong></span>
                                </div>
                                <div class="text-[10px] text-slate-500" id="modal-info-prodi">-</div>
                            </div>
                        @else
                            <div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs">
                                Belum ada jadwal mata kuliah yang di-plotting untuk Anda.
                            </div>
                        @endif
                    </div>

                    <!-- 2. Tanggal Pelaksanaan -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Tanggal Pertemuan <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>

                    <!-- 3. Jam Mulai & Jam Selesai -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Mulai <span class="text-rose-500">*</span></label>
                            <input type="time" name="waktu_masuk" id="modal_input_waktu_masuk" required value="08:00" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 font-mono font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Jam Selesai <span class="text-rose-500">*</span></label>
                            <input type="time" name="waktu_keluar" id="modal_input_waktu_keluar" required value="10:30" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 font-mono font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>
                    </div>

                    <!-- 4. Rencana Pembelajaran -->
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Rencana Pembelajaran / Materi <span class="text-rose-500">*</span></label>
                        <textarea name="rencana_pembelajaran" rows="3" required placeholder="Tuliskan materi pembelajaran pada pertemuan ini..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none"></textarea>
                    </div>

                    <!-- Fallback Collapsible: Pengaturan Ruangan Lain -->
                    <details class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden group">
                        <summary class="px-3 py-2 text-[11px] font-bold text-slate-500 hover:text-slate-700 cursor-pointer flex items-center justify-between select-none">
                            <span><i class="fa-solid fa-sliders mr-1"></i> Pengaturan Tambahan / Ganti Ruang Lab</span>
                            <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <div class="p-3 border-t border-slate-200 space-y-3 bg-white">
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Ganti Laboratorium (Opsional)</label>
                                <select name="lab_id" class="w-full p-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 text-xs">
                                    <option value="">Gunakan Lab Bawaan Jadwal</option>
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}">{{ $lab->nama_lab }} ({{ $lab->lokasi }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Dosen Pengampu (Opsional)</label>
                                <select name="dosen_pengampu_id" class="w-full p-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 text-xs">
                                    <option value="">Gunakan Pengampu Bawaan Jadwal</option>
                                    @foreach($dosens as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }} (NIP: {{ $d->nip }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </details>

                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 bg-white">
                        <button type="button" onclick="toggleModal('modal-add-agenda')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-lg transition shadow-sm flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-check"></i> Buat Agenda
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

    <!-- Bulk delete checkboxes Script -->
    <script>
        function submitBulkDelete() {
            const checkedBoxes = document.querySelectorAll('.agenda-checkbox:checked');
            if (checkedBoxes.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Pilih Agenda',
                    text: 'Silakan pilih setidaknya satu agenda untuk dihapus.',
                    confirmButtonColor: '#0c4ea6'
                });
                return;
            }
            
            Swal.fire({
                title: 'Hapus Agenda Terpilih?',
                text: 'Apakah Anda yakin ingin menghapus seluruh agenda terpilih?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
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
            const checkAll = document.getElementById('check-all');
            const checkboxes = document.querySelectorAll('.agenda-checkbox');
            const btnBulkDelete = document.getElementById('btn-bulk-delete');
            const selectedCount = document.getElementById('selected-count');
            
            const btnToggleSelect = document.getElementById('btn-toggle-select');
            const containerCheckAll = document.getElementById('container-check-all');
            const containerCheckboxes = document.querySelectorAll('.container-checkbox');
            const innerContainers = document.querySelectorAll('.inner-agenda-container');
            
            let selectModeActive = false;

            if (btnToggleSelect) {
                btnToggleSelect.addEventListener('click', function() {
                    selectModeActive = !selectModeActive;
                    
                    if (selectModeActive) {
                        // Activate select mode
                        containerCheckAll.classList.remove('hidden');
                        containerCheckboxes.forEach(cb => cb.classList.remove('hidden'));
                        innerContainers.forEach(container => {
                            container.classList.remove('pl-2');
                            container.classList.add('pl-7');
                        });
                        btnToggleSelect.innerHTML = `<i class="fa-solid fa-xmark"></i> Batal Pilih`;
                        btnToggleSelect.classList.remove('bg-slate-100', 'hover:bg-slate-200', 'text-slate-700');
                        btnToggleSelect.classList.add('bg-slate-200', 'text-slate-800');
                    } else {
                        // Deactivate select mode
                        containerCheckAll.classList.add('hidden');
                        containerCheckboxes.forEach(cb => cb.classList.add('hidden'));
                        innerContainers.forEach(container => {
                            container.classList.remove('pl-7');
                            container.classList.add('pl-2');
                        });
                        btnToggleSelect.innerHTML = `<i class="fa-solid fa-square-check"></i> Pilih Banyak`;
                        btnToggleSelect.classList.remove('bg-slate-200', 'text-slate-800');
                        btnToggleSelect.classList.add('bg-slate-100', 'hover:bg-slate-200', 'text-slate-700');
                        
                        // Uncheck everything
                        if (checkAll) checkAll.checked = false;
                        document.querySelectorAll('.agenda-checkbox').forEach(cb => cb.checked = false);
                        updateBulkDeleteButton();
                    }
                });
            }

            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    const currentCheckboxes = document.querySelectorAll('.agenda-checkbox');
                    currentCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateBulkDeleteButton();
                });

                document.addEventListener('change', function(e) {
                    if (e.target && e.target.classList.contains('agenda-checkbox')) {
                        const currentCheckboxes = document.querySelectorAll('.agenda-checkbox');
                        const allChecked = Array.from(currentCheckboxes).every(c => c.checked);
                        if (checkAll) checkAll.checked = allChecked;
                        updateBulkDeleteButton();
                    }
                });
            }

            function updateBulkDeleteButton() {
                const currentCheckboxes = document.querySelectorAll('.agenda-checkbox');
                const checkedCount = Array.from(currentCheckboxes).filter(c => c.checked).length;
                if (selectedCount) {
                    selectedCount.innerText = checkedCount;
                }
                if (btnBulkDelete) {
                    if (checkedCount > 0 && selectModeActive) {
                        btnBulkDelete.classList.remove('hidden');
                    } else {
                        btnBulkDelete.classList.add('hidden');
                    }
                }
            }

            // Real-time dynamic polling for student check-ins
            function pollAgendas() {
                // If bulk selection mode is active, do not poll
                if (selectModeActive) return;

                // If any modal (edit agenda, add agenda) is open, do not poll
                const openModal = document.querySelector('div[id^="modal-"]:not(.hidden)');
                if (openModal) return;

                // Check if any input/textarea in details has focus
                const activeEl = document.activeElement;
                if (activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'TEXTAREA')) {
                    return;
                }

                // Backup which details are currently open
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

                            // Restore open state
                            document.querySelectorAll('#agenda-list-container details').forEach((details, index) => {
                                if (openDetailsIndices.includes(index)) {
                                    details.open = true;
                                }
                            });
                        }
                    }
                })
                .catch(err => console.error("Error polling agendas: ", err));
            }

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

        window.addEventListener('pageshow', function() {
            if (typeof Swal !== 'undefined' && Swal.isVisible() && Swal.isLoading()) {
                Swal.close();
            }
        });
    </script>
</body>
</html>
