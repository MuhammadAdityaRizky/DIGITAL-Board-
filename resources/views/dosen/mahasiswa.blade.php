<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-alt"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda</span>
            </a>
            <a href="{{ route('dosen.mahasiswa') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full">
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
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Data Kehadiran Mahasiswa</h2>
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
            
            <!-- Filter & Summary Bar -->
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                        <i class="fa-solid fa-users text-teal-700"></i>
                        <span>Menampilkan <strong class="text-slate-800 font-bold">{{ $mahasiswas->count() }}</strong> mahasiswa</span>
                        @if(request()->hasAny(['search', 'fakultas_id', 'prodi_id', 'kelas', 'semester']))
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md text-[10px] font-bold">Filter Aktif</span>
                        @endif
                    </div>
                    
                    <div class="bg-teal-50 border border-teal-150 rounded-xl px-4 py-2 flex items-center gap-2.5 text-xs">
                        <i class="fa-solid fa-graduation-cap text-teal-850 text-base"></i>
                        <div>
                            <span class="font-bold text-teal-900 leading-none">Total Mahasiswa:</span>
                            <span class="font-semibold text-teal-700 ml-1">{{ $mahasiswas->count() }} Orang</span>
                        </div>
                    </div>
                </div>

                <!-- Filter Box Card -->
                <form action="{{ route('dosen.mahasiswa') }}" method="GET" id="filterForm" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4 text-xs">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2 font-bold text-slate-800">
                            <i class="fa-solid fa-filter text-teal-700"></i>
                            <span>Filter Data Rekapitulasi</span>
                        </div>
                        @if(request()->hasAny(['search', 'fakultas_id', 'prodi_id', 'kelas', 'semester']))
                            <a href="{{ route('dosen.mahasiswa') }}" class="text-[11px] font-semibold text-rose-600 hover:text-rose-700 flex items-center gap-1 transition">
                                <i class="fa-solid fa-rotate-left"></i> Reset Filter
                            </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        <!-- Search Input -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Pencarian</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / NIM..." class="w-full pl-8 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                            </div>
                        </div>

                        <!-- Fakultas Select -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Fakultas</label>
                            <select name="fakultas_id" id="filter_fakultas" onchange="filterProdiByFakultas()" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                <option value="">Semua Fakultas</option>
                                @foreach($fakultas as $fak)
                                    <option value="{{ $fak->id }}" {{ request('fakultas_id') == $fak->id ? 'selected' : '' }}>{{ $fak->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Prodi Select -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Program Studi</label>
                            <select name="prodi_id" id="filter_prodi" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                <option value="">Semua Prodi</option>
                                @foreach($prodis as $prd)
                                    <option value="{{ $prd->id }}" data-fakultas="{{ $prd->fakultas_id }}" {{ request('prodi_id') == $prd->id ? 'selected' : '' }}>{{ $prd->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kelas Select -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kelas</label>
                            <select name="kelas" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                <option value="">Semua Kelas</option>
                                @foreach($kelases as $kls)
                                    <option value="{{ $kls->nama_kelas }}" {{ request('kelas') == $kls->nama_kelas ? 'selected' : '' }}>{{ $kls->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Semester Select -->
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Semester</label>
                            <select name="semester" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs text-slate-700">
                                <option value="">Semua Semester</option>
                                @foreach($semesters as $sem)
                                    <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>Semester {{ $sem }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                        <button type="submit" class="px-4 py-2 bg-teal-850 hover:bg-teal-900 text-white rounded-xl font-bold transition flex items-center gap-1.5 shadow-sm text-xs">
                            <i class="fa-solid fa-filter"></i> Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Students List (Table/Grid) -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                    <h3 class="font-bold text-sm text-slate-800">Rekapitulasi Kehadiran Mahasiswa</h3>
                    @if($mahasiswas->count() > 0)
                        <a href="{{ route('dosen.mahasiswa.export', request()->all()) }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-print"></i> Cetak Rekap
                        </a>
                    @endif
                </div>
                
                <div class="p-6">
                    @if($mahasiswas->count() > 0)
                        <div class="overflow-x-auto border border-slate-100 rounded-xl">
                            <table class="w-full text-xs text-left text-slate-600">
                                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                    <tr>
                                        <th class="p-4">No</th>
                                        <th class="p-4">Nama Mahasiswa</th>
                                        <th class="p-4">NIM</th>
                                        <th class="p-4">Kelas & Semester</th>
                                        <th class="p-4 text-center">Hadir</th>
                                        <th class="p-4 text-center">Izin</th>
                                        <th class="p-4 text-center">Alpa</th>
                                        <th class="p-4 text-center">Total Agenda</th>
                                        <th class="p-4 text-center">Persentase</th>
                                        <th class="p-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($mahasiswas as $idx => $mhs)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="p-4 font-mono text-slate-400">{{ $idx + 1 }}</td>
                                            <td class="p-4">
                                                <span class="font-bold text-slate-800 text-sm block">{{ $mhs->nama_lengkap }}</span>
                                                <div class="text-[10px] text-slate-500 font-medium flex items-center gap-1 flex-wrap mt-0.5">
                                                    <span class="text-teal-700 font-semibold">{{ $mhs->fakultas->nama_fakultas ?? 'Fakultas Teknik & Ilmu Komputer' }}</span>
                                                    <span class="text-slate-300">•</span>
                                                    <span>{{ $mhs->prodi->nama_prodi ?? 'Informatika' }}</span>
                                                </div>
                                            </td>
                                            <td class="p-4 font-mono text-teal-800 font-bold">{{ $mhs->nim }}</td>
                                            <td class="p-4">
                                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-200 font-bold rounded-lg text-xs inline-block">
                                                    {{ $mhs->kelas ?? '-' }}
                                                </span>
                                                <span class="text-[10px] text-slate-450 block mt-0.5 font-medium">Semester {{ $mhs->semester ?? '1' }}</span>
                                            </td>
                                            <td class="p-4 text-center">
                                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold rounded-lg">
                                                    {{ $mhs->hadir_count }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-center">
                                                <span class="px-2.5 py-1 bg-blue-50 text-blue-750 border border-blue-100 font-bold rounded-lg">
                                                    {{ $mhs->izin_count }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-center">
                                                <span class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-100 font-bold rounded-lg">
                                                    {{ $mhs->alpa_count }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-center font-bold text-slate-700">
                                                {{ $mhs->total_agenda }} Sesi
                                            </td>
                                            <td class="p-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="w-16 bg-slate-100 rounded-full h-2 overflow-hidden hidden sm:block">
                                                        <div class="h-full rounded-full {{ $mhs->kehadiran_percentage >= 80 ? 'bg-emerald-500' : ($mhs->kehadiran_percentage >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}" style="width: {{ $mhs->kehadiran_percentage }}%"></div>
                                                    </div>
                                                    <span class="font-mono font-bold {{ $mhs->kehadiran_percentage >= 80 ? 'text-emerald-700' : ($mhs->kehadiran_percentage >= 50 ? 'text-amber-700' : 'text-rose-750') }}">
                                                        {{ $mhs->kehadiran_percentage }}%
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="p-4 text-center">
                                                <button onclick="toggleModal('modal-detail-izin-{{ $mhs->id }}')" class="px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-700 text-[10px] font-bold rounded-lg border border-teal-200 transition flex items-center gap-1 mx-auto">
                                                    <i class="fa-solid fa-file-invoice"></i> Lihat Izin
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal Detail Izin Mahasiswa (Rendered outside the table to prevent invalid HTML nesting) -->
                        @foreach($mahasiswas as $mhs)
                            <div id="modal-detail-izin-{{ $mhs->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                                <!-- Backdrop -->
                                <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-detail-izin-{{ $mhs->id }}')"></div>
                                
                                <!-- Modal Content -->
                                <div class="relative min-h-screen flex items-center justify-center p-4">
                                    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden text-left">
                                        <!-- Header -->
                                        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-800">
                                            <h3 class="font-bold text-sm flex items-center gap-2">
                                                <i class="fa-solid fa-file-signature text-teal-705"></i> Riwayat Izin: {{ $mhs->nama_lengkap }}
                                            </h3>
                                            <button type="button" onclick="toggleModal('modal-detail-izin-{{ $mhs->id }}')" class="text-slate-400 hover:text-slate-650 text-base">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Body -->
                                        <div class="p-6 space-y-4">
                                            @if($mhs->perizinan->count() > 0)
                                                <div class="overflow-x-auto border border-slate-100 rounded-lg">
                                                    <table class="w-full text-left text-slate-600">
                                                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                                            <tr>
                                                                <th class="p-2.5">Tanggal</th>
                                                                <th class="p-2.5">Mata Kuliah</th>
                                                                <th class="p-2.5">Alasan</th>
                                                                <th class="p-2.5">Bukti</th>
                                                                <th class="p-2.5">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-slate-100">
                                                            @foreach($mhs->perizinan as $p)
                                                                <tr class="hover:bg-slate-50/50 transition">
                                                                    <td class="p-2.5 font-mono text-slate-500 whitespace-nowrap">{{ date('d M Y', strtotime($p->agenda->tanggal)) }}</td>
                                                                    <td class="p-2.5 font-bold text-slate-800">{{ $p->agenda->mata_kuliah }}</td>
                                                                    <td class="p-2.5 text-slate-600 italic">"{{ $p->alasan }}"</td>
                                                                    <td class="p-2.5">
                                                                        @if($p->bukti_url)
                                                                            <a href="{{ asset($p->bukti_url) }}" target="_blank" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1">
                                                                                <i class="fa-solid fa-file-pdf"></i> Bukti
                                                                            </a>
                                                                        @else
                                                                            <span class="text-slate-400 italic">Tidak ada</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="p-2.5">
                                                                        @if(strtolower($p->status_persetujuan) === 'disetujui')
                                                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold rounded text-[10px] uppercase">Disetujui</span>
                                                                        @elseif(strtolower($p->status_persetujuan) === 'ditolak')
                                                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 font-bold rounded text-[10px] uppercase">Ditolak</span>
                                                                        @else
                                                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-100 font-bold rounded text-[10px] uppercase">Pending</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-center text-xs text-slate-400 italic py-4">Belum ada pengajuan izin/sakit untuk mahasiswa ini.</p>
                                            @endif
                                        </div>
                                        
                                        <!-- Footer -->
                                        <div class="flex justify-end gap-2 p-4 border-t border-slate-100 bg-slate-50/50">
                                            <button type="button" onclick="toggleModal('modal-detail-izin-{{ $mhs->id }}')" class="px-4 py-2 bg-slate-250 hover:bg-slate-300 text-slate-700 font-bold rounded-lg transition">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-users-slash text-2xl block mb-2"></i>
                            Mahasiswa tidak ditemukan.
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Figma Design) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-medium">Dashboard</span>
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
        <a href="{{ route('dosen.mahasiswa') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-users text-lg"></i>
            <span class="text-[9px] font-bold">Mahasiswa</span>
        </a>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>
    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        function filterProdiByFakultas() {
            const fakultasSelect = document.getElementById('filter_fakultas');
            const prodiSelect = document.getElementById('filter_prodi');
            if (!fakultasSelect || !prodiSelect) return;
            
            const selectedFakultas = fakultasSelect.value;
            
            Array.from(prodiSelect.options).forEach(option => {
                if (!option.value) return;
                const optionFakultas = option.getAttribute('data-fakultas');
                if (!selectedFakultas || optionFakultas === selectedFakultas) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                    if (option.selected) {
                        prodiSelect.value = '';
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', filterProdiByFakultas);
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
</body>
</html>
