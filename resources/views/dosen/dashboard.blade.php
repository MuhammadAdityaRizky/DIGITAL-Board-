@extends('layouts.app')

@section('title', 'Dashboard Dosen Pengampu')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="glass-card-glow rounded-3xl p-6 lg:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/20 text-cyan-300 text-xs font-semibold mb-2">
                <i class="fa-solid fa-chalkboard-user"></i> DOSEN DASHBOARD
            </div>
            <h1 class="text-2xl lg:text-3xl font-extrabold text-white">Kelola Agenda & Absensi Praktikum</h1>
            <p class="text-slate-400 text-sm mt-1">
                Selamat Datang, <strong>{{ auth()->user()->nama_lengkap }}</strong> (NIP: {{ $dosen->nip }})
            </p>
        </div>
    </div>

    <!-- Announcements Banner from Admin -->
    @if(isset($pengumuman) && $pengumuman->count() > 0)
        <div class="glass-card rounded-2xl p-4 border border-amber-500/30 bg-amber-950/20 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0 font-bold">
                <i class="fa-solid fa-bullhorn text-lg"></i>
            </div>
            <div class="flex-grow space-y-1">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-amber-300 flex items-center gap-2">
                        PENGUMUMAN RESMI LAB
                        <span class="text-[10px] font-normal text-amber-400/80">({{ $pengumuman->first()->tanggal }})</span>
                    </h3>
                    <span class="text-[10px] uppercase font-bold text-amber-400 px-2 py-0.5 rounded bg-amber-500/20">Admin Lab</span>
                </div>
                <p class="text-sm text-slate-300 leading-relaxed">
                    <strong>{{ $pengumuman->first()->judul_pengumuman }}:</strong> {{ $pengumuman->first()->penjelasan }}
                </p>
            </div>
        </div>
    @endif

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Column 1: Add New Agenda Form -->
        <div class="space-y-6">
            <div class="glass-card p-6 rounded-3xl space-y-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-calendar-plus text-cyan-400"></i> Buat Agenda Pembelajaran
                </h3>

                <form action="{{ route('dosen.agenda.store') }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Ruangan Laboratorium</label>
                        <select name="lab_id" required class="w-full p-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white">
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}">{{ $lab->nama_lab }} ({{ $lab->lokasi }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Judul Agenda / Mata Kuliah</label>
                        <input type="text" name="judul_agenda" required placeholder="Praktikum Pemrograman Web" class="w-full p-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white">
                    </div>

                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Tanggal Praktikum</label>
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full p-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-slate-300 font-semibold mb-1">Jam Masuk</label>
                            <input type="time" name="waktu_masuk" required value="08:00" class="w-full p-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white">
                        </div>
                        <div>
                            <label class="block text-slate-300 font-semibold mb-1">Jam Keluar</label>
                            <input type="time" name="waktu_keluar" required value="10:30" class="w-full p-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-300 font-semibold mb-1">Rencana Pembelajaran</label>
                        <textarea name="rencana_pembelajaran" rows="3" required placeholder="Tuliskan materi/topik yang akan dibahas..." class="w-full p-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-600 to-indigo-600 font-bold text-white shadow-lg hover:opacity-95 transition">
                        <i class="fa-solid fa-qrcode mr-1"></i> Buat Agenda & Generate QR Token
                    </button>
                </form>
            </div>
        </div>

        <!-- Column 2 & 3: Agendas & Live Attendance List -->
        <div class="lg:col-span-2 space-y-6">

            <div class="glass-card p-6 rounded-3xl space-y-6">
                <h3 class="text-base font-bold text-white flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-400"></i>
                        Daftar Agenda Mengajar Anda
                    </span>
                    <span class="text-xs text-slate-400 font-normal">({{ $agendas->count() }} agenda)</span>
                </h3>

                @if($agendas->count() > 0)
                    <div class="space-y-6">
                        @foreach($agendas as $ag)
                            <div class="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 space-y-4">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-800 pb-3">
                                    <div>
                                        <span class="text-[11px] font-bold text-cyan-400 uppercase tracking-wider block">
                                            {{ $ag->lab->nama_lab }} • {{ $ag->tanggal }} ({{ substr($ag->waktu_masuk,0,5) }} - {{ substr($ag->waktu_keluar,0,5) }} WIB)
                                        </span>
                                        <h4 class="text-lg font-bold text-white mt-0.5">{{ $ag->judul_agenda }}</h4>
                                    </div>
                                    
                                    <!-- Regenerate QR Token Form -->
                                    <form action="{{ route('dosen.agenda.qr', $ag->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-indigo-500/20 border border-indigo-500/40 text-indigo-300 hover:bg-indigo-500/30 text-xs font-semibold flex items-center gap-2">
                                            <i class="fa-solid fa-arrows-rotate"></i> Reset Token QR
                                        </button>
                                    </form>
                                </div>

                                <!-- QR Display & Info -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center bg-slate-950/70 p-4 rounded-xl border border-slate-800">
                                    <div class="md:col-span-2 space-y-2 text-xs">
                                        <div>
                                            <strong class="text-slate-400 block">Rencana Pembelajaran:</strong>
                                            <p class="text-slate-200">{{ $ag->rencana_pembelajaran }}</p>
                                        </div>

                                        <!-- Update Realisasi Form -->
                                        <form action="{{ route('dosen.agenda.realisasi', $ag->id) }}" method="POST" class="pt-2 border-t border-slate-800/80 space-y-2">
                                            @csrf
                                            @method('PUT')
                                            <label class="block font-semibold text-emerald-400">Realisasi Pembelajaran (Isi Setelah Kuliah):</label>
                                            <div class="flex gap-2">
                                                <input type="text" name="realisasi_pembelajaran" value="{{ $ag->realisasi_pembelajaran }}" placeholder="Contoh: Selesai membahas bab 1-3..." class="flex-grow p-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs">
                                                <button type="submit" class="px-3 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-500 transition">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- QR Code Image -->
                                    <div class="text-center p-3 bg-white rounded-xl">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($ag->qr_code_token) }}" alt="QR Code" class="w-28 h-28 mx-auto mb-1">
                                        <span class="text-[10px] font-mono font-bold text-slate-800 block break-all">{{ $ag->qr_code_token }}</span>
                                    </div>
                                </div>

                                <!-- Attendance Table for this Agenda -->
                                <div class="space-y-2">
                                    <span class="text-xs font-bold text-slate-300 flex items-center justify-between">
                                        <span><i class="fa-solid fa-user-check text-emerald-400 mr-1"></i> Rekapitulasi Absensi Mahasiswa</span>
                                        <span class="text-emerald-400">{{ $ag->absensi->count() }} Hadir</span>
                                    </span>

                                    @if($ag->absensi->count() > 0)
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-xs text-left text-slate-300">
                                                <thead class="bg-slate-950 text-slate-400 font-semibold uppercase">
                                                    <tr>
                                                        <th class="p-2">No</th>
                                                        <th class="p-2">Nama Mahasiswa</th>
                                                        <th class="p-2">NIM</th>
                                                        <th class="p-2">Waktu Scan</th>
                                                        <th class="p-2">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-800">
                                                    @foreach($ag->absensi as $idx => $abs)
                                                        <tr>
                                                            <td class="p-2 font-mono text-slate-500">{{ $idx + 1 }}</td>
                                                            <td class="p-2 font-bold text-white">{{ $abs->mahasiswa->user->nama_lengkap }}</td>
                                                            <td class="p-2 font-mono text-cyan-300">{{ $abs->mahasiswa->nim }}</td>
                                                            <td class="p-2 text-slate-400">{{ $abs->waktu_kehadiran }}</td>
                                                            <td class="p-2">
                                                                <span class="px-2 py-0.5 rounded font-bold text-[10px] bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                                                    {{ $abs->status }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-[11px] text-slate-500 italic">Belum ada mahasiswa yang memindai QR Code untuk agenda ini.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-xs text-center py-6">Anda belum membuat agenda praktikum.</p>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection
