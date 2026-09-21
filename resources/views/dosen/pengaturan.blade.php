<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Dosen - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-5 flex items-center gap-3 border-b border-slate-800 shrink-0">
            <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-10 h-10 object-contain shrink-0">
            <div>
                <h1 class="font-bold text-sm leading-tight text-white">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold text-teal-400 tracking-wider">PORTAL DOSEN</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-3 space-y-1">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-border-all text-sm"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-calendar-alt text-sm"></i>
                <span>Agenda Perkuliahan</span>
            </a>
            <a href="{{ route('dosen.jadwal-lab') }}" class="flex items-center gap-3 px-4 py-2.5 text-slate-400 hover:bg-slate-800 hover:text-white font-medium rounded-xl w-full text-xs transition">
                <i class="fa-solid fa-calendar-check text-sm"></i>
                <span>Ketersediaan Lab</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-2.5 bg-teal-800 text-white font-bold shadow-sm rounded-xl w-full text-xs">
                <i class="fa-solid fa-gear text-sm"></i>
                <span>Pengaturan Akun</span>
            </a>
        </nav>

        <!-- Tombol Panduan Dosen di Sidebar -->
        <div class="p-3 border-t border-slate-800 mt-auto">
            <button type="button" onclick="openTutorialDosenModal()" class="min-h-[44px] flex items-center gap-3 px-4 py-3 bg-amber-500/10 border border-amber-500/30 text-amber-300 hover:bg-amber-500/20 hover:text-white rounded-xl w-full transition text-sm font-bold cursor-pointer">
                <i class="fa-solid fa-book-open-reader text-base text-amber-400"></i>
                <span>Panduan Dosen</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0 shadow-xs">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-9 h-9 object-contain flex lg:hidden shrink-0">

                <div>
                    <h2 class="font-extrabold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                    <h2 class="font-extrabold text-lg text-slate-900 hidden lg:block">Pengaturan Akun & Keamanan</h2>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <!-- Tombol Panduan / Tutorial Dosen -->
                <button type="button" onclick="openTutorialDosenModal()" class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-900 rounded-xl text-xs font-extrabold transition shadow-2xs cursor-pointer" title="Buka Panduan & Tutorial Penggunaan Portal Dosen">
                    <i class="fa-solid fa-circle-question text-amber-600 text-sm"></i>
                    <span>Panduan Sistem</span>
                </button>

                <!-- Profile Avatar & Dropdown Menu -->
                <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1.5 rounded-xl hover:bg-slate-100 transition border border-transparent hover:border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="font-extrabold text-sm text-slate-900 group-hover:text-teal-800 transition">{{ $dosen->nama }}</p>
                        <p class="text-xs font-bold text-slate-600">NIP: {{ $dosen->nip }} • Dosen Pengajar</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-teal-100 group-hover:bg-teal-200 text-teal-900 border-2 border-teal-300 flex items-center justify-center font-extrabold text-sm transition transform group-hover:scale-105 shadow-xs">
                        {{ substr($dosen->nama, 0, 2) }}
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-500 group-hover:text-slate-800 transition hidden sm:inline-block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="absolute right-0 top-full mt-2 w-72 bg-white border-2 border-slate-200 rounded-2xl shadow-2xl py-2 z-50 hidden transform transition-all duration-200 origin-top-right">
                    <div class="px-5 py-3.5 border-b border-slate-100 bg-slate-50/70">
                        <p class="text-sm font-extrabold text-slate-900 truncate">{{ $dosen->nama }}</p>
                        <p class="text-xs font-bold text-slate-600 font-mono mt-0.5">NIP: {{ $dosen->nip }}</p>
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
                                <span class="text-xs text-slate-500 block font-normal">Profil & ganti password</span>
                            </div>
                        </a>
                    </div>

                    <div class="pt-1.5 border-t border-slate-100 px-1">
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-700 hover:bg-rose-50 rounded-xl transition font-extrabold text-left group cursor-pointer">
                                <div class="w-8 h-8 rounded-lg bg-rose-100 group-hover:bg-rose-200 text-rose-700 flex items-center justify-center transition">
                                    <i class="fa-solid fa-right-from-bracket text-sm"></i>
                                </div>
                                <span>Keluar / Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-8 space-y-6">
            
            <!-- Banner / Header Info -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-2xs max-w-3xl space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <span class="w-2 h-2 rounded-full bg-slate-900 inline-block"></span>
                    <span>Portal Dosen Pengajar</span>
                </div>
                <h3 class="font-bold text-2xl text-slate-900">Pengaturan Akun & Keamanan</h3>
                <p class="text-base text-slate-600 mt-1">Kelola data resmi akun dosen dan perbarui kata sandi masuk portal.</p>
            </div>

            <!-- Success/Error Alert -->
            @if(session('success'))
                <div class="bg-emerald-50 border-2 border-emerald-300 text-emerald-900 p-4 rounded-xl text-base flex items-start gap-3 shadow-xs max-w-3xl">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-xl flex-shrink-0"></i>
                    <div>
                        <span class="font-bold">Pembaruan Berhasil!</span>
                        <p class="mt-0.5 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border-2 border-rose-300 text-rose-900 p-4 rounded-xl text-base flex items-start gap-3 shadow-xs max-w-3xl">
                    <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-xl flex-shrink-0"></i>
                    <div>
                        <span class="font-bold">Terjadi Kesalahan:</span>
                        <ul class="list-disc list-inside mt-1 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Settings Form Cards -->
            <div class="max-w-3xl space-y-6">
                <!-- Account Info Form -->
                <div class="bg-white border border-slate-200 shadow-2xs rounded-xl p-6 sm:p-8 space-y-6">
                    
                    <div>
                        <h4 class="font-bold text-lg text-slate-900">Data Identitas Dosen</h4>
                        <p class="text-sm text-slate-500 font-medium mt-1">Data identitas berikut terhubung secara terpusat dengan data kepegawaian universitas.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-2">
                                <i class="fa-regular fa-user text-slate-400 text-sm"></i> Nama Lengkap (Resmi)
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ $dosen->nama }}" disabled class="w-full py-3 px-3.5 rounded-lg bg-white border border-slate-300 text-slate-900 font-bold text-base outline-none cursor-not-allowed shadow-2xs">
                                <span class="absolute right-3.5 top-3.5 text-xs text-slate-400" title="Terkunci dari Pusat"><i class="fa-solid fa-lock"></i></span>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5 flex items-center gap-2">
                                <i class="fa-regular fa-id-badge text-slate-400 text-sm"></i> NIP (Nomor Induk Pegawai)
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ $dosen->nip }}" disabled class="w-full py-3 px-3.5 rounded-lg bg-white border border-slate-300 text-slate-900 font-mono font-bold text-base outline-none cursor-not-allowed shadow-2xs">
                                <span class="absolute right-3.5 top-3.5 text-xs text-slate-400" title="Terkunci dari Pusat"><i class="fa-solid fa-lock"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Password Update Section -->
                    <form action="{{ route('dosen.pengaturan.update') }}" method="POST" class="pt-6 border-t border-slate-200 space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <h4 class="font-bold text-lg text-slate-900">Ganti Kata Sandi (Password)</h4>
                            <p class="text-sm text-slate-500 font-medium mt-1">Gunakan kombinasi minimal 6 karakter yang mudah Anda ingat namun sulit ditebak oleh orang lain.</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Kata sandi saat ini <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="input_password_lama" name="password_lama" required placeholder="Masukkan kata sandi saat ini..." class="w-full py-3.5 pl-4 pr-12 rounded-xl bg-white border border-slate-300 text-slate-900 font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition placeholder:text-slate-400 placeholder:font-normal">
                                <button type="button" onclick="togglePasswordVisibility('input_password_lama', this)" class="absolute right-3.5 top-3.5 p-1 text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer" title="Tampilkan kata sandi">
                                    <i class="fa-regular fa-eye text-base"></i>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">
                                    Kata sandi baru <span class="text-rose-600">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="input_password_baru" name="password" required placeholder="Minimal 6 karakter..." class="w-full py-3.5 pl-4 pr-12 rounded-xl bg-white border border-slate-300 text-slate-900 font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition placeholder:text-slate-400 placeholder:font-normal">
                                    <button type="button" onclick="togglePasswordVisibility('input_password_baru', this)" class="absolute right-3.5 top-3.5 p-1 text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer" title="Tampilkan kata sandi">
                                        <i class="fa-regular fa-eye text-base"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">
                                    Ulangi kata sandi baru <span class="text-rose-600">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="input_password_konfirmasi" name="password_confirmation" required placeholder="Ketik ulang kata sandi baru..." class="w-full py-3.5 pl-4 pr-12 rounded-xl bg-white border border-slate-300 text-slate-900 font-bold text-base focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition placeholder:text-slate-400 placeholder:font-normal">
                                    <button type="button" onclick="togglePasswordVisibility('input_password_konfirmasi', this)" class="absolute right-3.5 top-3.5 p-1 text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer" title="Tampilkan kata sandi">
                                        <i class="fa-regular fa-eye text-base"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="w-full sm:w-auto min-h-[48px] px-8 py-3.5 bg-slate-900 hover:bg-slate-800 active:scale-98 text-white rounded-xl font-bold text-base transition shadow-2xs flex items-center justify-center gap-2.5 cursor-pointer">
                                <i class="fa-solid fa-check text-base"></i>
                                <span>Simpan Kata Sandi Baru</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only - Symmetrical Layout with Center QR) -->
    @include('dosen.partials.bottom_nav')

    <!-- Script Password Toggle -->
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

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

    @include('dosen.partials.modal_tutorial')
</body>
</html>
