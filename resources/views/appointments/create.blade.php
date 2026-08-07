@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <div class="mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg text-on-background">Book New Appointment</h2>
        <p class="text-on-surface-variant font-body-md text-body-md mt-1">Schedule a visit for a patient with a specialist.</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-stack-lg">
        <!-- Left Column: Details Form -->
        <div class="xl:col-span-5 flex flex-col gap-stack-md">
            <div class="bg-surface-lowest border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] transition-shadow">
                <h3 class="font-headline-sm text-headline-sm text-on-background mb-stack-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">patient_list</span>
                    Patient Details
                </h3>

                <form action="{{ route('appointments.store') }}" method="POST" class="flex flex-col gap-stack-md">
                    @csrf

                    <!-- Searchable Patient Dropdown -->
                    <div class="mb-stack-md relative">
                        <label class="block font-label-md text-label-md text-on-surface mb-2 uppercase tracking-wider">Select Patient</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                            <input class="w-full h-12 pl-10 pr-4 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('patient_id') border-error @enderror" placeholder="Search by name, ID or phone..." type="text" value="{{ old('patient_name') }}">
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-primary cursor-pointer">arrow_drop_down</span>
                        </div>
                        @error('patient_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="mb-stack-md">
                        <label class="block font-label-md text-label-md text-on-surface mb-2 uppercase tracking-wider">Department</label>
                        <div class="relative">
                            <select class="w-full h-12 px-4 bg-surface border border-outline-variant rounded-lg text-body-md font-body-md appearance-none focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('department') border-error @enderror" name="department">
                                <option value="">Select Department</option>
                                <option value="cardiology" {{ old('department') === 'cardiology' ? 'selected' : '' }}>Cardiology</option>
                                <option value="neurology" {{ old('department') === 'neurology' ? 'selected' : '' }}>Neurology</option>
                                <option value="orthopedics" {{ old('department') === 'orthopedics' ? 'selected' : '' }}>Orthopedics</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">arrow_drop_down</span>
                        </div>
                        @error('department')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-2 uppercase tracking-wider">Attending Physician</label>
                        <div class="flex items-center gap-4 p-3 border border-primary rounded-lg bg-surface-container-low cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-bold text-lg">
                                {{ substr($selectedDoctor->name ?? 'Unknown', 0, 2) }}
                            </div>
                            <div class="flex-1">
                                <div class="font-label-md text-label-md text-on-background">{{ $selectedDoctor->name ?? 'Select a doctor' }}</div>
                                <div class="text-on-surface-variant text-sm">{{ $selectedDoctor->specialization ?? '' }}</div>
                            </div>
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                        </div>
                        @error('doctor_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Date & Time Scheduler -->
        <div class="xl:col-span-7 flex flex-col gap-stack-md">
            <div class="bg-surface-lowest border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] transition-shadow">
                <div class="flex justify-between items-center mb-stack-md">
                    <h3 class="font-headline-sm text-headline-sm text-on-background flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                        Date & Time
                    </h3>
                    <div class="flex gap-2 text-sm">
                        <button class="w-8 h-8 rounded-full border border-outline-variant flex items-center justify-center hover:bg-surface-container"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                        <button class="w-8 h-8 rounded-full border border-outline-variant flex items-center justify-center hover:bg-surface-container"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                    </div>
                </div>

                <!-- Date Picker Horizontal -->
                <div class="flex gap-3 overflow-x-auto pb-4 mb-4 border-b border-outline-variant no-scrollbar">
                    @foreach($availableDates ?? [] as $date)
                        <button class="flex-shrink-0 w-16 h-20 rounded-lg border border-outline-variant flex flex-col items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors
                            @if($date['selected']) bg-primary text-on-primary shadow-[0px_0px_0px_2px_rgba(0,97,148,0.2)] @endif">
                            <span class="text-xs uppercase font-semibold">{{ $date['day'] }}</span>
                            <span class="font-headline-sm text-headline-sm mt-1">{{ $date['date'] }}</span>
                        </button>
                    @endforeach
                </div>

                <!-- Time Slots -->
                <h4 class="font-label-md text-label-md text-on-surface mb-4 uppercase tracking-wider">Morning Slots</h4>
                <div class="grid grid-cols-4 gap-3 mb-6">
                    @foreach($morningSlots ?? [] as $slot)
                        <button type="button" class="py-3 rounded-lg
                            @if($slot['available']) border border-secondary-container bg-secondary-container text-on-secondary-container font-label-md text-label-md hover:bg-secondary hover:text-on-secondary transition-all
                            @else border border-error-container bg-error-container text-on-error-container font-label-md text-label-md opacity-75 cursor-not-allowed @endif">
                            {{ $slot['time'] }}
                        </button>
                    @endforeach
                </div>

                <h4 class="font-label-md text-label-md text-on-surface mb-4 uppercase tracking-wider">Afternoon Slots</h4>
                <div class="grid grid-cols-4 gap-3 mb-6">
                    @foreach($afternoonSlots ?? [] as $slot)
                        <button type="button" class="py-3 rounded-lg
                            @if($slot['available']) border border-secondary-container bg-secondary-container text-on-secondary-container font-label-md text-label-md hover:bg-secondary hover:text-on-secondary transition-all
                            @else border border-error-container bg-error-container text-on-error-container font-label-md text-label-md opacity-75 cursor-not-allowed @endif">
                            {{ $slot['time'] }}
                        </button>
                    @endforeach
                </div>

                <!-- Suggestion Alert -->
                <div class="bg-surface-container-low border-l-4 border-primary p-4 rounded-r-lg flex items-start gap-3 mb-stack-lg">
                    <span class="material-symbols-outlined text-primary mt-0.5">info</span>
                    <div>
                        <p class="font-label-md text-label-md text-on-background">Slot Unavailable</p>
                        <p class="text-sm text-on-surface-variant">Suggested: Next available slot is at <strong class="text-primary">{{ $suggestedSlot ?? '11:00 AM' }}</strong>.</p>
                    </div>
                </div>

                <!-- Action -->
                <div class="flex justify-end border-t border-outline-variant pt-6">
                    <a href="{{ route('appointments.index') }}" class="bg-surface border border-outline-variant text-on-surface font-label-md text-label-md py-3 px-6 rounded-lg mr-4 hover:bg-surface-container transition-colors">Cancel</a>
                    <button type="submit" form="appointment-form" class="bg-primary text-on-primary font-label-md text-label-md py-3 px-8 rounded-lg shadow-sm hover:opacity-90 transition-opacity flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">event_available</span>
                        Confirm Booking
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
