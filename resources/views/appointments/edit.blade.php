@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header -->
    <div class="mb-stack-lg flex justify-between items-end">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Edit Appointment</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Update appointment information below.</p>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-[#f8fafc] border border-[#e2e8f0] rounded-xl shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] p-8">
        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="space-y-stack-lg">
            @csrf
            @method('PUT')

            <!-- Section: Appointment Details -->
            <div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined">event</span>
                    Appointment Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="patient_id">Patient</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('patient_id') border-error @enderror" id="patient_id" name="patient_id" required>
                            <option value="">Select Patient</option>
                            @foreach($patients ?? [] as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="doctor_id">Doctor</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('doctor_id') border-error @enderror" id="doctor_id" name="doctor_id" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors ?? [] as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }} - {{ $doctor->specialization }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="date">Date</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('date') border-error @enderror" id="date" name="date" type="date" value="{{ old('date', $appointment->date) }}" required>
                        @error('date')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="time">Time</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('time') border-error @enderror" id="time" name="time" type="text" value="{{ old('time', $appointment->time) }}" placeholder="e.g., 09:00 AM" required>
                        @error('time')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="reason">Reason for Visit</label>
                        <textarea class="px-4 py-3 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md resize-none @error('reason') border-error @enderror" id="reason" name="reason" placeholder="Describe the reason for appointment..." rows="3">{{ old('reason', $appointment->reason) }}</textarea>
                        @error('reason')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="status">Status</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('status') border-error @enderror" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="scheduled" {{ old('status', $appointment->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="confirmed" {{ old('status', $appointment->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ old('status', $appointment->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $appointment->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="waiting" {{ old('status', $appointment->status) === 'waiting' ? 'selected' : '' }}>Waiting</option>
                        </select>
                        @error('status')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-stack-md mt-stack-lg border-t border-outline-variant">
                <a href="{{ route('appointments.show', $appointment->id) }}" class="px-6 py-2.5 rounded-lg border-2 border-secondary text-secondary font-label-md text-label-md hover:bg-surface-variant transition-colors min-h-[44px]">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-fixed-variant transition-colors shadow-sm min-h-[44px] flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
