@extends('layouts.app')

@section('title', 'Dettaglio Cliente - ' . $customer->name)

@section('content')
    <div class="mb-4">
        <h1 class="flex items-center gap-2 text-2xl font-semibold">
            <a href="{{ route('customers.index') }}" class="font-normal">Tutti i clienti</a>
            <x-lucide-chevron-right class="size-4" />{{ $customer->name }}
        </h1>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="md:col-span-1">
            <div class="card">
                <div class="p-6 card-body">
                    <div class="flex items-center justify-center mb-6">
                        <div class="p-6 bg-gray-100 rounded-full dark:bg-gray-800">
                            <x-lucide-user class="size-24 text-primary" />
                        </div>
                    </div>

                    <h2 class="mb-2 text-xl font-bold text-center">{{ $customer->name }}</h2>
                    <p class="mb-6 text-center text-gray-500">{{ $customer->email }}</p>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <x-lucide-phone class="mr-3 text-gray-500 size-5" />
                            <span>{{ $customer->phone }}</span>
                        </div>

                        <div class="flex items-center">
                            <x-lucide-credit-card class="mr-3 text-gray-500 size-5" />
                            <span>{{ $customer->license_number }}</span>
                        </div>

                        <div class="flex items-center">
                            <x-lucide-calendar class="mr-3 text-gray-500 size-5" />
                            <span>Cliente dal: {{ $customer->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="flex items-center">
                            <x-lucide-clock class="mr-3 text-gray-500 size-5" />
                            <span>Ultimo aggiornamento: {{ $customer->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="mb-6 card">
                <div class="p-4 border-b card-header">
                    <h3 class="text-lg font-semibold">Statistiche</h3>
                </div>
                <div class="p-6 card-body">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="flex flex-col p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                            <span
                                class="mb-2 text-3xl font-bold text-primary">{{ $customer->rentals()->where('status', 'active')->count() }}</span>
                            <span class="text-gray-500">Noleggi attivi</span>
                        </div>

                        <div class="flex flex-col p-4 rounded-lg bg-gray-50 dark:bg-gray-800">
                            <span
                                class="mb-2 text-3xl font-bold">{{ $customer->rentals_count ?? $customer->rentals()->count() }}</span>
                            <span class="text-gray-500">Noleggi totali</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b card-header">
                    <h3 class="text-lg font-semibold">Noleggi Attivi</h3>
                </div>
                <div class="p-0 card-body">
                    @php
                        $activeRentals = $customer->rentals()->where('status', 'active')->with('vehicle')->get();
                    @endphp

                    @if (count($activeRentals) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="p-4 text-left">Veicolo</th>
                                        <th class="p-4 text-left">Data inizio</th>
                                        <th class="p-4 text-left">Data fine</th>
                                        <th class="p-4 text-left">Costo</th>
                                        <th class="p-4 text-left">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($activeRentals as $rental)
                                        <tr>
                                            <td class="p-4">{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}
                                            </td>
                                            <td class="p-4">{{ $rental->start_time }}</td>
                                            <td class="p-4">
                                                {{ $rental->end_time ? $rental->end_time : 'In corso' }}
                                            </td>
                                            <td class="p-4">€{{ number_format($rental->total_cost, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            Nessun noleggio attivo al momento
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
