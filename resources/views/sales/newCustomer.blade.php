<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Add New Customer</h1>
        {{-- <p>Welcome to the Sales Dashboard. Here you can find an overview of sales metrics and performance.</p> --}}
    </div>


    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="#" class="mb-4" icon="home">Home</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="building-storefront">Orders</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="currency-dollar">Products</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="user">Customers</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="chart-bar">Reports</flux:navlist.item>
            <flux:navlist.item href="{{ route('sales.newCustomer') }}" class="mb-4" icon="plus">Add new customer
            </flux:navlist.item>

            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="#" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout
            </flux:navlist.item>

        </flux:navlist>
    @endsection


    <div class="min-h-screen p-6">
        <form action="route('customers.store')" method="POST">
            @csrf

            <flux:field variant="block" class="mb-4">
                <flux:label for="name">Company name</flux:label>
                <flux:input id="name" name="name" type="text" placeholder="John Doe" required
                    class="w-full" />
                <flux:error name="name" />
            </flux:field>

            <flux:field variant="block" class="mb-4">
                <flux:label for="email"> Company email address</flux:label>
                <flux:input id="email" name="email" type="email" placeholder="example@email.com" required
                    class="w-full" />
                <flux:error name="email" />
            </flux:field>

            <flux:field variant="block" class="mb-4">
                <flux:label for="phone">Company phone number</flux:label>
                <flux:input id="phone" name="phone" type="tel" placeholder="+31 6 123 45678" class="w-full" />
                <flux:error name="phone" />
            </flux:field>

            <flux:field variant="block" class="mb-6">
                <flux:label for="address">Commpany address</flux:label>
                <flux:input id="address" name="address" type="text" placeholder="Street name, City"
                    class="w-full" />
                <flux:error name="address" />
            </flux:field>

            <flux:field variant="block" class="mb-6">
                <flux:label for="kvk-nummer">Company kvk-nummer</flux:label>
                <flux:input id="kvk-nummer" name="kvk-nummer" type="number" placeholder="123456" class="w-full" />
                <flux:error name="kvk-nummer" />
                </flux::field>

                <flux:button type="submit" variant="primary" class="w-full">
                    Add Customer
                </flux:button>
        </form>
    </div>

</x-layouts.dashboard>
