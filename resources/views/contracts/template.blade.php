<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contract #{{ $contract->id ?? ($quote->id ?? '') }}</title>
    <style>
        :root { color-scheme: light dark; }
        body { font-family: Arial, Helvetica, sans-serif; color: #222; margin: 0; padding: 0; }
        .container { width: 92%; margin: 20px auto; padding: 16px; }
        header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:1px solid #e5e7eb; padding-bottom:12px; }
        .brand { font-size:20px; font-weight:700; }
        .meta { text-align:right; font-size:13px; color:#6b7280; }
        .sections { display:flex; gap:20px; margin-top:18px; }
        .card { background:#fff; padding:14px; border:1px solid #e5e7eb; border-radius:6px; }
        .customer, .contract { flex:1; }
        h2 { margin:0 0 8px 0; font-size:16px; color:#111827; }
        p { margin:4px 0; font-size:13px; color:#374151; }
        table { width:100%; border-collapse:collapse; margin-top:12px; }
        table th, table td { padding:10px; border:1px solid #e5e7eb; text-align:left; font-size:13px; }
        table th { background:#f9fafb; color:#374151; }
        .right { text-align:right; }
        .total-row td { font-weight:700; }
        footer { margin-top:18px; padding-top:12px; border-top:1px dashed #e5e7eb; font-size:12px; color:#6b7280; }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="brand">Company Name — Contract</div>
            <div class="meta">
                <div>Contract #: <strong>{{ $contract->id ?? '-' }}</strong></div>
                <div>Created: <strong>{{ optional($contract->created_at ?? $quote->created_at)->format('d-m-Y') }}</strong></div>
                <div>Status: <strong>{{ ucfirst($contract->status ?? ($quote->status ?? 'pending')) }}</strong></div>
            </div>
        </header>

        <div class="sections">
            <div class="card customer">
                <h2>Customer</h2>
                @php $c = $contract->customer ?? $quote->customer ?? $customer ?? null; @endphp
                @if($c)
                    <p><strong>{{ $c->name }}</strong></p>
                    <p>{{ $c->email }}</p>
                    <p>{{ $c->phone ?? '-' }}</p>
                    <p>{{ trim(($c->street ?? '') . ' ' . ($c->house_number ?? '') . ', ' . ($c->place ?? '')) }}</p>
                @else
                    <p>-</p>
                @endif
            </div>

            <div class="card contract">
                <h2>Contract Details</h2>
                <p><strong>Start:</strong> {{ optional($contract->start_date)->format('d-m-Y') ?? '-' }}</p>
                <p><strong>End:</strong> {{ optional($contract->end_date)->format('d-m-Y') ?? '-' }}</p>
                <p><strong>Amount:</strong> € {{ number_format($contract->total_amount ?? $quote->total_amount ?? 0, 2, ',', '.') }}</p>
                <p><strong>Related Quote:</strong> {{ $contract->quote?->id ?? $quote->id ?? '-' }}</p>
            </div>
        </div>

        <div style="margin-top:18px;" class="card">
            <h2>Scope & Items</h2>
            @php $items = $quote->items ?? ($contract->quote?->items ?? collect()); @endphp
            @if($items && $items->count())
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="right">Quantity</th>
                            <th class="right">Unit</th>
                            <th class="right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td class="right">{{ $item->quantity }}</td>
                                <td class="right">€ {{ number_format($item->unit_price ?? $item->price ?? 0, 2, ',', '.') }}</td>
                                <td class="right">€ {{ number_format(($item->quantity ?? 1) * ($item->unit_price ?? $item->price ?? 0), 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="3" class="right">Contract Total</td>
                            <td class="right">€ {{ number_format($contract->total_amount ?? $quote->total_amount ?? ($items->sum(fn($i) => ($i->quantity ?? 1) * ($i->unit_price ?? $i->price ?? 0))), 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p>No items attached to this quote/contract.</p>
            @endif
        </div>

        <footer>
            This document represents the contract between the customer and the company. Terms and conditions apply as agreed. For questions contact support@company.example
        </footer>
    </div>
</body>

</html>
