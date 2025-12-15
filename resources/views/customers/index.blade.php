<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')
    <div class="flex justify-between">
        <h1 class="text-3xl font-bold mb-6 text-left">Alle Klanten</h1>
        <div>
            <flux:button icon="arrow-left" variant="ghost" href="{{ route('customers.index') }}">Terug</flux:button>
        </div>
        {{-- <p>Welcome to the Sales Dashboard. Here you can find an overview of sales metrics and performance.</p> --}}
    </div>


    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    {{-- Customers Table list --}}
    <livewire:customers />

</x-layouts.dashboard>
