<x-layouts.dashboard :title="'Sales Dashboard - Alle bestellingen'">
    @section('title', 'Sales Dashboard')
    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection


    {{-- @include('orders._drawer') --}}

    <livewire:orders />

</x-layouts.dashboard>
