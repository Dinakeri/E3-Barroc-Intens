<x-layouts.dashboard title="Nieuwe factuur">
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection
    <div class="mb-6">
        <label class="block font-medium mb-2">Kies klant</label>
        <select id="customer_select" class="w-full border rounded px-2 py-1 bg-neutral-900 text-white dark:bg-neutral-900 dark:text-white">
            <option value="" style="color: #9CA3AF;">-- Kies klant --</option>
            @foreach($customers as $c)
                <option value="{{ $c->id }}" style="color: #FFFFFF; background-color: #0f172a;">{{ $c->name }} ({{ $c->email }})</option>
            @endforeach
        </select>
    </div>

    @include('invoices._form')
</x-layouts.dashboard>
