<x-layouts.dashboard :title="'Contract Details'">
    @section('title', 'Finance Dashboard')
    @section('sidebar')
        @include('partials.financeSidebar')
    @endsection

    <div class="mb-8 flex items-center justify-between">
        <div>
            <flux:heading size="xl">Contract Details</flux:heading>
            <flux:text class="text-zinc-500">
                Contract #{{ $contract->id }} - {{ $contract->customer->name ?? 'N/A' }}
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:button variant="filled" href="#">
                Edit Contract
            </flux:button>
            <flux:button variant="ghost" href="{{ route('contracts.index') }}">
                Back
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
                        <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Customer</flux:text>
                        <flux:text class="text-lg">{{ $contract->customer->name ?? 'N/A' }}</flux:text>
                        @if($contract->customer)
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
                            <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Start Date</flux:text>
                            <flux:text class="text-lg">{{ $contract->start_date }}</flux:text>
                        </div>
                        <div>
                            <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">End Date</flux:text>
                            <flux:text class="text-lg">{{ $contract->end_date }}</flux:text>
                        </div>
                    </div>

                    <!-- Contract Duration -->
                    <div class="border-b border-zinc-100 pb-6">
                        <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Duration</flux:text>
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
                        <flux:text variant="label" class="font-semibold text-zinc-50 mb-2">Total Amount</flux:text>
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
            @if($contract->quote)
                <div class="bg-zinc-800 rounded-lg border border-zinc-200 shadow-sm p-4">
                    <flux:text variant="label" class="font-semibold text-zinc-50 mb-3 block">Related Quote</flux:text>
                    <flux:text class="text-sm text-zinc-200 mb-3">
                        Quote #{{ $contract->quote->id }}
                    </flux:text>
                    <flux:button variant="primary" size="sm" href="{{ Storage::url($contract->quote->url) }}" target="_blank" rel="noopener noreferrer" class="w-full">
                        View Quote
                    </flux:button>
                </div>
            @endif

            <!-- Invoices Count -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 shadow-sm p-4">
                <flux:text variant="label" class="font-semibold text-zinc-50 mb-3 block">Invoices</flux:text>
                <div class="text-3xl font-bold text-zinc-800 mb-3">
                    {{ $contract->invoices()->count() }}
                </div>
                <flux:button variant="primary" size="sm" href="{{ route('invoices.index', ['contract_id' => $contract->id]) }}" class="w-full">
                    View Invoices
                </flux:button>
            </div>

            <!-- Contract ID -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 p-4">
                <flux:text variant="label" class="font-semibold text-zinc-50 mb-2 block">Contract ID</flux:text>
                <flux:text class="text-sm font-mono text-zinc-200 break-all">{{ $contract->id }}</flux:text>
            </div>

            <!-- Created Info -->
            <div class="bg-zinc-800 rounded-lg border border-zinc-200 p-4 text-xs">
                <flux:text variant="label" class="font-semibold text-zinc-50 mb-2 block">Created</flux:text>
                <flux:text class="text-zinc-200">{{ $contract->created_at->format('d M Y H:i') }}</flux:text>
                @if($contract->created_at != $contract->updated_at)
                    <flux:text class="text-zinc-500 mt-2">Updated: {{ $contract->updated_at->format('d M Y H:i') }}</flux:text>
                @endif
            </div>
        </div>
    </div>

    <!-- PDF Document Section -->
    @if($contract->pdf_path)
        <div class="bg-zinc-800 rounded-lg border border-zinc-200 shadow-sm">
            <div class="border-b border-zinc-200 px-6 py-4">
                <flux:heading size="lg">Contract Document</flux:heading>
            </div>
            <div class="p-6">
                <flux:button href="{{ asset('storage/' . $contract->pdf_path) }}" target="_blank" variant="filled">
                    Download PDF
                </flux:button>
            </div>
        </div>
    @endif

</x-layouts.dashboard>
