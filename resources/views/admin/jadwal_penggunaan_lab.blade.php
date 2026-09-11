<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Penggunaan Lab - Digital Board</title>
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
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0 h-screen sticky top-0 hidden lg:flex">
        <div class="p-5 flex items-center gap-3 border-b border-slate-800 shrink-0">
            <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white shrink-0">
                <i class="fa-solid fa-user-shield text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">ADMIN CONTROL PANEL</p>
            </div>
        </div>
        
        <nav class="flex-1 min-h-0 px-3 py-3 space-y-1 overflow-y-auto custom-sidebar-scroll">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-line"></i>
                <span class="text-xs">Dashboard Overview</span>
            </a>
            <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-users-gear"></i>
                <span class="text-xs">Manajemen Pengguna</span>
            </a>
            <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-door-open"></i>
                <span class="text-xs">Manajemen Lab</span>
            </a>
            <a href="{{ route('admin.jadwal-lab') }}" class="flex items-center gap-3 px-4 py-2.5 bg-teal-800 text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs">Jadwal & Agenda</span>
            </a>
            <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="text-xs">Laporan Absensi</span>
            </a>
<a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="text-xs">Data Akademik</span>
            </a>
            <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-bullhorn"></i>
                <span class="text-xs">Pengumuman Lab</span>
            </a>
            <a href="{{ route('admin.aktivitas') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="text-xs">Riwayat Aktivitas</span>
            </a>
            
            <div class="pt-2 border-t border-slate-800/80 my-2"></div>
            <a href="{{ route('board') }}" target="_blank" class="flex items-center justify-between px-4 py-2.5 bg-[#0c4ea6]/40 hover:bg-[#0c4ea6] text-teal-300 hover:text-white rounded-xl w-full transition font-bold border border-teal-500/20">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-desktop text-emerald-400"></i>
                    <span class="text-xs">Portal Display Board</span>
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 shrink-0">
            <div class="flex items-center gap-3">
                <h2 class="font-bold text-base text-slate-800">Pusat Jadwal & Perkuliahan</h2>
                <!-- Tab Switching Navigation (Analyst Recommendation #4) -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs">
                    <a href="{{ route('admin.jadwal-lab') }}" class="px-3 py-1 bg-white text-teal-900 font-bold rounded-lg shadow-2xs flex items-center gap-1.5">
                        <i class="fa-solid fa-table-cells text-teal-700"></i> Matriks Jadwal Lab
                    </a>
                    <a href="{{ route('admin.agenda') }}" class="px-3 py-1 text-slate-500 hover:text-slate-800 font-semibold rounded-lg transition flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-days"></i> Agenda & Realisasi
                    </a>
                </div>
            </div>
            
            <!-- User Info & Logout -->
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-medium">Semester Aktif: <strong class="text-slate-800">{{ $tahunAkademik }}</strong></span>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-full">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-full">
                    <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal Menyimpan:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Controls & Lab Filter -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <form action="{{ route('admin.jadwal-lab') }}" method="GET" class="flex flex-wrap items-center gap-3 text-xs w-full sm:w-auto">
                    <div>
                        <label class="block text-slate-500 font-bold mb-1">Pilih Laboratorium:</label>
                        <select name="lab_id" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            @foreach($labs as $l)
                                <option value="{{ $l->id }}" {{ $selectedLabId == $l->id ? 'selected' : '' }}>
                                    {{ strtoupper($l->nama_lab) }} ({{ $l->lokasi }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-500 font-bold mb-1">Tahun Akademik:</label>
                        <select name="tahun_akademik" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 font-bold text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="2026/2027 Ganjil" {{ $tahunAkademik == '2026/2027 Ganjil' ? 'selected' : '' }}>2026/2027 Ganjil</option>
                            <option value="2026/2027 Genap" {{ $tahunAkademik == '2026/2027 Genap' ? 'selected' : '' }}>2026/2027 Genap</option>
                        </select>
                    </div>
                </form>

                <div class="flex items-center gap-2.5">
                    @if($jadwals->count() > 0)
                        <form action="{{ route('admin.jadwal-lab.bulk-generate-16') }}" method="POST" onsubmit="return confirm('Otomatis buat 16 sesi agenda pertemuan perkuliahan 1 semester untuk SEMUA jadwal di lab ini?');" class="inline">
                            @csrf
                            <input type="hidden" name="lab_id" value="{{ $selectedLabId }}">
                            <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm" title="Otomatis buat 16 pertemuan untuk seluruh mata kuliah di lab ini">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Generate 16 Sesi Lab Ini
                            </button>
                        </form>
                    @endif
                    <button type="button" onclick="openAddModal()" class="px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-plus"></i> Tambah Slot Jadwal
                    </button>
                </div>
            </div>

            <!-- Matriks Visual Tabel Excel Mingguan -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-slate-800 text-white px-6 py-4 flex flex-wrap justify-between items-center gap-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-calendar-week text-teal-400 text-lg"></i>
                        <div>
                            <h3 class="font-extrabold text-sm uppercase tracking-wide">
                                Jadwal Penggunaan {{ strtoupper($labs->firstWhere('id', $selectedLabId)->nama_lab ?? 'Laboratorium') }}
                            </h3>
                            <p class="text-[11px] text-slate-300">Tahun Akademik {{ $tahunAkademik }} • Format Matriks Jadwal Mingguan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="px-2.5 py-1 bg-teal-600/90 text-white font-bold rounded-lg">{{ $jadwals->count() }} Sesi Terjadwal</span>
                    </div>
                </div>

                <!-- Table Grid -->
                <div class="overflow-x-auto">
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px] text-center">
                                <th class="p-3 border-r border-slate-200 w-32 bg-slate-200/80">Waktu</th>
                                @foreach($hariList as $hari)
                                    <th class="p-3 border-r border-slate-200 min-w-[170px]">{{ $hari }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($timeSlots as $slot)
                                @php
                                    list($slotStart, $slotEnd) = explode('-', $slot);
                                    $slotStartClean = str_replace('.', ':', trim($slotStart)) . ':00';
                                    $slotEndClean = str_replace('.', ':', trim($slotEnd)) . ':00';
                                @endphp
                                <tr>
                                    <td class="p-2.5 text-center font-mono font-bold text-slate-600 bg-slate-50 border-r border-slate-200 text-[11px]">
                                        {{ $slot }}
                                    </td>
                                    @foreach($hariList as $hari)
                                        @php
                                            // Find items that overlap or start in this slot
                                            $matches = $jadwals->filter(function($j) use ($hari, $slotStartClean, $slotEndClean) {
                                                return $j->hari === $hari && (
                                                    ($j->jam_mulai <= $slotStartClean && $j->jam_selesai > $slotStartClean) ||
                                                    ($j->jam_mulai >= $slotStartClean && $j->jam_mulai < $slotEndClean)
                                                );
                                            });
                                        @endphp
                                        <td class="p-1.5 border-r border-slate-200 align-top hover:bg-slate-50/50 transition">
                                            @if($matches->isNotEmpty())
                                                @foreach($matches as $m)
                                                    @php
                                                        // Determine background color based on Prodi
                                                        $prodiName = strtolower($m->prodi->nama_prodi ?? '');
                                                        $bgColor = 'bg-teal-900 text-white border-teal-800';
                                                        if (str_contains($prodiName, 'informasi')) {
                                                            $bgColor = 'bg-[#1b325f] text-white border-[#132547]'; // Biru dongker
                                                        } elseif (str_contains($prodiName, 'sipil')) {
                                                            $bgColor = 'bg-emerald-800 text-white border-emerald-900'; // Hijau
                                                        } elseif (str_contains($prodiName, 'mesin')) {
                                                            $bgColor = 'bg-amber-600 text-white border-amber-700'; // Kuning/oranye
                                                        } elseif (str_contains($prodiName, 'elektro')) {
                                                            $bgColor = 'bg-rose-800 text-white border-rose-900'; // Merah
                                                        }
                                                    @endphp
                                                    <div class="p-2 rounded-lg border {{ $bgColor }} shadow-xs mb-1 text-[11px] leading-tight relative group">
                                                        <div class="font-extrabold line-clamp-2">{{ $m->mata_kuliah }}</div>
                                                        <div class="text-[10px] text-teal-200 mt-1 font-semibold">
                                                            {{ $m->kelas ?: 'Reg A' }} @if($m->semester)• Sem {{ $m->semester }}@endif
                                                        </div>
                                                        <div class="text-[10px] text-slate-200 mt-0.5 font-medium flex items-center gap-1">
                                                            <i class="fa-solid fa-user-tie text-[9px]"></i> {{ $m->dosen->nama ?? '-' }}
                                                        </div>
                                                        <div class="text-[9px] font-mono opacity-80 mt-1">
                                                            {{ substr($m->jam_mulai,0,5) }} - {{ substr($m->jam_selesai,0,5) }}
                                                        </div>

                                                        <!-- Action buttons on hover -->
                                                        <div class="absolute right-1.5 top-1.5 hidden group-hover:flex items-center gap-1">
                                                            <form action="{{ route('admin.jadwal-lab.generate-16', $m->id) }}" method="POST" onsubmit="return confirm('Otomatis generate 16 sesi agenda praktikum 1 semester untuk {{ $m->mata_kuliah }}?');" class="inline">
                                                                @csrf
                                                                <button type="submit" class="w-5 h-5 rounded bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center text-[9px] shadow-2xs" title="Generate 16 Sesi Agenda 1 Semester">
                                                                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                                                                </button>
                                                            </form>
                                                            <button onclick="openEditModal({{ json_encode($m) }})" class="w-5 h-5 rounded bg-white/20 hover:bg-white/40 text-white flex items-center justify-center text-[9px]" title="Edit">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                            <form action="{{ route('admin.jadwal-lab.delete', $m->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="w-5 h-5 rounded bg-rose-600/80 hover:bg-rose-700 text-white flex items-center justify-center text-[9px]" title="Hapus">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <button onclick="openAddModalWith('{{ $hari }}', '{{ substr($slotStartClean, 0, 5) }}', '{{ substr($slotEndClean, 0, 5) }}')" class="w-full h-8 rounded border border-dashed border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-slate-300 hover:text-teal-600 flex items-center justify-center text-[10px] transition group" title="Tambah slot di sini">
                                                    <i class="fa-solid fa-plus opacity-0 group-hover:opacity-100 transition"></i>
                                                </button>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Legend (Warna Prodi) -->
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-2 text-slate-500 font-bold">
                        <i class="fa-solid fa-palette"></i> Keterangan Warna Prodi:
                    </div>
                    <div class="flex flex-wrap items-center gap-4 text-[11px] font-semibold">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-[#1b325f]"></span> Sistem Informasi (Biru Dongker)
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-emerald-800"></span> Teknik Sipil (Hijau)
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-amber-600"></span> Teknik Mesin (Kuning/Oranye)
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded bg-rose-800"></span> Teknik Elektro (Merah)
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Tambah / Edit Jadwal Master -->
    <div id="modal-jadwal" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden text-xs">
        <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl border border-slate-100">
            <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center">
                <h4 id="modal-jadwal-title" class="font-bold text-sm">Tambah Slot Jadwal Penggunaan Lab</h4>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-white text-base"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="form-jadwal" action="{{ route('admin.jadwal-lab.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="method-field" name="_method" value="POST">
                <input type="hidden" name="tahun_akademik" value="{{ $tahunAkademik }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Ruang Laboratorium <span class="text-rose-500">*</span></label>
                        <select name="lab_id" id="form_lab_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            @foreach($labs as $l)
                                <option value="{{ $l->id }}" {{ $selectedLabId == $l->id ? 'selected' : '' }}>{{ strtoupper($l->nama_lab) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Hari <span class="text-rose-500">*</span></label>
                        <select name="hari" id="form_hari" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            @foreach($hariList as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Mata Kuliah <span class="text-rose-500">*</span></label>
                    <input type="text" list="matkul-list" name="mata_kuliah" id="form_mata_kuliah" required placeholder="Contoh: Praktikum Dasar Bahasa Pemrograman" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    <datalist id="matkul-list">
                        @foreach($mataKuliahs as $mk)
                            <option value="{{ $mk->nama_mk }}">{{ $mk->nama_mk }}</option>
                        @endforeach
                    </datalist>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Dosen Pengajar <span class="text-rose-500">*</span></label>
                        <select name="dosen_id" id="form_dosen_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Program Studi</label>
                        <select name="id_prodi" id="form_id_prodi" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($prodis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Kelas</label>
                        <input type="text" name="kelas" id="form_kelas" value="Reg A" placeholder="Reg A" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Semester</label>
                        <select name="semester" id="form_semester" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            @for($i=1; $i<=8; $i++)
                                <option value="{{ $i }}">Sem {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Program</label>
                        <select name="program_kuliah" id="form_program_kuliah" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-semibold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            <option value="Reguler">Reguler</option>
                            <option value="Karyawan">Karyawan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Jam Mulai <span class="text-rose-500">*</span></label>
                        <input type="time" name="jam_mulai" id="form_jam_mulai" required value="08:00" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Jam Selesai <span class="text-rose-500">*</span></label>
                        <input type="time" name="jam_selesai" id="form_jam_selesai" required value="10:30" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 font-mono font-bold focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                </div>

                <div class="pt-2 flex justify-end gap-2 border-t border-slate-100">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-xl transition shadow-sm">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal-jadwal');
        const form = document.getElementById('form-jadwal');
        const title = document.getElementById('modal-jadwal-title');
        const methodField = document.getElementById('method-field');

        function openAddModal() {
            title.textContent = 'Tambah Slot Jadwal Penggunaan Lab';
            form.action = "{{ route('admin.jadwal-lab.store') }}";
            methodField.value = 'POST';
            form.reset();
            modal.classList.remove('hidden');
        }

        function openAddModalWith(hari, jamMulai, jamSelesai) {
            openAddModal();
            document.getElementById('form_hari').value = hari;
            document.getElementById('form_jam_mulai').value = jamMulai;
            document.getElementById('form_jam_selesai').value = jamSelesai;
        }

        function openEditModal(jadwal) {
            title.textContent = 'Edit Slot Jadwal Penggunaan Lab';
            form.action = "{{ url('admin/jadwal-lab') }}/" + jadwal.id;
            methodField.value = 'PUT';

            document.getElementById('form_lab_id').value = jadwal.lab_id;
            document.getElementById('form_hari').value = jadwal.hari;
            document.getElementById('form_mata_kuliah').value = jadwal.mata_kuliah;
            document.getElementById('form_dosen_id').value = jadwal.dosen_id;
            document.getElementById('form_id_prodi').value = jadwal.id_prodi || '';
            document.getElementById('form_kelas').value = jadwal.kelas || 'Reg A';
            document.getElementById('form_semester').value = jadwal.semester || '1';
            document.getElementById('form_program_kuliah').value = jadwal.program_kuliah || 'Reguler';
            document.getElementById('form_jam_mulai').value = jadwal.jam_mulai.substr(0, 5);
            document.getElementById('form_jam_selesai').value = jadwal.jam_selesai.substr(0, 5);

            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>
</body>
</html>
