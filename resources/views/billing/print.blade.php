<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($billing->id, 6, '0', STR_PAD_LEFT) }} - {{ config('app.name', 'MediFlow ERP') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', Arial, sans-serif;
            color: #0b1c30;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #006194;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .brand { font-size: 22px; font-weight: 700; color: #006194; }
        .brand-sub { font-size: 12px; color: #6b7280; margin-top: 2px; }
        .invoice-meta { text-align: right; font-size: 13px; color: #3f4850; }
        .invoice-meta h1 { font-size: 20px; margin: 0 0 4px; color: #0b1c30; }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 6px;
        }
        .status.paid { background: #dcfce7; color: #15803d; }
        .status.pending { background: #fef9c3; color: #a16207; }
        .status.overdue { background: #fee2e2; color: #b91c1c; }
        .grid { display: flex; gap: 2rem; margin-bottom: 1.5rem; }
        .grid > div { flex: 1; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; margin-bottom: 4px; }
        .value { font-size: 15px; font-weight: 600; }
        .sub-value { font-size: 13px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        th { color: #6b7280; text-transform: uppercase; font-size: 11px; }
        .total-row td { font-size: 16px; font-weight: 700; border-top: 2px solid #0b1c30; border-bottom: none; }
        .notes { margin-top: 1.5rem; font-size: 13px; color: #3f4850; }
        .footer { margin-top: 3rem; text-align: center; font-size: 11px; color: #9ca3af; }
        .print-bar { text-align: right; margin-bottom: 1rem; }
        .print-bar button {
            background: #006194;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
        }
        @media print {
            .print-bar { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="print-bar">
        <button onclick="window.print()">Print this invoice</button>
    </div>

    <div class="header">
        <div>
            <div class="brand">MediFlow ERP</div>
            <div class="brand-sub">Clinical Excellence</div>
        </div>
        <div class="invoice-meta">
            <h1>INVOICE #{{ str_pad($billing->id, 6, '0', STR_PAD_LEFT) }}</h1>
            <div>Date: {{ \Carbon\Carbon::parse($billing->date)->format('M d, Y') }}</div>
            <div class="status {{ $billing->status }}">{{ ucfirst($billing->status) }}</div>
        </div>
    </div>

    <div class="grid">
        <div>
            <div class="label">Patient</div>
            <div class="value">{{ $billing->patient->name ?? 'Unknown' }}</div>
            <div class="sub-value">{{ $billing->patient->contact ?? '' }}</div>
        </div>
        <div>
            <div class="label">Attending Physician</div>
            <div class="value">{{ $billing->doctor->name ?? 'Unknown' }}</div>
            <div class="sub-value">{{ $billing->doctor->specialization ?? '' }}</div>
        </div>
        <div>
            <div class="label">Related Appointment</div>
            @if($billing->appointment)
                <div class="value">{{ \Carbon\Carbon::parse($billing->appointment->date)->format('M d, Y') }}</div>
                <div class="sub-value">{{ $billing->appointment->time }}</div>
            @else
                <div class="sub-value">None</div>
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Payment Method</th>
                <th style="text-align:right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Consultation / Services rendered</td>
                <td>{{ ucwords(str_replace('_', ' ', $billing->payment_method)) }}</td>
                <td style="text-align:right">${{ number_format($billing->amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2">Total</td>
                <td style="text-align:right">${{ number_format($billing->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    @if($billing->notes)
        <div class="notes">
            <div class="label">Notes</div>
            <div>{{ $billing->notes }}</div>
        </div>
    @endif

    <div class="footer">
        Thank you for choosing MediFlow ERP. This is a system-generated invoice.
    </div>
</body>
</html>
