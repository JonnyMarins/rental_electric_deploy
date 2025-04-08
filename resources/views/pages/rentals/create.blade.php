@extends('layouts.app')

@section('title', 'Crea Noleggio')

@section('content')
    <form action="{{ route('rentals.store') }}" method="post" class="flex flex-col max-w-xs gap-4 px-4 mx-auto">
        <h1 class="text-xl">Crea Noleggio</h1>
        @csrf
        <h3 class="text-sm">Veicolo</h3>
        <select class="px-4 py-2 text-gray-300 bg-gray-800 border border-gray-500 rounded-lg" name="vehicle_id" required>
            <option value="" disabled selected>Seleziona un veicolo</option>
            @foreach ($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                    {{ $vehicle->model }}</option>
            @endforeach
        </select>
        <h3 class="text-sm">Cliente</h3>
        <select class="px-4 py-2 text-gray-300 bg-gray-800 border border-gray-500 rounded-lg" name="customer_id" required>
            <option value="" disabled selected>Seleziona un cliente</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}</option>
            @endforeach
        </select>
        <h3 class="text-sm">Data e Ora di Inizio</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500"
            type="datetime-local" name="start_time" value="{{ old('start_time') }}" required>
        <h3 class="text-sm">Data e Ora di Fine</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500"
            type="datetime-local" name="end_time" value="{{ old('end_time') }}" onchange="calculateCost()">
        {{-- <div class="flex items-center justify-between">
            <h3 class="text-sm">Costo totale</h3>
            <input class="text-right text-gray-300 bg-transparent " type="text" name="total_cost" id="total_cost"
                style="pointer-events: none;" size="10" readonly>
        </div> --}}
        <input type="hidden" name="status" value="active">
        <button class="px-4 py-2 text-white bg-blue-500 rounded-lg" type="submit">Invia</button>
    </form>
    <script>
        window.onload = function() {
            document.getElementById('total_cost').value = '$ 0.00';
        };

        function calculateCost() {
            let startTime = new Date(document.querySelector('[name=start_time]').value);
            let endTime = new Date(document.querySelector('[name=end_time]').value);

            if (isNaN(startTime) || isNaN(endTime) || endTime <= startTime) {
                document.getElementById('total_cost').value = '0.00';
                return;
            }

            let hours = Math.abs(endTime - startTime) / 36e5;
            let cost = (hours * 0.50).toFixed(2);
            document.getElementById('total_cost').value = cost;

        }
    </script>
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
