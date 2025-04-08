@extends('layouts.app')

@section('title', $vehicle->model)

@section('content')
    <div class="flex justify-between mb-4">
        <h1 class="flex items-center gap-2 text-2xl font-semibold">
            <a href="{{ route('vehicles.index') }}" class="font-normal">Tutti i veicoli</a>
            <x-lucide-chevron-right class="size-4" />{{ $vehicle->model }}
        </h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-soft">
                <x-lucide-pencil class="size-4" />Modifica veicolo
            </a>
            <button type="button" class="text-red-500 btn btn-soft" aria-haspopup="dialog" aria-expanded="false"
                aria-controls="delete-vehicle-modal" data-overlay="#delete-vehicle-modal">
                <x-lucide-trash class="size-4" />Elimina veicolo
            </button>
        </div>
    </div>

    @include('includes.delete-confirmation', [
        'id' => 'delete-vehicle-modal',
        'title' => 'Elimina ' . $vehicle->model,
        'message' => 'Sei sicuro di voler eliminare questo veicolo?',
        'route' => route('vehicles.destroy', $vehicle->id),
    ])

    @php
        switch ($vehicle->type) {
            case 'car':
                $vehicleImage = 'car.png';
                break;
            case 'bike':
                $vehicleImage = 'bike.png';
                break;
            case 'scooter':
                $vehicleImage = 'scooter.png';
                break;
            default:
                break;
        }
    @endphp

    <div class="flex flex-col gap-6">
        <div class="card">
            <div class="flex-col md:flex-row md:gap-6 card-body">
                <div class="md:w-2/5">
                    <img src="{{ asset('images/' . $vehicleImage) }}" alt="{{ $vehicle->model }}"
                        class="w-full mb-4 md:mb-0 rounded-2xl">
                </div>
                <div class="md:w-3/5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-sm text-gray-500">Modello</div>
                            <div class="font-medium">{{ $vehicle->model }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Tipo</div>
                            <div class="font-medium">{{ ucfirst($vehicle->type) }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Capacità batteria</div>
                            <div class="relative w-20 mt-1 overflow-hidden badge">
                                <div class="absolute top-0 left-0 h-full rounded-lg bg-gradient-to-br {{ $vehicle->battery_capacity > 80 ? ' from-green-500 to-green-400' : ($vehicle->battery_capacity > 30 ? 'from-yellow-500 to-yellow-400' : 'from-red-500 to-red-400') }}"
                                    style="width: {{ $vehicle->battery_capacity }}%;"></div>
                                <div
                                    class="absolute inset-0 flex items-center justify-center text-xs gap-1 font-semibold text-base-content dark:text-white {{ $vehicle->battery_capacity > 80 ? 'text-white' : '' }}">
                                    <x-lucide-battery-charging class="size-5" />
                                    {{ $vehicle->battery_capacity }}%
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Tariffa oraria</div>
                            <div class="relative mt-1 badge">
                                {{ $vehicle->hourly_rate }} &euro; / h
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Stato</div>
                            <div class="relative mt-1 badge">
                                @switch($vehicle->status)
                                    @case('available')
                                        <div class="relative">
                                            <div class="bg-green-500 rounded-full animate-ping size-2"
                                                style="animation-duration: 4s;">
                                            </div>
                                            <div
                                                class="absolute -translate-x-1/2 -translate-y-1/2 bg-green-500 border rounded-full top-1/2 left-1/2 border-white/20 size-2">
                                            </div>
                                        </div>
                                    @break

                                    @case('rented')
                                        <div class="bg-yellow-500 rounded-full size-2">
                                        </div>
                                    @break

                                    @case('maintenance')
                                        <div class="bg-red-500 rounded-full size-2">
                                        </div>
                                    @break

                                    @default
                                @endswitch
                                {{ ucwords($vehicle->status) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Creato il</div>
                            <div class="font-medium">{{ $vehicle->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Aggiornato il</div>
                            <div class="font-medium">{{ $vehicle->updated_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="col-span-2">
                            <div class="text-sm text-gray-500">Tags</div>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach ($vehicle->tags as $tag)
                                    <div
                                        class="badge {{ $tag->name == 'New' ? 'text-white bg-gradient-to-br from-orange-600 to-orange-400' : '' }}">
                                        @if ($tag->name === 'New')
                                            <x-lucide-star class="size-3" />
                                        @endif
                                        {{ $tag->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <h2 class="mb-4 text-xl font-semibold">Noleggi</h2>
                @if ($vehicle->customers->isNotEmpty())
                    <div class="space-y-3">
                        @foreach ($vehicle->customers as $customer)
                            <div class="p-3 border rounded-lg">
                                <div class="font-medium">{{ $customer->name }} {{ $customer->surname }}</div>
                                <div class="text-sm text-gray-500">
                                    Dal: {{ \Carbon\Carbon::parse($customer->pivot->start_time)->format('d/m/Y H:i') }}
                                    @if ($customer->pivot->end_time)
                                        <br>Al:
                                        {{ \Carbon\Carbon::parse($customer->pivot->end_time)->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                                <div
                                    class="mt-1 badge {{ $customer->pivot->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($customer->pivot->status) }}
                                </div>
                                @if ($customer->pivot->total_cost)
                                    <div class="mt-1 text-sm font-medium">
                                        Costo totale: {{ $customer->pivot->total_cost }} &euro;
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 border border-dashed rounded-xl">
                        Nessun noleggio registrato per questo veicolo
                    </div>
                @endif
            </div>
        </div>
    @endsection
