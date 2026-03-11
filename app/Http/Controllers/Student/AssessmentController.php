<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Ambil penilaian terbaru untuk user ini
        $latestAssessment = Assessment::with(['details.category', 'evaluator'])
            ->where('evaluatee_id', $userId)
            ->latest()
            ->first();

        // Ambil riwayat penilaian (History timeline)
        $history = Assessment::with(['evaluator'])
            ->where('evaluatee_id', $userId)
            ->orderBy('assessment_date', 'desc')
            ->get();

        // Siapkan data untuk Radar Chart (jika ada nilai)
        $chartData = null;
        if ($latestAssessment && $latestAssessment->details->count() > 0) {
            $labels = [];
            $scores = [];
            foreach ($latestAssessment->details as $detail) {
                $labels[] = $detail->category->name;
                $scores[] = (float)$detail->score;
            }
            $chartData = [
                'labels' => $labels,
                'scores' => $scores
            ];
        }

        return view('student.assessments.index', compact('latestAssessment', 'history', 'chartData'));
    }
}
