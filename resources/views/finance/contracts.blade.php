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

    <div class="contracts">
        <h2 class="text-2xl font-bold mb-4">Actieve Contracten</h2>

        @php
            $contracts = \App\Models\Contract::orderBy('created_at', 'desc')->get();
        @endphp

        @if ($contracts->isEmpty())
            <p class="text-sm text-gray-500">Geen contracten gevonden.</p>
        @else
            <ul class="space-y-3">
                @foreach ($contracts as $contract)
                    <li class="p-3 border rounded">
                        <div class="font-semibold">{{ $contract->customer }}</div>
                        <div class="text-sm text-gray-600">{{ $contract->products }}</div>
                        <div class="text-xs text-gray-500">{{ $contract->created_at->format('Y-m-d') }}</div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.dashboard>
