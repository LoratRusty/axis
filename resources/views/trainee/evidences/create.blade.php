@extends('trainee.layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4">Nueva Evidencia</h2>

        <form method="POST" action="{{ route('trainee.evidencias.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Ritual</label>
                <select name="ritual_id" class="form-select @error('ritual_id') is-invalid @enderror" required>
                    <option value="">Selecciona un ritual...</option>
                    @foreach($rituals as $r)
                        <option value="{{ $r->id }}">
                            #{{ $r->number }} - {{ $r->name }}
                        </option>
                    @endforeach
                </select>
                @error('ritual_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                    rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Archivo (opcional)</label>
                <input type="file" name="file" class="form-control">
                <div class="form-text">Máximo 50MB. PDF, Word, Excel, imagen, audio o video.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">URL externa (opcional)</label>
                <input type="url" name="external_url" class="form-control"
                    placeholder="https://" value="{{ old('external_url') }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar Evidencia</button>
                <a href="{{ route('trainee.evidencias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection