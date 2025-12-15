<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-zinc-900 dark:text-zinc-50">Maak een nieuwe betaling
                </h1>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Sequi non corrupti officia dolor dolore cumque, vero fugit, esse id voluptate ab
                    temporibus, vitae sed magni explicabo consequatur deserunt delectus expedita!</p>
            </div>
            <flux:button variant="ghost" href="{{ route('payments.index') }}" icon="arrow-left">Terug</flux:button>
        </div>

        <!-- Form Card -->
        <div
            class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-50">Betaalgegevens</h2>
            </div>

            <form action="{{ route('payments.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('POST')

                <!-- Invoice ID (Read-only) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:field>
                            <flux:label for="invoice_id" class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
                                Factuur ID
                            </flux:label>
                            <flux:select name="invoice_id" id="invoice_id" class="mt-2">
                                @foreach ($invoices as $invoice)
                                    <flux:select.option value="{{ $invoice->id }}">Invoice {{ $invoice->id }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                            @error('invoice_id')
                                <flux:error>{{ $message }}</flux:error>
                            @enderror
                        </flux:field>
                    </div>

                    <!-- Amount -->
                    <div>
                        <flux:field>
                            <flux:label for="amount" class="text-sm font-medium text-zinc-900 dark:text-zinc-200">
                                Bedrag (€)
                            </flux:label>
                            <flux:input type="number" name="amount" id="amount" step="0.01"
                                value="{{ old('amount') }}" placeholder="0.00" class="mt-2">
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
                                value="{{ old('payment_date') }}" class="mt-2">
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
                            {{-- <flux:select name="status" id="status" class="mt-2">
                                <flux:select.option value="pending">Openstaand</flux:select.option>
                                <flux:select.option value="completed">Voltooid</flux:select.option>
                                <flux:select.option value="failed">Mislukt</flux:select.option>
                            </flux:select> --}}

                            <flux:radio.group name="status"
                                class="text-sm font-medium text-zinc-900 dark:text-zinc-200" variant="segmented">
                                <flux:radio value="pending" icon="clock" label="Openstaand" checked />
                                <flux:radio value="completed" icon="check-circle" label="Voltooid" />
                                <flux:radio value="failed" icon="x-circle" label="Mislukt" />
                            </flux:radio.group>
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
                            <flux:select.option value="">Geen</flux:select.option>
                            <flux:select.option value="credit_card">Creditcard</flux:select.option>
                            <flux:select.option value="bank_transfer">Overschrijving</flux:select.option>
                            <flux:select.option value="cash">Contant</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between border-t border-zinc-200 dark:border-zinc-700 pt-6">
                    <flux:button variant="ghost" href="{{ route('payments.index') }}">
                        Annuleren
                    </flux:button>
                    <flux:button variant="primary" type="submit">
                        Maak Betaling
                    </flux:button>
                </div>
            </form>
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
    </div>
</x-layouts.dashboard>
