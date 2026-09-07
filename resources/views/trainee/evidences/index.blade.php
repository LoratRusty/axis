@extends('trainee.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Evidencias</h2>
    <a href="{{ route('trainee.evidencias.index') }}" class="btn btn-primary">Nueva Evidencia</a>
</div>

@if($evidences->isEmpty())
    <div class="alert alert-info">No hay evidencias registradas aún.</div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Ritual</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evidences as $e)
                    <tr>
                        <td>{{ $e->title }}</td>
                        <td>{{ $e->ritual?->name ?? '-' }}</td>
                        <td>{{ $e->evidence_type }}</td>
                        <td>
                            @if($e->status === 'approved')
                                <span class="badge bg-success">Aprobada</span>
                            @elseif($e->status === 'needs_revision')
                                <span class="badge bg-warning text-dark">Revisar</span>
                            @elseif($e->status === 'rejected')
                                <span class="badge bg-danger">Rechazada</span>
                            @else
                                <span class="badge bg-secondary">Pendiente</span>
                            @endif
                        </td>
                        <td>{{ $e->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $evidences->links() }}
@endif

@endsection