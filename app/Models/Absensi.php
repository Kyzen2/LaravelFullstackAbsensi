<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = [
        'sesi_id', 'siswa_id', 'waktu_scan', 
        'status', 'is_valid', 'lat_siswa', 'long_siswa'
    ];

    public function sesi()
    {
        return $this->belongsTo(SesiPresensi::class, 'sesi_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
