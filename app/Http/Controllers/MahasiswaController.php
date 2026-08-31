<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Agenda;
use App\Models\Mahasiswa;
use App\Models\Pengumuman;
use App\Models\Perizinan;
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

        $profileIncomplete = !$mahasiswa->kelas || !$mahasiswa->id_fakultas || !$mahasiswa->id_prodi;

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
            ->where('kelas', $mahasiswa->kelas)
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->map(function($ag) use ($mahasiswa) {
                $ag->perizinan = Perizinan::where('agenda_id', $ag->id)
                    ->where('mahasiswa_id', $mahasiswa->id)
                    ->first();
                return $ag;
            });
        }

        $absensiHistory = Absensi::with(['agenda.dosen', 'agenda.lab'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        $perizinans = Perizinan::with(['agenda.dosen', 'agenda.lab'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $pengumuman = Pengumuman::with('admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.dashboard', compact('mahasiswa', 'todayAgendas', 'absensiHistory', 'perizinans', 'pengumuman', 'profileIncomplete'));
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

        if (!$mahasiswa->id_fakultas || !$mahasiswa->id_prodi || !$mahasiswa->kelas || !$mahasiswa->fakultas || !$mahasiswa->prodi) {
            return back()->withErrors(['qr_code_token' => 'Profil Anda belum lengkap (Fakultas, Prodi, atau Kelas). Silakan lengkapi profil di Pengaturan terlebih dahulu.']);
        }

        $tokenValidation = Agenda::validateDynamicQrToken($request->qr_code_token);
        if (!$tokenValidation['agenda']) {
            return back()->withErrors(['qr_code_token' => $tokenValidation['error']]);
        }

        $agenda = $tokenValidation['agenda'];

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

        // 3. Validasi Kelas (Kelas harus sama)
        if ($agenda->kelas && $agenda->kelas !== $mahasiswa->kelas) {
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

    public function submitIzin(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required|exists:agenda,id',
            'alasan' => 'required|string',
            'bukti_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();
        $mahasiswa = Mahasiswa::with(['prodi', 'fakultas'])->where('user_id', $user->id)->firstOrFail();

        $agenda = Agenda::findOrFail($request->agenda_id);
        if (!$mahasiswa->id_fakultas || !$mahasiswa->id_prodi || !$mahasiswa->kelas ||
            $agenda->fakultas !== $mahasiswa->fakultas->nama_fakultas ||
            $agenda->jurusan !== $mahasiswa->prodi->nama_prodi ||
            $agenda->kelas !== $mahasiswa->kelas) {
            return back()->withErrors(['msg' => 'Anda hanya dapat mengajukan izin untuk kelas dari Fakultas, Prodi, dan Kelas Anda sendiri.']);
        }

        // Check if already attended
        $hasAttended = Absensi::where('agenda_id', $request->agenda_id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status_kehadiran', 'Hadir')
            ->exists();

        if ($hasAttended) {
            return back()->withErrors(['msg' => 'Anda sudah hadir di kelas ini, tidak bisa mengajukan izin.']);
        }

        // Check if there is an existing permission request
        $existing = Perizinan::where('agenda_id', $request->agenda_id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if ($existing) {
            return back()->with('info', 'Anda sudah mengajukan izin untuk kelas ini. Status saat ini: ' . strtoupper($existing->status_persetujuan));
        }

        $filename = null;
        if ($request->hasFile('bukti_dokumen')) {
            $file = $request->file('bukti_dokumen');
            $destinationPath = public_path('uploads/bukti_izin');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $filename = 'izin_' . time() . '_' . $mahasiswa->nim . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);
        }

        Perizinan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'agenda_id' => $request->agenda_id,
            'kategori' => 'Izin',
            'alasan' => $request->alasan,
            'bukti_url' => $filename ? 'uploads/bukti_izin/' . $filename : null,
            'status_persetujuan' => 'Pending',
        ]);

        return back()->with('success', 'Pengajuan izin berhasil dikirim. Menunggu verifikasi Dosen.');
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

        $perizinans = Perizinan::with(['agenda.dosen', 'agenda.lab'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $hadirCount = Absensi::where('mahasiswa_id', $mahasiswa->id)->where('status_kehadiran', 'Hadir')->count();
        $izinCount = Absensi::where('mahasiswa_id', $mahasiswa->id)->where('status_kehadiran', 'Izin')->count();
        $alpaCount = Absensi::where('mahasiswa_id', $mahasiswa->id)->where('status_kehadiran', 'Alpa')->count();
        $totalSesi = $hadirCount + $izinCount + $alpaCount;
        $attendancePercentage = $totalSesi > 0 ? round(($hadirCount / $totalSesi) * 100, 1) : 100;

        return view('mahasiswa.riwayat', compact('mahasiswa', 'absensiHistory', 'perizinans', 'hadirCount', 'izinCount', 'alpaCount', 'totalSesi', 'attendancePercentage'));
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

        $query->orderBy('tanggal', 'desc')
              ->orderBy('jam_mulai', 'desc');

        $agendas = $query->paginate(10)->withQueryString();

        $fakultas = \App\Models\Fakultas::all();
        $prodis = \App\Models\Prodi::with('fakultas')->get();

        return view('mahasiswa.agenda', compact('mahasiswa', 'agendas', 'scope', 'fakultas', 'prodis'));
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
