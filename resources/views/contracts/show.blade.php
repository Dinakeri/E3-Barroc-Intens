<x-layouts.dashboard :title="'Contractgegevens'">
    @section('title', 'Financiën Dashboard')
    @section('sidebar')
        @include('partials.financeSidebar')
    @endsection

    <div class="mb-8 flex items-center justify-between">
        <div>
            <flux:heading size="xl">Contractgegevens</flux:heading>
            <flux:text class="text-zinc-500">
                Contract #{{ $contract->id }} - {{ $contract->customer->name ?? 'N.v.t.' }}
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:button variant="primary" colour="zinc" icon="arrow-left" href="{{ route('contracts.index') }}">
                Terug
            </flux:button>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        @php
            $statusColors = [
                'active' => 'bg-emerald-100 text-emerald-800',
                'pending' => 'bg-amber-100 text-amber-800',
                'completed' => 'bg-blue-100 text-blue-800',
                'expired' => 'bg-red-100 text-red-800',
            ];
            $statusColor = $statusColors[$contract->status] ?? 'bg-gray-100 text-gray-800';
        @endphp
        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
            {{ ucfirst($contract->status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Contract Information -->
        <div class="lg:col-span-2">
            <div class="bg-zinc-800 rounded-lg border border-zinc-700 shadow-sm">
                <div class="border-b border-zinc-700 px-6 py-4">
                    <flux:heading size="lg">Contractgegevens</flux:heading>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Customer Information -->
                    <div class="border-b border-zinc-700 pb-6">
                        <flux:text variant="label" class="font-semibold text-white mb-2">Klant</flux:text>
                        <flux:text class="text-lg text-zinc-100">{{ $contract->customer->name ?? 'N.v.t.' }}</flux:text>
                        @if ($contract->customer)
                            <flux:text class="text-zinc-400 text-sm mt-1">
                                Email: {{ $contract->customer->email ?? 'N/A' }}
                            </flux:text>
                            <flux:text class="text-zinc-400 text-sm">
                                Telefoonnummer: {{ $contract->customer->phone ?? 'N/A' }}
                            </flux:text>
                        @endif
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-4 border-b border-zinc-700 pb-6">
                        <div>
                            <flux:text variant="label" class="font-semibold text-white mb-2">Startdatum</flux:text>
                            <flux:text class="text-lg text-zinc-100">{{ $contract->start_date }}</flux:text>
                        </div>
                        <div>
                            <flux:text variant="label" class="font-semibold text-white mb-2">Einddatum</flux:text>
                            <flux:text class="text-lg text-zinc-100">{{ $contract->end_date }}</flux:text>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <flux:text variant="label" class="font-semibold text-white mb-2">Totaalbedrag</flux:text>
                        <flux:text class="text-2xl font-bold text-emerald-500">
                            €{{ number_format($contract->total_amount, 2, ',', '.') }}
                        </flux:text>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="space-y-4">
            <!-- Related Quote -->
            @if ($contract->quote)
                <div class="bg-zinc-800 rounded-lg border border-zinc-700 shadow-sm p-4">
                    <flux:text variant="label" class="font-semibold text-white mb-3 block">Gerelateerde offerte</flux:text>
                    <flux:text class="text-sm text-zinc-300 mb-3">Offerte #{{ $contract->quote->id }}</flux:text>
                    <flux:button variant="primary" size="sm" href="{{ Storage::url($contract->quote->url) }}"
                        target="_blank" rel="noopener noreferrer" class="w-full">
                        Bekijk offerte
                    </flux:button>
                </div>
            @endif

            <!-- Invoices -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-700 shadow-sm p-4">
                <flux:text variant="label" class="font-semibold text-white mb-4 block">Facturen</flux:text>
                @if ($contract->invoices->count() > 0)
                    <div class="space-y-2 mb-4">
                        @foreach ($contract->invoices as $invoice)
                            <a href="{{ route('invoices.show', $invoice) }}"
                                class="flex items-center justify-between p-2 rounded bg-zinc-700 hover:bg-zinc-600 transition text-emerald-400 hover:text-emerald-300">
                                <span class="text-sm ">Factuur #{{ $invoice->id }}</span>
                                <flux:icon.arrow-up-right class="size-4" />
                            </a>
                        @endforeach
                    </div>
                    <flux:button variant="ghost" size="sm" href="{{ route('invoices.index') }}"
                        class="w-full text-zinc-300">
                        Alle facturen
                    </flux:button>
                @else
                    <flux:text class="text-sm text-zinc-400 mb-4">Nog geen facturen gegenereerd</flux:text>
                    <flux:button variant="primary" size="sm"
                        href="{{ route('invoices.create') }}" class="w-full">
                        Factuur aanmaken
                    </flux:button>
                @endif
            </div>

            <!-- Contract ID -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-700 p-4">
                <flux:text variant="label" class="font-semibold text-white mb-2 block">Contract-ID</flux:text>
                <flux:text class="text-sm font-mono text-zinc-300 break-all">{{ $contract->id }}</flux:text>
            </div>

            <!-- Created Info -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-700 p-4 text-xs">
                <flux:text variant="label" class="font-semibold text-white mb-2 block">Aangemaakt</flux:text>
                <flux:text class="text-zinc-300">{{ $contract->created_at->format('d M Y H:i') }}</flux:text>
                @if ($contract->created_at != $contract->updated_at)
                    <flux:text class="text-zinc-400 mt-2">Bijgewerkt: {{ $contract->updated_at->format('d M Y H:i') }}</flux:text>
                @endif
            </div>
        </div>
    </div>


    {{-- PDF Preview --}}
    <section class="bg-zinc-800 rounded-xl border border-zinc-700 shadow-sm mb-6">
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-700">
            <h2 class="text-lg font-semibold text-white">
                Contract PDF
            </h2>

            @if ($contract->pdf_path)
                <flux:button href="{{ Storage::url($contract->pdf_path) }}" target="_blank" variant="ghost">
                    Open in nieuw tabblad
                </flux:button>
            @endif
        </div>

        <div class="p-4 bg-zinc-900 rounded-b-xl">
            @if ($contract->pdf_path)
                <embed src="{{ Storage::url($contract->pdf_path) }}" type="application/pdf"
                    class="w-full h-[650px] rounded-md border border-zinc-700" />
            @else
                <div class="text-center text-zinc-500 py-16">
                    PDF is nog niet gegenereerd.
                </div>
            @endif
        </div>
    </section>

    {{-- Footer --}}
    <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-6 text-sm text-zinc-300 mb-6">
        <p>
            Bedankt voor het aangaan van deze overeenkomst met ons.
            Dit contract is geldig tot de hierboven vermelde einddatum.
        </p>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">
        <flux:button variant="ghost" href="{{ route('contracts.index') }}">
            Terug
        </flux:button>

        <form action="{{ route('contracts.send', $contract) }}" method="POST">
            @csrf
            <flux:button type="submit" variant="primary">
                Contract verzenden
            </flux:button>

        </form>
    </div>

</x-layouts.dashboard>
