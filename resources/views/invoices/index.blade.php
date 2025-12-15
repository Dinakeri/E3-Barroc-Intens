<x-layouts.dashboard title="Opgeslagen facturen">
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <livewire:invoices />

</x-layouts.dashboard>
