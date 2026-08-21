<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F7F9FB;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="flex min-h-screen items-center justify-center p-4 md:p-6 bg-slate-50">
    <div class="w-full max-w-[420px] bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden p-6 md:p-8 space-y-6">
        <!-- Logo and Heading -->
        <div class="text-center space-y-2">
            <div class="w-16 h-16 bg-teal-900 text-white rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto shadow-md">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">ABSENSI LAB</h1>
            <p class="text-sm text-slate-500">Silakan masuk menggunakan akun Anda</p>
        </div>

        <!-- Role Selection Visual Toggle (Figma Design element) -->
        <div class="space-y-2">
            <label class="block text-[11px] font-bold tracking-wider text-slate-500 uppercase mono">PILIH ROLE</label>
            <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-xl border border-slate-200">
                <button type="button" id="btn-dosen" onclick="selectRole('dosen')" class="py-2.5 text-xs font-bold rounded-lg transition-all shadow-sm bg-white text-teal-800">
                    <i class="fa-solid fa-chalkboard-user mr-1.5"></i> Dosen
                </button>
                <button type="button" id="btn-mahasiswa" onclick="selectRole('mahasiswa')" class="py-2.5 text-xs font-bold rounded-lg transition-all text-slate-600 hover:text-slate-800">
                    <i class="fa-solid fa-user-graduate mr-1.5"></i> Mahasiswa
                </button>
            </div>
        </div>

        <!-- Main Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Error Alert -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-3.5 rounded-xl text-xs flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 flex-shrink-0"></i>
                    <div>
                        <span class="font-bold">Gagal Masuk:</span>
                        <p class="mt-0.5">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Username/NIP/NIM Input -->
            <div class="space-y-1.5">
                <label id="input-label" class="block text-[11px] font-bold tracking-wider text-slate-500 uppercase mono">NIP DOSEN</label>
                <div class="relative">
                    <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" 
                           id="username_or_nim_nip"
                           name="username_or_nim_nip" 
                           required 
                           value="{{ old('username_or_nim_nip') }}"
                           placeholder="Masukkan NIP" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 focus:bg-white transition-all">
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold tracking-wider text-slate-500 uppercase mono">PASSWORD</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="password" 
                           name="password" 
                           required 
                           placeholder="Masukkan password" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-11 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 focus:bg-white transition-all">
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-teal-700 focus:ring-teal-500">
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="text-teal-700 hover:underline font-medium">Lupa password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs tracking-wider uppercase shadow-md transition-all flex items-center justify-center gap-2">
                Masuk <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="flex-shrink mx-4 text-[10px] text-slate-400 uppercase tracking-widest font-bold mono">ATAU DEMO LOGIN</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <!-- Quick Demo Login Buttons -->
        <div class="grid grid-cols-3 gap-2">
            <a href="{{ route('demo.login', 'admin') }}" class="py-2.5 px-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-center transition-all group">
                <i class="fa-solid fa-user-shield text-slate-500 group-hover:text-slate-700 block mb-1"></i>
                <span class="text-[10px] font-bold text-slate-600 block leading-tight">Admin</span>
            </a>
            <a href="{{ route('demo.login', 'dosen') }}" class="py-2.5 px-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-center transition-all group">
                <i class="fa-solid fa-chalkboard-user text-slate-500 group-hover:text-slate-700 block mb-1"></i>
                <span class="text-[10px] font-bold text-slate-600 block leading-tight">Dosen</span>
            </a>
            <a href="{{ route('demo.login', 'mahasiswa') }}" class="py-2.5 px-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-center transition-all group">
                <i class="fa-solid fa-user-graduate text-slate-500 group-hover:text-slate-700 block mb-1"></i>
                <span class="text-[10px] font-bold text-slate-600 block leading-tight">Mhs</span>
            </a>
        </div>

        <!-- Footer Copyright -->
        <div class="text-center pt-2 border-t border-slate-100">
            <p class="text-[10px] text-slate-400 mono">© 2024 Computer Laboratory Attendance System</p>
        </div>
    </div>

    <!-- Script to toggle placeholder/label based on role selector -->
    <script>
        function selectRole(role) {
            const btnDosen = document.getElementById('btn-dosen');
            const btnMahasiswa = document.getElementById('btn-mahasiswa');
            const inputLabel = document.getElementById('input-label');
            const inputField = document.getElementById('username_or_nim_nip');

            if (role === 'dosen') {
                btnDosen.className = "py-2.5 text-xs font-bold rounded-lg transition-all shadow-sm bg-white text-teal-800";
                btnMahasiswa.className = "py-2.5 text-xs font-bold rounded-lg transition-all text-slate-600 hover:text-slate-800";
                inputLabel.innerText = "NIP DOSEN";
                inputField.placeholder = "Masukkan NIP";
            } else {
                btnDosen.className = "py-2.5 text-xs font-bold rounded-lg transition-all text-slate-600 hover:text-slate-800";
                btnMahasiswa.className = "py-2.5 text-xs font-bold rounded-lg transition-all shadow-sm bg-white text-teal-800";
                inputLabel.innerText = "NIM MAHASISWA";
                inputField.placeholder = "Masukkan NIM";
            }
        }
    </script>
</body>
</html>
