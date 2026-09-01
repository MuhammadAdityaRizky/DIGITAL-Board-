<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengumuman - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white">
                <i class="fa-solid fa-user-shield text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">ADMIN CONTROL PANEL</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-line"></i>
                <span class="text-xs">Dashboard Overview</span>
            </a>
            <a href="{{ route('admin.pengguna') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-users-gear"></i>
                <span class="text-xs">Manajemen Pengguna</span>
            </a>
            <a href="{{ route('admin.laboratorium') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-door-open"></i>
                <span class="text-xs">Manajemen Lab</span>
            </a>
            <a href="{{ route('admin.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs">Jadwal & Agenda</span>
            </a>
            <a href="{{ route('admin.absensi') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-file-invoice"></i>
                <span class="text-xs">Laporan Absensi</span>
            </a>
            <a href="{{ route('admin.statistik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="text-xs">Statistik Kehadiran</span>
            </a>
            <a href="{{ route('admin.akademik') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="text-xs">Data Akademik</span>
            </a>
            <a href="{{ route('admin.pengumuman') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
                <i class="fa-solid fa-bullhorn"></i>
                <span class="text-xs">Pengumuman Lab</span>
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

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-teal-800 text-white rounded-lg flex lg:hidden items-center justify-center font-bold">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Pengumuman Laboratorium</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ auth()->user()->username }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">SUPER ADMIN</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr(auth()->user()->username, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-6 space-y-6">

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-855 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-4xl">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search & Action Bar -->
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between max-w-4xl">
                <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm w-full sm:w-96 text-xs">
                    <form action="{{ route('admin.pengumuman') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi pengumuman..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400"></i>
                    </form>
                </div>

                <button onclick="toggleModal('modal-announcement')" class="w-full sm:w-auto px-4 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-plus"></i> Terbitkan Pengumuman
                </button>
            </div>

            <!-- Announcements List -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden max-w-4xl">
                <div class="bg-slate-50/50 border-b border-slate-200 px-6 py-4">
                    <h3 class="font-bold text-sm text-slate-800">Daftar Pengumuman Resmi Laboratorium</h3>
                </div>
                <div class="p-6">
                    @if($pengumumanList->count() > 0)
                        <div class="space-y-4">
                            @foreach($pengumumanList as $p)
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3 relative group shadow-xs">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold text-sm text-slate-800 pr-20">{{ $p->judul }}</h4>
                                        
                                        <div class="flex items-center gap-2 absolute right-4 top-4">
                                            <button onclick='editAnnouncement(@json($p))' class="text-teal-700 hover:text-teal-900 text-sm transition" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button onclick="confirmDelete('{{ route('admin.pengumuman.delete', $p->id) }}')" class="text-rose-500 hover:text-rose-700 text-sm transition" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-650 leading-relaxed">{{ $p->isi_pengumuman }}</p>
                                    
                                    <div class="flex justify-between text-[10px] text-slate-450 pt-2 border-t border-slate-200/60">
                                        <span>Diterbitkan Oleh: <strong class="text-slate-600">{{ $p->admin->username }}</strong></span>
                                        <span><i class="fa-solid fa-calendar mr-1"></i> {{ date('d F Y', strtotime($p->created_at)) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-6">
                            {{ $pengumumanList->links() }}
                        </div>
                    @else
                        <p class="text-center py-10 text-slate-400 italic">Belum ada pengumuman terbit.</p>
                    @endif
                </div>
            </div>

        </div>
    </main>

    <!-- ANNOUNCEMENT MODAL -->
    <div id="modal-announcement" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-md w-full p-6 space-y-5">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 id="modal-ann-title" class="font-bold text-base text-slate-800">Terbitkan Pengumuman Resmi</h3>
                <button onclick="toggleModal('modal-announcement')" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>
            
            <form id="ann-form" action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" id="ann-method" name="_method" value="POST">
                
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Judul Pengumuman</label>
                    <input type="text" id="ann-judul" name="judul" required placeholder="Masukkan judul pengumuman..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Isi Detail Pengumuman</label>
                    <textarea id="ann-isi_pengumuman" name="isi_pengumuman" rows="5" required placeholder="Tulis rincian penjelasan pengumuman di sini..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none"></textarea>
                </div>
                <div class="flex gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-announcement')" class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold">Batal</button>
                    <button type="submit" id="ann-submit-btn" class="flex-1 py-2.5 bg-teal-800 hover:bg-teal-900 text-white rounded-lg font-bold shadow-sm">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CONFIRM DELETE MODAL -->
    <div id="modal-confirm-delete" class="fixed inset-0 bg-slate-900/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-sm w-full p-6 space-y-4 text-center">
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div class="space-y-2">
                <h3 class="font-bold text-sm text-slate-800">Konfirmasi Hapus</h3>
                <p class="text-xs text-slate-550 leading-relaxed">Apakah Anda yakin ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <form id="delete-form" action="" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-bold text-xs">Batal</button>
                <button type="submit" class="flex-grow py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-bold text-xs shadow-sm">Hapus Pengumuman</button>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg text-[9px] font-medium text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-chart-line text-lg"></i>
            <span>Overview</span>
        </a>
        <a href="{{ route('admin.pengguna') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-users-gear text-lg"></i>
            <span>Pengguna</span>
        </a>
        <a href="{{ route('admin.laboratorium') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-door-open text-lg"></i>
            <span>Lab</span>
        </a>
        <a href="{{ route('admin.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-calendar-days text-lg"></i>
            <span>Agenda</span>
        </a>
        <a href="{{ route('admin.absensi') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 hover:text-slate-800">
            <i class="fa-solid fa-file-invoice text-lg"></i>
            <span>Absen</span>
        </a>
    </nav>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
            
            if (modalId === 'modal-announcement' && modal.classList.contains('hidden')) {
                // Reset to create mode
                document.getElementById('modal-ann-title').innerText = "Terbitkan Pengumuman Resmi";
                document.getElementById('ann-form').action = "{{ route('admin.pengumuman.store') }}";
                document.getElementById('ann-method').value = "POST";
                document.getElementById('ann-judul').value = "";
                document.getElementById('ann-isi_pengumuman').value = "";
                document.getElementById('ann-submit-btn').innerText = "Terbitkan";
            }
        }

        function editAnnouncement(ann) {
            document.getElementById('modal-ann-title').innerText = "Edit Pengumuman Resmi";
            
            const updateUrl = `{{ url('admin/pengumuman') }}/${ann.id}`;
            document.getElementById('ann-form').action = updateUrl;
            document.getElementById('ann-method').value = "PUT";
            
            document.getElementById('ann-judul').value = ann.judul;
            document.getElementById('ann-isi_pengumuman').value = ann.isi_pengumuman;
            document.getElementById('ann-submit-btn').innerText = "Simpan Perubahan";
            
            toggleModal('modal-announcement');
        }

        function confirmDelete(deleteUrl) {
            document.getElementById('delete-form').action = deleteUrl;
            document.getElementById('modal-confirm-delete').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('modal-confirm-delete').classList.add('hidden');
        }
    </script>
</body>
</html>
