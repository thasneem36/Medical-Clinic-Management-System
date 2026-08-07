@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
<!-- Welcome Header -->
<div class="mb-stack-lg flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-on-background mb-1">Good morning, Dr. {{ auth()->user()->name ?? 'Smith' }}</h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant">Here is your patient queue for today.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-surface-container text-on-surface rounded-lg font-label-md text-label-md border border-outline-variant hover:bg-surface-container-high transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">calendar_month</span>
            View Full Schedule
        </a>
    </div>
</div>

<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
    <!-- Quick Summary Card (Spans 4 cols on large screens) -->
    <div class="lg:col-span-4 bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">analytics</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface">Quick Summary</h3>
            </div>
            <div class="space-y-4">
                <div class="p-4 bg-surface-container-low rounded-lg border border-outline-variant flex justify-between items-center">
                    <span class="font-body-md text-body-md text-on-surface-variant">Completed Today</span>
                    <span class="font-headline-md text-headline-md text-secondary">{{ $completedToday ?? 0 }}</span>
                </div>
                <div class="p-4 bg-primary-container rounded-lg border border-primary-fixed flex justify-between items-center">
                    <span class="font-body-md text-body-md text-on-primary-container">Remaining</span>
                    <span class="font-headline-md text-headline-md text-on-primary-container font-bold">{{ $remainingToday ?? 0 }}</span>
                </div>
            </div>
        </div>
        <!-- Upcoming Patient Mini-Card -->
        <div class="mt-stack-md pt-stack-md border-t border-outline-variant">
            <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-3">Up Next</p>
            @if($nextPatient ?? null)
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-surface-variant flex items-center justify-center text-primary font-bold text-lg">
                        {{ substr($nextPatient->patient->name ?? 'Unknown', 0, 2) }}
                    </div>
                    <div>
                        <p class="font-headline-sm text-headline-sm text-on-surface">{{ $nextPatient->patient->name ?? 'Unknown' }}</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $nextPatient->time ?? '' }} • {{ $nextPatient->reason ?? 'Checkup' }}</p>
                    </div>
                </div>
                <button class="mt-4 w-full bg-primary text-on-primary py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary-container hover:text-on-primary-container transition-colors">
                    <span class="material-symbols-outlined text-sm">stethoscope</span>
                    Start Consultation
                </button>
            @else
                <p class="text-on-surface-variant text-sm">No upcoming patients</p>
            @endif
        </div>
    </div>

    <!-- Patient Queue List (Spans 8 cols on large screens) -->
    <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-headline-sm text-headline-sm text-on-surface">My Patient Queue</h3>
            <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">filter_list</span>
                <span class="font-label-md">Filter</span>
            </div>
        </div>
        <!-- Zebra Table Structure -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-outline-variant text-on-surface-variant">
                        <th class="py-3 px-4 font-label-md text-label-md font-semibold uppercase tracking-wider">Patient Name</th>
                        <th class="py-3 px-4 font-label-md text-label-md font-semibold uppercase tracking-wider">Reason for Visit</th>
                        <th class="py-3 px-4 font-label-md text-label-md font-semibold uppercase tracking-wider">Appt Time</th>
                        <th class="py-3 px-4 font-label-md text-label-md font-semibold uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 font-label-md text-label-md font-semibold uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="font-body-md">
                    @forelse($patientQueue ?? [] as $appointment)
                        <tr class="bg-surface-container-lowest hover:bg-teal-50/50 transition-colors border-b border-outline-variant/50">
                            <td class="py-4 px-4">
                                <div class="font-semibold text-on-surface">{{ $appointment->patient->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-on-surface-variant">DOB: {{ $appointment->patient->dob ?? 'N/A' }}</div>
                            </td>
                            <td class="py-4 px-4 text-on-surface-variant">{{ $appointment->reason ?? 'Checkup' }}</td>
                            <td class="py-4 px-4 text-on-surface-variant font-medium">{{ $appointment->time ?? '' }}</td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($appointment->status === 'ready') bg-green-100 text-green-700
                                    @elseif($appointment->status === 'in-progress') bg-blue-100 text-blue-700
                                    @elseif($appointment->status === 'waiting') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-600 @endif">
                                    @if($appointment->status === 'in-progress')<span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                    @elseif($appointment->status === 'ready' || $appointment->status === 'waiting')<span class="w-1.5 h-1.5 rounded-full 
                                        @if($appointment->status === 'ready') bg-green-600 @else bg-yellow-600 @endif"></span>
                                    @endif
                                    {{ ucfirst($appointment->status ?? 'scheduled') }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <a href="{{ route('appointments.show', $appointment->id) }}" class="text-primary hover:text-primary-fixed-dim font-label-md">View Chart</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-on-surface-variant">
                                No patients in queue
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
