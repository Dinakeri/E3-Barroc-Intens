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
                            $purchaseDetails = [
                                'date' => $purchase->created_at->format('d-m-Y H:i'),
                                'item' => $itemName,
                                'type' => $itemType,
                                'quantity' => (string) $purchase->quantity,
                                'unit_cost' => number_format($purchase->unit_cost, 2, ',', '.'),
                                'total_cost' => number_format($purchase->total_cost, 2, ',', '.'),
                                'ordered_by' => $purchase->orderedBy?->name ?? '—',
                                'notes' => $purchase->notes ?? '—',
                            ];
                        @endphp
                        <tr class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-900"
                            data-details='@json($purchaseDetails)'
                            onclick="openPurchaseDetails(this)">
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

    <div id="purchaseDetailModal" class="fixed inset-0 hidden items-center justify-center bg-black/60 p-4">
        <div class="w-full max-w-2xl rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold">Bestelling details</h2>
                    <p class="text-sm text-gray-400">Bekijk de volledige bestelling.</p>
                </div>
                <button class="text-gray-400 hover:text-white" onclick="closePurchaseDetails()">✕</button>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 text-sm">
                <div>
                    <div class="text-xs uppercase text-gray-400">Datum</div>
                    <div id="purchaseDetailDate"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Item</div>
                    <div id="purchaseDetailItem" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Type</div>
                    <div id="purchaseDetailType"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Aantal</div>
                    <div id="purchaseDetailQuantity"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Inkoopprijs</div>
                    <div id="purchaseDetailUnitCost"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Totaal</div>
                    <div id="purchaseDetailTotalCost"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Besteld door</div>
                    <div id="purchaseDetailOrderedBy"></div>
                </div>
            </div>

            <div class="mt-4">
                <div class="text-xs uppercase text-gray-400">Notities</div>
                <div id="purchaseDetailNotes" class="mt-2 text-sm text-gray-600 dark:text-zinc-300"></div>
            </div>

            <div class="mt-6 flex justify-end">
                <flux:button variant="ghost" onclick="closePurchaseDetails()">Sluiten</flux:button>
            </div>
        </div>
    </div>

    <script>
        function openPurchaseDetails(row) {
            const details = JSON.parse(row.dataset.details || '{}');
            document.getElementById('purchaseDetailDate').textContent = details.date || '—';
            document.getElementById('purchaseDetailItem').textContent = details.item || '—';
            document.getElementById('purchaseDetailType').textContent = details.type || '—';
            document.getElementById('purchaseDetailQuantity').textContent = details.quantity || '—';
            document.getElementById('purchaseDetailUnitCost').textContent = details.unit_cost ? `€ ${details.unit_cost}` : '—';
            document.getElementById('purchaseDetailTotalCost').textContent = details.total_cost ? `€ ${details.total_cost}` : '—';
            document.getElementById('purchaseDetailOrderedBy').textContent = details.ordered_by || '—';
            document.getElementById('purchaseDetailNotes').textContent = details.notes || '—';
            document.getElementById('purchaseDetailModal').classList.remove('hidden');
            document.getElementById('purchaseDetailModal').classList.add('flex');
        }

        function closePurchaseDetails() {
            const modal = document.getElementById('purchaseDetailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-layouts.dashboard>
