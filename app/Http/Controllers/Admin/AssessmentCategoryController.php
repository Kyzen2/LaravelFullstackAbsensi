<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentCategory;
use Illuminate\Http\Request;

class AssessmentCategoryController extends Controller
{
    public function index()
    {
        $categories = AssessmentCategory::latest()->paginate(15);
        return view('admin.assessment-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.assessment-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        AssessmentCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'is_active' => true,
        ]);

        return redirect()->route('admin.assessment-categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit(AssessmentCategory $assessmentCategory)
    {
        return view('admin.assessment-categories.edit', compact('assessmentCategory'));
    }

    public function update(Request $request, AssessmentCategory $assessmentCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $assessmentCategory->update($request->all());

        return redirect()->route('admin.assessment-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(AssessmentCategory $assessmentCategory)
    {
        $assessmentCategory->delete();
        return redirect()->route('admin.assessment-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
