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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use App\Imports\DosenImport;
use App\Imports\AgendaImport;
use App\Imports\LaboratoriumImport;
use App\Imports\FakultasImport;
use App\Imports\ProdiImport;
use App\Imports\KelasImport;

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
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhereHas('dosen', function($qd) use ($search) {
                      $qd->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mahasiswa', function($qm) use ($search) {
                      $qm->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();
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
        Laboratorium::destroy($id);
        return back()->with('success', 'Laboratorium berhasil dihapus.');
    }

    public function agenda(Request $request)
    {
        $query = Agenda::with(['dosen', 'lab'])->orderBy('tanggal', 'desc')->orderBy('jam_mulai', 'desc');

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

        $agendas = $query->paginate(10)->withQueryString();

        return view('admin.agenda', compact('agendas'));
    }

    public function deleteAgenda($id)
    {
        Agenda::destroy($id);
        return back()->with('success', 'Agenda praktikum berhasil dihapus.');
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

        return view('admin.absensi', compact('agendas'));
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

    public function pengumuman(Request $request)
    {
        $query = Pengumuman::with('admin')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi_pengumuman', 'like', "%{$search}%");
        }

        $pengumumanList = $query->paginate(10)->withQueryString();

        return view('admin.pengumuman', compact('pengumumanList'));
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
                ]);
            } elseif ($request->role === 'mahasiswa') {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $request->username_or_nim_nip,
                    'nama_lengkap' => $request->nama_lengkap,
                    'kelas' => $request->kelas ?? '',
                    'semester' => $request->semester ?? 1,
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
            'semester' => 'nullable|integer|min:1|max:8',
            'status' => 'nullable|in:Tetap,Tidak Tetap,Honorer,Cuti',
            'kompetensi' => 'nullable|string',
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
                    ]
                );
            } elseif ($user->role === 'mahasiswa') {
                $mahasiswa = Mahasiswa::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nim' => $request->username_or_nim_nip,
                        'nama_lengkap' => $request->nama_lengkap,
                        'kelas' => $request->kelas ?? '',
                        'semester' => $request->semester ?? 1,
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
            'judul_pengumuman' => 'required|string|max:150',
            'penjelasan' => 'required|string',
        ]);

        Pengumuman::create([
            'admin_id' => auth()->id(),
            'judul' => $request->judul_pengumuman,
            'isi_pengumuman' => $request->penjelasan,
        ]);

        return back()->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function updatePengumuman(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'isi_pengumuman' => 'required|string',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update([
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
        ]);

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function deletePengumuman($id)
    {
        Pengumuman::destroy($id);
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function promoteSemesters(Request $request)
    {
        DB::transaction(function() {
            Mahasiswa::where('semester', '<', 8)->increment('semester');
        });

        return back()->with('success', 'Seluruh mahasiswa berhasil naik semester (semester dinaikkan 1 tingkat).');
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

    public function akademik(Request $request)
    {
        $fakultas = Fakultas::orderBy('nama_fakultas')->get();
        $prodis = Prodi::with('fakultas')->orderBy('nama_prodi')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.akademik', compact('fakultas', 'prodis', 'kelas'));
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
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new MahasiswaImport, $request->file('file_excel'));
            return back()->with('success', 'Data Mahasiswa berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importDosen(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new DosenImport, $request->file('file_excel'));
            return back()->with('success', 'Data Dosen berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importAgenda(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new AgendaImport, $request->file('file_excel'));
            return back()->with('success', 'Data Agenda berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
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
}
