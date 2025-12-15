<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <livewire:payments />
</x-layouts.dashboard>
