@extends('layouts.app')

@section('title', 'Doctor Management')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-stack-lg gap-4">
    <div>
        <h2 class="text-headline-lg font-headline-lg text-on-background">Doctor Directory</h2>
        <p class="text-body-md font-body-md text-on-surface-variant mt-1">Manage and review doctor profiles and specializations.</p>
    </div>
    <a href="{{ route('doctors.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary-container shadow-sm transition-colors whitespace-nowrap self-start md:self-auto">
        <span class="material-symbols-outlined text-[18px]">person_add</span>
        Add New Doctor
    </a>
</div>

<!-- Content Canvas: Data Table Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden flex flex-col">
    <!-- Table Filters / Toolbars -->
    <div class="p-4 border-b border-outline-variant bg-surface-bright flex justify-between items-center">
        <div class="flex gap-2">
            <span class="text-label-md font-label-md text-on-surface-variant uppercase px-2 py-1">All Doctors ({{ $doctors->total() ?? 0 }})</span>
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
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Doctor Name</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Specialization</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Working Hours</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold">Contact</th>
                    <th class="p-4 text-label-md font-label-md text-on-surface-variant font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md font-body-md text-on-background divide-y divide-outline-variant/30">
                @forelse($doctors ?? [] as $doctor)
                    <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors group">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">
                                    {{ substr($doctor->name ?? 'Unknown', 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-primary group-hover:underline cursor-pointer">{{ $doctor->name ?? 'Unknown' }}</p>
                                    <p class="text-label-md text-on-surface-variant">DR-{{ str_pad($doctor->id ?? 0, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-on-surface-variant">{{ $doctor->specialization ?? 'N/A' }}</td>
                        <td class="p-4 text-on-surface-variant">{{ $doctor->working_hours ?? 'N/A' }}</td>
                        <td class="p-4 text-on-surface-variant">{{ $doctor->contact ?? 'N/A' }}</td>
                        <td class="p-4 text-right">
                            <a href="{{ route('doctors.show', $doctor->id) }}" class="text-on-surface-variant hover:text-primary p-1 rounded-md transition-colors"><span class="material-symbols-outlined text-[20px]">visibility</span></a>
                            <a href="{{ route('doctors.edit', $doctor->id) }}" class="text-on-surface-variant hover:text-primary p-1 rounded-md transition-colors"><span class="material-symbols-outlined text-[20px]">edit</span></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-on-surface-variant">
                            No doctors found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t border-outline-variant bg-surface flex items-center justify-between">
        <span class="text-label-md font-label-md text-on-surface-variant">Showing {{ $doctors->firstItem() ?? 0 }} to {{ $doctors->lastItem() ?? 0 }} of {{ $doctors->total() ?? 0 }} entries</span>
        {{ $doctors->links() }}
    </div>
</div>
@endsection
