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

        if ($request->ajax()) {
            $html = view('dosen.agenda_partial', compact('dosen', 'dosens', 'agendas', 'labs', 'fakultas', 'prodis', 'uniqueClasses', 'groupedAgendas', 'jadwalPenggunaanLab'))->render();
            return response()->json(['html' => $html]);
        }

        return view('dosen.agenda', compact('dosen', 'dosens', 'agendas', 'labs', 'fakultas', 'prodis', 'uniqueClasses', 'groupedAgendas', 'jadwalPenggunaanLab'));
    }

    public function inputAbsensi($id)
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();

        $agenda = Agenda::with(['dosen', 'lab'])->findOrFail($id);
        
        if ($agenda->dosen_id !== $dosen->id && $agenda->dosen_pengampu_id !== $dosen->id) {
            abort(403, 'Anda tidak memiliki akses ke sesi ini.');
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

        Agenda::whereIn('id', $request->agenda_ids)
            ->where('dosen_id', $dosen->id)
            ->delete();

        return back()->with('success', 'Agenda terpilih berhasil dihapus.');
    }
}
