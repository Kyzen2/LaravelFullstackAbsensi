<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderBy('id', 'desc')->get();
        return view('admin.tahun-ajaran.index', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        TahunAjaran::create($request->all());

        return back()->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'tahun' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|boolean',
        ]);

        // Jika status diset True (Aktif), matikan status tahun ajaran lainnya
        if ($request->status) {
            TahunAjaran::where('id', '!=', $tahunAjaran->id)->update(['status' => false]);
        }

        $tahunAjaran->update($request->all());

        return back()->with('success', 'Data Tahun Ajaran berhasil diupdate.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return back()->with('success', 'Tahun Ajaran berhasil dihapus.');
    }
}
