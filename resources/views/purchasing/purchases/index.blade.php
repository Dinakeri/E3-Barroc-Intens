<x-layouts.dashboard>
    @section('title', 'Inkoop')

    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Inkoop</h1>
            <p class="text-gray-400">Bestellingen van onderdelen en machines</p>
        </div>
        <flux:button href="{{ route('purchases.create') }}" variant="primary">
            Nieuwe bestelling
        </flux:button>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-700 text-sm text-gray-500">
                        <th class="px-4 py-3">Datum</th>
                        <th class="px-4 py-3">Item</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Aantal</th>
                        <th class="px-4 py-3">Prijs</th>
                        <th class="px-4 py-3">Totaal</th>
                        <th class="px-4 py-3">Besteld door</th>
                        <th class="px-4 py-3">Notities</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700 text-sm">
                    @forelse($purchases as $purchase)
                        @php
                            $itemName = $purchase->product?->name ?? $purchase->part?->name ?? '—';
                            $itemType = $purchase->product_id ? 'Machine' : 'Onderdeel';
                        @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">
                                {{ $purchase->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $itemName }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $itemType }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $purchase->quantity }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">€ {{ number_format($purchase->unit_cost, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">€ {{ number_format($purchase->total_cost, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $purchase->orderedBy?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $purchase->notes ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-zinc-300">
                                Nog geen bestellingen geregistreerd.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $purchases->links() }}
        </div>
    </div>

    @section('sidebar')
        <x-purchasing-sidebar current="purchases" />
    @endsection
</x-layouts.dashboard>
