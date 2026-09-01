<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use App\Models\Pengumuman;
use App\Models\Perizinan;
use App\Models\Mahasiswa;
use App\Models\Absensi;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DosenController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return redirect()->route('login')->withErrors(['msg' => 'Data profil Dosen tidak ditemukan.']);
        }

        $allAgendas = Agenda::with(['lab', 'absensi.mahasiswa.user'])
            ->where('dosen_id', $dosen->id)
            ->get();

        $today = date('Y-m-d');

        // Prioritize agendas:
        // 1. Status: 'Berlangsung' (1), 'Akan Datang' (2), 'Selesai' (3), 'Dibatalkan' (4)
        // 2. Date: Today first, then future, then past
        // 3. Time: Closest start time (jam_mulai)
        $sortedAgendas = $allAgendas->sort(function ($a, $b) use ($today) {
            $statusWeight = [
                'Berlangsung' => 1,
                'Akan Datang' => 2,
                'Selesai' => 3,
                'Dibatalkan' => 4,
            ];

            $weightA = $statusWeight[$a->status_agenda] ?? 5;
            $weightB = $statusWeight[$b->status_agenda] ?? 5;

            if ($weightA !== $weightB) {
                return $weightA <=> $weightB;
            }

            // Prioritize today's date over past/future dates
            if ($a->tanggal === $today && $b->tanggal !== $today) return -1;
            if ($a->tanggal !== $today && $b->tanggal === $today) return 1;

            // For upcoming/active, sort by closest date/time
            if ($weightA <= 2) {
                if ($a->tanggal !== $b->tanggal) {
                    return strcmp($a->tanggal, $b->tanggal);
                }
                return strcmp($a->jam_mulai, $b->jam_mulai);
            }

            // For finished/cancelled, sort by most recent date/time
            if ($a->tanggal !== $b->tanggal) {
                return strcmp($b->tanggal, $a->tanggal);
            }
            return strcmp($b->jam_mulai, $a->jam_mulai);
        });

        // Limit to maximum 10 agendas for the dashboard view
        $agendas = $sortedAgendas->take(10);

        $labs = Laboratorium::all();
        $fakultas = \App\Models\Fakultas::all();
        $prodis = \App\Models\Prodi::with('fakultas')->get();

        $pengumuman = Pengumuman::with('admin')
            ->orderBy('created_at', 'desc')
            ->get();

        $izinPendingCount = Perizinan::where('status_persetujuan', 'pending')
            ->whereIn('agenda_id', $allAgendas->pluck('id'))
            ->count();

        $todayAgendas = $allAgendas->filter(function($ag) use ($today) {
            return $ag->tanggal === $today;
        });

        $activeOrNextAgenda = $todayAgendas->first(function($ag) {
            return $ag->status_agenda === 'Berlangsung' || $ag->status_agenda === 'Akan Datang';
        });

        return view('dosen.dashboard', compact(
            'dosen', 'agendas', 'labs', 'fakultas', 'prodis', 'pengumuman', 
            'izinPendingCount', 'todayAgendas', 'activeOrNextAgenda'
        ));
    }

    public function storeAgenda(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required|string|max:150',
            'kelas' => 'required|string|max:50',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'rencana_pembelajaran' => 'required|string',
        ]);

        $dosen = Dosen::where('user_id', auth()->id())->first();

        // Check for time overlap
        $overlap = Agenda::where('dosen_id', $dosen->id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->waktu_keluar)
                      ->where('jam_selesai', '>', $request->waktu_masuk);
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['waktu_masuk' => 'Jadwal berbenturan dengan agenda Anda yang lain pada hari dan jam tersebut.'])->withInput();
        }

        Agenda::create([
            'dosen_id' => $dosen->id,
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->judul_agenda,
            'kelas' => $request->kelas,
            'semester' => $request->semester,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->waktu_masuk,
            'jam_selesai' => $request->waktu_keluar,
            'status_agenda' => 'Akan Datang',
            'catatan' => $request->rencana_pembelajaran,
        ]);

        return back()->with('success', 'Agenda pembelajaran berhasil dibuat.');
    }

    public function updateAgenda(Request $request, $id)
    {
        $request->validate([
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required|string|max:150',
            'kelas' => 'required|string|max:50',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'rencana_pembelajaran' => 'required|string',
        ]);

        $agenda = Agenda::findOrFail($id);

        // Check for time overlap (excluding this agenda)
        $overlap = Agenda::where('dosen_id', $agenda->dosen_id)
            ->where('id', '!=', $id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->waktu_keluar)
                      ->where('jam_selesai', '>', $request->waktu_masuk);
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['waktu_masuk' => 'Jadwal berbenturan dengan agenda Anda yang lain pada hari dan jam tersebut.'])->withInput();
        }

        $agenda->update([
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->judul_agenda,
            'kelas' => $request->kelas,
            'semester' => $request->semester,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->waktu_masuk,
            'jam_selesai' => $request->waktu_keluar,
            'catatan' => $request->rencana_pembelajaran,
        ]);

        return back()->with('success', 'Agenda pembelajaran berhasil diperbarui.');
    }

    public function deleteAgenda($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return back()->with('success', 'Agenda pembelajaran berhasil dihapus.');
    }

    public function updateRealisasi(Request $request, $id)
    {
        $request->validate([
            'realisasi_pembelajaran' => 'required|string',
        ]);

        $agenda = Agenda::findOrFail($id);
        
        $agenda->update([
            'materi_realisasi' => $request->realisasi_pembelajaran,
        ]);

        return back()->with('success', 'Realisasi pembelajaran berhasil diperbarui.');
    }

    public function submitAttendance(Request $request)
    {
        $request->validate([
            'qr_code_token' => 'required|string',
        ]);

        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return back()->withErrors(['qr_code_token' => 'Data dosen tidak ditemukan.']);
        }

        $tokenValidation = Agenda::validateDynamicQrToken($request->qr_code_token);
        if (!$tokenValidation['agenda']) {
            return back()->withErrors(['qr_code_token' => $tokenValidation['error']]);
        }

        $agenda = $tokenValidation['agenda'];

        if ($agenda->dosen_id !== $dosen->id) {
            return back()->withErrors(['qr_code_token' => 'Anda bukan Dosen pengajar untuk agenda ini.']);
        }

        if ($agenda->dosen_waktu_masuk) {
            return back()->with('info', 'Anda sudah melakukan absensi masuk untuk agenda ini!');
        }

        $agenda->update([
            'dosen_waktu_masuk' => now(),
        ]);

        return back()->with('success', 'Absensi Dosen BERHASIL dicatat untuk: ' . $agenda->mata_kuliah);
    }

    public function generateNewQrToken($id)
    {
        return back()->with('success', 'Token QR diperbarui secara otomatis menggunakan ID Agenda.');
    }

    public function agenda(Request $request)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $query = Agenda::with(['lab', 'absensi.mahasiswa.user'])
            ->where('dosen_id', $dosen->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('mata_kuliah', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        $agendas = $query->paginate(10)->withQueryString();
        $labs = Laboratorium::all();
        $fakultas = \App\Models\Fakultas::all();
        $prodis = \App\Models\Prodi::with('fakultas')->get();

        if ($request->ajax()) {
            $html = view('dosen.agenda_partial', compact('dosen', 'agendas', 'labs', 'fakultas', 'prodis'))->render();
            return response()->json(['html' => $html]);
        }

        return view('dosen.agenda', compact('dosen', 'agendas', 'labs', 'fakultas', 'prodis'));
    }

    public function mahasiswa(Request $request)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $query = Mahasiswa::with(['user', 'fakultas', 'prodi', 'perizinan.agenda.lab']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas_id')) {
            $query->where('id_fakultas', $request->fakultas_id);
        }

        if ($request->filled('prodi_id')) {
            $query->where('id_prodi', $request->prodi_id);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $mahasiswas = $query->get()->map(function($mhs) use ($dosen) {
            $hadirCount = Absensi::where('mahasiswa_id', $mhs->id)
                ->whereHas('agenda', function($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id);
                })
                ->where('status_kehadiran', 'Hadir')
                ->count();

            $izinCount = Absensi::where('mahasiswa_id', $mhs->id)
                ->whereHas('agenda', function($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id);
                })
                ->where('status_kehadiran', 'Izin')
                ->count();

            $alpaCount = Absensi::where('mahasiswa_id', $mhs->id)
                ->whereHas('agenda', function($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id);
                })
                ->where('status_kehadiran', 'Alpa')
                ->count();

            $mhs->hadir_count = $hadirCount;
            $mhs->izin_count = $izinCount;
            $mhs->alpa_count = $alpaCount;
            $mhs->total_agenda = $hadirCount + $izinCount + $alpaCount;
            $mhs->kehadiran_percentage = $mhs->total_agenda > 0 ? round(($mhs->hadir_count / $mhs->total_agenda) * 100, 1) : 100;

            return $mhs;
        });

        $fakultas = Fakultas::all();
        $prodis = Prodi::with('fakultas')->get();
        $kelases = Kelas::all();
        $semesters = [1, 2, 3, 4, 5, 6, 7, 8];

        return view('dosen.mahasiswa', compact('dosen', 'mahasiswas', 'fakultas', 'prodis', 'kelases', 'semesters'));
    }

    public function perizinan(Request $request)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $agendaIds = Agenda::where('dosen_id', $dosen->id)->pluck('id');

        $perizinans = Perizinan::with(['mahasiswa.user', 'agenda.lab'])
            ->whereIn('agenda_id', $agendaIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.perizinan', compact('dosen', 'perizinans'));
    }

    public function verifikasiIzin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $perizinan = Perizinan::findOrFail($id);
        $perizinan->update([
            'status_persetujuan' => $request->status,
        ]);

        if ($request->status === 'disetujui') {
            Absensi::updateOrCreate(
                [
                    'agenda_id' => $perizinan->agenda_id,
                    'mahasiswa_id' => $perizinan->mahasiswa_id,
                ],
                [
                    'waktu_masuk' => now(),
                    'status_kehadiran' => $perizinan->kategori === 'Sakit' ? 'Sakit' : 'Izin',
                ]
            );
        } else {
            $absensi = Absensi::where('agenda_id', $perizinan->agenda_id)
                ->where('mahasiswa_id', $perizinan->mahasiswa_id)
                ->first();
            if ($absensi) {
                $absensi->update(['status_kehadiran' => 'Alpa']);
            }
        }

        return back()->with('success', 'Status pengajuan izin mahasiswa berhasil diperbarui menjadi: ' . strtoupper($request->status));
    }

    public function pengaturan()
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
        return view('dosen.pengaturan', compact('dosen'));
    }

    public function updatePengaturan(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password_lama' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!\Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama yang Anda masukkan salah.']);
        }

        $user->update([
            'password' => \Hash::make($request->password),
        ]);

        return back()->with('success', 'Password akun berhasil diperbarui.');
    }

    public function exportKehadiran($id)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
        $agenda = Agenda::with(['dosen', 'lab', 'absensi.mahasiswa'])->where('dosen_id', $dosen->id)->findOrFail($id);
        
        return view('dosen.export_agenda_kehadiran', compact('agenda'));
    }

    public function exportMahasiswa(Request $request)
    {
        $user = auth()->user();
        $dosen = Dosen::with(['fakultas', 'prodi'])->where('user_id', $user->id)->firstOrFail();

        $query = Mahasiswa::with(['user', 'fakultas', 'prodi']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas_id')) {
            $query->where('id_fakultas', $request->fakultas_id);
        }

        if ($request->filled('prodi_id')) {
            $query->where('id_prodi', $request->prodi_id);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $mahasiswas = $query->get()->map(function($mhs) use ($dosen) {
            $hadirCount = Absensi::where('mahasiswa_id', $mhs->id)
                ->whereHas('agenda', function($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id);
                })
                ->where('status_kehadiran', 'Hadir')
                ->count();

            $izinCount = Absensi::where('mahasiswa_id', $mhs->id)
                ->whereHas('agenda', function($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id);
                })
                ->where('status_kehadiran', 'Izin')
                ->count();

            $alpaCount = Absensi::where('mahasiswa_id', $mhs->id)
                ->whereHas('agenda', function($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id);
                })
                ->where('status_kehadiran', 'Alpa')
                ->count();

            $mhs->hadir_count = $hadirCount;
            $mhs->izin_count = $izinCount;
            $mhs->alpa_count = $alpaCount;
            $mhs->total_agenda = $hadirCount + $izinCount + $alpaCount;
            
            return $mhs;
        });

        return view('dosen.export_rekap_mahasiswa', compact('dosen', 'mahasiswas'));
    }

    public function bulkDeleteAgendas(Request $request)
    {
        $request->validate([
            'agenda_ids' => 'required|array',
            'agenda_ids.*' => 'exists:agenda,id',
        ]);

        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();

        Agenda::whereIn('id', $request->agenda_ids)
            ->where('dosen_id', $dosen->id)
            ->delete();

        return back()->with('success', 'Agenda terpilih berhasil dihapus.');
    }
}
