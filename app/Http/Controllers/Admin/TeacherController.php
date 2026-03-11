<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Menampilkan daftar guru dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $teachers = Guru::with(['user'])
            ->when($search, function($query) use ($search) {
                $query->where('nama_guru', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('admin.teachers.index', compact('teachers', 'search'));
    }

    /**
     * Menampilkan form tambah guru.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Menyimpan data guru baru ke tabel users dan guru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|unique:guru,nip',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat User sebagai identitas login
            $user = User::create([
                'name' => $request->nama_guru,
                'serial_number' => $request->nip, // NIP jadi username login
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru',
            ]);

            // 2. Buat profil Guru
            Guru::create([
                'user_id' => $user->id,
                'nama_guru' => $request->nama_guru,
                'nip' => $request->nip,
            ]);

            DB::commit();
            return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit guru.
     */
    public function edit(Guru $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Memperbarui data guru.
     */
    public function update(Request $request, Guru $teacher)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => [
                'required',
                'string',
                Rule::unique('guru', 'nip')->ignore($teacher->id),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($teacher->user_id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update data User
            $userData = [
                'name' => $request->nama_guru,
                'serial_number' => $request->nip,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $teacher->user->update($userData);

            // 2. Update data profil Guru
            $teacher->update([
                'nama_guru' => $request->nama_guru,
                'nip' => $request->nip,
            ]);

            DB::commit();
            return redirect()->route('admin.teachers.index')->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data guru beserta akun usernya.
     */
    public function destroy(Guru $teacher)
    {
        try {
            DB::beginTransaction();
            
            // Hapus user (maka profil guru akan terhapus karena on cascade delete)
            $teacher->user->delete();

            DB::commit();
            return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }
}
