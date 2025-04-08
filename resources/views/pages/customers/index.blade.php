@extends('layouts.app')

@section('title', 'Customers')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="mb-4 text-2xl font-semibold">Clienti</h1>
        <a class="btn btn-gradient btn-primary" href="{{ route('customers.create') }}">
            <x-lucide-plus class="size-4" />Aggiungi cliente
        </a>
    </div>
    @include('includes.success-alert')
    <div class="grid gap-4 md:grid-cols-3">
        @foreach ($customers as $customer)
            @include('includes.customer-card')
        @endforeach
    </div>
    @if (count($customers) === 0)
        <div class="w-full p-6 mt-6 text-center text-gray-500 border border-dashed rounded-xl bg-gray-50">
            Nessun cliente registrato
        </div>
    @endif
@endsection
