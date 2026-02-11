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
                <option value="pending">In behandeling</option>
                <option value="completed">Voltooid</option>
                <option value="failed">Mislukt</option>
            </flux:select>

            <div class="ml-auto">
                <flux:button href="{{ route('invoices.create') }}" icon="plus" variant="primary" color="blue">
                    Nieuwe
                    factuur</flux:button>
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
        <flux:text>Total facturen: <strong
                class="text-zinc-900 dark:text-zinc-50">{{ $invoices->total() ?? $invoices->count() }}</strong>
        </flux:text>
    </div>


    <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Factuur ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Klant </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Geldig tot</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Totaal (€)</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            PDF</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($invoices as $invoice)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors hover:cursor-pointer"
                            onclick="window.location='{{ route('invoices.show', $invoice) }}'">
                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $invoice->id }}</div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $invoice->customer->name }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $invoice->valid_until ? \Carbon\Carbon::parse($invoice->valid_until)->format('d-m-Y') : 'N.v.t.' }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    €{{ number_format($invoice->total_amount, 2, ',', '.') }}</div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    @if ($invoice->status === 'cancelled')
                                        <flux:badge color="red" icon="x-circle">
                                            Geannuleerd</flux:badge>
                                    @elseif ($invoice->status === 'sent')
                                        <flux:badge color="blue" icon="paper-airplane">
                                            Verzonden</flux:badge>
                                    @elseif ($invoice->status === 'paid')
                                        <flux:badge color="green" icon="check-circle">
                                            Betaald</flux:badge>
                                    @else
                                        <flux:badge color="amber" icon="pencil">
                                            Concept</flux:badge>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                @if ($invoice->pdf_path)
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        <flux:button
                                            class="hover:cursor-pointer hover:text-blue-500 hover:border-b hover:border-blue-500 text-sm text-zinc-900 dark:text-zinc-100"
                                            href="{{ Storage::url($invoice->pdf_path) }}" target="_blank"
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
                                Geen betalingen gevonden.</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

            <div>{{ $invoices->links() }}</div>

        </div>
    </div>
</div>
