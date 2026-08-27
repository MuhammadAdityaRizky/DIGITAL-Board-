<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dosen - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full">
                <i class="fa-solid fa-border-all"></i>
                <span class="text-xs font-semibold tracking-wide">Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-alt"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda</span>
            </a>
            <a href="{{ route('dosen.mahasiswa') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-users"></i>
                <span class="text-xs font-semibold tracking-wide">Daftar Mahasiswa</span>
            </a>
            <a href="{{ route('dosen.perizinan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-file-signature"></i>
                <span class="text-xs font-semibold tracking-wide">Verifikasi Perizinan</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
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
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Dashboard Dosen</h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ $dosen->nama }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">Dosen Informatika</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr($dosen->nama, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Welcome Header (Figma Green Style) -->
            <div class="bg-gradient-to-r from-teal-900 to-emerald-800 text-white rounded-2xl p-6 shadow-md relative overflow-hidden flex flex-col justify-between gap-4">
                <div class="space-y-1 z-10">
                    <p class="text-xs font-medium text-teal-200 uppercase tracking-widest">DOSEN PORTAL</p>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight">Selamat Datang, {{ $dosen->nama }}</h2>
                    <p class="text-xs text-teal-200/90 font-mono">NIP: {{ $dosen->nip }}</p>
                    @if($dosen->kompetensi)
                        <div class="pt-1 text-[10px] text-emerald-100 flex items-center gap-1.5">
                            <i class="fa-solid fa-star text-amber-400 animate-pulse"></i>
                            <span>Kompetensi: <strong class="text-white">{{ $dosen->kompetensi }}</strong></span>
                        </div>
                    @endif
                </div>
                <div class="z-10 self-start px-3 py-1.5 @if($activeOrNextAgenda && $activeOrNextAgenda->dosen_waktu_masuk) bg-emerald-950/40 border-emerald-500/30 @else bg-rose-950/40 border-rose-500/30 @endif border rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span class="w-2.5 h-2.5 @if($activeOrNextAgenda && $activeOrNextAgenda->dosen_waktu_masuk) bg-emerald-400 @else bg-rose-400 @endif rounded-full animate-pulse"></span>
                    Status: @if($activeOrNextAgenda && $activeOrNextAgenda->dosen_waktu_masuk) Sudah Check-in ({{ date('H:i', strtotime($activeOrNextAgenda->dosen_waktu_masuk)) }} WIB) @else Belum Check-in @endif
                </div>
                <i class="fa-solid fa-chalkboard-user absolute right-6 bottom-4 text-white/5 text-8xl pointer-events-none hidden md:block"></i>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Announcements -->
            @if(isset($pengumuman) && $pengumuman->count() > 0)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex gap-4 items-start shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <h3 class="font-bold text-amber-800 text-sm flex items-center gap-2">
                        PENGUMUMAN RESMI LAB
                        <span class="text-[10px] font-normal text-amber-600/80">({{ date('d M Y', strtotime($pengumuman->first()->created_at)) }})</span>
                    </h3>
                    <p class="text-amber-700 text-xs mt-1">
                        <strong>{{ $pengumuman->first()->judul }}:</strong> {{ $pengumuman->first()->isi_pengumuman }}
                    </p>
                </div>
            </div>
            @endif

            <!-- Summary Bento Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Bento 1 -->
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center gap-2 text-slate-500">
                        <i class="fa-solid fa-calendar-check text-teal-600 text-xs"></i>
                        <span class="text-[11px] font-bold tracking-wider uppercase">Agenda Hari Ini</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-2xl font-bold text-slate-800">{{ $todayAgendas->count() }} Sesi</h4>
                        <p class="text-[10px] font-semibold text-slate-400 tracking-wide mt-0.5">Praktikum Aktif</p>
                    </div>
                </div>

                <!-- Bento 2 -->
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center gap-2 text-slate-500">
                        <i class="fa-solid fa-user-clock text-rose-600 text-xs"></i>
                        <span class="text-[11px] font-bold tracking-wider uppercase">Izin Pending</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-2xl font-bold text-rose-650">{{ $izinPendingCount }} Mhs</h4>
                        <p class="text-[10px] font-semibold text-rose-600 tracking-wide mt-0.5"><i class="fa-solid fa-circle-exclamation mr-0.5"></i> Butuh review</p>
                    </div>
                </div>

                <!-- Bento 4: Absensi Dosen via QR / Manual -->
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center gap-2 text-slate-500">
                        <i class="fa-solid fa-qrcode text-indigo-600 text-xs"></i>
                        <span class="text-[11px] font-bold tracking-wider uppercase">Absensi Dosen</span>
                    </div>
                    <div class="mt-3">
                        @if($activeOrNextAgenda)
                            @if($activeOrNextAgenda->dosen_waktu_masuk)
                                <div class="text-xs text-emerald-750 font-bold flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check"></i> Hadir ({{ date('H:i', strtotime($activeOrNextAgenda->dosen_waktu_masuk)) }})
                                </div>
                                <span class="text-[9px] text-slate-400 block mt-1 truncate">MK: {{ $activeOrNextAgenda->mata_kuliah }}</span>
                            @else
                                <button type="button" onclick="startDosenQRScanner()" class="w-full py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-[10px] font-bold uppercase transition flex items-center justify-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-camera"></i> Scan QR Absen
                                </button>
                                <form action="{{ route('dosen.absensi.submit') }}" method="POST" class="flex gap-1 mt-2">
                                    @csrf
                                    <input type="text" name="qr_code_token" placeholder="Token manual..." required class="flex-grow px-2 py-1 rounded-lg border border-slate-250 bg-white text-[9px] focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 font-bold uppercase tracking-wider">
                                    <button type="submit" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 border border-slate-250 text-slate-700 rounded-lg text-[9px] font-bold uppercase transition">Kirim</button>
                                </form>
                            @endif
                        @else
                            <span class="text-[10px] text-slate-400 italic">Tidak ada agenda aktif saat ini</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Features Split Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Today's Classes list -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                        <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                            <h3 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                                <span>Kelas Hari Ini</span>
                                <span class="text-xs text-slate-450 font-semibold">({{ \Carbon\Carbon::today()->translatedFormat('dddd, d M Y') }})</span>
                            </h3>
                            <span class="text-[10px] bg-teal-50 text-teal-800 font-bold px-2 py-0.5 rounded-full">{{ $agendas->count() }} Agenda</span>
                        </div>
                        
                        <div class="p-4 md:p-6 space-y-4">
                            @if($agendas->count() > 0)
                                @foreach($agendas as $ag)
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-4">
                                    <div class="flex flex-col md:flex-row gap-5 items-start">
                                        <!-- Time block -->
                                        <div class="bg-teal-900 text-white rounded-xl p-3 flex flex-col items-center justify-center min-w-[80px] shadow-sm">
                                            <span class="text-xl font-bold leading-none">{{ substr($ag->jam_mulai,0,2) }}</span>
                                            <span class="text-[9px] font-semibold uppercase tracking-wider text-teal-300 mt-1">{{ substr($ag->jam_mulai,3,2) }} WIB</span>
                                        </div>
                                        
                                        <!-- Details -->
                                        <div class="flex-1 space-y-3 w-full">
                                            <div>
                                                @if($ag->status_agenda === 'Berlangsung')
                                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded text-[9px] font-bold uppercase tracking-wider">Berlangsung</span>
                                                @elseif($ag->status_agenda === 'Selesai')
                                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-650 border border-slate-200 rounded text-[9px] font-bold uppercase tracking-wider">Selesai</span>
                                                @elseif($ag->status_agenda === 'Dibatalkan')
                                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded text-[9px] font-bold uppercase tracking-wider">Dibatalkan</span>
                                                @else
                                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded text-[9px] font-bold uppercase tracking-wider">Mendatang</span>
                                                @endif
                                                <h4 class="font-bold text-slate-800 text-lg mt-1.5">{{ $ag->mata_kuliah }}</h4>
                                                <p class="text-xs text-slate-500 mt-1">Catatan/Materi: <span class="text-slate-650 font-medium">{{ $ag->catatan ?? 'Tidak ada catatan.' }}</span></p>
                                                <p class="text-[11px] text-slate-450 mt-0.5"><i class="fa-solid fa-location-dot mr-1"></i>{{ $ag->lab->nama_lab }}</p>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-slate-200 w-full">
                                                @if(!$ag->dosen_waktu_masuk)
                                                    <button type="button" onclick="startDosenQRScanner()" class="px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-850 text-xs font-bold rounded-lg border border-teal-200 transition flex items-center gap-1.5">
                                                        <i class="fa-solid fa-camera"></i> Absen QR Board
                                                    </button>
                                                @else
                                                    <span class="px-2.5 py-1.5 bg-emerald-50 text-emerald-750 border border-emerald-100 rounded-lg text-xs font-bold flex items-center gap-1.5">
                                                        <i class="fa-solid fa-circle-check"></i> Absen Masuk: {{ date('H:i', strtotime($ag->dosen_waktu_masuk)) }} WIB
                                                    </span>
                                                @endif

                                                <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-lg ml-auto">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    {{ $ag->absensi->count() }} Mahasiswa Hadir
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Collapsible Section: Realisasi & Absensi (Collapsible details) -->
                                    <details class="w-full bg-white border border-slate-200 rounded-xl overflow-hidden group">
                                        <summary class="px-4 py-3 bg-slate-50/50 hover:bg-slate-100/60 font-bold text-xs text-slate-650 cursor-pointer flex items-center justify-between transition-all select-none">
                                            <span class="flex items-center gap-2">
                                                <i class="fa-solid fa-folder-open text-teal-700"></i> Kelola Realisasi & Presensi Mahasiswa
                                            </span>
                                            <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform"></i>
                                        </summary>
                                        <div class="p-4 space-y-4 border-t border-slate-100 text-xs w-full">
                                            
                                            <!-- Form Realisasi -->
                                            <div class="w-full bg-slate-50 p-4 rounded-xl border border-slate-200">
                                                <h5 class="font-bold text-slate-700 mb-2 flex items-center gap-1.5"><i class="fa-solid fa-check-double text-emerald-600"></i> Realisasi Pembelajaran</h5>
                                                <form action="{{ route('dosen.agenda.realisasi', $ag->id) }}" method="POST" class="flex gap-2 w-full items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" 
                                                           name="realisasi_pembelajaran" 
                                                           value="{{ $ag->materi_realisasi }}"
                                                           placeholder="Contoh: Pembahasan OOP & Inheritance, disusul latihan..." 
                                                           class="flex-1 p-2.5 rounded-lg border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                                                    <button type="submit" class="px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-bold transition whitespace-nowrap">
                                                        Simpan
                                                    </button>
                                                    @if($ag->materi_realisasi)
                                                        <button type="submit" name="realisasi_pembelajaran" value="" onclick="return confirm('Apakah Anda yakin ingin menghapus realisasi pembelajaran ini?')" class="px-3 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-250 rounded-lg font-bold transition whitespace-nowrap" title="Hapus Realisasi">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    @endif
                                                </form>
                                            </div>

                                            <!-- Table Absensi Mahasiswa -->
                                            <div class="space-y-2">
                                                <h5 class="font-bold text-slate-700 flex items-center justify-between">
                                                    <span><i class="fa-solid fa-users text-indigo-650"></i> Daftar Kehadiran Mahasiswa</span>
                                                    <div class="flex items-center gap-2.5">
                                                        @if($ag->absensi->count() > 0)
                                                            <a href="{{ route('dosen.agenda.export-kehadiran', $ag->id) }}" target="_blank" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded text-[10px] font-bold uppercase flex items-center gap-1 transition">
                                                                <i class="fa-solid fa-print"></i> Cetak Absen
                                                            </a>
                                                        @endif
                                                        <span class="text-xs text-slate-500 font-semibold">Total: {{ $ag->absensi->count() }} Hadir</span>
                                                    </div>
                                                </h5>
                                                
                                                @if($ag->absensi->count() > 0)
                                                    <div class="overflow-x-auto border border-slate-100 rounded-lg">
                                                        <table class="w-full text-xs text-left text-slate-600">
                                                            <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                                                <tr>
                                                                    <th class="p-2.5">No</th>
                                                                    <th class="p-2.5">Nama Mahasiswa</th>
                                                                    <th class="p-2.5">NIM</th>
                                                                    <th class="p-2.5">Waktu Scan</th>
                                                                    <th class="p-2.5">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-slate-100">
                                                                @foreach($ag->absensi as $idx => $abs)
                                                                    <tr class="hover:bg-slate-50/50 transition">
                                                                        <td class="p-2.5 font-mono text-slate-400">{{ $idx + 1 }}</td>
                                                                        <td class="p-2.5 font-bold text-slate-800">{{ $abs->mahasiswa->nama_lengkap }}</td>
                                                                        <td class="p-2.5 font-mono text-teal-800">{{ $abs->mahasiswa->nim }}</td>
                                                                        <td class="p-2.5 text-slate-550">{{ $abs->waktu_masuk }}</td>
                                                                        <td class="p-2.5">
                                                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold rounded text-[10px] uppercase">
                                                                                {{ $abs->status_kehadiran }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="text-center py-6 bg-slate-50 border border-slate-150 border-dashed rounded-xl text-slate-400 italic">
                                                        Belum ada mahasiswa yang memindai QR Code untuk agenda ini.
                                                     </div>
                                                @endif
                                            </div>

                                        </div>
                                    </details>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-10">
                                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-450 mb-3 text-xl">
                                        <i class="fa-solid fa-calendar-xmark"></i>
                                    </div>
                                    <p class="text-xs text-slate-500 font-semibold">Belum ada agenda praktikum untuk hari ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Right column: Create New Agenda -->
                <div class="space-y-6">
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                        <h3 class="font-bold text-sm text-slate-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-plus text-teal-700"></i> Buat Agenda Baru
                        </h3>
                        
                        <form action="{{ route('dosen.agenda.store') }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Ruangan Laboratorium</label>
                                <select name="lab_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                                    @foreach($labs as $lab)
                                        <option value="{{ $lab->id }}">{{ $lab->nama_lab }} ({{ $lab->lokasi }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Mata Kuliah</label>
                                <input type="text" name="judul_agenda" required placeholder="Contoh: Pemrograman Web" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                            </div>

                             <div>
                                 <label class="block text-slate-700 font-bold mb-1">Fakultas</label>
                                 <select name="fakultas" id="select-fakultas" required onchange="handleFakultasChange(this.value, 'input-jurusan-hidden', 'label-jurusan', 'select-jurusan-dropdown')" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                                     <option value="" disabled selected>Pilih Fakultas</option>
                                     @foreach($fakultas as $fak)
                                         <option value="{{ $fak->nama_fakultas }}">{{ $fak->nama_fakultas }}</option>
                                     @endforeach
                                 </select>
                             </div>

                            <div class="custom-search-select relative">
                                <label class="block text-slate-700 font-bold mb-1">Jurusan / Program Studi</label>
                                <!-- Hidden input to submit the form value -->
                                <input type="hidden" name="jurusan" id="input-jurusan-hidden" required>
                                
                                <!-- Trigger Button -->
                                <button type="button" onclick="toggleSearchSelect('select-jurusan-dropdown')" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-left text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none flex justify-between items-center">
                                    <span id="label-jurusan" class="text-slate-400">Pilih Program Studi</span>
                                    <i class="fa-solid fa-chevron-down text-slate-400 text-[10px]"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="select-jurusan-dropdown" class="absolute left-0 right-0 mt-1 bg-white border border-slate-250 rounded-xl shadow-xl z-50 hidden flex flex-col max-h-60 overflow-hidden">
                                    <!-- Search Input -->
                                    <div class="p-2 border-b border-slate-100 sticky top-0 bg-white">
                                        <div class="relative">
                                            <input type="text" onkeyup="filterSearchSelect('select-jurusan-dropdown', this.value)" placeholder="Cari Program Studi..." class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs">
                                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-[10px]"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Options List -->
                                    <div class="overflow-y-auto flex-grow py-1 max-h-44 scrollbar-thin">
                                        @foreach($prodis as $prod)
                                            <button type="button" data-fakultas="{{ $prod->fakultas->nama_fakultas }}" onclick="selectSearchOption('input-jurusan-hidden', 'label-jurusan', 'select-jurusan-dropdown', '{{ $prod->nama_prodi }}')" class="w-full text-left px-4 py-2 hover:bg-slate-50 text-slate-750 transition text-xs select-option-item">
                                                {{ $prod->nama_prodi }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                 <label class="block text-slate-700 font-bold mb-1">Kelas</label>
                                 <select name="kelas" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                                     <option value="" disabled selected>Pilih Kelas</option>
                                     <option value="A">Kelas A</option>
                                     <option value="B">Kelas B</option>
                                     <option value="C">Kelas C</option>
                                     <option value="D">Kelas D</option>
                                 </select>
                             </div>

                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Semester</label>
                                <select name="semester" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                                    <option value="" disabled selected>Pilih Semester</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                    <option value="7">Semester 7</option>
                                    <option value="8">Semester 8</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Tanggal</label>
                                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-slate-700 font-bold mb-1">Jam Masuk</label>
                                    <input type="time" name="waktu_masuk" required value="08:00" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                                </div>
                                <div>
                                    <label class="block text-slate-700 font-bold mb-1">Jam Keluar</label>
                                    <input type="time" name="waktu_keluar" required value="10:30" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Rencana Pembelajaran</label>
                                <textarea name="rencana_pembelajaran" rows="3" required placeholder="Tuliskan materi..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-750/30 focus:border-teal-700 outline-none"></textarea>
                            </div>

                            <button type="submit" class="w-full py-3.5 mt-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-bold uppercase tracking-wider shadow-md transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-qrcode"></i> Buat Agenda & QR
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Figma Design) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-850">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-bold">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-medium">Agenda</span>
        </a>
        <!-- Floating FAB button style from Figma -->
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-850 text-white rounded-2xl shadow-md border-4 border-slate-50">
            <a href="{{ route('dosen.perizinan') }}" class="flex items-center justify-center w-full h-full text-white">
                <i class="fa-solid fa-file-signature text-lg"></i>
            </a>
        </div>
        <a href="{{ route('dosen.mahasiswa') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-users text-lg"></i>
            <span class="text-[9px] font-medium">Mahasiswa</span>
        </a>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>

    <!-- Search Select Script -->
    <script>
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
                    // Try to find the back/rear camera
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
                        (errorMessage) => {
                            // parse error, ignore
                        }
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                } else {
                    // Fallback to environment constraints
                    html5QrcodeScanner.start(
                        { facingMode: "environment" },
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {
                            // parse error, ignore
                        }
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                }
            }).catch(err => {
                console.error("Gagal getCameras: ", err);
                // Fallback to environment constraint
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText, decodedResult) => {
                        document.getElementById('dosen-qr-token-input').value = decodedText;
                        document.getElementById('dosen-absensi-form').submit();
                        closeScannerModal();
                    },
                    (errorMessage) => {
                        // parse error, ignore
                    }
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

    <!-- Bottom Navigation Bar (Mobile Only - Floating Scan QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-bold">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-medium">Agenda</span>
        </a>
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-800 text-white rounded-2xl shadow-xl border-4 border-white">
            <button type="button" onclick="startDosenQRScanner()" class="flex items-center justify-center w-full h-full text-white bg-teal-800 rounded-xl hover:bg-teal-900 transition-all" title="Scan QR Presensi">
                <i class="fa-solid fa-qrcode text-2xl text-white"></i>
            </button>
        </div>
        <a href="{{ route('dosen.mahasiswa') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-users text-lg"></i>
            <span class="text-[9px] font-medium">Mahasiswa</span>
        </a>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>
</body>
</html>
