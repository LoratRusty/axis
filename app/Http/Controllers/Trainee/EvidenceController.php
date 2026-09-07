<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Evidence;
use App\Models\Ritual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    public function index()
    {
        $program = auth()->user()->trainingProgram;

        $evidences = $program->evidences()
            ->with('ritual')
            ->latest()
            ->paginate(10);

        return view('trainee.evidences.index', compact('evidences'));
    }

    public function create()
    {
        $program = auth()->user()->trainingProgram;

        $rituals = Ritual::byPhase($program->current_stage)
            ->active()
            ->orderBy('number')
            ->get();

        return view('trainee.evidences.create', compact('rituals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ritual_id'   => 'required|exists:rituals,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'file'        => 'nullable|file|max:51200',
            'external_url' => 'nullable|url'
        ]);

        $program = auth()->user()->trainingProgram;
        $week = $program->weeklyTrackings()
            ->where('week_number', $program->current_week)
            ->first();

        if (!$week) {
            return back()->with('error', 'No hay semana activa.');
        }

        $filePath = null;
        $fileUrl  = null;
        $fileName = null;
        $fileMime = null;
        $fileSize = null;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filePath = $file->store('evidences', 'public');
            $fileUrl  = Storage::url($filePath);
            $fileName = $file->getClientOriginalName();
            $fileMime = $file->getMimeType();
            $fileSize = round($file->getSize() / 1024);
        }

        Evidence::create([
            'program_id'         => $program->id,
            'weekly_tracking_id' => $week->id,
            'ritual_id'          => $request->ritual_id,
            'uploaded_by'        => auth()->id(),
            'title'              => $request->title,
            'description'        => $request->description,
            'evidence_type'      => $request->hasFile('file') ? 'document' : 'url',
            'file_path'          => $filePath,
            'file_url'           => $fileUrl,
            'external_url'       => $request->external_url,
            'file_name'          => $fileName,
            'file_mime'          => $fileMime,
            'file_size_kb'       => $fileSize,
            'status'             => 'pending_review',
        ]);

        return redirect()
            ->route('trainee.evidencias.index')
            ->with('success', 'Evidencia cargada correctamente.');
    }

    public function show(Evidence $evidencia)
    {
        if ($evidencia->uploaded_by !== auth()->id()) {
            abort(403);
        }

        return view('trainee.evidences.show', compact('evidencia'));
    }

    public function destroy(Evidence $evidencia)
    {
        if ($evidencia->uploaded_by !== auth()->id()) {
            abort(403);
        }

        $evidencia->delete();

        return back()->with('success', 'Evidencia eliminada.');
    }
}
