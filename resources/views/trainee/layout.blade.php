<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AXIS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="{{ route('trainee.dashboard') }}">AXIS</a>
    <div class="navbar-nav ms-auto">
        <a class="nav-link" href="{{ route('trainee.evidencias.index') }}">Evidencias</a>
        <a class="nav-link" href="{{ route('trainee.interacciones.index') }}">Interacciones</a>
        <a class="nav-link" href="{{ route('trainee.feedback.index') }}">Feedback</a>
        <a class="nav-link" href="{{ route('trainee.expediente.index') }}">Expediente</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm ms-2">Salir</button>
        </form>
    </div>
</nav>

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')

</div>

</body>
</html>