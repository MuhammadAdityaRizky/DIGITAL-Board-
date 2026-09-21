@if(isset($groupedAgendas) && $groupedAgendas->count() > 0)
    <div class="space-y-6">
        @php
            $hasActiveAnywhere = false;
            foreach ($groupedAgendas as $sList) {
                if ($sList->where('status_agenda', 'Berlangsung')->count() > 0 || $sList->where('tanggal', date('Y-m-d'))->count() > 0) {
                    $hasActiveAnywhere = true;
                    break;
                }
            }
        @endphp
        @foreach($groupedAgendas as $courseTitle => $sessions)
            @php
                $first = $sessions->first();
                $totalSessions = $sessions->count();
                $completedSessions = $sessions->where('status_agenda', 'Selesai')->count();
                $ongoingSessions = $sessions->where('status_agenda', 'Berlangsung')->count();
                $todaySessions = $sessions->where('tanggal', date('Y-m-d'))->count();
                $courseSlug = 'course-' . $loop->index . '-' . Str::slug($courseTitle);

                $minTanggal = $sessions->min('tanggal');
                $maxTanggal = $sessions->max('tanggal');
                $isPastCourse = $maxTanggal < date('Y-m-d') && $ongoingSessions === 0;

                if ($minTanggal && $maxTanggal) {
                    if ($minTanggal === $maxTanggal) {
                        $periodeText = date('d M Y', strtotime($minTanggal));
                    } else {
                        $periodeText = date('d M Y', strtotime($minTanggal)) . ' - ' . date('d M Y', strtotime($maxTanggal));
                    }
                } else {
                    $periodeText = '-';
                }

                $isFiltered = request()->anyFilled(['search', 'tanggal']);
                // Default expanded jika difilter, ada sesi berlangsung, ada sesi hari ini, atau jika tidak ada yang aktif maka matkul pertama saja
                $isExpanded = $isFiltered || ($ongoingSessions > 0) || ($todaySessions > 0) || (!$hasActiveAnywhere && $loop->first);
            @endphp
            <!-- Course Card Container (Wadah Kartu Mata Kuliah) -->
            <div class="bg-white border-2 border-slate-300 rounded-2xl shadow-sm overflow-hidden transition-all">
                
                <!-- Course Card Header (Clickable Accordion) -->
                <div onclick="toggleCourseAccordion('{{ $courseSlug }}')" 
                     onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();toggleCourseAccordion('{{ $courseSlug }}');}"
                     class="bg-slate-100 hover:bg-slate-200/80 border-b-2 border-slate-300 p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4 cursor-pointer select-none transition-colors group/header"
                     role="button"
                     tabindex="0"
                     aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
                     id="header-{{ $courseSlug }}"
                     title="Klik untuk membuka atau menutup daftar sesi pertemuan">
                    
                    <div class="flex items-start sm:items-center gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold text-xl sm:text-2xl shadow-sm flex-shrink-0">
                            <i class="fa-solid fa-book-bookmark"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <h3 class="font-black text-xl sm:text-2xl text-slate-900 tracking-tight">
                                    {{ $first->mata_kuliah }}
                                </h3>
                                @if($first->kelas)
                                    <span class="px-3.5 py-1 bg-white border-2 border-slate-300 text-slate-900 rounded-lg text-sm sm:text-base font-extrabold shadow-2xs">
                                        Kelas {{ $first->kelas }}
                                    </span>
                                @endif
                                @if($first->semester)
                                    <span class="px-3.5 py-1 bg-white border-2 border-slate-300 text-slate-900 rounded-lg text-sm sm:text-base font-extrabold shadow-2xs">
                                        Semester {{ $first->semester }}
                                    </span>
                                @endif
                                @if($isPastCourse)
                                    <span class="px-3.5 py-1 bg-slate-200 border-2 border-slate-400 text-slate-800 rounded-lg text-sm sm:text-base font-extrabold flex items-center gap-1.5" title="Data agenda perkuliahan semester lalu">
                                        <i class="fa-solid fa-clock-rotate-left text-sm text-slate-700"></i> Semester Lalu
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 text-sm sm:text-base text-slate-700 mt-2 flex-wrap font-bold">
                                <span class="inline-flex items-center gap-1.5 text-slate-900 bg-white border-2 border-slate-300 px-3 py-1 rounded-lg" title="Rentang Tanggal Pertemuan">
                                    <i class="fa-regular fa-calendar-days text-slate-700"></i>
                                    <span>{{ $periodeText }}</span>
                                </span>
                                <span class="text-slate-400">•</span>
                                <span><i class="fa-solid fa-location-dot mr-1.5 text-slate-700"></i>{{ $first->lab->nama_lab ?? 'Laboratorium' }}</span>
                                <span class="text-slate-400">•</span>
                                <span><i class="fa-solid fa-graduation-cap mr-1.5 text-slate-700"></i>{{ $first->jurusan ?? 'Program Studi' }}</span>
                                @if($first->program_kuliah)
                                    <span class="text-slate-400">•</span>
                                    <span>Program {{ $first->program_kuliah }} {{ $first->tahun_ajaran }}</span>
                                @else
                                    <span class="text-slate-400">•</span>
                                    <span>TA {{ $first->tahun_ajaran }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 self-end lg:self-center flex-shrink-0 flex-wrap">
                        <div class="container-checkbox hidden items-center gap-2 px-3 py-2 bg-white border-2 border-slate-300 rounded-xl shadow-xs" onclick="event.stopPropagation()">
                            <input type="checkbox" data-course="{{ $courseSlug }}" onchange="toggleCourseGroup(this, '{{ $courseSlug }}')" class="course-master-checkbox rounded text-slate-900 focus:ring-0 w-5 h-5 cursor-pointer" id="master-{{ $courseSlug }}">
                            <label for="master-{{ $courseSlug }}" class="text-sm sm:text-base font-bold text-slate-900 cursor-pointer select-none">Pilih Semua Sesi</label>
                        </div>
                        @if($ongoingSessions > 0)
                            <span class="px-3.5 py-1.5 bg-teal-800 text-white rounded-xl text-sm sm:text-base font-extrabold animate-pulse flex items-center gap-2 shadow-xs">
                                <span class="w-2.5 h-2.5 rounded-full bg-white"></span> {{ $ongoingSessions }} Berlangsung
                            </span>
                        @endif
                        <span class="px-3.5 py-1.5 bg-white border-2 border-slate-300 text-slate-900 rounded-xl text-sm sm:text-base font-extrabold shadow-2xs">
                            <i class="fa-solid fa-calendar-days mr-1.5 text-slate-700"></i> {{ $totalSessions }} Pertemuan
                        </span>
                        @if($completedSessions > 0)
                            <span class="px-3.5 py-1.5 bg-teal-800 text-white rounded-xl text-sm sm:text-base font-bold shadow-xs">
                                <i class="fa-solid fa-circle-check mr-1.5"></i> {{ $completedSessions }} Selesai
                            </span>
                        @endif
                        <a href="{{ route('dosen.agenda.realisasi-praktikum.cetak', $first->id) }}" target="_blank" 
                           onclick="event.stopPropagation()"
                           class="min-h-[40px] px-3.5 py-1.5 bg-white hover:bg-teal-50 text-slate-900 border-2 border-slate-300 hover:border-teal-700 rounded-xl text-sm sm:text-base font-extrabold shadow-2xs transition flex items-center gap-2"
                           title="Cetak Lembar Realisasi Praktikum Resmi FT UIKA (Tabel Pertemuan 1–8/16)">
                            <i class="fa-solid fa-file-signature text-teal-800"></i>
                            <span class="hidden sm:inline">Lembar Realisasi</span>
                        </a>
                        <button type="button" 
                                onclick="event.stopPropagation(); openPrintBaModal('{{ $courseSlug }}', '{{ addslashes($first->mata_kuliah) }}', '{{ $first->kelas ?? '-' }}', '{{ $first->id }}')" 
                                class="min-h-[40px] px-3.5 py-1.5 bg-white hover:bg-slate-100 text-slate-900 border-2 border-slate-300 rounded-xl text-sm sm:text-base font-extrabold shadow-2xs transition flex items-center gap-2 cursor-pointer" 
                                title="Cetak Berita Acara (Pilih Pertemuan atau Semua)">
                            <i class="fa-regular fa-file-lines text-slate-700"></i>
                            <span class="hidden sm:inline">Cetak BA</span>
                        </button>
                        <div class="w-10 h-10 rounded-xl bg-white border-2 border-slate-300 flex items-center justify-center text-slate-700 group-hover/header:text-slate-900 group-hover/header:border-slate-400 transition shadow-2xs" title="Buka / Tutup Sesi Pertemuan">
                            <i class="fa-solid fa-chevron-down text-base transition-transform duration-200 {{ $isExpanded ? 'rotate-180' : '' }}" id="chevron-{{ $courseSlug }}"></i>
                        </div>
                    </div>
                </div>

                <!-- Sessions List inside Course Container (Pemisahan Tegas Antar Kartu Sesi) -->
                <div id="content-{{ $courseSlug }}" class="course-accordion-content p-4 sm:p-6 bg-slate-100/90 space-y-6 {{ $isExpanded ? '' : 'hidden' }}">
                    @foreach($sessions as $sessionIndex => $ag)
                        @php
                            $isToday = $ag->tanggal === date('Y-m-d');
                            $isFuture = $ag->tanggal > date('Y-m-d');
                            $isClashing = in_array($ag->id, $clashingAgendaIds ?? []);
                        @endphp
                        
                        <!-- Individual Session Card (Kartu Sesi Terpisah dengan Border & Shadow Tegas) -->
                        <div class="p-5 sm:p-6 bg-white border-2 border-slate-300 rounded-2xl shadow-md hover:border-slate-400 transition-all space-y-5 relative group item-{{ $courseSlug }}"
                             data-agenda-id="{{ $ag->id }}"
                             data-pertemuan="{{ $sessionIndex + 1 }}"
                             data-tanggal="{{ \Carbon\Carbon::parse($ag->tanggal)->isoFormat('dddd, D MMMM Y') }}"
                             data-jam="{{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB"
                             data-status="{{ $ag->status_agenda }}"
                             data-materi="{{ $ag->materi_realisasi ?: ($ag->catatan ?: '-') }}"
                             data-print-url="{{ route('dosen.agenda.berita-acara.cetak', $ag->id) }}">
                            
                            <!-- Selection Checkbox for bulk delete -->
                            <div class="absolute left-4 top-5 z-10 container-checkbox hidden">
                                <input type="checkbox" name="agenda_ids[]" value="{{ $ag->id }}" class="agenda-checkbox rounded text-slate-900 focus:ring-0 w-5 h-5 cursor-pointer" onchange="handleSingleCheckboxChange()">
                            </div>

                            <div class="pl-0 inner-agenda-container transition-all space-y-5">
                                
                                <!-- Baris 1: Header Sesi (Urutan KE-X, Tanggal, Jam, Lab, dan Status Badge Paling Menonjol) -->
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b-2 border-slate-200">
                                    
                                    <!-- Urutan Sesi & Tanggal (Tingkat 1 - Paling Menonjol) -->
                                    <div class="flex items-start sm:items-center gap-4">
                                        <!-- Kotak Besar Urutan Sesi -->
                                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-slate-900 text-white flex flex-col items-center justify-center flex-shrink-0 shadow-md">
                                            <span class="text-[11px] sm:text-xs font-bold text-slate-300 uppercase tracking-wider leading-none">SESI</span>
                                            <span class="text-xl sm:text-2xl font-black leading-none mt-1">KE-{{ $sessionIndex + 1 }}</span>
                                        </div>

                                        <div>
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <h4 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                                    {{ $ag->hari_tanggal }}
                                                </h4>
                                            </div>

                                            <div class="text-base sm:text-lg font-bold text-slate-700 mt-1 flex items-center gap-2 flex-wrap">
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i class="fa-regular fa-clock text-slate-600 text-base"></i>
                                                    <span>{{ substr($ag->jam_mulai,0,5) }} – {{ substr($ag->jam_selesai,0,5) }} WIB</span>
                                                </span>
                                                <span class="text-slate-400">•</span>
                                                <span class="inline-flex items-center gap-1.5 text-slate-900">
                                                    <i class="fa-solid fa-door-open text-slate-600"></i>
                                                    <span>{{ $ag->lab->nama_lab ?? 'Laboratorium' }}</span>
                                                </span>
                                            </div>

                                            <div class="flex items-center gap-2.5 mt-2 flex-wrap text-sm sm:text-base font-bold">
                                                @if($ag->dosen_waktu_masuk)
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-teal-50 border-2 border-teal-800 text-teal-950 rounded-lg">
                                                        <i class="fa-solid fa-check text-teal-800"></i> Dosen Hadir {{ date('H:i', strtotime($ag->dosen_waktu_masuk)) }}
                                                    </span>
                                                @endif
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 border-2 border-slate-300 text-slate-800 rounded-lg">
                                                    <i class="fa-solid {{ $isFuture ? 'fa-calendar-clock text-slate-600' : 'fa-users text-slate-700' }}"></i>
                                                    {{ $isFuture ? 'Sesi Terjadwal' : $ag->absensi->count() . ' Mahasiswa Hadir' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Badge (Tingkat 2 - Elemen Kedua Paling Menonjol, Minimal 15-16px, Semibold/Bold) -->
                                    <div class="flex items-center gap-3 self-start md:self-center flex-shrink-0">
                                        @if($isClashing)
                                            <span class="px-4 py-2 bg-rose-100 border-2 border-rose-500 text-rose-950 font-bold rounded-xl text-base shadow-xs flex items-center gap-2" title="Jadwal ini bentrok ruangan lab dengan sesi lain pada jam yang sama!">
                                                <span>▲</span>
                                                <span>Bentrok Ruangan</span>
                                            </span>
                                        @endif

                                        @if($ag->status_agenda === 'Berlangsung')
                                            <span class="px-4 py-2 bg-teal-50 border-2 border-teal-800 text-teal-950 font-black rounded-xl text-base shadow-xs flex items-center gap-2">
                                                <span class="w-3 h-3 rounded-full bg-teal-800 animate-pulse"></span>
                                                <span>Berlangsung</span>
                                            </span>
                                        @elseif($ag->status_agenda === 'Selesai')
                                            <span class="px-4 py-2 bg-slate-100 border-2 border-slate-400 text-slate-900 font-bold rounded-xl text-base shadow-xs flex items-center gap-2">
                                                <i class="fa-solid fa-check text-slate-700 text-base"></i>
                                                <span>Selesai</span>
                                            </span>
                                        @elseif($ag->status_agenda === 'Dibatalkan')
                                            <span class="px-4 py-2 bg-rose-50 border-2 border-rose-400 text-rose-950 font-bold rounded-xl text-base shadow-xs flex items-center gap-2">
                                                <span>✕</span>
                                                <span>Dibatalkan</span>
                                            </span>
                                        @else
                                            <span class="px-4 py-2 bg-slate-100 border-2 border-slate-300 text-slate-800 font-bold rounded-xl text-base shadow-xs flex items-center gap-2">
                                                <i class="fa-regular fa-clock text-slate-600 text-base"></i>
                                                <span>Terjadwal</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Peringatan Bentrok Ruangan Jika Ada (Palet Merah Perhatian) -->
                                @if($isClashing)
                                    <div class="p-4 bg-red-50 border-2 border-red-500 rounded-xl text-base text-red-950 font-bold flex flex-wrap items-center justify-between gap-3 shadow-xs">
                                        <span class="flex items-center gap-2">
                                            <i class="fa-solid fa-triangle-exclamation text-red-700 text-xl shrink-0"></i>
                                            <span>Ruang <strong>{{ $ag->lab->nama_lab ?? 'Laboratorium' }}</strong> terdeteksi bentrok dengan kelas lain pada jam yang sama!</span>
                                        </span>
                                        <a href="{{ route('dosen.jadwal-lab', ['lab_id' => $ag->lab_id, 'tanggal' => $ag->tanggal]) }}" 
                                           class="min-h-[44px] px-5 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-xl font-extrabold text-base transition flex items-center gap-2 shadow-sm">
                                            <span>Cek Jadwal Jam Kosong Lab</span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                @endif

                                <!-- Baris 2: Informasi Detail Terstruktur Vertikal (Minimal 16px, Line-height min 1.6, Kontras Tinggi) -->
                                <div class="space-y-4 text-base leading-relaxed">
                                    
                                    <!-- 1. Rencana / Catatan -->
                                    <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl space-y-1.5">
                                        <span class="block text-base font-extrabold text-slate-900">
                                            Rencana Pembelajaran / Catatan:
                                        </span>
                                        <p class="text-base text-slate-800 font-medium leading-relaxed">
                                            {{ $ag->catatan ?: 'Belum ada catatan rencana untuk sesi pertemuan ini.' }}
                                        </p>
                                    </div>

                                    <!-- 2. Realisasi Materi Praktikum -->
                                    <div class="p-4 {{ $ag->materi_realisasi ? 'bg-teal-50/70 border-2 border-teal-800' : ($isFuture ? 'bg-slate-50 border-2 border-slate-200' : 'bg-red-50/80 border-2 border-red-300') }} rounded-xl space-y-1.5">
                                        <div class="flex items-center justify-between gap-2 flex-wrap">
                                            <span class="block text-base font-extrabold {{ $ag->materi_realisasi ? 'text-teal-950' : 'text-slate-900' }}">
                                                Realisasi Materi Praktikum:
                                            </span>
                                            @if($ag->materi_realisasi)
                                                <span class="text-sm font-bold px-3 py-1 bg-teal-800 text-white rounded-lg flex items-center gap-1.5 shadow-2xs">
                                                    <i class="fa-solid fa-check"></i> Sudah Diisi
                                                </span>
                                            @elseif(!$isFuture)
                                                <span class="text-sm font-bold px-3 py-1 bg-red-700 text-white rounded-lg flex items-center gap-1.5 shadow-2xs">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> Belum Diisi
                                                </span>
                                            @endif
                                        </div>

                                        @if($ag->materi_realisasi)
                                            <p class="text-base text-emerald-950 font-semibold leading-relaxed">
                                                {{ $ag->materi_realisasi }}
                                            </p>
                                        @elseif($isFuture)
                                            <p class="text-base text-slate-700 italic font-medium leading-relaxed">
                                                Belum dimulai (materi realisasi diisi saat praktikum berlangsung).
                                            </p>
                                        @else
                                            <p class="text-base text-red-800 font-bold leading-relaxed flex items-center gap-2">
                                                <i class="fa-solid fa-circle-exclamation text-red-600 text-lg shrink-0"></i>
                                                <span>Materi realisasi belum diisi. Silakan klik tombol "Isi Realisasi" di bawah untuk mencatat materi yang diajarkan.</span>
                                            </p>
                                        @endif
                                    </div>

                                    <!-- 3. Berita Acara Perkuliahan (FTS-LAB-P03-F-01) -->
                                    <div class="p-4 {{ $ag->berita_acara ? 'bg-slate-50 border-2 border-slate-300' : 'bg-slate-50 border-2 border-slate-200' }} rounded-xl space-y-1.5">
                                        <div class="flex items-center justify-between gap-2 flex-wrap">
                                            <span class="block text-base font-extrabold text-slate-900">
                                                Berita Acara Resmi (FTS-LAB-P03-F-01):
                                            </span>
                                            @if($ag->berita_acara)
                                                <span class="text-sm font-bold px-3 py-1 bg-slate-800 text-white rounded-lg flex items-center gap-1.5 shadow-2xs">
                                                    <i class="fa-solid fa-check"></i> Tersedia
                                                </span>
                                            @endif
                                        </div>

                                        @if($ag->berita_acara)
                                            <p class="text-base text-slate-800 font-medium leading-relaxed">
                                                {{ Str::limit($ag->berita_acara, 160) }}
                                            </p>
                                        @elseif($isFuture)
                                            <p class="text-base text-slate-700 italic font-medium leading-relaxed">
                                                Belum dimulai (diisi saat praktikum berlangsung).
                                            </p>
                                        @else
                                            <p class="text-base text-slate-700 font-medium leading-relaxed">
                                                Belum ada catatan berita acara khusus. Klik tombol "Isi Berita Acara" di bawah jika ingin mencetak atau menyesuaikan dokumen fisik.
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Baris 3: Tombol Aksi (Area Klik Minimal 44px, Berlabel Teks Lengkap, Berjarak Aman) -->
                                <div class="pt-4 border-t-2 border-slate-200 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                                    
                                    <!-- Grup Tombol Utama (Presensi, Realisasi, Berita Acara) -->
                                    <div class="flex items-center gap-3.5 flex-wrap">
                                        @if($isFuture)
                                            <span class="min-h-[44px] px-5 py-2.5 bg-slate-200 text-slate-700 border-2 border-slate-300 rounded-xl text-base font-bold flex items-center gap-2 select-none" title="Presensi hanya dapat dibuka pada hari H perkuliahan">
                                                <i class="fa-solid fa-lock text-base text-slate-500"></i>
                                                <span>Presensi Dibuka Hari H</span>
                                            </span>
                                        @else
                                            <!-- 1. Tombol Buka Absensi Mahasiswa (Teal Admin Theme) -->
                                            <a href="{{ route('dosen.absensi.input', $ag->id) }}" 
                                               class="min-h-[44px] px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-base font-extrabold transition flex items-center gap-2.5 shadow-md cursor-pointer"
                                               title="Buka Lembar Presensi Mahasiswa">
                                                <i class="fa-solid fa-users-viewfinder text-lg"></i>
                                                <span>{{ $isToday ? 'Buka Absensi Mahasiswa' : 'Edit Rekap Absensi' }}</span>
                                            </a>

                                            <!-- 2. Tombol Realisasi Materi -->
                                            <button type="button" 
                                                    onclick="toggleModal('modal-realisasi-{{ $ag->id }}')" 
                                                    class="min-h-[44px] px-5 py-2.5 {{ $ag->materi_realisasi ? 'bg-slate-100 hover:bg-slate-200 text-slate-900 border-2 border-slate-400' : 'bg-amber-100 hover:bg-amber-200 text-amber-950 border-2 border-amber-500' }} rounded-xl text-base font-extrabold transition flex items-center gap-2.5 shadow-xs cursor-pointer"
                                                    title="Isi atau perbarui realisasi materi yang diajarkan">
                                                <i class="fa-solid fa-book-open text-base text-slate-700"></i>
                                                <span>{{ $ag->materi_realisasi ? 'Realisasi Materi' : 'Isi Realisasi' }}</span>
                                                @if($ag->materi_realisasi)
                                                    <i class="fa-solid fa-circle-check text-emerald-700 text-base"></i>
                                                @endif
                                            </button>

                                            <!-- 3. Tombol Berita Acara -->
                                            <button type="button" 
                                                    onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')" 
                                                    class="min-h-[44px] px-5 py-2.5 {{ $ag->berita_acara ? 'bg-slate-100 hover:bg-slate-200 text-slate-900 border-2 border-slate-400' : 'bg-slate-100 hover:bg-slate-200 text-slate-900 border-2 border-slate-300' }} rounded-xl text-base font-extrabold transition flex items-center gap-2.5 shadow-xs cursor-pointer"
                                                    title="Buka atau sesuaikan berita acara resmi pertemuan">
                                                <i class="fa-solid fa-file-signature text-base text-slate-700"></i>
                                                <span>{{ $ag->berita_acara ? 'Berita Acara' : 'Isi Berita Acara' }}</span>
                                                @if($ag->berita_acara)
                                                    <i class="fa-solid fa-circle-check text-emerald-700 text-base"></i>
                                                @endif
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Grup Tombol Utilitas (Cetak Hadir, Cetak BA, Edit, Hapus dengan Label Teks Jelas) -->
                                    <div class="flex items-center gap-3 flex-wrap">
                                        @if($ag->absensi->count() > 0)
                                            <a href="{{ route('dosen.agenda.export-kehadiran', $ag->id) }}" target="_blank" 
                                               class="min-h-[44px] px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-800 border-2 border-slate-300 rounded-xl text-sm sm:text-base font-bold transition flex items-center gap-2 shadow-2xs" 
                                               title="Cetak Rekapitulasi Daftar Hadir">
                                                <i class="fa-solid fa-print text-base text-slate-700"></i>
                                                <span>Cetak Hadir</span>
                                            </a>
                                        @endif

                                        @if(!$isFuture)
                                            <a href="{{ route('dosen.agenda.berita-acara.cetak', $ag->id) }}" target="_blank" 
                                               class="min-h-[44px] px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-800 border-2 border-slate-300 rounded-xl text-sm sm:text-base font-bold transition flex items-center gap-2 shadow-2xs" 
                                               title="Cetak Berita Acara Praktikum A4 Resmi UIKA">
                                                <i class="fa-solid fa-file-invoice text-base text-slate-700"></i>
                                                <span>Cetak BA</span>
                                            </a>
                                        @endif

                                        <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" 
                                                class="min-h-[44px] px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-800 border-2 border-slate-300 rounded-xl text-sm sm:text-base font-bold transition flex items-center gap-2 shadow-2xs" 
                                                title="Edit Jadwal & Ruangan Sesi Pertemuan">
                                            <i class="fa-solid fa-pen-to-square text-base text-slate-700"></i>
                                            <span>Edit</span>
                                        </button>

                                        <form action="{{ route('dosen.agenda.delete', $ag->id) }}" method="POST" 
                                              onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus pertemuan ini beserta seluruh data presensinya?', 'Hapus Pertemuan?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="min-h-[44px] px-4 py-2.5 bg-white hover:bg-red-50 text-red-700 border-2 border-red-300 rounded-xl text-sm sm:text-base font-bold transition flex items-center gap-2 shadow-2xs" 
                                                    title="Hapus Pertemuan Ini">
                                                <i class="fa-solid fa-trash-can text-base text-red-600"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!$isFuture)
                        <!-- MODAL: Realisasi Pembelajaran (Ramah Pengguna Lanjut Usia) -->
                        <div id="modal-realisasi-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-realisasi-{{ $ag->id }}')"></div>
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden text-left border-2 border-slate-200">
                                    <div class="bg-slate-100 border-b-2 border-slate-200 px-6 py-5 flex justify-between items-center text-slate-900">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg">
                                                <i class="fa-solid fa-book-open"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-black text-lg text-slate-900">Realisasi Materi Praktikum</h3>
                                                <p class="text-sm text-slate-700 font-bold mt-0.5">Pertemuan Ke-{{ $sessionIndex + 1 }} • {{ $ag->mata_kuliah }}</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="toggleModal('modal-realisasi-{{ $ag->id }}')" class="w-10 h-10 rounded-xl bg-white border border-slate-300 text-slate-700 hover:text-slate-900 flex items-center justify-center text-xl transition">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('dosen.agenda.realisasi', $ag->id) }}" method="POST" class="p-6 space-y-5">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="block text-base font-extrabold text-slate-900 mb-2">Catatan Materi</label>
                                            <div class="p-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 text-base leading-relaxed">
                                                {{ $ag->catatan ?: 'Tidak ada catatan rencana khusus.' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-base font-extrabold text-slate-900 mb-2">
                                                Materi Praktikum <span class="text-red-600">*</span>
                                            </label>
                                            <textarea name="realisasi_pembelajaran" rows="4" required placeholder="Tuliskan materi praktikum yang telah disampaikan pada pertemuan ini..." class="w-full p-3.5 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base leading-relaxed focus:border-slate-800 outline-none">{{ $ag->materi_realisasi }}</textarea>
                                        </div>
                                        <div class="flex items-center justify-end gap-3 pt-4 border-t-2 border-slate-100">
                                            <button type="button" onclick="toggleModal('modal-realisasi-{{ $ag->id }}')" class="min-h-[44px] px-6 py-2.5 bg-white border-2 border-slate-300 hover:bg-slate-100 text-slate-800 font-bold rounded-xl text-base transition">
                                                Batal
                                            </button>
                                            <button type="submit" class="min-h-[44px] px-6 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold rounded-xl text-base transition shadow flex items-center gap-2">
                                                <i class="fa-solid fa-floppy-disk"></i>
                                                <span>Simpan Realisasi</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL: Berita Acara Perkuliahan (FTS-LAB-P03-F-01 UIKA) -->
                        @php
                            $baDetails = $ag->berita_acara_details;
                        @endphp
                        <div id="modal-berita-acara-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')"></div>
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden text-left border-2 border-slate-200">
                                    
                                    <!-- Modal Header -->
                                    <div class="bg-slate-900 px-6 py-5 flex justify-between items-center text-white">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-white text-xl shadow-inner">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2.5">
                                                    <h3 class="font-black text-lg sm:text-xl text-white">Berita Acara Praktikum</h3>
                                                    <span class="px-2.5 py-0.5 bg-white/20 text-white border border-white/30 rounded text-xs font-bold font-mono">FTS-LAB-P03-F-01</span>
                                                </div>
                                                <p class="text-sm text-slate-300 font-medium mt-0.5">Pertemuan Ke-{{ $sessionIndex + 1 }} • {{ $ag->mata_kuliah }} • {{ $baDetails['hari_tanggal_indo'] }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-3">

                                            <button type="button" onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')" class="text-white/80 hover:text-white text-xl w-10 h-10 flex items-center justify-center rounded-xl hover:bg-white/10 transition">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <form action="{{ route('dosen.agenda.berita-acara', $ag->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="p-6 max-h-[75vh] overflow-y-auto space-y-6">
                                            
                                            <!-- Form Section & Document Preview Grid -->
                                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                                
                                                <!-- Kolom Form Edit (Left: 6 cols) -->
                                                <div class="lg:col-span-6 space-y-4">
                                                    <div class="bg-slate-50 border-2 border-slate-200 rounded-xl p-3.5 flex items-center gap-3 text-slate-800">
                                                        <i class="fa-solid fa-circle-info text-slate-700 text-lg shrink-0"></i>
                                                        <p class="text-sm text-slate-800 leading-normal font-medium">
                                                            Format Berita Acara ini mengacu 100% pada lembar fisik resmi <strong>Fakultas Teknik &amp; Sains UIKA Bogor</strong>.
                                                        </p>
                                                    </div>

                                                    <div>
                                                        <label class="block text-base font-extrabold text-slate-900 mb-1.5">
                                                            Materi Praktikum yang Disampaikan <span class="text-red-600">*</span>
                                                        </label>
                                                        <textarea name="materi" rows="3" required placeholder="Contoh: Evaluasi desain DB, data Anomaly, normalisasi relasional..." class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base focus:border-slate-800 outline-none leading-relaxed">{{ $baDetails['materi'] }}</textarea>
                                                    </div>

                                                    <div>
                                                        <label class="block text-base font-extrabold text-slate-900 mb-1.5">
                                                            Catatan Pelaksanaan Praktikum
                                                        </label>
                                                        <textarea name="catatan" rows="3" placeholder="Contoh: Praktikum berjalan tertib, seluruh PC laboratorium berfungsi baik..." class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base focus:border-slate-800 outline-none leading-relaxed">{{ $baDetails['catatan'] }}</textarea>
                                                    </div>

                                                    <div class="pt-3 border-t-2 border-slate-200">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <span class="text-sm font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                                                <i class="fa-solid fa-pen-to-square text-teal-700"></i> Informasi Penanggung Jawab &amp; Tanda Tangan
                                                            </span>
                                                            <span class="text-[11px] text-slate-500 font-medium">Bisa diedit jika ada pergantian</span>
                                                        </div>

                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                            <div class="p-2.5 bg-slate-50 border border-slate-300 rounded-xl">
                                                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Laboran</label>
                                                                <input type="text" name="laboran" value="{{ $baDetails['laboran'] }}" placeholder="Nama Laboran..." class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-slate-300 font-bold text-slate-900 text-xs focus:border-slate-800 outline-none">
                                                            </div>
                                                            <div class="p-2.5 bg-slate-50 border border-slate-300 rounded-xl">
                                                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Asisten Praktikum</label>
                                                                <input type="text" name="asisten" value="{{ $baDetails['asisten'] }}" placeholder="Nama Asisten..." class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-slate-300 font-bold text-slate-900 text-xs focus:border-slate-800 outline-none">
                                                            </div>
                                                            <div class="p-2.5 bg-slate-50 border border-slate-300 rounded-xl">
                                                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Dosen / Instruktur</label>
                                                                <input type="text" name="dosen" value="{{ $baDetails['dosen'] }}" placeholder="Nama Dosen Pengampu..." class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-slate-300 font-bold text-slate-900 text-xs focus:border-slate-800 outline-none">
                                                            </div>
                                                            <div class="p-2.5 bg-slate-50 border border-slate-300 rounded-xl">
                                                                <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Akademik (TA)</label>
                                                                <input type="text" name="tahun_ajaran" value="{{ $baDetails['tahun_ajaran'] }}" placeholder="Contoh: 2026/2027" class="w-full px-2.5 py-1.5 rounded-lg bg-white border border-slate-300 font-bold text-slate-900 text-xs focus:border-slate-800 outline-none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolom Pratinjau Dokumen Fisik (Right: 6 cols) -->
                                                <div class="lg:col-span-6 bg-slate-100 p-4 rounded-2xl border-2 border-slate-200 flex flex-col justify-between">
                                                    <div>
                                                        <div class="flex items-center justify-between pb-3 mb-3 border-b-2 border-slate-200">
                                                            <span class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                                                <i class="fa-solid fa-eye text-slate-700"></i> Pratinjau Dokumen Cetak
                                                            </span>
                                                            <a href="{{ route('dosen.agenda.berita-acara.cetak', $ag->id) }}" target="_blank" class="text-sm font-bold text-slate-900 hover:underline flex items-center gap-1.5">
                                                                <span>Buka Lembar A4</span>
                                                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                                            </a>
                                                        </div>

                                                        <!-- Mini Document Paper Container -->
                                                        <div class="bg-white p-5 rounded-xl border-2 border-slate-300 shadow-sm relative overflow-hidden text-[11px] space-y-2.5 select-none">
                                                            <!-- Watermark Mockup -->
                                                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-5 font-black text-2xl tracking-widest text-slate-900 select-none">
                                                                IMAN.ILMU.AMAL
                                                            </div>

                                                            <!-- Mini Kop Surat -->
                                                            <div class="flex justify-between items-start border-b border-slate-300 pb-2 relative z-10">
                                                                <div class="flex items-center gap-2.5">
                                                                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                                                                         alt="UIKA" class="w-9 h-9 object-contain">
                                                                    <div>
                                                                        <p class="font-extrabold text-[10px] text-teal-900 leading-tight">FAKULTAS TEKNIK &amp; SAINS</p>
                                                                        <p class="font-extrabold text-[9px] text-emerald-800 leading-tight">UNIVERSITAS IBN KHALDUN BOGOR</p>
                                                                        <p class="text-[8px] text-slate-600 tracking-tight">SISTEM INFORMASI • INFORMATIKA • SIPIL • ELEKTRO • MESIN</p>
                                                                    </div>
                                                                </div>
                                                                <div class="border border-slate-800 px-1.5 py-0.5 text-[8.5px] font-bold font-mono">
                                                                    FTS-LAB-P03-F-01
                                                                </div>
                                                            </div>

                                                            <!-- Mini Title -->
                                                            <div class="text-center py-1 relative z-10">
                                                                <p class="font-black text-[12px] text-slate-900 underline uppercase tracking-wide">BERITA ACARA PRAKTIKUM</p>
                                                                <p class="text-[9.5px] text-slate-700 mt-0.5 font-medium italic">
                                                                    Telah Dilaksanakan Praktikum {{ $ag->mata_kuliah }} Semester {{ $baDetails['semester_program_kelas'] ?? ($ag->semester ?? 'I') }} TA {{ $baDetails['tahun_ajaran'] }}
                                                                </p>
                                                            </div>

                                                            <!-- Mini Form Lines -->
                                                            <div class="space-y-1.5 text-[10px] text-slate-900 relative z-10">
                                                                <div class="flex">
                                                                    <span class="w-28 font-bold text-slate-700">Hari / Tanggal</span>
                                                                    <span class="mr-1.5">:</span>
                                                                    <span class="flex-1 border-b border-dotted border-slate-400 font-semibold">{{ $baDetails['hari_tanggal_indo'] }}</span>
                                                                </div>
                                                                <div class="flex">
                                                                    <span class="w-28 font-bold text-slate-700">Waktu / Durasi</span>
                                                                    <span class="mr-1.5">:</span>
                                                                    <span class="flex-1 border-b border-dotted border-slate-400 font-semibold">{{ $baDetails['waktu_durasi'] }}</span>
                                                                </div>
                                                                <div class="flex">
                                                                    <span class="w-28 font-bold text-slate-700">Prodi / Semester</span>
                                                                    <span class="mr-1.5">:</span>
                                                                    <span class="flex-1 border-b border-dotted border-slate-400 font-semibold">{{ $baDetails['prodi_semester_kelas'] }}</span>
                                                                </div>
                                                                <div class="flex">
                                                                    <span class="w-28 font-bold text-slate-700">Materi</span>
                                                                    <span class="mr-1.5">:</span>
                                                                    <span class="flex-1 border-b border-dotted border-slate-400 font-semibold truncate">{{ $baDetails['materi'] ?: 'Belum diisi...' }}</span>
                                                                </div>
                                                                <div class="flex">
                                                                    <span class="w-28 font-bold text-slate-700">Catatan</span>
                                                                    <span class="mr-1.5">:</span>
                                                                    <span class="flex-1 border-b border-dotted border-slate-400 font-semibold truncate">{{ $baDetails['catatan'] ?: '-' }}</span>
                                                                </div>
                                                            </div>

                                                            @if(!empty($baDetails['is_same_dosen']))
                                                                <!-- Mini 2 Signatures (Dosen Pengampu & Pengajar Sama) -->
                                                                <div class="grid grid-cols-2 gap-4 text-center pt-3 relative z-10 px-4">
                                                                    <div>
                                                                        <p class="font-bold text-[8.5px] text-slate-700">Laboran</p>
                                                                        <div class="h-6"></div>
                                                                        <p class="font-bold text-[9px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['laboran'] }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-bold text-[8.5px] text-slate-700">Dosen / Instruktur</p>
                                                                        <div class="h-6"></div>
                                                                        <p class="font-bold text-[9px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['dosen'] }}</p>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <!-- Mini 3 Signatures (Dosen Pengampu & Asisten Berbeda) -->
                                                                <div class="grid grid-cols-3 gap-2 text-center pt-3 relative z-10">
                                                                    <div>
                                                                        <p class="font-bold text-[8.5px] text-slate-700">Laboran</p>
                                                                        <div class="h-6"></div>
                                                                        <p class="font-bold text-[9px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['laboran'] }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-bold text-[8.5px] text-slate-700">Asisten Praktikum</p>
                                                                        <div class="h-6"></div>
                                                                        <p class="font-bold text-[9px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['asisten'] }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-bold text-[8.5px] text-slate-700">Dosen / Instruktur</p>
                                                                        <div class="h-6"></div>
                                                                        <p class="font-bold text-[9px] border-b border-slate-400 pb-0.5 truncate">{{ $baDetails['dosen'] }}</p>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <!-- Mini Footer Bar -->
                                                            <div class="bg-slate-800 text-white p-1.5 rounded-sm flex justify-between text-[8px] mt-2 relative z-10 font-medium">
                                                                <span class="truncate">Ibn Khaldun Bogor : Jl. KH. Sholeh Iskandar KM. 2</span>
                                                                <span class="font-bold">www.ft.uika-bogor.ac.id</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="flex items-center justify-between px-6 py-4 bg-slate-100 border-t-2 border-slate-200">
                                            <a href="{{ route('dosen.agenda.berita-acara.cetak', $ag->id) }}" 
                                               target="_blank" 
                                               class="min-h-[44px] px-5 py-2.5 bg-white hover:bg-slate-200 text-slate-900 border-2 border-slate-300 font-extrabold rounded-xl transition flex items-center gap-2 shadow-2xs">
                                                <i class="fa-solid fa-print text-base"></i>
                                                <span>Cetak / Lembar A4</span>
                                            </a>

                                            <div class="flex items-center gap-3">
                                                <button type="button" onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')" class="min-h-[44px] px-6 py-2.5 bg-white hover:bg-slate-200 text-slate-800 border-2 border-slate-300 font-bold rounded-xl text-base transition">
                                                    Batal
                                                </button>
                                                <button type="submit" class="min-h-[44px] px-6 py-2.5 bg-emerald-800 hover:bg-emerald-900 text-white font-extrabold rounded-xl text-base transition shadow flex items-center gap-2">
                                                    <i class="fa-solid fa-floppy-disk text-base"></i>
                                                    <span>Simpan Berita Acara</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- MODAL: Edit Agenda (Ramah Pengguna Lanjut Usia) -->
                        <div id="modal-edit-agenda-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')"></div>
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden text-left border-2 border-slate-200">
                                    <div class="bg-slate-100 border-b-2 border-slate-200 px-6 py-5 flex justify-between items-center text-slate-900">
                                        <h3 class="font-black text-lg sm:text-xl flex items-center gap-2.5 text-slate-900">
                                            <i class="fa-solid fa-pen-to-square text-slate-700"></i>
                                            <span>Edit Agenda Pertemuan</span>
                                        </h3>
                                        <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="w-10 h-10 rounded-xl bg-white border border-slate-300 text-slate-700 hover:text-slate-900 flex items-center justify-center text-xl transition">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('dosen.agenda.update', $ag->id) }}" method="POST" class="p-6 space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="block text-base font-extrabold text-slate-900 mb-1.5">Ruangan Laboratorium <span class="text-red-600">*</span></label>
                                            <select name="lab_id" required class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold focus:border-slate-800 outline-none">
                                                @foreach($labs as $lab)
                                                    <option value="{{ $lab->id }}" {{ $ag->lab_id == $lab->id ? 'selected' : '' }}>{{ $lab->nama_lab }} ({{ $lab->lokasi }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-base font-extrabold text-slate-900 mb-1.5">Dosen Pengampu <span class="text-slate-600 text-sm font-normal">(Opsional)</span></label>
                                            <select name="dosen_pengampu_id" class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold focus:border-slate-800 outline-none">
                                                <option value="">-- Gunakan Pengampu Default --</option>
                                                @foreach($dosens as $d)
                                                    <option value="{{ $d->id }}" {{ $ag->dosen_pengampu_id == $d->id ? 'selected' : '' }}>{{ $d->nama }} (NIP: {{ $d->nip }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-base font-extrabold text-slate-900 mb-1.5">Mata Kuliah <span class="text-red-600">*</span></label>
                                            <input type="text" name="judul_agenda" value="{{ $ag->mata_kuliah }}" required class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold focus:border-slate-800 outline-none">
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-base font-extrabold text-slate-900 mb-1.5">Fakultas</label>
                                                <input type="text" name="fakultas" value="{{ $ag->fakultas }}" required class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold focus:border-slate-800 outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-base font-extrabold text-slate-900 mb-1.5">Jurusan / Prodi</label>
                                                <input type="text" name="jurusan" value="{{ $ag->jurusan }}" required class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold focus:border-slate-800 outline-none">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                            <div>
                                                <label class="block text-sm font-extrabold text-slate-900 mb-1">Program</label>
                                                <select name="program_kuliah" required class="w-full p-2.5 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold">
                                                    <option value="Reguler" {{ $ag->program_kuliah == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                                    <option value="Karyawan" {{ $ag->program_kuliah == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-extrabold text-slate-900 mb-1">Tipe</label>
                                                <select name="jenis_pertemuan" required class="w-full p-2.5 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold">
                                                    <option value="Praktikum" {{ ($ag->jenis_pertemuan ?? 'Praktikum') == 'Praktikum' ? 'selected' : '' }}>Praktikum</option>
                                                    <option value="Teori" {{ ($ag->jenis_pertemuan ?? '') == 'Teori' ? 'selected' : '' }}>Teori</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-extrabold text-slate-900 mb-1">Kelas</label>
                                                <input type="text" name="kelas" value="{{ $ag->kelas }}" class="w-full p-2.5 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-extrabold text-slate-900 mb-1">Semester</label>
                                                <input type="text" name="semester" value="{{ $ag->semester }}" required class="w-full p-2.5 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-base font-extrabold text-slate-900 mb-1.5">Tanggal Pertemuan <span class="text-red-600">*</span></label>
                                            <input type="date" name="tanggal" value="{{ $ag->tanggal }}" required class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-bold focus:border-slate-800 outline-none">
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-base font-extrabold text-slate-900 mb-1.5">Jam Masuk <span class="text-red-600">*</span></label>
                                                <input type="time" name="waktu_masuk" value="{{ substr($ag->jam_mulai,0,5) }}" required class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-mono font-bold focus:border-slate-800 outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-base font-extrabold text-slate-900 mb-1.5">Jam Keluar <span class="text-red-600">*</span></label>
                                                <input type="time" name="waktu_keluar" value="{{ substr($ag->jam_selesai,0,5) }}" required class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-mono font-bold focus:border-slate-800 outline-none">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-base font-extrabold text-slate-900 mb-1.5">Materi Praktikum <span class="text-slate-500 font-normal text-xs">(Opsional)</span></label>
                                            <textarea name="materi_pembelajaran" rows="3" placeholder="Tuliskan materi praktikum (Opsional)..." class="w-full p-3 rounded-xl bg-slate-50 border-2 border-slate-300 text-slate-900 text-base font-medium focus:border-slate-800 outline-none leading-relaxed">{{ $ag->catatan }}</textarea>
                                        </div>

                                        <div class="flex justify-end gap-3 pt-4 border-t-2 border-slate-200">
                                            <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="min-h-[44px] px-6 py-2.5 bg-white border-2 border-slate-300 hover:bg-slate-100 text-slate-800 font-bold rounded-xl text-base transition">
                                                Batal
                                            </button>
                                            <button type="submit" class="min-h-[44px] px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold rounded-xl text-base transition shadow">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-16 bg-white border-2 border-slate-300 rounded-2xl shadow-sm">
        <div class="w-20 h-20 bg-slate-100 text-slate-700 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl border-2 border-slate-300">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
        <h4 class="text-xl font-black text-slate-900">Tidak Ada Agenda Ditemukan</h4>
        <p class="text-base text-slate-700 max-w-md mx-auto mt-2 leading-relaxed font-medium">
            Belum ada jadwal pertemuan praktikum yang sesuai dengan filter atau kata kunci pencarian.
        </p>
        <div class="mt-6 flex justify-center">
            <button type="button" onclick="toggleModal('modal-buat-agenda')" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl text-base shadow-md hover:shadow-lg transition flex items-center gap-2">
                <i class="fa-solid fa-circle-plus"></i>
                <span>+ Buat Agenda Baru</span>
            </button>
        </div>
    </div>
@endif
