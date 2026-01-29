<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')

    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    <div class="mb-8 flex items-center justify-between">
        <div>
            <flux:heading size="xl">{{ $customer->name }}</flux:heading>
            <flux:text class="text-zinc-500">
                Customer overview & order history
            </flux:text>
        </div>

        <div class="flex items-center gap-6">
            <flux:button href="{{ route('customers.index') }}" variant="primary" color="zinc" icon="arrow-left">Terug
            </flux:button>
            <flux:button href="{{ route('customers.edit', $customer) }}" variant="primary" color="blue"
                icon="pencil-square">Bewerken</flux:button>
        </div>

    </div>

    {{-- Customer information --}}
    <div class="p-6 mb-10">
        <flux:heading size="lg" class="mb-4">Customer information</flux:heading>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <flux:text class="text-sm text-zinc-500">Company</flux:text>
                <flux:text class="font-medium">{{ $customer->name }}</flux:text>
            </div>

            <div>
                <flux:text class="text-sm text-zinc-500">Contact person</flux:text>
                <flux:text class="font-medium">{{ $customer->contact_person }}</flux:text>
            </div>

            <div>
                <flux:text class="text-sm text-zinc-500">Email</flux:text>
                <flux:text class="font-medium">{{ $customer->email }}</flux:text>
            </div>

            <div>
                <flux:text class="text-sm text-zinc-500">Phone</flux:text>
                <flux:text class="font-medium">{{ $customer->phone }}</flux:text>
            </div>

            <div class="sm:col-span-2">
                <flux:text class="text-sm text-zinc-500">Address</flux:text>
                <flux:text class="font-medium">
                    {{ trim($customer->street . ' ' . $customer->house_number . ', ' . $customer->place) }}
                </flux:text>
            </div>

            <div>
                <flux:text class="text-sm text-zinc-500">KVK Number</flux:text>
                <flux:text class="font-medium">{{ $customer->kvk_number }}</flux:text>
            </div>

            <div>
                <flux:text class="text-sm text-zinc-500">BKR Status</flux:text>
                <div class="mt-1">
                    @if ($customer->bkr_status === 'cleared')
                        <flux:badge variant="pill" color="green" icon="check-circle">Cleared</flux:badge>
                    @else
                        <flux:badge variant="pill" color="red" icon="x-circle">Registered</flux:badge>
                    @endif
                </div>
            </div>

            <div>
                <flux:text class="text-sm text-zinc-500">Status</flux:text>
                @if ($customer->status === 'active')
                    <flux:badge variant="pill" color="green" icon="check-circle" class="font-medium">Active
                    </flux:badge>
                @elseif ($customer->status === 'inactive')
                    <flux:badge variant="pill" color="red" icon="x-circle   " class="font-medium">Inactive
                    </flux:badge>
                @else
                    <flux:badge variant="pill" color="zinc" icon="clock" class="font-medium">New</flux:badge>
                @endif
            </div>

            <div class="space-y-4">
                <flux:heading size="sm" class="text-zinc-500 uppercase tracking-wide">
                    Quotes
                </flux:heading>

                @if ($customer->quotes->count() > 0)
                    @foreach ($customer->quotes as $quote)
                        <div
                            class="flex items-center justify-between rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4 shadow-sm">
                            <div class="space-y-1">
                                <flux:text class="font-medium">
                                    Quote #{{ $quote->id }}
                                </flux:text>

                                @switch($quote->status)
                                    @case('sent')
                                        <flux:badge variant="pill" color="blue" icon="clock">
                                            In progress
                                        </flux:badge>
                                    @break

                                    @case('approved')
                                        <flux:badge variant="pill" color="green" icon="check-circle">
                                            Completed
                                        </flux:badge>
                                    @break

                                    @case('rejected')
                                        <flux:badge variant="pill" color="red" icon="x-circle">
                                            Rejected
                                        </flux:badge>
                                    @break

                                    @default
                                        <flux:badge variant="pill">
                                            {{ ucfirst($quote->status) }}
                                        </flux:badge>
                                @endswitch
                            </div>

                            <flux:button href="{{ Storage::url($quote->url) }}" variant="ghost" target="_blank"
                                icon:trailing="arrow-up-right" onclick="event.stopPropagation();">
                                View
                            </flux:button>
                        </div>
                    @endforeach

                    {{-- No quotes --}}
                @else
                    <div
                        class="rounded-lg border border-dashed border-zinc-300 dark:border-zinc-700 p-4 text-sm text-zinc-500">
                        Er zijn geen offertes beschikbaar voor deze klant.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Customer orders --}}
    <div>
        <flux:heading size="lg" class="mb-4">Orders</flux:heading>

        <div>
            @forelse ($customer->orders as $order)
                <div class="mb-6 rounded-2xl border border-zinc-200 p-6 hover:cursor-pointer hover:bg-zinc-700 hover:bg-opacity-50 hover:text-white"
                    onclick="window.location='{{ route('orders.show', $order) }}'">

                    {{-- Order header --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                        <div>
                            <flux:text class="text-sm text-zinc-500">Order #{{ $order->id }}</flux:text>
                            <flux:text class="font-medium">
                                {{ $order->order_date }}
                            </flux:text>
                        </div>

                        <span>
                            @switch($order->status)
                                @case('pending')
                                    <flux:badge variant="pill" color="yellow" icon="clock">{{ ucfirst($order->status) }}
                                    </flux:badge>
                                @break

                                @case('completed')
                                    <flux:badge variant="pill" color="green" icon="check-circle">{{ ucfirst($order->status) }}
                                    </flux:badge>
                                @break

                                @case('cancelled')
                                    <flux:badge variant="pill" color="red" icon="x-circle">{{ ucfirst($order->status) }}
                                    </flux:badge>
                                @break

                                @default
                                    <flux:badge variant="pill">{{ ucfirst($order->status) }}</flux:badge>
                            @endswitch
                        </span>
                    </div>

                    {{-- Order items table --}}
                    <div class="o   verflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-zinc-200 text-left text-zinc-500">
                                    <th class="py-2">Product</th>
                                    <th class="py-2">Quantity</th>
                                    <th class="py-2">Price</th>
                                    <th class="py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td class="py-3 font-medium">
                                            {{ ucfirst($item->product->name) }}
                                        </td>
                                        <td class="py-3">{{ $item->quantity }}</td>
                                        <td class="py-3">
                                            €{{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="py-3 text-zinc-600">
                                            @switch($item->status)
                                                @case('pending')
                                                    <span class="text-yellow-500">{{ ucfirst($item->status) }}</span>
                                                @break

                                                @case('completed')
                                                    <span class="text-green-500">{{ ucfirst($item->status) }}</span>
                                                @break

                                                @case('cancelled')
                                                    <span class="text-red-500">{{ ucfirst($item->status) }}</span>
                                                @break

                                                @default
                                                    <span>{{ ucfirst($item->status) }}</span>
                                            @endswitch

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Order total --}}
                    <div class="flex justify-end mt-4">
                        <flux:text class="font-semibold">
                            Total: €{{ number_format($order->total_amount, 2) }}
                        </flux:text>
                    </div>
                </div>
                @empty
                    <div class="rounded-xl border border-dashed border-zinc-300 p-8 text-center text-zinc-500">
                        No orders found for this customer.
                    </div>
                @endforelse
            </div>
        </div>
    </x-layouts.dashboard>
