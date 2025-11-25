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
            <p><strong>Naam:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Telefoonummer:</strong> {{ $customer->phone ?? '-' }}</p>
            <p><strong>Adres:</strong>
                {{ trim(($customer->straat ?? '') . ' ' . ($customer->huisnummer ?? '') . ', ' . ($customer->plaats ?? '')) }}
            </p>
        </div>

        <div class="quote-info">
            <h2>Offerte Details</h2>
            <div class="rounded-xl border border-zinc-200 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-200">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">ID
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                    Product</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                    Hoeveelheid</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                    Prijs
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @if ($customer->orders)
                                @forelse ($customer->orders as $order)
                                    @foreach ($order->orderItems as $item)
                                        <tr
                                            class="hover:bg-zinc-400 dark:hover:bg-zinc-800 hover:cursor-pointer transition-colors">
                                            <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">{{ $item->id }}
                                            </td>
                                            <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                                {{ ucfirst($item->product->name) }}</td>
                                            <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">{{ $item->quantity }}
                                            </td>
                                            <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                                €{{ number_format($item->price, 2) }}</td>
                                            <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">{{ $item->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-4 py-3 text-zinc-900 dark:text-zinc-200 text-center">
                                            Geen bestellingen gevonden.
                                        </td>
                                    </tr>
                                @endforelse
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer>
            Thank you for considering our services. If you have any questions, please contact us.
        </footer>
    </div>
</body>

</html>
