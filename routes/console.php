<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('pengumuman:clean-expired', function () {
    $count = \App\Models\Pengumuman::cleanExpiredPengumuman();
    $this->info("Berhasil membersihkan {$count} pengumuman yang telah melewati masa tenggang 24 jam.");
})->purpose('Membersihkan pengumuman yang kedaluwarsa lebih dari 24 jam');

Schedule::command('pengumuman:clean-expired')->hourly();
