<x-layouts.dashboard title="Nieuwe factuur">
    <div class="mb-6">
        <label class="block font-medium mb-2">Kies klant</label>
        <select id="customer_select" class="w-full border rounded px-2 py-1">
            <option value="">-- Kies klant --</option>
            @foreach($customers as $c)
                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
            @endforeach
        </select>
    </div>

    @include('invoices._form')
</x-layouts.dashboard>
