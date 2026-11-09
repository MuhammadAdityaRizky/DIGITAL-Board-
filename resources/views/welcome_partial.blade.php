@php
    // Current time
    $currentTime = now()->format('H:i:s');
    
    // 1. Current Running Agenda (strictly between start and end time today and MUST have status Berlangsung)
    $runningAgenda = $agendas->first(function($agenda) use ($currentTime) {
        return $currentTime >= $agenda->jam_mulai 
            && $currentTime <= $agenda->jam_selesai 
            && $agenda->status_agenda === 'Berlangsung';
    });
    
    // 2. Active display agenda for main card: use running agenda ONLY if running
    $activeAgenda = $runningAgenda;
    
    // 3. Next upcoming agenda today (not Selesai / Dibatalkan)
    $nextAgenda = $agendas->first(function($agenda) use ($currentTime) {
        return $agenda->jam_mulai > $currentTime 
            && $agenda->status_agenda !== 'Dibatalkan'
            && $agenda->status_agenda !== 'Selesai';
    });

    if ($activeAgenda) {
        $nextAgenda = $agendas->first(function($agenda) use ($activeAgenda, $currentTime) {
            return $agenda->id !== $activeAgenda->id 
                && $agenda->jam_mulai >= $activeAgenda->jam_selesai 
                && $agenda->status_agenda !== 'Dibatalkan'
                && $agenda->status_agenda !== 'Selesai';
        });
    }

    // 4. QR Agenda: ONLY active when class is currently RUNNING and NOT Selesai, or within 15 minutes before next start time!
    $qrAgenda = $runningAgenda;
    $isQrActive = false;

    if ($qrAgenda && $qrAgenda->status_agenda === 'Berlangsung') {
        $isQrActive = true;
    } else {
        // Check if there is an agenda starting within 15 minutes (buffer window)
        $upcomingBuffer = $agendas->first(function($agenda) use ($currentTime) {
            if ($agenda->status_agenda === 'Dibatalkan' || $agenda->status_agenda === 'Selesai') return false;
            $diffInSec = strtotime($agenda->jam_mulai) - strtotime($currentTime);
            return $diffInSec > 0 && $diffInSec <= 900; // <= 15 minutes (900 seconds)
        });
        if ($upcomingBuffer) {
            $qrAgenda = $upcomingBuffer;
            $isQrActive = true;
        }
    }
    
    // Get latest announcement
    $latestAnnouncement = $pengumuman->first();
    
    // Dynamic Theme Color
    $themeColor = $activeLab->warna_theme ?? '#0f172a';
@endphp

