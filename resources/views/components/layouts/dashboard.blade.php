<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <header class="w-4/5 mx-auto">
        <h1>Dashboard ({{ $title }})</h1>
    </header>
    <main class="w-4/5 mx-auto">
        {{ $slot }}
    </main>
    <footer>
    </footer>
</body>
</html>
