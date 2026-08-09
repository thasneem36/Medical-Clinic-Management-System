@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-stack-lg gap-4">
    <div>
        <h2 class="text-headline-lg font-headline-lg text-on-background">Patient Details</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-1">View patient information and history.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('patients.edit', $patient->id) }}" class="bg-surface-container-high text-on-surface px-4 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-surface-container-highest shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">edit</span>
            Edit Patient
        </a>
        <a href="{{ route('patients.index') }}" class="bg-outline text-on-surface px-4 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-outline-variant shadow-sm transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to List
        </a>
    </div>
</div>

<!-- Patient Information Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden mb-stack-lg">
    <div class="p-6 border-b border-outline-variant bg-surface-bright">
        <div class="flex items-start gap-4">
            <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-2xl shrink-0">
                {{ substr($patient->name ?? 'Unknown', 0, 2) }}
            </div>
            <div class="flex-1">
                <h3 class="text-headline-md font-headline-md text-primary font-semibold">{{ $patient->name ?? 'Unknown' }}</h3>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Patient ID: PT-{{ str_pad($patient->id ?? 0, 5, '0', STR_PAD_LEFT) }}</p>
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
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Age</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $patient->age ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Gender</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ ucfirst($patient->gender ?? 'N/A') }}</p>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Contact</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $patient->contact ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Email</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $patient->email ?? 'N/A' }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Address</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $patient->address ?? 'N/A' }}</p>
        </div>
        <div class="md:col-span-2 lg:col-span-3">
            <p class="text-label-md font-label-md text-on-surface-variant uppercase mb-1">Medical Notes</p>
            <p class="text-body-lg font-body-lg text-on-background">{{ $patient->medical_notes ?? 'No medical notes available.' }}</p>
        </div>
    </div>
</div>

<!-- Appointments Section -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden mb-stack-lg">
    <div class="p-4 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
        <h3 class="text-headline-md font-headline-md text-primary font-semibold">Appointment History</h3>
        <a href="{{ route('appointments.create') }}" class="text-primary text-label-md font-label-md hover:underline">Book New Appointment</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface border-b border-outline-variant">
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Date & Time</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Doctor</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Reason</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="text-body-md font-body-md text-on-background divide-y divide-outline-variant/30">
                @forelse($patient->appointments ?? [] as $appointment)
                    <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                        <td class="p-4">
                            <p class="font-medium">{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</p>
                            <p class="text-on-surface-variant text-sm">{{ $appointment->time }}</p>
                        </td>
                        <td class="p-4">{{ $appointment->doctor->name ?? 'N/A' }}</td>
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

<!-- Billing Section -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
        <h3 class="text-headline-md font-headline-md text-primary font-semibold">Billing History</h3>
        <a href="{{ route('billing.create') }}" class="text-primary text-label-md font-label-md hover:underline">Create Invoice</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface border-b border-outline-variant">
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Invoice #</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Date</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Amount</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Status</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md font-body-md text-on-background divide-y divide-outline-variant/30">
                @forelse($patient->billings ?? [] as $billing)
                    <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                        <td class="p-4 font-medium">#INV-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($billing->date)->format('M d, Y') }}</td>
                        <td class="p-4 font-medium">${{ number_format($billing->amount, 2) }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                @if($billing->status === 'paid') bg-secondary/10 text-secondary
                                @elseif($billing->status === 'overdue') bg-error/10 text-error
                                @else bg-surface-variant text-on-surface-variant @endif">
                                {{ ucfirst($billing->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('billing.show', $billing->id) }}" class="text-on-surface-variant hover:text-primary p-1 rounded-md transition-colors"><span class="material-symbols-outlined text-[20px]">visibility</span></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-on-surface-variant">
                            No billing records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
