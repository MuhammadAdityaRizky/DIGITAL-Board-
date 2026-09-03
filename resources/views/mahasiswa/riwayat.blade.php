<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kehadiran - Digital Board</title>
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
            <a href="{{ route('mahasiswa.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda Kuliah</span>
            </a>
            <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Riwayat Kehadiran & Perizinan</h2>
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

            <!-- Statistics Bento Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-700 rounded-xl"><i class="fa-solid fa-circle-check text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Hadir</p>
                        <p class="text-xl font-bold text-slate-800">{{ $hadirCount }} Sesi</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-blue-50 text-blue-700 rounded-xl"><i class="fa-solid fa-file-signature text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Izin</p>
                        <p class="text-xl font-bold text-slate-800">{{ $izinCount }} Sesi</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-rose-50 text-rose-700 rounded-xl"><i class="fa-solid fa-circle-xmark text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Alpa</p>
                        <p class="text-xl font-bold text-slate-800">{{ $alpaCount }} Sesi</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-teal-50 text-teal-800 rounded-xl"><i class="fa-solid fa-chart-pie text-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Persentase</p>
                        <p class="text-xl font-bold text-slate-800">{{ $attendancePercentage }}%</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6" x-data="{ activeTab: 'attendance' }">
                <!-- Left Details List -->
                <div class="xl:col-span-2 space-y-4">
                    <!-- Tab Buttons -->
                    <div class="flex border-b border-slate-200 text-xs font-bold uppercase tracking-wider bg-white px-4 pt-2 rounded-t-xl border-x">
                        <button @click="activeTab = 'attendance'" 
                                :class="activeTab === 'attendance' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                                class="px-5 py-3 transition focus:outline-none flex items-center gap-2">
                            <i class="fa-solid fa-calendar-days"></i>
                            Presensi Kehadiran
                        </button>
                        <button @click="activeTab = 'permissions'" 
                                :class="activeTab === 'permissions' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                                class="px-5 py-3 transition focus:outline-none flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            Status Pengajuan Izin
                        </button>
                    </div>

                    <!-- Attendance Log -->
                    <div x-show="activeTab === 'attendance'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-4">
                        <div class="flex justify-between items-center text-xs">
                            <h3 class="font-bold text-sm text-slate-800">Daftar Kehadiran Praktikum</h3>
                            <form action="{{ route('mahasiswa.riwayat') }}" method="GET" class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari praktikum..." class="pl-8 pr-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-1 focus:ring-teal-700">
                                <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-slate-400"></i>
                            </form>
                        </div>

                        @if($absensiHistory->count() > 0)
                            <div class="space-y-4">
                                @foreach($absensiHistory as $abs)
                                    @php
                                        $izin = null;
                                        if (in_array(strtolower($abs->status_kehadiran), ['izin', 'sakit'])) {
                                            $izin = \App\Models\Perizinan::where('agenda_id', $abs->agenda_id)
                                                ->where('mahasiswa_id', $abs->mahasiswa_id)
                                                ->first();
                                        }
                                    @endphp
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-4">
                                        <div class="flex flex-col md:flex-row gap-5 items-start">
                                            <!-- Time block -->
                                            <div class="bg-teal-900 text-white rounded-xl p-3 flex flex-col items-center justify-center min-w-[120px] shadow-sm text-center">
                                                <span class="text-[10px] font-semibold uppercase tracking-wider text-teal-350">{{ date('d M Y', strtotime($abs->agenda->tanggal)) }}</span>
                                                <span class="text-xs font-bold mt-1.5">{{ substr($abs->agenda->jam_mulai,0,5) }} - {{ substr($abs->agenda->jam_selesai,0,5) }} WIB</span>
                                            </div>
                                            
                                            <!-- Details -->
                                            <div class="flex-1 space-y-3 w-full">
                                                <div>
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <h4 class="font-bold text-slate-800 text-base mb-0.5">{{ $abs->agenda->mata_kuliah }}</h4>
                                                        @if(strtolower($abs->status_kehadiran) === 'hadir')
                                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded text-[9px] font-bold uppercase tracking-wider">Hadir</span>
                                                        @elseif(strtolower($abs->status_kehadiran) === 'izin')
                                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded text-[9px] font-bold uppercase tracking-wider">Izin</span>
                                                        @elseif(strtolower($abs->status_kehadiran) === 'sakit')
                                                            <span class="px-2 py-0.5 bg-[#fff8eb] text-[#d89115] border border-[#ffe0b2] rounded text-[9px] font-bold uppercase tracking-wider">Sakit</span>
                                                        @else
                                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded text-[9px] font-bold uppercase tracking-wider">Alpa</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-[11px] text-slate-500 mt-1">
                                                        <i class="fa-solid fa-location-dot mr-1"></i>{{ $abs->agenda->lab->nama_lab }}
                                                        • Dosen: {{ $abs->agenda->dosen->nama }}
                                                        • Kelas: {{ $abs->agenda->kelas ?: '-' }}
                                                        • Semester: {{ $abs->agenda->semester ?: '-' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-400 mt-1">Waktu Scan: <span class="font-mono text-slate-600">{{ $abs->waktu_masuk }}</span></p>
                                                </div>

                                                @if($izin)
                                                    <div class="pt-2 border-t border-slate-200 flex justify-end">
                                                        <button type="button" 
                                                                onclick="viewIzinDetail('{{ $izin->kategori }}', '{{ addslashes($izin->alasan) }}', '{{ $izin->bukti_url ? asset($izin->bukti_url) : '' }}')"
                                                                class="px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                                            <i class="fa-solid fa-file-waveform"></i> Detail Pengajuan
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="pt-4">
                                {{ $absensiHistory->links() }}
                            </div>
                        @else
                            <div class="text-center py-10 text-slate-400 italic">
                                <i class="fa-solid fa-calendar-xmark text-xl block mb-2"></i>
                                Tidak ada log kehadiran tercatat.
                            </div>
                        @endif
                    </div>

                    <!-- Permissions Log -->
                    <div x-show="activeTab === 'permissions'" class="bg-white border border-slate-200 rounded-b-xl shadow-sm overflow-hidden p-6 space-y-4" style="display: none;">
                        <h3 class="font-bold text-sm text-slate-800">Status Permohonan Perizinan</h3>
                        
                        @if($perizinans->count() > 0)
                            <div class="overflow-x-auto border border-slate-100 rounded-xl">
                                <table class="w-full text-xs text-left text-slate-600">
                                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                        <tr>
                                            <th class="p-3.5">Praktikum</th>
                                            <th class="p-3.5">Alasan</th>
                                            <th class="p-3.5">Bukti Dokumen</th>
                                            <th class="p-3.5">Tanggal Pengajuan</th>
                                            <th class="p-3.5">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($perizinans as $p)
                                            <tr class="hover:bg-slate-50/50 transition">
                                                <td class="p-3.5">
                                                    <span class="font-bold text-slate-800 block text-sm">{{ $p->agenda->mata_kuliah }}</span>
                                                    <span class="text-[10px] text-slate-450 uppercase font-semibold">Dosen: {{ $p->agenda->dosen->nama }}</span>
                                                </td>
                                                <td class="p-3.5 italic">"{{ $p->alasan }}"</td>
                                                <td class="p-3.5">
                                                    @if($p->bukti_url)
                                                        <a href="{{ asset($p->bukti_url) }}" target="_blank" class="text-teal-700 hover:underline font-semibold flex items-center gap-1"><i class="fa-solid fa-file-pdf"></i> Lihat File</a>
                                                    @else
                                                        <span class="text-slate-400 italic">None</span>
                                                    @endif
                                                </td>
                                                <td class="p-3.5 font-mono text-slate-500">{{ $p->created_at }}</td>
                                                <td class="p-3.5">
                                                    @if(strtolower($p->status_persetujuan) === 'pending')
                                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-100 font-bold rounded-lg text-[9px] uppercase tracking-wider">Pending</span>
                                                    @elseif(strtolower($p->status_persetujuan) === 'disetujui')
                                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold rounded-lg text-[9px] uppercase tracking-wider">Disetujui</span>
                                                    @else
                                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-100 font-bold rounded-lg text-[9px] uppercase tracking-wider">Ditolak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-10 text-slate-400 italic">
                                <i class="fa-solid fa-file-signature text-xl block mb-2"></i>
                                Belum ada pengajuan izin dibuat.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Card: Information & Tip -->
                <div class="space-y-6">
                    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                        <h3 class="font-bold text-sm text-slate-800 mb-3 flex items-center gap-1.5"><i class="fa-solid fa-circle-info text-teal-800"></i> Ketentuan Absensi</h3>
                        <ul class="text-xs text-slate-600 space-y-2.5 list-disc list-inside">
                            <li>Setiap mahasiswa wajib melakukan scan QR Code menggunakan token yang tertera pada Digital Board laboratorium.</li>
                            <li>Kehadiran tercatat otomatis jika token / ID agenda valid.</li>
                            <li>Bila mahasiswa berhalangan hadir (sakit/izin), harap mengajukan form **Ajukan Izin** dengan bukti surat dokter/pendukung sebelum kelas berakhir.</li>
                            <li>Bila izin disetujui dosen, status kehadiran akan otomatis diperbarui menjadi `Izin` di sistem.</li>
                        </ul>
                    </div>
                </div>
            </div>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical 4-tab layout with Center Scan QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-medium">Dashboard</span>
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
        <a href="{{ route('mahasiswa.riwayat') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
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

    <!-- Detail Izin Modal -->
    <div id="modal-detail-izin" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden shadow-xl border border-slate-100">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-855 font-bold">
                <h4 class="font-bold text-sm">Detail Pengajuan Izin</h4>
                <button type="button" onclick="closeModal('modal-detail-izin')" class="text-slate-400 hover:text-slate-655 text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-slate-400 font-bold mb-0.5">Kategori Perizinan</label>
                    <span id="detail-izin-kategori" class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 font-bold rounded text-[10px] uppercase">Izin</span>
                </div>
                <div>
                    <label class="block text-slate-400 font-bold mb-0.5">Keterangan / Alasan</label>
                    <p id="detail-izin-alasan" class="text-xs text-slate-700 font-medium bg-slate-50 border border-slate-200 p-3 rounded-lg leading-relaxed italic">"Alasan izin..."</p>
                </div>
                <div id="detail-izin-bukti-container">
                    <label class="block text-slate-400 font-bold mb-1">Bukti Foto / Dokumen</label>
                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50 p-2 text-center">
                        <img id="detail-izin-foto" src="" alt="Bukti Perizinan" class="max-h-60 mx-auto object-contain rounded-lg shadow-sm">
                        <p id="detail-izin-no-bukti" class="text-slate-400 italic py-4">Tidak ada bukti foto dilampirkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function viewIzinDetail(kategori, alasan, buktiUrl) {
            document.getElementById('detail-izin-kategori').innerText = kategori;
            if (kategori === 'Sakit') {
                document.getElementById('detail-izin-kategori').className = "px-2 py-0.5 bg-[#fff8eb] text-[#d89115] border border-[#ffe0b2] font-bold rounded text-[10px] uppercase";
            } else {
                document.getElementById('detail-izin-kategori').className = "px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 font-bold rounded text-[10px] uppercase";
            }
            document.getElementById('detail-izin-alasan').innerText = `"${alasan}"`;
            
            const fotoEl = document.getElementById('detail-izin-foto');
            const noBuktiEl = document.getElementById('detail-izin-no-bukti');
            if (buktiUrl) {
                fotoEl.src = buktiUrl;
                fotoEl.classList.remove('hidden');
                noBuktiEl.classList.add('hidden');
            } else {
                fotoEl.src = "";
                fotoEl.classList.add('hidden');
                noBuktiEl.classList.remove('hidden');
            }
            
            document.getElementById('modal-detail-izin').classList.remove('hidden');
        }
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

    <!-- AlpineJS for Simple Tabs -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
