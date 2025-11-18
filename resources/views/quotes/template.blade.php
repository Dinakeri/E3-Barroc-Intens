<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quote #{{ $quote->id }}</title>
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
        .quote-info {
            margin-bottom: 20px;
        }

        .customer-info h2,
        .quote-info h2 {
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
            <h1>Quote #{{ $quote->id }}</h1>
            <p>Date: {{ $quote->created_at->format('d-m-Y') }}</p>
        </header>

        <div class="customer-info">
            <h2>Customer Information</h2>
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Phone:</strong> {{ $customer->phone ?? '-' }}</p>
            <p><strong>Address:</strong>
                {{ trim(($customer->straat ?? '') . ' ' . ($customer->huisnummer ?? '') . ', ' . ($customer->plaats ?? '')) }}
            </p>
        </div>

        <div class="quote-info">
            <h2>Quote Details</h2>
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
                    @foreach ($quote->items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>€{{ number_format($item->unit_price, 2) }}</td>
                            <td>€{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="total">Total:</td>
                        <td>€{{ number_format($quote->total_price, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <footer>
            Thank you for considering our services. If you have any questions, please contact us.
        </footer>
    </div>
</body>

</html>
