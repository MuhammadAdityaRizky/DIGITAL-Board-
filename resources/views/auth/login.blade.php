<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System - Digital Board UIKA</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS CDN Fallback for guaranteed CSS rendering -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f4f9;
            color: #1e293b;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="flex min-h-screen items-center justify-center p-4 sm:p-6 bg-[#f0f4f9] antialiased selection:bg-[#0c4ea6] selection:text-white">

    <div class="w-full max-w-[440px] bg-white border border-slate-200/90 rounded-3xl shadow-xl p-6 sm:p-8 space-y-6 relative overflow-hidden">
        
        <!-- Top Accent Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0c4ea6] via-blue-600 to-[#00b87c]"></div>

        <!-- Campus Branding Header -->
        <div class="text-center space-y-3 pt-2">
            <a href="{{ route('board') }}" class="inline-block transition transform hover:scale-105">
                <img src="https://commons.wikimedia.org/wiki/Special:FilePath/LOGO_UIKA_Terbaru2.png" 
                     alt="Logo UIKA" 
                     style="width: 56px; height: 56px; min-width: 56px; min-height: 56px; object-fit: contain;" 
                     class="w-14 h-14 mx-auto object-contain shrink-0">
            </a>
            <div>
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight uppercase">
                    UNIVERSITAS IBN KHALDUN
                </h1>
                <p class="text-xs font-bold text-[#0c4ea6] tracking-wider uppercase mt-0.5">
                    Sistem Digital Information Board
                </p>
            </div>
            <p class="text-xs text-slate-500 font-medium">Masuk menggunakan akun Pengguna, Dosen, atau Mahasiswa</p>
        </div>

        <!-- Main Login Form -->
        <form id="loginForm" action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Error Notification Alert -->
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-3.5 rounded-2xl text-xs flex items-start gap-2.5 shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5 shrink-0"></i>
                    <div>
                        <span class="font-extrabold">Gagal Masuk:</span>
                        <p class="mt-0.5 text-rose-700 font-medium">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Identifier Input (NIM / NIP / Username) -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-extrabold tracking-wider text-slate-500 uppercase mono">NIM / NIP / USERNAME</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-user absolute left-4 text-slate-400 text-sm pointer-events-none z-10"></i>
                    <input type="text" 
                           id="username_or_nim_nip"
                           name="username_or_nim_nip" 
                           required 
                           value="{{ old('username_or_nim_nip') }}"
                           placeholder="Masukkan NIM, NIP, atau Username" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 pl-11 pr-4 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/20 focus:border-[#0c4ea6] focus:bg-white transition duration-200">
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-extrabold tracking-wider text-slate-500 uppercase mono">PASSWORD</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-lock absolute left-4 text-slate-400 text-sm pointer-events-none z-10"></i>
                    <input type="password" 
                           id="password"
                           name="password" 
                           required 
                           placeholder="Masukkan password" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 pl-11 pr-11 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/20 focus:border-[#0c4ea6] focus:bg-white transition duration-200">
                    <button type="button" 
                            onclick="togglePassword()" 
                            class="absolute right-3.5 text-slate-400 hover:text-slate-600 focus:outline-none p-1 transition cursor-pointer flex items-center justify-center z-10"
                            title="Tampilkan/Sembunyikan Password"
                            aria-label="Toggle Password Visibility">
                        <i class="fa-solid fa-eye text-sm" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Options Row -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#0c4ea6] focus:ring-[#0c4ea6]">
                    <span>Ingat saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="loginSubmitBtn" class="w-full py-3.5 rounded-2xl bg-[#0c4ea6] hover:bg-[#0a3f86] text-white font-extrabold text-xs tracking-wider uppercase shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center gap-2">
                <span>Masuk Sekarang</span>
                <i class="fa-solid fa-arrow-right text-[11px]"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative flex py-1 items-center">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="flex-shrink mx-3 text-[10px] text-slate-400 uppercase tracking-widest font-extrabold mono">DEMO QUICK LOGIN</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <!-- Quick Demo Accounts -->
        <div class="grid grid-cols-3 gap-2">
            <a href="{{ route('demo.login', 'admin') }}" 
               class="demo-login-btn py-2.5 px-2 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl text-center transition duration-200 group">
                <i class="fa-solid fa-user-shield text-[#0c4ea6] group-hover:scale-110 transition transform block mb-1"></i>
                <span class="text-[10px] font-extrabold text-slate-700 block leading-tight">Admin</span>
            </a>
            <a href="{{ route('demo.login', 'dosen') }}" 
               class="demo-login-btn py-2.5 px-2 bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 rounded-2xl text-center transition duration-200 group">
                <i class="fa-solid fa-chalkboard-user text-emerald-600 group-hover:scale-110 transition transform block mb-1"></i>
                <span class="text-[10px] font-extrabold text-slate-700 block leading-tight">Dosen</span>
            </a>
            <a href="{{ route('demo.login', 'mahasiswa') }}" 
               class="demo-login-btn py-2.5 px-2 bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-2xl text-center transition duration-200 group">
                <i class="fa-solid fa-user-graduate text-indigo-600 group-hover:scale-110 transition transform block mb-1"></i>
                <span class="text-[10px] font-extrabold text-slate-700 block leading-tight">Mahasiswa</span>
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center pt-2 border-t border-slate-100">
            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">
                &copy; {{ date('Y') }} UIKA Bogor - Digital Information Board
            </p>
        </div>
    </div>

    <!-- GLOBAL LOGIN LOADING OVERLAY -->
    <div id="login-loading-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-[9999] flex flex-col items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl space-y-5">
            <div class="relative w-16 h-16 mx-auto flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-blue-500/20 border-t-[#0c4ea6] animate-spin"></div>
                <i class="fa-solid fa-shield-halved text-2xl text-[#0c4ea6]"></i>
            </div>
            <div class="space-y-1.5">
                <h3 class="text-base font-extrabold text-white tracking-tight">Memverifikasi Akun...</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Sistem sedang mengautentikasi dan menyiapkan dashboard Anda. Mohon tunggu sejenak.
                </p>
            </div>
            <div class="pt-3 border-t border-slate-800 flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-notch animate-spin text-blue-400 text-xs"></i>
                <span class="text-[11px] font-bold tracking-wider text-slate-300 uppercase">Proses Autentikasi</span>
            </div>
        </div>
    </div>

    <!-- Toggle Password & Loading JS Script -->
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
                    submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin mr-1"></i> Memproses...';
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
                submitBtn.innerHTML = '<span>Masuk Sekarang</span><i class="fa-solid fa-arrow-right text-[11px]"></i>';
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        }

        // Reset loading overlay when user navigates back/forward in browser (BFCache)
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
                    confirmButtonColor: '#0c4ea6',
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
                    confirmButtonColor: '#0c4ea6',
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
