@extends('trainee.layout')

@section('content')

<h2 class="mb-4">Feedback</h2>

@if($feedbacks->isEmpty())
    <div class="alert alert-info">No hay feedback registrado aún.</div>
@else
    <div class="list-group">
        @foreach($feedbacks as $f)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ ucfirst(str_replace('_', ' ', $f->session_type)) }}</strong>
                    <small class="text-muted ms-2">{{ \Carbon\Carbon::parse($f->session_date)->format('d/m/Y') }}</small>
                    @if(!$f->trainee_ack)
                        <span class="badge bg-warning text-dark ms-2">No leído</span>
                    @else
                        <span class="badge bg-success ms-2">Leído</span>
                    @endif
                </div>
                <a href="{{ route('trainee.feedback.index') }}" class="btn btn-sm btn-outline-primary">Ver</a>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $feedbacks->links() }}</div>
@endif

@endsection