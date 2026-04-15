<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jalankan Auto-ALPA setiap jam (cek jadwal yang sudah lewat, tandai siswa yang bolos)
Schedule::command('attendance:mark-absent')->hourly();
