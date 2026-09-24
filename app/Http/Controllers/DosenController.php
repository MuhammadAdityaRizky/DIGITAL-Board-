<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use App\Models\Pengumuman;

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

        if (!$dosen && ($user->isSuperAdmin() || $user->isAdminFakultas())) {
            if (request()->filled('dosen_id')) {
                $dosen = Dosen::find(request('dosen_id'));
            }
            if (!$dosen) {
                $dosen = Dosen::whereHas('agendas')->first() ?? Dosen::first();
            }
        }

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
                'materi_pembelajaran' => 'nullable|string',
                'rencana_pembelajaran' => 'nullable|string',
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
                'tahun_akademik' => $jadwal->tahun_akademik ?? '2026/2027 Ganjil',
                'jenis_pertemuan' => 'Praktikum',
                'kelas' => $jadwal->kelas ?? 'Reg A',
                'semester' => $jadwal->semester ?? '1',
                'jurusan' => $jadwal->prodi->nama_prodi ?? 'Sistem Informasi',
                'fakultas' => $jadwal->prodi->fakultas->nama_fakultas ?? 'Fakultas Teknik & Sains',
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->waktu_masuk,
                'jam_selesai' => $request->waktu_keluar,
                'status_agenda' => 'Akan Datang',
                'catatan' => $request->materi_pembelajaran ?? $request->rencana_pembelajaran ?? '',
            ]);

            return back()->with('success', 'Agenda pembelajaran untuk ' . $jadwal->mata_kuliah . ' (' . $jadwal->kelas . ') berhasil dibuat.');
        }

        $request->validate([
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required_without:mata_kuliah|nullable|string|max:150',
            'mata_kuliah' => 'nullable|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'nullable|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'materi_pembelajaran' => 'nullable|string',
            'rencana_pembelajaran' => 'nullable|string',
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

        // Hitung status agenda secara otomatis berdasarkan tanggal dan waktu
        $tanggalCarbon = \Carbon\Carbon::parse($request->tanggal);
        if ($tanggalCarbon->isPast() && !$tanggalCarbon->isToday()) {
            $statusAgenda = 'Selesai';
        } elseif ($tanggalCarbon->isFuture() && !$tanggalCarbon->isToday()) {
            $statusAgenda = 'Akan Datang';
        } else {
            $nowTime = now()->format('H:i:s');
            $mulai = $request->waktu_masuk . (strlen($request->waktu_masuk) == 5 ? ':00' : '');
            $selesai = $request->waktu_keluar . (strlen($request->waktu_keluar) == 5 ? ':00' : '');
            if ($nowTime < $mulai) {
                $statusAgenda = 'Akan Datang';
            } elseif ($nowTime >= $mulai && $nowTime <= $selesai) {
                $statusAgenda = 'Berlangsung';
            } else {
                $statusAgenda = 'Selesai';
            }
        }

        Agenda::create([
            'dosen_id' => $dosen->id,
            'dosen_pengampu_id' => $request->dosen_pengampu_id ?: $dosen->id,
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->mata_kuliah ?: $request->judul_agenda,
            'program_kuliah' => $request->program_kuliah,
            'tahun_akademik' => $request->tahun_akademik ?? '2026/2027 Ganjil',
            'jenis_pertemuan' => $request->jenis_pertemuan ?? 'Praktikum',
            'kelas' => $request->kelas ?? '',
            'semester' => $request->semester,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->waktu_masuk,
            'jam_selesai' => $request->waktu_keluar,
            'status_agenda' => $statusAgenda,
            'catatan' => $request->materi_pembelajaran ?? $request->rencana_pembelajaran ?? '',
        ]);

        return back()->with('success', 'Agenda pembelajaran berhasil dibuat.');
    }

    public function updateAgenda(Request $request, $id)
    {
        $request->validate([
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required_without:mata_kuliah|nullable|string|max:150',
            'mata_kuliah' => 'nullable|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'nullable|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'materi_pembelajaran' => 'nullable|string',
            'rencana_pembelajaran' => 'nullable|string',
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

        // Hitung status agenda secara otomatis jika tidak dibatalkan
        $statusAgenda = $agenda->status_agenda;
        if ($statusAgenda !== 'Dibatalkan') {
            $tanggalCarbon = \Carbon\Carbon::parse($request->tanggal);
            if ($tanggalCarbon->isPast() && !$tanggalCarbon->isToday()) {
                $statusAgenda = 'Selesai';
            } elseif ($tanggalCarbon->isFuture() && !$tanggalCarbon->isToday()) {
                $statusAgenda = 'Akan Datang';
            } else {
                $nowTime = now()->format('H:i:s');
                $mulai = $request->waktu_masuk . (strlen($request->waktu_masuk) == 5 ? ':00' : '');
                $selesai = $request->waktu_keluar . (strlen($request->waktu_keluar) == 5 ? ':00' : '');
                if ($nowTime < $mulai) {
                    $statusAgenda = 'Akan Datang';
                } elseif ($nowTime >= $mulai && $nowTime <= $selesai) {
                    $statusAgenda = 'Berlangsung';
                } else {
                    $statusAgenda = 'Selesai';
                }
            }
        }

        $agenda->update([
            'dosen_pengampu_id' => $request->dosen_pengampu_id ?: $agenda->dosen_pengampu_id,
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->mata_kuliah ?: ($request->judul_agenda ?: $agenda->mata_kuliah),
            'program_kuliah' => $request->program_kuliah,
            'jenis_pertemuan' => $request->jenis_pertemuan ?? 'Praktikum',
            'kelas' => $request->kelas ?? '',
            'semester' => $request->semester,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->waktu_masuk,
            'jam_selesai' => $request->waktu_keluar,
            'status_agenda' => $statusAgenda,
            'catatan' => $request->materi_pembelajaran ?? ($request->rencana_pembelajaran ?? $agenda->catatan),
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

    public function selesaiAgenda($id)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->first();
        $agenda = Agenda::findOrFail($id);

        if (!$dosen || ($agenda->dosen_id !== $dosen->id && $agenda->dosen_pengampu_id !== $dosen->id)) {
            abort(403, 'Akses Ditolak');
        }

        $agenda->update(['status_agenda' => 'Selesai']);

        return back()->with('success', 'Kelas berhasil diakhiri (Selesai).');
    }

    public function updateBeritaAcara(Request $request, $id)
    {
        $request->validate([
            'materi' => 'nullable|string',
            'berita_acara' => 'nullable|string',
            'catatan' => 'nullable|string',
            'laboran' => 'nullable|string|max:150',
            'asisten' => 'nullable|string|max:150',
            'dosen' => 'nullable|string|max:150',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        $agenda = Agenda::findOrFail($id);

        if ($agenda->tanggal > date('Y-m-d')) {
            return back()->withErrors(['berita_acara' => 'Berita Acara belum dapat diisi untuk sesi yang belum dimulai.']);
        }

        $materi = $request->filled('materi') ? $request->materi : ($agenda->materi_realisasi ?: $agenda->catatan);
        $catatan = $request->filled('catatan') ? $request->catatan : ($request->filled('berita_acara') ? $request->berita_acara : '');

        // Capture metadata from schedule and institutional data, with support for manual overrides
        $details = $agenda->berita_acara_details;
        $laboran = $request->filled('laboran') ? trim($request->laboran) : $details['laboran'];
        $asisten = $request->filled('asisten') ? trim($request->asisten) : $details['asisten'];
        $dosenNama = $request->filled('dosen') ? trim($request->dosen) : $details['dosen'];
        $tahunAjaran = $request->filled('tahun_ajaran') ? trim($request->tahun_ajaran) : $details['tahun_ajaran'];

        $payload = [
            'materi' => $materi,
            'catatan' => $catatan,
            'laboran' => $laboran,
            'asisten' => $asisten,
            'dosen' => $dosenNama,
            'tahun_ajaran' => $tahunAjaran,
            'updated_at' => now()->toDateTimeString(),
        ];

        $updateData = [
            'berita_acara' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ];

        if ($request->filled('materi')) {
            $updateData['materi_realisasi'] = $request->materi;
        }

        $agenda->update($updateData);

        return back()->with('success', 'Berita Acara resmi praktikum berhasil disimpan.');
    }

    public function cetakBeritaAcara(Request $request, $id)
    {
        $user = auth()->user();

        // 1. Ambil data agenda (Mendukung mode cetak semua global, cetak terpilih, atau per mata kuliah)
        if ($id === 'all' || $request->get('mode') === 'all_global' || $request->get('ids') === 'all') {
            $query = Agenda::with(['dosen', 'dosenPengampu', 'lab', 'absensi.mahasiswa']);
            if ($user->role === 'dosen') {
                $dosen = Dosen::where('user_id', $user->id)->first();
                if ($dosen) {
                    $query->where(function($q) use ($dosen) {
                        $q->where('dosen_id', $dosen->id)
                          ->orWhere('dosen_pengampu_id', $dosen->id);
                    });
                }
            }
            $agendas = $query->get();
        } else {
            $baseAgenda = Agenda::with(['dosen', 'dosenPengampu', 'lab'])->find($id);

            if ($user->role === 'dosen' && $baseAgenda) {
                $dosen = Dosen::where('user_id', $user->id)->first();
                if ($dosen && $baseAgenda->dosen_id !== $dosen->id && $baseAgenda->dosen_pengampu_id !== $dosen->id) {
                    abort(403, 'Anda tidak memiliki akses ke Berita Acara ini.');
                }
            }

            if ($request->filled('ids')) {
                $rawIds = is_array($request->ids) ? $request->ids : explode(',', $request->ids);
                $ids = array_filter(array_map('intval', $rawIds));

                $agendas = Agenda::with(['dosen', 'dosenPengampu', 'lab', 'absensi.mahasiswa'])
                    ->whereIn('id', $ids)
                    ->get();
            } elseif ($request->boolean('all_mk') || $request->get('mode') === 'all') {
                $query = Agenda::with(['dosen', 'dosenPengampu', 'lab', 'absensi.mahasiswa']);
                if ($baseAgenda && $baseAgenda->jadwal_penggunaan_lab_id) {
                    $query->where('jadwal_penggunaan_lab_id', $baseAgenda->jadwal_penggunaan_lab_id);
                } elseif ($baseAgenda) {
                    $query->where('mata_kuliah', $baseAgenda->mata_kuliah)
                          ->where('kelas', $baseAgenda->kelas)
                          ->where('program_kuliah', $baseAgenda->program_kuliah)
                          ->where('dosen_id', $baseAgenda->dosen_id);
                }
                $agendas = $query->get();
            } else {
                $agendas = $baseAgenda ? collect([$baseAgenda]) : collect();
                if ($baseAgenda) {
                    $baseAgenda->load('absensi.mahasiswa');
                }
            }
        }

        if ($agendas->isEmpty()) {
            abort(404, 'Agenda pertemuan tidak ditemukan.');
        }

        $items = $agendas->map(function($ag) {
            return [
                'agenda' => $ag,
                'details' => $ag->berita_acara_details,
            ];
        });

        // Urutkan Rapi berdasarkan: Dosen (A-Z) -> Mata Kuliah (A-Z) -> Kelas (A-Z) -> Tanggal/Waktu
        $items = $items->sort(function ($a, $b) {
            // 1. Nama Dosen (A-Z)
            $dosenA = strtolower(trim($a['details']['dosen'] ?? $a['agenda']->dosenPengampu?->nama ?? $a['agenda']->dosen?->nama ?? ''));
            $dosenB = strtolower(trim($b['details']['dosen'] ?? $b['agenda']->dosenPengampu?->nama ?? $b['agenda']->dosen?->nama ?? ''));
            if ($dosenA !== $dosenB) {
                return strcmp($dosenA, $dosenB);
            }

            // 2. Nama Mata Kuliah (A-Z)
            $mkA = strtolower(trim($a['agenda']->mata_kuliah ?? ''));
            $mkB = strtolower(trim($b['agenda']->mata_kuliah ?? ''));
            if ($mkA !== $mkB) {
                return strcmp($mkA, $mkB);
            }

            // 3. Kelas (A-Z)
            $kelasA = strtolower(trim($a['agenda']->kelas ?? ''));
            $kelasB = strtolower(trim($b['agenda']->kelas ?? ''));
            if ($kelasA !== $kelasB) {
                return strcmp($kelasA, $kelasB);
            }

            // 4. Tanggal & Jam Pertemuan (Ascending)
            $tglA = ($a['agenda']->tanggal ?? '') . ' ' . ($a['agenda']->jam_mulai ?? '');
            $tglB = ($b['agenda']->tanggal ?? '') . ' ' . ($b['agenda']->jam_mulai ?? '');
            return strcmp($tglA, $tglB);
        })->values();

        $agenda = $items->first()['agenda'];
        $details = $items->first()['details'] ?? [];
        $totalItems = $items->count();

        return view('dosen.cetak_berita_acara', compact('items', 'agenda', 'details', 'totalItems'));
    }

    public function cetakRealisasiPraktikum($id)
    {
        $user = auth()->user();
        $agenda = Agenda::with(['dosen', 'dosenPengampu', 'lab', 'jadwalPenggunaanLab.prodi'])->findOrFail($id);

        if ($user->role === 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen && $agenda->dosen_id !== $dosen->id && $agenda->dosen_pengampu_id !== $dosen->id) {
                abort(403, 'Anda tidak memiliki akses ke dokumen Realisasi Praktikum ini.');
            }
        }

        // Ambil seluruh sesi pertemuan untuk mata kuliah & kelas ini
        $query = Agenda::with(['dosen', 'dosenPengampu', 'lab']);
        if ($agenda->jadwal_penggunaan_lab_id) {
            $query->where('jadwal_penggunaan_lab_id', $agenda->jadwal_penggunaan_lab_id);
        } else {
            $query->where('mata_kuliah', $agenda->mata_kuliah)
                  ->where('kelas', $agenda->kelas)
                  ->where('program_kuliah', $agenda->program_kuliah)
                  ->where('dosen_id', $agenda->dosen_id);
        }
        $agendas = $query->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc')->get();

        // Format Dosen / Dosen Pengampu (Dinamis dari relasi DB)
        $dosenUtama = $agenda->dosenPengampu->nama ?? $agenda->dosen->nama ?? '-';
        $dosenPendamping = null;
        if ($agenda->dosen_pengampu_id && $agenda->dosen_pengampu_id != $agenda->dosen_id && $agenda->dosen) {
            $dosenUtama = $agenda->dosenPengampu->nama;
            $dosenPendamping = $agenda->dosen->nama;
        }
        $dosenDisplay = $dosenPendamping ? "{$dosenUtama} / {$dosenPendamping}" : $dosenUtama;

        // Prodi
        $prodi = strtoupper($agenda->jurusan ?: ($agenda->jadwalPenggunaanLab?->prodi?->nama_prodi ?: 'SISTEM INFORMASI'));

        // Program Kuliah & Kelas (Reguler vs Karyawan)
        $programKuliah = $agenda->program_kuliah 
            ?? $agenda->jadwalPenggunaanLab?->program_kuliah 
            ?? 'Reguler';
            
        $kelasRaw = trim($agenda->kelas ?? ($agenda->jadwalPenggunaanLab?->kelas ?? ''));

        $isKaryawan = stripos($programKuliah, 'karyawan') !== false 
            || stripos($kelasRaw, 'karyawan') !== false 
            || stripos($kelasRaw, 'kar') !== false;

        if ($isKaryawan) {
            $suffix = trim(preg_replace('/karyawan|kar|\s+/i', ' ', $kelasRaw));
            $kelasFormatted = $suffix ? "Karyawan {$suffix}" : "Karyawan";
        } else {
            // Reguler
            $suffix = trim(preg_replace('/reguler|reg|\s+/i', ' ', $kelasRaw));
            $kelasFormatted = $suffix ? "Reg {$suffix}" : "Reg";
        }

        // Semester & Kelas (misal "II / Reg A" atau "II / Reg")
        $romanMap = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII'];
        $semRaw = (int) $agenda->semester;
        $semesterRomawi = $romanMap[$semRaw] ?? ($agenda->semester ?: 'II');
        $semesterKelas = "{$semesterRomawi} / {$kelasFormatted}";

        // Tahun Akademik & Teks Semester (SEMESTER GENAP / SEMESTER GANJIL)
        $tahunAkademikRaw = $agenda->tahun_akademik ?? ($agenda->jadwalPenggunaanLab?->tahun_akademik ?? '2025/2026 Genap');
        $isGenap = stripos($tahunAkademikRaw, 'genap') !== false || ($semRaw > 0 && $semRaw % 2 === 0);
        $semesterTeks = $isGenap ? 'SEMESTER GENAP' : 'SEMESTER GANJIL';

        $tahunAjaran = '2025 / 2026';
        if (preg_match('/(\d{4})\/(\d{4})/', $tahunAkademikRaw, $m)) {
            $tahunAjaran = "{$m[1]} / {$m[2]}";
        } elseif (preg_match('/(\d{4})/', $tahunAkademikRaw, $m)) {
            $tahunAjaran = $m[1] . ' / ' . ((int)$m[1] + 1);
        }

        // Kode Mata Kuliah & SKS diambil dinamis dari Master Data Mata Kuliah
        $masterMk = \App\Models\MataKuliah::where('nama_mk', $agenda->mata_kuliah)->first()
            ?? \App\Models\MataKuliah::where('nama_mk', 'LIKE', '%' . trim($agenda->mata_kuliah) . '%')->first();

        $kodeMatkul = $masterMk?->kode_mk;
        if (!$kodeMatkul && preg_match('/^([A-Z0-9]{4,10})\s*[-:]\s*(.+)/', $agenda->mata_kuliah, $m)) {
            $kodeMatkul = $m[1];
        }
        $kodeMatkul = $kodeMatkul ?: '-';

        $sks = $masterMk?->sks ?: 1;

        return view('dosen.cetak_realisasi_praktikum', compact(
            'agenda',
            'agendas',
            'dosenDisplay',
            'prodi',
            'semesterKelas',
            'semesterTeks',
            'tahunAjaran',
            'kodeMatkul',
            'sks'
        ));
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
                    'tahun_akademik' => $jadwal->tahun_akademik ?? '2026/2027 Ganjil',
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
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen && ($user->isSuperAdmin() || $user->isAdminFakultas())) {
            if ($request->filled('dosen_id')) {
                $dosen = Dosen::find($request->dosen_id);
            }
            if (!$dosen) {
                $dosen = Dosen::whereHas('agendas')->first() ?? Dosen::first();
            }
        }

        if (!$dosen) {
            return redirect()->route('login')->withErrors(['msg' => 'Data profil Dosen tidak ditemukan. Silakan hubungi Administrator.']);
        }

        $query = Agenda::with(['dosen', 'dosenPengampu', 'lab', 'absensi.mahasiswa.user', 'jadwalPenggunaanLab'])
            ->where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('mata_kuliah', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('status_agenda')) {
            $query->where('status_agenda', $request->status_agenda);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->get('sort') === 'terlama') {
            $query->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc');
        } else {
            $query->orderBy('tanggal', 'desc')->orderBy('jam_mulai', 'desc');
        }

        $allDosenAgendas = (clone $query)->get();
        $isSortDesc = $request->get('sort') !== 'terlama';
        $groupedAgendas = $allDosenAgendas->groupBy(function($item) {
            $progSuffix = $item->program_kuliah ? ' (' . $item->program_kuliah . ')' : '';
            $kelasSuffix = $item->kelas ? ' - Kelas ' . $item->kelas : '';
            return $item->mata_kuliah . $progSuffix . $kelasSuffix;
        })->map(function($group) use ($isSortDesc) {
            return $group->sortBy(function($agenda) {
                return $agenda->tanggal . ' ' . $agenda->jam_mulai;
            }, SORT_REGULAR, $isSortDesc)->values();
        });

        if ($isSortDesc) {
            $groupedAgendas = $groupedAgendas->sortByDesc(fn($g) => ($g->max('tanggal') ?? '') . ' ' . ($g->max('jam_mulai') ?? ''));
        } else {
            $groupedAgendas = $groupedAgendas->sortBy(fn($g) => ($g->min('tanggal') ?? '') . ' ' . ($g->min('jam_mulai') ?? ''));
        }

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
                return $item->mata_kuliah . '-' . $item->kelas . '-' . ($item->program_kuliah ?: 'Reguler') . '-' . $item->dosen_id;
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
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return redirect()->route('dosen.dashboard')->withErrors(['msg' => 'Data profil Dosen tidak ditemukan.']);
        }

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

        $students = $agenda->getStudentsQuery()->orderBy('nama_lengkap', 'asc')->get();

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
        $dosen = Dosen::where('user_id', $user->id)->first();
        if (!$dosen) {
            return back()->with('error', 'Data profil Dosen tidak ditemukan.');
        }
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
        $dosen = Dosen::where('user_id', $user->id)->first();
        if (!$dosen) {
            return back()->with('error', 'Data profil Dosen tidak ditemukan.');
        }

        $parts = explode('|', $request->mata_kuliah_kelas);
        $mata_kuliah = $parts[0] ?? '';
        $kelas = $parts[1] ?? '';
        $dosen_id = $parts[2] ?? '';
        $program_kuliah = $parts[3] ?? null;

        $baseAgendaQuery = Agenda::where('mata_kuliah', $mata_kuliah)
            ->where('kelas', $kelas)
            ->where('dosen_id', $dosen_id);

        if ($program_kuliah) {
            $baseAgendaQuery->where('program_kuliah', $program_kuliah);
        }

        $baseAgenda = $baseAgendaQuery->first();

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
        $dosen = Dosen::where('user_id', $user->id)->first();
        if (!$dosen) {
            return back()->with('error', 'Data profil Dosen tidak ditemukan.');
        }

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
        $dosen = Dosen::where('user_id', $user->id)->first();
        if (!$dosen && ($user->isSuperAdmin() || $user->isAdminFakultas())) {
            $dosen = Dosen::first();
        }
        if (!$dosen) {
            return redirect()->route('dosen.dashboard')->withErrors(['msg' => 'Data profil Dosen tidak ditemukan.']);
        }
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

    public function bulkDeleteAgendas(Request $request)
    {
        $request->validate([
            'agenda_ids' => 'required|array',
            'agenda_ids.*' => 'exists:agenda,id',
        ]);

        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            return back()->with('error', 'Data profil Dosen tidak ditemukan.');
        }

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
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen && ($user->isSuperAdmin() || $user->isAdminFakultas())) {
            if ($request->filled('dosen_id')) {
                $dosen = Dosen::find($request->dosen_id);
            }
            if (!$dosen) {
                $dosen = Dosen::whereHas('agendas')->first() ?? Dosen::first();
            }
        }

        if (!$dosen) {
            return redirect()->route('login')->withErrors(['msg' => 'Data profil Dosen tidak ditemukan.']);
        }
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

        // Standar slot waktu harian (08:00 - 23:00)
        $timeSlots = [
            ['start' => '08:00', 'end' => '10:00', 'label' => '08:00 - 10:00 WIB', 'session' => 'Pagi 1'],
            ['start' => '10:00', 'end' => '12:00', 'label' => '10:00 - 12:00 WIB', 'session' => 'Pagi 2'],
            ['start' => '13:00', 'end' => '15:00', 'label' => '13:00 - 15:00 WIB', 'session' => 'Siang 1'],
            ['start' => '15:00', 'end' => '17:00', 'label' => '15:00 - 17:00 WIB', 'session' => 'Sore 1'],
            ['start' => '17:00', 'end' => '19:00', 'label' => '17:00 - 19:00 WIB', 'session' => 'Sore 2'],
            ['start' => '19:00', 'end' => '21:00', 'label' => '19:00 - 21:00 WIB', 'session' => 'Malam 1'],
            ['start' => '21:00', 'end' => '23:00', 'label' => '21:00 - 23:00 WIB', 'session' => 'Malam 2'],
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
            '08.00-10.00', '10.00-12.00', '13.00-15.00', '15.00-17.00', '17.00-19.00', '19.00-21.00', '21.00-23.00'
        ];

        // Daftar kelas dosen untuk modal Buat Agenda / Kuliah Pengganti
        $myClasses = \App\Models\JadwalPenggunaanLab::where(function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id)
                  ->orWhere('dosen_pengampu_id', $dosen->id);
            })
            ->with(['lab', 'prodi'])
            ->get();

        $dosens = Dosen::orderBy('nama', 'asc')->get();

        return view('dosen.jadwal_lab', compact(
            'dosen', 'dosens', 'labs', 'selectedLab', 'selectedLabId', 'selectedDate',
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
