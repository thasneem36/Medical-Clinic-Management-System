@extends('layouts.app')

@section('title', 'Patient Management')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-stack-lg gap-4">
    <div>
        <h2 class="text-headline-lg font-headline-lg text-on-background">Patient Directory</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-1">Manage and review patient records and histories.</p>
    </div>
    <a href="{{ route('patients.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary-container shadow-sm transition-colors whitespace-nowrap self-start md:self-auto">
        <span class="material-symbols-outlined text-[18px]">person_add</span>
        Register New Patient
    </a>
</div>

<!-- Content Canvas: Data Table Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden flex flex-col">
    <!-- Table Filters / Toolbars -->
    <div class="p-4 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
        <div class="flex gap-2">
            <span class="text-label-md font-label-md text-on-surface-variant uppercase px-2 py-1">All Patients ({{ $patients->total() ?? 0 }})</span>
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
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Patient Name</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Age / Gender</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Last Visit</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Contact</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Status</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md font-body-md text-on-background divide-y divide-outline-variant/30">
                @forelse($patients ?? [] as $patient)
                    <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors group">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">
                                    {{ substr($patient->name ?? 'Unknown', 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-primary group-hover:underline cursor-pointer">{{ $patient->name ?? 'Unknown' }}</p>
                                    <p class="text-label-md text-on-surface-variant">PT-{{ str_pad($patient->id ?? 0, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-on-surface-variant">{{ $patient->age ?? 0 }} / {{ $patient->gender ?? 'N/A' }}</td>
                        <td class="p-4 text-on-surface-variant">{{ $patient->last_visit ?? 'N/A' }}</td>
                        <td class="p-4 text-on-surface-variant">{{ $patient->contact ?? 'N/A' }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                @if($patient->status === 'active') bg-secondary/10 text-secondary
                                @elseif($patient->status === 'overdue') bg-error/10 text-error
                                @else bg-surface-variant text-primary @endif">
                                {{ ucfirst($patient->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('patients.show', $patient->id) }}" class="text-on-surface-variant hover:text-primary p-1 rounded-md transition-colors"><span class="material-symbols-outlined text-[20px]">visibility</span></a>
                            <a href="{{ route('patients.edit', $patient->id) }}" class="text-on-surface-variant hover:text-primary p-1 rounded-md transition-colors"><span class="material-symbols-outlined text-[20px]">edit</span></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-on-surface-variant">
                            No patients found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t border-outline-variant bg-surface flex items-center justify-between">
        <span class="text-label-md font-label-md text-on-surface-variant">Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() ?? 0 }} entries</span>
        {{ $patients->links() }}
    </div>
</div>
@endsection
