<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .header { text-align: left; margin-bottom: 20px; }
    .items th, .items td { padding: 6px; border: 1px solid #ddd; }
    .items { border-collapse: collapse; width: 100%; }
  </style>
  <title>Factuur</title>
</head>
<body>
  <div class="header">
    <h1>Factuur</h1>
    <div>Factuurnummer: {{ $invoice->id ?? ($invoice['id'] ?? '') }}</div>
    <div>Datum: {{ $invoice->invoice_date ?? ($invoice['invoice_date'] ?? now()->toDateString()) }}</div>
    <div>Vervaldatum: {{ $invoice->due_date ?? ($invoice['due_date'] ?? '') }}</div>
  </div>

  <div>
    <strong>Klant</strong><br>
    @if(isset($customer))
      {{ $customer->name ?? $customer->email ?? '' }}<br>
      {{ $customer->straat ?? '' }} {{ $customer->huisnummer ?? '' }}<br>
      {{ $customer->postcode ?? '' }} {{ $customer->plaats ?? '' }}
    @else
      {{ $invoice->customer_id ?? '' }}
    @endif
  </div>

  <table class="items" style="margin-top: 20px;">
    <thead>
      <tr>
        <th>Omschrijving</th>
        <th>Aantal</th>
        <th>Prijs</th>
        <th>Totaal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($items as $item)
        <tr>
          <td>{{ $item['description'] }}</td>
          <td>{{ $item['qty'] }}</td>
          <td>{{ number_format($item['price'], 2) }}</td>
          <td>{{ number_format($item['qty'] * $item['price'], 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div style="text-align: right; margin-top: 10px;">
    <strong>Totaal: </strong>
    {{ number_format(collect($items)->sum(fn($i)=> $i['qty'] * $i['price']), 2) }}
  </div>
</body>
</html>
