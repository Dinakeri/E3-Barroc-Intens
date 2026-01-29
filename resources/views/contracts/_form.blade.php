<form action="{{ route('contracts.store') }}" method="POST" class="space-y-6" x-data="contractForm()">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 ">
        <div class="relative w-full">
            <!-- Label -->
            <flux:label>Klant</flux:label>

            <!-- Button (acts like select) -->
            <flux:button type="button" @click="open = !open" x-cloak
                class="w-full flex justify-start rounded-md border px-3 py-2 bg-zinc-700 text-white">
                <div class="w-full flex justify-between">
                    <span x-text="selected ? selected.name + ' (' + selected.email + ')' : 'Kies een klant'"></span>
                    <flux:icon.chevron-down class="size-4" />
                </div>

            </flux:button>
            {{-- No customer selected --}}
            <div x-show="!selected" class="mt-4" x-cloak>
                <flux:callout variant="neutral">
                    Kies eerst een klant om verder te gaan.
                </flux:callout>
            </div>

            {{-- Customer selected but BKR not passed --}}
            <div x-show="selected && !hasPassedBkr" class="mt-4" x-cloak>
                <flux:callout variant="danger">
                    Deze klant heeft de BKR-check nog niet succesvol afgerond.
                </flux:callout>
            </div>

            {{-- Customer selected and BKR passed but no approved quote --}}
            <div x-show="selected && hasPassedBkr && !hasApprovedQuote" class="mt-4" x-cloak>
                <flux:callout variant="warning">
                    Deze klant heeft nog geen goedgekeurde offerte.
                </flux:callout>
            </div>

            {{-- Customer selected, BKR passed and has quote --}}
            <div x-show="selected && hasPassedBkr && hasApprovedQuote" class="mt-4" x-cloak>
                <flux:callout variant="success" class="flex items-center justify-between gap-4">
                    <div>
                        Deze klant heeft een goedgekeurde offerte.
                    </div>

                    <flux:button x-bind:href="approvedQuote ? approvedQuote.url : null" target="_blank"
                        variant="primary" icon:trailing="arrow-up-right" onclick="event.stopPropagation();">
                        Open offerte
                    </flux:button>
                </flux:callout>
            </div>



            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false" x-transition x-cloak
                class="absolute z-50 mt-2 w-full rounded-md border bg-zinc-700 p-2">
                <!-- Search -->
                <flux:input x-model="search" placeholder="Zoek klant..." class="mb-2" />

                <!-- Results -->
                <div class="max-h-48 overflow-y-auto">
                    <template x-for="customer in filteredCustomers" :key="customer.id">
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

            <!-- Hidden input for form submit -->
            <input type="hidden" name="customer_id" :value="selected?.id">
            <input type="hidden" name="quote_id" :value="approvedQuote?.id">


        </div>
        @error('customer_id')
            <flux:error>{{ $message }}</flux:error>
        @enderror




        <div>
            <flux:field>
                <flux:label for="start_date">Startdatum</flux:label>
                <flux:input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                    class="mt-2" x-model="startDate" @change="updateEndDate()" x-bind:disabled="!canSubmit" />
                @error('start_date')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>
        </div>

        <div>
            <flux:field>
                <flux:label for="end_date">Einddatum (optioneel)</flux:label>
                <flux:input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-2"
                    x-model="endDate" x-bind:disabled="!canSubmit" />
                @error('end_date')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>
        </div>
    </div>

    <div class="flex justify-end">
        <flux:button type="submit" variant="primary" color="blue" x-bind:disabled="!canSubmit">
            Contract genereren (PDF)
        </flux:button>
    </div>
</form>
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

<script>
    function contractForm() {
        return {
            open: false,
            search: '',
            selected: null,
            customers: @js($customers),

            startDate: @js(old('start_date')),
            endDate: @js(old('end_date')),


            // ✅ BKR check
            get hasPassedBkr() {
                return this.selected?.bkr_status === 'cleared'
            },

            // ✅ Only approved quote counts
            get approvedQuote() {
                if (!this.selected?.quotes) return null

                return this.selected.quotes.find(q => q.status === 'approved') ?? null
            },

            // ✅ Does customer have an approved quote?
            get hasApprovedQuote() {
                return !!this.approvedQuote
            },

            // ✅ Can submit contract
            get canSubmit() {
                return this.hasPassedBkr && this.hasApprovedQuote
            },

            // Search
            get filteredCustomers() {
                return this.customers.filter(c =>
                    c.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    c.email.toLowerCase().includes(this.search.toLowerCase())
                )
            },

            updateEndDate() {
                if (!this.startDate) return

                const start = new Date(this.startDate)
                const end = new Date(start)
                end.setFullYear(start.getFullYear() + 1)

                // Format YYYY-MM-DD for input[type=date]
                this.endDate = end.toISOString().split('T')[0]
            }
        }
    }
</script>
