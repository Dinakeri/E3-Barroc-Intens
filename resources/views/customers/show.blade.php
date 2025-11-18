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
            <flux:navlist.item href="{{ route('customers.index') }}" class="mb-4" icon="user">Customers</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="chart-bar">Reports</flux:navlist.item>
            <flux:navlist.item href="" class="mb-4" icon="cog">Settings</flux:navlist.item>
            <flux:navlist.item href="{{ route('customers.create') }}" class="mb-4" icon="plus">Add new customer
            </flux:navlist.item>

            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="{{ route('logout') }}" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout
            </flux:navlist.item>

        </flux:navlist>
    @endsection

</x-layouts.dashboard>
