<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <div>
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-bold uppercase">Betaling {{ $payment->id }}</h2>
                <p class="text-sm text-zinc-900 dark:text-zinc-400">Bekijk hier de deatils van deze betaling en nog extra
                    informatie</p>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('payments.index') }}" variant="ghost" icon="arrow-left">Terug</flux:button>
                <flux:button variant="primary" color="blue" href="{{ route('payments.edit', $payment) }}"
                    variant="primary" icon="pencil-square">
                    Bewerk Betaling
                </flux:button>
                <flux:button href="{{ route('invoices.pdf', $payment->invoice) }}" icon:trailing="arrow-up-right"
                    variant="primary" target="_blank">
                    Invoice PDF
                </flux:button>
            </div>

        </div>

        {{-- Payment details --}}
        <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 mb-6">
            <div
                class="mb-4 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow p-6 bg-zinc-50 dark:bg-zinc-800">
                <h2 class="text-zinc-900 dark:text-zinc-400 uppercase mb-4">Bedrag </h2>
                <p class="font-bold text-3xl">€ {{ number_format($payment->amount, 2, ',', '.') }}</p>
            </div>

            <div
                class="mb-4 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow p-6 bg-zinc-50 dark:bg-zinc-800">
                <h2 class="text-zinc-900 dark:text-zinc-400 uppercase mb-4">Betalingsdatum </h2>
                <p class="font-bold text-xl">{{ $payment->payment_date ?? '-' }}</p>
            </div>

            <div
                class="mb-4 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow p-6 bg-zinc-50 dark:bg-zinc-800">
                <h2 class="text-zinc-900 dark:text-zinc-400 uppercase mb-4">Status </h2>
                <p class="font-bold text-sm">
                    @if ($payment->status === 'failed')
                        <flux:badge color="red" icon="x-circle">{{ ucfirst($payment->status) }}</flux:badge>
                    @elseif ($payment->status === 'completed')
                        <flux:badge color="green" icon="check-circle">{{ ucfirst($payment->status) }}</flux:badge>
                    @else
                        <flux:badge color="zinc" icon="clock">{{ ucfirst($payment->status) }}</flux:badge>
                    @endif
                </p>
            </div>

            <div
                class="mb-4 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow p-6 bg-zinc-50 dark:bg-zinc-800">
                <h2 class="text-zinc-900 dark:text-zinc-400 uppercase mb-4">Betalingsmethod </h2>
                <p class="font-bold text-xl">{{ ucfirst(str_replace('_', ' ', $payment->method) ?? '-') }}</p>
            </div>
        </div>

        {{-- Customer details --}}
        <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg">
            <div class="border-b border-zinc-200 dark:border-zinc-700 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-t-lg">
                <h1 class="text-2xl font-bold">Klantgegevens</h1>
            </div>

            <div class="p-6">
                <div class="mb-4 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                    <flux:heading size="lg" class="my-4 p-2">
                        {{ $payment->invoice->customer->name }}</flux:heading>
                </div>
            </div>

            {{-- Horizontal divider --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                <div>
                    <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wide">Klantnaam
                    </p>
                    <p class="text-zinc-900 dark:text-zinc-50 mt-1">
                        {{ $payment->invoice->customer->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wide">Emailadres
                    </p>
                    <p class="text-zinc-900 dark:text-zinc-50 mt-1">
                        {{ $payment->invoice->customer->email }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wide">Telefoon</p>
                    <p class="text-zinc-900 dark:text-zinc-50 mt-1">
                        {{ $payment->invoice->customer->phone }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wide">Adres</p>
                    <p class="text-zinc-900 dark:text-zinc-50 mt-1">
                        {{ trim($payment->invoice->customer->street . $payment->invoice->customer->house_number . ', ' . $payment->invoice->customer->place) }}
                    </p>
                </div>

                {{-- Customer order history link --}}
                <div class="md:col-span-2 mt-4" x-data="{ showOrders: false }">
                    <flux:button variant="primary" icon="shopping-bag" x-on:click="showOrders = !showOrders"
                        class="hover:cursor-pointer">
                        Bekijk bestelgeschiedenis
                    </flux:button>


                    <div class="md:col-span-2 mt-6" x-show="showOrders" x-transition>
                        <flux:heading size="lg" class="mb-2" x-cloak>Bestellingen</flux:heading>

                        <div class="rounded-xl border border-zinc-200 p-6" x-cloak>
                            <div class="overflow-x-auto">
                                <table class="w-full" x-cloak>
                                    <thead>
                                        <tr class="border-b border-zinc-200 dark:border-zinc-200">
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                                ID
                                            </th>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                                Product</th>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                                Hoeveelheid</th>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                                Prijs
                                            </th>
                                            <th
                                                class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @if ($payment->invoice->customer->orders)
                                            @forelse ($payment->invoice->customer->orders as $order)
                                                @foreach ($order->orderItems as $item)
                                                    <tr
                                                        class="hover:bg-zinc-400 dark:hover:bg-zinc-800 hover:cursor-pointer transition-colors">
                                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                                            {{ $item->id }}</td>
                                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                                            {{ ucfirst($item->product->name) }}</td>
                                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                                            {{ $item->quantity }}
                                                        </td>
                                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                                            €{{ number_format($item->price, 2) }}</td>
                                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                                            @if ($item->status === 'cancelled')
                                                                <flux:badge color="red" icon="x-circle">
                                                                    {{ ucfirst($item->status) }}</flux:badge>
                                                            @elseif ($item->status === 'processing')
                                                                <flux:badge color="blue" icon="arrow-path"
                                                                    class="animate-pulse">
                                                                    {{ ucfirst($item->status) }}</flux:badge>
                                                            @elseif ($item->status === 'completed')
                                                                <flux:badge color="green" icon="check-circle">
                                                                    {{ ucfirst($item->status) }}</flux:badge>
                                                            @else
                                                                <flux:badge color="zinc" icon="clock">
                                                                    {{ ucfirst($item->status) }}</flux:badge>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @empty
                                                <tr>
                                                    <td colspan="4"
                                                        class="px-4 py-3 text-zinc-900 dark:text-zinc-200 text-center">
                                                        Geen bestellingen gevonden.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
