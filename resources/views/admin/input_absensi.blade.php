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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F7F9FB; }
        .custom-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); border-radius: 4px; }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-800">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleAdminMobileSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition focus:outline-none cursor-pointer" title="Buka Menu Sidebar">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <a href="{{ route('admin.absensi') }}" class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg flex items-center justify-center transition">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <h2 class="font-bold text-base text-slate-800 hidden md:block">Input Absensi Manual</h2>
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
                </button>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-grow overflow-auto p-6 space-y-6 max-w-6xl mx-auto w-full">
            
            <!-- Agenda Info Card -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                            {{ $agenda->mata_kuliah }}
                            <span class="px-2 py-0.5 bg-teal-50 text-teal-800 border border-teal-100 rounded text-[10px] font-bold uppercase">Kelas {{ $agenda->kelas ?: '-' }}</span>
                            <span class="px-2 py-0.5 bg-slate-50 text-slate-600 border border-slate-200 rounded text-[10px] font-bold uppercase">Semester {{ $agenda->semester ?: '-' }}</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-1.5 font-medium">
                            <i class="fa-solid fa-user-tie text-slate-400 mr-1.5"></i> Dosen: <span class="text-slate-700 font-bold">{{ $agenda->dosen->nama }}</span>
                            <span class="mx-2 text-slate-300">|</span>
                            <i class="fa-solid fa-location-dot text-slate-400 mr-1.5"></i> {{ $agenda->lab->nama_lab }}
                        </p>
                    </div>
                    <div class="text-right bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5">
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Waktu Sesi</p>
                        <p class="text-sm font-bold text-slate-800">
                            {{ date('d M Y', strtotime($agenda->tanggal)) }} <span class="text-slate-400 font-normal mx-1">•</span> {{ substr($agenda->jam_mulai, 0, 5) }} - {{ substr($agenda->jam_selesai, 0, 5) }} WIB
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-slate-50/80 border-b border-slate-200 px-6 py-4">
                    <h4 class="font-bold text-slate-800 text-sm">Daftar Mahasiswa ({{ $students->count() }})</h4>
                    <p class="text-xs text-slate-500 mt-1">Silakan pilih status kehadiran untuk setiap mahasiswa.</p>
                </div>
                
                <form action="{{ route('admin.absensi.store-input', $agenda->id) }}" method="POST">
                    @csrf
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50/50 text-slate-500 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                                <tr>
                                    <th class="p-4 w-12 text-center">No</th>
                                    <th class="p-4">Mahasiswa (NIM)</th>
                                    <th class="p-4 text-center">Hadir</th>
                                    <th class="p-4 text-center">Izin</th>
                                    <th class="p-4 text-center">Sakit</th>
                                    <th class="p-4 text-center">Alpa</th>
                                    <th class="p-4 text-center">Terlambat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($students as $index => $mhs)
                                    @php
                                        $currentStatus = isset($existingAbsensi[$mhs->id]) ? strtolower($existingAbsensi[$mhs->id]->status_kehadiran) : 'alpa';
                                    @endphp
                                    <tr class="hover:bg-slate-50/30 transition">
                                        <td class="p-4 text-center text-slate-400 font-mono">{{ $index + 1 }}</td>
                                        <td class="p-4">
                                            <span class="font-bold text-slate-800 block text-xs">{{ $mhs->nama_lengkap }}</span>
                                            <span class="text-[10px] font-mono text-teal-800 font-semibold">NIM: {{ $mhs->nim }}</span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <input type="radio" name="absensi[{{ $mhs->id }}]" value="Hadir" class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500" {{ $currentStatus == 'hadir' ? 'checked' : '' }} required>
                                        </td>
                                        <td class="p-4 text-center">
                                            <input type="radio" name="absensi[{{ $mhs->id }}]" value="Izin" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500" {{ $currentStatus == 'izin' ? 'checked' : '' }}>
                                        </td>
                                        <td class="p-4 text-center">
                                            <input type="radio" name="absensi[{{ $mhs->id }}]" value="Sakit" class="w-4 h-4 text-amber-500 border-slate-300 focus:ring-amber-500" {{ $currentStatus == 'sakit' ? 'checked' : '' }}>
                                        </td>
                                        <td class="p-4 text-center">
                                            <input type="radio" name="absensi[{{ $mhs->id }}]" value="Alpa" class="w-4 h-4 text-rose-600 border-slate-300 focus:ring-rose-500" {{ $currentStatus == 'alpa' ? 'checked' : '' }}>
                                        </td>
                                        <td class="p-4 text-center">
                                            <input type="radio" name="absensi[{{ $mhs->id }}]" value="Terlambat" class="w-4 h-4 text-orange-500 border-slate-300 focus:ring-orange-500" {{ $currentStatus == 'terlambat' ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-slate-500 text-sm">
                                            <i class="fa-solid fa-users-slash text-2xl text-slate-300 mb-2 block"></i>
                                            Tidak ada data mahasiswa untuk kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($students->count() > 0)
                    <div class="p-5 border-t border-slate-200 bg-slate-50 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-teal-700 hover:bg-teal-800 text-white rounded-xl font-bold transition flex items-center gap-2 shadow-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Absensi
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

    <script>
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
</body>
</html>
