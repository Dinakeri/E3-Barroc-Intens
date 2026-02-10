<x-layouts.dashboard title="Nieuwe factuur">
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection


    @include('invoices._form')
</x-layouts.dashboard>
