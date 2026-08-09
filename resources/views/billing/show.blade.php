@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="max-w-[900px] mx-auto flex flex-col gap-stack-lg">
    <!-- Page Header -->
    <div class="flex justify-between items-end">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Invoice #{{ str_pad($billing->id, 6, '0', STR_PAD_LEFT) }}</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Issued {{ \Carbon\Carbon::parse($billing->date)->format('M d, Y') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                @if($billing->status === 'paid') bg-green-100 text-green-700
                @elseif($billing->status === 'pending') bg-yellow-100 text-yellow-700
                @else bg-red-100 text-red-700 @endif">
                {{ ucfirst($billing->status) }}
            </span>
            <a href="{{ route('billing.print', $billing->id) }}" target="_blank" class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-outline-variant text-on-surface font-label-md text-label-md hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Print
            </a>
            @if($billing->status !== 'paid')
                <form action="{{ route('billing.mark-paid', $billing->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Mark as Paid
                    </button>
                </form>
            @endif
            <a href="{{ route('billing.edit', $billing->id) }}" class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-outline-variant text-on-surface font-label-md text-label-md hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                Edit
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-ambient p-8 flex flex-col gap-stack-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-stack-lg">
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-1">Patient</p>
                <p class="font-headline-sm text-headline-sm text-on-surface">{{ $billing->patient->name ?? 'Unknown' }}</p>
                <p class="font-body-md text-body-md text-on-surface-variant">{{ $billing->patient->contact ?? '' }}</p>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-1">Attending Physician</p>
                <p class="font-headline-sm text-headline-sm text-on-surface">{{ $billing->doctor->name ?? 'Unknown' }}</p>
                <p class="font-body-md text-body-md text-on-surface-variant">{{ $billing->doctor->specialization ?? '' }}</p>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-1">Related Appointment</p>
                @if($billing->appointment)
                    <p class="font-headline-sm text-headline-sm text-on-surface">{{ \Carbon\Carbon::parse($billing->appointment->date)->format('M d, Y') }}</p>
                    <p class="font-body-md text-body-md text-on-surface-variant">{{ $billing->appointment->time }}</p>
                @else
                    <p class="font-body-md text-body-md text-on-surface-variant">None</p>
                @endif
            </div>
        </div>

        <div class="h-px bg-outline-variant"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-lg">
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-1">Payment Method</p>
                <p class="font-body-lg text-body-lg text-on-surface">{{ ucwords(str_replace('_', ' ', $billing->payment_method)) }}</p>
            </div>
            <div class="md:text-right">
                <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-1">Total Amount</p>
                <p class="font-headline-lg text-headline-lg text-on-surface">${{ number_format($billing->amount, 2) }}</p>
            </div>
        </div>

        @if($billing->notes)
            <div class="h-px bg-outline-variant"></div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-1">Notes</p>
                <p class="font-body-md text-body-md text-on-surface">{{ $billing->notes }}</p>
            </div>
        @endif
    </div>

    <div>
        <a href="{{ route('billing.index') }}" class="text-primary font-label-md text-label-md hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Back to Invoices
        </a>
    </div>
</div>
@endsection
