<x-layouts.dashboard title="Financien Dashboard">
    @section('title', 'Financien Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Financien Dashboard</h1>
        <p>Welkom bij het Financien Dashboard. hier kan je een overzicht vinden van de financiële statistieken en
            prestaties.</p>
    </div>

    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="{{ route('dashboards.finance') }}" class="mb-4" icon="home">Home</flux:navlist.item>
            <flux:navlist.item href="{{ route('dashboards.contracts') }}" class="mb-4" icon="building-storefront">Contracten
            </flux:navlist.item>
            <flux:navlist.item href="{{ route('dashboards.invoices') }}" class="mb-4" icon="building-storefront">Facturen
            </flux:navlist.item>
            <flux:navlist.item href="" class="mb-4" icon="building-storefront">Betalingen</flux:navlist.item>
            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
        </flux:navlist>
    @endsection

    <div class="mt-6">
        <h2 class="text-2xl font-bold mb-4">Nieuwe factuur aanmaken</h2>

        <div class="mb-6">
            <label class="block font-medium mb-2">Kies klant</label>
            <select id="customer_select"
                class="w-full border rounded px-2 py-1 bg-neutral-900 text-white dark:bg-neutral-900 dark:text-white">
                <option value="" style="color: #9CA3AF;">-- Kies klant --</option>
                @isset($customers)
                    @foreach ($customers as $c)
                        <option value="{{ $c->id }}" style="color: #FFFFFF; background-color: #0f172a;">
                            {{ $c->name }} ({{ $c->email }})</option>
                    @endforeach
                @endisset
            </select>
        </div>

        @include('invoices._form')
    </div>
</x-layouts.dashboard>
