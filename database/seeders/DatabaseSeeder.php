<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Lokasi;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\AnggotaKelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin
        User::create([
            'serial_number' => 'admin',
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Tahun Ajaran
        $ta = TahunAjaran::create([
            'tahun' => '2025/2026',
            'semester' => 'Ganjil',
            'status' => true,
        ]);

        // 3. Lokasi
        $lokasi = Lokasi::create([
            'nama_lokasi' => 'Lab RPL',
            'latitude' => -6.175392, // Example Jakarta coords
            'longitude' => 106.827153,
            'radius' => 50,
        ]);

        // 4. Guru
        $userGuru = User::create([
            'serial_number' => '123456',
            'name' => 'Budi Guru',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);
        $guru = Guru::create([
            'user_id' => $userGuru->id,
            'nama_guru' => 'Budi M.Kom',
            'nip' => '123456',
        ]);

        // 5. Kelas
        $kelas = Kelas::create([
            'nama_kelas' => '12 PPLG 2',
            'tahun_ajaran_id' => $ta->id,
            'wali_kelas_id' => $guru->id,
        ]);

        // 6. Siswa
        $userSiswa = User::create([
            'serial_number' => '223344',
            'name' => 'Andi Siswa',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
        $siswa = Siswa::create([
            'user_id' => $userSiswa->id,
            'nisn' => '223344',
            'nama_siswa' => 'Andi Pratama',
            'devices_id' => 'device_123',
        ]);

        // 7. Anggota Kelas
        AnggotaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $kelas->id,
        ]);

        // 8. Mapel
        $mapel = Mapel::create([
            'nama_mapel' => 'Pemrograman Web',
        ]);

        // 9. Jadwal
        Jadwal::create([
            'kelas_id' => $kelas->id,
            'mapel_id' => $mapel->id,
            'guru_id' => $guru->id,
            'lokasi_id' => $lokasi->id,
            'hari' => 'Senin',
            'jam_mulai' => '07:00:00',
            'jam_selesai' => '09:00:00',
        ]);
    }
}
