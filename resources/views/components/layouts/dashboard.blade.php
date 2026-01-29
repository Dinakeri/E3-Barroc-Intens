<!DOCTYPE html>
<html lang="en">

@include('partials.head')

<body class="font-sans min-h-screen flex text-white bg-neutral-800" x-data="{ openBkrDrawer: false }">
    <header class="bg-neutral-900 w-72 shadow-lg fixed">
        <aside class="flex flex-col h-screen w-4/5 mx-auto">
            <!-- Logo / Title -->
            <div class="px-6 py-5 border-b border-neutral-700">
                <h1 class="text-2xl font-bold text-white text-left">@yield('title', 'Admin Panel')</h1>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-col grow mt-6 overflow-hidden">
                @yield('sidebar')
            </nav>

        </aside>
    </header>

    <main class="flex-1 overflow-y-auto p-6 ml-72 text-black dark:text-white">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="w-full mb-6">
                <flux:callout variant="success">
                    <div class="flex items-start gap-3">
                        <flux:icon.check-circle class="size-5 text-green-600 mt-1" />

                        <div class="flex-1">
                            <flux:heading size="sm">Succes</flux:heading>
                            <p class="text-sm">
                                {{ session('success') }}
                            </p>
                        </div>

                        <flux:button variant="ghost" size="sm" @click="show = false">
                            ✕
                        </flux:button>
                    </div>
                    </flux:callou>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-transition class="w-full mb-6">
                <flux:callout variant="error">
                    <div class="flex items-start gap-3">
                        <flux:icon.x-circle class="size-5 text-red-600 mt-1" />

                        <div class="flex-1">
                            <flux:heading size="sm">Fout</flux:heading>
                            <p class="text-sm">
                                {{ session('error') }}
                            </p>
                        </div>

                        <flux:button variant="ghost" size="sm" @click="show = false">
                            ✕
                        </flux:button>
                    </div>
                </flux:callout>
            </div>
        @endif


        {{ $slot }}

    </main>

    <!-- BKR Drawer Overlay -->
    <div x-show="openBkrDrawer" x-transition.opacity class="fixed inset-0 bg-black/40 z-40"
        @click="openBkrDrawer = false" x-cloak></div>

    <!-- BKR Drawer -->
    <div x-show="openBkrDrawer" x-transition
        class="fixed right-0 top-0 h-full w-[420px] bg-white dark:bg-zinc-900 shadow-xl z-50" x-cloak>
        <div class="p-6 border-b flex justify-between items-center">
            <flux:heading size="md">BKR-check</flux:heading>
            <flux:button variant="ghost" @click="openBkrDrawer = false">✕</flux:button>
        </div>

        <div class="p-6">
            @include('bkr._drawer')
        </div>
    </div>

    @fluxScripts
</body>

</html>
