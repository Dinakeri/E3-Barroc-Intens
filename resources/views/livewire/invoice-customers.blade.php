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
                    <option value="">New</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
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

        {{-- Customers Table --}}
        <div class="rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                Naam
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
                        @forelse($customers as $customer)
                            <tr onclick="window.location='{{ route('customers.show', $customer->id) }}'"
                                class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">

                                <td class="px-4 py-3">
                                    <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $customer->name }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
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

                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100 truncate max-w-[200px]">
                                        @if ($customer->quote)
                                            @if ($customer->quote->url)
                                                <flux:button href="{{ $customer->quote->url }}" variant="ghost"
                                                    target="_blank" icon:trailing="arrow-up-right">
                                                    Open PDF
                                                </flux:button>
                                            @else
                                                <div class="text-zinc-900 dark:text-zinc-100">Geen offerte</div>
                                            @endif
                                        @else
                                            <flux:button wire:click.stop="generateQuote({{ $customer->id }})"
                                                variant="ghost" size="sm">
                                                Offerte genereren
                                            </flux:button>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <flux:button wire:click.stop="showCustomerDetails({{ $customer }})" variant="ghost"
                                        size="sm">
                                        maak factuur
                                    </flux:button>
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
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>


    @if ($selectedCustomer)
        <flux:modal name="customer-details" wire:model="showModal" class="max-w-2xl">
            <div>
                <flux:heading size="lg">Customer Details</flux:heading>
                <flux:subheading>View complete information about this customer</flux:subheading>
            </div>

            <div class="space-y-4 mt-6">
                <div class="grid gap-4 sm:grid-cols-2">


                    <div>
                        <flux:label>Name</flux:label>
                        <div class="mt-1 text-sm font-medium">{{ $selectedCustomer->name }}</div>
                    </div>

                    <div>
                        <flux:label>Email</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedCustomer->email }}</div>
                    </div>

                    <div>
                        <flux:label>Phone</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedCustomer->phone ?? '-' }}</div>
                    </div>

                    <div>
                        <flux:label>Address</flux:label>
                        <div class="mt-1 text-sm">
                            {{ trim(($selectedCustomer->street ?? '') . ' ' . ($selectedCustomer->house_number ?? '') . ', ' . ($selectedCustomer->place ?? '')) }}
                        </div>
                    </div>

                    <div>
                        <flux:label>KvK-nummer</flux:label>
                        <div class="mt-1 text-sm">{{ $selectedCustomer->kvk_number ?? '-' }}</div>
                    </div>

                    <div>
                        <flux:label>Status</flux:label>
                        <div class="mt-1">

                            <td class="px-4 py-3">
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
                        <flux:label>Notes</flux:label>
                        <div class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $selectedCustomer->notes }}</div>
                    </div>
                @endif
            </div>

        </flux:modal>
    @endif
</div>
