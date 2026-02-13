<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['user_id', 'nisn', 'nama_siswa', 'devices_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anggotaKelas()
    {
        return $this->hasMany(AnggotaKelas::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function perizinan()
    {
        return $this->hasMany(Perizinan::class);
    }
}
