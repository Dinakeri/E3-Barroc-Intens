<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Offerte {{ $customer->name }}</title>
</head>

<body>
    <main>
        <p>Offerte ID: {{ $quote->id }}</p>
        <p>Prijs: €{{ number_format($quote->price, 2) }}</p>
        <p>Status: {{ $quote->status }}</p>
    </main>
</body>

</html>
