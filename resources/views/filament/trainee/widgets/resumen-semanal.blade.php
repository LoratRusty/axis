@php
    $colores = [
        'verde'    => ['bg' => '#e8f5e9', 'borde' => '#2e7d32', 'texto' => '#1b5e20'],
        'amarillo' => ['bg' => '#fff8e1', 'borde' => '#f9a825', 'texto' => '#e65100'],
        'rojo'     => ['bg' => '#fdecea', 'borde' => '#E84444', 'texto' => '#b71c1c'],
        'gris'     => ['bg' => '#f5f5f5', 'borde' => '#9e9e9e', 'texto' => '#424242'],
    ];

    $etiquetas = [
        'verde'    => 'En meta',
        'amarillo' => 'En progreso',
        'rojo'     => 'Por debajo de meta',
        'gris'     => 'Sin datos',
    ];
@endphp

<div style="padding: 1.5rem;">

    @if (! $program)
        <div style="padding: 1rem; background: #fdecea; border-left: 4px solid #E84444; border-radius: 6px;">
            <strong style="color: #b71c1c;">Sin programa activo.</strong>
            Contacta a tu coach para iniciar tu programa de entrenamiento.
        </div>
    @else
        {{-- Encabezado --}}
        <div style="margin-bottom: 1.5rem;">
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #1B2F6E;">
                Semana {{ $program->current_week }} - {{ ucfirst($program->current_stage) }}
            </h2>
            <p style="margin: 0.25rem 0 0; color: #555; font-size: 0.9rem;">
                Sub-rol actual: <strong>{{ $program->current_subrole ?? '-' }}</strong>
                &nbsp;|&nbsp;
                Estado: <strong>{{ ucfirst($program->status) }}</strong>
                @if ($diasParaCorte !== null)
                    &nbsp;|&nbsp;
                    Cierre de semana en <strong>{{ $diasParaCorte }} {{ $diasParaCorte === 1 ? 'día' : 'días' }}</strong>
                @endif
            </p>
        </div>

        {{-- Semaforos --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">

            {{-- Interacciones --}}
            @php $c = $colores[$semaforoInteracciones]; @endphp
            <div style="background: {{ $c['bg'] }}; border-left: 5px solid {{ $c['borde'] }}; border-radius: 8px; padding: 1rem;">
                <div style="font-size: 0.75rem; font-weight: 600; color: {{ $c['texto'] }}; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                    Interacciones de campo
                </div>
                <div style="font-size: 2rem; font-weight: 800; color: {{ $c['borde'] }};">
                    {{ $interaccionesActual }} / {{ $interaccionesMeta }}
                </div>
                <div style="font-size: 0.8rem; color: {{ $c['texto'] }}; margin-top: 0.25rem;">
                    {{ $etiquetas[$semaforoInteracciones] }}
                </div>
                <div style="margin-top: 0.5rem; background: #ddd; border-radius: 99px; height: 6px;">
                    <div style="width: {{ $interaccionesMeta > 0 ? min(100, round($interaccionesActual / $interaccionesMeta * 100)) : 0 }}%; background: {{ $c['borde'] }}; border-radius: 99px; height: 6px; transition: width 0.3s;"></div>
                </div>
            </div>

            {{-- Rituales --}}
            @php $c = $colores[$semaforoRituales]; @endphp
            <div style="background: {{ $c['bg'] }}; border-left: 5px solid {{ $c['borde'] }}; border-radius: 8px; padding: 1rem;">
                <div style="font-size: 0.75rem; font-weight: 600; color: {{ $c['texto'] }}; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                    Rituales completados
                </div>
                <div style="font-size: 2rem; font-weight: 800; color: {{ $c['borde'] }};">
                    {{ $ritualesCompletados }} / {{ $ritualesMeta }}
                </div>
                <div style="font-size: 0.8rem; color: {{ $c['texto'] }}; margin-top: 0.25rem;">
                    {{ $etiquetas[$semaforoRituales] }}
                </div>
                <div style="margin-top: 0.5rem; background: #ddd; border-radius: 99px; height: 6px;">
                    <div style="width: {{ $ritualesMeta > 0 ? min(100, round($ritualesCompletados / $ritualesMeta * 100)) : 0 }}%; background: {{ $c['borde'] }}; border-radius: 99px; height: 6px; transition: width 0.3s;"></div>
                </div>
            </div>

            {{-- Evidencias --}}
            @php $c = $colores[$semaforoEvidencias]; @endphp
            <div style="background: {{ $c['bg'] }}; border-left: 5px solid {{ $c['borde'] }}; border-radius: 8px; padding: 1rem;">
                <div style="font-size: 0.75rem; font-weight: 600; color: {{ $c['texto'] }}; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                    Evidencias subidas
                </div>
                <div style="font-size: 2rem; font-weight: 800; color: {{ $c['borde'] }};">
                    {{ $evidenciasSubidas }} / {{ $evidenciasMeta }}
                </div>
                <div style="font-size: 0.8rem; color: {{ $c['texto'] }}; margin-top: 0.25rem;">
                    {{ $etiquetas[$semaforoEvidencias] }}
                </div>
                <div style="margin-top: 0.5rem; background: #ddd; border-radius: 99px; height: 6px;">
                    <div style="width: {{ $evidenciasMeta > 0 ? min(100, round($evidenciasSubidas / $evidenciasMeta * 100)) : 0 }}%; background: {{ $c['borde'] }}; border-radius: 99px; height: 6px; transition: width 0.3s;"></div>
                </div>
            </div>

        </div>

        {{-- Instruccion --}}
        <div style="background: #EEF2FB; border-radius: 8px; padding: 1rem; font-size: 0.85rem; color: #1B2F6E; border-left: 4px solid #1B2F6E;">
            Registra tus interacciones de campo y sube tus evidencias antes del cierre de semana.
            Tu coach revisara el avance al finalizar la semana.
        </div>
    @endif

</div>