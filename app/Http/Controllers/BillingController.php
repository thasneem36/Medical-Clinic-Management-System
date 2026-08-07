<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillingRequest;
use App\Models\Billing;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Billing::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Calculate stats
        $monthlyRevenue = Billing::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('status', 'paid')
            ->sum('amount');
        
        $pendingPayments = Billing::where('status', 'pending')->sum('amount');
        $pendingCount = Billing::where('status', 'pending')->count();
        
        return view('billing.index', compact('invoices', 'monthlyRevenue', 'pendingPayments', 'pendingCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        $invoiceNumber = Billing::max('id') + 1;
        
        return view('billing.create', compact('patients', 'doctors', 'invoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillingRequest $request)
    {
        // Calculate total from items
        $total = 0;
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
        }
        
        // Use provided amount or calculate from items
        $amount = $request->amount ?? $total;
        
        $billing = Billing::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_id' => $request->appointment_id,
            'amount' => $amount,
            'status' => $request->status ?? 'pending',
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'date' => now()->toDateString(),
        ]);
        
        return redirect()->route('billing.show', $billing->id)
            ->with('success', 'Invoice generated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Billing $billing)
    {
        $billing->load(['patient', 'doctor', 'appointment']);
        return view('billing.show', compact('billing'));
    }

    /**
     * Print the specified invoice.
     */
    public function print(Billing $billing)
    {
        $billing->load(['patient', 'doctor', 'appointment']);
        return view('billing.print', compact('billing'));
    }

    /**
     * Mark invoice as paid.
     */
    public function markAsPaid(Billing $billing)
    {
        $billing->update(['status' => 'paid']);
        
        return redirect()->route('billing.show', $billing->id)
            ->with('success', 'Invoice marked as paid.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing)
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        return view('billing.edit', compact('billing', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Billing $billing)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,paid,overdue',
            'payment_method' => 'required|in:credit_card,cash,insurance,bank_transfer',
            'notes' => 'nullable|string|max:1000',
        ]);

        $billing->update($validated);

        return redirect()->route('billing.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billing $billing)
    {
        $billing->delete();
        return redirect()->route('billing.index')->with('success', 'Invoice deleted successfully.');
    }
}
