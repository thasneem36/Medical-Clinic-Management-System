@extends('layouts.app')

@section('title', 'Doctor Details')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-stack-lg gap-4">
    <div>
        <h2 class="text-headline-lg font-headline-lg text-on-background">Doctor Details</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-1">View doctor information and appointment history.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('doctors.edit', $doctor->id) }}" class="bg-surface-container-high text-on-surface px-4 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-surface-container-highest shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">edit</span>
            Edit Doctor
        </a>
        <a href="{{ route('doctors.index') }}" class="bg-outline text-on-surface px-4 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-outline-variant shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to List
        </a>
    </div>
</div>

<!-- Doctor Information Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden mb-stack-lg">
    <div class="p-6 border-b border-outline-variant bg-surface-bright">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-2xl shrink-0">
                {{ substr($doctor->name ?? 'Unknown', 0, 2) }}
            </div>
            <div class="flex-1">
                <h3 class="text-headline-md font-headline-md text-primary font-semibold">{{ $doctor->name ?? 'Unknown' }}</h3>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Doctor ID: DR-{{ str_pad($doctor->id ?? 0, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-secondary/10 text-secondary">
                    Active
                </span>
            </div>
        </div>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Specialization</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $doctor->specialization ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Contact</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $doctor->contact ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Working Hours</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $doctor->working_hours ?? 'N/A' }}</p>
        </div>
    </div>
</div>

<!-- Appointments Section -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
        <h3 class="text-headline-md font-headline-md text-primary font-semibold">Appointment History</h3>
        <a href="{{ route('appointments.create') }}" class="text-primary text-label-md font-label-md hover:underline">Book New Appointment</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface border-b border-outline-variant">
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Date & Time</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Patient</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Reason</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="text-body-md font-body-md text-on-background divide-y divide-outline-variant/30">
                @forelse($doctor->appointments ?? [] as $appointment)
                    <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                        <td class="p-4">
                            <p class="font-medium">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                            <p class="text-on-surface-variant text-sm">{{ $appointment->time }}</p>
                        </td>
                        <td class="p-4">{{ $appointment->patient->name ?? 'N/A' }}</td>
                        <td class="p-4">{{ $appointment->reason ?? 'N/A' }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                @if($appointment->status === 'completed') bg-secondary/10 text-secondary
                                @elseif($appointment->status === 'cancelled') bg-error/10 text-error
                                @elseif($appointment->status === 'confirmed') bg-primary/10 text-primary
                                @else bg-surface-variant text-on-surface-variant @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-on-surface-variant">
                            No appointments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
