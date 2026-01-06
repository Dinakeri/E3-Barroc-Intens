<div class="mt-6">
    <div class="mb-10">
        <flux:heading size="xl" class="mb-5">Alle Orders</flux:heading>
        <flux:text>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe, unde qui. Corrupti
            provident possimus id voluptates praesentium. Ipsam eaque alias provident officiis distinctio
            voluptatem? Porro molestiae placeat harum error veniam!</flux:text>
    </div>

    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 mb-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="lg:col-span-2">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Zoeken op klantnaam of e-mailadres..."
                    icon="magnifying-glass" />
            </div>

            <flux:select wire:model.live="status" placeholder="Status">
                <option value="">Alle</option>
                <option value="pending">In behandeling</option>
                <option value="completed">Voltooid</option>
                <option value="cancelled">Mislukt</option>
            </flux:select>

            <div class="ml-auto">
                <flux:button icon="plus" variant="primary" color="blue" href="{{ route('orders.create') }}">
                    Nieuwe
                    bestelling</flux:button>
            </div>
        </div>

        @if ($search || $status)
            <div class="mt-4">
                <flux:button wire:click="resetFilters" variant="ghost" size="sm">
                    Clear Filters
                </flux:button>
            </div>
        @endif
    </div>


    <div class="border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-md rounded-xl p-4">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b-2 border-zinc-900 dark:border-zinc-400">
                    <tr class="text-left">
                        <th class="px-4 py-5 text-sm text-zinc-900 dark:text-zinc-200 font-bold">ID</th>
                        <th class="px-4 py-5 text-sm text-zinc-900 dark:text-zinc-200 font-bold">Klant</th>
                        <th class="px-4 py-5 text-sm text-zinc-900 dark:text-zinc-200 font-bold">Producten</th>
                        <th class="px-4 py-5 text-sm text-zinc-900 dark:text-zinc-200 font-bold">Besteldatum</th>
                        <th class="px-4 py-5 text-sm text-zinc-900 dark:text-zinc-200 font-bold">Totale bedrag</th>
                        <th class="px-4 py-5 text-sm text-zinc-900 dark:text-zinc-200 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b border-zinc-200 dark:border-zinc-700 hover:cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors"
                            onclick="window.location='{{ route('orders.show', $order) }}'">
                            <td class="px-4 py-4 text-sm text-zinc-900 dark:text-zinc-200 font-medium">
                                {{ $order->id }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-900 dark:text-zinc-200 font-medium">
                                {{ $order->customer->name }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-900 dark:text-zinc-200 font-medium flex gap-2">
                                @foreach ($order->orderItems as $item)
                                    <div class="border border-zinc-900 dark:border-zinc-400 rounded-full px-2 py-1">
                                        {{ $item->product->name }}</div>
                                @endforeach
                            </td>
                            <td class="px-4 py-4 text-sm text-zinc-900 dark:text-zinc-200 font-medium">
                                {{ $order->order_date }}</td>
                            <td class="px-4 py-4 text-sm text-zinc-900 dark:text-zinc-200 font-medium">
                                {{ $order->total_amount }}</td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    @if ($order->status === 'cancelled')
                                        <flux:badge color="red" icon="x-circle">
                                            Geannuleerd</flux:badge>
                                    @elseif ($order->status === 'completed')
                                        <flux:badge color="green" icon="check-circle">
                                            Voltooid</flux:badge>
                                    @else
                                        <flux:badge color="zinc" icon="clock">
                                            In behandeling</flux:badge>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 p-8 text-center text-zinc-500 dark:text-zinc-400">
                                Geen bestellingen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-10">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
