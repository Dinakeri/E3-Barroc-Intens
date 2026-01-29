<x-layouts.dashboard>
    @section('title', 'Financiën Dashboard')

    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <h1 class="text-3xl font-bold mb-6">Financiën Dashboard</h1>

    <p class="mb-8">
        Welcome bij het Financiën Dashboard.
    </p>

    {{-- Overlay --}}
    <div x-show="openBkrDrawer" x-transition.opacity class="fixed inset-0 bg-black/40 z-40" @click="openBkrDrawer = false"
        x-cloak></div>

    {{-- Drawer --}}
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
</x-layouts.dashboard>
