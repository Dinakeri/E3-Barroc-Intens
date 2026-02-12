<div class="mt-6">
    <div>
        <h2 class="text-2xl font-bold mb-4">Betalingen Overzicht</h2>
        <p class="mb-6">Hieronder vind je een overzicht van alle betalingen. Klik op een betaling voor meer
            details.</p>
    </div>

    <!-- Filters -->
    <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6 mb-10">
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
                <flux:button href="{{ route('payments.create') }}" icon="plus" variant="primary" color="blue">
                    Nieuwe
                    Betaling</flux:button>
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



    <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Betaling ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Factuur ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Klant</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Bedrag (€)</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            Status</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($payments as $payment)
                        <tr onclick="window.location='{{ route('payments.show', $payment) }}'"
                            class="hover:cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">{{ $payment->id }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    <flux:button
                                        class="hover:cursor-pointer hover:text-blue-500 hover:border-b hover:border-blue-500 text-sm text-zinc-900 dark:text-zinc-100"
                                        href="{{ route('invoices.pdf', $payment->invoice) }}" target="_blank"
                                        icon:trailing="arrow-up-right" onclick="event.stopPropagation();">
                                        {{ $payment->invoice->id }}
                                    </flux:button>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    {{ $payment->invoice->customer->name }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    €{{ $payment->amount }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                    @if ($payment->status === 'failed')
                                        <flux:badge color="red" icon="x-circle">
                                            Mislukt</flux:badge>
                                    @elseif ($payment->status === 'completed')
                                        <flux:badge color="green" icon="check-circle">
                                            Voltooid</flux:badge>
                                    @else
                                        <flux:badge color="zinc" icon="clock">
                                            In behandeling</flux:badge>
                                    @endif
                                </div>
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

            <div>{{ $payments->links() }}</div>

        </div>
    </div>
</div>
