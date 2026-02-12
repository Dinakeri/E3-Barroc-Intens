<x-layouts.dashboard>
    @section('title', 'Producten')
    
    <livewire:products />

    @section('sidebar')
        <x-purchasing-sidebar current="products" />
    @endsection
</x-layouts.dashboard>
