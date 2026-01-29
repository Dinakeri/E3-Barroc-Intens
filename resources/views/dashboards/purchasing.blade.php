<x-layouts.dashboard>
    @section('title', 'Inkoop Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Inkoop Dashboard</h1>
        <p>Welkom op het Inkoop Dashboard. Hier vindt u een overzicht van inkoop en voorraadbeheer.</p>
    </div>

    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="{{ route('dashboards.purchasing') }}" class="mb-4" icon="home">Startpagina</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="shopping-cart">Bestellingen</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="cube">Voorraad</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="users">Leveranciers</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="chart-bar">Rapporten</flux:navlist.item>

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
        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Openstaande bestellingen:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">45</flux:subheading>
            <flux:text icon="arrow-trending-up" color="green" class="text-sm font-bold">12% gestegen</flux:text>
        </div>

        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Voorraadwaarde:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">€125,000</flux:subheading>
            <flux:text icon="arrow-trending-up" color="green" class="text-sm font-bold">5% gestegen</flux:text>
        </div>

        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Leveranciers:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">23</flux:subheading>
            <flux:text icon="arrow-trending-down" color="red" class="text-sm font-bold">2 nieuwe deze maand</flux:text>
        </div>
    </div>
</x-layouts.dashboard>
