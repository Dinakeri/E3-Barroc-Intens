<x-layouts.dashboard>
    @section('title', 'Voorraad Beheer')
    
    <livewire:products />

    @section('sidebar')
        <x-purchasing-sidebar current="products" />
    @endsection
</x-layouts.dashboard>
