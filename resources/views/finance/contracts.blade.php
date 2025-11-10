<x-layouts.dashboard title="Contracten">
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
