<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun - Digital Board</title>
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
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm leading-tight">DIGITAL Board</h1>
                <p class="text-[10px] font-semibold tracking-wider text-teal-400">Portal Mahasiswa</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-qrcode"></i>
                <span class="text-xs font-semibold tracking-wide">Absensi Mandiri</span>
            </a>
            <a href="{{ route('mahasiswa.agenda') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="text-xs font-semibold tracking-wide">Agenda Kuliah</span>
            </a>
            <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="text-xs font-semibold tracking-wide">Riwayat Kehadiran</span>
            </a>
            <a href="{{ route('mahasiswa.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-850 text-white rounded-xl w-full font-bold">
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
                    <i class="fa-solid fa-user-graduate text-sm"></i>
                </div>
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Pengaturan Akun & Profil</h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-xs text-slate-800">{{ $mahasiswa->nama_lengkap }}</p>
                    <p class="text-[9px] font-semibold tracking-wider text-slate-500">NIM: {{ $mahasiswa->nim }} • {{ $mahasiswa->prodi->nama_prodi ?? 'Mahasiswa' }}</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-850 flex items-center justify-center font-bold text-xs">
                    {{ substr($mahasiswa->nama_lengkap, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-6 space-y-6">
            
            <!-- Mobile Profile Summary Card -->
            <div class="bg-teal-50 border border-teal-100 rounded-2xl p-4 flex items-center gap-4 lg:hidden shadow-sm">
                <div class="w-12 h-12 rounded-full bg-teal-850 text-white font-bold flex items-center justify-center text-lg shrink-0">
                    {{ substr($mahasiswa->nama_lengkap, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $mahasiswa->nama_lengkap }}</h4>
                    <p class="text-[10px] font-semibold text-slate-500 mt-0.5">NIM: {{ $mahasiswa->nim }}</p>
                    <p class="text-[9px] text-slate-450 mt-1 font-medium">
                        Kelas: {{ $mahasiswa->kelas ?: '-' }} • Semester: {{ $mahasiswa->semester ?: '-' }} • {{ $mahasiswa->prodi->nama_prodi ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Success/Error Alert -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-850 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-xl">
                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Berhasil!</span>
                        <p class="mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs flex items-start gap-3 shadow-sm max-w-xl">
                    <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-lg"></i>
                    <div>
                        <span class="font-bold">Terjadi Kesalahan:</span>
                        <ul class="list-disc list-inside mt-0.5 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Settings Card -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 max-w-xl">
                <h3 class="font-bold text-sm text-slate-800 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-user-gear text-teal-800"></i> Informasi Profil Mahasiswa
                </h3>
                
                <form action="{{ route('mahasiswa.pengaturan.update') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" disabled class="w-full p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed outline-none">
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1.5 uppercase tracking-wider">NIM (Nomor Induk Mahasiswa)</label>
                        <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" disabled class="w-full p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed outline-none font-mono font-semibold">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-slate-700 font-bold mb-1.5 uppercase tracking-wider">Fakultas</label>
                            <select name="fakultas" id="mhs-fakultas" disabled class="w-full p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed outline-none">
                                <option value="" disabled selected>-- Pilih Fakultas --</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id }}" {{ old('fakultas', $mahasiswa->id_fakultas) == $f->id ? 'selected' : '' }}>{{ $f->nama_fakultas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-slate-700 font-bold mb-1.5 uppercase tracking-wider">Jurusan</label>
                            <select name="jurusan" id="mhs-jurusan" disabled class="w-full p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed outline-none">
                                <option value="" disabled selected>-- Pilih Jurusan --</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->id }}" {{ old('jurusan', $mahasiswa->id_prodi) == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-slate-700 font-bold mb-1.5 uppercase tracking-wider">Kelas</label>
                            <input type="text" name="kelas" value="{{ old('kelas', $mahasiswa->kelas) }}" disabled class="w-full p-2.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed outline-none font-semibold">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <h4 class="font-bold text-[11px] text-slate-500 uppercase tracking-widest flex items-center gap-1.5"><i class="fa-solid fa-key"></i> Ubah Password Akun</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-slate-700 font-bold mb-1.5 uppercase tracking-wider">Password Baru</label>
                                <input type="password" name="password" required placeholder="Min. 6 karakter..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            </div>
                            <div>
                                <label class="block text-slate-700 font-bold mb-1.5 uppercase tracking-wider">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" required placeholder="Ulangi password..." class="w-full p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 focus:ring-2 focus:ring-teal-700/30 focus:border-teal-700 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-bold uppercase tracking-wider shadow-md transition-all flex items-center gap-2">
                            <i class="fa-solid fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    <!-- Bottom Navigation Bar (Mobile Only - Figma Design) -->
    <nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-slate-200 flex items-center justify-between px-3 z-40 lg:hidden shadow-lg">
        <a href="{{ route('mahasiswa.dashboard') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-qrcode text-lg"></i>
            <span class="text-[9px] font-medium">Absen</span>
        </a>
        <a href="{{ route('mahasiswa.agenda') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-calendar-days text-lg"></i>
            <span class="text-[9px] font-medium">Agenda</span>
        </a>
        <a href="{{ route('mahasiswa.riwayat') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-slate-500 hover:text-slate-800">
            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            <span class="text-[9px] font-medium">Riwayat</span>
        </a>
        <a href="{{ route('mahasiswa.pengaturan') }}" class="flex flex-col justify-center items-center gap-1 flex-1 py-2 text-teal-900 font-bold">
            <i class="fa-solid fa-gear text-lg"></i>
            <span class="text-[9px] font-bold">Settings</span>
        </a>
    </nav>

    <script>
        const allProdis = [
            @foreach($prodis as $p)
                { id: "{{ $p->id }}", fakultasId: "{{ $p->fakultas_id }}", nama: "{{ $p->nama_prodi }}" },
            @endforeach
        ];

        function filterProdis(selectedFakultasId, selectedProdiId = "") {
            const prodiSelect = document.getElementById('mhs-jurusan');
            prodiSelect.innerHTML = '<option value="" disabled selected>-- Pilih Jurusan --</option>';
            
            const filtered = allProdis.filter(p => !selectedFakultasId || p.fakultasId == selectedFakultasId);
            filtered.forEach(p => {
                const option = document.createElement('option');
                option.value = p.id;
                option.textContent = p.nama;
                if (p.id == selectedProdiId) {
                    option.selected = true;
                }
                prodiSelect.appendChild(option);
            });
        }

        const initialFakultas = "{{ old('fakultas', $mahasiswa->id_fakultas) }}";
        const initialProdi = "{{ old('jurusan', $mahasiswa->id_prodi) }}";
        
        document.getElementById('mhs-fakultas').addEventListener('change', function() {
            filterProdis(this.value);
        });

        // Initialize
        if (initialFakultas) {
            filterProdis(initialFakultas, initialProdi);
        }
    </script>

        </div>
    </main>
</body>
</html>
