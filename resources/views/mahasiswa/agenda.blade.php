<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Kuliah - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <a href="{{ route('mahasiswa.agenda') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda Kuliah</span>
            </a>
            <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="text-xs font-semibold tracking-wide">Riwayat Kehadiran</span>
            </a>
            <a href="{{ route('mahasiswa.pengumuman') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-bullhorn"></i>
                <span class="text-xs font-semibold tracking-wide">Pengumuman</span>
            </a>
        </nav>
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Agenda Kuliah & Praktikum</h2>
            </div>

            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ $mahasiswa->nama_lengkap }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIM: {{ $mahasiswa->nim }} • {{ $mahasiswa->prodi->nama_prodi ?? 'Mahasiswa' }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ substr($mahasiswa->nama_lengkap, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $mahasiswa->nama_lengkap }}</p>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">NIM: {{ $mahasiswa->nim }}</p>
                        <span class="inline-block mt-1.5 px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200/60 rounded-md text-[9px] font-bold">
                            Mahasiswa • {{ $mahasiswa->kelas ?? 'Reguler' }}
                        </span>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('mahasiswa.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800 transition font-medium group">
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
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6 pb-24">
            
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

            <div class="flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <div>
                        <h2 class="font-bold text-base text-slate-800">Daftar Agenda Perkuliahan</h2>
                        <p class="text-[10px] text-slate-500 font-semibold mt-1">
                             Prodi: {{ $mahasiswa->prodi->nama_prodi ?? 'Informatika' }} • Kelas {{ $mahasiswa->kelas }}
                        </p>
                    </div>
                </div>

                <!-- Tab Switcher -->
                <div class="flex border-b border-slate-200 gap-6 mt-2">
                    <a href="{{ route('mahasiswa.agenda', array_merge(request()->except(['page', 'scope']), ['scope' => 'untuk-saya'])) }}" 
                       class="pb-3 text-xs font-bold transition-all relative {{ $scope === 'untuk-saya' ? 'text-teal-850 border-b-2 border-teal-800 font-extrabold' : 'text-slate-400 hover:text-slate-600' }}">
                        <i class="fa-solid fa-user-check mr-1.5"></i>Agenda Untuk Saya
                    </a>
                    <a href="{{ route('mahasiswa.agenda', array_merge(request()->except(['page', 'scope']), ['scope' => 'semua'])) }}" 
                       class="pb-3 text-xs font-bold transition-all relative {{ $scope === 'semua' ? 'text-teal-850 border-b-2 border-teal-800 font-extrabold' : 'text-slate-400 hover:text-slate-600' }}">
                        <i class="fa-solid fa-globe mr-1.5"></i>Semua Agenda
                    </a>
                </div>

                <!-- Filter Panel -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <form action="{{ route('mahasiswa.agenda') }}" method="GET" class="space-y-4">
                        <input type="hidden" name="scope" value="{{ $scope }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end text-xs">
                            <!-- Keyword Search -->
                            <div class="{{ $scope === 'untuk-saya' ? 'md:col-span-7' : 'md:col-span-2' }} w-full">
                                <label class="block text-slate-655 font-bold mb-1.5">Cari Mata Kuliah</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama kelas/praktikum..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                                </div>
                            </div>

                            <!-- Date filter -->
                            <div class="{{ $scope === 'untuk-saya' ? 'md:col-span-3' : 'md:col-span-2' }} w-full">
                                <label class="block text-slate-655 font-bold mb-1.5">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                            </div>

                            @if($scope === 'semua')
                                <!-- Fakultas filter -->
                                <div class="md:col-span-2 w-full">
                                    <label class="block text-slate-655 font-bold mb-1.5">Fakultas</label>
                                    <select name="filter_fakultas" id="filter-fakultas" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                        <option value="">Semua Fakultas</option>
                                        @foreach($fakultas as $fak)
                                            <option value="{{ $fak->nama_fakultas }}" {{ request('filter_fakultas') == $fak->nama_fakultas ? 'selected' : '' }}>{{ $fak->nama_fakultas }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Prodi filter -->
                                <div class="md:col-span-2 w-full">
                                    <label class="block text-slate-655 font-bold mb-1.5">Program Studi</label>
                                    <select name="filter_jurusan" id="filter-jurusan" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                        <option value="">Semua Prodi</option>
                                        @foreach($prodis as $prod)
                                            <option value="{{ $prod->nama_prodi }}" data-fakultas="{{ $prod->fakultas->nama_fakultas }}" {{ request('filter_jurusan') == $prod->nama_prodi ? 'selected' : '' }}>{{ $prod->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kelas filter -->
                                <div class="md:col-span-1 w-full">
                                    <label class="block text-slate-655 font-bold mb-1.5">Kelas</label>
                                    <select name="filter_kelas" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                        <option value="">Semua</option>
                                        <option value="A" {{ request('filter_kelas') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ request('filter_kelas') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ request('filter_kelas') == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ request('filter_kelas') == 'D' ? 'selected' : '' }}>D</option>
                                    </select>
                                </div>
                                
                                <!-- Semester filter -->
                                <div class="md:col-span-1 w-full">
                                    <label class="block text-slate-655 font-bold mb-1.5">Sem</label>
                                    <select name="filter_semester" class="w-full py-2.5 px-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                        <option value="">Semua</option>
                                        @foreach(['1','2','3','4','5','6','7','8'] as $semOpt)
                                            <option value="{{ $semOpt }}" {{ request('filter_semester') == $semOpt ? 'selected' : '' }}>{{ $semOpt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Filter Button -->
                            <div class="md:col-span-2 flex gap-2 w-full">
                                <button type="submit" class="flex-1 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition-all shadow-sm">
                                    Filter
                                </button>
                                @if(request()->anyFilled(['search', 'tanggal', 'filter_fakultas', 'filter_jurusan', 'filter_kelas']))
                                    <a href="{{ route('mahasiswa.agenda', ['scope' => $scope]) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-750 rounded-xl font-bold transition-all border border-slate-200 text-center flex items-center justify-center">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Agendas List -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4">
                    <h3 class="font-bold text-xs text-slate-800">
                        {{ $scope === 'untuk-saya' ? 'Jadwal Praktikum & Kelas Saya' : 'Semua Jadwal Praktikum & Kelas' }}
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    @if($agendas->count() > 0)
                        @foreach($agendas as $ag)
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-4">
                            <div class="flex flex-col md:flex-row gap-5 items-start">
                                <!-- Time block -->
                                <div class="bg-teal-900 text-white rounded-xl p-3 flex flex-col items-center justify-center min-w-[120px] shadow-sm text-center">
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-teal-350">{{ date('d M Y', strtotime($ag->tanggal)) }}</span>
                                    <span class="text-xs font-bold mt-1.5">{{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB</span>
                                </div>
                                
                                <!-- Details -->
                                <div class="flex-1 space-y-3 w-full">
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-bold text-slate-800 text-base">{{ $ag->mata_kuliah }}</h4>
                                            @if($ag->status_agenda === 'Berlangsung')
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded text-[9px] font-bold uppercase tracking-wider">Berlangsung</span>
                                            @elseif($ag->status_agenda === 'Selesai')
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-655 border border-slate-200 rounded text-[9px] font-bold uppercase tracking-wider">Selesai</span>
                                            @elseif($ag->status_agenda === 'Dibatalkan')
                                                <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded text-[9px] font-bold uppercase tracking-wider">Dibatalkan</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded text-[9px] font-bold uppercase tracking-wider">Mendatang</span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-slate-500 mt-1">
                                            <i class="fa-solid fa-location-dot mr-1"></i>{{ $ag->lab->nama_lab }}
                                            • Dosen: {{ $ag->dosen->nama }}
                                            @if($ag->kelas) • Kelas: {{ $ag->kelas }} @endif
                                            @if($ag->semester) • Semester: {{ $ag->semester }} @endif
                                        </p>
                                    </div>
                                    
                                    @if($ag->materi_realisasi)
                                        <div class="p-3 bg-white border border-slate-150 rounded-lg text-[11px]">
                                            <span class="font-bold text-slate-700 block mb-0.5">Materi Pembelajaran / Realisasi:</span>
                                            <p class="text-slate-600 font-medium leading-relaxed">{{ $ag->materi_realisasi }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="pt-4">
                            {{ $agendas->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 text-slate-400">
                            <i class="fa-solid fa-calendar-xmark text-3xl block mb-2"></i>
                            Belum ada agenda kelas terdaftar.
                        </div>
                    @endif
                </div>
            </div>

        </main>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical 4-tab layout with Center Scan QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('mahasiswa.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-bold">Agenda</span>
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
        <a href="{{ route('mahasiswa.pengumuman') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-bullhorn text-lg"></i>
            <span class="text-[9px] font-semibold">Pengumuman</span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterFakultas = document.getElementById('filter-fakultas');
            const filterJurusan = document.getElementById('filter-jurusan');

            if (filterFakultas && filterJurusan) {
                const originalProdis = Array.from(filterJurusan.options).map(opt => ({
                    value: opt.value,
                    text: opt.textContent,
                    fakultas: opt.getAttribute('data-fakultas')
                }));

                filterFakultas.addEventListener('change', function() {
                    const selectedFakultas = this.value;
                    
                    // Clear options but keep the first one
                    filterJurusan.innerHTML = '<option value="">Semua Prodi</option>';
                    
                    originalProdis.forEach(prod => {
                        if (!selectedFakultas || prod.fakultas === selectedFakultas || prod.value === "") {
                            if (prod.value !== "") {
                                const opt = document.createElement('option');
                                opt.value = prod.value;
                                opt.textContent = prod.text;
                                opt.setAttribute('data-fakultas', prod.fakultas);
                                if (prod.value === "{{ request('filter_jurusan') }}") {
                                    opt.selected = true;
                                }
                                filterJurusan.appendChild(opt);
                            }
                        }
                    });
                });

                // Trigger change on load if there is an initial value
                if (filterFakultas.value) {
                    filterFakultas.dispatchEvent(new Event('change'));
                }
            }
        });
    </script>

    <!-- Hidden form for QR attendance submission -->
    <form id="mahasiswa-absensi-form" action="{{ route('mahasiswa.absensi.submit') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="qr_code_token" id="mahasiswa-qr-token-input">
    </form>

    <!-- QR Scanner Modal -->
    <div id="modal-qr-scanner" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100 text-slate-800">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i class="fa-solid fa-camera text-teal-800"></i> Pindai QR Code Presensi
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

        function startMahasiswaQRScanner() {
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
                            let inputToken = document.getElementById('mahasiswa-qr-token-input');
                            if (inputToken) inputToken.value = decodedText;
                            document.getElementById('mahasiswa-absensi-form').submit();
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
                            let inputToken = document.getElementById('mahasiswa-qr-token-input');
                            if (inputToken) inputToken.value = decodedText;
                            document.getElementById('mahasiswa-absensi-form').submit();
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
                        let inputToken = document.getElementById('mahasiswa-qr-token-input');
                        if (inputToken) inputToken.value = decodedText;
                        document.getElementById('mahasiswa-absensi-form').submit();
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
            event.preventDefault();
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            
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
                    if (form.checkValidity && !form.checkValidity()) {
                        return;
                    }

                    const fileInput = form.querySelector('input[type="file"]');
                    if (fileInput && fileInput.required && fileInput.files && fileInput.files.length === 0) {
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
