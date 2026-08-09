@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header -->
    <div class="mb-stack-lg flex justify-between items-end">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Edit Patient</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Update patient information below.</p>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-[#f8fafc] border border-[#e2e8f0] rounded-xl shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] p-8">
        <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="space-y-stack-lg">
            @csrf
            @method('PUT')

            <!-- Section: Personal Info -->
            <div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined">badge</span>
                    Personal Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="firstName">First Name</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('first_name') border-error @enderror" id="firstName" name="first_name" type="text" value="{{ old('first_name', $firstName) }}" required>
                        @error('first_name')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="lastName">Last Name</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('last_name') border-error @enderror" id="lastName" name="last_name" type="text" value="{{ old('last_name', $lastName) }}" required>
                        @error('last_name')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="age">Age</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('age') border-error @enderror" id="age" name="age" type="number" value="{{ old('age', $patient->age) }}" required>
                        @error('age')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="gender">Gender</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('gender') border-error @enderror" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $patient->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $patient->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $patient->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Contact Info -->
            <div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined">contact_mail</span>
                    Contact Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="contact">Phone Number</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('contact') border-error @enderror" id="contact" name="contact" type="tel" value="{{ old('contact', $patient->contact) }}" required>
                        @error('contact')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="email">Email Address</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('email') border-error @enderror" id="email" name="email" type="email" value="{{ old('email', $patient->email) }}">
                        @error('email')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="address">Home Address</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('address') border-error @enderror" id="address" name="address" type="text" value="{{ old('address', $patient->address) }}">
                        @error('address')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Medical Background -->
            <div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined">health_and_safety</span>
                    Medical Background
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="medical_notes">Medical Notes</label>
                        <textarea class="px-4 py-3 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md resize-none @error('medical_notes') border-error @enderror" id="medical_notes" name="medical_notes" placeholder="List current medications, allergies, or medical history..." rows="4">{{ old('medical_notes', $patient->medical_notes) }}</textarea>
                        @error('medical_notes')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-stack-md mt-stack-lg border-t border-outline-variant">
                <a href="{{ route('patients.show', $patient->id) }}" class="px-6 py-2.5 rounded-lg border-2 border-secondary text-secondary font-label-md text-label-md hover:bg-surface-variant transition-colors min-h-[44px]">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-fixed-variant transition-colors shadow-sm min-h-[44px] flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Update Patient
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
