<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Perizinan - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-gear"></i>
                <span class="text-xs font-semibold tracking-wide">Pengaturan</span>
            </a>
        </nav>

        <div class="p-6 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-rose-400 hover:text-rose-300 text-xs font-bold w-full transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
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

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ $dosen->nama }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">Dosen Informatika</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr($dosen->nama, 0, 2) }}
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

    <!-- Bottom Navigation Bar (Mobile Only - Figma Design) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('dosen.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-border-all text-lg"></i>
            <span class="text-[9px] font-medium">Dashboard</span>
        </a>
        <a href="{{ route('dosen.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-calendar-alt text-lg"></i>
            <span class="text-[9px] font-medium">Agenda</span>
        </a>
        <!-- Floating FAB button style from Figma -->
        <div class="relative w-14 h-14 -mt-6 flex justify-center items-center bg-teal-850 text-white rounded-2xl shadow-md border-4 border-slate-50">
            <a href="{{ route('dosen.perizinan') }}" class="flex items-center justify-center w-full h-full text-white">
                <i class="fa-solid fa-file-signature text-lg"></i>
            </a>
        </div>
        <a href="{{ route('dosen.mahasiswa') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-users text-lg"></i>
            <span class="text-[9px] font-medium">Mahasiswa</span>
        </a>
        <a href="{{ route('dosen.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-medium">Pengaturan</span>
        </a>
    </nav>

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
                document.body.style.overflow = 'hidden'; // Disable scroll background
            }
        }

        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = ''; // Enable scroll background
            }
        }
        
        // Close modal on Escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>

</body>
</html>
