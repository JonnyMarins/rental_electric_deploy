@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
    <div class="space-y-8">

        <!-- Statistiche principali -->
        <div class="grid gap-4 md:grid-cols-3">
            <div class="p-6 text-center card bg-base-100">
                <div class="card-body">
                    <div class="flex flex-col items-center justify-center">
                        <x-lucide-car class="mb-4 size-12 text-primary" />
                        <h2 class="text-3xl font-bold text-primary">{{ \App\Models\Vehicle::count() }}</h2>
                        <p class="text-lg">Veicoli Disponibili</p>
                    </div>
                </div>
            </div>

            <div class="p-6 text-center card bg-base-100">
                <div class="card-body">
                    <div class="flex flex-col items-center justify-center">
                        <x-lucide-users class="mb-4 size-12 text-primary" />
                        <h2 class="text-3xl font-bold text-primary">{{ \App\Models\Customer::count() }}</h2>
                        <p class="text-lg">Clienti Registrati</p>
                    </div>
                </div>
            </div>

            <div class="p-6 text-center card bg-base-100">
                <div class="card-body">
                    <div class="flex flex-col items-center justify-center">
                        <x-lucide-calendar-days class="mb-4 size-12 text-primary" />
                        <h2 class="text-3xl font-bold text-primary">
                            {{ \App\Models\Rental::where('status', 'active')->count() }}</h2>
                        <p class="text-lg">Noleggi Attivi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sezioni principali -->
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Veicoli in evidenza -->
            <div class="card bg-base-100">
                <div class="flex items-center justify-between p-4 border-b card-header">
                    <h3 class="text-xl font-semibold">Veicoli in Evidenza</h3>
                    <a href="{{ route('vehicles.index') }}" class="text-primary link">Vedi tutti</a>
                </div>
                <div class="p-4 card-body">
                    @php
                        $featuredVehicles = \App\Models\Vehicle::whereRelation('tags', 'name', 'New')
                            ->orWhere('status', 'available')
                            ->take(3)
                            ->get();
                    @endphp

                    @if ($featuredVehicles->isEmpty())
                        <div class="w-full p-4 text-center text-gray-500 border border-dashed rounded-xl">
                            Nessun veicolo disponibile
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach ($featuredVehicles as $vehicle)
                                <div class="flex items-center p-3 transition-all rounded-lg hover:bg-base-200">
                                    <div class="mr-4">
                                        <div class="p-2 rounded-full bg-primary/10">
                                            <x-lucide-car class="size-8 text-primary" />
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                            class="font-semibold hover:underline">
                                            {{ $vehicle->model }}
                                        </a>
                                        <p class="text-sm text-gray-500">{{ $vehicle->type }} -
                                            {{ $vehicle->battery_capacity }} kWh</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center">
                                            <span class="font-medium">€{{ $vehicle->hourly_rate }}/h</span>
                                        </div>
                                        <span
                                            class="text-sm badge badge-outline {{ $vehicle->status === 'available' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $vehicle->status === 'available' ? 'Disponibile' : 'In Noleggio' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ultimi noleggi -->
            <div class="card bg-base-100">
                <div class="flex items-center justify-between p-4 border-b card-header">
                    <h3 class="text-xl font-semibold">Ultimi Noleggi</h3>
                    <a href="{{ route('rentals.index') }}" class="text-primary link">Vedi tutti</a>
                </div>
                <div class="p-4 card-body">
                    @php
                        $recentRentals = \App\Models\Rental::with(['customer', 'vehicle'])
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
                    @endphp

                    @if ($recentRentals->isEmpty())
                        <div class="w-full p-4 text-center text-gray-500 border border-dashed rounded-xl">
                            Nessun noleggio registrato
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach ($recentRentals as $rental)
                                <div class="flex items-center p-3 transition-all rounded-lg hover:bg-base-200">
                                    <div class="mr-4">
                                        <div class="p-2 rounded-full bg-secondary/10">
                                            <x-lucide-calendar-days class="size-8 text-secondary" />
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold">
                                            <a href="{{ route('customers.show', $rental->customer_id) }}"
                                                class="hover:underline">
                                                {{ $rental->customer->name }}
                                            </a>
                                        </div>
                                        <p class="text-sm">
                                            <a href="{{ route('vehicles.show', $rental->vehicle_id) }}"
                                                class="text-primary hover:underline">
                                                {{ $rental->vehicle->model }}
                                            </a>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">{{ $rental->start_time }}</div>
                                        <span
                                            class="badge {{ $rental->status === 'active' ? 'badge-primary' : 'badge-ghost' }}">
                                            {{ $rental->status === 'active' ? 'Attivo' : 'Completato' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Funzionalità principali -->
        <div class="grid gap-6 md:grid-cols-3">
            <div class="text-center card bg-base-100">
                <div class="flex flex-col gap-3 card-body">
                    <div class="flex justify-center">
                        <div class="p-3 rounded-full bg-primary/10">
                            <x-lucide-car class="size-10 text-primary" />
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold">Gestione Veicoli</h3>
                    <p class="text-sm text-gray-500">Aggiungi, modifica e monitora tutti i veicoli elettrici della flotta
                    </p>
                    <div class="mt-auto card-actions">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-sm btn-block">
                            Gestisci Veicoli
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center card bg-base-100">
                <div class="flex-col gap-3 card-body">
                    <div class="flex justify-center">
                        <div class="p-3 rounded-full bg-secondary/10">
                            <x-lucide-users class="size-10 text-secondary" />
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold">Gestione Clienti</h3>
                    <p class="text-sm text-gray-500">Gestisci l'anagrafica clienti e visualizza la loro storia di noleggi
                    </p>
                    <div class="mt-auto card-actions">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm btn-block">
                            Gestisci Clienti
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center card bg-base-100">
                <div class="flex-col gap-3 card-body">
                    <div class="flex justify-center">
                        <div class="p-3 rounded-full bg-accent/10">
                            <x-lucide-calendar-days class="size-10 text-accent" />
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold">Gestione Noleggi</h3>
                    <p class="text-sm text-gray-500">Crea nuovi noleggi e monitora quelli attualmente attivi</p>
                    <div class="mt-auto card-actions">
                        <a href="{{ route('rentals.index') }}" class="btn btn-accent btn-sm btn-block">
                            Gestisci Noleggi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
