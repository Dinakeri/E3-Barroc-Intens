<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:30px">

    <div style="max-width:600px; margin:auto; background:white; padding:30px; border-radius:8px">

        @php use Illuminate\Support\Facades\Storage; @endphp


        <h2 style="margin-bottom:10px">Your quote is ready</h2>

        <p>Dear {{ $quote->customer->name }},</p>

        <p>
            We have prepared a quote for you.
            You can view the quote using the button below.
        </p>

        <p style="margin:30px 0">
            <a href="{{ route('quotes.preview', $quote->url) }}"
                style="background:#2563eb; color:white; padding:12px 20px; text-decoration:none; border-radius:6px">
                View quote
            </a>
        </p>

        <p>
            If you have any questions, feel free to contact us.
        </p>

        <p style="margin-top:40px">
            Kind regards,<br>
            <strong>Your Company</strong>
        </p>

    </div>

</body>

</html>
