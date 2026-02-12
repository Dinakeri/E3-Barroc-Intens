<div>
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>Producten</flux:heading>
                <flux:subheading>Beheer en filter uw producten</flux:subheading>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg bg-green-600 text-white px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="Zoeken op naam of type..." icon="magnifying-glass" />
                </div>

                <flux:select wire:model.live="status" placeholder="Status">
                    <option value="">Alle</option>
                    <option value="active">Actief</option>
                    <option value="phased_out">Uitgefaseerd</option>
                    <option value="out_of_stock">Niet op voorraad</option>
                </flux:select>

                <div class="ml-auto">
                    <flux:button variant="primary" color="blue" icon:trailing="plus"
                        href="{{ route('products.create') }}">Nieuw Product</flux:button>
                </div>
            </div>
            @if ($search || $status)
                <div class="mt-4">
                    <flux:button wire:click="resetFilters" variant="ghost" size="sm">
                        Filters wissen
                    </flux:button>
                </div>
            @endif
        </div>

        {{-- Products Table --}}
        <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                <button wire:click="sortBy('name')" class="flex items-center gap-1 hover:text-blue-600">
                                    Product
                                    @if($sortField === 'name')
                                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Type
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                <button wire:click="sortBy('stock')" class="flex items-center gap-1 hover:text-blue-600">
                                    Voorraad
                                    @if($sortField === 'stock')
                                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </button>
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Min. Voorraad
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Status
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Prijs
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Acties
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($products as $product)
                            <tr wire:click="showProductDetails({{ $product->id }})"
                                class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">

                                <td class="px-4 py-3">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $product->name }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $product->type }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    @if($product->stock < $product->min_stock)
                                        <flux:badge color="red" icon="exclamation-triangle">
                                            {{ $product->stock }}
                                        </flux:badge>
                                    @elseif($product->stock <= $product->min_stock * 1.5)
                                        <flux:badge color="yellow" icon="exclamation-circle">
                                            {{ $product->stock }}
                                        </flux:badge>
                                    @else
                                        <flux:badge color="green" icon="check-circle">
                                            {{ $product->stock }}
                                        </flux:badge>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $product->min_stock }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    @if($product->status === 'active')
                                        <flux:badge color="green" icon="check-circle">
                                            Actief
                                        </flux:badge>
                                    @elseif($product->status === 'out_of_stock')
                                        <flux:badge color="red" icon="x-circle">
                                            Niet op voorraad
                                        </flux:badge>
                                    @else
                                        <flux:badge color="zinc" icon="archive-box">
                                            Uitgefaseerd
                                        </flux:badge>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">€{{ number_format($product->sales_price, 2) }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    <flux:button href="{{ route('products.edit', $product) }}" variant="ghost" size="sm" wire:click.stop>
                                        Bewerken
                                    </flux:button>
                                    <flux:button wire:click.stop="confirmDelete({{ $product->id }})" variant="ghost" size="sm" aria-label="Verwijderen">
                                        <span class="inline-flex items-center justify-center rounded-md bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 px-2 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M9 3.75A.75.75 0 0 1 9.75 3h4.5a.75.75 0 0 1 .75.75V5.25h4.5a.75.75 0 0 1 0 1.5h-.75l-.55 11.05a2.25 2.25 0 0 1-2.245 2.135H8.045A2.25 2.25 0 0 1 5.8 17.8L5.25 6.75H4.5a.75.75 0 0 1 0-1.5H9V3.75Zm1.5 1.5V5.25h3V5.25h-3Zm-2.755 1.5.53 10.61a.75.75 0 0 0 .748.715h7.91a.75.75 0 0 0 .748-.715l.53-10.61H7.745Zm3.255 2.25a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 .75-.75Zm3 0a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    Geen producten gevonden.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <flux:modal name="delete-product" wire:model="showDeleteModal" class="max-w-md">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Product verwijderen</flux:heading>
                <flux:subheading>Weet u zeker dat u dit product wilt verwijderen?</flux:subheading>
            </div>

            @if($productToDelete)
                <div class="rounded-lg bg-zinc-100 dark:bg-zinc-900 p-3 text-sm">
                    {{ $productToDelete->name }}
                </div>
            @endif

            <div class="flex justify-end gap-3">
                <flux:button variant="ghost" wire:click="cancelDelete">Annuleren</flux:button>
                <flux:button variant="primary" color="red" wire:click="deleteProduct">Verwijderen</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="product-details" wire:model="showDetailsModal" class="max-w-2xl">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Productdetails</flux:heading>
                <flux:subheading>Bekijk alle informatie van dit product.</flux:subheading>
            </div>

            @if($selectedProduct)
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <flux:label>Naam</flux:label>
                        <div class="mt-1 text-sm font-medium">{{ $selectedProduct['name'] }}</div>
                    </div>
                    <div>
                        <flux:label>Type</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedProduct['type'] }}</div>
                    </div>
                    <div>
                        <flux:label>Voorraad</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedProduct['stock'] }}</div>
                    </div>
                    <div>
                        <flux:label>Min. voorraad</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedProduct['min_stock'] }}</div>
                    </div>
                    <div>
                        <flux:label>Status</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedProduct['status'] }}</div>
                    </div>
                    <div>
                        <flux:label>Inkoopprijs</flux:label>
                        <div class="mt-1 text-sm">€{{ number_format($selectedProduct['cost_price'], 2) }}</div>
                    </div>
                    <div>
                        <flux:label>Verkoopprijs</flux:label>
                        <div class="mt-1 text-sm">€{{ number_format($selectedProduct['sales_price'], 2) }}</div>
                    </div>
                    <div>
                        <flux:label>Afmetingen (L x B x D)</flux:label>
                        <div class="mt-1 text-sm">
                            {{ $selectedProduct['length'] }} x {{ $selectedProduct['width'] }} x {{ $selectedProduct['breadth'] }} cm
                        </div>
                    </div>
                    <div>
                        <flux:label>Gewicht</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedProduct['weight'] }} kg</div>
                    </div>
                </div>

                <div>
                    <flux:label>Beschrijving</flux:label>
                    <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $selectedProduct['description'] }}</div>
                </div>
            @endif

            <div class="flex justify-end">
                <flux:button variant="ghost" wire:click="closeDetails">Sluiten</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
