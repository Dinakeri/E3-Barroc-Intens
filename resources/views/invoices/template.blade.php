<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
            background: #fff;
        }

        .page {
            width: 80%;
            margin: 0 auto;
            height: 297mm;
            padding: 40px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .company h1 {
            font-size: 20px;
            font-weight: bold;
        }

        .company p {
            font-size: 11px;
            color: #555;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .invoice-info table {
            font-size: 11px;
        }

        .invoice-info td {
            padding: 2px 0;
        }

        /* Customer */
        .customer-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 30px;
        }

        .customer-box h3 {
            font-size: 13px;
            margin-bottom: 8px;
        }

        /* Items table */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.items th {
            border-bottom: 2px solid #000;
            padding: 8px 4px;
            text-align: left;
            font-size: 11px;
        }

        table.items td {
            padding: 8px 4px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        /* Totals */
        .totals {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .totals table {
            width: 250px;
            font-size: 12px;
        }

        .totals td {
            padding: 6px 0;
        }

        .totals .total {
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 6px;
        }

        /* Footer */
        footer {
            position: absolute;
            bottom: 30px;
            left: 40px;
            right: 40px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="page">

        <!-- Header -->
        <div class="header">
            <div class="company">
                <h1>Barroc Intens</h1>
            </div>

            <div class="invoice-info">
                <h2>FACTUUR</h2>
                <table>
                    <tr>
                        <td>Factuurnummer:</td>
                        <td>{{ $invoice->id }}</td>
                    </tr>
                    <tr>
                        <td>Factuurdatum:</td>
                        <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Vervaldatum:</td>
                        <td>{{ $invoice->valid_until }}</td>
                    </tr>
                </table>

                <div style="margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px;">
                    <p style="font-size: 11px; color: #666; margin-bottom: 5px;"><strong>Betaalgegevens:</strong></p>
                    <p style="font-size: 10px; color: #666; margin: 2px 0;"><strong>Rekeninghouder:</strong> Barroc Intens</p>
                    <p style="font-size: 10px; color: #666; margin: 2px 0;"><strong>IBAN:</strong> NL91 ABNA 0417 1643 00</p>
                </div>
            </div>
        </div>

        <!-- Customer -->
        <div class="customer-box">
            <h3>Factuur aan:</h3>
            <p><strong>{{ $customer->name }}</strong></p>
            <p>{{ $customer->street }} {{ $customer->house_number }}</p>
            <p>{{ $customer->postcode }} {{ $customer->place }}</p>
            <p>{{ $customer->email }}</p>
        </div>

        <!-- Items -->
        <table class="items">
            <thead>
                <tr>
                    <th>Omschrijving</th>
                    <th class="text-right">Aantal</th>
                    <th class="text-right">Prijs</th>
                    <th class="text-right">Totaal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoice->order?->orderItems ?? [] as $item)
                    <tr>
                        <td>{{ $item['description'] }}</td>
                        <td class="text-right">{{ $item['qty'] }}</td>
                        <td class="text-right">€{{ number_format($item['price'], 2, ',', '.') }}</td>
                        <td class="text-right">€{{ number_format($item['qty'] * $item['price'], 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Geen items gevonden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotaal:</td>
                    <td class="text-right">€{{ number_format($invoice->total_amount, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="total">Totaal te betalen:</td>
                    <td class="text-right total">€{{ number_format($invoice->total_amount, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Notes -->
        @if ($invoice->description)
            <p style="margin-top: 20px;"><strong>Opmerking:</strong> {{ $invoice->description }}</p>
        @endif

        <!-- Footer -->
        <footer>
            Bedankt voor uw vertrouwen • {{ config('app.name') }} • {{ date('Y') }}
        </footer>

    </div>
</body>

</html>
