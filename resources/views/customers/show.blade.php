<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">{{ $customer->name }}</h1>
        {{-- <p>Welcome to the Sales Dashboard. Here you can find an overview of sales metrics and performance.</p> --}}
    </div>


    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="{{ route('dashboards.sales') }}" class="mb-4" icon="home">Home</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="building-storefront">Orders</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="currency-dollar">Products</flux:navlist.item>
            <flux:navlist.item href="{{ route('customers.index') }}" class="mb-4" icon="user">Customers
            </flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="chart-bar">Reports</flux:navlist.item>
            <flux:navlist.item href="" class="mb-4" icon="cog">Settings</flux:navlist.item>
            <flux:navlist.item href="{{ route('customers.create') }}" class="mb-4" icon="plus">Add new customer
            </flux:navlist.item>

            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="{{ route('logout') }}" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout
            </flux:navlist.item>

        </flux:navlist>
    @endsection

    <div class="grid gap-4 lg:grid-cols-2 sm:grid-cols-1 mb-8">
        <div class="mb-2">
            <flux:heading size="lg">Bedrijfsnaam</flux:heading>
            <flux:text size="lg">{{ $customer->name }}</flux:text>
        </div>

        <div class="mb-2">
            <flux:heading size="lg">Contact persoon</flux:heading>
            <flux:text size="lg">{{ $customer->contact_person }}</flux:text>
        </div>

        <div class="mb-2">
            <flux:heading size="lg">Email</flux:heading>
            <flux:text size="lg">{{ $customer->email }}</flux:text>
        </div>

        <div class="mb-2">
            <flux:heading size="lg">Telefoonnummer</flux:heading>
            <flux:text size="lg">{{ $customer->phone }}</flux:text>
        </div>

        <div class="mb-2">
            <flux:heading size="lg">Adres</flux:heading>
            <flux:text size="lg">
                {{ trim($customer->street . ' ' . $customer->house_number . ', ' . $customer->place) }}</flux:text>
        </div>

    </div>

    <div>
        <flux:heading size="lg" class="mb-2">Bestellingen</flux:heading>
        <div class="rounded-xl border border-zinc-200 p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">ID
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                Product</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                Hoeveelheid</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">Prijs
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-200">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @if ($customer->orders)
                            @forelse ($customer->orders as $order)
                                @foreach ($order->orderItems as $item)
                                    <tr
                                        class="hover:bg-zinc-400 dark:hover:bg-zinc-800 hover:cursor-pointer transition-colors">
                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">{{ $item->id }}</td>
                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                            {{ ucfirst($item->product->name) }}</td>
                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">{{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">
                                            €{{ number_format($item->price, 2) }}</td>
                                        <td class="px-4 py-3 text-zinc-900 dark:text-zinc-200">{{ $item->status }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-zinc-900 dark:text-zinc-200 text-center">
                                        Geen bestellingen gevonden.
                                    </td>
                                </tr>
                            @endforelse
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
