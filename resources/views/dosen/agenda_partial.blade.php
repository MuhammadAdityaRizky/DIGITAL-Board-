@if($agendas->count() > 0)
    @foreach($agendas as $ag)
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 space-y-4 relative group">
        <!-- Selection Checkbox -->
        <div class="absolute left-3.5 top-3.5 z-10 container-checkbox hidden">
            <input type="checkbox" name="agenda_ids[]" value="{{ $ag->id }}" class="agenda-checkbox rounded text-teal-850 focus:ring-teal-700/30 w-3.5 h-3.5 cursor-pointer">
        </div>
        <div class="flex flex-col md:flex-row gap-5 items-start pl-2 inner-agenda-container transition-all">
            <!-- Time block -->
            <div class="bg-teal-900 text-white rounded-xl p-3 flex flex-col items-center justify-center min-w-[120px] shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-teal-355">{{ date('d M Y', strtotime($ag->tanggal)) }}</span>
                <span class="text-xs font-bold mt-1.5">{{ substr($ag->jam_mulai,0,5) }} - {{ substr($ag->jam_selesai,0,5) }} WIB</span>
            </div>
            
            <!-- Details -->
            <div class="flex-1 space-y-3 w-full">
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h4 class="font-bold text-slate-800 text-lg">{{ $ag->mata_kuliah }}</h4>
                        @if($ag->status_agenda === 'Berlangsung')
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded text-[9px] font-bold uppercase tracking-wider">Berlangsung</span>
                        @elseif($ag->status_agenda === 'Selesai')
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-650 border border-slate-200 rounded text-[9px] font-bold uppercase tracking-wider">Selesai</span>
                        @elseif($ag->status_agenda === 'Dibatalkan')
                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded text-[9px] font-bold uppercase tracking-wider">Dibatalkan</span>
                        @else
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded text-[9px] font-bold uppercase tracking-wider">Mendatang</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Catatan/Rencana Pembelajaran: <span class="text-slate-600 font-medium">{{ $ag->catatan ?? 'Tidak ada catatan.' }}</span></p>
                    @if($ag->materi_realisasi)
                        <p class="text-xs text-emerald-700 mt-1 bg-emerald-50/50 border border-emerald-100 rounded-lg p-2.5">
                            <strong>Realisasi Pembelajaran:</strong> <span class="font-medium">{{ $ag->materi_realisasi }}</span>
                        </p>
                    @elseif($ag->status_agenda === 'Selesai')
                        <p class="text-xs text-amber-700 mt-1 bg-amber-50/50 border border-amber-100 rounded-lg p-2.5">
                            <strong>Realisasi Pembelajaran:</strong> <span class="italic font-medium">Belum diisi. Silakan isi realisasi di bawah.</span>
                        </p>
                    @endif
                    <p class="text-[11px] text-slate-455 mt-1">
                        <i class="fa-solid fa-location-dot mr-1"></i>{{ $ag->lab->nama_lab }}
                        @if($ag->program_kuliah) Program: {{ $ag->program_kuliah }} @else Program: Reguler @endif
                        @if($ag->kelas) • Kelas: {{ $ag->kelas }} @endif
                        @if($ag->semester) • Semester: {{ $ag->semester }} @endif
                    </p>
                </div>
                
                <!-- Collapsible Section: Realisasi (Collapsible details) -->
                @if($ag->status_agenda === 'Selesai')
                <details class="w-full bg-white border border-slate-200 rounded-xl overflow-hidden group mt-3">
                    <summary class="px-4 py-2 bg-slate-50/50 hover:bg-slate-100/60 font-bold text-[11px] text-slate-655 cursor-pointer flex items-center justify-between transition-all select-none">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-folder-open text-teal-700"></i> Isi / Edit Realisasi Pembelajaran
                        </span>
                        <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform"></i>
                    </summary>
                    <div class="p-3 border-t border-slate-100 w-full">
                        <!-- Form Realisasi -->
                        <div class="w-full bg-slate-50 p-3 rounded-lg border border-slate-200">
                            <form action="{{ route('dosen.agenda.realisasi', $ag->id) }}" method="POST" class="flex gap-2 w-full items-center">
                                @csrf
                                @method('PUT')
                                <input type="text" 
                                       name="realisasi_pembelajaran" 
                                       value="{{ $ag->materi_realisasi }}"
                                       placeholder="Contoh: Pembahasan OOP & Inheritance, disusul latihan..." 
                                       class="flex-1 p-2 rounded-lg border border-slate-200 bg-white text-xs focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700">
                                <button type="submit" class="px-3 py-2 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition whitespace-nowrap">
                                    Simpan
                                </button>
                                @if($ag->materi_realisasi)
                                    <button type="submit" name="realisasi_pembelajaran" value="" onclick="return confirm('Apakah Anda yakin ingin menghapus realisasi pembelajaran ini?')" class="px-2.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-250 rounded-lg text-xs font-bold transition whitespace-nowrap" title="Hapus Realisasi">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </details>
                @endif

                <!-- Actions -->
                <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-slate-200 w-full">
                    <button onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-lg border border-amber-200 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    
                    <form action="{{ route('dosen.agenda.delete', $ag->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-lg border border-rose-200 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </form>

                    @if($ag->dosen_waktu_masuk)
                        <span class="px-2.5 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-lg text-xs font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check"></i> Absen Masuk: {{ date('H:i', strtotime($ag->dosen_waktu_masuk)) }} WIB
                        </span>
                    @endif
                    
                    <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-lg ml-auto">
                        <i class="fa-solid fa-users"></i>
                        {{ $ag->absensi->count() }} Hadir
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Include the Edit Modal for this agenda -->
        <div id="modal-edit-agenda-{{ $ag->id }}" class="fixed inset-0 z-50 overflow-y-auto hidden text-xs">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')"></div>
            
            <!-- Modal Content -->
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden text-left">
                    <!-- Header -->
                    <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex justify-between items-center text-slate-800">
                        <h3 class="font-bold text-sm flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-teal-705"></i> Edit Agenda Pembelajaran
                        </h3>
                        <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="text-slate-400 hover:text-slate-655 text-base">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    
                    <!-- Body -->
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
                            <label class="block text-slate-700 font-bold mb-1">Mata Kuliah</label>
                            <input type="text" name="judul_agenda" value="{{ $ag->mata_kuliah }}" required placeholder="Contoh: Pemrograman Web" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        </div>

                        <div>
                            <label class="block text-slate-700 font-bold mb-1">Fakultas</label>
                            <select name="fakultas" required onchange="handleFakultasChange(this.value, 'input-jurusan-hidden-edit-{{ $ag->id }}', 'label-jurusan-edit-{{ $ag->id }}', 'select-jurusan-dropdown-edit-{{ $ag->id }}')" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                <option value="" disabled>Pilih Fakultas</option>
                                @foreach($fakultas as $fak)
                                    <option value="{{ $fak->nama_fakultas }}" {{ $ag->fakultas == $fak->nama_fakultas ? 'selected' : '' }}>{{ $fak->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="custom-search-select relative">
                            <label class="block text-slate-700 font-bold mb-1">Jurusan / Program Studi</label>
                            <!-- Hidden input to submit the form value -->
                            <input type="hidden" name="jurusan" id="input-jurusan-hidden-edit-{{ $ag->id }}" value="{{ $ag->jurusan }}" required>
                            
                            <!-- Trigger Button -->
                            <button type="button" onclick="toggleSearchSelect('select-jurusan-dropdown-edit-{{ $ag->id }}')" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-left text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none flex justify-between items-center">
                                <span id="label-jurusan-edit-{{ $ag->id }}" class="text-slate-700">{{ $ag->jurusan ?? 'Pilih Program Studi' }}</span>
                                <i class="fa-solid fa-chevron-down text-slate-400 text-[10px]"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="select-jurusan-dropdown-edit-{{ $ag->id }}" class="absolute left-0 right-0 mt-1 bg-white border border-slate-250 rounded-xl shadow-xl z-55 hidden flex flex-col max-h-60 overflow-hidden">
                                <!-- Search Input -->
                                <div class="p-2 border-b border-slate-100 sticky top-0 bg-white">
                                    <div class="relative">
                                        <input type="text" onkeyup="filterSearchSelect('select-jurusan-dropdown-edit-{{ $ag->id }}', this.value)" placeholder="Cari Program Studi..." class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none text-xs">
                                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-[10px]"></i>
                                    </div>
                                </div>
                                
                                <!-- Options List -->
                                <div class="overflow-y-auto flex-grow py-1 max-h-44 scrollbar-thin">
                                    @foreach($prodis as $prod)
                                        <button type="button" data-fakultas="{{ $prod->fakultas->nama_fakultas }}" onclick="selectSearchOption('input-jurusan-hidden-edit-{{ $ag->id }}', 'label-jurusan-edit-{{ $ag->id }}', 'select-jurusan-dropdown-edit-{{ $ag->id }}', '{{ $prod->nama_prodi }}')" class="w-full text-left px-4 py-2 hover:bg-slate-50 text-slate-755 transition text-xs select-option-item">
                                            {{ $prod->nama_prodi }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Program</label>
                                <select name="program_kuliah" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                    <option value="Reguler" {{ $ag->program_kuliah == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                    <option value="Karyawan" {{ $ag->program_kuliah == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Kelas</label>
                                <select name="kelas" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                    <option value="" disabled>Pilih Kelas</option>
                                    @foreach(['A', 'B', 'C', 'D'] as $kelasOpt)
                                        <option value="{{ $kelasOpt }}" {{ $ag->kelas == $kelasOpt ? 'selected' : '' }}>Kelas {{ $kelasOpt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-slate-700 font-bold mb-1">Semester</label>
                                <select name="semester" required class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                                    <option value="" disabled>Pilih Semester</option>
                                    @foreach(['1','2','3','4','5','6','7','8'] as $semOpt)
                                        <option value="{{ $semOpt }}" {{ $ag->semester == $semOpt ? 'selected' : '' }}>Semester {{ $semOpt }}</option>
                                    @endforeach
                                </select>
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
                            <textarea name="rencana_pembelajaran" rows="3" required placeholder="Tuliskan materi..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-700 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">{{ $ag->catatan }}</textarea>
                        </div>

                        <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                            <button type="button" onclick="toggleModal('modal-edit-agenda-{{ $ag->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-lg transition">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Collapsible Section: Kehadiran Mahasiswa -->
        <details class="bg-white border border-slate-200 rounded-xl overflow-hidden group">
            <summary class="px-4 py-3 bg-slate-50/50 hover:bg-slate-100/60 font-bold text-xs text-slate-655 cursor-pointer flex items-center justify-between transition-all select-none">
                <span><i class="fa-solid fa-list-check text-teal-700 mr-1.5"></i> Lihat Detail Kehadiran Kelas</span>
                <i class="fa-solid fa-chevron-down group-open:rotate-180 transition-transform"></i>
            </summary>
            <div class="p-4 border-t border-slate-100">
                @if($ag->absensi->count() > 0)
                    <div class="overflow-x-auto border border-slate-100 rounded-lg text-xs">
                        <table class="w-full text-left text-slate-650">
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
                                        <td class="p-2.5 font-mono text-slate-450">{{ $idx + 1 }}</td>
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
                    <p class="text-center text-xs text-slate-400 italic py-4">Belum ada data presensi/kehadiran mahasiswa untuk kelas ini.</p>
                @endif
            </div>
        </details>
    </div>
    @endforeach

    <div class="pt-4">
        {{ $agendas->links() }}
    </div>
@else
    <div class="text-center py-12">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto text-slate-400 mb-4 text-2xl">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
        <p class="text-sm text-slate-500 font-semibold">Tidak ada data agenda ditemukan.</p>
    </div>
@endif
