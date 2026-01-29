<div>
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>Klanten</flux:heading>
                <flux:subheading>Beheer en filter uw klantendatabase</flux:subheading>
            </div>
        </div>

        <!-- Filters -->
        <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="Zoeken op naam, e-mailadres of adres..." icon="magnifying-glass" />
                </div>

                <flux:select wire:model.live="status" placeholder="Status">
                    <option value="">Alle</option>
                    <option value="new">Nieuw</option>
                    <option value="active">Actief</option>
                    <option value="pending">In behandeling</option>
                    <option value="inactive">Inactief</option>
                </flux:select>

                <div class="ml-auto">
                    <flux:button variant="primary" color="blue" icon:trailing="plus"
                        href="{{ route('customers.create') }}">Voeg nieuwe klant toe</flux:button>
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
                            <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Naam
                            </th>

                            <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Email
                            </th>

                            <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Status
                            </th>

                            <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Offertes
                            </th>

                            <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Notities
                            </th>

                            <th class="px-4 py-5 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Acties
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($customers as $customer)
                            <tr onclick="window.location='{{ route('customers.show', $customer) }}'"
                                class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">

                                <td class="px-4 py-5">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $customer->name }}
                                    </div>
                                </td>

                                <td class="px-4 py-5">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">{{ $customer->email }}
                                    </div>
                                </td>

                                <td class="px-4 py-5">
                                    @if ($customer->status === 'new')
                                        <flux:badge color="blue" icon="sparkles">
                                            {{ ucfirst($customer->status) }}
                                        </flux:badge>
                                    @elseif ($customer->status === 'active')
                                        <flux:badge color="green" icon="check-circle">
                                            {{ ucfirst($customer->status) }}
                                        </flux:badge>
                                    @elseif ($customer->status === 'pending')
                                        <flux:badge color="zinc" icon="clock">
                                            {{ ucfirst($customer->status) }}
                                        </flux:badge>
                                    @elseif ($customer->status === 'inactive')
                                        <flux:badge color="red" icon="x-circle">
                                            {{ ucfirst($customer->status) }}
                                        </flux:badge>
                                    @endif
                                </td>

                                <td class="px-4 py-5">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">

                                        {{-- BKR NOT DONE --}}
                                        @if (!$customer->bkr_status)
                                            <span class="text-zinc-200">BKR check nog niet uitgevoerd!</span>

                                            {{-- BKR REGISTERED (BLOCKED) --}}
                                        @elseif ($customer->bkr_status === 'registered')
                                            <span class="text-red-600">
                                                Klant is geregistreerd in BKR en heeft geen contract mogelijkheid!
                                            </span>

                                            {{-- BKR CLEARED --}}
                                        @elseif ($customer->bkr_status === 'cleared')
                                            {{-- Accepted quote --}}
                                            @if ($customer->acceptedQuote?->url)
                                                <flux:button href="{{ Storage::url($customer->acceptedQuote->url) }}"
                                                    variant="ghost" target="_blank" icon:trailing="arrow-up-right"
                                                    onclick="event.stopPropagation();">
                                                    Open geaccepteerde offerte
                                                </flux:button>

                                                {{-- Other quotes exist --}}
                                            @elseif ($customer->quotes->isNotEmpty())
                                                @php
                                                    $latestQuote = $customer->quotes->sortByDesc('created_at')->first();
                                                @endphp

                                                <flux:button href="{{ Storage::url($latestQuote->url) }}"
                                                    variant="ghost" target="_blank" icon:trailing="arrow-up-right"
                                                    onclick="event.stopPropagation();">
                                                    Open laatste offerte
                                                </flux:button>

                                                {{-- No quotes → generate --}}
                                            @else
                                                <flux:button wire:click.stop="generateQuote({{ $customer->id }})"
                                                    variant="ghost" size="sm">
                                                    Offerte genereren
                                                </flux:button>
                                            @endif
                                        @endif

                                    </div>
                                </td>


                                <td class="px-4 py-5">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100 truncate max-w-[200px]">
                                        {{ $customer->notes }}</div>
                                </td>

                                <td class="px-4 py-5">
                                    <flux:button wire:click.stop="showCustomerDetails({{ $customer }})"
                                        variant="ghost" size="sm">
                                        Bekijk Details
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    Geen klanten gevonden.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>


    @if ($selectedCustomer)
        <flux:modal name="customer-details" wire:model="showModal" class="max-w-2xl">
            <div>
                <flux:heading size="lg">Details bedrijf</flux:heading>
                <flux:subheading>Bekijk volledige informatie over deze klant.</flux:subheading>
            </div>

            <div class="space-y-4 mt-6">
                <div class="grid gap-4 sm:grid-cols-2">

                    <div>
                        <flux:label>Naam</flux:label>
                        <div class="mt-1 text-sm font-medium">{{ $selectedCustomer->name }}</div>
                    </div>

                    <div>
                        <flux:label>Contactpersoon bedrijf</flux:label>
                        <div class="mt-1 text-sm font-medium">{{ $selectedCustomer->contact_person }}</div>
                    </div>

                    <div>
                        <flux:label>Email</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedCustomer->email }}</div>
                    </div>

                    <div>
                        <flux:label>Telefoonnummer</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedCustomer->phone ?? '-' }}</div>
                    </div>

                    <div>
                        <flux:label>Adres</flux:label>
                        <div class="mt-1 text-sm">
                            {{ trim(($selectedCustomer->street ?? '') . ' ' . ($selectedCustomer->house_number ?? '') . ', ' . ($selectedCustomer->place ?? '')) }}
                        </div>
                    </div>

                    <div>
                        <flux:label>BKR-status</flux:label>
                        <div class="mt-1">

                            <td class="px-4 py-5">
                                @if ($selectedCustomer->bkr_status === 'pending')
                                    <flux:badge color="zinc" icon="clock">
                                        {{ ucfirst($selectedCustomer->bkr_status) }}
                                    </flux:badge>
                                @elseif ($selectedCustomer->bkr_status === 'cleared')
                                    <flux:badge color="green" icon="check-circle">
                                        {{ ucfirst($selectedCustomer->bkr_status) }}
                                    </flux:badge>
                                @elseif ($selectedCustomer->status === 'registered')
                                    <flux:badge color="red" icon="x-circle">
                                        {{ ucfirst($selectedCustomer->bkr_status) }}
                                    </flux:badge>
                                @else
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">-</div>
                                @endif
                            </td>
                        </div>

                    </div>

                    <div>
                        <flux:label>KvK-nummer</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedCustomer->kvk_number ?? '-' }}</div>
                    </div>

                    <div>
                        <flux:label>Status</flux:label>
                        <div class="mt-1">

                            <td class="px-4 py-5">
                                @if ($selectedCustomer->status === 'new')
                                    <flux:badge color="blue" icon="sparkles">
                                        {{ ucfirst($selectedCustomer->status) }}
                                    </flux:badge>
                                @elseif ($selectedCustomer->status === 'active')
                                    <flux:badge color="green" icon="check-circle">
                                        {{ ucfirst($selectedCustomer->status) }}
                                    </flux:badge>
                                @elseif ($selectedCustomer->status === 'pending')
                                    <flux:badge color="zinc" icon="clock">
                                        {{ ucfirst($selectedCustomer->status) }}
                                    </flux:badge>
                                @elseif ($selectedCustomer->status === 'inactive')
                                    <flux:badge color="red" icon="x-circle">
                                        {{ ucfirst($selectedCustomer->status) }}
                                    </flux:badge>
                                @endif
                            </td>
                        </div>

                    </div>
                </div>


                @if ($selectedCustomer->notes)
                    <div>
                        <flux:label>Notities</flux:label>
                        <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $selectedCustomer->notes }}</div>
                    </div>
                @endif
            </div>

        </flux:modal>
    @endif
</div>
