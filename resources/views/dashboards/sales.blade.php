<x-layouts.dashboard>
    @section('title', 'Verkoopsdashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Verkoopsdashboard</h1>
        <p>Welkom op het Verkoopsdashboard. Hier vindt u een overzicht van verkoopsgegevens en prestaties.</p>
    </div>


    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="{{ route('dashboards.sales') }}" class="mb-4" icon="home">Startpagina</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="building-storefront">Bestellingen</flux:navlist.item>
            <flux:navlist.item href="{{ url('sales/products') }}" class="mb-4" icon="currency-dollar">Producten</flux:navlist.item>
            <flux:navlist.item href="{{ route('customers.index') }}" class="mb-4" icon="user">Klanten
            </flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="chart-bar">Rapporten</flux:navlist.item>
            <flux:navlist.item href="{{ route('customers.create') }}" class="mb-4" icon="plus">Nieuwe klant toevoegen
            </flux:navlist.item>

            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            
            <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="home">Dashboard</flux:navlist.item>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:navlist.item as="button" type="submit" class="mb-4 mt-auto w-full text-left" icon="arrow-left-end-on-rectangle">
                    Afmelden
                </flux:navlist.item>
            </form>

        </flux:navlist>
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
