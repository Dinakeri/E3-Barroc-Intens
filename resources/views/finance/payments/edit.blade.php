<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-zinc-900 dark:text-zinc-50">Betaling bewerken</h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Betaling #{{ $payment->id }}</p>
            </div>
            <flux:button variant="ghost" href="{{ route('payments.show', $payment) }}">Terug</flux:button>
        </div>

        <!-- Form Card -->
        <div
            class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-50">Betaalgegevens</h2>
            </div>

            <form action="{{ route('payments.update', $payment) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Invoice ID (Read-only) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:field>
                            <flux:label for="invoice_id" class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
                                Factuur ID
                            </flux:label>
                            <flux:input type="text" name="invoice_id" id="invoice_id"
                                value="{{ old('invoice_id', $payment->invoice_id) }}" disabled class="mt-2">
                            </flux:input>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Dit veld kan niet worden gewijzigd.
                            </p>
                        </flux:field>
                    </div>

                    <!-- Amount -->
                    <div>
                        <flux:field>
                            <flux:label for="amount" class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
                                Bedrag (€)
                            </flux:label>
                            <flux:input type="number" name="amount" id="amount" step="0.01"
                                value="{{ old('amount', $payment->amount) }}" placeholder="0.00" class="mt-2">
                            </flux:input>
                            @error('amount')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                </div>

                <!-- Payment Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:field>
                            <flux:label for="payment_date" class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
                                Betalingsdatum
                            </flux:label>
                            <flux:input type="date" name="payment_date" id="payment_date"
                                value="{{ old('payment_date', $payment->payment_date) }}" class="mt-2">
                            </flux:input>
                            @error('payment_date')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Status -->
                    <div>
                        <flux:field>
                            <flux:label for="status" class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
                                Status
                            </flux:label>
                            <flux:select name="status" id="status" class="mt-2">
                                <flux:select.option value="pending">Openstaand</flux:select.option>
                                <flux:select.option value="completed">Voltooid</flux:select.option>
                                <flux:select.option value="failed">Mislukt</flux:select.option>
                            </flux:select>
                            @error('status')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>
                </div>

                <!-- Method -->
                <div>
                    <flux:field>
                        <flux:label for="method" class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
                            Betalingsmethode
                        </flux:label>
                        <flux:select name="method" id="method" class="mt-2">
                            <flux:select.option value="credit_card">Creditcard</flux:select.option>
                            <flux:select.option value="bank_transfer">Overschrijving</flux:select.option>
                            <flux:select.option value="cash">Contant</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between border-t border-zinc-200 dark:border-zinc-700 pt-6">
                    <flux:button variant="ghost" href="{{ route('payments.show', $payment) }}">
                        Annuleren
                    </flux:button>
                    <flux:button variant="primary" type="submit">
                        Wijzigingen opslaan
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
