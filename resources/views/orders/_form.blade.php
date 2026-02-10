<div class="mt-10">
    <div class=" mb-16">
        <flux:heading size="xl">Maak nieuwe bestelling aan</flux:heading>
        <flux:text class="mt-2">Vul het onderstaande formulier in om een nieuwe bestelling aan te maken.</flux:text>
    </div>

    <div class="border rounded-lg border-zinc-900 dark:border-zinc-400">
        <div class="border-b bg-zinc-300 dark:bg-zinc-900 p-6 rounded-t-lg">
            <flux:heading size="lg" class="uppercase ">Nieuwe bestelling</flux:heading>
        </div>


        <form action="{{ route('orders.store') }}" method="POST" x-data="orderForm(@js($products))" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 ">
                <div x-data="{
                    open: false,
                    search: '',
                    selected: null,
                    customers: @js($customers)
                }" class="relative w-full">
                    <!-- Label -->
                    <flux:label>Klant</flux:label>

                    <!-- Button (acts like select) -->
                    <flux:button type="button" @click="open = !open" x-cloak
                        class="w-full flex justify-start rounded-md border px-3 py-2 bg-zinc-700 text-white">
                        <div class="w-full flex justify-between">
                            <span
                                x-text="selected ? selected.name + ' (' + selected.email + ')' : 'Kies een klant'"></span>
                            <flux:icon.chevron-down class="size-4" />
                        </div>

                    </flux:button>

                    <!-- Hidden input for form submit -->
                    <input type="hidden" name="customer_id" :value="selected?.id">

                    <!-- Dropdown -->
                    <div x-show="open" @click.outside="open = false" x-transition x-cloak
                        class="absolute z-50 mt-2 w-full rounded-md border bg-zinc-700 p-2">
                        <!-- Search -->
                        <flux:input x-model="search" placeholder="Zoek klant..." class="mb-2" />

                        <!-- Results -->
                        <div class="max-h-48 overflow-y-auto">
                            <template
                                x-for="customer in customers.filter(c =>
                            c.name.toLowerCase().includes(search.toLowerCase()) ||
                            c.email.toLowerCase().includes(search.toLowerCase()))"
                                :key="customer.id">
                                <div @click="selected = customer; open = false"
                                    class="cursor-pointer px-3 py-2 hover:bg-zinc-600 rounded">
                                    <div class="font-medium" x-text="customer.name"></div>
                                    <div class="text-sm text-zinc-400" x-text="customer.email"></div>
                                </div>
                            </template>

                            <!-- Empty state -->
                            <div x-show="customers.filter(c =>
                            c.name.toLowerCase().includes(search.toLowerCase()) ||
                            c.email.toLowerCase().includes(search.toLowerCase())).length === 0"
                                class="px-3 py-2 text-zinc-400 text-sm">
                                Geen klanten gevonden
                            </div>
                        </div>
                    </div>
                </div>


                <flux:fieldset>
                    <flux:label>Besteldatum</flux:label>
                    <flux:input type="date" name="order_date" value="{{ old('order_date', now()->format('Y-m-d')) }}" required />
                </flux:fieldset>

                <flux:fieldset>
                    <flux:label>Status</flux:label>
                    <flux:select name="status" required>
                        <option value="pending">In behandeling</option>
                        <option value="completed">Voltooid</option>
                        <option value="cancelled">Geannuleerd</option>
                    </flux:select>
                </flux:fieldset>
            </div>


            {{-- Products --}}
            <div class="mt-10">
                <div class="border rounded-lg border-zinc-200 dark:border-zinc-700">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left px-4 py-3">Product</th>
                                <th class="text-left px-4 py-3">Aantal</th>
                                <th class="text-left px-4 py-3">Prijs</th>
                                <th class="text-left px-4 py-3">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-6">
                                    <flux:select x-model="selectedProductId">
                                        <option value="">Kies product</option>
                                        <template x-for="product in products" :key="product.id">
                                            <option :value="product.id" x-text="product.name"></option>
                                        </template>
                                    </flux:select>
                                </td>
                                <td class="px-4 py-6">
                                    <flux:input type="number" min="1" x-model.number="quantity" />
                                </td>
                                <td class="px-4 py-6">
                                    <flux:input type="text" disabled
                                        x-bind:value="selectedProduct ? '€ ' + selectedProduct.sales_price : ''" />
                                </td>
                                <td class="px-4 py-6">
                                    <flux:button type="button" @click="addItem">
                                        Toevoegen
                                    </flux:button>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>


                {{-- Notes --}}
                <flux:fieldset class="mt-10">
                    <flux:label>Interne notitie (optioneel)</flux:label>
                    <flux:textarea name="notes" rows="3"
                        placeholder="Extra informatie over deze bestelling..." />
                </flux:fieldset>

            </div>

            {{-- Added products --}}
            <div class="mt-8">
                <flux:heading size="md">Toegevoegde producten</flux:heading>

                <template x-if="items.length === 0">
                    <p class="text-sm text-zinc-500 mt-2">
                        Nog geen producten toegevoegd
                    </p>
                </template>

                <div class="mt-4 space-y-3">
                    <template x-for="(item, index) in items" :key="item.product_id">
                        <div class="flex items-center justify-between border rounded-lg p-3">
                            <div>
                                <div class="font-medium" x-text="item.name"></div>
                                <div class="text-sm text-zinc-500">
                                    € <span x-text="item.price"></span> ×
                                    <input type="number" min="1" x-model.number="item.quantity"
                                        class="w-16 border rounded px-2">
                                </div>
                            </div>

                            <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id">
                            <input type="hidden" :name="`items[${index}][quantity]`" :value="item.quantity">
                            <input type="hidden" :name="`items[${index}][price]`" :value="item.price">

                            <flux:button variant="ghost" @click="removeItem(index)">
                                Verwijderen
                            </flux:button>
                        </div>
                    </template>
                </div>

                {{-- Total --}}
                <div class="text-right mt-4 font-bold">
                    Totaal: €<span x-text="total.toFixed(2)"></span>
                    <input type="hidden" name="total_amount" :value="total.toFixed(2)">
                </div>
            </div>



            {{-- Actions --}}
            <div class="flex justify-end gap-3 border-t border-zinc-200 dark:border-zinc-700 pt-6">
                <flux:button variant="ghost" href="{{ route('orders.index') }}">
                    Annuleren
                </flux:button>

                <flux:button variant="primary" type="submit">
                    Bestelling opslaan
                </flux:button>
            </div>

            @if ($errors->any)
                <div class="mt-4 p-4 bg-red-100 text-red-700 rounded">
                    <strong>Whoops! There were some problems with your input:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif

        </form>

    </div>
</div>

<script>
    function orderForm(products) {
        return {
            // 🧠 STATE
            products: products,
            selectedProductId: '',
            quantity: 1,
            items: [],

            // 🔍 Find selected product
            get selectedProduct() {
                return this.products.find(p => p.id == this.selectedProductId)
            },

            // ➕ Add product
            addItem() {
                if (!this.selectedProduct || this.quantity < 1) return

                let existing = this.items.find(
                    item => item.product_id === this.selectedProduct.id
                )

                if (existing) {
                    existing.quantity += this.quantity
                } else {
                    this.items.push({
                        product_id: this.selectedProduct.id,
                        name: this.selectedProduct.name,
                        price: this.selectedProduct.sales_price,
                        quantity: this.quantity
                    })
                }

                // reset input
                this.quantity = 1
                this.selectedProductId = ''
            },

            // ❌ Remove product
            removeItem(index) {
                this.items.splice(index, 1)
            },

            // 💰 Total calculation
            get total() {
                return this.items.reduce(
                    (sum, item) => sum + (item.price * item.quantity),
                    0
                )
            }
        }
    }
</script>
