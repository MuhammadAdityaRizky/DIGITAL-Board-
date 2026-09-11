<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use App\Models\Mahasiswa;
use App\Models\Pengumuman;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\JadwalPenggunaanLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use App\Imports\DosenImport;
use App\Imports\AgendaImport;
use App\Imports\LaboratoriumImport;
use App\Imports\FakultasImport;
use App\Imports\ProdiImport;
use App\Imports\KelasImport;
use App\Imports\KehadiranImport;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $dosenCount = Dosen::count();
        $mhsCount = Mahasiswa::count();
        $labCount = Laboratorium::count();
        $agendaCount = Agenda::count();

        // Today's attendance summary
        $today = date('Y-m-d');
        $todayHadir = Absensi::whereDate('waktu_masuk', $today)->where('status_kehadiran', 'Hadir')->count();
        $todayIzin = Absensi::whereDate('waktu_masuk', $today)->where('status_kehadiran', 'Izin')->count();
        $todayAlpa = Absensi::whereDate('waktu_masuk', $today)->where('status_kehadiran', 'Alpa')->count();

        // Recent activity
        $recentAbsensi = Absensi::with(['mahasiswa.user', 'agenda.lab'])
            ->orderBy('waktu_masuk', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'usersCount', 'dosenCount', 'mhsCount', 'labCount', 'agendaCount',
            'todayHadir', 'todayIzin', 'todayAlpa', 'recentAbsensi'
        ));
    }

    public function pengguna(Request $request)
    {
        $query = User::with(['dosen.fakultas', 'dosen.prodi', 'mahasiswa.fakultas', 'mahasiswa.prodi'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhereHas('dosen', function($qd) use ($search) {
                      $qd->where('nama', 'like', "%{$search}%")
                        ->orWhere('nip', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mahasiswa', function($qm) use ($search) {
                      $qm->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('role')) {
            $role = strtolower(trim($request->role));
            $query->where('role', $role);
        }

        if ($request->filled('program_kuliah')) {
            $program = $request->program_kuliah;
            $query->whereHas('mahasiswa', function($q) use ($program) {
                $q->where('program_kuliah', $program);
            });
        }

        if ($request->filled('semester')) {
            $semester = $request->semester;
            $query->whereHas('mahasiswa', function($q) use ($semester) {
                $q->where('semester', $semester);
            });
        }

        if ($request->filled('kelas')) {
            $kelas = $request->kelas;
            $query->whereHas('mahasiswa', function($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }

        if ($request->filled('status_mahasiswa')) {
            $statusMhs = strtolower($request->status_mahasiswa);
            $query->whereHas('mahasiswa', function($q) use ($statusMhs) {
                $q->where('status', $statusMhs);
            });
        }

        $users = $query->paginate(50)->withQueryString();
        $fakultas = Fakultas::all();
        $prodis = Prodi::all();
        $kelases = Kelas::all();

        return view('admin.pengguna', compact('users', 'fakultas', 'prodis', 'kelases'));
    }

    public function deleteUser($id)
    {
        if (auth()->id() == $id) {
            return back()->withErrors(['msg' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }
        User::destroy($id);
        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }

    public function bulkDeleteUsers(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || empty($ids)) {
            return back()->withErrors(['msg' => 'Tidak ada pengguna yang dipilih untuk dihapus.']);
        }

        // Prevent admin from deleting themselves in bulk
        $ids = array_diff($ids, [auth()->id()]);

        if (empty($ids)) {
            return back()->withErrors(['msg' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        User::whereIn('id', $ids)->delete();
        
        return back()->with('success', count($ids) . ' akun pengguna berhasil dihapus.');
    }

    public function laboratorium(Request $request)
    {
        $query = Laboratorium::orderBy('nama_lab', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lab', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
        }

        $labs = $query->paginate(10)->withQueryString();

        return view('admin.laboratorium', compact('labs'));
    }

    public function updateLab(Request $request, $id)
    {
        $request->validate([
            'nama_lab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'kapasitas' => 'required|integer',
        ]);

        $lab = Laboratorium::findOrFail($id);
        $lab->update([
            'nama_lab' => $request->nama_lab,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
        ]);

        return back()->with('success', 'Data laboratorium berhasil diperbarui.');
    }

    public function deleteLab($id)
    {
        try {
            $lab = Laboratorium::findOrFail($id);

            // 1. Get all agenda IDs associated with this lab
            $agendaIds = Agenda::where('lab_id', $id)->pluck('id');
            
            // 2. Delete absensi associated with those agendas
            if ($agendaIds->count() > 0) {
                \App\Models\Absensi::whereIn('agenda_id', $agendaIds)->delete();
            }

            // 3. Delete agendas for this lab
            Agenda::where('lab_id', $id)->delete();

            // 4. Delete jadwal_penggunaan_lab for this lab
            \App\Models\JadwalPenggunaanLab::where('lab_id', $id)->delete();

            // 5. Detach pengumuman pivot
            $lab->pengumumans()->detach();

            // 6. Delete lab
            $lab->delete();

            return back()->with('success', 'Laboratorium dan seluruh data terkait berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal menghapus laboratorium: ' . $e->getMessage()]);
        }
    }

    public function generate16Pertemuan($id)
    {
        $jadwal = \App\Models\JadwalPenggunaanLab::with(['lab', 'prodi.fakultas', 'dosenPengampu'])->findOrFail($id);

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
                    'dosen_id' => $jadwal->dosen_id,
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

        return back()->with('success', "Berhasil membuat {$createdCount} sesi pertemuan (Pertemuan 1 s/d 16) untuk " . $jadwal->mata_kuliah);
    }

    public function agenda(Request $request)
    {
        $query = Agenda::with(['dosen', 'dosenPengampu', 'lab']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('mata_kuliah', 'like', "%{$search}%")
                  ->orWhereHas('dosen', function($qd) use ($search) {
                      $qd->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('dosenPengampu', function($qd) use ($search) {
                      $qd->where('nama', 'like', "%{$search}%");
                  });
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

        $allAgendas = $query->get();

        $dosens = Dosen::orderBy('nama', 'asc')->get();
        $labs = Laboratorium::orderBy('nama_lab', 'asc')->get();
        $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();
        $prodis = Prodi::with('fakultas')->orderBy('nama_prodi', 'asc')->get();
        $kelases = Kelas::all();
        $mataKuliahs = MataKuliah::orderBy('nama_mk', 'asc')->get();

        return view('admin.agenda', compact('allAgendas', 'dosens', 'labs', 'fakultas', 'prodis', 'kelases', 'mataKuliahs'));
    }

    public function storeAgenda(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'required|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'status_agenda' => 'required|in:Akan Datang,Berlangsung,Selesai,Dibatalkan',
            'rencana_pembelajaran' => 'nullable|string',
        ]);

        Agenda::create([
            'dosen_id' => $request->dosen_id,
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
            'status_agenda' => $request->status_agenda,
            'catatan' => $request->rencana_pembelajaran ?? '',
        ]);

        return back()->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function updateAgenda(Request $request, $id)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'required|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'status_agenda' => 'required|in:Akan Datang,Berlangsung,Selesai,Dibatalkan',
            'rencana_pembelajaran' => 'nullable|string',
        ]);

        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'dosen_id' => $request->dosen_id,
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
            'status_agenda' => $request->status_agenda,
            'catatan' => $request->rencana_pembelajaran ?? '',
        ]);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function deleteAgenda($id)
    {
        Agenda::destroy($id);
        return back()->with('success', 'Agenda praktikum berhasil dihapus.');
    }

    public function bulkDeleteAgendas(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || empty($ids)) {
            return back()->withErrors(['msg' => 'Tidak ada agenda yang dipilih untuk dihapus.']);
        }

        Agenda::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' agenda praktikum berhasil dihapus.');
    }

    public function absensi(Request $request)
    {
        $query = Agenda::with(['dosen', 'lab', 'absensi.mahasiswa'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('mata_kuliah', 'like', "%{$search}%")
                  ->orWhereHas('dosen', function($qd) use ($search) {
                      $qd->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $agendas = $query->paginate(10)->withQueryString();

        $uniqueClasses = Agenda::with('dosen')
            ->orderBy('mata_kuliah')
            ->get()
            ->unique(function ($item) {
                return $item->mata_kuliah . '-' . $item->kelas . '-' . $item->dosen_id;
            });

        return view('admin.absensi', compact('agendas', 'uniqueClasses'));
    }

    public function exportAbsensi(Request $request)
    {
        $query = Agenda::with(['dosen', 'lab', 'absensi.mahasiswa'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('mata_kuliah', 'like', "%{$search}%")
                  ->orWhereHas('dosen', function($qd) use ($search) {
                      $qd->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $agendas = $query->get();

        return view('admin.export_absensi', compact('agendas'));
    }

    public function inputAbsensi($id)
    {
        $agenda = Agenda::with(['dosen', 'lab'])->findOrFail($id);
        
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

        return view('admin.input_absensi', compact('agenda', 'students', 'existingAbsensi'));
    }

    public function importAbsensi(Request $request, $id)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ], [
            'file_excel.required' => 'Pilih file Excel terlebih dahulu.',
            'file_excel.mimes' => 'Format file harus .xlsx atau .xls'
        ]);

        $agenda = Agenda::findOrFail($id);

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

        $parts = explode('|', $request->mata_kuliah_kelas);
        $mata_kuliah = $parts[0] ?? '';
        $kelas = $parts[1] ?? '';
        $dosen_id = $parts[2] ?? '';

        $baseAgenda = Agenda::where('mata_kuliah', $mata_kuliah)
            ->where('kelas', $kelas)
            ->where('dosen_id', $dosen_id)
            ->first();

        if (!$baseAgenda) {
            return redirect()->back()->with('error', 'Data mata kuliah/kelas tidak ditemukan.');
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
        $request->validate([
            'absensi' => 'required|array',
            'absensi.*' => 'in:Hadir,Izin,Sakit,Alpa,Terlambat'
        ]);

        $agenda = Agenda::findOrFail($id);
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

        return redirect()->route('admin.absensi')->with('success', 'Absensi manual berhasil disimpan untuk sesi ' . $agenda->mata_kuliah);
    }

    public function pengumuman(Request $request)
    {
        $query = Pengumuman::with(['admin', 'laboratoriums'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi_pengumuman', 'like', "%{$search}%");
        }

        $pengumumanList = $query->paginate(10)->withQueryString();
        $laboratoriums = Laboratorium::all();

        return view('admin.pengumuman', compact('pengumumanList', 'laboratoriums'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'username_or_nim_nip' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:4',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'kelas' => 'nullable|string|max:50',
            'semester' => 'nullable|integer|min:1|max:8',
            'status' => 'nullable|in:Tetap,Tidak Tetap,Honorer,Cuti',
            'kompetensi' => 'nullable|string',
            'jabatan' => 'nullable|string|max:100',
            'program_kuliah' => 'nullable|in:Reguler,Karyawan',
        ];

        if ($request->role === 'dosen' || $request->role === 'mahasiswa') {
            $rules['fakultas'] = 'required|exists:fakultas,id';
            $rules['jurusan'] = 'required|exists:prodi,id';
        } else {
            $rules['fakultas'] = 'nullable|exists:fakultas,id';
            $rules['jurusan'] = 'nullable|exists:prodi,id';
        }

        $request->validate($rules);

        DB::transaction(function() use ($request) {
            $user = User::create([
                'username' => $request->username_or_nim_nip,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($request->role === 'dosen') {
                Dosen::create([
                    'user_id' => $user->id,
                    'nip' => $request->username_or_nim_nip,
                    'nama' => $request->nama_lengkap,
                    'status' => $request->status ?? 'Tetap',
                    'id_fakultas' => $request->fakultas,
                    'id_prodi' => $request->jurusan,
                    'kompetensi' => $request->kompetensi,
                    'jabatan' => $request->jabatan,
                ]);
            } elseif ($request->role === 'mahasiswa') {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $request->username_or_nim_nip,
                    'nama_lengkap' => $request->nama_lengkap,
                    'kelas' => $request->kelas ?? '',
                    'program_kuliah' => $request->program_kuliah ?? 'Reguler',
                    'semester' => $request->semester ?? 1,
                    'status' => $request->status_mahasiswa ?? 'aktif',
                    'id_fakultas' => $request->fakultas,
                    'id_prodi' => $request->jurusan,
                ]);
            }
        });

        return back()->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'username_or_nim_nip' => 'required|string|max:50|unique:users,username,' . $id,
            'kelas' => 'nullable|string|max:50',
            'semester' => 'nullable|integer|min:1|max:14',
            'status' => 'nullable|in:Tetap,Tidak Tetap,Honorer,Cuti',
            'status_mahasiswa' => 'nullable|in:aktif,cuti,lulus,do',
            'kompetensi' => 'nullable|string',
            'jabatan' => 'nullable|string|max:100',
            'program_kuliah' => 'nullable|in:Reguler,Karyawan',
        ];

        if ($user->role === 'dosen' || $user->role === 'mahasiswa') {
            $rules['fakultas'] = 'required|exists:fakultas,id';
            $rules['jurusan'] = 'required|exists:prodi,id';
        } else {
            $rules['fakultas'] = 'nullable|exists:fakultas,id';
            $rules['jurusan'] = 'nullable|exists:prodi,id';
        }

        $request->validate($rules);

        DB::transaction(function() use ($request, $user) {
            $data = [
                'username' => $request->username_or_nim_nip,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            if ($user->role === 'dosen') {
                $dosen = Dosen::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nip' => $request->username_or_nim_nip,
                        'nama' => $request->nama_lengkap,
                        'status' => $request->status ?? 'Tetap',
                        'id_fakultas' => $request->fakultas,
                        'id_prodi' => $request->jurusan,
                        'kompetensi' => $request->kompetensi,
                        'jabatan' => $request->jabatan,
                    ]
                );
            } elseif ($user->role === 'mahasiswa') {
                $mahasiswa = Mahasiswa::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nim' => $request->username_or_nim_nip,
                        'nama_lengkap' => $request->nama_lengkap,
                        'kelas' => $request->kelas ?? '',
                        'program_kuliah' => $request->program_kuliah ?? 'Reguler',
                        'semester' => $request->semester ?? 1,
                        'status' => $request->status_mahasiswa ?? 'aktif',
                        'id_fakultas' => $request->fakultas,
                        'id_prodi' => $request->jurusan,
                    ]
                );
            }
        });

        return back()->with('success', 'Data akun pengguna berhasil diperbarui.');
    }

    public function storeLab(Request $request)
    {
        $request->validate([
            'nama_lab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'kapasitas' => 'required|integer',
        ]);

        Laboratorium::create([
            'nama_lab' => $request->nama_lab,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
        ]);

        return back()->with('success', 'Laboratorium berhasil ditambahkan.');
    }

    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'isi_pengumuman' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'laboratorium_ids' => 'nullable|array',
            'laboratorium_ids.*' => 'exists:laboratorium,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $fotoUrl = null;
        if ($request->hasFile('foto')) {
            $fotoUrl = $request->file('foto')->store('pengumuman', 'public');
        }

        $pengumuman = Pengumuman::create([
            'admin_id' => auth()->id(),
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'foto_url' => $fotoUrl,
        ]);

        if ($request->has('laboratorium_ids')) {
            $pengumuman->laboratoriums()->sync($request->laboratorium_ids);
        }

        return back()->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function updatePengumuman(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'isi_pengumuman' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'laboratorium_ids' => 'nullable|array',
            'laboratorium_ids.*' => 'exists:laboratorium,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        $fotoUrl = $pengumuman->foto_url;

        if ($request->boolean('hapus_foto')) {
            if ($pengumuman->foto_url && Storage::disk('public')->exists($pengumuman->foto_url)) {
                Storage::disk('public')->delete($pengumuman->foto_url);
            }
            $fotoUrl = null;
        }

        if ($request->hasFile('foto')) {
            if ($pengumuman->foto_url && Storage::disk('public')->exists($pengumuman->foto_url)) {
                Storage::disk('public')->delete($pengumuman->foto_url);
            }
            $fotoUrl = $request->file('foto')->store('pengumuman', 'public');
        }

        $pengumuman->update([
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'foto_url' => $fotoUrl,
        ]);

        if ($request->has('laboratorium_ids')) {
            $pengumuman->laboratoriums()->sync($request->laboratorium_ids);
        } else {
            $pengumuman->laboratoriums()->detach();
        }

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function deletePengumuman($id)
    {
        $pengumuman = Pengumuman::find($id);
        if ($pengumuman) {
            if ($pengumuman->foto_url && Storage::disk('public')->exists($pengumuman->foto_url)) {
                Storage::disk('public')->delete($pengumuman->foto_url);
            }
            $pengumuman->delete();
        }
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function promoteSemesters(Request $request)
    {
        $action = $request->input('action_type', 'promote'); // 'promote' (+1) or 'revert' (-1)
        $targetFakultas = $request->input('target_fakultas');
        $targetProdi = $request->input('target_prodi');
        $targetAngkatan = $request->input('target_angkatan');
        $autoGraduate = $request->boolean('auto_graduate'); // If semester >= 8 or 14, mark as 'lulus'

        $countUpdated = 0;
        $countGraduated = 0;

        DB::transaction(function() use ($action, $targetFakultas, $targetProdi, $targetAngkatan, $autoGraduate, &$countUpdated, &$countGraduated) {
            $query = Mahasiswa::query();

            // By default, only touch active students for promotions
            if ($action === 'promote') {
                $query->where('status', 'aktif');
            } else {
                // For rollback, allow active or students recently touched
                $query->whereIn('status', ['aktif', 'lulus']);
            }

            if ($targetFakultas) {
                $query->where('id_fakultas', $targetFakultas);
            }
            if ($targetProdi) {
                $query->where('id_prodi', $targetProdi);
            }
            if ($targetAngkatan) {
                $query->where('nim', 'like', $targetAngkatan . '%');
            }

            $students = $query->get();

            foreach ($students as $mhs) {
                if ($action === 'promote') {
                    if ($mhs->semester < 14) {
                        $newSem = $mhs->semester + 1;
                        if ($autoGraduate && $newSem > 8) {
                            $mhs->update(['semester' => 8, 'status' => 'lulus']);
                            $countGraduated++;
                        } else {
                            $mhs->update(['semester' => $newSem]);
                            $countUpdated++;
                        }
                    }
                } elseif ($action === 'revert') {
                    if ($mhs->semester > 1) {
                        $updates = ['semester' => $mhs->semester - 1];
                        if ($mhs->status === 'lulus') {
                            $updates['status'] = 'aktif';
                        }
                        $mhs->update($updates);
                        $countUpdated++;
                    }
                }
            }
        });

        $msg = $action === 'promote' 
            ? "Berhasil menaikkan semester untuk {$countUpdated} mahasiswa aktif" . ($countGraduated > 0 ? " ({$countGraduated} ditandai lulus)." : ".")
            : "Berhasil mengembalikan/menurunkan semester untuk {$countUpdated} mahasiswa.";

        return back()->with('success', $msg);
    }

    public function akademik(Request $request)
    {
        $fakultas = Fakultas::orderBy('nama_fakultas')->get();
        $prodis = Prodi::with('fakultas')->orderBy('nama_prodi')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mataKuliahs = MataKuliah::with('prodi')->orderBy('nama_mk')->get();

        return view('admin.akademik', compact('fakultas', 'prodis', 'kelas', 'mataKuliahs'));
    }

    // Fakultas CRUD
    public function storeFakultas(Request $request)
    {
        $request->validate(['nama_fakultas' => 'required|string|max:100']);
        Fakultas::create(['nama_fakultas' => $request->nama_fakultas]);
        return back()->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function updateFakultas(Request $request, $id)
    {
        $request->validate(['nama_fakultas' => 'required|string|max:100']);
        Fakultas::findOrFail($id)->update(['nama_fakultas' => $request->nama_fakultas]);
        return back()->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function deleteFakultas($id)
    {
        Fakultas::destroy($id);
        return back()->with('success', 'Fakultas berhasil dihapus.');
    }

    // Prodi CRUD
    public function storeProdi(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
            'fakultas_id' => 'required|exists:fakultas,id'
        ]);
        Prodi::create([
            'nama_prodi' => $request->nama_prodi,
            'fakultas_id' => $request->fakultas_id
        ]);
        return back()->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function updateProdi(Request $request, $id)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
            'fakultas_id' => 'required|exists:fakultas,id'
        ]);
        Prodi::findOrFail($id)->update([
            'nama_prodi' => $request->nama_prodi,
            'fakultas_id' => $request->fakultas_id
        ]);
        return back()->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function deleteProdi($id)
    {
        Prodi::destroy($id);
        return back()->with('success', 'Program Studi berhasil dihapus.');
    }

    // Kelas CRUD
    public function storeKelas(Request $request)
    {
        $request->validate(['nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas']);
        Kelas::create(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    public function updateKelas(Request $request, $id)
    {
        $request->validate(['nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas,' . $id]);
        Kelas::findOrFail($id)->update(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Kelas berhasil diperbarui.');
    }

    public function deleteKelas($id)
    {
        Kelas::destroy($id);
        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    // Mata Kuliah CRUD
    public function storeMataKuliah(Request $request)
    {
        $request->validate([
            'nama_mk' => 'required|string|max:150',
            'kode_mk' => 'nullable|string|max:30',
            'sks' => 'nullable|integer',
            'id_prodi' => 'nullable|exists:prodi,id',
        ]);
        MataKuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks ?? 3,
            'id_prodi' => $request->id_prodi,
        ]);
        return back()->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function updateMataKuliah(Request $request, $id)
    {
        $request->validate([
            'nama_mk' => 'required|string|max:150',
            'kode_mk' => 'nullable|string|max:30',
            'sks' => 'nullable|integer',
            'id_prodi' => 'nullable|exists:prodi,id',
        ]);
        MataKuliah::findOrFail($id)->update([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks ?? 3,
            'id_prodi' => $request->id_prodi,
        ]);
        return back()->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function deleteMataKuliah($id)
    {
        MataKuliah::destroy($id);
        return back()->with('success', 'Mata Kuliah berhasil dihapus.');
    }

    public function bulkDeleteKelas(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || empty($ids)) {
            return back()->withErrors(['msg' => 'Tidak ada kelas yang dipilih untuk dihapus.']);
        }
        Kelas::whereIn('id', $ids)->delete();
        return back()->with('success', count($ids) . ' kelas berhasil dihapus.');
    }

    public function importMahasiswa(Request $request)
    {
        $request->validate([
            'file_excel' => 'required',
            'file_excel.*' => 'mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $file = is_array($request->file('file_excel')) ? $request->file('file_excel')[0] : $request->file('file_excel');
            
            $importId = (string) \Illuminate\Support\Str::uuid();
            $path = $file->storeAs('imports', $importId . '.' . $file->getClientOriginalExtension());
            
            $import = new \App\Imports\MahasiswaImport($importId);
            $import->queue($path);
            
            if ($request->ajax()) {
                return response()->json(['import_id' => $importId]);
            }
            
            return back()->with('success', 'Proses impor data Mahasiswa sedang berjalan di latar belakang.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importDosen(Request $request)
    {
        $request->validate([
            'file_excel' => 'required',
            'file_excel.*' => 'mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $files = is_array($request->file('file_excel')) ? $request->file('file_excel') : [$request->file('file_excel')];
            foreach ($files as $file) {
                Excel::import(new DosenImport, $file);
            }
            return back()->with('success', count($files) . ' file Dosen berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importAgenda(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|max:10240',
        ]);

        try {
            $import = new AgendaImport();
            Excel::import($import, $request->file('file_excel'));
            
            if ($import->importedCount === 0) {
                return redirect()->route('admin.agenda')->withErrors(['msg' => 'Tidak ada data agenda yang berhasil diimpor dari file tersebut. Pastikan file memuat data tanggal, waktu, dan mata kuliah.']);
            }

            return redirect()->route('admin.agenda')->with('success', 'Berhasil mengimpor ' . $import->importedCount . ' sesi agenda praktikum.');
        } catch (\Exception $e) {
            return redirect()->route('admin.agenda')->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importLaboratorium(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new LaboratoriumImport, $request->file('file_excel'));
            return back()->with('success', 'Data Laboratorium berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importFakultas(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new FakultasImport, $request->file('file_excel'));
            return back()->with('success', 'Data Fakultas berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importProdi(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ProdiImport, $request->file('file_excel'));
            return back()->with('success', 'Data Program Studi berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importKelas(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new KelasImport, $request->file('file_excel'));
            return back()->with('success', 'Data Kelas berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importMataKuliah(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new \App\Imports\MataKuliahImport, $request->file('file_excel'));
            return back()->with('success', 'Data Mata Kuliah berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function aktivitas()
    {
        $activities = \Spatie\Activitylog\Models\Activity::with(['causer.dosen', 'causer.mahasiswa'])
            ->latest()
            ->paginate(50);
            
        return view('admin.aktivitas', compact('activities'));
    }

    public function jadwalPenggunaanLab(Request $request)
    {
        $labs = Laboratorium::all();
        $selectedLabId = $request->get('lab_id', $labs->first()->id ?? null);
        $tahunAkademik = $request->get('tahun_akademik', '2026/2027 Ganjil');

        $query = JadwalPenggunaanLab::with(['lab', 'dosen', 'dosenPengampu', 'prodi'])
            ->when($selectedLabId, function($q) use ($selectedLabId) {
                $q->where('lab_id', $selectedLabId);
            })
            ->when($tahunAkademik, function($q) use ($tahunAkademik) {
                $q->where('tahun_akademik', $tahunAkademik);
            });

        $jadwals = $query->orderBy('jam_mulai', 'asc')->get();

        $dosens = Dosen::orderBy('nama', 'asc')->get();
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_mk', 'asc')->get();
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $timeSlots = [
            '08.00-09.00', '09.00-10.00', '10.00-11.00', '11.00-12.00',
            '12.00-13.00', '13.00-14.00', '14.00-15.00', '15.00-16.00',
            '16.00-17.00', '17.00-18.00', '18.00-19.00', '19.00-20.00',
            '20.00-21.00', '21.00-22.00'
        ];

        return view('admin.jadwal_penggunaan_lab', compact(
            'labs', 'selectedLabId', 'tahunAkademik', 'jadwals',
            'dosens', 'prodis', 'mataKuliahs', 'kelas', 'hariList', 'timeSlots'
        ));
    }

    public function storeJadwalPenggunaanLab(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:laboratorium,id',
            'mata_kuliah' => 'required|string|max:150',
            'dosen_id' => 'required|exists:dosen,id',
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'id_prodi' => 'nullable|exists:prodi,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kelas' => 'nullable|string|max:50',
            'semester' => 'nullable|string|max:20',
            'program_kuliah' => 'nullable|in:Reguler,Karyawan',
            'tahun_akademik' => 'nullable|string|max:50',
        ]);

        JadwalPenggunaanLab::create([
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->mata_kuliah,
            'dosen_id' => $request->dosen_id,
            'dosen_pengampu_id' => $request->dosen_pengampu_id,
            'id_prodi' => $request->id_prodi,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas' => $request->kelas ?? 'Reg A',
            'semester' => $request->semester ?? '1',
            'program_kuliah' => $request->program_kuliah ?? 'Reguler',
            'tahun_akademik' => $request->tahun_akademik ?? '2026/2027 Ganjil',
            'is_aktif' => true,
        ]);

        return back()->with('success', 'Jadwal Penggunaan Lab berhasil ditambahkan.');
    }

    public function updateJadwalPenggunaanLab(Request $request, $id)
    {
        $request->validate([
            'lab_id' => 'required|exists:laboratorium,id',
            'mata_kuliah' => 'required|string|max:150',
            'dosen_id' => 'required|exists:dosen,id',
            'dosen_pengampu_id' => 'nullable|exists:dosen,id',
            'id_prodi' => 'nullable|exists:prodi,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kelas' => 'nullable|string|max:50',
            'semester' => 'nullable|string|max:20',
            'program_kuliah' => 'nullable|in:Reguler,Karyawan',
            'tahun_akademik' => 'nullable|string|max:50',
        ]);

        $jadwal = JadwalPenggunaanLab::findOrFail($id);
        $jadwal->update([
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->mata_kuliah,
            'dosen_id' => $request->dosen_id,
            'dosen_pengampu_id' => $request->dosen_pengampu_id,
            'id_prodi' => $request->id_prodi,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas' => $request->kelas ?? 'Reg A',
            'semester' => $request->semester ?? '1',
            'program_kuliah' => $request->program_kuliah ?? 'Reguler',
            'tahun_akademik' => $request->tahun_akademik ?? '2026/2027 Ganjil',
        ]);

        return back()->with('success', 'Jadwal Penggunaan Lab berhasil diperbarui.');
    }

    public function deleteJadwalPenggunaanLab($id)
    {
        JadwalPenggunaanLab::destroy($id);
        return back()->with('success', 'Jadwal Penggunaan Lab berhasil dihapus.');
    }

    public function bulkGenerate16Pertemuan(Request $request)
    {
        $labId = $request->input('lab_id');
        $query = JadwalPenggunaanLab::with(['lab', 'prodi.fakultas', 'dosenPengampu', 'dosen'])->where('is_aktif', true);
        if ($labId) {
            $query->where('lab_id', $labId);
        }
        $jadwals = $query->get();

        $dayMap = [
            'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 0
        ];

        $totalCreated = 0;
        foreach ($jadwals as $jadwal) {
            $targetDayIndex = $dayMap[$jadwal->hari] ?? 1;
            $startDate = \Carbon\Carbon::today();

            while ($startDate->dayOfWeek !== $targetDayIndex) {
                $startDate->addDay();
            }

            for ($i = 0; $i < 16; $i++) {
                $date = $startDate->copy()->addWeeks($i)->format('Y-m-d');

                $exists = Agenda::where('jadwal_penggunaan_lab_id', $jadwal->id)
                    ->where('tanggal', $date)
                    ->exists();

                if (!$exists) {
                    Agenda::create([
                        'jadwal_penggunaan_lab_id' => $jadwal->id,
                        'dosen_id' => $jadwal->dosen_id,
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
                    $totalCreated++;
                }
            }
        }

        return back()->with('success', "Berhasil membuat {$totalCreated} sesi pertemuan perkuliahan 1 semester secara otomatis untuk seluruh jadwal lab!");
    }

    public function statistik(Request $request)
    {
        $allAgendas = Agenda::with('lab')->orderBy('tanggal', 'desc')->get();
        
        $selectedAgendaIds = $request->input('agenda_ids', []);
        if (!is_array($selectedAgendaIds)) {
            $selectedAgendaIds = [$selectedAgendaIds];
        }

        $agendas = collect();
        $studentStats = collect();
        $summary = [
            'total_expected' => 0,
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpa' => 0,
            'rate' => 100
        ];

        if (!empty($selectedAgendaIds)) {
            $agendas = Agenda::with(['dosen', 'lab', 'absensi.mahasiswa'])
                ->whereIn('id', $selectedAgendaIds)
                ->get();

            $studentsData = [];
            foreach ($agendas as $agenda) {
                $students = Mahasiswa::where('kelas', $agenda->kelas)
                    ->whereHas('fakultas', function($q) use ($agenda) {
                        $q->where('nama_fakultas', $agenda->fakultas);
                    })
                    ->whereHas('prodi', function($q) use ($agenda) {
                        $q->where('nama_prodi', $agenda->jurusan);
                    })
                    ->get();

                $summary['total_expected'] += $students->count();

                $absensiByStudent = $agenda->absensi->keyBy('mahasiswa_id');

                foreach ($students as $mhs) {
                    if (!isset($studentsData[$mhs->id])) {
                        $studentsData[$mhs->id] = [
                            'mahasiswa' => $mhs,
                            'hadir' => 0,
                            'izin' => 0,
                            'sakit' => 0,
                            'alpa' => 0,
                            'total' => 0
                        ];
                    }

                    $studentsData[$mhs->id]['total']++;
                    
                    $abs = $absensiByStudent->get($mhs->id);
                    if ($abs) {
                        $status = strtolower($abs->status_kehadiran);
                        if ($status === 'hadir' || $status === 'terlambat') {
                            $studentsData[$mhs->id]['hadir']++;
                            $summary['hadir']++;
                        } elseif ($status === 'izin') {
                            $studentsData[$mhs->id]['izin']++;
                            $summary['izin']++;
                        } elseif ($status === 'sakit') {
                            $studentsData[$mhs->id]['sakit']++;
                            $summary['sakit']++;
                        } else {
                            $studentsData[$mhs->id]['alpa']++;
                            $summary['alpa']++;
                        }
                    } else {
                        $studentsData[$mhs->id]['alpa']++;
                        $summary['alpa']++;
                    }
                }
            }

            $studentStats = collect($studentsData);
            
            $totalReal = $summary['hadir'] + $summary['izin'] + $summary['sakit'] + $summary['alpa'];
            if ($totalReal > 0) {
                $summary['rate'] = round(($summary['hadir'] / $totalReal) * 100, 1);
            }
        }

        return view('admin.statistik', compact('allAgendas', 'selectedAgendaIds', 'agendas', 'studentStats', 'summary'));
    }
}

