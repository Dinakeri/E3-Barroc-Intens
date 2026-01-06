<x-layouts.dashboard :title="'Sales Dashboard - nieuwe bestelling'">
    @section('title', 'Sales Dashboard')
    @section('sidebar')
        @include('partials.financeSidebar')
    @endsection

    @include('bkr._drawer')

</x-layouts.dashboard>
