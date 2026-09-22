<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Agenda;
use App\Models\Mahasiswa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::with(['prodi', 'fakultas'])->where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->route('login')->withErrors(['msg' => 'Data profil Mahasiswa tidak ditemukan.']);
        }

        $profileIncomplete = !$mahasiswa->id_fakultas || !$mahasiswa->id_prodi;

        $today = date('Y-m-d');
        if ($profileIncomplete) {
            $todayAgendas = collect();
        } else {
            $todayAgendas = Agenda::with(['dosen', 'lab', 'absensi' => function($q) use ($mahasiswa) {
                $q->where('mahasiswa_id', $mahasiswa->id);
            }])
            ->where('tanggal', $today)
            ->where('fakultas', $mahasiswa->fakultas->nama_fakultas)
            ->where('jurusan', $mahasiswa->prodi->nama_prodi)
            ->when($mahasiswa->kelas, function ($query) use ($mahasiswa) {
                return $query->where('kelas', $mahasiswa->kelas);
            })
            ->orderBy('jam_mulai', 'asc')
            ->get();
        }

        $absensiHistory = Absensi::with(['agenda.dosen', 'agenda.lab'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        return view('mahasiswa.dashboard', compact('mahasiswa', 'todayAgendas', 'absensiHistory', 'profileIncomplete'));
    }

    public function submitAttendance(Request $request)
    {
        $request->validate([
            'qr_code_token' => 'required|string',
        ]);

        $user = auth()->user();
        $mahasiswa = Mahasiswa::with(['prodi', 'fakultas'])->where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return back()->withErrors(['qr_code_token' => 'Data profil Mahasiswa tidak ditemukan.']);
        }

        if (!$mahasiswa->id_fakultas || !$mahasiswa->id_prodi || !$mahasiswa->fakultas || !$mahasiswa->prodi) {
            return back()->withErrors(['qr_code_token' => 'Profil Anda belum lengkap (Fakultas atau Prodi). Silakan lengkapi profil di Pengaturan terlebih dahulu.']);
        }

        $tokenValidation = Agenda::validateDynamicQrToken($request->qr_code_token);
        if (!$tokenValidation['agenda']) {
            return back()->withErrors(['qr_code_token' => $tokenValidation['error']]);
        }

        $agenda = $tokenValidation['agenda'];

        if ($agenda->tanggal > date('Y-m-d')) {
            return back()->withErrors([
                'qr_code_token' => 'Absensi ditolak! Sesi perkuliahan ini belum dimulai (Jadwal: ' . \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') . '). Presensi mahasiswa hanya dibuka pada hari H pelaksanaan perkuliahan.'
            ]);
        }

        // 1. Validasi Fakultas (Fakultas harus sama)
        if ($agenda->fakultas && $agenda->fakultas !== $mahasiswa->fakultas->nama_fakultas) {
            return back()->withErrors([
                'qr_code_token' => 'Absensi ditolak! Agenda ini ditujukan untuk ' . $agenda->fakultas . ', bukan Fakultas Anda (' . $mahasiswa->fakultas->nama_fakultas . ').'
            ]);
        }

        // 2. Validasi Program Studi / Jurusan (Jurusan harus sama)
        if ($agenda->jurusan && $agenda->jurusan !== $mahasiswa->prodi->nama_prodi) {
            return back()->withErrors([
                'qr_code_token' => 'Absensi ditolak! Agenda ini ditujukan untuk Program Studi ' . $agenda->jurusan . ', bukan Program Studi Anda (' . $mahasiswa->prodi->nama_prodi . ').'
            ]);
        }

        // 3. Validasi Kelas (Kelas harus sama, jika mahasiswa sudah mengatur kelas)
        if ($agenda->kelas && $mahasiswa->kelas && $agenda->kelas !== $mahasiswa->kelas) {
            return back()->withErrors([
                'qr_code_token' => 'Absensi ditolak! Agenda ini ditujukan untuk Kelas ' . $agenda->kelas . ', bukan Kelas Anda (' . $mahasiswa->kelas . ').'
            ]);
        }

        // Catatan: Semester sengaja tidak dibatasi (menerima presensi meskipun semester mahasiswa berbeda).

        $existing = Absensi::where('agenda_id', $agenda->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if ($existing) {
            return back()->with('info', 'Anda sudah melakukan absensi untuk agenda ini!');
        }

        Absensi::create([
            'agenda_id' => $agenda->id,
            'mahasiswa_id' => $mahasiswa->id,
            'waktu_masuk' => now(),
            'status_kehadiran' => 'Hadir',
        ]);

        return back()->with('success', 'Absensi BERHASIL dicatat untuk: ' . $agenda->mata_kuliah);
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();

        $query = Absensi::with(['agenda.dosen', 'agenda.lab'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('waktu_masuk', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('agenda', function($q) use ($search) {
                $q->where('mata_kuliah', 'like', "%{$search}%");
            });
        }

        $absensiHistory = $query->paginate(10)->withQueryString();

        $hadirCount = Absensi::where('mahasiswa_id', $mahasiswa->id)->where('status_kehadiran', 'Hadir')->count();
        $izinCount = Absensi::where('mahasiswa_id', $mahasiswa->id)->where('status_kehadiran', 'Izin')->count();
        $alpaCount = Absensi::where('mahasiswa_id', $mahasiswa->id)->where('status_kehadiran', 'Alpa')->count();
        $totalSesi = $hadirCount + $izinCount + $alpaCount;
        $attendancePercentage = $totalSesi > 0 ? round(($hadirCount / $totalSesi) * 100, 1) : 100;

        return view('mahasiswa.riwayat', compact('mahasiswa', 'absensiHistory', 'hadirCount', 'izinCount', 'alpaCount', 'totalSesi', 'attendancePercentage'));
    }

    public function agenda(Request $request)
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::with(['prodi', 'fakultas'])->where('user_id', $user->id)->firstOrFail();

        $scope = $request->get('scope', 'untuk-saya');

        $query = Agenda::with(['dosen', 'lab']);

        if ($scope === 'untuk-saya') {
            if ($mahasiswa->fakultas) {
                $query->where('fakultas', $mahasiswa->fakultas->nama_fakultas);
            }
            if ($mahasiswa->prodi) {
                $query->where('jurusan', $mahasiswa->prodi->nama_prodi);
            }
            if ($mahasiswa->kelas) {
                $query->where('kelas', $mahasiswa->kelas);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('mata_kuliah', 'like', "%{$search}%");
            }
            if ($request->filled('tanggal')) {
                $query->where('tanggal', $request->tanggal);
            }
        } else {
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('mata_kuliah', 'like', "%{$search}%");
            }
            if ($request->filled('tanggal')) {
                $query->where('tanggal', $request->tanggal);
            }
            if ($request->filled('filter_fakultas')) {
                $query->where('fakultas', $request->filter_fakultas);
            }
            if ($request->filled('filter_jurusan')) {
                $query->where('jurusan', $request->filter_jurusan);
            }
            if ($request->filled('filter_kelas')) {
                $query->where('kelas', $request->filter_kelas);
            }
            if ($request->filled('filter_semester')) {
                $query->where('semester', $request->filter_semester);
            }
        }

        if ($request->get('sort') === 'terlama') {
            $query->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc');
        } else {
            $query->orderBy('tanggal', 'desc')->orderBy('jam_mulai', 'desc');
        }

        $agendas = $query->paginate(10)->withQueryString();

        $fakultas = \App\Models\Fakultas::all();
        $prodis = \App\Models\Prodi::with('fakultas')->get();

        return view('mahasiswa.agenda', compact('mahasiswa', 'agendas', 'scope', 'fakultas', 'prodis'));
    }

    public function pengumuman()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();
        $pengumuman = Pengumuman::with(['admin', 'laboratoriums'])->orderBy('created_at', 'desc')->get();
        return view('mahasiswa.pengumuman', compact('mahasiswa', 'pengumuman'));
    }

    public function pengaturan()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();
        $fakultas = \App\Models\Fakultas::all();
        $prodis = \App\Models\Prodi::all();
        return view('mahasiswa.pengaturan', compact('mahasiswa', 'fakultas', 'prodis'));
    }

    public function updatePengaturan(Request $request)
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Password Anda berhasil diperbarui.');
    }
}
