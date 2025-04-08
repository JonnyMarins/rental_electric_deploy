@extends('layouts.app')

@section('title', 'Noleggi')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="mb-4 text-2xl font-semibold">Noleggi</h1>
        <a class="btn btn-gradient btn-primary" href="{{ route('rentals.create') }}">
            <x-lucide-plus class="size-4" />Aggiungi noleggio
        </a>
    </div>
    @include('includes.success-alert')

    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
        @foreach ($rentals as $rental)
            <div class="card">
                <div class="p-5 card-body">
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="font-bold card-title">
                            #{{ $rental->id }}
                            <a href="{{ route('vehicles.show', $rental->vehicle_id) }}"
                                class="text-primary hover:underline">
                                {{ $rental->vehicle->brand ?? '' }} {{ $rental->vehicle->model }}
                            </a>
                        </h5>
                    </div>

                    <div class="mb-3">
                        <span class="text-sm text-gray-500">Cliente:</span>
                        <a href="{{ route('customers.show', $rental->customer_id) }}" class="hover:underline">
                            {{ $rental->customer->name }}
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div>
                            <div class="text-sm text-gray-500">Inizio noleggio</div>
                            <div class="font-medium">{{ $rental->start_time }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Fine noleggio</div>
                            <div class="font-medium">
                                {{ $rental->end_time ? $rental->end_time : 'In corso' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-sm text-gray-500">Costo totale:</span>
                            <span class="font-semibold">€{{ number_format($rental->total_cost, 2) }}</span>
                        </div>
                        <div>
                            @php
                                $statusColor = 'bg-gray-100 text-gray-800';
                                if ($rental->status === 'active') {
                                    $statusColor = 'bg-blue-100 text-blue-800';
                                } elseif ($rental->status === 'completed') {
                                    $statusColor = 'bg-green-100 text-green-800';
                                } elseif ($rental->status === 'cancelled') {
                                    $statusColor = 'bg-red-100 text-red-800';
                                }
                            @endphp
                            <span class="badge {{ $statusColor }}">{{ ucfirst($rental->status) }}</span>
                        </div>
                    </div>

                    <div class="w-full h-px my-4 bg-gray-900/10 dark:bg-white/10"></div>

                    @if ($rental->status !== 'completed')
                        <form action="{{ route('rentals.complete', $rental->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full btn btn-success">
                                <x-lucide-check class="size-4" />Completa noleggio
                            </button>
                        </form>
                    @else
                        <div class="w-full text-green-800 btn btn-disabled bg-green-500/10">
                            <x-lucide-check class="size-4" />Noleggio completato
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if (count($rentals) === 0)
        <div class="w-full p-6 mt-6 text-center text-gray-500 border border-dashed rounded-xl bg-gray-50">
            Nessun noleggio registrato
        </div>
    @endif
@endsection
