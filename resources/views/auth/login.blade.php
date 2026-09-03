<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIKA Login Portal - Sistem Digital Information Board</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Subtle Dot Matrix Background for Outer Canvas */
        .bg-dot-pattern {
            background-image: radial-gradient(rgba(148, 163, 184, 0.25) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* Dashboard Slate & Teal High-Tech Grid Background for Banner */
        .hero-grid-pattern {
            background-color: #0f172a;
            background-image: 
                radial-gradient(circle at 25% 20%, rgba(13, 148, 136, 0.3) 0%, transparent 60%),
                radial-gradient(circle at 80% 80%, rgba(20, 184, 166, 0.2) 0%, transparent 55%),
                linear-gradient(to right, rgba(255, 255, 255, 0.06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.06) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 32px 32px, 32px 32px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }
    </style>
</head>
<body class="min-h-screen bg-[#f1f5f9] bg-dot-pattern antialiased selection:bg-teal-600 selection:text-white flex flex-col justify-center items-center p-3 sm:p-6 lg:p-10">

    <!-- MAIN CONTAINER (Compact Rounded Card on Mobile, Split View on Desktop) -->
    <div class="w-full max-w-[460px] lg:max-w-[1020px] bg-white border border-slate-200/90 rounded-[28px] lg:rounded-[32px] shadow-2xl shadow-slate-300/40 p-0 lg:p-6 overflow-hidden transition-all duration-300">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 lg:gap-8 items-stretch">
            
            <!-- LEFT / TOP PANEL: BRANDING BANNER (Slim & Compact on Mobile, Full-Height Column on Desktop) -->
            <div class="lg:col-span-5 hero-grid-pattern rounded-none lg:rounded-[24px] p-4 sm:p-6 lg:p-9 text-white flex flex-col justify-between relative overflow-hidden shadow-none lg:shadow-lg lg:shadow-slate-950/30 border-b lg:border-b-0 lg:border border-slate-800/80">
                
                <!-- Ambient Glow Decoration -->
                <div class="absolute -top-24 -right-24 w-60 h-60 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-52 h-52 bg-teal-600/15 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Top Branding Section -->
                <div class="relative z-10">
                    
                    <!-- Mobile Compact Horizontal Header / Desktop Vertical Stack -->
                    <div class="flex items-center gap-3.5 lg:block">
                        <!-- Logo Box -->
                        <div class="inline-flex items-center justify-center p-2 bg-white/95 backdrop-blur-md rounded-2xl shadow-sm border border-white/40 shrink-0">
                            <a href="{{ route('board') }}" title="Ke Halaman Display Board" class="transition transform hover:scale-105">
                                <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                                     alt="Logo UIKA" 
                                     class="w-10 h-10 sm:w-11 sm:h-11 lg:w-12 lg:h-12 object-contain">
                            </a>
                        </div>

                        <!-- Badge (Desktop Only) -->
                        <div class="hidden lg:block mt-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-950/80 border border-teal-400/40 text-teal-300 text-[10px] font-extrabold uppercase tracking-widest">
                                <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                                PORTAL AKADEMIK RESMI
                            </span>
                        </div>

                        <!-- Campus Title & Subtitle -->
                        <div class="lg:mt-3">
                            <h1 class="text-base sm:text-lg lg:text-3xl font-black tracking-tight uppercase leading-tight text-white">
                                UNIVERSITAS IBN<span class="inline lg:hidden"> </span><br class="hidden lg:inline">KHALDUN
                            </h1>
                            <p class="text-[10px] sm:text-xs font-bold text-teal-400 tracking-wider uppercase mt-0.5 sm:mt-1">
                                SISTEM DIGITAL INFORMATION BOARD
                            </p>
                        </div>
                    </div>

                    <!-- Long Description (Desktop Only) -->
                    <div class="hidden lg:block border-l-2 border-teal-400/70 pl-3.5 py-0.5 mt-6">
                        <p class="text-[13px] text-slate-200/90 leading-relaxed font-normal">
                            Portal Akses Pengguna, Dosen, dan Mahasiswa untuk tata kelola perkuliahan, administrasi digital, dan sistem informasi kampus terpadu.
                        </p>
                    </div>
                </div>

                <!-- Bottom Trust Badges (Desktop Only) -->
                <div class="hidden lg:block relative z-10 pt-6 mt-6 border-t border-slate-800 space-y-2.5 text-xs text-slate-300 font-medium">
                    <div class="flex items-center gap-2.5">
                        <div class="w-5 h-5 rounded-full bg-teal-950/90 border border-teal-500/30 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-teal-400 text-[10px]"></i>
                        </div>
                        <span class="text-xs">Autentikasi Terenkripsi SSL 256-Bit</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-5 h-5 rounded-full bg-teal-950/90 border border-teal-500/30 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-building-columns text-teal-400 text-[10px]"></i>
                        </div>
                        <span class="text-xs">Kampus UIKA Bogor - Jl. KH. Sholeh Iskandar</span>
                    </div>
                </div>

            </div>

            <!-- RIGHT PANEL: LOGIN FORM & ACTIONS -->
            <div class="lg:col-span-7 flex flex-col justify-center p-5 sm:p-6 lg:p-6 lg:py-4">
                
                <!-- Form Header -->
                <div class="mb-4 sm:mb-5">
                    <h2 class="text-xl sm:text-2xl lg:text-[26px] font-black text-slate-900 tracking-tight">
                        Masuk ke Akun
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium mt-0.5 sm:mt-1">
                        Silakan masukkan kredensial akun Anda
                    </p>
                </div>

                <!-- Main Login Form -->
                <form id="loginForm" action="{{ route('login') }}" method="POST" class="space-y-3.5 sm:space-y-4">
                    @csrf
                    
                    <!-- Error Notification Alert -->
                    @if ($errors->any())
                        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-3 rounded-xl text-xs flex items-start gap-2.5 shadow-xs">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5 shrink-0"></i>
                            <div>
                                <span class="font-extrabold">Gagal Masuk:</span>
                                <p class="mt-0.5 text-rose-700 font-medium">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Identifier Input (NIM / NIP / Username) -->
                    <div class="space-y-1">
                        <label for="username_or_nim_nip" class="block text-[11px] font-extrabold tracking-wider text-slate-700 uppercase">
                            NIM / NIP / USERNAME
                        </label>
                        <div class="relative flex items-center">
                            <i class="fa-regular fa-user absolute left-4 text-slate-400 text-sm pointer-events-none z-10"></i>
                            <input type="text" 
                                   id="username_or_nim_nip"
                                   name="username_or_nim_nip" 
                                   required 
                                   value="{{ old('username_or_nim_nip') }}"
                                   placeholder="Masukkan NIM, NIP, atau Username" 
                                   class="w-full min-h-[48px] bg-white border border-slate-200 rounded-xl py-3 pl-11 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 focus:bg-white transition duration-200 shadow-xs">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1">
                        <label for="password" class="block text-[11px] font-extrabold tracking-wider text-slate-700 uppercase">
                            PASSWORD
                        </label>
                        <div class="relative flex items-center">
                            <i class="fa-solid fa-lock absolute left-4 text-slate-400 text-sm pointer-events-none z-10"></i>
                            <input type="password" 
                                   id="password"
                                   name="password" 
                                   required 
                                   placeholder="Masukkan password" 
                                   class="w-full min-h-[48px] bg-white border border-slate-200 rounded-xl py-3 pl-11 pr-11 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 focus:bg-white transition duration-200 shadow-xs">
                            <button type="button" 
                                    onclick="togglePassword()" 
                                    class="absolute right-3 text-slate-400 hover:text-slate-600 focus:outline-none p-2 transition cursor-pointer flex items-center justify-center z-10 min-w-[36px] min-h-[36px]"
                                    title="Tampilkan/Sembunyikan Password"
                                    aria-label="Toggle Password Visibility">
                                <i class="fa-regular fa-eye text-sm" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Options Row: Ingat Saya & Lupa Password -->
                    <div class="flex items-center justify-between text-xs pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium select-none py-1">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                            <span>Ingat saya</span>
                        </label>
                        <a href="javascript:void(0)" onclick="showForgotPasswordAlert()" class="text-slate-600 hover:text-teal-600 font-semibold transition py-1">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="loginSubmitBtn" class="w-full min-h-[48px] py-3.5 rounded-xl bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-extrabold text-xs sm:text-sm tracking-wider uppercase shadow-md shadow-teal-900/20 hover:shadow-lg transition duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <span>MASUK SEKARANG</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </form>

                <!-- Divider DEMO QUICK LOGIN -->
                <div class="relative flex py-3.5 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-3 text-[10px] text-slate-400 uppercase tracking-widest font-extrabold">DEMO QUICK LOGIN</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <!-- Quick Demo Accounts (3 Cards) -->
                <div class="grid grid-cols-3 gap-2 sm:gap-3">
                    <!-- Admin Button -->
                    <a href="{{ route('demo.login', 'admin') }}" 
                       class="demo-login-btn p-2.5 sm:p-3 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl sm:rounded-2xl text-center transition duration-200 group shadow-xs">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center mx-auto mb-1 group-hover:scale-110 transition transform">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 block leading-tight">Admin</span>
                        <span class="text-[9px] sm:text-[10px] text-slate-400 font-medium block mt-0.5">Staf & Biro</span>
                    </a>

                    <!-- Dosen Button -->
                    <a href="{{ route('demo.login', 'dosen') }}" 
                       class="demo-login-btn p-2.5 sm:p-3 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl sm:rounded-2xl text-center transition duration-200 group shadow-xs">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-1 group-hover:scale-110 transition transform">
                            <i class="fa-solid fa-id-badge text-xs"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 block leading-tight">Dosen</span>
                        <span class="text-[9px] sm:text-[10px] text-slate-400 font-medium block mt-0.5">NIP / NIDN</span>
                    </a>

                    <!-- Mahasiswa Button -->
                    <a href="{{ route('demo.login', 'mahasiswa') }}" 
                       class="demo-login-btn p-2.5 sm:p-3 bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl sm:rounded-2xl text-center transition duration-200 group shadow-xs">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center mx-auto mb-1 group-hover:scale-110 transition transform">
                            <i class="fa-solid fa-graduation-cap text-xs"></i>
                        </div>
                        <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 block leading-tight">Mahasiswa</span>
                        <span class="text-[9px] sm:text-[10px] text-slate-400 font-medium block mt-0.5">NIM Mahasiswa</span>
                    </a>
                </div>

                <!-- Footer Help Link -->
                <div class="text-center pt-3.5 sm:pt-4 text-xs text-slate-500 font-medium">
                    Butuh bantuan kendala akun? 
                    <a href="javascript:void(0)" onclick="showSupportModal()" class="font-bold text-slate-800 hover:text-teal-600 inline-flex items-center gap-1 transition">
                        Hubungi IT Support / BAAK <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>

            </div>

        </div>

    </div>

    <!-- MOBILE BOTTOM TRUST BADGES (Shown below card on small screens) -->
    <div class="flex lg:hidden items-center justify-center gap-4 text-[11px] text-slate-500 font-medium mt-3.5">
        <span class="flex items-center gap-1.5">
            <i class="fa-solid fa-shield-halved text-teal-600"></i>
            SSL 256-bit Encrypted
        </span>
        <span class="flex items-center gap-1.5">
            <i class="fa-solid fa-circle-check text-teal-600"></i>
            UIKA Secure Single Sign-On
        </span>
    </div>

    <!-- GLOBAL LOGIN LOADING OVERLAY -->
    <div id="login-loading-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[9999] flex flex-col items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl space-y-5">
            <div class="relative w-16 h-16 mx-auto flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-teal-500/20 border-t-teal-500 animate-spin"></div>
                <i class="fa-solid fa-shield-halved text-2xl text-teal-500"></i>
            </div>
            <div class="space-y-1.5">
                <h3 class="text-base font-extrabold text-white tracking-tight">Memverifikasi Akun...</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem sedang mengautentikasi dan menyiapkan dashboard Anda. Mohon tunggu sejenak.
                </p>
            </div>
            <div class="pt-3 border-t border-slate-800 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-notch animate-spin text-teal-400 text-xs"></i>
                <span class="text-[11px] font-bold tracking-wider text-slate-300 uppercase">Proses Autentikasi</span>
            </div>
        </div>
    </div>

    <!-- JavaScript Handlers -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function showLoginLoading() {
            const overlay = document.getElementById('login-loading-overlay');
            if (overlay) {
                overlay.classList.remove('hidden');
            }
            setTimeout(() => {
                const submitBtn = document.getElementById('loginSubmitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-1.5"></i> <span>MEMPROSES...</span>';
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
            }, 10);
        }

        function resetLoginLoading() {
            const overlay = document.getElementById('login-loading-overlay');
            if (overlay) {
                overlay.classList.add('hidden');
            }
            const submitBtn = document.getElementById('loginSubmitBtn');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>MASUK SEKARANG</span><i class="fa-solid fa-arrow-right text-xs"></i>';
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        }

        function showForgotPasswordAlert() {
            Swal.fire({
                title: 'Lupa Password?',
                html: `
                    <div class="text-left text-xs text-slate-600 space-y-2 mt-2">
                        <p>Silakan hubungi bagian <b>Biro Administrasi Akademik (BAAK)</b> atau <b>Pusat IT Kampus UIKA</b> untuk melakukan reset password akun Anda.</p>
                        <div class="p-3 bg-teal-50 rounded-xl border border-teal-200 text-teal-800 text-[11px] mt-2">
                            <i class="fa-solid fa-circle-info mr-1"></i> Bawa Kartu Identitas / KTM / KTP untuk verifikasi data kepemilikan akun.
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#0d9488',
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'rounded-3xl p-6',
                    title: 'text-lg font-extrabold text-slate-800',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-bold uppercase'
                }
            });
        }

        function showSupportModal() {
            Swal.fire({
                title: 'Layanan Bantuan & IT Support',
                html: `
                    <div class="text-left text-xs text-slate-600 space-y-2.5 mt-2">
                        <p class="font-medium">Pusat Layanan IT & BAAK Universitas Ibn Khaldun Bogor:</p>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-1.5 text-slate-700">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-envelope text-teal-600 w-4"></i> <span>support@uika-bogor.ac.id</span></div>
                            <div class="flex items-center gap-2"><i class="fa-solid fa-phone text-teal-600 w-4"></i> <span>(0251) 8356884</span></div>
                            <div class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-teal-600 w-4"></i> <span>Gedung Rektorat Lt. 1, Kampus UIKA</span></div>
                        </div>
                    </div>
                `,
                icon: 'question',
                confirmButtonColor: '#0d9488',
                confirmButtonText: 'Tutup',
                customClass: {
                    popup: 'rounded-3xl p-6',
                    title: 'text-lg font-extrabold text-slate-800',
                    confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-bold'
                }
            });
        }

        // Reset loading overlay when navigating back/forward (BFCache)
        window.addEventListener('pageshow', function(event) {
            resetLoginLoading();
        });

        document.addEventListener('DOMContentLoaded', function() {
            resetLoginLoading();

            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    showLoginLoading();
                });
            }

            document.querySelectorAll('.demo-login-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    showLoginLoading();
                });
            });

            @if(session('error') || session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Login!',
                    text: @json(session('error') ?? session('failed')),
                    confirmButtonColor: '#0d9488',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif

            @if($errors->any() && !session('error') && !session('failed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Autentikasi Gagal!',
                    text: @json($errors->first()),
                    confirmButtonColor: '#0d9488',
                    customClass: {
                        popup: 'rounded-3xl p-6',
                        title: 'text-lg font-extrabold text-slate-800',
                        htmlContainer: 'text-xs text-slate-600 font-medium',
                        confirmButton: 'rounded-xl text-xs px-5 py-2.5 font-extrabold'
                    }
                });
            @endif
        });
    </script>
</body>
</html>
