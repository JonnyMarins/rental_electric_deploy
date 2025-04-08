@extends('layouts.app')

@section('title', 'Crea Cliente')

@section('content')
    <form action="{{ route('customers.store') }}" method="post" class="flex flex-col max-w-xs gap-4 px-4 mx-auto">
        <h1 class="text-xl">Crea Cliente</h1>
        @csrf

        <h3 class="text-sm">Nome</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500" placeholder="Nome"
            type="text" name="name" value="{{ old('name') }}" required>

        <h3 class="text-sm">Email</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500" placeholder="Email"
            type="email" name="email" value="{{ old('email') }}" required>

        <h3 class="text-sm">Telefono</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500"
            placeholder="Telefono" type="text" name="phone" value="{{ old('phone') }}" required>

        <h3 class="text-sm">Numero di Patente</h3>
        <input class="px-4 py-2 bg-gray-800 border border-gray-500 rounded-lg placeholder:text-gray-500"
            placeholder="Numero di Patente" type="text" name="license_number" value="{{ old('license_number') }}"
            required>

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
