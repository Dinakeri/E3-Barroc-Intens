<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
        }

        h1 {
            margin-bottom: 12px;
        }

        p {
            color: #555;
        }
    </style>
</head>

<body>

    <div class="card">
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
    </div>

</body>

</html>
