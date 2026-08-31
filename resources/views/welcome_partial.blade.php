@php
    // Find active agenda (current time falls between start and end time today)
    $currentTime = now()->format('H:i:s');
    
    $activeAgenda = $agendas->first(function($agenda) use ($currentTime) {
        return $currentTime >= $agenda->jam_mulai && $currentTime <= $agenda->jam_selesai;
    });
    
    // If no agenda is currently active, find the next upcoming one as the main active display
    if (!$activeAgenda) {
        $activeAgenda = $agendas->first(function($agenda) use ($currentTime) {
            return $agenda->jam_mulai > $currentTime;
        });
    }
    
    // Get next agenda after the active agenda
    $nextAgenda = null;
    if ($activeAgenda) {
        $nextAgenda = $agendas->first(function($agenda) use ($activeAgenda, $currentTime) {
            return $agenda->jam_mulai > $activeAgenda->jam_mulai && $agenda->jam_mulai > $currentTime;
        });
    }
    
    // Get latest announcement
    $latestAnnouncement = $pengumuman->first();
@endphp

<!-- Main Board Grid -->
<main class="flex-grow grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <!-- Left & Center columns: Class Schedules & Announcements -->
    <div class="xl:col-span-2 flex flex-col gap-6">
        
        <!-- Agenda Panel -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col gap-5">
            <!-- Header -->
            <div class="flex justify-between items-center border-b border-slate-150 pb-3">
                <div class="flex items-center gap-2 text-[#0b8a5a] font-bold text-sm tracking-wider uppercase">
                    <i class="fa-solid fa-calendar-days text-base"></i>
                    <span>Agenda {{ $activeLab->nama_lab }}</span>
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#00b87c] text-white rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-ping"></span>
                    <span>Live</span>
                </div>
            </div>

            <!-- Schedule Content -->
            <div class="flex flex-col gap-6">
                <!-- Current Class (Sedang Berlangsung) -->
                @if($activeAgenda)
                    <div class="border-l-4 border-[#0c4ea6] pl-5 py-1 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-extrabold text-slate-400 tracking-wider uppercase">Mata Kuliah Saat Ini</span>
                            <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">{{ substr($activeAgenda->jam_mulai, 0, 5) }}-{{ substr($activeAgenda->jam_selesai, 0, 5) }}</span>
                        </div>
                        <div>
                            @if($activeAgenda->status_agenda === 'Berlangsung')
                                <span class="inline-block px-2.5 py-1 bg-[#e0effe] text-[#1d4ed8] rounded-md text-[11px] font-extrabold uppercase tracking-wide animate-pulse">
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
                        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 leading-tight">
                            {{ $activeAgenda->mata_kuliah }}
                        </h2>
                        <div class="text-xs text-slate-500 font-semibold space-y-1">
                            <div>{{ $activeAgenda->lab->nama_lab }} • {{ $activeAgenda->dosen->nama }}</div>
                            <div>Fakultas: {{ $activeAgenda->fakultas }} • Prodi: {{ $activeAgenda->jurusan }}</div>
                            <div>Semester {{ $activeAgenda->semester ?? '1' }} • Kelas: {{ $activeAgenda->kelas ?? 'A' }}</div>
                            <div class="flex items-center gap-1.5 pt-1.5">
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
                    <div class="border-l-4 border-[#0c4ea6] pl-5 py-4 bg-slate-50 rounded-r-2xl text-center">
                        <i class="fa-solid fa-desktop text-2xl text-slate-300 block mb-2"></i>
                        <p class="text-sm font-bold text-slate-500">Tidak ada agenda kuliah sedang berlangsung saat ini.</p>
                    </div>
                @endif

                <div class="h-px bg-slate-150"></div>

                <!-- Next Class (Mata Kuliah Berikutnya) -->
                @if($nextAgenda)
                    <div class="border-l-4 border-[#00b87c] pl-5 py-1 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-extrabold text-slate-400 tracking-wider uppercase">Mata Kuliah Berikutnya</span>
                            <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">{{ substr($nextAgenda->jam_mulai, 0, 5) }} - {{ substr($nextAgenda->jam_selesai, 0, 5) }}</span>
                        </div>
                        <div>
                            @if($nextAgenda->status_agenda === 'Berlangsung')
                                <span class="inline-block px-2.5 py-1 bg-[#e0effe] text-[#1d4ed8] rounded-md text-[11px] font-extrabold uppercase tracking-wide animate-pulse">
                                    Sedang Berlangsung
                                </span>
                            @elseif($nextAgenda->status_agenda === 'Dibatalkan')
                                <span class="inline-block px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-md text-[11px] font-extrabold uppercase tracking-wide">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-1 bg-[#f1f5f9] text-[#475569] rounded-md text-[11px] font-extrabold uppercase tracking-wide">
                                    Kelas Selanjutnya
                                </span>
                            @endif
                        </div>
                        <h2 class="text-xl md:text-2xl font-extrabold text-slate-800 leading-tight">
                            {{ $nextAgenda->mata_kuliah }}
                        </h2>
                         <div class="text-xs text-slate-500 font-semibold space-y-1">
                            <div>{{ $nextAgenda->lab->nama_lab }} • {{ $nextAgenda->dosen->nama }}</div>
                            <div>Fakultas: {{ $nextAgenda->fakultas }} • Prodi: {{ $nextAgenda->jurusan }}</div>
                            <div>Semester {{ $nextAgenda->semester ?? '1' }} • Kelas: {{ $nextAgenda->kelas ?? 'A' }}</div>
                            <div class="flex items-center gap-1.5 pt-1.5">
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
                    <div class="border-l-4 border-[#00b87c] pl-5 py-4 bg-slate-50 rounded-r-2xl text-center">
                        <i class="fa-solid fa-calendar-check text-2xl text-slate-300 block mb-2"></i>
                        <p class="text-sm font-bold text-slate-500">Tidak ada agenda kuliah berikutnya untuk hari ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Important Info Panel -->
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col gap-4">
            <!-- Header -->
            <div class="flex items-center gap-2 text-slate-800 font-bold text-sm tracking-wider uppercase border-b border-slate-150 pb-3">
                <i class="fa-solid fa-bullhorn text-[#0c4ea6] text-base"></i>
                <span>Informasi Penting</span>
            </div>

            <!-- Info Box -->
            <div class="border border-slate-200 rounded-2xl p-4 flex gap-4 items-start md:items-center bg-white shadow-sm">
                <!-- UIKA Logo box on the left -->
                <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center p-2 shrink-0">
                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                         alt="UIKA Logo Box" 
                         class="w-full h-full object-contain">
                </div>
                
                <!-- Content on the right -->
                <div class="flex-grow">
                    @if($latestAnnouncement)
                        <h3 class="font-extrabold text-sm md:text-base text-slate-850">
                            {{ $latestAnnouncement->judul }}
                        </h3>
                        <p class="text-[10px] md:text-xs font-bold text-slate-400 mt-0.5">
                            {{ \Carbon\Carbon::parse($latestAnnouncement->created_at)->isoFormat('dddd, D MMMM Y') }}
                        </p>
                        <p class="text-xs md:text-sm text-slate-600 mt-2 leading-relaxed">
                            {{ $latestAnnouncement->isi_pengumuman }}
                        </p>
                    @else
                        <h3 class="font-extrabold text-sm md:text-base text-slate-855">
                            Jadwal Ujian Tengah Semester
                        </h3>
                        <p class="text-[10px] md:text-xs font-bold text-slate-400 mt-0.5">
                            Senin, 17 Agustus 2026
                        </p>
                        <p class="text-xs md:text-sm text-slate-600 mt-2 leading-relaxed">
                            Pelaksanaan UTS ganjil akan dimulai pada minggu pertama bulan ini. Mohon persiapkan berkas pendaftaran Anda.
                        </p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Right column: QR Access Code & Room Regulations -->
    <div class="flex flex-col gap-6">
        
        <!-- Scan QR Card -->
        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm flex flex-col">
            <!-- Banner Header -->
            <div class="bg-[#ebf3fc] px-5 py-3.5 border-b border-slate-150 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-qrcode text-[#0c4ea6] text-base"></i>
                    <span class="font-extrabold text-[#0c4ea6] text-xs uppercase tracking-wider">Scan untuk Akses Presensi</span>
                </div>
                @if($activeAgenda && $activeAgenda->id)
                    <span class="inline-flex items-center gap-1 text-[9px] font-extrabold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full border border-emerald-200 uppercase">
                        <i class="fa-solid fa-arrows-rotate text-[8px] animate-spin"></i> 5s Dynamic
                    </span>
                @endif
            </div>

            <!-- QR Center Body -->
            <div class="flex-grow flex flex-col items-center justify-center py-8 px-6 bg-white">
                @php
                    $dynamicQrToken = ($activeAgenda && $activeAgenda->id) 
                        ? \App\Models\Agenda::generateDynamicQrToken($activeAgenda->id) 
                        : 'NO_ACTIVE_AGENDA';
                @endphp

                <!-- QR Container -->
                <div class="p-3 bg-white shrink-0 mb-3 flex items-center justify-center">
                    <!-- QR Image -->
                    @if($activeAgenda && $activeAgenda->id)
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode($dynamicQrToken) }}" 
                             alt="Presensi QR Code" 
                             class="w-48 h-48 md:w-56 md:h-56 object-contain drop-shadow-sm">
                    @else
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=NO_ACTIVE_AGENDA" 
                             alt="Fallback QR Code" 
                             class="w-48 h-48 md:w-56 md:h-56 object-contain opacity-35">
                    @endif
                </div>

                @if($activeAgenda && $activeAgenda->id)
                    <div class="text-center bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 w-full max-w-[240px] shadow-sm">
                        <p class="text-[9px] font-extrabold text-slate-500 uppercase tracking-wider">KODE PRESENSI MANUAL (5s REFRESH)</p>
                        <p class="text-xs font-extrabold text-teal-850 tracking-widest font-mono mt-0.5 select-all">{{ $dynamicQrToken }}</p>
                    </div>
                    <div class="mt-2 flex items-center justify-center gap-1.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                        <span>Dynamic Anti-Cheat (Refresh 5dtk)</span>
                    </div>
                @endif
            </div>

            <!-- Banner Footer -->
            <div class="bg-[#ebf3fc] py-3 px-5 text-center border-t border-slate-150 w-full">
                <span class="text-[#0c4ea6] font-extrabold text-xs uppercase tracking-wider">
                    @if($activeAgenda)
                        Berlaku s.d. {{ substr($activeAgenda->jam_selesai, 0, 5) }} WIB
                    @else
                        Belum Ada Agenda Aktif
                    @endif
                </span>
            </div>
        </div>

        <!-- Tata Tertib Ruangan Card -->
        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm flex flex-col">
            <!-- Banner Header -->
            <div class="bg-[#ebf3fc] px-5 py-3.5 border-b border-slate-150 flex items-center gap-2.5">
                <i class="fa-solid fa-list-check text-[#0c4ea6] text-base"></i>
                <span class="font-extrabold text-[#0c4ea6] text-xs uppercase tracking-wider">Tata Tertib Ruangan</span>
            </div>

            <!-- Rules List -->
            <div class="p-6 bg-white flex flex-col gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                        <i class="fa-solid fa-ban text-red-500 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Wajib menjaga kebersihan dan ketertiban selama berada di laboratorium.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                        <i class="fa-solid fa-desktop text-blue-500 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Gunakan komputer sesuai absen.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                        <i class="fa-solid fa-power-off text-amber-500 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Matikan komputer & rapikan kursi.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                        <i class="fa-solid fa-burger text-red-400 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Dilarang membawa makanan dan minuman ke dalam laboratorium.
                    </p>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-7 h-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0 mt-0.5 shadow-sm">
                        <i class="fa-solid fa-shield-halved text-emerald-500 text-xs"></i>
                    </div>
                    <p class="text-xs text-slate-700 leading-normal font-medium mt-0.5">
                        Gunakan komputer dan fasilitas laboratorium dengan baik dan bertanggung jawab.
                    </p>
                </div>
            </div>
        </div>

    </div>

</main>
