<div>
    <form action="{{ route('bkr.check') }}" method="POST">
        @csrf
        @method('POST')

        <div x-data="bkrDrawer()" x-init="loadCustomers()" class="relative w-full">
            <flux:label>Klant</flux:label>

            <flux:button type="button" @click="open = !open"
                class="w-full flex justify-between rounded-md border px-3 py-2 bg-zinc-700 text-white">
                <span x-text="selected ? `${selected.name} (${selected.email})` : 'Kies een klant'"></span>
                <flux:icon.chevron-down class="size-4" />
            </flux:button>

            <input type="hidden" name="customer_id" :value="selected?.id">

            <div x-show="open" @click.outside="open = false"
                class="absolute z-50 mt-2 w-full rounded-md border bg-zinc-700 p-2">

                <flux:input x-model="search" placeholder="Zoek klant..." class="mb-2" />

                <template
                    x-for="customer in customers.filter(c =>
                c.name.toLowerCase().includes(search.toLowerCase()) ||
                c.email.toLowerCase().includes(search.toLowerCase())
            )"
                    :key="customer.id">
                    <div @click="selected = customer; open = false"
                        class="cursor-pointer px-3 py-2 hover:bg-zinc-600 rounded">
                        <div class="font-medium" x-text="customer.name"></div>
                        <div class="text-sm text-zinc-400" x-text="customer.email"></div>
                    </div>
                </template>

                <div x-show="!loading && customers.length === 0" class="px-3 py-2 text-zinc-400 text-sm">
                    Geen klanten gevonden
                </div>

                <div x-show="loading" class="px-3 py-2 text-zinc-400 text-sm">
                    Klanten laden…
                </div>
            </div>

        </div>


        <flux:fieldset class="mt-4">
            <flux:label>Status</flux:label>
            <flux:select name="status">
                <option value="registered">Geregistreerd</option>
                <option value="cleared">Vrijgegeven</option>
            </flux:select>
        </flux:fieldset>

        <div class="mt-6 flex justify-end gap-3">
            <flux:button variant="ghost" type="button" @click="$root.openBkrDrawer = false">
                Annuleren
            </flux:button>

            <flux:button variant="primary" type="submit">
                BKR-check uitvoeren
            </flux:button>
        </div>
    </form>
</div>

<script>
    function bkrDrawer() {
        return {
            // UI state
            open: false,
            search: '',
            selected: null,

            // Data
            customers: [],
            loading: false,

            async loadCustomers() {
                this.loading = true

                try {
                    const response = await fetch("{{ route('bkr.customers') }}")
                    this.customers = await response.json()
                } catch (e) {
                    console.error('Failed to load customers', e)
                } finally {
                    this.loading = false
                }
            }
        }
    }
</script>
