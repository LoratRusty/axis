<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\WeeklyTracking;

class ExpedienteController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $program = $user->trainingProgram;

        $subroles = $program->subroleAchievements()
            ->orderBy('accredited_date')
            ->get();

        $kpis = $program->kpiSnapshots()
            ->orderByDesc('snapshot_date')
            ->take(12)
            ->get()
            ->reverse()
            ->values();

        $weeks = WeeklyTracking::where('program_id', $program->id)
            ->with('evidences')
            ->orderByDesc('week_number')
            ->get();

        $rubrics = $program->evaluations()
            ->where('instrument', 'I3')
            ->with('ritual')
            ->orderBy('evaluated_at')
            ->get();

        return view('trainee.expediente.index', compact(
            'user',
            'program',
            'subroles',
            'kpis',
            'weeks',
            'rubrics'
        ));
    }
}
