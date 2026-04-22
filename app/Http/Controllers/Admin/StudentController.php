<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $students = Siswa::with(['user', 'anggotaKelas.kelas'])
            ->whereHas('user', function($q) use ($search) {
                if ($search) $q->where('name', 'like', "%{$search}%");
            })
            ->orWhere('nisn', 'like', "%{$search}%")
            ->latest()
            ->paginate(15);

        return view('admin.students.index', compact('students', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswa,nisn',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // 1. Buat Akun User
        $user = User::create([
            'name' => $request->name,
            'serial_number' => $request->nisn, // NISN jadi login ID
            'email' => $request->email,
            'role' => 'siswa',
            'password' => bcrypt($request->password),
            'point_balance' => 100, // Modal awal 100 poin bro biar seneng
        ]);

        // 2. Buat Profil Siswa
        Siswa::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
        ]);

        return back()->with('success', 'Siswa baru berhasil ditambahkan!');
    }

    public function update(Request $request, Siswa $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswa,nisn,' . $student->id,
            'email' => 'nullable|email|unique:users,email,' . $student->user_id,
        ]);

        $student->user->update([
            'name' => $request->name,
            'serial_number' => $request->nisn,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $student->user->update(['password' => bcrypt($request->password)]);
        }

        $student->update(['nisn' => $request->nisn]);

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $student)
    {
        // Hapus Usernya (Siswa bakal kehapus otomatis kalau pake Cascade di migration)
        $student->user->delete();
        return back()->with('success', 'Siswa berhasil dihapus dari sistem.');
    }

    public function adjustPoints(Request $request, Siswa $student)
    {
        $request->validate([
            'amount' => 'required|integer',
            'description' => 'required|string|max:255',
        ]);

        $user = $student->user;
        $user->point_balance += $request->amount;
        $user->save();

        // Catat di Ledger sebagai "EARN" atau "PENALTY" biar sesuai ENUM database
        \App\Models\PointLedger::create([
            'user_id' => $user->id,
            'transaction_type' => $request->amount >= 0 ? 'EARN' : 'PENALTY',
            'amount' => $request->amount,
            'current_balance' => $user->point_balance,
            'description' => "MANUAL ADJUSTMENT: " . $request->description,
        ]);

        return back()->with('success', "Poin {$user->name} berhasil disesuaikan (" . ($request->amount >= 0 ? '+' : '') . $request->amount . ").");
    }
}
