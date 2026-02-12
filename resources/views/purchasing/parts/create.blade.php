<x-layouts.dashboard>
    @section('title', 'Nieuw Onderdeel')

    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">Nieuw Onderdeel Toevoegen</h1>
        <p class="text-gray-400">Voeg een nieuw onderdeel toe aan de voorraad</p>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <form action="{{ route('parts.store') }}" method="POST">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <flux:field variant="block">
                    <flux:label>Naam *</flux:label>
                    <flux:input name="name" value="{{ old('name') }}" placeholder="Bijv. Pompfilter" required />
                    <flux:error name="name" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>SKU *</flux:label>
                    <flux:input name="sku" value="{{ old('sku') }}" placeholder="Bijv. PART-001" required />
                    <flux:error name="sku" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>Inkoopprijs (€) *</flux:label>
                    <flux:input type="number" step="0.01" min="0" name="cost_price" value="{{ old('cost_price') }}" required />
                    <flux:error name="cost_price" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>Voorraad *</flux:label>
                    <flux:input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" required />
                    <flux:error name="stock" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>Minimale Voorraad *</flux:label>
                    <flux:input type="number" min="0" name="min_stock" value="{{ old('min_stock', 5) }}" required />
                    <flux:error name="min_stock" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>Status *</flux:label>
                    <flux:select name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actief</option>
                        <option value="phased_out" {{ old('status') == 'phased_out' ? 'selected' : '' }}>Uitgefaseerd</option>
                        <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Niet op voorraad</option>
                    </flux:select>
                    <flux:error name="status" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>Locatie</flux:label>
                    <flux:input name="location" value="{{ old('location') }}" placeholder="Bijv. Magazijn A" />
                    <flux:error name="location" />
                </flux:field>
            </div>

            <flux:field variant="block" class="mt-6">
                <flux:label>Beschrijving *</flux:label>
                <flux:textarea name="description" rows="4" placeholder="Voer een omschrijving in..." required>{{ old('description') }}</flux:textarea>
                <flux:error name="description" />
            </flux:field>

            <div class="flex gap-3 mt-6">
                <flux:button type="submit" variant="primary">
                    Onderdeel Opslaan
                </flux:button>
                <flux:button href="{{ route('parts.index') }}" variant="ghost">
                    Annuleren
                </flux:button>
            </div>
        </form>
    </div>

    @section('sidebar')
        <x-purchasing-sidebar current="parts" />
    @endsection
</x-layouts.dashboard>
