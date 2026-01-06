<flux:navlist class="w-64">
    <flux:navlist.item href="{{ route('dashboards.sales') }}" class="mb-4" icon="home">Home</flux:navlist.item>
    <flux:navlist.item href="{{ route('orders.index') }}" class="mb-4" icon="building-storefront">Orders</flux:navlist.item>
    <flux:navlist.item href="{{ route('products') }}" class="mb-4" icon="currency-dollar">Products</flux:navlist.item>
    <flux:navlist.item href="{{ route('customers.index') }}" class="mb-4" icon="user">Customers
    </flux:navlist.item>
    <flux:navlist.item href="#" class="mb-4" icon="chart-bar">Reports</flux:navlist.item>
    <flux:navlist.item href="" class="mb-4" icon="cog">Settings</flux:navlist.item>
    <flux:navlist.item href="{{ route('customers.create') }}" class="mb-4" icon="plus">Add new customer
    </flux:navlist.item>

    <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
    <form action="{{ route('logout') }}" method="POST">
        <flux:navlist.item class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout</flux:navlist.item>
    </form>

</flux:navlist>
