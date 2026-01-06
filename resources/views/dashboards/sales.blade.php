<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Sales Dashboard</h1>
        <p>Welcome to the Sales Dashboard. Here you can find an overview of sales metrics and performance.</p>
    </div>


    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="border-2 rounded-lg p-2 my-6">
            <flux:heading>Sales Overview</flux:heading>
            <flux:subheading>Track your sales performance and metrics</flux:subheading>
        </div>

        <div class="border-2 rounded-lg p-2 my-6">
            <flux:heading>Sales Overview</flux:heading>
            <flux:subheading>Track your sales performance and metrics</flux:subheading>
        </div>

        <div class="border-2 rounded-lg p-2 my-6">
            <flux:heading>Sales Overview</flux:heading>
            <flux:subheading>Track your sales performance and metrics</flux:subheading>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="border-2 rounded-lg p-2">
            <h1 class="font-bold text-lg text-center p-2">Total Orders</h1>
            <canvas id="totalOrdersChart"></canvas>
        </div>
        <div class="border-2 rounded-lg p-2">
            <h1 class="font-bold text-lg text-center p-2">Total Customers</h1>
            <canvas id="totalCustomersChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Offertes:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">120</flux:subheading>
            <flux:text icon="arrow-trending-down" color="red" class="text-sm font-bold">
                230 offertes nog niet aangevraagd
            </flux:text>
        </div>

        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Lopende klanten:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">350</flux:subheading>
            <flux:text icon="arrow-trending-up" color="green" class="text-sm font-bold">3% gestegen</flux:text>
        </div>

        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">BKR-statussen:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">262,5</flux:subheading>
            <flux:text icon="arrow-trending-down" color="red" class="text-sm font-bold">75% al gecheckt</flux:text>
        </div>
    </div>
</x-layouts.dashboard>
