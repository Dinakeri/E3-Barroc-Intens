<div x-data="{ open: false }" x-on:open-order-drawer.window="open = true" x-on:close-order-drawer.window="open = false"
    x-cloak>
    <!-- Overlay -->
    <div x-show="open" class="fixed inset-0 bg-black/50 z-40" x-transition.opacity x-on:click="open = false"></div>

    <!-- Drawer -->
    <div x-show="open" class="fixed right-0 top-0 h-full w-full max-w-lg bg-white dark:bg-zinc-900 z-50 shadow-xl"
        x-transition:enter="transform transition ease-out duration-300" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
        <div class="p-6 border-b dark:border-zinc-700 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Nieuwe bestelling</h2>

            <button x-on:click="open = false">✕</button>
        </div>

        <div class="p-6">
            @include('orders._form')
        </div>
    </div>
</div>
