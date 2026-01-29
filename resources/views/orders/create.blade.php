<x-layouts.dashboard :title="'Sales Dashboard - nieuwe bestelling'">
    @section('title', 'Sales Dashboard')
    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    @include('orders._form')

</x-layouts.dashboard>
