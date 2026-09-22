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
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use App\Imports\DosenImport;
use App\Imports\AgendaImport;
use App\Imports\LaboratoriumImport;
use App\Imports\FakultasImport;
use App\Imports\ProdiImport;
use App\Imports\KelasImport;
use App\Imports\KehadiranImport;
use App\Exports\JadwalLabExport;
use App\Imports\JadwalLabImport;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $now = \Carbon\Carbon::now();
        $today = $now->toDateString();
        $currentTime = $now->format('H:i:s');
        
        $daysIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $monthsIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $todayFormatted = ($daysIndo[$now->format('l')] ?? $now->format('l')) . ', ' . $now->format('d') . ' ' . ($monthsIndo[(int)$now->format('m')] ?? $now->format('F')) . ' ' . $now->format('Y');

        if ($user->isAdminFakultas()) {
            $fakId = $user->fakultas_id;
            $usersCount = User::where('fakultas_id', $fakId)
                ->orWhereHas('dosen', fn($q) => $q->where('id_fakultas', $fakId))
                ->orWhereHas('mahasiswa', fn($q) => $q->where('id_fakultas', $fakId))
                ->count();
            $dosenCount = Dosen::where('id_fakultas', $fakId)->count();
            $mhsCount = Mahasiswa::where('id_fakultas', $fakId)->count();
            $labCount = Laboratorium::forUser($user)->count();
            $agendaCount = Agenda::whereHas('lab', fn($q) => $q->where('fakultas_id', $fakId))->count();

            $todayHadir = Absensi::whereDate('waktu_masuk', $today)
                ->where('status_kehadiran', 'Hadir')
                ->whereHas('agenda.lab', fn($q) => $q->where('fakultas_id', $fakId))
                ->count();
            $todayIzin = Absensi::whereDate('waktu_masuk', $today)
                ->where('status_kehadiran', 'Izin')
                ->whereHas('agenda.lab', fn($q) => $q->where('fakultas_id', $fakId))
                ->count();
            $todayAlpa = Absensi::whereDate('waktu_masuk', $today)
                ->where('status_kehadiran', 'Alpa')
                ->whereHas('agenda.lab', fn($q) => $q->where('fakultas_id', $fakId))
                ->count();

            $recentAbsensi = Absensi::with(['mahasiswa.user', 'agenda.lab'])
                ->whereHas('agenda.lab', fn($q) => $q->where('fakultas_id', $fakId))
                ->orderBy('waktu_masuk', 'desc')
                ->limit(5)
                ->get();
        } else {
            $usersCount = User::count();
            $dosenCount = Dosen::count();
            $mhsCount = Mahasiswa::count();
            $labCount = Laboratorium::count();
            $agendaCount = Agenda::count();

            // Today's attendance summary
            $todayHadir = Absensi::whereDate('waktu_masuk', $today)->where('status_kehadiran', 'Hadir')->count();
            $todayIzin = Absensi::whereDate('waktu_masuk', $today)->where('status_kehadiran', 'Izin')->count();
            $todayAlpa = Absensi::whereDate('waktu_masuk', $today)->where('status_kehadiran', 'Alpa')->count();

            // Recent activity
            $recentAbsensi = Absensi::with(['mahasiswa.user', 'agenda.lab'])
                ->orderBy('waktu_masuk', 'desc')
                ->limit(5)
                ->get();
        }

        // Operational Queries: Labs & Live Occupancy
        $labsQuery = Laboratorium::with(['fakultas']);
        if ($user->isAdminFakultas()) {
            $labsQuery->where('fakultas_id', $user->fakultas_id);
        }
        $laboratoriums = $labsQuery->orderBy('nama_lab')->get();

        // Agendas Today
        $agendasTodayQuery = Agenda::with(['dosen', 'dosenPengampu', 'lab.fakultas'])
            ->whereDate('tanggal', $today);
        if ($user->isAdminFakultas()) {
            $agendasTodayQuery->whereHas('lab', fn($q) => $q->where('fakultas_id', $user->fakultas_id));
        }
        $agendasToday = $agendasTodayQuery->orderBy('jam_mulai', 'asc')->get();

        // If no agenda today, get upcoming agendas
        $agendasUpcomingQuery = Agenda::with(['dosen', 'dosenPengampu', 'lab.fakultas'])
            ->whereDate('tanggal', '>=', $today);
        if ($user->isAdminFakultas()) {
            $agendasUpcomingQuery->whereHas('lab', fn($q) => $q->where('fakultas_id', $user->fakultas_id));
        }
        $agendasUpcoming = $agendasUpcomingQuery->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc')->limit(6)->get();

        // Compute Live Status for each Lab
        $labStatusList = [];
        $labAktifSaatIni = 0;
        $alertDosenBelumHadir = [];

        foreach ($laboratoriums as $lab) {
            // Check currently active agenda right now
            $currentAgenda = Agenda::with(['dosen', 'dosenPengampu'])
                ->where('lab_id', $lab->id)
                ->whereDate('tanggal', $today)
                ->where('jam_mulai', '<=', $currentTime)
                ->where('jam_selesai', '>=', $currentTime)
                ->first();

            // Next upcoming agenda for this lab
            $nextAgenda = Agenda::with(['dosen', 'dosenPengampu'])
                ->where('lab_id', $lab->id)
                ->where(function($q) use ($today, $currentTime) {
                    $q->where(function($q2) use ($today, $currentTime) {
                        $q2->whereDate('tanggal', $today)->where('jam_mulai', '>', $currentTime);
                    })->orWhereDate('tanggal', '>', $today);
                })
                ->orderBy('tanggal', 'asc')
                ->orderBy('jam_mulai', 'asc')
                ->first();

            $isOccupied = !empty($currentAgenda);
            if ($isOccupied) {
                $labAktifSaatIni++;
                if (empty($currentAgenda->dosen_waktu_masuk)) {
                    $alertDosenBelumHadir[] = [
                        'lab' => $lab->nama_lab,
                        'mata_kuliah' => $currentAgenda->mata_kuliah,
                        'dosen' => $currentAgenda->dosen?->nama ?? 'Dosen Pengampu',
                        'jam' => substr($currentAgenda->jam_mulai, 0, 5) . ' - ' . substr($currentAgenda->jam_selesai, 0, 5),
                        'tipe' => 'sedang_berlangsung'
                    ];
                }
            }

            // Check if next agenda is today and starts soon (within 30 mins) without check-in
            $nextTanggal = $nextAgenda ? (is_object($nextAgenda->tanggal) ? $nextAgenda->tanggal->toDateString() : substr((string)$nextAgenda->tanggal, 0, 10)) : null;
            if ($nextAgenda && $nextTanggal == $today) {
                $startCarbon = \Carbon\Carbon::parse($today . ' ' . $nextAgenda->jam_mulai);
                $diffMin = $now->diffInMinutes($startCarbon, false);
                if ($diffMin <= 30 && $diffMin >= 0 && empty($nextAgenda->dosen_waktu_masuk)) {
                    $alertDosenBelumHadir[] = [
                        'lab' => $lab->nama_lab,
                        'mata_kuliah' => $nextAgenda->mata_kuliah,
                        'dosen' => $nextAgenda->dosen?->nama ?? 'Dosen Pengampu',
                        'jam' => substr($nextAgenda->jam_mulai, 0, 5) . ' - ' . substr($nextAgenda->jam_selesai, 0, 5),
                        'tipe' => 'segera_mulai'
                    ];
                }
            }

            $labStatusList[] = [
                'lab' => $lab,
                'is_occupied' => $isOccupied,
                'current_agenda' => $currentAgenda,
                'next_agenda' => $nextAgenda,
            ];
        }

        $totalSesiHariIni = $agendasToday->count();
        $totalPresensiHariIni = $todayHadir + $todayIzin + $todayAlpa;
        $attendanceRate = $totalPresensiHariIni > 0 ? round(($todayHadir / $totalPresensiHariIni) * 100) : 0;

        // Active Announcements on Smart Board TVs
        $pengumumanQuery = \App\Models\Pengumuman::query();
        if ($user->isAdminFakultas()) {
            $pengumumanQuery->where(function($q) use ($user) {
                $q->where('admin_id', $user->id)
                  ->orWhereHas('laboratoriums', fn($lq) => $lq->where('fakultas_id', $user->fakultas_id));
            });
        }
        $pengumumanAktifCount = $pengumumanQuery->where(function($q) use ($today) {
            $q->whereNull('tanggal_mulai')->orWhere('tanggal_mulai', '<=', $today);
        })->where(function($q) use ($today) {
            $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', $today);
        })->count();

        return view('admin.dashboard', compact(
            'usersCount', 'dosenCount', 'mhsCount', 'labCount', 'agendaCount',
            'todayHadir', 'todayIzin', 'todayAlpa', 'recentAbsensi',
            'todayFormatted', 'laboratoriums', 'agendasToday', 'agendasUpcoming',
            'labStatusList', 'labAktifSaatIni', 'alertDosenBelumHadir',
            'totalSesiHariIni', 'attendanceRate', 'totalPresensiHariIni',
            'pengumumanAktifCount'
        ));
    }

    public function pengguna(Request $request)
    {
        $authUser = Auth::user();
        $query = User::with(['fakultas', 'dosen.fakultas', 'dosen.prodi', 'mahasiswa.fakultas', 'mahasiswa.prodi'])->orderBy('created_at', 'desc');

        if ($authUser->isAdminFakultas()) {
            $fakId = (int) $authUser->fakultas_id;
            $query->where(function($q) use ($fakId) {
                $q->where('fakultas_id', $fakId)
                  ->orWhereHas('dosen', function($qd) use ($fakId) {
                      $qd->where('id_fakultas', $fakId)
                        ->orWhereHas('prodi', fn($qp) => $qp->where('fakultas_id', $fakId));
                  })
                  ->orWhereHas('mahasiswa', function($qm) use ($fakId) {
                      $qm->where('id_fakultas', $fakId)
                        ->orWhereHas('prodi', fn($qp) => $qp->where('fakultas_id', $fakId));
                  });
            });
        }

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

        if ($authUser->isSuperAdmin() && $request->filled('fakultas_id')) {
            $fakId = (int) $request->fakultas_id;
            $query->where(function($q) use ($fakId) {
                $q->where('fakultas_id', $fakId)
                  ->orWhereHas('dosen', function($qd) use ($fakId) {
                      $qd->where('id_fakultas', $fakId)
                        ->orWhereHas('prodi', fn($qp) => $qp->where('fakultas_id', $fakId));
                  })
                  ->orWhereHas('mahasiswa', function($qm) use ($fakId) {
                      $qm->where('id_fakultas', $fakId)
                        ->orWhereHas('prodi', fn($qp) => $qp->where('fakultas_id', $fakId));
                  });
            });
        }

        $selectedRole = strtolower(trim($request->role ?? ''));
        if (!empty($selectedRole)) {
            $query->where('role', $selectedRole);
        }

        $isMahasiswaContext = empty($selectedRole) || $selectedRole === 'mahasiswa';

        if ($isMahasiswaContext && $request->filled('program_kuliah')) {
            $program = trim($request->program_kuliah);
            $query->whereHas('mahasiswa', function($q) use ($program) {
                if (in_array(strtolower($program), ['reguler', 'reg'])) {
                    $q->where(function($sq) {
                        $sq->where('program_kuliah', 'like', 'Reg%')
                          ->orWhere('program_kuliah', 'Reguler')
                          ->orWhere('program_kuliah', 'reguler');
                    });
                } elseif (strtolower($program) === 'karyawan') {
                    $q->where(function($sq) {
                        $sq->where('program_kuliah', 'like', 'Karyawan%')
                          ->orWhere('program_kuliah', 'karyawan');
                    });
                } else {
                    $q->where('program_kuliah', $program);
                }
            });
        }

        if ($isMahasiswaContext && $request->filled('semester')) {
            $semester = $request->semester;
            $query->whereHas('mahasiswa', function($q) use ($semester) {
                $q->where('semester', $semester);
            });
        }

        if ($isMahasiswaContext && $request->filled('kelas')) {
            $kelasReq = strtoupper(trim($request->kelas));
            $query->whereHas('mahasiswa', function($q) use ($kelasReq) {
                if ($kelasReq === 'KAR') {
                    $q->where(function($sq) {
                        $sq->where('kelas', 'KAR')
                          ->orWhere('program_kuliah', 'like', 'Karyawan%');
                    });
                } elseif (in_array($kelasReq, ['KAR A', 'KAR-A', 'KARYAWAN A'])) {
                    $q->where(function($sq) {
                        $sq->whereIn('kelas', ['Kar A', 'KAR A', 'A'])
                          ->orWhere('kelas', 'like', '%A');
                    })->where('program_kuliah', 'like', 'Karyawan%');
                } elseif (in_array($kelasReq, ['KAR B', 'KAR-B', 'KARYAWAN B'])) {
                    $q->where(function($sq) {
                        $sq->whereIn('kelas', ['Kar B', 'KAR B', 'B'])
                          ->orWhere('kelas', 'like', '%B');
                    })->where('program_kuliah', 'like', 'Karyawan%');
                } elseif ($kelasReq === 'REG') {
                    $q->where(function($sq) {
                        $sq->where('kelas', 'REG')
                          ->orWhere('kelas', 'XI-RR')
                          ->orWhere(function($ssq) {
                              $ssq->where('program_kuliah', 'like', 'Reg%')
                                 ->whereNotIn('kelas', ['A', 'B', 'Reg A', 'Reg B', 'REG A', 'REG B', 'IF-3A', 'IF-3B']);
                          });
                    });
                } elseif (in_array($kelasReq, ['REG A', 'REG-A', 'A'])) {
                    $q->where(function($sq) {
                        $sq->whereIn('kelas', ['A', 'Reg A', 'REG A', 'IF-3A'])
                          ->orWhere('kelas', 'like', '%A')
                          ->orWhere('kelas', 'like', '%-A')
                          ->orWhere('kelas', 'like', '%3A');
                    });
                } elseif (in_array($kelasReq, ['REG B', 'REG-B', 'B'])) {
                    $q->where(function($sq) {
                        $sq->whereIn('kelas', ['B', 'Reg B', 'REG B', 'IF-3B'])
                          ->orWhere('kelas', 'like', '%B')
                          ->orWhere('kelas', 'like', '%-B')
                          ->orWhere('kelas', 'like', '%3B');
                    });
                } elseif (in_array($kelasReq, ['REG C', 'REG-C', 'C'])) {
                    $q->where(function($sq) {
                        $sq->whereIn('kelas', ['C', 'Reg C', 'REG C', 'IF-3C'])
                          ->orWhere('kelas', 'like', '%C')
                          ->orWhere('kelas', 'like', '%-C')
                          ->orWhere('kelas', 'like', '%3C');
                    });
                } else {
                    $q->where('kelas', $kelasReq)
                      ->orWhere('kelas', 'like', "%{$kelasReq}%");
                }
            });
        }

        if ($isMahasiswaContext && $request->filled('status_mahasiswa')) {
            $statusMhs = strtolower($request->status_mahasiswa);
            $query->whereHas('mahasiswa', function($q) use ($statusMhs) {
                $q->where('status', $statusMhs);
            });
        }

        // Dynamic Column Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = strtolower($request->get('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'role') {
            $query->orderBy('role', $sortOrder);
        } elseif ($sortBy === 'status') {
            $query->orderBy('users.status', $sortOrder);
        } elseif ($sortBy === 'nama') {
            $query->leftJoin('dosen', 'users.id', '=', 'dosen.user_id')
                  ->leftJoin('mahasiswa', 'users.id', '=', 'mahasiswa.user_id')
                  ->select('users.*')
                  ->orderByRaw("COALESCE(dosen.nama, mahasiswa.nama_lengkap, users.username) {$sortOrder}");
        } elseif ($sortBy === 'nim_nip') {
            $query->leftJoin('dosen', 'users.id', '=', 'dosen.user_id')
                  ->leftJoin('mahasiswa', 'users.id', '=', 'mahasiswa.user_id')
                  ->select('users.*')
                  ->orderByRaw("COALESCE(dosen.nip, mahasiswa.nim, '') {$sortOrder}");
        } else {
            $query->orderBy('users.created_at', 'desc');
        }

        // Configurable Pagination Per Page
        $perPage = (int) $request->get('per_page', 25);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 25;
        }

        $users = $query->paginate($perPage)->withQueryString();

        if ($authUser->isAdminFakultas()) {
            $fakultas = Fakultas::where('id', $authUser->fakultas_id)->get();
            $prodis = Prodi::where('fakultas_id', $authUser->fakultas_id)->get();
            $selectedFakId = (int) $authUser->fakultas_id;
        } else {
            $fakultas = Fakultas::all();
            $prodis = Prodi::all();
            $selectedFakId = $request->filled('fakultas_id') ? (int) $request->fakultas_id : null;
        }

        // Base Mahasiswa query for populating dynamic dependent dropdown options
        $mhsOptQuery = Mahasiswa::query();
        if ($selectedFakId) {
            $mhsOptQuery->where(function($q) use ($selectedFakId) {
                $q->where('id_fakultas', $selectedFakId)
                  ->orWhereHas('prodi', fn($qp) => $qp->where('fakultas_id', $selectedFakId));
            });
        }

        // 1. Dynamic Available Programs (Reguler / Karyawan)
        $dbPrograms = (clone $mhsOptQuery)
            ->whereNotNull('program_kuliah')
            ->where('program_kuliah', '!=', '')
            ->distinct()
            ->pluck('program_kuliah')
            ->toArray();
        $availablePrograms = array_values(array_unique(array_merge(['Reguler', 'Karyawan'], $dbPrograms)));
        sort($availablePrograms);

        // 2. Available Semesters (Always display all semesters 1-8+ regardless of program_kuliah selection)
        $dbSemesters = (clone $mhsOptQuery)
            ->whereNotNull('semester')
            ->where('semester', '>', 0)
            ->distinct()
            ->pluck('semester')
            ->toArray();
        $availableSemesters = array_values(array_unique(array_merge(range(1, 8), $dbSemesters)));
        sort($availableSemesters, SORT_NUMERIC);

        // 3. Dynamic Available Kelases based on Fakultas, Program Kuliah, and Semester
        $klsQuery = clone $mhsOptQuery;
        if ($request->filled('program_kuliah')) {
            $progReq = trim($request->program_kuliah);
            $klsQuery->where(function($q) use ($progReq) {
                if (in_array(strtolower($progReq), ['reguler', 'reg'])) {
                    $q->where('program_kuliah', 'like', 'Reg%');
                } elseif (strtolower($progReq) === 'karyawan') {
                    $q->where('program_kuliah', 'like', 'Karyawan%');
                } else {
                    $q->where('program_kuliah', $progReq);
                }
            });
        }
        if ($request->filled('semester')) {
            $klsQuery->where('semester', $request->semester);
        }

        $rawDbKelases = $klsQuery
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->pluck('kelas')
            ->toArray();

        $formattedKelases = [];
        $progReqLower = strtolower(trim($request->program_kuliah ?? ''));

        foreach ($rawDbKelases as $rk) {
            $rkUpper = strtoupper(trim($rk));
            $isKar = ($progReqLower === 'karyawan' || str_contains($rkUpper, 'KAR') || str_contains($rkUpper, 'KARYAWAN'));

            if ($isKar) {
                if (str_contains($rkUpper, 'KAR A') || $rkUpper === 'A' || str_ends_with($rkUpper, '3A') || str_ends_with($rkUpper, '-A')) {
                    $formattedKelases[] = 'Kar A';
                } elseif (str_contains($rkUpper, 'KAR B') || $rkUpper === 'B' || str_ends_with($rkUpper, '3B') || str_ends_with($rkUpper, '-B')) {
                    $formattedKelases[] = 'Kar B';
                } elseif (str_contains($rkUpper, 'KAR C') || $rkUpper === 'C' || str_ends_with($rkUpper, '3C') || str_ends_with($rkUpper, '-C')) {
                    $formattedKelases[] = 'Kar C';
                } else {
                    $formattedKelases[] = 'KAR';
                }
            } else {
                if (str_contains($rkUpper, 'REG A') || $rkUpper === 'A' || str_ends_with($rkUpper, '3A') || str_ends_with($rkUpper, '-A')) {
                    $formattedKelases[] = 'Reg A';
                } elseif (str_contains($rkUpper, 'REG B') || $rkUpper === 'B' || str_ends_with($rkUpper, '3B') || str_ends_with($rkUpper, '-B')) {
                    $formattedKelases[] = 'Reg B';
                } elseif (str_contains($rkUpper, 'REG C') || $rkUpper === 'C' || str_ends_with($rkUpper, '3C') || str_ends_with($rkUpper, '-C')) {
                    $formattedKelases[] = 'Reg C';
                } elseif ($rkUpper === 'REG' || $rkUpper === 'XI-RR') {
                    $formattedKelases[] = 'REG';
                } else {
                    $formattedKelases[] = $rk;
                }
            }
        }

        if (empty($formattedKelases)) {
            if ($progReqLower === 'karyawan') {
                $formattedKelases = ['Kar A', 'Kar B', 'KAR'];
            } elseif (in_array($progReqLower, ['reguler', 'reg'])) {
                $formattedKelases = ['Reg A', 'Reg B', 'REG'];
            } else {
                $formattedKelases = ['Reg A', 'Reg B', 'REG', 'Kar A', 'Kar B', 'KAR'];
            }
        } else {
            $formattedKelases = array_values(array_unique($formattedKelases));
            sort($formattedKelases);
        }
        $kelases = $formattedKelases;

        return view('admin.pengguna', compact(
            'users', 'fakultas', 'prodis', 'kelases', 
            'availablePrograms', 'availableSemesters'
        ));
    }

    public function deleteUser($id)
    {
        $authUser = Auth::user();
        if ($authUser->id == $id) {
            return back()->withErrors(['msg' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $targetUser = User::with(['dosen', 'mahasiswa'])->findOrFail($id);
        if ($authUser->isAdminFakultas()) {
            $userFakId = $targetUser->fakultas_id 
                ?? $targetUser->dosen?->id_fakultas 
                ?? $targetUser->mahasiswa?->id_fakultas;
            if ($userFakId != $authUser->fakultas_id || $targetUser->isSuperAdmin()) {
                return back()->withErrors(['msg' => 'Anda tidak memiliki izin untuk menghapus pengguna ini.']);
            }
        }

        $targetUser->delete();
        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }

    public function bulkDeleteUsers(Request $request)
    {
        $authUser = Auth::user();
        $ids = $request->ids;
        if (!$ids || empty($ids)) {
            return back()->withErrors(['msg' => 'Tidak ada pengguna yang dipilih untuk dihapus.']);
        }

        $ids = array_diff($ids, [$authUser->id]);

        if (empty($ids)) {
            return back()->withErrors(['msg' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $usersToDelete = User::with(['dosen', 'mahasiswa'])->whereIn('id', $ids)->get();
        $validIds = [];

        foreach ($usersToDelete as $u) {
            if ($authUser->isAdminFakultas()) {
                $userFakId = $u->fakultas_id 
                    ?? $u->dosen?->id_fakultas 
                    ?? $u->mahasiswa?->id_fakultas;
                if ($userFakId == $authUser->fakultas_id && !$u->isSuperAdmin()) {
                    $validIds[] = $u->id;
                }
            } else {
                $validIds[] = $u->id;
            }
        }

        if (empty($validIds)) {
            return back()->withErrors(['msg' => 'Tidak ada pengguna yang dapat Anda hapus dalam pilihan ini.']);
        }

        User::whereIn('id', $validIds)->delete();
        
        return back()->with('success', count($validIds) . ' akun pengguna berhasil dihapus.');
    }

    public function resetPasswordUser($id)
    {
        $authUser = Auth::user();
        $user = User::with(['dosen', 'mahasiswa'])->findOrFail($id);

        if ($authUser->isAdminFakultas()) {
            $userFakId = $user->fakultas_id ?? $user->dosen?->id_fakultas ?? $user->mahasiswa?->id_fakultas;
            if ($userFakId != $authUser->fakultas_id || $user->isSuperAdmin()) {
                return back()->withErrors(['msg' => 'Anda tidak memiliki izin untuk mengedit pengguna ini.']);
            }
        }

        $user->password = \Illuminate\Support\Facades\Hash::make('password');
        $user->save();

        return back()->with('success', "Password akun '{$user->username}' berhasil di-reset menjadi 'password'.");
    }

    public function toggleStatusUser($id)
    {
        $authUser = Auth::user();
        if ($authUser->id == $id) {
            return back()->withErrors(['msg' => 'Anda tidak dapat mengubah status akun Anda sendiri.']);
        }

        $user = User::with(['dosen', 'mahasiswa'])->findOrFail($id);

        if ($authUser->isAdminFakultas()) {
            $userFakId = $user->fakultas_id ?? $user->dosen?->id_fakultas ?? $user->mahasiswa?->id_fakultas;
            if ($userFakId != $authUser->fakultas_id || $user->isSuperAdmin()) {
                return back()->withErrors(['msg' => 'Anda tidak memiliki izin untuk mengedit pengguna ini.']);
            }
        }

        $newStatus = strtolower($user->status ?? 'aktif') === 'aktif' ? 'nonaktif' : 'aktif';
        $user->status = $newStatus;
        $user->save();

        $statusText = $newStatus === 'aktif' ? 'diaktifkan kembali' : 'dinonaktifkan (suspended)';
        return back()->with('success', "Akun '{$user->username}' berhasil {$statusText}.");
    }

    public function laboratorium(Request $request)
    {
        $user = Auth::user();
        $nowDate = \Carbon\Carbon::today()->format('Y-m-d');
        $nowTime = now()->format('H:i:s');

        $query = Laboratorium::with(['fakultas', 'agendas' => function($q) use ($nowDate) {
            $q->whereDate('tanggal', $nowDate)->with(['dosen', 'dosenPengampu']);
        }])->forUser($user)->orderBy('nama_lab', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lab', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('nama_laboran', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas_id') && $user->isSuperAdmin()) {
            $query->where('fakultas_id', $request->fakultas_id);
        }

        if ($request->filled('kapasitas')) {
            $cap = $request->kapasitas;
            if ($cap === 'small') {
                $query->where('kapasitas', '<', 30);
            } elseif ($cap === 'medium') {
                $query->whereBetween('kapasitas', [30, 50]);
            } elseif ($cap === 'large') {
                $query->where('kapasitas', '>', 50);
            }
        }

        if ($request->filled('status')) {
            $st = strtolower($request->status);
            if ($st === 'sedang dipakai') {
                $query->whereHas('agendas', function($q) use ($nowDate, $nowTime) {
                    $q->whereDate('tanggal', $nowDate)
                      ->where('jam_mulai', '<=', $nowTime)
                      ->where('jam_selesai', '>=', $nowTime);
                });
            } elseif ($st === 'maintenance') {
                $query->where(function($q) {
                    $q->where('nama_lab', 'like', '%maintenance%')
                      ->orWhere('lokasi', 'like', '%maintenance%');
                });
            } elseif ($st === 'tersedia') {
                $query->whereDoesntHave('agendas', function($q) use ($nowDate, $nowTime) {
                    $q->whereDate('tanggal', $nowDate)
                      ->where('jam_mulai', '<=', $nowTime)
                      ->where('jam_selesai', '>=', $nowTime);
                })->where('nama_lab', 'not like', '%maintenance%')
                  ->where('lokasi', 'not like', '%maintenance%');
            }
        }

        $labs = $query->paginate(12)->withQueryString();

        $labs->getCollection()->transform(function($lab) use ($nowTime) {
            $activeAgenda = $lab->agendas->first(function($agenda) use ($nowTime) {
                return $agenda->jam_mulai <= $nowTime && $agenda->jam_selesai >= $nowTime;
            });

            if (str_contains(strtolower($lab->nama_lab . ' ' . $lab->lokasi), 'maintenance')) {
                $lab->computed_status = 'Maintenance';
            } elseif ($activeAgenda) {
                $lab->computed_status = 'Sedang Dipakai';
                $lab->active_agenda = $activeAgenda;
            } else {
                $lab->computed_status = 'Tersedia';
            }

            $lab->today_agendas = $lab->agendas->sortBy('jam_mulai')->values();

            return $lab;
        });

        $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();

        return view('admin.laboratorium', compact('labs', 'fakultas'));
    }

    public function storeLab(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdminFakultas() && !$request->filled('fakultas_id')) {
            $request->merge(['fakultas_id' => $user->fakultas_id]);
        }

        $rules = [
            'nama_lab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'nama_laboran' => 'nullable|string|max:100',
        ];

        if ($user->isSuperAdmin()) {
            $rules['fakultas_id'] = 'required|exists:fakultas,id';
            $fakultasId = $request->fakultas_id;
        } else {
            $fakultasId = $user->fakultas_id;
        }

        $messages = [
            'nama_lab.required' => 'Nama laboratorium wajib diisi.',
            'lokasi.required' => 'Lokasi gedung/ruang wajib diisi.',
            'kapasitas.required' => 'Kapasitas workstation wajib diisi.',
            'kapasitas.integer' => 'Kapasitas harus berupa angka.',
            'fakultas_id.required' => 'Fakultas naungan laboratorium wajib dipilih.',
            'fakultas_id.exists' => 'Fakultas yang dipilih tidak valid.',
        ];

        $request->validate($rules, $messages);

        Laboratorium::create([
            'fakultas_id' => $fakultasId,
            'nama_lab' => $request->nama_lab,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'nama_laboran' => $request->nama_laboran,
        ]);

        return back()->with('success', 'Laboratorium baru berhasil ditambahkan.');
    }

    public function updateLab(Request $request, $id)
    {
        $user = Auth::user();
        $lab = Laboratorium::findOrFail($id);

        if (!$user->canManageLab($lab)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data laboratorium ini.');
        }

        if ($user->isAdminFakultas() && !$request->filled('fakultas_id')) {
            $request->merge(['fakultas_id' => $user->fakultas_id]);
        }

        $rules = [
            'nama_lab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'nama_laboran' => 'nullable|string|max:100',
        ];

        if ($user->isSuperAdmin()) {
            $rules['fakultas_id'] = 'required|exists:fakultas,id';
            $fakultasId = $request->fakultas_id;
        } else {
            $fakultasId = $lab->fakultas_id ?? $user->fakultas_id;
        }

        $messages = [
            'nama_lab.required' => 'Nama laboratorium wajib diisi.',
            'lokasi.required' => 'Lokasi gedung/ruang wajib diisi.',
            'kapasitas.required' => 'Kapasitas workstation wajib diisi.',
            'kapasitas.integer' => 'Kapasitas harus berupa angka.',
            'fakultas_id.required' => 'Fakultas naungan laboratorium wajib dipilih.',
            'fakultas_id.exists' => 'Fakultas yang dipilih tidak valid.',
        ];

        $request->validate($rules, $messages);

        $lab->update([
            'fakultas_id' => $fakultasId,
            'nama_lab' => $request->nama_lab,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'nama_laboran' => $request->nama_laboran,
        ]);

        return back()->with('success', 'Data laboratorium berhasil diperbarui.');
    }

    public function deleteLab($id)
    {
        try {
            $user = Auth::user();
            $lab = Laboratorium::findOrFail($id);

            if (!$user->canManageLab($lab)) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus laboratorium ini.');
            }

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

        return back()->with('success', "Berhasil membuat {$createdCount} sesi pertemuan (Pertemuan 1 s/d 16) untuk " . $jadwal->mata_kuliah);
    }

    public function agenda(Request $request)
    {
        $user = Auth::user();
        $query = Agenda::with(['dosen', 'dosenPengampu', 'lab', 'jadwalPenggunaanLab']);

        if ($user->isAdminFakultas()) {
            $query->whereHas('lab', fn($q) => $q->where('fakultas_id', $user->fakultas_id));
        }

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

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('prodi_id')) {
            $prodiObj = Prodi::find($request->prodi_id);
            if ($prodiObj) {
                $prodiName = $prodiObj->nama_prodi;
                $query->where(function($q) use ($prodiName, $request) {
                    $q->where('jurusan', 'like', "%{$prodiName}%")
                      ->orWhereHas('dosen', fn($qd) => $qd->where('id_prodi', $request->prodi_id))
                      ->orWhereHas('dosenPengampu', fn($qd) => $qd->where('id_prodi', $request->prodi_id));
                });
            }
        }

        if ($request->filled('pertemuan')) {
            $pertNum = (int)$request->pertemuan;
            $query->where(function($q) use ($pertNum) {
                $q->where('catatan', 'like', "%Pertemuan {$pertNum}%")
                  ->orWhere('catatan', 'like', "%Pertemuan ke-{$pertNum}%")
                  ->orWhere('catatan', 'like', "%Pertemuan {$pertNum} %")
                  ->orWhere('catatan', 'like', "%Pertemuan ke-{$pertNum} %");
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

        if ($user->isAdminFakultas()) {
            $dosens = Dosen::where('id_fakultas', $user->fakultas_id)->orderBy('nama', 'asc')->get();
            $labs = Laboratorium::forUser($user)->orderBy('nama_lab', 'asc')->get();
            $fakultas = Fakultas::where('id', $user->fakultas_id)->get();
            $prodis = Prodi::where('fakultas_id', $user->fakultas_id)->orderBy('nama_prodi', 'asc')->get();
        } else {
            $dosens = Dosen::orderBy('nama', 'asc')->get();
            $labs = Laboratorium::orderBy('nama_lab', 'asc')->get();
            $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();
            $prodis = Prodi::with('fakultas')->orderBy('nama_prodi', 'asc')->get();
        }
        $kelases = Kelas::all();
        $mataKuliahs = MataKuliah::with('prodi.fakultas')->orderBy('nama_mk', 'asc')->get();

        return view('admin.agenda', compact('allAgendas', 'dosens', 'labs', 'fakultas', 'prodis', 'kelases', 'mataKuliahs'));
    }

    public function storeAgenda(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'dosen_pengampu_id' => 'required_without:dosen_id|nullable|exists:dosen,id',
            'dosen_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'mata_kuliah' => 'required_without:judul_agenda|nullable|string|max:150',
            'judul_agenda' => 'nullable|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'required|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'status_agenda' => 'nullable|string',
            'materi_pembelajaran' => 'nullable|string',
            'rencana_pembelajaran' => 'nullable|string',
        ]);

        $targetLab = Laboratorium::findOrFail($request->lab_id);
        if (!$user->canManageLab($targetLab)) {
            abort(403, 'Anda tidak memiliki wewenang untuk mengatur agenda di laboratorium ini.');
        }

        $dosenPengampuId = $request->dosen_pengampu_id ?: $request->dosen_id;
        $dosenId = $request->dosen_id ?: $dosenPengampuId;
        $mataKuliah = $request->mata_kuliah ?: $request->judul_agenda;
        $materi = $request->materi_pembelajaran ?? $request->rencana_pembelajaran ?? '';

        // Cek Bentrok Laboratorium
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

        // Cek Bentrok Dosen (pengajar di lab)
        $bentrokDosen = Agenda::with('lab')
            ->where('dosen_id', $dosenId)
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
                'waktu_masuk' => "⛔ BENTROK JADWAL DOSEN! Dosen pengajar sudah memiliki jadwal di {$labName} pada jam {$jamRange} (\"{$bentrokDosen->mata_kuliah}\")."
            ])->withInput();
        }

        // Kalkulasi Status Agenda Otomatis jika tidak ditentukan atau disetel Otomatis
        $statusAgenda = $request->status_agenda;
        if (empty($statusAgenda) || $statusAgenda === 'Otomatis') {
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

        $startDateCarbon = \Carbon\Carbon::parse($request->tanggal);
        for ($i = 0; $i < 16; $i++) {
            $meetDate = $startDateCarbon->copy()->addWeeks($i)->format('Y-m-d');
            $statusAg = $meetDate < date('Y-m-d') ? 'Selesai' : ($meetDate === date('Y-m-d') ? 'Berlangsung' : 'Akan Datang');

            Agenda::create([
                'dosen_id' => $dosenId,
                'dosen_pengampu_id' => $dosenPengampuId,
                'lab_id' => $request->lab_id,
                'mata_kuliah' => $mataKuliah,
                'program_kuliah' => $request->program_kuliah,
                'tahun_akademik' => $request->tahun_akademik ?? '2026/2027 Ganjil',
                'jenis_pertemuan' => $request->jenis_pertemuan ?? 'Praktikum',
                'kelas' => $request->kelas ?? '',
                'semester' => $request->semester,
                'jurusan' => $request->jurusan,
                'fakultas' => $request->fakultas,
                'tanggal' => $meetDate,
                'jam_mulai' => $request->waktu_masuk,
                'jam_selesai' => $request->waktu_keluar,
                'status_agenda' => $statusAg,
                'catatan' => "Pertemuan ke-" . ($i + 1) . ($materi ? ": {$materi}" : ": {$mataKuliah}"),
            ]);
        }

        return back()->with('success', "Berhasil membuat 16 sesi pertemuan perkuliahan secara otomatis untuk mata kuliah {$mataKuliah}.");
    }

    public function absenDosen($id)
    {
        $user = Auth::user();
        $agenda = Agenda::with('lab')->findOrFail($id);

        if ($user->isAdminFakultas() && !$user->canManageLab($agenda->lab)) {
            return back()->withErrors(['msg' => 'Akses Ditolak: Anda tidak memiliki izin untuk mengedit agenda di lab ini.']);
        }

        if ($agenda->tanggal > date('Y-m-d')) {
            return back()->withErrors(['msg' => 'Agenda belum bisa diabsen (sesi perkuliahan belum dimulai).']);
        }

        $agenda->update(['dosen_waktu_masuk' => now()]);

        return back()->with('success', 'Kehadiran dosen berhasil ditandai (Hadir).');
    }

    public function updateAgenda(Request $request, $id)
    {
        $user = Auth::user();
        $agenda = Agenda::with('lab')->findOrFail($id);
        if (!$user->canManageLab($agenda->lab)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah agenda di laboratorium ini.');
        }

        $request->validate([
            'dosen_pengampu_id' => 'required_without:dosen_id|nullable|exists:dosen,id',
            'dosen_id' => 'nullable|exists:dosen,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'mata_kuliah' => 'required_without:judul_agenda|nullable|string|max:150',
            'judul_agenda' => 'nullable|string|max:150',
            'kelas' => 'nullable|string|max:50',
            'program_kuliah' => 'required|in:Reguler,Karyawan',
            'jenis_pertemuan' => 'required|in:Teori,Praktikum',
            'semester' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'status_agenda' => 'nullable|string',
            'materi_pembelajaran' => 'nullable|string',
            'rencana_pembelajaran' => 'nullable|string',
        ]);

        $targetLab = Laboratorium::findOrFail($request->lab_id);
        if (!$user->canManageLab($targetLab)) {
            abort(403, 'Anda tidak memiliki wewenang untuk memindahkan agenda ke laboratorium ini.');
        }

        $dosenPengampuId = $request->dosen_pengampu_id ?: $request->dosen_id;
        $dosenId = $request->dosen_id ?: $dosenPengampuId;
        $mataKuliah = $request->mata_kuliah ?: $request->judul_agenda;
        $materi = $request->materi_pembelajaran ?? $request->rencana_pembelajaran ?? '';

        // Cek Bentrok Laboratorium (kecuali agenda ini sendiri)
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
            return back()->withErrors([
                'waktu_masuk' => "⛔ BENTROK JADWAL LAB! {$labName} sudah digunakan pada jam {$jamRange} (\"{$bentrokLab->mata_kuliah}\")."
            ])->withInput();
        }

        // Cek Bentrok Dosen (kecuali agenda ini sendiri)
        $bentrokDosen = Agenda::with(['dosen', 'lab'])
            ->where(function ($q) use ($dosenId, $dosenPengampuId) {
                $q->where('dosen_id', $dosenId)
                  ->orWhere('dosen_pengampu_id', $dosenPengampuId);
            })
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
                'waktu_masuk' => "⛔ BENTROK JADWAL DOSEN! Dosen pengajar sudah memiliki jadwal di {$labName} pada jam {$jamRange} (\"{$bentrokDosen->mata_kuliah}\")."
            ])->withInput();
        }

        // Kalkulasi Status Agenda Otomatis jika tidak ditentukan atau disetel Otomatis
        $statusAgenda = $request->status_agenda;
        if (empty($statusAgenda) || $statusAgenda === 'Otomatis') {
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

        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'dosen_id' => $dosenId,
            'dosen_pengampu_id' => $dosenPengampuId,
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $mataKuliah,
            'program_kuliah' => $request->program_kuliah,
            'tahun_akademik' => $request->tahun_akademik ?? $agenda->tahun_akademik ?? '2026/2027 Ganjil',
            'jenis_pertemuan' => $request->jenis_pertemuan ?? 'Praktikum',
            'kelas' => $request->kelas ?? '',
            'semester' => $request->semester,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->waktu_masuk,
            'jam_selesai' => $request->waktu_keluar,
            'status_agenda' => $statusAgenda,
            'catatan' => $materi,
        ]);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function deleteAgenda($id)
    {
        $user = Auth::user();
        $agenda = Agenda::with('lab')->findOrFail($id);
        if (!$user->canManageLab($agenda->lab)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus agenda ini.');
        }
        $agenda->delete();
        return back()->with('success', 'Agenda praktikum berhasil dihapus.');
    }

    public function bulkDeleteAgendas(Request $request)
    {
        $user = Auth::user();
        $ids = $request->ids;
        if (!$ids || empty($ids)) {
            return back()->withErrors(['msg' => 'Tidak ada agenda yang dipilih untuk dihapus.']);
        }

        $agendas = Agenda::with('lab')->whereIn('id', $ids)->get();
        $validIds = [];
        foreach ($agendas as $agenda) {
            if ($user->canManageLab($agenda->lab)) {
                $validIds[] = $agenda->id;
            }
        }

        if (empty($validIds)) {
            return back()->withErrors(['msg' => 'Tidak ada agenda yang diizinkan untuk Anda hapus.']);
        }

        Agenda::whereIn('id', $validIds)->delete();

        return back()->with('success', count($validIds) . ' agenda praktikum berhasil dihapus.');
    }

    public function absensi(Request $request)
    {
        $user = Auth::user();
        $query = Agenda::with(['dosen', 'lab', 'absensi.mahasiswa'])
            ->orderBy('mata_kuliah', 'asc')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc');

        if ($user->isAdminFakultas()) {
            $query->whereHas('lab', fn($q) => $q->where('fakultas_id', $user->fakultas_id));
        }

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

        $allAgendas = $query->get();

        // Group agendas by Mata Kuliah + Kelas + Dosen ID
        $groupedAgendas = $allAgendas->groupBy(function($item) {
            return $item->mata_kuliah . '___' . ($item->kelas ?: 'General') . '___' . ($item->dosen_id ?: 0);
        });

        $agendas = $allAgendas;

        $uniqueClasses = $allAgendas->unique(function ($item) {
            return $item->mata_kuliah . '-' . $item->kelas . '-' . $item->dosen_id;
        });

        return view('admin.absensi', compact('agendas', 'groupedAgendas', 'uniqueClasses'));
    }

    public function exportAbsensi(Request $request)
    {
        $user = Auth::user();
        
        $selectedAgendaIds = $request->input('agenda_ids', []);
        if ($request->filled('agenda_id')) {
            $selectedAgendaIds[] = $request->agenda_id;
        }
        $selectedAgendaIds = array_filter(array_unique($selectedAgendaIds));

        $query = Agenda::with(['dosen', 'lab', 'absensi.mahasiswa'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc');

        if ($user->isAdminFakultas()) {
            $query->whereHas('lab', fn($q) => $q->where('fakultas_id', $user->fakultas_id));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $allAgendas = $query->get();

        // Group agendas by Mata Kuliah + Kelas + Dosen
        $groupedAgendas = $allAgendas->groupBy(function($item) {
            return $item->mata_kuliah . '___' . ($item->kelas ?: '-') . '___' . $item->dosen_id;
        });

        // Filter groups if specific agenda IDs were checked
        if (!empty($selectedAgendaIds)) {
            $groupedAgendas = $groupedAgendas->filter(function($group) use ($selectedAgendaIds) {
                return $group->pluck('id')->intersect($selectedAgendaIds)->isNotEmpty();
            });
        }

        $courseReports = [];

        foreach ($groupedAgendas as $groupKey => $agendasInGroup) {
            $mainAgenda = $agendasInGroup->first();
            $mataKuliah = $mainAgenda->mata_kuliah;
            $kelas = $mainAgenda->kelas;

            // Retrieve students from Mahasiswa table precisely matching class/semester/program
            $studentsFromClass = $mainAgenda->getStudentsQuery()->with('user')->orderBy('nim')->get();
            $validIds = $studentsFromClass->pluck('id')->toArray();
            
            $studentsFromAbsensi = collect();
            foreach ($agendasInGroup as $ag) {
                foreach ($ag->absensi as $abs) {
                    if ($abs->mahasiswa && in_array($abs->mahasiswa_id, $validIds)) {
                        $studentsFromAbsensi->push($abs->mahasiswa);
                    }
                }
            }

            $students = $studentsFromClass->concat($studentsFromAbsensi)
                ->unique('id')
                ->sortBy('nim')
                ->values();

            // 16 Meeting slots
            $sessions = [];
            for ($i = 1; $i <= 16; $i++) {
                $ag = $agendasInGroup->get($i - 1);
                $sessions[$i] = [
                    'pertemuan' => $i,
                    'agenda' => $ag,
                    'tanggal' => $ag ? $ag->tanggal : null,
                    'is_uts' => ($i == 8),
                    'is_uas' => ($i == 16),
                ];
            }

            // 2D attendance matrix
            $matrix = [];
            foreach ($students as $mhs) {
                $matrix[$mhs->id] = [];
                for ($i = 1; $i <= 16; $i++) {
                    $ag = $sessions[$i]['agenda'];
                    $record = null;
                    if ($ag) {
                        $record = $ag->absensi->firstWhere('mahasiswa_id', $mhs->id);
                    }
                    $matrix[$mhs->id][$i] = $record;
                }
            }

            $courseReports[] = [
                'mainAgenda' => $mainAgenda,
                'mataKuliah' => $mataKuliah,
                'kelas' => $kelas,
                'agendas' => $agendasInGroup,
                'students' => $students,
                'sessions' => $sessions,
                'matrix' => $matrix,
            ];
        }

        return view('admin.export_absensi', compact('courseReports'));
    }

    public function inputAbsensi($id)
    {
        $user = Auth::user();
        $agenda = Agenda::with(['dosen', 'lab'])->findOrFail($id);
        
        if ($user->isAdminFakultas() && !$user->canManageLab($agenda->lab)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk mengelola absensi lab ini.');
        }

        if ($agenda->tanggal > date('Y-m-d')) {
            return redirect()->route('admin.absensi')->withErrors([
                'msg' => 'Sesi perkuliahan ini belum dimulai (Jadwal: ' . \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('l, d F Y') . '). Presensi mahasiswa hanya dapat dibuka pada hari H pelaksanaan perkuliahan.'
            ]);
        }
        
        $existingAbsensi = \App\Models\Absensi::where('agenda_id', $agenda->id)->get()->keyBy('mahasiswa_id');

        $students = $agenda->getStudentsQuery()->orderBy('nama_lengkap', 'asc')->get();

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

        $user = Auth::user();
        $agenda = Agenda::with('lab')->findOrFail($id);

        if ($user->isAdminFakultas() && !$user->canManageLab($agenda->lab)) {
            return redirect()->back()->with('error', 'Akses Ditolak: Anda tidak berwenang mengimpor absensi lab ini.');
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

        $parts = explode('|', $request->mata_kuliah_kelas);
        $mata_kuliah = $parts[0] ?? '';
        $kelas = $parts[1] ?? '';
        $dosen_id = $parts[2] ?? '';

        $baseAgenda = Agenda::with('lab')->where('mata_kuliah', $mata_kuliah)
            ->where('kelas', $kelas)
            ->where('dosen_id', $dosen_id)
            ->first();

        if (!$baseAgenda) {
            return redirect()->back()->with('error', 'Data mata kuliah/kelas tidak ditemukan.');
        }

        $user = Auth::user();
        if ($user->isAdminFakultas() && !$user->canManageLab($baseAgenda->lab)) {
            return redirect()->back()->with('error', 'Akses Ditolak: Anda tidak memiliki izin untuk mengimpor absensi kelas di luar fakultas Anda.');
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

        $user = Auth::user();
        $agenda = Agenda::with('lab')->findOrFail($id);

        if ($user->isAdminFakultas() && !$user->canManageLab($agenda->lab)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk menyimpan absensi lab ini.');
        }

        if ($agenda->tanggal > date('Y-m-d')) {
            return redirect()->route('admin.absensi')->withErrors([
                'msg' => 'Presensi tidak dapat disimpan untuk sesi perkuliahan yang belum dimulai.'
            ]);
        }

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
        $user = Auth::user();
        $query = Pengumuman::with(['admin', 'laboratoriums'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc');

        if ($user->isAdminFakultas()) {
            $myLabIds = Laboratorium::forUser($user)->pluck('id');
            $query->where(function($q) use ($user, $myLabIds) {
                $q->where('admin_id', $user->id)
                  ->orWhereHas('laboratoriums', function($labQuery) use ($myLabIds) {
                      $labQuery->whereIn('laboratorium.id', $myLabIds);
                  });
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi_pengumuman', 'like', "%{$search}%");
            });
        }

        if ($request->filled('lab_id')) {
            $labIdFilter = $request->lab_id;
            if ($labIdFilter === 'umum') {
                $query->whereDoesntHave('laboratoriums');
            } else {
                $query->whereHas('laboratoriums', function($lq) use ($labIdFilter) {
                    $lq->where('laboratorium.id', $labIdFilter);
                });
            }
        }

        if ($request->filled('status')) {
            $st = $request->status;
            $today = date('Y-m-d H:i:s');
            if ($st === 'aktif') {
                $query->where(function($q) use ($today) {
                    $q->whereNull('tanggal_mulai')->orWhere('tanggal_mulai', '<=', $today);
                })->where(function($q) use ($today) {
                    $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', $today);
                });
            } elseif ($st === 'dijadwalkan') {
                $query->where('tanggal_mulai', '>', $today);
            } elseif ($st === 'kedaluwarsa') {
                $query->where('tanggal_selesai', '<', $today);
            } elseif ($st === 'penting') {
                $query->whereIn('prioritas', ['Penting', 'Urgen']);
            }
        }

        $pengumumanList = $query->paginate(10)->withQueryString();
        $laboratoriums = Laboratorium::forUser($user)->get();

        return view('admin.pengumuman', compact('pengumumanList', 'laboratoriums'));
    }

    public function storeUser(Request $request)
    {
        $authUser = Auth::user();
        $allowedRoles = $authUser->isSuperAdmin() ? 'super_admin,admin,dosen,mahasiswa' : 'admin,dosen,mahasiswa';

        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'username_or_nim_nip' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:4',
            'role' => 'required|in:' . $allowedRoles,
            'kelas' => 'nullable|string|max:50',
            'semester' => 'nullable|integer|min:1|max:8',
            'status' => 'nullable|in:Tetap,Tidak Tetap,Honorer,Cuti',
            'kompetensi' => 'nullable|string',
            'jabatan' => 'nullable|string|max:100',
            'program_kuliah' => 'nullable|in:Reguler,Karyawan',
        ];

        if ($authUser->isAdminFakultas() && !$request->filled('fakultas')) {
            $request->merge(['fakultas' => $authUser->fakultas_id]);
        }

        if ($request->role === 'dosen' || $request->role === 'mahasiswa') {
            $rules['fakultas'] = 'required|exists:fakultas,id';
            $rules['jurusan'] = 'required|exists:prodi,id';
            if ($authUser->isAdminFakultas() && $request->fakultas != $authUser->fakultas_id) {
                return back()->withErrors(['fakultas' => 'Anda hanya dapat menambahkan pengguna ke fakultas Anda.']);
            }
        } elseif ($request->role === 'admin') {
            $rules['fakultas'] = $authUser->isAdminFakultas() ? 'nullable|exists:fakultas,id' : 'required|exists:fakultas,id';
            $rules['jurusan'] = 'nullable|exists:prodi,id';
        } else {
            $rules['fakultas'] = 'nullable|exists:fakultas,id';
            $rules['jurusan'] = 'nullable|exists:prodi,id';
        }

        $request->validate($rules);

        DB::transaction(function() use ($request, $authUser) {
            $fakultasId = null;
            if ($request->role === 'admin') {
                $fakultasId = $authUser->isAdminFakultas() ? $authUser->fakultas_id : $request->fakultas;
            } elseif ($request->role === 'super_admin') {
                $fakultasId = null;
            }

            $user = User::create([
                'username' => $request->username_or_nim_nip,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'fakultas_id' => $fakultasId,
            ]);

            if ($request->role === 'dosen') {
                Dosen::create([
                    'user_id' => $user->id,
                    'nip' => $request->username_or_nim_nip,
                    'nama' => $request->nama_lengkap,
                    'status' => $request->status ?? 'Tetap',
                    'id_fakultas' => $authUser->isAdminFakultas() ? $authUser->fakultas_id : $request->fakultas,
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
                    'id_fakultas' => $authUser->isAdminFakultas() ? $authUser->fakultas_id : $request->fakultas,
                    'id_prodi' => $request->jurusan,
                ]);
            }
        });

        return back()->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $authUser = Auth::user();
        $user = User::with(['dosen', 'mahasiswa'])->findOrFail($id);

        if ($authUser->isAdminFakultas()) {
            $userFakId = $user->fakultas_id 
                ?? $user->dosen?->id_fakultas 
                ?? $user->mahasiswa?->id_fakultas;
            if ($userFakId != $authUser->fakultas_id || $user->isSuperAdmin()) {
                abort(403, 'Anda tidak memiliki wewenang untuk mengubah data pengguna ini.');
            }
        }

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

        if ($authUser->isAdminFakultas() && !$request->filled('fakultas')) {
            $request->merge(['fakultas' => $authUser->fakultas_id]);
        }

        if ($user->role === 'dosen' || $user->role === 'mahasiswa') {
            $rules['fakultas'] = 'required|exists:fakultas,id';
            $rules['jurusan'] = 'required|exists:prodi,id';
        } else {
            $rules['fakultas'] = 'nullable|exists:fakultas,id';
            $rules['jurusan'] = 'nullable|exists:prodi,id';
        }

        $request->validate($rules);

        DB::transaction(function() use ($request, $user, $authUser) {
            $data = [
                'username' => $request->username_or_nim_nip,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($user->role === 'admin' && $authUser->isSuperAdmin() && $request->filled('fakultas')) {
                $data['fakultas_id'] = $request->fakultas;
            }

            $user->update($data);

            if ($user->role === 'dosen') {
                $fakultasVal = $authUser->isAdminFakultas() ? $authUser->fakultas_id : ($request->fakultas ?: $user->dosen?->id_fakultas);
                $dosen = Dosen::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nip' => $request->username_or_nim_nip,
                        'nama' => $request->nama_lengkap,
                        'status' => $request->status ?? 'Tetap',
                        'id_fakultas' => $fakultasVal,
                        'id_prodi' => $request->jurusan,
                        'kompetensi' => $request->kompetensi,
                        'jabatan' => $request->jabatan,
                    ]
                );
            } elseif ($user->role === 'mahasiswa') {
                $fakultasVal = $authUser->isAdminFakultas() ? $authUser->fakultas_id : ($request->fakultas ?: $user->mahasiswa?->id_fakultas);
                $mahasiswa = Mahasiswa::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nim' => $request->username_or_nim_nip,
                        'nama_lengkap' => $request->nama_lengkap,
                        'kelas' => $request->kelas ?? '',
                        'program_kuliah' => $request->program_kuliah ?? 'Reguler',
                        'semester' => $request->semester ?? 1,
                        'status' => $request->status_mahasiswa ?? 'aktif',
                        'id_fakultas' => $fakultasVal,
                        'id_prodi' => $request->jurusan,
                    ]
                );
            }
        });

        return back()->with('success', 'Data akun pengguna berhasil diperbarui.');
    }


    public function storePengumuman(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'judul' => 'required|string|max:150',
            'isi_pengumuman' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'laboratorium_ids' => 'nullable|array',
            'laboratorium_ids.*' => 'exists:laboratorium,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'prioritas' => 'nullable|string|in:Normal,Penting,Urgen',
            'is_pinned' => 'nullable|boolean',
        ]);

        if ($user->isAdminFakultas() && $request->has('laboratorium_ids')) {
            $allowedLabIds = Laboratorium::forUser($user)->pluck('id')->toArray();
            foreach ($request->laboratorium_ids as $targetLabId) {
                if (!in_array($targetLabId, $allowedLabIds)) {
                    return back()->withErrors(['laboratorium_ids' => 'Anda hanya dapat menautkan pengumuman ke laboratorium di bawah naungan fakultas Anda.']);
                }
            }
        }

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
            'prioritas' => $request->prioritas ?: 'Normal',
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        if ($request->has('laboratorium_ids')) {
            $pengumuman->laboratoriums()->sync($request->laboratorium_ids);
        }

        return back()->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function updatePengumuman(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'judul' => 'required|string|max:150',
            'isi_pengumuman' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'laboratorium_ids' => 'nullable|array',
            'laboratorium_ids.*' => 'exists:laboratorium,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'prioritas' => 'nullable|string|in:Normal,Penting,Urgen',
            'is_pinned' => 'nullable|boolean',
        ]);

        $pengumuman = Pengumuman::with('laboratoriums')->findOrFail($id);

        if ($user->isAdminFakultas()) {
            if ($pengumuman->admin_id != $user->id) {
                $allowedLabIds = Laboratorium::forUser($user)->pluck('id')->toArray();
                $existingLabIds = $pengumuman->laboratoriums->pluck('id')->toArray();
                if (empty($existingLabIds) || count(array_diff($existingLabIds, $allowedLabIds)) > 0) {
                    abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengubah pengumuman ini.');
                }
            }

            if ($request->has('laboratorium_ids')) {
                $allowedLabIds = Laboratorium::forUser($user)->pluck('id')->toArray();
                foreach ($request->laboratorium_ids as $targetLabId) {
                    if (!in_array($targetLabId, $allowedLabIds)) {
                        return back()->withErrors(['laboratorium_ids' => 'Anda hanya dapat menautkan pengumuman ke laboratorium di bawah naungan fakultas Anda.']);
                    }
                }
            }
        }

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
            'prioritas' => $request->prioritas ?: 'Normal',
            'is_pinned' => $request->boolean('is_pinned'),
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
        $user = Auth::user();
        $pengumuman = Pengumuman::with('laboratoriums')->find($id);
        if ($pengumuman) {
            if ($user->isAdminFakultas()) {
                if ($pengumuman->admin_id != $user->id) {
                    $allowedLabIds = Laboratorium::forUser($user)->pluck('id')->toArray();
                    $existingLabIds = $pengumuman->laboratoriums->pluck('id')->toArray();
                    if (empty($existingLabIds) || count(array_diff($existingLabIds, $allowedLabIds)) > 0) {
                        abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk menghapus pengumuman ini.');
                    }
                }
            }

            if ($pengumuman->foto_url && Storage::disk('public')->exists($pengumuman->foto_url)) {
                Storage::disk('public')->delete($pengumuman->foto_url);
            }
            $pengumuman->delete();
        }
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function promoteSemesters(Request $request)
    {
        $authUser = Auth::user();
        $action = $request->input('action_type', 'promote'); // 'promote' (+1) or 'revert' (-1)
        $targetFakultas = $authUser->isAdminFakultas() ? $authUser->fakultas_id : $request->input('target_fakultas');
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

    private function ensureSuperAdmin()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Akses Terbatas: Hanya Super Admin yang berhak mengakses dan memodifikasi parameter master akademik.');
        }
    }

    public function akademik(Request $request)
    {
        $this->ensureSuperAdmin();

        $fakultas = Fakultas::orderBy('nama_fakultas')->get();
        $prodis = Prodi::with('fakultas')->orderBy('nama_prodi')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $mataKuliahs = MataKuliah::with('prodi.fakultas')->orderBy('nama_mk')->get();

        return view('admin.akademik', compact('fakultas', 'prodis', 'kelas', 'mataKuliahs'));
    }

    // Fakultas CRUD
    public function storeFakultas(Request $request)
    {
        $this->ensureSuperAdmin();
        $request->validate(['nama_fakultas' => 'required|string|max:100']);
        Fakultas::create(['nama_fakultas' => $request->nama_fakultas]);
        return back()->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function updateFakultas(Request $request, $id)
    {
        $this->ensureSuperAdmin();
        $request->validate(['nama_fakultas' => 'required|string|max:100']);
        Fakultas::findOrFail($id)->update(['nama_fakultas' => $request->nama_fakultas]);
        return back()->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function deleteFakultas($id)
    {
        $this->ensureSuperAdmin();
        Fakultas::destroy($id);
        return back()->with('success', 'Fakultas berhasil dihapus.');
    }

    // Prodi CRUD
    public function storeProdi(Request $request)
    {
        $this->ensureSuperAdmin();
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
        $this->ensureSuperAdmin();
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
        $this->ensureSuperAdmin();
        Prodi::destroy($id);
        return back()->with('success', 'Program Studi berhasil dihapus.');
    }

    // Kelas CRUD
    public function storeKelas(Request $request)
    {
        $this->ensureSuperAdmin();
        $request->validate(['nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas']);
        Kelas::create(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    public function updateKelas(Request $request, $id)
    {
        $this->ensureSuperAdmin();
        $request->validate(['nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas,' . $id]);
        Kelas::findOrFail($id)->update(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Kelas berhasil diperbarui.');
    }

    public function deleteKelas($id)
    {
        $this->ensureSuperAdmin();
        Kelas::destroy($id);
        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    // Mata Kuliah CRUD
    public function storeMataKuliah(Request $request)
    {
        $this->ensureSuperAdmin();
        $request->validate([
            'nama_mk' => 'required|string|max:150',
            'kode_mk' => 'nullable|string|max:30',
            'sks' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|integer|min:1|max:8',
            'kategori' => 'nullable|string|in:Wajib,Pilihan,Praktikum Lab,Teori & Praktikum',
            'id_prodi' => 'nullable|exists:prodi,id',
        ]);
        MataKuliah::create([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks ?: 3,
            'semester' => $request->semester ?: 1,
            'kategori' => $request->kategori ?: 'Wajib',
            'id_prodi' => $request->id_prodi,
        ]);
        return back()->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function updateMataKuliah(Request $request, $id)
    {
        $this->ensureSuperAdmin();
        $request->validate([
            'nama_mk' => 'required|string|max:150',
            'kode_mk' => 'nullable|string|max:30',
            'sks' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|integer|min:1|max:8',
            'kategori' => 'nullable|string|in:Wajib,Pilihan,Praktikum Lab,Teori & Praktikum',
            'id_prodi' => 'nullable|exists:prodi,id',
        ]);
        MataKuliah::findOrFail($id)->update([
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'sks' => $request->sks ?: 3,
            'semester' => $request->semester ?: 1,
            'kategori' => $request->kategori ?: 'Wajib',
            'id_prodi' => $request->id_prodi,
        ]);
        return back()->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function deleteMataKuliah($id)
    {
        $this->ensureSuperAdmin();
        MataKuliah::destroy($id);
        return back()->with('success', 'Mata Kuliah berhasil dihapus.');
    }

    public function bulkDeleteMataKuliah(Request $request)
    {
        $this->ensureSuperAdmin();
        $ids = $request->ids;
        if (!$ids || empty($ids)) {
            return back()->withErrors(['msg' => 'Tidak ada mata kuliah yang dipilih untuk dihapus.']);
        }
        MataKuliah::whereIn('id', $ids)->delete();
        return back()->with('success', count($ids) . ' mata kuliah berhasil dihapus.');
    }

    public function bulkDeleteKelas(Request $request)
    {
        $this->ensureSuperAdmin();
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
        ]);

        try {
            $user = Auth::user();
            $fakultasId = $user->isAdminFakultas() ? $user->fakultas_id : null;
            $importId = (string) \Illuminate\Support\Str::uuid();
            $files = is_array($request->file('file_excel')) ? $request->file('file_excel') : [$request->file('file_excel')];
            $totalImported = 0;

            foreach ($files as $file) {
                if ($file) {
                    $import = new \App\Imports\MahasiswaImport($importId, $fakultasId);
                    Excel::import($import, $file);
                    $totalImported += $import->importedCount;
                }
            }

            if ($totalImported === 0) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Gagal mengimpor data Mahasiswa. Tidak ada data yang terbaca dari file Excel.'], 422);
                }
                return back()->with('error', 'Gagal Impor Data! Tidak ada baris data Mahasiswa yang berhasil terbaca dari file Excel. Harap periksa format nama kolom (nim, nama, kelas, semester, angkatan, prodi).');
            }
            
            if ($request->ajax()) {
                return response()->json(['import_id' => $importId, 'status' => 'completed', 'count' => $totalImported]);
            }
            
            return redirect()->route('admin.pengguna', ['role' => 'mahasiswa'])->with('success', "Berhasil! {$totalImported} data Mahasiswa berhasil diimpor dan terdaftar di sistem.");
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function importDosen(Request $request)
    {
        $request->validate([
            'file_excel' => 'required',
        ]);

        try {
            $user = Auth::user();
            $fakultasId = $user->isAdminFakultas() ? $user->fakultas_id : null;
            $files = is_array($request->file('file_excel')) ? $request->file('file_excel') : [$request->file('file_excel')];
            $totalImported = 0;

            foreach ($files as $file) {
                if ($file) {
                    $import = new DosenImport($fakultasId);
                    Excel::import($import, $file);
                    $totalImported += $import->importedCount;
                }
            }

            if ($totalImported === 0) {
                return back()->with('error', 'Gagal Impor Data! Tidak ada baris data Dosen yang berhasil terbaca dari file Excel. Harap periksa format nama kolom (nip, nama, status, jabatan, prodi).');
            }

            return redirect()->route('admin.pengguna', ['role' => 'dosen'])->with('success', "Berhasil! {$totalImported} data Dosen berhasil diimpor ke sistem.");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function exportPengguna(Request $request)
    {
        $authUser = Auth::user();
        $role = strtolower(trim($request->get('role', 'all')));
        
        $export = new \App\Exports\PenggunaExport($authUser, $role, $request->all());
        return $export->download();
    }

    public function importAgenda(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|max:10240',
        ]);

        try {
            $user = Auth::user();
            $fakultasId = $user->isAdminFakultas() ? $user->fakultas_id : null;
            $import = new AgendaImport($fakultasId);
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
            $user = Auth::user();
            $fakultasId = $user->isAdminFakultas() ? $user->fakultas_id : null;
            Excel::import(new LaboratoriumImport($fakultasId), $request->file('file_excel'));
            return back()->with('success', 'Data Laboratorium berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor data: ' . $e->getMessage()]);
        }
    }

    public function importFakultas(Request $request)
    {
        $this->ensureSuperAdmin();
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
        $this->ensureSuperAdmin();
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
        $this->ensureSuperAdmin();
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
        $this->ensureSuperAdmin();
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
        $user = Auth::user();
        $query = \Spatie\Activitylog\Models\Activity::with(['causer.dosen', 'causer.mahasiswa'])
            ->latest();

        if ($user->isAdminFakultas()) {
            $myFacultyId = $user->fakultas_id;
            $query->where(function($q) use ($myFacultyId) {
                $q->whereHasMorph('causer', [\App\Models\User::class], function($uq) use ($myFacultyId) {
                    $uq->where('fakultas_id', $myFacultyId)
                       ->orWhereHas('dosen', fn($dq) => $dq->where('id_fakultas', $myFacultyId))
                       ->orWhereHas('mahasiswa', fn($mq) => $mq->where('id_fakultas', $myFacultyId));
                });
            });
        }

        $activities = $query->paginate(50);
            
        return view('admin.aktivitas', compact('activities'));
    }

    public function jadwalPenggunaanLab(Request $request)
    {
        $user = Auth::user();
        $labs = Laboratorium::with('fakultas')->forUser($user)->orderBy('nama_lab', 'asc')->get();

        $selectedLabId = $request->get('lab_id');
        if (!$selectedLabId || !$labs->contains('id', $selectedLabId)) {
            $selectedLabId = $labs->first()->id ?? null;
        }

        $tahunAkademik = $request->get('tahun_akademik', '2026/2027 Ganjil');

        if (!$selectedLabId) {
            $jadwals = collect();
        } else {
            $query = JadwalPenggunaanLab::with(['lab', 'dosen', 'dosenPengampu', 'prodi'])
                ->where('lab_id', $selectedLabId)
                ->when($tahunAkademik, function($q) use ($tahunAkademik) {
                    $q->where('tahun_akademik', $tahunAkademik);
                });

            $jadwals = $query->orderBy('jam_mulai', 'asc')->get();
        }

        $dosensQuery = Dosen::with('prodi')->orderBy('nama', 'asc');
        $prodisQuery = Prodi::with('fakultas')->orderBy('nama_prodi', 'asc');
        if ($user->isAdminFakultas() && $user->fakultas_id) {
            $dosensQuery->where('id_fakultas', $user->fakultas_id);
            $prodisQuery->where('fakultas_id', $user->fakultas_id);
        }
        $dosens = $dosensQuery->get();
        $prodis = $prodisQuery->get();
        $mataKuliahs = MataKuliah::with('prodi')->orderBy('nama_mk', 'asc')->get();
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $timeSlots = [
            '08.00-09.00', '09.00-10.00', '10.00-11.00', '11.00-12.00',
            '12.00-13.00', '13.00-14.00', '14.00-15.00', '15.00-16.00',
            '16.00-17.00', '17.00-18.00', '18.00-19.00', '19.00-20.00',
            '20.00-21.00'
        ];

        return view('admin.jadwal_penggunaan_lab', compact(
            'labs', 'selectedLabId', 'tahunAkademik', 'jadwals',
            'dosens', 'prodis', 'mataKuliahs', 'kelas', 'hariList', 'timeSlots', 'fakultas'
        ));
    }

    public function exportJadwalLab(Request $request)
    {
        $user = Auth::user();
        $labId = $request->get('lab_id');
        $tahunAkademik = $request->get('tahun_akademik', '2026/2027 Ganjil');

        $allowedLabs = Laboratorium::forUser($user)->get();
        if ($allowedLabs->isEmpty()) {
            return back()->withErrors(['msg' => 'Fakultas Anda belum memiliki laboratorium untuk diekspor jadwalnya.']);
        }

        if (!$labId || !$allowedLabs->contains('id', $labId)) {
            $labId = $allowedLabs->first()->id;
        }

        $lab = Laboratorium::findOrFail($labId);
        if (!$user->canManageLab($lab)) {
            abort(403, 'Anda tidak memiliki akses untuk mengekspor jadwal laboratorium ini.');
        }

        $export = new JadwalLabExport($labId, $tahunAkademik);
        return $export->download();
    }

    public function importJadwalLab(Request $request)
    {
        $fileKey = $request->hasFile('file') ? 'file' : 'file_excel';

        $request->validate([
            $fileKey => 'required|file|mimes:xlsx,xls|max:10240',
            'lab_id' => 'nullable|exists:laboratorium,id',
            'tahun_akademik' => 'nullable|string|max:50',
            'mode' => 'nullable|in:replace,append',
        ], [
            "{$fileKey}.required" => 'Silakan pilih berkas Excel jadwal yang valid.',
            "{$fileKey}.mimes" => 'Berkas harus berformat spreadsheet .xlsx atau .xls.',
            "{$fileKey}.max" => 'Ukuran berkas maksimal adalah 10 MB.',
        ]);

        $user = Auth::user();
        $file = $request->file($fileKey);
        $explicitLabId = $request->filled('lab_id') ? (int)$request->lab_id : null;
        $explicitTahunAkademik = $request->tahun_akademik;
        $mode = $request->get('mode', 'replace');

        try {
            $importer = new JadwalLabImport();
            $result = $importer->import(
                $file,
                $explicitLabId,
                $explicitTahunAkademik,
                $mode,
                $user
            );

            return back()->with('success', "Berhasil mengimpor {$result['count']} sesi jadwal perkuliahan untuk {$result['lab_name']} ({$result['tahun_akademik']})!");
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Gagal mengimpor jadwal: ' . $e->getMessage()]);
        }
    }

    public function storeJadwalPenggunaanLab(Request $request)
    {
        $user = Auth::user();

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

        $lab = Laboratorium::findOrFail($request->lab_id);
        if (!$user->canManageLab($lab)) {
            abort(403, 'Anda tidak memiliki akses ke laboratorium ini.');
        }

        $dosenPengampuId = $request->dosen_pengampu_id ?: $request->dosen_id;

        JadwalPenggunaanLab::create([
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->mata_kuliah,
            'dosen_id' => $request->dosen_id,
            'dosen_pengampu_id' => $dosenPengampuId,
            'id_prodi' => $request->id_prodi,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas' => $request->kelas ?? 'A',
            'semester' => $request->semester ?? '1',
            'program_kuliah' => $request->program_kuliah ?? 'Reguler',
            'tahun_akademik' => $request->tahun_akademik ?? '2026/2027 Ganjil',
            'is_aktif' => true,
        ]);

        return back()->with('success', 'Jadwal Penggunaan Lab berhasil ditambahkan.');
    }

    public function updateJadwalPenggunaanLab(Request $request, $id)
    {
        $user = Auth::user();
        $jadwal = JadwalPenggunaanLab::with('lab')->findOrFail($id);

        if (!$user->canManageLab($jadwal->lab)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah jadwal laboratorium ini.');
        }

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

        $newLab = Laboratorium::findOrFail($request->lab_id);
        if (!$user->canManageLab($newLab)) {
            abort(403, 'Anda tidak memiliki akses ke laboratorium target.');
        }

        $dosenPengampuId = $request->dosen_pengampu_id ?: $request->dosen_id;

        $jadwal->update([
            'lab_id' => $request->lab_id,
            'mata_kuliah' => $request->mata_kuliah,
            'dosen_id' => $request->dosen_id,
            'dosen_pengampu_id' => $dosenPengampuId,
            'id_prodi' => $request->id_prodi,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kelas' => $request->kelas ?? 'A',
            'semester' => $request->semester ?? '1',
            'program_kuliah' => $request->program_kuliah ?? 'Reguler',
            'tahun_akademik' => $request->tahun_akademik ?? '2026/2027 Ganjil',
        ]);

        // Cascade sync updates to associated Agenda sessions
        Agenda::where('jadwal_penggunaan_lab_id', $jadwal->id)
            ->where('status_agenda', '!=', 'Selesai')
            ->update([
                'lab_id' => $request->lab_id,
                'mata_kuliah' => $request->mata_kuliah,
                'dosen_id' => $request->dosen_id,
                'dosen_pengampu_id' => $dosenPengampuId,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'kelas' => $request->kelas ?? 'A',
                'semester' => $request->semester ?? '1',
                'program_kuliah' => $request->program_kuliah ?? 'Reguler',
            ]);

        return back()->with('success', 'Jadwal Penggunaan Lab berhasil diperbarui dan sesi agenda terkait telah disinkronkan.');
    }

    public function deleteJadwalPenggunaanLab($id)
    {
        $user = Auth::user();
        $jadwal = JadwalPenggunaanLab::with('lab')->findOrFail($id);

        if (!$user->canManageLab($jadwal->lab)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus jadwal laboratorium ini.');
        }

        $jadwal->delete();
        return redirect()->back()->with('success', 'Slot jadwal berhasil dihapus.');
    }

    public function bulkDeleteJadwalLab(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada jadwal yang dipilih untuk dihapus.');
        }

        $user = Auth::user();
        $jadwals = JadwalPenggunaanLab::with('lab')->whereIn('id', $ids)->get();

        foreach ($jadwals as $jadwal) {
            if (!$user->canManageLab($jadwal->lab)) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus beberapa jadwal laboratorium ini.');
            }
        }

        JadwalPenggunaanLab::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', count($ids) . ' slot jadwal berhasil dihapus.');
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
                        'dosen_pengampu_id' => $jadwal->dosen_pengampu_id ?: $jadwal->dosen_id,
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

}


