@extends('trainee.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Interacciones</h2>
    <a href="{{ route('trainee.interacciones.index') }}" class="btn btn-primary">Nueva Interacción</a>
</div>

@if($interactions->isEmpty())
    <div class="alert alert-info">No hay interacciones registradas esta semana.</div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Válida</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interactions as $i)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($i->visit_date)->format('d/m/Y') }}</td>
                        <td>{{ $i->client_name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $i->visit_type)) }}</td>
                        <td>
                            @if($i->is_valid)
                                <span class="badge bg-success">Válida</span>
                            @else
                                <span class="badge bg-danger">No válida</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $interactions->links() }}
@endif

@endsection