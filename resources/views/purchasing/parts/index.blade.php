<x-layouts.dashboard>
    @section('title', 'Onderdelen')

    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Onderdelen</h1>
            <p class="text-gray-400">Overzicht van onderdelen en voorraad</p>
        </div>
        <flux:button href="{{ route('parts.create') }}" variant="primary">
            Nieuw onderdeel
        </flux:button>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-700 text-sm text-gray-500">
                        <th class="px-4 py-3">Onderdeel</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Voorraad</th>
                        <th class="px-4 py-3">Min</th>
                        <th class="px-4 py-3">Locatie</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700 text-sm">
                    @forelse($parts as $part)
                        @php
                            $partDetails = [
                                'name' => $part->name,
                                'sku' => $part->sku,
                                'stock' => (string) $part->stock,
                                'min_stock' => (string) $part->min_stock,
                                'location' => $part->location ?? '—',
                                'status' => $part->status,
                                'cost_price' => number_format($part->cost_price, 2, ',', '.'),
                                'description' => $part->description,
                            ];
                        @endphp
                        <tr class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-900"
                            data-details='@json($partDetails)'
                            onclick="openPartDetails(this)">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $part->name }}</div>
                                <p class="text-xs text-gray-500 dark:text-zinc-300 line-clamp-1">{{ $part->description }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->sku }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->stock }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->min_stock }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->location ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <flux:badge color="{{ $part->status === 'out_of_stock' ? 'red' : ($part->status === 'phased_out' ? 'zinc' : 'green') }}">
                                    {{ $part->status === 'out_of_stock' ? 'Niet op voorraad' : ($part->status === 'phased_out' ? 'Uitgefaseerd' : 'Actief') }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" href="{{ route('parts.edit', $part) }}" onclick="event.stopPropagation()">
                                        Bewerken
                                    </flux:button>
                                    <form action="{{ route('parts.destroy', $part) }}" method="POST" onsubmit="event.stopPropagation();">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button size="sm" variant="ghost" type="button" aria-label="Verwijderen" onclick="event.stopPropagation(); openPartDeleteModal('{{ route('parts.destroy', $part) }}', '{{ addslashes($part->name) }}')">
                                            <span class="inline-flex items-center justify-center rounded-md bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 px-2 py-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                    <path fill-rule="evenodd" d="M9 3.75A.75.75 0 0 1 9.75 3h4.5a.75.75 0 0 1 .75.75V5.25h4.5a.75.75 0 0 1 0 1.5h-.75l-.55 11.05a2.25 2.25 0 0 1-2.245 2.135H8.045A2.25 2.25 0 0 1 5.8 17.8L5.25 6.75H4.5a.75.75 0 0 1 0-1.5H9V3.75Zm1.5 1.5V5.25h3V5.25h-3Zm-2.755 1.5.53 10.61a.75.75 0 0 0 .748.715h7.91a.75.75 0 0 0 .748-.715l.53-10.61H7.745Zm3.255 2.25a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 .75-.75Zm3 0a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-zinc-300">
                                Geen onderdelen gevonden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $parts->links() }}
        </div>
    </div>

    @section('sidebar')
        <x-purchasing-sidebar current="parts" />
    @endsection

    <div id="partDetailModal" class="fixed inset-0 hidden items-center justify-center bg-black/60 p-4">
        <div class="w-full max-w-2xl rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold">Onderdeel details</h2>
                    <p class="text-sm text-gray-400">Bekijk alle informatie van dit onderdeel.</p>
                </div>
                <button class="text-gray-400 hover:text-white" onclick="closePartDetails()">✕</button>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 text-sm">
                <div>
                    <div class="text-xs uppercase text-gray-400">Naam</div>
                    <div id="partDetailName" class="font-medium"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">SKU</div>
                    <div id="partDetailSku"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Voorraad</div>
                    <div id="partDetailStock"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Minimale voorraad</div>
                    <div id="partDetailMinStock"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Locatie</div>
                    <div id="partDetailLocation"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Status</div>
                    <div id="partDetailStatus"></div>
                </div>
                <div>
                    <div class="text-xs uppercase text-gray-400">Inkoopprijs</div>
                    <div id="partDetailCost"></div>
                </div>
            </div>

            <div class="mt-4">
                <div class="text-xs uppercase text-gray-400">Beschrijving</div>
                <div id="partDetailDescription" class="mt-2 text-sm text-gray-600 dark:text-zinc-300"></div>
            </div>

            <div class="mt-6 flex justify-end">
                <flux:button variant="ghost" onclick="closePartDetails()">Sluiten</flux:button>
            </div>
        </div>
    </div>

    <div id="partDeleteModal" class="fixed inset-0 hidden items-center justify-center bg-black/60 p-4">
        <div class="w-full max-w-md rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-6">
            <div class="space-y-4">
                <div>
                    <h2 class="text-lg font-semibold">Onderdeel verwijderen</h2>
                    <p class="text-sm text-gray-400">Weet je zeker dat je dit onderdeel wilt verwijderen?</p>
                </div>

                <div class="rounded-lg bg-zinc-100 dark:bg-zinc-900 p-3 text-sm" id="partDeleteName"></div>

                <div class="flex justify-end gap-3">
                    <flux:button variant="ghost" onclick="closePartDeleteModal()">Annuleren</flux:button>
                    <form id="partDeleteForm" method="POST" onsubmit="event.stopPropagation();">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="primary" color="red" type="submit">Verwijderen</flux:button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPartDetails(row) {
            const details = JSON.parse(row.dataset.details || '{}');
            document.getElementById('partDetailName').textContent = details.name || '—';
            document.getElementById('partDetailSku').textContent = details.sku || '—';
            document.getElementById('partDetailStock').textContent = details.stock || '—';
            document.getElementById('partDetailMinStock').textContent = details.min_stock || '—';
            document.getElementById('partDetailLocation').textContent = details.location || '—';
            document.getElementById('partDetailStatus').textContent = details.status || '—';
            document.getElementById('partDetailCost').textContent = details.cost_price ? `€ ${details.cost_price}` : '—';
            document.getElementById('partDetailDescription').textContent = details.description || '—';
            document.getElementById('partDetailModal').classList.remove('hidden');
            document.getElementById('partDetailModal').classList.add('flex');
        }

        function closePartDetails() {
            const modal = document.getElementById('partDetailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openPartDeleteModal(actionUrl, partName) {
            const modal = document.getElementById('partDeleteModal');
            document.getElementById('partDeleteForm').setAttribute('action', actionUrl);
            document.getElementById('partDeleteName').textContent = partName || '—';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePartDeleteModal() {
            const modal = document.getElementById('partDeleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-layouts.dashboard>
