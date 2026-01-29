<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <div class="contracts">
        <h2 class="text-2xl font-bold mb-4">Alle Contracten</h2>
    </div>

    <livewire:contracts />
</x-layouts.dashboard>
