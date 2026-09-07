@extends('trainee.layout')

@section('content')

<div class="row mb-4">
    <div class="col">
        <h2 class="mb-0">Bienvenido, {{ $user->name }}</h2>
        <p class="text-muted">{{ ucfirst($program->current_subrole) }} · Fase {{ $program->current_stage }} · Semana {{ $program->current_week }}</p>
    </div>
    <div class="col-auto">
        <span class="badge bg-secondary">Coach: {{ $program->coach->name }}</span>
    </div>
</div>

{{-- Semáforo semanal --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Interacciones</h6>
                @if($currentWeek)
                    <h2 class="{{ $currentWeek->actual_interactions >= $currentWeek->target_interactions ? 'text-success' : 'text-danger' }}">
                        {{ $currentWeek->actual_interactions }} / {{ $currentWeek->target_interactions }}
                    </h2>
                @else
                    <h2 class="text-muted">-</h2>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Rituales</h6>
                @if($currentWeek)
                    <h2 class="{{ $currentWeek->rituals_completed >= $currentWeek->rituals_target ? 'text-success' : 'text-warning' }}">
                        {{ $currentWeek->rituals_completed }} / {{ $currentWeek->rituals_target }}
                    </h2>
                @else
                    <h2 class="text-muted">-</h2>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <h6 class="card-title text-muted">Días para corte</h6>
                <h2 class="{{ $daysToCutoff <= 2 ? 'text-danger' : 'text-primary' }}">
                    {{ $daysToCutoff }}
                </h2>
            </div>
        </div>
    </div>
</div>

{{-- Feedback pendiente --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Feedback pendiente</strong>
        <a href="{{ route('trainee.feedback.index') }}" class="btn btn-sm btn-outline-primary">Ver todo</a>
    </div>
    <div class="card-body">
        @forelse($pendingFeedback as $f)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <div>
                    <span class="badge bg-warning text-dark me-2">{{ $f->session_type }}</span>
                    {{ \Carbon\Carbon::parse($f->session_date)->format('d/m/Y') }}
                </div>
                <a href="{{ route('trainee.feedback.index') }}" class="btn btn-sm btn-warning">Leer</a>
            </div>
        @empty
            <p class="text-muted mb-0">No hay feedback pendiente.</p>
        @endforelse
    </div>
</div>

{{-- Accesos rápidos --}}
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('trainee.evidencias.index') }}" class="btn btn-outline-primary w-100 py-3">
            📄 Cargar Evidencia
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('trainee.interacciones.index') }}" class="btn btn-outline-success w-100 py-3">
            🤝 Registrar Interacción
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('trainee.expediente.index') }}" class="btn btn-outline-secondary w-100 py-3">
            📁 Ver Expediente
        </a>
    </div>
</div>

@endsection