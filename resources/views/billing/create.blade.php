@extends('layouts.app')

@section('title', 'Generate Bill')

@section('content')
<div class="max-w-[1440px] mx-auto">
    <div class="flex justify-between items-end mb-stack-lg">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-background mb-1">New Invoice</h2>
            <p class="text-on-surface-variant font-body-md text-body-md">INV-{{ str_pad($invoiceNumber ?? 0, 6, '0', STR_PAD_LEFT) }} • {{ date('M d, Y') }}</p>
        </div>
        <div class="flex gap-4">
            <button class="px-4 py-2 border border-outline text-on-surface rounded flex items-center gap-2 hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined text-sm">save</span> Save Draft
            </button>
        </div>
    </div>

    <!-- Bento Grid Layout for Invoice Form -->
    <div class="grid grid-cols-12 gap-stack-lg">
        <!-- Left Column: Patient Info & Payment -->
        <div class="col-span-12 lg:col-span-4 flex flex-col gap-stack-lg">
            <!-- Patient Info Card -->
            <div class="level-1 rounded-xl p-6 level-2-hover transition-shadow">
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2">
                    <span class="material-symbols-outlined">person</span> Patient Info
                </h3>
                <div class="flex flex-col gap-stack-sm">
                    <div>
                        <label class="block text-label-md font-label-md text-on-surface-variant mb-1">Select Patient</label>
                        <div class="relative">
                            <select class="w-full h-11 px-3 border border-outline-variant rounded-lg bg-surface erp-input appearance-none text-on-background @error('patient_id') border-error @enderror" name="patient_id">
                                <option value="">Select Patient</option>
                                @foreach($patients ?? [] as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->name }} (ID: {{ $patient->id }})</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                        </div>
                        @error('patient_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @if($selectedPatient ?? null)
                        <div class="mt-2 p-4 bg-surface rounded-lg border border-outline-variant text-body-sm">
                            <p class="font-semibold text-on-surface mb-1">{{ $selectedPatient->name }}</p>
                            <p class="text-on-surface-variant">Age: {{ $selectedPatient->age }} | Gender: {{ $selectedPatient->gender }}</p>
                            <p class="text-on-surface-variant">Contact: {{ $selectedPatient->contact }}</p>
                        </div>
                    @endif
                    <div class="mt-2">
                        <label class="block text-label-md font-label-md text-on-surface-variant mb-1">Attending Physician</label>
                        <select class="w-full h-11 px-3 border border-outline-variant rounded-lg bg-surface erp-input text-on-background @error('doctor_id') border-error @enderror" name="doctor_id">
                            <option value="">Select Doctor</option>
                            @foreach($doctors ?? [] as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>Dr. {{ $doctor->name }} ({{ $doctor->specialization }})</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Method Card -->
            <div class="level-1 rounded-xl p-6 level-2-hover transition-shadow">
                <h3 class="font-headline-sm text-headline-sm text-primary mb-stack-md flex items-center gap-2">
                    <span class="material-symbols-outlined">credit_card</span> Payment Method
                </h3>
                <div class="flex flex-col gap-stack-sm">
                    <label class="block text-label-md font-label-md text-on-surface-variant mb-1">Method</label>
                    <div class="relative">
                        <select class="w-full h-11 px-3 border border-outline-variant rounded-lg bg-surface erp-input appearance-none text-on-background @error('payment_method') border-error @enderror" name="payment_method">
                            <option value="credit_card">Credit Card (Terminal)</option>
                            <option value="cash">Cash</option>
                            <option value="insurance">Insurance Claim</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                    </div>
                    @error('payment_method')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-4">
                        <label class="block text-label-md font-label-md text-on-surface-variant mb-1">Billing Notes (Optional)</label>
                        <textarea class="w-full p-3 border border-outline-variant rounded-lg bg-surface erp-input text-on-background min-h-[80px]" name="notes" placeholder="Add notes for patient...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Itemized Bill -->
        <div class="col-span-12 lg:col-span-8 flex flex-col gap-stack-lg">
            <div class="level-1 rounded-xl p-6 flex-1 flex flex-col">
                <div class="flex justify-between items-center mb-stack-md">
                    <h3 class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">list_alt</span> Itemized Services
                    </h3>
                    <button type="button" class="text-primary hover:text-primary-container font-label-md text-label-md flex items-center gap-1 transition-colors">
                        <span class="material-symbols-outlined text-sm">add_circle</span> Add Item
                    </button>
                </div>
                <div class="border border-outline-variant rounded-lg overflow-hidden bg-surface mb-stack-md">
                    <table class="w-full text-left erp-table">
                        <thead class="bg-surface-variant text-on-surface-variant font-label-md text-label-md border-b border-outline-variant">
                            <tr>
                                <th class="p-3">Service Name</th>
                                <th class="p-3 w-24 text-center">Qty</th>
                                <th class="p-3 w-32 text-right">Unit Price</th>
                                <th class="p-3 w-32 text-right">Total</th>
                                <th class="p-3 w-12 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items ?? [] as $index => $item)
                                <tr class="border-b border-outline-variant border-dashed">
                                    <td class="p-3">
                                        <input class="w-full bg-transparent border-b border-transparent focus:border-primary erp-input px-1" type="text" name="items[{{ $index }}][name]" value="{{ $item['name'] ?? '' }}">
                                        <div class="text-xs text-outline px-1">Code: {{ $item['code'] ?? 'N/A' }}</div>
                                    </td>
                                    <td class="p-3">
                                        <input class="w-full text-center bg-transparent border border-outline-variant rounded px-2 py-1 erp-input" min="1" type="number" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] ?? 1 }}">
                                    </td>
                                    <td class="p-3 text-right">
                                        <div class="flex items-center justify-end">
                                            <span class="text-outline mr-1">$</span>
                                            <input class="w-20 text-right bg-transparent border border-outline-variant rounded px-2 py-1 erp-input item-price" type="number" name="items[{{ $index }}][price]" value="{{ $item['price'] ?? 0 }}">
                                        </div>
                                    </td>
                                    <td class="p-3 text-right font-medium item-total">${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</td>
                                    <td class="p-3 text-center">
                                        <button type="button" class="text-outline hover:text-error transition-colors"><span class="material-symbols-outlined text-sm">delete</span></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-on-surface-variant">
                                        No items added yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Totals Section -->
                <div class="mt-auto bg-surface-bright border border-outline-variant rounded-lg p-6 flex flex-col md:flex-row justify-between items-end gap-6">
                    <div class="w-full md:w-1/2 space-y-2">
                        <div class="flex justify-between items-center text-on-surface-variant font-body-md text-body-md">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-on-surface-variant font-body-md text-body-md">
                            <span class="flex items-center gap-2">Tax (0%) <span class="material-symbols-outlined text-xs text-outline cursor-help" title="Medical services non-taxable in this region">info</span></span>
                            <span>$0.00</span>
                        </div>
                        <div class="flex justify-between items-center text-on-surface-variant font-body-md text-body-md">
                            <span>Discount</span>
                            <span class="text-secondary">-${{ number_format($discount ?? 0, 2) }}</span>
                        </div>
                        <div class="h-px bg-outline-variant my-2 w-full"></div>
                        <div class="flex justify-between items-center text-on-surface font-headline-sm text-headline-sm">
                            <span>Total Amount</span>
                            <span class="text-primary" id="grand-total">${{ number_format($total ?? 0, 2) }}</span>
                        </div>
                    </div>
                    <div class="w-full md:w-auto flex flex-col gap-3">
                        <button type="submit" class="w-full md:w-auto bg-[#0284c7] text-white px-8 py-3 rounded-lg font-label-md text-label-md hover:bg-primary transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <span class="material-symbols-outlined">print</span> Finalize & Print Invoice
                        </button>
                        <button type="button" class="w-full md:w-auto border border-[#0d9488] text-[#0d9488] px-8 py-3 rounded-lg font-label-md text-label-md hover:bg-secondary-container transition-colors flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">send</span> Send to Insurance
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
