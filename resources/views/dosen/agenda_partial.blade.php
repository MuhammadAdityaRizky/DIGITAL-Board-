@if(isset($groupedAgendas) && $groupedAgendas->count() > 0)
    <div class="space-y-6">
        @foreach($groupedAgendas as $courseTitle => $sessions)
            @php
                $first = $sessions->first();
                $totalSessions = $sessions->count();
                $completedSessions = $sessions->where('status_agenda', 'Selesai')->count();
            @endphp
            <!-- Course Card Container -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden transition hover:border-slate-300">
                <!-- Course Card Header -->
                <div class="bg-slate-50/80 border-b border-slate-200 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start sm:items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-800 text-white flex items-center justify-center font-bold text-lg shadow-sm flex-shrink-0">
                            <i class="fa-solid fa-book-bookmark"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-bold text-base text-slate-800">{{ $first->mata_kuliah }}</h3>
                                @if($first->kelas)
                                    <span class="px-2.5 py-0.5 bg-teal-50 text-teal-800 border border-teal-200 rounded-full text-[11px] font-bold">
                                        Kelas {{ $first->kelas }}
                                    </span>
                                @endif
                                @if($first->semester)
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-full text-[11px] font-bold">
                                        Semester {{ $first->semester }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3 text-xs text-slate-500 mt-1 flex-wrap font-medium">
                                <span><i class="fa-solid fa-location-dot mr-1 text-slate-400"></i>{{ $first->lab->nama_lab ?? 'Laboratorium' }}</span>
                                <span class="text-slate-300">•</span>
                                <span><i class="fa-solid fa-graduation-cap mr-1 text-slate-400"></i>{{ $first->jurusan ?? 'Program Studi' }}</span>
                                @if($first->program_kuliah)
                                    <span class="text-slate-300">•</span>
                                    <span>Program {{ $first->program_kuliah }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-end sm:self-center flex-shrink-0">
                        <span class="px-3 py-1 bg-teal-50 text-teal-900 border border-teal-200 rounded-xl text-xs font-bold shadow-xs">
                            <i class="fa-solid fa-calendar-days mr-1 text-teal-700"></i> {{ $totalSessions }} Pertemuan
                        </span>
                        @if($completedSessions > 0)
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold">
                                {{ $completedSessions }} Selesai
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Sessions List inside Course Container -->
                <div class="divide-y divide-slate-100">
                    @foreach($sessions as $sessionIndex => $ag)
                        <div class="p-4 sm:p-5 hover:bg-slate-50/60 transition relative group">
                            <!-- Selection Checkbox for bulk delete -->
                            <div class="absolute left-3 top-4 z-10 container-checkbox hidden">
                                <input type="checkbox" name="agenda_ids[]" value="{{ $ag->id }}" class="agenda-checkbox rounded text-teal-800 focus:ring-teal-700/30 w-4 h-4 cursor-pointer">
                            </div>

                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pl-0 inner-agenda-container transition-all">
                                
                                <!-- Left Column: Session Badge, Time, Status -->
                                <div class="flex items-start gap-3.5 min-w-[240px]">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex flex-col items-center justify-center text-slate-800 flex-shrink-0 shadow-xs">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase leading-none">Ke-</span>
                                        <span class="text-base font-extrabold text-teal-800 leading-none mt-0.5">{{ $sessionIndex + 1 }}</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-xs text-slate-800">
                                                {{ date('d M Y', strtotime($ag->tanggal)) }}
                                            </span>
                                            @if($ag->status_agenda === 'Berlangsung')
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[9px] font-bold uppercase tracking-wider animate-pulse">
                                                    Berlangsung
                                                </span>
                                            @elseif($ag->status_agenda === 'Selesai')
                                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded text-[9px] font-bold uppercase tracking-wider">
                                                    Selesai
                                                </span>
                                            @elseif($ag->status_agenda === 'Dibatalkan')
                                                <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-200 rounded text-[9px] font-bold uppercase tracking-wider">
                                                    Dibatalkan
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded text-[9px] font-bold uppercase tracking-wider">
                                                    Mendatang
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] font-mono font-semibold text-slate-500 mt-1">
                                            <i class="fa-regular fa-clock mr-1 text-slate-400"></i>{{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($ag->dosen_waktu_masuk)
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded">
                                                    <i class="fa-solid fa-check mr-1"></i>Dosen Masuk {{ date('H:i', strtotime($ag->dosen_waktu_masuk)) }}
                                                </span>
                                            @endif
                                            <span class="text-[10px] font-bold text-teal-800 bg-teal-50 border border-teal-200 px-1.5 py-0.5 rounded">
                                                <i class="fa-solid fa-users mr-1"></i>{{ $ag->absensi->count() }} Hadir
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Middle Column: Rencana, Realisasi & Berita Acara Overview -->
                                <div class="flex-1 space-y-1.5 max-w-xl text-xs">
                                    <div class="text-slate-600">
                                        <span class="font-bold text-slate-700">Rencana/Catatan:</span>
                                        <span class="text-slate-600 ml-1">{{ $ag->catatan ?: 'Belum ada catatan rencana.' }}</span>
                                    </div>

                                    <!-- Realisasi Snippet -->
                                    <div class="flex items-start gap-1.5">
                                        <span class="font-bold text-amber-800 text-[11px] flex-shrink-0">Realisasi:</span>
                                        @if($ag->materi_realisasi)
                                            <span class="text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded text-[11px] font-medium leading-tight line-clamp-2">
                                                {{ $ag->materi_realisasi }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-[11px] italic">Belum diisi (klik tombol Realisasi)</span>
                                        @endif
                                    </div>

                                    <!-- Berita Acara Snippet -->
                                    <div class="flex items-start gap-1.5">
                                        <span class="font-bold text-indigo-800 text-[11px] flex-shrink-0">Berita Acara:</span>
                                        @if($ag->berita_acara)
                                            <span class="text-indigo-900 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded text-[11px] font-medium leading-tight line-clamp-2">
                                                {{ Str::limit($ag->berita_acara, 100) }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-[11px] italic">Belum diisi (klik tombol Berita Acara)</span>
                                        @endif
                                    </div>
                                </div>

                                 <!-- Right Column: 3 KEY ACTIONS + Secondary Tools -->
                                 <div class="flex flex-wrap lg:flex-nowrap items-center gap-2 flex-shrink-0">
                                     @php
                                         $isPastOrSelesai = ($ag->tanggal < date('Y-m-d')) || ($ag->status_agenda === 'Selesai');
                                         $canAccessFeatures = !empty($ag->dosen_waktu_masuk) || $isPastOrSelesai;
                                     @endphp

                                     @if($canAccessFeatures)
                                         <!-- 1. Tombol Absensi Mahasiswa (Input/Check Status Hadir, Izin, Sakit, Alpa) -->
                                         <a href="{{ route('dosen.absensi.input', $ag->id) }}" 
                                            class="px-3 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm"
                                            title="Buka Input Absensi Mahasiswa (Hadir, Izin WhatsApp, Sakit, Alpa)">
                                             <i class="fa-solid fa-users-viewfinder"></i>
                                             <span>Absensi Mahasiswa</span>
                                         </a>

                                         <!-- 2. Tombol Realisasi Pembelajaran -->
                                         <button type="button" 
                                                 onclick="toggleModal('modal-realisasi-{{ $ag->id }}')" 
                                                 class="px-3 py-2 {{ $ag->materi_realisasi ? 'bg-amber-100 hover:bg-amber-200 text-amber-900 border border-amber-300' : 'bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200' }} rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-xs"
                                                 title="Isi atau perbarui realisasi materi yang diajarkan">
                                             <i class="fa-solid fa-book-open"></i>
                                             <span>Realisasi</span>
                                             @if($ag->materi_realisasi)
                                                 <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                             @endif
                                         </button>

                                         <!-- 3. Tombol Berita Acara -->
                                         <button type="button" 
                                                 onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')" 
                                                 class="px-3 py-2 {{ $ag->berita_acara ? 'bg-indigo-100 hover:bg-indigo-200 text-indigo-900 border border-indigo-300' : 'bg-indigo-50 hover:bg-indigo-100 text-indigo-800 border border-indigo-200' }} rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-xs"
                                                 title="Tuliskan berita acara resmi sesi perkuliahan">
                                             <i class="fa-solid fa-file-signature"></i>
                                             <span>Berita Acara</span>
                                             @if($ag->berita_acara)
                                                 <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                             @endif
                                         </button>
                                     @else
                                          <div class="flex items-center gap-1.5">
                                              <button type="button" onclick="startDosenQRScanner()" class="px-3.5 py-2 bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-2" title="Lakukan Absensi QR Dosen di Board Kelas terlebih dahulu">
                                                  <i class="fa-solid fa-camera"></i> Absen QR Board
                                              </button>

                                              <form action="{{ route('dosen.absensi.submit') }}" method="POST" class="inline" onsubmit="return confirm('Emergency Check-in: Gunakan fitur ini jika QR Board / Scanner TV bermasalah?')">
                                                  @csrf
                                                  <input type="hidden" name="agenda_id" value="{{ $ag->id }}">
                                                  <button type="submit" class="px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-1.5" title="Emergency Check-in Manual tanpa scan QR Board">
                                                      <i class="fa-solid fa-hand-pointer"></i> Emergency Check-in
                                                  </button>
                                              </form>
                                          </div>
                                     @endif

                                    <!-- Secondary Actions: Print, Edit, Delete -->
                                    <div class="flex items-center gap-1 border-l border-slate-200 pl-2">
                                        @if($ag->absensi->count() > 0)
                                            <a href="{{ route('dosen.agenda.export-kehadiran', $ag->id) }}" target="_blank" class="p-2 text-slate-400 hover:text-teal-800 hover:bg-slate-100 rounded-lg transition" title="Cetak/Export Daftar Hadir">
                                                <i class="fa-solid fa-print"></i>
                                            </a>
                                        @endif

                                        <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition" title="Edit Sesi">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <form action="{{ route('dosen.agenda.delete', $ag->id) }}" method="POST" onsubmit="return confirmAction(event, 'Apakah Anda yakin ingin menghapus pertemuan ini?', 'Hapus Pertemuan?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition" title="Hapus Pertemuan">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL: Realisasi Pembelajaran -->
                        <div id="modal-realisasi-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-realisasi-{{ $ag->id }}')"></div>
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden text-left border border-slate-100">
                                    <div class="bg-amber-50 border-b border-amber-100 px-6 py-4 flex justify-between items-center text-slate-800">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                                                <i class="fa-solid fa-book-open"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-800">Realisasi Pembelajaran</h3>
                                                <p class="text-[10px] text-slate-500 font-semibold">Pertemuan ke-{{ $sessionIndex + 1 }} • {{ $ag->mata_kuliah }}</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="toggleModal('modal-realisasi-{{ $ag->id }}')" class="text-slate-400 hover:text-slate-600 text-lg">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('dosen.agenda.realisasi', $ag->id) }}" method="POST" class="p-6 space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Rencana Materi Sebelumnya</label>
                                            <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-600 text-xs italic">
                                                {{ $ag->catatan ?: 'Tidak ada catatan rencana.' }}
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Materi / Realisasi yang Disampaikan <span class="text-rose-500">*</span></label>
                                            <textarea name="realisasi_pembelajaran" rows="4" required placeholder="Contoh: Praktikum manipulasi DOM dan asynchronous fetch data API, latihan mandiri membuat tabel interaktif..." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-amber-500/30 focus:border-amber-600 outline-none text-xs">{{ $ag->materi_realisasi }}</textarea>
                                        </div>
                                        <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                            <button type="button" onclick="toggleModal('modal-realisasi-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                                            <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg transition shadow-sm">
                                                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Realisasi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL: Berita Acara Perkuliahan -->
                        <div id="modal-berita-acara-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')"></div>
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden text-left border border-slate-100">
                                    <div class="bg-indigo-50 border-b border-indigo-100 px-6 py-4 flex justify-between items-center text-slate-800">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-800">Berita Acara Perkuliahan</h3>
                                                <p class="text-[10px] text-slate-500 font-semibold">Pertemuan ke-{{ $sessionIndex + 1 }} • {{ $ag->mata_kuliah }}</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')" class="text-slate-400 hover:text-slate-600 text-lg">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('dosen.agenda.berita-acara', $ag->id) }}" method="POST" class="p-6 space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Catatan / Berita Acara Pelaksanaan Kuliah <span class="text-rose-500">*</span></label>
                                            <textarea name="berita_acara" rows="5" required placeholder="Tuliskan berita acara (e.g. Perkuliahan praktikum berjalan tertib, seluruh mahasiswa hadir tepat waktu, software IDE berjalan lancar tanpa kendala perangkat lab)..." class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-600 outline-none text-xs">{{ $ag->berita_acara }}</textarea>
                                        </div>
                                        <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                            <button type="button" onclick="toggleModal('modal-berita-acara-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                                            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition shadow-sm">
                                                <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Berita Acara
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL: Edit Agenda -->
                        <div id="modal-edit-agenda-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
                            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')"></div>
                            <div class="relative min-h-screen flex items-center justify-center p-4">
                                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden text-left">
                                    <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-800">
                                        <h3 class="font-bold text-sm flex items-center gap-2">
                                            <i class="fa-solid fa-pen-to-square text-teal-700"></i> Edit Agenda Pertemuan
                                        </h3>
                                        <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="text-slate-400 hover:text-slate-600 text-base">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('dosen.agenda.update', $ag->id) }}" method="POST" class="p-6 space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Ruangan Laboratorium</label>
                                            <select name="lab_id" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                                @foreach($labs as $lab)
                                                    <option value="{{ $lab->id }}" {{ $ag->lab_id == $lab->id ? 'selected' : '' }}>{{ $lab->nama_lab }} ({{ $lab->lokasi }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Dosen Pengampu <span class="text-slate-400 font-normal text-[10px]">(Opsional)</span></label>
                                            <select name="dosen_pengampu_id" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                                <option value="">-- Pilih Dosen Pengampu --</option>
                                                @foreach($dosens as $d)
                                                    <option value="{{ $d->id }}" {{ $ag->dosen_pengampu_id == $d->id ? 'selected' : '' }}>{{ $d->nama }} (NIP: {{ $d->nip }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Mata Kuliah</label>
                                            <input type="text" name="judul_agenda" value="{{ $ag->mata_kuliah }}" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Fakultas</label>
                                                <input type="text" name="fakultas" value="{{ $ag->fakultas }}" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Jurusan / Prodi</label>
                                                <input type="text" name="jurusan" value="{{ $ag->jurusan }}" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Program</label>
                                                <select name="program_kuliah" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                                    <option value="Reguler" {{ $ag->program_kuliah == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                                    <option value="Karyawan" {{ $ag->program_kuliah == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Tipe</label>
                                                <select name="jenis_pertemuan" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                                    <option value="Praktikum" {{ ($ag->jenis_pertemuan ?? 'Praktikum') == 'Praktikum' ? 'selected' : '' }}>Praktikum</option>
                                                    <option value="Teori" {{ ($ag->jenis_pertemuan ?? '') == 'Teori' ? 'selected' : '' }}>Teori</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Kelas</label>
                                                <input type="text" name="kelas" value="{{ $ag->kelas }}" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Semester</label>
                                                <input type="text" name="semester" value="{{ $ag->semester }}" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Tanggal</label>
                                            <input type="date" name="tanggal" value="{{ $ag->tanggal }}" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Jam Masuk</label>
                                                <input type="time" name="waktu_masuk" value="{{ substr($ag->jam_mulai,0,5) }}" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-slate-700 font-bold mb-1">Jam Keluar</label>
                                                <input type="time" name="waktu_keluar" value="{{ substr($ag->jam_selesai,0,5) }}" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-slate-700 font-bold mb-1">Rencana/Catatan Pembelajaran</label>
                                            <textarea name="rencana_pembelajaran" rows="3" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">{{ $ag->catatan }}</textarea>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                                            <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                                            <button type="submit" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-lg transition">Simpan Perubahan</button>
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
    <div class="text-center py-16 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="w-16 h-16 bg-teal-50 text-teal-800 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl border border-teal-100">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
        <h4 class="text-base font-bold text-slate-800">Tidak Ada Agenda Ditemukan</h4>
        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Belum ada agenda pertemuan praktikum. Klik tombol "Tambah Agenda" di atas untuk membuat agenda perkuliahan dari jadwal lab Anda.</p>
    </div>
@endif
