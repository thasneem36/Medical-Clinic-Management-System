@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-stack-lg gap-4">
    <div>
        <h2 class="text-headline-lg font-headline-lg text-on-background">Appointment Details</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-1">View appointment information and status.</p>
    </div>
    <div class="flex gap-2">
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
        <a href="{{ route('appointments.edit', $appointment->id) }}" class="bg-surface-container-high text-on-surface px-4 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-surface-container-highest shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">edit</span>
            Edit Appointment
        </a>
        @endif
        <a href="{{ route('appointments.index') }}" class="bg-outline text-on-surface px-4 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-outline-variant shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to List
        </a>
    </div>
</div>

<!-- Appointment Information Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden mb-stack-lg">
    <div class="p-6 border-b border-outline-variant bg-surface-bright">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-2xl shrink-0">
                <span class="material-symbols-outlined">event</span>
            </div>
            <div class="flex-1">
                <h3 class="text-headline-md font-headline-md text-primary font-semibold">Appointment #APT-{{ str_pad($appointment->id ?? 0, 5, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">{{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }} at {{ $appointment->time }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($appointment->status === 'completed') bg-secondary/10 text-secondary
                    @elseif($appointment->status === 'cancelled') bg-error/10 text-error
                    @elseif($appointment->status === 'confirmed') bg-primary/10 text-primary
                    @elseif($appointment->status === 'waiting') bg-tertiary/10 text-tertiary
                    @else bg-surface-variant text-on-surface-variant @endif">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
        </div>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Patient</p>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">
                    {{ substr($appointment->patient->name ?? 'Unknown', 0, 1) }}
                </div>
                <p class="text-body-lg font-body-lg text-on-background">{{ $appointment->patient->name ?? 'N/A' }}</p>
            </div>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Doctor</p>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-xs">
                    {{ substr($appointment->doctor->name ?? 'Unknown', 0, 1) }}
                </div>
                <p class="text-body-lg font-body-lg text-on-background">{{ $appointment->doctor->name ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="md:col-span-2">
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Reason for Visit</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $appointment->reason ?? 'No reason provided.' }}</p>
        </div>
    </div>
</div>

<!-- Billing Section -->
@if($appointment->billing)
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
        <h3 class="text-headline-md font-headline-md text-primary font-semibold">Billing Information</h3>
        <a href="{{ route('billing.show', $appointment->billing->id) }}" class="text-primary text-label-md font-label-md hover:underline">View Invoice</a>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Invoice #</p>
            <p class="text-body-lg font-body-lg text-on-background">#INV-{{ str_pad($appointment->billing->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Amount</p>
            <p class="text-body-lg font-body-lg text-on-background font-semibold">${{ number_format($appointment->billing->amount, 2) }}</p>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Status</p>
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                @if($appointment->billing->status === 'paid') bg-secondary/10 text-secondary
                @elseif($appointment->billing->status === 'overdue') bg-error/10 text-error
                @else bg-surface-variant text-on-surface-variant @endif">
                {{ ucfirst($appointment->billing->status) }}
            </span>
        </div>
    </div>
</div>
@else
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 text-center text-on-surface-variant">
        <p class="text-body-md font-body-md">No invoice generated for this appointment.</p>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
        <a href="{{ route('billing.create') }}" class="text-primary text-label-md font-label-md hover:underline mt-2 inline-block">Create Invoice</a>
        @endif
    </div>
</div>
@endif
@endsection
