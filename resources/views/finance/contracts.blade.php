<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <div class="contracts">
        <h2 class="text-2xl font-bold mb-4">Actieve Contracten</h2>

        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Klanten met offerte (PDF)</h3>
            @livewire('invoice-customers', ['onlyWithPdf' => true])
        </div>

        @php
            // Expect contracts and customers to be passed from the route. Fall back to simple queries
            $contracts = $contracts ?? \App\Models\Contract::orderBy('created_at', 'desc')->get();
            $customers = $customers ?? collect();
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

                        @php
                            $linkedCustomer = $customers->get($contract->customer) ?? null;
                        @endphp

                        @if ($linkedCustomer && $linkedCustomer->quote && $linkedCustomer->quote->url)
                            <div class="mt-2">
                                <a href="{{ $linkedCustomer->quote->url }}" target="_blank" class="text-blue-500 hover:underline">Bekijk offerte</a>
                            </div>
                        @else
                            <div class="mt-2 text-sm text-gray-500">Geen offerte beschikbaar</div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.dashboard>
