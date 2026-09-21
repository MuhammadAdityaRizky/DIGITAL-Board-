<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-uika.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo-uika.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas - Digital Board</title>
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
    @include('admin.partials.sidebar')

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 flex-shrink-0">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-uika.png') }}" alt="Logo UIKA" class="w-8 h-8 object-contain flex lg:hidden shrink-0">
                <h2 class="font-bold text-base text-slate-800 lg:hidden">DIGITAL Board</h2>
                <h2 class="font-bold text-base text-slate-800 hidden lg:block">Riwayat Aktivitas Sistem (CRUD)</h2>
            </div>
            
            <!-- Profile Avatar & Dropdown Menu -->
            <div class="relative" id="profileDropdownWrapper">
                <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 focus:outline-none group cursor-pointer p-1 rounded-xl hover:bg-slate-50 transition">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 group-hover:text-teal-700 transition">{{ auth()->user()->username ?? 'Admin' }}</p>
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

            <!-- Title & Info -->
            <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-xl flex items-start gap-4 shadow-sm max-w-6xl">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0 mt-0.5">
                    <i class="fa-solid fa-info-circle text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-indigo-900">Log Aktivitas Sistem</h3>
                    <p class="text-xs text-indigo-700 mt-1 leading-relaxed">Halaman ini mencatat semua perubahan data (Tambah, Edit, Hapus) yang dilakukan oleh pengguna pada sistem. Anda bisa melacak siapa yang melakukan perubahan dan kapan perubahan tersebut terjadi.</p>
                </div>
            </div>

            <!-- Activity Table -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden max-w-6xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="p-4 w-48">Waktu</th>
                                <th class="p-4 w-56">Dilakukan Oleh (Causer)</th>
                                <th class="p-4 w-32">Aksi</th>
                                <th class="p-4">Objek Data (Subject)</th>
                                <th class="p-4 text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($activities as $log)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-700">{{ $log->created_at->format('d M Y') }}</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="p-4">
                                        @if($log->causer)
                                            @php
                                                $displayName = 'User';
                                                if ($log->causer->dosen) {
                                                    $displayName = $log->causer->dosen->nama . ' (Dosen)';
                                                } elseif ($log->causer->mahasiswa) {
                                                    $displayName = $log->causer->mahasiswa->nama_lengkap . ' (Mahasiswa)';
                                                } elseif (strtolower($log->causer->username) === 'admin1' || strtolower($log->causer->role ?? '') === 'admin') {
                                                    $displayName = 'Administrator';
                                                } else {
                                                    $displayName = $log->causer->username;
                                                }
                                            @endphp
                                            <div class="font-semibold text-slate-800">{{ $displayName }}</div>
                                            <div class="text-[10px] text-slate-500">User ID / Username: {{ $log->causer->username }}</div>
                                        @else
                                            <span class="text-slate-400 italic">Sistem / Guest</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $color = 'slate';
                                            $icon = 'circle';
                                            if ($log->event === 'created') { $color = 'emerald'; $icon = 'plus-circle'; }
                                            if ($log->event === 'updated') { $color = 'blue'; $icon = 'pen-to-square'; }
                                            if ($log->event === 'deleted') { $color = 'rose'; $icon = 'trash'; }
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-200 font-bold text-[9px] uppercase tracking-wider">
                                            <i class="fa-solid fa-{{ $icon }}"></i> {{ $log->event }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-slate-700">
                                            {{ class_basename($log->subject_type) }}
                                        </div>
                                        @if($log->subject_id)
                                            <div class="text-[10px] font-mono text-slate-400 mt-0.5">ID: {{ $log->subject_id }}</div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <button onclick="document.getElementById('modal-{{ $log->id }}').classList.remove('hidden')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded text-[10px] font-bold transition">
                                            Lihat Data
                                        </button>

                                        <!-- Modal Detail -->
                                        <div id="modal-{{ $log->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
                                            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden text-left">
                                                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                                    <h3 class="font-bold text-sm text-slate-800">Detail Perubahan Data</h3>
                                                    <button onclick="document.getElementById('modal-{{ $log->id }}').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition">
                                                        <i class="fa-solid fa-xmark text-lg"></i>
                                                    </button>
                                                </div>
                                                <div class="p-6 max-h-[60vh] overflow-y-auto">
                                                    @if($log->properties && count($log->properties) > 0)
                                                        @if(isset($log->properties['old']) && isset($log->properties['attributes']))
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div>
                                                                    <div class="text-[10px] font-bold uppercase tracking-wider text-rose-500 mb-2">Data Lama (Sebelum)</div>
                                                                    <pre class="bg-slate-50 border border-slate-200 p-3 rounded-lg text-[10px] text-slate-600 overflow-x-auto font-mono leading-relaxed">{{ json_encode($log->properties['old'], JSON_PRETTY_PRINT) }}</pre>
                                                                </div>
                                                                <div>
                                                                    <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-500 mb-2">Data Baru (Sesudah)</div>
                                                                    <pre class="bg-slate-50 border border-slate-200 p-3 rounded-lg text-[10px] text-slate-600 overflow-x-auto font-mono leading-relaxed">{{ json_encode($log->properties['attributes'], JSON_PRETTY_PRINT) }}</pre>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Properti Log</div>
                                                            <pre class="bg-slate-50 border border-slate-200 p-3 rounded-lg text-[10px] text-slate-600 overflow-x-auto font-mono leading-relaxed">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                                        @endif
                                                    @else
                                                        <div class="text-center text-slate-400 py-8 italic text-xs">
                                                            Tidak ada detail properti yang dicatat untuk event ini.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 text-right">
                                                    <button onclick="document.getElementById('modal-{{ $log->id }}').classList.add('hidden')" class="px-4 py-2 bg-slate-800 text-white rounded-lg text-xs font-bold hover:bg-slate-900 transition">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-400 italic">
                                        <div class="text-4xl mb-3 text-slate-200"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                        Belum ada riwayat aktivitas yang tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($activities->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-center">
                    {{ $activities->links() }}
                </div>
                @endif
            </div>

        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile Only) -->
    @include('admin.partials.bottom_nav')

</body>
</html>

