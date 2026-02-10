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
            <flux:button variant="filled" href="#">
                Contract bewerken
            </flux:button>
            <flux:button variant="ghost" href="{{ route('contracts.index') }}">
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
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 shadow-sm">
                <div class="border-b border-zinc-200 px-6 py-4">
                    <flux:heading size="lg">Contract Information</flux:heading>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Customer Information -->
                    <div class="border-b border-zinc-100 pb-6">
                        <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Klant</flux:text>
                        <flux:text class="text-lg">{{ $contract->customer->name ?? 'N.v.t.' }}</flux:text>
                        @if ($contract->customer)
                            <flux:text class="text-zinc-500 text-sm mt-1">
                                Email: {{ $contract->customer->email ?? 'N/A' }}
                            </flux:text>
                            <flux:text class="text-zinc-500 text-sm">
                                Phone: {{ $contract->customer->phone ?? 'N/A' }}
                            </flux:text>
                        @endif
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-4 border-b border-zinc-100 pb-6">
                        <div>
                            <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Startdatum</flux:text>
                            <flux:text class="text-lg">{{ $contract->start_date }}</flux:text>
                        </div>
                        <div>
                            <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Einddatum</flux:text>
                            <flux:text class="text-lg">{{ $contract->end_date }}</flux:text>
                        </div>
                    </div>

                    <!-- Contract Duration -->
                    <div class="border-b border-zinc-100 pb-6">
                        <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Duur</flux:text>
                        <flux:text class="text-lg">
                            {{-- @php
                                $days = $contract->end_date->diffInDays($contract->start_date);
                                $months = intdiv($days, 30);
                                $remainingDays = $days % 30;
                            @endphp
                            {{ $months }} months and {{ $remainingDays }} days --}}
                        </flux:text>
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Totaalbedrag</flux:text>
                        <flux:text class="text-2xl font-bold text-emerald-600">
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
                <div class="bg-zinc-800 rounded-lg border border-zinc-200 shadow-sm p-4">
                    <flux:text variant="label" class="font-semibold text-zinc-50 mb-3 block">Gerelateerde offerte
                    </flux:text>
                    <flux:text class="text-sm text-zinc-200 mb-3">
                        Offerte #{{ $contract->quote->id }}
                    </flux:text>
                    <flux:button variant="primary" size="sm" href="{{ Storage::url($contract->quote->url) }}"
                        target="_blank" rel="noopener noreferrer" class="w-full">
                        Bekijk offerte
                    </flux:button>
                </div>
            @endif

            <!-- Invoices Count -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 shadow-sm p-4">
                <flux:text variant="label" class="font-semibold text-zinc-50 mb-3 block">Facturen</flux:text>
                <div class="text-3xl font-bold text-zinc-800 mb-3">
                    {{ $contract->invoices()->count() }}
                </div>
                <flux:button variant="primary" size="sm"
                    href="{{ route('invoices.index', ['contract_id' => $contract->id]) }}" class="w-full">
                    Bekijk facturen
                </flux:button>
            </div>

            <!-- Contract ID -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 p-4">
                <flux:text variant="label" class="font-semibold text-zinc-50 mb-2 block">Contract-ID</flux:text>
                <flux:text class="text-sm font-mono text-zinc-200 break-all">{{ $contract->id }}</flux:text>
            </div>

            <!-- Created Info -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 p-4 text-xs">
                <flux:text variant="label" class="font-semibold text-zinc-50 mb-2 block">Aangemaakt</flux:text>
                <flux:text class="text-zinc-200">{{ $contract->created_at->format('d M Y H:i') }}</flux:text>
                @if ($contract->created_at != $contract->updated_at)
                    <flux:text class="text-zinc-500 mt-2">Bijgewerkt: {{ $contract->updated_at->format('d M Y H:i') }}
                    </flux:text>
                @endif
            </div>
        </div>
    </div>


    {{-- PDF Preview --}}
    <section class="bg-white dark:bg-zinc-800 rounded-xl border shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                Contract PDF
            </h2>

            <flux:button href="{{ Storage::url($contract->pdf_path) }}" target="_blank" variant="ghost"
                icon:trailing="arrow-up-right">
                Open in nieuw tabblad
            </flux:button>
        </div>

        <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-b-xl">
            @if ($contract->pdf_path)
                <embed src="{{ Storage::url($contract->pdf_path) }}" type="application/pdf"
                    class="w-full h-[650px] rounded-md border" />
            @else
                <div class="text-center text-zinc-500 py-16">
                    PDF is nog niet gegenereerd.
                </div>
            @endif
        </div>
    </section>

</x-layouts.dashboard>
