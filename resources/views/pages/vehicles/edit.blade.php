@extends('layouts.app')

@section('title', 'Modifica Veicolo')

@section('content')
    <div class="mb-4">
        <h1 class="flex items-center gap-2 text-2xl font-semibold">
            <a href="{{ route('vehicles.index') }}" class="font-normal">Tutti i veicoli</a>
            <x-lucide-chevron-right class="size-4" />Modifica Veicolo: {{ $vehicle->model }}
        </h1>
    </div>

    <form action="{{ route('vehicles.update', ['vehicle' => $vehicle->id]) }}" method="post"
        class="flex flex-col gap-4 mx-auto">
        @method('PUT')
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="w-full">
                <label class="label label-text" for="modelInput">Modello</label>
                <input class="w-full input" placeholder="Modello" type="text" name="model" id="modelInput"
                    value="{{ old('model', $vehicle->model) }}" required>
            </div>

            <div class="w-full">
                <label class="label label-text">Tipo</label>
                <div class="max-w-full">
                    <select
                        data-select='{
                                "placeholder": "Seleziona un tipo...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "advance-select-toggle",
                                "dropdownClasses": "advance-select-menu",
                                "optionClasses": "advance-select-option selected:active",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] flex-shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] flex-shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                }'
                        class="hidden" name="type" required>
                        <option value="">Seleziona un tipo</option>
                        <option value="car" {{ old('type', $vehicle->type) == 'car' ? 'selected' : '' }}>Auto
                        </option>
                        <option value="scooter" {{ old('type', $vehicle->type) == 'scooter' ? 'selected' : '' }}>
                            Scooter</option>
                        <option value="bike" {{ old('type', $vehicle->type) == 'bike' ? 'selected' : '' }}>
                            Bicicletta</option>
                    </select>
                </div>
            </div>

            <div class="w-full">
                <label class="label label-text">Disponibilità</label>
                <div class="max-w-full">
                    <select
                        data-select='{
                                "placeholder": "Seleziona uno stato...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "advance-select-toggle",
                                "dropdownClasses": "advance-select-menu",
                                "optionClasses": "advance-select-option selected:active",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] flex-shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                                "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] flex-shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                                }'
                        class="hidden" name="status" required>
                        <option value="">Seleziona uno stato</option>
                        <option value="available" {{ old('status', $vehicle->status) == 'available' ? 'selected' : '' }}>
                            Disponibile
                        </option>
                        <option value="rented" {{ old('status', $vehicle->status) == 'rented' ? 'selected' : '' }}>
                            Noleggiato</option>
                        <option value="maintenance"
                            {{ old('status', $vehicle->status) == 'maintenance' ? 'selected' : '' }}>In
                            Manutenzione
                        </option>
                    </select>
                </div>
            </div>

            <div class="w-full col-span-2">
                <label class="label label-text" for="batteryInput">Capacità Batteria</label>
                <div class="flex items-center gap-2 select-none">
                    <input hidden class="w-full input" type="range" name="battery_capacity" id="batteryInput"
                        min="0" max="100"
                        value="{{ old('battery_capacity', $vehicle->battery_capacity ?? 0) }}" required>
                    <div id="batteryContainer"
                        class="relative w-full overflow-hidden bg-gray-200 rounded-btn cursor-pointer h-[2.375rem]">
                        <div id="batteryFill" class="absolute top-0 left-0 h-full transition-all duration-500 ease-in-out"
                            style="width: {{ old('battery_capacity', $vehicle->battery_capacity ?? 0) }}%;"></div>
                        <div id="batteryHandle"
                            class="absolute top-0 h-full transition-all duration-300 ease-in-out bg-white border border-gray-300 btn cursor-grab"
                            style="left: calc({{ old('battery_capacity', $vehicle->battery_capacity ?? 0) }}% - 10px);">
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" id="decrementBattery"
                            class="items-center justify-center btn btn-soft btn-secondary btn-square">
                            <x-lucide-minus class="size-4" />
                        </button>
                        <div class="max-w-sm input-group">
                            <input type="text" class="w-16 text-center input" id="batteryNumberInput" min="0"
                                max="100" value="{{ old('battery_capacity', $vehicle->battery_capacity ?? 0) }}">
                            <span class="input-group-text">%</span>
                        </div>
                        <button type="button" id="incrementBattery"
                            class="items-center justify-center btn btn-soft btn-secondary btn-square">
                            <x-lucide-plus class="size-4" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <label class="label label-text" for="rateInput">Tariffa Oraria</label>
                <input class="w-full input" placeholder="Tariffa oraria" type="number" name="hourly_rate" id="rateInput"
                    value="{{ old('hourly_rate', $vehicle->hourly_rate) }}" required>
            </div>
        </div>

        <div class="mt-4">
            <label class="mb-2 font-semibold label label-text">Tags</label>
            <div class="flex flex-wrap items-start w-full gap-3">
                @foreach ($tags as $tag)
                    <label class="flex items-center w-auto gap-3 p-3 cursor-pointer max-w-1/4 custom-option">
                        <input type="checkbox" class="checkbox checkbox-primary checkbox-sm" name="tags[]"
                            value="{{ $tag->id }}" {{ $vehicle->tags->contains($tag) ? 'checked' : '' }} />
                        <span class="text-base label label-text !pb-0">{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('vehicles.index') }}" class="mr-2 btn btn-soft">Annulla</a>
            <button class="btn btn-primary" type="submit">Salva Modifiche</button>
        </div>
    </form>

    @if ($errors->any())
        <div class="p-4 mt-4 text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const batteryInput = document.getElementById('batteryInput');
            const batteryFill = document.getElementById('batteryFill');
            const batteryContainer = document.getElementById('batteryContainer');
            const batteryNumberInput = document.getElementById('batteryNumberInput');
            const decrementBattery = document.getElementById('decrementBattery');
            const incrementBattery = document.getElementById('incrementBattery');
            const batteryHandle = document.getElementById('batteryHandle');

            // Disabilita le transizioni durante il trascinamento per migliorare le prestazioni
            let isDragging = false;

            // Inizializza il gradient al caricamento della pagina
            const initialValue = parseInt(batteryInput.value) || 0;
            updateBattery(initialValue);

            // Gestione dei pulsanti + e -
            decrementBattery.addEventListener('click', function() {
                let value = parseInt(batteryNumberInput.value) || 0;
                value = Math.max(0, value - 1);
                batteryNumberInput.value = value;
                batteryInput.value = value;
                updateBattery(value);
            });

            incrementBattery.addEventListener('click', function() {
                let value = parseInt(batteryNumberInput.value) || 0;
                value = Math.min(100, value + 1);
                batteryNumberInput.value = value;
                batteryInput.value = value;
                updateBattery(value);
            });

            // Aggiorna quando si cambia il valore numerico
            batteryNumberInput.addEventListener('input', function() {
                let value = parseInt(this.value) || 0;
                // Limita il valore tra 0 e 100
                value = Math.max(0, Math.min(100, value));
                this.value = value;

                // Aggiorna lo slider e la barra
                batteryInput.value = value;
                updateBattery(value);
            });

            // Funzionalità per trascinare direttamente sulla barra
            batteryContainer.addEventListener('mousedown', function(e) {
                e.preventDefault(); // Previene la selezione del testo

                // Disattiva le transizioni durante il trascinamento
                isDragging = true;
                batteryFill.style.transition = 'none';
                batteryHandle.style.transition = 'none';

                updateBatteryFromClick(e);

                function handleMouseMove(e) {
                    // Usa requestAnimationFrame per ottimizzare le prestazioni
                    if (!isDragging) return;

                    requestAnimationFrame(function() {
                        updateBatteryFromClick(e);
                    });
                }

                function handleMouseUp() {
                    // Riattiva le transizioni alla fine del trascinamento
                    isDragging = false;
                    batteryFill.style.transition = 'all 500ms ease-in-out';
                    batteryHandle.style.transition = 'all 300ms ease-in-out';

                    document.removeEventListener('mousemove', handleMouseMove);
                    document.removeEventListener('mouseup', handleMouseUp);
                }

                // Aggiunge event listener per il trascinamento
                document.addEventListener('mousemove', handleMouseMove);
                document.addEventListener('mouseup', handleMouseUp);
            });

            function getBatteryColor(value) {
                if (value <= 20) {
                    return '#ff3333'; // Rosso
                } else if (value <= 40) {
                    return '#ffa500'; // Arancione
                } else if (value <= 60) {
                    return '#ffdd00'; // Giallo
                } else if (value <= 80) {
                    return '#90ee90'; // Verde chiaro
                } else {
                    return '#00aa00'; // Verde
                }
            }

            function updateBatteryFromClick(e) {
                const rect = batteryContainer.getBoundingClientRect();
                let x = Math.max(0, Math.min(rect.width, e.clientX - rect.left));
                let percentage = Math.round((x / rect.width) * 100);

                // Limita il valore tra 0 e 100
                percentage = Math.max(0, Math.min(100, percentage));

                // Aggiorna lo slider e il campo nascosto
                batteryInput.value = percentage;

                // Aggiorna tutti i valori della batteria
                updateBattery(percentage);
            }

            function updateBattery(value) {
                // Converte a numero e limita tra 0-100 per sicurezza
                value = parseInt(value) || 0;
                value = Math.max(0, Math.min(100, value));

                // Aggiorna i valori testuali
                batteryNumberInput.value = value;
                batteryInput.value = value;

                // Aggiorna la larghezza della barra
                batteryFill.style.width = value + '%';

                // Aggiorna il colore della barra con un colore pieno
                const color = getBatteryColor(value);
                batteryFill.style.backgroundColor = color;

                // Aggiorna la posizione dell'handle
                // Calcola la posizione in pixel
                const containerWidth = batteryContainer.offsetWidth;
                const handleWidth = batteryHandle.offsetWidth;
                const handlePosition = (value / 100) * containerWidth - (handleWidth / 2);

                // Limita la posizione dell'handle per evitare che esca dal contenitore
                const minPosition = -1;
                const maxPosition = containerWidth - handleWidth + 1;
                const finalPosition = Math.max(minPosition, Math.min(maxPosition, handlePosition));

                batteryHandle.style.left = finalPosition + 'px';
            }
        });
    </script>
@endpush
