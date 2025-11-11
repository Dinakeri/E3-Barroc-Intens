<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Sales Dashboard</h1>
        <p>Welcome to the Sales Dashboard. Here you can find an overview of sales metrics and performance.</p>
    </div>


    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="#" class="mb-4" icon="home">Home</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="building-storefront">Orders</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="currency-dollar">Products</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="user">Customers</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="chart-bar">Reports</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="cog">Settings</flux:navlist.item>
            <flux:navlist.item href="{{ route('sales.newCustomer') }}" class="mb-4" icon="plus">Add new customer</flux:navlist.item>

            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="#" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout</flux:navlist.item>

        </flux:navlist>
        {{-- <a href="#"
            class="flex items-center px-4 py-2 mb-4 text-gray-300 hover:rounded-xl hover:bg-neutral-700 hover:text-white text-sm"><i
                class="fa-solid fa-house mr-2"></i>
            <span>Dashboard</span></a>
        <a href="#"
            class="flex items-center px-4 py-2 mb-4 text-gray-300 hover:rounded-xl hover:bg-neutral-700 hover:text-white text-sm">Orders</a>
        <a href="#"
            class="flex items-center px-4 py-2 mb-4 text-gray-300 hover:rounded-xl hover:bg-neutral-700 hover:text-white text-sm">Products</a>
        <a href="#"
            class="flex items-center px-4 py-2 mb-4 text-gray-300 hover:rounded-xl hover:bg-neutral-700 hover:text-white text-sm">Customers</a>
        <a href="#"
            class="flex items-center px-4 py-2 mb-4 text-gray-300 hover:rounded-xl hover:bg-neutral-700 hover:text-white text-sm">Reports</a>
        <a href="#"
            class="flex items-center px-4 py-2 mb-4 text-gray-300 hover:rounded-xl hover:bg-neutral-700 hover:text-white text-sm">Settings</a> --}}
    @endsection
</x-layouts.dashboard>
