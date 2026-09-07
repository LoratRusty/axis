<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTraineeOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $programId = $request->route('program')
            ?? $request->route('program_id')
            ?? $request->route('id');

        if (!$programId) {
            return $next($request);
        }

        if ($user->isTrainee()) {

            $ownsProgram = $user->trainingProgram
                && $user->trainingProgram->id === $programId;

            if (!$ownsProgram) {
                abort(403, 'No puedes acceder a este recurso.');
            }
        }

        return $next($request);
    }
}