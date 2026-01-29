<div class="my-5">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Opgeslagen facturen</h1>
        <flux:text>Overzicht van alle gegenereerde facturen. Gebruik de zoekbalk om snel een factuur te vinden.
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
        <flux:text>Total offertes: <strong
                class="text-zinc-900 dark:text-zinc-50">{{ $quotes->total() ?? $quotes->count() }}</strong>
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
                            Aangemaakt op</th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Geldig tot</th>
                        <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Offerte</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($quotes as $quote)
                        <tr onclick="window.location='{{ route('quotes.preview', $quote) }}'"
                            class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors hover:cursor-pointer">
                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $quote->id }}</div>
                            </td>

                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $quote->customer->name }}
                                </div>
                            </td>

                            <td class="px-4 py-5" x-data="{ status: '{{ $quote->status }}' }">
                                <form action="{{ route('quotes.update-status', $quote) }}" method="POST"
                                    @change="$el.submit()" @click.stop>
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="status" :value="status">

                                    <flux:select x-model="status" size="sm">
                                        <option value="draft">In behandeling</option>
                                        <option value="sent">Verstuurd</option>
                                        <option value="approved">Voltooid</option>
                                        <option value="rejected">Mislukt</option>
                                    </flux:select>
                                </form>
                            </td>


                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    €{{ number_format($quote->total_amount, 2, ',', '.') }}</div>
                            </td>

                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $quote->created_at->toDateString() }}
                                </div>
                            </td>


                            <td class="px-4 py-5">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $quote->valid_until }}
                                </div>
                            </td>

                            </td>

                            <td class="px-4 py-5">
                                @if ($quote->url)
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        <flux:button
                                            class="hover:cursor-pointer hover:text-blue-500 hover:border-b hover:border-blue-500 text-sm text-zinc-900 dark:text-zinc-100"
                                            href="{{ Storage::url($quote->url) }}" target="_blank"
                                            icon:trailing="arrow-up-right" onclick="event.stopPropagation();">
                                            Open PDF
                                        </flux:button>
                                    </div>
                                @else
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        <p>Nog niet gegenereerd</p>
                                    </div>
                                @endif

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
</div>
