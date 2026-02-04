<div class="py-4 min-h-screen">
    <div class="mb-8">
        <flux:heading size="xl" class="mb-2 text-zinc-100">Nieuwe Offerte Aanmaken</flux:heading>
        <flux:subheading class="text-zinc-300">Selecteer een klant en controleer de voorwaarden voordat u verder gaat.
        </flux:subheading>
    </div>

    <div class="bg-zinc-800 rounded-lg shadow-sm border border-zinc-700 p-8">
        <form action="{{ route('quotes.store') }}" method="POST" class="space-y-8" x-data="quoteForm()">
            @csrf

            <!-- Customer Selection -->
            <div>
                <label class="block text-sm font-semibold text-zinc-100 mb-3">Selecteer Klant</label>
                <flux:button type="button" @click="open = !open" x-cloak
                    class="w-full flex justify-between items-center rounded-lg border border-zinc-700 px-4 py-3 bg-zinc-800 text-zinc-100 hover:bg-zinc-700 transition-colors">
                    <span x-text="selected ? selected.name + ' • ' + selected.email : 'Klik om een klant te kiezen'"
                        class="text-left font-medium"></span>
                    <flux:icon.chevron-down class="size-5 text-zinc-300 flex-shrink-0" />
                </flux:button>

                {{-- Dropdown --}}
                <div x-show="open" @click.outside="open = false" x-transition x-cloak
                    class="absolute z-50 mt-2 w-full max-w-md rounded-lg border border-zinc-700 bg-zinc-800 shadow-lg p-3">
                    <!-- Search -->
                    <flux:input x-model="search" placeholder="Zoeken op naam of e-mailadres..."
                        class="mb-3 border border-zinc-700 rounded-lg px-3 py-2 bg-zinc-700 text-zinc-100 placeholder-zinc-400" />

                    <!-- Results -->
                    <div class="max-h-64 overflow-y-auto">
                        <template x-for="customer in filteredCustomers" :key="customer.id">
                            <div @click="selected = customer; open = false"
                                class="cursor-pointer px-4 py-3 hover:bg-zinc-700 rounded-lg transition-colors border-b border-zinc-700 last:border-0">
                                <div class="font-medium text-zinc-100" x-text="customer.name"></div>
                                <div class="text-sm text-zinc-300" x-text="customer.email"></div>
                            </div>
                        </template>

                        <!-- Empty state -->
                        <div x-show="customers.filter(c =>
                                c.name.toLowerCase().includes(search.toLowerCase()) ||
                                c.email.toLowerCase().includes(search.toLowerCase())).length === 0"
                            class="px-4 py-8 text-center text-zinc-400 text-sm">
                            <flux:icon.magnifying-glass class="size-6 mx-auto mb-2 text-zinc-500" />
                            Geen klanten gevonden
                        </div>
                    </div>
                </div>

                <div x-show="selected" class="mt-4">
                    <label class="block text-sm font-semibold text-zinc-100 mb-2">Kies bestelling</label>

                    <template x-if="customerOrders.length">
                        <div class="space-y-2">
                            <template x-for="order in customerOrders" :key="order.id">
                                <label
                                    class="flex items-center gap-3 p-3 rounded-lg border border-zinc-700 hover:bg-zinc-700 cursor-pointer">
                                    <input type="radio" name="order_radio" :value="order.id"
                                        x-model="selectedOrderId"
                                        class="h-4 w-4 text-blue-500 bg-zinc-800 border-zinc-600" />
                                    <div>
                                        <div class="font-medium text-zinc-100" x-text="('Bestelling #' + order.id)">
                                        </div>
                                        <div class="text-sm text-zinc-300"
                                            x-text="(new Date(order.created_at)).toLocaleDateString() + ' — €' + (parseFloat(order.total_amount ?? order.total ?? 0).toFixed(2))">
                                        </div>
                                    </div>
                                </label>
                            </template>
                        </div>
                    </template>

                    <template x-if="!customerOrders.length">
                        <p class="text-sm text-zinc-400">Geen bestellingen beschikbaar voor deze klant.</p>
                    </template>

                    <input type="hidden" name="customer_id" :value="selected?.id">
                    <input type="hidden" name="order_id" :value="selectedOrderId">

                    <div
                        x-effect="if (selected && !selectedOrderId && customerOrders.length === 1) selectedOrderId = customerOrders[0].id">
                    </div>
                </div>
            </div>

            <div>
                <flux:fieldset>
                    <flux:label class="text-sm font-semibold text-zinc-100">Geldig tot</flux:label>
                    <flux:input name="valid_until" type="date" required />
                </flux:fieldset>
            </div>

            <!-- Status Messages -->
            <div class="space-y-3">
                {{-- No customer selected --}}
                <div x-show="!selected" class="flex items-start gap-3 p-4 rounded-lg bg-zinc-800 border border-zinc-700"
                    x-cloak>
                    <flux:icon.exclamation-circle class="size-5 text-zinc-300 flex-shrink-0 mt-0.5" />
                    <div>
                        <h4 class="font-semibold text-zinc-100 mb-1">Klant selecteren</h4>
                        <p class="text-sm text-zinc-300">Selecteer eerst een klant om verder te gaan.</p>
                    </div>
                </div>

                {{-- Customer selected but BKR not passed --}}
                <div x-show="selected && !hasPassedBkr"
                    class="flex items-start gap-3 p-4 rounded-lg bg-red-900 border border-red-700" x-cloak>
                    <flux:icon.exclamation-triangle class="size-5 text-red-300 flex-shrink-0 mt-0.5" />
                    <div>
                        <h4 class="font-semibold text-red-100 mb-1">BKR-controle vereist</h4>
                        <p class="text-sm text-red-200">Deze klant heeft de BKR-check nog niet succesvol afgerond.</p>
                    </div>
                </div>

                {{-- Customer selected and BKR passed but no orders --}}
                <div x-show="selected && hasPassedBkr && !hasOrders"
                    class="flex items-start gap-3 p-4 rounded-lg bg-amber-900 border border-amber-700" x-cloak>
                    <flux:icon.information-circle class="size-5 text-amber-200 flex-shrink-0 mt-0.5" />
                    <div>
                        <h4 class="font-semibold text-amber-100 mb-1">Geen bestellingen</h4>
                        <p class="text-sm text-amber-200">Deze klant heeft nog geen bestelling geplaatst.</p>
                    </div>
                </div>

                {{-- Customer selected, BKR passed, has orders but is not active customer --}}
                <div x-show="selected && hasPassedBkr && hasOrders && customerStatus !== 'active'"
                    class="flex items-start gap-3 p-4 rounded-lg bg-amber-900 border border-amber-700" x-cloak>
                    <flux:icon.information-circle class="size-5 text-amber-200 flex-shrink-0 mt-0.5" />
                    <div>
                        <h4 class="font-semibold text-amber-100 mb-1">Klant niet actief</h4>
                        <p class="text-sm text-amber-200">Deze klant is niet actief.</p>
                    </div>
                </div>

                {{-- Customer selected, BKR passed, customer status active and has orders --}}
                <div x-show="selected && hasPassedBkr && hasOrders && customerStatus === 'active'"
                    class="flex items-start gap-3 p-4 rounded-lg bg-green-900 border border-green-700" x-cloak>
                    <flux:icon.check-circle class="size-5 text-green-200 flex-shrink-0 mt-0.5" />
                    <div>
                        <h4 class="font-semibold text-green-100 mb-1">Klaar om te gaan</h4>
                        <p class="text-sm text-green-200">U kunt nu een offerte aanmaken voor deze klant.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-zinc-700 flex justify-end gap-3">
                <flux:button type="submit" variant="primary" color="blue" x-bind:disabled="!canSubmit"
                    class="px-6 py-3 font-medium rounded-lg transition-all bg-blue-600 hover:bg-blue-500 text-white w-1/3"
                    x-bind:class="!canSubmit ? 'opacity-50 cursor-not-allowed' : ''">
                    <flux:icon.document-text class="size-4 text-zinc-100" />
                    Offerte Aanmaken
                </flux:button>
            </div>
        </form>
    </div>
</div>
<script>
    function quoteForm() {
        return {
            open: false,
            search: '',
            selected: null,
            selectedOrderId: null,
            customers: @js($customers),


            // ✅ BKR check
            get hasPassedBkr() {
                return this.selected?.bkr_status === 'cleared'
            },

            get hasOrders() {
                return !!this.selected?.orders && this.selected.orders.length > 0
            },

            get customerStatus() {
                return this.selected?.status || null
            },

            get customerOrders() {
                return this.selected?.orders || []
            },

            // ✅ Can submit contract
            get canSubmit() {
                return this.hasPassedBkr && this.hasOrders && !!this.selectedOrderId
            },

            // Search
            get filteredCustomers() {
                return this.customers.filter(c =>
                    c.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    c.email.toLowerCase().includes(this.search.toLowerCase())
                )
            },

        }
    }
</script>
