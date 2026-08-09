@extends('layouts.app')

@section('title', 'Add New Doctor')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header -->
    <div class="mb-stack-lg flex justify-between items-end">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Add New Doctor</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Enter the doctor's details below to create a new record.</p>
        </div>
    </div>

    <!-- Registration Form Card -->
    <div class="bg-[#f8fafc] border border-[#e2e8f0] rounded-xl shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] p-8">
        <form action="{{ route('doctors.store') }}" method="POST" class="space-y-stack-lg">
            @csrf

            <!-- Section: Personal Info -->
            <div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined">badge</span>
                    Doctor Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="name">Full Name</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('name') border-error @enderror" id="name" name="name" type="text" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="specialization">Specialization</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('specialization') border-error @enderror" id="specialization" name="specialization" type="text" value="{{ old('specialization') }}" required>
                        @error('specialization')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="contact">Contact Number</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('contact') border-error @enderror" id="contact" name="contact" type="tel" value="{{ old('contact') }}" required>
                        @error('contact')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="working_hours">Working Hours</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('working_hours') border-error @enderror" id="working_hours" name="working_hours" type="text" value="{{ old('working_hours') }}" placeholder="e.g., Mon-Fri 9AM-5PM" required>
                        @error('working_hours')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-stack-md mt-stack-lg border-t border-outline-variant">
                <a href="{{ route('doctors.index') }}" class="px-6 py-2.5 rounded-lg border-2 border-secondary text-secondary font-label-md text-label-md hover:bg-surface-variant transition-colors min-h-[44px]">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-fixed-variant transition-colors shadow-sm min-h-[44px] flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save Doctor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
