<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\WeeklyTracking;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $program = $user->trainingProgram;

        $currentWeek = $program->weeklyTrackings()
            ->where('week_number', $program->current_week)
            ->first();

        $pendingFeedback = $program->feedbackSessions()
            ->where('trainee_ack', false)
            ->orderByDesc('session_date')
            ->get();

        $lastWeeks = WeeklyTracking::where('program_id', $program->id)
            ->orderByDesc('week_number')
            ->take(8)
            ->get()
            ->reverse()
            ->values();

        $chartData = [
            'labels'       => $lastWeeks->map(fn($w) => "Sem {$w->week_number}"),
            'interactions' => $lastWeeks->pluck('actual_interactions'),
            'rituals_pct'  => $lastWeeks->map(function ($w) {
                if ($w->rituals_target === 0) return 0;
                return round(($w->rituals_completed / $w->rituals_target) * 100, 1);
            }),
        ];

        $daysToCutoff = (int) Carbon::now()->diffInDays(
            Carbon::now()->endOfWeek(),
            false
        );

        return view('trainee.dashboard', compact(
            'user',
            'program',
            'currentWeek',
            'pendingFeedback',
            'chartData',
            'daysToCutoff'
        ));
    }
}
