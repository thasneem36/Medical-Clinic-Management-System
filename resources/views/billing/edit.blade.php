@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <!-- Page Header -->
    <div class="mb-stack-lg flex justify-between items-end">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Edit Invoice</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Update invoice information below.</p>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-[#f8fafc] border border-[#e2e8f0] rounded-xl shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] p-8">
        <form action="{{ route('billing.update', $billing->id) }}" method="POST" class="space-y-stack-lg">
            @csrf
            @method('PUT')

            <!-- Section: Invoice Details -->
            <div>
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined">receipt</span>
                    Invoice Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="patient_id">Patient</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('patient_id') border-error @enderror" id="patient_id" name="patient_id" required>
                            <option value="">Select Patient</option>
                            @foreach($patients ?? [] as $patient)
                                <option value="{{ $patient->id }}" {{ old('patient_id', $billing->patient_id) == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
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
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $billing->doctor_id) == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }} - {{ $doctor->specialization }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="appointment_id">Appointment (Optional)</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('appointment_id') border-error @enderror" id="appointment_id" name="appointment_id">
                            <option value="">No Appointment</option>
                            @foreach($billing->patient->appointments ?? [] as $appointment)
                                <option value="{{ $appointment->id }}" {{ old('appointment_id', $billing->appointment_id) == $appointment->id ? 'selected' : '' }}>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }} - {{ $appointment->time }}</option>
                            @endforeach
                        </select>
                        @error('appointment_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="amount">Amount</label>
                        <input class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('amount') border-error @enderror" id="amount" name="amount" type="number" step="0.01" value="{{ old('amount', $billing->amount) }}" required>
                        @error('amount')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="payment_method">Payment Method</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('payment_method') border-error @enderror" id="payment_method" name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="credit_card" {{ old('payment_method', $billing->payment_method) === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="cash" {{ old('payment_method', $billing->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="insurance" {{ old('payment_method', $billing->payment_method) === 'insurance' ? 'selected' : '' }}>Insurance</option>
                            <option value="bank_transfer" {{ old('payment_method', $billing->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_method')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="status">Status</label>
                        <select class="min-h-[44px] px-4 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md @error('status') border-error @enderror" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $billing->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('status', $billing->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ old('status', $billing->status) === 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        @error('status')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="notes">Notes</label>
                        <textarea class="px-4 py-3 rounded-lg border border-outline-variant bg-surface focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-body-md font-body-md resize-none @error('notes') border-error @enderror" id="notes" name="notes" placeholder="Additional notes about this invoice..." rows="3">{{ old('notes', $billing->notes) }}</textarea>
                        @error('notes')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-stack-md mt-stack-lg border-t border-outline-variant">
                <a href="{{ route('billing.show', $billing->id) }}" class="px-6 py-2.5 rounded-lg border-2 border-secondary text-secondary font-label-md text-label-md hover:bg-surface-variant transition-colors min-h-[44px]">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-fixed-variant transition-colors shadow-sm min-h-[44px] flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Update Invoice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