<!-- Main Board Grid -->
<main class="flex-grow grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <!-- Left & Center columns: Class Schedules & Announcements -->
    <div class="xl:col-span-2 flex flex-col gap-6">
        
        <!-- Agenda Panel -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col gap-5">
            <!-- Header -->
            <div class="flex justify-between items-center border-b-2 border-slate-200 pb-3.5 mb-1">
                <div class="flex items-center gap-2.5 text-slate-900 font-extrabold text-sm tracking-wider uppercase">
                    <i class="fa-solid fa-calendar-days text-teal-700 text-base"></i>
                    <span>Agenda {{ $activeLab->nama_lab }}</span>
                    @if($activeLab->fakultas)
                        <span class="text-[11px] font-semibold text-slate-400 normal-case tracking-normal">({{ $activeLab->fakultas->nama_fakultas }})</span>
                    @endif
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-600 text-white rounded-full text-[10px] font-bold uppercase tracking-wider shadow-xs">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
                    <span>Live</span>
                </div>
            </div>

            <!-- Schedule Content -->
            <div class="flex flex-col gap-5">
                <!-- Current Class (Sedang Berlangsung) -->
                @if($activeAgenda)
                    <div class="border-l-4 border-slate-900 bg-slate-50/80 border border-slate-200/90 rounded-2xl p-4 md:p-5 space-y-3 shadow-2xs">
                        <div class="flex justify-between items-center pb-1 border-b border-slate-200/60">
                            <span class="text-[11px] font-extrabold text-teal-800 tracking-wider uppercase">Mata Kuliah Saat Ini</span>
                            <span class="text-xs font-bold text-slate-700 bg-white border border-slate-200 px-2.5 py-0.5 rounded-md shadow-2xs">{{ substr($activeAgenda->jam_mulai, 0, 5) }} - {{ substr($activeAgenda->jam_selesai, 0, 5) }} WIB</span>
                        </div>
                        <div>
                            @if($activeAgenda->status_agenda === 'Berlangsung')
                                <span class="inline-block px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-200 rounded-md text-[11px] font-extrabold uppercase tracking-wide animate-pulse">
                                    Sedang Berlangsung
                                </span>
                            @elseif($activeAgenda->status_agenda === 'Dibatalkan')
                                <span class="inline-block px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-md text-[11px] font-extrabold uppercase tracking-wide">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-md text-[11px] font-extrabold uppercase tracking-wide">
                                    Akan Datang
                                </span>
                            @endif
                        </div>
                        <h2 class="text-xl md:text-2xl font-extrabold text-slate-850 leading-tight">
                            {{ $activeAgenda->mata_kuliah }}
                        </h2>
                        <div class="border-t border-slate-200/80 pt-3 mt-3 text-xs text-slate-600 font-semibold space-y-1.5">
                            <div>{{ $activeAgenda->lab->nama_lab }} • Dosen Mengajar: {{ $activeAgenda->dosen->nama ?? '-' }} • Dosen Pengampu: {{ $activeAgenda->dosenPengampu->nama ?? $activeAgenda->dosen->nama ?? '-' }}</div>
                            <div>Fakultas: {{ $activeAgenda->fakultas }} • Prodi: {{ $activeAgenda->jurusan }}</div>
                            <div>Program: {{ $activeAgenda->program_kuliah ?? 'Reguler' }} {{ $activeAgenda->tahun_ajaran }} • Tipe: {{ $activeAgenda->jenis_pertemuan ?? 'Praktikum' }} • Semester: {{ $activeAgenda->semester ?? '1' }} • Kelas: {{ $activeAgenda->kelas ?? 'A' }}</div>
                            <div class="flex items-center gap-1.5 pt-1.5 border-t border-slate-200/50 mt-2">
                                <span class="text-slate-400">Kehadiran Dosen:</span>
                                @if($activeAgenda->dosen_waktu_masuk)
                                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">
                                        <i class="fa-solid fa-circle-check text-emerald-600 mr-0.5"></i> Hadir ({{ date('H:i', strtotime($activeAgenda->dosen_waktu_masuk)) }} WIB)
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded font-bold text-[10px] animate-pulse">
                                        <i class="fa-solid fa-circle-xmark text-rose-600 mr-0.5"></i> Belum Check-in
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border-l-4 border-slate-900 p-5 bg-slate-50/80 border border-slate-200/90 rounded-2xl text-center shadow-2xs">
                        <i class="fa-solid fa-desktop text-2xl text-slate-300 block mb-2"></i>
                        <p class="text-sm font-bold text-slate-500">Tidak ada agenda kuliah sedang berlangsung saat ini.</p>
                    </div>
                @endif

                <!-- Garis Pemisah (Divider) -->
                <div class="relative flex items-center my-1">
                    <div class="flex-grow border-t-2 border-slate-200"></div>
                    <span class="shrink-0 mx-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">Agenda Selanjutnya</span>
                    <div class="flex-grow border-t-2 border-slate-200"></div>
                </div>

                <!-- Next Class (Mata Kuliah Berikutnya) -->
                @if($nextAgenda)
                    <div class="border-l-4 border-teal-700 bg-slate-50/80 border border-slate-200/90 rounded-2xl p-4 md:p-5 space-y-3 shadow-2xs">
                        <div class="flex justify-between items-center pb-1 border-b border-slate-200/60">
                            <span class="text-[11px] font-extrabold text-teal-800 tracking-wider uppercase">Mata Kuliah Berikutnya</span>
                            <span class="text-xs font-bold text-slate-700 bg-white border border-slate-200 px-2.5 py-0.5 rounded-md shadow-2xs">{{ substr($nextAgenda->jam_mulai, 0, 5) }} - {{ substr($nextAgenda->jam_selesai, 0, 5) }} WIB</span>
                        </div>
                        <div>
                            @if($nextAgenda->status_agenda === 'Berlangsung')
                                <span class="inline-block px-2.5 py-1 bg-teal-50 text-teal-800 border border-teal-200 rounded-md text-[11px] font-extrabold uppercase tracking-wide animate-pulse">
                                    Sedang Berlangsung
                                </span>
                            @elseif($nextAgenda->status_agenda === 'Dibatalkan')
                                <span class="inline-block px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-md text-[11px] font-extrabold uppercase tracking-wide">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-md text-[11px] font-extrabold uppercase tracking-wide">
                                    Kelas Selanjutnya
                                </span>
                            @endif
                        </div>
                        <h2 class="text-xl md:text-2xl font-extrabold text-slate-850 leading-tight">
                            {{ $nextAgenda->mata_kuliah }}
                        </h2>
                        <div class="border-t border-slate-200/80 pt-3 mt-3 text-xs text-slate-600 font-semibold space-y-1.5">
                            <div>{{ $nextAgenda->lab->nama_lab }} • Dosen Mengajar: {{ $nextAgenda->dosen->nama ?? '-' }} • Dosen Pengampu: {{ $nextAgenda->dosenPengampu->nama ?? $nextAgenda->dosen->nama ?? '-' }}</div>
                            <div>Fakultas: {{ $nextAgenda->fakultas }} • Prodi: {{ $nextAgenda->jurusan }}</div>
                            <div>Program: {{ $nextAgenda->program_kuliah ?? 'Reguler' }} {{ $nextAgenda->tahun_ajaran }} • Semester: {{ $nextAgenda->semester ?? '1' }} • Kelas: {{ $nextAgenda->kelas ?? 'A' }}</div>
                            <div class="flex items-center gap-1.5 pt-1.5 border-t border-slate-200/50 mt-2">
                                <span class="text-slate-400">Kehadiran Dosen:</span>
                                @if($nextAgenda->dosen_waktu_masuk)
                                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">
                                        <i class="fa-solid fa-circle-check text-emerald-600 mr-0.5"></i> Hadir ({{ date('H:i', strtotime($nextAgenda->dosen_waktu_masuk)) }} WIB)
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded font-bold text-[10px]">
                                        <i class="fa-solid fa-circle-xmark text-rose-600 mr-0.5"></i> Belum Check-in
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border-l-4 border-teal-700 p-4 bg-slate-50/80 border border-slate-200/90 rounded-2xl text-center shadow-2xs">
                        <i class="fa-solid fa-calendar-check text-2xl text-slate-300 block mb-2"></i>
                        <p class="text-sm font-bold text-slate-500">Tidak ada agenda kuliah berikutnya untuk hari ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Important Info Panel (Compact Clean Strip - TV Standard) -->
        <div class="bg-white border border-slate-200/90 rounded-3xl p-5 shadow-sm flex flex-col gap-3 relative overflow-hidden">
            <!-- Header Row -->
            <div class="flex items-center justify-between pb-1">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-teal-600 text-sm"></i>
                    <span class="font-extrabold text-slate-800 text-xs sm:text-sm tracking-wide">INFORMASI PENTING</span>
                    @if(isset($pengumuman) && count($pengumuman) > 0)
                        <span class="px-2.5 py-0.5 bg-teal-50 text-teal-700 text-[10px] font-black rounded-full border border-teal-200/80">
                            {{ count($pengumuman) }} Berita
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-2.5">
                    @if(isset($pengumuman) && count($pengumuman) > 1)
                        <!-- Multi-slide Controls & Dots -->
                        <div class="flex items-center gap-1.5 mr-1">
                            @foreach($pengumuman as $index => $item)
                                <button type="button" onclick="goToAnnouncementSlide({{ $index }})" 
                                        id="announcement-dot-{{ $index }}"
                                        class="h-1.5 rounded-full transition-all duration-300 cursor-pointer {{ $index === 0 ? 'bg-slate-900 w-3.5' : 'bg-slate-300 w-1.5' }}" 
                                        title="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                    <span class="text-xs text-slate-400 font-bold">
                        Update {{ $activeLab->nama_lab ?? 'Lab' }}
                    </span>
                </div>
            </div>

            <!-- Slides Container (Compact Clean Strip) -->
            @if(isset($pengumuman) && count($pengumuman) > 0)
                @foreach($pengumuman as $index => $p)
                    @php
                        \Carbon\Carbon::setLocale('id');
                        $tglIndo = \Carbon\Carbon::parse($p->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
                        
                        // Badge Tag Style
                        $isDanger = in_array(strtolower($p->prioritas ?? ''), ['penting', 'urgen', 'wajib']) || $p->is_pinned;
                        $badgeLabel = $p->is_pinned ? 'WAJIB' : strtoupper($p->prioritas ?: 'INFO');
                    @endphp
                    <div id="announcement-slide-{{ $index }}" 
                         class="announcement-slide-item border border-slate-200/90 rounded-2xl p-3 sm:p-3.5 items-center gap-4 bg-slate-50/40 hover:bg-slate-50 transition shadow-2xs {{ $index === 0 ? 'flex' : 'hidden' }}">
                        
                        <!-- 1. Thumbnail Image (Anti-Crop: 100% Utuh & Proporsional) -->
                        <div class="w-20 h-20 sm:w-24 sm:h-20 rounded-xl overflow-hidden relative shrink-0 shadow-2xs border border-slate-200/90 bg-slate-950 flex items-center justify-center group cursor-pointer" 
                             @if($p->foto_url) onclick="openPosterModal('{{ asset('storage/' . $p->foto_url) }}', '{{ addslashes($p->judul) }}')" title="Klik untuk lihat poster penuh" @endif>
                            @if($p->foto_url)
                                <!-- Ambient Blurred Backdrop (Mencegah ruang kosong terlihat kaku) -->
                                <img src="{{ asset('storage/' . $p->foto_url) }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-md opacity-40 scale-125">
                                
                                <!-- Foto Utama 100% Utuh (object-contain: TIDAK TERPOTONG) -->
                                <img src="{{ asset('storage/' . $p->foto_url) }}" 
                                     alt="{{ $p->judul }}" 
                                     class="relative z-10 max-w-full max-h-full object-contain p-0.5 drop-shadow-md transition-transform duration-300 group-hover:scale-105">
                                
                                <!-- Hover Zoom Icon -->
                                <div class="absolute inset-0 z-20 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <i class="fa-solid fa-magnifying-glass-plus text-white text-xs drop-shadow-md"></i>
                                </div>
                            @else
                                <div class="w-full h-full bg-linear-to-br from-teal-800 to-slate-900 flex flex-col items-center justify-center p-1.5">
                                    <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-7 h-7 object-contain opacity-90 drop-shadow-xs">
                                </div>
                            @endif
                            <span class="absolute bottom-1 left-1.5 z-20 px-1.5 py-0.2 bg-black/60 backdrop-blur-xs text-white text-[8px] font-bold rounded">
                                Poster Lab
                            </span>
                        </div>

                        <!-- 2. Center Content (Meta, Title, Excerpt) -->
                        <div class="flex-1 min-w-0">
                            <!-- Meta Tag & Date -->
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 {{ $isDanger ? 'bg-rose-50 text-rose-600 border-rose-200/80' : 'bg-teal-50 text-teal-700 border-teal-200/80' }} text-[9.5px] font-black rounded border uppercase tracking-wider">
                                    {{ $badgeLabel }}
                                </span>
                                <span class="text-[11px] font-semibold text-slate-400">
                                    {{ $tglIndo }}
                                </span>
                            </div>

                            <!-- Headline / Judul -->
                            <h3 class="font-extrabold text-xs sm:text-[13.5px] text-slate-900 truncate leading-snug tracking-tight mt-1" title="{{ $p->judul }}">
                                {{ $p->judul }}
                            </h3>

                            <!-- Excerpt / Deskripsi Singkat -->
                            <p class="text-[11.5px] text-slate-500 truncate leading-normal mt-0.5">
                                {{ Str::limit(strip_tags($p->isi_pengumuman), 95) }}
                            </p>
                        </div>

                        <!-- 3. Publisher & Sesi Status (Right Column with Divider) -->
                        <div class="border-l border-slate-200/80 pl-4 sm:pl-6 shrink-0 flex flex-col items-end justify-center text-right">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                DITERBITKAN OLEH
                            </span>
                            <p class="font-black text-xs sm:text-[12.5px] text-slate-800 mt-0.5">
                                {{ $activeLab->nama_lab ?? 'Lab' }} {{ $activeLab->fakultas->singkatan ?? 'FTS UIKA' }}
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-[10.5px] font-extrabold text-teal-600 mt-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span> Sesi Aktif
                            </span>
                        </div>

                    </div>
                @endforeach
            @else
                <!-- Empty state when DB has no announcements -->
                <div class="border border-slate-200/90 rounded-2xl p-4 flex items-center justify-between gap-4 bg-slate-50/40">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 bg-slate-100 border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 shrink-0">
                            <i class="fa-solid fa-bullhorn text-sm"></i>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-xs sm:text-sm text-slate-700">Belum Ada Pengumuman Resmi</h4>
                            <p class="text-[11px] text-slate-400">Saat ini belum ada pengumuman terbaru yang diterbitkan untuk laboratorium ini.</p>
                        </div>
                    </div>
                    <div class="border-l border-slate-200/80 pl-4 shrink-0 flex flex-col items-end justify-center text-right">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">STATUS LAB</span>
                        <p class="font-bold text-xs text-slate-700 mt-0.5">{{ $activeLab->nama_lab ?? 'Lab' }} UIKA</p>
                        <span class="inline-flex items-center gap-1.5 text-[10.5px] font-bold text-emerald-600 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Siaga
                        </span>
                    </div>
                </div>
            @endif
        </div>


    </div>

    <!-- Right column: QR Access Code & Room Regulations -->
    <div class="flex flex-col gap-6">
        
        <!-- Scan QR Card -->
        <div class="bg-white border border-slate-200/90 rounded-3xl overflow-hidden shadow-sm flex flex-col">
            <!-- Banner Header (Dynamic Theme Color matching Admin Lab RGB) -->
            <div class="px-5 py-3.5 border-b border-slate-800 flex items-center justify-between text-white transition-all duration-500" style="background: linear-gradient(135deg, {{ $themeColor }} 0%, #090d16 100%);">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-qrcode text-teal-400 text-base"></i>
                    <span class="font-extrabold text-white text-xs uppercase tracking-wider">Scan untuk Akses Presensi</span>
                </div>
                @if($isQrActive && $qrAgenda && $qrAgenda->id)
                    <span class="inline-flex items-center gap-1 text-[9px] font-extrabold text-teal-300 bg-teal-950/80 px-2.5 py-0.5 rounded-full border border-teal-500/40 uppercase tracking-wider">
                        <i class="fa-solid fa-arrows-rotate text-[8px] animate-spin text-teal-400"></i> 5s Dynamic
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-[9px] font-extrabold text-slate-400 bg-slate-800 px-2.5 py-0.5 rounded-full border border-slate-700 uppercase tracking-wider">
                        <i class="fa-solid fa-lock text-[8px]"></i> QR Belum Aktif
                    </span>
                @endif
            </div>

            <!-- QR Center Body -->
            <div class="flex-grow flex flex-col items-center justify-center py-8 px-6 bg-white">
                @if($isQrActive && $qrAgenda && $qrAgenda->id)
                    @php
                        $dynamicQrToken = \App\Models\Agenda::generateDynamicQrToken($qrAgenda->id);
                    @endphp

                    <!-- QR Container -->
                    <div class="p-3 bg-white shrink-0 mb-3 flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode($dynamicQrToken) }}" 
                             alt="Presensi QR Code" 
                             class="w-48 h-48 md:w-56 md:h-56 object-contain drop-shadow-sm">
                    </div>

                    <div class="text-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 w-full max-w-[240px] shadow-2xs">
                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider">KODE PRESENSI MANUAL (5s REFRESH)</p>
                        <p class="text-xs font-extrabold text-slate-800 tracking-widest font-mono mt-0.5 select-all">{{ $dynamicQrToken }}</p>
                    </div>
                    <div class="mt-2 flex items-center justify-center gap-1.5 text-[10px] font-bold text-teal-800 bg-teal-50 px-3 py-1 rounded-full border border-teal-200">
                        <i class="fa-solid fa-shield-halved text-[9px] text-teal-600"></i>
                        <span>Dynamic Anti-Cheat (Refresh 5dtk)</span>
                    </div>
                @else
                    <!-- Inactive / Lock State -->
                    <div class="flex flex-col items-center justify-center text-center p-6 space-y-3 my-2">
                        <div class="w-20 h-20 rounded-full bg-slate-50 border-2 border-slate-200 flex items-center justify-center text-slate-300 shadow-inner">
                            <i class="fa-solid fa-lock text-3xl text-slate-400"></i>
                        </div>
                        <div class="space-y-1 max-w-[245px]">
                            <h4 class="font-extrabold text-xs text-slate-700 uppercase tracking-wide">QR Presensi Belum Aktif</h4>
                            <p class="text-[11px] text-slate-500 leading-normal font-medium">
                                @if($nextAgenda)
                                    QR Code presensi akan terbuka otomatis 15 menit sebelum jam kuliah dimulai (<strong>{{ substr($nextAgenda->jam_mulai, 0, 5) }} WIB</strong>).
                                @else
                                    Saat ini belum ada sesi perkuliahan aktif di laboratorium ini.
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Banner Footer -->
            <div class="py-3.5 px-5 text-center border-t border-slate-800 w-full transition-all duration-500" style="background: linear-gradient(135deg, {{ $themeColor }} 0%, #090d16 100%);">
                <span class="text-teal-300 font-extrabold text-xs uppercase tracking-wider">
                    @if($isQrActive && $qrAgenda)
                        Berlaku s.d. {{ substr($qrAgenda->jam_selesai, 0, 5) }} WIB
                    @elseif($nextAgenda)
                        Sesi Berikutnya: {{ substr($nextAgenda->jam_mulai, 0, 5) }} - {{ substr($nextAgenda->jam_selesai, 0, 5) }} WIB
                    @else
                        Belum Ada Agenda Aktif
                    @endif
                </span>
            </div>
        </div>

        <!-- Tata Tertib Ruangan Card -->
        <div class="bg-white border border-slate-200/90 rounded-3xl overflow-hidden shadow-sm flex flex-col">
            <!-- Banner Header (Dynamic Theme Color matching Admin Lab RGB) -->
            <div class="px-5 py-3.5 border-b border-slate-800 flex items-center justify-between text-white transition-all duration-500" style="background: linear-gradient(135deg, {{ $themeColor }} 0%, #090d16 100%);">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-list-check text-teal-400 text-base"></i>
                    <span class="font-extrabold text-white text-xs uppercase tracking-wider">Tata Tertib Ruangan</span>
                </div>
                <span class="text-[10px] font-bold text-slate-300 bg-white/10 px-2.5 py-0.5 rounded-full border border-white/10 uppercase tracking-wide">
                    {{ $activeLab->nama_lab ?? 'Lab' }}
                </span>
            </div>

            <!-- 3 Poin Aturan Utama (Format Card Icon Elegan) -->
            <div class="p-5 sm:p-6 flex flex-col gap-3.5">
                
                <!-- Card 1: Dilarang Makan & Minum -->
                <div class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-rose-50/60 border border-rose-100 hover:border-rose-200 transition shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 border border-rose-200/80 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-ban text-rose-600 text-base"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-[13px] font-extrabold text-slate-800 leading-snug">
                            Dilarang makan & minum di dalam lab.
                        </p>
                        <p class="text-[10.5px] font-semibold text-rose-600/90 mt-0.5">
                            Menjaga kebersihan & mencegah tumpahan pada perangkat elektronik.
                        </p>
                    </div>
                </div>

                <!-- Card 2: Jaga & Jangan Merusak Perangkat -->
                <div class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-teal-50/60 border border-teal-100 hover:border-teal-200 transition shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 border border-teal-200/80 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-shield-halved text-teal-700 text-base"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-[13px] font-extrabold text-slate-800 leading-snug">
                            Jaga dan dilarang merusak perangkat/fasilitas lab.
                        </p>
                        <p class="text-[10.5px] font-semibold text-teal-700/90 mt-0.5">
                            Gunakan komputer dan peralatan fasilitas dengan baik & bertanggung jawab.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Matikan PC & Rapikan Kursi -->
                <div class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-amber-50/60 border border-amber-100 hover:border-amber-200 transition shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 border border-amber-200/80 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="fa-solid fa-power-off text-amber-700 text-base"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-[13px] font-extrabold text-slate-800 leading-snug">
                            Matikan PC & rapikan kursi sebelum keluar.
                        </p>
                        <p class="text-[10.5px] font-semibold text-amber-700/90 mt-0.5">
                            Pastikan komputer shutdown normal dan posisi meja kursi kembali rapi.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>

</main>
