<!-- MODAL TUTORIAL & PANDUAN PENGGUNAAN SISTEM UNTUK MAHASISWA -->
<div id="modal-tutorial-mahasiswa" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden text-left animate-in fade-in zoom-in duration-150">
        
        <!-- Header Modal -->
        <div class="px-6 py-5 flex justify-between items-center flex-shrink-0 text-white border-b border-teal-950/40 rounded-t-3xl" style="background: linear-gradient(135deg, #042f2e 0%, #0d9488 55%, #0f172a 100%);">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center font-black text-white text-lg shadow-inner shrink-0">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-base sm:text-lg tracking-tight text-white">Panduan Mahasiswa: Absensi & Kuliah</h3>
                    <p class="text-xs text-teal-100 font-semibold">Petunjuk Praktis Penggunaan Portal DIGITAL Board</p>
                </div>
            </div>
            <button type="button" onclick="closeTutorialMahasiswaModal()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-sm transition cursor-pointer border border-white/15 shrink-0" title="Tutup Modal">
                <i class="fa-solid fa-xmark text-base"></i>
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
            <button type="button" onclick="switchMhsTutorialTab('tab-mhs-riwayat')" id="btn-mhs-riwayat" class="px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-chart-pie text-emerald-600"></i> 3. Rekap Kehadiran
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
                            <strong class="text-slate-900 block font-bold text-xs">Buka Kamera / Scanner di Portal Mahasiswa</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Klik tombol scan QR di dashboard atau navigasi bawah, lalu arahkan kamera HP Anda ke layar Smart Board.
                            </p>
                        </div>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-teal-800 text-white font-extrabold flex items-center justify-center shrink-0 text-xs">3</span>
                        <div>
                            <strong class="text-slate-900 block font-bold text-xs">Presensi Otomatis Berhasil</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Notifikasi berhasil akan langsung muncul dan status kehadiran Anda otomatis tercatat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: JADWAL & RUANG -->
            <div id="tab-mhs-agenda" class="hidden space-y-4">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-700 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-blue-950">Melihat Agenda Perkuliahan & Pemakaian Lab</h4>
                        <p class="text-blue-900 font-medium mt-1 leading-relaxed">
                            Pantau seluruh jadwal perkuliahan, ruang laboratorium, dan dosen pengampu secara berkala.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">Tab "Untuk Saya"</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Secara otomatis menyaring dan hanya menampilkan jadwal praktikum khusus untuk kelas, semester, dan prodi Anda.
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">Tab "Semua Agenda Lab"</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Melihat seluruh jadwal pemakaian laboratorium di seluruh fakultas untuk mengecek ketersediaan lab kosong.
                        </p>
                    </div>
                </div>
            </div>

            <!-- TAB 3: REKAP KEHADIRAN -->
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
                            Jika Anda merasa hadir di kelas namun terlewat scan QR atau memiliki kendala izin, segera konfirmasi langsung kepada dosen pengajar agar status dapat disesuaikan secara manual.
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
        const tabs = ['tab-mhs-absen', 'tab-mhs-agenda', 'tab-mhs-riwayat'];
        tabs.forEach(t => {
            const el = document.getElementById(t);
            const btn = document.getElementById('btn-' + t);
            if (el) {
                if (t === tabId) {
                    el.classList.remove('hidden');
                    if (btn) {
                        btn.className = "px-4 py-2.5 rounded-t-xl font-extrabold transition border-b-2 border-teal-800 bg-white text-teal-900 shadow-2xs flex items-center gap-2 whitespace-nowrap";
                    }
                } else {
                    el.classList.add('hidden');
                    if (btn) {
                        btn.className = "px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap";
                    }
                }
            }
        });
    }
</script>
