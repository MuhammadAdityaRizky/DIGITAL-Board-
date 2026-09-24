<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Absensi Manual - Digital Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800 pb-16 lg:pb-0">

    <!-- Sidebar (Desktop Only) -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 h-full hidden lg:flex">
        <div class="p-6 flex items-center gap-3 border-b border-slate-800">
            <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-10 h-10 object-contain shrink-0">

            <div>
                <h1 class="font-extrabold text-sm leading-tight text-white">DIGITAL Board</h1>
                <p class="text-xs font-bold tracking-wide text-teal-300">Smart Lab Management</p>
            </div>
        </div>
        
        <nav class="flex-1 px-3 py-4 space-y-1.5">
            <a href="{{ route('dosen.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-border-all text-sm"></i>
                <span class="text-sm font-bold tracking-wide">Dashboard</span>
            </a>
            <a href="{{ route('dosen.agenda') }}" class="flex items-center gap-3 px-4 py-3 bg-teal-800 text-white rounded-xl w-full font-extrabold shadow-md">
                <i class="fa-solid fa-calendar-alt text-sm"></i>
                <span class="text-sm font-bold tracking-wide">Agenda Perkuliahan</span>
            </a>
            <a href="{{ route('dosen.jadwal-lab') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-calendar-check text-sm"></i>
                <span class="text-sm font-bold tracking-wide">Ketersediaan Lab</span>
            </a>
            <a href="{{ route('dosen.pengaturan') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl w-full transition">
                <i class="fa-solid fa-gear text-sm"></i>
                <span class="text-sm font-bold tracking-wide">Pengaturan Akun</span>
            </a>
        </nav>

        <!-- Tombol Panduan Dosen di Sidebar -->
        <div class="p-3 border-t border-slate-800 mt-auto">
            <button type="button" onclick="openTutorialDosenModal()" class="flex items-center gap-3 px-3.5 py-2.5 bg-amber-500/15 border border-amber-500/30 text-amber-300 hover:bg-amber-500/25 hover:text-white rounded-xl w-full transition text-xs font-bold cursor-pointer">
                <i class="fa-solid fa-book-open-reader text-sm text-amber-400"></i>
                <span>Panduan Dosen</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Top Navbar -->
        @include('dosen.partials.header', ['title' => 'Kelola Presensi Mahasiswa', 'backUrl' => route('dosen.agenda')])

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-4 md:p-8 space-y-6 max-w-6xl mx-auto w-full">
            
            <!-- Agenda Info Card -->
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                    <div>
                        <h3 class="font-extrabold text-xl text-slate-900 flex items-center gap-2.5 flex-wrap">
                            {{ $agenda->mata_kuliah }}
                            <span class="px-3 py-1 bg-teal-100 text-teal-950 border border-teal-300 rounded-lg text-xs font-extrabold uppercase">Kelas {{ $agenda->kelas ?: '-' }}</span>
                            <span class="px-3 py-1 bg-slate-100 text-slate-800 border border-slate-300 rounded-lg text-xs font-bold uppercase">Semester {{ $agenda->semester ?: '-' }}</span>
                        </h3>
                        <p class="text-xs text-slate-600 mt-2 font-semibold flex items-center gap-3 flex-wrap">
                            <span><i class="fa-solid fa-user-tie text-teal-700 mr-1.5"></i> Dosen: <strong class="text-slate-900">{{ $agenda->dosen->nama }}</strong></span>
                            <span class="text-slate-300">•</span>
                            <span><i class="fa-solid fa-location-dot text-teal-700 mr-1.5"></i> {{ $agenda->lab->nama_lab }} ({{ $agenda->lab->lokasi }})</span>
                        </p>
                    </div>
                    <div class="text-left md:text-right bg-slate-50 border-2 border-slate-200 rounded-xl px-5 py-3 shadow-2xs">
                        <p class="text-xs font-extrabold text-slate-700 uppercase tracking-wider mb-1">Waktu Pelaksanaan</p>
                        <p class="text-sm font-extrabold text-slate-900">
                            {{ date('d M Y', strtotime($agenda->tanggal)) }} <span class="text-slate-400 font-normal mx-1">•</span> {{ substr($agenda->jam_mulai, 0, 5) }} - {{ substr($agenda->jam_selesai, 0, 5) }} WIB
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border-2 border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-slate-50/80 border-b border-slate-200 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-base">Daftar Kehadiran Mahasiswa ({{ $students->count() }} Orang)</h4>
                        <p class="text-xs text-slate-600 font-medium mt-0.5">
                            Pilih status kehadiran mahasiswa. Status yang ditandai akan langsung tercatat ke sistem rekapitulasi.
                        </p>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <button type="button" onclick="setAllStatus('Hadir')" class="px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-950 border border-emerald-300 rounded-xl text-xs font-extrabold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                            <i class="fa-solid fa-check-double text-emerald-700"></i> Semua Hadir
                        </button>
                        <button type="button" onclick="setAllStatus('Alpa')" class="px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-950 border border-rose-300 rounded-xl text-xs font-extrabold transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                            <i class="fa-solid fa-xmark text-rose-700"></i> Semua Alpa
                        </button>
                    </div>
                </div>
                
                <form action="{{ route('dosen.absensi.store-input', $agenda->id) }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-100/70 text-slate-700 font-extrabold uppercase tracking-wider text-xs border-b border-slate-200">
                                <tr>
                                    <th class="p-4 w-12 text-center font-bold">No</th>
                                    <th class="p-4 font-extrabold">Nama Mahasiswa & NIM</th>
                                    <th class="p-4 text-center font-bold text-emerald-800">Hadir</th>
                                    <th class="p-4 text-center font-bold text-blue-800">Izin</th>
                                    <th class="p-4 text-center font-bold text-amber-800">Sakit</th>
                                    <th class="p-4 text-center font-bold text-rose-800">Alpa</th>
                                    <th class="p-4 text-center font-bold text-orange-800">Terlambat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($students as $index => $mhs)
                                    @php
                                        $currentStatus = isset($existingAbsensi[$mhs->id]) ? strtolower($existingAbsensi[$mhs->id]->status_kehadiran) : 'alpa';
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="p-4 text-center text-slate-600 font-bold font-mono text-xs">{{ $index + 1 }}</td>
                                        <td class="p-4">
                                            <span class="font-extrabold text-slate-900 block text-sm">{{ $mhs->nama_lengkap }}</span>
                                            <span class="text-xs font-mono text-teal-900 font-bold mt-0.5 inline-block">NIM: {{ $mhs->nim }}</span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <label class="inline-flex items-center justify-center p-2 rounded-xl hover:bg-emerald-50 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $mhs->id }}]" value="Hadir" class="w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500 cursor-pointer" {{ $currentStatus == 'hadir' ? 'checked' : '' }} required>
                                            </label>
                                        </td>
                                        <td class="p-4 text-center">
                                            <label class="inline-flex items-center justify-center p-2 rounded-xl hover:bg-blue-50 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $mhs->id }}]" value="Izin" class="w-5 h-5 text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer" {{ $currentStatus == 'izin' ? 'checked' : '' }}>
                                            </label>
                                        </td>
                                        <td class="p-4 text-center">
                                            <label class="inline-flex items-center justify-center p-2 rounded-xl hover:bg-amber-50 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $mhs->id }}]" value="Sakit" class="w-5 h-5 text-amber-500 border-slate-300 focus:ring-amber-500 cursor-pointer" {{ $currentStatus == 'sakit' ? 'checked' : '' }}>
                                            </label>
                                        </td>
                                        <td class="p-4 text-center">
                                            <label class="inline-flex items-center justify-center p-2 rounded-xl hover:bg-rose-50 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $mhs->id }}]" value="Alpa" class="w-5 h-5 text-rose-600 border-slate-300 focus:ring-rose-500 cursor-pointer" {{ $currentStatus == 'alpa' ? 'checked' : '' }}>
                                            </label>
                                        </td>
                                        <td class="p-4 text-center">
                                            <label class="inline-flex items-center justify-center p-2 rounded-xl hover:bg-orange-50 cursor-pointer">
                                                <input type="radio" name="absensi[{{ $mhs->id }}]" value="Terlambat" class="w-5 h-5 text-orange-500 border-slate-300 focus:ring-orange-500 cursor-pointer" {{ $currentStatus == 'terlambat' ? 'checked' : '' }}>
                                            </label>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-600 text-sm font-medium">
                                            <i class="fa-solid fa-users-slash text-3xl text-slate-400 mb-2 block"></i>
                                            Tidak ada data mahasiswa untuk kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($students->count() > 0)
                    <div class="p-5 border-t border-slate-200 bg-slate-50 flex justify-end">
                        <button type="submit" class="px-7 py-3 bg-teal-800 hover:bg-teal-900 text-white rounded-xl font-extrabold text-sm transition flex items-center gap-2 shadow-md cursor-pointer">
                            <i class="fa-solid fa-floppy-disk text-base"></i> Simpan Absensi
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            
        </div>
    </main>

    <script>
        function setAllStatus(status) {
            const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
            radios.forEach(r => r.checked = true);
        }

        function toggleProfileDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('profileDropdownMenu');
            menu.classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileDropdownMenu');
            if(menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>

    @include('dosen.partials.modal_tutorial')
</body>
</html>
