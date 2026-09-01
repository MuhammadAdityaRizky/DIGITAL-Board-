<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - Digital Board</title>
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
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold tracking-wider text-teal-400">Portal Mahasiswa</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-qrcode"></i>
                <span class="text-xs font-semibold tracking-wide">Absensi Mandiri</span>
            </a>
            <a href="{{ route('mahasiswa.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda Kuliah</span>
            </a>
            <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="text-xs font-semibold tracking-wide">Riwayat Kehadiran</span>
            </a>
            <a href="{{ route('mahasiswa.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
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
                    <i class="fa-solid fa-user-graduate text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Portal Absensi Mahasiswa</h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ $mahasiswa->nama_lengkap }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIM: {{ $mahasiswa->nim }} • {{ $mahasiswa->prodi->nama_prodi ?? 'Mahasiswa' }}</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr($mahasiswa->nama_lengkap, 0, 2) }}
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

            <!-- Alert Notifications -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-2xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Informasi:</span>
                        <p class="mt-0.5">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-xmark text-red-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Gagal Absen:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Announcement Section -->
            @if(isset($pengumuman) && $pengumuman->count() > 0)
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex gap-4 items-start shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0 text-lg">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-amber-800 text-sm flex items-center gap-2">
                            PENGUMUMAN RESMI
                            <span class="text-[10px] font-normal text-amber-600/80">({{ date('d M Y', strtotime($pengumuman->first()->created_at)) }})</span>
                        </h3>
                        <p class="text-amber-700 text-sm mt-1">
                            <strong>{{ $pengumuman->first()->judul }}:</strong> {{ $pengumuman->first()->isi_pengumuman }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Hidden form for attendance submission -->
            <form action="{{ route('mahasiswa.absensi.submit') }}" method="POST" id="mahasiswa-absensi-form" class="hidden">
                @csrf
                <input type="hidden" name="qr_code_token" id="mahasiswa-qr-token-input">
            </form>

            <!-- Main Layout (Class Lists & Status) -->
            <div class="space-y-6">
                <!-- Today's Classes -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4 flex justify-between items-center">
                            <h3 class="font-bold text-sm text-slate-800">Mata Kuliah & Praktikum Hari Ini</h3>
                            <span class="text-[10px] bg-teal-100 text-teal-800 font-bold px-2 py-0.5 rounded-full">{{ date('d M Y') }}</span>
                        </div>
                        
                        <div class="p-6 divide-y divide-slate-100">
                            @if(isset($profileIncomplete) && $profileIncomplete)
                                <div class="text-center py-8 px-4 bg-amber-50 rounded-xl border border-amber-200">
                                    <i class="fa-solid fa-triangle-exclamation text-3xl mb-3 text-amber-500 block"></i>
                                    <span class="font-bold text-sm text-amber-900 block">Profil Kelas Belum Lengkap!</span>
                                    <p class="text-xs text-amber-700 mt-1.5 leading-relaxed max-w-md mx-auto">Silakan lengkapi data **Kelas, Fakultas, dan Jurusan** Anda di halaman **Pengaturan** terlebih dahulu agar kelas praktikum Anda dapat muncul di sini.</p>
                                    <a href="{{ route('mahasiswa.pengaturan') }}" class="inline-block mt-4 px-4 py-2 bg-amber-800 hover:bg-amber-900 text-white rounded-lg font-bold text-xs transition shadow-sm">Lengkapi Profil Sekarang</a>
                                </div>
                            @elseif(count($todayAgendas) > 0)
                                @foreach($todayAgendas as $ag)
                                    <div class="py-4 first:pt-0 last:pb-0 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-660 text-[10px] font-bold rounded">
                                                    {{ substr($ag->jam_mulai, 0, 5) }} - {{ substr($ag->jam_selesai, 0, 5) }} WIB
                                                </span>
                                                <span class="text-xs text-slate-500 font-semibold">{{ $ag->lab->nama_lab }}</span>
                                            </div>
                                            <h4 class="font-bold text-slate-800 text-base">{{ $ag->mata_kuliah }}</h4>
                                            <p class="text-xs text-slate-500">Dosen: <span class="font-medium text-slate-700">{{ $ag->dosen->nama }}</span></p>
                                            
                                            <!-- Token / ID Agenda Info for Camera Fallback -->
                                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                                <span class="px-2 py-0.5 bg-slate-100 border border-slate-200 rounded text-[11px] font-extrabold font-mono text-teal-850 select-all" title="Kode Token Agenda">
                                                    ID: AGENDA_ID_{{ $ag->id }}
                                                </span>
                                                @if(!$ag->absensi->count() && !$ag->perizinan)
                                                    <button type="button" onclick="useAgendaToken('AGENDA_ID_{{ $ag->id }}')" 
                                                            class="px-2 py-0.5 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 rounded text-[10px] font-bold uppercase transition flex items-center gap-1">
                                                        <i class="fa-solid fa-i-cursor"></i> Salin/Isi Kode Ini
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2">
                                            @if($ag->absensi->count() > 0)
                                                @if(strtolower($ag->absensi->first()->status_kehadiran) == 'hadir')
                                                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                                        <i class="fa-solid fa-circle-check"></i> Hadir
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                                        <i class="fa-solid fa-circle-check"></i> Izin (Disetujui)
                                                    </span>
                                                @endif
                                            @elseif($ag->perizinan)
                                                @if(strtolower($ag->perizinan->status_persetujuan) == 'pending')
                                                    <span class="px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-100 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                                        <i class="fa-solid fa-clock"></i> Izin (Pending)
                                                    </span>
                                                @elseif(strtolower($ag->perizinan->status_persetujuan) == 'disetujui')
                                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                                        <i class="fa-solid fa-circle-check"></i> Izin (Disetujui)
                                                    </span>
                                                @elseif(strtolower($ag->perizinan->status_persetujuan) == 'ditolak')
                                                    <span class="px-3 py-1.5 bg-rose-50 text-rose-700 border border-rose-100 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                                        <i class="fa-solid fa-circle-xmark"></i> Izin (Ditolak)
                                                    </span>
                                                @endif
                                            @else
                                                <span class="px-3 py-1.5 bg-rose-50 text-rose-700 border border-rose-100 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                                    <i class="fa-solid fa-circle-xmark"></i> Belum Absen
                                                </span>
                                                <button type="button" onclick="openIzinModal({{ $ag->id }}, '{{ $ag->mata_kuliah }}')" class="px-3 py-1.5 bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-1">
                                                    <i class="fa-solid fa-file-signature"></i> Ajukan Izin
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-400 mb-2">
                                        <i class="fa-solid fa-calendar-xmark text-lg"></i>
                                    </div>
                                    <p class="text-xs text-slate-500 font-medium">Tidak ada praktikum dijadwalkan hari ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Attendance History -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4">
                            <h3 class="font-bold text-sm text-slate-800">Riwayat Kehadiran Terakhir</h3>
                        </div>
                        <div class="p-6">
                            @if(count($absensiHistory) > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs text-left text-slate-600">
                                        <thead class="bg-slate-50 text-slate-500 font-semibold uppercase tracking-wider">
                                            <tr>
                                                <th class="p-3">Mata Kuliah / Praktikum</th>
                                                <th class="p-3">Lab / Lokasi</th>
                                                <th class="p-3">Waktu Presensi</th>
                                                <th class="p-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($absensiHistory as $h)
                                                <tr class="hover:bg-slate-50/50 transition">
                                                    <td class="p-3 font-bold text-slate-800">
                                                        {{ $h->agenda->mata_kuliah }}
                                                        <span class="block text-[10px] text-slate-400 font-normal mt-0.5">Dosen: {{ $h->agenda->dosen->nama }}</span>
                                                    </td>
                                                    <td class="p-3">{{ $h->agenda->lab->nama_lab }}</td>
                                                    <td class="p-3 text-slate-550 font-mono">{{ $h->waktu_masuk }}</td>
                                                    <td class="p-3">
                                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] font-bold rounded">
                                                            {{ $h->status_kehadiran }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-6 text-slate-400 text-xs">
                                    <i class="fa-solid fa-clock-rotate-left text-lg block mb-2"></i>
                                    Belum ada riwayat kehadiran tercatat.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Permission History -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4">
                            <h3 class="font-bold text-sm text-slate-800">Status Pengajuan Izin Anda</h3>
                        </div>
                        <div class="p-6">
                            @if(count($perizinans) > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs text-left text-slate-600">
                                        <thead class="bg-slate-50 text-slate-500 font-semibold uppercase tracking-wider">
                                            <tr>
                                                <th class="p-3">Mata Kuliah / Praktikum</th>
                                                <th class="p-3">Alasan</th>
                                                <th class="p-3">Bukti</th>
                                                <th class="p-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($perizinans as $p)
                                                <tr class="hover:bg-slate-50/50 transition">
                                                    <td class="p-3 font-bold text-slate-800">
                                                        {{ $p->agenda->mata_kuliah }}
                                                        <span class="block text-[10px] text-slate-400 font-normal mt-0.5">Dosen: {{ $p->agenda->dosen->nama }}</span>
                                                        <span class="block text-[9px] text-slate-400 font-mono">{{ date('d M Y', strtotime($p->agenda->tanggal)) }}</span>
                                                    </td>
                                                    <td class="p-3 italic">"{{ $p->alasan }}"</td>
                                                    <td class="p-3">
                                                        @if($p->bukti_url)
                                                            <a href="{{ asset($p->bukti_url) }}" target="_blank" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1">
                                                                <i class="fa-solid fa-file-pdf"></i> Bukti
                                                            </a>
                                                        @else
                                                            <span class="text-slate-400 italic">None</span>
                                                        @endif
                                                    </td>
                                                    <td class="p-3">
                                                        @if(strtolower($p->status_persetujuan) === 'pending')
                                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-100 text-[10px] font-bold rounded">PENDING</span>
                                                        @elseif(strtolower($p->status_persetujuan) === 'disetujui')
                                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] font-bold rounded">DISETUJUI</span>
                                                        @elseif(strtolower($p->status_persetujuan) === 'ditolak')
                                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 text-[10px] font-bold rounded">DITOLAK</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-6 text-slate-400 text-xs">
                                    <i class="fa-solid fa-file-signature text-lg block mb-2"></i>
                                    Belum ada pengajuan izin yang dibuat.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

        </main>
    </div>

    <!-- Modal Ajukan Izin -->
    <div id="izinModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 border border-slate-200 shadow-xl space-y-4 m-4">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-file-signature text-teal-800"></i> Ajukan Izin Praktikum
                </h3>
                <button onclick="closeIzinModal()" class="text-slate-400 hover:text-slate-650 text-lg">&times;</button>
            </div>
            
            <form action="{{ route('mahasiswa.perizinan.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" name="agenda_id" id="modal_agenda_id">
                
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Mata Kuliah / Praktikum</label>
                    <input type="text" id="modal_agenda_name" readonly class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 font-semibold focus:outline-none">
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Alasan Izin</label>
                    <textarea name="alasan" required rows="3" placeholder="Tuliskan alasan izin Anda (misal: Sakit demam, keperluan keluarga mendesak...)" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700"></textarea>
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Unggah Bukti Dokumen / Surat (Opsional)</label>
                    <input type="file" name="bukti_dokumen" accept="image/*,application/pdf" class="w-full p-2 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:ring-2 focus:ring-teal-700/30">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, PDF (Max. 2MB)</span>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" onclick="closeIzinModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-lg transition shadow-sm">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openIzinModal(agendaId, agendaName) {
            document.getElementById('modal_agenda_id').value = agendaId;
            document.getElementById('modal_agenda_name').value = agendaName;
            document.getElementById('izinModal').classList.remove('hidden');
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeIzinModal();
            }
        });

        function closeIzinModal() {
            document.getElementById('izinModal').classList.add('hidden');
        }
    </script>

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

                <!-- Fallback manual input inside modal for camera issues -->
                <div class="pt-3 border-t border-slate-100 space-y-2 text-left">
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider">
                        <i class="fa-solid fa-keyboard text-teal-800 mr-1"></i> Alternatif: Input Manual Token / ID Agenda
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="modal-manual-token-input" placeholder="Contoh: AGENDA_ID_1" 
                               class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs uppercase font-bold tracking-widest text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 focus:bg-white">
                        <button type="button" onclick="submitModalManualToken()" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold uppercase transition shadow-sm flex items-center gap-1.5 shrink-0">
                            <i class="fa-solid fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 italic">Gunakan ini jika kamera HP Anda bermasalah atau tidak dapat diakses.</p>
                </div>
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
                            document.getElementById('mahasiswa-qr-token-input').value = decodedText;
                            document.getElementById('mahasiswa-absensi-form').submit();
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
                            document.getElementById('mahasiswa-qr-token-input').value = decodedText;
                            document.getElementById('mahasiswa-absensi-form').submit();
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
                        document.getElementById('mahasiswa-qr-token-input').value = decodedText;
                        document.getElementById('mahasiswa-absensi-form').submit();
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

        function submitModalManualToken() {
            const val = document.getElementById('modal-manual-token-input').value.trim();
            if (!val) {
                alert('Silakan masukkan Kode Token / ID Agenda terlebih dahulu.');
                return;
            }
            document.getElementById('mahasiswa-qr-token-input').value = val;
            document.getElementById('mahasiswa-absensi-form').submit();
            closeScannerModal();
        }

        function useAgendaToken(token) {
            const input = document.getElementById('mahasiswa-qr-token-input');
            if (input) {
                input.value = token;
                input.focus();
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    </script>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Floating Center Scan QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-bold">Dashboard</span>
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
        <a href="{{ route('mahasiswa.riwayat') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            <span class="text-[9px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('mahasiswa.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>
</body>
</html>
