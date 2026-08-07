@extends('layouts.app')

@section('title', 'Billing Management')

@section('content')
<div class="flex justify-between items-end mb-stack-lg">
    <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface">Billing Management</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Overview of financial transactions and pending invoices.</p>
    </div>
    <a href="{{ route('billing.create') }}" class="bg-[#0284c7] text-white px-6 py-3 rounded-lg font-label-md text-label-md flex items-center gap-2 hover:bg-primary-container transition-colors shadow-sm">
        <span class="material-symbols-outlined">add</span>
        Generate New Bill
    </a>
</div>

<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column (Recent Invoices Table) -->
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl border border-outline-variant p-6 shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)]">
        <h2 class="font-headline-sm text-headline-sm text-on-surface mb-stack-md">Recent Invoices</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant text-on-surface-variant font-label-md text-label-md">
                        <th class="py-3 px-4 font-semibold">Invoice ID</th>
                        <th class="py-3 px-4 font-semibold">Patient Name</th>
                        <th class="py-3 px-4 font-semibold">Date</th>
                        <th class="py-3 px-4 font-semibold">Amount</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-body-md">
                    @forelse($invoices ?? [] as $invoice)
                        <tr class="border-b border-outline-variant hover:bg-[#f0fdfa] transition-colors">
                            <td class="py-3 px-4 font-medium">#{{ $invoice->invoice_number ?? 'INV-' . str_pad($invoice->id ?? 0, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-4">{{ $invoice->patient->name ?? 'Unknown' }}</td>
                            <td class="py-3 px-4 text-on-surface-variant">{{ $invoice->date ?? 'N/A' }}</td>
                            <td class="py-3 px-4 font-medium">${{ number_format($invoice->amount ?? 0, 2) }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                    @if($invoice->status === 'paid') bg-green-100 text-green-700
                                    @elseif($invoice->status === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($invoice->status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button class="text-on-surface-variant hover:text-primary transition-colors"><span class="material-symbols-outlined text-sm">more_vert</span></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-on-surface-variant">
                                No invoices found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-center">
            <a href="{{ route('billing.index') }}" class="text-primary font-label-md text-label-md hover:underline">View All Invoices</a>
        </div>
    </div>

    <!-- Right Column (Recaps & Totals) -->
    <div class="flex flex-col gap-6">
        <!-- Monthly Revenue Recap -->
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-6 shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)] relative overflow-hidden group">
            <!-- Decorative background element -->
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary-container rounded-full opacity-10 group-hover:scale-150 transition-transform duration-500 ease-out"></div>
            <div class="flex justify-between items-start mb-2 relative z-10">
                <h2 class="font-headline-sm text-headline-sm text-on-surface">Monthly Revenue</h2>
                <span class="material-symbols-outlined text-primary">trending_up</span>
            </div>
            <p class="text-on-surface-variant font-label-md text-label-md mb-4 relative z-10">{{ $currentMonth ?? date('F Y') }}</p>
            <div class="relative z-10">
                <span class="font-headline-lg text-headline-lg text-on-surface block mb-1">${{ number_format($monthlyRevenue ?? 0, 2) }}</span>
                <span class="text-secondary font-label-md text-label-md flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                    {{ $revenueGrowth ?? 12.5 }}% vs last month
                </span>
            </div>
            <!-- Mini Chart Placeholder -->
            <div class="mt-6 h-16 w-full flex items-end gap-1 relative z-10">
                <div class="w-1/6 bg-surface-variant rounded-t-sm h-[40%]"></div>
                <div class="w-1/6 bg-surface-variant rounded-t-sm h-[60%]"></div>
                <div class="w-1/6 bg-surface-variant rounded-t-sm h-[45%]"></div>
                <div class="w-1/6 bg-surface-variant rounded-t-sm h-[80%]"></div>
                <div class="w-1/6 bg-surface-variant rounded-t-sm h-[50%]"></div>
                <div class="w-1/6 bg-primary rounded-t-sm h-[100%] shadow-[0_0_8px_rgba(0,97,148,0.4)]"></div>
            </div>
        </div>

        <!-- Pending Payments Total -->
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-6 shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.05)]">
            <div class="flex justify-between items-start mb-2">
                <h2 class="font-headline-sm text-headline-sm text-on-surface">Pending Payments</h2>
                <span class="material-symbols-outlined text-yellow-600">pending_actions</span>
            </div>
            <p class="text-on-surface-variant font-label-md text-label-md mb-4">Awaiting processing</p>
            <div>
                <span class="font-headline-lg text-headline-lg text-on-surface block mb-1">${{ number_format($pendingPayments ?? 0, 2) }}</span>
                <span class="text-on-surface-variant font-body-md text-body-md">Across {{ $pendingCount ?? 0 }} invoices</span>
            </div>
            <div class="mt-6">
                <button class="w-full border-2 border-[#0d9488] text-[#0d9488] py-2 rounded-lg font-label-md text-label-md hover:bg-[#f0fdfa] transition-colors">
                    Send Reminders
                </button>
            </div>
        </div>

        <!-- Quick Action Card -->
        <a href="{{ route('billing.create') }}" class="bg-[#0284c7] text-white rounded-xl p-6 shadow-md relative overflow-hidden flex flex-col justify-center items-center text-center cursor-pointer hover:bg-primary-container transition-colors">
            <span class="material-symbols-outlined text-4xl mb-2 opacity-80">receipt_long</span>
            <h3 class="font-headline-sm text-headline-sm mb-1">Batch Processing</h3>
            <p class="font-body-md text-sm opacity-80">Process multiple payments at once.</p>
        </a>
    </div>
</div>
@endsection
