<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveProgram
{
    public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();

    \Log::info('EnsureActiveProgram', [
        'user'    => $user?->email,
        'role'    => $user?->role,
        'program' => $user?->trainingProgram?->status,
    ]);

    if (!$user || !$user->isTrainee()) {
        \Log::info('Abortando: no es trainee');
        abort(403);
    }

    $program = $user->trainingProgram;

    if (!$program || $program->status !== 'active') {
        \Log::info('Abortando: sin programa activo');
        abort(403);
    }

    return $next($request);
}
}