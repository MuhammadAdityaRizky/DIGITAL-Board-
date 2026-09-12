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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KehadiranImport;

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
            ->where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            })
            ->get();

        $today = date('Y-m-d');

        // Filter agenda untuk Dashboard Dosen:
        // Tampilkan hanya agenda aktif/mendatang (Berlangsung / Akan Datang) atau agenda hari ini/mendatang.
        // Seluruh agenda berstatus Selesai/Dibatalkan dari tanggal lalu (semester yang sudah rampung/libur) disimpan di Sidebar Agenda.
        $dashboardAgendas = $allAgendas->filter(function($ag) use ($today) {
            if ($ag->status_agenda === 'Berlangsung' || $ag->status_agenda === 'Akan Datang') {
                return true;
            }
            if ($ag->tanggal >= $today) {
                return true;
            }
            return false;
        });

        $sortedAgendas = $dashboardAgendas->sort(function ($a, $b) use ($today) {
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

            if ($a->tanggal === $today && $b->tanggal !== $today) return -1;
            if ($a->tanggal !== $today && $b->tanggal === $today) return 1;

            if ($weightA <= 2) {
                if ($a->tanggal !== $b->tanggal) {
                    return strcmp($a->tanggal, $b->tanggal);
                }
                return strcmp($a->jam_mulai, $b->jam_mulai);
            }

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

        $todayAgendas = $allAgendas->filter(function($ag) use ($today) {
            return $ag->tanggal === $today;
        });

        $activeOrNextAgenda = $todayAgendas->first(function($ag) {
            return $ag->status_agenda === 'Berlangsung' || $ag->status_agenda === 'Akan Datang';
        });

        $jadwalPenggunaanLab = \App\Models\JadwalPenggunaanLab::with(['lab', 'prodi.fakultas', 'dosenPengampu'])
            ->where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            })
            ->where('is_aktif', true)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $dayNames = [
            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 0 => 'Minggu'
        ];
        $todayName = $dayNames[\Carbon\Carbon::today()->dayOfWeek] ?? 'Senin';

        $todayScheduledJadwal = $jadwalPenggunaanLab->first(function($j) use ($todayName, $todayAgendas) {
            if ($j->hari !== $todayName) return false;
            return !$todayAgendas->contains(function($ag) use ($j) {
                return $ag->jadwal_penggunaan_lab_id == $j->id;
            });
        });

        return view('dosen.dashboard', compact(
            'dosen', 'agendas', 'labs', 'fakultas', 'prodis', 'pengumuman', 
            'todayAgendas', 'activeOrNextAgenda', 'jadwalPenggunaanLab', 'todayScheduledJadwal'
        ));
    }

    public function storeAgenda(Request $request)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();

        if ($request->filled('jadwal_penggunaan_lab_id')) {
            $request->validate([
                'jadwal_penggunaan_lab_id' => 'required|exists:jadwal_penggunaan_lab,id',
                'tanggal' => 'required|date',
                'waktu_masuk' => 'required',
                'waktu_keluar' => 'required',
                'rencana_pembelajaran' => 'required|string',
            ]);

            $jadwal = \App\Models\JadwalPenggunaanLab::with(['lab', 'prodi.fakultas', 'dosenPengampu'])->findOrFail($request->jadwal_penggunaan_lab_id);

            $targetLabId = $jadwal->lab_id ?? 5;
            $targetDosenId = $jadwal->dosen_id ?? $dosen->id;

            // 1. Cek Bentrok Ruang Laboratorium
            $bentrokLab = Agenda::with(['dosen', 'lab'])
                ->where('lab_id', $targetLabId)
                ->where('tanggal', $request->tanggal)
                ->where('status_agenda', '!=', 'Dibatalkan')
                ->where(function ($query) use ($request) {
                    $query->where('jam_mulai', '<', $request->waktu_keluar)
                          ->where('jam_selesai', '>', $request->waktu_masuk);
                })
                ->first();

            if ($bentrokLab) {
                $labName = $bentrokLab->lab->nama_lab ?? 'Laboratorium';
                $jamRange = substr($bentrokLab->jam_mulai, 0, 5) . ' - ' . substr($bentrokLab->jam_selesai, 0, 5) . ' WIB';
                $dosenName = $bentrokLab->dosen->nama ?? 'Dosen Lain';
                return back()->withErrors([
                    'waktu_masuk' => "⛔ BENTROK RUANGAN! {$labName} sudah digunakan pada jam {$jamRange} untuk mata kuliah \"{$bentrokLab->mata_kuliah} (Kelas {$bentrokLab->kelas})\" oleh {$dosenName}. Silakan pilih jam atau lab lain."
                ])->withInput();
            }

            // 2. Cek Bentrok Dosen
            $bentrokDosen = Agenda::with('lab')
                ->where('dosen_id', $targetDosenId)
                ->where('tanggal', $request->tanggal)
                ->where('status_agenda', '!=', 'Dibatalkan')
                ->where(function ($query) use ($request) {
                    $query->where('jam_mulai', '<', $request->waktu_keluar)
                          ->where('jam_selesai', '>', $request->waktu_masuk);
                })
                ->first();

            if ($bentrokDosen) {
                $jamRange = substr($bentrokDosen->jam_mulai, 0, 5) . ' - ' . substr($bentrokDosen->jam_selesai, 0, 5) . ' WIB';
                $labName = $bentrokDosen->lab->nama_lab ?? 'Lab';
                return back()->withErrors([
                    'waktu_masuk' => "⛔ BENTROK JADWAL DOSEN! Anda sudah memiliki jadwal mengajar di {$labName} pada jam {$jamRange} (\"{$bentrokDosen->mata_kuliah}\")."
                ])->withInput();
            }

            Agenda::create([
                'jadwal_penggunaan_lab_id' => $jadwal->id,
                'dosen_id' => $jadwal->dosen_id ?? $dosen->id,
                'dosen_pengampu_id' => $jadwal->dosen_pengampu_id,
                'lab_id' => $jadwal->lab_id ?? 5,
                'mata_kuliah' => $jadwal->mata_kuliah,
                'program_kuliah' => $jadwal->program_kuliah ?? 'Reguler',
                'jenis_pertemuan' => 'Praktikum',
                'kelas' => $jadwal->kelas ?? 'Reg A',
                'semester' => $jadwal->semester ?? '1',
                'jurusan' => $jadwal->prodi->nama_prodi ?? 'Sistem Informasi',
                'fakultas' => $jadwal->prodi->fakultas->nama_fakultas ?? 'Fakultas Teknik & Sains',
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->waktu_masuk,
                'jam_selesai' => $request->waktu_keluar,
                'status_agenda' => 'Akan Datang',
                'catatan' => $request->rencana_pembelajaran,
            ]);

            return back()->with('success', 'Agenda pembelajaran untuk ' . $jadwal->mata_kuliah . ' (' . $jadwal->kelas . ') berhasil dibuat.');
        }

        $request->validate([
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'nullable|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'rencana_pembelajaran' => 'required|string',
        ]);

        // 1. Cek Bentrok Ruang Laboratorium
        $bentrokLab = Agenda::with(['dosen', 'lab'])
            ->where('lab_id', $request->lab_id)
            ->where('tanggal', $request->tanggal)
            ->where('status_agenda', '!=', 'Dibatalkan')
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->waktu_keluar)
                      ->where('jam_selesai', '>', $request->waktu_masuk);
            })
            ->first();

        if ($bentrokLab) {
            $labName = $bentrokLab->lab->nama_lab ?? 'Laboratorium';
            $jamRange = substr($bentrokLab->jam_mulai, 0, 5) . ' - ' . substr($bentrokLab->jam_selesai, 0, 5) . ' WIB';
            $dosenName = $bentrokLab->dosen->nama ?? 'Dosen Lain';
            return back()->withErrors([
                'waktu_masuk' => "⛔ BENTROK RUANGAN! {$labName} sudah digunakan pada jam {$jamRange} untuk mata kuliah \"{$bentrokLab->mata_kuliah} (Kelas {$bentrokLab->kelas})\" oleh {$dosenName}. Silakan pilih jam atau lab lain."
            ])->withInput();
        }

        // 2. Cek Bentrok Dosen
        $bentrokDosen = Agenda::with('lab')
            ->where('dosen_id', $dosen->id)
            ->where('tanggal', $request->tanggal)
            ->where('status_agenda', '!=', 'Dibatalkan')
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->waktu_keluar)
                      ->where('jam_selesai', '>', $request->waktu_masuk);
            })
            ->first();

        if ($bentrokDosen) {
            $jamRange = substr($bentrokDosen->jam_mulai, 0, 5) . ' - ' . substr($bentrokDosen->jam_selesai, 0, 5) . ' WIB';
            $labName = $bentrokDosen->lab->nama_lab ?? 'Lab';
            return back()->withErrors([
                'waktu_masuk' => "⛔ BENTROK JADWAL DOSEN! Anda sudah memiliki jadwal mengajar di {$labName} pada jam {$jamRange} (\"{$bentrokDosen->mata_kuliah}\")."
            ])->withInput();
        }

        Agenda::create([
            'dosen_id' => $dosen->id,
            'dosen_pengampu_id' => $request->dosen_pengampu_id,
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->judul_agenda,
            'program_kuliah' => $request->program_kuliah,
            'jenis_pertemuan' => $request->jenis_pertemuan ?? 'Praktikum',
            'kelas' => $request->kelas ?? '',
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
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'nullable|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'rencana_pembelajaran' => 'required|string',
        ]);

        $agenda = Agenda::findOrFail($id);

        // 1. Cek Bentrok Ruang Laboratorium (kecuali agenda ini)
        $bentrokLab = Agenda::with(['dosen', 'lab'])
            ->where('lab_id', $request->lab_id)
            ->where('id', '!=', $id)
            ->where('tanggal', $request->tanggal)
            ->where('status_agenda', '!=', 'Dibatalkan')
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->waktu_keluar)
                      ->where('jam_selesai', '>', $request->waktu_masuk);
            })
            ->first();

        if ($bentrokLab) {
            $labName = $bentrokLab->lab->nama_lab ?? 'Laboratorium';
            $jamRange = substr($bentrokLab->jam_mulai, 0, 5) . ' - ' . substr($bentrokLab->jam_selesai, 0, 5) . ' WIB';
            $dosenName = $bentrokLab->dosen->nama ?? 'Dosen Lain';
            return back()->withErrors([
                'waktu_masuk' => "⛔ BENTROK RUANGAN! {$labName} sudah digunakan pada jam {$jamRange} untuk mata kuliah \"{$bentrokLab->mata_kuliah} (Kelas {$bentrokLab->kelas})\" oleh {$dosenName}. Silakan pilih jam atau lab lain."
            ])->withInput();
        }

        // 2. Cek Bentrok Dosen (kecuali agenda ini)
        $bentrokDosen = Agenda::with('lab')
            ->where('dosen_id', $agenda->dosen_id)
            ->where('id', '!=', $id)
            ->where('tanggal', $request->tanggal)
            ->where('status_agenda', '!=', 'Dibatalkan')
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->waktu_keluar)
                      ->where('jam_selesai', '>', $request->waktu_masuk);
            })
            ->first();

        if ($bentrokDosen) {
            $jamRange = substr($bentrokDosen->jam_mulai, 0, 5) . ' - ' . substr($bentrokDosen->jam_selesai, 0, 5) . ' WIB';
            $labName = $bentrokDosen->lab->nama_lab ?? 'Lab';
            return back()->withErrors([
                'waktu_masuk' => "⛔ BENTROK JADWAL DOSEN! Anda sudah memiliki jadwal mengajar di {$labName} pada jam {$jamRange} (\"{$bentrokDosen->mata_kuliah}\")."
            ])->withInput();
        }

        $agenda->update([
            'dosen_pengampu_id' => $request->dosen_pengampu_id,
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->judul_agenda,
            'program_kuliah' => $request->program_kuliah,
            'jenis_pertemuan' => $request->jenis_pertemuan ?? 'Praktikum',
            'kelas' => $request->kelas ?? '',
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
        
        if ($agenda->tanggal > date('Y-m-d')) {
            return back()->withErrors(['realisasi_pembelajaran' => 'Realisasi pembelajaran belum dapat diisi untuk sesi yang belum dimulai.']);
        }

        $agenda->update([
            'materi_realisasi' => $request->realisasi_pembelajaran,
        ]);

        return back()->with('success', 'Realisasi pembelajaran berhasil diperbarui.');
    }

    public function updateBeritaAcara(Request $request, $id)
    {
        $request->validate([
            'berita_acara' => 'required|string',
        ]);

        $agenda = Agenda::findOrFail($id);

        if ($agenda->tanggal > date('Y-m-d')) {
            return back()->withErrors(['berita_acara' => 'Berita Acara belum dapat diisi untuk sesi yang belum dimulai.']);
        }

        $agenda->update([
            'berita_acara' => $request->berita_acara,
        ]);

        return back()->with('success', 'Berita Acara berhasil disimpan.');
    }

    public function submitAttendance(Request $request)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return back()->withErrors(['qr_code_token' => 'Data dosen tidak ditemukan.']);
        }

        // Support Emergency Manual Check-in by agenda_id
        if ($request->filled('agenda_id')) {
            $agenda = Agenda::where('id', $request->agenda_id)
                ->where(function($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id)
                      ->orWhere('dosen_pengampu_id', $dosen->id);
                })
                ->first();

            if (!$agenda) {
                return back()->withErrors(['msg' => 'Agenda tidak ditemukan atau Anda tidak memiliki akses.']);
            }

            if ($agenda->tanggal > date('Y-m-d')) {
                return back()->withErrors(['msg' => 'Sesi perkuliahan ini belum dimulai. Absensi Dosen hanya dapat dilakukan pada hari pelaksanaan.']);
            }

            if ($agenda->dosen_waktu_masuk) {
                return back()->with('info', 'Anda sudah terabsen masuk untuk agenda ini.');
            }

            $agenda->update([
                'dosen_waktu_masuk' => now(),
            ]);

            return back()->with('success', 'Absensi Dosen Manual (Emergency) BERHASIL dicatat untuk: ' . $agenda->mata_kuliah);
        }

        // QR Code Check-in Flow
        $request->validate([
            'qr_code_token' => 'required|string',
        ]);

        $tokenValidation = Agenda::validateDynamicQrToken($request->qr_code_token);
        if (!$tokenValidation['agenda']) {
            return back()->withErrors(['qr_code_token' => $tokenValidation['error']]);
        }

        $agenda = $tokenValidation['agenda'];

        if ($agenda->dosen_id !== $dosen->id && $agenda->dosen_pengampu_id !== $dosen->id) {
            return back()->withErrors(['qr_code_token' => 'Anda bukan Dosen pengajar untuk agenda ini.']);
        }

        if ($agenda->tanggal > date('Y-m-d')) {
            return back()->withErrors(['qr_code_token' => 'Sesi perkuliahan ini belum dimulai. Absensi Dosen hanya dapat dilakukan pada hari pelaksanaan.']);
        }

        if ($agenda->dosen_waktu_masuk) {
            return back()->with('info', 'Anda sudah melakukan absensi masuk untuk agenda ini!');
        }

        $agenda->update([
            'dosen_waktu_masuk' => now(),
        ]);

        return back()->with('success', 'Absensi Dosen BERHASIL dicatat untuk: ' . $agenda->mata_kuliah);
    }

    public function generate16Pertemuan($jadwal_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $jadwal = \App\Models\JadwalPenggunaanLab::with(['lab', 'prodi.fakultas', 'dosenPengampu'])->findOrFail($jadwal_id);

        $dayMap = [
            'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 0
        ];
        
        $targetDayIndex = $dayMap[$jadwal->hari] ?? 1;
        $startDate = \Carbon\Carbon::today();

        while ($startDate->dayOfWeek !== $targetDayIndex) {
            $startDate->addDay();
        }

        $createdCount = 0;
        for ($i = 0; $i < 16; $i++) {
            $date = $startDate->copy()->addWeeks($i)->format('Y-m-d');

            $exists = Agenda::where('jadwal_penggunaan_lab_id', $jadwal->id)
                ->where('tanggal', $date)
                ->exists();

            if (!$exists) {
                Agenda::create([
                    'jadwal_penggunaan_lab_id' => $jadwal->id,
                    'dosen_id' => $jadwal->dosen_id ?? $dosen->id,
                    'dosen_pengampu_id' => $jadwal->dosen_pengampu_id,
                    'lab_id' => $jadwal->lab_id,
                    'mata_kuliah' => $jadwal->mata_kuliah,
                    'fakultas' => $jadwal->prodi->fakultas->nama_fakultas ?? 'Teknik',
                    'jurusan' => $jadwal->prodi->nama_prodi ?? $jadwal->jurusan ?? 'Sistem Informasi',
                    'program_kuliah' => $jadwal->program_kuliah ?? 'Reguler',
                    'jenis_pertemuan' => $jadwal->jenis_pertemuan ?? 'Praktikum',
                    'kelas' => $jadwal->kelas,
                    'semester' => $jadwal->semester ?? '1',
                    'tanggal' => $date,
                    'jam_mulai' => $jadwal->jam_mulai,
                    'jam_selesai' => $jadwal->jam_selesai,
                    'status_agenda' => $date < date('Y-m-d') ? 'Selesai' : ($date === date('Y-m-d') ? 'Berlangsung' : 'Akan Datang'),
                    'catatan' => 'Pertemuan ke-' . ($i + 1) . ': ' . $jadwal->mata_kuliah,
                ]);
                $createdCount++;
            }
        }

        return back()->with('success', "Berhasil membuat {$createdCount} sesi pertemuan perkuliahan 1 semester (Pertemuan 1 s/d 16) secara otomatis!");
    }

    public function generateNewQrToken($id)
    {
        return back()->with('success', 'Token QR diperbarui secara otomatis menggunakan ID Agenda.');
    }

    public function agenda(Request $request)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $query = Agenda::with(['dosen', 'dosenPengampu', 'lab', 'absensi.mahasiswa.user', 'jadwalPenggunaanLab'])
            ->where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            });

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

        if ($request->get('sort') === 'terlama') {
            $query->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc');
        } else {
            $query->orderBy('tanggal', 'desc')->orderBy('jam_mulai', 'desc');
        }

        $allDosenAgendas = (clone $query)->get();
        $groupedAgendas = $allDosenAgendas->groupBy(function($item) {
            $kelasSuffix = $item->kelas ? ' - Kelas ' . $item->kelas : '';
            return $item->mata_kuliah . $kelasSuffix;
        })->map(function($group) {
            return $group->sortBy(function($agenda) {
                return $agenda->tanggal . ' ' . $agenda->jam_mulai;
            })->values();
        });

        $agendas = $query->paginate(15)->withQueryString();

        $dosens = Dosen::orderBy('nama', 'asc')->get();
        $labs = Laboratorium::all();
        $fakultas = \App\Models\Fakultas::all();
        $prodis = \App\Models\Prodi::with('fakultas')->get();

        $jadwalPenggunaanLab = \App\Models\JadwalPenggunaanLab::with(['lab', 'prodi.fakultas', 'dosenPengampu'])
            ->where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            })
            ->where('is_aktif', true)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        $uniqueClasses = Agenda::where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            })
            ->with('dosen')
            ->orderBy('mata_kuliah')
            ->get()
            ->unique(function ($item) {
                return $item->mata_kuliah . '-' . $item->kelas . '-' . $item->dosen_id;
            });

        $dosenAgendaIds = $allDosenAgendas->pluck('id')->toArray();
        $clashingAgendaIds = Agenda::whereIn('id', $dosenAgendaIds)
            ->whereExists(function ($subQuery) {
                $subQuery->select(\DB::raw(1))
                    ->from('agenda as a2')
                    ->whereColumn('a2.lab_id', 'agenda.lab_id')
                    ->whereColumn('a2.tanggal', 'agenda.tanggal')
                    ->whereColumn('a2.id', '!=', 'agenda.id')
                    ->where('a2.status_agenda', '!=', 'Dibatalkan')
                    ->whereRaw('agenda.jam_mulai < a2.jam_selesai')
                    ->whereRaw('agenda.jam_selesai > a2.jam_mulai');
            })
            ->pluck('id')
            ->toArray();

        if ($request->ajax()) {
            $html = view('dosen.agenda_partial', compact('dosen', 'dosens', 'agendas', 'labs', 'fakultas', 'prodis', 'uniqueClasses', 'groupedAgendas', 'jadwalPenggunaanLab', 'clashingAgendaIds'))->render();
            return response()->json(['html' => $html]);
        }

        return view('dosen.agenda', compact('dosen', 'dosens', 'agendas', 'labs', 'fakultas', 'prodis', 'uniqueClasses', 'groupedAgendas', 'jadwalPenggunaanLab', 'clashingAgendaIds'));
    }

    public function inputAbsensi($id)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $agenda = Agenda::with(['dosen', 'lab'])->findOrFail($id);
        
        if ($agenda->dosen_id !== $dosen->id && $agenda->dosen_pengampu_id !== $dosen->id) {
            abort(403, 'Anda tidak memiliki akses ke sesi ini.');
        }

        if ($agenda->tanggal > date('Y-m-d')) {
            return redirect()->route('dosen.dashboard')->withErrors([
                'msg' => 'Sesi perkuliahan ini belum dimulai (Jadwal: ' . \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') . '). Presensi mahasiswa hanya dapat dibuka pada hari H pelaksanaan perkuliahan.'
            ]);
        }

        $existingAbsensi = \App\Models\Absensi::where('agenda_id', $agenda->id)->get()->keyBy('mahasiswa_id');
        $existingAbsensiIds = $existingAbsensi->keys()->toArray();

        // Query Mahasiswa pintar dengan fallback berjenjang
        $baseQuery = \App\Models\Mahasiswa::with(['prodi', 'fakultas']);

        if ($agenda->jurusan) {
            $jurusanClean = trim($agenda->jurusan);
            $baseQuery->whereHas('prodi', function($qP) use ($jurusanClean) {
                $qP->where('nama_prodi', 'like', "%{$jurusanClean}%");
            });
        }

        // 1. Coba match prodi + semester + kelas
        $students = (clone $baseQuery)
            ->when($agenda->semester, function($q) use ($agenda) {
                $semNum = preg_replace('/[^0-9]/', '', $agenda->semester);
                if ($semNum) {
                    $q->where('semester', $semNum);
                }
            })
            ->when($agenda->kelas, function($q) use ($agenda) {
                $kelasClean = trim(preg_replace('/^(IF|SI|TI|Reg|-|\s)+/i', '', $agenda->kelas));
                if ($kelasClean) {
                    $q->where('kelas', 'like', "%{$kelasClean}%");
                }
            })
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        // 2. Jika 0, coba match prodi + semester
        if ($students->isEmpty() && $agenda->semester) {
            $semNum = preg_replace('/[^0-9]/', '', $agenda->semester);
            if ($semNum) {
                $students = (clone $baseQuery)->where('semester', $semNum)->orderBy('nama_lengkap', 'asc')->get();
            }
        }

        // 3. Jika 0, coba match prodi + program_kuliah
        if ($students->isEmpty() && $agenda->program_kuliah) {
            $students = (clone $baseQuery)->where('program_kuliah', $agenda->program_kuliah)->orderBy('nama_lengkap', 'asc')->get();
        }

        // 4. Jika masih 0, ambil seluruh mahasiswa di prodi tersebut
        if ($students->isEmpty() && $agenda->jurusan) {
            $students = (clone $baseQuery)->orderBy('nama_lengkap', 'asc')->get();
        }

        // 5. Fallback utama: jika masih 0, tampilkan seluruh mahasiswa aktif yang terdaftar di database
        if ($students->isEmpty()) {
            $students = \App\Models\Mahasiswa::orderBy('nama_lengkap', 'asc')->get();
        }

        // Gabungkan mahasiswa yang sudah memiliki data absensi di agenda ini agar tidak pernah terlewat
        if (!empty($existingAbsensiIds)) {
            $existingStudents = \App\Models\Mahasiswa::whereIn('id', $existingAbsensiIds)->get();
            $students = $students->merge($existingStudents)->unique('id')->sortBy('nama_lengkap')->values();
        }

        return view('dosen.input_absensi', compact('agenda', 'students', 'existingAbsensi', 'dosen'));
    }

    public function importAbsensi(Request $request, $id)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ], [
            'file_excel.required' => 'Pilih file Excel terlebih dahulu.',
            'file_excel.mimes' => 'Format file harus .xlsx atau .xls'
        ]);

        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
        $agenda = Agenda::findOrFail($id);

        if ($agenda->dosen_id !== $dosen->id && $agenda->dosen_pengampu_id !== $dosen->id) {
            abort(403, 'Anda tidak memiliki akses ke sesi ini.');
        }

        if ($agenda->tanggal > date('Y-m-d')) {
            return redirect()->back()->with('error', 'Tidak dapat mengimpor absensi untuk sesi perkuliahan di masa mendatang.');
        }

        try {
            Excel::import(new KehadiranImport($agenda), $request->file('file_excel'));
            return redirect()->back()->with('success', 'Data absensi berhasil diimpor dari Excel.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function importAbsensiGlobal(Request $request)
    {
        $request->validate([
            'mata_kuliah_kelas' => 'required|string',
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $parts = explode('|', $request->mata_kuliah_kelas);
        $mata_kuliah = $parts[0] ?? '';
        $kelas = $parts[1] ?? '';
        $dosen_id = $parts[2] ?? '';

        $baseAgenda = Agenda::where('mata_kuliah', $mata_kuliah)
            ->where('kelas', $kelas)
            ->where('dosen_id', $dosen_id)
            ->first();

        if (!$baseAgenda || ($baseAgenda->dosen_id !== $dosen->id && $baseAgenda->dosen_pengampu_id !== $dosen->id)) {
            return redirect()->back()->with('error', 'Data mata kuliah/kelas tidak ditemukan atau Anda tidak memiliki akses.');
        }

        try {
            Excel::import(new KehadiranImport($baseAgenda), $request->file('file_excel'));
            return redirect()->back()->with('success', 'Data absensi berhasil diimpor ke seluruh pertemuan untuk kelas tersebut.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function storeInputAbsensi(Request $request, $id)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $agenda = Agenda::findOrFail($id);

        if ($agenda->dosen_id !== $dosen->id && $agenda->dosen_pengampu_id !== $dosen->id) {
            abort(403, 'Anda tidak memiliki akses ke sesi ini.');
        }

        if ($agenda->tanggal > date('Y-m-d')) {
            return redirect()->route('dosen.dashboard')->withErrors([
                'msg' => 'Presensi tidak dapat disimpan untuk sesi perkuliahan yang belum dimulai.'
            ]);
        }

        $request->validate([
            'absensi' => 'required|array',
            'absensi.*' => 'in:Hadir,Izin,Sakit,Alpa,Terlambat'
        ]);

        $waktu_masuk = now();

        foreach ($request->absensi as $mahasiswa_id => $status) {
            $absensi = \App\Models\Absensi::firstOrNew([
                'agenda_id' => $agenda->id,
                'mahasiswa_id' => $mahasiswa_id
            ]);
            
            $absensi->status_kehadiran = $status;
            if (!$absensi->exists) {
                $absensi->waktu_masuk = $waktu_masuk;
            }
            $absensi->save();
        }

        return redirect()->route('dosen.agenda')->with('success', 'Absensi manual berhasil disimpan untuk sesi ' . $agenda->mata_kuliah);
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



    public function bulkDeleteAgendas(Request $request)
    {
        $request->validate([
            'agenda_ids' => 'required|array',
            'agenda_ids.*' => 'exists:agenda,id',
        ]);

        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();

        $deletedCount = Agenda::whereIn('id', $request->agenda_ids)
            ->where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            })
            ->delete();

        return back()->with('success', $deletedCount . ' agenda perkuliahan berhasil dihapus.');
    }

    /**
     * Kalender Visual Ketersediaan Lab untuk Dosen (Senior-Friendly)
     */
    public function jadwalPenggunaanLab(Request $request)
    {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $labs = Laboratorium::orderBy('nama_lab', 'asc')->get();
        $selectedLabId = $request->get('lab_id', $labs->first()->id ?? null);
        $selectedDate = $request->get('tanggal', date('Y-m-d'));
        
        $selectedLab = Laboratorium::find($selectedLabId) ?? $labs->first();
        if ($selectedLab) {
            $selectedLabId = $selectedLab->id;
        }

        // Perhitungan Tanggal & Hari
        $carbonDate = \Carbon\Carbon::parse($selectedDate);
        $dayNames = [
            1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 0 => 'Minggu'
        ];
        $selectedDayName = $dayNames[$carbonDate->dayOfWeek] ?? 'Senin';

        // 1. Ambil jadwal rutin mingguan untuk lab ini
        $rutinJadwals = \App\Models\JadwalPenggunaanLab::with(['dosen', 'prodi'])
            ->where('lab_id', $selectedLabId)
            ->where('is_aktif', true)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 2. Ambil seluruh agenda aktual pada tanggal yang dipilih di lab ini
        $agendasOnDate = Agenda::with(['dosen', 'lab'])
            ->where('lab_id', $selectedLabId)
            ->where('tanggal', $selectedDate)
            ->where('status_agenda', '!=', 'Dibatalkan')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Standar slot waktu harian (08:00 - 21:00)
        $timeSlots = [
            ['start' => '08:00', 'end' => '10:00', 'label' => '08:00 - 10:00 WIB', 'session' => 'Pagi 1'],
            ['start' => '10:00', 'end' => '12:00', 'label' => '10:00 - 12:00 WIB', 'session' => 'Pagi 2'],
            ['start' => '13:00', 'end' => '15:00', 'label' => '13:00 - 15:00 WIB', 'session' => 'Siang 1'],
            ['start' => '15:00', 'end' => '17:00', 'label' => '15:00 - 17:00 WIB', 'session' => 'Sore 1'],
            ['start' => '17:00', 'end' => '19:00', 'label' => '17:00 - 19:00 WIB', 'session' => 'Sore 2'],
            ['start' => '19:00', 'end' => '21:00', 'label' => '19:00 - 21:00 WIB', 'session' => 'Malam 1'],
        ];

        // Hitung ketersediaan slot harian untuk tanggal terpilih
        $slotAvailability = [];
        foreach ($timeSlots as $slot) {
            $slotStart = $slot['start'] . ':00';
            $slotEnd = $slot['end'] . ':00';

            // Cek agenda aktual terlebih dahulu
            $agendaOccupant = $agendasOnDate->first(function($a) use ($slotStart, $slotEnd) {
                return $a->jam_mulai < $slotEnd && $a->jam_selesai > $slotStart;
            });

            // Jika tidak ada agenda aktual, cek jadwal rutin mingguan
            $rutinOccupant = null;
            if (!$agendaOccupant) {
                $rutinOccupant = $rutinJadwals->first(function($j) use ($selectedDayName, $slotStart, $slotEnd) {
                    return $j->hari === $selectedDayName && ($j->jam_mulai < $slotEnd && $j->jam_selesai > $slotStart);
                });
            }

            $occupant = $agendaOccupant ?? $rutinOccupant;
            $isOccupied = !is_null($occupant);
            $isMine = false;
            $title = '';
            $dosenName = '';
            $kelas = '';
            $exactTime = '';

            if ($occupant) {
                $isMine = ($occupant->dosen_id == $dosen->id || ($occupant->dosen_pengampu_id ?? null) == $dosen->id);
                $title = $occupant->mata_kuliah;
                $dosenName = $occupant->dosen->nama ?? 'Dosen';
                $kelas = $occupant->kelas ?? '-';
                $exactTime = substr($occupant->jam_mulai, 0, 5) . ' - ' . substr($occupant->jam_selesai, 0, 5);
            }

            $slotAvailability[] = [
                'slot' => $slot,
                'is_occupied' => $isOccupied,
                'is_mine' => $isMine,
                'title' => $title,
                'dosen_name' => $dosenName,
                'kelas' => $kelas,
                'exact_time' => $exactTime,
                'source' => $agendaOccupant ? 'Agenda' : ($rutinOccupant ? 'Jadwal Rutin' : 'Kosong'),
            ];
        }

        // Data untuk mode Matriks Mingguan
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $matrixSlots = [
            '08.00-10.00', '10.00-12.00', '13.00-15.00', '15.00-17.00', '17.00-19.00', '19.00-21.00'
        ];

        // Daftar kelas dosen untuk modal Buat Agenda / Kuliah Pengganti
        $myClasses = \App\Models\JadwalPenggunaanLab::where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            })
            ->with(['lab', 'prodi'])
            ->get();

        return view('dosen.jadwal_lab', compact(
            'dosen', 'labs', 'selectedLab', 'selectedLabId', 'selectedDate',
            'carbonDate', 'selectedDayName', 'slotAvailability', 'timeSlots',
            'hariList', 'matrixSlots', 'rutinJadwals', 'myClasses'
        ));
    }

    /**
     * Endpoint API Ringan untuk Cek Ketersediaan Lab Real-time (Anti-Bentrok)
     */
    public function checkLabAvailability(Request $request)
    {
        $labId = $request->get('lab_id');
        $tanggal = $request->get('tanggal');
        $waktuMasuk = $request->get('waktu_masuk');
        $waktuKeluar = $request->get('waktu_keluar');
        $excludeAgendaId = $request->get('exclude_agenda_id');
        $dosen = Dosen::where('user_id', auth()->id())->first();

        if (!$labId || !$tanggal || !$waktuMasuk || !$waktuKeluar) {
            return response()->json(['available' => true, 'message' => 'Lengkapi data jam untuk cek ketersediaan.']);
        }

        // 1. Cek bentrok ruangan lab
        $clashLab = Agenda::with('dosen')
            ->where('lab_id', $labId)
            ->where('tanggal', $tanggal)
            ->where('status_agenda', '!=', 'Dibatalkan')
            ->when($excludeAgendaId, fn($q) => $q->where('id', '!=', $excludeAgendaId))
            ->where(function ($query) use ($waktuMasuk, $waktuKeluar) {
                $query->where('jam_mulai', '<', $waktuKeluar)
                      ->where('jam_selesai', '>', $waktuMasuk);
            })
            ->first();

        if ($clashLab) {
            $jam = substr($clashLab->jam_mulai, 0, 5) . ' - ' . substr($clashLab->jam_selesai, 0, 5);
            $dosenName = $clashLab->dosen->nama ?? 'Dosen Lain';
            return response()->json([
                'available' => false,
                'clash_type' => 'lab',
                'title' => 'Lab Sudah Terisi!',
                'message' => "Ruangan lab pada jam {$jam} WIB sudah digunakan untuk \"{$clashLab->mata_kuliah} ({$clashLab->kelas})\" oleh {$dosenName}.",
            ]);
        }

        // 2. Cek bentrok dosen
        if ($dosen) {
            $clashDosen = Agenda::with('lab')
                ->where('dosen_id', $dosen->id)
                ->where('tanggal', $tanggal)
                ->where('status_agenda', '!=', 'Dibatalkan')
                ->when($excludeAgendaId, fn($q) => $q->where('id', '!=', $excludeAgendaId))
                ->where(function ($query) use ($waktuMasuk, $waktuKeluar) {
                    $query->where('jam_mulai', '<', $waktuKeluar)
                          ->where('jam_selesai', '>', $waktuMasuk);
                })
                ->first();

            if ($clashDosen) {
                $jam = substr($clashDosen->jam_mulai, 0, 5) . ' - ' . substr($clashDosen->jam_selesai, 0, 5);
                $labName = $clashDosen->lab->nama_lab ?? 'Lab';
                return response()->json([
                    'available' => false,
                    'clash_type' => 'dosen',
                    'title' => 'Bentrok Jadwal Dosen!',
                    'message' => "Anda sudah memiliki jadwal mengajar lain di {$labName} pada jam {$jam} WIB (\"{$clashDosen->mata_kuliah}\").",
                ]);
            }
        }

        return response()->json([
            'available' => true,
            'title' => 'Ruangan Tersedia!',
            'message' => 'Lab dan jam yang Anda pilih kosong dan siap digunakan.',
        ]);
    }
}
