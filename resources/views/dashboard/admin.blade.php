@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-stack-lg">
    <h2 class="font-headline-lg text-headline-lg text-on-background">Admin Overview</h2>
    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Welcome back. Here is your daily summary.</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-12 gap-gutter">
    <!-- Left Column (Main Content) -->
    <div class="xl:col-span-8 flex flex-col gap-stack-lg">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
            <!-- Stat Card 1 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-[0px_4px_10px_-2px_rgba(0,0,0,0.03)] hover:shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-primary-container/20 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">group</span>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Total Patients</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-on-background">{{ $totalPatients ?? 0 }}</div>
                <div class="font-body-md text-body-md text-secondary mt-1 flex items-center gap-1 text-[12px]">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    +5.2% from last month
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-[0px_4px_10px_-2px_rgba(0,0,0,0.03)] hover:shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-tertiary-container/20 text-tertiary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">event</span>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Today's Appointments</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-on-background">{{ $todayAppointments ?? 0 }}</div>
                <div class="font-body-md text-body-md text-on-surface-variant mt-1 text-[12px]">
                    {{ $remainingAppointments ?? 0 }} remaining
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-[0px_4px_10px_-2px_rgba(0,0,0,0.03)] hover:shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-secondary-container/30 text-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">account_balance_wallet</span>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Revenue This Month</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-on-background">${{ number_format($monthlyRevenue ?? 0, 1) }}k</div>
                <div class="font-body-md text-body-md text-secondary mt-1 flex items-center gap-1 text-[12px]">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    +8% vs previous
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-[0px_4px_10px_-2px_rgba(0,0,0,0.03)] hover:shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] transition-shadow">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-primary-container/20 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">stethoscope</span>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface-variant">Active Doctors</span>
                </div>
                <div class="font-headline-lg text-headline-lg text-on-background">{{ $activeDoctors ?? 0 }}</div>
                <div class="font-body-md text-body-md text-on-surface-variant mt-1 text-[12px]">
                    Across 4 departments
                </div>
            </div>
        </div>

        <!-- Recent Appointments Table -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-[0px_4px_10px_-2px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="px-6 py-4 border-b border-outline-variant flex justify-between items-center bg-surface-container-lowest">
                <h3 class="font-headline-sm text-headline-sm text-on-background">Recent Appointments</h3>
                <a href="{{ route('appointments.index') }}" class="font-label-md text-label-md text-primary hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface border-b border-outline-variant">
                            <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Patient Name</th>
                            <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Doctor</th>
                            <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="font-body-md text-body-md text-on-background">
                        @forelse($recentAppointments ?? [] as $appointment)
                            <tr class="bg-surface-container-lowest border-b border-outline-variant hover:bg-secondary-fixed/10 transition-colors">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-surface-variant text-primary flex items-center justify-center font-bold text-xs">
                                        {{ substr($appointment->patient->name ?? 'Unknown', 0, 2) }}
                                    </div>
                                    {{ $appointment->patient->name ?? 'Unknown' }}
                                </td>
                                <td class="px-6 py-4">{{ $appointment->doctor->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4">{{ $appointment->time ?? '' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($appointment->status === 'confirmed') bg-[#dcfce7] text-[#15803d]
                                        @elseif($appointment->status === 'pending') bg-[#fef08a] text-[#a16207]
                                        @elseif($appointment->status === 'completed') bg-[#dbeafe] text-[#1d4ed8]
                                        @else bg-[#fee2e2] text-[#dc2626] @endif">
                                        {{ ucfirst($appointment->status ?? 'pending') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-on-surface-variant">
                                    No recent appointments found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column (Sidebar) -->
    <div class="xl:col-span-4 flex flex-col gap-stack-lg">
        <!-- Revenue Trend Chart (Placeholder) -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-[0px_4px_10px_-2px_rgba(0,0,0,0.03)] p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-headline-sm text-headline-sm text-on-background">Revenue Trend</h3>
                <span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary">more_horiz</span>
            </div>
            <div class="h-48 w-full bg-surface-container-low rounded-lg border border-outline-variant/50 relative overflow-hidden flex items-end">
                <!-- Abstract SVG Chart Graphic -->
                <svg class="w-full h-full text-primary-fixed-dim/40 absolute bottom-0" preserveaspectratio="none" viewbox="0 0 100 100">
                    <path d="M0,100 L0,80 Q10,70 20,85 T40,60 T60,75 T80,40 T100,20 L100,100 Z" fill="currentColor"></path>
                </svg>
                <svg class="w-full h-full text-primary/20 absolute bottom-0" preserveaspectratio="none" viewbox="0 0 100 100">
                    <path d="M0,100 L0,90 Q15,85 25,95 T50,70 T70,85 T90,50 T100,30 L100,100 Z" fill="currentColor"></path>
                </svg>
                <div class="absolute inset-0 flex justify-center items-center">
                    <span class="text-on-surface-variant font-label-md text-label-md bg-surface-container-lowest px-2 py-1 rounded opacity-70">Chart Visualization</span>
                </div>
            </div>
        </div>

        <!-- System Notifications -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-[0px_4px_10px_-2px_rgba(0,0,0,0.03)] p-6 flex-1">
            <h3 class="font-headline-sm text-headline-sm text-on-background mb-4">System Notifications</h3>
            <div class="flex flex-col gap-4">
                @forelse($notifications ?? [] as $notification)
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 rounded-full 
                            @if($notification->type === 'success') bg-secondary-container/30 text-secondary
                            @elseif($notification->type === 'error') bg-[#fee2e2] text-error
                            @else bg-primary-container/20 text-primary @endif
                            flex items-center justify-center shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[16px]">
                                @if($notification->type === 'success') sync
                                @elseif($notification->type === 'error') error
                                @else person_add @endif
                            </span>
                        </div>
                        <div>
                            <p class="font-body-md text-body-md text-on-background font-medium">{{ $notification->title }}</p>
                            <p class="font-body-sm text-[12px] text-on-surface-variant">{{ $notification->message }}</p>
                            <span class="font-label-md text-[10px] text-tertiary-container">{{ $notification->time }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-on-surface-variant text-sm">No recent notifications</p>
                @endforelse
            </div>
            <button class="w-full mt-6 py-2 text-primary font-label-md text-label-md hover:bg-surface-container-low rounded-lg transition-colors border border-outline-variant/30">
                View All Logs
            </button>
        </div>
    </div>
</div>
@endsection
