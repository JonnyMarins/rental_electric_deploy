<div class="relative card">
    <div class="p-4 card-body">
        <div class="flex items-center justify-between">
            <h5 class="card-title">{{ $customer->name }}</h5>
            <a class="btn btn-square btn-soft" href="{{ route('customers.show', $customer->id) }}">
                <x-lucide-eye class="size-4" />
            </a>
        </div>
        <div class="text-lg font-medium text-gray-500">{{ $customer->email }}</div>
        <a href="{{ route('customers.show', $customer->id) }}">
            <div
                class="flex items-center justify-center w-full p-4 my-4 text-center bg-gray-100 rounded-2xl dark:bg-gray-800">
                <x-lucide-user class="size-20 text-primary" />
            </div>
        </a>
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <div class="badge badge-outline">
                <x-lucide-phone class="mr-1 size-4" />
                {{ $customer->phone }}
            </div>
            <div class="badge badge-outline">
                <x-lucide-credit-card class="mr-1 size-4" />
                {{ $customer->license_number }}
            </div>
        </div>
        <div class="w-full h-px my-4 bg-gray-900/10 dark:bg-white/10"></div>
        <div class="flex flex-col space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Noleggi attivi:</span>
                <span
                    class="font-semibold badge badge-primary">{{ $customer->rentals()->where('status', 'active')->count() }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Noleggi totali:</span>
                <span class="font-semibold badge">{{ $customer->rentals_count ?? $customer->rentals()->count() }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Cliente dal:</span>
                <span class="text-sm">{{ $customer->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>
