<!-- Top Navbar (Unified Dosen Header) -->
<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-xs z-20 relative">
    <div class="flex items-center gap-3">
        @if(isset($backUrl))
            <a href="{{ $backUrl }}" class="w-9 h-9 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl flex items-center justify-center transition cursor-pointer shrink-0" title="Kembali">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
        @else
            <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-9 h-9 object-contain flex lg:hidden shrink-0">
        @endif

        <div>
            <h2 class="font-extrabold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
            <h2 class="font-extrabold text-lg text-slate-900 hidden lg:block">{{ $title ?? 'Portal Dosen Pengajar' }}</h2>
        </div>
    </div>

    <div class="flex items-center gap-2.5">
        <!-- Scan QR Board Button in Header -->
        <button type="button" onclick="startDosenQRScanner()" class="hidden md:flex items-center gap-2 px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer" title="Scan QR Code di Layar Digital Board Lab">
            <i class="fa-solid fa-qrcode text-teal-400"></i>
            <span>Scan QR Board</span>
        </button>

        <!-- Cek Ketersediaan Lab Button in Header -->
        <a href="{{ route('dosen.jadwal-lab') }}" class="hidden sm:flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-300 rounded-xl text-xs font-bold transition shadow-xs cursor-pointer" title="Lihat Ketersediaan & Plotting Ruang Lab">
            <i class="fa-solid fa-calendar-check text-teal-700"></i>
            <span>Cek Ketersediaan Lab</span>
        </a>

        <!-- Tombol Panduan / Tutorial Dosen -->
        <button type="button" onclick="openTutorialDosenModal()" class="hidden md:flex items-center gap-2 px-3 py-2 bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-900 rounded-xl text-xs font-extrabold transition shadow-2xs cursor-pointer" title="Buka Panduan & Tutorial Penggunaan Portal Dosen">
            <i class="fa-solid fa-circle-question text-amber-600 text-sm"></i>
            <span>Panduan Sistem</span>
        </button>

        <!-- Profile Avatar & Dropdown Menu -->
        <div class="relative" id="profileDropdownWrapper">
            <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1.5 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200">
                <div class="text-right hidden sm:block">
                    <p class="font-extrabold text-sm text-slate-900 group-hover:text-teal-800 transition">{{ $dosen->nama ?? 'Dosen' }}</p>
                    <p class="text-xs font-bold text-slate-600">NIP: {{ $dosen->nip ?? '-' }} • Dosen Pengajar</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border-2 border-teal-300 flex items-center justify-center font-extrabold text-sm transition transform group-hover:scale-105 shadow-xs">
                    {{ substr($dosen->nama ?? 'D', 0, 2) }}
                </div>
                <i class="fa-solid fa-chevron-down text-xs text-slate-500 group-hover:text-slate-800 transition hidden sm:inline-block"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-72 bg-white border-2 border-slate-200 rounded-2xl shadow-2xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                <div class="px-5 py-3.5 border-b border-slate-100 bg-slate-50/70">
                    <p class="text-sm font-extrabold text-slate-900 truncate">{{ $dosen->nama ?? 'Dosen' }}</p>
                    <p class="text-xs font-bold text-slate-600 font-mono mt-0.5">NIP: {{ $dosen->nip ?? '-' }}</p>
                    <span class="inline-block mt-2 px-2.5 py-0.5 bg-teal-100 text-teal-900 border border-teal-300 rounded-md text-xs font-extrabold">
                        <i class="fa-solid fa-chalkboard-user mr-1"></i> Dosen Pengajar
                    </span>
                </div>

                <div class="py-1.5 px-1">
                    <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-800 hover:bg-teal-50 hover:text-teal-900 rounded-xl transition font-bold group">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 group-hover:bg-teal-200 text-teal-800 flex items-center justify-center transition">
                            <i class="fa-solid fa-gear text-sm"></i>
                        </div>
                        <div>
                            <span class="font-extrabold block">Pengaturan Akun</span>
                            <span class="text-xs text-slate-500 block font-normal">Edit profil & ganti password</span>
                        </div>
                    </a>
                </div>

                <div class="pt-1.5 px-1 border-t border-slate-100">
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold group cursor-pointer">
                            <div class="w-8 h-8 rounded-lg bg-rose-100 group-hover:bg-rose-200 text-rose-600 flex items-center justify-center transition">
                                <i class="fa-solid fa-right-from-bracket text-sm"></i>
                            </div>
                            <div>
                                <span class="font-extrabold block">Keluar (Logout)</span>
                                <span class="text-xs text-rose-400 block font-normal">Akhiri sesi portal dosen</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    if (typeof window.toggleProfileDropdown !== 'function') {
        window.toggleProfileDropdown = function(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        };
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileDropdownMenu');
            const wrapper = document.getElementById('profileDropdownWrapper');
            if (menu && wrapper && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    }
</script>
