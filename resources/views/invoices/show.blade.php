<x-layouts.dashboard :title="'Facturgegevens'">
    @section('title', 'Financiën Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <div class="mb-8 flex items-center justify-between">
        <div>
            <flux:heading size="xl">Factuurgegevens</flux:heading>
            <flux:text class="text-zinc-500">
                Factuur #{{ $invoice->id }} - {{ $invoice->customer->name ?? 'N.v.t.' }}
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:button variant="primary" color="zinc" href="{{ route('invoices.index') }}" icon="arrow-left">
                Terug
            </flux:button>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        @php
            $statusColors = [
                'draft' => 'bg-amber-900 text-amber-200',
                'sent' => 'bg-blue-900 text-blue-200',
                'paid' => 'bg-emerald-900 text-emerald-200',
                'cancelled' => 'bg-red-900 text-red-200',
            ];
            $statusColor = $statusColors[$invoice->status] ?? 'bg-zinc-700 text-zinc-200';
            $statusLabels = [
                'draft' => 'Concept',
                'sent' => 'Verzonden',
                'paid' => 'Betaald',
                'cancelled' => 'Geannuleerd',
            ];
        @endphp
        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
            {{ $statusLabels[$invoice->status] ?? ucfirst($invoice->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Invoice Information -->
        <div class="lg:col-span-2">
            <div class="bg-zinc-800 rounded-lg border border-zinc-700 shadow-sm">
                <div class="border-b border-zinc-700 bg-gradient-to-r from-black to-zinc-900 px-6 py-4 rounded-t-lg">
                    <flux:heading size="lg" class="text-white">Factuurinformatie</flux:heading>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Invoice Dates -->
                    <div class="border-b border-zinc-700 pb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <flux:text variant="label" class="font-semibold text-white mb-2">Factuurdatum
                                </flux:text>
                                <flux:text class="text-lg text-zinc-100">{{ $invoice->created_at->format('d-m-Y') }}
                                </flux:text>
                            </div>
                            <div>
                                <flux:text variant="label" class="font-semibold text-white mb-2">Vervaldatum
                                </flux:text>
                                <flux:text class="text-lg text-zinc-100">{{ $invoice->valid_until }}</flux:text>
                            </div>
                        </div>
                    </div>

                    <!-- Klant Information -->
                    <div class="border-b border-zinc-700 pb-6">
                        <flux:text variant="label" class="font-semibold text-white mb-3 block">Klantinformatie
                        </flux:text>
                        <div class="space-y-2">
                            <flux:text class="text-lg font-semibold text-zinc-100">
                                {{ $invoice->customer->name ?? 'N.v.t.' }}</flux:text>
                            @if ($invoice->customer)
                                <flux:text class="text-zinc-400 text-sm">
                                    E-mail: {{ $invoice->customer->email ?? 'N.v.t.' }}
                                </flux:text>
                                <flux:text class="text-zinc-400 text-sm">
                                    Telefoonnummer: {{ $invoice->customer->phone ?? 'N.v.t.' }}
                                </flux:text>
                            @endif
                        </div>
                    </div>

                    <!-- Order Information -->
                    @if ($invoice->order)
                        <div class="border-b border-zinc-700 pb-6">
                            <flux:text variant="label" class="font-semibold text-white mb-3 block">
                                Bestellinginformatie</flux:text>
                            <div class="space-y-2">
                                <flux:text class="text-sm">
                                    <span class="text-zinc-400">Bestelling #</span>
                                    <span class="font-semibold text-zinc-100">{{ $invoice->order->id }}</span>
                                </flux:text>
                                <flux:text class="text-sm text-zinc-400">
                                    Datum: {{ $invoice->order->created_at->format('d-m-Y') }}
                                </flux:text>
                            </div>
                        </div>
                    @endif

                    <!-- Contract Information -->
                    @if ($invoice->contract)
                        <div class="border-b border-zinc-700 pb-6">
                            <flux:text variant="label" class="font-semibold text-white mb-3 block">Contractinformatie
                            </flux:text>
                            <div class="space-y-2">
                                <flux:text class="text-sm">
                                    <span class="text-zinc-400">Contract #</span>
                                    <span class="font-semibold text-zinc-100">{{ $invoice->contract->id }}</span>
                                </flux:text>
                                <flux:text class="text-sm text-zinc-400">
                                    Periode: {{ $invoice->contract->start_date }} tot
                                    {{ $invoice->contract->end_date }}
                                </flux:text>
                            </div>
                        </div>
                    @endif

                    <!-- Total Amount -->
                    <div>
                        <flux:text variant="label" class="font-semibold text-white mb-2 block">Factuurbedrag
                        </flux:text>
                        <div class="flex items-baseline gap-2">
                            <flux:text class="text-3xl font-bold text-amber-400">
                                €{{ number_format($invoice->total_amount, 2, ',', '.') }}
                            </flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="space-y-4">
            <!-- Invoice ID -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-700 p-4">
                <flux:text variant="label" class="font-semibold text-white mb-2 block">Factuur-ID</flux:text>
                <flux:text class="text-sm font-mono text-zinc-300 break-all">{{ $invoice->id }}</flux:text>
            </div>

            <!-- Related Contract -->
            @if ($invoice->contract)
                <div class="bg-zinc-800 rounded-lg border border-zinc-700 shadow-sm p-4">
                    <flux:text variant="label" class="font-semibold text-white mb-3 block">Gerelateerd Contract
                    </flux:text>
                    <flux:text class="text-sm text-zinc-300 mb-3">
                        Contract #{{ $invoice->contract->id }}
                    </flux:text>
                    <flux:button variant="primary" size="sm"
                        href="{{ route('contracts.show', $invoice->contract->id) }}" class="w-full">
                        Bekijk contract
                    </flux:button>
                </div>
            @endif

            <!-- Payments -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 shadow-sm p-4">
                <flux:text variant="label" class="font-semibold text-zinc-50 mb-3 block">Betalingen</flux:text>
                @if ($invoice->payments->count() > 0)
                    <div class="space-y-2 mb-4">
                        @foreach ($invoice->payments as $payment)
                            <a href="{{ route('payments.show', $payment) }}"
                                class="flex items-center justify-between p-2 rounded bg-zinc-700 hover:bg-zinc-600 transition text-emerald-400 hover:text-emerald-300">
                                <span class="text-sm font-mono">Betaling #{{ $payment->id }}</span>
                                <flux:icon.arrow-up-right class="size-4" />
                            </a>
                        @endforeach
                    </div>
                    <flux:button variant="ghost" size="sm" href="{{ route('payments.index') }}"
                        class="w-full text-zinc-300">
                        Alle betalingen
                    </flux:button>
                @else
                    <flux:text class="text-sm text-zinc-400 mb-4">Nog geen betalingen gegenereerd</flux:text>
                    <flux:button variant="primary" size="sm" href="{{ route('payments.create') }}" class="w-full">
                        Betaling aanmaken
                    </flux:button>
                @endif
            </div>

            <!-- Created Info -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-700 p-4 text-xs">
                <flux:text variant="label" class="font-semibold text-white mb-2 block">Aangemaakt</flux:text>
                <flux:text class="text-zinc-300">{{ $invoice->created_at->format('d M Y H:i') }}</flux:text>
                @if ($invoice->created_at != $invoice->updated_at)
                    <flux:text class="text-zinc-400 mt-2">Bijgewerkt: {{ $invoice->updated_at->format('d M Y H:i') }}
                    </flux:text>
                @endif
            </div>
        </div>
    </div>

    <!-- PDF Document Section -->
    @if ($invoice->pdf_path)
        <div class="bg-zinc-800 rounded-lg border border-zinc-700 shadow-sm mb-6">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-700">
                <div class="rounded-t-lg">
                    <flux:heading size="lg" class="text-white uppercase">Factuur</flux:heading>
                </div>
                <div class="p-4">
                    <div class="flex gap-3">
                        <flux:button href="{{ Storage::url($invoice->pdf_path) }}" target="_blank" variant="ghost">
                            <flux:icon.arrow-top-right-on-square class="size-4 mr-2" />
                            Bekijk in nieuwe tab
                        </flux:button>
                    </div>
                </div>
            </div>
            <div class="bg-zinc-900 rounded-b-xl">
                @if ($invoice->pdf_path)
                    <embed src="{{ Storage::url($invoice->pdf_path) }}" type="application/pdf"
                        class="w-full h-[650px] rounded-md border border-zinc-700" />
                @else
                    <div class="text-center text-zinc-300 py-16">
                        PDF is nog niet gegenereerd.
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Footer --}}
    <div class="bg-zinc-900 rounded-xl border border-zinc-700 p-6 text-sm text-zinc-300 mb-6">
        <p>
            Dank u voor uw vertrouwen in Barroc Intens. Wij stellen het zeer op prijs dat u voor onze diensten kiest.
            Gelieve het factuurbedrag voor de vervaldatum over te maken aan het rekeningnummer vermeld op de factuur.
            Bij vragen kunt u ons altijd bereiken via support@barrocintens.nl
        </p>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">
        <flux:button variant="ghost" href="{{ route('invoices.index') }}">
            Terug
        </flux:button>

        <form action="{{ route('invoices.send', $invoice) }}" method="POST">
            @csrf
            <flux:button type="submit" variant="primary">
                Factuur verzenden
            </flux:button>

        </form>
    </div>

</x-layouts.dashboard>
