<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">All Customers</h1>
        {{-- <p>Welcome to the Sales Dashboard. Here you can find an overview of sales metrics and performance.</p> --}}
    </div>


    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    {{-- Customers Table list --}}
    <livewire:customers />

</x-layouts.dashboard>
