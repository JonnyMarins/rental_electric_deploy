@extends('layouts.app')

@section('title', 'Crea Veicolo')

@section('content')
    <form action="{{ route('vehicles.store') }}" method="post" class="flex flex-col max-w-xs gap-4 px-4 mx-auto">
        <h1 class="text-xl">Crea Veicolo</h1>
        @csrf
        <h3 class="text-sm">Modello</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500" placeholder="Modello"
            type="text" name="model" value="{{ old('model') }}" required>
        <h3 class="text-sm">Tipo</h3>
        <select class="px-4 py-2 text-gray-300 bg-gray-800 border border-gray-500 rounded-lg" name="type" required>
            <option value="" disabled selected>Seleziona un tipo</option>
            <option value="car" {{ old('type') == 'car' ? 'selected' : '' }}>Auto</option>
            <option value="scooter" {{ old('type') == 'scooter' ? 'selected' : '' }}>Scooter</option>
            <option value="bike" {{ old('type') == 'bike' ? 'selected' : '' }}>Bicicletta</option>
        </select>
        <h3 class="text-sm">Capacità Batteria</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500"
            placeholder="Capacità batteria" type="number" name="battery_capacity" value="{{ old('battery_capacity') }}"
            required>
        <h3 class="text-sm">Disponibilità</h3>
        <select class="px-4 py-2 text-gray-300 bg-gray-800 border border-gray-500 rounded-lg" name="status" required>
            <option value="" disabled selected>Seleziona uno stato</option>
            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponibile
            </option>
            <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Noleggiato</option>
            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>In Manutenzione
            </option>
        </select>
        <h3 class="text-sm">Tariffa Oraria</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500"
            placeholder="Tariffa oraria" type="number" name="hourly_rate" value="{{ old('hourly_rate') }}" required>
        <h3 class="text-sm">Tags</h3>
        @foreach ($tags as $tag)
            <div class="flex gap-2">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" />
                <label>{{ $tag->name }}</label>
            </div>
        @endforeach
        <button class="px-4 py-2 text-white bg-blue-500 rounded-lg" type="submit">Invia</button>
    </form>
    @if ($errors->any())
        <div class="text-red-500 bg-red-500/30">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
