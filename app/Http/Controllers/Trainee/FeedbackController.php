<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\FeedbackSession;

class FeedbackController extends Controller
{
    public function index()
    {
        $program = auth()->user()->trainingProgram;

        $feedbacks = $program->feedbackSessions()
            ->orderByDesc('session_date')
            ->paginate(10);

        return view('trainee.feedback.index', compact('feedbacks'));
    }

    public function show(FeedbackSession $feedback)
    {
        if ($feedback->program_id !== auth()->user()->trainingProgram->id) {
            abort(403);
        }

        return view('trainee.feedback.show', compact('feedback'));
    }

    public function acknowledge(FeedbackSession $feedback)
    {
        if ($feedback->program_id !== auth()->user()->trainingProgram->id) {
            abort(403);
        }

        $feedback->acknowledge();

        return redirect()
            ->route('trainee.feedback.index')
            ->with('success', 'Feedback marcado como leído.');
    }
}