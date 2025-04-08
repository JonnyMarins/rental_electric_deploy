@extends('layouts.app')

@section('title', 'Completa Noleggio')

@section('content')
    <form action="{{ route('rentals.complete.store', $rental->id) }}" method="POST"
        class="flex flex-col max-w-xs gap-4 px-4 mx-auto">
        <h1 class="text-xl">Completa Noleggio</h1>
        @csrf
        @method('POST')

        <h3 class="text-sm">Data e Ora di Fine</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500"
            placeholder="Data e ora di fine" type="datetime-local" name="end_time" value="{{ old('end_time') }}" required>

        <h3 class="text-sm">Stato del Noleggio</h3>
        <select class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg text-gray-300" name="status" required>
            <option value="" disabled selected>Seleziona uno stato</option>
            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completato</option>
            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Annullato</option>
        </select>

        <button class="px-4 py-2 text-white bg-blue-500 rounded-lg" type="submit">Completa Noleggio</button>
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
