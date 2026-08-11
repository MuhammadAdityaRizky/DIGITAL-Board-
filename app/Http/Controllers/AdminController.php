<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use App\Models\Mahasiswa;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $dosenCount = Dosen::count();
        $mhsCount = Mahasiswa::count();
        $labCount = Laboratorium::count();
        $agendaCount = Agenda::count();

        $users = User::with(['dosen', 'mahasiswa'])->orderBy('created_at', 'desc')->get();
        $labs = Laboratorium::all();
        $pengumumanList = Pengumuman::with('admin')->orderBy('tanggal', 'desc')->get();

        // Dosen Teaching History for Admin View
        $dosenHistories = Agenda::with(['dosen.user', 'lab', 'absensi'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        // Mahasiswa Attendance History for Admin View
        $mahasiswaHistories = Absensi::with(['mahasiswa.user', 'agenda.dosen.user', 'agenda.lab'])
            ->orderBy('waktu_kehadiran', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'usersCount', 'dosenCount', 'mhsCount', 'labCount', 'agendaCount',
            'users', 'labs', 'pengumumanList', 'dosenHistories', 'mahasiswaHistories'
        ));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username_or_nim_nip' => 'required|string|max:50|unique:users,username_or_nim_nip',
            'password' => 'required|string|min:4',
            'role' => 'required|in:admin,dosen,mahasiswa',
        ]);

        DB::transaction(function() use ($request) {
            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username_or_nim_nip' => $request->username_or_nim_nip,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($request->role === 'dosen') {
                Dosen::create([
                    'user_id' => $user->id,
                    'nip' => $request->username_or_nim_nip,
                ]);
            } elseif ($request->role === 'mahasiswa') {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $request->username_or_nim_nip,
                ]);
            }
        });

        return back()->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'username_or_nim_nip' => 'required|string|max:50|unique:users,username_or_nim_nip,' . $id,
        ]);

        DB::transaction(function() use ($request, $user) {
            $data = [
                'nama_lengkap' => $request->nama_lengkap,
                'username_or_nim_nip' => $request->username_or_nim_nip,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            if ($user->role === 'dosen' && $user->dosen) {
                $user->dosen->update(['nip' => $request->username_or_nim_nip]);
            } elseif ($user->role === 'mahasiswa' && $user->mahasiswa) {
                $user->mahasiswa->update(['nim' => $request->username_or_nim_nip]);
            }
        });

        return back()->with('success', 'Data akun pengguna berhasil diperbarui.');
    }

    public function storeLab(Request $request)
    {
        $request->validate([
            'nama_lab' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
        ]);

        Laboratorium::create([
            'nama_lab' => $request->nama_lab,
            'lokasi' => $request->lokasi,
        ]);

        return back()->with('success', 'Laboratorium berhasil ditambahkan.');
    }

    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul_pengumuman' => 'required|string|max:150',
            'penjelasan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        Pengumuman::create([
            'admin_id' => auth()->id(),
            'judul_pengumuman' => $request->judul_pengumuman,
            'penjelasan' => $request->penjelasan,
            'tanggal' => $request->tanggal,
        ]);

        return back()->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function deletePengumuman($id)
    {
        Pengumuman::destroy($id);
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
