@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="mb-4 text-2xl font-semibold">Veicoli</h1>
        <a class="btn btn-gradient btn-primary" href="{{ route('vehicles.create') }}">
            <x-lucide-plus class="size-4" />Aggiungi veicolo
        </a>
    </div>
    @include('includes.success-alert')
    @if (!$newVehicles->isEmpty())
        <div class="grid gap-4 pb-5 mb-5 border-b dark:border-white/10 md:grid-cols-3">
            @foreach ($newVehicles as $vehicle)
                @include('includes.vehicle-card', ['type' => 'new'])
            @endforeach
        </div>
    @endif
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($vehicles as $vehicle)
            @include('includes.vehicle-card')
        @endforeach
    </div>
    @if ($vehicles->isEmpty())
        <div class="w-full p-4 mt-4 border border-dashed rounded-xl">
            Nessun veicolo registrato
        </div>
    @endif
@endsection
