<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['tahunAjaran', 'waliKelas.user'])->get();
        $tahunAjarans = TahunAjaran::all();
        $gurus = Guru::with('user')->get();
        
        return view('admin.kelas.index', compact('kelas', 'tahunAjarans', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'wali_kelas_id' => 'required|exists:guru,id|unique:kelas,wali_kelas_id',
        ]);

        Kelas::create($request->all());

        return back()->with('success', 'Kelas berhasil dibuat.');
    }

    public function show(Kelas $kela)
    {
        // $kela adalah instance model Kelas
        $kelas = $kela->load(['tahunAjaran', 'waliKelas.user', 'anggotaKelas.siswa.user']);
        
        // Cari siswa yang BELUM masuk kelas ini di tahun ajaran ini
        $availableStudents = Siswa::with('user')
            ->whereDoesntHave('anggotaKelas', function($q) use ($kelas) {
                $q->where('kelas_id', $kelas->id);
            })->get();

        return view('admin.kelas.show', compact('kelas', 'availableStudents'));
    }

    public function addStudent(Request $request, Kelas $kelas)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
        ]);

        // Cek apakah siswa sudah ada di kelas ini
        $exists = AnggotaKelas::where('kelas_id', $kelas->id)
            ->where('siswa_id', $request->siswa_id)
            ->exists();

        if (!$exists) {
            AnggotaKelas::create([
                'kelas_id' => $kelas->id,
                'siswa_id' => $request->siswa_id
            ]);
            return back()->with('success', 'Siswa berhasil ditambahkan ke kelas.');
        }

        return back()->with('error', 'Siswa sudah terdaftar di kelas ini.');
    }

    public function removeStudent(Kelas $kelas, Siswa $siswa)
    {
        AnggotaKelas::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->delete();

        return back()->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}
