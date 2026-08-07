<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MediFlow ERP') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background font-body-md min-h-screen antialiased">
    @auth
        <!-- SideNavBar -->
        <nav class="bg-surface-container-low w-sidebar-width h-screen fixed left-0 top-0 border-r border-outline-variant flex flex-col py-gutter z-50 hidden md:flex">
            <!-- Header -->
            <div class="px-gutter mb-stack-lg flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined icon-fill">local_hospital</span>
                </div>
                <div>
                    <h1 class="font-headline-sm text-headline-sm text-primary">MediFlow ERP</h1>
                    <p class="font-label-md text-label-md text-on-surface-variant">Clinical Excellence</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 flex flex-col gap-1">
                <!-- Dashboard -->
                <a class="flex items-center gap-3 px-4 py-3 @if(request()->routeIs('dashboard')) bg-surface-variant text-primary border-l-4 border-primary font-bold rounded-r-lg opacity-90 @else text-on-surface-variant hover:bg-surface-container-high @endif transition-all rounded-lg" href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-label-md text-label-md">Dashboard</span>
                </a>

                <!-- Patients -->
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
                <a class="flex items-center gap-3 px-4 py-3 @if(request()->routeIs('patients.*')) bg-surface-variant text-primary border-l-4 border-primary font-bold rounded-r-lg opacity-90 @else text-on-surface-variant hover:bg-surface-container-high @endif transition-all rounded-lg" href="{{ route('patients.index') }}">
                    <span class="material-symbols-outlined">person</span>
                    <span class="font-label-md text-label-md">Patients</span>
                </a>
                @endif

                <!-- Appointments -->
                <a class="flex items-center gap-3 px-4 py-3 @if(request()->routeIs('appointments.*')) bg-surface-variant text-primary border-l-4 border-primary font-bold rounded-r-lg opacity-90 @else text-on-surface-variant hover:bg-surface-container-high @endif transition-all rounded-lg" href="{{ route('appointments.index') }}">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span class="font-label-md text-label-md">Appointments</span>
                </a>

                <!-- Doctors -->
                @if(auth()->user()->role === 'admin')
                <a class="flex items-center gap-3 px-4 py-3 @if(request()->routeIs('doctors.*')) bg-surface-variant text-primary border-l-4 border-primary font-bold rounded-r-lg opacity-90 @else text-on-surface-variant hover:bg-surface-container-high @endif transition-all rounded-lg" href="{{ route('doctors.index') }}">
                    <span class="material-symbols-outlined">medical_services</span>
                    <span class="font-label-md text-label-md">Doctors</span>
                </a>
                @endif

                <!-- Billing -->
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
                <a class="flex items-center gap-3 px-4 py-3 @if(request()->routeIs('billing.*')) bg-surface-variant text-primary border-l-4 border-primary font-bold rounded-r-lg opacity-90 @else text-on-surface-variant hover:bg-surface-container-high @endif transition-all rounded-lg" href="{{ route('billing.index') }}">
                    <span class="material-symbols-outlined">payments</span>
                    <span class="font-label-md text-label-md">Billing</span>
                </a>
                @endif
            </div>

            <!-- Footer / CTA -->
            <div class="px-4 mt-auto flex flex-col gap-4">
                <button class="w-full py-2 px-4 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined icon-fill text-[18px]">add</span>
                    Quick Book
                </button>
                <div class="h-px bg-outline-variant/50 w-full"></div>
                <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg" href="#">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-label-md text-label-md">Settings</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2 text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg w-full">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="font-label-md text-label-md">Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        <!-- TopAppBar & Main Content -->
        <div class="ml-[260px] min-h-screen flex flex-col">
            <!-- TopAppBar -->
            <header class="bg-surface border-b border-outline-variant shadow-sm w-full top-0 sticky z-40 flex justify-between items-center h-16 px-margin-page">
                <div class="flex items-center gap-4">
                    <h2 class="font-headline-md text-headline-md font-bold text-primary">MediFlow ERP</h2>
                    <div class="relative hidden md:block w-64 ml-4">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                        <input class="w-full pl-10 pr-4 py-1.5 bg-surface-container-low border-none rounded-full font-body-md text-body-md focus:ring-2 focus:ring-primary outline-none" placeholder="Search patients, doctors..." type="text">
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="text-on-surface-variant hover:text-primary cursor-pointer hover:scale-105 duration-200 transition-transform relative p-1.5 rounded-full hover:bg-surface-container-low">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full border border-surface"></span>
                    </button>
                    <button class="text-on-surface-variant hover:text-primary cursor-pointer hover:scale-105 duration-200 transition-transform p-1.5 rounded-full hover:bg-surface-container-low">
                        <span class="material-symbols-outlined">help</span>
                    </button>
                    <div class="flex items-center gap-3 ml-2">
                        <div class="text-right hidden sm:block">
                            <p class="font-label-md text-label-md text-on-surface">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-on-surface-variant uppercase">{{ auth()->user()->role }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full overflow-hidden cursor-pointer border border-outline-variant">
                            <div class="w-full h-full bg-primary-container flex items-center justify-center text-on-primary-container font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-margin-page bg-surface-bright">
                @yield('content')
            </main>
        </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
