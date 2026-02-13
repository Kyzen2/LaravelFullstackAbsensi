<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiPresensi extends Model
{
    protected $table = 'sesi_presensi';
    protected $fillable = ['jadwal_id', 'tanggal', 'token_qr'];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'sesi_id');
    }
}
