<x-layouts.dashboard>
    @section('title', 'Nieuwe Bestelling')

    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">Nieuwe Bestelling</h1>
        <p class="text-gray-400">Bestel bestaande onderdelen of machines en voeg toe aan voorraad</p>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <flux:field variant="block">
                    <flux:label>Type *</flux:label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="item_type" value="product" {{ old('item_type', 'product') === 'product' ? 'checked' : '' }}>
                            Machines
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="item_type" value="part" {{ old('item_type') === 'part' ? 'checked' : '' }}>
                            Onderdelen
                        </label>
                    </div>
                    <flux:error name="item_type" />
                </flux:field>

                <flux:field variant="block" id="productField">
                    <flux:label>Machine *</flux:label>
                    <flux:select name="product_id">
                        <option value="">Selecteer machine</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-cost="{{ $product->cost_price }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Inkoop € {{ number_format($product->cost_price, 2, ',', '.') }})
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="product_id" />
                </flux:field>

                <flux:field variant="block" id="partField">
                    <flux:label>Onderdeel *</flux:label>
                    <flux:select name="part_id">
                        <option value="">Selecteer onderdeel</option>
                        @foreach($parts as $part)
                            <option value="{{ $part->id }}" data-cost="{{ $part->cost_price }}" {{ old('part_id') == $part->id ? 'selected' : '' }}>
                                {{ $part->name }} ({{ $part->sku }})
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="part_id" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>Aantal *</flux:label>
                    <flux:input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" required />
                    <flux:error name="quantity" />
                </flux:field>

                <flux:field variant="block">
                    <flux:label>Inkoopprijs per stuk (€)</flux:label>
                    <flux:input id="unitCost" type="text" value="" readonly />
                </flux:field>
            </div>

            <flux:field variant="block" class="mt-6">
                <flux:label>Notities</flux:label>
                <flux:textarea name="notes" rows="3" placeholder="Optioneel">{{ old('notes') }}</flux:textarea>
                <flux:error name="notes" />
            </flux:field>

            <div class="flex gap-3 mt-6">
                <flux:button type="submit" variant="primary">
                    Bestelling plaatsen
                </flux:button>
                <flux:button href="{{ route('purchases.index') }}" variant="ghost">
                    Annuleren
                </flux:button>
            </div>
        </form>
    </div>

    <script>
        const productField = document.getElementById('productField');
        const partField = document.getElementById('partField');
        const typeInputs = document.querySelectorAll('input[name="item_type"]');
        const unitCostInput = document.getElementById('unitCost');
        const productSelect = document.querySelector('select[name="product_id"]');
        const partSelect = document.querySelector('select[name="part_id"]');

        function formatCost(value) {
            if (value === null || value === undefined || value === '') return '';
            const number = Number(value);
            if (Number.isNaN(number)) return '';
            return `€ ${number.toFixed(2)}`.replace('.', ',');
        }

        function updateUnitCost() {
            const type = document.querySelector('input[name="item_type"]:checked')?.value || 'product';
            if (type === 'product') {
                const option = productSelect?.selectedOptions?.[0];
                unitCostInput.value = formatCost(option?.dataset?.cost ?? '');
            } else {
                const option = partSelect?.selectedOptions?.[0];
                unitCostInput.value = formatCost(option?.dataset?.cost ?? '');
            }
        }

        function toggleFields() {
            const type = document.querySelector('input[name="item_type"]:checked')?.value || 'product';
            if (type === 'product') {
                productField.style.display = 'block';
                partField.style.display = 'none';
            } else {
                productField.style.display = 'none';
                partField.style.display = 'block';
            }
            updateUnitCost();
        }

        typeInputs.forEach((input) => input.addEventListener('change', toggleFields));
        productSelect?.addEventListener('change', updateUnitCost);
        partSelect?.addEventListener('change', updateUnitCost);
        toggleFields();
    </script>

    @section('sidebar')
        <x-purchasing-sidebar current="purchases" />
    @endsection
</x-layouts.dashboard>
