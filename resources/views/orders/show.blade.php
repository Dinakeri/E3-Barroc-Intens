<x-layouts.dashboard :title="'Sales Dashboard - Alle bestellingen'">
    @section('title', 'Sales Dashboard')
    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection


    <div class="flex items-center justify-between mb-8">
        <div>
            <flux:heading size="xl">
                Bestelling #{{ $order->id }}
            </flux:heading>
            <flux:text class="text-zinc-500 mt-1">
                Aangemaakt op {{ $order->order_date }}
            </flux:text>
        </div>


        {{-- Status badge --}}
        <div class="flex items-center gap-3">
            <span>
                @switch($order->status)
                    @case('pending')
                        <flux:badge variant="pill" color="yellow" icon="arrow-path">In afwachting</flux:badge>
                    @break

                    @case('completed')
                        <flux:badge variant="pill" color="green" icon="check-circle">Voltooid</flux:badge>
                    @break

                    @case('cancelled')
                        <flux:badge variant="pill" color="red" icon="x-circle">Geannuleerd</flux:badge>
                    @break

                    @default
                        <flux:badge variant="pill">Onbekend</flux:badge>
                @endswitch
            </span>

            <flux:button href="{{ route('orders.edit', $order) }}" icon="pencil-square" variant="primary"
                color="blue">
                Bewerken
            </flux:button>

            <flux:button href="{{ route('orders.index') }}" variant="primary" color="zinc" icon="arrow-left">Terug
            </flux:button>
        </div>
    </div>


    {{-- Customer info and order details --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Customer info and order --}}
        <a href="{{ route('customers.show', $order->customer) }}" class="hover:cursor-pointer">
            <div class="border rounded-xl p-6 bg-white dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700"">
                <flux:heading size="md">Klant</flux:heading>

                <div class="mt-4 space-y-1">
                    <div class="font-medium">{{ $order->customer->name }}</div>
                    <div class="text-sm text-zinc-500">{{ $order->customer->email }}</div>
                    <div class="text-sm text-zinc-500">{{ $order->customer->phone }}</div>
                </div>
            </div>
        </a>


        {{-- Order details --}}
        <div class="border rounded-xl p-6 bg-white dark:bg-zinc-800">
            <flux:heading size="md">Bestelgegevens</flux:heading>

            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-zinc-500">Besteldatum</span>
                    <span>{{ $order->order_date }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-zinc-500">Status</span>
                    <span>{{ ucfirst($order->status) }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-zinc-500">Aantal producten</span>
                    <span>{{ $order->orderItems->sum('quantity') }}</span>
                </div>
            </div>
        </div>


        {{-- Financial summary --}}
        <div class="border rounded-xl p-6 bg-white dark:bg-zinc-800">
            <flux:heading size="md">Financieel</flux:heading>

            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-zinc-500">Subtotaal</span>
                    <span>€ {{ number_format($order->total_amount, 2) }}</span>
                </div>

                <div class="flex justify-between font-semibold border-t pt-2 mt-2">
                    <span>Totaal</span>
                    <span>€ {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>


        {{-- Products --}}
        <div class="col-span-4">
            <div class="px-4 py-3">
                <flux:heading size="lg">Producten</flux:heading>
            </div>


            <div class="border rounded-xl bg-white dark:bg-zinc-800 overflow-hidden">
                <table class="w-full text-sm">
                    <thead
                        class="bg-zinc-100 dark:bg-zinc-900 rounded-t-xl border-b-2 border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-5 font-semibold text-left">Product</th>
                            <th class="px-6 py-5 font-semibold text-right">Prijs</th>
                            <th class="px-6 py-5 font-semibold text-right">Aantal</th>
                            <th class="px-6 py-5 font-semibold text-right">Totaal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $item->product->name }}</div>
                                    <div class="text-xs text-zinc-500">
                                        {{ $item->product->type }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    € {{ number_format($item->price, 2) }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    {{ $item->quantity }}
                                </td>

                                <td class="px-6 py-4 text-right font-medium">
                                    € {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($order->notes)
            <div class="mt-8 border rounded-xl p-6 bg-white dark:bg-zinc-800">
                <flux:heading size="md">Notities</flux:heading>
                <p class="mt-2 text-sm text-zinc-600">
                    {{ $order->notes }}
                </p>
            </div>
        @endif
    </div>

</x-layouts.dashboard>
