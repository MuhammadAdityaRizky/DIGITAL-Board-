<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pengumuman;
use App\Models\Laboratorium;
use App\Models\Fakultas;

class DigitalBoardController extends Controller
{
    public function index($lab_id = null)
    {
        if (!$lab_id && request()->has('lab_id')) {
            $lab_id = request('lab_id');
        }

        if (!$lab_id) {
            // Proteksi Akses: Hanya Administrator yang dapat memilih & mengakses Portal Kiosk Board
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Akses Terbatas: Silakan login sebagai Administrator terlebih dahulu untuk mengakses Portal Digital Board.');
            }

            if (auth()->user()->role !== 'admin') {
                return redirect()->route('login')->with('error', 'Akses Terbatas: Hanya Administrator yang berhak mengakses Portal Kiosk Monitor.');
            }

            $labs = Laboratorium::with('fakultas')->orderBy('nama_lab')->get();
            $fakultas = Fakultas::orderBy('nama_fakultas')->get();

            return view('board_portal', compact('labs', 'fakultas'));
        }

        $activeLab = Laboratorium::with('fakultas')->findOrFail($lab_id);

        $agendas = Agenda::with(['dosen.user', 'lab'])
            ->where('lab_id', $lab_id)
            ->whereDate('tanggal', today())
            ->orderBy('jam_mulai')
            ->get();

        $pengumuman = Pengumuman::where(function($q) use ($lab_id) {
            $q->whereDoesntHave('laboratoriums')
              ->orWhereHas('laboratoriums', function($lq) use ($lab_id) {
                  $lq->where('laboratorium.id', $lab_id);
              });
        })->orderByDesc('created_at')->limit(5)->get();

        if (request()->ajax()) {
            $html = view('welcome_partial', compact('agendas', 'pengumuman', 'activeLab'))->render();
            return response()->json(['html' => $html]);
        }

        return view('welcome', compact('agendas', 'pengumuman', 'activeLab'));
    }
}
