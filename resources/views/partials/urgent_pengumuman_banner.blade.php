@if(isset($urgentPengumuman) && $urgentPengumuman->isNotEmpty())
    <div id="urgent-pengumuman-container" class="space-y-3">
        @foreach($urgentPengumuman as $announcement)
            @php
                $isUrgen = ($announcement->prioritas === 'Urgen');
                $borderClass = $isUrgen ? 'border-rose-300 hover:border-rose-400 bg-gradient-to-r from-rose-50/90 via-rose-50/40 to-white' : 'border-amber-300 hover:border-amber-400 bg-gradient-to-r from-amber-50/90 via-amber-50/40 to-white';
                $accentColor = $isUrgen ? 'bg-rose-600' : 'bg-amber-500';
                $badgeBg = $isUrgen ? 'bg-rose-600 text-white' : 'bg-amber-500 text-white';
                $badgeIcon = $isUrgen ? 'fa-triangle-exclamation' : 'fa-circle-exclamation';
                $badgeText = $isUrgen ? 'Darurat / Urgen' : 'Penting';
                $btnColor = $isUrgen ? 'bg-rose-600 hover:bg-rose-700 text-white shadow-rose-200' : 'bg-amber-600 hover:bg-amber-700 text-white shadow-amber-200';
            @endphp
            <div id="urgent-banner-item-{{ $announcement->id }}" 
                 data-pengumuman-id="{{ $announcement->id }}"
                 class="urgent-banner-card relative border-2 {{ $borderClass }} rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 p-4 sm:p-5 overflow-hidden">
                
                <!-- Left Accent Indicator -->
                <div class="absolute left-0 top-0 bottom-0 w-2 {{ $accentColor }}"></div>

                <div class="pl-2.5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <!-- Left: Details & Content -->
                    <div class="space-y-2 flex-1 min-w-0">
                        <!-- Top Metadata Badges -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-black {{ $badgeBg }} shadow-xs tracking-wider uppercase">
                                @if($isUrgen)
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                @endif
                                <i class="fa-solid {{ $badgeIcon }} text-[10px]"></i>
                                {{ $badgeText }}
                            </span>

                            @if($announcement->is_pinned)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-slate-900 text-amber-300 shadow-2xs">
                                    <i class="fa-solid fa-thumbtack text-[10px] text-amber-400"></i> Disematkan
                                </span>
                            @endif

                            <!-- Target Lab Badges -->
                            @if($announcement->laboratoriums && $announcement->laboratoriums->count() > 0)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-[11px] font-bold bg-white border border-slate-300 text-slate-700 shadow-2xs">
                                    <i class="fa-solid fa-door-open text-teal-600"></i>
                                    Lab: {{ $announcement->laboratoriums->pluck('nama_lab')->join(', ') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-[11px] font-bold bg-white border border-slate-300 text-slate-700 shadow-2xs">
                                    <i class="fa-solid fa-building text-slate-500"></i>
                                    Semua Laboratorium
                                </span>
                            @endif

                            <span class="text-[11px] font-medium text-slate-500 inline-flex items-center gap-1">
                                <i class="fa-regular fa-clock text-slate-400"></i>
                                {{ \Carbon\Carbon::parse($announcement->created_at)->translatedFormat('d M Y, H:i') }} WIB
                            </span>
                        </div>

                        <!-- Announcement Title -->
                        <h3 class="text-base sm:text-lg font-black text-slate-900 leading-tight">
                            {{ $announcement->judul }}
                        </h3>

                        <!-- Snippet Text -->
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal line-clamp-2">
                            {{ Str::limit($announcement->isi_pengumuman, 180) }}
                        </p>
                    </div>

                    <!-- Right: Action Buttons & Dismiss -->
                    <div class="pl-2.5 md:pl-0 flex items-center justify-between md:justify-end gap-3 shrink-0">
                        @if($announcement->foto_url)
                            <div class="hidden sm:block shrink-0">
                                <img src="{{ asset('storage/' . $announcement->foto_url) }}" 
                                     alt="Preview Lampiran" 
                                     class="w-12 h-12 rounded-xl object-cover border border-slate-300/80 shadow-2xs cursor-pointer hover:opacity-90"
                                     onclick="openUrgentPengumumanModal({{ $announcement->id }})">
                            </div>
                        @endif

                        <button type="button" 
                                onclick="openUrgentPengumumanModal({{ $announcement->id }})"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-black shadow-sm {{ $btnColor }} transition cursor-pointer">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </button>

                        <button type="button" 
                                onclick="dismissUrgentBanner({{ $announcement->id }})"
                                class="w-8 h-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition cursor-pointer"
                                title="Tutup pemberitahuan ini">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- MODAL DETAIL PENGUMUMAN PENTING & URGEN -->
    <div id="modal-detail-urgent-pengumuman" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden text-left animate-in fade-in zoom-in duration-150">
            
            <!-- Header Modal -->
            <div id="modal-urgent-header" class="px-6 py-5 flex justify-between items-center flex-shrink-0 text-white rounded-t-3xl transition-colors duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center font-black text-white text-lg shadow-inner shrink-0">
                        <i id="modal-urgent-icon" class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <span id="modal-urgent-badge" class="inline-block px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider bg-white/20 text-white mb-0.5">
                            Pengumuman Penting
                        </span>
                        <h3 id="modal-urgent-title" class="font-extrabold text-base sm:text-lg tracking-tight text-white line-clamp-1">
                            Judul Pengumuman
                        </h3>
                    </div>
                </div>
                <button type="button" onclick="closeUrgentPengumumanModal()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-sm transition cursor-pointer border border-white/15 shrink-0" title="Tutup Modal">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Content Area (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-4 text-xs flex-1 bg-white">
                
                <!-- Metadata Bar -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl flex flex-wrap items-center justify-between gap-3 text-slate-600">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="font-medium inline-flex items-center gap-1.5">
                            <i class="fa-regular fa-user text-slate-400"></i>
                            Oleh: <strong id="modal-urgent-author" class="text-slate-800 font-bold">Admin</strong>
                        </span>
                        <span class="text-slate-300">•</span>
                        <span class="font-medium inline-flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-slate-400"></i>
                            <span id="modal-urgent-date">16 Okt 2026</span>
                        </span>
                    </div>

                    <div id="modal-urgent-lab-wrap">
                        <!-- Lab badges inserted here -->
                    </div>
                </div>

                <!-- Periode Tayang (Jika Ada) -->
                <div id="modal-urgent-periode-wrap" class="p-3 bg-teal-50/80 border border-teal-200 rounded-xl text-teal-900 hidden flex items-center gap-2">
                    <i class="fa-solid fa-calendar-range text-teal-600"></i>
                    <span class="font-bold">Masa Berlaku Pengumuman:</span>
                    <span id="modal-urgent-periode" class="font-medium"></span>
                </div>

                <!-- Isi Pengumuman -->
                <div class="space-y-2">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-500">Isi Pengumuman:</h4>
                    <div id="modal-urgent-body" class="p-4 bg-slate-50/60 border border-slate-200 rounded-2xl text-slate-800 text-sm leading-relaxed whitespace-pre-line font-normal">
                    </div>
                </div>

                <!-- Foto Lampiran (Jika Ada) -->
                <div id="modal-urgent-foto-wrap" class="space-y-2 hidden">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-500">Lampiran Foto / Dokumen:</h4>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-2xl text-center space-y-2">
                        <img id="modal-urgent-img" src="" alt="Lampiran Pengumuman" class="max-h-80 w-auto rounded-xl mx-auto border border-slate-300 shadow-sm object-contain">
                        <div>
                            <a id="modal-urgent-img-link" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Buka Gambar Ukuran Penuh
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end items-center flex-shrink-0">
                <button type="button" onclick="closeUrgentPengumumanModal()" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition cursor-pointer">
                    Tutup Pengumuman
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Payload JSON for Modals -->
    <script id="urgent-pengumuman-payload" type="application/json">
        {!! json_encode($urgentPengumuman->keyBy('id')) !!}
    </script>

    <script>
        (function() {
            // Restore dismissal from sessionStorage
            document.querySelectorAll('.urgent-banner-card').forEach(function(card) {
                var id = card.getAttribute('data-pengumuman-id');
                if (id && sessionStorage.getItem('dismiss_pengumuman_' + id) === 'true') {
                    card.remove();
                }
            });

            var container = document.getElementById('urgent-pengumuman-container');
            if (container && container.querySelectorAll('.urgent-banner-card').length === 0) {
                container.remove();
            }
        })();

        function dismissUrgentBanner(id) {
            var el = document.getElementById('urgent-banner-item-' + id);
            if (el) {
                el.style.transition = 'all 0.25s ease-out';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    el.remove();
                    var container = document.getElementById('urgent-pengumuman-container');
                    if (container && container.querySelectorAll('.urgent-banner-card').length === 0) {
                        container.remove();
                    }
                }, 250);
            }
            sessionStorage.setItem('dismiss_pengumuman_' + id, 'true');
        }

        function openUrgentPengumumanModal(id) {
            var payloadEl = document.getElementById('urgent-pengumuman-payload');
            if (!payloadEl) return;
            var data = JSON.parse(payloadEl.textContent || '{}');
            var item = data[id];
            if (!item) return;

            var modal = document.getElementById('modal-detail-urgent-pengumuman');
            var header = document.getElementById('modal-urgent-header');
            var icon = document.getElementById('modal-urgent-icon');
            var badge = document.getElementById('modal-urgent-badge');
            var title = document.getElementById('modal-urgent-title');
            var author = document.getElementById('modal-urgent-author');
            var date = document.getElementById('modal-urgent-date');
            var body = document.getElementById('modal-urgent-body');
            var labWrap = document.getElementById('modal-urgent-lab-wrap');
            var periodeWrap = document.getElementById('modal-urgent-periode-wrap');
            var periode = document.getElementById('modal-urgent-periode');
            var fotoWrap = document.getElementById('modal-urgent-foto-wrap');
            var img = document.getElementById('modal-urgent-img');
            var imgLink = document.getElementById('modal-urgent-img-link');

            var isUrgen = item.prioritas === 'Urgen';
            if (isUrgen) {
                header.style.background = 'linear-gradient(135deg, #881337 0%, #e11d48 100%)';
                icon.className = 'fa-solid fa-triangle-exclamation';
                badge.textContent = 'DARURAT / URGEN';
            } else {
                header.style.background = 'linear-gradient(135deg, #78350f 0%, #d97706 100%)';
                icon.className = 'fa-solid fa-circle-exclamation';
                badge.textContent = 'PENGUMUMAN PENTING';
            }

            title.textContent = item.judul || '';
            author.textContent = (item.admin && item.admin.name) ? item.admin.name : 'Admin Laboratorium';
            
            // Format created_at date
            if (item.created_at) {
                try {
                    var d = new Date(item.created_at);
                    date.textContent = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) + ' WIB';
                } catch(e) {
                    date.textContent = item.created_at;
                }
            } else {
                date.textContent = '-';
            }

            body.textContent = item.isi_pengumuman || '';

            // Labs
            if (item.laboratoriums && item.laboratoriums.length > 0) {
                var labNames = item.laboratoriums.map(function(l) { return l.nama_lab; }).join(', ');
                labWrap.innerHTML = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-white border border-slate-300 text-slate-800 shadow-2xs"><i class="fa-solid fa-door-open text-teal-600"></i> Lab: ' + labNames + '</span>';
            } else {
                labWrap.innerHTML = '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-white border border-slate-300 text-slate-800 shadow-2xs"><i class="fa-solid fa-building text-slate-500"></i> Semua Lab</span>';
            }

            // Periode
            if (item.tanggal_mulai || item.tanggal_selesai) {
                periodeWrap.classList.remove('hidden');
                var textPeriode = (item.tanggal_mulai || 'Sekarang') + ' s/d ' + (item.tanggal_selesai || 'Selesai');
                periode.textContent = textPeriode;
            } else {
                periodeWrap.classList.add('hidden');
            }

            // Foto
            if (item.foto_url) {
                fotoWrap.classList.remove('hidden');
                var storageUrl = "{{ asset('storage') }}/" + item.foto_url;
                img.src = storageUrl;
                imgLink.href = storageUrl;
            } else {
                fotoWrap.classList.add('hidden');
                img.src = '';
                imgLink.href = '#';
            }

            modal.classList.remove('hidden');
        }

        function closeUrgentPengumumanModal() {
            var modal = document.getElementById('modal-detail-urgent-pengumuman');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Close on backdrop click
        document.addEventListener('click', function(e) {
            var modal = document.getElementById('modal-detail-urgent-pengumuman');
            if (modal && !modal.classList.contains('hidden') && e.target === modal) {
                closeUrgentPengumumanModal();
            }
        });
    </script>
@endif
