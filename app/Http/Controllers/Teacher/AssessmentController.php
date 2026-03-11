<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\AssessmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    /**
     * Dashboard Penilaian (Halaman Utama Guru)
     */
    public function index()
    {
        $evaluatorId = Auth::id();
        $period = date('F Y'); // Contoh Periode: March 2026
        
        // Ambil semua siswa (Bisa difilter per kelas jika perlu)
        // Untuk sekarang, ambil semua siswa agar guru bisa menilai siapa saja
        $students = Siswa::with(['user'])->orderBy('nama_siswa')->get();
        
        // Cek siapa saja yang sudah dinilai periode ini oleh guru ini
        $evaluatedIds = Assessment::where('evaluator_id', $evaluatorId)
            ->where('period', $period)
            ->pluck('evaluatee_id')
            ->toArray();

        $totalStudents = count($students);
        $totalEvaluated = count($evaluatedIds);
        $progress = $totalStudents > 0 ? ($totalEvaluated / $totalStudents) * 100 : 0;

        return view('teacher.assessments.index', compact(
            'students', 
            'evaluatedIds', 
            'totalStudents', 
            'totalEvaluated', 
            'progress',
            'period'
        ));
    }

    /**
     * Menampilkan Form Penilaian (Modal Pop-up atau Halaman Baru)
     */
    public function create(User $studentUser)
    {
        $categories = AssessmentCategory::where('is_active', true)->get();
        $period = date('F Y');

        return view('teacher.assessments.create', compact('studentUser', 'categories', 'period'));
    }

    /**
     * Menyimpan hasil penilaian
     */
    public function store(Request $request)
    {
        $request->validate([
            'evaluatee_id' => 'required|exists:users,id',
            'period' => 'required|string',
            'scores' => 'required|array',
            'general_notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $assessment = Assessment::updateOrCreate(
                [
                    'evaluator_id' => Auth::id(),
                    'evaluatee_id' => $request->evaluatee_id,
                    'period' => $request->period,
                ],
                [
                    'assessment_date' => now(),
                    'general_notes' => $request->general_notes,
                ]
            );

            // Simpan atau update detail nilai
            foreach ($request->scores as $categoryId => $score) {
                AssessmentDetail::updateOrCreate(
                    [
                        'assessment_id' => $assessment->id,
                        'category_id' => $categoryId,
                    ],
                    ['score' => $score]
                );
            }

            DB::commit();

            if ($request->action === 'save_next') {
                // Cari siswa berikutnya yang belum dinilai periode ini
                $evaluatorId = Auth::id();
                $period = $request->period;
                
                $evaluatedIds = Assessment::where('evaluator_id', $evaluatorId)
                    ->where('period', $period)
                    ->pluck('evaluatee_id')
                    ->toArray();

                $nextStudent = Siswa::whereNotIn('user_id', $evaluatedIds)
                    ->where('user_id', '!=', $request->evaluatee_id)
                    ->orderBy('nama_siswa')
                    ->first();

                if ($nextStudent) {
                    return redirect()->route('teacher.assessments.create', $nextStudent->user_id)
                        ->with('success', 'Penilaian berhasil disimpan. Lanjut ke ' . $nextStudent->nama_siswa);
                }
            }

            return redirect()->route('teacher.assessments.index')->with('success', 'Penilaian berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan nilai: ' . $e->getMessage());
        }
    }
}
