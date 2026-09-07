@extends('trainee.layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Nueva Interacción</h2>

            <form method="POST" action="{{ route('trainee.interacciones.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Cliente / Cuenta</label>
                    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror"
                        value="{{ old('client_name') }}" required>
                    @error('client_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Cuenta (opcional)</label>
                    <input type="text" name="client_account" class="form-control" value="{{ old('client_account') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de visita</label>
                    <input type="date" name="visit_date" class="form-control @error('visit_date') is-invalid @enderror"
                        value="{{ old('visit_date') }}" required>
                    @error('visit_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de interacción</label>
                    <select name="visit_type" class="form-select" required>
                        <option value="prospecting">Prospección</option>
                        <option value="discovery">Descubrimiento</option>
                        <option value="proposal">Propuesta</option>
                        <option value="negotiation">Negociación</option>
                        <option value="closing">Cierre</option>
                        <option value="follow_up">Seguimiento</option>
                    </select>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Las 5 Normas de Validez</strong>
                        <small class="text-muted ms-2">La interacción solo cuenta si cumple las 5</small>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_in_matrix" value="1"
                                id="matrix">
                            <label class="form-check-label" for="matrix">
                                El cliente figura en la Matriz de Planificación
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_scheduled" value="1"
                                id="scheduled">
                            <label class="form-check-label" for="scheduled">
                                La cita fue agendada proactivamente por mí
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_presential" value="1"
                                id="presential">
                            <label class="form-check-label" for="presential">
                                La interacción fue estrictamente presencial
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="crm_registered" value="1"
                                id="crm">
                            <label class="form-check-label" for="crm">
                                Está registrada en el CRM antes del corte semanal
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="has_artifacts" value="1"
                                id="artifacts">
                            <label class="form-check-label" for="artifacts">
                                Tengo evidencia tangible de que ocurrió
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Clasificación del cliente</label>
                    <select name="client_classification" class="form-select">
                        <option value="">Sin clasificar</option>
                        <option value="A">Cuenta A - Alto potencial</option>
                        <option value="B">Cuenta B - Potencial medio</option>
                        <option value="C">Cuenta C - Potencial bajo</option>
                    </select>
                    <div class="form-text">Las cuentas A y B requieren aprobación del líder para cotizar.</div>
                </div>

                <div class="mb-3" id="approval-section" style="display:none;">
                    <div class="alert alert-warning">
                        Esta es una cuenta de alto potencial (A o B). Para enviar cotizaciones necesitarás aprobación del
                        líder comercial.
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="leader_approval" value="1"
                            id="leader_approval">
                        <label class="form-check-label" for="leader_approval">
                            Confirmo que tengo aprobación del líder para cotizar a esta cuenta
                        </label>
                    </div>
                </div>

                <script>
                    document.querySelector('[name="client_classification"]').addEventListener('change', function() {
                        const section = document.getElementById('approval-section');
                        section.style.display = ['A', 'B'].includes(this.value) ? 'block' : 'none';
                    });
                </script>

                <div class="mb-3">
                    <label class="form-label">Documento SPICED (URL, opcional)</label>
                    <input type="url" name="spiced_doc_url" class="form-control" placeholder="https://"
                        value="{{ old('spiced_doc_url') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Notas adicionales</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Registrar Interacción</button>
                    <a href="{{ route('trainee.interacciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
