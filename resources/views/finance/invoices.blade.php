<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Financien Dashboard</h1>
        <p>Welcome bij het Financien Dashboard. hier kan je een overzicht vinden van de financiële statistieken en prestaties.</p>
    </div>

    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="#" class="mb-4" icon="home">Home</flux:navlist.item>
            <flux:navlist.item href="{{ route('dashboards.contracts') }}" class="mb-4" icon="building-storefront">Contracten</flux:navlist.item>
            <flux:navlist.item href="{{ route('dashboards.invoices') }}" class="mb-4" icon="building-storefront">Facturen</flux:navlist.item>
            <flux:navlist.item href="" class="mb-4" icon="building-storefront">Betalingen</flux:navlist.item>
            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="#" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout</flux:navlist.item>

        </flux:navlist>
    @endsection

</x-layouts.dashboard>
