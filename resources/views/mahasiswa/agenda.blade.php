<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Kuliah - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex flex-col h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Top Navbar -->
    <header class="h-16 bg-teal-900 text-white flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-md">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-user-graduate text-white text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-300 tracking-wider">MAHASISWA PORTAL</p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="font-bold text-xs text-white">{{ $mahasiswa->nama_lengkap }}</p>
                <p class="text-[9px] font-semibold tracking-wider text-teal-300">NIM: {{ $mahasiswa->nim }}</p>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="w-8 h-8 rounded-lg bg-teal-950/40 text-teal-200 hover:text-white flex items-center justify-center transition-all text-xs" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Workspace -->
    <div class="flex-1 flex overflow-hidden">
        
        <!-- Sidebar Navigation (Desktop) -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col flex-shrink-0 h-full hidden lg:flex">
            <div class="p-6">
                <div class="bg-teal-50 border border-teal-100 rounded-2xl p-4 text-center">
                    <div class="w-12 h-12 rounded-full bg-teal-800 text-white font-bold flex items-center justify-center mx-auto text-lg mb-2">
                        {{ substr($mahasiswa->nama_lengkap, 0, 1) }}
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $mahasiswa->nama_lengkap }}</h4>
                    <p class="text-[10px] font-semibold tracking-wide text-slate-500 mt-0.5">{{ $mahasiswa->nim }}</p>
                    
                    <div class="mt-3 pt-3 border-t border-teal-100/80 text-left text-[10px] text-slate-650 space-y-1.5 font-medium">
                        <div class="flex items-center gap-1.5 truncate">
                            <i class="fa-solid fa-building text-teal-800 text-[10px] w-3.5"></i>
                            <span class="truncate" title="{{ $mahasiswa->fakultas->nama_fakultas ?? '-' }}">{{ $mahasiswa->fakultas->nama_fakultas ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 truncate">
                            <i class="fa-solid fa-graduation-cap text-teal-800 text-[10px] w-3.5"></i>
                            <span class="truncate" title="{{ $mahasiswa->prodi->nama_prodi ?? '-' }}">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-chalkboard-user text-teal-800 text-[10px] w-3.5"></i>
                            <span>Kelas: <strong>{{ $mahasiswa->kelas ?? '-' }}</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-clock-rotate-left text-teal-800 text-[10px] w-3.5"></i>
                            <span>Semester: <strong>{{ $mahasiswa->semester ?? '1' }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="flex-1 px-3 space-y-1">
                <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl w-full transition">
                    <i class="fa-solid fa-qrcode"></i>
                    <span class="text-xs font-semibold tracking-wide">Absensi Mandiri</span>
                </a>
                <a href="{{ route('mahasiswa.agenda') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-50 text-teal-900 rounded-xl w-full font-bold">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span class="text-xs font-semibold tracking-wide">Agenda Kuliah</span>
                </a>
                <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl w-full transition">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span class="text-xs font-semibold tracking-wide">Riwayat Kehadiran</span>
                </a>
                <a href="{{ route('mahasiswa.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-slate-100 rounded-xl w-full transition">
                    <i class="fa-solid fa-gear"></i>
                    <span class="text-xs font-semibold tracking-wide">Pengaturan</span>
                </a>
            </nav>
        </aside>

        <!-- Content Area -->
        <main class="flex-grow overflow-auto p-4 md:p-6 space-y-6 pb-24">
            
            <!-- Mobile Profile Summary Card -->
            <div class="bg-teal-50 border border-teal-100 rounded-2xl p-4 flex items-center gap-4 lg:hidden shadow-sm">
                <div class="w-12 h-12 rounded-full bg-teal-850 text-white font-bold flex items-center justify-center text-lg shrink-0">
                    {{ substr($mahasiswa->nama_lengkap, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $mahasiswa->nama_lengkap }}</h4>
                    <p class="text-[10px] font-semibold text-slate-500 mt-0.5">NIM: {{ $mahasiswa->nim }}</p>
                    <p class="text-[9px] text-slate-450 mt-1 font-medium">
                        Kelas: {{ $mahasiswa->kelas ?: '-' }} • Sem: {{ $mahasiswa->semester ?: '-' }} • {{ $mahasiswa->prodi->nama_prodi ?? '-' }}
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
    </div>

    <!-- Bottom Navigation Bar (Mobile Only - Figma Design) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-qrcode text-lg"></i>
            <span class="text-[9px] font-medium">Absen</span>
        </a>
        <a href="{{ route('mahasiswa.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-900 font-bold">
            <i class="fa-solid fa-calendar-days text-lg"></i>
            <span class="text-[9px] font-bold">Agenda</span>
        </a>
        <a href="{{ route('mahasiswa.riwayat') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            <span class="text-[9px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('mahasiswa.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Settings</span>
        </a>
    </nav>

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
</body>
</html>
