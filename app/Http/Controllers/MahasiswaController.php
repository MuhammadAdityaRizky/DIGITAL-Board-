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
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->route('login')->withErrors(['msg' => 'Data profil Mahasiswa tidak ditemukan.']);
        }

        $today = date('Y-m-d');
        $todayAgendas = Agenda::with(['dosen.user', 'lab', 'absensi' => function($q) use ($mahasiswa) {
            $q->where('mahasiswa_id', $mahasiswa->id);
        }])
        ->where('tanggal', $today)
        ->orderBy('waktu_masuk', 'asc')
        ->get();

        $absensiHistory = Absensi::with(['agenda.dosen.user', 'agenda.lab'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('waktu_kehadiran', 'desc')
            ->get();

        $pengumuman = Pengumuman::with('admin')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.dashboard', compact('mahasiswa', 'todayAgendas', 'absensiHistory', 'pengumuman'));
    }

    public function submitAttendance(Request $request)
    {
        $request->validate([
            'qr_code_token' => 'required|string',
        ]);

        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        $agenda = Agenda::where('qr_code_token', trim($request->qr_code_token))->first();

        if (!$agenda) {
            return back()->withErrors(['qr_code_token' => 'Token QR tidak valid / agenda tidak ditemukan.']);
        }

        $existing = Absensi::where('agenda_id', $agenda->id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        if ($existing) {
            return back()->with('info', 'Anda sudah melakukan absensi untuk agenda ini!');
        }

        Absensi::create([
            'agenda_id' => $agenda->id,
            'mahasiswa_id' => $mahasiswa->id,
            'waktu_kehadiran' => now(),
            'status' => 'Hadir',
        ]);

        return back()->with('success', 'Absensi BERHASIL dicatat untuk: ' . $agenda->judul_agenda);
    }
}
