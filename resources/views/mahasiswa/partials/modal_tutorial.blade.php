<!-- MODAL TUTORIAL & PANDUAN PENGGUNAAN SISTEM UNTUK MAHASISWA -->
<div id="modal-tutorial-mahasiswa" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden text-left animate-in fade-in zoom-in duration-150">
        
        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-teal-900 via-teal-800 to-slate-900 text-white px-6 py-5 flex justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-teal-700/80 border border-teal-500/40 flex items-center justify-center font-black text-white text-lg shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-base sm:text-lg tracking-tight">Panduan Mahasiswa: Absensi & Kuliah</h3>
                    <p class="text-xs text-teal-200 font-bold">Petunjuk Praktis Penggunaan Portal DIGITAL Board</p>
                </div>
            </div>
            <button type="button" onclick="closeTutorialMahasiswaModal()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex border-b border-slate-200 bg-slate-50 px-4 pt-3 gap-2 overflow-x-auto flex-shrink-0 text-xs">
            <button type="button" onclick="switchMhsTutorialTab('tab-mhs-absen')" id="btn-mhs-absen" class="px-4 py-2.5 rounded-t-xl font-extrabold transition border-b-2 border-teal-800 bg-white text-teal-900 shadow-2xs flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-qrcode text-teal-700"></i> 1. Cara Absen QR
            </button>
            <button type="button" onclick="switchMhsTutorialTab('tab-mhs-agenda')" id="btn-mhs-agenda" class="px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-calendar-days text-blue-600"></i> 2. Jadwal & Ruang
            </button>
            <button type="button" onclick="switchMhsTutorialTab('tab-mhs-izin')" id="btn-mhs-izin" class="px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-file-signature text-amber-600"></i> 3. Izin & Sakit
            </button>
            <button type="button" onclick="switchMhsTutorialTab('tab-mhs-riwayat')" id="btn-mhs-riwayat" class="px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-chart-pie text-emerald-600"></i> 4. Rekap Kehadiran
            </button>
        </div>

        <!-- Tab Contents (Scrollable) -->
        <div class="p-6 overflow-y-auto space-y-4 text-xs flex-1 bg-white">
            
            <!-- TAB 1: CARA ABSEN QR -->
            <div id="tab-mhs-absen" class="space-y-4">
                <div class="p-4 bg-teal-50 border border-teal-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-teal-700 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-teal-950">Langkah Absensi di Laboratorium</h4>
                        <p class="text-teal-900 font-medium mt-1 leading-relaxed">
                            Presensi kehadiran dilakukan dengan memindai kode QR dinamis yang ditampilkan pada layar Smart Board di laboratorium.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-teal-800 text-white font-extrabold flex items-center justify-center shrink-0 text-xs">1</span>
                        <div>
                            <strong class="text-slate-900 block font-bold text-xs">Hadir di Ruang Laboratorium Tepat Waktu</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Pastikan Anda sudah berada di dalam ruangan lab sesuai jadwal mata kuliah yang sedang berlangsung.
                            </p>
                        </div>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-teal-800 text-white font-extrabold flex items-center justify-center shrink-0 text-xs">2</span>
                        <div>
                            <strong class="text-slate-900 block font-bold text-xs">Buka Kamera HP atau Tombol "Scan QR"</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Klik tombol <strong>"Scan QR Presensi"</strong> di Dashboard portal mahasiswa, atau gunakan aplikasi scanner kamera smartphone Anda.
                            </p>
                        </div>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-teal-800 text-white font-extrabold flex items-center justify-center shrink-0 text-xs">3</span>
                        <div>
                            <strong class="text-slate-900 block font-bold text-xs">Arahkan Kamera ke Layar Smart Board Lab</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Arahkan kamera ke QR Code yang berganti setiap 5 detik di layar depan kelas. Status kehadiran Anda akan langsung tersimpan dan otomatis menjadi <strong class="text-emerald-700">Hadir</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: JADWAL & RUANG -->
            <div id="tab-mhs-agenda" class="hidden space-y-4">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-700 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-blue-950">Melihat Agenda Kuliah & Lokasi Ruang Lab</h4>
                        <p class="text-blue-900 font-medium mt-1 leading-relaxed">
                            Cek jadwal perkuliahan Anda secara berkala agar tidak salah ruangan atau terlambat masuk kelas.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">Menu "Agenda Kuliah"</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Di menu ini Anda dapat melihat daftar seluruh pertemuan perkuliahan, lengkap dengan nama dosen pengampu, materi rencana, dan jam pelaksanaan.
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">Cek Lokasi Lab</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Setiap kartu agenda mencantumkan nama lab dan lokasinya (contoh: <em>Lab 209 - Gedung FTS Lantai 2</em>). Jika terdapat jadwal pengganti, ruangan lab mungkin dipindahkan ke lab lain yang kosong.
                        </p>
                    </div>
                </div>
            </div>

            <!-- TAB 3: IZIN & SAKIT -->
            <div id="tab-mhs-izin" class="hidden space-y-4">
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-file-medical"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-amber-950">Pengajuan Surat Izin atau Keterangan Sakit</h4>
                        <p class="text-amber-900 font-medium mt-1 leading-relaxed">
                            Jika Anda berhalangan hadir pada sesi perkuliahan, segera ajukan izin resmi sebelum atau sesaat setelah perkuliahan selesai.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">1. Buka Agenda Perkuliahan Hari Ini</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Klik tombol <strong>"Ajukan Perizinan"</strong> pada sesi pertemuan yang ingin Anda mintakan dispensasi.
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">2. Unggah Foto Bukti Surat yang Sah</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Lampirkan foto surat dokter (jika sakit) atau surat dispensasi/tugas resmi (jika ada keperluan dinas/kampus). Tuliskan alasan secara jelas dan sopan.
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">3. Verifikasi oleh Dosen Pengampu</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Dosen pengampu akan memeriksa permohonan Anda. Setelah disetujui, status Anda di rekapitulasi akan berubah menjadi <strong class="text-blue-700">Izin</strong> atau <strong class="text-amber-700">Sakit</strong> (bukan Alpa).
                        </p>
                    </div>
                </div>
            </div>

            <!-- TAB 4: REKAP KEHADIRAN -->
            <div id="tab-mhs-riwayat" class="hidden space-y-4">
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-emerald-950">Memantau Rekapitulasi Persentase Kehadiran</h4>
                        <p class="text-emerald-900 font-medium mt-1 leading-relaxed">
                            Kehadiran minimal 75% adalah syarat mutlak untuk dapat mengikuti Ujian Akhir Semester (UAS).
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">Menu "Riwayat Kehadiran"</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Di menu ini Anda dapat melihat rincian jumlah Hadir, Terlambat, Izin, Sakit, dan Alpa untuk setiap mata kuliah yang Anda kontrak di semester ini.
                        </p>
                    </div>

                    <div class="p-3.5 bg-emerald-50/70 border border-emerald-300 rounded-xl space-y-1">
                        <strong class="text-emerald-950 block font-bold text-xs">Pemberitahuan Dosen Manual</strong>
                        <p class="text-emerald-900 font-medium leading-relaxed">
                            Jika Anda merasa hadir di kelas namun terlewat scan QR, segera konfirmasi langsung kepada dosen pengajar sebelum perkuliahan hari itu ditutup agar dosen dapat menginput status Hadir secara manual.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Modal -->
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between flex-shrink-0">
            <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                <i class="fa-solid fa-circle-info text-teal-700"></i> Simpan petunjuk ini sebagai acuan praktikum Anda.
            </span>
            <button type="button" onclick="closeTutorialMahasiswaModal()" class="px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white font-extrabold rounded-xl transition text-xs shadow-sm cursor-pointer">
                Mengerti & Tutup Panduan
            </button>
        </div>

    </div>
