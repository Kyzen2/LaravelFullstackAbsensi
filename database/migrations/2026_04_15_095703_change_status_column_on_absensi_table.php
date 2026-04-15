<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah tipe ENUM menjadi VARCHAR agar mendukung value dinamis dari Gamification ("terlambat", "hadir (token used)")
        DB::statement('ALTER TABLE absensi MODIFY status VARCHAR(255) DEFAULT "hadir"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE absensi MODIFY status ENUM('hadir', 'sakit', 'izin', 'alpa')");
    }
};
