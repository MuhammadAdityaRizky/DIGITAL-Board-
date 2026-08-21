<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Agenda;
use App\Models\Mahasiswa;
use App\Models\Absensi;
use App\Models\Perizinan;
use Carbon\Carbon;

class AutoAlphaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Disable during command line execution
        if (app()->runningInConsole()) {
            return $next($request);
        }

        try {
            $today = Carbon::today()->format('Y-m-d');
            $nowPlusTen = Carbon::now()->addMinutes(10)->format('H:i:s');

            // Automatic clean up: Delete agendas older than 2 semesters (1 year / 365 days)
            $oldAgendaIds = Agenda::where('tanggal', '<', Carbon::now()->subDays(365)->format('Y-m-d'))->pluck('id');
            if ($oldAgendaIds->isNotEmpty()) {
                Absensi::whereIn('agenda_id', $oldAgendaIds)->delete();
                Perizinan::whereIn('agenda_id', $oldAgendaIds)->delete();
                Agenda::whereIn('id', $oldAgendaIds)->delete();
            }

            // Find all unprocessed agendas that:
            // 1. Tanggal is in the past, OR
            // 2. Tanggal is today and jam_selesai <= now + 10 minutes (which is 10 minutes before class ends)
            $unprocessed = Agenda::where('auto_alpha_processed', 0)
                ->where(function ($query) use ($today, $nowPlusTen) {
                    $query->where('tanggal', '<', $today)
                          ->orWhere(function ($q) use ($today, $nowPlusTen) {
                              $q->where('tanggal', $today)
                                ->where('jam_selesai', '<=', $nowPlusTen);
                          });
                })
                ->get();

            foreach ($unprocessed as $agenda) {
                // Get all students matching this class's Fakultas, Prodi/Jurusan, and Kelas
                $students = Mahasiswa::where('kelas', $agenda->kelas)
                    ->whereHas('fakultas', function($q) use ($agenda) {
                        $q->where('nama_fakultas', $agenda->fakultas);
                    })
                    ->whereHas('prodi', function($q) use ($agenda) {
                        $q->where('nama_prodi', $agenda->jurusan);
                    })
                    ->get();

                foreach ($students as $student) {
                    // Check if they already have an absensi record
                    $exists = Absensi::where('agenda_id', $agenda->id)
                        ->where('mahasiswa_id', $student->id)
                        ->exists();

                    if (!$exists) {
                        // Check if they have an approved permission request
                        $approvedIzin = Perizinan::where('agenda_id', $agenda->id)
                            ->where('mahasiswa_id', $student->id)
                            ->where('status_persetujuan', 'disetujui')
                            ->first();

                        $status = 'Alpa';
                        if ($approvedIzin) {
                            $status = $approvedIzin->kategori === 'Sakit' ? 'Sakit' : 'Izin';
                        }

                        Absensi::create([
                            'agenda_id' => $agenda->id,
                            'mahasiswa_id' => $student->id,
                            'waktu_masuk' => $agenda->tanggal . ' ' . $agenda->jam_selesai,
                            'status_kehadiran' => $status,
                        ]);
                    }
                }

                // Mark as processed
                $agenda->update(['auto_alpha_processed' => 1]);
            }
        } catch (\Exception $e) {
            // Log or ignore to prevent breaking the web application if a database issue occurs
            logger()->error('AutoAlphaMiddleware error: ' . $e->getMessage());
        }

        return $next($request);
    }
}
