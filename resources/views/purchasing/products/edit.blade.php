<x-layouts.dashboard>
    @section('title', 'Product Bewerken')
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">Product Bewerken</h1>
        <p class="text-gray-400">Wijzig de productinformatie</p>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <!-- Name -->
                <flux:field variant="block">
                    <flux:label>Productnaam *</flux:label>
                    <flux:input 
                        name="name" 
                        value="{{ old('name', $product->name) }}" 
                        placeholder="Bijv. Italian Light"
                        required 
                    />
                    <flux:error name="name" />
                </flux:field>

                <!-- Type -->
                <flux:field variant="block">
                    <flux:label>Type *</flux:label>
                    <flux:input 
                        name="type" 
                        value="{{ old('type', $product->type) }}" 
                        placeholder="Bijv. Koffiemachine"
                        required 
                    />
                    <flux:error name="type" />
                </flux:field>

                <!-- Cost Price -->
                <flux:field variant="block">
                    <flux:label>Inkoopprijs (€) *</flux:label>
                    <flux:input 
                        type="number" 
                        step="0.01" 
                        min="0"
                        name="cost_price" 
                        value="{{ old('cost_price', $product->cost_price) }}" 
                        placeholder="0.00"
                        required 
                    />
                    <flux:error name="cost_price" />
                </flux:field>

                <!-- Sales Price -->
                <flux:field variant="block">
                    <flux:label>Verkoopprijs (€) *</flux:label>
                    <flux:input 
                        type="number" 
                        step="0.01" 
                        min="0"
                        name="sales_price" 
                        value="{{ old('sales_price', $product->sales_price) }}" 
                        placeholder="0.00"
                        required 
                    />
                    <flux:error name="sales_price" />
                </flux:field>

                <!-- Stock -->
                <flux:field variant="block">
                    <flux:label>Voorraad *</flux:label>
                    <flux:input 
                        type="number" 
                        min="0"
                        name="stock" 
                        value="{{ old('stock', $product->stock) }}" 
                        required 
                    />
                    <flux:error name="stock" />
                </flux:field>

                <!-- Min Stock -->
                <flux:field variant="block">
                    <flux:label>Minimale Voorraad *</flux:label>
                    <flux:input 
                        type="number" 
                        min="0"
                        name="min_stock" 
                        value="{{ old('min_stock', $product->min_stock) }}" 
                        required 
                    />
                    <flux:error name="min_stock" />
                </flux:field>

                <!-- Status -->
                <flux:field variant="block">
                    <flux:label>Status *</flux:label>
                    <flux:select name="status" required>
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Actief</option>
                        <option value="phased_out" {{ old('status', $product->status) == 'phased_out' ? 'selected' : '' }}>Uitgefaseerd</option>
                        <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Niet op voorraad</option>
                    </flux:select>
                    <flux:error name="status" />
                </flux:field>

                <!-- Length -->
                <flux:field variant="block">
                    <flux:label>Lengte (cm) *</flux:label>
                    <flux:input 
                        type="number" 
                        min="0"
                        name="length" 
                        value="{{ old('length', $product->length) }}" 
                        placeholder="0"
                        required 
                    />
                    <flux:error name="length" />
                </flux:field>

                <!-- Width -->
                <flux:field variant="block">
                    <flux:label>Breedte (cm) *</flux:label>
                    <flux:input 
                        type="number" 
                        min="0"
                        name="width" 
                        value="{{ old('width', $product->width) }}" 
                        placeholder="0"
                        required 
                    />
                    <flux:error name="width" />
                </flux:field>

                <!-- Breadth/Depth -->
                <flux:field variant="block">
                    <flux:label>Diepte (cm) *</flux:label>
                    <flux:input 
                        type="number" 
                        min="0"
                        name="breadth" 
                        value="{{ old('breadth', $product->breadth) }}" 
                        placeholder="0"
                        required 
                    />
                    <flux:error name="breadth" />
                </flux:field>

                <!-- Weight -->
                <flux:field variant="block">
                    <flux:label>Gewicht (kg) *</flux:label>
                    <flux:input 
                        type="number" 
                        step="0.01" 
                        min="0"
                        name="weight" 
                        value="{{ old('weight', $product->weight) }}" 
                        placeholder="0.00"
                        required 
                    />
                    <flux:error name="weight" />
                </flux:field>
            </div>

            <!-- Description (full width) -->
            <flux:field variant="block" class="mt-6">
                <flux:label>Beschrijving *</flux:label>
                <flux:textarea 
                    name="description" 
                    rows="4"
                    placeholder="Voer een productbeschrijving in..."
                    required
                >{{ old('description', $product->description) }}</flux:textarea>
                <flux:error name="description" />
            </flux:field>

            <!-- Action Buttons -->
            <div class="flex gap-3 mt-6">
                <flux:button type="submit" variant="primary">
                    Wijzigingen Opslaan
                </flux:button>
                <flux:button href="{{ route('products.index') }}" variant="ghost">
                    Annuleren
                </flux:button>
            </div>
        </form>
    </div>

    @section('sidebar')
        <x-purchasing-sidebar current="products" />
    @endsection
</x-layouts.dashboard>