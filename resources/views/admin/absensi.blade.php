<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Laporan Presensi Mahasiswa</h2>
            </div>
            
            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ auth()->user()->username }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500 uppercase">SUPER ADMIN</p>
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
                            Super Admin
                        </span>
                    </div>

                    <div class="p-1">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold text-left group">
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

            <!-- Search & Filter Bar -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm max-w-5xl">
                <form action="{{ route('admin.absensi') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end text-xs">
                    <div class="flex-grow w-full">
                        <label class="block text-slate-655 font-bold mb-1.5">Cari Agenda / Dosen</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mata kuliah atau nama dosen..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                        </div>
                    </div>
                    <div class="w-full sm:w-40">
                        <label class="block text-slate-650 font-bold mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div class="w-full sm:w-40">
                        <label class="block text-slate-650 font-bold mb-1.5">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full py-2.5 px-3 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="flex-grow sm:flex-grow-0 px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'start_date', 'end_date', 'tanggal']))
                            <a href="{{ route('admin.absensi') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-all border border-slate-200 text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Attendance Logs Grouped Per Agenda -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden max-w-5xl">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center flex-wrap gap-3">
                    <h3 class="font-bold text-sm text-slate-800">Laporan Kehadiran Per Sesi Praktikum</h3>
                    <div class="flex gap-2">
                        <button onclick="document.getElementById('modal-import-global').classList.remove('hidden')" class="px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white border border-blue-700 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-file-excel"></i> Import Excel Global
                        </button>
                        <a href="{{ route('admin.absensi.export', request()->all()) }}" target="_blank" class="px-3.5 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-print"></i> Cetak/Ekspor Range Laporan
                        </a>
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
                        
                        <form action="{{ route('admin.absensi.import-global') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Mata Kuliah & Kelas</label>
                                <select name="mata_kuliah_kelas" required class="w-full text-sm p-2.5 rounded-lg border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                    @foreach($uniqueClasses as $uc)
                                        <option value="{{ $uc->mata_kuliah }}|{{ $uc->kelas }}|{{ $uc->dosen_id }}">
                                            {{ $uc->mata_kuliah }} {{ $uc->kelas ? '('.$uc->kelas.')' : '' }} - Dosen: {{ $uc->dosen->nama ?? '-' }}
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
                <div class="p-6 space-y-8">
                    @if($agendas->count() > 0)
                        @foreach($agendas as $ag)
                            <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50/20">
                                <!-- Agenda Info Header -->
                                <div class="bg-slate-100/70 border-b border-slate-200 px-5 py-3.5 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                                            {{ $ag->mata_kuliah }}
                                            <span class="px-2 py-0.5 bg-teal-55 text-teal-800 border border-teal-100 rounded text-[9px] font-bold uppercase">Kelas {{ $ag->kelas ?: '-' }}</span>
                                        </h4>
                                        <p class="text-[10px] text-slate-500 font-semibold mt-1">
                                            Dosen: <span class="text-slate-700 font-bold">{{ $ag->dosen->nama }}</span>
                                            @if($ag->dosen_waktu_masuk)
                                                <span class="ml-1 px-1.5 py-0.5 bg-emerald-55 text-emerald-700 border border-emerald-100 rounded-md font-bold uppercase tracking-wider text-[8px]">
                                                    <i class="fa-solid fa-circle-check"></i> Masuk: {{ date('H:i:s', strtotime($ag->dosen_waktu_masuk)) }} WIB
                                                </span>
                                            @else
                                                <span class="ml-1 px-1.5 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded-md font-bold uppercase tracking-wider text-[8px]">
                                                    <i class="fa-solid fa-circle-xmark"></i> Belum Check-in
                                                </span>
                                            @endif
                                            • {{ $ag->lab->nama_lab }} ({{ $ag->lab->lokasi }})
                                        </p>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <div class="text-right text-[10px] font-semibold text-slate-500 bg-white border border-slate-200 rounded-lg px-3 py-1.5 shadow-xs">
                                            <i class="fa-solid fa-calendar-day text-teal-700 mr-1"></i>{{ date('d F Y', strtotime($ag->tanggal)) }} | {{ substr($ag->jam_mulai, 0, 5) }} - {{ substr($ag->jam_selesai, 0, 5) }} WIB
                                        </div>
                                        @if($ag->tanggal > date('Y-m-d'))
                                            <span class="text-[10px] bg-slate-100 text-slate-400 border border-slate-200 font-semibold py-1.5 px-3 rounded-lg flex items-center gap-1.5 cursor-not-allowed select-none" title="Sesi perkuliahan belum berlangsung">
                                                <i class="fa-solid fa-lock text-[9px]"></i> Presensi Dibuka Hari H
                                            </span>
                                        @else
                                            <a href="{{ route('admin.absensi.input', $ag->id) }}" class="text-[10px] bg-teal-600 hover:bg-teal-700 text-white font-bold py-1.5 px-3 rounded-lg transition shadow-sm flex items-center gap-1.5">
                                                <i class="fa-solid fa-user-check"></i> {{ $ag->tanggal === date('Y-m-d') ? 'Input Absensi Manual' : 'Edit Rekap Absensi' }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Students attendance table -->
                                <div class="p-4 bg-white">
                                    @if($ag->absensi->count() > 0)
                                        <div class="overflow-x-auto rounded-lg border border-slate-100 text-xs">
                                            <table class="w-full text-left text-slate-655">
                                                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                                    <tr>
                                                        <th class="p-3">No</th>
                                                        <th class="p-3">Mahasiswa (NIM)</th>
                                                        <th class="p-3">Waktu Masuk</th>
                                                        <th class="p-3 text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-100">
                                                    @foreach($ag->absensi as $index => $abs)
                                                        <tr class="hover:bg-slate-50/50 transition">
                                                            <td class="p-3 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                                            <td class="p-3">
                                                                <span class="font-bold text-slate-800 block text-xs">{{ $abs->mahasiswa->nama_lengkap }}</span>
                                                                <span class="text-[10px] font-mono text-teal-800 font-semibold">NIM: {{ $abs->mahasiswa->nim }}</span>
                                                            </td>
                                                            <td class="p-3 font-mono text-slate-500">{{ date('H:i:s', strtotime($abs->waktu_masuk)) }} WIB</td>
                                                            <td class="p-3 text-center">
                                                                <span class="px-2 py-0.5 border font-bold rounded text-[9px] uppercase tracking-wider
                                                                    @if(strtolower($abs->status_kehadiran) === 'hadir') bg-emerald-50 text-emerald-700 border-emerald-100
                                                                    @elseif(strtolower($abs->status_kehadiran) === 'terlambat') bg-amber-50 text-amber-700 border-amber-100
                                                                    @elseif(strtolower($abs->status_kehadiran) === 'izin' || strtolower($abs->status_kehadiran) === 'sakit') bg-blue-50 text-blue-755 border-blue-100
                                                                    @else bg-rose-50 text-rose-750 border-rose-100
                                                                    @endif">
                                                                    {{ $abs->status_kehadiran }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-center py-4 text-[11px] text-slate-400 italic"><i class="fa-solid fa-triangle-exclamation mr-1 text-amber-500"></i> Belum ada mahasiswa yang melakukan absensi pada sesi ini.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-4">
                            {{ $agendas->links() }}
                        </div>
                    @else
                        <p class="text-center py-10 text-slate-400 italic">Data agenda praktikum tidak ditemukan.</p>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

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

        // Profile Dropdown Handler
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const menu = document.getElementById('profileDropdownMenu');
            const button = event.target.closest('button[onclick="toggleProfileDropdown(event)"]');
            if (menu && !menu.classList.contains('hidden') && !button && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>




