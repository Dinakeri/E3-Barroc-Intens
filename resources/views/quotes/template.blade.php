<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Offerte #{{ $quote->id }}</title>
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
            <h1>Offerte #{{ $quote->id }}</h1>
            <p>Datum: {{ $quote->created_at->format('d-m-Y') }}</p>
        </header>

        <div class="customer-info">
            <h2>Klantinformatie</h2>
            <p><strong>Naam:</strong> {{ $customer->name }}</p>
            <p><strong>E-mailadres:</strong> {{ $customer->email }}</p>
            <p><strong>Telefoonnummer:</strong> {{ $customer->phone ?? '-' }}</p>
            <p><strong>Adres:</strong>
                {{ trim(($customer->street ?? '') . ' ' . ($customer->house_number ?? '') . ', ' . ($customer->place ?? '')) }}
            </p>
        </div>

        <div class="quote-info">
            <h2>Offertedetails</h2>
            <table>
                <thead>
                    <tr>
                        <th>Beschrijving</th>
                        <th>Hoeveelheid</th>
                        <th>Eenheidsprijs</th>
                        <th>Totaal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>€{{ number_format($item->price, 2) }}</td>
                            <td>€{{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="total">Totaal:</td>
                        <td>€{{ number_format($quote->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <footer>
            Dank je wel voor het overwegen van onze diensten. Bij vragen kunt u ons contacteren.
        </footer>
    </div>
</body>

</html>
