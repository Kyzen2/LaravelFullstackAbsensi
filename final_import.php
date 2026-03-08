<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$targetClass = "XII PPLG-RPL 2";

$ta = TahunAjaran::where('status', true)->first();
if (!$ta) {
    $ta = TahunAjaran::create([
        'tahun' => '2025/2026',
        'semester' => 'Ganjil',
        'status' => true,
    ]);
}

$kelas = Kelas::firstOrCreate(
    ['nama_kelas' => $targetClass],
    ['tahun_ajaran_id' => $ta->id]
);

$students = [
    ["nama" => "Ahmad Zidan", "nisn" => "0072140056"],
    ["nama" => "AIRIL JAHRAN", "nisn" => "0085689927"],
    ["nama" => "AMIR HANAFI SIREGAR", "nisn" => "0082055196"],
    ["nama" => "ANFERNEE RASHAD HERDIAN", "nisn" => "0076799826"],
    ["nama" => "ANNISA AULIA FIRDAUS", "nisn" => "0082821168"],
    ["nama" => "BILQISTY JAZILA RIZKI", "nisn" => "3089020262"],
    ["nama" => "Dimas Atha Fathurizqi", "nisn" => "3082067551"],
    ["nama" => "EGI NOVIANI SAPUTRA", "nisn" => "0083183761"],
    ["nama" => "Fahri Rasyid Hidayat", "nisn" => "0072825471"],
    ["nama" => "FAHRY RAFZAN SATRIANI", "nisn" => "0089561178"],
    ["nama" => "INSSAN MUNAZAT ZARAHAN", "nisn" => "0086238213"],
    ["nama" => "M RIHHADATUL AISY N", "nisn" => "0086910814"],
    ["nama" => "M. NABIL DZIKRIKA RAMDANI", "nisn" => "0078475186"],
    ["nama" => "MOCH DAFA SYAFA FADILAH", "nisn" => "0078684714"],
    ["nama" => "Muh Zidan Al Rajib", "nisn" => "0079638321"],
    ["nama" => "MUHAMAD ANDIKA DZULFADILLAH", "nisn" => "0071289789"],
    ["nama" => "MUHAMAD NABIL MU'AFA", "nisn" => "0067941572"],
    ["nama" => "MUHAMAD NABIL NUR PRAJA", "nisn" => "0081047470"],
    ["nama" => "MUHAMMAD ALDIANSYAH PUTRA", "nisn" => "0082172367"],
    ["nama" => "MUHAMMAD ARGHA ARINDRA", "nisn" => "0089849289"],
    ["nama" => "MUHAMMAD AZHAR RIZQILLAH", "nisn" => "0083380307"],
    ["nama" => "MUHAMMAD RIQZAN RAMADHAN", "nisn" => "0077223396"],
    ["nama" => "MUHAMMAD RIZKY FEBRIAN", "nisn" => "0082442383"],
    ["nama" => "Nuno Erlangga", "nisn" => "0072448474"],
    ["nama" => "Rifki Muhammad Fadhil", "nisn" => "3075754655"],
    ["nama" => "RIVALDY ALFRIAN", "nisn" => "0073999807"],
    ["nama" => "RIYANTO", "nisn" => "0081218304"],
    ["nama" => "Robyansyah Saputra", "nisn" => "3076951495"],
    ["nama" => "SANIA EKA WARDAH", "nisn" => "3085596388"],
    ["nama" => "Shalwa Ainnur Hafidzin", "nisn" => "0073340484"],
    ["nama" => "SHAQILLA SALSABILA", "nisn" => "0072188492"],
    ["nama" => "SUBHANUL ARIFIN", "nisn" => "0089829406"],
    ["nama" => "TURKY KHALID WALIDAT", "nisn" => "0081506973"],
    ["nama" => "WENDY HARYADI", "nisn" => "0077635739"],
];

$count = 0;
foreach ($students as $student) {
    DB::transaction(function () use ($student, $kelas, &$count) {
        $user = User::updateOrCreate(
            ['serial_number' => $student['nisn']],
            [
                'name' => $student['nama'],
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );

        $siswa = Siswa::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nisn' => $student['nisn'],
                'nama_siswa' => $student['nama'],
            ]
        );

        AnggotaKelas::updateOrCreate(
            ['siswa_id' => $siswa->id, 'kelas_id' => $kelas->id]
        );
        $count++;
    });
}

file_put_contents('final_import_result.txt', "IMPORTED: $count | TOTAL IN DB: " . Siswa::count());
echo "DONE. IMPORTED $count STUDENTS.";
