<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['kelas', 'mapel', 'guru.user', 'lokasi'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
            
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $kelases = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::with('user')->get();
        $lokasis = Lokasi::all();
        
        return view('admin.jadwal.form', compact('kelases', 'mapels', 'gurus', 'lokasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'guru_id' => 'required|exists:guru,id',
            'lokasi_id' => 'nullable|exists:lokasi,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        Jadwal::create($validated);
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Kelas berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $kelases = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::with('user')->get();
        $lokasis = Lokasi::all();
        
        // Memastikan jam diformat dengan H:i untuk input type="time"
        $jadwal->jam_mulai = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
        $jadwal->jam_selesai = \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i');

        return view('admin.jadwal.form', compact('jadwal', 'kelases', 'mapels', 'gurus', 'lokasis'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapel,id',
            'guru_id' => 'required|exists:guru,id',
            'lokasi_id' => 'nullable|exists:lokasi,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal->update($validated);
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Kelas berhasil diperbarui!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Kelas berhasil dihapus!');
    }
}
