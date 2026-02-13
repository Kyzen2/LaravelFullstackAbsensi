<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $fillable = ['nama_lokasi', 'latitude', 'longitude', 'radius'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
