@extends('trainee.layout')

@section('content')

<h2>{{ $evidencia->title }}</h2>

<p>{{ $evidencia->description }}</p>
<p>Status: {{ $evidencia->status }}</p>

@if($evidencia->file_url)
    <a href="{{ $evidencia->file_url }}" target="_blank">Ver archivo</a>
@endif

@endsection