<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('admin.mapel.index', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mapel,nama_mapel',
        ]);

        Mapel::create($request->all());

        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mapel,nama_mapel,' . $mapel->id,
        ]);

        $mapel->update($request->all());

        return back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel)
    {
        // Cek dulu apakah mapel ini dipake di jadwal
        if ($mapel->jadwals()->exists()) {
            return back()->with('error', 'Gagal hapus! Mapel ini sedang digunakan dalam jadwal pelajaran.');
        }

        $mapel->delete();
        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
