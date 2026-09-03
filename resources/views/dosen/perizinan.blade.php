<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Perizinan - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold tracking-wider text-teal-400">Smart Lab Management</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-border-all"></i>
                <span class="text-xs font-semibold tracking-wide">Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-alt"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda</span>
            </a>
            <a href="{{ route('dosen.mahasiswa') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-users"></i>
                <span class="text-xs font-semibold tracking-wide">Daftar Mahasiswa</span>
            </a>
            <a href="{{ route('dosen.perizinan') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full">
                <i class="fa-solid fa-file-signature"></i>
                <span class="text-xs font-semibold tracking-wide">Verifikasi Perizinan</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Verifikasi Perizinan Mahasiswa</h2>
            </div>

            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ $dosen->nama }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIP: {{ $dosen->nip }} • Dosen</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ substr($dosen->nama, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-64 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $dosen->nama }}</p>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">NIP: {{ $dosen->nip }}</p>
                        <span class="inline-block mt-1.5 px-2 py-0.5 bg-teal-50 text-teal-700 border border-teal-200/60 rounded-md text-[9px] font-bold">
                            Dosen Pengajar
                        </span>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-teal-50 hover:text-teal-800 transition font-medium group">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-teal-100 group-hover:text-teal-700 flex items-center justify-center text-slate-500 transition">
                                <i class="fa-solid fa-gear text-xs"></i>
                            </div>
                            <div>
                                <span class="font-bold block">Pengaturan Akun</span>
                                <span class="text-[10px] text-slate-400 block font-normal">Edit profil & ganti password</span>
                            </div>
                        </a>
                    </div>

                    <div class="pt-1 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 transition font-bold text-left group">
                                <div class="w-7 h-7 rounded-lg bg-rose-50 group-hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                </div>
                                <span>Keluar / Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Success/Error Alert -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-855 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabs Layout -->
            <div class="space-y-4" x-data="{ activeTab: 'pending' }">
                <!-- Tab Buttons -->
                <div class="flex border-b border-slate-200 text-xs font-bold uppercase tracking-wider">
                    <button @click="activeTab = 'pending'" 
                            :class="activeTab === 'pending' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                            class="px-5 py-3 transition focus:outline-none flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Menunggu Persetujuan
                        <span class="bg-rose-100 text-rose-700 rounded-full px-2 py-0.5 text-[10px] font-bold">
                            {{ $perizinans->filter(fn($p) => strtolower($p->status_persetujuan) === 'pending')->count() }}
                        </span>
                    </button>
                    <button @click="activeTab = 'history'" 
                            :class="activeTab === 'history' ? 'border-teal-700 text-teal-850 border-b-2' : 'text-slate-400 hover:text-slate-700'"
                            class="px-5 py-3 transition focus:outline-none flex items-center gap-2">
                        <i class="fa-solid fa-history"></i>
                        Riwayat Perizinan
                        <span class="bg-slate-100 text-slate-650 rounded-full px-2 py-0.5 text-[10px]">
                            {{ $perizinans->filter(fn($p) => strtolower($p->status_persetujuan) !== 'pending')->count() }}
                        </span>
                    </button>
                </div>

                <!-- Tab Pending -->
                <div x-show="activeTab === 'pending'" class="space-y-4">
                    @php
                        $pendingIzin = $perizinans->filter(fn($p) => strtolower($p->status_persetujuan) === 'pending');
                    @endphp
                    @if($pendingIzin->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($pendingIzin as $p)
                                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4 flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-start gap-2">
                                            <div>
                                                <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $p->mahasiswa->nama_lengkap }}</h4>
                                                <span class="text-[10px] font-mono text-teal-800 font-bold tracking-wide">NIM: {{ $p->mahasiswa->nim }}</span>
                                            </div>
                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 font-bold rounded text-[9px] uppercase tracking-wider">Pending</span>
                                        </div>
                                        
                                        <div class="p-3 bg-slate-50 border border-slate-150 rounded-xl space-y-1.5 text-xs">
                                            <p class="text-slate-500 font-medium">Praktikum:</p>
                                            <p class="font-bold text-slate-800 leading-tight">{{ $p->agenda->mata_kuliah }}</p>
                                            <p class="text-[10px] text-slate-450"><i class="fa-solid fa-calendar mr-1"></i>{{ date('d M Y', strtotime($p->agenda->tanggal)) }} | {{ $p->agenda->lab->nama_lab }}</p>
                                        </div>

                                        <div class="space-y-1 text-xs">
                                            <p class="text-slate-500 font-medium">Alasan Izin:</p>
                                            <p class="text-slate-800 bg-teal-50/20 p-2.5 rounded-lg border border-teal-100/40 italic">"{{ $p->alasan }}"</p>
                                        </div>

                                        @if($p->bukti_url)
                                             @php
                                                 $ext = strtolower(pathinfo($p->bukti_url, PATHINFO_EXTENSION));
                                                 $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                             @endphp
                                             @if($isImage)
                                                 <div class="space-y-1.5">
                                                     <p class="text-slate-500 font-medium text-xs">Dokumen Bukti Surat:</p>
                                                     <div onclick="showImageModal('{{ asset($p->bukti_url) }}')" class="border border-slate-200 rounded-lg p-1 bg-white shadow-sm cursor-pointer hover:border-teal-500 transition-all inline-block" style="max-w-[180px]; max-width: 180px; overflow: hidden;">
                                                         <img src="{{ asset($p->bukti_url) }}" alt="Bukti Surat" style="height: 100px; max-height: 100px; width: auto; object-fit: contain; border-radius: 6px; display: block;">
                                                     </div>
                                                     <div class="text-right">
                                                         <button type="button" onclick="showImageModal('{{ asset($p->bukti_url) }}')" class="text-teal-700 hover:text-teal-900 text-[10px] font-bold inline-flex items-center gap-1 transition">
                                                             <i class="fa-solid fa-up-right-from-square"></i> Buka Ukuran Penuh
                                                         </button>
                                                     </div>
                                                 </div>
                                             @else
                                                 <div class="text-xs">
                                                     <a href="{{ asset($p->bukti_url) }}" target="_blank" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1.5 transition p-2 bg-teal-50/50 rounded-lg border border-teal-100">
                                                         <i class="fa-solid fa-file-pdf text-rose-600"></i> Lihat Dokumen Bukti Surat (PDF)
                                                     </a>
                                                 </div>
                                             @endif
                                         @else
                                             <p class="text-slate-400 italic text-[11px]"><i class="fa-solid fa-circle-info"></i> Tidak ada unggahan bukti surat</p>
                                         @endif
                                    </div>

                                    <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                                        <form action="{{ route('dosen.perizinan.verifikasi', $p->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('dosen.perizinan.verifikasi', $p->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="w-full py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 bg-white border border-slate-200 rounded-2xl shadow-sm text-slate-400">
                            <i class="fa-solid fa-circle-check text-3xl block mb-2 text-emerald-500"></i>
                            Tidak ada pengajuan izin pending yang membutuhkan persetujuan.
                        </div>
                    @endif
                </div>

                <!-- Tab History -->
                <div x-show="activeTab === 'history'" class="space-y-4" style="display: none;">
                    @php
                        $historyIzin = $perizinans->filter(fn($p) => strtolower($p->status_persetujuan) !== 'pending');
                    @endphp
                    @if($historyIzin->count() > 0)
                        <div class="overflow-x-auto border border-slate-200 bg-white rounded-xl shadow-sm">
                            <table class="w-full text-xs text-left text-slate-650">
                                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                                    <tr>
                                        <th class="p-4">Mahasiswa</th>
                                        <th class="p-4">Praktikum / Tanggal</th>
                                        <th class="p-4">Alasan</th>
                                        <th class="p-4">Bukti</th>
                                        <th class="p-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($historyIzin as $h)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="p-4">
                                                <span class="font-bold text-slate-800 block text-sm leading-tight">{{ $h->mahasiswa->nama_lengkap }}</span>
                                                <span class="text-[10px] font-mono text-teal-800 font-bold">NIM: {{ $h->mahasiswa->nim }}</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="font-bold text-slate-850 block leading-tight">{{ $h->agenda->mata_kuliah }}</span>
                                                <span class="text-[10px] text-slate-450">{{ date('d M Y', strtotime($h->agenda->tanggal)) }}</span>
                                            </td>
                                            <td class="p-4 max-w-xs truncate italic">"{{ $h->alasan }}"</td>
                                            <td class="p-4">
                                                @if($h->bukti_url)
                                                    @php
                                                        $h_ext = strtolower(pathinfo($h->bukti_url, PATHINFO_EXTENSION));
                                                        $h_isImage = in_array($h_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                    @endphp
                                                    @if($h_isImage)
                                                        <div class="flex items-center gap-1.5">
                                                            <div onclick="showImageModal('{{ asset($h->bukti_url) }}')" class="block border border-slate-200 rounded p-0.5 bg-white hover:border-teal-500 transition shadow-sm cursor-pointer">
                                                                <img src="{{ asset($h->bukti_url) }}" alt="Bukti" class="w-8 h-8 object-cover rounded">
                                                            </div>
                                                            <button type="button" onclick="showImageModal('{{ asset($h->bukti_url) }}')" class="text-teal-700 hover:text-teal-900 font-bold text-xs">
                                                                Buka
                                                            </button>
                                                        </div>
                                                    @else
                                                        <a href="{{ asset($h->bukti_url) }}" target="_blank" class="text-teal-700 hover:text-teal-900 font-bold flex items-center gap-1 text-xs">
                                                            <i class="fa-solid fa-file-pdf text-rose-600"></i> PDF
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-slate-400 italic text-xs">None</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                @if(strtolower($h->status_persetujuan) === 'disetujui')
                                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold rounded text-[10px] uppercase">Disetujui</span>
                                                @else
                                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 font-bold rounded text-[10px] uppercase">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 bg-white border border-slate-200 rounded-2xl shadow-sm text-slate-400">
                            <i class="fa-solid fa-history text-2xl block mb-2"></i>
                            Belum ada riwayat perizinan yang diproses.
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical Layout with Center QR) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-medium">Agenda</span>
        </a>
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-800 text-white rounded-2xl shadow-xl border-4 border-white">
            <button type="button" onclick="startDosenQRScanner()" class="flex items-center justify-center w-full h-full text-white bg-teal-800 rounded-xl hover:bg-teal-900 transition-all" title="Scan QR Presensi">
                <i class="fa-solid fa-qrcode text-2xl text-white"></i>
            </button>
        </div>
        <a href="{{ route('dosen.mahasiswa') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-users text-lg"></i>
            <span class="text-[9px] font-medium">Mahasiswa</span>
        </a>
        <a href="{{ route('dosen.perizinan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-800 font-bold">
            <i class="fa-solid fa-file-signature text-lg"></i>
            <span class="text-[9px] font-bold">Perizinan</span>
        </a>
    </nav>

    <!-- Profile Dropdown Handler -->
    <script>
        function toggleProfileDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const wrapper = document.getElementById('profileDropdownWrapper');
            const menu = document.getElementById('profileDropdownMenu');
            if (wrapper && menu && !wrapper.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    <!-- Import Alpine.js (for simple tabs logic) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Image Modal -->
    <div id="image-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeImageModal()"></div>
        
        <!-- Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-full md:max-w-[90vw] lg:max-w-[80vw] max-h-[90vh] overflow-hidden flex flex-col z-10 w-fit mx-auto animate-fade-in">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 gap-8">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-file-image text-teal-700"></i> Bukti Surat Perizinan
                </h3>
                <button type="button" onclick="closeImageModal()" class="text-slate-400 hover:text-slate-650 text-lg transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-4 bg-slate-50 overflow-y-auto flex items-center justify-center flex-1 min-h-[200px]">
                <img id="modal-preview-image" src="" alt="Pratinjau Bukti" class="max-h-[60vh] max-w-full md:max-w-[85vw] lg:max-w-[75vw] rounded-xl object-contain shadow-sm border border-slate-200 bg-white">
            </div>
            
            <!-- Modal Footer -->
            <div class="px-5 py-3.5 bg-slate-100 border-t border-slate-200/50 flex justify-end items-center text-xs">
                <a id="modal-download-link" href="" target="_blank" class="px-4 py-2 bg-teal-800 hover:bg-teal-900 text-white font-bold rounded-lg shadow-sm transition flex items-center gap-1.5">
                    <i class="fa-solid fa-download"></i> Unduh Asli
                </a>
            </div>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function showImageModal(src) {
            const modal = document.getElementById('image-modal');
            const img = document.getElementById('modal-preview-image');
            const downloadLink = document.getElementById('modal-download-link');
            
            if (modal && img && downloadLink) {
                img.src = src;
                downloadLink.href = src;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }
        
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>

    <!-- Hidden form for QR attendance submission -->
    <form id="dosen-absensi-form" action="{{ route('dosen.absensi.submit') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="qr_code_token" id="dosen-qr-token-input">
    </form>

    <!-- QR Scanner Modal -->
    <div id="modal-qr-scanner" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100 text-slate-800">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i class="fa-solid fa-camera text-teal-800"></i> Pindai QR Code Board
                </h3>
                <button type="button" onclick="closeScannerModal()" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <div class="space-y-4">
                <div id="qr-reader" class="overflow-hidden rounded-xl border border-slate-200" style="width: 100%; min-height: 250px;"></div>
                <div id="qr-reader-results" class="text-center text-xs text-slate-500 font-mono"></div>
            </div>
            
            <div class="flex pt-3 border-t border-slate-100">
                <button type="button" onclick="closeScannerModal()" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <!-- html5-qrcode script -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let html5QrcodeScanner = null;

        function startDosenQRScanner() {
            document.getElementById('modal-qr-scanner').classList.remove('hidden');
            
            html5QrcodeScanner = new Html5Qrcode("qr-reader");
            const config = { fps: 10, qrbox: { width: 220, height: 220 } };
            
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    let cameraId = devices[0].id;
                    for (let i = 0; i < devices.length; i++) {
                        const label = devices[i].label.toLowerCase();
                        if (label.includes('back') || label.includes('rear') || label.includes('lingkungan') || label.includes('belakang')) {
                            cameraId = devices[i].id;
                            break;
                        }
                    }
                    
                    html5QrcodeScanner.start(
                        cameraId,
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {}
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                } else {
                    html5QrcodeScanner.start(
                        { facingMode: "environment" },
                        config,
                        (decodedText, decodedResult) => {
                            document.getElementById('dosen-qr-token-input').value = decodedText;
                            document.getElementById('dosen-absensi-form').submit();
                            closeScannerModal();
                        },
                        (errorMessage) => {}
                    ).catch((err) => {
                        console.error("Gagal memulai kamera: ", err);
                        alert("Gagal mengakses kamera. Detail: " + err);
                        closeScannerModal();
                    });
                }
            }).catch(err => {
                console.error("Gagal getCameras: ", err);
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText, decodedResult) => {
                        document.getElementById('dosen-qr-token-input').value = decodedText;
                        document.getElementById('dosen-absensi-form').submit();
                        closeScannerModal();
                    },
                    (errorMessage) => {}
                ).catch((err2) => {
                    console.error("Gagal memulai kamera: ", err2);
                    alert("Gagal mengakses kamera. Detail:\n1. " + err + "\n2. " + err2);
                    closeScannerModal();
                });
            });
        }

        function closeScannerModal() {
            document.getElementById('modal-qr-scanner').classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner = null;
                }).catch(err => {
                    console.error("Gagal menghentikan scanner: ", err);
                });
            }
        }
    </script>

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
        function confirmAction(event, text, title = 'Apakah Anda yakin?', confirmText = 'Ya, Lanjutkan!') {
            event.preventDefault();
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.dataset.confirmed = "true";
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            });
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium'
                    }
                });
            @endif

            @if(session('error') || session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error') ?? session('failed')),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            @if($errors->any() && !session('success') && !session('error') && !session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memproses Data!',
                    text: @json($errors->first()),
                    confirmButtonColor: '#0c4ea6',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            // CRUD & Form Submit Loading Spinner
            document.querySelectorAll('form').forEach(function(form) {
                if (form.method.toUpperCase() === 'GET' || form.classList.contains('no-loading')) {
                    return;
                }

                form.addEventListener('submit', function(e) {
                    if (form.checkValidity && !form.checkValidity()) {
                        return;
                    }

                    const fileInput = form.querySelector('input[type="file"]');
                    if (fileInput && fileInput.required && fileInput.files && fileInput.files.length === 0) {
                        return;
                    }

                    const isLogout = (form.action && form.action.includes('logout')) || form.classList.contains('logout-form');
                    const isImport = form.getAttribute('enctype') === 'multipart/form-data';
                    
                    let loadingTitle = 'Menyimpan Data...';
                    let loadingText = 'Sedang memproses dan menyimpan data ke sistem.';
                    
                    if (isLogout) {
                        loadingTitle = 'Sedang Keluar...';
                        loadingText = 'Menutup sesi akun Anda dengan aman.';
                    } else if (isImport) {
                        loadingTitle = 'Mengimpor Data...';
                        loadingText = 'Sistem sedang membaca dan memproses file Excel/CSV.';
                    }

                    Swal.fire({
                        title: loadingTitle,
                        text: loadingText,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl p-8 shadow-2xl border border-slate-100',
                            title: 'text-base font-extrabold text-slate-800',
                            htmlContainer: 'text-xs text-slate-500 font-medium'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        }
                    }, 10);
                });
            });
        });

        window.addEventListener('pageshow', function() {
            if (typeof Swal !== 'undefined' && Swal.isVisible() && Swal.isLoading()) {
                Swal.close();
            }
        });
    </script>
</body>
</html>
