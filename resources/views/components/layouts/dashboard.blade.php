<!DOCTYPE html>
<html lang="en">

@include('partials.head')

<body class="font-sans min-h-screen flex text-black bg-white">
    <header class="bg-neutral-900 w-72 shadow-lg fixed">
        <aside class="flex flex-col h-screen w-4/5 mx-auto">
            <!-- Logo / Title -->
            <div class="px-6 py-5 border-b border-neutral-700">
                <h1 class="text-2xl font-bold text-white text-left">@yield('title', 'Admin Panel')</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-col flex-grow mt-6">
                @yield('sidebar')
            </nav>
        </aside>
    </header>

    <main class="flex-1 overflow-y-auto p-6 ml-72 text-black dark:text-white">
        {{ $slot }}
    </main>

    @fluxScripts
</body>

</html>
