<x-filament-panels::page>
    <div style="max-width: 48rem; display: flex; flex-direction: column; gap: 1.5rem;">

        {{-- Selector de semana --}}
        <x-filament::section>
            <x-slot name="heading">Selecciona la semana</x-slot>
            <div style="max-width: 20rem;">
                <select
                    wire:model.live="weekly_tracking_id"
                    style="width: 100%; border: 1px solid #d1d5db; border-radius: 0.5rem; padding: 0.5rem 0.75rem; font-size: 0.875rem; background: white; color: #111827;">
                    <option value="">— Elige una semana —</option>
                    @foreach($this->getWeekOptions() as $id => $label)
                        <option value="{{ $id }}" @selected($weekly_tracking_id == $id)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </x-filament::section>

        {{-- Rituales --}}
        @if($weekly_tracking_id && count($scores))

            <x-filament::section>
                <x-slot name="heading">Califica tus rituales</x-slot>
                <x-slot name="description">Del 1 al 10, ¿cómo sientes que ejecutaste cada ritual esta semana?</x-slot>

                <div style="margin-top: 0.5rem;">
                    @foreach($scores as $i => $row)
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                        <span style="font-size: 0.875rem; color: #111827; flex: 1;">
                            {{ $row['ritual_name'] }}
                        </span>
                        <div style="display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0;">
                            <input
                                type="number"
                                min="1"
                                max="10"
                                wire:model.defer="scores.{{ $i }}.score"
                                placeholder="—"
                                style="width: 4rem; border: 1px solid #d1d5db; border-radius: 0.5rem; padding: 0.375rem 0.5rem; font-size: 0.875rem; text-align: center; background: white; color: #111827;" />
                            <span style="font-size: 0.75rem; color: #9ca3af; width: 1.5rem;">/10</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Notas --}}
                <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #e5e7eb;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                        Notas generales <span style="font-weight: 400; color: #9ca3af;">(opcional)</span>
                    </label>
                    <textarea
                        wire:model.defer="general_notes"
                        rows="4"
                        placeholder="¿Qué te costó más esta semana? ¿Algo que quieras recordar para la reunión con tu Coach?"
                        style="width: 100%; border: 1px solid #d1d5db; border-radius: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem; color: #111827; background: white; resize: vertical; box-sizing: border-box;"></textarea>
                </div>

                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <x-filament::button wire:click="save" size="lg">
                        Guardar calificaciones
                    </x-filament::button>
                </div>

            </x-filament::section>

        @elseif($weekly_tracking_id)

            <x-filament::section>
                <p style="font-size: 0.875rem; color: #6b7280;">
                    No se encontraron rituales activos. Contacta a tu Coach.
                </p>
            </x-filament::section>

        @endif

    </div>
</x-filament-panels::page>