<div class="max-w-3xl">
    <h2 class="text-2xl font-bold mb-4">Nieuwe factuur aanmaken</h2>

    <form method="POST" action="{{ route('invoices.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Klant</label>
            <select name="customer_id" required class="w-full border rounded px-2 py-1">
                @foreach(
                    \App\Models\Customer::orderBy('name')->get() as $c
                )
                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-medium">Factuurdatum</label>
                <input type="date" name="invoice_date" value="{{ now()->toDateString() }}" required class="w-full border rounded px-2 py-1" />
            </div>
            <div>
                <label class="block font-medium">Vervaldatum</label>
                <input type="date" name="due_date" value="{{ now()->addDays(14)->toDateString() }}" required class="w-full border rounded px-2 py-1" />
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Items (JSON array)</label>
            <textarea name="items_json" rows="6" class="w-full border rounded px-2 py-1">[{"description":"Voorbeeld","qty":1,"price":100}]</textarea>
            <p class="text-sm text-gray-500">Voer items in als JSON array; het formulier parseert dit naar items.</p>
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Genereer PDF</button>
        </div>
    </form>
</div>
