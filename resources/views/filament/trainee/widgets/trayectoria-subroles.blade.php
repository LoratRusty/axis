<div style="padding: 1.5rem;">

    @if (! $program)
        <div style="color: #555; font-size: 0.9rem;">Sin programa activo.</div>
    @else
        <h3 style="margin: 0 0 1.25rem; font-size: 1rem; font-weight: 700; color: #1B2F6E; text-transform: uppercase; letter-spacing: 0.05em;">
            Trayectoria de Sub-roles
        </h3>

        @foreach ($subroles as $fase => $items)
            <div style="margin-bottom: 1.25rem;">
                <div style="font-size: 0.7rem; font-weight: 700; color: #5BB8E8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.5rem;">
                    Fase {{ $fase }}
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                    @foreach ($items as $sr)
                        @php
                            $claveNorm = strtolower($sr['clave']);
                            $esActual  = $claveNorm === $actual;
                            $esLogrado = in_array($claveNorm, $logrosClaves);

                            if ($esActual) {
                                $bg     = '#1B2F6E';
                                $texto  = '#FFFFFF';
                                $borde  = '#1B2F6E';
                                $etiq   = 'En curso';
                                $etiqColor = '#5BB8E8';
                            } elseif ($esLogrado) {
                                $bg     = '#e8f5e9';
                                $texto  = '#1b5e20';
                                $borde  = '#2e7d32';
                                $etiq   = 'Acreditado';
                                $etiqColor = '#2e7d32';
                            } else {
                                $bg     = '#f5f5f5';
                                $texto  = '#9e9e9e';
                                $borde  = '#e0e0e0';
                                $etiq   = 'Pendiente';
                                $etiqColor = '#9e9e9e';
                            }
                        @endphp
                        <div style="background: {{ $bg }}; border: 2px solid {{ $borde }}; border-radius: 10px; padding: 0.75rem 1.1rem; min-width: 150px;">
                            <div style="font-size: 0.95rem; font-weight: 700; color: {{ $texto }};">
                                {{ $sr['clave'] }}
                            </div>
                            <div style="font-size: 0.72rem; color: {{ $etiqColor }}; margin-top: 0.2rem; font-weight: 600;">
                                {{ $etiq }}
                            </div>
                            <div style="font-size: 0.7rem; color: {{ $esActual ? '#5BB8E8' : '#aaa' }}; margin-top: 0.15rem;">
                                Sem. {{ $sr['semana_min'] }}–{{ $sr['semana_max'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div style="margin-top: 1rem; background: #EEF2FB; border-radius: 8px; padding: 0.85rem 1rem; font-size: 0.82rem; color: #1B2F6E; border-left: 4px solid #1B2F6E;">
            Para avanzar de sub-rol necesitas: volumen meta cumplido, rituales al 90% o mas, y rubrica promedio de 2 o superior.
            Tu coach valida y solicita la acreditacion.
        </div>
    @endif

</div>