@extends('trainee.layout')

@section('content')

<h2 class="mb-4">Expediente Profesional - {{ $user->name }}</h2>

{{-- Trayectoria de sub-roles --}}
<div class="card mb-4">
    <div class="card-header"><strong>Trayectoria de Sub-Roles</strong></div>
    <div class="card-body">
        @php
            $allSubroles = ['visitador','prospectador','descubridor','articulador','negociador','asesor_comercial'];
            $acreditados = $subroles->pluck('subrole')->toArray();
        @endphp
        <div class="d-flex flex-wrap gap-2">
            @foreach($allSubroles as $sr)
                @if(in_array($sr, $acreditados))
                    <span class="badge bg-success fs-6">{{ ucfirst($sr) }}</span>
                @elseif($sr === $program->current_subrole)
                    <span class="badge bg-primary fs-6">{{ ucfirst($sr) }} (en curso)</span>
                @else
                    <span class="badge bg-secondary fs-6">{{ ucfirst($sr) }}</span>
                @endif
            @endforeach
        </div>
    </div>
</div>

{{-- Historial de semanas --}}
<div class="card mb-4">
    <div class="card-header"><strong>Historial Semanal</strong></div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th>Semana</th>
                        <th>Interacciones</th>
                        <th>Rituales</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weeks as $w)
                        <tr>
                            <td>Sem. {{ $w->week_number }}</td>
                            <td>{{ $w->actual_interactions }} / {{ $w->target_interactions }}</td>
                            <td>{{ $w->rituals_completed }} / {{ $w->rituals_target }}</td>
                            <td>
                                @if($w->status === 'completed')
                                    <span class="badge bg-success">Completada</span>
                                @elseif($w->status === 'in_progress')
                                    <span class="badge bg-primary">En curso</span>
                                @else
                                    <span class="badge bg-secondary">{{ $w->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection