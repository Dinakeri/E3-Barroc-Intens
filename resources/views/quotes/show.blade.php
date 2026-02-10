<x-layouts.dashboard :title="'Offerte preview'">

    @section('title', 'Sales Dashboard')

    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    <div class="max-w-5xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex justify-between items-start border-b pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Offerte</h1>
                <p class="text-zinc-500 mt-1">
                    Offerte #{{ $quote->id }} • {{ $quote->created_at->format('d-m-Y') }}
                </p>
            </div>

            <div class="text-right text-sm text-zinc-600">
                <flux:button variant="primary" color="zinc" icon="arrow-left" href="{{ route('quotes.index') }}">
                    Terug
                </flux:button>
            </div>
        </div>

        {{-- Customer & Quote Info --}}
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border p-6">
                <h2 class="font-semibold mb-3 text-zinc-900 dark:text-white">Klantgegevens</h2>
                <dl class="text-sm space-y-1 text-zinc-700 dark:text-zinc-300">
                    <div><strong>Naam:</strong> {{ $quote->customer->name }}</div>
                    <div><strong>Email:</strong> {{ $quote->customer->email }}</div>
                    <div><strong>Telefoon:</strong> {{ $quote->customer->phone ?? '-' }}</div>
                    <div><strong>Adres:</strong>
                        {{ trim(($quote->customer->straat ?? '') . ' ' . ($quote->customer->huisnummer ?? '') . ', ' . ($quote->customer->plaats ?? '')) }}
                    </div>
                </dl>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border p-6">
                <h2 class="font-semibold mb-3 text-zinc-900 dark:text-white">Offerte details</h2>
                <dl class="text-sm space-y-2">
                    <div class="flex justify-between">
                        <span>Status</span>
                        @switch($quote->status)
                            @case('draft')
                                <flux:badge color="amber">
                                    In behandeling
                                </flux:badge>
                            @break

                            @case('sent')
                                <flux:badge color="blue">
                                    Verstuurd
                                </flux:badge>
                            @break

                            @case('approved')
                                <flux:badge color="green">
                                    Goedgekeurd
                                </flux:badge>
                            @break

                            @case('rejected')
                                <flux:badge color="red">
                                    Afgewezen
                                </flux:badge>
                            @break

                            @default
                                <flux:badge>
                                    {{ ucfirst($quote->status) }}
                                </flux:badge>
                        @endswitch
                    </div>

                    <div class="flex justify-between">
                        <span>Geldig tot</span>
                        <span class="font-medium">
                            {{ \Carbon\Carbon::parse($quote->valid_until)->format('d-m-Y') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Totaalbedrag</span>
                        <span class="font-semibold text-lg">
                            € {{ number_format($quote->total_amount, 2, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span>Bestellingnummer</span>
                        <a href="{{ route('orders.show', $quote->order) }}">
                            <span class="font-semibold text-lg hover:underline text-blue-500">
                                #{{ $quote->order_id ?? '-' }}
                            </span>
                        </a>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Line items --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl border overflow-hidden">
            <table class="w-full">
                <thead class="bg-zinc-100 dark:bg-zinc-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Product</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aantal</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Prijs</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Totaal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($quote->customer->orders as $order)
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td class="px-4 py-3">{{ ucfirst($item->product->name) }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">€ {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 font-medium">
                                    € {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PDF Preview --}}
        <section class="bg-white dark:bg-zinc-800 rounded-xl border shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Offerte PDF
                </h2>

                <flux:button href="{{ Storage::url($quote->url) }}" target="_blank" variant="ghost"
                    icon:trailing="arrow-up-right">
                    Open in nieuw tabblad
                </flux:button>
            </div>

            <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-b-xl">
                @if ($quote->url)
                    <embed src="{{ Storage::url($quote->url) }}" type="application/pdf"
                        class="w-full h-[650px] rounded-md border" />
                @else
                    <div class="text-center text-zinc-500 py-16">
                        PDF is nog niet gegenereerd.
                    </div>
                @endif
            </div>
        </section>


        {{-- Footer --}}
        <div class="bg-zinc-50 dark:bg-zinc-900 rounded-xl p-6 text-sm text-zinc-600 dark:text-zinc-400">
            <p>
                Bedankt voor uw interesse in onze diensten.
                Deze offerte is vrijblijvend en geldig tot de hierboven vermelde datum.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3">
            <flux:button variant="ghost" href="{{ route('quotes.index') }}">
                Terug
            </flux:button>

            <form action="{{ route('quotes.send', $quote) }}" method="POST">
                @csrf
                <flux:button type="submit" variant="primary">
                    Offerte verzenden
                </flux:button>

            </form>
        </div>

    </div>
</x-layouts.dashboard>
