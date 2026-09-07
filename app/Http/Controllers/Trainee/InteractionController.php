<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\FieldInteraction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function index()
    {
        $program = auth()->user()->trainingProgram;

        $interactions = $program->fieldInteractions()
            ->latest()
            ->paginate(10);

        return view('trainee.interactions.index', compact('interactions'));
    }

    public function create()
    {
        return view('trainee.interactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name'     => 'required|string|max:255',
            'client_account'  => 'nullable|string|max:255',
            'visit_date'      => 'required|date',
            'visit_type'      => 'required|in:prospecting,discovery,proposal,negotiation,closing,follow_up',

            'is_in_matrix'    => 'required|boolean',
            'is_scheduled'    => 'required|boolean',
            'is_presential'   => 'required|boolean',
            'crm_registered'  => 'required|boolean',
            'has_artifacts'   => 'required|boolean',
            'client_classification' => 'nullable|in:A,B,C',
            'leader_approval'       => 'boolean',

            'spiced_doc_url'  => 'nullable|url',
            'notes'           => 'nullable|string'
        ]);

        $program = auth()->user()->trainingProgram;
        $week = $program->weeklyTrackings()
            ->where('week_number', $program->current_week)
            ->first();

        if (!$week) {
            return back()->with('error', 'No hay semana activa.');
        }

        $interaction = FieldInteraction::create([
            'program_id'         => $program->id,
            'weekly_tracking_id' => $week->id,

            'client_name'        => $request->client_name,
            'client_account'     => $request->client_account,
            'visit_date'         => $request->visit_date,
            'visit_type'         => $request->visit_type,

            'is_in_matrix'       => $request->boolean('is_in_matrix'),
            'is_scheduled'       => $request->boolean('is_scheduled'),
            'is_presential'      => $request->boolean('is_presential'),
            'crm_registered'     => $request->boolean('crm_registered'),
            'has_artifacts'      => $request->boolean('has_artifacts'),

            'spiced_doc_url'     => $request->spiced_doc_url,
            'notes'              => $request->notes,
            'client_classification' => $request->client_classification,
            'leader_approval'       => $request->boolean('leader_approval'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validación automática (modelo calcula is_valid)
        |--------------------------------------------------------------------------
        */

        // Restricción financiera - cuentas A y B
        if ($interaction->requiresLeaderApproval() && !$interaction->leader_approval) {
            return redirect()
                ->route('trainee.interacciones.index')
                ->with('warning', 'Interacción registrada. Esta cuenta requiere aprobación del líder para enviar cotizaciones.');
        }

        if (!$interaction->is_valid) {
            return redirect()
                ->route('trainee.interactions.index')
                ->with('warning', 'La interacción fue registrada pero NO es válida. Revisa las 5 normas.');
        }

        return redirect()
            ->route('trainee.interactions.index')
            ->with('success', 'Interacción válida registrada correctamente.');
    }

    public function show(FieldInteraction $interaccion)
    {
        if ($interaccion->program_id !== auth()->user()->trainingProgram->id) {
            abort(403);
        }

        return view('trainee.interactions.show', compact('interaccion'));
    }

    public function destroy(FieldInteraction $interaccion)
    {
        if ($interaccion->program_id !== auth()->user()->trainingProgram->id) {
            abort(403);
        }

        $interaccion->delete();

        return back()->with('success', 'Interacción eliminada.');
    }
}
