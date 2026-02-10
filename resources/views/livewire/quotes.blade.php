<div class="my-5">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Opgeslagen offertes</h1>
        <flux:text>Overzicht van alle gegenereerde offertes. Gebruik de zoekbalk om snel een offerte te vinden.
        </flux:text>
    </div>

    <!-- Filters -->
    <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Zoeken op klantnaam of e-mailadres..."
                    icon="magnifying-glass" />
            </div>

            <flux:select wire:model.live="status" placeholder="Status">
                <option value="">Alle</option>
                <option value="draft">In behandeling</option>
                <option value="sent">Gestuurd</option>
                <option value="approved">Goedgekeurd</option>
                <option value="rejected">Afgewezen</option>
            </flux:select>

            <div class="ml-auto">
                <flux:button variant="primary" icon="plus" color="blue" href="{{ route('quotes.create') }}">
                    Nieuwe offerte
                </flux:button>
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

    <div class="flex justify-end my-6 mr-2">
        {{-- <div class="text-sm text-zinc-500 dark:text-zinc-400">Totaal facturen: </div> --}}
        <flux:text>Total offertes: <strong class="text-zinc-900 dark:text-zinc-50">{{ $quotes->count() }}</strong>
        </flux:text>
    </div>


    <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Offerte ID</th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Klant </th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Status</th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Totaal (€)</th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Geldig tot</th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Bestelling</th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Acties</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($quotes as $quote)
                        <tr onclick="window.location='{{ route('quotes.show', $quote) }}'" @click.stop
                            class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors hover:cursor-pointer">
                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $quote->id }}</div>
                            </td>

                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $quote->customer->name }}
                                </div>
                            </td>


                            <td class="px-4 py-5">
                                @if ($quote->status === 'draft')
                                    <flux:badge color="zinc" icon="clock">
                                        {{ ucfirst($quote->status) }}
                                    </flux:badge>
                                @elseif ($quote->status === 'sent')
                                    <flux:badge color="blue" icon="paper-airplane">
                                        {{ ucfirst($quote->status) }}
                                    </flux:badge>
                                @elseif ($quote->status === 'approved')
                                    <flux:badge color="green" icon="check-circle">
                                        {{ ucfirst($quote->status) }}
                                    </flux:badge>
                                @elseif ($quote->status === 'rejected')
                                    <flux:badge color="red" icon="x-circle">
                                        {{ ucfirst($quote->status) }}
                                    </flux:badge>
                                @endif
                            </td>

                            </td>



                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    €{{ number_format($quote->total_amount, 2, ',', '.') }}</div>
                            </td>

                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $quote->valid_until }}
                                </div>
                            </td>

                            </td>

                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    Bestelling #{{ $quote->order->id }}
                                </div>
                            </td>

                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100 flex gap-2">
                                    <flux:button wire:click.stop="openDeleteModal({{ $quote->id }})" color="red"
                                        icon="trash" size="sm"></flux:button>

                                    <flux:button wire:click.stop="openEditModal({{ $quote->id }})" color="blue"
                                        icon="pencil-square" size="sm">
                                    </flux:button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 p-8 text-center text-zinc-500 dark:text-zinc-400">
                                Geen offertes gevonden.</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

            <div>{{ $quotes->links() }}</div>

        </div>
    </div>

    <flux:modal title="Offerte verwijderen" wire:close="closeDeleteModal" wire:model="showDeleteModal">
        <div class="space-y-6">
            <!-- Warning Icon & Message -->
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <flux:heading level="3" class="text-red-900 dark:text-red-100">
                        Offerte verwijderen?
                    </flux:heading>
                    <flux:text class="text-zinc-600 dark:text-zinc-400 mt-2">
                        Weet je zeker dat je deze offerte wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
                    </flux:text>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4 flex justify-end gap-3">
                <flux:button wire:click="closeDeleteModal" variant="ghost">
                    Annuleren
                </flux:button>
                @if ($selectedQuote)
                    <form action="{{ route('quotes.destroy', $selectedQuote->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <flux:button type="submit" color="red" variant="primary">
                            Verwijderen
                        </flux:button>
                    </form>
                @endif

            </div>
        </div>
    </flux:modal>

    <flux:modal title="Offerte bewerken" wire:close="closeEditModal" wire:model="showEditModal">
        @if ($selectedQuote)
            <form action="{{ route('quotes.update', $selectedQuote->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Header Section -->
                <div class="border-b border-zinc-200 dark:border-zinc-700 pb-4">
                    <flux:heading level="2" class="text-zinc-900 dark:text-zinc-100">
                        {{ $selectedQuote->customer->name }}
                    </flux:heading>
                    <flux:text class="text-zinc-600 dark:text-zinc-400 mt-1">
                        Offerte #{{ $selectedQuote->id }}
                    </flux:text>
                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-500 mt-2">
                        Pas de vervaldatum en status van deze offerte aan.
                    </flux:text>
                </div>

                <!-- Form Fields -->
                <div class="space-y-5">
                    <!-- Valid Until Field -->
                    <div>
                        <flux:fieldset>
                            <flux:label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">
                                Geldig tot
                            </flux:label>
                            <flux:input name="valid_until" type="date" value="{{ $selectedQuote->valid_until }}"
                                required class="w-full" />
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5">
                                Bepaal tot wanneer deze offerte geldig is.
                            </flux:text>
                        </flux:fieldset>
                    </div>

                    <!-- Status Field -->
                    <div>
                        <flux:fieldset>
                            <flux:label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">
                                Status
                            </flux:label>
                            <flux:select name="status" required class="w-full">
                                <option value="draft"
                                    {{ $selectedQuote && $selectedQuote->status === 'draft' ? 'selected' : '' }}>
                                    In behandeling
                                </option>
                                <option value="sent"
                                    {{ $selectedQuote && $selectedQuote->status === 'sent' ? 'selected' : '' }}>
                                    Gestuurd
                                </option>
                                <option value="approved"
                                    {{ $selectedQuote && $selectedQuote->status === 'approved' ? 'selected' : '' }}>
                                    Goedgekeurd
                                </option>
                                <option value="rejected"
                                    {{ $selectedQuote && $selectedQuote->status === 'rejected' ? 'selected' : '' }}>
                                    Afgewezen
                                </option>
                            </flux:select>
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5">
                                Wijzig de huidige status van de offerte.
                            </flux:text>
                        </flux:fieldset>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4 flex justify-end gap-3">
                    <flux:button wire:click="closeEditModal" variant="ghost">
                        Annuleren
                    </flux:button>
                    <flux:button type="submit" variant="primary" color="blue">
                        Opslaan
                    </flux:button>
                </div>
            </form>
        @endif

    </flux:modal>
</div>
