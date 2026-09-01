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
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
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
                <div class="relative">
                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
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
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="password" 
                           name="password" 
                           required 
                           placeholder="Masukkan password" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 pl-11 pr-4 text-xs sm:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0c4ea6]/20 focus:border-[#0c4ea6] focus:bg-white transition duration-200">
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
            <button type="submit" class="w-full py-3.5 rounded-2xl bg-[#0c4ea6] hover:bg-[#0a3f86] text-white font-extrabold text-xs tracking-wider uppercase shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center gap-2">
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
               class="py-2.5 px-2 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-2xl text-center transition duration-200 group">
                <i class="fa-solid fa-user-shield text-[#0c4ea6] group-hover:scale-110 transition transform block mb-1"></i>
                <span class="text-[10px] font-extrabold text-slate-700 block leading-tight">Admin</span>
            </a>
            <a href="{{ route('demo.login', 'dosen') }}" 
               class="py-2.5 px-2 bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 rounded-2xl text-center transition duration-200 group">
                <i class="fa-solid fa-chalkboard-user text-emerald-600 group-hover:scale-110 transition transform block mb-1"></i>
                <span class="text-[10px] font-extrabold text-slate-700 block leading-tight">Dosen</span>
            </a>
            <a href="{{ route('demo.login', 'mahasiswa') }}" 
               class="py-2.5 px-2 bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-2xl text-center transition duration-200 group">
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
</body>
</html>
