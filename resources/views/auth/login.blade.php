@extends('layouts.app')

@section('title', 'Login')

@section('content')
<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<!-- Main Container -->
<main class="w-full max-w-md px-margin-page mx-auto flex items-center justify-center min-h-screen">
    <!-- Login Card -->
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_10px_15px_-3px_rgba(0,0,0,0.05)] border border-outline-variant/30 p-8 flex flex-col gap-stack-lg">
        <!-- Header Section -->
        <div class="flex flex-col items-center text-center gap-stack-sm">
            <!-- Brand / Logo Area -->
            <div class="flex items-center gap-2 mb-2">
                <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-primary shadow-sm">
                    <span class="material-symbols-outlined icon-fill">health_and_safety</span>
                </div>
                <span class="font-headline-md text-headline-md text-primary">MediFlow ERP</span>
            </div>
            <h1 class="font-headline-sm text-headline-sm text-on-surface">Welcome Back</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Please enter your credentials to access the system.</p>
        </div>

        <!-- Form Section -->
        <form action="{{ route('login') }}" class="flex flex-col gap-stack-md" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="flex flex-col gap-1">
                <label class="font-label-md text-label-md text-on-surface" for="email">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </div>
                    <input class="block w-full pl-10 pr-3 py-3 border border-outline-variant rounded-lg bg-surface-bright text-on-surface focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm min-h-[44px] transition-shadow duration-200 @error('email') border-error @enderror" id="email" name="email" placeholder="doctor@mediflow.com" required type="email" value="{{ old('email') }}" autofocus autocomplete="username">
                </div>
                @error('email')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="flex flex-col gap-1">
                <div class="flex justify-between items-center">
                    <label class="font-label-md text-label-md text-on-surface" for="password">Password</label>
                    @if (Route::has('password.request'))
                        <a class="font-label-md text-label-md text-primary hover:text-primary-fixed-dim transition-colors" href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </div>
                    <input class="block w-full pl-10 pr-10 py-3 border border-outline-variant rounded-lg bg-surface-bright text-on-surface focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm min-h-[44px] transition-shadow duration-200 @error('password') border-error @enderror" id="password" name="password" placeholder="••••••••" required type="password" autocomplete="current-password">
                    <button aria-label="Toggle password visibility" class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface transition-colors" type="button">
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary">
                <label for="remember_me" class="ml-2 text-sm text-on-surface-variant">Remember me</label>
            </div>

            <!-- Submit Button -->
            <button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm font-label-md text-label-md text-on-primary bg-primary hover:bg-primary-container hover:text-on-primary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary min-h-[44px] transition-colors duration-200 mt-2" type="submit">
                Sign In
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-4 text-center">
            <p class="font-label-md text-label-md text-outline-variant uppercase tracking-wider">
                Role-based access system
            </p>
            <div class="flex items-center justify-center gap-1 mt-2 text-outline-variant">
                <span class="material-symbols-outlined text-[16px]">verified_user</span>
                <span class="text-[10px]">Secure Encrypted Connection</span>
            </div>
        </div>
    </div>
</main>
@endsection
