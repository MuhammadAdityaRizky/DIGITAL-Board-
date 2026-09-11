<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengumuman - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

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
            
            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ auth()->user()->username }}</p>
                        <p class="text-[9px] font-semibold tracking-wider text-slate-500 uppercase">SUPER ADMIN</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border border-teal-200 flex items-center justify-center font-bold text-xs transition transform group-hover:scale-105 shadow-xs">
                        {{ strtoupper(substr(auth()->user()->username ?? 'AD', 0, 2)) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ auth()->user()->username ?? 'Administrator' }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-md text-[9px] font-bold uppercase tracking-wider">
                            Super Admin
                        </span>
                    </div>

                    <div class="p-1">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 rounded-xl transition font-bold text-left group">
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
                                <div class="bg-slate-50 p-4.5 rounded-xl border border-slate-200 relative group shadow-xs space-y-3">
                                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                                        @if($p->foto_url)
                                            <div class="shrink-0">
                                                <a href="{{ asset('storage/' . $p->foto_url) }}" target="_blank" title="Klik untuk memperbesar" class="block group/img">
                                                    <img src="{{ asset('storage/' . $p->foto_url) }}" alt="Foto Pengumuman" class="w-28 h-28 sm:w-36 sm:h-36 rounded-xl border border-slate-200 object-cover shadow-xs group-hover/img:opacity-90 transition">
                                                </a>
                                            </div>
                                        @endif

                                        <div class="flex-grow min-w-0 pr-16 sm:pr-20 space-y-1.5">
                                            <h4 class="font-bold text-sm text-slate-800 leading-snug">{{ $p->judul }}</h4>
                                            <p class="text-xs text-slate-650 leading-relaxed whitespace-pre-line">{{ $p->isi_pengumuman }}</p>
                                        </div>

                                        <div class="flex items-center gap-2 absolute right-4 top-4">
                                            <button onclick='editAnnouncement(@json($p))' class="text-teal-700 hover:text-teal-900 text-sm transition p-1" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button onclick="confirmDelete('{{ route('admin.pengumuman.delete', $p->id) }}')" class="text-rose-500 hover:text-rose-700 text-sm transition p-1" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                        </div>
                                    </div>

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
            
            <form id="ann-form" action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <input type="hidden" id="ann-method" name="_method" value="POST">
                
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Judul Pengumuman</label>
                    <input type="text" id="ann-judul" name="judul" required placeholder="Masukkan judul pengumuman..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Isi Detail Pengumuman</label>
                    <textarea id="ann-isi_pengumuman" name="isi_pengumuman" rows="4" required placeholder="Tulis rincian penjelasan pengumuman di sini..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Foto / Gambar Pengumuman (Opsional)</label>
                    <input type="file" id="ann-foto" name="foto" accept="image/*" class="w-full p-2 text-xs rounded-lg bg-slate-50 border border-slate-200 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-teal-100 file:text-teal-800 hover:file:bg-teal-200 cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-1">* Format: JPG, PNG, WEBP, GIF, SVG (Maks. 5MB)</p>
                    
                    <div id="ann-foto-preview-container" class="mt-2.5 hidden p-2 bg-slate-100/80 rounded-xl border border-slate-200 flex items-center gap-3">
                        <img id="ann-foto-preview" src="" alt="Pratinjau Foto" class="w-14 h-14 object-cover rounded-lg border border-slate-300 shadow-xs">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold text-slate-700 block">Foto Pengumuman Saat Ini</span>
                            <label class="inline-flex items-center gap-1.5 text-[10px] text-rose-600 font-bold cursor-pointer hover:text-rose-700">
                                <input type="checkbox" id="ann-hapus-foto" name="hapus_foto" value="1" class="rounded text-rose-600 focus:ring-rose-500">
                                <span>Hapus foto saat ini</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Mulai Berlaku (Opsional)</label>
                        <input type="datetime-local" id="ann-tanggal_mulai" name="tanggal_mulai" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">Berakhir Pada (Opsional)</label>
                        <input type="datetime-local" id="ann-tanggal_selesai" name="tanggal_selesai" class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-slate-700 font-bold">Tampilkan di Ruangan</label>
                        <label class="inline-flex items-center gap-1.5 text-[10px] font-bold text-teal-800 cursor-pointer select-none hover:text-teal-900">
                            <input type="checkbox" id="select-all-labs" class="rounded text-teal-600 focus:ring-teal-500">
                            <span>Pilih Semua</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto p-2 border border-slate-200 rounded-lg bg-slate-50">
                        @foreach($laboratoriums as $lab)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="laboratorium_ids[]" value="{{ $lab->id }}" class="rounded text-teal-600 focus:ring-teal-500 lab-checkbox">
                            <span>{{ $lab->nama_lab }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-slate-500 mt-1">* Kosongkan jika pengumuman ini tidak ditujukan ke ruang spesifik (atau tampil di semua).</p>
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
    @include('admin.partials.bottom_nav')

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
                document.getElementById('ann-tanggal_mulai').value = "";
                document.getElementById('ann-tanggal_selesai').value = "";
                document.getElementById('ann-submit-btn').innerText = "Terbitkan";
                document.getElementById('ann-foto').value = "";
                document.getElementById('ann-hapus-foto').checked = false;
                document.getElementById('ann-foto-preview-container').classList.add('hidden');
                document.getElementById('ann-foto-preview').src = "";
                if (document.getElementById('select-all-labs')) {
                    document.getElementById('select-all-labs').checked = false;
                }
                
                // Clear checkboxes
                document.querySelectorAll('input[name="laboratorium_ids[]"]').forEach(cb => cb.checked = false);
            }
        }

        function editAnnouncement(ann) {
            document.getElementById('modal-ann-title').innerText = "Edit Pengumuman Resmi";
            
            const updateUrl = `/admin/pengumuman/${ann.id}`;
            document.getElementById('ann-form').action = updateUrl;
            document.getElementById('ann-method').value = "PUT";
            
            document.getElementById('ann-judul').value = ann.judul;
            document.getElementById('ann-isi_pengumuman').value = ann.isi_pengumuman;
            document.getElementById('ann-tanggal_mulai').value = ann.tanggal_mulai ? ann.tanggal_mulai.substring(0, 16) : "";
            document.getElementById('ann-tanggal_selesai').value = ann.tanggal_selesai ? ann.tanggal_selesai.substring(0, 16) : "";
            document.getElementById('ann-submit-btn').innerText = "Simpan Perubahan";
            
            document.getElementById('ann-foto').value = "";
            document.getElementById('ann-hapus-foto').checked = false;
            
            const previewContainer = document.getElementById('ann-foto-preview-container');
            const previewImg = document.getElementById('ann-foto-preview');
            if (ann.foto_url) {
                previewImg.src = `/storage/${ann.foto_url}`;
                previewContainer.classList.remove('hidden');
            } else {
                previewImg.src = "";
                previewContainer.classList.add('hidden');
            }
            
            // Set checkboxes
            const labIds = ann.laboratoriums ? ann.laboratoriums.map(l => l.id.toString()) : [];
            document.querySelectorAll('input[name="laboratorium_ids[]"]').forEach(cb => {
                cb.checked = labIds.includes(cb.value);
            });
            
            toggleModal('modal-announcement');
        }

        const selectAllLabs = document.getElementById('select-all-labs');
        const labCbs = document.querySelectorAll('.lab-checkbox');
        if (selectAllLabs) {
            selectAllLabs.addEventListener('change', function() {
                labCbs.forEach(cb => cb.checked = selectAllLabs.checked);
            });
        }

        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Hapus Pengumuman?',
                text: 'Apakah Anda yakin ingin menghapus pengumuman ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl',
                    title: 'text-lg font-extrabold text-slate-800',
                    htmlContainer: 'text-xs text-slate-600 font-medium',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm',
                    cancelButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    if (form) {
                        form.action = deleteUrl;
                        form.dataset.confirmed = "true";
                        form.submit();
                    }
                }
            });
        }

        function closeDeleteModal() {
            document.getElementById('modal-confirm-delete').classList.add('hidden');
        }
    </script>

    <!-- SweetAlert2 Automatic Alerts & Loading Handler -->
    <script>
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
                    if (e.defaultPrevented) return;
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




