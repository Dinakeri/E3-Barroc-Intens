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
            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="#" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout</flux:navlist.item>

        </flux:navlist>
    @endsection
    <div class="contracts">
        <h2 class="text-2xl font-bold mb-4">Actieve Contracten</h2>

        <div class="flex items-center gap-4 mb-4">
            <div class="text-4xl font-semibold" data-test="contracts-count">{{ \App\Models\Contract::count() }}</div>
        </div>
    </div>

</x-layouts.dashboard>
