<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pengumuman;

class DigitalBoardController extends Controller
{
    public function index($lab_id = null)
    {
        if (!$lab_id && request()->has('lab_id')) {
            $lab_id = request('lab_id');
        }

        if (!$lab_id) {
            $labs = \App\Models\Laboratorium::orderBy('nama_lab')->get();
            return view('board_portal', compact('labs'));
        }

        $activeLab = \App\Models\Laboratorium::findOrFail($lab_id);

        $agendas = Agenda::with(['dosen.user', 'lab'])
            ->where('lab_id', $lab_id)
            ->whereDate('tanggal', today())
            ->orderBy('jam_mulai')
            ->get();

        $pengumuman = Pengumuman::orderByDesc('created_at')->limit(5)->get();

        if (request()->ajax()) {
            $html = view('welcome_partial', compact('agendas', 'pengumuman', 'activeLab'))->render();
            return response()->json(['html' => $html]);
        }

        return view('welcome', compact('agendas', 'pengumuman', 'activeLab'));
    }
}
