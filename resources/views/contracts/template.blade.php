<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contract #{{ $contract->id ?? ($quote->id ?? '') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        header p {
            margin: 2px 0;
            font-size: 14px;
        }

        .customer-info,
        .contract-info {
            margin-bottom: 20px;
        }

        .customer-info h2,
        .contract-info h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #f5f5f5;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        footer {
            border-top: 2px solid #333;
            padding-top: 10px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Contract #{{ $contract->id ?? ($quote->id ?? '') }}</h1>
            <p>Date: {{ optional($contract->created_at ?? $quote->created_at)->format('d-m-Y') }}</p>
            <p>Status: {{ ucfirst($contract->status ?? ($quote->status ?? 'pending')) }}</p>
        </header>

        @php
            $c = $contract->customer ?? $quote->customer ?? $customer ?? null;
            $items = $quote->items ?? $contract->items ?? ($contract->quote?->items ?? collect());
        @endphp

        <div class="customer-info">
            <h2>Customer Information</h2>
            @if($c)
                <p><strong>{{ $c->name ?? ($c->company_name ?? '-') }}</strong></p>
                <p>{{ $c->email ?? '-' }}</p>
                <p>{{ $c->phone ?? '-' }}</p>
                <p>
                    @php
                        $addr = trim((($c->straat ?? $c->street ?? '') . ' ' . ($c->huisnummer ?? $c->house_number ?? '') . ', ' . ($c->plaats ?? $c->place ?? '')));
                    @endphp
                    {{ $addr ?: '-' }}
                </p>
            @else
                <p>-</p>
            @endif
        </div>

        <div class="contract-info">
            <h2>Contract Details</h2>
            <p><strong>Start:</strong> {{ optional($contract->start_date)->format('d-m-Y') ?? '-' }}</p>
            <p><strong>End:</strong> {{ optional($contract->end_date)->format('d-m-Y') ?? '-' }}</p>
            <p><strong>Amount:</strong> €{{ number_format($contract->total_amount ?? $quote->total_amount ?? ($items->sum(fn($i) => ($i->quantity ?? 1) * ($i->unit_price ?? $i->price ?? 0))), 2) }}</p>
            <p><strong>Related Quote:</strong> {{ $contract->quote?->id ?? $quote->id ?? '-' }}</p>
        </div>

        <div class="quote-info">
            <h2>Items & Scope</h2>
            @if($items && $items->count())
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->description ?? ($item->product->name ?? $item->name ?? '-') }}</td>
                                <td>{{ $item->quantity ?? 1 }}</td>
                                <td>€{{ number_format($item->unit_price ?? $item->price ?? 0, 2) }}</td>
                                <td>€{{ number_format(($item->quantity ?? 1) * ($item->unit_price ?? $item->price ?? 0), 2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="total">Total:</td>
                            <td>€{{ number_format($contract->total_amount ?? $quote->total_amount ?? ($items->sum(fn($i) => ($i->quantity ?? 1) * ($i->unit_price ?? $i->price ?? 0))), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p>No items attached to this contract.</p>
            @endif
        </div>

        <footer>
            Thank you for your business. For questions, please contact support@company.example
        </footer>
    </div>
</body>

</html>
