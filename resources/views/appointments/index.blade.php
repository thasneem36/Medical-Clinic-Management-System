@extends('layouts.app')

@section('title', 'Appointment Management')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-stack-lg gap-4">
    <div>
        <h2 class="text-headline-lg font-headline-lg text-on-background">Appointments</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-1">Manage and review appointment schedules.</p>
    </div>
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
    <a href="{{ route('appointments.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary-container shadow-sm transition-colors whitespace-nowrap self-start md:self-auto">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Book Appointment
    </a>
    @endif
</div>

<!-- Content Canvas: Data Table Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden flex flex-col">
    <!-- Table Filters / Toolbars -->
    <div class="p-4 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
        <div class="flex gap-2">
            <span class="text-label-md font-label-md text-on-surface-variant uppercase px-2 py-1">All Appointments ({{ $appointments->total() ?? 0 }})</span>
        </div>
        <button class="text-on-surface-variant flex items-center gap-1 hover:text-primary text-label-md font-label-md">
            <span class="material-symbols-outlined text-[18px]">filter_list</span> Filter
        </button>
    </div>

    <!-- Zebra Table -->
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-surface border-b border-outline-variant">
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Date & Time</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Patient</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Doctor</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Reason</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Status</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md font-body-md text-on-background divide-y divide-outline-variant/30">
                @forelse($appointments ?? [] as $appointment)
                    <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors group">
                        <td class="p-4">
                            <p class="font-medium">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                            <p class="text-on-surface-variant text-sm">{{ $appointment->time }}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">
                                    {{ substr($appointment->patient->name ?? 'Unknown', 0, 1) }}
                                </div>
                                <span>{{ $appointment->patient->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td class="p-4">{{ $appointment->doctor->name ?? 'N/A' }}</td>
                        <td class="p-4 text-on-surface-variant">{{ $appointment->reason ?? 'N/A' }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                @if($appointment->status === 'completed') bg-secondary/10 text-secondary
                                @elseif($appointment->status === 'cancelled') bg-error/10 text-error
                                @elseif($appointment->status === 'confirmed') bg-primary/10 text-primary
                                @elseif($appointment->status === 'waiting') bg-tertiary/10 text-tertiary
                                @else bg-surface-variant text-on-surface-variant @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('appointments.show', $appointment->id) }}" class="text-on-surface-variant hover:text-primary p-1 rounded-md transition-colors"><span class="material-symbols-outlined text-[20px]">visibility</span></a>
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="text-on-surface-variant hover:text-primary p-1 rounded-md transition-colors"><span class="material-symbols-outlined text-[20px]">edit</span></a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-on-surface-variant">
                            No appointments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t border-outline-variant bg-surface flex items-center justify-between">
        <span class="text-label-md font-label-md text-on-surface-variant">Showing {{ $appointments->firstItem() ?? 0 }} to {{ $appointments->lastItem() ?? 0 }} of {{ $appointments->total() ?? 0 }} entries</span>
        {{ $appointments->links() }}
    </div>
</div>
@endsection
