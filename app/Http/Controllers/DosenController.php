<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Dosen;
use App\Models\Laboratorium;
use App\Models\Pengumuman;
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

        $agendas = Agenda::with(['lab', 'absensi.mahasiswa.user'])
            ->where('dosen_id', $dosen->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        $labs = Laboratorium::all();

        $pengumuman = Pengumuman::with('admin')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.dashboard', compact('dosen', 'agendas', 'labs', 'pengumuman'));
    }

    public function storeAgenda(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:laboratorium,id',
            'judul_agenda' => 'required|string|max:150',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'required',
            'waktu_keluar' => 'required',
            'rencana_pembelajaran' => 'required|string',
        ]);

        $dosen = Dosen::where('user_id', auth()->id())->first();

        $token = 'TOKEN_QR_' . Str::upper(Str::random(6)) . '_' . date('Ymd', strtotime($request->tanggal));

        Agenda::create([
            'dosen_id' => $dosen->id,
            'lab_id' => $request->lab_id,
            'judul_agenda' => $request->judul_agenda,
            'tanggal' => $request->tanggal,
            'waktu_masuk' => $request->waktu_masuk,
            'waktu_keluar' => $request->waktu_keluar,
            'rencana_pembelajaran' => $request->rencana_pembelajaran,
            'qr_code_token' => $token,
        ]);

        return back()->with('success', 'Agenda pembelajaran & Token QR berhasil dibuat.');
    }

    public function updateRealisasi(Request $request, $id)
    {
        $request->validate([
            'realisasi_pembelajaran' => 'required|string',
        ]);

        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'realisasi_pembelajaran' => $request->realisasi_pembelajaran,
        ]);

        return back()->with('success', 'Realisasi pembelajaran berhasil diperbarui.');
    }

    public function generateNewQrToken($id)
    {
        $agenda = Agenda::findOrFail($id);
        $token = 'TOKEN_QR_' . Str::upper(Str::random(6)) . '_' . date('Ymd');
        $agenda->update(['qr_code_token' => $token]);

        return back()->with('success', 'Token QR baru berhasil dibuat: ' . $token);
    }
}
