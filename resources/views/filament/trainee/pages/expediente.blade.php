<x-filament-panels::page>

    @if (! $program)
        <div style="padding: 1.5rem; background: #fdecea; border-left: 4px solid #E84444; border-radius: 6px;">
            <strong style="color: #b71c1c;">Sin programa activo.</strong>
            Contacta a tu coach para iniciar tu programa de entrenamiento.
        </div>
    @else

        {{-- PERFIL --}}
        <div style="background: #1B2F6E; border-radius: 12px; padding: 1.5rem 2rem; color: #fff; margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: center;">
            <div style="flex: 1; min-width: 200px;">
                <div style="font-size: 0.75rem; color: #5BB8E8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.25rem;">Vendedor en entrenamiento</div>
                <div style="font-size: 1.4rem; font-weight: 800;">{{ $user->name }}</div>
                <div style="font-size: 0.85rem; color: #a0b4d6; margin-top: 0.15rem;">{{ $user->email }}</div>
                @if ($user->region)
                    <div style="font-size: 0.8rem; color: #a0b4d6;">Region: {{ $user->region }}</div>
                @endif
            </div>
            <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                <div style="text-align: center;">
                    <div style="font-size: 1.6rem; font-weight: 800; color: #5BB8E8;">{{ $program->current_week }}</div>
                    <div style="font-size: 0.7rem; color: #a0b4d6; text-transform: uppercase;">Semana actual</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 1.6rem; font-weight: 800; color: #5BB8E8;">{{ ucfirst($program->current_stage ?? '-') }}</div>
                    <div style="font-size: 0.7rem; color: #a0b4d6; text-transform: uppercase;">Fase</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 1.6rem; font-weight: 800; color: #5BB8E8;">{{ $program->current_subrole ?? '-' }}</div>
                    <div style="font-size: 0.7rem; color: #a0b4d6; text-transform: uppercase;">Sub-rol</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 1.6rem; font-weight: 800; color: #5BB8E8;">{{ $program->coach->name ?? '-' }}</div>
                    <div style="font-size: 0.7rem; color: #a0b4d6; text-transform: uppercase;">Coach</div>
                </div>
            </div>
        </div>

        {{-- KPIs ULTIMO SNAPSHOT --}}
        @if ($ultimo)
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 0.85rem; font-weight: 700; color: #1B2F6E; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 0.75rem;">
                Indicadores - Semana {{ $ultimo->week_number }}
                <span style="font-weight: 400; color: #888; text-transform: none; font-size: 0.78rem;">
                    (corte {{ $ultimo->snapshot_date->format('d/m/Y') }})
                </span>
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0.75rem;">
                @php
                    $kpiItems = [
                        ['Interacciones semana',  $ultimo->weekly_interactions ?? '-', '#5BB8E8'],
                        ['Interacciones total',   $ultimo->total_interactions ?? '-',  '#5BB8E8'],
                        ['Oportunidades SPICED',  $ultimo->spiced_opportunities ?? '-','#1B2F6E'],
                        ['Acuerdos mutuos',       $ultimo->mutual_agreements ?? '-',   '#1B2F6E'],
                        ['Tasa de cierre',        $ultimo->win_rate ? number_format($ultimo->win_rate, 1) . '%' : '-', '#2e7d32'],
                        ['ARR Consumibles',       $ultimo->arr_consumables ? '$' . number_format($ultimo->arr_consumables, 0) : '-', '#2e7d32'],
                        ['Dimension actual',      $ultimo->current_dimension ?? '-',   '#e65100'],
                        ['Fase actual',           $ultimo->current_phase ?? '-',       '#e65100'],
                    ];
                @endphp
                @foreach ($kpiItems as $kpi)
                <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0.85rem 1rem;">
                    <div style="font-size: 0.68rem; color: #888; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.3rem;">
                        {{ $kpi[0] }}
                    </div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: {{ $kpi[2] }};">
                        {{ $kpi[1] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- LOGROS DE SUB-ROL --}}
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 0.85rem; font-weight: 700; color: #1B2F6E; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 0.75rem;">
                Sub-roles acreditados
            </h3>
            @if ($logros->isEmpty())
                <div style="background: #f5f5f5; border-radius: 8px; padding: 1rem; color: #888; font-size: 0.85rem;">
                    Aun no tienes sub-roles acreditados. Tu coach registrara los logros cuando cumplas los requisitos.
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach ($logros as $logro)
                    <div style="background: #e8f5e9; border-left: 5px solid #2e7d32; border-radius: 8px; padding: 1rem 1.25rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-start;">
                        <div style="flex: 1; min-width: 150px;">
                            <div style="font-size: 1rem; font-weight: 700; color: #1b5e20;">
                                {{ $logro->subrole }}
                            </div>
                            <div style="font-size: 0.78rem; color: #388e3c; margin-top: 0.1rem;">
                                Acreditado el {{ $logro->accredited_date->format('d/m/Y') }}
                                @if ($logro->accreditedBy)
                                    por {{ $logro->accreditedBy->name }}
                                @endif
                            </div>
                        </div>
                        @if ($logro->evidence_summary)
                        <div style="flex: 2; min-width: 200px; font-size: 0.82rem; color: #2e7d32;">
                            {{ $logro->evidence_summary }}
                        </div>
                        @endif
                        @if ($logro->kpis_at_accreditation)
                        <div style="flex: 1; min-width: 150px;">
                            @foreach ($logro->kpis_at_accreditation as $k => $v)
                            <div style="font-size: 0.75rem; color: #388e3c;">
                                <strong>{{ $k }}:</strong> {{ $v }}
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- HISTORIAL KPI --}}
        @if ($kpis->count() > 1)
        <div>
            <h3 style="font-size: 0.85rem; font-weight: 700; color: #1B2F6E; text-transform: uppercase; letter-spacing: 0.06em; margin: 0 0 0.75rem;">
                Historial de indicadores
            </h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem;">
                    <thead>
                        <tr style="background: #1B2F6E; color: #fff;">
                            <th style="padding: 0.6rem 0.8rem; text-align: left; white-space: nowrap;">Semana</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: left; white-space: nowrap;">Corte</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: center; white-space: nowrap;">Int. semana</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: center; white-space: nowrap;">Int. total</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: center; white-space: nowrap;">SPICED</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: center; white-space: nowrap;">Acuerdos</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: center; white-space: nowrap;">Cierre %</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: left; white-space: nowrap;">Dimension</th>
                            <th style="padding: 0.6rem 0.8rem; text-align: left; white-space: nowrap;">Fase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kpis as $i => $snap)
                        <tr style="background: {{ $i % 2 === 0 ? '#f9fafb' : '#ffffff' }}; border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.5rem 0.8rem; font-weight: 600; color: #1B2F6E;">Sem. {{ $snap->week_number }}</td>
                            <td style="padding: 0.5rem 0.8rem; color: #555;">{{ $snap->snapshot_date->format('d/m/Y') }}</td>
                            <td style="padding: 0.5rem 0.8rem; text-align: center;">{{ $snap->weekly_interactions ?? '-' }}</td>
                            <td style="padding: 0.5rem 0.8rem; text-align: center;">{{ $snap->total_interactions ?? '-' }}</td>
                            <td style="padding: 0.5rem 0.8rem; text-align: center;">{{ $snap->spiced_opportunities ?? '-' }}</td>
                            <td style="padding: 0.5rem 0.8rem; text-align: center;">{{ $snap->mutual_agreements ?? '-' }}</td>
                            <td style="padding: 0.5rem 0.8rem; text-align: center;">{{ $snap->win_rate ? number_format($snap->win_rate, 1) . '%' : '-' }}</td>
                            <td style="padding: 0.5rem 0.8rem;">{{ $snap->current_dimension ?? '-' }}</td>
                            <td style="padding: 0.5rem 0.8rem;">{{ $snap->current_phase ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    @endif

</x-filament-panels::page>