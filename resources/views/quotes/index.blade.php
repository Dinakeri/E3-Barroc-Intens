<x-layouts.dashboard :title="'Sales Dashboard - nieuwe bestelling'">
    @section('title', 'Sales Dashboard')
    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    <div>
        <livewire:quotes />
    </div>
</x-layouts.dashboard>
