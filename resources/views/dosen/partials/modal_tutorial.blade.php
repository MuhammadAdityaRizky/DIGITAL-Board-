<!-- MODAL TUTORIAL & PANDUAN PENGGUNAAN SISTEM UNTUK DOSEN -->
<div id="modal-tutorial-dosen" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden text-left animate-in fade-in zoom-in duration-150">
        
        <!-- Header Modal -->
        <div class="bg-gradient-to-r from-teal-900 via-teal-800 to-slate-900 text-white px-6 py-5 flex justify-between items-center flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-teal-700/80 border border-teal-500/40 flex items-center justify-center font-black text-white text-lg shadow-inner">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-base sm:text-lg tracking-tight">Panduan Penggunaan Portal Dosen</h3>
                    <p class="text-xs text-teal-200 font-bold">Petunjuk Praktis Pengelolaan Perkuliahan & Lab</p>
                </div>
            </div>
            <button type="button" onclick="closeTutorialDosenModal()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex border-b border-slate-200 bg-slate-50 px-4 pt-3 gap-2 overflow-x-auto flex-shrink-0 text-xs">
            <button type="button" onclick="switchTutorialTab('tab-presensi')" id="btn-tab-presensi" class="px-4 py-2.5 rounded-t-xl font-extrabold transition border-b-2 border-teal-800 bg-white text-teal-900 shadow-2xs flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-users-viewfinder text-teal-700"></i> 1. Presensi Mahasiswa
            </button>
            <button type="button" onclick="switchTutorialTab('tab-realisasi')" id="btn-tab-realisasi" class="px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-file-signature text-amber-600"></i> 2. Realisasi & Berita Acara
            </button>
            <button type="button" onclick="switchTutorialTab('tab-lab')" id="btn-tab-lab" class="px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-calendar-check text-emerald-600"></i> 3. Ketersediaan Lab
            </button>
            <button type="button" onclick="switchTutorialTab('tab-cetak')" id="btn-tab-cetak" class="px-4 py-2.5 rounded-t-xl font-extrabold transition text-slate-600 hover:text-slate-900 flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-print text-blue-600"></i> 4. Cetak & Rekap
            </button>
        </div>

        <!-- Tab Contents (Scrollable) -->
        <div class="p-6 overflow-y-auto space-y-4 text-xs flex-1 bg-white">
            
            <!-- TAB 1: PRESENSI MAHASISWA -->
            <div id="tab-presensi" class="space-y-4">
                <div class="p-4 bg-teal-50 border border-teal-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-teal-700 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-teal-950">Cara Membuka & Mengelola Presensi</h4>
                        <p class="text-teal-900 font-medium mt-1 leading-relaxed">
                            Presensi mahasiswa dapat dilakukan secara mandiri oleh mahasiswa melalui pemindaian QR di layar Smart Board Lab, atau dikelola manual oleh Anda sebagai Dosen.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-teal-800 text-white font-extrabold flex items-center justify-center shrink-0 text-xs">1</span>
                        <div>
                            <strong class="text-slate-900 block font-bold text-xs">Buka Menu "Agenda Perkuliahan" pada Hari H</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Temukan kartu mata kuliah yang sedang berlangsung hari ini. Tombol <span class="px-2 py-0.5 bg-teal-800 text-white rounded text-[11px] font-bold">Absensi Mahasiswa</span> akan aktif berwarna hijau/teal gelap.
                            </p>
                        </div>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-teal-800 text-white font-extrabold flex items-center justify-center shrink-0 text-xs">2</span>
                        <div>
                            <strong class="text-slate-900 block font-bold text-xs">Absen Masuk Dosen Sendiri</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Klik tombol <strong>"Scan QR"</strong> untuk memindai kode QR Smart Board di lab, atau gunakan tombol <strong>"Hadir Manual Dosen"</strong> jika terdapat kendala kamera.
                            </p>
                        </div>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-teal-800 text-white font-extrabold flex items-center justify-center shrink-0 text-xs">3</span>
                        <div>
                            <strong class="text-slate-900 block font-bold text-xs">Ubah Status Kehadiran (Hadir / Izin / Sakit / Alpa)</strong>
                            <p class="text-slate-600 mt-0.5 font-medium leading-relaxed">
                                Anda bisa mengklik tombol <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded text-[11px] font-bold">Semua Hadir</span> untuk menandai seluruh kelas hadir sekaligus, atau mengubah status mahasiswa tertentu jika ada yang izin via WhatsApp/sakit. Lalu klik <strong>Simpan Perubahan Absensi</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: REALISASI & BERITA ACARA -->
            <div id="tab-realisasi" class="hidden space-y-4">
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-amber-950">Pengisian Realisasi Materi & Berita Acara</h4>
                        <p class="text-amber-900 font-medium mt-1 leading-relaxed">
                            Sebagai bukti pelaksanaan akademik yang sah, Anda diharapkan mengisi materi realisasi yang diajarkan dan ringkasan berita acara.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-4 bg-amber-50/50 border-2 border-amber-200 rounded-2xl space-y-2">
                        <div class="flex items-center gap-2 text-amber-900 font-extrabold">
                            <i class="fa-solid fa-book-open text-amber-700"></i> Tombol "Realisasi"
                        </div>
                        <p class="text-slate-700 font-medium leading-relaxed">
                            Klik tombol kuning bertuliskan <strong>"Isi Realisasi"</strong> pada pertemuan yang telah selesai. Tuliskan materi yang benar-benar disampaikan (misal: <em>Pengenalan Variabel & Looping Array</em>).
                        </p>
                    </div>

                    <div class="p-4 bg-indigo-50/50 border-2 border-indigo-200 rounded-2xl space-y-2">
                        <div class="flex items-center gap-2 text-indigo-950 font-extrabold">
                            <i class="fa-solid fa-file-signature text-indigo-700"></i> Tombol "Berita Acara"
                        </div>
                        <p class="text-slate-700 font-medium leading-relaxed">
                            Klik tombol biru/ungu bertuliskan <strong>"Isi Berita Acara"</strong>. Tuliskan catatan jalannya perkuliahan (misal: <em>Praktikum berjalan lancar, seluruh PC Lab 209 berfungsi baik</em>).
                        </p>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-2.5 text-slate-700">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>Tanda centang hijau <strong class="text-emerald-800">✅</strong> akan otomatis muncul jika Realisasi atau Berita Acara sudah tersimpan rapi.</span>
                </div>
            </div>

            <!-- TAB 3: KETERSEDIAAN LAB & KULIAH PENGGANTI -->
            <div id="tab-lab" class="hidden space-y-4">
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-700 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-emerald-950">Melihat Ruangan Kosong & Kuliah Pengganti</h4>
                        <p class="text-emerald-900 font-medium mt-1 leading-relaxed">
                            Sistem secara otomatis mencegah bentrok ruangan. Anda dapat melihat kapan saja jam kosong di setiap laboratorium komputer.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">1. Buka Menu "Ketersediaan Lab"</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Pilih ruangan laboratorium (misal: <strong>Lab 209</strong>) dan tanggal yang ingin Anda gunakan.
                        </p>
                    </div>

                    <div class="p-3.5 bg-emerald-50/70 border border-emerald-300 rounded-xl space-y-1">
                        <strong class="text-emerald-950 block font-bold text-xs flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> 2. Perhatikan Kotak Warna Hijau vs Merah
                        </strong>
                        <p class="text-emerald-900 font-medium leading-relaxed">
                            - 🟩 <strong>Kotak Hijau (BISA DIPAKAI)</strong>: Jam tersebut kosong. Cukup klik tombol <strong>[ + Pakai Jam Ini ]</strong> untuk langsung memesan sesi.<br>
                            - 🟥 <strong>Kotak Merah (SUDAH TERISI)</strong>: Jam tersebut sedang dipakai oleh mata kuliah & dosen lain.
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">3. Peringatan Otomatis Anti-Bentrok</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Jika Anda tidak sengaja memasukkan jam yang berbenturan dengan dosen lain, sistem akan langsung menolak dan memberi peringatan dengan nama dosen yang sedang menempati lab tersebut.
                        </p>
                    </div>
                </div>
            </div>

            <!-- TAB 4: CETAK & REKAP LAPORAN -->
            <div id="tab-cetak" class="hidden space-y-4">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-700 text-white flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-print"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-sm text-blue-950">Mencetak Rekap Kehadiran Perkuliahan</h4>
                        <p class="text-blue-900 font-medium mt-1 leading-relaxed">
                            Anda dapat mencetak formulir kehadiran resmi untuk kebutuhan tanda tangan laboran, arsip prodi, maupun BAAK.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">Ikon Cetak Printer 🖨️ pada Sesi Pertemuan</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Pada setiap baris sesi pertemuan di halaman <strong>Agenda Perkuliahan</strong>, klik ikon printer di sebelah kanan untuk membuka lembar presensi siap cetak atau simpan ke file PDF.
                        </p>
                    </div>

                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-1">
                        <strong class="text-slate-900 block font-bold text-xs">Import Nilai & Presensi Excel Global</strong>
                        <p class="text-slate-600 font-medium leading-relaxed">
                            Gunakan tombol biru <strong>"Import Excel Global"</strong> di bagian atas halaman Agenda untuk mengunggah rekapan absensi kelas sekaligus dari file spreadsheet Excel Anda.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Modal -->
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between flex-shrink-0">
            <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                <i class="fa-solid fa-circle-info text-teal-700"></i> Anda dapat membuka panduan ini kapan saja.
            </span>
            <button type="button" onclick="closeTutorialDosenModal()" class="px-5 py-2.5 bg-teal-800 hover:bg-teal-900 text-white font-extrabold rounded-xl transition text-xs shadow-sm cursor-pointer">
                Mengerti & Tutup Panduan
            </button>
        </div>

    </div>
</div>

<script>
    function openTutorialDosenModal() {
        const modal = document.getElementById('modal-tutorial-dosen');
        if (modal) modal.classList.remove('hidden');
    }

    function closeTutorialDosenModal() {
        const modal = document.getElementById('modal-tutorial-dosen');
        if (modal) modal.classList.add('hidden');
    }

    function switchTutorialTab(tabId) {
        const tabs = ['tab-presensi', 'tab-realisasi', 'tab-lab', 'tab-cetak'];
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
