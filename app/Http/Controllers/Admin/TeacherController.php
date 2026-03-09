<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
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
}
