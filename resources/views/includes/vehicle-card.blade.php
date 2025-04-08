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

<div class="relative card" href="{{ route('vehicles.show', $vehicle->id) }}">
    <div class="p-4 card-body">
        <div class="flex items-center justify-between">
            <h5 class="card-title">{{ $vehicle->model }}</h5>
            <div class="dropdown relative inline-flex rtl:[--placement:bottom-end]">
                <button id="dropdown-menu-icon" type="button" class="btn btn-square btn-soft" aria-haspopup="menu"
                    aria-expanded="false" aria-label="Dropdown">
                    <span class="icon-[tabler--dots-vertical] size-6"></span>
                </button>
                <ul class="hidden rounded-2xl dropdown-menu dropdown-open:opacity-100 min-w-60" role="menu"
                    aria-orientation="vertical" aria-labelledby="dropdown-menu-icon">
                    <li>
                        <a class="rounded-xl dropdown-item" href="{{ route('vehicles.show', $vehicle->id) }}">
                            <x-lucide-eye class="size-4" />Mostra
                        </a>
                    </li>
                    <li>
                        <a class="rounded-xl dropdown-item" href="{{ route('vehicles.edit', $vehicle->id) }}">
                            <x-lucide-pencil class="size-4" />Modifica
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button
                                class="justify-start text-red-500 rounded-xl hover:bg-red-500/10 dropdown-item"><x-lucide-trash
                                    class="size-4" />
                                Elimina</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="text-lg font-medium text-gray-500">{{ ucfirst($vehicle->type) }}</div>
        <a href="{{ route('vehicles.show', $vehicle->id) }}">
            <img src="{{ asset('images/' . $vehicleImage) }}" alt="{{ $vehicle->model }}" class="w-full rounded-2xl">
        </a>
        <div class="flex flex-wrap items-center gap-2">
            <div class="relative w-20 overflow-hidden badge">
                <div class="absolute top-0 left-0 h-full rounded-lg bg-gradient-to-br {{ $vehicle->battery_capacity > 80 ? ' from-green-500 to-green-400' : ($vehicle->battery_capacity > 30 ? 'from-yellow-500 to-yellow-400' : 'from-red-500 to-red-400') }}"
                    style="width: {{ $vehicle->battery_capacity }}%;"></div>
                <div
                    class="absolute inset-0 flex items-center justify-center text-xs gap-1 font-semibold text-base-content dark:text-white {{ $vehicle->battery_capacity > 80 ? 'text-white' : '' }}">
                    <x-lucide-battery-charging class="size-5" />
                    {{ $vehicle->battery_capacity }}%
                </div>
            </div>
            <div class="relative badge">
                @switch($vehicle->status)
                    @case('available')
                        <div class="relative">
                            <div class="bg-green-500 rounded-full animate-ping size-2" style="animation-duration: 4s;">
                            </div>
                            <div
                                class="absolute font-semibold -translate-x-1/2 -translate-y-1/2 bg-green-500 border rounded-full top-1/2 left-1/2 border-white/20 size-2">
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
            <div class="relative badge">
                {{ $vehicle->hourly_rate }} &euro; / h
            </div>
        </div>
        @if ($vehicle->tags->count() > 0)
            <div class="w-full h-px my-4 bg-gray-900/10 dark:bg-white/10"></div>
            <div class="flex flex-wrap gap-2 text-sm">
                @foreach ($vehicle->tags as $tag)
                    <div
                        class="badge {{ $tag->name == 'New' ? 'text-white bg-gradient-to-br from-orange-600 to-orange-400' : '' }}">
                        @if ($tag->name === 'New')
                            <x-lucide-star class="size-3" />
                        @endif
                        {{ $tag->name }}
                    </div>
                @endforeach
        @endif
    </div>
</div>
</div>
