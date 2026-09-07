@extends('trainee.layout')

@section('content')

<h2>Feedback</h2>

<p><strong>Fortalezas:</strong></p>
<p>{{ $feedback->strengths }}</p>

<p><strong>Brechas:</strong></p>
<p>{{ $feedback->gaps }}</p>

<p><strong>Acción:</strong></p>
<p>{{ $feedback->single_action }}</p>

@if(!$feedback->trainee_ack)
<form method="POST" action="{{ route('trainee.feedback.acknowledge', $feedback) }}">
    @csrf
    <button type="submit">Marcar como leído</button>
</form>
@endif

@endsection