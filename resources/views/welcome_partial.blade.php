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

        <!-- Important Info Panel -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col gap-4 relative overflow-hidden">
            <!-- Header with Slide Controls -->
            <div class="flex items-center justify-between border-b-2 border-slate-200 pb-3.5">
                <div class="flex items-center gap-2.5 text-slate-900 font-extrabold text-sm tracking-wider uppercase">
                    <i class="fa-solid fa-bullhorn text-teal-700 text-base"></i>
                    <span>Informasi Penting</span>
                    @if(isset($pengumuman) && count($pengumuman) > 0)
                        <span class="ml-2 px-2.5 py-0.5 bg-teal-50 text-teal-800 text-[10px] font-extrabold rounded-full border border-teal-200">
                            {{ count($pengumuman) }} Berita
                        </span>
                    @endif
                </div>

                @if(isset($pengumuman) && count($pengumuman) > 1)
                    <!-- Controls (Prev / Next & Dots) -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1 mr-1">
                            @foreach($pengumuman as $index => $item)
                                <button type="button" onclick="goToAnnouncementSlide({{ $index }})" 
                                        id="announcement-dot-{{ $index }}"
                                        class="h-2 rounded-full transition-all duration-300 cursor-pointer {{ $index === 0 ? 'bg-slate-900 w-4' : 'bg-slate-300 w-2' }}" 
                                        title="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        <button type="button" onclick="prevAnnouncementSlide()" 
                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition cursor-pointer text-xs" title="Sebelumnya">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button type="button" onclick="nextAnnouncementSlide()" 
                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition cursor-pointer text-xs" title="Berikutnya">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Slides Container -->
            @if(isset($pengumuman) && count($pengumuman) > 0)
                @foreach($pengumuman as $index => $p)
                    @php
                        \Carbon\Carbon::setLocale('id');
                        $tglIndo = \Carbon\Carbon::parse($p->created_at)->locale('id')->isoFormat('dddd, D MMMM Y');
                    @endphp
                    <div id="announcement-slide-{{ $index }}" 
                         class="announcement-slide-item border border-slate-200 rounded-2xl p-4 flex flex-col sm:flex-row gap-4 items-start sm:items-center bg-slate-50/50 shadow-xs transition-all duration-300 {{ $index === 0 ? 'block' : 'hidden' }}">
                        
                        <!-- Photo box or UIKA Logo -->
                        <div class="w-20 h-20 md:w-28 md:h-28 bg-white border border-slate-200 rounded-xl flex items-center justify-center p-1 shrink-0 overflow-hidden shadow-xs">
                            @if($p->foto_url)
                                <img src="{{ asset('storage/' . $p->foto_url) }}" 
                                     alt="Foto Pengumuman" 
                                     class="w-full h-full object-cover rounded-lg">
                            @else
                                <img src="{{ asset('images/logo-uika.png') }}" 
                                     alt="UIKA Logo Box" 
                                     class="w-full h-full object-contain p-1">
                            @endif
                        </div>
                        
                        <!-- Content on the right -->
                        <div class="flex-grow min-w-0 space-y-1.5">
                            <div class="flex items-center gap-2">
                                @if($p->is_pinned || in_array($p->prioritas, ['Penting', 'Urgen']))
                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-800 text-[10px] font-extrabold rounded-md uppercase tracking-wider inline-flex items-center gap-1 border border-rose-200">
                                        <i class="fa-solid fa-thumbtack text-[9px]"></i> {{ $p->prioritas ?: 'PENTING' }}
                                    </span>
                                @endif
                                <span class="text-[10px] md:text-xs font-bold text-slate-400">
                                    {{ $tglIndo }}
                                </span>
                            </div>

                            <h3 class="font-extrabold text-sm md:text-base text-slate-850 leading-snug">
                                {{ $p->judul }}
                            </h3>
                            
                            <p class="text-xs md:text-sm text-slate-600 leading-relaxed whitespace-pre-line line-clamp-3">
                                {{ $p->isi_pengumuman }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty state when DB has no announcements -->
                <div class="border border-slate-200 rounded-2xl p-6 flex flex-col items-center justify-center bg-slate-50/50 shadow-xs text-center py-8">
                    <div class="w-12 h-12 bg-slate-100 border border-slate-200 rounded-full flex items-center justify-center mb-3">
                        <i class="fa-solid fa-bullhorn text-slate-400 text-lg"></i>
                    </div>
                    <h3 class="font-bold text-sm md:text-base text-slate-700">
                        Belum Ada Pengumuman Resmi
                    </h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-md">
                        Saat ini belum ada pengumuman terbaru yang diterbitkan untuk laboratorium ini.
                    </p>
                </div>
            @endif
        </div>

        <script>
            if (typeof window.announcementTotalSlides === 'undefined') {
                window.currentAnnouncementSlide = 0;
            }
            window.announcementTotalSlides = {{ isset($pengumuman) ? count($pengumuman) : 0 }};

            function showAnnouncementSlide(index) {
                if (window.announcementTotalSlides <= 0) return;
                window.currentAnnouncementSlide = (index + window.announcementTotalSlides) % window.announcementTotalSlides;

                document.querySelectorAll('.announcement-slide-item').forEach((slide, idx) => {
                    if (idx === window.currentAnnouncementSlide) {
                        slide.classList.remove('hidden');
                        slide.classList.add('block');
                    } else {
                        slide.classList.remove('block');
                        slide.classList.add('hidden');
                    }
                });

                for (let i = 0; i < window.announcementTotalSlides; i++) {
                    const dot = document.getElementById('announcement-dot-' + i);
                    if (dot) {
                        if (i === window.currentAnnouncementSlide) {
                            dot.className = "h-2 rounded-full transition-all duration-300 cursor-pointer bg-slate-900 w-4";
                        } else {
                            dot.className = "h-2 rounded-full transition-all duration-300 cursor-pointer bg-slate-300 w-2";
                        }
                    }
                }
            }

            function nextAnnouncementSlide() {
                showAnnouncementSlide(window.currentAnnouncementSlide + 1);
            }

            function prevAnnouncementSlide() {
                showAnnouncementSlide(window.currentAnnouncementSlide - 1);
            }

            function goToAnnouncementSlide(index) {
                showAnnouncementSlide(index);
            }

            if (window.announcementInterval) {
                clearInterval(window.announcementInterval);
            }

            if (window.announcementTotalSlides > 1) {
                window.announcementInterval = setInterval(() => {
                    nextAnnouncementSlide();
                }, 6000);
            }
        </script>

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
                                @if($activeAgenda && $activeAgenda->jam_mulai > $currentTime)
                                    QR Code presensi akan terbuka otomatis 15 menit sebelum jam kuliah dimulai (<strong>{{ substr($activeAgenda->jam_mulai, 0, 5) }} WIB</strong>).
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
                    @elseif($activeAgenda && $activeAgenda->jam_mulai > $currentTime)
                        Sesi Berikutnya: {{ substr($activeAgenda->jam_mulai, 0, 5) }} - {{ substr($activeAgenda->jam_selesai, 0, 5) }} WIB
                    @else
                        Belum Ada Agenda Aktif
                    @endif
                </span>
            </div>
        </div>

        <!-- Tata Tertib Ruangan Card -->
        <div class="bg-white border border-slate-200/90 rounded-3xl overflow-hidden shadow-sm flex flex-col">
            <!-- Banner Header (Dynamic Theme Color matching Admin Lab RGB) -->
            <div class="px-5 py-3.5 border-b border-slate-800 flex items-center gap-2.5 text-white transition-all duration-500" style="background: linear-gradient(135deg, {{ $themeColor }} 0%, #090d16 100%);">
                <i class="fa-solid fa-list-check text-teal-400 text-base"></i>
                <span class="font-extrabold text-white text-xs uppercase tracking-wider">Tata Tertib Ruangan</span>
            </div>

            <!-- Rules List -->
            <div class="p-6 bg-white flex flex-col gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                        <i class="fa-solid fa-ban text-rose-600 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Wajib menjaga kebersihan dan ketertiban selama berada di laboratorium.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-teal-50 border border-teal-100 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                        <i class="fa-solid fa-desktop text-teal-700 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Gunakan komputer sesuai absen.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                        <i class="fa-solid fa-power-off text-amber-600 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Matikan komputer & rapikan kursi.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                        <i class="fa-solid fa-burger text-rose-500 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Dilarang membawa makanan dan minuman ke dalam laboratorium.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                        <i class="fa-solid fa-shield-halved text-emerald-600 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Gunakan komputer dan fasilitas laboratorium dengan baik dan bertanggung jawab.
                    </p>
                </div>
            </div>
        </div>

    </div>

</main>
