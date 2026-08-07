@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('content')
<div class="max-w-[1180px] mx-auto flex flex-col gap-stack-lg">
    <!-- Dashboard Header & Actions -->
    <section class="flex justify-between items-end">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-background mb-2">Receptionist Dashboard</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Welcome back. It's a busy day.</p>
        </div>
        <div class="flex gap-4 items-center">
            <a href="{{ route('patients.create') }}" class="flex items-center gap-2 px-6 py-3 bg-secondary-container text-secondary font-label-md text-label-md rounded-lg shadow-ambient hover:opacity-90 transition-all border border-secondary-fixed">
                <span class="material-symbols-outlined">person_add</span>
                Register New Patient
            </a>
            <a href="{{ route('appointments.create') }}" class="flex items-center gap-2 px-6 py-3 bg-primary text-on-primary font-label-md text-label-md rounded-lg shadow-ambient hover:opacity-90 transition-all">
                <span class="material-symbols-outlined">calendar_add_on</span>
                Book New Appointment
            </a>
        </div>
    </section>

    <!-- Key Metrics Bento -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Waiting Room Counter -->
        <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant shadow-ambient flex flex-col justify-center items-center gap-2 border-l-4 border-error">
            <div class="flex items-center gap-2 text-error">
                <span class="material-symbols-outlined text-3xl">airline_seat_recline_normal</span>
            </div>
            <div class="font-headline-lg text-headline-lg text-on-background">{{ $waitingRoomCount ?? 0 }}</div>
            <div class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wide">Patients in Waiting Room</div>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant shadow-ambient flex flex-col justify-center items-center gap-2 border-l-4 border-primary">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-3xl">calendar_today</span>
            </div>
            <div class="font-headline-lg text-headline-lg text-on-background">{{ $todayAppointments ?? 0 }}</div>
            <div class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wide">Total Appointments Today</div>
        </div>

        <!-- Emergency Action -->
        <div class="bg-error-container p-6 rounded-xl border border-error shadow-ambient flex flex-col justify-center items-center gap-2 cursor-pointer hover:bg-opacity-80 transition-all">
            <div class="flex items-center gap-2 text-on-error-container">
                <span class="material-symbols-outlined text-3xl">emergency</span>
            </div>
            <div class="font-headline-md text-headline-md text-on-error-container">Emergency Triage</div>
            <div class="font-label-md text-label-md text-on-error-container opacity-80 uppercase tracking-wide">Initiate Protocol</div>
        </div>
    </section>

    <!-- Table Section -->
    <section class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-ambient overflow-hidden flex flex-col">
        <div class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface-bright">
            <h2 class="font-headline-sm text-headline-sm text-on-background">Incoming Patients</h2>
            <a href="{{ route('appointments.index') }}" class="text-primary font-label-md text-label-md hover:underline flex items-center gap-1">
                View Full Schedule
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Patient Name</th>
                        <th class="px-6 py-4 font-semibold">Appt Time</th>
                        <th class="px-6 py-4 font-semibold">Doctor</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md text-on-background">
                    @forelse($incomingPatients ?? [] as $appointment)
                        <tr class="bg-surface-container-lowest border-b border-outline-variant hover:bg-surface-container-low transition-colors">
                            <td class="px-6 py-4 font-medium flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">
                                    {{ substr($appointment->patient->name ?? 'Unknown', 0, 2) }}
                                </div>
                                {{ $appointment->patient->name ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4">{{ $appointment->time ?? '' }}</td>
                            <td class="px-6 py-4">{{ $appointment->doctor->name ?? 'Unknown' }} ({{ $appointment->doctor->specialization ?? '' }})</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($appointment->status === 'waiting') bg-[#fefce8] text-[#a16207]
                                    @elseif($appointment->status === 'checked-in') bg-[#f0fdf4] text-[#15803d]
                                    @elseif($appointment->status === 'in-consultation') bg-[#eff6ff] text-[#1d4ed8]
                                    @else bg-[#f3f4f6] text-[#6b7280] @endif">
                                    @if($appointment->status === 'waiting')<span class="w-1.5 h-1.5 rounded-full bg-[#eab308]"></span>
                                    @elseif($appointment->status === 'checked-in')<span class="w-1.5 h-1.5 rounded-full bg-[#22c55e]"></span>
                                    @elseif($appointment->status === 'in-consultation')<span class="w-1.5 h-1.5 rounded-full bg-[#3b82f6]"></span>
                                    @endif
                                    {{ ucfirst($appointment->status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-primary hover:text-primary-container p-1 rounded hover:bg-surface-variant transition-colors">
                                    <span class="material-symbols-outlined text-xl">more_vert</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-on-surface-variant">
                                No incoming patients
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
