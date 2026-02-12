<div>
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>Customers</flux:heading>
                <flux:subheading>Manage and filter through your customer database</flux:subheading>
            </div>
        </div>

        <!-- Filters -->
        <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name, email, or address..."
                        icon="magnifying-glass" />
                </div>

                <flux:select wire:model.live="status" placeholder="Status">
                    <option value="">Alle</option>
                    <option value="new">New</option>
                    <option value="active">Actief</option>
                    <option value="expired">Verlopen</option>
                    <option value="inactive">Inactief</option>
                </flux:select>

                <div class="ml-auto">
                    <flux:button variant="primary" icon="plus" color="blue" href="{{ route('contracts.create') }}">
                        Nieuwe contract
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

        {{-- Customers Table --}}
        <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                ID
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Klantnaam
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Klantemail
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Status
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Offertes
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Acties
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($contracts as $contract)
                            <tr onclick="window.location='{{ route('contracts.show', $contract) }}'"
                                class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">

                                <td class="px-4 py-4 text-sm text-zinc-900 dark:text-zinc-200 font-medium">
                                    {{ $contract->id }}</td>

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $contract->customer->name }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $contract->customer->email }}
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">
                                    @if ($contract->status === 'active')
                                        <flux:badge color="green" icon="check-circle">
                                            {{ ucfirst($contract->status) }}
                                        </flux:badge>
                                    @elseif ($contract->status === 'expired')
                                        <flux:badge color="zinc" icon="clock">
                                            {{ ucfirst($contract->status) }}
                                        </flux:badge>
                                    @elseif ($contract->status === 'inactive')
                                        <flux:badge color="red" icon="x-circle">
                                            {{ ucfirst($contract->status) }}
                                        </flux:badge>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100 truncate max-w-[200px]">
                                        @if ($contract->customer->acceptedQuote && $contract->customer->acceptedQuote->url)
                                            <flux:button href="{{ $contract->customer->acceptedQuote->url }}"
                                                variant="ghost" target="_blank" icon:trailing="arrow-up-right"
                                                onclick="event.stopPropagation();">
                                                Open PDF
                                            </flux:button>
                                        @else
                                            <div class="text-zinc-900 dark:text-zinc-100">Geen offerte</div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100 flex gap-2">
                                        <flux:button wire:click.stop="openDeleteModal({{ $contract }})"
                                            color="red" icon="trash" size="sm"></flux:button>

                                        <flux:button wire:click.stop="openEditModal({{ $contract }})"
                                            color="blue" icon="pencil-square" size="sm">
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    No customers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $contracts->links() }}
                </div>
            </div>
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
                @if ($selectedContract)
                    <form action="{{ route('contracts.destroy', $selectedContract->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <flux:button type="submit" color="red" variant="primary">
                            Verwijderen
                        </flux:button>
                    </form>
                @endif\
            </div>
        </div>
    </flux:modal>

    <flux:modal title="Offerte bewerken" wire:close="closeEditModal" wire:model="showEditModal">
        @if ($selectedContract)
            <form action="{{ route('contracts.update', $selectedContract->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Header Section -->
                <div class="border-b border-zinc-200 dark:border-zinc-700 pb-4">
                    <flux:heading level="2" class="text-zinc-900 dark:text-zinc-100">
                        {{ $selectedContract->customer->name }}
                    </flux:heading>
                    <flux:text class="text-zinc-600 dark:text-zinc-400 mt-1">
                        Offerte #{{ $selectedContract->id }}
                    </flux:text>
                    <flux:text class="text-sm text-zinc-500 dark:text-zinc-500 mt-2">
                        Pas de vervaldatum en status van deze offerte aan.
                    </flux:text>
                </div>

                <!-- Form Fields -->
                <div class="space-y-5">
                    <!-- Start Date Field -->
                    <div>
                        <flux:fieldset>
                            <flux:label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">
                                Geldig tot
                            </flux:label>
                            <flux:input name="valid_until" type="date"
                                value="{{ $selectedContract->start_date }}" required class="w-full" />
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5">
                                Bepaal wanneer deze contract begint.
                            </flux:text>
                        </flux:fieldset>
                    </div>

                    <!-- End Date Field -->
                    <div>
                        <flux:fieldset>
                            <flux:label class="block text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">
                                Geldig tot
                            </flux:label>
                            <flux:input name="valid_until" type="date" value="{{ $selectedContract->end_date }}"
                                required class="w-full" />
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5">
                                Bepaal tot wanneer deze contract actief is.
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
                                    {{ $selectedContract && $selectedContract->status === 'pending' ? 'selected' : '' }}>
                                    In behandeling
                                </option>
                                <option value="sent"
                                    {{ $selectedContract && $selectedContract->status === 'active' ? 'selected' : '' }}>
                                    Actief
                                </option>
                                <option value="approved"
                                    {{ $selectedContract && $selectedContract->status === 'expired' ? 'selected' : '' }}>
                                    Verlopen
                                </option>
                                <option value="rejected"
                                    {{ $selectedContract && $selectedContract->status === 'terminated' ? 'selected' : '' }}>
                                    Inactief
                                </option>
                            </flux:select>
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5">
                                Wijzig de huidige status van het contract.
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
