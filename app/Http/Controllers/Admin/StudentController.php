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
            ->when($search, function($query) use ($search) {
                $query->where('nama_siswa', 'like', "%{$search}%")
                      ->orWhere('nisn', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('admin.students.index', compact('students', 'search'));
    }
}
