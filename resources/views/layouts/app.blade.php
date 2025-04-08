<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <!-- Script per evitare il flash al cambio pagina -->
        <script>
            // Imposta il tema prima del rendering della pagina
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="max-w-screen-xl mx-auto">
        <header>
            <nav class="p-4 navbar rounded-box">
                <div class="w-full md:flex md:items-center md:gap-2">
                    <div class="flex items-center justify-between">
                        <div class="items-center justify-between navbar-start max-md:w-full">
                            <a class="flex items-center flex-none gap-3 text-2xl font-semibold no-underline link text-base-content link-neutral whitespace-nowrap"
                                href="{{ route('vehicles.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-none size-12"
                                    viewBox="0 0 328.81 235.19">
                                    <path
                                        d="M56.39,211.06c0,4.55.07,8.36-.01,12.17-.19,8.35-3.67,11.85-11.98,11.92-10.49.08-20.99.02-31.48,0-9.46-.01-12.86-3.38-12.88-13.02-.04-14.66-.02-29.32.06-43.98.09-15.99.21-31.98.42-47.96.16-12.04,1.53-23.89,5.87-35.27,3.06-8.01,7.9-14.54,15.81-19.45-4.46-1.14-8.26-1.94-11.96-3.09-7.14-2.21-10.59-7.2-9.7-13.65.94-6.86,7.22-12.51,14.07-12.52,7.84-.01,13.34,4.42,18.61,10.44,3.67-7.54,7.02-14.84,10.71-21.95,8.83-17.01,21.98-28.18,41.72-30.21,6.46-.67,12.89-1.65,19.36-2.13,43.1-3.2,86.18-3.41,129.22,1.03,1.46.15,2.91.47,5.51.9-50.67,34.86-100.47,69.13-151.27,104.08,23.22,7.94,45.58,15.59,68.65,23.48-5.6,6.52-10.84,12.67-16.13,18.76-16.57,19.11-33.1,38.27-49.86,57.22-1.58,1.78-4.68,2.98-7.13,3.08-8.95.36-17.92.14-27.58.14ZM77.25,149.34c-2.84-9.64-5.23-17.4-7.39-25.21-1.28-4.62-4.21-7.63-8.63-8.79-12.04-3.15-24.15-6.09-36.29-8.84-1.16-.26-3.78,1.14-3.96,2.11-1.2,6.28-2.67,12.67-2.58,19.01.1,7.47,4.36,13.29,11.92,14.65,15.13,2.72,30.4,4.64,46.94,7.08Z"
                                        style="fill: #20783d; stroke-width: 0px;" />
                                    <path
                                        d="M239.47,117.34c-22.19-7.6-44.39-15.21-67.12-22.99,8.71-9.84,16.93-19.11,25.14-28.4,11.75-13.3,23.48-26.63,35.25-39.92,5.17-5.84,10.27-11.77,15.75-17.3,1.22-1.23,4.17-1.8,5.9-1.28,14.49,4.32,23.75,14.7,30.55,27.57,3.71,7.02,6.99,14.28,10.7,21.93,2.39-2.07,4.48-4.08,6.78-5.81,5.49-4.14,11.31-5.76,18.19-3.11,6.02,2.32,7.98,8.55,7.84,13.54-.13,4.78-3.81,8.96-9.19,10.5-3.81,1.09-7.69,1.93-11.51,2.87-.03.46-.18.96-.05,1.04,13.61,9.33,18.35,23.46,19.39,38.73,1.27,18.58,1.31,37.25,1.58,55.88.25,17.16.13,34.32.09,51.48-.02,9.93-2.97,12.79-12.87,12.78-10.33-.02-20.66.01-30.99-.05-8.23-.05-11.48-3.19-11.79-11.46-.15-3.95-.03-7.91-.03-12.52H107.45c-.09-.36-.18-.71-.27-1.07,44.07-30.23,88.14-60.46,132.21-90.69.03-.57.05-1.14.08-1.71ZM251.5,148.69c6.63-.53,11.9-.73,17.11-1.42,10.19-1.35,20.42-2.63,30.5-4.61,5.7-1.11,9.71-5.12,11.31-10.89,2.08-7.44,1.27-14.8-1.07-22.09-1.08-3.37-3.01-4.36-6.4-3.5-11.28,2.88-22.65,5.4-33.85,8.54-2.99.84-6.96,2.78-7.97,5.25-3.67,8.96-6.27,18.35-9.64,28.71Z"
                                        style="fill: #74c043; stroke-width: 0px;" />
                                </svg> Rental Electric
                            </a>
                            <div class="md:hidden">
                                <button type="button"
                                    class="collapse-toggle btn btn-outline btn-secondary btn-sm btn-square"
                                    data-collapse="#default-navbar-collapse" aria-controls="default-navbar-collapse"
                                    aria-label="Toggle navigation">
                                    <span class="icon-[tabler--menu-2] collapse-open:hidden size-4"></span>
                                    <span class="icon-[tabler--x] collapse-open:block hidden size-4"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="default-navbar-collapse"
                        class="md:navbar-end collapse hidden grow basis-full overflow-hidden transition-[height] duration-300 max-md:w-full">
                        <ul class="gap-2 p-0 text-base font-medium menu md:menu-horizontal max-md:mt-2">
                            <li><a class="{{ request()->is('vehicles') ? 'active' : '' }}"
                                    href="{{ route('vehicles.index') }}"><x-lucide-car class="size-4" />
                                    Veicoli</a></li>
                            <li><a class="{{ request()->is('customers') ? 'active' : '' }}"
                                    href="{{ route('customers.index') }}"><x-lucide-users class="size-4" /> Clienti</a>
                            </li>
                            <li><a class="{{ request()->is('rentals') ? 'active' : '' }}"
                                    href="{{ route('rentals.index') }}"><x-lucide-calendar-days class="size-4" />
                                    Noleggi</a></li>
                            <li>
                                <div class="flex items-center justify-center">
                                    <label class="relative block leading-[0]">
                                        <input type="checkbox" id="theme-switch" class="switch switch-primary peer"
                                            aria-label="Cambia tema chiaro/scuro" />
                                        <x-lucide-moon
                                            class="absolute hidden pointer-events-none peer-checked:text-primary-content start-1 top-1 size-4 peer-checked:block" />
                                        <x-lucide-sun
                                            class="text-base-content peer-checked:text-base-content absolute end-1.5 top-1  block size-4 peer-checked:hidden pointer-events-none" />
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main id="main-container" class="p-4">
            @yield('content')
        </main>
        @stack('scripts')
    </body>

</html>