</div>

<script>
    function openTutorialMahasiswaModal() {
        const modal = document.getElementById('modal-tutorial-mahasiswa');
        if (modal) modal.classList.remove('hidden');
    }

    function closeTutorialMahasiswaModal() {
        const modal = document.getElementById('modal-tutorial-mahasiswa');
        if (modal) modal.classList.add('hidden');
    }

    function switchMhsTutorialTab(tabId) {
        const tabs = ['tab-mhs-absen', 'tab-mhs-agenda', 'tab-mhs-izin', 'tab-mhs-riwayat'];
        tabs.forEach(t => {
            const el = document.getElementById(t);
            const btn = document.getElementById('btn-' + t);
            if (el) {
                if (t === tabId) {
                    el.classList.remove('hidden');
                } else {
                    el.classList.add('hidden');
                }
            }
            if (btn) {
                if (t === tabId) {
                    btn.classList.add('border-b-2', 'border-teal-800', 'bg-white', 'text-teal-900', 'shadow-2xs');
                    btn.classList.remove('text-slate-600');
                } else {
                    btn.classList.remove('border-b-2', 'border-teal-800', 'bg-white', 'text-teal-900', 'shadow-2xs');
                    btn.classList.add('text-slate-600');
                }
            }
        });
    }
</script>
