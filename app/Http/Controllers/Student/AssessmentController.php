<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Tampilan Laporan Penilaian untuk Siswa
     */
    /**
     * Tampilan Laporan Penilaian untuk Siswa
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $selectedMonth = $request->get('month');
        $selectedYear = $request->get('year', date('Y'));

        // 1. Ambil Semua Tahun & Bulan yang ada datanya untuk Filter
        $availableYears = Assessment::where('evaluatee_id', $userId)
            ->selectRaw('YEAR(assessment_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // 2. Ambil riwayat penilaian (History timeline)
        $historyQuery = Assessment::with(['evaluator'])
            ->where('evaluatee_id', $userId);
        
        if ($selectedMonth) {
            $historyQuery->whereMonth('assessment_date', $selectedMonth);
        }
        if ($selectedYear) {
            $historyQuery->whereYear('assessment_date', $selectedYear);
        }

        $history = $historyQuery->orderBy('assessment_date', 'desc')->get();

        // 3. Hitung Nilai Rata-rata per Kategori (Aggregat)
        // Jika difilter, maka rata-rata hanya untuk periode tersebut
        $overallStatsQuery = \App\Models\AssessmentDetail::join('assessments', 'assessment_details.assessment_id', '=', 'assessments.id')
            ->join('assessment_categories', 'assessment_details.category_id', '=', 'assessment_categories.id')
            ->where('assessments.evaluatee_id', $userId);

        if ($selectedMonth) {
            $overallStatsQuery->whereMonth('assessments.assessment_date', $selectedMonth);
        }
        if ($selectedYear) {
            $overallStatsQuery->whereYear('assessments.assessment_date', $selectedYear);
        }

        $overallStats = $overallStatsQuery->select('assessment_categories.name', \DB::raw('AVG(assessment_details.score) as average_score'))
            ->groupBy('assessment_categories.id', 'assessment_categories.name')
            ->get();

        $chartData = null;
        if ($overallStats->count() > 0) {
            $chartData = [
                'labels' => $overallStats->pluck('name')->toArray(),
                'scores' => $overallStats->pluck('average_score')->map(function($score) {
                    return (float) number_format($score, 2);
                })->toArray()
            ];
        }

        // 4. Detail penilaian spesifik (untuk Feedback)
        $selectedId = $request->get('assessment_id');
        if ($selectedId) {
            $latestAssessment = Assessment::with(['details.category', 'evaluator'])
                ->where('evaluatee_id', $userId)
                ->find($selectedId);
        } else {
            // Jika ada filter, ambil yang terbaru dari hasil filter
            $latestAssessment = $history->first();
        }

        return view('student.assessments.index', compact(
            'latestAssessment', 
            'history', 
            'chartData', 
            'availableYears', 
            'selectedMonth', 
            'selectedYear'
        ));
    }
}
